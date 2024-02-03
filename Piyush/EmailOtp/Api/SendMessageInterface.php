<?php

namespace Piyush\EmailOtp\Api;

interface SendMessageInterface
{
    public function execute($otp);
}