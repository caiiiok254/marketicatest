<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?CJSCore::Init(array("jquery"));?>
<div class="product__wrap">
    <h2 class="product__title"><?=$arResult["NAME"]?></h2>
    <div class="product-list">
    <?
    if(count($arResult["ITEMS"])>0){
    $arItems = $arResult["ITEMS"];
    foreach($arItems as $arItem){
        $this->AddEditAction($arItem['ID'], $arItem['ADD_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_ADD"));
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?> 
        <div class="product-list__item">
			<div class="product-list__wrap" id="<?=$this->GetEditAreaId($arItem['ID']);?>">				
				<div id="<?=$arItem["ID"]?>" class="fancybox-productPopup" href="javascript:;"><img class="product-list__img" src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="..." /></div>
				<a class="product-list__text" href="/product/<?=$arItem["CODE"]?>"><?=$arItem["NAME"]?></a>
				<div class="product__spoiler">
					<div class="btn-spolier onSpoiler ">Описание</div>
					<div class="product__spoilerbox spoiler-hide">				
							<div class="product-text__valign"><?=$arItem["~PREVIEW_TEXT"]?></div>				
					</div>
				</div>
			</div>
        </div>
        <?}}?>        
    </div>
</div>
     