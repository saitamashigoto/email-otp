<?php

namespace Piyush\EmailOtp\Api;

interface OtpRepositoryInterface
{
    /**
     * @param int $id
     * @return \Piyush\EmailOtp\Api\Data\OtpInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id);

    /**
     * @param \Piyush\EmailOtp\Api\Data\OtpInterface $student
     * @return \Piyush\EmailOtp\Api\Data\OtpInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(\Piyush\EmailOtp\Api\Data\OtpInterface $student);

    /**
     * @param \Piyush\EmailOtp\Api\Data\OtpInterface $student
     * @return bool true on success
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(\Piyush\EmailOtp\Api\Data\OtpInterface $student);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Piyush\EmailOtp\Api\Data\OtpSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
}