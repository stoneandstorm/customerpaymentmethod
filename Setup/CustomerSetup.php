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

namespace StoneandStorm\CustomerPaymentMethod\Setup;

use Magento\Eav\Model\Config;
use Magento\Eav\Model\Entity\Setup\Context;
use Magento\Eav\Setup\EavSetup;
use Magento\Framework\App\CacheInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\Group\CollectionFactory;

class CustomerSetup extends EavSetup {

	protected $eavConfig;

	public function __construct(
		ModuleDataSetupInterface $setup,
		Context $context,
		CacheInterface $cache,
		CollectionFactory $attrGroupCollectionFactory,
		Config $eavConfig
		) {
		$this -> eavConfig = $eavConfig;
		parent :: __construct($setup, $context, $cache, $attrGroupCollectionFactory);
	}

	public function installAttributes($customerSetup)
    {
		$this -> installCustomerAttributes($customerSetup);
		$this -> installCustomerAddressAttributes($customerSetup);
	}

	public function installCustomerAttributes($customerSetup)
    {
		$customerSetup -> addAttribute(\Magento\Customer\Model\Customer::ENTITY,
			'cpm_disable',
			[
			'label' => 'disable payment method',
			'system' => 0,
			'position' => 100,
            'sort_order' =>100,
            'visible' =>  false,
			'note' => '',
                'type' => 'varchar',
                'input' => 'multiselect',
                'source' => 'StoneandStorm\CustomerPaymentMethod\Model\Entity\Attribute\Source\Paymentmethods',
                'backend' => 'Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend',
			]
        );

		$customerSetup -> getEavConfig() -> getAttribute('customer', 'cpm_disable')->setData('is_user_defined',1)->setData('is_required',0)->setData('default_value','')->setData('used_in_forms', ['adminhtml_customer']) -> save();
	}

	public function installCustomerAddressAttributes($customerSetup) {
			
	}

	public function getEavConfig() {
		return $this -> eavConfig;
	}
} 