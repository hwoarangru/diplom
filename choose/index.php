<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Конфигуратор");
?>

<iframe wmode="opaque" src="http://ebsm.bmwgroup.com/ecomlight50/RFCIServlet?wmode=opaque&_service=vco&_brand=BM&_country=RU" frameborder="0" name="external" id="external" scrolling="auto" width="1010" height="800" style="z-index:-1;margin-left: -300px;margin-top: 2px;"></iframe>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('body').height(800);
	jQuery('#footer').css("position", "absolute");
	jQuery('#footer').css("top", "989px");
});	
</script>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>