<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if(!defined("WIZARD_SITE_ID")) return;
if(!defined("WIZARD_SITE_DIR")) return;
if(!defined("WIZARD_SITE_PATH")) return;
if(!defined("WIZARD_TEMPLATE_ID")) return;
if(!defined("WIZARD_TEMPLATE_ABSOLUTE_PATH")) return;

if(!WIZARD_INSTALL_DEMO_DATA){
	return;
}

$bitrixTemplateDir = $_SERVER["DOCUMENT_ROOT"].BX_PERSONAL_ROOT."/templates/".WIZARD_TEMPLATE_ID."/";

CopyDirFiles(
	WIZARD_THEME_ABSOLUTE_PATH,
	$_SERVER["DOCUMENT_ROOT"].$templateDir,
	$rewrite = true, 
	$recursive = true,
	$delete_after_copy = false,
	$exclude = "description.php"
);

COption::SetOptionString("main", "wizard_site_logo", WIZARD_SITE_LOGO, "", WIZARD_SITE_ID);
COption::SetOptionString("main", "wizard_".WIZARD_TEMPLATE_ID."_theme_id", WIZARD_THEME_ID, "", WIZARD_SITE_ID);

//Color scheme for main.interface.grid/form
require_once($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/classes/".strToLower($GLOBALS["DB"]->type)."/favorites.php");
CUserOptions::SetOption("main.interface", "global", array("theme" => WIZARD_THEME_ID), true);
?>