<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Продукция");
?><?$APPLICATION->IncludeComponent(
	"junior:product.detail",
	"",
Array("ELEMENT_CODE"=>!empty($_REQUEST['ELEMENT_CODE'])?$_REQUEST['ELEMENT_CODE']:false)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>