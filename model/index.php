<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
?>
<?
$_DirTitle = "Модельный ряд BMW, каталог автомобилей BMW - официальный дилер Независимость BMW";

$APPLICATION->SetPageProperty("pagetitle", $_DirTitle);

$APPLICATION->IncludeComponent("adv:model", "", array(
	  "SEF_MODE" => "Y"
	, "SEF_FOLDER" => "cars"
));
?>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>