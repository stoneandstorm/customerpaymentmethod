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

namespace StoneandStorm\CustomerPaymentMethod\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    protected $_config;
    protected $_customerSession;
    protected $_customerRepositoryInterface;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $config
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface,
        \Magento\Framework\App\Config\ScopeConfigInterface $config
    ) {
        $this->_config = $config;
        $this->_customerSession = $customerSession;
        $this->_customerRepositoryInterface = $customerRepositoryInterface;
        parent::__construct($context);
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        $moduleStatus = ($this->_config->getValue('sas_customerpaymentmethod/general/enabled') == 1) ? true : false;
        return $moduleStatus;
    }

    /**
     * @return array
     */
    public function getActiveCPM()
    {
        // Get the current userID from the logged in customer
        $customerID = $this->_customerSession->getId();

        // If we have an customerID get his settings, otherwise get the default settings
        if(isset($customerID)) {
            $customer = $this->_customerRepositoryInterface->getById($customerID);
            $customerPaymentMethods = $customer->getCustomAttribute('cpm_disable')->getValue();
        } else {
            $customerPaymentMethods = $this->_config->getValue('sas_customerpaymentmethod/general/payment_method', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        }

        // Value is a string
        $methods = explode(",", $customerPaymentMethods);

        return $methods;
    }

    /**
     * @return array
     */
    public function prepareDropdowndata($string) {
        $array = [];

        foreach ($string as $key => $paymentmethod) {
            if(isset($paymentmethod['title'])) {
                $array[] = ['value' => $key, 'label' => $paymentmethod['title'] . ' ('. $paymentmethod['model'] .')'];
            }
        }

        return $array;
    }
}
