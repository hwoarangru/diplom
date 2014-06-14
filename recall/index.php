<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("image", "/images/mteaser.jpg");
$APPLICATION->SetTitle("Заказать звонок");
?>
<div style="width: 500px; float: left">
<?$APPLICATION->IncludeComponent("bitrix:form", "event_price", array(
	"START_PAGE" => "new",
	"SHOW_LIST_PAGE" => "N",
	"SHOW_EDIT_PAGE" => "N",
	"SHOW_VIEW_PAGE" => "N",
	"SUCCESS_URL" => "",
	"WEB_FORM_ID" => "28",
	"RESULT_ID" => "",
	"SHOW_ANSWER_VALUE" => "N",
	"SHOW_ADDITIONAL" => "N",
	"SHOW_STATUS" => "N",
	"EDIT_ADDITIONAL" => "N",
	"EDIT_STATUS" => "N",
	"NOT_SHOW_FILTER" => array(
		0 => "",
		1 => "",
	),
	"NOT_SHOW_TABLE" => array(
		0 => "",
		1 => "",
	),
	"IGNORE_CUSTOM_TEMPLATE" => "N",
	"USE_EXTENDED_ERRORS" => "N",
	"SEF_MODE" => "N",
	"SEF_FOLDER" => "/auto_price/",
	"AJAX_MODE" => "N",
	"AJAX_OPTION_JUMP" => "N",
	"AJAX_OPTION_STYLE" => "Y",
	"AJAX_OPTION_HISTORY" => "N",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "3600",
	"CHAIN_ITEM_TEXT" => "",
	"CHAIN_ITEM_LINK" => "",
	"AJAX_OPTION_ADDITIONAL" => "",
	"VARIABLE_ALIASES" => array(
		"action" => "action",
	)
	),
	false
);?>
</div>
<div style="width: 180px; margin-left:500px;">
	<div style="padding:20px 15px; border-left: 1px solid #CCC;"><b>Адрес</b><br /><br />
	Россия, Московская область, город Котельники<br />
	Коммерческий проезд, д. 10<br />
	<a href="/contacts/#item-1">схема проезда</a><br />
	<br />
	Россия, город Москва<br />
	Проспект 60-летия Октября, д. 6<br />
	<a href="/contacts/#item-2">схема проезда</a><br />
	<br />
	<b>Телефон</b><br />
	+7 (495) 787-80-08<br />
	<br />
	<b>Время работы</b><br />
	ежедн. 10:00-22:00<br />
	</div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>