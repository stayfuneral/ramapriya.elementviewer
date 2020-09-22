<?php

use Bitrix\Iblock\IblockTable;
use Bitrix\Iblock\ElementTable;
use Bitrix\Iblock\SectionTable;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");




$request = Bitrix\Main\Context::getCurrent()->getRequest();


if($request['IFRAME'] === 'Y') {

    $APPLICATION->RestartBuffer();
    $APPLICATION->ShowHead();

    if($request['element_id'] && $request['list_id']) {

        $listId = $request['list_id'];
        $elementId = $request['element_id'];

        $Iblock = IblockTable::getById($listId)->fetchObject();
        $listName = $Iblock->getName();

        $element = ElementTable::getById($elementId)->fetchObject();
        $elementName = $element->getName();
        if($element->getDetailText()) {
            $detailText = $element->getDetailText();
        }

        if($request['section_id']) {
            $sectionId = $request['section_id'];
            $section = SectionTable::getById($sectionId)->fetchObject();
            $sectionName = $section->getName();
        }

?>


        <div style="margin: 1em;">
            <h1>[#<?=$elementId?>] <?=$elementName?></h1>
            <p><b>Универсальный список:</b> <?=$listName?></p>
            <?php if($sectionId) {?><p><b>Раздел:</b> <?=$sectionName?></p><?php }?>
        </div>




<?php
    }

}



require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");