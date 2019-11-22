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

namespace StoneandStorm\CustomerPaymentMethod\Model\Entity\Attribute\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class Paymentmethods extends AbstractSource
{
    protected $_helper;
    protected $_paymentConfig;
    protected $_orderPayment;
    protected $_paymentHelper;

    /**
     * @param \StoneandStorm\CustomerPaymentMethod\Helper\Data $helper
     * @param \Magento\Sales\Model\ResourceModel\Order\Payment\Collection $orderPayment
     * @param \Magento\Payment\Helper\Data $paymentHelper
     * @param \Magento\Payment\Model\Config $paymentConfig
     */
    public function __construct(
        \StoneandStorm\CustomerPaymentMethod\Helper\Data $helper,
        \Magento\Sales\Model\ResourceModel\Order\Payment\Collection $orderPayment,
        \Magento\Payment\Helper\Data $paymentHelper,
        \Magento\Payment\Model\Config $paymentConfig
    ) {
        $this->_helper = $helper;
        $this->_orderPayment = $orderPayment;
        $this->_paymentHelper = $paymentHelper;
        $this->_paymentConfig = $paymentConfig;
    }

    public function getAllOptions()
    {
        $paymentMethods = $this->getActivePaymentMethods();

        $optionArray = $this->_helper->prepareDropdowndata($paymentMethods);

        return $optionArray;
    }

    public function getActivePaymentMethods()
    {
        return $this->_paymentHelper->getPaymentMethods();
    }
}