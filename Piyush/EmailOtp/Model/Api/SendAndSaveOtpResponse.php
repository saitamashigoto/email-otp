<?php
namespace Piyush\EmailOtp\Model\Api;

use Piyush\EmailOtp\Api\SendAndSaveOtpResponseInterface;
use Magento\Framework\DataObject;

class SendAndSaveOtpResponse extends DataObject implements SendAndSaveOtpResponseInterface
{
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
