$(document).ready(function () {
	setInterval("Counter();",1000);

$( ".bk_outelt_ex").click(function() {
	return false;
});

});

function Counter(){
	var now = new Date();
	var newYear = new Date($('#dateafter').text());
	var totalRemains = (newYear.getTime()-now.getTime());
	if (totalRemains>1){
		var RemainsSec=(parseInt(totalRemains/1000));
		var RemainsFullDays=(parseInt(RemainsSec/(24*60*60)));
		var secInLastDay=RemainsSec-RemainsFullDays*24*3600;
		var RemainsFullHours=(parseInt(secInLastDay/3600));
		var secInLastHour=secInLastDay-RemainsFullHours*3600;
		var RemainsMinutes=(parseInt(secInLastHour/60));
		var lastSec=secInLastHour-RemainsMinutes*60;
		document.getElementById('Cdays').innerHTML = RemainsFullDays+1;
		$('#Cdays').parent('span').find('font').text(declOfNum(RemainsFullDays, ['дня', 'дней', 'дней']));
		document.getElementById('Chours').innerHTML = RemainsFullHours;
		$('#Chours').parent('span').find('font').text(declOfNum(RemainsFullHours, ['часа', 'часов', 'часов']));
		document.getElementById('Cminutes').innerHTML = RemainsMinutes;
		$('#Cminutes').parent('span').find('font').text(declOfNum(RemainsMinutes, ['минуты', 'минут', 'минут']));
		document.getElementById('Cseconds').innerHTML = lastSec;					
		$('#Cseconds').parent('span').find('font').text(declOfNum(lastSec, ['секунды', 'секунд', 'секунд']));
	} 			
}

function declOfNum(number, titles)  {  
    cases = [2, 0, 1, 1, 1, 2];  
    return titles[ (number%100>4 && number%100<20)? 2 : cases[(number%10<5)?number%10:5] ];  
}  

