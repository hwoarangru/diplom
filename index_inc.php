<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="information-block"> 	 	 
	<div class="information-block-head">���������������</div>
	�������� ��������, �� ��������� ����������� ������ <b>���������</b>. ��� ���� ����� ����������� �������� ������ ����-����� ���������� �������� <a href="/bitrix/admin/cache.php">���������������</a>.
</div>

<div class="information-block"> 	 	 
  <div class="information-block-head">�����</div>
 	<?$APPLICATION->IncludeComponent(
	"bitrix:voting.current",
	"main_page",
	Array(
		"CHANNEL_SID" => "ANKETA",
		"CACHE_TYPE"	=>	"A",
		"CACHE_TIME"	=>	"3600",
	)
);?> </div>
 
<div class="information-block"> 	 	 
  <div class="information-block-head">���� ���</div>
 <?$APPLICATION->IncludeComponent(
	"bitrix:photo.random",
	".default",
	Array(
		"IBLOCK_TYPE" => "photo", 
		"IBLOCKS" => Array("8"), 
		"PARENT_SECTION" => "", 
		"CACHE_TYPE"	=>	"A",
		"CACHE_TIME"	=>	"180",
		"DETAIL_URL" => "/content/photo/index.php?SECTION_ID=#SECTION_ID#&ELEMENT_ID=#ELEMENT_ID#" 
	)
);?> </div>
