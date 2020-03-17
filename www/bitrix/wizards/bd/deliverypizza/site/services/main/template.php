<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if(!defined("WIZARD_SITE_ID")) return;
if(!defined("WIZARD_SITE_DIR")) return;
if(!defined("WIZARD_SITE_PATH")) return;
if(!defined("WIZARD_TEMPLATE_ABSOLUTE_PATH")) return;

if(!WIZARD_INSTALL_DEMO_DATA){
	return;
}

$bitrixTemplateDir = $_SERVER["DOCUMENT_ROOT"].BX_PERSONAL_ROOT."/templates/".WIZARD_TEMPLATE_ID."/";

CopyDirFiles(
	WIZARD_TEMPLATE_ABSOLUTE_PATH,
	$bitrixTemplateDir,
	$rewrite = true,
	$recursive = true, 
	$delete_after_copy = false,
	$exclude = "themes"
);

// replace macros SITE_DIR & SITE_ID
CWizardUtil::ReplaceMacrosRecursive($bitrixTemplateDir, Array("SITE_DIR" => WIZARD_SITE_DIR));
CWizardUtil::ReplaceMacrosRecursive($bitrixTemplateDir, Array("SITE_ID" => WIZARD_SITE_ID));

// attach template to default site
if($arSite = CSite::GetByID(WIZARD_SITE_ID)->Fetch()){
	$obTemplate = CSite::GetTemplateList(WIZARD_SITE_ID);
	$arTemplates = array();
	$found = false;
	while ($arTemplate = $obTemplate->Fetch()){
		if(!$found && !strlen($arTemplate["CONDITION"])){
			$arTemplate["TEMPLATE"] = WIZARD_TEMPLATE_ID;
			$found = true;
		}
		if($arTemplate["TEMPLATE"] == "empty"){
			continue;
		}
		$arTemplates[]= $arTemplate;
	}
	if (!$found){
		$arTemplates[]= array("CONDITION" => "", "SORT" => 150, "TEMPLATE" => WIZARD_TEMPLATE_ID);
	}

	$obSite = new CSite();
	$arFields = array("TEMPLATE" => $arTemplates, "DIR" => str_replace('//', '/', str_replace('//', '/', '/'.$arSite["DIR"].'/')));
	$obSite->Update(WIZARD_SITE_ID, $arFields);
}
COption::SetOptionString("main", "wizard_template_id", WIZARD_TEMPLATE_ID, false, WIZARD_SITE_ID);

// add mobile
if (is_dir($_SERVER["DOCUMENT_ROOT"].WizardServices::GetTemplatesPath(WIZARD_RELATIVE_PATH."/site")."/bd_deliverypizza_mobile")){
	$bitrixTemplateDir = $_SERVER["DOCUMENT_ROOT"].BX_PERSONAL_ROOT."/templates/bd_deliverypizza_mobile";
	CopyDirFiles(
		$_SERVER["DOCUMENT_ROOT"].WizardServices::GetTemplatesPath(WIZARD_RELATIVE_PATH."/site")."/bd_deliverypizza_mobile",
		$bitrixTemplateDir,
		$rewrite = true,
		$recursive = true,
		$delete_after_copy = false,
		$exclude = "themes"
	);
	//Attach template to default site
	$obSite = CSite::GetList($by = "def", $order = "desc", Array("LID" => WIZARD_SITE_ID));
	if ($arSite = $obSite->Fetch())
	{
		$arTemplates = Array();
		$found = false;
		$foundEmpty = false;
		$obTemplate = CSite::GetTemplateList($arSite["LID"]);
		while($arTemplate = $obTemplate->Fetch())
		{
			if($arTemplate["TEMPLATE"] == "bd_deliverypizza_mobile")
			{
				$found = true;
			}
			$arTemplates[]= $arTemplate;
		}
	
		if (!$found)
			$arTemplates[]= Array("CONDITION" => '($_SESSION["IS_MOBILE"] == true && $_SESSION["IS_TABLET"]==false)', "SORT" => 200, "TEMPLATE" => 'bd_deliverypizza_mobile');
	
		$arFields = Array(
				"TEMPLATE" => $arTemplates,
				"NAME" => $arSite["NAME"],
		);
	
		$obSite = new CSite();
		$obSite->Update($arSite["LID"], $arFields);
	}
}


?>
