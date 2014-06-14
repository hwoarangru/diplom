<?php
/*  Р”РѕР±Р°РІР»СЏРµРј РЅРѕРІСѓСЋ РІРµР±-С„РѕСЂРјСѓ */

FormIntegrate::FormSet(array (
  'TIMESTAMP_X' => '26.02.2008 10:16:36',
  'NAME' => 'Форма Newsletter',
  'SID' => 'SIMPLE_FORM_10',
  'BUTTON' => 'Отправить',
  'C_SORT' => '300',
  'FIRST_SITE_ID' => NULL,
  'IMAGE_ID' => NULL,
  'USE_CAPTCHA' => 'N',
  'DESCRIPTION' => '',
  'DESCRIPTION_TYPE' => 'text',
  'FORM_TEMPLATE' => ' 
<p><?=$FORM->ShowFormNote()?><?=$FORM->ShowFormErrors()?></p>
 
<p>&nbsp;</p>
 
<div align="center"> 
  <div style="color: rgb(51, 153, 0); width: 100px;"> 
    <div style="background-color: rgb(51, 153, 0); width: 7px; height: 15px; float: left;"></div>
   <b>Required Field</b></div>
 </div>
 
<p>&nbsp;</p>
 
<p> 
  <table width="100%" cellspacing="2" cellpadding="2" border="0" style="border-collapse: collapse;" class="data-table"> 
    <tbody> 
      <tr><td width="30%" valign="top" align="right">Фамилия 
          <br />
         </td><td> 
          <div style="background-color: rgb(51, 153, 0); width: 7px; height: 100%;"></div>
         
          <br />
         </td><td width="70%"><?=$FORM->ShowInput(\'VS_SURNAME\')?></td></tr>
     
      <tr><td align="right">&nbsp;Имя 
          <br />
         </td><td> 
          <div style="background-color: rgb(51, 153, 0); width: 7px; height: 100%;"></div>
         
          <br />
         </td><td><?=$FORM->ShowInput(\'VS_NAME\')?></td></tr>
     
      <tr><td valign="top" align="right">Отчество 
          <br />
         </td><td> 
          <div style="background-color: rgb(51, 153, 0); width: 7px; height: 100%;"></div>
         
          <br />
         </td><td><?=$FORM->ShowInput(\'VS_LASTNAME\')?></td></tr>
     
      <tr><td valign="top" align="right">Данные паспорта 
          <br />
         </td><td> 
          <div style="background-color: rgb(51, 153, 0); width: 7px; height: 100%;"></div>
         
          <br />
         </td><td><?=$FORM->ShowInput(\'VS_PASSPORT\')?></td></tr>
     
      <tr><td valign="top" align="right">Дата рождения(dd.mm.yyyy) 
          <br />
         </td><td> 
          <div style="background-color: rgb(51, 153, 0); width: 7px; height: 100%;"></div>
         
          <br />
         </td><td> <?=$FORM->ShowInput(\'VS_DATE\')?> </td></tr>
     
      <tr><td valign="top" align="right">Вы женаты / замужем?&nbsp;
          <br />
         </td><td> 
          <div style="background-color: rgb(51, 153, 0); width: 7px; height: 100%;"></div>
         
          <br />
         </td><td><?=$FORM->ShowInput(\'VS_MARRIED\')?></td></tr>
     
      <tr><td valign="top" align="right">E-Mail 
          <br />
         </td><td> 
          <div style="background-color: rgb(51, 153, 0); width: 7px; height: 100%;"></div>
         
          <br />
         </td><td><?=$FORM->ShowInput(\'VS_EMAIL\')?></td></tr>
     
      <tr><td valign="top" align="right">Адрес 
          <br />
         </td><td> 
          <div style="background-color: rgb(51, 153, 0); width: 7px; height: 100%;"></div>
         
          <br />
         </td><td><?=$FORM->ShowInput(\'VS_MAIL\')?></td></tr>
     
      <tr><td valign="top" align="right">Телефон 
          <br />
         </td><td> 
          <div style="background-color: rgb(51, 153, 0); width: 7px; height: 100%;"></div>
         
          <br />
         </td><td valign="top"><?=$FORM->ShowInput(\'VS_PHONE\')?></td></tr>
     
      <tr><td valign="top" align="right">Профессия 
          <br />
         </td><td> 
          <div style="background-color: rgb(51, 153, 0); width: 7px; height: 100%;"></div>
         
          <br />
         </td><td valign="top"><?=$FORM->ShowInput(\'VS_OCUP\')?></td></tr>
     </tbody>
   </table>
 </p>
 
<div style="border-top: 1px solid rgb(111, 165, 219); height: 10px;"></div>
 I declare that all the above information are true and accurate. 
<p></p>
 
<p>&nbsp;</p>
 
<p align="center"><?=$FORM->ShowSubmitButton("","")?></p>
 
<p></p>
 ',
  'USE_DEFAULT_TEMPLATE' => 'N',
  'SHOW_TEMPLATE' => NULL,
  'MAIL_EVENT_TYPE' => 'FORM_FILLING_SIMPLE_FORM_10',
  'SHOW_RESULT_TEMPLATE' => NULL,
  'PRINT_RESULT_TEMPLATE' => NULL,
  'EDIT_RESULT_TEMPLATE' => NULL,
  'FILTER_RESULT_TEMPLATE' => '',
  'TABLE_RESULT_TEMPLATE' => '',
  'USE_RESTRICTIONS' => 'N',
  'RESTRICT_USER' => '0',
  'RESTRICT_TIME' => '0',
  'RESTRICT_STATUS' => '',
  'STAT_EVENT1' => 'form',
  'STAT_EVENT2' => 'SIMPLE_FORM_4_IAVNa_2rW4L',
  'STAT_EVENT3' => '',
  'LID' => NULL,
  'VARNAME' => 'SIMPLE_FORM_10',
  'C_FIELDS' => '0',
  'QUESTIONS' => '15',
  'STATUSES' => '1',
  'arSITE' => 
  array (
    0 => 'ru',
  ),
  'arMAIL_TEMPLATE' => 
  array (
  ),
  'arMENU' => 
  array (
    'ru' => 'Форма Newsletter',
    'en' => 'Newsletter Form',
  ),
), '');


