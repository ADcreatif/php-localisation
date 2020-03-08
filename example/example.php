<?php
// Autoload files using Composer autoload

use ADcreatif\Localisation\Localisation;

require_once "../src/Localisation.php";
require_once "../src/Storage.php";

$localisation = new Localisation();
$localisation
    ->setDefaultLangage('EN')
    ->setCurrentLangage('EN')
    ->setDirname(__DIR__ . "/../lang/");


require_once "../src/Common.php";
// Gives access to translations functions

// define the global variable $lang (for ex with session)

// now you can use it eveywhere
//use function ADcreatif\Localisation\Common\_;
//use function ADcreatif\Localisation\Common\edit_localisation;

echo _('my sentence to translate');
