<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$GLOBALS['APPLICATION']->SetAdditionalCSS('/bitrix/templates/bmw_inner/styles.css');
CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

$APPLICATION->SetTitle("���� �� ������ - BMW-�������������");
?>

<style type="text/css">
body > *{color: #363636;;}
#contenttext{
    margin-top: 30px;
    top: 0px;
    width: 375px;
    height: 132px;
    padding: 10px 0 30px 315px;
    color: #363636;
}

a, a:visited, a:active, a:link {
font-family: arial,helvetica,sans-serif;
color:#777777;
text-decoration: none;
}

a:hover {
color:#003399;
}

#contenttext p{
line-height: 13px;
margin: 1em 0 0;
}

ul {
    list-style-position: inside;
}
ul, menu, dir {
    list-style-type: disc;
}
li {
    display: list-item;
    text-align: -webkit-match-parent;
    line-height: 13px;
    padding-top: 3px;
}

h1 {
    font-size: 20px;
    font-family: Arial;
    padding-bottom: 3px;
    line-height: 21px;
    margin: 0px;
    font-weight: normal;
}
</style>
<div style="margin-top: 79px; margin-left: 30px;">���� �� ������ - BMW-�������������</div>


<div id="contenttext">
    <h1>404 HTTP Status:  ���� �� ������</h1>
<p>
	<b>��������, ��� �������� ���� �������, �������������, ��� ��� �������� ����������.</b>
</p>
<p>
	���������� ���������:
</p>
<ul>
	<li>��������� ������������ ������ �������� � ������ ������,</li>
	<li>��������� �� <a href="/">������� ��������</a>, ����� ������� ��� ������ �� ������ ��� ������,</li>
	<li>��������� <a href="javascript:history.back()">�����</a>, ����� ������������ ������ ������.</li>
	<li>�������������� <a href="/search/">�������</a> ��� <a href="/sitemap/">������ �����</a>  ��� ���������� ������ ��� ���������� �� �����.</li>
</ul>					
</div>

<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php"); ?>