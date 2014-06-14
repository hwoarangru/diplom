$(function(){
	var curSliderPos = 0;
	var sliderWidth = 969;
	var fullcount = 0;
	$('.outlet_ex_slider_item').each(function(){
		fullcount++;
	});
	$('.outlet_ex_left_arrow').bind('click', function(){
		if(curSliderPos>0){
			curSliderPos--;
			var newPos = 0-(curSliderPos*sliderWidth);
			$('.outlet_ex_sliderTable').animate({'margin-left':newPos+'px'}, 300);
		}
	});
	$('.outlet_ex_right_arrow').bind('click', function(){
		if(curSliderPos<fullcount-1){
			curSliderPos++;
			var newPos = 0-(curSliderPos*sliderWidth);
			$('.outlet_ex_sliderTable').animate({'margin-left':newPos+'px'}, 300);
		}
	});
	$('.bk_outelt_ex').bind('click', function(){
		$('.outex_carHidden').val($(this).attr('data-car'));
		showForm($('.offer_hidden_box'));
		_gaq.push(['_trackEvent', 'Forms', 'sendOK', 'special']);
	});
	$('.callbackFormShow').bind('click', function(){
		showForm($('.callback_hidden_box'));
		_gaq.push(['_trackEvent', 'Forms', 'sendOK', 'Callback']);
		return false;
	});
	$('.whiteBgThief').live('click', function(){
		$('.whiteBgThief').remove();
		$('.callback_hidden_box, .offer_hidden_box').css('display','none');
		if($('.redirect_complete').hasClass('redirect_complete')){
			window.location = $('.redirect_complete').attr('data-url');
		}
	});
	$(document).scroll(function(){
		HeyHeyIHere();
	});
	searchActiveForms();
});
function showForm(formBox){
	$('body').prepend('<div class="whiteBgThief"></div>');
	$('.whiteBgThief').css({'opacity':0.5, 'height':$(document).height()});
	formBox.css({'opacity':0, 'display':'block'}).animate({'opacity':1},300);
	HeyHeyIHere();
}
function HeyHeyIHere(){
	var activePop = 0;
	$('.popScrolled').each(function(){
		if($(this).css('display')=='block'){
			activePop = $(this);
		}
	});
	if(activePop!==0){
		activePop.css({'top':($(document).scrollTop())+'px'});
	}
}
function searchActiveForms(){
	if($('.showMePls').hasClass('showMePls')){
		showForm($('.showMePls').parents('.popScrolled'));
	}
}