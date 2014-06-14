<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<html>
<head>
<link href="/bitrix/templates/.default/components/bitrix/menu/horizontal_top_drop/style.css" type="text/css" rel="stylesheet" />
<link href="/bitrix/templates/.default/components/bitrix/menu/horizontal_top_sec/style.css" type="text/css" rel="stylesheet" />
<link href="/bitrix/templates/.default/components/bitrix/menu/localnav/style.css" type="text/css" rel="stylesheet" />
<link href="/bitrix/templates/.default/components/bitrix/catalog.element/model_detail/style.css" type="text/css" rel="stylesheet" />
<link href="/bitrix/templates/.default/components/bitrix/menu/bottom_menu/style.css" type="text/css" rel="stylesheet" />
<link href="/bitrix/templates/bmw_inner_2/styles.css" type="text/css" rel="stylesheet" />
<link href="/bitrix/templates/bmw_inner_2/template_styles.css" type="text/css" rel="stylesheet" />
</head>
<body onload="parent.ifWorkspace.focus();parent.ifWorkspace.print();">
<style type="text/css">
#contentText {padding-left:140px;padding-top:10px;//padding-left:20px;}
td.data              {padding-top:1px; padding-bottom:2px;font-size:8.5pt;}
#lense               {position:absolute; top:  25px;left: 80px; //left: 20px;width: 19px; height: 18px;}
#modelNavigation     {position:absolute; top:  0px; left: 80px; //left: 20px; width:662px; height: 23px; z-index:1; overflow:hidden;}
#disclaimer          {position:absolute; top:  2px; left:130px; //left: 20px; width:672px; height: 605px; //height:470px; z-index:3; visibility:hidden; background-color:#ffffff;}
#disclaimerInline    {position:absolute; top:  0px; left:  0px; width:326px; height:470px;}
#lenseZoom           {position:absolute; top:  9px; left:  8px; width: 19px; height: 18px;}
div.loaderZoom       {position:absolute; top:352px; left:637px; width: 87px; height: 65px; z-index:3; visibility:hidden;}
div.loaderData       {position:absolute; top:152px; left:315px; width: 87px; height: 65px; z-index:3; visibility:hidden;}
div.leftColumnMulti  {position:absolute; top:100px; //left:20px; width:326px;               z-index:1; overflow;hidden; }
div.rightColumnMulti {position:absolute; top: 25px; left:416px; //left:356px; width:326px;               z-index:1; overflow;hidden; }
div.zoomMulti        {position:absolute; top:  0px; left:60px; //left:  0px; width:700px; height:auto;  z-index:10; display:none; background-color:#ffffff;}
div.zoomSingle       {position:absolute; top:106px; left:  0px; width:679px; height:auto;  z-index:2; visibility:hidden; background-color:#ffffff;}
div.leftColumnSingle {position:absolute; top:106px; left: 20px; width:326px;               z-index:1; overflow;hidden; }
div.rightColumnSingle{position:absolute; top:106px; left:356px; width:326px;               z-index:1; overflow;hidden;}
div.loaderDataSingle {position:absolute; top:121px; left:300px; width: 87px; height: 65px; z-index:3; visibility:hidden;}
#printIcon           {position:absolute; top: 25px; left: 60px; //left:  0px; width:20px;                z-index:5; visibility:;}
#modelNavigation a{
background: url('/images/arrow.gif') 0px 4px no-repeat;
font-size:11px;
font-family: arial,helvetica,sans-serif;
margin: -1px auto 3px;
padding: 0px 0px 0px 8px;
}
</style>
<script>
var cont = parent.document.getElementById('tech_inf<?=$_GET["tech"]?>').innerHTML;
document.write(cont);
</script>
</body>
</html>
