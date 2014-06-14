<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?

define('FORM_MODEL_IBLOCK', 262);

if (CModule::IncludeModule("form"))
{
	$arDefaultComponentParameters = array(
		"WEB_FORM_ID" => $_REQUEST["WEB_FORM_ID"],
		"SEF_MODE" => "N",
		"IGNORE_CUSTOM_TEMPLATE" => "N",
		"USE_EXTENDED_ERRORS" => "N",
		"CACHE_TIME" => "3600",
	);

	foreach ($arDefaultComponentParameters as $key => $value) if (!is_set($arParams, $key)) $arParams[$key] = $value;
	
	$arDefaultUrl = array(
		'LIST' => $arParams["SEF_MODE"] == "Y" ? "list/" : "result_list.php", 
		'EDIT' => $arParams["SEF_MODE"] == "Y" ? "edit/#RESULT_ID#/" : "result_edit.php"
	);
	
	foreach ($arDefaultUrl as $action => $url)
	{
		if (!is_set($arParams, $action.'_URL'))
		{
			if (!is_set($arParams, 'SHOW_'.$action.'_PAGE') || $arParams['SHOW_'.$action.'_PAGE'] == 'Y')
				$arParams[$action.'_URL'] = $url;
		}
	}
	
	if (isset($arParams['RESULT_ID']))
		unset($arParams['RESULT_ID']);
	
	//  insert chain item
	if (strlen($arParams["CHAIN_ITEM_TEXT"]) > 0)
	{
		$APPLICATION->AddChainItem($arParams["CHAIN_ITEM_TEXT"], $arParams["CHAIN_ITEM_LINK"]);
	}
	
	// check whether cache using needed
	$bCache = !(
		$_SERVER["REQUEST_METHOD"] == "POST" 
		&& 
		(
			!empty($_REQUEST["web_form_submit"]) 
			|| 
			!empty($_REQUEST["web_form_apply"])
		)
		||
		$_REQUEST['formresult'] == 'ADDOK'
	) 
	&& 
	!(
		$arParams["CACHE_TYPE"] == "N" 
		|| 
		(
			$arParams["CACHE_TYPE"] == "A" 
			&& 
			COption::GetOptionString("main", "component_cache_on", "Y") == "N" 
		)
		||
		(
			$arParams["CACHE_TYPE"] == "Y"
			&&
			intval($arParams["CACHE_TIME"]) <= 0
		)
	);
	
	// start caching
	if ($bCache)
	{
		// append arParams to cache ID;
		$arCacheParams = array();
		foreach ($arParams as $key => $value) if (substr($key, 0, 1) != "~") $arCacheParams[$key] = $value;
		// create CPHPCache class instance
		$obFormCache = new CPHPCache;
		// create cache ID and path
		$CACHE_ID = SITE_ID."|".$componentName."|".md5(serialize($arCacheParams))."|".$USER->GetGroups();
		$CACHE_PATH = "/".SITE_ID.CComponentEngine::MakeComponentPath($componentName);
	}

	// initialize cache
	if ($bCache && $obFormCache->InitCache($arParams["CACHE_TIME"], $CACHE_ID, $CACHE_PATH))
	{
		// if cache already exists - get vars
		$arCacheVars = $obFormCache->GetVars();
		$bVarsFromCache = true;
		
		$arResult = $arCacheVars["arResult"];
		
		if ($arParams["IGNORE_CUSTOM_TEMPLATE"] == "N" && $arResult["arForm"]["USE_DEFAULT_TEMPLATE"] == "N" && strlen($arResult["arForm"]["FORM_TEMPLATE"]) > 0)
		{
			$FORM = $arCacheVars["FORM"];
			if (!$FORM) $bVarsFromCache = false;
		}
		$arResult['FORM_NOTE'] = '';
		$arResult['isFormNote'] = 'N';
	}
	else
	{
/*************************************************************************************************/
		$bVarsFromCache = false;
		
		$arResult["bSimple"] = COption::GetOptionString("form", "SIMPLE", "Y") == "N" ? "N" : "Y";
		$arResult["bAdmin"] = defined("ADMIN_SECTION") && ADMIN_SECTION===true ? "Y" : "N";

		// if form taken from admin interface - check rights to form module
		if ($arResult["bAdmin"] == "Y")
		{
			$FORM_RIGHT = $APPLICATION->GetGroupRight("form");
			if($FORM_RIGHT<="D") $APPLICATION->AuthForm(GetMessage("ACCESS_DENIED"));
		}
		
		if (intval($arParams['WEB_FORM_ID']) <= 0 && strlen($arParams['WEB_FORM_ID']) > 0)
		{
			$obForm = CForm::GetBySID($arParams['WEB_FORM_ID']);
			if ($arForm = $obForm->Fetch())
			{
				$arParams['WEB_FORM_ID'] = $arForm['ID'];
			}
		}
		
		
		// check WEB_FORM_ID and get web form data
		$arParams["WEB_FORM_ID"] = CForm::GetDataByID($arParams["WEB_FORM_ID"], $arResult["arForm"], $arResult["arQuestions"], $arResult["arAnswers"], $arResult["arDropDown"], $arResult["arMultiSelect"], $arResult["bAdmin"] == "Y" || $arParams["SHOW_ADDITIONAL"] == "Y" || $arParams["EDIT_ADDITIONAL"] == "Y" ? "ALL" : "N");
		
		$arResult["WEB_FORM_NAME"] = $arResult["arForm"]["SID"];
	
		// if wrong WEB_FORM_ID return error;
		if ($arParams["WEB_FORM_ID"] > 0) 
		{
			// check web form rights;
			$arResult["F_RIGHT"] = intval(CForm::GetPermission($arParams["WEB_FORM_ID"]));
			
			// in no form access - return error
			if ($arResult["F_RIGHT"] < 10)
			{
				$arResult["ERROR"] = "FORM_ACCESS_DENIED";
			}
		}
		else
		{
			$arResult["ERROR"] = "FORM_NOT_FOUND";
		}
	}
	if (strlen($arResult["ERROR"]) <= 0)
	{
		// ************************************************************* //
		//                                             get/post processing                                             //
		// ************************************************************* //
		$arResult["arrVALUES"] = array();
		
		//echo '<pre>'; print_r($_REQUEST); echo '</pre>';
		
		if (($_POST['WEB_FORM_ID'] == $arParams['WEB_FORM_ID'] || $_POST['WEB_FORM_ID'] == $arResult['arForm']['SID']) && (strlen($_REQUEST["web_form_submit"])>0 || strlen($_REQUEST["web_form_apply"])>0))
		{
			$arResult["arrVALUES"] = $_REQUEST;
			
			// check errors
			$arResult["FORM_ERRORS"] = CForm::Check($arParams["WEB_FORM_ID"], $arResult["arrVALUES"], false, "Y", $arParams['USE_EXTENDED_ERRORS']);
                        
                           //var_dump($arResult['FORM_ERRORS']);
                           if ((!isset($_POST["list"]))||($_POST["list"] == "")){
                              $flag = true;
                              if ($_POST["form_text_".$_SESSION["first_model"]] == "") $flag=false;
                              if ($flag){
                              $arResult["list"] = 2;
                              //$_SESSION["list"] = 2;
                              $arResult['FORM_ERRORS'] = "";
                              $arResult['FORM_ERRORS']['nextLevel'] ="next";
                              } else {
                                $arResult["View_Message"] = true;
                              }
                           } else {
                             //echo('!!!!');
                             if ($_POST["list"] == "2"){
                              $flag = true;
                              //var_dump($arResult['FORM_ERRORS']);
                              if ((isset($arResult['FORM_ERRORS']["fio_surname"]))||(isset($arResult['FORM_ERRORS']["fio_name"]))||(isset($arResult['FORM_ERRORS']["fio_patronymic"]))||(isset($arResult['FORM_ERRORS']["contact_cellular"]))||(isset($arResult['FORM_ERRORS']["contact_email"]))||(isset($arResult['FORM_ERRORS']["contact_rather"]))) $flag = false;
                              if ($flag){
                              $arResult["list"] = 3;
                              //$_SESSION["list"] = 3;
                              $arResult['FORM_ERRORS'] = "";
                              $arResult['FORM_ERRORS']['nextLevel'] ="next";
                              } else {
                                $arResult["list"] = 2;
                                $arResult["View_Message"] = true;
                              }
                             }
                             else {
                               $arResult["list"] = 3;
                               if (isset($arResult['FORM_ERRORS'])){
                                   $arResult["View_Message"] = true;
                               }
                               if (!isset($_POST["send"])){
                                  $arResult['FORM_ERRORS']['send'] ="send";
                               }
                               //var_dump($arResult['FORM_ERRORS']);
                             }
                           }
			if (
				$arParams['USE_EXTENDED_ERRORS'] == 'Y' && (!is_array($arResult["FORM_ERRORS"]) || count($arResult["FORM_ERRORS"]) <= 0)
				||
				$arParams['USE_EXTENDED_ERRORS'] != 'Y' && strlen($arResult["FORM_ERRORS"]) <= 0
			)
			{
				// check user session
                                $next = true;
				if (check_bitrix_sessid())
				{
					$return = false;
					// add result
					if($RESULT_ID = CFormResult::Add($arParams["WEB_FORM_ID"], $arResult["arrVALUES"]))
					{

						//$arResult["FORM_NOTE"] = GetMessage("FORM_DATA_SAVED1").$RESULT_ID.GetMessage("FORM_DATA_SAVED2");
						$arResult["FORM_RESULT"] = 'addok';
						
/*
$EMAIL_TO = array();
$answer = CFormAnswer::GetByID($_REQUEST['form_radio_carshop_diller']);

$mess = $answer->Fetch();

if ($mess['MESSAGE'] != '����� ����'){
$EMAIL_TO[] = 'kirill.romanov@bmw-indep.ru';
$EMAIL_TO[] = 'aleksandr.rozhnov@bmw-indep.ru';

	
} else {	

$EMAIL_TO[] = 'roman.chernousov@bmw-indep.ru';
$EMAIL_TO[] = 'dmitriy.shcheverov@bmw-indep.ru';

}

$arFields = array("EMAIL_TO" => implode(",", $EMAIL_TO));
CEvent::Send("FORM_FILLING_test_drive", array("ru", "en"), $arFields);
*/
# ���, ���� ��� �������� �� �����, �.�. ��� �������� ����������� ������� ���������� ��������� ��� ��� ����
# � ������� arFields. ��� �� ����������� ������ 'EMAIL_TO'. ����� ���������, ���������� ��������� �� ������� b_event


						// send email notifications
						CFormResult::SetEvent($RESULT_ID);
						CFormResult::Mail($RESULT_ID);
						
						// choose type of user redirect and do it
						
						if ($arResult["F_RIGHT"] >= 15)
						{

							if (strlen($_REQUEST["web_form_submit"])>0 && strlen($arParams["LIST_URL"]) > 0)
							{
								if ($arParams["SEF_MODE"] == "Y")
								{
									//LocalRedirect($arParams["LIST_URL"]."?strFormNote=".urlencode($arResult["FORM_NOTE"]));
									LocalRedirect(
										str_replace(
											array('#WEB_FORM_ID#', '#RESULT_ID#'),
											array($arParams['WEB_FORM_ID'], $RESULT_ID),
											$arParams["LIST_URL"]
										)."?formresult=".urlencode($arResult["FORM_RESULT"])
									);
								}
								else
								{
									//LocalRedirect($arParams["LIST_URL"].(strpos($arParams["LIST_URL"], "?") === false ? "?" : "&")."WEB_FORM_ID=".$arParams["WEB_FORM_ID"]."&RESULT_ID=".$RESULT_ID."&strFormNote=".urlencode($arResult["FORM_NOTE"]));
									LocalRedirect(
										$arParams["LIST_URL"]
										.(strpos($arParams["LIST_URL"], "?") === false ? "?" : "&")
										."WEB_FORM_ID=".$arParams["WEB_FORM_ID"]
										."&RESULT_ID=".$RESULT_ID
										."&formresult=".urlencode($arResult["FORM_RESULT"])
									);
								}
							}
							elseif (strlen($_REQUEST["web_form_apply"])>0 && strlen($arParams["EDIT_URL"])>0)
							{
								if ($arParams["SEF_MODE"] == "Y")
								{
									//LocalRedirect(str_replace("#RESULT_ID#", $RESULT_ID, $arParams["EDIT_URL"])."?strFormNote=".urlencode($arResult["FORM_NOTE"]));
								LocalRedirect(
										str_replace(
											array('#WEB_FORM_ID#', '#RESULT_ID#'),
											array($arParams['WEB_FORM_ID'], $RESULT_ID),
											$arParams["EDIT_URL"]
										)
										.(strpos($arParams["EDIT_URL"], "?") === false ? "?" : "&")
										."formresult=".urlencode($arResult["FORM_RESULT"])
									);
								}
								else
								{
									LocalRedirect(
										$arParams["EDIT_URL"]
										.(strpos($arParams["EDIT_URL"], "?") === false ? "?" : "&")
										."WEB_FORM_ID=".$arParams["WEB_FORM_ID"]
										."&RESULT_ID=".$RESULT_ID
										."&formresult=".urlencode($arResult["FORM_RESULT"])
									);
								}
								die();
							}
							
							$arResult["return"] = true;
						}

						if (strlen($arParams["SUCCESS_URL"]) > 0)
						{
							if ($arParams['SEF_MODE'] == 'Y')
							{
								LocalRedirect(
									str_replace(
										array('#WEB_FORM_ID#', '#RESULT_ID#'),
										array($arParams['WEB_FORM_ID'], $RESULT_ID),
										$arParams["SUCCESS_URL"]
									)
									.(strpos($arParams["SUCCESS_URL"], "?") === false ? "?" : "&")
									."formresult=".urlencode($arResult["FORM_RESULT"])
								);
							}
							else
							{
								LocalRedirect(
									$arParams["SUCCESS_URL"]
									.(strpos($arParams["SUCCESS_URL"], "?") === false ? "?" : "&")
									."WEB_FORM_ID=".$arParams["WEB_FORM_ID"]
									."&RESULT_ID=".$RESULT_ID
									."&formresult=".urlencode($arResult["FORM_RESULT"])
								);
							}
							
							die();
						}
						elseif ($arParams["SEF_MODE"] == "Y")
						{
							LocalRedirect(
								$APPLICATION->GetCurPageParam(
									"formresult=".urlencode($arResult["FORM_RESULT"]), 
									array('formresult', 'strFormNote', 'SEF_APPLICATION_CUR_PAGE_URL')."?add=true"
								)
							);
							
							die();
						}
						else
						{
							LocalRedirect(
								$APPLICATION->GetCurPageParam(
									"WEB_FORM_ID=".$arParams["WEB_FORM_ID"]
									."&RESULT_ID=".$RESULT_ID
									."&formresult=".urlencode($arResult["FORM_RESULT"]), 
									array('formresult', 'strFormNote', 'WEB_FORM_ID', 'RESULT_ID')."?add=true"
								)
							);
							
							die();
							//LocalRedirect($APPLICATION->GetCurPage()."?WEB_FORM_ID=".$arParams["WEB_FORM_ID"]."&strFormNote=".urlencode($arResult["FORM_NOTE"]));
						}
					}
					else
					{
						if ($arParams['USE_EXTENDED_ERRORS'] == 'Y')
							$arResult["FORM_ERRORS"] = array($GLOBALS["strError"]);
						else
							$arResult["FORM_ERRORS"] = $GLOBALS["strError"];
					}
				}
			}
		}
		
		/*
		if (is_array($arResult["FORM_ERRORS"])) 
		{
			$arResult["FORM_ERRORS"] = implode("<br />", $arResult["FORM_ERRORS"]);
		}
		*/
		
		//if (!empty($_REQUEST["strFormNote"])) $arResult["FORM_NOTE"] = $_REQUEST["strFormNote"];
		if (!empty($_REQUEST["formresult"]) && $_REQUEST['WEB_FORM_ID'] == $arParams['WEB_FORM_ID']) 
		{
			$formResult = strtoupper($_REQUEST['formresult']);
			switch ($formResult)
			{
				case 'ADDOK':
					$arResult['FORM_NOTE'] = str_replace("#RESULT_ID#", $RESULT_ID, GetMessage('FORM_NOTE_ADDOK'));
			}
		}
		
		$arResult["isFormErrors"] = 
			(
				$arParams['USE_EXTENDED_ERRORS'] == 'Y' && is_array($arResult["FORM_ERRORS"]) && count($arResult["FORM_ERRORS"]) > 0
				||
				$arParams['USE_EXTENDED_ERRORS'] != 'Y' && strlen($arResult["FORM_ERRORS"]) > 0
			)
			? "Y" : "N";
				
		// ************************************************************* //
		//                                             output                                                                    //
		// ************************************************************* //

		//echo '<pre>'; print_r($arResult['arForm']); echo '</pre>';
		
		if ($arParams["IGNORE_CUSTOM_TEMPLATE"] == "N" && $arResult["arForm"]["USE_DEFAULT_TEMPLATE"] == "N" && strlen($arResult["arForm"]["FORM_TEMPLATE"]) > 0)
		{
			// use visual template
			if (!$bCache || $bCache && !$bVarsFromCache)
			{
				if ($bCache)
				{
					$obFormCache->StartDataCache();
				}
				
				//if (is_array($arResult['FORM_ERRORS']))
					//$arResult['FORM_ERRORS'] = implode('<br />', $arResult['FORM_ERRORS']);
				
				$FORM = new CFormOutput();
				// initialize template
				
				
				$FORM->InitializeTemplate($arParams, $arResult);
				//echo '<pre>',htmlspecialchars(print_r($arParams, true)),htmlspecialchars(print_r($arResult, true)),htmlspecialchars(print_r($FORM, true)),'</pre>';
				
				// cache image files paths
				$FORM->ShowFormImage();
				$FORM->getFormImagePath();

				if ($bCache)
				{
					$obFormCache->EndDataCache(
						array(
							"arResult" => $arResult,
							"FORM" => $FORM,
						)
					);
				}
			}
			else
			{
				$FORM->strFormNote = $arResult['FORM_NOTE'];
				$FORM->isFormNote = (bool)$arResult['FORM_NOTE'];
			}
		
			// if form uses CAPCHA initialize it
			if ($arResult["arForm"]["USE_CAPTCHA"] == "Y") $FORM->CAPTCHACode = $arResult["CAPTCHACode"] = $APPLICATION->CaptchaGetCode();
		
			// get template
			if ($strReturn = $FORM->IncludeFormCustomTemplate())
			{
				// add icons
				$back_url = $_SERVER['REQUEST_URI'];
				
				$editor = "/bitrix/admin/fileman_file_edit.php?full_src=Y&site=".SITE_ID."&";
				$href = "javascript:window.location='".$editor."path=".urlencode($path)."&lang=".LANGUAGE_ID."&back_url=".urlencode($back_url)."'";
				
				if ($arParams['USE_EXTENDED_ERRORS'] == 'Y')
					$APPLICATION->SetAdditionalCSS($this->GetPath()."/error.css");
				
				if ($APPLICATION->GetShowIncludeAreas() && $USER->IsAdmin())
				{
					$APPLICATION->SetAdditionalCSS($this->GetPath()."/icons.css");
					// define additional icons for Site Edit mode
					$arIcons = array(
						// form template edit icon
						array(
							'URL' => "javascript:".$APPLICATION->GetPopupLink(
								array(
									'URL' => "/bitrix/admin/form_edit.php?bxpublic=Y&from_module=form&lang=".LANGUAGE_ID."&ID=".$FORM->WEB_FORM_ID."&tabControl_active_tab=edit5&back_url=".urlencode($_SERVER["REQUEST_URI"]),
									'PARAMS' => array(
										'width' => 700,
										'height' => 500,
										'resize' => false,
									)
								)
							),
							'ICON' => 'form-edit-tpl',
							'TITLE' => GetMessage("FORM_PUBLIC_ICON_EDIT_TPL")
						),
						
						// form params edit icon
						/*array(
							'URL' => "/bitrix/admin/form_edit.php?lang=".LANGUAGE_ID."&ID=".$FORM->WEB_FORM_ID."&back_url=".urlencode($_SERVER["REQUEST_URI"]),
							'ICON' => 'form-edit',
							'TITLE' => GetMessage("FORM_PUBLIC_ICON_EDIT")
						),*/

						array(
							'URL' => "javascript:".$APPLICATION->GetPopupLink(
								array(
									'URL' => "/bitrix/admin/form_edit.php?bxpublic=Y&from_module=form&lang=".LANGUAGE_ID."&ID=".$FORM->WEB_FORM_ID."&back_url=".urlencode($_SERVER["REQUEST_URI"]),
									'PARAMS' => array(
										'width' => 700,
										'height' => 500,
										'resize' => false,
									)
								)
							),
							'ICON' => 'form-edit',
							'TITLE' => GetMessage("FORM_PUBLIC_ICON_EDIT"),
							'DEFAULT' => ($APPLICATION->GetPublicShowMode() != 'configure' ? true : false),
							"MODE" => array("edit", "configure"),
						),
					);
					
					$this->AddIncludeAreaIcons($arIcons);
				}
				
				// output template
				echo $strReturn;
				
				return;
			}
		}
		
		if ($arResult["arForm"]["USE_CAPTCHA"] == "Y") $arResult["CAPTCHACode"] = $APPLICATION->CaptchaGetCode();

		// include CSS with additional icons for Site Edit mode
		if ($APPLICATION->GetShowIncludeAreas() && $USER->IsAdmin())
		{
			$APPLICATION->SetAdditionalCSS($this->GetPath()."/icons.css");
			// define additional icons for Site Edit mode
			$arIcons = array(
				// form params edit icon
				array(
					'URL' => "javascript:".$APPLICATION->GetPopupLink(
								array(
									'URL' => "/bitrix/admin/form_edit.php?bxpublic=Y&from_module=form&lang=".LANGUAGE_ID."&ID=".$arParams["WEB_FORM_ID"]."&back_url=".urlencode($_SERVER["REQUEST_URI"]),
									'PARAMS' => array(
										'width' => 700,
										'height' => 500,
										'resize' => false,
									)
								)
							),
					'ICON' => 'form-edit',
					'TITLE' => GetMessage("FORM_PUBLIC_ICON_EDIT"),
					'DEFAULT' => ($APPLICATION->GetPublicShowMode() != 'configure' ? true : false),
					"MODE" => array("edit", "configure"),
					
				),
			);

			// append icons
			$this->AddIncludeAreaIcons($arIcons);
		}
			
		// define variables to assign
		$arResult = array_merge(
			$arResult,
			array(
				"isFormNote"			=> strlen($arResult["FORM_NOTE"]) ? "Y" : "N", // flag "is there a form note"
				"isAccessFormParams"	=> $arResult["F_RIGHT"] >= 25 ? "Y" : "N", // flag "does current user have access to form params"
				"isStatisticIncluded"	=> CModule::IncludeModule('statistic') ? "Y" : "N", // flag "is statistic module included"
				
				"FORM_HEADER" => sprintf( // form header (<form> tag and hidden inputs)
					"<form name=\"%s\" action=\"%s\" method=\"%s\" enctype=\"multipart/form-data\">", 
					$arResult["arForm"]["SID"], POST_FORM_ACTION_URI, "POST"
				).$res .= bitrix_sessid_post().'<input type="hidden" name="WEB_FORM_ID" value="'.$arParams['WEB_FORM_ID'].'" />',
				
				"FORM_TITLE"			=> trim(htmlspecialchars($arResult["arForm"]["NAME"])), // form title
				
				"FORM_DESCRIPTION" => // form description
					$arResult["arForm"]["DESCRIPTION_TYPE"] == "html" ? 
					trim($arResult["arForm"]["DESCRIPTION"]) : 
					nl2br(htmlspecialchars(trim($arResult["arForm"]["DESCRIPTION"]))),
				
				"isFormTitle"			=> strlen($arResult["arForm"]["NAME"]) > 0 ? "Y" : "N", // flag "does form have title"
				"isFormDescription"		=> strlen($arResult["arForm"]["DESCRIPTION"]) > 0 ? "Y" : "N", // flag "does form have description"
				"isFormImage"			=> intval($arResult["arForm"]["IMAGE_ID"]) > 0 ? "Y" : "N", // flag "does form have image"
				"isUseCaptcha"			=> $arResult["arForm"]["USE_CAPTCHA"] == "Y", // flag "does form use captcha"
				"DATE_FORMAT"			=> CLang::GetDateFormat("SHORT"), // current site date format
				"REQUIRED_SIGN"			=> CForm::ShowRequired("Y"), // "required" sign
				"FORM_FOOTER"			=> "</form>", // form footer (close <form> tag)
			)
		);

		/*
		if ($arResult["isFormNote"] == "Y")
		{
			ob_start();
			ShowMessage($arResult["FORM_NOTE"]);
			$arResult["FORM_NOTE"] = ob_get_contents();
			ob_end_clean();
		}
		*/
			
		// get template vars for form image
		if ($arResult["isFormImage"] == "Y")
		{
			$arResult["FORM_IMAGE"]["ID"] = $arResult["arForm"]["IMAGE_ID"];
			// assign form image url
			$arResult["FORM_IMAGE"]["URL"] = CFile::GetPath($arResult["arForm"]["IMAGE_ID"]);
			
			// check image file existance and assign image data
			if (
				file_exists($_SERVER["DOCUMENT_ROOT"].$arResult["FORM_IMAGE"]["URL"]) 
				&& 
				list(
					$arResult["FORM_IMAGE"]["WIDTH"], 
					$arResult["FORM_IMAGE"]["HEIGHT"], 
					$arResult["FORM_IMAGE"]["TYPE"], 
					$arResult["FORM_IMAGE"]["ATTR"]
				) = @getimagesize($_SERVER["DOCUMENT_ROOT"].$arResult["FORM_IMAGE"]["URL"])
			)
			{
				$arResult["FORM_IMAGE"]["HTML_CODE"] = CFile::ShowImage($arResult["arForm"]["IMAGE_ID"]);
			}
		}
		
		$arResult["QUESTIONS"] = array();
		reset($arResult["arQuestions"]);
		
		// assign questions data
		foreach ($arResult["arQuestions"] as $key => $arQuestion)
		{
			$FIELD_SID = $arQuestion["SID"];
			$arResult["QUESTIONS"][$FIELD_SID] = array(
				"CAPTION" => // field caption
					$arResult["arQuestions"][$FIELD_SID]["TITLE_TYPE"] == "html" ? 
					$arResult["arQuestions"][$FIELD_SID]["TITLE"] : 
					nl2br(htmlspecialchars($arResult["arQuestions"][$FIELD_SID]["TITLE"])), 
					
				"IS_HTML_CAPTION"			=> $arResult["arQuestions"][$FIELD_SID]["TITLE_TYPE"] == "html" ? "Y" : "N",
				"REQUIRED"					=> $arResult["arQuestions"][$FIELD_SID]["REQUIRED"] == "Y" ? "Y" : "N", 
				"IS_INPUT_CAPTION_IMAGE"	=> intval($arResult["arQuestions"][$FIELD_SID]["IMAGE_ID"]) > 0 ? "Y" : "N",
			);
			
			// ******************************** customize answers ***************************** //
			
			$arResult["QUESTIONS"][$FIELD_SID]["HTML_CODE"] = array();
			
			if (is_array($arResult["arAnswers"][$FIELD_SID]))
			{
				$res = "";
			
				reset($arResult["arAnswers"][$FIELD_SID]);
				if (is_array($arResult["arDropDown"][$FIELD_SID])) reset($arResult["arDropDown"][$FIELD_SID]);
				if (is_array($arResult["arMutiselect"][$FIELD_SID])) reset($arResult["arMutiselect"][$FIELD_SID]);

				$show_dropdown = "N";
				$show_multiselect = "N";

				foreach ($arResult["arAnswers"][$FIELD_SID] as $key => $arAnswer)
				{
					//echo "<pre>".$FIELD_SID." ".$key." "; print_r($arAnswer); echo "</pre>";
					if ($arAnswer["FIELD_TYPE"]=="dropdown" && $show_dropdown=="Y") continue;
					if ($arAnswer["FIELD_TYPE"]=="multiselect" && $show_multiselect=="Y") continue;
					
					$res = "";
					
					switch ($arAnswer["FIELD_TYPE"]) 
					{
						case "radio":
							if (strpos($arAnswer["FIELD_PARAM"], "id=") === false)
							{
								$ans_id = $arAnswer["ID"];
								$arAnswer["FIELD_PARAM"] .= " id=\"".$ans_id."\"";
							}
							else
							{
								$ans_id = "";
							}
						
							$value = CForm::GetRadioValue($FIELD_SID, $arAnswer, $arResult["arrVALUES"]);
							
							if ($arResult["isFormErrors"] == 'Y')
							{
								if (
									strpos(strtolower($arAnswer["FIELD_PARAM"]), "selected")!==false 
									|| 
									strpos(strtolower($arAnswer["FIELD_PARAM"]), "checked")!==false)
									{
										$arAnswer["FIELD_PARAM"] = preg_replace("/checked|selected/i", "", $arAnswer["FIELD_PARAM"]);
									}
							}
							
							$input = CForm::GetRadioField(
								$FIELD_SID,
								$arAnswer["ID"],
								$value,
								$arAnswer["FIELD_PARAM"]);
							
							
							if (strlen($ans_id) > 0)
							{
								$res .= $input;
								$res .= "<label for=\"".$ans_id."\">".$arAnswer["MESSAGE"]."</label>";
							}
							else
							{
								$res .= "<label>".$input.$arAnswer["MESSAGE"]."</label>";
							}
							
							$arResult["QUESTIONS"][$FIELD_SID]["HTML_CODE"][] = $res;
							
							break;
						case "checkbox":
							if (strpos($arAnswer["FIELD_PARAM"], "id=") === false)
							{
								$ans_id = $arAnswer["ID"];
								$arAnswer["FIELD_PARAM"] .= " id=\"".$ans_id."\"";
							}
							else
							{
								$ans_id = "";
							}					
						
							$value = CForm::GetCheckBoxValue($FIELD_SID, $arAnswer, $arResult["arrVALUES"]);

							if ($arResult['isFormErrors'] == 'Y')
							{
								if (
									strpos(strtolower($arAnswer["FIELD_PARAM"]), "selected")!==false 
									|| 
									strpos(strtolower($arAnswer["FIELD_PARAM"]), "checked")!==false)
									{
										$arAnswer["FIELD_PARAM"] = preg_replace("/checked|selected/i", "", $arAnswer["FIELD_PARAM"]);
									}
							}
							
							$input = CForm::GetCheckBoxField(
								$FIELD_SID,
								$arAnswer["ID"],
								$value,
								$arAnswer["FIELD_PARAM"]);
								
							
							if (strlen($ans_id) > 0)
							{
								$res .= $input."<label for=\"".$ans_id."\">".$arAnswer["MESSAGE"]."</label>";
							}
							else
							{
								$res .= "<label>".$input.$arAnswer["MESSAGE"]."</label>";
							}
							
							$arResult["QUESTIONS"][$FIELD_SID]["HTML_CODE"][] = $res;
							
							break;
						case "dropdown":
							if ($show_dropdown!="Y")
							{
								$value = CForm::GetDropDownValue($FIELD_SID, $arResult["arDropDown"], $arResult["arrVALUES"]);
								
								if (strlen($arResult["FORM_ERROR"]) > 0)
									for ($i=0;$i<=count($arDropDown[$FIELD_SID]["param"])-1;$i++)
										$arDropDown[$FIELD_SID]["param"][$i] = preg_replace("/checked|selected/i", "", $arDropDown[$FIELD_SID]["param"][$i]);
										
								$res .= CForm::GetDropDownField(
									$FIELD_SID,
									$arResult["arDropDown"][$FIELD_SID],
									$value,
									$arAnswer["FIELD_PARAM"]);
								$show_dropdown = "Y";
							}
							
							$arResult["QUESTIONS"][$FIELD_SID]["HTML_CODE"][] = $res;
							
							break;
						case "multiselect":
							if ($show_multiselect!="Y")
							{
								$value = CForm::GetMultiSelectValue($FIELD_SID, $arResult["arMultiSelect"], $arResult["arrVALUES"]);
								
								if (strlen($arResult["FORM_ERROR"]) > 0)
									for ($i=0;$i<=count($arResult["arMultiSelect"][$FIELD_SID]["param"])-1;$i++)
										$arResult["arMultiSelect"][$FIELD_SID]["param"][$i] = preg_replace("/checked|selected/i", "", $arResult["arMultiSelect"][$FIELD_SID]["param"][$i]);
								$res .= CForm::GetMultiSelectField(
									$FIELD_SID,
									$arResult["arMultiSelect"][$FIELD_SID],
									$value,
									$arAnswer["FIELD_HEIGHT"],
									$arAnswer["FIELD_PARAM"]
								);
									
								$show_multiselect = "Y";
							}
							
							$arResult["QUESTIONS"][$FIELD_SID]["HTML_CODE"][] = $res;
							
							break;
						case "text":
							if (strlen(trim($arAnswer["MESSAGE"]))>0) 
							{
								$arResult["QUESTIONS"][$FIELD_SID]["HTML_CODE"][] = $arAnswer["MESSAGE"];
							}
							
							$value = CForm::GetTextValue($arAnswer["ID"], $arAnswer, $arResult["arrVALUES"]);
							$res .= CForm::GetTextField(
								$arAnswer["ID"],
								$value,
								$arAnswer["FIELD_WIDTH"],
								$arAnswer["FIELD_PARAM"]);
								
							$arResult["QUESTIONS"][$FIELD_SID]["HTML_CODE"][] = $res;
							
							break;
							
						case "hidden":

							$value = CForm::GetHiddenValue($arAnswer["ID"], $arAnswer, $arResult["arrVALUES"]);
							$res .= CForm::GetHiddenField(
								$arAnswer["ID"],
								$value,
								$arAnswer["FIELD_PARAM"]);
								
							$arResult["QUESTIONS"][$FIELD_SID]["HTML_CODE"][] = $res;							
							
							break;
							
						case "password":
							if (strlen(trim($arAnswer["MESSAGE"]))>0) 
							{
								$arResult["QUESTIONS"][$FIELD_SID]["HTML_CODE"][] = $arAnswer["MESSAGE"];
							}
							
							$value = CForm::GetPasswordValue($arAnswer["ID"], $arAnswer, $arResult["arrVALUES"]);
							$res .= CForm::GetPasswordField(
								$arAnswer["ID"],
								$value,
								$arAnswer["FIELD_WIDTH"],
								$arAnswer["FIELD_PARAM"]);
								
							$arResult["QUESTIONS"][$FIELD_SID]["HTML_CODE"][] = $res;
							
							break;
						case "email":
							if (strlen(trim($arAnswer["MESSAGE"]))>0) 
							{
								$arResult["QUESTIONS"][$FIELD_SID]["HTML_CODE"][] = $arAnswer["MESSAGE"];
							}
							$value = CForm::GetEmailValue($arAnswer["ID"], $arAnswer, $arResult["arrVALUES"]);
							$res .= CForm::GetEmailField(
								$arAnswer["ID"],
								$value,
								$arAnswer["FIELD_WIDTH"],
								$arAnswer["FIELD_PARAM"]);
							
							$arResult["QUESTIONS"][$FIELD_SID]["HTML_CODE"][] = $res;							
							
							break;
						case "url":
							if (strlen(trim($arAnswer["MESSAGE"]))>0) 
							{
								$arResult["QUESTIONS"][$FIELD_SID]["HTML_CODE"][] = $arAnswer["MESSAGE"];
							}
							$value = CForm::GetUrlValue($arAnswer["ID"], $arAnswer, $arResult["arrVALUES"]);
							$res .= CForm::GetUrlField(
								$arAnswer["ID"],
								$value,
								$arAnswer["FIELD_WIDTH"],
								$arAnswer["FIELD_PARAM"]);
								
							$arResult["QUESTIONS"][$FIELD_SID]["HTML_CODE"][] = $res;
							
							break;
						case "textarea":
							if (strlen(trim($arAnswer["MESSAGE"]))>0) 
							{
								$arResult["QUESTIONS"][$FIELD_SID]["HTML_CODE"][] = $arAnswer["MESSAGE"];
							}
							
							if (intval($arAnswer["FIELD_WIDTH"]) <= 0) $arAnswer["FIELD_WIDTH"] = "40";
							if (intval($arAnswer["FIELD_HEIGHT"]) <= 0) $arAnswer["FIELD_HEIGHT"] = "5";
							
							$value = CForm::GetTextAreaValue($arAnswer["ID"], $arAnswer, $arResult["arrVALUES"]);
							$res .= CForm::GetTextAreaField(
								$arAnswer["ID"],
								$arAnswer["FIELD_WIDTH"],
								$arAnswer["FIELD_HEIGHT"],
								$arAnswer["FIELD_PARAM"],
								$value
								);
								
							$arResult["QUESTIONS"][$FIELD_SID]["HTML_CODE"][] = $res;
							
							break;
						case "date":
							if (strlen(trim($arAnswer["MESSAGE"]))>0) 
							{
								$res .= $arAnswer["MESSAGE"];
							}
							$value = CForm::GetDateValue($arAnswer["ID"], $arAnswer, $arResult["arrVALUES"]);
							$res .= CForm::GetDateField(
								$arAnswer["ID"],
								$arResult["arForm"]["SID"],
								$value,
								$arAnswer["FIELD_WIDTH"],
								$arAnswer["FIELD_PARAM"]);
								
							$arResult["QUESTIONS"][$FIELD_SID]["HTML_CODE"][] = $res." (".CSite::GetDateFormat("SHORT").")";
							
							break;
						case "image":
							$res .= CForm::GetFileField(
								$arAnswer["ID"],
								$arAnswer["FIELD_WIDTH"],
								"IMAGE",
								0,
								"",
								$arAnswer["FIELD_PARAM"]);
								
							$arResult["QUESTIONS"][$FIELD_SID]["HTML_CODE"][] = $res;
							
							break;
						case "file":
							
							$res .= CForm::GetFileField(
								$arAnswer["ID"],
								$arAnswer["FIELD_WIDTH"],
								"FILE",
								0,
								"",
								$arAnswer["FIELD_PARAM"]);
								
							$arResult["QUESTIONS"][$FIELD_SID]["HTML_CODE"][] = $res;
							
							break;
					} //endswitch;
				} //endwhile;
				
				
			} //endif(is_array($arAnswers[$FIELD_SID]));
			elseif (is_array($arResult["arQuestions"][$FIELD_SID]) && $arResult["arQuestions"][$FIELD_SID]["ADDITIONAL"] == "Y")
			{
			
				$res = "";
				
				switch ($arResult["arQuestions"][$FIELD_SID]["FIELD_TYPE"])
				{
					case "text":
						$value = CForm::GetTextAreaValue("ADDITIONAL_".$arResult["arQuestions"][$FIELD_SID]["ID"], array(), $arResult["arrVALUES"]);
						$res .= CForm::GetTextAreaField(
							"ADDITIONAL_".$arResult["arQuestions"][$FIELD_SID]["ID"],
							"60",
							"5",
							"",
							$value
							);
							
						$arResult["QUESTIONS"][$FIELD_SID]["HTML_CODE"][] = $res;
						
						break;
					case "integer":
						$value = CForm::GetTextValue("ADDITIONAL_".$arResult["arQuestions"][$FIELD_SID]["ID"], array(), $arResult["arrVALUES"]);
						$res .= CForm::GetTextField(
							"ADDITIONAL_".$arResult["arQuestions"][$FIELD_SID]["ID"], 
							$value);
							
						$arResult["QUESTIONS"][$FIELD_SID]["HTML_CODE"][] = $res;
						
						break;
					case "date":
						$value = CForm::GetDateValue("ADDITIONAL_".$arResult["arQuestions"][$FIELD_SID]["ID"], array(), $arResult["arrVALUES"]);
						$res .= CForm::GetDateField(
							"ADDITIONAL_".$arResult["arQuestions"][$FIELD_SID]["ID"],
							$arResult["arForm"]["SID"],
							$value);
							
						$arResult["QUESTIONS"][$FIELD_SID]["HTML_CODE"][] = $res." (".CSite::GetDateFormat("SHORT").")";
						
						break;
				} //endswitch;
			}
			
			$arResult["QUESTIONS"][$FIELD_SID]["HTML_CODE"] = implode("<br />", $arResult["QUESTIONS"][$FIELD_SID]["HTML_CODE"]);
			
			// ******************************************************************************* //
			
			if ($arResult["QUESTIONS"][$FIELD_SID]["IS_INPUT_CAPTION_IMAGE"] == "Y")
			{
				$arResult["QUESTIONS"][$FIELD_SID]["IMAGE"]["ID"] = $arResult["arQuestions"][$FIELD_SID]["IMAGE_ID"];
				
				// assign field image path
				$arResult["QUESTIONS"][$FIELD_SID]["IMAGE"]["URL"] = CFile::GetPath($arResult["arQuestions"][$FIELD_SID]["IMAGE_ID"]);
				
				// check image file existance and assign image data
				if (
					file_exists($_SERVER["DOCUMENT_ROOT"].$arResult["QUESTIONS"][$FIELD_SID]["IMAGE"]["URL"]) 
					&& 
					list(
						$arResult["QUESTIONS"][$FIELD_SID]["IMAGE"]["WIDTH"], 
						$arResult["QUESTIONS"][$FIELD_SID]["IMAGE"]["HEIGHT"], 
						$arResult["QUESTIONS"][$FIELD_SID]["IMAGE"]["TYPE"], 
						$arResult["QUESTIONS"][$FIELD_SID]["IMAGE"]["ATTR"]
					) = @getimagesize($_SERVER["DOCUMENT_ROOT"].$arResult["QUESTIONS"][$FIELD_SID]["IMAGE"]["URL"])
				)
				{
					$arResult["QUESTIONS"][$FIELD_SID]["IMAGE"]["HTML_CODE"] = CFile::ShowImage($arResult["arQuestions"][$FIELD_SID]["IMAGE_ID"]);
				}
			}
			
			// get answers raw structure
			$arResult["QUESTIONS"][$FIELD_SID]["STRUCTURE"] = $arResult["arAnswers"][$FIELD_SID];
			
			// nullify value
			$arResult["QUESTIONS"][$FIELD_SID]["VALUE"] = "";
		}
		
		// compability:
		
		if ($arResult["isFormErrors"] == "Y")
		{
			ob_start();
			if ($arParams['USE_EXTENDED_ERRORS'] == 'N')
				ShowError($arResult["FORM_ERRORS"]);
			else
				ShowError(implode('<br />', $arResult["FORM_ERRORS"]));
			
			$arResult["FORM_ERRORS_TEXT"] = ob_get_contents();
			ob_end_clean();
		}
               $arSelect = Array();
               $str="";
               $arFilter = Array("IBLOCK_ID"=>"192", "ACTIVE_DATE"=>"Y", "NAME"=>"BMW%", "ACTIVE"=>"Y", "IBLOCK_SECTION_ID" => $parent_sect_names);
               $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
               $models = array();
               while($ob = $res->GetNextElement())
               {
                  $arFields = $ob->GetFields();
                  $select = "";
                  if ($arFields['NAME'] == $_POST["form_text_".$arResult["QUESTIONS"]["first_Model"]["STRUCTURE"]["0"]["ID"]]){
                    $select = "selected";}
                 //�� ��������� ������ + ����� � option
                 $arFilter_sections = Array("ID"=>$arFields['IBLOCK_SECTION_ID']);
                 $res_section = CIBlockSection::GetList(Array(),$arFilter_sections,false);
                 $obs = $res_section->GetNextElement();
                 $arSections = $obs->GetFields();
                 if ($arSections['NAME']!="�����")
                 {

                    $str = $str.'<option value="'.$arFields['NAME'].'" '.$select.'>'.$arFields['NAME'].'</option>';
                    $models[$arFields['ID']] = $arFields['NAME'];
                 }
//������ end
               }

		$arResult["QUESTIONS"]["first_Model"]["HTML_CODE"] = '<select name="form_text_'.$arResult["QUESTIONS"]["first_Model"]["STRUCTURE"]["0"]["ID"].'"><option value="">����������,�������� ������...</option>'.$str."</select>";
                $_SESSION["first_model"] = $arResult["QUESTIONS"]["first_Model"]["STRUCTURE"]["0"]["ID"];
                $radioAp1 = CForm::GetRadioField(
                "appeal",
                $arResult["QUESTIONS"]["appeal"]["STRUCTURE"]["0"]["ID"],
                $_POST["form_radio_appeal"]
                );
                $radioAp1 = $radioAp1.'<label for="'.$arResult["QUESTIONS"]["appeal"]["STRUCTURE"]["0"]["ID"].'">'.$arResult["QUESTIONS"]["appeal"]["STRUCTURE"]["0"]["VALUE"].'</label>';
                $radioAp2 = CForm::GetRadioField(
                "appeal",
                $arResult["QUESTIONS"]["appeal"]["STRUCTURE"]["1"]["ID"],
                $_POST["form_radio_appeal"]
                );
                $radioAp2 = $radioAp2.'<label for="'.$arResult["QUESTIONS"]["appeal"]["STRUCTURE"]["1"]["ID"].'">'.$arResult["QUESTIONS"]["appeal"]["STRUCTURE"]["1"]["VALUE"].'</label>';
                $arResult["appeal"][] = $radioAp1;
                $arResult["appeal"][] = $radioAp2;
                if (!isset($_POST["form_radio_carshop_diller"])){
                   $_POST["form_radio_carshop_diller"] = $arResult["QUESTIONS"]["carshop_diller"]["STRUCTURE"]["0"]["ID"];
                }
                foreach ($arResult["QUESTIONS"]["carshop_diller"]["STRUCTURE"] as $key => $arEl){
                   $str = CForm::GetRadioField(
                   "carshop_diller",
                   $arEl["ID"],
                   $_POST["form_radio_carshop_diller"]
                   );
                   $str = $str.'<label for="'.$arEl["ID"].'">'.$arEl["VALUE"].'</label>';
                   $arResult["dillers"][] = $str;
                }
		$arResult["SUBMIT_BUTTON"] = "<input ".(intval($arResult["F_RIGHT"]) < 10 ? "disabled=\"disabled\"" : "")." type=\"submit\" name=\"web_form_submit\" value=\"".(strlen(trim($arResult["arForm"]["BUTTON"])) <= 0 ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"])."\" />";
		$arResult["APPLY_BUTTON"] = "<input type=\"hidden\" name=\"web_form_apply\" value=\"Y\" /><input type=\"submit\" name=\"web_form_apply\" value=\"".GetMessage("FORM_APPLY")."\" />";
		$arResult["RESET_BUTTON"] = "<input type=\"reset\" value=\"".GetMessage("FORM_RESET")."\" />";
		$arResult["REQUIRED_STAR"] = $arResult["REQUIRED_SIGN"];
		$arResult["CAPTCHA_IMAGE"] = "<input type=\"hidden\" name=\"captcha_sid\" value=\"".htmlspecialchars($arResult["CAPTCHACode"])."\" /><img src=\"/bitrix/tools/captcha.php?captcha_sid=".htmlspecialchars($arResult["CAPTCHACode"])."\" width=\"180\" height=\"40\" />";
		$arResult["CAPTCHA_FIELD"] = "<input type=\"text\" name=\"captcha_word\" size=\"30\" maxlength=\"50\" value=\"\" class=\"inputtext\" />";
		$arResult["CAPTCHA"] = $arResult["CAPTCHA_IMAGE"]."<br />".$arResult["CAPTCHA_FIELD"];
		
		if ($bCache)
		{
			$obFormCache->StartDataCache();
			$obFormCache->EndDataCache(
				array(
					"arResult" => $arResult,
				)
			);
		}

                  $arResult['SelectString'] = "";
                  $rsElement = CIBlockElement::GetList(array(), array("IBLOCK_ID"=>FORM_MODEL_IBLOCK,"ACTIVE"=>"Y"), false, false, array("ID","NAME","PROPERTY_parent"));
                  while($ob = $rsElement->GetNextElement()){
                    $arFields = $ob->GetFields();
                    if (!isset($arFields["PROPERTY_PARENT_VALUE"]))
                    $arResult['SelectString'] .= "<option value = \"".$arFields["NAME"]."\">".$arFields["NAME"]."</option>";
                  }
                $arResult["QUESTIONS"]["info_brand"]["HTML_CODE"] = '<select name="form_text_'. $arResult["QUESTIONS"]["info_brand"]["STRUCTURE"]["0"]["ID"].'" id="info_brand" onChange = "selectChange();" class="inputSelect"><option value="">���������� �������� ������...</option>'.$arResult['SelectString'].'</select>';
                $arResult["QUESTIONS"]["info_model"]["HTML_CODE"] = '<select name="form_text_'. $arResult["QUESTIONS"]["info_model"]["STRUCTURE"]["0"]["ID"].'" id="info_model" class="inputSelect"></select>';
                $arResult["QUESTIONS"]["personal_birth_date"]["HTML_CODE"] = CalendarDate("form_date_".$arResult["QUESTIONS"]["personal_birth_date"]["STRUCTURE"]["0"]["ID"], $_POST["form_date_".$arResult["QUESTIONS"]["personal_birth_date"]["STRUCTURE"]["0"]["ID"]], "test_drive");
                $arResult["date_id"] = $arResult["QUESTIONS"]["personal_birth_date"]["STRUCTURE"]["0"]["ID"];
                $arResult["brand_id"] = $arResult["QUESTIONS"]["info_brand"]["STRUCTURE"]["0"]["ID"];
                $arResult["model_id"] = $arResult["QUESTIONS"]["info_model"]["STRUCTURE"]["0"]["ID"];
                $arResult["personal_hobby"] = $arResult["QUESTIONS"]["personal_hobby"]["STRUCTURE"]["0"]["ID"];
                $arResult["personal_activity"] = $arResult["QUESTIONS"]["personal_activity"]["STRUCTURE"]["0"]["ID"];
                $arResult["personal_name_company"] = $arResult["QUESTIONS"]["personal_name_company"]["STRUCTURE"]["0"]["ID"];
                $arResult["info_years_buy"] = $arResult["QUESTIONS"]["info_years_buy"]["STRUCTURE"]["0"]["ID"];
                $arResult["info_years"] = $arResult["QUESTIONS"]["info_years"]["STRUCTURE"]["0"]["ID"];
		// include default template
		$this->IncludeComponentTemplate();
	}
	else
	{
		ShowError(GetMessage($arResult["ERROR"]));
	}
}
else
{
	echo ShowError(GetMessage("FORM_MODULE_NOT_INSTALLED"));
}
?>