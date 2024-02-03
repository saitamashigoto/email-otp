<?php

namespace Piyush\EmailOtp\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;
use Piyush\EmailOtp\Api\Data\OtpInterface;

class Otp extends AbstractModel implements IdentityInterface, OtpInterface
{
    /**
     * No route page id.
     */
    public const NOROUTE_ENTITY_ID = 'no-route';
        
    public const CACHE_TAG = 'piyush_emailotp_otp';
    
    /**
     * @var string
     */
    protected $_cacheTag = 'piyush_emailotp_otp';

    /**
     * @var string
     */
    protected $_eventPrefix = 'piyush_emailotp_otp';
    
    /**
     * Dependency Initilization
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init(\Piyush\EmailOtp\Model\ResourceModel\Otp::class);
    }
    
    /**
     * Load object data.
     *
     * @param int $id
     * @param string|null $field
     * @return $this
     */
    public function load($id, $field = null)
    {
        if ($id === null) {
            return $this->noRoute();
        }
        return parent::load($id, $field);
    }
    
    /**
     * No Route
     *
     * @return $this
     */
    public function noRoute()
    {
        return $this->load(self::NOROUTE_ENTITY_ID, $this->getIdFieldName());
    }

    /**
     * Get Identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG.'_'.$this->getId()];
    }

    /**
     * Get Id
     *
     * @return int|null
     */
    public function getId()
    {
        return parent::getData(self::ENTITY_ID);
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        return $this->setData(self::ENTITY_ID, $id);
    }

    /**
     * @inheritdoc
     */
    public function getIpAddress()
    {
        return parent::getData(self::IP_ADDRESS);
    }

    /**
     * @inheritdoc
     */
    public function setIpAddress($ipAddress)
    {
        return $this->setData(self::IP_ADDRESS, $ipAddress);
    }

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

    /**
     * @inheritdoc
     */
    public function getEmail()
    {
        return parent::getData(self::EMAIL);
    }

    /**
     * @inheritdoc
     */
    public function setEmail($email)
    {
        return $this->setData(self::EMAIL, $email);
    }

    /**
     * @inheritdoc
     */
    public function getTimes()
    {
        return parent::getData(self::TIMES);
    }

    /**
     * @inheritdoc
     */
    public function setTimes($times)
    {
        return $this->setData(self::TIMES, $times);
    }

    /**
     * @inheritdoc
     */
    public function getCreatedAt()
    {
        return parent::getData(self::CREATED_AT);
    }

    /**
     * @inheritdoc
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * @inheritdoc
     */
    public function getUpdatedAt()
    {
        return parent::getData(self::UPDATED_AT);
    }

    /**
     * @inheritdoc
     */
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $createdAt);
    }
}