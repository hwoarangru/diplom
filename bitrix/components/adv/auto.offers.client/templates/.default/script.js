$(function(){
	Counter();
	var CounterInterval = setInterval('Counter()', 30000);
	$('.button_silver').live('click', function(){
		var curObject = $(this).children('a');
		var ModelFilter = curObject.attr('data-model');
		if(ModelFilter!='all'){
			$('.outlet_car_box').hide();
			$('.carFilt_'+ModelFilter).show();
		}else{
			$('.outlet_car_box').show();
		}
		$('html, body').animate({scrollTop:$('.outlet_car_box:visible').offset().top}, 300, function(){});
		$('.button_silver').each(function(){
			if($(this).children('a').hasClass('active')){
				$(this).children('a').removeClass('active')
			}
		});
		curObject.addClass('active');
		return false;
	});
	$('.bk_outlet').click(function(){
		$('.outex_carHidden').val($(this).attr('data-car'));
		showForm($('.BOOKING_hidden_box'));
		goCarInfo($(this).parents('.outlet_table').attr('data-id'));
		return false;
	});
	$('.td_outlet').click(function(){
		$('.outex_carHidden').val($(this).attr('data-car'));
		showForm($('.TEST_DRIVE_hidden_box'));
		goCarInfo($(this).parents('.outlet_table').attr('data-id'));
		return false;
	});
	$('.cr_outlet').click(function(){
		$('.outex_carHidden').val($(this).attr('data-car'));
		showForm($('.CREDIT_hidden_box'));
		goCarInfo($(this).parents('.outlet_table').attr('data-id'));
		return false;
	});
	$('.detailLink').click(function(){
		$('.detail_outlet_car_box').hide();
		$('.outlet_table').show();
		var curBbox = $(this).parents('.outlet_car_box');
		$('html, body').animate({scrollTop:curBbox.offset().top}, 800, function()
		{
			curBbox.find('.outlet_table').hide();
			curBbox.find('.detail_outlet_car_box').slideDown();
		});
		return false;
	});
	$('.detailLinkclose').click(function(){
		$('.detail_outlet_car_box').hide();
		$('.outlet_table').show();
		var curBbox = $(this).parents('.outlet_car_box');
		curBbox.find('.outlet_table').show();
		curBbox.find('.detail_outlet_car_box').hide();
		return false;
	});
	$('.whiteBgThief').live('click', function(){
		$('.whiteBgThief').remove();
		$('.popScrolled').css('display','none');
		if($('.redirect_complete').hasClass('redirect_complete')){
			window.location = $('.redirect_complete').attr('data-url');
		}
	});
	$(document).scroll(function(){
		HeyHeyIHere();
	});
	$('.selectBDes').live('click', function(){
		var type = $(this).attr('data-type');
		var value = $(this).text();
		if($(this).hasClass('act')){
			$(this).removeClass('act');
		}else{
			$(this).addClass('act');
		}
		var linkData = '';
		$('.selectBDes[data-type="'+type+'"]').each(function(){
			if($(this).hasClass('act')){
				linkData += $(this).text()+' ';
			}
		});
		$('input[data-type="'+type+'"]').val(linkData);
		return false;
	});
	searchActiveForms();
});
function goCarInfo(carId){
	if(carId>0){
		$.cookie("lastCar", carId);
	}else{
		carId = $.cookie("lastCar");
	}
	var CarBox = $('#car_'+carId);
	$('.popCarImage').attr('src',CarBox.find('.image_box').children('img').attr('src'));
	$('.popCarName').text('BMW '+CarBox.find('.colormark').text());
	$('.hidden_car_input').val(CarBox.find('.car_desc_box').attr('data-carline'));
	$('.popCarPrice').text(CarBox.find('bprice').text());
	$('.popCarPriceOld').text(CarBox.find('price').text());
	
}
function Counter(){
	var now = new Date();
	var newYear = new Date($('#dateafter').text());
	var totalRemains = (newYear.getTime()-now.getTime());
	if (totalRemains>1){
		var RemainsSec=(parseInt(totalRemains/1000));
		var RemainsFullDays=(parseInt(RemainsSec/(24*60*60)));
		var secInLastDay=RemainsSec-RemainsFullDays*24*3600;
		var RemainsFullHours=(parseInt(secInLastDay/3600));
		if (RemainsFullHours<10){RemainsFullHours="0"+RemainsFullHours};
		var secInLastHour=secInLastDay-RemainsFullHours*3600;
		var RemainsMinutes=(parseInt(secInLastHour/60));
		if (RemainsMinutes<10){RemainsMinutes="0"+RemainsMinutes};
		var lastSec=secInLastHour-RemainsMinutes*60;
		if (lastSec<10){lastSec="0"+lastSec};
		$('.daySlice span').text(RemainsFullDays);
		$('.daySlice div').text(declOfNum(RemainsFullDays, ['День', 'Дня', 'Дней']));
		$('.hourSlice span').text(RemainsFullHours);
		$('.hourSlice div').text(declOfNum(RemainsFullHours, ['Час', 'Часа', 'Часов']));
		$('.minutsSlice span').text(RemainsMinutes);
		$('.minutsSlice div').text(declOfNum(RemainsMinutes, ['Минута', 'Минуты', 'Минут']));
		setTimeout("Counter()",1000);
	} 			
}
function declOfNum(number, titles)  {  
    cases = [2, 0, 1, 1, 1, 2];  
    return titles[ (number%100>4 && number%100<20)? 2 : cases[(number%10<5)?number%10:5] ];  
}
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
		goCarInfo(0);
	}
}