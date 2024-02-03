<?php

namespace Piyush\EmailOtp\Model\Api;

use Piyush\EmailOtp\Api\VerifyOtpRequestInterface;
use Magento\Framework\DataObject;

class VerifyOtpRequest extends DataObject implements VerifyOtpRequestInterface
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

    /**
     * @inheritdoc
     */
    public function getOtp()
    {
        return parent::getData(self::OTP);
    }

    /**
     * @inheritdoc
     */
    public function setOtp($otp)
    {
        return $this->setData(self::OTP, $otp);
    }
}
