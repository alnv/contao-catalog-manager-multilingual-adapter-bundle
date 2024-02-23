<?php

foreach ($GLOBALS['TL_DCA']['tl_catalog_field']['palettes'] as $strName => $strPalette) {
    if (\in_array($strName, ['default', '__selector__'])) {
        continue;
    }
    $GLOBALS['TL_DCA']['tl_catalog_field']['palettes'][$strName] .= ';{multilingual_legend},translatableFor';
}

$GLOBALS['TL_DCA']['tl_catalog_field']['fields']['translatableFor'] = [
    'inputType' => 'checkbox',
    'eval' => [
        'chosen' => true,
        'maxlength' => 255,
        'multiple' => true,
        'tl_class' => 'clr'
    ],
    'options_callback' => ['catalogmanagermultilingualadapter.datacontainer.catalogfield', 'getLanguages'],
    'search' => true,
    'sql' => ['type' => 'string', 'length' => 255, 'default' => '']
];