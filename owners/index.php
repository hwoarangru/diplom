<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("alt_image", "������ BMW");
$APPLICATION->SetPageProperty("image", "/upload/service.jpg");
$APPLICATION->SetTitle("���������� BMW");
?> 
<!--<div id="headlines"> 
  <h1>������ BMW</h1>
 </div>
 
<div style="width: 375px;"> 
  <p>���� ����������� ���������� ������ ������ ������� ��� ����� ������ � ������� � ������������ ������ BMW.</p>
 
  <p>��������� ����� ������� �� ����� ��������� � �������� �����, �������������� �� ��������� ���������� �������� BMW AG � ������������� ���� ������ ��������� ����� ����� ���������. </p>
 
  <p>��������������� ��������, ���������� ��� ���������� ��������� ����������������� BMW � ������, ��������� �������� ���������� � ���������� � ������������ � �������� ��������.</p>
 
  <p>������������ ������� ������ ������������ ������������ ������ ���������� � ������� ��� ��� ����� � ������� ���������, � ������� ���� ����� �� ������� ���������� ��������� �������������� ������ �� ���� ������ � ����������� ��������������� ������� ����������� �� ����������� ������.</p>
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