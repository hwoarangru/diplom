<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if (!CModule::includeModule('iblock')) {
    return false;
}
if(!function_exists('DateFormat'))
{
	function DateFormat($format, $timestamp)
	{
		if($timestamp===false)
			return "";
		if(LANG=="en")
			return date($format, $timestamp);
		elseif(preg_match_all("/[FMlD]/", $format, $matches))
		{
			$ar = preg_split("/[FMlD]/", $format);
			$result = "";
			foreach($matches[0] as $i=>$match)
			{
				switch($match)
				{
					case "F":$match=GetMessage("FORMAT_MONTH_".date("n", $timestamp));break;
					case "M":$match=GetMessage("FORMAT_MON_".date("n", $timestamp));break;
					case "l":$match=GetMessage("FORMAT_DAY_OF_WEEK_".date("w", $timestamp));break;
					case "D":$match=GetMessage("FORMAT_DOW_".date("w", $timestamp));break;
				}
				$result .= date($ar[$i], $timestamp).$match;
			}
			$result .= date($ar[count($ar)-1], $timestamp);
			return $result;
		}
		else
			return date($format, $timestamp);
	}
}

if(!function_exists('TwoDateConvert'))
{
	function TwoDateConvert($format, $date_from, $date_to,$custom=false)
	{
		$dates=array();
		$dates["date_from"]= DateFormat($format, $date_from);
		$dates["date_to"]= DateFormat($format, $date_to);
		if($custom && strlen($dates["date_to"]))
		{
			$sep=str_replace(array("d","m","Y","j","M","F","y","g","i","G","H"),array("","","","","","","","","","",""),$format);
			$new_to=$new_from="";
			$n=strlen($dates["date_to"]);
			$j=strlen($sep)-1;
			for($i=strlen($dates["date_to"])-1; $i>=0; $i--)
			{
				//var_dump($dates["date_to"][$i]);
				if($dates["date_to"][$i]==$dates["date_from"][$i])
				{
					if($dates["date_to"][$i]==$sep[$j])
					{
						$n=$i;
						$j--;
					}
				}
				else
				{
					$new_from=substr($dates["date_from"],0,$n);
					$new_to="- ".substr($dates["date_to"],0,$n).substr($dates["date_to"],$n);
				}

			}
			$dates["date_from"]= $new_from;
			$dates["date_to"]= $new_to;
		}
		return $dates;
	}
}

if(!isset($arParams["CACHE_TIME"]))
	$arParams["CACHE_TIME"] = 3600;

$arParams["IBLOCK_TYPE"] = trim($arParams["IBLOCK_TYPE"]);

if(!is_array($arParams['IBLOCK_ID']) && (int)$arParams['IBLOCK_ID'])
	$arParams['IBLOCK_ID'] = (int)$arParams['IBLOCK_ID'];

$arParams['CHECK_DATES'] = (isset($arParams['CHECK_DATES']) && $arParams['CHECK_DATES']=='Y');

$arParams['DISPLAY_PANEL'] = (isset($arParams['DISPLAY_PANEL']) && $arParams['DISPLAY_PANEL']=='Y');
$arParams['SET_TITLE'] = (isset($arParams['SET_TITLE']) && $arParams['SET_TITLE']=='Y');
$arParams['INCLUDE_SECTIONS_INTO_CHAIN'] = (isset($arParams['INCLUDE_SECTIONS_INTO_CHAIN']) && $arParams['INCLUDE_SECTIONS_INTO_CHAIN']=='Y');
$arParams['NOT_SHOW_ERRORS'] = (isset($arParams['NOT_SHOW_ERRORS']) && $arParams['NOT_SHOW_ERRORS']=='Y');
$arParams['NOPAGING'] = (isset($arParams['NOPAGING']) && $arParams['NOPAGING']=='Y');

$arParams['DATE_FORMAT'] = trim($arParams['DATE_FORMAT']);
$arParams["DATE_CUSTOM"]= (isset($arParams['DATE_CUSTOM']) && $arParams['DATE_CUSTOM']=='Y');

if(!isset($arParams['DATE_FORMAT']) || strlen($arParams['DATE_FORMAT'])==0)
	$arParams['DATE_FORMAT']="j F Y";

$arParams['SORT_BY1'] = trim($arParams['SORT_BY1']);
if(strlen($arParams['SORT_BY1'])<=0)
    $arParams['SORT_BY1'] = 'ACTIVE_FROM';

if($arParams['SORT_ORDER1']!='ASC')
    $arParams['SORT_ORDER1']='DESC';

if(strlen($arParams['SORT_BY2'])<=0)
    $arParams['SORT_BY2'] = 'SORT';

if($arParams['SORT_ORDER2']!='DESC')
    $arParams['SORT_ORDER2']='ASC';

if(strlen($arParams['SORT_BY3'])<=0)
    $arParams['SORT_BY3'] = 'SORT';

if($arParams['SORT_ORDER3']!='DESC')
    $arParams['SORT_ORDER3']='ASC';

if(strlen($arParams['SECTION_SORT_BY'])<=0)
    $arParams['SECTION_SORT_BY'] = 'SORT';

if($arParams['SECTION_SORT_ORDER']!='DESC')
    $arParams['SECTION_SORT_ORDER']='ASC';

if(strlen($arParams["FILTER_NAME"])<=0 || !ereg("^[A-Za-z_][A-Za-z01-9_]*$", $arParams["FILTER_NAME"]))
{
	$arrFilter = array();
}
else
{
	global $$arParams["FILTER_NAME"];
	$arrFilter = ${$arParams["FILTER_NAME"]};
	if(!is_array($arrFilter))
		$arrFilter = array();
}

if(!$arParams['ELEMENT_COUNT'])	$arNavParams = false;
elseif($arParams['NOPAGING'])
    $arNavParams = array("nTopCount"=>$arParams["ELEMENT_COUNT"]);
else
{
    $arNavParams = array("nPageSize"=>$arParams["ELEMENT_COUNT"]);
    $arNavigation = CDBResult::GetNavParams($arNavParams);
}

if(intval($arParams['SECTION_ID']))
	$arParams['SECTION_ID'] = (int)$arParams['SECTION_ID'];
elseif(strlen($arParams['SECTION_ID']))
{
	$arParams['SECTION_CODE'] = $arParams['SECTION_ID'];
	unset($arParams['SECTION_ID']);
}


if(!is_set($arParams['SECTION_ID']) && !empty($arParams['SECTION_CODE']))
{
	$arSecCodeFilter=array(
			'IBLOCK_ID'=>$arParams['IBLOCK_ID'],
			'GLOBAL_ACTIVE'=>'Y',
			'CODE'=>$arParams['SECTION_CODE'],
			);

	$cache_id = serialize($arSecCodeFilter);
	$cache_folder = '/catalog/section/code/';
	$cache_time = $arParams['CACHE_TIME'];
	$obCache = new CPHPCache;

	if($obCache->InitCache($cache_time,$cache_id,$cache_folder))
	{
	    $vars = $obCache->GetVars();
	    $sec_id = $vars["sec_id"];
	}
	if($obCache->StartDataCache())
	{
		$SecRes = CIBlockSection::GetList(array("SORT"=>"ASC"),$arSecCodeFilter);
		if($arSec = $SecRes->GetNext())
		{
	    	$sec_id = $arSec["ID"];
	    }
	    $obCache->EndDataCache(array(
	        "sec_id"    => $sec_id
	    ));
	}
	$arParams['SECTION_ID']=$sec_id;
}

if($this->StartResultCache(false, array($arParams, $arNavigation, $arrFilter)))
{
	$arSelect=array(
                'ID',
                'IBLOCK_ID',
                'IBLOCK_SECTION_ID',
                'NAME',
                'DATE_CREATE',
                'DATE_ACTIVE_FROM',
                'DATE_ACTIVE_TO',
                'PREVIEW_TEXT_TYPE',
                'PREVIEW_TEXT',
                'DETAIL_TEXT_TYPE',
                'DETAIL_TEXT',
                'PREVIEW_PICTURE',
                'DETAIL_PICTURE',
                'DETAIL_PAGE_URL',
            );
	$ArProps=array();
	$ComplexProp=array();
	$SimpleProp=array();
	if(!empty($arParams['SELECT_PROPERTIES']) && (strlen($arParams['SELECT_PROPERTIES'][0]) || strlen($arParams['SELECT_PROPERTIES'][1])))
	{
		$arPropFilter=array("ACTIVE"=>"Y");
		if(is_array($arParams['IBLOCK_ID']))
			$arPropFilter['IBLOCK_ID'] = $arParams['IBLOCK_ID'][0];
		elseif(intval($arParams['IBLOCK_ID']))
			$arPropFilter['IBLOCK_ID'] = $arParams['IBLOCK_ID'];
		elseif(strlen($arParams['IBLOCK_ID']))
			$arPropFilter['IBLOCK_CODE'] = $arParams['IBLOCK_ID'];
//		if(!empty($arParams['SELECT_PROPERTIES']))
//			$arPropFilter['CODE'] = $arParams['SELECT_PROPERTIES'];
		//var_dump(strlen($arParams['IBLOCK_ID']));
		$properties = CIBlockProperty::GetList(Array("id"=>"asc", "name"=>"asc"), $arPropFilter);
	    while ($prop_fields = $properties->GetNext())
	    {
	    	if(is_array($arParams['SELECT_PROPERTIES']) && !in_array($prop_fields['CODE'],$arParams['SELECT_PROPERTIES']))
	    		continue;

	    	if($prop_fields["PROPERTY_TYPE"]=="G"
	    	|| $prop_fields["PROPERTY_TYPE"]=="E"
	    	|| $prop_fields["PROPERTY_TYPE"]=="L"
	    	|| $prop_fields["PROPERTY_TYPE"]=="F"
	    	|| $prop_fields["MULTIPLE"]=="Y"
	    	|| $prop_fields["WITH_DESCRIPTION"]=="Y")
	    	{
	    		$ComplexProp[$prop_fields['IBLOCK_ID']][]=$prop_fields['CODE'];
	    	}
	    	else
	    	{
	    		if(!in_array("PROPERTY_".$prop_fields['CODE'],$arSelect))
		    		$arSelect[]="PROPERTY_".$prop_fields['CODE'];
		    	$SimpleProp[$prop_fields['IBLOCK_ID']][]=$prop_fields['CODE'];

	    	}
	        $ArProp=array();
	        $ArProp['ID']=$prop_fields['ID'];
	        $ArProp['NAME']=$prop_fields['NAME'];
	        $ArProp['CODE']=$prop_fields['CODE'];
	        $ArProp['DEFAULT_VALUE']=$prop_fields['DEFAULT_VALUE'];
	        $ArProp['PROPERTY_TYPE']=$prop_fields['PROPERTY_TYPE'];
	        $ArProp['MULTIPLE']=$prop_fields['MULTIPLE'];
	        $ArProp['LINK_IBLOCK_ID']=$prop_fields['LINK_IBLOCK_ID'];

	        $ArProps[$prop_fields['IBLOCK_ID']][$ArProp['CODE']]=$ArProp;
	    }
	}

   /* echo "<pre>";
    print_r($arParams['SELECT_PROPERTIES']);
	print_r($ComplexProp);
	print_r($SimpleProp);
	echo "</pre>";*/
    $arrFilter['ACTIVE'] = 'Y';
    $arrFilter['IBLOCK_LID'] = SITE_ID;
    if(strlen($arParams["IBLOCK_TYPE"]))
    	$arrFilter['IBLOCK_TYPE'] = $arParams["IBLOCK_TYPE"];
    if($arParams['CHECK_DATES'])
    	$arrFilter['ACTIVE_DATE']='Y';

    if(!array_key_exists('IBLOCK_ID', $arrFilter) && (is_array($arParams['IBLOCK_ID']) || intval($arParams['IBLOCK_ID'])))
		$arrFilter['IBLOCK_ID'] = $arParams['IBLOCK_ID'];
	elseif(!array_key_exists('IBLOCK_ID', $arrFilter) && strlen($arParams['IBLOCK_ID']))
		$arrFilter['IBLOCK_CODE'] = $arParams['IBLOCK_ID'];

	$arSecFilter = Array(
							'IBLOCK_ID'=>$arParams['IBLOCK_ID'],
							'GLOBAL_ACTIVE'=>'Y',
							);

	if(intval($arParams['SECTION_ID']))
	{
		$arrFilter['SECTION_ID'] = $arParams['SECTION_ID'];
		$arrFilter['INCLUDE_SUBSECTIONS'] = "Y";
		$arSecFilter['ID']=$arParams['SECTION_ID'];
	}

	$arSections=array();
	$SecRes = CIBlockSection::GetList(
		array($arParams['SECTION_SORT_BY'] => $arParams['SECTION_SORT_ORDER']),
		$arSecFilter,
		false,
		array('UF_*')
		);
	while($arSec = $SecRes->GetNext())
	{
		$arSections[$arSec["ID"]]=$arSec;
	}
	/*echo "<pre>";
	print_r($arrFilter);
	echo "</pre>";*/
	if(count($arSections))
		$arResult["section_list"]=$arSections;

    $res = CIBlockElement::getList(
            array(
                $arParams['SORT_BY1'] => $arParams['SORT_ORDER1'],
                $arParams['SORT_BY2'] => $arParams['SORT_ORDER2'],
                $arParams['SORT_BY3'] => $arParams['SORT_ORDER3'],
             ),
            $arrFilter,
            false,
            $arNavParams,
            $arSelect
        );
    $arResult["list"] = array();
    //var_dump($arrFilter);
    while ($arRes = $res->getNext())
    {
    	/*if(strlen($arRes["DATE_ACTIVE_FROM"])>0)
			$arRes["DISPLAY_ACTIVE_FROM"] = DateFormat($arParams["DATE_FORMAT"], MakeTimeStamp($arRes["DATE_ACTIVE_FROM"], CSite::GetDateFormat()));
		else
			$arRes["DISPLAY_ACTIVE_FROM"] = "";

		if(strlen($arRes["DATE_ACTIVE_TO"])>0)
			$arRes["DISPLAY_ACTIVE_TO"] = DateFormat($arParams["DATE_FORMAT"], MakeTimeStamp($arRes["DATE_ACTIVE_TO"], CSite::GetDateFormat()));
		else
			$arRes["DISPLAY_ACTIVE_TO"] = "";*/

		$dates=TwoDateConvert($arParams["DATE_FORMAT"], MakeTimeStamp($arRes["DATE_ACTIVE_FROM"], CSite::GetDateFormat()),MakeTimeStamp($arRes["DATE_ACTIVE_TO"], CSite::GetDateFormat()), $arParams["DATE_CUSTOM"]);
		$arRes["DISPLAY_ACTIVE_FROM"]=$dates["date_from"];
		$arRes["DISPLAY_ACTIVE_TO"]=$dates["date_to"];


		if(strlen($arRes["DATE_CREATE"])>0)
			$arRes["DISPLAY_DATE_CREATE"] = DateFormat($arParams["DATE_FORMAT"], MakeTimeStamp($arRes["DATE_CREATE"], CSite::GetDateFormat()));
		else
			$arRes["DISPLAY_DATE_CREATE"] = "";

	   if(!isset($SimpleProp[$arRes["IBLOCK_ID"]]))
    		$SimpleProp[$arRes["IBLOCK_ID"]]=array();

		foreach ($SimpleProp[$arRes["IBLOCK_ID"]] as $prop_code)
		{
			$ArProp=$ArProps[$arRes["IBLOCK_ID"]][$prop_code];
			$ArProp['PROPERTY_VALUE_ID']=$arRes["PROPERTY_".mb_strtoupper($prop_code)."_VALUE_ID"];
		    $ArProp['VALUE']=$arRes["PROPERTY_".mb_strtoupper($prop_code)."_VALUE"];
		    $arRes['PROPERTY_'.$prop_code]=$arRes["PROPERTY_".mb_strtoupper($prop_code)."_VALUE"];
		    $arRes["PROPERTIES"][$ArProp['CODE']]=$ArProp;
		}

		if(!isset($ComplexProp[$arRes["IBLOCK_ID"]]))
    		$ComplexProp[$arRes["IBLOCK_ID"]]=array();
		foreach ($ComplexProp[$arRes["IBLOCK_ID"]] as $prop_code)
        {
       		$ArProp=$ArProps[$arRes["IBLOCK_ID"]][$prop_code];
            $db_props = CIBlockElement::GetProperty($arRes["IBLOCK_ID"], $arRes["ID"], "id", "asc", Array("CODE"=>$prop_code));
            while($ar_props = $db_props->Fetch())
            {
				$ArProp['PROPERTY_VALUE_ID']=$ar_props['PROPERTY_VALUE_ID'];
				$ArProp['DESCRIPTION']=$ar_props['DESCRIPTION'];

			  if($ArProp["PROPERTY_TYPE"]=="F" && intval($ar_props["VALUE"]))
			  {
			    $arDetail=CFile::GetFileArray($ar_props["VALUE"]);
                $a=explode(".", $arDetail["ORIGINAL_NAME"]);
                $arDetail["DISPLAY_SIZE"]["format"]=$a[1];
                if(intval($arDetail["FILE_SIZE"])> 1048576)
                {
                    $arDetail["DISPLAY_SIZE"]["size"]= round($arDetail["FILE_SIZE"]/1048576,2);
                    $arDetail["DISPLAY_SIZE"]["unit"]= "Mb";
                }
                elseif(intval($arDetail["FILE_SIZE"])> 1024)
                {
                    $arDetail["DISPLAY_SIZE"]["size"]= round($arDetail["FILE_SIZE"]/1024,1);
                    $arDetail["DISPLAY_SIZE"]["unit"]= "Kb";
                }
                else
                {
                    $arDetail["DISPLAY_SIZE"]["size"]= $arDetail["FILE_SIZE"];
                    $arDetail["DISPLAY_SIZE"]["unit"]= "b";
                }

                if($ar_props["MULTIPLE"]=="Y")
                {
                   $ArProp["VALUE"][]=$ar_props["VALUE"];
                   $ArProp["FILE_DETAIL"][]=$arDetail;
                }
                else
                {
                	$ArProp["VALUE"]=$ar_props["VALUE"];
                	$ArProp["FILE_DETAIL"]=$arDetail;
                }
			  }
			  elseif($ArProp["PROPERTY_TYPE"]=="L")
			  {
			        $arrEnum = array();
					$rsEnum = CIBlockProperty::GetPropertyEnum($ArProp["ID"]);
					while($arEnum = $rsEnum->Fetch())
					{
						$arrEnum[$arEnum["ID"]] = $arEnum["VALUE"];
					}
					$ArProp["VALUE"]=$ar_props["VALUE"];
					$ArProp["VALUE_LIST"] = $arrEnum;
			  }
			  elseif($ArProp["PROPERTY_TYPE"]=="E" || $ArProp["PROPERTY_TYPE"]=="G")
			  {
				if($ArProp["MULTIPLE"]=="Y")
				{
				    if(!empty($ar_props['VALUE']))
				          $ArProp["VALUE"][]=intval($ar_props['VALUE']);

				}
				else
					$ArProp["VALUE"]=!empty($ar_props['VALUE'])?intval($ar_props['VALUE']):null;
			  }
			  else
			  {
			  	 if($ar_props["MULTIPLE"]=="Y")
                   $ArProp['VALUE'][]=$ar_props['VALUE'];
                else
                	$ArProp['VALUE']=$ar_props['VALUE'];
                $arRes['PROPERTY_'.$ArProp['CODE']]=$ArProp['VALUE'];
			  }

			  if(empty($ArProp['VALUE']))
			  		$ArProp['VALUE']=null;

			  $arRes['PROPERTY_'.$ArProp['CODE']]=$ArProp['VALUE'];
			}

			if($ArProp["PROPERTY_TYPE"]=="E" && !empty($ArProp["VALUE"]))
			{
				if(is_array($ArProp['VALUE']) && is_array($ArProp['VALUE'][0]))
				{
					$ids=array();
					foreach ($ArProp['VALUE'] as $pr)
					{
						foreach ($pr as $val)
						{
							if(is_array($val) && intval(current($val)))
							{
								$ids=my_array_merge($ids,$val);
							}
						}
					}
				}
				else
					$ids=$ArProp['VALUE'];

				$arLinkSelect=array(
			            'ID',
			            'ACTIVE',
			            'IBLOCK_ID',
			            'NAME',
			            'DATE_ACTIVE_FROM',
			            'DATE_ACTIVE_TO',
			            'DETAIL_TEXT',
			            'DETAIL_TEXT_TYPE',
			            'DETAIL_PICTURE',
			            'LIST_PAGE_URL',
			            'DETAIL_PAGE_URL'
			        );
			      if(is_array($arParams['PROPERTY_'.$prop_code.'_SELECT']))
			      		$arLinkSelect=array_merge($arLinkSelect,$arParams['PROPERTY_'.$prop_code.'_SELECT']);

			      $link_res = CIBlockElement::getList(
			        Array("SORT"=>"ASC"),
			        array(
			            'IBLOCK_ID' => $ArProp['LINK_IBLOCK_ID'],
			            'ID'=>$ids,
			        ),
			        false,
			        false,
			        $arLinkSelect
			         );
			        while($arLink = $link_res->GetNext())
			        {
			            if($ArProp["MULTIPLE"]=="Y")
			            {

			                $ArProp["VALUE_LIST"][$arLink["ID"]]=$arLink;
			            }
			            else
			                $ArProp["VALUE_DETAIL"]=$arLink;
			        }
			}
			if($ArProp["PROPERTY_TYPE"]=="G" && (is_array($ArProp["VALUE"]) || intval($ArProp["VALUE"])))
			{
			      $link_res = CIBlockSection::GetList(
			        Array("SORT"=>"ASC"),
			        array(
			            'IBLOCK_ID' => $ArProp['LINK_IBLOCK_ID'],
			            'ID'=>$ArProp['VALUE'],
			            'ACTIVE'    => 'Y',
			        ),
			        false
			         );
			        while($arLink = $link_res->fetch())
			        {
			        	if($arLink["DEPTH_LEVEL"]>1)
						{
							$nav = CIBlockSection::GetNavChain(false, $arLink["ID"]);
							$str="";
							while($arNav=$nav->GetNext())
							{
								/*echo "<pre>";
								print_r($arNav);
								echo "</pre>";	*/
							    $str.=$arNav["NAME"]." ";
							}
							$arLink["NAV_NAME"]=$str;
						}
			            if($ArProp["MULTIPLE"]=="Y")
			            {

			                $ArProp["VALUE_LIST"][$arLink["ID"]]=$arLink;
			            }
			            else
			                $ArProp["VALUE_DETAIL"]=$arLink;
			        }
			}
			$arRes["PROPERTIES"][$ArProp['CODE']]=$ArProp;
        }

        $arRes['PREVIEW_PICTURE_URL'] = (int)$arRes['PREVIEW_PICTURE']?CFile::getPath($arRes['PREVIEW_PICTURE']):'';
        $arRes['DETAIL_PICTURE_URL'] = (int)$arRes['DETAIL_PICTURE']?CFile::getPath($arRes['DETAIL_PICTURE']):'';
        if(strlen($arParams["DETAIL_PAGE_URL"]))
        {
	        $arRes["DETAIL_PAGE_URL"] = str_replace(
				array("#SERVER_NAME#", "#SITE_DIR#", "#IBLOCK_ID#", "#ELEMENT_ID#"),
				array(SITE_SERVER_NAME, SITE_DIR, $arRes["IBLOCK_ID"], $arRes["ID"]),
				$arParams["DETAIL_PAGE_URL"]
			);
        }

        if(count($arResult["section_list"]))
        	$arResult["section_list"][intval($arRes["IBLOCK_SECTION_ID"])]["list"][$arRes["ID"]] = $arRes;

        if(intval($arRes["IBLOCK_SECTION_ID"]) && is_array($arSections[$arRes["IBLOCK_SECTION_ID"]]))
			$arRes["SECTION_DETAIL"] = $arSections[$arRes["IBLOCK_SECTION_ID"]];

        $arResult["list"][$arRes["ID"]] = $arRes;


    }
    $arResult['navResult'] = &$res;

    /*echo "<pre>";
    print_r($arResult);
    echo "</pre>";*/

    if(!count( $arResult["list"]))
    {
        $this->AbortResultCache();
        if(!$arParams['NOT_SHOW_ERRORS'])
            ShowError(GetMessage("IBLOCK_ELEMENT_LIST_NA"));

		CHTTP::SetStatus("404 Not Found");
		@define("ERROR_404","Y");
    }
    $this->IncludeComponentTemplate();

}

if(is_array($arParams["SCRIPTS"]) && count($arParams["SCRIPTS"]))
{
	foreach ($arParams["SCRIPTS"] as $v)
	{
		$GLOBALS['APPLICATION']->AddHeadScript($v);
	}
}

if(count($arResult["list"]))
{
	if($arParams['INCLUDE_SECTIONS_INTO_CHAIN'] && count($arResult["section_list"])==1)
	{
		foreach ($arResult["section_list"] as $sec)
		{
			$APPLICATION->SetTitle($sec["NAME"]);
			$APPLICATION->AddChainItem($sec['NAME']);
		}
	}
	if($USER->IsAuthorized())
	{
		if($GLOBALS["APPLICATION"]->GetShowIncludeAreas() && CModule::IncludeModule("iblock"))
			$this->AddIncludeAreaIcons(CIBlock::ShowPanel($arParams['IBLOCK_ID'], 0, 0, $arParams['IBLOCK_TYPE'], true));

		if($arParams["DISPLAY_PANEL"] && CModule::IncludeModule("iblock"))
			CIBlock::ShowPanel($arParams['IBLOCK_ID'], 0, 0, $arParams['IBLOCK_TYPE'], false, $this->GetName());
	}
	return $arResult;
}
?>