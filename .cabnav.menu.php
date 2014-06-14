<?
$aMenuLinks = Array(
	Array(
		"Ваш профиль", 
		"/cabinet/profile/", 
		Array(), 
		Array(), 
		"" 
	),
	Array(
		"Консультация специалиста по телефону", 
		"/cabinet/consultation/", 
		Array(), 
		Array(), 
		"" 
	),
	Array(
		"Индивидуальное предложение", 
		"/cabinet/indivsug/", 
		Array(), 
		Array(), 
		"" 
	),
	Array(
		"Пробная поездка", 
		"/testdrive/testdrive.php", 
		Array(), 
		Array(), 
		"" 
	),
	Array(
		"Cлужба поддержки", 
		"/cabinet/support/", 
		Array(), 
		Array(), 
		"" 
	),
	Array(
		"Корпоративное обслуживание", 
		"/cabinet/corporate/", 
		Array(), 
		Array(), 
		"false" 
	),
	Array(
		"Запись на обслуживание", 
		"/cabinet/service/", 
		Array(), 
		Array(), 
		"" 
	),
//	Array(
//		"Резерв автомобилей с пробегом", 
//		"/cabinet/used/", 
//		Array(), 
//		Array(), 
//		"" 
//	),
//	Array(
//		"Акции", 
//		"/cabinet/stocks/", 
//		Array(), 
//		Array(), 
//		"Items()" 
//	),
//	Array(
//		"Прайс-лист и наличие", 
//		"/cabinet/price/", 
//		Array(), 
//		Array(), 
//		"Items()"  
//	),
	Array(
		"Выход", 
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