<?php

namespace Piyush\EmailOtp\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Piyush\EmailOtp\Api\Data\OtpInterface;
use Piyush\EmailOtp\Api\Data\OtpSearchResultsInterfaceFactory;
use Piyush\EmailOtp\Api\OtpRepositoryInterface;
use Piyush\EmailOtp\Model\ResourceModel\Otp;
use Piyush\EmailOtp\Model\ResourceModel\Otp\CollectionFactory;

class OtpRepository implements OtpRepositoryInterface
{
    /**
     * @var OtpFactory
     */
    private $otpFactory;

    /**
     * @var Otp
     */
    private $otpResource;

    /**
     * @var OtpCollectionFactory
     */
    private $otpCollectionFactory;

    /**
     * @var OtpSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    public function __construct(
        OtpFactory $otpFactory,
        Otp $otpResource,
        CollectionFactory $otpCollectionFactory,
        OtpSearchResultsInterfaceFactory $otpSearchResultsInterfaceFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->otpFactory = $otpFactory;
        $this->otpResource = $otpResource;
        $this->otpCollectionFactory = $otpCollectionFactory;
        $this->searchResultsFactory = $otpSearchResultsInterfaceFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @param int $id
     * @return \Piyush\EmailOtp\Api\Data\OtpInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id)
    {
        $otp = $this->otpFactory->create();
        $this->otpResource->load($otp, $id);
        if (!$otp->getId()) {
            throw new NoSuchEntityException(__('Unable to find Otp with ID "%1"', $id));
        }
        return $otp;
    }

    /**
     * @param \Piyush\EmailOtp\Api\Data\OtpInterface $otp
     * @return \Piyush\EmailOtp\Api\Data\OtpInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(OtpInterface $otp)
    {
        $this->otpResource->save($otp);
        return $otp;
    }

    /**
     * @param \Piyush\EmailOtp\Api\Data\OtpInterface $otp
     * @return bool true on success
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(OtpInterface $otp)
    {
        try {
            $this->otpResource->delete($otp);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the entry: %1', $exception->getMessage())
            );
        }

        return true;

    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Piyush\EmailOtp\Api\Data\OtpSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->otpCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultsFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());

        return $searchResults;
    }
}