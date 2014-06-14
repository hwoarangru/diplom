<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

if(!isset($arParams['CACHE_TIME'])) {
	$arParams['CACHE_TIME'] = 3600;
}

if($arParams['CACHE_TYPE'] == 'N' || ($arParams['CACHE_TYPE'] == 'A' && COption::GetOptionString('main', 'component_cache_on', 'Y') == 'N')) {
	$arParams['CACHE_TIME'] = 0;
}

$arParams['IBLOCK_ID'] = intval($arParams['IBLOCK_ID']);
if($arParams['IBLOCK_ID'] <= 0) {
	return;
}
$arParams['PARENT_SECTION'] = intval($arParams['PARENT_SECTION']);

$arParams['YEAR'] = intval($arParams['YEAR']);
$arParams['YEAR'] = $arParams['YEAR'] < 2000 ? false : $arParams['YEAR'];
$arParams['YEAR'] = $arParams['YEAR'] > date('Y') ? false : $arParams['YEAR'];

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

$arNavigation = false;
$arCacheParams = $arParams;
unset($arCacheParams['YEAR'], $arCacheParams['~YEAR']);
$CACHE_ID = md5(serialize(array(($arParams['CACHE_GROUPS']==='N'? false: $GLOBALS['USER']->GetGroups()), $bUSER_HAVE_ACCESS, $arNavigation, $arrFilter, $arCacheParams)));
$obMenuCache = new CPHPCache;
if($obMenuCache->StartDataCache($arParams['CACHE_TIME'], $CACHE_ID)) {
	$obMenuCache->AbortDataCache();
	if(!CModule::IncludeModule('iblock')) {
		$obMenuCache->AbortDataCache();
		return;
	}

	$arParams['DETAIL_URL'] = trim($arParams['DETAIL_URL']);

	$arParams['PARENT_SECTION'] = CIBlockFindTools::GetSectionID(
		$arParams['PARENT_SECTION'],
		$arParams['PARENT_SECTION_CODE'],
		array(
			'GLOBAL_ACTIVE' => 'Y',
			'IBLOCK_ID' => $arParams['IBLOCK_ID'],
		)
	);

	//
	// !!! Запрос собираем вручную !!!
	// 
	$sQuery = '';
	$sQuery .= '
		SELECT DISTINCT
			DATE_FORMAT(BE.ACTIVE_FROM, \'%Y\') as YEAR
			FROM
			b_iblock B
			INNER JOIN b_lang L ON B.LID=L.LID
			INNER JOIN b_iblock_element BE ON BE.IBLOCK_ID = B.ID
	';
	if(intval($arParams['PARENT_SECTION'])) {
		$sQuery .= '
			INNER JOIN ( 
				SELECT DISTINCT BSE.IBLOCK_ELEMENT_ID
				FROM
				b_iblock_section_element BSE
				INNER JOIN b_iblock_section BSubS ON BSE.IBLOCK_SECTION_ID = BSubS.ID
				INNER JOIN b_iblock_section BS ON (
					BSubS.IBLOCK_ID = BS.IBLOCK_ID 
					AND 
					BSubS.LEFT_MARGIN >= BS.LEFT_MARGIN 
					AND 
					BSubS.RIGHT_MARGIN <= BS.RIGHT_MARGIN
				)
				WHERE
				BS.ID IN ('.intval($arParams['PARENT_SECTION']).')
			) BES ON BES.IBLOCK_ELEMENT_ID = BE.ID
		';
	}
	$sQuery .= '
		WHERE ( 
			BE.IBLOCK_ID = \''.$arParams['IBLOCK_ID'].'\'
			AND 
			BE.ACTIVE = \'Y\' 
			AND (
				(
					BE.ACTIVE_TO >= now() OR BE.ACTIVE_TO IS NULL
				) AND (
					BE.ACTIVE_FROM <= now() OR BE.ACTIVE_FROM IS NULL
				)
			)
		) AND (
			BE.WF_STATUS_ID = 1 AND BE.WF_PARENT_ELEMENT_ID IS NULL
		)
		ORDER BY YEAR desc
	';
	$rsItems = $GLOBALS['DB']->Query($sQuery, false, 'FILE: '.__FILE__.'<br /> LINE: '.__LINE__);
	$rsItems = new CIBlockResult($rsItems);
	$arResult['ITEMS'] = array();
	while($arItem = $rsItems->Fetch()) {
		$arItem['DETAIL_PAGE_URL'] = str_replace(
			array('#YEAR#'),
			array($arItem['YEAR']),
			$arParams['DETAIL_URL']
		);
		$arResult['ITEMS'][] = $arItem;
	}

	$arResult['NAV_CACHED_DATA'] = false;
	if(!empty($arResult['ITEMS'])) {
	        $obMenuCache->EndDataCache($arResult);
	} else {
		$arResult['ERROR_404'] = 'Y';
		$obMenuCache->AbortDataCache();
		@define('ERROR_404', 'Y');
		if($arParams['SET_STATUS_404'] === 'Y') {
			CHTTP::SetStatus('404 Not Found');
		}
	}
} else {
        $arResult = $obMenuCache->GetVars();
}
$this->IncludeComponentTemplate();


if(!empty($arResult)) {
	if($GLOBALS['USER']->IsAuthorized()) {
		if($arParams['DISPLAY_PANEL'] || $APPLICATION->GetShowIncludeAreas()) {
			if(CModule::IncludeModule('iblock')) {
				$arButtons = CIBlock::GetPanelButtons($arParams['IBLOCK_ID'], 0, $arParams['PARENT_SECTION']);

				if($arParams['DISPLAY_PANEL']) {
					CIBlock::AddPanelButtons($APPLICATION->GetPublicShowMode(), $this->GetName(), $arButtons);
				}
				
				if($APPLICATION->GetShowIncludeAreas()) {
					$this->AddIncludeAreaIcons(CIBlock::GetComponentMenu($APPLICATION->GetPublicShowMode(), $arButtons));
				}
			}
		}
	}

	$this->SetTemplateCachedData($arResult['NAV_CACHED_DATA']);
}
