<?
//KRFT-1077
//���������� �������� ��� ������
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
CModule::IncludeModule("iblock");

define("SPECIAL_OFFERS_IB",203);


 $arFields = Array(
        "NAME" => "�����",
        "ACTIVE" => "Y",
        "SORT" => "50",
        "CODE" => "BANNER_IMG",
        "PROPERTY_TYPE" => "F",
        "IS_REQUIRED"=>"N",
        "FILE_TYPE"=>"jpg,jpeg,png",
        "IBLOCK_ID" => SPECIAL_OFFERS_IB
);



$properties = CIBlockProperty::GetList(Array("sort"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$arFields['IBLOCK_ID'],"CODE"=>$arFields['CODE']));
if (!$properties->GetNext()){
    
    $ibp = new CIBlockProperty;
    if ($PropID = $ibp->Add($arFields)) echo '�������� ���������!';  
    
}else {
    echo '�������� "'.$arFields['NAME'].'" ��� ����.';
}

      




?>