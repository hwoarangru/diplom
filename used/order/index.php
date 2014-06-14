<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Автомобили BMW с пробегом");?>
<?$APPLICATION->IncludeComponent(
	"bitrix:form.result.new",
	"used_order",
	Array(
		"SEF_MODE" => "N",
		"WEB_FORM_ID" => "16",
		"LIST_URL" => "",
		"EDIT_URL" => "",
		"SUCCESS_URL" => "",
		"CHAIN_ITEM_TEXT" => "",
		"CHAIN_ITEM_LINK" => "",
		"IGNORE_CUSTOM_TEMPLATE" => "N",
		"USE_EXTENDED_ERRORS" => "N",
		"CACHE_TYPE" => "N",
		"CACHE_TIME" => "0",
		"VARIABLE_ALIASES" => Array(
			"WEB_FORM_ID" => "WEB_FORM_ID",
			"RESULT_ID" => "RESULT_ID"
		)
	)
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>