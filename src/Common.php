<?php

namespace ADcreatif\Localisation\Common;
global $localisation;

function _(string $string, string $lang = null)
{
    global $localisation;
    $lang = $lang ? $lang : $localisation->getCurrentLangage();
    return $localisation->getTranslation($string, $lang);
}

if (array_key_exists('lang', $_GET)) {
    // language selection for view
    $languages = $localisation->getAvailableLanguages();

    if (array_key_exists('from', $_GET) && array_key_exists('to', $_GET)) {
        // translations edition for view
        $from = $_GET['from'];
        $to = $_GET['to'];

        $translations = $localisation->getFromTo($from, $to);
    }

    include "../public/edit_localisation.phtml";
    exit;
}
