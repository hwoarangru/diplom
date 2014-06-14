<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
/*echo "<pre>";
print_r($arResult);
echo "</pre>";*/
$newResult=array();
foreach ($arResult as $item)
{
	$newResult[$item["DEPTH_LEVEL"]][]=$item;
}
ksort($newResult);
$arResult=$newResult;
/*echo "<pre>";
print_r($arResult);
echo "</pre>";*/
?>
<style>
	ul.subitem{
		display: block !important;
		padding-top:10px;
	}
</style>
<?if (!empty($arResult)):?>

<style>
#completeText {
	left: <?=(strstr($APPLICATION->GetCurDir(),'/cabinet/') || strstr($APPLICATION->GetCurDir(),'/news/') ? '210px':'240px')?>;
	width:730px;
}
</style>
<div id='naviClipArea'>
	<div id='buttonClose2'>
		<a class="droplink" href="#" onclick='jQuery("#navigation").slideToggle("fast");jQuery("#buttonClose2").hide();return false;'>
<!--			<img height="16" alt="" src="/images/dropper.gif" width="221" /> -->
		</a>
	</div>
	<div id='navigation' style="padding-top:0px;">
		<ul>
			<?$current_level = key($arResult);?>
			<?foreach($arResult[$current_level] as $arItem):
				$target = '';
				if($arItem["PARAMS"]["BLANK"]=="Y")
				{
					$target = 'target="_blank"';
				}?>
				<li><a href="<?=$arItem["LINK"]?>" <?=$target?> class="<?=$arItem["SELECTED"]?'selected':''?>"><?=$arItem["TEXT"]?></a>
				<?if($arItem["SELECTED"] && count($arResult[$current_level+1])):?>
						<ul class="subitem">
							<?foreach($arResult[$current_level+1] as $arItem):
								$target = '';
								if($arItem["PARAMS"]["BLANK"]=="Y")
								{
									$target = 'target="_blank"';
								}?>
								<li><a href="<?=$arItem["LINK"]?>" <?=$target?> class="<?=$arItem["SELECTED"]?'selected':''?>"><?=$arItem["TEXT"]?></a>
								<?if($arItem["SELECTED"] && count($arResult[$current_level+2])):?>
									<ul class="subitem">
										<?foreach($arResult[$current_level+2] as $arItem):
											$target = '';
											if($arItem["PARAMS"]["BLANK"]=="Y")
											{
												$target = 'target="_blank"';
											}?>
											<li><a href="<?=$arItem["LINK"]?>" <?=$target?> class="<?=$arItem["SELECTED"]?'selected':''?>"><?=$arItem["TEXT"]?></a>
											<?if($arItem["SELECTED"] && count($arResult[$current_level+3])):?>
												<ul class="subitem">
													<?foreach($arResult[$current_level+3] as $arItem):
														$target = '';
														if($arItem["PARAMS"]["BLANK"]=="Y")
														{
															$target = 'target="_blank"';
														}?>
														<li><a href="<?=$arItem["LINK"]?>" <?=$target?> class="<?=$arItem["SELECTED"]?'selected':''?>"><?=$arItem["TEXT"]?></a>
															<?if($arItem["SELECTED"] && count($arResult[$current_level+4])):?>
																<ul class="subitem">
																	<?foreach($arResult[$current_level+4] as $arItem):
																		$target = '';
																		if($arItem["PARAMS"]["BLANK"]=="Y")
																		{
																			$target = 'target="_blank"';
																		}?>
																		<li><a href="<?=$arItem["LINK"]?>" <?=$target?> class="<?=$arItem["SELECTED"]?'selected':''?>"><?=$arItem["TEXT"]?></a></li>
																	<?endforeach;?>
																</ul>
															</li>
														<?else:?>
															</li>
														<?endif;?>
													<?endforeach;?>
												</ul>
												</li>
											<?else:?>
												</li>
											<?endif;?>
										<?endforeach;?>
									</ul>
									</li>
								<?else:?>
									</li>
								<?endif;?>
							<?endforeach;?>
						</ul>
					</li>
				<?else:?>
					</li>
				<?endif;?>
			<?endforeach;?>
		</ul>
		<div id='buttonClose'>
			<a class="droplink" href="#" onclick='jQuery("#navigation").slideToggle("fast");jQuery("#buttonClose2").show();return false;'>
<!--				<img height="16" alt="" src="/images/dropper.gif" width="221" /> -->
			</a>
		</div>
	</div>
</div>
<script type="text/javascript">
jQuery(document).ready(function() {
	jQuery("#navigation li .selected").parent().parent().css("display", "block");
	<?if (ereg('/owners/partners/about/advantage/', $_SERVER['REQUEST_URI'])):?>
	jQuery("#navigation").slideDown("fast");jQuery("#buttonClose2").hide();
	<?endif?>
});
</script>
<?endif;?>