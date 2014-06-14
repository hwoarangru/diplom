<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
ћаксимально возможна€ стоимость автомобил€ составл€ет <b><?=$arResult["MAX_PRICE"]?></b> руб.<br />
- первый взнос: <b><?=$arResult["vznosProc"]?></b> руб;<br />
- ежемес€чный платеж: <b><?=$arResult["platProc"]?></b> руб;<br />
- срок кредита: <b><?=$arResult["srokProc"]?></b> мес.<br />

<?if(!isset($arResult["ITEM"][0]))
{?>
	<b>ћодели удовлетвор€щие данным расчета не найдены.</b>
<?}
else
{
	foreach($arResult["ITEM"] as $item)
	{?>
		<h3 style="padding:20px 0 0"><?=$item["NAME"]?></h3>
		<?foreach($item["ENGINE"] as $engine)
		{?>
			<div class="hiddenStandardTeaser2" style="padding:0 0 14px">
				<div style="width: 239px; height: 56px;" class="smallStandard">
					<a <?if($item["PROPERTY_BANK_URL_VALUE"]){?>href="<?=$item["PROPERTY_BANK_URL_VALUE"]?>" target="_blank"<?}?>><br>
						<?if($engine["PIC"]["src"])
						{?>
							<img style="border:1px solid #AFAFAF; float: left;" alt="" src="<?=$engine["PIC"]["src"]?>">
						<?}
						else
						{?>
							Ќет фото
						<?}?>
							<strong><?=$engine["NAME"]?></strong>
					</a><br>
					<span>—тоимость: <?=$engine["PROPERTY_PRICE_VALUE"]?> руб.</span>
				</div>
			</div>
		<?}
	}
}?>