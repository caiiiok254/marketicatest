<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?CJSCore::Init(array("jquery"));?>
<? $db_props = CIBlockElement::GetProperty($arResult["IBLOCK_ID"], $arResult["ID"], "sort", "asc", array()); ?>
<? $ar_props = $db_props->Fetch(); ?>
<? $getPic = CIBlockElement::GetByID($arResult["ID"])->GetNextElement()->GetFields(); ?>
<div class="wrap">
	<h2 class="chrono__title"><?=$arResult["NAME"]?></h2>
    <div> <img class="product-list__img" src="<?=CFile::GetPath($getPic["PREVIEW_PICTURE"]) ?>" alt="..." /> </div>
    <br>
	<?=$arResult["PREVIEW_TEXT"]; ?>
    <h2>Цена: <?=$ar_props["VALUE"]?></h2>
</div>