<?php

namespace Piyush\EmailOtp\Api;

interface SendAndSaveOtpRequestInterface
{
    public const EMAIL = 'email';

    /**
     * @return string
     */
    public function getEmail();
    
    /**
     * @return string
     */
    public function setEmail($email);
}