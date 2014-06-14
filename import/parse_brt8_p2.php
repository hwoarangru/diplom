<?
error_reporting(E_ALL ^ E_NOTICE);
ini_set ('display_errors', 'stdout');

$_SERVER["DOCUMENT_ROOT"]="/adv/vhosts/www.bmw-autokraft.ru/htdocs";

set_time_limit(10000);
ini_set("memory_limit", "512M");

function ParseCsv ($file) {
	$result = Array ();
	if (!$handle = fopen ($file, 'r'))
		die ("Can't open file for reading");
	$line = fgets ($handle);
	while ($line) {
		$line = trim ($line);
		if (!empty ($line)) {
			$line_values = explode (';', $line);
			$l_values = Array ();

			foreach ($line_values as $line_value) {
				$has_quotes = preg_match ("#^\"(.+?)\"$#", $line_value);
				if ($has_quotes)
					$line_value = mb_substr ($line_value, 1, mb_strlen ($line_value) - 2);
				$has_quotes = preg_match ("#\'#", $line_value);
				if ($has_quotes)
					$line_value = str_replace ("'", "\'", $line_value);
				$l_values[] = $line_value;
			}

			$result[] = $l_values;
		}
		$line = null;
		$has_quotes = null;
		$line_values = null;
		$line_value = null;
		$l_values = null;
		$line = fgets ($handle);
	}
	fclose ($handle);
	unset ($result[0]);
	return $result;
}

function put2file ($values) {
	if (!$handle = fopen ($_SERVER["DOCUMENT_ROOT"].'/import/brt_8_temp_array_1.php', 'w'))
		die ("Can't open file 'brt_8_temp_array_1.php' for writing");
	fwrite ($handle, '<?'."\n");
	fwrite ($handle, '$values = Array ('."\n");

	$count = 0;
	foreach ($values as $key1=>$values1) {
		$count++;
		if ($count == 50000) {
			fwrite ($handle, "	);\n");
			fwrite ($handle, '?>');
			fclose ($handle);
			system ('chmod 0777 '.$_SERVER["DOCUMENT_ROOT"].'/import/brt_8_temp_array_1.php');
			if (!$handle = fopen ($_SERVER["DOCUMENT_ROOT"].'/import/brt_8_temp_array_2.php', 'w'))
				die ("Can't open file 'brt_8_temp_array_2.php' for writing");
			fwrite ($handle, '<?'."\n");
			fwrite ($handle, '$values = Array ('."\n");
		}
		if ($count == 100000) {
			fwrite ($handle, "	);\n");
			fwrite ($handle, '?>');
			fclose ($handle);
			system ('chmod 0777 '.$_SERVER["DOCUMENT_ROOT"].'/import/brt_8_temp_array_2.php');
			if (!$handle = fopen ($_SERVER["DOCUMENT_ROOT"].'/import/brt_8_temp_array_3.php', 'w'))
				die ("Can't open file 'brt_8_temp_array_3.php' for writing");
			fwrite ($handle, '<?'."\n");
			fwrite ($handle, '$values = Array ('."\n");
		}
		fwrite ($handle, "	'".$key1."' => Array (\n");
		foreach ($values1 as $key2=>$value2)
			fwrite ($handle, "		'".$key2."' => '".$value2."',\n");
		fwrite ($handle, "		),\n");
	}
	fwrite ($handle, "	);\n");
	fwrite ($handle, '?>');
	fclose ($handle);
	system ('chmod 0777 '.$_SERVER["DOCUMENT_ROOT"].'/import/brt_8_temp_array_3.php');
}

$_FILES["filename"]["name"] = "prices/BRT_8.csv";

if (!file_exists ($_SERVER["DOCUMENT_ROOT"].'/upload/'.$_FILES["filename"]["name"]))
	die ('File not found!');

// добавление элементов
$values = ParseCsv ($_SERVER["DOCUMENT_ROOT"].'/upload/'.$_FILES["filename"]["name"]);
put2file ($values);

echo "done";
?>
