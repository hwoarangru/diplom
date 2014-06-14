<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Поиск");?>

<?$APPLICATION->IncludeComponent("bitrix:search.page", "search_temp", Array(
	"RESTART"	=>	"N",
	"CHECK_DATES"	=>	"N",
	"USE_TITLE_RANK"	=>	"N",
	"arrWHERE"	=>	array(
		0	=>	"iblock_news",
		1	=>	"iblock_models",
	),
	"arrFILTER"	=>	array(
		0	=>	"main",
		1	=>	"iblock_news",
		2	=>	"iblock_models",
	),
	"arrFILTER_main"	=>	array(
		0	=>	"",
	),
	"arrFILTER_iblock_news"	=>	array(
		0	=>	"all",
	),
	"arrFILTER_iblock_models"	=>	array(
		0	=>	"all",
	),
	"SHOW_WHERE"	=>	"N",
	"PAGE_RESULT_COUNT"	=>	"10",
	"AJAX_MODE"	=>	"N",
	"AJAX_OPTION_SHADOW"	=>	"Y",
	"AJAX_OPTION_JUMP"	=>	"N",
	"AJAX_OPTION_STYLE"	=>	"Y",
	"AJAX_OPTION_HISTORY"	=>	"N",
	"CACHE_TYPE"	=>	"A",
	"CACHE_TIME"	=>	"3600",
	"PAGER_TITLE"	=>	"Результаты поиска",
	"PAGER_SHOW_ALWAYS"	=>	"Y",
	"PAGER_TEMPLATE"	=>	"",
	"TAGS_SORT"	=>	"NAME",
	"TAGS_PAGE_ELEMENTS"	=>	"150",
	"TAGS_PERIOD"	=>	"",
	"TAGS_URL_SEARCH"	=>	"",
	"TAGS_INHERIT"	=>	"Y",
	"FONT_MAX"	=>	"50",
	"FONT_MIN"	=>	"10",
	"COLOR_NEW"	=>	"000000",
	"COLOR_OLD"	=>	"C8C8C8",
	"PERIOD_NEW_TAGS"	=>	"",
	"SHOW_CHAIN"	=>	"Y",
	"COLOR_TYPE"	=>	"Y",
	"WIDTH"	=>	"100%"
	)
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>