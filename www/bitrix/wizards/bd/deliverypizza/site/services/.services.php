<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arServices = Array(
	"main" => Array(
		"NAME" => GetMessage("SERVICE_MAIN_SETTINGS"),
		"STAGES" => Array(
			"files.php", // Copy bitrix files
			"template.php", // Install template
			"theme.php", // Install theme
			"group.php", // Install group
			"settings.php",
		),
	),

	"iblock" => Array(
		"NAME" => GetMessage("SERVICE_IBLOCK"),
		"STAGES" => Array(
		    "types.php", //IBlock types
		    "catalog_stickers.php",
		    "catalog_ingredients.php",
		    "catalog.php",
			"catalog_additional_products.php",
			"catalog_recomendation.php",
			"wokbox_base.php",
			"wokbox_souce.php",
			"wokbox_ingredients.php",
			"wokbox_ready.php",
			"news.php",
			"sale.php",
			"slider.php",
			"tabs.php",
			"gifts_stickers.php",
			"gifts.php",
			"destrict.php",
			"takeaway.php",
			"paymethod.php",
			"promo.php",
			"sms_templates.php",
		),
	),
);
?>