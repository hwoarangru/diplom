<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();
CModule::IncludeModule("adv_phone_controller");
$apc = new advPhoneController();
$newPhone = $apc->GetPhone();
if(!empty($arResult['ITEMS'])) {
	?><div class="news-item-block"><?
		?><a class="print-icon" href="javascript:PrintThisPage();">печать</a><?
		foreach($arResult['ITEMS'] as $arItem) {
			?><div class="news-item"><?
				?><h1><?
					echo $arItem['NAME'];
				?></h1><?
				?><div class="description"><?
					if(!empty($arItem['DETAIL_TEXT'])) {
						echo str_replace('#PHONE#','',$arItem['DETAIL_TEXT'])
					} else {
						echo $arItem['PREVIEW_TEXT'];
					}
				?></div><?
			?></div><?
		}
	?></div><?
	?><script type="text/javascript"><!-- 
		var PrintThisPage = function() {
			window.print();
		};
	//--></script><?
} else {
	// 404
}
?>