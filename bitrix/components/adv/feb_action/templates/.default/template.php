<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$x = strtotime($arParams['DEADLINE']);
$y = time();
$time = $x - $y;
$date = list($days,$hours,$minutes,$seconds) = explode(':',date('d:h:m:s', $time));
?>
		<div class="b-count">
		<p style="margin-bottom: 0.0001pt; text-align: justify;" class="MsoNormal">ƒо конца феврал€ осталось <br><span><span id="Cdays"><?=$days?></span> <font>дней</font></span> <span><span id="Chours"><?=$hours?></span> <font>часов</font></span> <span><span id="Cminutes"><?=$minutes?></span> <font>минут</font></span> <span><span id="Cseconds"><?=$seconds?></span> <font>секунд</font></span></p>
		<div id="dateafter" style="display:none;"><?=date('M,d,Y,H:i:s', $x);?></div>
		</div>
		
</div>


		