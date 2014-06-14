<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

if(!isset($arParams['CACHE_TIME'])) {
	$arParams['CACHE_TIME'] = 3600;
}

$arParams['IBLOCK_ID'] = intval($arParams['IBLOCK_ID']);
if($arParams['IBLOCK_ID'] <= 0) {
	return;
}
$arParams['PARENT_SECTION'] = intval($arParams['PARENT_SECTION']);
$arParams['INCLUDE_SUBSECTIONS'] = $arParams['INCLUDE_SUBSECTIONS']!='N';

$arParams['ELEMENT_ID'] = intval($arParams['ELEMENT_ID']);

$arParams['SORT_BY1'] = trim($arParams['SORT_BY1']);
if(strlen($arParams['SORT_BY1']) <= 0) {
	$arParams['SORT_BY1'] = 'ACTIVE_FROM';
}
if($arParams['SORT_ORDER1']!='ASC') {
	 $arParams['SORT_ORDER1']='DESC';
}
if(strlen($arParams['SORT_BY2'])<=0) {
	$arParams['SORT_BY2'] = 'SORT';
}
if($arParams['SORT_ORDER2']!='DESC') {
	 $arParams['SORT_ORDER2']='ASC';
}

if(strlen($arParams['FILTER_NAME'])<=0 || !ereg('^[A-Za-z_][A-Za-z01-9_]*$', $arParams['FILTER_NAME'])) {
	$arrFilter = array();
} else {
	$arrFilter = $GLOBALS[$arParams['FILTER_NAME']];
	if(!is_array($arrFilter)) {
		$arrFilter = array();
	}
}

$arParams['CHECK_DATES'] = $arParams['CHECK_DATES'] != 'N';
$arParams['CACHE_FILTER'] = $arParams['CACHE_FILTER'] == 'Y';
if(!$arParams['CACHE_FILTER'] && !empty($arrFilter)) {
	$arParams['CACHE_TIME'] = 0;
}

$arParams['SET_TITLE'] = $arParams['SET_TITLE'] != 'N';
$arParams['DISPLAY_PANEL'] = $arParams['DISPLAY_PANEL'] == 'Y';

$arParams['USE_PERMISSIONS'] = $arParams['USE_PERMISSIONS']=='Y';
if(!is_array($arParams['GROUP_PERMISSIONS'])) {
	$arParams['GROUP_PERMISSIONS'] = array(1);
}

$bUSER_HAVE_ACCESS = !$arParams['USE_PERMISSIONS'];
if($arParams['USE_PERMISSIONS'] && isset($GLOBALS['USER']) && is_object($GLOBALS['USER'])) {
	$arUserGroupArray = $GLOBALS['USER']->GetUserGroupArray();
	foreach($arParams['GROUP_PERMISSIONS'] as $PERM) {
		if(in_array($PERM, $arUserGroupArray)) {
			$bUSER_HAVE_ACCESS = true;
			break;
		}
	}
}
$arNavigation = array();
if($this->StartResultCache(false, array(($arParams['CACHE_GROUPS']==='N'? false: $GLOBALS['USER']->GetGroups()), $bUSER_HAVE_ACCESS, $arNavigation, $arrFilter))) {
	if(!CModule::IncludeModule('iblock')) {
		$this->AbortResultCache();
		return;
	}

	if(!is_array($arParams['FIELD_CODE'])) {
		$arParams['FIELD_CODE'] = array();
	}
	foreach($arParams['FIELD_CODE'] as $key=>$val) {
		if(!$val) {
			unset($arParams['FIELD_CODE'][$key]);
		}
	}
	if(!is_array($arParams['PROPERTY_CODE'])) {
		$arParams['PROPERTY_CODE'] = array();
	}
	foreach($arParams['PROPERTY_CODE'] as $key=>$val) {
		if($val==='') {
			unset($arParams['PROPERTY_CODE'][$key]);
		}
	}

	$arParams['DETAIL_URL'] = trim($arParams['DETAIL_URL']);

	$arParams['ACTIVE_DATE_FORMAT'] = trim($arParams['ACTIVE_DATE_FORMAT']);
	if(strlen($arParams['ACTIVE_DATE_FORMAT']) <= 0) {
		$arParams['ACTIVE_DATE_FORMAT'] = $GLOBALS['DB']->DateFormatToPHP(CSite::GetDateFormat('SHORT'));
	}

	$arResult['USER_HAVE_ACCESS'] = $bUSER_HAVE_ACCESS;
	$arSelect = array_merge(
		$arParams['FIELD_CODE'], 
		array(
			'ID',
			'IBLOCK_ID',
			'IBLOCK_SECTION_ID',
			'NAME',
			'ACTIVE_FROM',
			'DETAIL_PAGE_URL',
			'DETAIL_TEXT',
			'DETAIL_TEXT_TYPE',
			'PREVIEW_TEXT',
			'PREVIEW_TEXT_TYPE',
			'PREVIEW_PICTURE',
		)
	);
	$bGetProperty = count($arParams['PROPERTY_CODE'])>0;
	if($bGetProperty) {
		$arSelect[] = 'PROPERTY_*';
	}

	$arFilter = array(
		'IBLOCK_ID' => $arParams['IBLOCK_ID'],
		'ACTIVE' => 'Y',
		'CHECK_PERMISSIONS' => 'Y',
	);
	
	if($arParams['ELEMENT_ID'] > 0) {
		$arFilter['ID'] = $arParams['ELEMENT_ID'];
	}

	if($arParams['CHECK_DATES']) {
		$arFilter['ACTIVE_DATE'] = 'Y';
	}

	$arParams['PARENT_SECTION'] = CIBlockFindTools::GetSectionID(
		$arParams['PARENT_SECTION'],
		$arParams['PARENT_SECTION_CODE'],
		array(
			'GLOBAL_ACTIVE' => 'Y',
			'IBLOCK_ID' => $arParams['IBLOCK_ID'],
		)
	);

	if($arParams['PARENT_SECTION'] > 0) {
		$arFilter['SECTION_ID'] = $arParams['PARENT_SECTION'];
		if($arParams['INCLUDE_SUBSECTIONS']) {
			$arFilter['INCLUDE_SUBSECTIONS'] = 'Y';
		}
	}

	$arSort = array(
		$arParams['SORT_BY1'] => $arParams['SORT_ORDER1'],
		$arParams['SORT_BY2'] => $arParams['SORT_ORDER2'],
	);

	if(!array_key_exists('ID', $arSort)) {
		$arSort['ID'] = 'DESC';
	}
	$arNavParams = array('nTopCount' => 1);
	$arResult['ITEMS'] = array();
	$rsElement = CIBlockElement::GetList($arSort, array_merge($arFilter, $arrFilter), false, $arNavParams, $arSelect);
	$rsElement->SetUrlTemplates($arParams['DETAIL_URL']);
	$arResult['ITEMS'] = array();
	if($obElement = $rsElement->GetNextElement()) {
		$arItem = $obElement->GetFields();
		if(strlen($arItem['ACTIVE_FROM'])) {
			$arItem['DISPLAY_ACTIVE_FROM'] = CIBlockFormatProperties::DateFormat($arParams['ACTIVE_DATE_FORMAT'], MakeTimeStamp($arItem['ACTIVE_FROM'], CSite::GetDateFormat()));
		} else {
			$arItem['DISPLAY_ACTIVE_FROM'] = '';
		}

		if(array_key_exists('PREVIEW_PICTURE', $arItem)) {
			$arItem['PREVIEW_PICTURE'] = CFile::GetFileArray($arItem['PREVIEW_PICTURE']);
		}
		
		if(array_key_exists('DETAIL_PICTURE', $arItem)) {
			$arItem['DETAIL_PICTURE'] = CFile::GetFileArray($arItem['DETAIL_PICTURE']);
		}
		
		$arItem['FIELDS'] = array();
		foreach($arParams['FIELD_CODE'] as $code) {
			if(array_key_exists($code, $arItem)) {
				$arItem['FIELDS'][$code] = $arItem[$code];
			}
		}
		
		if($bGetProperty) {
			$arItem['PROPERTIES'] = $obElement->GetProperties();
		}
		
		$arItem['DISPLAY_PROPERTIES'] = array();
		foreach($arParams['PROPERTY_CODE'] as $pid) {
			$prop = &$arItem['PROPERTIES'][$pid];
			if((is_array($prop['VALUE']) && count($prop['VALUE']) > 0) || (!is_array($prop['VALUE']) && strlen($prop['VALUE']) > 0)) {
				$arItem['DISPLAY_PROPERTIES'][$pid] = CIBlockFormatProperties::GetDisplayValue($arItem, $prop, 'news_out');
			}
		}

		$arResult['ITEMS'][] = $arItem;
	}

	$arResult['NAV_CACHED_DATA'] = false;
	if(!empty($arResult['ITEMS'])) {
		$this->SetResultCacheKeys(
			array(
				'ID',
				'IBLOCK_TYPE_ID',
				'NAV_CACHED_DATA',
				'NAME',
				'SECTION',
			)
		);
	} else {
		$arResult['ERROR_404'] = 'Y';
		$this->AbortResultCache();
		@define('ERROR_404', 'Y');
		if($arParams['SET_STATUS_404'] === 'Y') {
			CHTTP::SetStatus('404 Not Found');
		}
	}
	$this->IncludeComponentTemplate();
}

if(!empty($arResult)) {
	$arTitleOptions = null;
	if($GLOBALS['USER']->IsAuthorized()) {
		if($arParams['DISPLAY_PANEL'] || $APPLICATION->GetShowIncludeAreas() || $arParams['SET_TITLE']) {
			if(CModule::IncludeModule('iblock')) {
				$arButtons = CIBlock::GetPanelButtons($arParams['IBLOCK_ID'], 0, $arParams['PARENT_SECTION']);

				if($arParams['DISPLAY_PANEL']) {
					CIBlock::AddPanelButtons($APPLICATION->GetPublicShowMode(), $this->GetName(), $arButtons);
				}
				
				if($APPLICATION->GetShowIncludeAreas()) {
					$this->AddIncludeAreaIcons(CIBlock::GetComponentMenu($APPLICATION->GetPublicShowMode(), $arButtons));
				}
				
				if($arParams['SET_TITLE']) {
					$arTitleOptions = array(
						'ADMIN_EDIT_LINK' => $arButtons['submenu']['edit_iblock']['ACTION'],
						'PUBLIC_EDIT_LINK' => '',
						'COMPONENT_NAME' => $this->GetName(),
					);
				}
			}
		}
	}

	$this->SetTemplateCachedData($arResult['NAV_CACHED_DATA']);

	if($arParams['SET_TITLE']) {
		$APPLICATION->SetTitle($arResult['NAME'], $arTitleOptions);
	}
}
