<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule('iblock')){
    return;
}
$arIBlockType = array();
$rsIBlockType = CIBlockType::GetList(array('sort'=>'asc'), array('ACTIVE'=>'Y'));
while ($arr=$rsIBlockType->Fetch()) {
    if($ar=CIBlockType::GetByIDLang($arr['ID'], LANGUAGE_ID)) {
        $arIBlockType[$arr['ID']] = '['.$arr['ID'].'] '.$ar['NAME'];
    }
}

$arIBlock=array();
$rsIBlock = CIBlock::GetList(Array('sort' => 'asc'), Array('TYPE' => $arCurrentValues['IBLOCK_TYPE'], 'ACTIVE'=>'Y'));
while($arr=$rsIBlock->Fetch()) {
    $arIBlock[$arr['ID']] = '['.$arr['ID'].'] '.$arr['NAME'];
}



$arSorts = Array('ASC'=>'�� �����������', 'DESC'=>'�� ��������');
$arSortFields = Array(
        'ID'=>'�� id',
        'NAME'=>'�� �����',
        'ACTIVE_FROM'=>'�� ����',
        'SORT'=>'�� ���� ����������',
        'TIMESTAMP_X'=>'�� ���� ��������'
    );

$arProperty_LNS = array();
$rsProp = CIBlockProperty::GetList(Array('sort'=>'asc', 'name'=>'asc'), Array('ACTIVE'=>'Y', 'IBLOCK_ID'=>$arCurrentValues['IBLOCK_ID']));
while ($arr=$rsProp->Fetch())
{
    $arProperty[$arr['CODE']] = '['.$arr['CODE'].'] '.$arr['NAME'];
    if (in_array($arr['PROPERTY_TYPE'], array('L', 'N', 'S', 'E')))
    {
        $arProperty_LNS[$arr['CODE']] = '['.$arr['CODE'].'] '.$arr['NAME'];
    }
}

$arAscDesc = array(
    'asc' => GetMessage('BN_P_SORT_ASC'),
    'desc' => GetMessage('BN_P_SORT_DESC'),
);

$arUGroupsEx = Array();
$dbUGroups = CGroup::GetList($by = 'c_sort', $order = 'asc');
while($arUGroups = $dbUGroups -> Fetch())
{
    $arUGroupsEx[$arUGroups['ID']] = $arUGroups['NAME'];
}

$arComponentParameters = array(
    'PARAMETERS' => array(
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
            'REFRESH' => 'N',
        ),
        'SECTION_ID' => Array(
            'PARENT' => 'BASE',
            'NAME' => 'ID �������',
            'TYPE' => 'STRING',
            'DEFAULT' => '',
        ),
        'ELEMENT_COUNT' => Array(
            'PARENT' => 'BASE',
            'NAME' => '���������� ���������',
            'TYPE' => 'STRING',
            'DEFAULT' => '',
        ),
        'NOPAGING' => Array(
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME" => "�� ���������� ������������ ���������",
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
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
        'SORT_SECTION_BY' => Array(
            'PARENT' => 'DATA_SOURCE',
            'NAME' => '���������� ��������',
            'TYPE' => 'LIST',
            'DEFAULT' => 'SORT',
            'VALUES' => $arSortFields,
            'ADDITIONAL_VALUES' => 'Y',
        ),
        'SORT_SECTION_ORDER' => Array(
            'PARENT' => 'DATA_SOURCE',
            'NAME' => '�������',
            'TYPE' => 'LIST',
            'DEFAULT' => 'ASC',
            'VALUES' => $arSorts,
        ),
        "CHECK_DATES" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => "��������� ������ ����������",
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		),
		"DATE_FORMAT" => CIBlockParameters::GetDateFormat("������ ������ ����", "DETAIL_SETTINGS"),
		"DATE_CUSTOM" => Array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => "���������������� ������ ������ ���������� ���",
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),
		"SELECT_PROPERTIES" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => "�������� ���������",
			"TYPE" => "LIST",
			"MULTIPLE" => "Y",
			"VALUES" => $arProperty_LNS,
			"ADDITIONAL_VALUES" => "Y",
		),
        "FILTER_NAME" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => "����������, ���������� ��������� �������",
			"TYPE" => "STRING",
			"DEFAULT" => "arrFilter",
		),
		"NOT_SHOW_ERRORS" => Array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => "�� ���������� ������",
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
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
		"INCLUDE_SECTIONS_INTO_CHAIN" => Array(
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME" => "��������� ������� � ������������� �������",
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		),
		"CACHE_TIME"  =>  Array("DEFAULT"=>3600),
    ),
);

?>