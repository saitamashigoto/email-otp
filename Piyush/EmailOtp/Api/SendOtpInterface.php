<?php

namespace Piyush\EmailOtp\Api;

interface SendOtpInterface
{
    /**
     * @return bool
     */
    public function execute();
}