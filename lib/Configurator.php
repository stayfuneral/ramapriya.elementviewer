<?php


namespace Ramapriya\ElementViewer;

use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class Configurator
{
    use ElementViewerTrait;

    /**
     * Получает ссылку на открываемую в слайдере страницу, указанную в настройках модуля
     *
     * @return string
     *
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     */
    public static function getSliderURI()
    {
        return Option::get(
            self::$moduleId,
            'slider'
        );
    }

    /**
     * Возвращает массив для создания формы на странице настроек модуля
     *
     * @return array
     *
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     */
    public static function getModuleOptionsTabs()
    {
        return [
            [
                'DIV' => 'edit1',
                'TAB' => Loc::getMessage('EV_OPTIONS_TAB_SETTINGS'),
                'TITLE' => Loc::getMessage('EV_OPTIONS_TAB_SETTINGS'),
                'OPTIONS' => [
                    [
                        'slider',
                        Loc::getMessage('EV_OPTIONS_SLIDER_LINK'),
                        self::getSliderURI(),
                        ['text', 40]
                    ]
                ]
            ]
        ];
    }


    /**
     * Возвращает имя формы на странице настроек модуля
     *
     * @return string
     */
    public static function getModuleSettingsParam()
    {
        return str_ireplace('.', '_', self::$moduleId) . '_settings';
    }
}