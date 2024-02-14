<?php

/**
 * noimage
 *
 * @author  Jay Trees <noimage@grandels.email>
 * @link    https://github.com/grandeljay/modified-noimage
 */

namespace Grandeljay\Noimage;

use Grandeljay\Translator\Translations;

$translations = new Translations(__FILE__, Constants::MODULE_NAME);
$translations->add('TITLE', 'grandeljay - noimage');
$translations->add('TEXT_TITLE', 'noimage');

$translations->define();
