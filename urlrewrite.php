<?
$arUrlRewrite = array(
	array(
		"CONDITION"	=>	"#^/cars/([^\\d]{1}[0-9a-zA-Z_-]+)/(\\D[0-9a-zA-Z_-]+)/(\\D[0-9a-zA-Z_-]+)/(\\D[0-9a-zA-Z_-]+)/(.*)#",
		"RULE"	=>	"SECTION_ID=$1&ELEMENT_ID=$2&cat=$3&fact=$4&URIG=Y&OLD=Y",
		"PATH"	=>	"/cars/model_detail.php",
		"ID"	=>	"",
	),
	array(
		"CONDITION"	=>	"#^/cars/([^\\d]{1}[0-9a-zA-Z_-]+)/(\\D[0-9a-zA-Z_-]+)/(\\D[0-9a-zA-Z_-]+)/(.*)#",
		"RULE"	=>	"SECTION_ID=$1&ELEMENT_ID=$2&cat=$3&URIG=Y&OLD=Y",
		"PATH"	=>	"/cars/model_detail.php",
		"ID"	=>	"",
	),
	array(
		"CONDITION"	=>	"#^/cars/([^\\d]{1}[0-9a-zA-Z_-]+)/(\\D[0-9a-zA-Z_-]+)/([0-9a-zA-Z_-]+)/(.*)#",
		"RULE"	=>	"SECTION_ID=$1&ELEMENT_ID=$2&fact=$3&URIG=Y&OLD=Y",
		"PATH"	=>	"/cars/model_detail.php",
		"ID"	=>	"",
	),
	array(
		"CONDITION"	=>	"#^/owners/special_offer/(?!.*_wheels).+([0-9a-zA-Z_-]+)/([0-9]+)/(\\?.+)?#",
		"RULE"	=>	"ID=$2",
		"PATH"	=>	"/owners/special_offer/detail.php",
	),
	array(
		"CONDITION"	=>	"#^/owners/special_offer/summer_wheels/([0-9]+)/(\\?.*)?$#",
		"RULE"	=>	"ID=$1",
		"ID"	=>	"adv:materials",
		"PATH"	=>	"/owners/special_offer/summer_wheels/index.php",
	),
	array(
		"CONDITION"	=>	"#^/cars/([^\\d]{1}[0-9a-z_]+)/(\\D[0-9A-Za-z_-]+)/(.*)#",
		"RULE"	=>	"SECTION_ID=$1&ELEMENT_ID=$2&OLD=Y",
		"PATH"	=>	"/cars/model_detail.php",
		"ID"	=>	"",
	),
	array(
		"CONDITION"	=>	"#^/owners/special_offer/auto/([0-9]+)/(\\?.+)?#",
		"RULE"	=>	"ID=$1",
		"PATH"	=>	"/owners/special_offer/auto/detail.php",
	),
	array(
		"CONDITION"	=>	"#^/cars/([^\\d]{1}[0-9a-zA-Z_-]+)/(\\?.+)?#",
		"RULE"	=>	"SECTION_ID=$1",
		"PATH"	=>	"/cars/seria_models.php",
		"ID"	=>	"",
	),
	array(
		"CONDITION"	=>	"#^/products/([0-9]+)/([0-9]+)/([a-z_]+)#",
		"RULE"	=>	"SECTION_ID=$1&USECTION_ID=$2&CAT_CODE=$3",
		"PATH"	=>	"/products/elements.php",
	),
	array(
		"CONDITION"	=>	"#^/owners/service/maintenance_services/#",
		"RULE"	=>	"",
		"ID"	=>	"bitrix:catalog",
		"PATH"	=>	"/owners/service/maintenance_services/index.php",
	),
	array(
		"CONDITION"	=>	"#^/owners/special_offer/winter_wheels/#",
		"RULE"	=>	"",
		"ID"	=>	"adv:materials",
		"PATH"	=>	"/owners/special_offer/winter_wheels/index.php",
	),
	array(
		"CONDITION"	=>	"#^/news/special/([0-9A-z-_]*)/(\\?.+)?#",
		"RULE"	=>	"SECTION_CODE=$1",
		"ID"	=>	"",
		"PATH"	=>	"/news/special/index.php",
	),
	array(
		"CONDITION"	=>	"#^/owners/accessories/winter_wheels/#",
		"RULE"	=>	"",
		"ID"	=>	"adv:materials",
		"PATH"	=>	"/owners/accessories/winter_wheels/index.php",
	),
	array(
		"CONDITION"	=>	"#^/owners/service/winter_wheels/#",
		"RULE"	=>	"",
		"ID"	=>	"adv:materials",
		"PATH"	=>	"/owners/service/winter_wheels/index.php",
	),
	array(
		"CONDITION"	=>	"#^/communication/blog/weblogs/#",
		"RULE"	=>	"",
		"ID"	=>	"bitrix:blog",
		"PATH"	=>	"/communication/blog/blog_sef.php",
	),
	array(
		"CONDITION"	=>	"#^/communication/forum/talk/#",
		"RULE"	=>	"",
		"ID"	=>	"bitrix:forum",
		"PATH"	=>	"/communication/forum/forum_sef.php",
	),
	array(
		"CONDITION"	=>	"#^/products/([0-9]+)/([0-9])#",
		"RULE"	=>	"SECTION_ID=$1&USECTION_ID=$2",
		"PATH"	=>	"/products/index.php",
	),
	array(
		"CONDITION"	=>	"#^/products/([0-9A-z-_]*)#",
		"RULE"	=>	"ID=$1",
		"PATH"	=>	"/products/product.php",
	),
	array(
		"CONDITION"	=>	"#^/archive/([0-9A-z-_]*)#",
		"RULE"	=>	"ID=$1",
		"PATH"	=>	"/archive/product.php",
	),
	array(
		"CONDITION"	=>	"#^/owners/winter_wheels/#",
		"RULE"	=>	"",
		"ID"	=>	"adv:materials",
		"PATH"	=>	"/service/winter_wheels/index.php",
	),
	array(
		"CONDITION"	=>	"#^/corporate/security/#",
		"RULE"	=>	"",
		"ID"	=>	"bitrix:catalog",
		"PATH"	=>	"/corporate/security/index.php",
	),
	array(
		"CONDITION"	=>	"#^/autocraft/command/#",
		"RULE"	=>	"",
		"ID"	=>	"bitrix:catalog",
		"PATH"	=>	"/autocraft/command/index.php",
	),
	array(
		"CONDITION"	=>	"#^/contacts/feedback/#",
		"RULE"	=>	"",
		"ID"	=>	"bitrix:form.result.new",
		"PATH"	=>	"/contacts/feedback/index.php",
	),
	array(
		"CONDITION"	=>	"#^/products/([0-9])#",
		"RULE"	=>	"SECTION_ID=$1",
		"PATH"	=>	"/products/index.php",
	),
	array(
		"CONDITION"	=>	"#^/contacts/team/#",
		"RULE"	=>	"",
		"ID"	=>	"bitrix:catalog",
		"PATH"	=>	"/contacts/team/index.php",
	),
	array(
		"CONDITION"	=>	"#^/events/#",
		"RULE"	=>	"",
		"ID"	=>	"bitrix:news",
		"PATH"	=>	"/events/index.php",
	),
	array(
		"CONDITION"	=>	"#^/model/#",
		"RULE"	=>	"",
		"PATH"	=>	"/model/index.php",
	),
	array(
		"CONDITION"	=>	"#^/press/#",
		"RULE"	=>	"",
		"ID"	=>	"bitrix:news",
		"PATH"	=>	"/press/index.php",
	),
	array(
		"CONDITION"	=>	"#^/news/#",
		"RULE"	=>	"",
		"ID"	=>	"bitrix:news",
		"PATH"	=>	"/news/index.php",
	),
);

?>