<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
global $DB;
if(detect_my_utf($_POST['u_lname'])){
	$_POST['u_lname'] = iconv("utf-8", "windows-1251", $_POST['u_lname']);
	$_POST['u_fname'] = iconv("utf-8", "windows-1251", $_POST['u_fname']);
	$_POST['u_mname'] = iconv("utf-8", "windows-1251", $_POST['u_mname']);
}
if($_POST['u_phone']!=''&&$_POST['u_email']){
	$nFlag = false;
	$ActionID = intval($_POST['action_id']);
	$curRes = $DB->Query("SELECT `PROMO` FROM `adv_user_action` WHERE (`PHONE`='".$_POST['u_phone']."' OR `EMAIL`='".$_POST['u_email']."') AND `ACTION_TYPE`='".$ActionID."';", true);
	while($ob=$curRes->GetNext()){
		$nFlag=true;
	}
	if(!$nFlag){
		$promo = GeneratePromo();
		$uName = $_POST['u_lname'].' '.$_POST['u_fname'].' '.$_POST['u_mname'];
		if(strlen($uName)>3){
			$curRes = $DB->Query("INSERT INTO `adv_user_action` (`PROMO`,`NAME`,`PHONE`,`EMAIL`, `DATE_CREATE`, `ACTION_TYPE`) VALUES ('".$promo."','".$uName."','".$_POST['u_phone']."','".$_POST['u_email']."', now(), '".$ActionID."');", true);
			$APPLICATION->set_cookie("USER_PROMO", $promo, time()+60*60*24*30*12*2);
			$_SESSION['USER_PROMO'] = $_POST;
			echo $promo;
		}else{
			echo "error 1";
		}
	}else{
		echo "error 2";
	}
}
function detect_my_utf($s){
	$s=urlencode($s);
	$res='0';
	$j=strlen($s);

	$s2=strtoupper($s);
	$s2=str_replace("%D0",'',$s2);
	$s2=str_replace("%D1",'',$s2);
	$k=strlen($s2);

	$m=1;
	if ($k>0){
		$m=$j/$k;
		if (($m>1.2)&&($m<2.2)){ $res='1'; }
	}
	return $res;
}
function GeneratePromo(){
	global $DB;
	$PromoString = '';
	do{
		$pFlag = false;
		$PromoString = randString(5, "0123456789abcdefghijklmnopqrstuvwxyz");
		$curRes = $DB->Query("SELECT `PHONE` FROM `adv_user_action` WHERE `PROMO`='".$PromoString."')", true);
		while($Promo=mysql_fetch_array($curRes)){
			$pFlag = true;
		}
	}while($pFlag);
	return $PromoString;
}
?>