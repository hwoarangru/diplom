<?
$aMenuLinks = Array(
	Array(
		"��� �������", 
		"/cabinet/profile/", 
		Array(), 
		Array(), 
		"" 
	),
	Array(
		"������������ ����������� �� ��������", 
		"/cabinet/consultation/", 
		Array(), 
		Array(), 
		"" 
	),
	Array(
		"�������������� �����������", 
		"/cabinet/indivsug/", 
		Array(), 
		Array(), 
		"" 
	),
	Array(
		"������� �������", 
		"/testdrive/testdrive.php", 
		Array(), 
		Array(), 
		"" 
	),
	Array(
		"C����� ���������", 
		"/cabinet/support/", 
		Array(), 
		Array(), 
		"" 
	),
	Array(
		"������������� ������������", 
		"/cabinet/corporate/", 
		Array(), 
		Array(), 
		"false" 
	),
	Array(
		"������ �� ������������", 
		"/cabinet/service/", 
		Array(), 
		Array(), 
		"" 
	),
//	Array(
//		"������ ����������� � ��������", 
//		"/cabinet/used/", 
//		Array(), 
//		Array(), 
//		"" 
//	),
//	Array(
//		"�����", 
//		"/cabinet/stocks/", 
//		Array(), 
//		Array(), 
//		"Items()" 
//	),
//	Array(
//		"�����-���� � �������", 
//		"/cabinet/price/", 
//		Array(), 
//		Array(), 
//		"Items()"  
//	),
	Array(
		"�����", 
		"/cabinet/logout.php?logout=true", 
		Array(), 
		Array(), 
		"\$USER->IsAuthorized()" 
	)
);

function Items(){
	if(CModule::IncludeModule("iblock"))
	{
		$iBlockCount = 0; 
		$iblocks = GetIBlockList("price");
		while($arIBlock = $iblocks->GetNext())
		{
			$iBlockCount++; 
		}
		if ($iBlockCount>0) return true; else return false;
	} else return false;
}
?>