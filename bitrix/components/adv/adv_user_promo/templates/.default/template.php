<?//if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
global $APPLICATION;?>
<div id="cur_url" style="display: none;"><?=$APPLICATION->GetCurDir()?></div>
<div id="grey_bg"></div>
<div id="hidden_angry_promo" style="width: <?=$arResult['PICTURE_PROP']['WIDTH']?>px">
	<div class="close_promo_box"><img src="/bitrix/components/adv/adv_user_promo/templates/.default/images/close.png" alt="" /></div>
	<div class="step_1" style="background:url(<?=$arResult['PICTURE']?>) no-repeat;margin-top:-23px;">		
		<div class="ab_bottom_right_text" style="padding-top: <?=($arResult['PICTURE_PROP']['HEIGHT']+5)?>px;">
			<?=$arResult['PREVIEW_TEXT']?>
		</div>
		<a href="#" class="onestep_button" style="position: absolute;"></a>
		<img src="/images/bmw-0s.jpg" style="float: right;">
	</div>
	<div class="step_2" style="background:url(<?=$arResult['PICTURE']?>) no-repeat;margin-top:-23px;">	
		<div>
			<form method="POST" class="superform" style="padding-top: <?=($arResult['PICTURE_PROP']['HEIGHT']-60)?>px;">
			<div class="form_div">
				<input type="hidden" name="action_id" value="<?=$arResult['ID']?>">
				<input type="text" name="u_lname" class="err1 surEr" MAXLENGTH="30" value="Фамилия*" />
				<input type="text" name="u_fname" class="err1 nameEr" MAXLENGTH="15" value="Имя*" /><br />
				<input type="text" name="u_mname" class="err1 otchEr" MAXLENGTH="15" value="Отчество" />
			<div class="newFont"><img src="/bitrix/components/adv/adv_user_promo/templates/.default/images/checked.jpg" class="promo_checkbox" alt="" /> Я согласен с <a href="/include/terms.php" target="_blank" class="nocufon">правилами акции</a>.</div>
			<img src="/bitrix/components/adv/adv_user_promo/templates/.default/images/send_btn.jpg" style="cursor:pointer; margin-bottom: 10px;" class="superbtn" alt="" />
			</div>
			<div class="form_div">
				<input type="text" name="u_phone" class="err2 phoneEr" MAXLENGTH="20" value="Телефон* +7(___) ___-__-__" /><br />
				<input type="text" name="u_email" class="err2 emailEr" MAXLENGTH="50" value="E-mail" /><br />
				<div class="error_box"></div>
			</div>
			<br/>
			<input type="hidden" name="go" value="Отправить" />
			</form>
		</div>
		<div id="ind_bmw_pic" style="float: right;">
			<img src="/images/bmw-0s.jpg">
		</div>
	</div>
	<div class="step_3" style="background:url(<?=$arResult['PICTURE']?>) no-repeat;margin-top:-23px;height: <?=($arResult['PICTURE_PROP']['HEIGHT']+215)?>px">
		<div class="st3_title" style="margin-top: <?=($arResult['PICTURE_PROP']['HEIGHT']+5)?>px;margin-left: 23px;"><span class="username"></span>, ваш промокод:<br /><b class="promocode">LJ56S</b></div>
		<?=$arResult['DETAIL_TEXT']?>
		<div class="print_box" style="margin-left: 23px;margin-top: <?=($arResult['PICTURE_PROP']['HEIGHT']+115)?>px">
			<img src="/bitrix/components/adv/adv_user_promo/templates/.default/images/print_btn.png" class="print_btn_promo" align="left" alt="" />
			<b>Чтобы участвовать в розыгрыше призов,<br />опустите этот купон в лотерейную урну</b>
		</div>
		<div id="ind_bmw_pic" style="float: right;margin-top: <?=($arResult['PICTURE_PROP']['HEIGHT']+115)?>px">
			<img src="/images/bmw-0s.jpg">
		</div>
	</div>
</div>
<?$APPLICATION->AddHeadScript('/bitrix/components/adv/adv_user_promo/templates/.default/jquery.cookie.js');
$APPLICATION->AddHeadScript('/bitrix/components/adv/adv_user_promo/templates/.default/scripts.js');?>