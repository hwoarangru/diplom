<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule('iblock')){
    return;
}
CModule::IncludeModule('form');
$arIBlockType = array(''=>'');
$rsIBlockType = CIBlockType::GetList(array('sort'=>'asc'), array('ACTIVE'=>'Y'));
while ($arr=$rsIBlockType->Fetch()) {
    if($ar=CIBlockType::GetByIDLang($arr['ID'], LANGUAGE_ID)) {
        $arIBlockType[$arr['ID']] = '['.$arr['ID'].'] '.$ar['NAME'];
    }
}

$arIBlock=array(''=>'');
$rsIBlock = CIBlock::GetList(Array('sort' => 'asc'), Array('TYPE' => $arCurrentValues['IBLOCK_TYPE'], 'ACTIVE'=>'Y'));
while($arr=$rsIBlock->Fetch()) {
    $arIBlock[$arr['ID']] = '['.$arr['ID'].'] '.$arr['NAME'];
}

$arForms = array(''=>'');
$rsForms = CForm::GetList($by="s_id", $order="desc", array(), $is_filtered);
while($arr=$rsForms->Fetch()) {
    $arForms[$arr['ID']] = '['.$arr['ID'].'] '.$arr['NAME'];
}



$arSorts = Array('ASC'=>'По возрастанию', 'DESC'=>'По убыванию');
$arSortFields = Array(
        'ID'=>'По id',
        'NAME'=>'По имени',
        'ACTIVE_FROM'=>'По дате',
        'SORT'=>'По полю сортировки',
        'TIMESTAMP_X'=>'По дате создания'
    );

$arComponentParameters = array(
	'GROUPS' => array(
		"WEB_FORM"	=> array("NAME"	=> "Параметры веб-формы"),
	),
    'PARAMETERS' => array(
		"VARIABLE_ALIASES" => Array(
			"list" => Array("NAME" => 'Список'),
			"section" => Array("NAME" => 'Раздел'),
			"detail" => Array("NAME" => 'Элемент'),
		),
		"SEF_MODE" => Array(
			"list" => array(
				"NAME" => 'Список',
				"DEFAULT" => "index.php",
				"VARIABLES" => array(),
			),
			"section" => array(
				"NAME" => 'Раздел',
				"DEFAULT" => "",
				"VARIABLES" => array("SECTION_ID"),
			),
			"detail" => array(
				"NAME" => 'Элемент',
				"DEFAULT" => "#ELEMENT_ID#",
				"VARIABLES" => array("ELEMENT_ID"),
			),
		),
        'IBLOCK_TYPE' => array(
            'PARENT' => 'BASE',
            'NAME' => 'Тип инфоблока',
            'TYPE' => 'LIST',
            'VALUES' => $arIBlockType,
            'REFRESH' => 'Y',
        ),
        'IBLOCK_ID' => array(
            'PARENT' => 'BASE',
            'NAME' => 'ID инфоблока',
            'TYPE' => 'LIST',
            'VALUES' => $arIBlock,
            'REFRESH' => 'Y',
        ),
        'ELEMENT_COUNT' => Array(
            'PARENT' => 'BASE',
            'NAME' => 'Количество элементов',
            'TYPE' => 'STRING',
            'DEFAULT' => '',
        ),
        'SORT_BY1' => Array(
            'PARENT' => 'DATA_SOURCE',
            'NAME' => 'Сортировка',
            'TYPE' => 'LIST',
            'DEFAULT' => 'ACTIVE_FROM',
            'VALUES' => $arSortFields,
            'ADDITIONAL_VALUES' => 'Y',
        ),
        'SORT_ORDER1' => Array(
            'PARENT' => 'DATA_SOURCE',
            'NAME' => 'порядок',
            'TYPE' => 'LIST',
            'DEFAULT' => 'DESC',
            'VALUES' => $arSorts,
        ),
        'SORT_BY2' => Array(
            'PARENT' => 'DATA_SOURCE',
            'NAME' => 'Вторая сортировка',
            'TYPE' => 'LIST',
            'DEFAULT' => 'SORT',
            'VALUES' => $arSortFields,
            'ADDITIONAL_VALUES' => 'Y',
        ),
        'SORT_ORDER2' => Array(
            'PARENT' => 'DATA_SOURCE',
            'NAME' => 'порядок',
            'TYPE' => 'LIST',
            'DEFAULT' => 'ASC',
            'VALUES' => $arSorts,
        ),
       'DATE_FORMAT' => CIBlockParameters::GetDateFormat("Формат вывода даты", "DETAIL_SETTINGS"),
       'FILTER_NAME' => Array(
    		"PARENT" => "FILTER_SETTINGS",
    		"NAME" => "Переменная, содержащая параметры фильтра",
    		"TYPE" => "STRING",
    		"DEFAULT" => "",
    	),
		"DISPLAY_PANEL" => Array(
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME" => "Показывать панель",
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		),
		"SET_TITLE" => Array(
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME" => "Разрешить устанавливать заголовок страницы",
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		),
		"INCLUDE_IBLOCK_INTO_CHAIN" => Array(
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME" => "Строить навигационную цепочку",
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		),
		"ADD_SECTIONS_CHAIN" => Array(
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME" => "Добавлять разделы в навигационную цепочку",
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		),
		"CACHE_TIME"  =>  Array("DEFAULT"=>3600),
		"FORM_ID" => Array(
			"PARENT" => "WEB_FORM",
			"NAME" => "ID web-формы",
			"TYPE" => "LIST",
            'VALUES' => $arForms,
            'REFRESH' => 'Y',
            'DEFAULT' => 'N',
		),
		"FORM_TITLE" => Array(
			"PARENT" => "WEB_FORM",
			"NAME" => "Заголовок web-формы",
			"TYPE" => "STRING",
            'DEFAULT' => '',
		),
    ),
);

?>