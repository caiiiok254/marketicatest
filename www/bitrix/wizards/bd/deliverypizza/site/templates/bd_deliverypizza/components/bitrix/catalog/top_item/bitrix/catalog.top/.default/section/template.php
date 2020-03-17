<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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

use Bitrix\Main\Loader;

Loader::includeModule('bd.deliverypizza');

use Bd\Deliverypizza;

$this->setFrameMode(true);
?>
<!--RestartBuffer-->
<?
if (isset($_GET['AJAX_PAGE'])) {
	$APPLICATION->RestartBuffer();
}

foreach ($arResult["ITEMS"] as $arItem):

	$arItem["OLD_PRICE"] = $arItem["PROPERTIES"]["OLD_PRICE"]["VALUE"];
	$arItem["PRICE"] = $arItem["PROPERTIES"]["PRICE"]["VALUE"];
	$arItem["G"] = $arItem["PROPERTIES"]["G"]["VALUE"];
	$arItem["G_UNITS"] = $arItem["PROPERTIES"]["UNITS"]["VALUE"];

	?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>

	<? if ($arItem["PROPERTIES"]['BANNER']["VALUE"]): ?>
    <div class="<?php if(\COption::GetOptionString('bd.deliverypizza','BD_DELIVERY_MAIN_PAGE_STATIC_BLOCKS','',SITE_ID) == 'Y'): ?>col-xl-4 col-lg-4 <?php else: ?> col-xl-3 col-lg-3 <?php endif; ?>col-sm-6 product-ajax-cont <?php if (isset($_GET['AJAX_PAGE'])): ?>animate<?php endif; ?>">
        <div data-id="<?= $arItem['ID']; ?>" class="product banner" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
			<?
			$Banner = CFile::ResizeImageGet($arItem["PROPERTIES"]['BANNER']["VALUE"], array('width' => '255', 'height' => '435'), BX_RESIZE_IMAGE_EXACT, true);
			$Banner2 = CFile::ResizeImageGet($arItem["PROPERTIES"]['BANNER']["VALUE"], array('width' => '222', 'height' => '435'), BX_RESIZE_IMAGE_EXACT, true);
			$Banner3 = CFile::ResizeImageGet($arItem["PROPERTIES"]['BANNER']["VALUE"], array('width' => '344', 'height' => '435'), BX_RESIZE_IMAGE_EXACT, true);
			$Banner4 = CFile::ResizeImageGet($arItem["PROPERTIES"]['BANNER']["VALUE"], array('width' => '275', 'height' => '465'), BX_RESIZE_IMAGE_EXACT, true);
			$Banner5 = CFile::ResizeImageGet($arItem["PROPERTIES"]['BANNER']["VALUE"], array('width' => '344', 'height' => '435'), BX_RESIZE_IMAGE_EXACT, true);
			?>
			<? if ($arItem["PROPERTIES"]['BANNER_URL']["VALUE"]): ?>
            <a href="<?= $arItem["PROPERTIES"]['BANNER_URL']["VALUE"] ?>">
				<? endif;
				?>
                <picture>
                    <source srcset="<?= CUtil::GetAdditionalFileURL($Banner5['src']); ?>" media="(max-width: 554px)">
                    <source srcset="<?= CUtil::GetAdditionalFileURL($Banner4['src']); ?>" media="(max-width: 768px)">
                    <source srcset="<?= CUtil::GetAdditionalFileURL($Banner3['src']); ?>" media="(max-width: 991px)">
                    <source srcset="<?= CUtil::GetAdditionalFileURL($Banner2['src']); ?>" media="(max-width: 1199px)">
                    <source srcset="<?= CUtil::GetAdditionalFileURL($Banner['src']); ?>" media="(max-width: 2000px)">

                    <img
                            srcset="<?= CUtil::GetAdditionalFileURL($Banner['src']); ?>"
                            itemprop="image"
                            class="product-image"
                    />
                </picture>
				<? if ($arItem["PROPERTIES"]['BANNER_URL']["VALUE"]): ?>
            </a>
		<? endif;
		?>
        </div>
    </div>
<? else: ?>
	<?php
	$prop_choose_label = $arItem['PROPERTIES']['OPTIONS_CHOOSE']['VALUE'];
	if (empty($prop_choose_label))
		$prop_choose_label = GetMessage("choose_option_");
	?>
    <div class="<?php if(\COption::GetOptionString('bd.deliverypizza','BD_DELIVERY_MAIN_PAGE_STATIC_BLOCKS','',SITE_ID) == 'Y'): ?>col-xl-4 col-lg-4<?php else: ?> col-xl-3 col-lg-3 <?php endif; ?> col-sm-6 col-xs-12">
        <div data-choose-label="<?=$prop_choose_label?>" data-id="<?= $arItem['ID']; ?>" itemscope itemtype="http://schema.org/Product" class="product product-item"
             id="<?= $this->GetEditAreaId($arItem['ID']); ?>"
             data-unit="<?php echo $arItem['PROPERTIES']['UNITS']['VALUE']; ?>">

            <div style="display: none;" class="product-options">

                <div class="product-option-list_ scrollbar-macosx">
                    <form>
						<?php $i = 1;
						foreach ($arItem['PROPS'] as $key => $props): ?>
                            <div class="row">

                                <div class="options-row-select col-xs-12 options-length-<?php echo count($arItem['PROPS']); ?>">
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
            </div>
            <div data-modal="product-detail" class="preview md-trigger base-view">
				<? if ($arItem["PROPERTIES"]['BADGES']["VALUE"]): ?>
                    <div class="product-labels">
						<? foreach ($arItem["BADGES"] as $key => $Badges) : ?>
                            <div title="<?= $Badges['NAME'] ?>" class="product-label"><img src="<?= $Badges['ICON'] ?>">
                            </div>
						<? endforeach ?>
                    </div>
				<? endif; ?>

				<? if ($arItem['PREVIEW_PICTURE']): ?>
					<?

                    $preLoadPhoto = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']['ID'], array('width' => '25', 'height' => '19'), BX_RESIZE_IMAGE_EXACT, true);


					$MiniPhoto = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']['ID'], array('width' => '254', 'height' => '197'), BX_RESIZE_IMAGE_EXACT, true);
					$MiniPhoto2 = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']['ID'], array('width' => '353', 'height' => '275'), BX_RESIZE_IMAGE_EXACT, true);
					$MiniPhoto3 = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']['ID'], array('width' => '553', 'height' => '475'), BX_RESIZE_IMAGE_EXACT, true);
					$MiniPhoto4 = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']['ID'], array('width' => '342', 'height' => '265'), BX_RESIZE_IMAGE_EXACT, true);

					?>
                <div class="image-tmp">
                    <source srcset="<?= CUtil::GetAdditionalFileURL($MiniPhoto3['src']); ?>"
                            media="(max-width: 554px)">
                    <source srcset="<?= CUtil::GetAdditionalFileURL($MiniPhoto2['src']); ?>"
                            media="(max-width: 768px)">
                    <source srcset="<?= CUtil::GetAdditionalFileURL($MiniPhoto4['src']); ?>"
                            media="(max-width: 992px)">
                    <source srcset="<?= CUtil::GetAdditionalFileURL($MiniPhoto['src']); ?>"
                            media="(max-width: 2000px)">
                </div>
                    <picture>

                        <img
                                data-full = "<?= CUtil::GetAdditionalFileURL($MiniPhoto['src']); ?>"
                                style="width: 254px;height: 197px;"
                                srcset="<?= CUtil::GetAdditionalFileURL($preLoadPhoto['src']); ?>"
                                alt="<?= $arItem["PREVIEW_PICTURE"]["ALT"] ?>"
                                title="<?= $arItem["PREVIEW_PICTURE"]["TITLE"] ?>"
                                class="product-image progressiveLoad"
                        />

                    </picture>
                    <a style="display: none;" itemprop="image"
                       href="<?= CUtil::GetAdditionalFileURL($MiniPhoto['src']); ?>" onclick="return false;"></a>
				<? else: ?>
                    <img src="<?= SITE_TEMPLATE_PATH ?>/images/no_photo.jpg" itemprop="image" class="product-image">
				<? endif; ?>

                <div class="overlay">
                    <div class="zoom-btn"></div>
                </div>
				<?php if ($arItem['PROPERTIES']['NO_SALE']['VALUE'] == 'Y'): ?>
                <div title="<?= GetMessage("item_no_sale_title"); ?>" class="without-sale"></div><?php endif; ?>
				<? Bd\Deliverypizza\UncachedArea::startCapture(); ?>
                <div class="likes">
                    <div class="like-content">
                        <div class="like-icon"></div>
                        <span>#LIKES#</span>
                    </div>
                </div>
				<? $like_native = Bd\Deliverypizza\UncachedArea::endCapture(); ?>
				<? Bd\Deliverypizza\UncachedArea::show('likesCount', array('arItem' => $arItem, 'like_native' => $like_native)); ?>
            </div>
            <div class="product-info base-view">
                <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>" onclick="return false;"
                   class="product-title font-fix base-view"><span
                            itemprop="name"><?= $arItem["NAME"] ?></span></a>
                <div itemprop="description" class="product-description base-view">
					<?= TruncateText(strip_tags($arItem["PREVIEW_TEXT"]),170) ?>
                </div>
            </div>
			<?php if (!empty($arItem["PRICE"]) && $arItem["PRICE"] != 0): ?>
                <div class="product-footer<? if ($arItem["OLD_PRICE"]): ?><? else: ?> base-price<? endif; ?>">
                    <div itemprop="offers" itemscope itemtype="http://schema.org/Offer"
                         class="product-prices font-fix">

	                  <span class="old-price" <? if (!$arItem["OLD_PRICE"]): ?>style="display: none;" <? endif; ?>>

	                  	<span class="line-through"><?= number_format($arItem["OLD_PRICE"], (substr_count($arItem["OLD_PRICE"], '.') > 0) ? 2 : 0, '.', ' '); ?></span><span
                                  class="currency"><?= CURRENCY_FONT; ?></span>
	                  </span>

                        <span class="current-price"><span
                                    itemprop="price"><?= number_format($arItem["PRICE"], (substr_count($arItem["PRICE"], '.') > 0) ? 2 : 0, '.', ' '); ?></span><span
                                    class="currency"><?= CURRENCY_FONT; ?></span>
	                  <span itemprop="priceCurrency" class="text-hide"><?= CURRENCY_CODE ?></span>
	                  </span>

                        <span class="weight" <? if (!$arItem["G"]): ?> style="display: none;"<? endif; ?>><span><?= $arItem["G"] ?></span><span> <?= $arItem["G_UNITS"] ?></span></span>

                    </div>
                    <div class="product-actions clearfix <?php if (intval($arItem['PROPERTIES']['BUY_IT']['VALUE']) !== 0 && $arItem['PROPERTIES']['BUY_IT']['VALUE'] - $arItem['PROPERTIES']['BUY_IT_COMPLETE']['VALUE'] > 0): ?>with-progress<?php endif; ?> <?php if (intval($arItem['PROPERTIES']['BUY_IT']['VALUE']) !== 0 && ($arItem['PROPERTIES']['BUY_IT']['VALUE'] - $arItem['PROPERTIES']['BUY_IT_COMPLETE']['VALUE'] == 0 || $arItem['PROPERTIES']['BUY_IT']['VALUE'] - $arItem['PROPERTIES']['BUY_IT_COMPLETE']['VALUE'] < 0)): ?>progress-complete<?php endif; ?>">
						<?php
						$delta = Bd\Deliverypizza\Models\Product::GetProductDelta($arItem['ID']);
						if ($delta < 0) $delta = 0; ?>
						<?php if (!empty($arItem['PROPERTIES']['BUY_IT']['VALUE'])): ?>
							<? Bd\Deliverypizza\UncachedArea::startCapture(); ?>
                            <div class="progress-container">
                                <div style="width: #PERCENT#%;" class="progress-bar"></div>
                                <div class="progress-bar-content font-fix">
                                    <div>#PLURAL#</div>
                                </div>
                            </div>
							<? $delta_ = Bd\Deliverypizza\UncachedArea::endCapture(); ?>
							<? Bd\Deliverypizza\UncachedArea::show('productDelta', array('id' => $arItem['ID'], 'dc' => $delta_)); ?>
						<?php endif; ?>
						<? Bd\Deliverypizza\UncachedArea::startCapture(); ?>

                        <a href="#" class="product-back pull-xs-left"></a>
                        <a <?php if ($delta > 0): ?>data-max="<?= intval($delta); ?>"<?php endif; ?>
                           data-id="<?php echo $arItem['ID']; ?>" href="#"
                           class="add-to-cart-btn native choose_options pull-xs-right"><?php echo $prop_choose_label; ?></a>
						<? $choose = Bd\Deliverypizza\UncachedArea::endCapture(); ?>
						<? Bd\Deliverypizza\UncachedArea::startCapture(); ?>
                        <a <?php if ($delta > 0): ?>data-max="<?= intval($delta); ?>"<?php endif; ?>
                           data-id="<?php echo $arItem['ID']; ?>" href="#"
                           class="add-to-cart-btn native"><?php echo GetMessage("add_to_basket"); ?></a>
						<? $buy = Bd\Deliverypizza\UncachedArea::endCapture(); ?>

						<? Bd\Deliverypizza\UncachedArea::startCapture(); ?>
                        <a <?php if ($delta > 0): ?>data-max="<?= intval($delta); ?>"<?php endif; ?>
                           data-id="<?php echo $arItem['ID']; ?>" href="#"
                           class="add-to-cart-btn native retry"><?= GetMessage("one_more_add_button"); ?></a>
						<? $inBasket = Bd\Deliverypizza\UncachedArea::endCapture(); ?>
						<? Bd\Deliverypizza\UncachedArea::show('productBuyBlock', array('id' => $arItem['ID'], 'buy' => $buy, 'inBasket' => $inBasket, 'choose' => $choose, 'props' => $arItem['PROPS'])); ?>
                    </div>
                </div>
			<?php endif; ?>
        </div>
    </div>
<? endif; ?>
<? endforeach; ?>
<?php
$paramName = 'PAGEN_' . $arResult['NAV_RESULT']->NavNum;
$paramValue = $arResult['NAV_RESULT']->NavPageNomer;
$pageCount = $arResult['NAV_RESULT']->NavPageCount;

if ($paramValue < $pageCount) {
	$paramValue = (int)$paramValue + 1;
	$url = htmlspecialcharsbx(
		$APPLICATION->GetCurPageParam(
			sprintf('%s=%s', $paramName, $paramValue),
			array($paramName, 'AJAX_PAGE',)
		)
	);
	echo sprintf('<div class="ajax-pager-wrap">
                      <a class="ajax-pager-link" data-wrapper-class="product-list" href="%s"></a>
                  </div>',
		$url);
}
if (isset($_GET['AJAX_PAGE'])) {
	die();
}
?>
<?php if ($pageCount > 1): ?>
    <div class="row load-more">
        <div class="col-lg-12"><a href="#" class="product-load-more-btn font-fix"><?= GetMessage("loadmore"); ?></a>
        </div>
    </div>
<?php endif; ?>
<!--RestartBuffer-->