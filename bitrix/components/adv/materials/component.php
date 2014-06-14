<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arDefaultUrlTemplates404 = array(
    "list" => "index.php",
    "detail" => "section/#SECTION_ID#/#ELEMENT_ID#",
    "section" => "section/#SECTION_ID#"

);

$arDefaultVariableAliases404 = Array(
    "list"=>array(),
    "detail"=>array(),
);

$arComponentVariables = Array(
    "ELEMENT_ID",
    "SECTION_ID",
);

$arDefaultVariableAliases = Array(
    "ELEMENT_ID"=>"ELEMENT_ID",
    "SECTION_ID"=>"SECTION_ID",
);

if($arParams["SEF_MODE"] == "Y")
{
    $arUrlTemplates = CComponentEngine::makeComponentUrlTemplates($arDefaultUrlTemplates404, $arParams["SEF_URL_TEMPLATES"]);

    $arVariableAliases = CComponentEngine::MakeComponentVariableAliases($arDefaultVariableAliases404, $arParams["VARIABLE_ALIASES"]);

    $componentPage = CComponentEngine::ParseComponentPath(
        $arParams["SEF_FOLDER"],
        $arUrlTemplates,
        $arVariables
    );

    if(!$componentPage) {
        $componentPage = "list";
    }

    CComponentEngine::InitComponentVariables($componentPage, $arComponentVariables, $arVariableAliases, $arVariables);
    $arResult = array(
            "FOLDER" => $arParams["SEF_FOLDER"],
            "URL_TEMPLATES" => $arUrlTemplates,
            "VARIABLES" => $arVariables,
            "ALIASES" => $arVariableAliases
        );
}
else
{
	$arVariableAliases = CComponentEngine::MakeComponentVariableAliases($arDefaultVariableAliases, $arParams["VARIABLE_ALIASES"]);
	CComponentEngine::InitComponentVariables(false, $arComponentVariables, $arVariableAliases, $arVariables);

	$componentPage = "";

	if(isset($arVariables["ELEMENT_ID"]) && intval($arVariables["ELEMENT_ID"]) > 0)
		$componentPage = "detail";
	else
		$componentPage = "list";

	$arResult = array(
			"FOLDER" => "",
			"URL_TEMPLATES" => Array(
				"index" => htmlspecialchars($APPLICATION->GetCurPage()),
				"detail" => htmlspecialchars($APPLICATION->GetCurPage()."?".$arVariableAliases["ELEMENT_ID"]."=#ELEMENT_ID#"),
			),
			"VARIABLES" => $arVariables,
			"ALIASES" => $arVariableAliases
		);
}
//echo $componentPage;
$this->IncludeComponentTemplate($componentPage);

?>