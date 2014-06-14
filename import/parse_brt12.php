<?
	//Замеряем время начала работы скрипта
$time_begin_script = time();

	//Подключаем битрикс
$_SERVER["DOCUMENT_ROOT"]="/adv/vhosts/www.bmw-autokraft.ru/htdocs";

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//Устанавливаем лимит времени и памяти.
	//Определяем ID инфоблока импорта ($arr['IBLOCK_ID_POST'])
	//Определяем место нахождения файла импорта ($file)
	//Определяем время шага выполнения скрипта ($script_run_step_time)
	//Определяем имя файла в котором хранится смещение, с которого надо начинать текущий шаг ($filename)
set_time_limit(10000);
ini_set("memory_limit", "256M");
$arr['IBLOCK_ID_POST'] = '223';
//$file = $_SERVER["DOCUMENT_ROOT"].'/upload/prices/BRT_12.csv';
$file = $_SERVER["DOCUMENT_ROOT"].'/upload/prices/BRT_8.csv';
$script_run_step_time = 20;
$filename = "tempstring_import.txt";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	//Подключаем модуль инфоблоков
if (!CModule::includeModule('iblock'))
	return;

if ( file_exists($file)) {
		//Читаем файл tempstring_import.txt в папке скрипта и определяем смещение файла csv, с которого надо начинать импорт
		//(если в файле присутствует число, начинаем с него, иначе начинаем с начала). После чтения файл удаляем
		//Также устанавливаем флаг $first_step, который указывает, надо ли удалять существующие элементы инфоблока
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
			//Если мы находимся на первом шаге (если надо удалять существующие элементы инфоблока)
		if ($first_step)
		{
			
				//Начинаем транзакцию. Выбираем все элементы инфоблока
			$DB->StartTransaction();
			$arFilter = Array("IBLOCK_ID"=>(int)$iBlockEnabled);
			$arSelect = Array("ID");
			$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1000000), $arSelect);
			while($ob = $res->GetNextElement())
			{
				$ID = (int)$ob->fields['ID'];
					//Удаляем найденные элементы инфоблока
				if(!CIBlockElement::Delete($ID))
				{
					echo 'error for delete element ID="'.$ID.'"';
				}
			}
				//Закрываем транзакцию
			$DB->Commit();
		}
			//Удалили все существуюшие элементы (если находимся на первом шаге)
			
		
			//открываем файл
		$handle = fopen ($file, 'r');
			//Если находимся на первом шаге, читаем первую строку (Материал;Краткий текст материала...) чтобы она не попала в выгрузку
			//Если шаг уже не первый, устанавливаем смещение файла на прочитанное
		if ($first_step)
		{
			$line = fgets ($handle);
		}
		else
		{
			fseek($handle,$current_line);
		}
			//Начинаем разбирать файл по строчкам
		while (($line = fgets ($handle)) !== false) {
			$line = trim ($line);
				//Если строка не пустая
			if (!empty ($line)) {
					//разбираем строку
				$line_values = explode (';', $line);
				$val = Array ();
			
				foreach ($line_values as $line_value) {
					if (preg_match ("#^\"(.+?)\"$#", $line_value))
						$line_value = mb_substr ($line_value, 1, mb_strlen ($line_value) - 2);
					$val[] = $line_value;
				}


					//Распарсили строку (массив значений лежит в $val)
					
					//Записываем только что полученный элемент в инфоблок
				$el = new CIBlockElement; 
				$PROP = array(); 
				
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

					//Добавляем элемент инфоблока
				$PRODUCT_ID = $el->Add($arLoadProductArray); // Занесение в базу

					//Смотрим сколько времени прошло с начала запуска скрипта ($time_current_script)
				$time_current_script = time() - $time_begin_script;
//Сношу пошаговость (начало)
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*					//Если время шага уже закончено (время выполнения больше или равно $script_run_step_time) выполнение пора прекращать 
				if ($time_current_script >= $script_run_step_time) 
				{
						//Создаём файл tempstring_import.txt в папке со скриптом (запишем туда смещение файла csv, на котором остановились)
					$file_link = fopen($filename, "w+");
						//Если смещение записать не удалось
					if (fwrite($file_link, ftell($handle)) === FALSE)
					{
							//Выводим ошибку и пишем, сколько элементов мы импортировали
						echo "Import error. Current step: ".ftell($handle);
						die();
					}	
					else
					{
							//Иначе закрываем файл и запускаем этот же скрипт сначала
						fclose($file_link);
						fclose ($handle);
						echo "NextStep";
						die();
						//LocalRedirect(basename (__FILE__));
					}
				}
				//Конец условия окончания время выполнения скрипта
*/
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Сношу пошаговость (конец)
			}
			//Конец условия что строка не пустая
		}
		//Конец прохода по строкам файла
		fclose ($handle);
	echo "Import done";
			//Вывод сообщения об успешном завершении импорта. При этом файл tempstring_import.txt затирается вначале выполнения скрипта
			//и не создаётся в конце скрипта
	}
	//конец условия, что мы знаем ID инфоблока, в который производится импорт
}
//конец условия, что файл с ценами существует
//если файл не существует, выводим ошибку
else
{
	echo "Import fails";
}
?>
