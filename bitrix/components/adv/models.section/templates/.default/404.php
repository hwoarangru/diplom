<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$GLOBALS['APPLICATION']->SetAdditionalCSS('/bitrix/templates/bmw_inner/styles.css');
CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

$APPLICATION->SetTitle("Файл не найден - BMW-Независимость");
?>

<style type="text/css">
body > *{color: #363636;;}
#contenttext{
padding: 50px 0 30px 280px;
top: 0;
width: 730px;
}

a, a:visited, a:active, a:link {
font-family: arial,helvetica,sans-serif;
color:#777777;
text-decoration: none;
}

a:hover {
color:#003399;
}

#contenttext p{
margin-bottom: 1em;
}

ul {
    list-style-position: inside;
}
ul, menu, dir {
    list-style-type: disc;
}
li {
    display: list-item;
    text-align: -webkit-match-parent;
    line-height: 13px;
    padding-top: 3px;
}

h1 {
    font-size: 20px;
padding-bottom: 3px;
line-height: 21px;
margin: 0px;
font-weight: normal;
}
</style>


<div id="contenttext">
    <h1>404 HTTP Status:  Файл не найден</h1>
<p>
	<b>Возможно, эта страница была удалена, переименована, или она временно недоступна.</b>
</p>
<p>
	Попробуйте следующее:
</p>
<ul>
	<li>Проверьте правильность адреса страницы в строке адреса,</li>
	<li>Перейдите на <a href="/">главную страницу</a>, затем найдите там ссылки на нужные Вам данные,</li>
	<li>Вернитесь <a href="javascript:history.back()">назад</a>, чтобы использовать другую ссылку.</li>
	<li>Воспользуйтесь <a href="/search/">поиском</a> или <a href="/sitemap/">картой сайта</a>  для нахождения нужной Вам информации на сайте.</li>
</ul>					
</div>

<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php"); ?>