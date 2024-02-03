<?php
namespace Piyush\EmailOtp\Model\ResourceModel;

class Otp extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * @return void
     */
    public function _construct()
    {
        $this->_init("piyush_emailotp_otp", "entity_id");
    }
}