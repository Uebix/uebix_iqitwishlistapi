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

$sql = [];

try {
    $sql[] = 'ALTER TABLE `' . _DB_PREFIX_ . 'iqitwishlist_product`
        ADD COLUMN `date_add` datetime NOT NULL';
    $sql[] = 'ALTER TABLE `' . _DB_PREFIX_ . 'iqitwishlist_product`
        ADD COLUMN `date_upd` datetime NOT NULL';
    
    Db::getInstance()->execute($qryModifyCategoryConfTable);
} catch (Exception $e) {
    if (Db::getInstance()->getNumberError() != 1060)
        $result .= $this->displayError('Error in ALTER TABLE ' . _DB_PREFIX_ . $this->name . '_category ADD COLUMN: [' . Db::getInstance()->getNumberError() . '] ' . $e->getMessage());
}


$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'configurator3d_ticket` (
            `id_ticket` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(128) NOT NULL,
            `ticket` varchar(500) NOT NULL,
            `date_add` datetime NOT NULL,
            `date_upd` datetime NOT NULL,
            PRIMARY KEY  (`id_ticket`)
            ) ENGINE=' . _MYSQL_ENGINE_;

foreach ($sql as $query) {
    if (Db::getInstance()->execute($query) == false) {
        return false;
    }
}
