<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if ($_REQUEST['formresult'] == 'addok') {
  echo "��� ������ ��������� - � ��������� ����� � ���� �������� ��� ��������. <br>\n
�������.";
exit;
}

?>
<?if ($arResult["isFormNote"] != "Y") 
{
?>
<?=$arResult["FORM_HEADER"]?>
<?echo $arResult["QUESTIONS"]['manager_email']['HTML_CODE'];?>
<?
/***********************************************************************************
						form questions
***********************************************************************************/
?>
<script>
function selectChange(id){
   var i = $("#info_brand option:selected").val();
   $("#info_model").load('ajax.php',{id: i});
 };

 $().ready(function() {
 $("input[name=salon]").attr('value', $("input[name=form_radio_carshop_diller]").attr('value'));
 
$("input[name=form_radio_carshop_diller]").click(function(){
	$("input[name=salon]").attr('value', $(this).attr('value'));
});

 $("select option[value='<?=$arResult["personal_hobby"];?>']").val(''); 
$("select option[value='<?=$arResult["personal_name_company"];?>']").val(''); 
$("select option[value='<?=$arResult["personal_activity"];?>']").val(''); 
$("select option[value='<?=$arResult["info_years_buy"];?>']").val(''); 
$("select option[value='<?=$arResult["info_years"];?>']").val(''); 
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



<div id="firstImage" style="<?if (isset($arResult["list"])) echo("display:none;")?>">
<div class="selectionContent" style="padding:0;">
	<div class="selectionContentHeader">
	<span class="f11l13b">���� ���������� ����-�����</span>

	<br/>
	</div>
	<div class="spacer3px">
	<br/>
	</div>
	<div class="dot">

	<br/>
	</div>
</div>
<div>
	<?
	foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion)
	{
        $Array = split("_",$FIELD_SID);
        if ($Array[0] == "first"){
	?>
          <div class="section">

            <div class="segmentMiddle">
               <div class="inputMiddle">
                             <span class="f11l13"><?=$arQuestion["CAPTION"]?><?if ($arQuestion["REQUIRED"] == "Y"):?><?=$arResult["REQUIRED_SIGN"]?><?endif;?></span>
                             <br/>

			<?=$arQuestion["HTML_CODE"]?>
               </div>
             </div>
          </div>           
	<? 
        }
	} //endwhile 
	?>
</div>
</div>

<div id="secondImage" style="<?if ($arResult["list"] != 2 ) echo("display:none;")?>">
<div class="selectionContent" style="padding:0;">
	<div class="selectionContentHeader">
	<span class="f11l13b">���</span>
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
<div class="segmentMiddle">
<div class="inputMiddle">
<span class="f11l13">
���������
</span>
<br/>

<table id="_ctl0_ContentPlaceHolder1_rblSalut" class="inputMiddle inputMiddleRadio" border="0" style="height:16px;width:292px;">
  <tbody>
    <tr>
      <?foreach ($arResult["appeal"] as $key => $radio){?>
      <td>
        <?=$radio?>

      </td>
      <?}?>
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
        if ($Array[0] == "fio"){
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
	<span class="f11l13b">�����</span>
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
        if ($Array[0] == "address"){
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
	<span class="f11l13b">���������� ����������</span>
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
        if ($Array[0] == "contact"){
	?>
            <div class="segmentMiddle">
               <div class="inputMiddle">
                             <span class="f11l13"><?=$arQuestion["CAPTION"]?><?if ($arQuestion["REQUIRED"] == "Y"):?><?=$arResult["REQUIRED_SIGN"]?>
							 <?endif;?>
<?
$mail = false;
if ($arResult['FORM_ERRORS'][$FIELD_SID] && ($FIELD_SID == 'contact_email')){
foreach ($_POST as $name => $value)
{
	if (strpos($name, 'form_email') === false) continue;
	if (strlen($_POST[$name]) !== 0){
		echo '<span style="color:red"> ������� ������ </span>';
		$mail = true;
	}
	break;
}
}?>

							 </span>
                             <br/>
			<?=$arQuestion["HTML_CODE"]?>
               </div>

             </div>                        
	<? 
        }
	} //endwhile 
	?>
</div>
</div>
<div id="treeImage" style="<?if ($arResult["list"] != 3 ) echo("display:none;")?>">
<div class="selectionContent">
	<div class="selectionContentHeader">

	<span class="f11l13b">��������� BMW</span>
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
            <div class="segmentMiddle">

               <div class="inputMiddle"><input type="hidden" name="salon" value=""/>
<table id="_ctl0_ContentPlaceHolder1_rblSalut" class="inputMiddle inputMiddleRadio" border="0" style="height:16px;width:292px;">
  <tbody>
    <tr>
     <?foreach ($arResult["dillers"] as $key => $radio){?>
      <td>

        <?=$radio?>
      </td>
      <?}?>
    </tr>
  </tbody>
</table>

</div>
</div>
</div>
<br class="noFloat"/>
<div class="selectionContent">
	<div class="selectionContentHeader">
	<span class="f11l13b">���������� � ����� ����������</span>

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
	<span class="f11l13b">������ ������</span>

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
        $newStr = 1;
	foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion)
	{
        $Array = split("_",$FIELD_SID);
        if ($Array[0] == "personal"){
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
        <?//echo(CalendarDate(�DATE_ITEM�, "", �curform�));?>
</div>
<br class="noFloat"/>
<div class="segmentMiddleL">
  <div class="inputMiddleL">
    <span class="bmw-checkbox">

      <input type="checkbox" name="send">
      <label for="send">�������� �� ������������� ����������</label><?=$arResult["REQUIRED_SIGN"]?>
<?php
	$error_send = false;

        if (empty($_POST['send']) && $_POST['web_form_apply'] == 'Y'  && $_POST['list'] == $arResult["list"]){
		$error_send = true;
	}
?>
    </span>
    <br>
    <span class="f11l13">��������� �����������, ��� � �� �������� ������ ����, ����� ��� ������������ ������ ���� �������� � ���������� ���� ������ ��������������� ������ BMW � BMW Group ������ ��� ������������ ��������� ���������� � ��������� � �������, ������������ �������� BMW �� ���������� ��. ��� ���� ����� � �������� �������� BMW �������, ������������ � ��� ������������� ���������� ��� ������������ ������ ����������� ��������� �������� BMW.</span>

    <br>
    <span class="f11l13">����������: ����� ������������ ���� �������� �� ������������� ����������, ����������� � ������ ���������� ��������� BMW �� ���.<br /> +7 (495) 787 80 08.</span>
  </div>
</div>
</div>

<div>
<br class="noFloat"/>
<INPUT TYPE=hidden NAME=list value="<?=$arResult["list"];?>"> 
<input <?=(intval($arResult["F_RIGHT"]) < 10 ? "disabled=\"disabled\"" : "");?> type="submit" name="web_form_submit" class="standardButton bgDarkGreyBlue" value="<?if ($arResult["list"] == 3){?><?=strlen(trim($arResult["arForm"]["BUTTON"])) <= 0 ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"];?><?} else {echo("�����");}?>" />

<?if (($arResult['isFormErrors'] == 'Y') && ($arResult['FORM_ERRORS']['nextLevel'] != 'next' ))

if (!$mail && (count($arResult['FORM_ERRORS']) > 1))
{
  echo '<span style="color:red;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;�� ��� ������������ ���� ���������</span>';
  $error_send = false;
}

if ($error_send)
  echo '<span style="color:red;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;�� ��� ������������ ���� ���������</span>';


?>

				<?if ($arResult["F_RIGHT"] >= 15):?>

				&nbsp;<input type="hidden" name="web_form_apply" value="Y" />
				<?endif;?>
<?if (($arResult["list"]) == 2){?>
<div class="selectionContent" style="height:50px;">
  <div class="selectionContentHeader">
    <span class="invariable" >* ������������ ����</span>

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
<?
} //endif (isFormNote)
?>