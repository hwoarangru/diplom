<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Спецпредложения");?>
<?$APPLICATION->IncludeComponent("adv:outlet_experiment", ".default",
	Array(
		'FORMS' => Array(
			'OFFER' => 'OUTLET_EX_OFFER',
			'CALLBACK' => 'OUTLET_EX_CALLBACK'
		)
	),
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>