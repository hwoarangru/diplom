<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
?>
<pre><?//print_r($arResult);?>
</pre>
<div id="stage">
	<div id="mediaGalleryLightboxLayer">
		<div id="blackLayer"></div>
		<div id="lightbox">
			<div class="closeButtonLayer">
				<a href="#" class="closeLink" onfocus="this.blur();"><img src="images/1x1_trans.gif" width="15" height="15" border="0"/></a>
			</div>
			<img id="bigImage" src="images/1x1_trans.gif" width="612" height="383" border="0" />
			<div id="textLayer" style="display: block;"></div>
		</div>
	</div>
	<div id="background" style="clip:rect(0px 1024px 634px 0px);">
		<img src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" alt="">
	</div>
	<div id="overlay">
		<img src="" alt="">
	</div>
    
	<div id="overlayborder">
		<div id="corners" style="position: relative;height:100%;width:100%;">
			<img src="images/corner_topleft.png" alt="" style="position:absolute;top:0;left:0;">
			<img src="images/corner_topright.png" alt="" style="position:absolute;top:0;right:0;">
			<img src="images/corner_bottomleft.png" alt="" style="position:absolute;bottom:0;left:0;">
			<img src="images/corner_bottomright.png" alt="" style="position:absolute;bottom:0;right:0;">
		</div>
	</div>
	<div id="content">
		<div id="highlights_accordion">
			<h3 class="joy_small" style="color:#ffffff;">Отличительные особенности продукта - <br><?=$arResult["NAME"]?></h3>
			<div id="highlight_overview">
			<?foreach ($arResult["ACC_SECTIONS"] as $key=>$value):?>
				<div id="<?=$key;?>" class="highlight">
					<div class="title" background-img="<?$w_name = $value["CODE"].'_white';if (CFile::GetPath($arResult["PROPERTIES"][$w_name]["VALUE"])) {echo (CFile::GetPath($arResult["PROPERTIES"][$w_name]["VALUE"]));}?>" background-img-dark="<?$d_name = $value["CODE"].'_dark';if (CFile::GetPath($arResult["PROPERTIES"][$d_name]["VALUE"])) {echo (CFile::GetPath($arResult["PROPERTIES"][$d_name]["VALUE"]));}?>">
						<h1><?=$value["NAME"];?></h1>
					</div>
					<div class="products" style="display: none;">
						<?foreach ($value["ITEMS"] as $el_key=>$el_value):?>
							<div class="productimage">
								<?$arCoord = array();if (strlen($el_value["PROPERTIES"]["coord"]["VALUE"]) > 0) $arCoord = explode('#',$el_value["PROPERTIES"]["coord"]["VALUE"]);?>
								<a href="" class="detaillink" background-img="<?$w_name = $el_value["PROPERTIES"]["big_pic"]["VALUE"].'_white';if (CFile::GetPath($arResult["PROPERTIES"][$w_name]["VALUE"])) {echo (CFile::GetPath($arResult["PROPERTIES"][$w_name]["VALUE"]));}?>" background-img-dark="<?$d_name = $el_value["PROPERTIES"]["big_pic"]["VALUE"].'_dark';if (CFile::GetPath($arResult["PROPERTIES"][$d_name]["VALUE"])) {echo (CFile::GetPath($arResult["PROPERTIES"][$d_name]["VALUE"]));}?>" id="<?=$key?>_<?=$el_key?>" pos1="<?=$arCoord[1]?>" pos2="<?=$arCoord[2]?>" pos3="<?=$arCoord[3]?>" pos4="<?=$arCoord[4]?>">
								<span class="blend semitransparent"></span>
								<img src="<?=$el_value["PREVIEW_PICTURE"]["SRC"]?>" width="86px" height="48px" alt="<?=$el_value["NAME"]?>" title="<?=$el_value["NAME"]?>" />
								</a>
							</div>
						<?endforeach;?>
						<div class="clearFloat"></div>
					</div>
				</div>
			<?endforeach;?>
			</div>
			<div id="highlight_details">
				<div id="closeButtonLayer">
					<a href="#" class="closeLink" id="close_details" onfocus="this.blur();"><img src="images/1x1_trans.gif" width="15" height="15" border="0" /></a>
				</div>
				<?foreach ($arResult["ACC_SECTIONS"] as $key=>$value):?>
					<div id="details_<?=$key;?>" class="product_details">
						<?foreach ($value["ITEMS"] as $el_key=>$el_value):?>
							<?$arCoord = array();if (strlen($el_value["PROPERTIES"]["coord"]["VALUE"]) > 0) $arCoord = explode('#',$el_value["PROPERTIES"]["coord"]["VALUE"]);?>
							<div id="details_<?=$key?>_<?=$el_key?>" background-img="<?$w_name = $el_value["PROPERTIES"]["big_pic"]["VALUE"].'_white';if (CFile::GetPath($arResult["PROPERTIES"][$w_name]["VALUE"])) {echo (CFile::GetPath($arResult["PROPERTIES"][$w_name]["VALUE"]));}?>" background-img-dark="<?$d_name = $el_value["PROPERTIES"]["big_pic"]["VALUE"].'_dark';if (CFile::GetPath($arResult["PROPERTIES"][$d_name]["VALUE"])) {echo (CFile::GetPath($arResult["PROPERTIES"][$d_name]["VALUE"]));}?>" class="product_detail" pos1="<?=$arCoord[1]?>" pos2="<?=$arCoord[2]?>" pos3="<?=$arCoord[3]?>" pos4="<?=$arCoord[4]?>">
								<div class="teaser_image">
									<?foreach ($el_value["PROPERTIES"]["more_imgs"]["VALUE"] as $im_key=>$im_value):?>
									<div class="product_detail_image" preloadflash="" preload="<?=$el_value["PROPERTIES"]["more_imgs_sm"]["VALUE"][$im_key]["SRC"]?>" preloadlarge="<?=$im_value["SRC"];?>"><div id="details_<?=$key?>_<?=$el_key?>_product_detail_image_<?=$im_key?>"></div></div>
									<?endforeach;?>
									<div class="teaser_image_icon">
										<a class="vehicle_navigation_teaser_button" href=""></a>
										<span class="teaser_image_icon_counter">1/2</span>
									</div>
								</div>
								<div class="product_text">
									<h3><?=$el_value["NAME"]?></h3>
									<?=$el_value["PREVIEW_TEXT"]?>
								</div>
							</div>
						<?endforeach;?>
					</div>
				<?endforeach;?>
			</div>
		</div>
	</div>
	<img class="lightboxArrowRight rightWhiteArrow" id="next_details" width="20" height="48" border="0" src="images/1x1_trans.gif" />
	<img class="lightboxArrowLeft leftWhiteArrow" id="prev_details" width="20" height="48" border="0" src="images/1x1_trans.gif" />
</div>
<img src="images/powered_by_M.png" width="163" height="28" id="mlogo" />
<a href="index.php"  id="highlightCloseButton">Закрыть</a>
<div id="vehicle_navigation">
	<ul>
	</ul>
        <div id="teaser">
        </div>
        <script type="text/javascript">
          var vehicle_navigation_teaser_db = new Array();
        </script>
</div>
