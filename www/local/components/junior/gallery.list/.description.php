<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => "Галерея",
	"DESCRIPTION" => GetMessage("T_IBLOCK_DESC_LIST_DESC"),
	"ICON" => "/images/news_list.gif",
	"SORT" => 20,
	"CACHE_PATH" => "Y",
	"PATH" => array(
		"ID" => "Junior",
		"CHILD" => array(
			"ID" => "productlist",
			"NAME" => "Галерея",
			"SORT" => 40,
			"CHILD" => array(
				"ID" => "gallery",
			),
		),
	),
);

?>