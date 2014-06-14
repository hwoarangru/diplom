<?
error_reporting(E_ALL ^ E_NOTICE);
ini_set ('display_errors', 'stdout');

$_SERVER["DOCUMENT_ROOT"]="/adv/vhosts/www.bmw-autokraft.ru/htdocs";

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

set_time_limit(10000);
ini_set("memory_limit", "512M");

if (!CModule::includeModule('iblock'))
	die ();

$arr['IBLOCK_ID_POST'] = '223';
	
if(isset($arr['IBLOCK_ID_POST']))
	$iBlockEnabled = (int)$arr['IBLOCK_ID_POST'];

if(!isset($iBlockEnabled))
	die('Access deny');
else {
	$STORE_NUM = 2;

	$files_count = 1;
	while ($files_count < 4) {
		if (file_exists ($_SERVER["DOCUMENT_ROOT"].'/import/brt_8_temp_array_'.$files_count.'.php')) {
			require_once ($_SERVER["DOCUMENT_ROOT"].'/import/brt_8_temp_array_'.$files_count.'.php');

			foreach($values as $val){
				$el = new CIBlockElement; 
				$PROP = array(); 

				// Заполнение свойств
				$PROP['PName'] = $val[0];
				$PROP['PCount'] = $val[6];
				$PROP['PPriceZak'] = 0;
				$PROP['PCountZak'] = 0;
				$PROP['PPriceRozn'] = str_replace(".",",",floatval(str_replace(",",".",str_replace(" ","",$val[2]))));
				$PROP['PPriceZakBRT'] = str_replace(".",",",floatval(str_replace(",",".",str_replace(" ","",$val[4]))));

				$arLoadProductArray = Array( 
					"MODIFIED_BY"    => 0, // элемент изменен текущим пользователем 
					"IBLOCK_SECTION" => false,          // элемент лежит в корне раздела 
					"IBLOCK_ID"      => $iBlockEnabled, 
					"PROPERTY_VALUES"=> $PROP, 
					"NAME"           => $val[1], 
					"ACTIVE"         => "Y",            // активен 
					); 

				$PRODUCT_ID = $el->Add($arLoadProductArray); // Занесение в базу
			}

			unlink ($_SERVER["DOCUMENT_ROOT"].'/import/brt_8_temp_array_'.$files_count.'.php');
			die ("done");
		}
		else
			$files_count++;
	}
}
?>
