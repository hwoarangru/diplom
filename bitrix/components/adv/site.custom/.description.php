<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
        'NAME' => GetMessage('PTK_COMPONENT_NAME'),
        'DESCRIPTION' => GetMessage('PTK_COMPONENT_DESCRIPTION'),
	'ICON' => '/images/icon.gif',
        'CACHE_PATH' => 'Y',
        'SORT' => 50,
        'PATH' => array(
                'ID' => 'projectkit',
                'NAME' => GetMessage('PTK_COMPONENTS'),
                'CHILD' => array(
                        'SORT' => 10,
                        'ID' => 'templates',
                        'NAME' => GetMessage('PTK_GROUP_NAME'),
		),
	),
);

