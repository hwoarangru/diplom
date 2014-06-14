<?
	//�������� ����� ������ ������ �������
$time_begin_script = time();

	//���������� �������
$_SERVER["DOCUMENT_ROOT"]="/adv/vhosts/www.bmw-autokraft.ru/htdocs";

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//������������� ����� ������� � ������.
	//���������� ID ��������� ������� ($arr['IBLOCK_ID_POST'])
	//���������� ����� ���������� ����� ������� ($file)
	//���������� ����� ���� ���������� ������� ($script_run_step_time)
	//���������� ��� ����� � ������� �������� ��������, � �������� ���� �������� ������� ��� ($filename)
set_time_limit(10000);
ini_set("memory_limit", "256M");
$arr['IBLOCK_ID_POST'] = '223';
//$file = $_SERVER["DOCUMENT_ROOT"].'/upload/prices/BRT_12.csv';
$file = $_SERVER["DOCUMENT_ROOT"].'/upload/prices/BRT_8.csv';
$script_run_step_time = 20;
$filename = "tempstring_import.txt";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	//���������� ������ ����������
if (!CModule::includeModule('iblock'))
	return;

if ( file_exists($file)) {
		//������ ���� tempstring_import.txt � ����� ������� � ���������� �������� ����� csv, � �������� ���� �������� ������
		//(���� � ����� ������������ �����, �������� � ����, ����� �������� � ������). ����� ������ ���� �������
		//����� ������������� ���� $first_step, ������� ���������, ���� �� ������� ������������ �������� ���������
	$current_line = 0;
	$first_step = true;
	if( file_exists($filename)){
		$file_link = fopen($filename, "r+");
			if(filesize($filename)>0) {
				$current_line = intval(fread($file_link, filesize($filename))); 
			}
		fclose($file_link);
		unlink($filename);
	$first_step = false;
	}


	if(isset($arr['IBLOCK_ID_POST']))
		$iBlockEnabled = (int)$arr['IBLOCK_ID_POST'];
	if(!isset($iBlockEnabled)){die('Access deny');}
	else 
	{
			//���� �� ��������� �� ������ ���� (���� ���� ������� ������������ �������� ���������)
		if ($first_step)
		{
			
				//�������� ����������. �������� ��� �������� ���������
			$DB->StartTransaction();
			$arFilter = Array("IBLOCK_ID"=>(int)$iBlockEnabled);
			$arSelect = Array("ID");
			$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1000000), $arSelect);
			while($ob = $res->GetNextElement())
			{
				$ID = (int)$ob->fields['ID'];
					//������� ��������� �������� ���������
				if(!CIBlockElement::Delete($ID))
				{
					echo 'error for delete element ID="'.$ID.'"';
				}
			}
				//��������� ����������
			$DB->Commit();
		}
			//������� ��� ������������ �������� (���� ��������� �� ������ ����)
			
		
			//��������� ����
		$handle = fopen ($file, 'r');
			//���� ��������� �� ������ ����, ������ ������ ������ (��������;������� ����� ���������...) ����� ��� �� ������ � ��������
			//���� ��� ��� �� ������, ������������� �������� ����� �� �����������
		if ($first_step)
		{
			$line = fgets ($handle);
		}
		else
		{
			fseek($handle,$current_line);
		}
			//�������� ��������� ���� �� ��������
		while (($line = fgets ($handle)) !== false) {
			$line = trim ($line);
				//���� ������ �� ������
			if (!empty ($line)) {
					//��������� ������
				$line_values = explode (';', $line);
				$val = Array ();
			
				foreach ($line_values as $line_value) {
					if (preg_match ("#^\"(.+?)\"$#", $line_value))
						$line_value = mb_substr ($line_value, 1, mb_strlen ($line_value) - 2);
					$val[] = $line_value;
				}


					//���������� ������ (������ �������� ����� � $val)
					
					//���������� ������ ��� ���������� ������� � ��������
				$el = new CIBlockElement; 
				$PROP = array(); 
				
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					// ���������� �������
				$PROP['PName'] = $val[0];
				$PROP['PCount'] = $val[6];
				$PROP['PPriceZak'] = 0;
				$PROP['PCountZak'] = 0;
				$PROP['PPriceRozn'] = str_replace(".",",",floatval(str_replace(",",".",str_replace(" ","",$val[2]))));
				$PROP['PPriceZakBRT'] = str_replace(".",",",floatval(str_replace(",",".",str_replace(" ","",$val[4]))));
				$arLoadProductArray = Array( 
					"MODIFIED_BY"    => 0, // ������� ������� ������� ������������� 
					"IBLOCK_SECTION" => false,          // ������� ����� � ����� ������� 
					"IBLOCK_ID"      => $iBlockEnabled, 
					"PROPERTY_VALUES"=> $PROP, 
					"NAME"           => $val[1], 
					"ACTIVE"         => "Y",            // ������� 
				); 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

					//��������� ������� ���������
				$PRODUCT_ID = $el->Add($arLoadProductArray); // ��������� � ����

					//������� ������� ������� ������ � ������ ������� ������� ($time_current_script)
				$time_current_script = time() - $time_begin_script;
//����� ����������� (������)
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*					//���� ����� ���� ��� ��������� (����� ���������� ������ ��� ����� $script_run_step_time) ���������� ���� ���������� 
				if ($time_current_script >= $script_run_step_time) 
				{
						//������ ���� tempstring_import.txt � ����� �� �������� (������� ���� �������� ����� csv, �� ������� ������������)
					$file_link = fopen($filename, "w+");
						//���� �������� �������� �� �������
					if (fwrite($file_link, ftell($handle)) === FALSE)
					{
							//������� ������ � �����, ������� ��������� �� �������������
						echo "Import error. Current step: ".ftell($handle);
						die();
					}	
					else
					{
							//����� ��������� ���� � ��������� ���� �� ������ �������
						fclose($file_link);
						fclose ($handle);
						echo "NextStep";
						die();
						//LocalRedirect(basename (__FILE__));
					}
				}
				//����� ������� ��������� ����� ���������� �������
*/
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//����� ����������� (�����)
			}
			//����� ������� ��� ������ �� ������
		}
		//����� ������� �� ������� �����
		fclose ($handle);
	echo "Import done";
			//����� ��������� �� �������� ���������� �������. ��� ���� ���� tempstring_import.txt ���������� ������� ���������� �������
			//� �� �������� � ����� �������
	}
	//����� �������, ��� �� ����� ID ���������, � ������� ������������ ������
}
//����� �������, ��� ���� � ������ ����������
//���� ���� �� ����������, ������� ������
else
{
	echo "Import fails";
}
?>
