<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

if($_GET["model"]["new"])
{

$_DirTitle = "Модельный ряд BMW, каталог автомобилей BMW - официальный дилер Независимость BMW";

$APPLICATION->SetPageProperty("pagetitle", $_DirTitle);

$APPLICATION->IncludeComponent("adv:model", "", array(
	  "SEF_MODE" => "Y"
	, "SEF_FOLDER" => "cars"
));

}
else
{
	$APPLICATION->SetTitle("Детали модели серии");

	if (!CModule::IncludeModule("iblock"))
	{
		return false;
	}

	$arFilter = Array('IBLOCK_ID'=>192 , 'GLOBAL_ACTIVE'=>'Y');
	$db_list = CIBlockSection::GetList(Array("sort"=>"asc"), $arFilter, true, Array("ID","UF_TITLE"));
	 
	while( $ar_result = $db_list->GetNext()) 
	{
		$stitle[$ar_result["ID"]] = $ar_result["UF_TITLE"];
	}

	if($stitle[$_GET["SECTION_ID"]] != '')
		$APPLICATION->SetPageProperty("pagetitle", $stitle[$_GET["SECTION_ID"]]);   

	$_SESSION['PageTitle'] = '';
	$_SESSION['DirTitle'] = '';

	$_DirTitle = "Модельный ряд BMW, каталог автомобилей BMW - официальный дилер Независимость BMW";
	if (!is_numeric($_REQUEST["ELEMENT_ID"])) {
		$elem = CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>192, "CODE"=>$_REQUEST["ELEMENT_ID"]), Array("ID", "NAME", "PROPERTY_ALLFACTS"));
		if ($elem = $elem->GetNext()) {
			$_REQUEST["ELEMENT_ID"]=$elem["ID"];
		}
	$APPLICATION->SetPageProperty('seriatitle', $elem['NAME']);
			$_DirTitle = $elem['NAME']." - ".$_DirTitle;
		$prop_allfacts = $elem['PROPERTY_ALLFACTS_VALUE'];
	}
	$APPLICATION->SetPageProperty("pagetitle", $_DirTitle);

	if(!empty($_REQUEST["fact"]) && !is_numeric($_REQUEST["fact"])){
		$arFilter = array(
			"IBLOCK_CODE" => "features" , 
			"CODE" => $_REQUEST["fact"],
			"SECTION_ID" => $prop_allfacts,
			"INCLUDE_SUBSECTIONS" => "Y"
		);
		//if(!empty($elem)){
			$resFact = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, Array("ID", "IBLOCK_SECTION_ID", "PROPERTY_ALLFACTS"));
			$_el = $resFact->GetNext();
			if(empty($_el)){
			
			$elSID = CIBlockSection::GetByID((int)$prop_allfacts)->GetNext();
					
			$arFilter = array(
				"IBLOCK_CODE" => "features" , 
				"CODE" => $_REQUEST["fact"],
				">LEFT_MARGIN" => $elSID['LEFT_MARGIN'],
				"<RIGHT_MARGIN" => $elSID['RIGHT_MARGIN']
			);
			
				$resFact = CIBlockSection::GetList(Array("SORT"=>"ASC"), $arFilter, Array("ID", "IBLOCK_SECTION_ID"));
				$_el = $resFact->GetNext();
			}
	// && !isset($prop_allfacts) && (int)$prop_allfacts == 0		
			
			$_GET["fact"] = $_el['ID'];
			$_GET["cat"] = $_el['IBLOCK_SECTION_ID'];
			$_REQUEST["fact"] = $_el['ID'];
			$_REQUEST["cat"] = $_el['IBLOCK_SECTION_ID'];
			
		//}
	}

	if (!is_numeric($_REQUEST["SECTION_ID"])) {
		$elem = CIBlockSection::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>192, "CODE"=>$_REQUEST["SECTION_ID"]), Array("ID"));
		if ($elem = $elem->GetNext()) {
			$_REQUEST["SECTION_ID"]=$elem["ID"];
		}
	}

	if(!$elem["ID"]){
		@define("ERROR_404", "Y");
		CHTTP::SetStatus("404 Not Found");
		global $APPLICATION;
		$APPLICATION->RestartBuffer();
		include $_SERVER['DOCUMENT_ROOT']."/bitrix/templates/".SITE_TEMPLATE_ID."/header.php";
		require ($_SERVER["DOCUMENT_ROOT"]."/404.php");
		include $_SERVER['DOCUMENT_ROOT']."/bitrix/templates/".SITE_TEMPLATE_ID."/footer.php";
		exit;
	}

	$elem = CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>192, "ID"=>$_REQUEST["ELEMENT_ID"]), Array("ID","PROPERTY_PAGETITLE", "PROPERTY_MENU_LINK","PROPERTY_DESCRIPTION","PROPERTY_KEYWORDS"));
	$elem = $elem->GetNext();

	if(!$elem){
		@define("ERROR_404", "Y");
		CHTTP::SetStatus("404 Not Found");
		global $APPLICATION;
		$APPLICATION->RestartBuffer();
		include $_SERVER['DOCUMENT_ROOT']."/bitrix/templates/".SITE_TEMPLATE_ID."/header.php";
		require ($_SERVER["DOCUMENT_ROOT"]."/404.php");
		include $_SERVER['DOCUMENT_ROOT']."/bitrix/templates/".SITE_TEMPLATE_ID."/footer.php"; 
	}

	/*
	echo '<pre>';
	var_dump($APPLICATION->GetCurPage(false));
	var_dump(strlen(trim($elem['PROPERTY_MENU_LINK_VALUE'])) && trim($elem['PROPERTY_MENU_LINK_VALUE']) !== $APPLICATION->GetCurPage(false));
	print_r($elem);echo "\n";
	print_r($APPLICATION->GetCurPage(false)); echo "\n";
	print_r($_SERVER);echo "\n";
	echo '</pre>';
	die();

	if (strlen(trim($elem['PROPERTY_MENU_LINK_VALUE'])) && trim($elem['PROPERTY_MENU_LINK_VALUE']) !== $APPLICATION->GetCurPage(false))
	{
		LocalRedirect(trim($elem['PROPERTY_MENU_LINK_VALUE']));
	}*/ 
	if($elem["PROPERTY_PAGETITLE_VALUE"] != '')   /*$_SESSION['PageTitle'] = $elem["PROPERTY_PAGETITLE_VALUE"]; */ $APPLICATION->SetPageProperty("pagetitle", $elem["PROPERTY_PAGETITLE_VALUE"]);
	if($elem["PROPERTY_DESCRIPTION_VALUE"] != '') $APPLICATION->SetPageProperty("description", $elem["PROPERTY_DESCRIPTION_VALUE"]);
	if($elem["PROPERTY_KEYWORDS_VALUE"] != '')    $APPLICATION->SetPageProperty("keywords", $elem["PROPERTY_KEYWORDS_VALUE"]);
	?>

	<script type="text/javascript" src="/bitrix/templates/bmw_inner/js/jquery.js"></script>

	<!--
	MODE : <?=$_GET["mode"];?>
	-->
	<?if($elem){
	$APPLICATION->IncludeComponent("bitrix:catalog.element", "model_detail", Array(
		"IBLOCK_TYPE"	=>	"models",
		"IBLOCK_ID"	=>	"192",
		"ELEMENT_ID"	=>	$_REQUEST["ELEMENT_ID"],
		"SECTION_ID"	=>	$_REQUEST["SECTION_ID"],
		"PROPERTY_CODE"	=>	array(
			0	=>	"",
			1	=>	$_REQUEST["fact"],
			2	=>	"",
		),
		"SECTION_URL"	=>	"section.php?IBLOCK_ID=#IBLOCK_ID#&SECTION_ID=#SECTION_ID#",
		"DETAIL_URL"	=>	"element.php?IBLOCK_ID=#IBLOCK_ID#&SECTION_ID=#SECTION_ID#&ELEMENT_ID=#ELEMENT_ID#",
		"BASKET_URL"	=>	"/personal/basket.php",
		"ACTION_VARIABLE"	=>	"action",
		"PRODUCT_ID_VARIABLE"	=>	"id",
		"SECTION_ID_VARIABLE"	=>	"SECTION_ID",
		"CACHE_TYPE"	=>	"N",
		"CACHE_TIME"	=>	"3600",
		"META_KEYWORDS"	=>	"-",
		"META_DESCRIPTION"	=>	"-",
		"DISPLAY_PANEL"	=>	"N",
		"SET_TITLE"	=>	"Y",
		"ADD_SECTIONS_CHAIN"	=>	"Y",
		"USE_PRICE_COUNT"	=>	"N",
		"SHOW_PRICE_COUNT"	=>	"1",
		"PRICE_VAT_INCLUDE"	=>	"Y",
		"PRICE_VAT_SHOW_VALUE"	=>	"N",
		"LINK_IBLOCK_TYPE"	=>	"models",
		"LINK_IBLOCK_ID"	=>	"193",
		"LINK_PROPERTY_SID"	=>	"ALLFACTS",
		"LINK_ELEMENTS_URL"	=>	"link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#"
		)
	);
	}?>
<?}?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>