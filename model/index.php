<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
?>
<?
$_DirTitle = "��������� ��� BMW, ������� ����������� BMW - ����������� ����� ������������� BMW";

$APPLICATION->SetPageProperty("pagetitle", $_DirTitle);

$APPLICATION->IncludeComponent("adv:model", "", array(
	  "SEF_MODE" => "Y"
	, "SEF_FOLDER" => "cars"
));
?>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>