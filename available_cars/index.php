<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("���� � �������");
$APPLICATION->IncludeComponent("adv:available_cars", ".default",
	Array('BRAND_NAME'=>''),
	false
);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>