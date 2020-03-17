<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/install/wizard_sol/wizard.php");
use Bitrix\Main\Localization\Loc;

if(!CModule::IncludeModule("bd.deliverypizza")){
	if(@file_exists($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/bd.deliverypizza/install/index.php")){
		include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/bd.deliverypizza/install/index.php");
		$obModule = new bd_deliverypizza();
		if(!$obModule->IsInstalled()){
			$obModule->DoInstall();
		}
	}
}

class SelectSiteStep extends CSelectSiteWizardStep {
	function InitStep() {
		parent::InitStep();
		
		$wizard =& $this->GetWizard();
		$wizard->solutionName = "deliverypizza";
	}
}
class SelectTemplateStep extends CSelectTemplateWizardStep {
	function ShowStep(){
		parent::ShowStep();
		echo '<script
  src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
  integrity="sha256-k2WSCIexGzOj3Euiig+TlR8gA0EmPjuc79OEeY5L45g="
  crossorigin="anonymous"></script>';
		echo '<script>$(document).ready(function(){$(".inst-template-description #bd_deliverypizza_mobile").parent().remove()})</script>';
	}
}
class SelectThemeStep extends CSelectThemeWizardStep
{

}

class SiteSettingsStep extends CSiteSettingsWizardStep
{
	function InitStep()
	{
		$wizard =& $this->GetWizard();
		$wizard->solutionName = "deliverypizza";
		parent::InitStep();

		$templateID = $wizard->GetVar("templateID");
		$themeID = $wizard->GetVar($templateID."_themeID");
		
		$wizard->SetDefaultVars(
			Array(
				"siteMetaDescription" => GetMessage("wiz_site_desc"),
				"siteMetaKeywords" => GetMessage("wiz_keywords"),  
			)
		);
	}

	function ShowStep()
	{
		$wizard =& $this->GetWizard();
		$firstStep = COption::GetOptionString("main", "wizard_first" . substr($wizard->GetID(), 7)  . "_" . $wizard->GetVar("siteID"), false, $wizard->GetVar("siteID")); 

		$styleMeta = 'style="display:block"';
		if($firstStep == "Y") $styleMeta = 'style="display:none"';


		$this->content .= '
		<div  id="bx_metadata" '.$styleMeta.'>
			<div class="wizard-input-form-block">
				<div class="wizard-metadata-title">'.GetMessage("wiz_meta_data").'</div>
				<div class="wizard-upload-img-block">
					<label for="siteMetaDescription" class="wizard-input-title">'.GetMessage("wiz_meta_description").'</label>
					'.$this->ShowInputField("textarea", "siteMetaDescription", Array("id" => "siteMetaDescription", "class" => "wizard-field", "rows"=>"3")).'
				</div>';
			$this->content .= '
				<div class="wizard-upload-img-block">
					<label for="siteMetaKeywords" class="wizard-input-title">'.GetMessage("wiz_meta_keywords").'</label><br>
					'.$this->ShowInputField('text', 'siteMetaKeywords', array("id" => "siteMetaKeywords", "class" => "wizard-field")).'
				</div>
			</div>
		</div>';
		
		if($firstStep == "Y")
		{

			$this->content .= $this->ShowCheckboxField("installDemoData", "Y", 
				(array("id" => "install-demo-data", "onClick" => "if(this.checked == true){document.getElementById('bx_metadata').style.display='block';}else{document.getElementById('bx_metadata').style.display='none';}")));
			$this->content .= '<label for="install-demo-data">'.GetMessage("wiz_structure_data").'</label><br />';

		}
		else
		{
			$this->content .= $this->ShowHiddenField("installDemoData","Y");
		}

		$formName = $wizard->GetFormName();
		$installCaption = $this->GetNextCaption();
		$nextCaption = GetMessage("NEXT_BUTTON");
	}
}

class DataInstallStep extends CDataInstallWizardStep
{
	function CorrectServices(&$arServices)
	{
		$wizard =& $this->GetWizard();
		if($wizard->GetVar("installDemoData") != "Y")
		{
		}
	}
}

class FinishStep extends CFinishWizardStep{
	public $MODULE_ID = "bd.deliverypizza";
	function InitStep(){
		$this->SetStepID("finish");
		$this->SetNextStep("finish");
		$this->SetTitle(GetMessage("FINISH_STEP_TITLE"));
		$this->SetNextCaption(GetMessage("wiz_go"));
	}

	function checkValid(){
		return true;
	}

	function ShowStep(){
		$wizard =& $this->GetWizard();

		$templateID = $wizard->GetVar("templateID");
		$ThemeID = $wizard->GetVar($templateID."_themeID");
		$this->content .='<script type="text/javascript">$(document).ready(function(){setWizardBackgroundColor("'.$ThemeID.'");});</script>';

		if($wizard->GetVar("installDemoData") == "Y")
		{
			if(!CModule::IncludeModule("iblock")) return;
		}

		if ($wizard->GetVar("proactive") == "Y")
			COption::SetOptionString("statistic", "DEFENCE_ON", "Y");

		$siteID = WizardServices::GetCurrentSiteID($wizard->GetVar("siteID"));
		$rsSites = CSite::GetByID($siteID);
		$siteDir = "/";
		if ($arSite = $rsSites->Fetch())
			$siteDir = $arSite["DIR"];

		$wizard->SetFormActionScript(str_replace("//", "/", $siteDir."/?finish"));

		$this->CreateNewIndex();

		COption::SetOptionString("main", "wizard_solution", $wizard->solutionName, false, $siteID);

		$this->content .= GetMessage("FINISH_STEP_CONTENT");
		$this->content .= "";

		if ($wizard->GetVar("installDemoData") == "Y")
			$this->content .= GetMessage("FINISH_STEP_REINDEX");

		COption::SetOptionString("bd.deliverypizza", "WIZARD_DEMO_INSTALLED", "Y");
			if ($wizard->GetVar("installDemoData") == "Y"){
				Loc::loadMessages($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/".$this->MODULE_ID."/options.php");
				
				$options = include_once $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'.$this->MODULE_ID.'/options_config.php';
				
				$defaultOptions = array();
				
				
				foreach($options as $option){
					if(isset($option[1])){
						if($option[1] == 'bd_custom'){
							$defaultOptions[$option[0]] = $option['DEFAULT'];
						}else{
							if(isset($option[3]) && is_array($option[3]))
								$defaultOptions[$option[0]] = $option[3]['DEFAULT'];
						}
					}
					if(isset($option['relation_fields'])){
						foreach($option['relation_fields'] as $rel){
							foreach($rel as $rel_i){
								$defaultOptions[$rel_i[0]] = $rel_i['DEFAULT'];
							}
						}
					}
				}
				if(!file_exists($_SERVER["DOCUMENT_ROOT"].'/upload/'.$this->MODULE_ID.'/')){
					mkdir($_SERVER["DOCUMENT_ROOT"].'/upload/'.$this->MODULE_ID.'/',0777);
				}
				$logo = \CFile::SaveFile(\CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".$this->MODULE_ID."/img/logo.png"),$this->MODULE_ID);
				$logo_m = \CFile::SaveFile(\CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".$this->MODULE_ID."/img/logo_mobile.png"),$this->MODULE_ID);
				$sharing_img = \CFile::SaveFile(\CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".$this->MODULE_ID."/img/sharing.jpg"),$this->MODULE_ID);
				$defaultOptions['BD_SITE_LOGO'] = $logo;
				$defaultOptions['BD_SITE_LOGO_MOBILE'] = $logo_m;
				$defaultOptions['BD_SHARING_IMG'] = $sharing_img;
				$arSites = array();
				$db_res = CSite::GetList($by , $sort ,array("ACTIVE"=>"Y"));
				while($res = $db_res->Fetch()){
					$arSites[] = $res;
				}
				foreach($arSites as $site){
					foreach($defaultOptions as $key=>$val){
						\Bitrix\Main\Config\Option::set($this->MODULE_ID,$key,$val,$site['ID']);
					}
				}
			}
			
		COption::SetOptionString("main", "optimize_css_files", "Y");
		COption::SetOptionString("main", "optimize_js_files", "Y");
		COption::SetOptionString("main", "use_minified_assets", "Y");
		COption::SetOptionString("main", "move_js_to_body", "Y");
		COption::SetOptionString("main", "compres_css_js_files", "Y");
		BXClearCache(true);
	}
}
?>