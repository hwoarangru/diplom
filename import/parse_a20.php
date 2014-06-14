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
   
	// ���������� ���������
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
			// ���������� �������
				$PROP['PName'] = $val[0];
				$PROP['PCount'] = $ar["PROPERTY_PCOUNT_VALUE"];
				$PROP['PCountZak'] = $val[3];
				$PROP['PPriceZak'] = str_replace(".",",",floatval(str_replace(",",".",str_replace(" ","",$val[5]))));
				$PROP['PPriceRozn'] = $ar["PROPERTY_PPRICEROZN_VALUE"];
				$PROP['PPriceZakBRT'] = $ar["PROPERTY_PPRICEZAKBRT_VALUE"];
				$arLoadProductArray = Array( 
				"MODIFIED_BY"    => 0, // ������� ������� ������� ������������� 
				"IBLOCK_SECTION" => false,          // ������� ����� � ����� ������� 
				"IBLOCK_ID"      => $iBlockEnabled, 
				"PROPERTY_VALUES"=> $PROP, 
				"NAME"           => $val[2], 
				"ACTIVE"         => "Y",            // ������� 


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

//������ CSV


function ParseCsv($file){
  $csv_lines  = file($file);
  if(is_array($csv_lines))
  {
    //������ csv
    $cnt = count($csv_lines);
    for($i = 1; $i < $cnt; $i++)
    {
      $line = $csv_lines[$i];
      $line = trim($line);
      //��������� �� ��, ��� ����� ���� �������� ������ ������ �������
      $first_char = true;
      //����� �������
      $col_num = 0;
      $length = strlen($line);
      for($b = 0; $b < $length; $b++)
      {
        //���������� $skip_char ���������� ������������ �� ������ ������
        if($skip_char != true)
        {
          //���������� ������������/�� ������������ ������
          ///print $line[$b];
          $process = true;
          //���������� ������ ��������� ������� �� ������� �������
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
          //������������� ������ �������, ��������� �� �������
          if($line[$b] == '"')
          {
            $next_char = $line[$b + 1];
            //��������� �������
            if($next_char == '"')
              $skip_char = true;
            //������ ����� �������
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
          //���������� ������� ����� � �������
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
