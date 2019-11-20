<?php
declare(strict_types=1);

$i18nData = require __DIR__ . '/en_US.php';
$i18nData['locale'] =  'en';
$i18nData['messages']['_LOCALE']['translate'] = 'en';
$i18nData['messages']['_LANG']['translate']   = 'en';
$i18nData['messages']['_REGION']['translate'] = 'intl';
return $i18nData;
