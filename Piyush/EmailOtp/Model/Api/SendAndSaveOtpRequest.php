<?php

namespace Piyush\EmailOtp\Model\Api;

use Piyush\EmailOtp\Api\SendAndSaveOtpRequestInterface;
use Magento\Framework\DataObject;

class SendAndSaveOtpRequest extends DataObject implements SendAndSaveOtpRequestInterface
{
    /**
     * @inheritdoc
     */
    public function getEmail()
    {
        return parent::getData(self::EMAIL);
    }

    /**
     * @inheritdoc
     */
    public function setEmail($email)
    {
        return $this->setData(self::EMAIL, $email);
    }
}
