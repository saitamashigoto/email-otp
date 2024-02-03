<?php

namespace Piyush\EmailOtp\Api;

use Piyush\EmailOtp\Api\SendAndSaveOtpRequestInterface;
use Piyush\EmailOtp\Api\SendAndSaveOtpResponseInterface;
use Piyush\EmailOtp\Api\VerifyOtpRequestInterface;
use Piyush\EmailOtp\Api\VerifyOtpResponseInterface;

interface OtpManagerInterface
{
    /**
     * @param SendAndSaveOtpRequestInterface $request
     * @return SendAndSaveOtpResponseInterface
     */
    public function sendAndSaveOtp($request);

    /**
     * @param VerifyOtpRequestInterface $request
     * @return boolean
     */
    public function verifyOtp($request);
}