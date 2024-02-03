<?php
namespace Piyush\EmailOtp\Cron;

use Psr\Log\LoggerInterface as PsrLogger;
use Piyush\EmailOtp\Api\Data\OtpInterface;
use Piyush\EmailOtp\Api\OtpRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\FilterGroupBuilder;
use Magento\Framework\Stdlib\DateTime;

class CleanOtp
{
    private $otpRepository;
    
    private $searchCriteriaBuilder;

    private $filterBuilder;

    private $filterGroupBuilder;

    private $dateTime;

    private $logger;

    public function __construct(
        OtpRepositoryInterface $otpRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterBuilder $filterBuilder,
        FilterGroupBuilder $filterGroupBuilder,
        DateTime $dateTime,
        PsrLogger $logger
    ) {
        $this->otpRepository = $otpRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
        $this->filterGroupBuilder = $filterGroupBuilder;
        $this->dateTime = $dateTime;
        $this->logger = $logger;
    }

    public function execute()
    {
        foreach($this->getExpiredOtps() as $otp) {
            $this->otpRepository->delete($otp);
        }
    }

    private function getExpiredOtps()
    {
        $filterGroups = [];
        $ipFilter = $this->filterBuilder->create()
            ->setField(OtpInterface::UPDATED_AT)
            ->setConditionType('lt')
            ->setValue($this->getOtpExpiryDateTime());
        $filterGroups[] = $this->filterGroupBuilder->create()
            ->setFilters([$ipFilter]);
        $searchCriteria = $this->searchCriteriaBuilder
            ->setFilterGroups($filterGroups)
            ->create();
        return $this->otpRepository->getList($searchCriteria)->getItems();
    }

    private function getOtpExpiryDateTime()
    {
        $now = new \DateTime();
        $now->modify('-2 minutes');
        return $this->dateTime->formatDate($now, true);
    }
}
