<?php

namespace Piyush\EmailOtp\Api;

interface SendAndSaveOtpResponseInterface
{
    public const OTP = 'otp';
    
    /**
     * @return string|null
     */
    public function getOtp();
    
    /**
     * @param string $otp
     * @return $this
     */
    public function setOtp($otp);
}