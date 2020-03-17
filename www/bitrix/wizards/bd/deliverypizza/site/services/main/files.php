<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
if (!defined("WIZARD_SITE_ID")) return;
if (!defined("WIZARD_SITE_DIR")) return;
 
function ___writeToAreasFile($fn, $text){
	if(file_exists($fn) && !is_writable($abs_path) && defined("BX_FILE_PERMISSIONS")){
		@chmod($abs_path, BX_FILE_PERMISSIONS);
	}
	if(!$fd = @fopen($fn, "wb")){
		return false;
	}
	if(!$res = @fwrite($fd, $text)){
		@fclose($fd);
		return false;
	}
	@fclose($fd);
	if(defined("BX_FILE_PERMISSIONS"))
		@chmod($fn, BX_FILE_PERMISSIONS);
}
$bitrixTemplateDir = $_SERVER["DOCUMENT_ROOT"].BX_PERSONAL_ROOT."/templates/".WIZARD_TEMPLATE_ID."/";
$wizard =& $this->GetWizard(); 

if(COption::GetOptionString("bd.deliverypizza", "wizard_installed", "N") == 'N'){
	COption::SetOptionString("bd.deliverypizza", "wizard_installed", "Y");
}
 
if(WIZARD_INSTALL_DEMO_DATA){
	CopyDirFiles(
		str_replace("//", "/", WIZARD_ABSOLUTE_PATH."/site/public/".LANGUAGE_ID."/"),
		WIZARD_SITE_PATH,
		$rewrite = true, 
		$recursive = true,
		$delete_after_copy = false,
		$exclude = "bitrix"
	);
	
	WizardServices::PatchHtaccess(WIZARD_SITE_PATH);
	
	// replace macros SITE_DIR & SITE_ID
	CWizardUtil::ReplaceMacrosRecursive(WIZARD_SITE_PATH, Array("SITE_DIR" => WIZARD_SITE_DIR));
	CWizardUtil::ReplaceMacrosRecursive(WIZARD_SITE_PATH, Array("SITE_ID" => WIZARD_SITE_ID));

	// add to UrlRewrite
	$arUrlRewrite = array(); 
	if(file_exists(WIZARD_SITE_ROOT_PATH."/urlrewrite.php")){
		include(WIZARD_SITE_ROOT_PATH."/urlrewrite.php");
	}
	$arNewUrlRewrite = array(
		array(
			"CONDITION" => "#^".WIZARD_SITE_DIR."catalog/#",
			"RULE" => "",
			"ID" => "bitrix:catalog",
			"PATH" => WIZARD_SITE_DIR."catalog/index.php",
		),
		array(
			"CONDITION" => "#^".WIZARD_SITE_DIR."sales/#",
			"RULE" => "",
			"ID" => "bitrix:news",
			"PATH" => WIZARD_SITE_DIR."sales/index.php",
		),
		array(
			"CONDITION" => "#^".WIZARD_SITE_DIR."news/#",
			"RULE" => "",
			"ID" => "bitrix:news",
			"PATH" => WIZARD_SITE_DIR."news/index.php",
		),
	);
	
	foreach($arNewUrlRewrite as $arUrl){
		if(!in_array($arUrl, $arUrlRewrite)){
			CUrlRewriter::Add($arUrl);
		}
	}

	CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/.section.php", array("SITE_DESCRIPTION" => htmlspecialcharsbx($wizard->GetVar("siteMetaDescription"))));
	CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/.section.php", array("SITE_KEYWORDS" => htmlspecialcharsbx($wizard->GetVar("siteMetaKeywords"))));
}

CheckDirPath(WIZARD_SITE_PATH."include/");

if($wizard->GetVar('rewriteIndex', true)){
	CopyDirFiles(
		WIZARD_ABSOLUTE_PATH."/site/public/".LANGUAGE_ID."/_index.php",
		WIZARD_SITE_PATH."/index.php",
		$rewrite = true,
		$recursive = true,
		$delete_after_copy = false
	);
	CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/_index.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
	CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/index.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
}
?>