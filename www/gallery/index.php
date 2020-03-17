<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Галерея");
?><?$APPLICATION->IncludeComponent(
	"junior:gallery.list", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"IBLOCK_TYPE" => "advantage",
		"IBLOCK_ID" => "2",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_ORDER1" => "DESC",
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"SET_STATUS_404" => "N",
		"SHOW_404" => "N",
		"MESSAGE_404" => ""
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>