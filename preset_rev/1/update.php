<?php
/*  РћР±РЅРѕРІР»СЏРµРј РР‘ */

IblockIntegrate::Update('models', array (
  'TIMESTAMP_X' => '21.02.2014 11:12:19',
  'IBLOCK_TYPE_ID' => 'models',
  'LID' => 'ru',
  'CODE' => 'models',
  'NAME' => 'Модели (!)',
  'ACTIVE' => 'Y',
  'SORT' => '500',
  'LIST_PAGE_URL' => '#SITE_DIR#/cars/index.php?ID=#IBLOCK_ID#',
  'DETAIL_PAGE_URL' => '#SITE_DIR#/cars/#SECTION_CODE#/#CODE#/',
  'SECTION_PAGE_URL' => '#SITE_DIR#/cars/#ID#/',
  'PICTURE' => NULL,
  'DESCRIPTION' => '',
  'DESCRIPTION_TYPE' => 'text',
  'RSS_TTL' => '24',
  'RSS_ACTIVE' => 'Y',
  'RSS_FILE_ACTIVE' => 'N',
  'RSS_FILE_LIMIT' => NULL,
  'RSS_FILE_DAYS' => NULL,
  'RSS_YANDEX_ACTIVE' => 'N',
  'XML_ID' => '192',
  'TMP_ID' => '43ec587c351da8939de05a4b0c0b6d13',
  'INDEX_ELEMENT' => 'Y',
  'INDEX_SECTION' => 'Y',
  'WORKFLOW' => 'N',
  'VERSION' => '1',
  'LAST_CONV_ELEMENT' => '0',
  'EDIT_FILE_BEFORE' => '',
  'EDIT_FILE_AFTER' => '',
  'SECTIONS_NAME' => 'Разделы',
  'SECTION_NAME' => 'Раздел',
  'ELEMENTS_NAME' => 'Элемент',
  'ELEMENT_NAME' => 'Элемент',
  'SECTION_CHOOSER' => 'L',
  'BIZPROC' => 'N',
  'LIST_MODE' => '',
  'SOCNET_GROUP_ID' => NULL,
  'RIGHTS_MODE' => 'S',
  'SECTION_PROPERTY' => NULL,
  'EXTERNAL_ID' => '192',
  'LANG_DIR' => '/',
  'SERVER_NAME' => 'bmw-indep.ru',
  'FIELDS' => 
  array (
    'IBLOCK_SECTION' => 
    array (
      'NAME' => 'Привязка к разделам',
      'IS_REQUIRED' => 'N',
      'DEFAULT_VALUE' => '',
    ),
    'ACTIVE' => 
    array (
      'NAME' => 'Активность',
      'IS_REQUIRED' => 'Y',
      'DEFAULT_VALUE' => 'Y',
    ),
    'ACTIVE_FROM' => 
    array (
      'NAME' => 'Начало активности',
      'IS_REQUIRED' => 'N',
      'DEFAULT_VALUE' => '',
    ),
    'ACTIVE_TO' => 
    array (
      'NAME' => 'Окончание активности',
      'IS_REQUIRED' => 'N',
      'DEFAULT_VALUE' => '',
    ),
    'SORT' => 
    array (
      'NAME' => 'Сортировка',
      'IS_REQUIRED' => 'N',
      'DEFAULT_VALUE' => '0',
    ),
    'NAME' => 
    array (
      'NAME' => 'Название',
      'IS_REQUIRED' => 'Y',
      'DEFAULT_VALUE' => '',
    ),
    'PREVIEW_PICTURE' => 
    array (
      'NAME' => 'Картинка для анонса',
      'IS_REQUIRED' => 'N',
      'DEFAULT_VALUE' => 
      array (
        'FROM_DETAIL' => 'N',
        'SCALE' => 'N',
        'WIDTH' => '',
        'HEIGHT' => '',
        'IGNORE_ERRORS' => 'N',
        'METHOD' => '',
        'COMPRESSION' => '',
        'DELETE_WITH_DETAIL' => 'N',
        'UPDATE_WITH_DETAIL' => 'N',
        'USE_WATERMARK_TEXT' => 'N',
        'WATERMARK_TEXT' => '',
        'WATERMARK_TEXT_FONT' => '',
        'WATERMARK_TEXT_COLOR' => '',
        'WATERMARK_TEXT_SIZE' => '',
        'WATERMARK_TEXT_POSITION' => 'tl',
        'USE_WATERMARK_FILE' => 'N',
        'WATERMARK_FILE' => '',
        'WATERMARK_FILE_ALPHA' => '',
        'WATERMARK_FILE_POSITION' => 'tl',
        'WATERMARK_FILE_ORDER' => NULL,
      ),
    ),
    'PREVIEW_TEXT_TYPE' => 
    array (
      'NAME' => 'Тип описания для анонса',
      'IS_REQUIRED' => 'Y',
      'DEFAULT_VALUE' => 'text',
    ),
    'PREVIEW_TEXT' => 
    array (
      'NAME' => 'Описание для анонса',
      'IS_REQUIRED' => 'N',
      'DEFAULT_VALUE' => '',
    ),
    'DETAIL_PICTURE' => 
    array (
      'NAME' => 'Детальная картинка',
      'IS_REQUIRED' => 'N',
      'DEFAULT_VALUE' => 
      array (
        'SCALE' => 'N',
        'WIDTH' => '',
        'HEIGHT' => '',
        'IGNORE_ERRORS' => 'N',
        'METHOD' => '',
        'COMPRESSION' => '',
        'USE_WATERMARK_TEXT' => 'N',
        'WATERMARK_TEXT' => '',
        'WATERMARK_TEXT_FONT' => '',
        'WATERMARK_TEXT_COLOR' => '',
        'WATERMARK_TEXT_SIZE' => '',
        'WATERMARK_TEXT_POSITION' => 'tl',
        'USE_WATERMARK_FILE' => 'N',
        'WATERMARK_FILE' => '',
        'WATERMARK_FILE_ALPHA' => '',
        'WATERMARK_FILE_POSITION' => 'tl',
        'WATERMARK_FILE_ORDER' => NULL,
      ),
    ),
    'DETAIL_TEXT_TYPE' => 
    array (
      'NAME' => 'Тип детального описания',
      'IS_REQUIRED' => 'Y',
      'DEFAULT_VALUE' => 'text',
    ),
    'DETAIL_TEXT' => 
    array (
      'NAME' => 'Детальное описание',
      'IS_REQUIRED' => 'N',
      'DEFAULT_VALUE' => '',
    ),
    'XML_ID' => 
    array (
      'NAME' => 'Внешний код',
      'IS_REQUIRED' => 'N',
      'DEFAULT_VALUE' => '',
    ),
    'CODE' => 
    array (
      'NAME' => 'Символьный код',
      'IS_REQUIRED' => 'N',
      'DEFAULT_VALUE' => 
      array (
        'UNIQUE' => 'N',
        'TRANSLITERATION' => 'N',
        'TRANS_LEN' => 100,
        'TRANS_CASE' => '',
        'TRANS_SPACE' => false,
        'TRANS_OTHER' => false,
        'TRANS_EAT' => 'Y',
        'USE_GOOGLE' => 'N',
      ),
    ),
    'TAGS' => 
    array (
      'NAME' => 'Теги',
      'IS_REQUIRED' => 'N',
      'DEFAULT_VALUE' => '',
    ),
    'SECTION_NAME' => 
    array (
      'NAME' => 'Название',
      'IS_REQUIRED' => 'Y',
      'DEFAULT_VALUE' => '',
    ),
    'SECTION_PICTURE' => 
    array (
      'NAME' => 'Картинка для анонса',
      'IS_REQUIRED' => 'N',
      'DEFAULT_VALUE' => 
      array (
        'FROM_DETAIL' => 'N',
        'SCALE' => 'N',
        'WIDTH' => '',
        'HEIGHT' => '',
        'IGNORE_ERRORS' => 'N',
        'METHOD' => 'resample',
        'COMPRESSION' => 95,
        'DELETE_WITH_DETAIL' => 'N',
        'UPDATE_WITH_DETAIL' => 'N',
        'USE_WATERMARK_TEXT' => 'N',
        'WATERMARK_TEXT' => '',
        'WATERMARK_TEXT_FONT' => '',
        'WATERMARK_TEXT_COLOR' => '',
        'WATERMARK_TEXT_SIZE' => '',
        'WATERMARK_TEXT_POSITION' => 'tl',
        'USE_WATERMARK_FILE' => 'N',
        'WATERMARK_FILE' => '',
        'WATERMARK_FILE_ALPHA' => '',
        'WATERMARK_FILE_POSITION' => 'tl',
        'WATERMARK_FILE_ORDER' => NULL,
      ),
    ),
    'SECTION_DESCRIPTION_TYPE' => 
    array (
      'NAME' => 'Тип описания',
      'IS_REQUIRED' => 'Y',
      'DEFAULT_VALUE' => 'text',
    ),
    'SECTION_DESCRIPTION' => 
    array (
      'NAME' => 'Описание',
      'IS_REQUIRED' => 'N',
      'DEFAULT_VALUE' => '',
    ),
    'SECTION_DETAIL_PICTURE' => 
    array (
      'NAME' => 'Детальная картинка',
      'IS_REQUIRED' => 'N',
      'DEFAULT_VALUE' => 
      array (
        'SCALE' => 'N',
        'WIDTH' => '',
        'HEIGHT' => '',
        'IGNORE_ERRORS' => 'N',
        'METHOD' => 'resample',
        'COMPRESSION' => '',
        'USE_WATERMARK_TEXT' => 'N',
        'WATERMARK_TEXT' => '',
        'WATERMARK_TEXT_FONT' => '',
        'WATERMARK_TEXT_COLOR' => '',
        'WATERMARK_TEXT_SIZE' => '',
        'WATERMARK_TEXT_POSITION' => 'tl',
        'USE_WATERMARK_FILE' => 'N',
        'WATERMARK_FILE' => '',
        'WATERMARK_FILE_ALPHA' => '',
        'WATERMARK_FILE_POSITION' => 'tl',
        'WATERMARK_FILE_ORDER' => NULL,
      ),
    ),
    'SECTION_XML_ID' => 
    array (
      'NAME' => 'Внешний код',
      'IS_REQUIRED' => 'N',
      'DEFAULT_VALUE' => '',
    ),
    'SECTION_CODE' => 
    array (
      'NAME' => 'Символьный код',
      'IS_REQUIRED' => 'N',
      'DEFAULT_VALUE' => 
      array (
        'UNIQUE' => 'N',
        'TRANSLITERATION' => 'N',
        'TRANS_LEN' => 100,
        'TRANS_CASE' => 'L',
        'TRANS_SPACE' => '_',
        'TRANS_OTHER' => '_',
        'TRANS_EAT' => 'Y',
        'USE_GOOGLE' => 'N',
      ),
    ),
    'LOG_SECTION_ADD' => 
    array (
      'NAME' => 'LOG_SECTION_ADD',
      'IS_REQUIRED' => 'N',
      'DEFAULT_VALUE' => NULL,
    ),
    'LOG_SECTION_EDIT' => 
    array (
      'NAME' => 'LOG_SECTION_EDIT',
      'IS_REQUIRED' => 'N',
      'DEFAULT_VALUE' => NULL,
    ),
    'LOG_SECTION_DELETE' => 
    array (
      'NAME' => 'LOG_SECTION_DELETE',
      'IS_REQUIRED' => 'N',
      'DEFAULT_VALUE' => NULL,
    ),
    'LOG_ELEMENT_ADD' => 
    array (
      'NAME' => 'LOG_ELEMENT_ADD',
      'IS_REQUIRED' => 'N',
      'DEFAULT_VALUE' => NULL,
    ),
    'LOG_ELEMENT_EDIT' => 
    array (
      'NAME' => 'LOG_ELEMENT_EDIT',
      'IS_REQUIRED' => 'N',
      'DEFAULT_VALUE' => NULL,
    ),
    'LOG_ELEMENT_DELETE' => 
    array (
      'NAME' => 'LOG_ELEMENT_DELETE',
      'IS_REQUIRED' => 'N',
      'DEFAULT_VALUE' => NULL,
    ),
  ),
  'GROUP_ID' => 
  array (
    1 => 'X',
    2 => 'R',
    29 => 'W',
  ),
));


