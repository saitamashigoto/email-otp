<?php
namespace Piyush\EmailOtp\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const XML_PATH_MODULE_ENABLE = "emailotp/general/enable";
    const XML_PATH_STORE_NAME = 'trans_email/ident_sales/name';
    const XML_PATH_STORE_EMAIL = 'trans_email/ident_sales/email';
    const XML_PATH_OTP_TEMPLATE = 'emailotp/general/template';

    public function isModuleEnabled($store = null)
    {
        return !!$this->scopeConfig->getValue(
            self::XML_PATH_MODULE_ENABLE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    public function getStoreName($store = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_STORE_NAME,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    public function getStoreEmail($store = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_STORE_EMAIL,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    public function getOtpEmailTemplate($store = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_OTP_TEMPLATE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $store
        );
    }
}
