<?php


namespace Ramapriya\ElementViewer;

use Bitrix\Main\IO\Directory;
use Bitrix\Main\Loader;
use Bitrix\Main\Page\Asset;

class Viewer
{
    use ElementViewerTrait;

    /**
     * @var string MODULE_JS_LIBRARY название js библиотеки
     */
    const MODULE_JS_LIBRARY = 'ElementViewer';

    /**
     * @var array $folders список папок, где может быть установлен модуль
     */
    private static $folders = [
        Loader::BITRIX_HOLDER,
        Loader::LOCAL_HOLDER
    ];

    /**
     * Получает путь к модулю, вне зависимости от расположения
     *
     * @param bool $notDocumentRoot
     *
     * @uses Viewer::$folders
     * @uses Viewer::MODULE_ID
     *
     * @return string
     */
    public static function getModulePath($notDocumentRoot = false)
    {
        foreach (self::$folders as $folder) {

            $path = $_SERVER['DOCUMENT_ROOT'] . '/' . $folder . '/modules/' . self::$moduleId;

            if(Directory::isDirectoryExists($path)) {

                if($notDocumentRoot) {
                    $path = str_ireplace($_SERVER['DOCUMENT_ROOT'], '', $path);
                }

                return $path;
            }

        }
    }

    /**
     * Регистрирует js библиотеку
     *
     * @uses Viewer::MODULE_JS_LIBRARY
     */
    public static function RegisterJsLibrary()
    {
        \CJSCore::RegisterExt(self::MODULE_JS_LIBRARY, [
            'js' => self::getModulePath(true) . '/js/elementviewer.js',
            'rel' => ['SidePanel']
        ]);
    }

    /**
     * Инициализирует js библиотеку
     *
     * @uses Viewer::MODULE_JS_LIBRARY
     */
    public static function InitJsLibrary()
    {
        \CJSCore::Init([self::MODULE_JS_LIBRARY]);

        Asset::getInstance()->addString("<script>
    BX.ready(function() {
      ElementViewer.init('".Configurator::getSliderURI()."');
    });
</script>");
    }

}