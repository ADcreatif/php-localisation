<?php

namespace ADcreatif\Localisation\Common;

use ADcreatif\Localisation\Localisation;

function _(string $string, string $local_lang = null)
{
    global $lang;
    $localisation = new Localisation();
    return $localisation->getTranslation($string, $local_lang || $lang);
}