<?php
/*  Обновляем тип почт. события */

EventTypeIntegrate::Update('ru', 'MAIL_RESPONSIBLE', array (
  'LID' => 'ru',
  'EVENT_NAME' => 'MAIL_RESPONSIBLE',
  'NAME' => 'MAIL_RESPONSIBLE',
  'DESCRIPTION' => '#MAIL_SUMMARY# - Mail summary
#DATE_CREATE# - Date create',
  'SORT' => '150',
));


