<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

$APPLICATION->SetTitle("Файл не найден - BMW Независимость");
?>

<script type="text/javascript">
$(function(){
if(null == document.getElementById('contentText')){
	$('._contentText_').attr('id', 'contentText');
	}
});

</script>

<div id="stage">
</div>

<div class="_contentText_">

<div id="innerPageContent">
    <h1>404 HTTP Status:  Файл не найден</h1>
<p>
	<b>Возможно, эта страница была удалена, переименована, или она временно недоступна.</b>
</p>

<p>Попробуйте следующее:</p>
<ul>
	<li>Проверьте правильность адреса страницы в строке адреса,</li>
	<li>Перейдите на <a href="/">главную страницу</a>, затем найдите там ссылки на нужные Вам данные,</li>
	<li>Вернитесь <a href="javascript:history.back()">назад</a>, чтобы использовать другую ссылку.</li>
	<li>Воспользуйтесь <a href="/search/">поиском</a> или <a href="/map/">картой сайта</a>  для нахождения нужной Вам информации на сайте.</li>
</ul>					</div>
</div>
<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php"); ?> 