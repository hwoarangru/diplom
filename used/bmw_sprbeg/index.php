<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("BMW � ��������");
?> 
<style type="text/css">
#completeText {
	left:30px;
}

#contentText {
	left:0px;
	padding-left:320px;
}

#copyText {
	width: 600px;
}
.divPanelTop{
	clear:both;
	width:604px;
	position: relative;
	left: 60px;
}

.divPanelTop A.divPanelLink2 {
	color: #4C4C4C;
	background: #FFF top right no-repeat url(/images/table.gif);
	padding-bottom: 6px;
	border-color: #999;
	border-bottom: 0px;
}

.divPanelTop A {
	position: relative;
	color: #4C4C4C;
	background: #FFF url(/images/table.gif) top right no-repeat;
	display: block;
	float: left;
	border: 0;
	padding: 5px 9px;
	border-left: 1px #999 solid;
	border-bottom: 1px #023499 solid;
	height:12px;
	width: 104px;
	-width: 122px;
	min-width: 99px;
	margin-right: 2px;
}

.divPanel{
	width: 604px;
	background-image: url(/images/divPanel.gif);
	background-position: -2px 0px;
	background-repeat: no-repeat;
	position: relative;
	clear: both;
	border: 1px #999 solid;
	left: 60px;
	top: -1px;
	padding: 7px 9px 4px;
	padding-top:0px;
	-moz-box-sizing: border-box;
	border-top:none;
}

.tableList { border-collapse: collapse; font-size: 11px;}
.tableList A { color: #000; }
.tableList TH{ white-space: nowrap; font-size: 11px; font-weight: normal; padding: 0 0 13px 15px; text-align: left; border: 0; border-bottom: 1px #999 solid; }
.tableList TD { border: 0; border-bottom: 1px #999 solid; padding: 1px 0px 1px 15px; cursor: pointer; height:34px;padding-top:0px;}
.tableList .first IMG	{ width: 49px; height: 34px; }
.tableList .first { width: 49px; padding-left: 0; height: 36px; }
.tableList TD.paging { border: 0; padding: 6px 0 0px !important; cursor: default; border-bottom: 0px none;}
.tableList DIV.paging { float: right; text-align: right; right: 0; }

.used-car{
	width: 260px;
	position:absolute;
	left:0px;
	top:0px;
	padding-bottom:50px;
	text-align: left;
}
.used-car .used-car-text{
	width: 260px;
}

#rightcontent {
margin-top: 53px !important;
left: 232px !important;
}

#selectcontainer {
padding-left: 15px !important;
background: #D3E4FF !important;
}
ul.tabs-nav {display:none !important;}
#largeTeaser{z-index:1;position:relative;}
#largeTeaser img{z-index:1}
 </style>
 	 
<div style=" width: 1000px; height: 720px; overflow: hidden;position:absolute;z-index:0;top: -20px;"> <iframe width="1040" style="padding-bottom: 35px; border: 0;" height="720" align="left" src="http://e4c.bmwgroup.com/eric/link/linkfromdealerpage.do?domain=BMW&amp;countryCode=RU&amp;lang=ru_RU&amp;eric4c&amp;startNewSession&amp;businessPartnerNumber=00197602" style="border: 0pt none;"> ��� ������� �� ������������ ��������� ������! </iframe> </div>
 <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>