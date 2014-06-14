<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("alt_image", "—ервис BMW");
$APPLICATION->SetPageProperty("image", "/upload/service.jpg");
$APPLICATION->SetTitle("¬ладельцам BMW");
?> 
<!--<div id="headlines"> 
  <h1>—ервис BMW</h1>
 </div>
 
<div style="width: 375px;"> 
  <p>Ќаши специалисты сервисного центра готовы оказать ¬ам любую помощь в ремонте и обслуживании ¬ашего BMW.</p>
 
  <p>—ервисный центр состоит из цехов слесарных и кузовных работ, сконструирован по последним стандартам концерна BMW AG и предоставл€ет весь спектр сервисных услуг любой сложности. </p>
 
  <p>ƒипломированный персонал, работающий под посто€нным контролем представительства BMW в –оссии, регул€рно проходит стажировку и аттестацию в соответствии с графиком обучени€.</p>
 
  <p>ћногосменна€ система работы обеспечивает обслуживание ¬ашего автомобил€ в удобное дл€ ¬ас врем€ с высоким качеством, а строгий учет работ по каждому автомобилю позвол€ет контролировать ремонт на всех этапах и гарантирует ответственность каждого специалиста за проделанную работу.</p>
 </div>-->
<?$APPLICATION->IncludeComponent("adv:materials.list", "owners", array(
	"IBLOCK_TYPE" => "helpers",
	"IBLOCK_ID" => "210",
	"SECTION_ID" => "",
	"ELEMENT_COUNT" => "",
	"SORT_BY1" => "SORT",
	"SORT_ORDER1" => "ASC",
	"SORT_BY2" => "ID",
	"SORT_ORDER2" => "ASC",
	"SORT_SECTION_BY" => "SORT",
	"SORT_SECTION_ORDER" => "ASC",
	"CHECK_DATES" => "N",
	"DATE_CUSTOM" => "Y",
	"SELECT_PROPERTIES" => array(
		0 => "show_right",
		1 => "url",
		2 => "",
	),
	"FILTER_NAME" => "arrFilter",
	"NOT_SHOW_ERRORS" => "N",
	"CACHE_TYPE" => "N",
	"CACHE_TIME" => "3600",
	"NOPAGING" => "N",
	"DISPLAY_PANEL" => "N",
	"SET_TITLE" => "Y",
	"INCLUDE_SECTIONS_INTO_CHAIN" => "N",
	"DATE_FORMAT" => "d.m.Y"
	),
	false
);?> <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>