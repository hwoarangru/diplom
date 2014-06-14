<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<div id="cur_url" style="display: none;"><?=$arResult['CUR_DIR'] ?></div>
<div id="grey_bg"></div>
<div id="hidden_angry_promo">
	<div class="close_promo_box" style="position:absolute;"><img src="/bitrix/components/adv/adv_promo_popup/templates/.default/images/close.png" alt="" /></div>
	<a class="button1" id="banner_btn" href="#">
		<img class="big_img" src="<?=$arParams['IMAGE_PATH']?>" alt="" />	
	</a>
</div>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>  
<script type="text/javascript">
var HashInterval = null;
	$(function(){
		var dataObjDef = new Object;
		var Promo = '';

		ShowPromo();

		$('.big_img').load(function () {
			setMargin();
		});
		

		$('.close_promo_box').bind('click',function(){
			$('#grey_bg, #hidden_angry_promo').animate({opacity:0},300, function(){
				$('#grey_bg, #hidden_angry_promo').remove();
			});
			ClosePromo();
		});

		$('#grey_bg').click(function(){
			$('#grey_bg, #hidden_angry_promo').animate({opacity:0},300, function(){
				$('#grey_bg, #hidden_angry_promo').remove();
			});
			ClosePromo();
		});
		$('#banner_btn').click(function(){
			$.ajax({ 
				url: '/bitrix/components/adv/adv_promo_popup/close_btn.php',
				success: function() {
					location.href="<?=$arParams['URL_REDIRECT'];?>";
				}
			});
		});

	});
	function ShowPromo(){
		$('#grey_bg').delay(1000).css({
			'opacity':0,
			'display':'block'
			// 'height':$(document).height()
		}).animate({opacity:0.8},300,function(){

			var $hap = $('#hidden_angry_promo');
			var curtop = 150;

			left = (parseInt($(window).width())/2) - parseInt($('#hidden_angry_promo').width())/2;
			$hap.css({
				'opacity':0,
				'display':'block',
				'position':'fixed'
			}).animate({opacity:1},300); //'left':left+'px'
		});
	}
	function setMargin () {
		var $hap = $('#hidden_angry_promo');
		var mTop = -$hap.height()/2;
		var mLeft = -$hap.width()/2;

		$hap.css({
				'margin-top': mTop + 'px',
				'margin-left': mLeft + 'px'
			});
	}
	function ClosePromo(){
		$.ajax({ 
				url: '/bitrix/components/adv/adv_promo_popup/close_btn.php',
				success: function() {
					return true;
				}
			});
	}
</script>