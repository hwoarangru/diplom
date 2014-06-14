<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
?>

<script type="text/javascript" src="/bitrix/templates/.default/js/datasheet.js"></script>

<style type="text/css">

#horizontal-multilevel-menu2 {
    margin-top: 53px;
    z-index: 10000;
    margin-left: 30px;
}

#datasheet_innertable {
  overflow:auto;
  position:relative;
  margin-bottom:10px;
  display: block;
  height: 400px;
}

#downloadDatasheet {
  margin-left:15px;
  display:none;
}

#datasheet_head {
  position:absolute;
  top:115px;
  left:255px;
  width:350px;
  height:40px;
  overflow:hidden;
  font-weight:bold;
}

#datasheet_select {
  position:absolute;
  top:113px;
  left:714px;
  width:219px;
  height:43px;
  display:none;
  z-index:100;
}

#datasheet_select .select {
  display:block;
  position:relative;
  padding:1px 5px;
  width:209px;
  height:14px;
  overflow:hidden;
  background-color:#fff;
  background-image:url("/upload/1-/images_packed_v1.gif");
  background-repeat:no-repeat;
  background-position:209px -164px;
  z-index:20;
}

#datasheet_select .select:hover {
  color:#0044cc;
  background-position:209px -188px;
}

#datasheet_select .dropdown {
  position:absolute;
  top:17px;
  left:0px;
  background-color:#fff;
  width:219px;
  display:none;
  z-index:19;
}

#datasheet_select .dropdown_content {
  position:relative;
  margin:5px;
  width:180px;
}


#datasheet_select .dropdown a {
  display:block;
  width:160px;
  color:#363636;
  line-height:13px;
  margin-bottom:3px;
}

#datasheet_select .dropdown a:hover {
  color:#0044cc;
}


#datasheet_select .configure {
  margin-top:2px;
  display:none;
}

#datasheet_table {
  position:absolute;
  top:155px;
  left:242px;
  width:714px;
  z-index:95;
}

#datasheet_table table {
  table-layout:fixed;
  margin:0 0 10px 0;
}

#datasheet_table tr.mc_table_headline {
  background-image:url( /bitrix/components/adv/model/templates/.default/images/table_headline_bg.png );
}

#datasheet_table tr.mc_table_headline td {
  font-weight:bold;
  padding-top:3px;
  padding-bottom:2px;
}

#datasheet_table tr.mc_table_seperator {
  height:1px;
  overflow:hidden;
}

#datasheet_table tr.mc_table_entry {
  background-image:url( /bitrix/components/adv/model/templates/.default/images/table_entry_bg.png );
}

#datasheet_table tr.mc_table_entry td {
  text-align:center;
  padding-top:3px;
  padding-bottom:2px;
}

#datasheet_table tr.mc_table_entry td.leftalign {
  text-align:left;
}

#datasheet_table .modelImageContainer{
  position:relative;
  width:338px;
  height:169px;
  margin:0 0 10px 0;
}

#datasheet_table .dataTableColumnLeft{
  position:absolute;
  top:178px;
  left:0;
  width:338px;
}

#datasheet_table .dataTableColumnRight{
  position:absolute;
  top:43px;
  left:348px;
  width:338px;
}

#datasheetHiddenPrintLayer{
  position:relative;
  display:none;
}

#datasheet_table .modelImageContainer .modelImageMagnifier{
  position:absolute;
  top:1px;
  left:10px;
  width:15px;
  height:15px;
  display:block;
  background-repeat: no-repeat;
  background-position:0 -460px;
  background-image: url( "/upload/1-/images_packed_v1.gif" );
}

#datasheet_table .modelImageContainer .modelImageMagnifier:hover{
  background-position:0 -475px;
}

#datasheet_table .modelImageContainer .datasheetPrint{
  position:absolute;
  top:20px;
  left:10px;
  width:15px;
  height:15px;
  display:block;
  background-repeat: no-repeat;
  background-position:0 -520px;
  background-image: url( "/upload/1-/images_packed_v1.gif" );
}

#datasheet_table .modelImageContainer .datasheetPrint:hover{
  background-position:0 -535px;
}

#datasheet_table .modelImageContainer .modelImageSmall{
  position:absolute;
  top:0px;
  right:0px;
  width:308px;
  height:169px;
}

#datasheetZoomImage {
  position:relative;
  display:none;
}

#datasheetZoomImage .modelImageMinifier{
  position:absolute;
  top:1px;
  left:10px;
  width:15px;
  height:15px;
  display:block;
  background-repeat: no-repeat;
  background-position:0 -490px;
  background-image: url( "/upload/1-/images_packed_v1.gif" );
}

#datasheetZoomImage .modelImageMinifier:hover{
  background-position:0 -505px;
}

#datasheetZoomImage .modelImageZoom{
  position:absolute;
  top:0px;
  right:0px;
  width:645px;
  height:372px;
}

.datasheet_icon {
  padding-left:14px;
  padding-right:20px;
  background-repeat:no-repeat;
  float:left;
}

.datasheet_table_icon {
  width:8px;
  height:11px;
  overflow:hidden;
  display:inline-block;
}

#datasheetInfoLayer{
  position:absolute;
  top:380px;
  left:235px;
  width:356px;
  height:186px;
  z-index:810;
  display:none;
}

#datasheetInfoLayerBg{
  width:356px;
  height:186px;
  background-repeat: no-repeat;
  background-image: url( /upload/1-/compare_info_layer_background.png );
  position: relative;
  top: 0px;
}

#datasheetInfoLayer a.closeDatasheetInfoLayer {
  position:absolute;
  top:7px;
  left:332px;
  width:15px;
  height:15px;
  cursor:pointer;
  background-repeat: no-repeat;
  background-position:0 -220px;
  background-image: url( "/upload/1-/images_packed_v1.gif" );
}

#datasheetInfoLayer a.closeDatasheetInfoLayer:hover{
  background-position:0 -235px;
}

#datasheetInfoLayer h4{
  width:240px;
  padding:9px 0 0 12px;
  font-size:11px;
  line-height:12px;
  font-weight:bold;
  color:#363636;
  margin-bottom: 8px;
}

#datasheetInfoLayer .datasheetInfoLayerContent{
  position:relative;
  height:150px;
  width:335px;
  margin:5px 0 0 12px;
  overflow:auto;
}

#datasheetDialogButtons {
  position:absolute;
  top:605px;
  left:889px;
  width:100px;
  z-index:800;
  text-align:right;
}
</style>

<?if (!empty($arResult["MORE_PROPS"]) && $arResult["MORE_PROPS"] == "Y"):?><style  type="text/css">
#sales_navigation ul a {
	background-image: url(/bitrix/components/adv/model/templates/.default/images/sales_navigation_carbon_button_bg.png);
	color: #606060;
}
#vehicle_navigation ul a {
	background-image: url(/bitrix/components/adv/model/templates/.default/images/vehicle_navigation_button_bg_dark_vehicle_nav.gif);
	border-top: 1px solid #505050;
	color: white;
}
.teaser_cont {
	background-image: url(/bitrix/components/adv/model/templates/.default/images/vehicle_navigation_button_bg_dark.gif);
}
.teaser_cont .teaser_text {
	color: white;
}
.teaser_cont .teaser_text a{
	background-position: 0 -81px;
	color: white;
}
.teaser_cont .teaser_text a:hover{
	background-position: 0 -551px;
	color: #1D6AD4;
}
#datasheet_head {
	color: white;
}
</style>
<?endif;?>

<div id="stage">
	<?if($arResult['FON'])
	{?>
		<img src="<?=$arResult['FON']?>" width="1024" height="634" alt="<?=$arResult['NAME']?>" />
	<?}?>
</div>
	<div id="datasheet_head">
        Технические характеристики
      </div>
<div id="datasheet_select" style="display: block; ">
        <a id="datasheet_select_box" href="" onclick="return false" class="select"><?=$arResult['NAME']?> <?=$arResult['technical'][0]['NAME']?></a>
        <div class="dropdown">
          <div class="dropdown_content">
			<?foreach($arResult['technical'] as $tid=>$technical)
			{?>
				<a href="" model="<?=$technical['NAME']?>"><?=$arResult['NAME']?> <?=$technical['NAME']?></a>
			<?}?>
			</div>
        </div>
</div>

<div id="datasheetInfoLayer">
      <div id="datasheetInfoLayerBg">

        <a class="closeDatasheetInfoLayer" href="" onclick="return false;">&nbsp;</a>
        <h4>Сведения о приведенных данных</h4>
        <div class="datasheetInfoLayerContent">
			<?=$arResult["TEXT"]?>
        </div>

      </div>
</div>

<div id="datasheet_table">
      <div id="datasheetZoomImage">
        <a class="modelImageMinifier" href="javascript:void(0)"></a>
        <img class="modelImageZoom" src="<?=$arResult['technical_fields'][0]['DETAIL_PICTURE']?>" width="645" height="372">
      </div>
      <div id="datasheet_innertable" style="height: 305px; ">      
		<div class="modelImageContainer">         
			<a class="modelImageMagnifier" href="javascript:void(0)"></a>         
			<a class="datasheetPrint" href="javascript:void(0)"></a>         
			<img class="modelImageSmall" src="<?=$arResult['technical_fields'][0]['PREVIEW_PICTURE']?>" width="308" height="169">       
		</div>       
		<div class="dataTableColumnLeft">  
			<?if(isset($arResult['technical'][0]["GAS"]["VALUE"][0]))
			{?>
				<table width="338" border="0" cellspacing="0" cellpadding="0">          
					<tbody>
						<tr>            
							<td width="11"></td>
							<td width="192"></td>
							<td width="10"></td>
							<td width="120"></td>
							<td width="5"></td>         
						</tr>                  
						<tr class="mc_table_headline">            
							<td></td>            
							<td colspan="4">Расход топлива</td>          
						</tr>   
						<tr class="mc_table_seperator">            
							<td colspan="5"></td>          
						</tr>
						<?foreach($arResult['technical'][0]["GAS"]["VALUE"] as $pid => $gas)
						{?>
							<tr class="mc_table_entry">            
								<td></td>            
								<td class="leftalign"><?=$gas?><br></td>            
								<td></td>            
								<td><?=$arResult['technical'][0]["GAS"]["DESCRIPTION"][$pid]?><br></td>            
								<td></td>          
							</tr>    
							<tr class="mc_table_seperator">            
								<td colspan="5"></td>          
							</tr>
						<?}?>
					</tbody>
				</table>
			<?}?>
			<?if(isset($arResult['technical'][0]["TTX"]["VALUE"][0]))
			{?>
				<table width="338" border="0" cellspacing="0" cellpadding="0">          
					<tbody>
						<tr>            
							<td width="11"></td>
							<td width="192"></td>
							<td width="10"></td>
							<td width="120"></td>
							<td width="5"></td>          
						</tr>           
						<tr class="mc_table_headline">            
							<td></td>            
							<td colspan="4">Технические характеристики</td>          
						</tr>   
						<tr class="mc_table_seperator">            
							<td colspan="5"></td>          
						</tr>
						<?foreach($arResult['technical'][0]["TTX"]["VALUE"] as $pid => $ttx)
						{?>
							<tr class="mc_table_entry">            
								<td></td>            
								<td class="leftalign"><?=$ttx?><br></td>            
								<td></td>            
								<td><?=$arResult['technical'][0]["TTX"]["DESCRIPTION"][$pid]?><br></td>            
								<td></td>          
							</tr>    
							<tr class="mc_table_seperator">            
								<td colspan="5"></td>          
							</tr>
						<?}?>
					</tbody>
				</table>
			<?}?>     
		</div>      
		<div class="dataTableColumnRight">
			<?if(isset($arResult['technical'][0]["MASS"]["VALUE"][0]))
			{?>
				<table width="338" border="0" cellspacing="0" cellpadding="0">          
					<tbody>
						<tr>            
							<td width="11"></td>
							<td width="192"></td>
							<td width="10"></td>
							<td width="120"></td>
							<td width="5"></td>          
						</tr>          
						<tr class="mc_table_headline">            
							<td></td>            
							<td colspan="4">Масса</td>          
						</tr>   
						<tr class="mc_table_seperator">            
							<td colspan="5"></td>          
						</tr>
						<?foreach($arResult['technical'][0]["MASS"]["VALUE"] as $pid => $mass)
						{?>
							<tr class="mc_table_entry">            
								<td></td>            
								<td class="leftalign"><?=$mass?><br></td>            
								<td></td>            
								<td><?=$arResult['technical'][0]["MASS"]["DESCRIPTION"][$pid]?><br></td>            
								<td></td>          
							</tr>    
							<tr class="mc_table_seperator">            
								<td colspan="5"></td>          
							</tr>
						<?}?>
					</tbody>
				</table>
			<?}?>
			<?if(isset($arResult['technical'][0]["ENGINE"]["VALUE"][0]))
			{?>
				<table width="338" border="0" cellspacing="0" cellpadding="0">          
					<tbody>
						<tr>            
							<td width="11"></td>
							<td width="192"></td>
							<td width="10"></td>
							<td width="120"></td>
							<td width="5"></td>         
						</tr>        
						<tr class="mc_table_headline">            
							<td></td>            
							<td colspan="4">Двигатель</td>          
						</tr>   
						<tr class="mc_table_seperator">            
							<td colspan="5"></td>          
						</tr>
						<?foreach($arResult['technical'][0]["ENGINE"]["VALUE"] as $pid => $eng)
						{?>
							<tr class="mc_table_entry">            
								<td></td>            
								<td class="leftalign"><?=$eng?><br></td>            
								<td></td>            
								<td><?=$arResult['technical'][0]["ENGINE"]["DESCRIPTION"][$pid]?><br></td>            
								<td></td>          
							</tr>    
							<tr class="mc_table_seperator">            
								<td colspan="5"></td>          
							</tr>
						<?}?>
					</tbody>
				</table>
			<?}?>
			<?if(isset($arResult['technical'][0]["WHEELS"]["VALUE"][0]))
			{?>
				<table width="338" border="0" cellspacing="0" cellpadding="0">          
					<tbody>
						<tr>            
							<td width="11"></td>
							<td width="192"></td>
							<td width="10"></td>
							<td width="120"></td>
							<td width="5"></td>     
						</tr>         
						<tr class="mc_table_headline">            
							<td></td>            
							<td colspan="4">Колеса</td>          
						</tr>   
						<tr class="mc_table_seperator">            
							<td colspan="5"></td>          
						</tr>
						<?foreach($arResult['technical'][0]["WHEELS"]["VALUE"] as $pid => $whee)
						{?>
							<tr class="mc_table_entry">            
								<td></td>            
								<td class="leftalign"><?=$whee?><br></td>            
								<td></td>            
								<td><?=$arResult['technical'][0]["WHEELS"]["DESCRIPTION"][$pid]?><br></td>            
								<td></td>          
							</tr>    
							<tr class="mc_table_seperator">            
								<td colspan="5"></td>          
							</tr>
						<?}?>
					</tbody>
				</table>
			<?}?>
		</div>
	</div>
    <a href="" id="openDatasheetInfoLayer" onclick="return false;" class="standard">Сведения о приведенных данных</a>
</div>


<!-- JS SCRIPT -->


<script type="text/javascript">
	var compare_model = new Array();
var datasheet_model_selected = new Array();
datasheet_model_selected = "";
var datasheet_model_short = new Array();

function datasheetSetTableHeight() {
  newCategoryLayerHeight = Math.round($("#sales_navigation").offset().top - $("#datasheet_innertable").offset().top - 39);
  $("#datasheet_innertable").css("height", newCategoryLayerHeight + "px");
}

function datasheetInit() {
  datasheet_model = compare_model;
  for(i in datasheet_model) {
    if(typeof datasheet_model[i] != "function"){
      datasheet_model_short.push(i);
    }
  }
  var dropdownCode = "";
  for(i = 0; i <= (datasheet_model_short.length - 1); i++) {
    dropdownCode += '<a href="" model="' + datasheet_model_short[i] + '">' + datasheet_model[datasheet_model_short[i]]["model_name"] + '</a>';
  }
  $(".dropdown_content").html(dropdownCode);

  datasheet_model_selected = datasheet_model_short[0];

  splitSearchString();
  if (query.model_1 && inArray(query.model_1,datasheet_model_short)) {
    datasheet_model_selected = query.model_1;
  }


  datasheetWriteSelectboxes();
  datasheetWriteTable();

  $(window).resize(function() {
    datasheetSetTableHeight();
  });

  $(".closeDatasheetInfoLayer").click(function(){
    $("#datasheetInfoLayer").hide();
  });

  $("#openDatasheetInfoLayer").click(function(){

    newCategoryLayerHeight = Math.round($("#sales_navigation").offset().top - $("#datasheet_innertable").offset().top - 47);
    $("#datasheetInfoLayer").css("top",newCategoryLayerHeight + "px").show();
  });

  $("#datasheet_select .select").click(function () {
    if($("#datasheet_select .dropdown").css("display") == "none"){
      $("#datasheet_select .dropdown").show();
    }else{
      $("#datasheet_select .dropdown").hide();
    }
  });

  $(".dropdown_content a").click(
    function () {
      datasheet_model_selected = $(this).attr("model");
      datasheetWriteSelectboxes();
      datasheetWriteTable();
      $("#datasheet_select .dropdown").hide();
      return false;
    }
  );
  $(document).click(function(e){
    if($(e.target).attr("id") != "datasheet_select_box"){
      $("#datasheet_select .dropdown").hide();
    }
  });
}


function datasheetWriteSelectboxes() {
  $("#datasheet_select .select").html(datasheet_model[datasheet_model_selected]["model_name"]);
  $("#datasheet_select").show();
  if(datasheet_model[datasheet_model_selected]["configure_link"]) {
    $("#datasheet_select .configure a").attr("href", datasheet_model[datasheet_model_selected]["configure_link"]);
    $("#datasheet_select .configure").show();
  }
}

function datasheetWriteTable() {
  var datasheetTableCode = ''+
  '       <div class="modelImageContainer">' +
  '         <a class="modelImageMagnifier" href="javascript:void(0)"></a>' +
  '         <a class="datasheetPrint" href="javascript:void(0)"></a>' +
  '         <img class="modelImageSmall" src="" width="308" height="169">' +
  '       </div>' +
  '       <div class="dataTableColumnLeft">';

  var datasheetTableBreak = Math.floor(datasheetDisplaySections.length /2);

  for(h = 0; h < datasheetDisplaySections.length; h++) {
    var datasheetDisplayCurrentSection = false;
    if(datasheetTableBreak == h){
      datasheetTableCode += ''+
      '      </div>' +
      '      <div class="dataTableColumnRight">';
    }
    datasheetTableCode += '' +
    '        <table width="338" border="0" cellspacing="0" cellpadding="0">' +
    '          <tr>' +
    '            <td width="11"></td>' +
    '            <td width="192"></td>' +
    '            <td width="10"></td>' +
    '            <td width="120"></td>' +
    '            <td width="5"></td>' +
    '          </tr>';
    for(i = 0; i < datasheet_model[datasheet_model_selected].length; i++) {

      if(datasheetDisplaySections[h] == datasheet_model[datasheet_model_selected][i][0]){
        datasheetDisplayCurrentSection = true;
      }else if(datasheetDisplayCurrentSection && (datasheet_model[datasheet_model_selected][i][0] == "")) {
        datasheetDisplayCurrentSection = true;
      }else if(datasheet_model[datasheet_model_selected][i][0] != "" && datasheetDisplaySections[h] != datasheet_model[datasheet_model_selected][i][0]){
        datasheetDisplayCurrentSection = false;
      }
      if(datasheetDisplayCurrentSection){
        if(datasheet_model[datasheet_model_selected][i][0] != "") {
          datasheetTableCode += '' +
          '          <tr class="mc_table_headline">' +
          '            <td></td>' +
          '            <td colspan="4">' + datasheet_model[datasheet_model_selected][i][0] + '</td>' +
          '          </tr>' +
          '          <tr class="mc_table_seperator">' +
          '            <td colspan="5"></td>' +
          '          </tr>';
        }else if(datasheet_model[datasheet_model_selected][i][1] != "") {
          datasheetTableCode += '' +
          '          <tr class="mc_table_entry">' +
          '            <td></td>' +
          '            <td class="leftalign">' + datasheet_model[datasheet_model_selected][i][1] + '</td>' +
          '            <td></td>' +
          '            <td>' + datasheet_model[datasheet_model_selected][i][2] + '</td>' +
          '            <td></td>' +
          '          </tr>' +
          '          <tr class="mc_table_seperator">' +
          '            <td colspan="5"></td>' +
          '          </tr>';
        }
      }
    }
    datasheetTableCode += '        </table>';
  }
  datasheetTableCode += '       </div>';

  $("#datasheet_innertable").html(datasheetTableCode);
  if(datasheetTableCode != ""){
    $(".modelImageSmall").attr("src",datasheetImageList[$.inArray(datasheet_model_selected, datasheet_model_short) ]["small"]);
    $(".modelImageZoom").attr("src",datasheetImageList[$.inArray(datasheet_model_selected, datasheet_model_short) ]["large"]);
    $("#downloadDatasheet").hide();
    if(datasheetImageList[$.inArray(datasheet_model_selected, datasheet_model_short) ]["download"] != ""){
      $("#downloadDatasheet").attr("href",datasheetImageList[$.inArray(datasheet_model_selected, datasheet_model_short) ]["download"] + "?download=true" );
      if($("#datasheetZoomImage").css("display") == "none"){
        $("#downloadDatasheet").show();
      }
    }

    $(".modelImageMagnifier").click(function(){
      $("#datasheet_innertable").hide();
      $("#openDatasheetInfoLayer").hide();
      $("#downloadDatasheet").hide();
      $("#datasheetZoomImage").show();
    });

    $(".modelImageMinifier").click(function(){
      $("#datasheetZoomImage").hide();
      $("#datasheet_innertable").show();
      if(datasheetImageList[$.inArray(datasheet_model_selected, datasheet_model_short) ]["download"] != ""){
        $("#downloadDatasheet").show();
      }
      $("#openDatasheetInfoLayer").show();
      datasheetSetTableHeight();
    });

    $(".datasheetPrint").click(function(){
      window.print();
    });
  }
  $("#datasheetHiddenPrintLayer").html($("#datasheetInfoLayerBg").html());
  var tableContent = $("#datasheet_innertable").html();
  tableContent = tableContent.replace(/width=["]338["]/g, "width=\"645\"");
  tableContent = tableContent.replace(/width=["]120["]/g, "width=\"249\"");
  tableContent = tableContent.replace(/width=["]192["]/g, "width=\"370\"");
  tableContent = tableContent.replace(/width=338/g, "width=645");
  tableContent = tableContent.replace(/width=120/g, "width=249");
  tableContent = tableContent.replace(/width=192/g, "width=370");
  $("#datasheetHiddenPrintLayer").prepend(tableContent);
  $("#datasheetHiddenPrintLayer").prepend($("#datasheetZoomImage").html());
  $("#datasheetHiddenPrintLayer").prepend("<div class=\"printSubhead\">" + $("#datasheet_select .select").html() +"</div>");
  $("#datasheetHiddenPrintLayer").prepend("<div class=\"printHead\">" + $("#datasheet_head").html() +"</div>");
  $("#datasheetHiddenPrintLayer").prepend("<div class=\"printIdModuls\"><img src=\"" + buildValidServerRelativeUrl("/" + confCountryTopic + "/" + confLanguageTopic + "/_common/shared/img/id_moduls_grey.png") + "\"></div>");

  datasheetSetTableHeight();
}

// ******** OPK datasheet END ******** //

        var pageOid = "3362975";
        var vehicle_navigation_teaser = "r";

        $(document).ready(function(){
          initStandardPage();
          datasheetInit();
        });
        var datasheetDisplaySections =new Array();

        datasheetDisplaySections[0] = "Расход топлива";
        datasheetDisplaySections[1] = "Технические характеристики";
        datasheetDisplaySections[2] = "Масса";
        datasheetDisplaySections[3] = "Двигатель";
        datasheetDisplaySections[4] = "Колеса";


		var datasheetImageList = new Array();
<?foreach($arResult['technical'] as $tid=>$technical)
{?>
		datasheetImageList[<?=$tid?>] = new Array();
        datasheetImageList[<?=$tid?>]["small"] = buildValidServerRelativeUrl("<?=$arResult['technical_fields'][$tid]['PREVIEW_PICTURE']?>");
        datasheetImageList[<?=$tid?>]["large"] = buildValidServerRelativeUrl("<?=$arResult['technical_fields'][$tid]['DETAIL_PICTURE']?>");

        datasheetImageList[<?=$tid?>]["download"] = buildValidServerRelativeUrl("/upload/1-/1series.pdf");
              


<!-- VIPINCLUDE:bmw:<?=$technical['NAME']?> -->

		<?//$technical['NAME'] = str_replace(' ','',$technical['NAME']);?>
      compare_model['<?=$technical['NAME']?>'] = new Array();
      compare_model['<?=$technical['NAME']?>']['model_name'] = '<?=$arResult['NAME']?> <?=$technical['NAME']?>';
      compare_model['<?=$technical['NAME']?>']['short_model_name'] = '<?=$technical['NAME']?>';
      compare_model['<?=$technical['NAME']?>']['configure_link'] = '';
	<?$i=0;
	/////////////////////////////////////////////////////// MASS
	if(isset($technical["MASS"]["VALUE"][0]))
	{?>
		compare_model['<?=$technical['NAME']?>'][<?=$i?>] = new Array('Масса','','',false, 0);
		<?$i++;
		foreach($technical["MASS"]["VALUE"] as $pid => $mass)
		{?>
			compare_model['<?=$technical['NAME']?>'][<?=$i?>] = new Array('','<?=$mass?>','<?=$technical["MASS"]["DESCRIPTION"][$pid]?><br>',false, 0);
			<?$i++;
		}
	}
	///////////////////////////////////////////////////////// ENGINE
	if(isset($technical["ENGINE"]["VALUE"][0]))
	{?>
		compare_model['<?=$technical['NAME']?>'][<?=$i?>] = new Array('Двигатель','','',false, 0);
		<?$i++;
		foreach($technical["ENGINE"]["VALUE"] as $pid => $engine)
		{?>
			compare_model['<?=$technical['NAME']?>'][<?=$i?>] = new Array('','<?=$engine?><br>','<?=$technical["ENGINE"]["DESCRIPTION"][$pid]?><br>',false, 0);
			<?$i++;
		}
	}
	///////////////////////////////////////////////////////// TTX
	if(isset($technical["TTX"]["VALUE"][0]))
	{?>
		compare_model['<?=$technical['NAME']?>'][<?=$i?>] = new Array('Технические характеристики','','',false, 0);
		<?$i++;
		foreach($technical["TTX"]["VALUE"] as $pid => $ttx)
		{?>
			compare_model['<?=$technical['NAME']?>'][<?=$i?>] = new Array('','<?=$ttx?><br>','<?=$technical["TTX"]["DESCRIPTION"][$pid]?><br>',false, 0);
			<?$i++;
		}
	}
	////////////////////////////////////////////////////////////// GAS
	if(isset($technical["GAS"]["VALUE"][0]))
	{?>
		compare_model['<?=$technical['NAME']?>'][<?=$i?>] = new Array('Расход топлива','','',false, 0);
		<?$i++;
		foreach($technical["GAS"]["VALUE"] as $pid => $gas)
		{?>
			compare_model['<?=$technical['NAME']?>'][<?=$i?>] = new Array('','<?=$gas?><br>','<?=$technical["GAS"]["DESCRIPTION"][$pid]?><br>',false, 0);
			<?$i++;
		}
	}
	///////////////////////////////////////////////////////////// WHEELS
	if(isset($technical["WHEELS"]["VALUE"][0]))
	{?>
		compare_model['<?=$technical['NAME']?>'][<?=$i?>] = new Array('Колеса','','',false, 0);
		<?$i++;
		foreach($technical["WHEELS"]["VALUE"] as $pid => $wheels)
		{?>
			compare_model['<?=$technical['NAME']?>'][<?=$i?>] = new Array('','<?=$wheels?><br>','<?=$technical["WHEELS"]["DESCRIPTION"][$pid]?><br>',false, 0);
			<?$i++;
		}
	}?>

<!-- /VIPINCLUDE:bmw:<?=$technical['NAME']?> -->
		
<?}?>
	  </script>
<div id="facebook_like">
<iframe src="//www.facebook.com/plugins/like.php?href=<?= urlencode("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])?>&amp;send=false&amp;layout=button_count&amp;width=450&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font=arial&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:21px;" allowTransparency="true"></iframe>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>