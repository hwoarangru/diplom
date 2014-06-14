<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "БМВ Независимость - официальный дилер BMW в России. Мы осуществляем продажу и сервисное обслуживание всего модельного ряда  автомобилей BMW 1, 3, 5, 6, 7, x, z4, M, Hybrid серии. Предлагаем купить БМВ в кредит или купить BMW с пробегом.");
$APPLICATION->SetPageProperty("keywords", "bmw бмв купить продажа автомобили автосалон официальный дилер");
$APPLICATION->SetPageProperty("alt_image", "Автомобили BMW, автосалон BMW, официальный дилер BMW");
$APPLICATION->SetPageProperty("title", "BMW Независимость - официальный дилер БМВ | Купить автомобили BMW в автосалоне официального дилера в Москве: продажа БМВ, сервисное обслуживание автомобилей BMW");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");
$APPLICATION->SetTitle("BMW Независимость - официальный дилер БМВ | Купить автомобили BMW в автосалоне официального дилера в Москве: продажа БМВ, сервисное обслуживание автомобилей BMW");

?><script type="text/javascript">
var mTeaserCurrent = 0;

jQuery(document).ready(function(){
	var mTeaserCount = jQuery("#mainTeaser .hiddenLargeTeaser").length;
	
	// jQuery("#mainTeaserPreloader").css("visibility", "visible");
	
	if (mTeaserCount>1)
		jQuery("#mainTeaserContinueLink").css("visibility", "visible");
	else
		jQuery("#mainTeaserContinueLink").css("visibility", "hidden");
	
	jQuery("#skipMainTeaserButton").click(function(){
		jQuery("#mainTeaser .hiddenLargeTeaser").hide().filter(":eq("+mTeaserCurrent+")").show();
		
		if (mTeaserCurrent<(mTeaserCount-1))
			mTeaserCurrent++;
		else
			mTeaserCurrent=0;
			
	}).click();
   
	jQuery("#show-other-items").click(function(){
		var i=1;
		jQuery('#standardRightContainer').find('.hiddenStandardTeaser').each(function(){		
			if(i<=3 && jQuery(this).css('display') == "block") {				
				i++;
				jQuery(this).css('display', 'none');
			} else if(i>=3 && i<=6) {
				i++;
				jQuery(this).css('display', 'block');
			}
		});
		/*if ((jQuery("#second-news-col .item-active").length>0) && (jQuery("#second-news-col .item-active").next(".item-hidden").length>0)) {
			jQuery("#second-news-col .item-active").removeClass("item-active").addClass("item-hidden").hide().next(".item-hidden").filter(":eq(0)").removeClass("item-hidden").addClass("item-active").show();
		}
		else {
			jQuery("#second-news-col .item-active").removeClass("item-active").addClass("item-hidden").hide();
			jQuery("#second-news-col .item-hidden:first").removeClass("item-hidden").addClass("item-active").show();
		}
		return false;*/
	});
   
	jQuery("#show-other-news").click(function(){
		var i=1;
		jQuery('#standardLeftTeaserContainer').find('.hiddenStandardTeaser').each(function(){		
			if(i<=3 && jQuery(this).css('display') == "block") {				
				i++;
				jQuery(this).css('display', 'none');
			} else if(i>=3 && i<=6) {
				i++;
				jQuery(this).css('display', 'block');
			}
		});
		return false;
	});

});
</script>

<noindex>
<div id="standardLeftTeaserContainer">
	<span id="vSpace" style="height:3px;"></span>
<?$APPLICATION->IncludeComponent("bitrix:news.list", "index_news", array(
	"IBLOCK_TYPE" => "news",
	"IBLOCK_ID" => "203",
	"NEWS_COUNT" => "",
	"SORT_BY1" => "ACTIVE_FROM",
	"SORT_ORDER1" => "DESC",
	"SORT_BY2" => "SORT",
	"SORT_ORDER2" => "ASC",
	"FILTER_NAME" => "",
	"FIELD_CODE" => array(
		0 => "",
		1 => "",
	),
	"PROPERTY_CODE" => array(
		0 => "",
		1 => "",
	),
	"CHECK_DATES" => "Y",
	"DETAIL_URL" => "",
	"AJAX_MODE" => "N",
	"AJAX_OPTION_JUMP" => "N",
	"AJAX_OPTION_STYLE" => "Y",
	"AJAX_OPTION_HISTORY" => "N",
	"CACHE_TYPE" => "N",
	"CACHE_TIME" => "3600",
	"CACHE_FILTER" => "N",
	"CACHE_GROUPS" => "Y",
	"PREVIEW_TRUNCATE_LEN" => "",
	"ACTIVE_DATE_FORMAT" => "d.m.Y",
	"SET_TITLE" => "N",
	"SET_STATUS_404" => "N",
	"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
	"ADD_SECTIONS_CHAIN" => "N",
	"HIDE_LINK_WHEN_NO_DETAIL" => "N",
	"PARENT_SECTION" => "1251",
	"PARENT_SECTION_CODE" => "",
	"DISPLAY_TOP_PAGER" => "N",
	"DISPLAY_BOTTOM_PAGER" => "N",
	"PAGER_TITLE" => "Новости",
	"PAGER_SHOW_ALWAYS" => "N",
	"PAGER_TEMPLATE" => "",
	"PAGER_DESC_NUMBERING" => "N",
	"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
	"PAGER_SHOW_ALL" => "Y",
	"DISPLAY_DATE" => "N",
	"DISPLAY_NAME" => "Y",
	"DISPLAY_PICTURE" => "Y",
	"DISPLAY_PREVIEW_TEXT" => "N",
	"AJAX_OPTION_ADDITIONAL" => ""
	),
	false
);?>
</div>
</noindex>

<div id="standardLeftTeaserContinueLinks">
    <div style="visibility: visible;" id="standardLeftTeaserContinueLinkMulti"><a href="javascript://" id="show-other-news"><img src="images/1x1_trans.gif" alt="" class="arrow">Еще новости</a></div>
    <div style="position: relative; top: 16px;"><a href="/news/"><img src="images/1x1_trans.gif" alt="" class="arrow">Архив новостей</a><br><br><br><br></div>
</div>
<div id="standardRightContinueLinks">
    <div style="visibility: visible;" id="standardRightContinueLinkMulti"><a href="javascript://" id="show-other-items"><img src="images/1x1_trans.gif" alt="" class="arrow">Другие предложения</a></div>
    <div id="standardRightContinueLinkSingle"><a href="javascript://" onclick="changeTeaser('standardRight');"><img src="images/1x1_trans.gif" alt="" class="arrow">Next topic</a></div>
</div>



<noindex>
<div id="standardRightContainer">
<?$APPLICATION->IncludeComponent("bitrix:news.list", "index_news", array(
	"IBLOCK_TYPE" => "news",
	"IBLOCK_ID" => "203",
	"NEWS_COUNT" => "",
	"SORT_BY1" => "ACTIVE_FROM",
	"SORT_ORDER1" => "DESC",
	"SORT_BY2" => "SORT",
	"SORT_ORDER2" => "ASC",
	"FILTER_NAME" => "",
	"FIELD_CODE" => array(
		0 => "",
		1 => "",
	),
	"PROPERTY_CODE" => array(
		0 => "",
		1 => "",
	),
	"CHECK_DATES" => "Y",
	"DETAIL_URL" => "/owners/special_offer/auto/#ELEMENT_ID#/",
	"AJAX_MODE" => "N",
	"AJAX_OPTION_JUMP" => "N",
	"AJAX_OPTION_STYLE" => "Y",
	"AJAX_OPTION_HISTORY" => "N",
	"CACHE_TYPE" => "N",
	"CACHE_TIME" => "3600",
	"CACHE_FILTER" => "N",
	"CACHE_GROUPS" => "Y",
	"PREVIEW_TRUNCATE_LEN" => "",
	"ACTIVE_DATE_FORMAT" => "d.m.Y",
	"SET_TITLE" => "N",
	"SET_STATUS_404" => "N",
	"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
	"ADD_SECTIONS_CHAIN" => "N",
	"HIDE_LINK_WHEN_NO_DETAIL" => "N",
	"PARENT_SECTION" => "3105",
	"PARENT_SECTION_CODE" => "",
	"INCLUDE_SUBSECTIONS" => "Y",
	"DISPLAY_TOP_PAGER" => "N",
	"DISPLAY_BOTTOM_PAGER" => "N",
	"PAGER_TITLE" => "Новости",
	"PAGER_SHOW_ALWAYS" => "N",
	"PAGER_TEMPLATE" => "",
	"PAGER_DESC_NUMBERING" => "N",
	"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
	"PAGER_SHOW_ALL" => "Y",
	"DISPLAY_DATE" => "N",
	"DISPLAY_NAME" => "Y",
	"DISPLAY_PICTURE" => "Y",
	"DISPLAY_PREVIEW_TEXT" => "N",
	"AJAX_OPTION_ADDITIONAL" => ""
	),
	false
);?>

</div>
</noindex>


<noindex>
<?
 $APPLICATION->IncludeFile(
		"/bitrix/templates/bmw_index_redesign/include_areas/quicklinks.inc.php",
		Array(),
		Array("MODE"=>"php")
);
?>
</noindex>
 

<div class="likesBar">
	<div class="likeBtn">		
		<div class="fb-like" data-href="https://www.facebook.com/BMW.indep" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
	</div>
</div>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>