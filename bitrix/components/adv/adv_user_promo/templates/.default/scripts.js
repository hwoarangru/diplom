var HashInterval = null;
jQuery(function(){
	var dataObjDef = new Object;
	var Promo = '';
	var showFlag = false;
	if(jQuery.cookie('BITRIX_SM_SHOW_PROMO_HOL')=='Y')
	{
		showFlag = false;
	}else{
		showFlag = true;
	}
	HashInterval = setInterval('SearchHash()', 300);
	if(showFlag){
		ShowPromo();
	}
	jQuery('.close_promo_box').bind('click',function(){
		jQuery('#footer').css("position", "fixed");
		jQuery.ajax({ 
			url: '/bitrix/components/adv/adv_user_promo/close_btn.php',
			success: function() {
				jQuery('#grey_bg, #hidden_angry_promo').animate({opacity:0},300, function(){
					jQuery('#footer').css("position", "fixed");
					jQuery('#grey_bg, #hidden_angry_promo').remove();
					jQuery('#external').css({visibility: "visible"});
					//window.location = jQuery('#cur_url').html();
				});
				
			}
		});
	});
	jQuery('.onestep_button').live('click', function(){
		jQuery('.step_1').animate({opacity:0},300,function(){
			jQuery(this).css('display','none');
			jQuery('.step_2').css({'display':'block','opcaity':0}).animate({opacity:1},300);
			jQuery('#ind_bmw_pic').css('marginTop',(jQuery('#hidden_angry_promo').height()-510)).animate({opacity:1},300);
			jQuery('#grey_bg').height(jQuery(document).height());
			jQuery('#hidden_angry_promo').css('marginTop', '-'+jQuery('#hidden_angry_promo').height()/2+'px');
		});
		return false;
	});
	jQuery('.step_2 input').each(function(){
		dataObjDef[jQuery(this).attr('name')] = jQuery(this).val();
	});
	jQuery('.step_2 input').live('focus',function(){
		jQuery(this).css('color','black');
		if(dataObjDef[jQuery(this).attr('name')]==jQuery(this).val()){
			jQuery(this).val('');
		}
	}).live('blur', function(){
		if(jQuery(this).val()==''){
			jQuery(this).val(dataObjDef[jQuery(this).attr('name')]);
		}
	});
	jQuery('.print_btn_promo').live('click', function(){
		window.location = '/include/print_promo.php';
	});
	//Cufon.set('fontFamily', 'Futuris').replace('.newFont');
	jQuery('.promo_checkbox').live('click', function(){
		if(jQuery(this).hasClass('unchecked')){
			jQuery(this).attr('src','/bitrix/components/adv/adv_user_promo/templates/.default/images/checked.jpg').removeClass('unchecked');
		}else{
			jQuery(this).attr('src','/bitrix/components/adv/adv_user_promo/templates/.default/images/unchecked.jpg').addClass('unchecked');
		}
	});
	jQuery('.superbtn').live('click',function(){
		jQuery('.error_box').text("");
		var allOk = true;
		var Name = jQuery('input[name="u_fname"]').val();
		if((Name=="") || (Name=="Имя*")){
			jQuery('.nameEr').css('color','red');
			jQuery('.error_box').append("Вы не ввели имя.<br>");
			allOk = false;
		}
		var SurName = jQuery('input[name="u_lname"]').val();
		if((SurName=="") || (SurName=="Фамилия*")){
			jQuery('.surEr').css('color','red');
			jQuery('.error_box').append("Вы не ввели фамилию.<br>");
			allOk = false;
		}
		var Phone = jQuery('input[name="u_phone"]').val();
		if(!/^(?:\+\d{1,3}\s?)?(?:\(?\d{2,5}\)?\s?)?\d{1,3}(\s|-)?\d{1,3}(\s|-)?\d{1,3}$/.test(Phone)){
			jQuery('.phoneEr').css('color','red');
			jQuery('.error_box').append("Некорректный номер телефона.<br>");
			allOk = false;
		}
		var Email = jQuery('input[name="u_email"]').val();
		if(!/^\w+([\.-]?\w+)*@(((([a-z0-9]{2,})|([a-z0-9][-][a-z0-9]+))[\.][a-z0-9])|([a-z0-9]+[-]?))+[a-z0-9]+\.([a-z]{2}|(com|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|museum))$/.test(Email)){
			jQuery('.emailEr').css('color','red');
			jQuery('.error_box').append("Некорректный адрес электронной почты.<br>");
			allOk = false;
		}
		if(jQuery('.promo_checkbox').hasClass('unchecked')){
			jQuery('.error_box').append("Для участия необходимо согласие с правилами акции");
			allOk = false;
		}
		if(allOk){
			var data = '';
			jQuery('.form_div input').each(function(){
				if((jQuery(this).attr('name')=='u_mname') && (jQuery(this).val()=='Отчество'))
				{
					jQuery(this).val('');
				}
				data += jQuery(this).attr('name')+'='+jQuery(this).val()+'&';
			});
			jQuery.ajax({ 
				url: '/bitrix/components/adv/adv_user_promo/promo_answer.php',
				type: 'POST',
				data: data,
				success: function(data) {
					jQuery('.error_box').empty();
					if(data=='error 1'){
						jQuery('.err1').css('color','red');
						jQuery('.error_box').text("Вы забыли ввести ФИО");
					}else if(data=='error 2'){
						jQuery('.err2').css('color','red');
						jQuery('.error_box').text("Ошибка. Человек с таким email или номером телефона уже участвует.");
					}else{
						if(data.length=5){
							Promo = data;
							jQuery('.promocode').text(Promo);
							jQuery('.username').text(jQuery('input[name="u_fname"]').val());
							jQuery('.step_2').animate({opacity:0},300,function(){
								jQuery(this).css('display','none');
								jQuery('.step_3').css({'display':'block','opcaity':0}).animate({opacity:1},300);
								//Cufon.set('fontFamily', 'Futuris').replace('.step_3 .st3_title,.step_3 .print_box');
							});
						}
					}
					jQuery('#grey_bg').height(jQuery(document).height());
					jQuery('#hidden_angry_promo').css('marginTop', '-'+jQuery('#hidden_angry_promo').height()/2+'px');
				}
			});
		}
		return false;
	});
	
	jQuery(document).scroll(function () {
		jQuery('#grey_bg').height(jQuery(document).height());
	});
	
});
function SearchHash(){
	var hash = window.location.hash;
	if(hash.substring(1)=='promo1'){
		clearInterval(HashInterval);
		ShowPromo();
	}
}
function ShowPromo(){
	jQuery('#grey_bg').css({'opacity':0,'display':'block'}).animate({opacity:0.8},300,function(){
		jQuery('#grey_bg').height(jQuery(document).height());
		jQuery('#external').css({visibility: "hidden"});
		jQuery('#hidden_angry_promo').css({'opacity':0,'display':'block','margin-left':'-'+jQuery('#hidden_angry_promo').width()/2+'px','margin-top':'-'+jQuery('#hidden_angry_promo').height()/2+'px'}).animate({opacity:1},300);
		//Cufon.set('fontFamily', 'Futuris').replace('.ab_bottom_right_text');
		jQuery('#footer').css("position", "static");
	});
}