<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();
	
if(!defined("WIZARD_SITE_ID")) return;

COption::SetOptionString("main", "captcha_registration", "N");
COption::SetOptionString("fileman", "propstypes", serialize(array("description"=>GetMessage("MAIN_OPT_DESCRIPTION"), "keywords"=>GetMessage("MAIN_OPT_KEYWORDS"), "title"=>GetMessage("MAIN_OPT_TITLE"), "keywords_inner"=>GetMessage("MAIN_OPT_KEYWORDS_INNER"))), false, $siteID);
COption::SetOptionInt("search", "suggest_save_days", 250);
COption::SetOptionString("search", "use_tf_cache", "Y");
COption::SetOptionString("search", "use_word_distance", "Y");
COption::SetOptionString("search", "use_social_rating", "Y");
COption::SetOptionString("iblock", "use_htmledit", "Y");
COption::SetOptionString("iblock", "combined_list_mode", "Y");
COption::SetOptionString("main", "optimize_css_files", "Y", false, $siteID);
COption::SetOptionString("main", "optimize_js_files", "Y", false, $siteID);
COption::SetOptionString("main", "use_minified_assets", "Y", false, $siteID);
COption::SetOptionString("main", "move_js_to_body", "Y", false, $siteID);
COption::SetOptionString("main", "compres_css_js_files", "Y", false, $siteID);


$arSites = Array();
$rsSites = CSite::GetList($by="sort", $order="desc");
while ($ar = $rsSites->Fetch())
	$arSites[] = $ar['LID'];


// NEW ORDER
$etInstalled = CEventType::GetList(Array("TYPE_ID" => "BD_NEW_ORDER"))->SelectedRowsCount();

if (!$etInstalled)
{
	$obET = new CEventType();
	$obET->Add(array(
			"LID"           => 'ru',
			"EVENT_NAME"    => "BD_NEW_ORDER",
			"NAME"          => GetMessage("BD_ORDER_NAME"),
			"DESCRIPTION"   => GetMessage("BD_ORDER_DESCRIPTION"),
		)
	);
}

$obEM = new CEventMessage();
$rsEventMessages = CEventMessage::GetList($by="site_id", $order="desc", Array("EVENT_NAME" => "BD_NEW_ORDER"));
if ($rsEventMessages->SelectedRowsCount() > 0)
{
	while ($arEventMessage = $rsEventMessages->Fetch())
		$obEM->Update($arEventMessage['ID'], Array('LID' => $arSites));
}
else
{
	$obEM->Add(Array(
		"ACTIVE" => "Y",
		"EVENT_NAME" => "BD_NEW_ORDER",
		'LID' => $arSites,
		'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
		'EMAIL_TO' => '#DEFAULT_EMAIL_FROM#',
		"SUBJECT" => GetMessage("BD_ORDER_SUBJECT"),
		'BODY_TYPE' => 'html',
		'MESSAGE' => GetMessage("BD_ORDER_BODY"),
	));
}


// ORDER PAID
$etInstalled = CEventType::GetList(Array("TYPE_ID" => "BD_ORDER_PAID"))->SelectedRowsCount();

if (!$etInstalled)
{
	$obET = new CEventType();
	$obET->Add(array(
			"LID"           => 'ru',
			"EVENT_NAME"    => "BD_ORDER_PAID",
			"NAME"          => GetMessage("BD_ORDER_PAID_NAME"),
			"DESCRIPTION"   => GetMessage("BD_ORDER_PAID_DESCRIPTION"),
		)
	);
}

$obEM = new CEventMessage();
$rsEventMessages = CEventMessage::GetList($by="site_id", $order="desc", Array("EVENT_NAME" => "BD_ORDER_PAID"));
if ($rsEventMessages->SelectedRowsCount() > 0)
{
	while ($arEventMessage = $rsEventMessages->Fetch())
		$obEM->Update($arEventMessage['ID'], Array('LID' => $arSites));
}
else
{
	$obEM->Add(Array(
		"ACTIVE" => "Y",
		"EVENT_NAME" => "BD_ORDER_PAID",
		'LID' => $arSites,
		'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
		'EMAIL_TO' => '#DEFAULT_EMAIL_FROM#',
		"SUBJECT" => GetMessage("BD_ORDER_PAID_SUBJECT"),
		'BODY_TYPE' => 'html',
		'MESSAGE' => GetMessage("BD_ORDER_PAID_BODY"),
	));
}


// USER RESET PASSWORD
$etInstalled = CEventType::GetList(Array("TYPE_ID" => "BD_USER_RESET_PASSWORD"))->SelectedRowsCount();

if (!$etInstalled)
{
	$obET = new CEventType();
	$obET->Add(array(
			"LID"           => 'ru',
			"EVENT_NAME"    => "BD_USER_RESET_PASSWORD",
			"NAME"          => GetMessage("BD_USER_RESET_PASSWORD_NAME"),
			"DESCRIPTION"   => GetMessage("BD_USER_RESET_PASSWORD_DESCRIPTION"),
		)
	);
}

$obEM = new CEventMessage();
$rsEventMessages = CEventMessage::GetList($by="site_id", $order="desc", Array("EVENT_NAME" => "BD_USER_RESET_PASSWORD"));
if ($rsEventMessages->SelectedRowsCount() > 0)
{
	while ($arEventMessage = $rsEventMessages->Fetch())
		$obEM->Update($arEventMessage['ID'], Array('LID' => $arSites));
}
else
{
	$obEM->Add(Array(
		"ACTIVE" => "Y",
		"EVENT_NAME" => "BD_USER_RESET_PASSWORD",
		'LID' => $arSites,
		'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
		'EMAIL_TO' => '#EMAIL#',
		"SUBJECT" => GetMessage("BD_USER_RESET_PASSWORD_SUBJECT"),
		'BODY_TYPE' => 'html',
		'MESSAGE' => GetMessage("BD_USER_RESET_PASSWORD_BODY"),
	));
}
?>