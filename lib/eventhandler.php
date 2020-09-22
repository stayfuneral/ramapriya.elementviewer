<?php


namespace Ramapriya\ElementViewer;

use Bitrix\Main\Context;
use Bitrix\Main\EventManager;

class EventHandler
{
    use ElementViewerTrait;

    private static $pattern = '/\/lists\/(\d+)\/view\//';

    const EVENT_ON_EPILOG = 'OnEpilog';

    /**
     * Обработчик события OnEpilog
     *
     * @uses Viewer::InitJsLibrary()
     */
    public static function handleEpilog()
    {
        $server = Context::getCurrent()->getServer();

        if(preg_match(self::$pattern, $server->getRequestUri())) {
            Viewer::InitJsLibrary();
        }
    }

    /**
     * Регистрация обработчика событий при установке модуля
     *
     * @param EventManager $eventManager
     */
    public static function registerHandler(EventManager $eventManager)
    {
        $eventManager->registerEventHandler(
            'main',
            self::EVENT_ON_EPILOG,
            self::$moduleId,
            __CLASS__,
            'handleEpilog'
        );
    }

    /**
     * Удаление обработчиков событий при удалении модуля
     *
     * @param EventManager $eventManager
     */
    public static function unRegisterHandler(EventManager $eventManager)
    {
        $eventManager->unRegisterEventHandler(
            'main',
            self::EVENT_ON_EPILOG,
            self::$moduleId,
            __CLASS__,
            'handleEpilog'
        );
    }
}