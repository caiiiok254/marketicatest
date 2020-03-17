<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
if(!CModule::IncludeModule("iblock")) return;

if (COption::GetOptionString("bd.deliverypizza", "wizard_installed", "N", WIZARD_SITE_ID) == "Y" && !WIZARD_INSTALL_DEMO_DATA){
	return;
}

$arTypes = Array(
	Array(
		"ID" => "bd_content_pizza",
		"SECTIONS" => "Y",
		"IN_RSS" => "N",
		"SORT" => 100,
		"LANG" => Array(),
	),
	Array(
		"ID" => "bd_pizza_constructor",
		"SECTIONS" => "Y",
		"IN_RSS" => "N",
		"SORT" => 200,
		"LANG" => Array(),
	),
	Array(
		"ID" => "bd_information_pizza",
		"SECTIONS" => "Y",
		"IN_RSS" => "N",
		"SORT" => 300,
		"LANG" => Array(),
	),
	Array(
		"ID" => "bd_gifts_pizza",
		"SECTIONS" => "Y",
		"IN_RSS" => "N",
		"SORT" => 400,
		"LANG" => Array(),
	),
	Array(
		"ID" => "bd_settings_pizza",
		"SECTIONS" => "Y",
		"IN_RSS" => "N",
		"SORT" => 500,
		"LANG" => Array(),
	),
);

$arLanguages = array();
$rsLanguage = CLanguage::GetList($by, $order, array());
while($arLanguage = $rsLanguage->Fetch())
	$arLanguages[] = $arLanguage["LID"];

$iblockType = new CIBlockType;

foreach($arTypes as $arType){
	$dbType = CIBlockType::GetList(Array(),Array("=ID" => $arType["ID"]));
	if($dbType->Fetch())
		continue;
	foreach($arLanguages as $languageID)
	{
		WizardServices::IncludeServiceLang("types.php", $languageID);
		$code = strtoupper($arType["ID"]);
		$arType["LANG"][$languageID]["NAME"] = GetMessage($code."_TYPE_NAME");
		$arType["LANG"][$languageID]["ELEMENT_NAME"] = GetMessage($code."_ELEMENT_NAME");
		if ($arType["SECTIONS"] == "Y")
			$arType["LANG"][$languageID]["SECTION_NAME"] = GetMessage($code."_SECTION_NAME");
	}

	$iblockType->Add($arType);
}
COption::SetOptionString('iblock','combined_list_mode','Y');
?>