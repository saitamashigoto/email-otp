<?php

namespace Piyush\EmailOtp\Model\Api;

use Piyush\EmailOtp\Api\OtpManagerInterface;
use Piyush\EmailOtp\Api\SendAndSaveOtpRequestInterfaceFactory;
use Piyush\EmailOtp\Api\SendAndSaveOtpResponseInterfaceFactory;
use Piyush\EmailOtp\Api\VerifyOtpRequestInterfaceFactory;
use Piyush\EmailOtp\Api\Data\OtpInterfaceFactory;
use Piyush\EmailOtp\Api\Data\OtpInterface;
use Piyush\EmailOtp\Api\GenerateOtpInterface;
use Piyush\EmailOtp\Api\SendMessageInterface;
use Piyush\EmailOtp\Helper\Data as DataHelper;
use Piyush\EmailOtp\Api\OtpRepositoryInterface;
use Magento\Framework\HTTP\PhpEnvironment\RemoteAddress;
use Magento\Framework\Webapi\Exception as WebapiException;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\FilterGroupBuilder;
use Psr\Log\LoggerInterface as PsrLogger;

class OtpManager implements OtpManagerInterface
{
    private $sendAndSaveOtpRequestFactory;
    
    private $sendAndSaveOtpResponseFactory;
    
    private $verifyOtpRequestFactory;

    private $verifyOtpResponseFactory;

    private $logger;

    private $generateOtp;

    private $sendMessage;

    private $otpInterfaceFactory;

    private $remoteAddress;

    private $dataHelper;

    private $otpRepository;

    private $searchCriteriaBuilder;

    private $filterBuilder;

    private $filterGroupBuilder;

    public function __construct(
        SendAndSaveOtpRequestFactory $sendAndSaveOtpRequestFactory,
        SendAndSaveOtpResponseFactory $sendAndSaveOtpResponseFactory,
        VerifyOtpRequestFactory $verifyOtpRequestFactory,
        PsrLogger $logger,
        GenerateOtpInterface $generateOtp,
        SendMessageInterface $sendMessage,
        OtpInterfaceFactory $otpInterfaceFactory,
        RemoteAddress $remoteAddress,
        DataHelper $dataHelper,
        OtpRepositoryInterface $otpRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterBuilder $filterBuilder,
        FilterGroupBuilder $filterGroupBuilder
    ) {
        $this->sendAndSaveOtpRequestFactory = $sendAndSaveOtpRequestFactory;
        $this->sendAndSaveOtpResponseFactory = $sendAndSaveOtpResponseFactory;
        $this->verifyOtpRequestFactory = $verifyOtpRequestFactory;
        $this->logger = $logger;
        $this->generateOtp = $generateOtp;
        $this->sendMessage = $sendMessage;
        $this->otpInterfaceFactory = $otpInterfaceFactory;
        $this->remoteAddress = $remoteAddress;
        $this->dataHelper = $dataHelper;
        $this->otpRepository = $otpRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
        $this->filterGroupBuilder = $filterGroupBuilder;
    }

    /**
     * @inheritdoc
     */
    public function sendAndSaveOtp($sendAndSaveOtpRequest)
    {
        if (!$this->dataHelper->isModuleEnabled()) {
            throw new WebapiException(__("Unauthorized"), 1, WebapiException::HTTP_UNAUTHORIZED);
        }
        $otpsByIpAddress = $this->getOtpsByIpAddress()->getItems();
        foreach ($otpsByIpAddress as $otp) {
            if ($otp->getTimes() >= 5) {
                throw new WebapiException(__("Too Many Requests"), 1, WebapiException::HTTP_TOO_MANY_REQUESTS);
            }
        }
        $otp = $this->otpInterfaceFactory->create();
        if (count($otpsByIpAddress) > 0) {
            $otp = array_shift($otpsByIpAddress);
        }
        $otp->setIpAddress($this->getClientIpAddress())
            ->setEmail($sendAndSaveOtpRequest->getEmail())
            ->setOtp($this->generateOtp->execute())
            ->setTimes($otp->getTimes() ? $otp->getTimes() + 1 : 0);
        try {
            $this->otpRepository->save($otp);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            throw new WebapiException(__("Internal Server Error"), 1, WebapiException::HTTP_INTERNAL_ERROR);
        }
        if (!$this->sendMessage->execute($otp)) {
            throw new WebapiException(__("Internal Server Error"), 1, WebapiException::HTTP_INTERNAL_ERROR);
        }
        return $this->sendAndSaveOtpResponseFactory->create()
            ->setOtp($otp->getOtp());
    }

    private function getOtpsByIpAddress()
    {
        $filterGroups = [];
        $ipFilter = $this->filterBuilder->create()
            ->setField(OtpInterface::IP_ADDRESS)
            ->setConditionType('eq')
            ->setValue($this->getClientIpAddress());
        $filterGroups[] = $this->filterGroupBuilder->create()
            ->setFilters([$ipFilter]);
        $searchCriteria = $this->searchCriteriaBuilder
            ->setFilterGroups($filterGroups)
            ->create();
        return $this->otpRepository->getList($searchCriteria);
    }

    private function getClientIpAddress()
    {
        return $this->remoteAddress->getRemoteAddress();
    }

    /**
     * @inheritdoc
     */
    public function verifyOtp($verifyOtpRequest)
    {
        $otps = $this->getOtpByPhoneNumberOtp($verifyOtpRequest)->getItems();
        $ans = count($otps) > 0;
        foreach ($otps as $otp) {
            $this->otpRepository->delete($otp);
        }
        return $ans;
    }


    private function getOtpByPhoneNumberOtp($verifyOtpRequest)
    {
        $filterGroups = [];
        $phoneNumberFilter = $this->filterBuilder->create()
            ->setField(OtpInterface::EMAIL)
            ->setConditionType('eq')
            ->setValue($verifyOtpRequest->getEmail());
        $filterGroups[] = $this->filterGroupBuilder->create()
            ->setFilters([$phoneNumberFilter]);
        $otpFilter = $this->filterBuilder->create()
            ->setField(OtpInterface::OTP)
            ->setConditionType('eq')
            ->setValue($verifyOtpRequest->getOtp());
        $filterGroups[] = $this->filterGroupBuilder->create()
            ->setFilters([$otpFilter]);
        $searchCriteria = $this->searchCriteriaBuilder->setFilterGroups($filterGroups)->create();
        return $this->otpRepository->getList($searchCriteria);
    }
}