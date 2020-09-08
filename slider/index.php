<?php

use Bitrix\Iblock\IblockTable;
use Bitrix\Iblock\ElementTable;

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
?>

        <div style="margin: 1em;">
            <h1>[#<?=$elementId?>] <?=$elementName?></h1>
            <p><b>Универсальный список:</b> <?=$listName?></p>
        </div>




<?php
    }

}



require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");