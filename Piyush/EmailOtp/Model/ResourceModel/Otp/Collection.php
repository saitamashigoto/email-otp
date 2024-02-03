<?php
namespace Piyush\EmailOtp\Model\ResourceModel\Otp;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';
    
    /**
     * @return void
     */
    public function _construct()
    {
        $this->_init(
            \Piyush\EmailOtp\Model\Otp::class,
            \Piyush\EmailOtp\Model\ResourceModel\Otp::class
        );
        $this->_map['fields']['entity_id'] = 'main_table.entity_id';
    }
}