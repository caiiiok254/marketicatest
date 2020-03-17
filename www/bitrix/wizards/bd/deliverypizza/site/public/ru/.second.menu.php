<?
$aMenuLinks = Array(

);
if (COption::GetOptionString('bd.deliverypizza', 'BD_SUB_MODULE_CONSTRUCTOR', '', SITE_ID) == 'Y'){
	$aMenuLinks[] = Array(
		"Конструктор",
		SITE_DIR."catalog/constructor/",
		Array(),
		Array(),
		""
	);
}
?>