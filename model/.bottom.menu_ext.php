<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?

$arParams["SEF_BASE_URL"] = '/cars/';
$arParams['DefaultUrlTemplates404'] = array(
      "model_index" => "#RANGE_CODE#/#MODEL_ID#/"
	, "model_media" => "#RANGE_CODE#/#MODEL_ID#/media/"
	, "feature_list" => "#RANGE_CODE#/#MODEL_ID#/#FEATURE_SECTION_CODE#/"
	, "feature_detail" => "#RANGE_CODE#/#MODEL_ID#/#FEATURE_SECTION_CODE#/#FEATURE_CODE#/"
	//, "feature_presentation" => "#RANGE_CODE#/#MODEL_ID#/#FEATURE_SECTION_CODE#/#FEATURE_CODE#/presentation/"
);

$arParams["CACHE_TIME"] = 0;//86400;
$arParams["IBLOCK_ID"] = ADV_IBLOCK_PARAM_ID;
$arParams["IBLOCK_FEATURE_TYPE"] = "models";
$arParams["IBLOCK_FEATURE_CODE"] = "param";
$arParams["IBLOCK_MODEL_CODE"] = "models";
$arParams["IBLOCK_PHOTO_CODE"] = "photo";
$arParams["IBLOCK_VIDEO_CODE"] = "video";
$arParams["IBLOCK_PRESENTATION_CODE"] = "presentation";

$arVariables = array();

$componentPage = CComponentEngine::ParseComponentPath(
    $arParams["SEF_BASE_URL"],
    $arParams['DefaultUrlTemplates404'],
    $arVariables
);
CComponentEngine::InitComponentVariables(
	$componentPage,
	array("RANGE_CODE", "MODEL_ID"),
	$arParams['DefaultUrlTemplates404'],
	$arVariables
);
    
/*
echo '<pre>';
print_r($componentPage);
print_r($arVariables);
echo '</pre>';    
*/
$objCache = new CPHPCache; 
$strCacheID = md5(serialize(array(
    __FILE__,
    $arParams,
    $arVariables,
	"bottom_menu" //соль
)));
if($objCache->InitCache($arParams['CACHE_TIME'], $strCacheID, "/"))
{
    $vars = $objCache->GetVars();
    $arModel = $vars['arModel'];
}
else 
{



	$arOrder = array("SORT" => "ASC", "NAME" => "ASC");
	$arFilter = array(

		  "IBLOCK_CODE" => $arParams["IBLOCK_MODEL_CODE"]
		, "IBLOCK_TYPE" => $arParams["IBLOCK_FEATURE_TYPE"]
		, "ACTIVE" => "Y"
	);
	$index = ((int)$arVariables['MODEL_ID'] > 0)?'ID':'CODE';
	$arFilter[$index] = $arVariables['MODEL_ID'];
	


	$rsModel = CIBlockElement::GetList($arOrder, $arFilter);
	while ($rsModel && $objModel = $rsModel->GetNextElement()) 
	{
		$arModel = array
		(
			  'FIELDS' => $objModel->GetFields()
			, 'PROPS' => $objModel->GetProperty()//array()
		);
		/*// Цены и комплектация
		$arModel['PROPS']['PRICES'] = $objModel->GetProperty('PRICES');
		// Специальные предложения
		$arModel['PROPS']['FILE_SPECIAL_OFFER'] = $objModel->GetProperty('FILE_SPECIAL_OFFER');
		// Электронный каталог (файл)
		$arModel['PROPS']['FILE_CATALOG'] = $objModel->GetProperty('FILE_CATALOG');
		// Электронный каталог (прямые ссылки)
		$arModel['PROPS']['LINK_CATALOG'] = $objModel->GetProperty('LINK_CATALOG');
		// Сравнение моделей
		$arModel['PROPS']['COMPARISON'] = $objModel->GetProperty('COMPARISON');
		// Сравнение моделей
		//$arModel['PROPS']['TEST_DRIVE'] = $objModel->GetProperty('TEST_DRIVE');*/
	}
	
	$objCache->StartDataCache();
	$objCache->EndDataCache(array(
		'arModel' => $arModel
	)); 
}




$aMenuLinks = array();


/************************************************************
	ЦЕНЫ И КОМПЛЕКТАЦИЯ
 ************************************************************/
if ($arModel['PROPS']['PRICES']['VALUE'] || $arModel['PROPS']['FILE_SPECIAL_OFFER']['VALUE'])
{
	$aMenuLinks[] = Array
	(
		"Цены и комплектация", 
		"", 
		Array(), 
		Array
		(
			  "DEPTH_LEVEL" => 1
			, "TEXT" => $arModel['FIELDS']['NAME']
		)
	);
}
if(is_array($arModel['PROPS']['PRICES']['VALUE']))
{
	foreach($arModel['PROPS']['PRICES']['VALUE'] as $id_price=>$val)
	{
		if($arModel['PROPS']['PRICES']['DESCRIPTION'][$id_price]=="")
		{
			$text="Цены и комплектация";
		}
		else
		{
			$text=$arModel['PROPS']['PRICES']['DESCRIPTION'][$id_price];
		}
		$aMenuLinks[] = Array
		(
			$text, 
			CFile::GetPath($val), 
			Array(), 
			Array
			(
				  "DEPTH_LEVEL" => 2
				, "TARGET" => "_blank"
			)
		);
	}
}
else
{
	if ($arModel['PROPS']['PRICES']['VALUE'])
	{
		$aMenuLinks[] = Array
		(
			"Цены и комплектация", 
			CFile::GetPath($arModel['PROPS']['PRICES']['VALUE']), 
			Array(), 
			Array
			(
				  "DEPTH_LEVEL" => 2
				, "TARGET" => "_blank"
			)
		);
	}
}
if ($arModel['PROPS']['FILE_SPECIAL_OFFER']['VALUE'])
{
	$aMenuLinks[] = Array
	(
		"Специальные предложения", 
		CFile::GetPath($arModel['PROPS']['FILE_SPECIAL_OFFER']['VALUE']), 
		Array(), 
		Array
		(
			  "DEPTH_LEVEL" => 2
			, "TARGET" => "_blank"
		)
	);
}

/************************************************************
	ПОДОБРАТЬ КОМПЛЕКТАЦИЮ
 ************************************************************/
$aMenuLinks[] = Array
(
	"Конфигуратор", 
	"", 
	Array(), 
	Array
	(
		  "DEPTH_LEVEL" => 1
		, "TEXT" => "Выберите подходящий для вас автомобиль: определите собственную конфигурацию " . $arModel['FIELDS']['NAME']
	)
);
$aMenuLinks[] = Array
(
	"Конфигуратор", 
	"http://www.bmw.ru/ru/ru/general/carconfigurator/content.html", 
	Array(), 
	Array
	(
		  "DEPTH_LEVEL" => 2
		, "TARGET" => "_blank"
	)
);



/************************************************************
	ЭЛЕКТРОННЫЙ КАТАЛОГ
 ************************************************************/


if (
	(count($arModel['PROPS']['FILE_CATALOG']['VALUE']) && $arModel['PROPS']['FILE_CATALOG']['VALUE'])|| 
	(count($arModel['PROPS']['LINK_CATALOG']['VALUE']) && $arModel['PROPS']['LINK_CATALOG']['VALUE'])
)
{
	
	$aMenuLinks[] = Array
	(
		"Электронный каталог", 
		"", 
		Array(), 
		Array
		(
			  "DEPTH_LEVEL" => 1
			, "TEXT" => ""
		)
	);
	foreach ($arModel['PROPS']['FILE_CATALOG']['VALUE'] as $key => $value) 
	{
		$aMenuLinks[] = Array
		(
			$arModel['PROPS']['FILE_CATALOG']['DESCRIPTION'][$key], 
			CFile::GetPath($value), 
			Array(), 
			Array
			(
				  "DEPTH_LEVEL" => 2
				, "TARGET" => "_self"
			)
		);
	}
	foreach ($arModel['PROPS']['LINK_CATALOG']['VALUE'] as $key => $value) 
	{
		$aMenuLinks[] = Array
		(
			$arModel['PROPS']['LINK_CATALOG']['DESCRIPTION'][$key], 
			$value, 
			Array(), 
			Array
			(
				  "DEPTH_LEVEL" => 2
				, "TARGET" => "_blank"
			)
		);
	}
}



/*************************************************************
	СРАВНЕНИЕ МОДЕЛЕЙ
**************************************************************/
if($arModel['PROPS']['COMPARISON']['VALUE'] > '')
{
$aMenuLinks[] = Array(
	"Сравнение моделей",
	"",
	Array(),
	Array(
		"DEPTH_LEVEL" => 1
		, "TEXT" => "Выберите подходящий для вас автомобиль"
	)
);
$aMenuLinks[] = Array
(
	"Сравнение моделей", 
	$arModel['PROPS']['COMPARISON']['VALUE'], 
	Array(), 
	Array
	(
		  "DEPTH_LEVEL" => 2
		, "TARGET" => "_self"
	)
);
}


/************************************************************
	ЗАПИСЬ НА ТЕСТ-ДРАЙВ
 ************************************************************/
if((bool)$arModel['PROPS']['TEST_DRIVE']['VALUE']){
$aMenuLinks[] = Array
(
	"Запись на тест-драйв", 
	"", 
	Array(), 
	Array
	(
		  "DEPTH_LEVEL" => 1
		, "TEXT" => "Выберите подходящий для вас автомобиль"
	)
);
$aMenuLinks[] = Array
(
	"Запись на тест-драйв", 
	"/testdrive/", 
	Array(), 
	Array
	(
		  "DEPTH_LEVEL" => 2
		, "TARGET" => "_self"
	)
);

}


/*************************************************************
	Каталог
**************************************************************/
if($arModel['PROPS']['COMPARISON']['VALUE'] > '')
{
$aMenuLinks[] = Array(
	"Каталог",
	"",
	Array(),
	Array(
		"DEPTH_LEVEL" => 1
		, "TEXT" => "Каталог"
	)
);

$aMenuLinks[] = Array
(
	"Заказ Каталог", 
	$arModel['PROPS']['COMPARISON']['VALUE'], 
	Array(), 
	Array
	(
		  "DEPTH_LEVEL" => 2
		, "TARGET" => "_self"
	)
);
}



/*************************************************************
	Каталог
**************************************************************/
/* if($arModel['PROPS']['COMPARISON']['VALUE'] > '')
{
$aMenuLinks[] = Array(
	"Кредит от BMW Bank",
	"",
	Array(),
	Array(
		"DEPTH_LEVEL" => 1
		, "TEXT" => "Кредитные программы BMW Bank на новый BMW 1 серии."
	)
);

$aMenuLinks[] = Array
(
	"Кредит от BMW Bank", 
	$arModel['PROPS']['COMPARISON']['VALUE'], 
	Array(), 
	Array
	(
		  "DEPTH_LEVEL" => 2
		, "TARGET" => "_self"
	)
);
}*/




$menuIndex = 0;
$previousDepthLevel = 1;
foreach($aMenuLinks as $arItem)
{
    if ($menuIndex > 0)
        $aMenuLinks[$menuIndex - 1][3]["IS_PARENT"] = $arItem[3]["DEPTH_LEVEL"] > $previousDepthLevel;
    $previousDepthLevel = $arItem[3]["DEPTH_LEVEL"];
    $menuIndex++;
}

//print_r($aMenuLinks);
