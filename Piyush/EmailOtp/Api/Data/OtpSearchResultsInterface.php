<?php
/**
 * Copyright © Piyush, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Piyush\EmailOtp\Api\Data;

/**
 * Interface for customer search results.
 * @api
 * @since 100.0.2
 */
interface OtpSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get customers list.
     *
     * @return \Piyush\EmailOtp\Api\Data\OtpInterface[]
     */
    public function getItems();

    /**
     * Set customers list.
     *
     * @param \Piyush\EmailOtp\Api\Data\OtpInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
