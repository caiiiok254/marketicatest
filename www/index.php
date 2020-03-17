<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Демонстрационная версия продукта «1С-Битрикс: Управление сайтом»");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");
$APPLICATION->SetTitle("Главная страница");
?>
<?$APPLICATION->IncludeComponent(
	"junior:product.list",
	".default",
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "1",
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
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>