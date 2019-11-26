<?php
declare(strict_types=1);

use Gettext\Generator\MoGenerator;
use Gettext\Generator\PoGenerator;
use Reformo\Common\Services\GettextArrayLoader;

chdir(__DIR__ . '/../');

require 'vendor/autoload.php';

$localeFiles = glob('config/autoload/*/locale/*.php');
$moGenerator = new MoGenerator();
$poGenerator = new PoGenerator();

foreach ($localeFiles as $localeFile) {
    $localeData = require($localeFile);
    $domain = $localeData['domain'];
    $locale = $localeData['locale'];
    $translations = (new GettextArrayLoader())->loadArray($localeData);
    $dirName = 'data/cache/locale/' . $locale . '/LC_MESSAGES';
    if (!file_exists($dirName)) {
        mkdir($dirName, 0744, true);
    }
    $moGenerator->generateFile($translations, $dirName. '/'.$domain.'.mo');
    $poGenerator->generateFile($translations, $dirName. '/'.$domain.'.po');

}



