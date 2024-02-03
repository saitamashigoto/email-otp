<?php

namespace Piyush\EmailOtp\Api;

interface GenerateOtpInterface
{
    public const OTP_LENGTH = 6;

    public const CHARS_DIGITS = '0123456789';

    public const CHARS_DIGITS_WITHOUT_ZERO = '123456789';

    public function execute();
}