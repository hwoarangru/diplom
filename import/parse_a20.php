<?
$dir = dirname(__FILE__);
include($dir . "/timer.php");

$_SERVER["DOCUMENT_ROOT"]="/adv/vhosts/www.bmw-autokraft.ru/htdocs";

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");


if (!CModule::includeModule('iblock'))
	return;

set_time_limit(10000);
ini_set("memory_limit", "256M");
/////////////////


	$arr['IBLOCK_ID_POST'] = '226';
	
	if(isset($arr['IBLOCK_ID_POST']))
		$iBlockEnabled = (int)$arr['IBLOCK_ID_POST'];
	if(!isset($iBlockEnabled)){die('Access deny');}
	else {
   
	$STORE_NUM = 1;
	
	$_FILES["filename"]["name"] = "prices/AVT_20.csv";
   
	// добавление элементов
	$values = ParseCsv($_SERVER["DOCUMENT_ROOT"].'/upload/'.$_FILES["filename"]["name"]);
	$count = 0;
	foreach($values as $val){
		$el = new CIBlockElement; 

		
		$arFilter = array("IBLOCK_ID" => $arr['IBLOCK_ID_POST'], "PROPERTY_PNAME"=>$val[0]);
		$arSort = array();
		$rs=CIBlockElement::GetList($arSort, $arFilter, false, false, array("ID", "IBLOCK_ID", "PROPERTY_PName", "PROPERTY_PPriceRozn", "PROPERTY_PPriceZakBRT", "PROPERTY_PCount", "PROPERTY_PName"));
		
		
		while($ar=$rs->GetNext())
		{
		
			$PROP = array(); 
			// Заполнение свойств
				$PROP['PName'] = $val[0];
				$PROP['PCount'] = $ar["PROPERTY_PCOUNT_VALUE"];
				$PROP['PCountZak'] = $val[3];
				$PROP['PPriceZak'] = str_replace(".",",",floatval(str_replace(",",".",str_replace(" ","",$val[5]))));
				$PROP['PPriceRozn'] = $ar["PROPERTY_PPRICEROZN_VALUE"];
				$PROP['PPriceZakBRT'] = $ar["PROPERTY_PPRICEZAKBRT_VALUE"];
				$arLoadProductArray = Array( 
				"MODIFIED_BY"    => 0, // элемент изменен текущим пользователем 
				"IBLOCK_SECTION" => false,          // элемент лежит в корне раздела 
				"IBLOCK_ID"      => $iBlockEnabled, 
				"PROPERTY_VALUES"=> $PROP, 
				"NAME"           => $val[2], 
				"ACTIVE"         => "Y",            // активен 


				); 
	
			//print_r($val);
			//print_r($ar["PROPERTY_PCOUNT_VALUE"]);			
			$res = $el->Update($ar['ID'], $arLoadProductArray);
		}
		$count++;
		//break;
	}
	 
	 echo("WELL DONE! Count = ".$count);
 }

//импорт CSV


function ParseCsv($file){
  $csv_lines  = file($file);
  if(is_array($csv_lines))
  {
    //разбор csv
    $cnt = count($csv_lines);
    for($i = 1; $i < $cnt; $i++)
    {
      $line = $csv_lines[$i];
      $line = trim($line);
      //указатель на то, что через цикл проходит первый символ столбца
      $first_char = true;
      //номер столбца
      $col_num = 0;
      $length = strlen($line);
      for($b = 0; $b < $length; $b++)
      {
        //переменная $skip_char определяет обрабатывать ли данный символ
        if($skip_char != true)
        {
          //определяет обрабатывать/не обрабатывать строку
          ///print $line[$b];
          $process = true;
          //определяем маркер окончания столбца по первому символу
          if($first_char == true)
          {
            if($line[$b] == '"')
            {
              $terminator = '";';
              $process = false;
            }
            else
              $terminator = ';';
            $first_char = false;
          }
          //просматриваем парные кавычки, опредляем их природу
          if($line[$b] == '"')
          {
            $next_char = $line[$b + 1];
            //удвоенные кавычки
            if($next_char == '"')
              $skip_char = true;
            //маркер конца столбца
            elseif($next_char == ';')
            {
              if($terminator == '";')
              {
                $first_char = true;
                $process = false;
                $skip_char = true;
              }
            }
          }
          //определяем природу точки с запятой
          if($process == true)
          {
            if($line[$b] == ';')
            {
               if($terminator == ';')
               {

                  $first_char = true;
                  $process = false;
               }
            }
          }
          if($process == true)
            $column .= $line[$b];
          if($b == ($length - 1))
          {
            $first_char = true;
          }

          if($first_char == true)
          {
	          	$values[$i][$col_num] = $column;
	            $column = '';
	            $col_num++;
          }

        }
        else
          $skip_char = false;
      }
    }
  }
   return ($values);
}

timerlog(__FILE__);
?>
