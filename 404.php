<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

$APPLICATION->SetTitle("���� �� ������ - BMW �������������");
?>

<script type="text/javascript">
$(function(){
if(null == document.getElementById('contentText')){
	$('._contentText_').attr('id', 'contentText');
	}
});

</script>

<div id="stage">
</div>

<div class="_contentText_">

<div id="innerPageContent">
    <h1>404 HTTP Status:  ���� �� ������</h1>
<p>
	<b>��������, ��� �������� ���� �������, �������������, ��� ��� �������� ����������.</b>
</p>

<p>���������� ���������:</p>
<ul>
	<li>��������� ������������ ������ �������� � ������ ������,</li>
	<li>��������� �� <a href="/">������� ��������</a>, ����� ������� ��� ������ �� ������ ��� ������,</li>
	<li>��������� <a href="javascript:history.back()">�����</a>, ����� ������������ ������ ������.</li>
	<li>�������������� <a href="/search/">�������</a> ��� <a href="/map/">������ �����</a>  ��� ���������� ������ ��� ���������� �� �����.</li>
</ul>					</div>
</div>
<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php"); ?> 