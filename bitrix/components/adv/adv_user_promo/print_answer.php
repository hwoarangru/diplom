<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
global $DB;
$sqlStr = "SELECT `PICTURE` FROM `adv_action` WHERE `ACTIVE_TO` >= curdate() AND `ACTIVE_FROM` <= curdate() AND `ACTIVE` = 'Y'";
$dbAction = $DB->Query($sqlStr);// 
if($arAction= $dbAction->Fetch())
{
	$rsFile = CFile::GetByID($arAction["PICTURE"]);
	$arAction["PICTURE_PROP"] = $rsFile->Fetch();
	$arAction["PICTURE"] = CFile::GetPath($arAction["PICTURE"]);?>
	<html>
		<body style="padding:0px;margin:0px;">
		<div style="width:<?=$arAction['PICTURE_PROP']['WIDTH']?>px;margin:0px auto;margin-top:10px;">
			<img src="<?=$arAction["PICTURE"]?>" alt="" /><br />
			<div style="font-size:17px;">
			<p>
			  <strong><b>При предъявлении данного купона Вы получаете гарантированный подарок от нашего салона.</b></strong></p>
			</div>
		</div>
		<div style="border-bottom:2px dashed black;margin:0px auto;width:<?=$arAction['PICTURE_PROP']['WIDTH']?>px">
			<table width="100%" align="center">
				<tr>
					<!--td width="167px" valign="top"><img src="/bitrix/components/adv/adv_user_promo/templates/.default/images/left_bottom_print_star.jpg" style="margin-top:90px;" alt="" /></td-->
					<td valign="top" style="color:#0168B5;">
						<center style="font-family:'arial';margin-bottom:25px;">
							<div style="font-size:28px;font-weight:bold;">Промо код: <?=$_COOKIE['BITRIX_SM_USER_PROMO'];?></div>
							<div style="font-size:18px;">Обладатель: <?=$_SESSION['USER_PROMO']['u_lname'];?> <?=$_SESSION['USER_PROMO']['u_fname'];?>, <?=$_SESSION['USER_PROMO']['u_phone'];?></div>
						</center>
					</td>
					<!--td width="184px"><img src="/bitrix/components/adv/adv_user_promo/templates/.default/images/right_bottom_print_star.jpg" alt="" /></td-->
				</tr>
			</table>
		</div>
		<div style="margin-left:75%"><img src="/bitrix/components/adv/adv_user_promo/templates/.default/images/print_crop.jpg" alt="" /></div>
		</body>
	</html>
	<script type="text/javascript">
	window.onload = PrintLoad();
	function PrintLoad(){
	window.print();
	setTimeout("window.location = '/'",1000);
	}
	</script>
	<?$APPLICATION->set_cookie("SHOW_PROMO_HOL", 'Y', time()+60*60*24*7);
}?>