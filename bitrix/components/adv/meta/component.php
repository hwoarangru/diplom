<?
	CModule::IncludeModule("iblock");
	$page=$APPLICATION->GetCurPage();
	if (substr($page,strlen($page)-1,1)!="/") $page.="/";
	$dbMeta=CIblockElement::GetList(array(),array("IBLOCK_ID"=>$arParams["IBLOCK_ID"],"IBLOCK_TYPE"=>$arParams["IBLOCK_TYPE"],"NAME"=>$page),false,false,array("ID","NAME","PROPERTY_title","PROPERTY_keywords","PROPERTY_description","PROPERTY_footer"));
	if ($arMeta=$dbMeta->GetNext()) {
		if ($arMeta["PROPERTY_TITLE_VALUE"]) $APPLICATION->SetPageProperty("long_title",$arMeta["PROPERTY_TITLE_VALUE"]);
		if ($arMeta["PROPERTY_KEYWORDS_VALUE"]) $APPLICATION->SetPageProperty("keywords",$arMeta["PROPERTY_KEYWORDS_VALUE"]);
		if ($arMeta["PROPERTY_DESCRIPTION_VALUE"]) $APPLICATION->SetPageProperty("description",$arMeta["PROPERTY_DESCRIPTION_VALUE"]);
		/* if ($arMeta["PROPERTY_FOOTER_VALUE"]["TEXT"]) {
			$APPLICATION->SetPageProperty("footer_text","<div id='metaText'><br clear='all' /><div style='padding-top:30px;'>&nbsp;</div>".$arMeta["~PROPERTY_FOOTER_VALUE"]["TEXT"].'</div><style>
			#metaText h2, strong, h1 {
			    display: inline;
			    font-weight: normal;
			}
			#metaText h1 {
				padding-bottom:15px;
			}
			</style>');
		}*/
		
	}

?>