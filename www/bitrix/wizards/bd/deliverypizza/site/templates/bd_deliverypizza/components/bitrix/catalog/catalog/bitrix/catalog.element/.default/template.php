<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

	 $arResult["OLD_PRICE"] = $arResult["PROPERTIES"]["OLD_PRICE"]["VALUE"];
	 $arResult["PRICE"] = $arResult["PROPERTIES"]["PRICE"]["VALUE"];	
	 $arResult["G"] = $arResult["PROPERTIES"]["G"]["VALUE"];
	 $arResult["G_UNITS"] = $arResult["PROPERTIES"]["UNITS"]["VALUE"];

?>
<div itemprop="description" class="product-description">
	<? if ($arResult['DETAIL_TEXT']): ?>
		<?= $arResult["DETAIL_TEXT"] ?>
	<? else: ?> 
		<?= $arResult["PREVIEW_TEXT"] ?>
	<?php endif; ?>
</div>
<?php if (!empty($arResult['PROPERTIES']['PROTEINS']['VALUE']) || !empty($arResult['PROPERTIES']['FATS']['VALUE']) || !empty($arResult['PROPERTIES']['CARBOHYDRATES']['VALUE']) || !empty($arResult['PROPERTIES']['CALORIFIC_VALUE']['VALUE'])): ?>
    <div class="product-energy"><a href="#"><?= GetMessage("item_energy_title"); ?></a>
        <div class="energy-value-content">
            <ul>
				<?php if (!empty($arResult['PROPERTIES']['PROTEINS']['VALUE'])): ?>
                    <li><span class="meta-property">
                      <div><?=GetMessage("item_energy_1");?></div></span><span class="meta-value"><?php echo $arResult['PROPERTIES']['PROTEINS']['VALUE']; ?></span></li>
				<?php endif; ?>
				<?php if (!empty($arResult['PROPERTIES']['FATS']['VALUE'])): ?>
                    <li><span class="meta-property">
                      <div><?=GetMessage("item_energy_2");?></div></span><span class="meta-value"><?php echo $arResult['PROPERTIES']['FATS']['VALUE']; ?></span></li>
				<?php endif; ?>
				<?php if (!empty($arResult['PROPERTIES']['CARBOHYDRATES']['VALUE'])): ?>
                    <li><span class="meta-property">
                      <div><?=GetMessage("item_energy_3");?></div></span><span class="meta-value"><?php echo $arResult['PROPERTIES']['CARBOHYDRATES']['VALUE']; ?></span></li>
				<?php endif; ?>
				<?php if (!empty($arResult['PROPERTIES']['CALORIFIC_VALUE']['VALUE'])): ?>
                    <li><span class="meta-property">
                      <div><?=GetMessage("item_energy_4");?></div></span><span class="meta-value"><?php echo $arResult['PROPERTIES']['CALORIFIC_VALUE']['VALUE']; ?></span></li>
				<?php endif; ?>
            </ul>
        </div>
    </div>
<?php endif; ?>
<div class="options_main_title"><?= GetMessage('choose_option') ?></div>
<div class="product-option-list_">
    <form>
		<?php $i = 1;
		foreach ($arResult['PROPS'] as $key => $props): ?>
            <div class="row">

                <div class="options-row-select col-xs-12 options-length-<?php echo count($arResult['PROPS']); ?>">
                    <div class="option_title"><?php echo $key; ?></div>
					<?php foreach ($props as $j => $val): ?>
                        <div>
                            <label>
                                <input <?= ($j == 0) ? 'checked="checked"' : '' ?> type="radio"
                                                                                   name="OPTION_<?= $i ?>"
                                                                                   value="<?php echo $j; ?>"
                                                                                   data-price="<?php echo $val['PRICE']; ?>"
                                                                                   data-old-price="<?php echo $val['OLD_PRICE']; ?>"
                                                                                   data-weight="<?php echo $val['WEIGHT']; ?>"/>
                                <label>
                                    <span></span>
                                </label>
                                <span><?php echo $val['VALUE']; ?></span>

                            </label>
                        </div>
					<?php endforeach; ?>
                </div>
            </div>
			<?php $i++; endforeach; ?>
    </form>
</div>

<div class="<? if ($arResult["OLD_PRICE"]): ?><? else: ?> base-price<? endif; ?>">
    <div itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="product-prices font-fix">
	                  <span class="old-price" <?if(!$arResult["OLD_PRICE"]):?>style="display: none;" <?endif;?>>
	                  	<span class="line-through"><?=number_format($arResult["OLD_PRICE"],(substr_count($arResult["OLD_PRICE"], '.') > 0) ? 2 : 0 ,'.',' ');?></span><span class="currency"><?=CURRENCY_FONT; ?></span>
	                  </span>
        <span class="current-price"><span itemprop="price"><?= number_format($arResult["PRICE"], (substr_count($arResult["PRICE"], '.') > 0) ? 2 : 0, '.', ' '); ?></span><span
                    class="currency"><?= CURRENCY_FONT; ?></span>
	                  <span itemprop="priceCurrency" class="text-hide"><?=CURRENCY_CODE; ?></span>
	                  </span>

        <span class="weight" <? if (!$arResult["G"]): ?> style="display: none;"<? endif; ?>><span><?= $arResult["G"] ?></span><span> <?= $arResult["G_UNITS"] ?></span></span>
		<?php if ($arResult['PROPERTIES']['NO_SALE']['VALUE'] == 'Y'): ?>
            <div title="<?= GetMessage("item_no_sale_title"); ?>" class="without-sale"></div><?php endif; ?>
    </div>
</div>
<div class="product-actions <?php if (intval($arResult['PROPERTIES']['BUY_IT']['VALUE']) !== 0 && $arResult['PROPERTIES']['BUY_IT']['VALUE'] - $arResult['PROPERTIES']['BUY_IT_COMPLETE']['VALUE'] > 0): ?>with-progress<?php endif; ?> <?php if (intval($arResult['PROPERTIES']['BUY_IT']['VALUE']) !== 0 && $arResult['PROPERTIES']['BUY_IT']['VALUE'] - $arResult['PROPERTIES']['BUY_IT_COMPLETE']['VALUE'] <= 0): ?>progress-complete<?php endif; ?>">


	<?php $delta = Bd\Deliverypizza\Models\Product::GetProductDelta($arResult['ID']);
	if ($delta < 0) $delta = 0; ?>
	<?php if (!empty($arResult['PROPERTIES']['BUY_IT']['VALUE'])): ?>
		<? Bd\Deliverypizza\UncachedArea::startCapture(); ?>
        <div class="progress-container">
            <div style="width: #PERCENT#%;" class="progress-bar"></div>
            <div class="progress-bar-content font-fix">
                <div>#PLURAL#</div>
            </div>
        </div>
		<? $delta_ = Bd\Deliverypizza\UncachedArea::endCapture(); ?>
		<? Bd\Deliverypizza\UncachedArea::show('productDelta', array('id' => $arResult['ID'], 'dc' => $delta_)); ?>
	<?php endif; ?>

	<? Bd\Deliverypizza\UncachedArea::startCapture(); ?>
    <a <?php if ($delta > 0): ?>data-max="<?= intval($delta); ?>"<?php endif; ?>
       data-id="<?php echo $arResult['ID']; ?>" href="#"
       class="add-to-cart-btn native"><?php echo GetMessage("add_to_basket"); ?></a>
	<? $buy = Bd\Deliverypizza\UncachedArea::endCapture(); ?>

	<? Bd\Deliverypizza\UncachedArea::startCapture(); ?>
    <a <?php if ($delta > 0): ?>data-max="<?= intval($delta); ?>"<?php endif; ?>
       data-id="<?php echo $arResult['ID']; ?>" href="#"
       class="add-to-cart-btn native retry"><?= GetMessage("one_more_add_button"); ?></a>
	<? $inBasket = Bd\Deliverypizza\UncachedArea::endCapture(); ?>
    <div class="col-xs-3 back-to-catalog nopadl">
        <a href="<?php echo $arResult['SECTION']['SECTION_PAGE_URL']; ?>"><span
                    class="go-back"><?= GetMessage("go_back"); ?></span></a></div>
    <div class="col-xs-4">
		<? Bd\Deliverypizza\UncachedArea::show('productBuyBlock', array('id' => $arResult['ID'], 'buy' => $buy, 'inBasket' => $inBasket)); ?>
    </div>
</div>

</div>
<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 pull-xl-8 pull-lg-8 pull-md-0 pull-sm-0 pull-xs-0">
    <div class="preview common-block">
		<? if ($arResult["PROPERTIES"]['BADGES']["VALUE"]): ?>
            <div class="product-labels">
				<? foreach ($arResult["BADGES"] as $key => $Badges) : ?>
                    <div title="<?= $Badges['NAME'] ?>" class="product-label"><img src="<?= $Badges['ICON'] ?>"></div>
				<? endforeach ?>
            </div>
		<? endif; ?>
		<? if ($arResult['PREVIEW_PICTURE']): ?>
			<?
			$MiniPhoto = CFile::ResizeImageGet($arResult['PREVIEW_PICTURE']['ID'], array('width' => '336', 'height' => '261'), BX_RESIZE_IMAGE_EXACT, true);
			$MiniPhoto2 = CFile::ResizeImageGet($arResult['PREVIEW_PICTURE']['ID'], array('width' => '379', 'height' => '275'), BX_RESIZE_IMAGE_EXACT, true);
			$MiniPhoto3 = CFile::ResizeImageGet($arResult['PREVIEW_PICTURE']['ID'], array('width' => '553', 'height' => '475'), BX_RESIZE_IMAGE_EXACT, true);
			$MiniPhoto4 = CFile::ResizeImageGet($arResult['PREVIEW_PICTURE']['ID'], array('width' => '480', 'height' => '372'), BX_RESIZE_IMAGE_EXACT, true);
			?>

            <picture>
                <source srcset="<?= CUtil::GetAdditionalFileURL($MiniPhoto3['src']); ?>" media="(max-width: 554px)">
                <source srcset="<?= CUtil::GetAdditionalFileURL($MiniPhoto2['src']); ?>" media="(max-width: 768px)">
                <source srcset="<?= CUtil::GetAdditionalFileURL($MiniPhoto4['src']); ?>" media="(max-width: 992px)">
                <source srcset="<?= CUtil::GetAdditionalFileURL($MiniPhoto['src']); ?>" media="(max-width: 2000px)">
                <a itemprop="image" href="<?= CUtil::GetAdditionalFileURL($MiniPhoto4['src']); ?>"
                   onclick="return false;">
                    <img
                            src="<?= CUtil::GetAdditionalFileURL($MiniPhoto4['src']); ?>"
                            alt="<?= $arResult["PREVIEW_PICTURE"]["ALT"] ?>"
                            title="<?= $arResult["PREVIEW_PICTURE"]["TITLE"] ?>"
                            class="product-image"
                    />
                </a>
            </picture>
		<? else: ?>
            <img src="<?= SITE_TEMPLATE_PATH ?>/images/no_photo.jpg" itemprop="image" class="product-image">
		<? endif; ?>
		<? Bd\Deliverypizza\UncachedArea::startCapture(); ?>
        <div class="likes">
            <div class="like-content">
                <div class="like-icon"></div>
                <span>#LIKES#</span>
            </div>
        </div>
		<? $like_native = Bd\Deliverypizza\UncachedArea::endCapture(); ?>
		<? Bd\Deliverypizza\UncachedArea::show('likesCount', array('arItem' => $arResult, 'like_native' => $like_native)); ?>
        <div class="icons">
            <div class="product-icon icon-hot"></div>
            <div class="product-icon icon-vegan"></div>
        </div>
    </div>
</div>
<div class="clearfix"></div>

