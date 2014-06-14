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



$arSorts = Array('ASC'=>'�� �����������', 'DESC'=>'�� ��������');
$arSortFields = Array(
        'ID'=>'�� id',
        'NAME'=>'�� �����',
        'ACTIVE_FROM'=>'�� ����',
        'SORT'=>'�� ���� ����������',
        'TIMESTAMP_X'=>'�� ���� ��������'
    );

$arComponentParameters = array(
	'GROUPS' => array(
		"WEB_FORM"	=> array("NAME"	=> "��������� ���-�����"),
	),
    'PARAMETERS' => array(
		"VARIABLE_ALIASES" => Array(
			"list" => Array("NAME" => '������'),
			"section" => Array("NAME" => '������'),
			"detail" => Array("NAME" => '�������'),
		),
		"SEF_MODE" => Array(
			"list" => array(
				"NAME" => '������',
				"DEFAULT" => "index.php",
				"VARIABLES" => array(),
			),
			"section" => array(
				"NAME" => '������',
				"DEFAULT" => "",
				"VARIABLES" => array("SECTION_ID"),
			),
			"detail" => array(
				"NAME" => '�������',
				"DEFAULT" => "#ELEMENT_ID#",
				"VARIABLES" => array("ELEMENT_ID"),
			),
		),
        'IBLOCK_TYPE' => array(
            'PARENT' => 'BASE',
            'NAME' => '��� ���������',
            'TYPE' => 'LIST',
            'VALUES' => $arIBlockType,
            'REFRESH' => 'Y',
        ),
        'IBLOCK_ID' => array(
            'PARENT' => 'BASE',
            'NAME' => 'ID ���������',
            'TYPE' => 'LIST',
            'VALUES' => $arIBlock,
            'REFRESH' => 'Y',
        ),
        'ELEMENT_COUNT' => Array(
            'PARENT' => 'BASE',
            'NAME' => '���������� ���������',
            'TYPE' => 'STRING',
            'DEFAULT' => '',
        ),
        'SORT_BY1' => Array(
            'PARENT' => 'DATA_SOURCE',
            'NAME' => '����������',
            'TYPE' => 'LIST',
            'DEFAULT' => 'ACTIVE_FROM',
            'VALUES' => $arSortFields,
            'ADDITIONAL_VALUES' => 'Y',
        ),
        'SORT_ORDER1' => Array(
            'PARENT' => 'DATA_SOURCE',
            'NAME' => '�������',
            'TYPE' => 'LIST',
            'DEFAULT' => 'DESC',
            'VALUES' => $arSorts,
        ),
        'SORT_BY2' => Array(
            'PARENT' => 'DATA_SOURCE',
            'NAME' => '������ ����������',
            'TYPE' => 'LIST',
            'DEFAULT' => 'SORT',
            'VALUES' => $arSortFields,
            'ADDITIONAL_VALUES' => 'Y',
        ),
        'SORT_ORDER2' => Array(
            'PARENT' => 'DATA_SOURCE',
            'NAME' => '�������',
            'TYPE' => 'LIST',
            'DEFAULT' => 'ASC',
            'VALUES' => $arSorts,
        ),
       'DATE_FORMAT' => CIBlockParameters::GetDateFormat("������ ������ ����", "DETAIL_SETTINGS"),
       'FILTER_NAME' => Array(
    		"PARENT" => "FILTER_SETTINGS",
    		"NAME" => "����������, ���������� ��������� �������",
    		"TYPE" => "STRING",
    		"DEFAULT" => "",
    	),
		"DISPLAY_PANEL" => Array(
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME" => "���������� ������",
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		),
		"SET_TITLE" => Array(
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME" => "��������� ������������� ��������� ��������",
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		),
		"INCLUDE_IBLOCK_INTO_CHAIN" => Array(
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME" => "������� ������������� �������",
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		),
		"ADD_SECTIONS_CHAIN" => Array(
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME" => "��������� ������� � ������������� �������",
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		),
		"CACHE_TIME"  =>  Array("DEFAULT"=>3600),
		"FORM_ID" => Array(
			"PARENT" => "WEB_FORM",
			"NAME" => "ID web-�����",
			"TYPE" => "LIST",
            'VALUES' => $arForms,
            'REFRESH' => 'Y',
            'DEFAULT' => 'N',
		),
		"FORM_TITLE" => Array(
			"PARENT" => "WEB_FORM",
			"NAME" => "��������� web-�����",
			"TYPE" => "STRING",
            'DEFAULT' => '',
		),
    ),
);

?>