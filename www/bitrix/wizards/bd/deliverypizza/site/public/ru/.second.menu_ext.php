<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
global $APPLICATION;

$aMenuLinksExt = $APPLICATION->IncludeComponent(
	"bitrix:menu.sections", 
	"second_menu", 
	array(
		"IS_SEF" => "Y",
		"SEF_BASE_URL" => SITE_DIR."catalog/",
		"SECTION_PAGE_URL" => "#SECTION_CODE_PATH#/",
		"IBLOCK_TYPE" => "bd_content",
		"IBLOCK_ID" => (int)\Bd\Deliverypizza\BdCache::$iblocks[SITE_ID]["bd_content_pizza"]["bd_catalog"][0],
		"DEPTH_LEVEL" => "2",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"PATH" => rtrim(str_replace(SITE_DIR."catalog/","",$APPLICATION->GetCurDir()),"/"),
		"DETAIL_PAGE_URL" => "#SECTION_CODE_PATH#/#ELEMENT_ID#/",
		"COMPONENT_TEMPLATE" => "second_menu"
	),
	false
); 
$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt); 
?>