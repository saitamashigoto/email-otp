<?php

namespace Piyush\EmailOtp\Api\Data;

interface OtpInterface
{
    public const ENTITY_ID = "entity_id";

    public const IP_ADDRESS = "ip_address";

    public const OTP = "otp";

    public const EMAIL = "email";

    public const TIMES = "times";

    public const CREATED_AT = "created_at";

    public const UPDATED_AT = "updated_at";

    /**
     * @return int|null
     */
    public function getId();

    /**
     * @return string
     */
    public function getIpAddress();

    /**
     * @return string
     */
    public function getOtp();

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @return int
     */
    public function getTimes();

    /**
     * @return string
     */
    public function getCreatedAt();

    /**
     * @return string
     */
    public function getUpdatedAt();

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * @param string $ipAddress
     * @return $this
     */
    public function setIpAddress($ipAddress);

    /**
     * @param string $otp
     * @return $this
     */
    public function setOtp($otp);

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail($email);

    /**
     * @param int $times
     * @return $this
     */
    public function setTimes($times);

    /**
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt);

    /**
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt);
}