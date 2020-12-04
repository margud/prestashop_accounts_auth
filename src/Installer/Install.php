<?php
/**
* 2007-2020 PrestaShop and Contributors
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License 3.0 (AFL-3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* https://opensource.org/licenses/AFL-3.0
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* @author    PrestaShop SA <contact@prestashop.com>
* @copyright 2007-2020 PrestaShop SA and Contributors
* @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
* International Registered Trademark & Property of PrestaShop SA
*/

namespace PrestaShop\AccountsAuth\Installer;

// FIXME : why nothing for 1.6
// FIXME : why no upgrade if not installed
// FIXME : manage dependencies here

use PrestaShop\AccountsAuth\Context\ShopContext;
use PrestaShop\AccountsAuth\Handler\ErrorHandler\ErrorHandler;
use PrestaShop\PrestaShop\Core\Addon\Module\ModuleManagerBuilder;

/**
 * Install ps_accounts module
 */
class Install
{
    /**
     * @var string
     */
    private $psAccounts = 'ps_accounts';

    /**
     * @var ShopContext
     */
    private $shopContext;

    /**
     * Install constructor.
     */
    public function __construct()
    {
        $this->shopContext = new ShopContext();
    }

    /**
     * Install ps_accounts module if not installed
     * Method to call in every psx modules during the installation process
     *
     * @return bool
     *
     * @throws \Exception
     */
    public function installPsAccounts()
    {
        if (true === $this->shopContext->isShop17()) {
            return $this->installPsAccounts17();
        }
        return $this->installPsAccounts16();
    }

    /**
     * @return bool
     *
     * @throws \Exception
     */
    public function installPsAccounts17()
    {
        $moduleManager = ModuleManagerBuilder::getInstance()->build();

//        if (true === $moduleManager->isInstalled($this->psAccounts)) {
//            return true;
//        }

        // install or upgrade module
        $moduleIsInstalled = $moduleManager->install($this->psAccounts);
        if (false === $moduleIsInstalled) {
            ErrorHandler::getInstance()->handle(
                new \Exception('Module ps_accounts can\'t be installed', 500),
                500
            );
        }

        return $moduleIsInstalled;
    }

    /**
     * @return bool
     */
    public function installPsAccounts16()
    {
        // if on PrestaShop 1.6, do nothing
        return true;
    }
}
