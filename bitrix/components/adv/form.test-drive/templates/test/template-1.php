<?
if ($_REQUEST['formresult'] == 'addok') {
  echo "Ваш запрос отправлен - в ближайшее время с Вами свяжется наш менеджер. <br>\n
Спасибо.";
//header('Location: /testdrive/testdrive.php');
exit;
}
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<?if ($arResult["isFormNote"] != "Y") 
{
?>
<?=$arResult["FORM_HEADER"]?>
<?//var_dump($arResult['FORM_ERRORS']);?>
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
 //$("input[name='form_date_1391']").addClass("inputtext"); 
if (navigator.userAgent.indexOf("MSIE") != -1){
 $("input[name=form_date_1391]").css("width","190px");
} else {
 $("input[name=form_date_1391]").css("width","197px");
}
$("input[name=form_date_1391]").css("border","#919191 solid 1px");
 $("input[name=form_date_1391]").css("height","18px");
 $("input[name=form_date_1391]").css("background-image","url('/images/txt-bg.jpg')");



 $("#info_brand option[value='<?=$_POST[form_text_1211]?>']").attr('selected', 'selected');
 //$("#info_model").load('ajax.php',{id: <?=$_POST[form_text_1211]?>},function(){$("#info_model option[value='<?=$_POST[form_text_1221]?>']").attr('selected', 'selected');});
 $("#info_model").load("ajax.php", {id:"<?=$_POST[form_text_1211]?>"}, function(){$("#info_model option[value='<?=$_POST[form_text_1221]?>']").attr('selected', 'selected');});
});
</script>



<div id="firstImage" style="<?if (isset($arResult["list"])) echo("display:none;")?>">
<div class="selectionContent" style="padding:0;">
	<div class="selectionContentHeader">
	<span class="f11l13b">Меня интересует тест-драйв</span>
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
                <?
                $arSelect = Array();
                $str="";
$arFilter = Array("IBLOCK_ID"=>"192", "ACTIVE_DATE"=>"Y", "NAME"=>"%BMW%", "ACTIVE"=>"Y", "IBLOCK_SECTION_ID" => $parent_sect_names);
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);

$models = array();
while($ob = $res->GetNextElement())
{
  $arFields = $ob->GetFields();
if ($arFields['ID'] != "24852")
  $str = $str.'<option value="'.$arFields['ID'].'">'.$arFields['NAME'].'</option>';
  $models[$arFields['ID']] = $arFields['NAME'];
}

                $arQuestion["HTML_CODE"] = '<select name="form_text_1681"><option value="">Пожалуйста,выберите модель...</option>'.$str."</select>";
                ?>
                             <span class="f11l13"><?=$arQuestion["CAPTION"]?><?if ($arQuestion["REQUIRED"] == "Y"):?><span style='color:red;'> *</span><?endif;?></span>
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
<div class="section">
<div class="segmentMiddle">
<div class="inputMiddle">
<span class="f11l13">
Обращение
<span controltovalidate="_ctl0_ContentPlaceHolder1_rblSalut" errormessage="*" id="_ctl0_ContentPlaceHolder1_rblSalutValidator" evaluationfunction="RequiredFieldValidatorEvaluateIsValid" initialvalue="" style="color:Red;visibility:hidden;">*</span>
</span>
<br/>
<table id="_ctl0_ContentPlaceHolder1_rblSalut" class="inputMiddle inputMiddleRadio" border="0" style="height:16px;width:292px;">
  <tbody>
    <tr>
      <td>
        <input type="radio" id="1011" name="form_radio_appeal" id="1011" value="1011"/>
        <label for="1011">Г-н</label>
      </td>
      <td>
        <input type="radio" id="1021" name="form_radio_appeal" id="1021" value="1021"/>
        <label for="1021">Г-жа</label>
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
        if ($Array[0] == "fio"){
	?>
            <div class="segmentMiddle">
               <div class="inputMiddle">
                             <span class="f11l13"><?=$arQuestion["CAPTION"]?><?if ($arQuestion["REQUIRED"] == "Y"):?><span style='color:red;'> *</span><?endif;?></span>
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
<div class="selectionContent" style="padding:0;">
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
        if ($Array[0] == "address"){
	?>
            <div class="segmentMiddle">
               <div class="inputMiddle">
                             <span class="f11l13"><?=$arQuestion["CAPTION"]?><?if ($arQuestion["REQUIRED"] == "Y"):?><span style='color:red;'> *</span><?endif;?></span>
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
<div class="selectionContent" style="padding:0;">
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
        if ($Array[0] == "contact"){
	?>
            <div class="segmentMiddle">
               <div class="inputMiddle">
                             <span class="f11l13"><?=$arQuestion["CAPTION"]?><?if ($arQuestion["REQUIRED"] == "Y"):?><span style='color:red;'> *</span><?endif;?></span>
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
<div class="selectionContent" style="padding:0;">
	<div class="selectionContentHeader">
	<span class="f11l13b">Автосалон BMW</span>
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
<table id="_ctl0_ContentPlaceHolder1_rblSalut" class="inputMiddle inputMiddleRadio" border="0" style="height:16px;width:292px;">
  <tbody>
    <tr>
      <td>
        <input type="radio" id="1191" name="form_radio_carshop_diller" id="1191" value="1191" checked>
  <label for="1191"> на ул. 60-летия Октября</label>
      </td>
      <td>
        <input type="radio" id="1201" name="form_radio_carshop_diller" id="1201" value="1201">
  <label for="1201">Белая Дача</label>
      </td>
    </tr>
  </tbody>
</table>
</div>
</div>
</div>
<br class="noFloat"/>
<div class="selectionContent" style="padding:0;">
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
<div class="section">
	<?
        $newStr = 1;
	foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion)
	{
        $Array = split("_",$FIELD_SID);
        if ($Array[0] == "info"){
	?>
            <?if($FIELD_SID == "info_brand"){?>
                <?
                  $SelectString = "";
                  $rsElement = CIBlockElement::GetList(array(), array("IBLOCK_ID"=>271,"ACTIVE"=>"Y"), false, false, array("ID","NAME","PROPERTY_parent"));
                  while($ob = $rsElement->GetNextElement()){
                    $arFields = $ob->GetFields();
                    //var_dump($arFields);
                    if (!isset($arFields["PROPERTY_PARENT_VALUE"]))
                    $SelectString = $SelectString."<option value = \"".$arFields["ID"]."\">".$arFields["NAME"]."</option>";
                  }
                  //var_dump($SelectString);
                ?>
                <?$arQuestion["HTML_CODE"] = '<select name="form_text_1211" id="info_brand" onChange = "selectChange();" class="inputSelect"><option value="">Пожалуйста выберите модель...</option>'.$SelectString.'</select>';?>
            <?}?>
            <?
              if($FIELD_SID == "info_model"){
                $arQuestion["HTML_CODE"] = '<select name="form_text_1221" id="info_model" class="inputSelect"></select>';
              }
            ?>
            <div class="segmentMiddle">
               <div class="inputMiddle">
                             <span class="f11l13"><?=$arQuestion["CAPTION"]?><?if ($arQuestion["REQUIRED"] == "Y"):?><span style='color:red;'> *</span><?endif;?></span>
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
<div class="selectionContent" style="padding:0;">
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
<?/*
<script type="text/javascript">
$(function(){
  //$("#form_date_1391").css("width", "197px !important");
//inputMiddle
$(".inputMiddle input").css("width", "197px !important");
});
</script>*/?>
<?/*
<style type="text/css">
#form_date_1391{width: 197px !important}
</style>
*/?>
<div class="section">
	<?
        $newStr = 1;
	foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion)
	{
        $Array = split("_",$FIELD_SID);
        if ($Array[0] == "personal"){
	?>
            <?if ($FIELD_SID == "personal_birth_date"){
                $arQuestion["HTML_CODE"] = CalendarDate("form_date_1391", $_POST["form_date_1391"], "test_drive");
            }?>
            <div class="segmentMiddle">
               <div class="inputMiddle">
                             <span class="f11l13"><?=$arQuestion["CAPTION"]?><?if ($arQuestion["REQUIRED"] == "Y"):?><span style='color:red;'> *</span><?endif;?></span>
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
        <?//echo(CalendarDate(“DATE_ITEM”, "", “curform”));?>
</div>
<br class="noFloat"/>
<style type="text/css">
				.bmw-checkbox INPUT { width: 20px; }
			</style>
<div class="segmentMiddle" style="width: 750px;">
  <div class="inputMiddle" style="width: 750px; vertical-align: middle;">
    <span class="bmw-checkbox">
      <input type="checkbox" name="send">
      <label for="send">Согласие на использование информации</label>
    </span>
    <br>
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
				<?if ($arResult["F_RIGHT"] >= 15):?>
				&nbsp;<input type="hidden" name="web_form_apply" value="Y" />
				<?endif;?>
<?if (($arResult["list"]) == 2){?>
<div class="selectionContent" style="padding:0;height:50px;">
  <div class="selectionContentHeader">
    <span style="color:red;position:relative;top:30px;">* Обязательные поля</span>
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