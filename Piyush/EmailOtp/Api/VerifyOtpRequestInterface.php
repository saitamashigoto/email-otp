<?php

namespace Piyush\EmailOtp\Api;

interface VerifyOtpRequestInterface
{
    public const OTP = 'otp';

    public const EMAIL = 'email';

    /**
     * @return string
     */
    public function getEmail();
    
    /**
     * @param string $email
     * @return $this
     */
    public function setEmail($email);

    /**
     * @return string
     */
    public function getOtp();
    
    /**
     * @param string $otp
     * @return $this
     */
    public function setOtp($otp);
}