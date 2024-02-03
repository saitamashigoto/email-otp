<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * Captcha block
 *
 * @author     Magento Core Team <core@magentocommerce.com>
 */
namespace Piyush\EmailOtp\Block\Button;

/**
 * @api
 * @since 100.0.2
 */
class Register extends \Magento\Framework\View\Element\Template
{
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Captcha\Helper\Data $captchaData
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    public function getText()
    {
        return __('Otp Verification');
    }
}
