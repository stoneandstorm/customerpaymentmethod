<?php
/**
 * With this module you can set-up payment methods for each customer
 * Copyright (C) 2019
 *
 * This file included in StoneandStorm/CustomerPaymentMethod is licensed under OSL 3.0
 *
 * http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * Please see LICENSE.txt for the full text of the OSL 3.0 license
 */

namespace StoneandStorm\CustomerPaymentMethod\Observer;

use Magento\Framework\Event\ObserverInterface;

class PaymentMethodHandler implements ObserverInterface
{
    protected $_helper;

    /**
     * @param \StoneandStorm\CustomerPaymentMethod\Helper\Data $helper
     */
    public function __construct(
        \StoneandStorm\CustomerPaymentMethod\Helper\Data $helper
    ) {
        $this->_helper = $helper;
    }

    /**
     * payment_method_is_active event handler.
     *
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        // First we check if the module is active
        if($this->_helper->isEnabled())
        {
            // Get all the active payment methods
            $availablePaymentMethods = $this->_helper->getActiveCPM();

            // A simple in array check
            if (in_array($observer->getEvent()->getMethodInstance()->getCode(), $availablePaymentMethods))
            {
                // If payment methos is in the array we need to disable it
                $checkResult = $observer->getEvent()->getResult();
                $checkResult->setData('is_available', false);
            }
        }
    }
}