<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
/*echo "<pre>";
print_r($arResult['list']);
echo "</pre>";*/
?>
<?if (count($arResult['list'])>0):?>
<div>
<?foreach ($arResult['list'] as $item):?>
        <?if (strlen($item['DETAIL_TEXT'])>0):?>
            <a href="<?=$item['DETAIL_PAGE_URL']?>"><?=$item['DISPLAY_DATE_CREATE']?>:&nbsp;<?=$item['NAME']?></a>
        <?else:?>
            <?=$item['DISPLAY_ACTIVE_FROM']?>:&nbsp;<?=$item['NAME']?>
        <?endif;?>
        <?=ShowImage($item['DETAIL_PICTURE'])?>
        <p><?=$item['PREVIEW_TEXT']?></p>
<?endforeach;?>
</div>
<?
$arResult["navResult"]->nPageWindow=5;
$APPLICATION->IncludeComponent("bitrix:system.pagenavigation", "",array('NAV_RESULT'=> $arResult["navResult"]),false,array("HIDE_ICONS"=>"Y"));
?>
<?endif;?>