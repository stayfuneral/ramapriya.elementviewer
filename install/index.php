<?php

use Bitrix\Main\ModuleManager;
use Bitrix\Main\EventManager;
use Bitrix\Main\Loader;
use Bitrix\Main\Config\Option;
use Ramapriya\ElementViewer\EventHandler;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);


class ramapriya_elementviewer extends CModule
{

    private $eventManager;

    function __construct()
    {
        $this->eventManager = EventManager::getInstance();

        $this->MODULE_ID = 'ramapriya.elementviewer';

        $this->MODULE_NAME = Loc::getMessage('EV_MODULE_NAME');
        $this->PARTNER_NAME = Loc::getMessage('EV_PARTNER_NAME');
        $this->PARTNER_URI = Loc::getMessage('EV_PARTNER_URI');
    }

    function DoInstall()
    {
        if(!$this->isD7()) {
            throw new \Exception('Kernel version is not support D7 technology. Please, update website core');
        }

        ModuleManager::registerModule($this->MODULE_ID);
        $this->InstallEvents();
        $this->InstallDB();


    }

    function DoUninstall()
    {
        ModuleManager::unRegisterModule($this->MODULE_ID);
        $this->UnInstallDB();
        $this->UnInstallEvents();

    }

    function isD7()
    {
        return CheckVersion(ModuleManager::getVersion('main'), '14.00.00');
    }

    function InstallDB()
    {
        Loader::includeModule($this->MODULE_ID);
        Option::set(
            $this->MODULE_ID,
            'slider',
            Ramapriya\ElementViewer\Viewer::getModulePath(true) .'/slider/'
        );
    }

    function UnInstallDB()
    {
        Option::delete($this->MODULE_ID);
    }

    function InstallEvents()
    {
        Loader::includeModule($this->MODULE_ID);
        EventHandler::registerHandler($this->eventManager);
    }

    function UnInstallEvents()
    {
        Loader::includeModule($this->MODULE_ID);
        EventHandler::unRegisterHandler($this->eventManager);
    }


}


