<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
CJSCore::Init(array("jquery"));
$APPLICATION->SetAdditionalCss("/local/assets/fancybox/jquery.fancybox.min.css");
$APPLICATION->AddHeadScript("/local/assets/fancybox/jquery.fancybox.min.js");
?>
<div class="product__wrap">
    <h2 class="product__title"><?=$arResult["NAME"]?></h2>
    <div class="product-list">
    <?if(count($arResult["ITEMS"])>0){
    foreach($arResult["ITEMS"] as $arItem){
        $this->AddEditAction($arItem['ID'], $arItem['ADD_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_ADD"));
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?> 
        <div class="product-list__item">
			<div class="product-list__wrap" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
				<a class="product-list__text" href="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" data-fancybox><img class="product-list__img" src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="..." /></a>
			</div>
        </div>
        <?}}?>        
    </div>
</div>
     