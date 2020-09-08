<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;
use Ramapriya\ElementViewer;
use Bitrix\Main\Context;

$module_id = 'ramapriya.elementviewer';
$request = Context::getCurrent()->getRequest();
$server = Context::getCurrent()->getServer();

Loc::loadMessages($_SERVER['DOCUMENT_ROOT'].BX_ROOT.'/modules/main/options.php');
Loc::loadMessages(__FILE__);

Loader::includeModule($module_id);


$aTabs = [
    [
        'DIV' => 'edit1',
        'TAB' => Loc::getMessage('EV_OPTIONS_TAB_SETTINGS'),
        'TITLE' => Loc::getMessage('EV_OPTIONS_TAB_SETTINGS'),
        'OPTIONS' => [
            [
                'slider',
                Loc::getMessage('EV_OPTIONS_SLIDER_LINK'),
                ElementViewer\Configurator::getSliderURI(),
                ['text', 40]
            ]
        ]
    ]
];

if ($request->isPost() && $request['Update'] && check_bitrix_sessid())
{

    foreach ($aTabs as $aTab)
    {
        //Или можно использовать __AdmSettingsSaveOptions($MODULE_ID, $arOptions);
        foreach ($aTab['OPTIONS'] as $arOption)
        {
            if (!is_array($arOption)) //Строка с подсветкой. Используется для разделения настроек в одной вкладке
                continue;

            if ($arOption['note']) //Уведомление с подсветкой
                continue;


            //Или __AdmSettingsSaveOption($MODULE_ID, $arOption);
            $optionName = $arOption[0];

            $optionValue = $request->getPost($optionName);

            Option::set($module_id, $optionName, is_array($optionValue) ? implode(",", $optionValue):$optionValue);
        }
    }
}

$tabControl = new CAdminTabControl('tabControl', $aTabs);

$tabControl->Begin();

?>

<form action="<?=$request->getRequestedPage()?>?mid=<?=htmlspecialcharsbx($request['mid'])
?>&lang=<?=$request['lang']?>" method="POST" name="<?=ElementViewer\Configurator::getModuleSettingsParam()?>">

    <?php

    foreach ($aTabs as $tab) {

        if($tab['OPTIONS']) {
            $tabControl->BeginNextTab();
            __AdmSettingsDrawList($module_id, $tab['OPTIONS']);
        }

    }

    $tabControl->BeginNextTab();

    $tabControl->Buttons();

    ?>

    <input type="submit" name="Update" value="<?=Loc::getMessage('MAIN_SAVE')?>">
    <input type="reset" name="reset" value="<?=Loc::getMessage('MAIN_RESET')?>">
    <?=bitrix_sessid_post();?>

</form>

