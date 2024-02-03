<?php

namespace Piyush\EmailOtp\Model;

use Piyush\EmailOtp\Api\SendMessageInterface;
use Piyush\EmailOtp\Helper\Data as DataHelper;
use Piyush\EmailOtp\Helper\Email as EmailHelper;
use Magento\Framework\Json\Helper\Data as JsonHelper;
use Psr\Log\LoggerInterface as PsrLoggerInterface;

class SendMessage implements SendMessageInterface
{
    private $dataHelper;

    private $emailHelper;

    private $jsonHelper;

    private $logger;

    public function __construct(
        DataHelper $dataHelper,
        EmailHelper $emailHelper,
        JsonHelper $jsonHelper,
        PsrLoggerInterface $logger
    ) {
        $this->dataHelper = $dataHelper;
        $this->emailHelper = $emailHelper;
        $this->jsonHelper = $jsonHelper;
        $this->logger = $logger;
    }

    public function execute($otp)
    {
        if (!$this->dataHelper->isModuleEnabled()) {
            return false;
        }

        $senderName = $this->dataHelper->getStoreName();
        $senderEmail = $this->dataHelper->getStoreEmail();
        $otpTemplateId = $this->dataHelper->getOtpEmailTemplate();
        
        return $this->emailHelper->sendEmail(
            $senderName,
            $senderEmail,
            $otp->getOtp(),
            $otp->getEmail(),
            $otpTemplateId
        );
    }
}