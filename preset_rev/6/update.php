<?php
/*  Добавляем новой тип почт. события */

EventTypeIntegrate::Add(array (
  'LID' => 'ru',
  'EVENT_NAME' => 'MAIL_RESPONSIBLE',
  'NAME' => 'MAIL_RESPONSIBLE',
  'DESCRIPTION' => '#MAIL_SUMMARY# - Mail summary
#DATE_CREATE# - Date create',
  'SORT' => '150',
));


