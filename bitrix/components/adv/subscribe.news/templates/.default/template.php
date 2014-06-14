<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?
global $SUBSCRIBE_TEMPLATE_RUBRIC;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
    <title>Письмо сгенерировано автоматически</title>
	<style type="text/css">
html, body, div, span, applet, object, iframe,
h1, h2, h3, h4, h5, h6, p, blockquote, pre,
a, abbr, acronym, address, big, cite, code,
del, dfn, em, font, img, ins, kbd, q, s, samp,
small, strike, strong, sub, sup, tt, var,
dl, dt, dd, ol, ul, li,
fieldset, form, label, legend,
table, caption, tbody, tfoot, thead, tr, th, td {padding: 0; margin: 0;}

.h{margin-bottom:5px; height:20px;}

.cl:after {display: block; content: '.'; clear: both; height: 0; visibility: hidden;}
*.cl {zoom: 1;}

html, body {background: #fff;}
body {position: relative; font: 12px Verdana,sans-serif; color: #121212;}

table {border-collapse: collapse;}
td {font: 12px Verdana,sans-serif; color: #121212; vertical-align: top;}

#header, #main, #footer {margin: auto; position: relative;}
#footer {font-size: 11px;}

img {border: 0;}
a {color: #227fb2; text-decoration: underline;}
a:hover {text-decoration: none;}
a.link {font-size: 11px;}

.date {font-size: 11px; color: #666;}

#header .links {list-style: none; position: absolute; right: 0; top: 20px;}
#header .link4 {margin-left: 28px;}
#header .link3 {margin-left: 46px;}
#header .link2 {margin-left: 55px;}
#header .logo {margin-top: 10px;}
#header .slogan {width: 283px; height: 13px; position: relative; margin-top: 23px;}
#header .slogan b {display: block; width: 283px; height: 13px; position: absolute; left: 0; top: 0; background: url('://www.indep.ru/images/subscribe-news/slogan.gif');}

#main .content {width: 650px;}

h1.h1News {font: 22px Tahoma,sans-serif; font-style: normal; margin-bottom: 7px; color: #0a4c88; text-transform: uppercase;}

.news  {padding-right: 120px;}
.news .row {padding-top: 20px;}
.news .row a {font-weight: bold; display: block; padding: 5px 0 17px;}
h4 { margin-bottom:0; padding-bottom:0; }
.phone  {color: #000000; display: block; font-size: 28px; letter-spacing: -1px; text-align: right;}
	</style>
</head>
<body>
<table align="center"><tr><td width="50%"></td><td width="880px">
<div id="header">
	<table style="width: 880px; height: 100px;"><tr>
		<td style="height: 100px;" width="283">
			<img src="http://www.bmw-indep.ru/images/indepGroup.jpg" class="logo" alt="Независимость - группа компаний"/>
		</td>
		<td>
	    </td>
	</tr></table>
</div>

<div id="main" class="cl">
	<table class="content">
		<tr>
			<td>
				<font face="EtelkaLightProBold, arial, helvetica, sans-serif" size="1" style="font-size:21px; line-height:18px;"><?=$arResult['TITLE_TEXT']?></font>
				<div class="news" style="padding-top:10px">
					<table><?

foreach($arResult['ITEMS'] as $arItem)
{
	?>
	<tr>
		<td colspan="2">
			<font face="EtelkaLightProBold, arial, helvetica, sans-serif" size="1" style="font-size:13px; line-height:18px;">
				<a style="color:#40627f;" href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem['NAME']?></a>
			</font>
		</td>
	</tr>
	<tr>
		<td width="100px" style="padding-top:10px;"><?

	if (strLen($arItem['PREVIEW_PICTURE']) > 0)
	{
		?><p><img src="<?=$arItem['PREVIEW_PICTURE']?>" /></p><?
	}

	?></td>
		<td style="padding-top:5px;" valign="top">
			<p>
				<font face="arial, helvetica, sans-serif" size="1" style="font-size:11px; line-height:18px; color:#9b9b9b;"><?=$arItem['DATE_ACTIVE_FROM']?></font>
			</p>
			<p>
				<font face="arial, helvetica, sans-serif" size="1" style="font-size:13px; line-height:20px;"><?=$arItem["PREVIEW_TEXT"]?></font>
			</p>
		</td>
	</tr><?
}?>
					</table>
		        </div>
			</td>
		</tr>
	</table>
	<br /><br />
</div>

<div id="footer">
	<br/>
	<table style="width: 100%"><tr>
	<td>
		<span style="color: #999; font-size: 11px;">© 2012. ГРУППА КОМПАНИЙ НЕЗАВИСИМОСТЬ.</span>		
		<img src="http://www.indep.ru/images/subscribe-news/arrow.gif" border="0"> 
		<a href="http://www.indep.ru" class="link col3">www.indep.ru</a>                <br />
<span style="color: #333; font-size: 11px;"><a href="http://www.bmw-indep.ru/">Независимость BMW.</a> Проспект 60-летия Октября, д. 6, + 7 (495) 787-80-08<br />
г. Котельники, Коммерческий проезд, д. 10, 14 км МКАД (внешний радиус), + 7 (495) 787-80-08<br />
Время работы: ежедневно, с 10:00 до 22:00.</span>	
	</td>
	<td>
		
	</td>
	<td align="right">

	</td>
	</tr>
	</table>
	<br/><br/>
</div>
</td><td width="50%"></td></tr></table>
</body>
</html>