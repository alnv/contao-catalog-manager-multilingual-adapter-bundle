<?php
$GLOBALS['TL_HOOKS']['changelanguageNavigation'][] = ['catalogmanagermultilingualadapter.hooks.changelanguage', 'onChangelanguageNavigation'];
$GLOBALS['TL_HOOKS']['loadVirtualDataContainer'][] = ['catalogmanagermultilingualadapter.hooks.datacontainer', 'generateVirtualDataContainerArray'];
$GLOBALS['TL_HOOKS']['loadDataContainer'][] = ['catalogmanagermultilingualadapter.hooks.datacontainer', 'generateDataContainerArray'];
$GLOBALS['TL_HOOKS']['parseCatalogField'][] = ['catalogmanagermultilingualadapter.hooks.catalogwizard', 'parseCatalogField'];
$GLOBALS['TL_HOOKS']['parseCatalog'][] = ['catalogmanagermultilingualadapter.hooks.catalogwizard', 'parseCatalog'];

$GLOBALS['CM_DATA_CONTAINERS'][] = 'Multilingual';

$GLOBALS['CM_CUSTOM_FIELDS']['lid'] = [
    'index' => true,
    'sql' => "int(10) unsigned NOT NULL default '0'"
];

$GLOBALS['CM_CUSTOM_FIELDS']['language'] = [
    'index' => true,
    'sql' => "varchar(6) NOT NULL default ''"
];