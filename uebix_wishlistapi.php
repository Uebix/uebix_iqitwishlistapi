<?php
/**
 * 2014-2021 Uebix di Di Bella Antonino
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Uebix commercial License
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@uebix.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this PrestaShop Module to newer
 * versions in the future. If you wish to customize this PrestaShop Module for your
 * needs please refer to info@uebix.com for more information.
 *
 *  @author    Uebix <info@uebix.com>
 *  @copyright 2021-2021 Uebix
 *  @license   commercial use only, contact info@uebix.com for licence
 *  International Registered Trademark & Property of Uebix di Di Bella Antonino
 */

if (! defined('_PS_VERSION_')) {
    exit();
}

class Uebix_WishlistAPI extends Module
{

    protected $_hooks = array(
        'addWebserviceResources'
    );

    public function __construct()
    {
        $this->name = 'uebix_wishlistapi';
        $this->tab = 'export';
        $this->version = '1.1.0';
        $this->author = 'Uebix.com';
        $this->need_instance = 1;
        $this->dependencies = ['iqitwishlist'];
        
        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;
        
        parent::__construct();
        
        $this->displayName = $this->getTranslator()->trans('Extend IqitWishlist with web services', [], 'Modules.Uebix_WishlistAPI.Admin');
        $this->description = $this->getTranslator()->trans('Extend IqitWishlist PrestaShop Module with web services for external services like Marketing Automation Software', [], 'Modules.Uebix_WishlistAPI.Admin');
        
        $this->confirmUninstall = $this->getTranslator()->trans('Are you sure you want to uninstall?', [], 'Modules.Uebix_WishlistAPI.Admin');
        
        $this->ps_versions_compliancy = array(
            'min' => '1.7',
            'max' => _PS_VERSION_
        );
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        if (Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }
        
        if (parent::install()) {
            foreach ($this->_hooks as $hook) {
                if (! $this->registerHook($hook)) {
                    return false;
                }
            }
            return true;
        }
        return false;
    }

    public function uninstall()
    {
        if (Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }
        
        return parent::uninstall();
    }

    public function isUsingNewTranslationSystem()
    {
        return true;
    }

    public function hookAddWebserviceResources()
    {
        if (Module::isInstalled('iqitwishlist')) {
            $iqitWishlist = Module::getInstanceByName('iqitwishlist');
            return array(
                'iqitwishlist_products' => array(
                    'description' => 'Customer\'s Wishlists',
                    'specific_management' => false,
                    'class' => 'IqitWishlistProduct'
                )
            );
        }
    }
}
