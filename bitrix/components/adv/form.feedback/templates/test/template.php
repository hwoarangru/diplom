<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if ($_REQUEST['formresult'] == 'addok') {
  echo "Ваш запрос отправлен - в ближайшее время с Вами свяжется наш менеджер. <br>\n
Спасибо.";
exit;
}
?>
<?if ($arResult["isFormNote"] != "Y") 
{
?>
<?=$arResult["FORM_HEADER"]?>
<?echo $arResult["QUESTIONS"]['manager_email']['HTML_CODE']; ?>
<?
/***********************************************************************************
						form questions
***********************************************************************************/
?>

<script>
function selectChange(){
   var i = $("#info_brand option:selected").val();
   $("#info_model").load('/contacts/feedback/ajax.php',{id: i});
 };


$().ready(function() {
 $("select option[value='<?=$arResult["info3_hobby"];?>']").val(''); 
$("select option[value='<?=$arResult["info1_model"];?>']").val(''); 
$("select option[value='<?=$arResult["info4_sphere"];?>']").val(''); 
$("select option[value='<?=$arResult["info2_date"];?>']").val(''); 
$("select option[value='<?=$arResult["info2_year"];?>']").val(''); 
 //$("input[name='form_date_1391']").addClass("inputtext"); 
if (navigator.userAgent.indexOf("MSIE") != -1){
 $("input[name=form_date_<?=$arResult["date_id"]?>]").css("width","190px");
} else {
 $("input[name=form_date_<?=$arResult["date_id"]?>]").css("width","197px");
}

$("input[name=form_date_<?=$arResult["date_id"]?>]").css("border","#919191 solid 1px");
 $("input[name=form_date_<?=$arResult["date_id"]?>]").css("height","18px");
 $("input[name=form_date_<?=$arResult["date_id"]?>]").css("background-image","url('/images/txt-bg.jpg')");


 $("#info_brand option[value='<?=$_POST["form_text_".$arResult["brand_id"]]?>']").attr('selected', 'selected');

 $("#info_model").load("ajax.php", {id:"<?=$_POST["form_text_".$arResult["brand_id"]]?>"}, function(){
   if (navigator.userAgent.indexOf("MSIE") == -1)
     $("#info_model option[value='<?=$_POST["form_text_".$arResult["model_id"]]?>']").attr('selected', 'selected');
   else
      setTimeout( function() {  $("#info_model option[value='<?=$_POST["form_text_".$arResult["model_id"]]?>']").attr('selected', 'selected'); } , 300);
 });


});
</script>
	<div class="selectionContent" style="padding:0;">
		<div class="selectionContentHeader">
			<span class="h4">Обратная связь</span>
			<br/>
		</div>

	</div>

<div class="forma">

<div id="firstImage" style="<?if (isset($arResult["list"])) echo("display:none;")?>">
	<div class="selectionContent" style="padding:0;">

		<br/><br/>

		<div class="dot">
			<br/>
		</div>
	</div>
	<div class="section">
	<?
	 
	foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion)
	{
        $Array = split("_",$FIELD_SID);
        if ($Array[0] == "f"){
	?>
         

            <div>
               <div class="inputMiddle">
                             <span class="f11l13"><?=$arQuestion["CAPTION"]?><?if ($arQuestion["REQUIRED"] == "Y"):?><?=$arResult["REQUIRED_SIGN"]?><?endif;?></span>
                             <br/>

			<?=$arQuestion["HTML_CODE"]?>
               </div>
             </div>
             <br class="noFloat"/>  <br/>
                
	<? 
        }
	} //endwhile 
	?>
	</div>
</div>

<div id="secondImage" style="<?if ($arResult["list"] != 2 ) echo("display:none;")?>">

	<div class="selectionContent" style="padding:0;">
		<div class="selectionContentHeader">
			<span class="f11l13b">ФИО</span>
			<br/>
		</div>
		<div class="spacer3px">
			<br/>
		</div>
		<div class="dot">
			<br/>
		</div>
	</div>
<?//pre($arResult["QUESTIONS"]["s_appeal"])?>

<div class="section">
	<div class="segmentMiddle">
		<div class="inputMiddle">
			<span class="f11l13">
				Обращение
			</span>
			<br/>
			<table id="_ctl0_ContentPlaceHolder1_rblSalut" class="inputMiddle inputMiddleRadio" border="0" style="height:16px;width:392px;">
			  <tbody>
			    <tr>
			      <td>
			        <?=$arResult["QUESTIONS"]["s_appeal"]["HTML_CODE"]?>
			      </td>
			    </tr>
			  </tbody>
			</table>
		</div>
	</div>

	<br class="noFloat"/>
	<?
	foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion)
	{
        $Array = split("_",$FIELD_SID);
        if ($Array[0] == "s1"){
	?>
            <div class="segmentMiddle">
               <div class="inputMiddle">
                             <span class="f11l13"><?=$arQuestion["CAPTION"]?><?if ($arQuestion["REQUIRED"] == "Y"):?><?=$arResult["REQUIRED_SIGN"]?><?endif;?></span>

                             <br/>
			<?=$arQuestion["HTML_CODE"]?>
               </div>
             </div>                     
	<? 
        }
	} //endwhile 
	?>
</div>

<br class="noFloat"/>   

<div class="selectionContent">
	<div class="selectionContentHeader">
	<span class="f11l13b">Адрес</span>
	<br/>
	</div>
	<div class="spacer3px">

	<br/>
	</div>
	<div class="dot">
	<br/>
	</div>
</div>

<div class="section">
	<?
	foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion)
	{
        $Array = split("_",$FIELD_SID);
        if ($Array[0] == "s2"){
	?>
            <div class="segmentMiddle">
               <div class="inputMiddle">
                             <span class="f11l13"><?=$arQuestion["CAPTION"]?><?if ($arQuestion["REQUIRED"] == "Y"):?><?=$arResult["REQUIRED_SIGN"]?><?endif;?></span>

                             <br/>
			<?=$arQuestion["HTML_CODE"]?>
               </div>
             </div>                     
	<? 
        }
	} //endwhile 
	?>
<br class="noFloat"/> 	
	<?
	foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion)
	{
        $Array = split("_",$FIELD_SID);
        if ($Array[0] == "s3"){
	?>
            <div class="segmentMiddle">
               <div class="inputMiddle">
                             <span class="f11l13"><?=$arQuestion["CAPTION"]?><?if ($arQuestion["REQUIRED"] == "Y"):?><?=$arResult["REQUIRED_SIGN"]?><?endif;?></span>

                             <br/>
			<?=$arQuestion["HTML_CODE"]?>
               </div>
             </div>                     
	<? 
        }
	} //endwhile 
	?>
</div>



<br class="noFloat"/>   

<div class="selectionContent">
	<div class="selectionContentHeader">
		<span class="f11l13b">Контактная информация</span>
		<br/>
	</div>
	<div class="spacer3px">
		<br/>
	</div>
	<div class="dot">
		<br/>
	</div>
</div>

<div class="section">
	<?
	foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion)
	{
        $Array = split("_",$FIELD_SID);
        if ($Array[0] == "s4"){
	?>
            <div class="segmentMiddle">
               <div class="inputMiddle">
                             <span class="f11l13"><?=$arQuestion["CAPTION"]?><?if ($arQuestion["REQUIRED"] == "Y"):?><?=$arResult["REQUIRED_SIGN"]?><?endif;?></span>

                             <br/>
			<?=$arQuestion["HTML_CODE"]?>
               </div>
             </div>                     
	<? 
        }
	} //endwhile 
	?>
	<br class="noFloat"/> 	
	<?
	foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion)
	{
        $Array = split("_",$FIELD_SID);
        if ($Array[0] == "s5"){
	?>
            <div class="segmentMiddle">
               <div class="inputMiddle">
                             <span class="f11l13"><?=$arQuestion["CAPTION"]?><?if ($arQuestion["REQUIRED"] == "Y"):?><?=$arResult["REQUIRED_SIGN"]?><?endif;?></span>

                             <br/>
			<?=$arQuestion["HTML_CODE"]?>
               </div>
             </div>                     
	<? 
        }
	} 
	?>
                      
</div>
</div>










<div id="treeImage" style="<?if ($arResult["list"] != 3 ) echo("display:none;")?>">

<div class="section">
	<?
        $newStr = 1;
	foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion)
	{
        $Array = split("_",$FIELD_SID);
        if ($Array[0] == "info"){
	?>
            <div class="segmentMiddle">

               <div class="inputMiddle">
                             <span class="f11l13"><?=$arQuestion["CAPTION"]?><?if ($arQuestion["REQUIRED"] == "Y"):?><?=$arResult["REQUIRED_SIGN"]?><?endif;?></span>
                             <br/>
			<?=$arQuestion["HTML_CODE"]?>

               </div>
             </div>
             <?if ($newStr >= 2){?>
                <?$newStr = 1;?>
               <br class="noFloat"/>
             <?} else {
             $newStr++;
             }?>

                                     
	<? 
        }
	} //endwhile 
	?>
</div>


<br class="noFloat"/>
<div class="selectionContent">
	<div class="selectionContentHeader">
	<span class="f11l13b">Информация о Вашем автомобиле</span>

	<br/>
	</div>
	<div class="spacer3px">
	<br/>
	</div>
	<div class="dot">

	<br/>
	</div>
</div>

<?//pre($arResult["QUESTIONS"]);?>
<div class="section">
	<?
	foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion)
	{
        $Array = split("_",$FIELD_SID);
        if ($Array[0] == "info1"){
	?>
            <div class="segmentMiddle">
               <div class="inputMiddle">
                             <span class="f11l13"><?=$arQuestion["CAPTION"]?><?if ($arQuestion["REQUIRED"] == "Y"):?><?=$arResult["REQUIRED_SIGN"]?><?endif;?></span>

                             <br/>
			<?=$arQuestion["HTML_CODE"]?>
               </div>
             </div>                     
	<? 
        }
	} //endwhile 
	?>
	<br class="noFloat"/> 	
	<?
	foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion)
	{
        $Array = split("_",$FIELD_SID);
        if ($Array[0] == "info2"){
	?>
            <div class="segmentMiddle">
               <div class="inputMiddle">
                             <span class="f11l13"><?=$arQuestion["CAPTION"]?><?if ($arQuestion["REQUIRED"] == "Y"):?><?=$arResult["REQUIRED_SIGN"]?><?endif;?></span>

                             <br/>
			<?=$arQuestion["HTML_CODE"]?>
               </div>
             </div>                     
	<? 
        }
	} 
	?>
                      
</div>


<br class="noFloat"/>
<div class="selectionContent">
	<div class="selectionContentHeader">
	<span class="f11l13b">Личные данные</span>

	<br/>
	</div>
	<div class="spacer3px">
	<br/>
	</div>
	<div class="dot">

	<br/>
	</div>
</div>

<div class="section">
	<?
	foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion)
	{
        $Array = split("_",$FIELD_SID);
        if ($Array[0] == "info3"){
	?>
            <div class="segmentMiddle">
               <div class="inputMiddle">
                             <span class="f11l13"><?=$arQuestion["CAPTION"]?><?if ($arQuestion["REQUIRED"] == "Y"):?><?=$arResult["REQUIRED_SIGN"]?><?endif;?></span>

                             <br/>
			<?=$arQuestion["HTML_CODE"]?>
               </div>
             </div>                     
	<? 
        }
	} //endwhile 
	?>
	<br class="noFloat"/> 	
	<?
	foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion)
	{
        $Array = split("_",$FIELD_SID);
        if ($Array[0] == "info4"){
	?>
            <div class="segmentMiddle">
               <div class="inputMiddle">
                             <span class="f11l13"><?=$arQuestion["CAPTION"]?><?if ($arQuestion["REQUIRED"] == "Y"):?><?=$arResult["REQUIRED_SIGN"]?><?endif;?></span>

                             <br/>
			<?=$arQuestion["HTML_CODE"]?>
               </div>
             </div>                     
	<? 
        }
	} 
	?>
                      
</div>


<br class="noFloat"/>
<div class="segmentMiddleL">
  <div class="inputMiddleL">
    <span class="bmw-checkbox">

      <input type="checkbox" name="send">
      <label for="send">Согласие на использование информации</label><?=$arResult["REQUIRED_SIGN"]?>
<?php
	$error_send = false;

        if (empty($_POST['send']) && $_POST['web_form_apply'] == 'Y'  && $_POST['list'] == $arResult["list"]){
		$error_send = true;
	}
?>
    </span>
    <br><br>
    <span class="f11l13">Настоящим подтверждаю, что я не возражаю против того, чтобы мои персональные данные были переданы в клиентскую базу данных авторизованного дилера BMW и BMW Group Россия для последующего получения информации о продуктах и услугах, предлагаемых клиентам BMW на территории РФ. Для этих целей я разрешаю компании BMW хранить, обрабатывать и при необходимости передавать мои персональные данные официальным партнерам концерна BMW.</span>

    <br>
    <span class="f11l13">Примечание: чтобы аннулировать Ваше согласие на использование информации, обращайтесь в Службу Клиентской Поддержки BMW по тел.<br /> +7 (495) 787 80 08.</span>
  </div>
</div>
</div>

<div>
<br class="noFloat"/>
<INPUT TYPE=hidden NAME=list value="<?=$arResult["list"];?>"> 
<input <?=(intval($arResult["F_RIGHT"]) < 10 ? "disabled=\"disabled\"" : "");?> type="submit" name="web_form_submit" class="standardButton bgDarkGreyBlue" value="<?if ($arResult["list"] == 3){?><?=strlen(trim($arResult["arForm"]["BUTTON"])) <= 0 ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"];?><?} else {echo("Далее");}?>" />

<?if (($arResult['isFormErrors'] == 'Y') && ($arResult['FORM_ERRORS']['nextLevel'] != 'next' ))

if (!$mail && (count($arResult['FORM_ERRORS']) > 1))
{
  echo '<span style="color:red;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Не все обязательные поля заполнены. ';
  //	foreach ($arResult['FORM_ERRORS'] as $dta): echo $dta.'.&nbsp;'; endforeach;
  echo '</span>';
  $error_send = false;
}

if ($error_send):
  echo '<span style="color:red;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Не все обязательные поля заполнены. ';
  //foreach ($arResult['FORM_ERRORS'] as $dta): echo $dta.'.&nbsp;'; endforeach;
  echo '</span>';
endif;

?>

				<?if ($arResult["F_RIGHT"] >= 10):?>

				&nbsp;<input type="hidden" name="web_form_apply" value="Y" />
				<?endif;?>
<?if (($arResult["list"]) == 2){?>
<div class="selectionContent" style="height:50px;">
  <div class="selectionContentHeader">
    <span class="invariable" >* Обязательные поля</span>

    <br>
  </div>
  <div class="spacer3px">
    <br>
  </div>
</div>

<?}?>
<p>
<!--<?=$arResult["REQUIRED_SIGN"];?> - <?=GetMessage("FORM_REQUIRED_FIELDS")?>-->
</p>
<!--<?=$arResult["FORM_FOOTER"]?>-->

</div>
</div>
<?
} //endif (isFormNote)
?>