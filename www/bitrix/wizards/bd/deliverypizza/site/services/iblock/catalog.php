<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?if(!CModule::IncludeModule("iblock")) return;
  if(!defined("WIZARD_SITE_ID")) return;
  if(!defined("WIZARD_SITE_DIR")) return;
  if(!defined("WIZARD_SITE_PATH")) return;
  if(!defined("WIZARD_TEMPLATE_ABSOLUTE_PATH")) return;
	
$iblockShortCODE = "catalog";
$iblockXMLFile = WIZARD_SERVICE_RELATIVE_PATH."/xml/".LANGUAGE_ID."/".$iblockShortCODE.".xml";
$iblockTYPE = "bd_content_pizza";
$iblockXMLID = "bd_".$iblockShortCODE."_".WIZARD_SITE_ID;
$iblockCODE = "bd_".$iblockShortCODE;
$iblockID = false;

$rsIBlock = CIBlock::GetList(array(), array("XML_ID" => $iblockXMLID, "TYPE" => $iblockTYPE));
if ($arIBlock = $rsIBlock->Fetch()) {
	$iblockID = $arIBlock["ID"];
	if (WIZARD_INSTALL_DEMO_DATA) {
		CIBlock::Delete($arIBlock["ID"]);
		$iblockID = false;
	}
}

if(WIZARD_INSTALL_DEMO_DATA){
	if(!$iblockID){
		// add new iblock
		$permissions = array("1" => "X", "2" => "R");
		$dbGroup = CGroup::GetList($by = "", $order = "", array("STRING_ID" => "content_editor"));
		if($arGroup = $dbGroup->Fetch()){
			$permissions[$arGroup["ID"]] = "W";
		};
		
		// replace macros IN_XML_SITE_ID & IN_XML_SITE_DIR in xml file - for correct url links to site
		if(file_exists($_SERVER["DOCUMENT_ROOT"].$iblockXMLFile.".back")){
			@copy($_SERVER["DOCUMENT_ROOT"].$iblockXMLFile.".back", $_SERVER["DOCUMENT_ROOT"].$iblockXMLFile);
		}
		@copy($_SERVER["DOCUMENT_ROOT"].$iblockXMLFile, $_SERVER["DOCUMENT_ROOT"].$iblockXMLFile.".back");
		CWizardUtil::ReplaceMacros($_SERVER["DOCUMENT_ROOT"].$iblockXMLFile, Array("IN_XML_SITE_DIR" => WIZARD_SITE_DIR));
		CWizardUtil::ReplaceMacros($_SERVER["DOCUMENT_ROOT"].$iblockXMLFile, Array("IN_XML_SITE_ID" => WIZARD_SITE_ID));
		$iblockID = WizardServices::ImportIBlockFromXML($iblockXMLFile, $iblockCODE, $iblockTYPE, WIZARD_SITE_ID, $permissions);
		if(file_exists($_SERVER["DOCUMENT_ROOT"].$iblockXMLFile.".back")){
			@copy($_SERVER["DOCUMENT_ROOT"].$iblockXMLFile.".back", $_SERVER["DOCUMENT_ROOT"].$iblockXMLFile);
		}
		if ($iblockID < 1)	return;
			
		// iblock fields
		$iblock = new CIBlock;
		$arFields = array(
			"ACTIVE" => "Y",
			"CODE" => $iblockCODE,
			"XML_ID" => $iblockXMLID,
			"FIELDS" => array(
				"IBLOCK_SECTION" => array(
					"IS_REQUIRED" => "N",
					"DEFAULT_VALUE" => "",
				),
				"ACTIVE" => array(
					"IS_REQUIRED" => "Y",
					"DEFAULT_VALUE"=> "Y",
				),
				"ACTIVE_FROM" => array(
					"IS_REQUIRED" => "N",
					"DEFAULT_VALUE" => "",
				),
				"ACTIVE_TO" => array(
					"IS_REQUIRED" => "N",
					"DEFAULT_VALUE" => "",
				),
				"SORT" => array(
					"IS_REQUIRED" => "N",
					"DEFAULT_VALUE" => "0",
				), 
				"NAME" => array(
					"IS_REQUIRED" => "Y",
					"DEFAULT_VALUE" => "",
				), 
				"PREVIEW_PICTURE" => array(
					"IS_REQUIRED" => "N",
					"DEFAULT_VALUE" => array(
						"FROM_DETAIL" => "Y",
						"SCALE" => "Y",
						"WIDTH" => "300",
						"HEIGHT" => "300",
						"IGNORE_ERRORS" => "N",
						"METHOD" => "resample",
						"COMPRESSION" => 95,
						"DELETE_WITH_DETAIL" => "N",
						"UPDATE_WITH_DETAIL" => "N",
					),
				), 
				"PREVIEW_TEXT_TYPE" => array(
					"IS_REQUIRED" => "Y",
					"DEFAULT_VALUE" => "text",
				), 
				"PREVIEW_TEXT" => array(
					"IS_REQUIRED" => "N",
					"DEFAULT_VALUE" => "",
				), 
				"DETAIL_PICTURE" => array(
					"IS_REQUIRED" => "N",
					"DEFAULT_VALUE" => array(
						"SCALE" => "Y",
						"WIDTH" => "1500",
						"HEIGHT" => "1500",
						"IGNORE_ERRORS" => "N",
						"METHOD" => "resample",
						"COMPRESSION" => 95,
					),
				), 
				"DETAIL_TEXT_TYPE" => array(
					"IS_REQUIRED" => "Y",
					"DEFAULT_VALUE" => "text",
				), 
				"DETAIL_TEXT" => array(
					"IS_REQUIRED" => "N",
					"DEFAULT_VALUE" => "",
				), 
				"XML_ID" =>  array(
					"IS_REQUIRED" => "N",
					"DEFAULT_VALUE" => "",
				), 
				"CODE" => array(
					"IS_REQUIRED" => "Y",
					"DEFAULT_VALUE" => array(
						"UNIQUE" => "Y",
						"TRANSLITERATION" => "Y",
						"TRANS_LEN" => 100,
						"TRANS_CASE" => "L",
						"TRANS_SPACE" => "-",
						"TRANS_OTHER" => "-",
						"TRANS_EAT" => "Y",
						"USE_GOOGLE" => "N",
					),
				),
				"TAGS" => array(
					"IS_REQUIRED" => "N",
					"DEFAULT_VALUE" => "",
				), 
				"SECTION_NAME" => array(
					"IS_REQUIRED" => "Y",
					"DEFAULT_VALUE" => "",
				), 
				"SECTION_PICTURE" => array(
					"IS_REQUIRED" => "N",
					"DEFAULT_VALUE" => array(
						"FROM_DETAIL" => "Y",
						"SCALE" => "Y",
						"WIDTH" => "300",
						"HEIGHT" => "300",
						"IGNORE_ERRORS" => "N",
						"METHOD" => "resample",
						"COMPRESSION" => 95,
						"DELETE_WITH_DETAIL" => "N",
						"UPDATE_WITH_DETAIL" => "N",
					),
				), 
				"SECTION_DESCRIPTION_TYPE" => array(
					"IS_REQUIRED" => "Y",
					"DEFAULT_VALUE" => "text",
				), 
				"SECTION_DESCRIPTION" => array(
					"IS_REQUIRED" => "N",
					"DEFAULT_VALUE" => "",
				), 
				"SECTION_DETAIL_PICTURE" => array(
					"IS_REQUIRED" => "N",
					"DEFAULT_VALUE" => array(
						"SCALE" => "Y",
						"WIDTH" => "1500",
						"HEIGHT" => "1500",
						"IGNORE_ERRORS" => "N",
						"METHOD" => "resample",
						"COMPRESSION" => 95,
					),
				), 
				"SECTION_XML_ID" => array(
					"IS_REQUIRED" => "N",
					"DEFAULT_VALUE" => "",
				), 
				"SECTION_CODE" => array(
					"IS_REQUIRED" => "Y",
					"DEFAULT_VALUE" => array(
						"UNIQUE" => "Y",
						"TRANSLITERATION" => "Y",
						"TRANS_LEN" => 100,
						"TRANS_CASE" => "L",
						"TRANS_SPACE" => "-",
						"TRANS_OTHER" => "-",
						"TRANS_EAT" => "Y",
						"USE_GOOGLE" => "N",
					),
				), 
			),
		);
		
		$iblock->Update($iblockID, $arFields);
	}
	else{
		// attach iblock to site
		$arSites = array(); 
		$db_res = CIBlock::GetSite($iblockID);
		while ($res = $db_res->Fetch())
			$arSites[] = $res["LID"]; 
		if (!in_array(WIZARD_SITE_ID, $arSites)){
			$arSites[] = WIZARD_SITE_ID;
			$iblock = new CIBlock;
			$iblock->Update($iblockID, array("LID" => $arSites));
		}
	}

	// iblock user fields
	$dbSite = CSite::GetByID(WIZARD_SITE_ID);
	if($arSite = $dbSite -> Fetch()) $lang = $arSite["LANGUAGE_ID"];
	if(!strlen($lang)) $lang = "ru";
	WizardServices::IncludeServiceLang("editform_options.php", $lang);
	$arProperty = array();
	$dbProperty = CIBlockProperty::GetList(array(), array("IBLOCK_ID" => $iblockID));
	while($arProp = $dbProperty->Fetch())
		$arProperty[$arProp["CODE"]] = $arProp["ID"];

	// edit form user oprions
	CUserOptions::SetOption("form", "form_element_".$iblockID, array(
		"tabs" => 'edit1--#--'.GetMessage("BD_OPTION_1").'--,--ACTIVE--#--'.GetMessage("BD_OPTION_31").'--,--PROPERTY_'.$arProperty["RECOMEND"].'--#--'.GetMessage("BD_OPTION_2").'--,--PROPERTY_'.$arProperty["NO_SALE"].'--#--'.GetMessage("BD_OPTION_3").'--,--NAME--#--'.GetMessage("BD_OPTION_4").'--,--CODE--#--'.GetMessage("BD_OPTION_5").'--,--SORT--#--'.GetMessage("BD_OPTION_32").'--,--PROPERTY_'.$arProperty["BADGES"].'--#--'.GetMessage("BD_OPTION_6").'--,--PROPERTY_'.$arProperty["PRICE"].'--#--'.GetMessage("BD_OPTION_7").'--,--PROPERTY_'.$arProperty["OLD_PRICE"].'--#--'.GetMessage("BD_OPTION_8").'--,--PROPERTY_'.$arProperty["G"].'--#--'.GetMessage("BD_OPTION_9").'--,--PROPERTY_'.$arProperty["UNITS"].'--#--'.GetMessage("BD_OPTION_10").'--,--PROPERTY_'.$arProperty["BD_PROPS_1"].'--#--'.GetMessage("BD_OPTION_11").'--,--PROPERTY_'.$arProperty["BD_PROPS_2"].'--#--'.GetMessage("BD_OPTION_12").'--,--PROPERTY_'.$arProperty["OPTIONS_CHOOSE"].'--#--'.GetMessage("BD_OPTION_107").'--,--PROPERTY_'.$arProperty["SIZE"].'--#--'.GetMessage("WZD_OPTION_86").'--,--PROPERTY_'.$arProperty["TYPE"].'--#--'.GetMessage("WZD_OPTION_88").'--,--PROPERTY_'.$arProperty["COLOR"].'--#--'.GetMessage("WZD_OPTION_90").'--,--PREVIEW_PICTURE--#--'.GetMessage("BD_OPTION_13").'--,--PROPERTY_'.$arProperty["LIKE_COUNTER"].'--#--'.GetMessage("BD_OPTION_14").'--,--IBLOCK_ELEMENT_PROP_VALUE--#--'.GetMessage("BD_OPTION_15").'--,--PROPERTY_'.$arProperty["BUY_IT"].'--#--'.GetMessage("BD_OPTION_16").'--,--PROPERTY_'.$arProperty["BUY_IT_COMPLETE"].'--#--'.GetMessage("BD_OPTION_17").'--;--edit2--#--'.GetMessage("BD_OPTION_18").'--,--PREVIEW_TEXT--#--'.GetMessage("BD_OPTION_19").'--,--DETAIL_TEXT--#--'.GetMessage("BD_OPTION_20").'--;--edit3--#--'.GetMessage("BD_OPTION_21").'--,--PROPERTY_'.$arProperty["INGREDIENTS"].'--#--'.GetMessage("BD_OPTION_22").'--;--edit4--#--'.GetMessage("BD_OPTION_23").'--,--PROPERTY_'.$arProperty["PROTEINS"].'--#--'.GetMessage("BD_OPTION_24").'--,--PROPERTY_'.$arProperty["FATS"].'--#--'.GetMessage("BD_OPTION_25").'--,--PROPERTY_'.$arProperty["CARBOHYDRATES"].'--#--'.GetMessage("BD_OPTION_26").'--,--PROPERTY_'.$arProperty["CALORIFIC_VALUE"].'--#--'.GetMessage("BD_OPTION_27").'--;--edit5--#--'.GetMessage("BD_OPTION_28").'--,--PROPERTY_'.$arProperty["BANNER"].'--#--'.GetMessage("BD_OPTION_29").'--,--PROPERTY_'.$arProperty["BANNER_URL"].'--#--'.GetMessage("BD_OPTION_30").'--;--;--',
	));
	// list user options
	CUserOptions::SetOption("list", "tbl_iblock_list_".md5($iblockTYPE.".".$iblockID), array(
		'columns' => 'NAME,PREVIEW_PICTURE,PROPERTY_'.$arProperty["PRICE"].',PROPERTY_'.$arProperty["OLD_PRICE"].',ACTIVE,SORT,TIMESTAMP_X,ID', 'by' => 'timestamp_x', 'order' => 'desc', 'page_size' => '20',
	));
}

?>
