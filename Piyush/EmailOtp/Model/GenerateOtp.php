<?php

namespace Piyush\EmailOtp\Model;

use Piyush\EmailOtp\Api\GenerateOtpInterface;
use Magento\Framework\Math\Random as MathRandom;

class GenerateOtp implements GenerateOtpInterface
{
    private $mathRandom;

    public function __construct(
        MathRandom $mathRandom
    ) {
        $this->mathRandom = $mathRandom;
    }

    public function execute()
    {
        return $this->mathRandom->getRandomString(1, self::CHARS_DIGITS_WITHOUT_ZERO)
            .$this->mathRandom->getRandomString(self::OTP_LENGTH-1, self::CHARS_DIGITS);
    }
}