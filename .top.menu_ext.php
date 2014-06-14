<?
if (CModule::IncludeModule("iblock")):

$IBLOCK_TYPE = "models";   	 	// тип инфо-блока
$IBLOCK_ID = 192;            	// ID инфо-блока
$CACHE_TIME = 86400;        	 	// время кэширования
$aMenuLinksNew = array();
$ROOT_SECTION_ID = 0;
$CACHE_ID = __FILE__.$IBLOCK_ID;
$obMenuCache = new CPHPCache;
$CACHE_ADD = "";

if($obMenuCache->InitCache($CACHE_TIME, $CACHE_ID.$CACHE_ADD, "/"))
{
	// берем данные из кэша
	$arVars = $obMenuCache->GetVars();
	$aMenuLinksNew = $arVars["aMenuLinksNew"];
}
else
{
	//Выбираем разделы
	$arSections=array();
	$SecRes = CIBlockSection::GetList(array("SORT"=>"asc", "ID"=>"asc"), Array("IBLOCK_ID"=> $IBLOCK_ID, "ACTIVE"=>"Y"), false, array("UF_LINK", "UF_MENU_LINK_SPLIT"));
	while($arSec = $SecRes->GetNext())
	{
		$arSections[$arSec["ID"]]=$arSec;
	}
	if(count($arSections))
		$arResult["section_list"]=$arSections;

    //Выбираем элементы
	$arSelect = array(
	        'ID',
	        'IBLOCK_ID',
	        'IBLOCK_SECTION_ID',
	        'NAME',
	        'CODE',
	        'DETAIL_PAGE_URL',
	        'PROPERTY_MENU_LINK',
	        'PROPERTY_MENU_LINK2SECT',
	        'PROPERTY_MENU_LINK_SEPARATE',
                'PROPERTY_MENUIMG',
                'PROPERTY_ALLFACTS',
	);

	$res = CIBlockElement::GetList(array("SORT" => "ASC", "ID" => "ASC"), array("IBLOCK_ID"=>$IBLOCK_ID, "ACTIVE"=>"Y"), false, false, $arSelect);
	$arResult["list"] = array();
	while ($arRes = $res->GetNext())
	{
		$arRes["PROPERTY_MENU_LINK_VALUE"]=trim($arRes["PROPERTY_MENU_LINK_VALUE"]);
        if(count($arResult["section_list"]))
        	$arResult["section_list"][intval($arRes["IBLOCK_SECTION_ID"])]["ELEMENTS_LIST"][$arRes["ID"]] = $arRes;

		 $arResult["list"][$arRes["ID"]] = $arRes;
	}

	//Формируем дерево разделов и элементов для 2-х уровневой структуры
	$arResult["section_tree"] = array();
	foreach($arResult["section_list"] as $id=>$section){
		if($section["DEPTH_LEVEL"] == 1){
			$arResult["section_tree"][$id]=$arResult["section_list"][$id];
		}
	}
	foreach($arResult["section_list"] as $id=>$section){
		if($section["DEPTH_LEVEL"] == 2){
			$arResult["section_tree"][$section["IBLOCK_SECTION_ID"]]["CHILD_SECTIONS"][$id]=$arResult["section_list"][$id];
		}
	}

	//Формируем массив меню
	foreach($arResult["section_tree"] as $arFirstLevel){

		if(isset($arFirstLevel["UF_LINK"]) && strlen($arFirstLevel["UF_LINK"]))
			$section_url = $arFirstLevel["UF_LINK"];
		else
			$section_url = SITE_DIR."cars/".(strlen($arFirstLevel["ID"]) ? $arFirstLevel["CODE"] : $arFirstLevel["ID"])."/";
                
                $MENU_SL = 0;
                if(count($arFirstLevel["CHILD_SECTIONS"])){
                    foreach($arFirstLevel["CHILD_SECTIONS"] as $arSecondLevel){
                        if ($arSecondLevel["NAME"] != "Обзор") {
                            $MENU_SL = count($arSecondLevel["ELEMENTS_LIST"]);
                        }
                    }
                }

		$aMenuLinksNew[] = array(
			$arFirstLevel["NAME"],
			$section_url,
			Array(),
			Array(
				"DEPTH_LEVEL"=>1,
				"BOLD"=>1,
				"notShowInMap" => "Y",
				"PARENT"=>isset($arFirstLevel["CHILD_SECTIONS"]) || isset($arFirstLevel["ELEMENTS_LIST"]) ? 1 : 0,
				"BLANK"=>preg_match("~http\:\/\/~", $section_url) ? 1 : 0,
				"SPLIT" => "Y",
                                "MENUCARS"=>"Y",
                                "MENU_SL"=>$MENU_SL,
			)
		);

		//Если у раздела 1 уровня есть элементы
		if(count($arFirstLevel["ELEMENTS_LIST"])){
			foreach($arFirstLevel["ELEMENTS_LIST"] as $arItem){
            	$aMenuLinksNew[] = array(
					$arItem["NAME"],
					SITE_DIR."cars/".(strlen($arFirstLevel["ID"]) ? $arFirstLevel["CODE"] : $arFirstLevel["ID"])."/".$arItem["ID"]."/",
					Array(),
					Array(
						"DEPTH_LEVEL"=>1,
						"notShowInMap" => "Y",
						"CHILD"=>1,
						"SEPARATE"=>$arItem["PROPERTY_MENU_LINK_SEPARATE_VALUE"]=="Y" ? 1 : 0,
						"BLANK"=>isset($arItem["PROPERTY_MENU_LINK_VALUE"]) && preg_match("~http\:\/\/~", $arItem["PROPERTY_MENU_LINK_VALUE"]) ? 1 : 0,
                                                "MENUCARS"=>"Y",
					)
				);
			}
		}

		//Если есть разделы 2 уровня
		if(count($arFirstLevel["CHILD_SECTIONS"])){
		$subCount = 0;
			foreach($arFirstLevel["CHILD_SECTIONS"] as $arSecondLevel){
                            
                            //Хак, ссылки с Hybrid идут на сторонний ресурс
                            if ($arFirstLevel["NAME"] != "Hybrid") {
                                
                                if ($arSecondLevel["NAME"] != "Обзор") {
                                
                                    if(count($arSecondLevel["ELEMENTS_LIST"])){
                                            foreach($arSecondLevel["ELEMENTS_LIST"] as $arItem){

                                                    if(isset($arItem["PROPERTY_MENU_LINK_VALUE"]) && strlen($arItem["PROPERTY_MENU_LINK_VALUE"]))
                                                            $url = $arItem["PROPERTY_MENU_LINK_VALUE"];
                                                    elseif($arItem["PROPERTY_MENU_LINK2SECT_VALUE"]=="Y")
                                                            $url = $section_url;
                                                    else
                                                            $url = SITE_DIR."cars/".(strlen($arFirstLevel["ID"]) ? $arFirstLevel["CODE"] : $arFirstLevel["ID"])."/".$arItem["ID"]."/";
                                                    
                                                    $MENUPRICE = "";
                                                    
                                                    /*if ($arItem["PROPERTY_ALLFACTS_VALUE"] != "") {
                                                        $rsMULTIMEDIA = CIBlockSection::GetList(Array(), Array("IBLOCK_ID"=>"193", "SECTION_ID"=>$arItem["PROPERTY_ALLFACTS_VALUE"]),false, Array("UF_MULTIMEDIA"));
                                                        while($ar_result = $rsMULTIMEDIA->GetNext()) {
                                                            $rsMULTIMEDIA2 = CIBlockSection::GetList(Array(), Array("IBLOCK_ID"=>"193", "SECTION_ID"=>$ar_result["ID"], "!UF_MULTIMEDIA"=>""),false, Array("UF_MULTIMEDIA"));
                                                            while($ar_result2 = $rsMULTIMEDIA2->GetNext()) {
                                                                if (substr($ar_result2["UF_MULTIMEDIA"],-3) == "pdf") {
                                                                    $MENUPRICE = $ar_result2["UF_MULTIMEDIA"]; 
                                                                }
                                                            }
                                                        }
                                                    }*/

                                                    $aMenuLinksNew[] = array(
                                                            $arItem["~NAME"],
                                                            $url,
                                                            Array(),
                                                            Array(
                                                                    "DEPTH_LEVEL"=>2,
                                                                    "notShowInMap" => "Y",
                                                                    "CHILD"=>1,
                                                                    "SEPARATE"=>$arItem["PROPERTY_MENU_LINK_SEPARATE_VALUE"]=="Y" ? 1 : 0,
                                                                    "MENUIMG"=>$arItem["PROPERTY_MENUIMG_VALUE"],
                                                                    "MENUCARS"=>"Y",
                                                                    "MENU_PRICE"=>$MENUPRICE,
                                                                    "BLANK"=>preg_match("~http\:\/\/~", $url) ? 1 : 0,
                                                            )
                                                    );

                                            }
                                    }
                                
                                }
                                
                            } else {
                                
				//По умолчанию у раздела второго уровня берется ссылка из его первого элемента
				$firstItem = current($arSecondLevel["ELEMENTS_LIST"]);

				//Если задан кастомный урл у первого элемента раздела
				if(isset($firstItem["PROPERTY_MENU_LINK_VALUE"]) && strlen($firstItem["PROPERTY_MENU_LINK_VALUE"]))
					$url = $firstItem["PROPERTY_MENU_LINK_VALUE"];
				//Если у первого элемента ссылка на обзор серии
				elseif($firstItem["PROPERTY_MENU_LINK2SECT_VALUE"]=="Y")
					$url = $section_url;
				//Если есть свой урл у раздела
				elseif(isset($firstItem["UF_LINK"]) && strlen($firstItem["UF_LINK"]))
					$url = $firstItem["UF_LINK"];
				//Иначе урл равен урлу певрого элемента
				else
                	$url = SITE_DIR."cars/".(strlen($arFirstLevel["ID"]) ? $arFirstLevel["CODE"] : $arFirstLevel["ID"])."/".$firstItem["ID"]."/";

				$aMenuLinksNew[] = array(
					$arSecondLevel["NAME"],
					$url,
					Array(),
					Array(
						"DEPTH_LEVEL"=>2,
						"BOLD"=>1,
						"notShowInMap" => "Y",
						"CHILD"=>1,
						"SEPARATE"=> $subCount == 0 || $arSecondLevel["UF_MENU_LINK_SPLIT"] ? 0 : 1,
						"BLANK"=>preg_match("~http\:\/\/~", $url) ? 1 : 0,
						"SPLIT"=>$arSecondLevel["UF_MENU_LINK_SPLIT"] ? "Y" : "N",
					)
				);

				//Если у раздела 2 уровня есть элементы
				if(count($arSecondLevel["ELEMENTS_LIST"])){
					foreach($arSecondLevel["ELEMENTS_LIST"] as $arItem){

						if(isset($arItem["PROPERTY_MENU_LINK_VALUE"]) && strlen($arItem["PROPERTY_MENU_LINK_VALUE"]))
							$url = $arItem["PROPERTY_MENU_LINK_VALUE"];
						elseif($arItem["PROPERTY_MENU_LINK2SECT_VALUE"]=="Y")
							$url = $section_url;
						else
		                	$url = SITE_DIR."cars/".(strlen($arFirstLevel["ID"]) ? $arFirstLevel["CODE"] : $arFirstLevel["ID"])."/".$arItem["ID"]."/";
                                                
                                                $aMenuLinksNew[] = array(
							$arItem["~NAME"],
							$url,
							Array(),
							Array(
								"DEPTH_LEVEL"=>2,
								"notShowInMap" => "Y",
								"CHILD"=>1,
								"SEPARATE"=>$arItem["PROPERTY_MENU_LINK_SEPARATE_VALUE"]=="Y" ? 1 : 0,
								"BLANK"=>preg_match("~http\:\/\/~", $url) ? 1 : 0,
							)
						); 
					}
				}
                                $subCount++;
                            }
                        
                        }
		}

	}
}
// сохраняем данные в кэше
if($obMenuCache->StartDataCache($CACHE_TIME, $CACHE_ID.$CACHE_ADD, "/"))
{
	$obMenuCache->EndDataCache(Array("aMenuLinksNew" => $aMenuLinksNew));
}

$arFirstLink = $aMenuLinks[0];
array_shift($aMenuLinks);
$aMenuLinks = array_merge($aMenuLinksNew, $aMenuLinks);
array_unshift($aMenuLinks, $arFirstLink);


endif;

?>
<!--- <?php //print_r($aMenuLinks); ?> --->