<?php

use Bitrix\Main\Context;
use Bitrix\Main\Config\Option;
use Ramapriya\ElementViewer;

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

$request = Context::getCurrent()->getRequest();
$inputs = json_decode($request->getInput());

if($inputs->action === 'get_slider_url') {

    $response = [
        'slider' => ElementViewer\Configurator::getSliderURI()
    ];
    echo json_encode($response);
}

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/epilog_after.php';