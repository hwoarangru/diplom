<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
/*echo "<pre>";
print_r($arResult['list']);
echo "</pre>";*/
?>
<?if (count($arResult['section_list'])>0):?>
<?foreach ($arResult['section_list'] as $sec):?>
    	<dl>
    		<dt class="mgreengrey">
				<strong><a href="<?=$sec['SECTION_PAGE_URL']?>" style="color:white;"><?=$sec['NAME']?></a></strong>
			</dt>
			<dd class="lgreengrey">
		    	<ul class="triangles">
		    	<?foreach ($sec['list'] as $item):?>
			    	<li>
	  		          	<?if(intval($item['PREVIEW_PICTURE']))
					    	echo SmallFromLargeImage($item['PREVIEW_PICTURE'],159, 71, "style='float:right;'");
				    	elseif(intval($item['DETAIL_PICTURE_URL']))
				        	echo SmallFromLargeImage($item['DETAIL_PICTURE'], 159, 71, "style='float:right;'");?>
				        <?if (strlen($item['DETAIL_TEXT'])>0):?>
				            <a href="<?=$item['DETAIL_PAGE_URL']?>"><?=$item['DISPLAY_DATE_CREATE']?>:&nbsp;<?=$item['NAME']?></a>
				        <?else:?>
				            <?=$item['DISPLAY_DATE_CREATE']?>:&nbsp;<?=$item['NAME']?>
				        <?endif;?>
				        <div class="content"><?=$item['PREVIEW_TEXT']?></div>
				    	<?if (strlen($item['DISPLAY_ACTIVE_FROM']) && strlen($item['DISPLAY_ACTIVE_TO'])):?>
						<p>Проводится с <?=$item['DISPLAY_ACTIVE_FROM']?> по <?=$item['DISPLAY_ACTIVE_TO']?></p>
				    	<?endif?>
		        	</li>
		        <?endforeach;?>
		        </ul>
			</dd>
        </dl>
<?endforeach;?>
<?
$APPLICATION->IncludeComponent("bitrix:system.pagenavigation", "", array('NAV_RESULT'=> $arResult["navResult"]));
endif;
?>