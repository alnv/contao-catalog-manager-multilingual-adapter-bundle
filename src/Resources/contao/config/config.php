<?php

$GLOBALS['TL_HOOKS']['loadVirtualDataContainer'][] = [ 'catalogmanagermultilingualadapter.hooks.virtualdatacontainer', 'generateVirtualDataContainerArray' ];
$GLOBALS['TL_HOOKS']['parseCatalogField'][] = [ 'catalogmanagermultilingualadapter.hooks.catalogwizard', 'parseCatalogField' ];

$GLOBALS['CM_DATA_CONTAINERS'][] = 'Multilingual';

$GLOBALS['CM_CUSTOM_FIELDS']['lid'] = [
    'index' => true,
    'sql' => "int(10) unsigned NOT NULL default '0'"
];

$GLOBALS['CM_CUSTOM_FIELDS']['language'] = [
    'index' => true,
    'sql' => "varchar(6) NOT NULL default ''"
];