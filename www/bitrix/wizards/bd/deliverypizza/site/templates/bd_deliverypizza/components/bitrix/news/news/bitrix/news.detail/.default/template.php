<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);

?>
<div class="news-detail" itemscope itemtype="http://schema.org/Article">
			<div class="hidden-xs-up" itemprop="headline name"><?php echo $arResult['NAME']; ?></div>
			<?if($arParams["DISPLAY_DATE"]!="N" && $arResult["DISPLAY_ACTIVE_FROM"]):?>
                <span class="news-date-time" itemprop="datePublished"
                      content="<?php echo date('Y-m-d', strtotime($product["PROPERTIES"]['DATE']["VALUE"])); ?>"><?= $arResult["DISPLAY_ACTIVE_FROM"] ?></span>
			<?endif;?>
    <div class="detail-content row clearfix" itemprop="articleBody">
        <div class="col-xs-8">
            <p><?= $arResult["DETAIL_TEXT"]; ?></p>
        </div>
        <div class="col-xs-4">
            <div class="news-sharing-block common-block">
                <div class="news-sharing-block_title"><?= GetMessage('sharing_title') ?></div>
                <div class="social-icons-footer">
                    <a class="sprite sprite-social_vk" data-id="vk" href="#"></a>
                    <a class="sprite sprite-social_fb" data-id="fb" href="#"></a>
                    <a class="sprite sprite-social_tw" data-id="tw" href="#"></a>
                    <a class="sprite sprite-social_ok" data-id="ok" href="#"></a>
                </div>
                <a href="<?php echo $arResult['LIST_PAGE_URL']; ?>"
                   class="news-sharing-block_go-back"><span><?= GetMessage("go_back"); ?></span></a>
            </div>
        </div>
			</div>
			<?php if(!empty($arResult['DETAIL_PICTURE'])): ?>
				<div class="news-detail-image">
					<img src="<?php echo $arResult['DETAIL_PICTURE']['SRC']; ?>" alt="<?php echo $arResult['NAME']; ?>" title="<?php echo $arResult['NAME']; ?>">
				</div>
			<?php endif; ?>
    <div class="news-additional-block">
		<?php if ($arResult['PROPERTIES']['ADDITIONAL_PHOTOS']['VALUE']): ?>
            <div class="row additional-photos">
				<?php foreach ($arResult['PROPERTIES']['ADDITIONAL_PHOTOS']['VALUE'] as $photo_): ?>
                    <div class="additional-photo-item">
						<?php
						if (count($arResult['PROPERTIES']['ADDITIONAL_PHOTOS']['VALUE']) < 3) {
							$photo = CFile::ResizeImageGet($photo_, array('width' => '444', 'height' => '405'), BX_RESIZE_IMAGE_EXACT, true);
						} else {
							$photo = CFile::ResizeImageGet($photo_, array('width' => '255', 'height' => '233'), BX_RESIZE_IMAGE_EXACT, true);
						}
						$full = CFile::GetFileArray($photo_);
						?>
                        <a class="fancybox preview_" rel="gallery1"
                           href="<?= CUtil::GetAdditionalFileURL($full['SRC']); ?>">
                            <div class="overlay">
                                <div class="zoom-btn"></div>
                            </div>
                            <img src="<?= CUtil::GetAdditionalFileURL($photo['src']); ?>" alt="">
                        </a>
                    </div>
				<?php endforeach; ?>
            </div>
		<?php endif; ?>
		<?php if ($arResult['PROPERTIES']['RELATED_PRODUCT']['VALUE']): ?>
            <div class="row">
				<?php foreach ($arResult['PROPERTIES']['RELATED_PRODUCT']['VALUE'] as $pid): ?>
					<?php
					$res = CIBlockElement::GetList(array(), array('ID' => $pid), false, false, array('*'));
					if ($ar_res = $res->GetNextElement()) {
						$product = $ar_res->GetFields();
						$product['PROPERTIES'] = $ar_res->GetProperties();
					}
					$product["OLD_PRICE"] = $product["PROPERTIES"]["OLD_PRICE"]["VALUE"];
					$product["PRICE"] = $product["PROPERTIES"]["PRICE"]["VALUE"];
					$product["G"] = $product["PROPERTIES"]["G"]["VALUE"];
					$product["G_UNITS"] = $product["PROPERTIES"]["UNITS"]["VALUE"];

					$basket_m = new \Bd\Deliverypizza\Models\Basket();
					$basket = $basket_m->getBasket(0, session_id(), false);
					$basket_res = unserialize($basket['BASKET_CONTENT']);
					$product['IN_BASKET'] = 0;
					if (!empty($basket_res)) {
						foreach ($basket_res as $bi) {
							if ($bi['PRODUCT_ID'] == $product['ID'])
								$product['IN_BASKET'] = 1;
						}
					}
					if (!empty($product['PROPERTIES']['BADGES'])) {
						$arNames = Array();
						$ShopOption = CIBlockElement::GetList(Array("SORT" => "ASC"), Array("ID" => $product['PROPERTIES']['BADGES']["VALUE"]), false, false, Array("ID", "NAME", "PROPERTY_COLOR", "PROPERTY_ICON"));

						while ($arShopOption = $ShopOption->GetNext()) {
							$product["BADGES"][] = array(
								"ID" => $arShopOption['ID'],
								"NAME" => $arShopOption['NAME'],
								"COLOR" => $arShopOption['PROPERTY_COLOR_VALUE'],
								"ICON" => CFile::GetPath($arShopOption['PROPERTY_ICON_VALUE'])
							);
						}
					}

					$props = array();
					if (!empty($product['PROPERTIES']['BD_PROPS_1']['VALUE'])) {
						foreach ($product['PROPERTIES']['BD_PROPS_1']['VALUE'] as $prop_item) {
							if (!empty($prop_item['VALUE']))
								$props[$prop_item['PROP']][] = array('VALUE' => $prop_item['VALUE'], 'PRICE' => $prop_item['PRICE'], 'OLD_PRICE' => $prop_item['OLD_PRICE'], 'WEIGHT' => $prop_item['WEIGHT']);
						}
					}
					if (!empty($product['PROPERTIES']['BD_PROPS_2']['VALUE'])) {
						foreach ($product['PROPERTIES']['BD_PROPS_2']['VALUE'] as $prop_item) {
							if (!empty($prop_item['VALUE']))
								$props[$prop_item['PROP']][] = array('VALUE' => $prop_item['VALUE'], 'PRICE' => $prop_item['PRICE'], 'OLD_PRICE' => $prop_item['OLD_PRICE'], 'WEIGHT' => $prop_item['WEIGHT']);
						}
					}
					$prop_choose_label = $product['PROPERTIES']['OPTIONS_CHOOSE']['VALUE'];
					if (empty($prop_choose_label))
						$prop_choose_label = GetMessage("choose_option");

					$product['PROPS'] = $props;
					$product['LIKE_COUNTER'] = \Bd\Deliverypizza\Entity\LikeTable::getCount(array('PRODUCT_ID' => $product['ID']));

					?>

                    <div class="col-lg-3 col-xl-3 col-sm-6">
                        <div data-id="<?= $product['ID']; ?>" itemscope itemtype="http://schema.org/Product"
                             class="product product-item"
                             id="<?= $this->GetEditAreaId($product['ID']); ?>"
                             data-unit="<?php echo $product['PROPERTIES']['UNITS']['VALUE']; ?>">

                            <div style="display: none;" class="product-options">
                                <div class="options_main_title"><?= GetMessage('choose_option') ?></div>
                                <div class="product-option-list_ scrollbar-macosx">
                                    <form>
										<?php $i = 1;
										foreach ($product['PROPS'] as $key => $props): ?>
                                            <div class="row">

                                                <div class="options-row-select col-xs-12 options-length-<?php echo count($product['PROPS']); ?>">
                                                    <div class="option_title"><?php echo $key; ?></div>
													<?php foreach ($props as $j => $val): ?>
                                                        <div>
                                                            <label>
                                                                <input <?= ($j == 0) ? 'checked="checked"' : '' ?>
                                                                        type="radio" name="OPTION_<?= $i ?>"
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
								<? if ($product["PROPERTIES"]['BADGES']["VALUE"]): ?>
                                    <div class="product-labels">
										<? foreach ($product["BADGES"] as $key => $Badges) : ?>
                                            <div title="<?= $Badges['NAME'] ?>" class="product-label"><img
                                                        src="<?= $Badges['ICON'] ?>">
                                            </div>
										<? endforeach ?>
                                    </div>
								<? endif; ?>

								<? if ($product['PREVIEW_PICTURE']): ?>
									<?
									$preLoadPhoto = CFile::ResizeImageGet($product['PREVIEW_PICTURE'], array('width' => '25', 'height' => '19'), BX_RESIZE_IMAGE_EXACT, true);


									$MiniPhoto = CFile::ResizeImageGet($product['PREVIEW_PICTURE'], array('width' => '254', 'height' => '197'), BX_RESIZE_IMAGE_EXACT, true);
									$MiniPhoto2 = CFile::ResizeImageGet($product['PREVIEW_PICTURE'], array('width' => '353', 'height' => '275'), BX_RESIZE_IMAGE_EXACT, true);
									$MiniPhoto3 = CFile::ResizeImageGet($product['PREVIEW_PICTURE'], array('width' => '553', 'height' => '475'), BX_RESIZE_IMAGE_EXACT, true);
									$MiniPhoto4 = CFile::ResizeImageGet($product['PREVIEW_PICTURE'], array('width' => '342', 'height' => '265'), BX_RESIZE_IMAGE_EXACT, true);

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
                                                alt="<?= $product["PREVIEW_PICTURE"]["ALT"] ?>"
                                                title="<?= $product["PREVIEW_PICTURE"]["TITLE"] ?>"
                                                class="product-image progressiveLoad"
                                        />

                                    </picture>
                                    <a style="display: none;" itemprop="image"
                                       href="<?= CUtil::GetAdditionalFileURL($MiniPhoto['src']); ?>"
                                       onclick="return false;"></a>
								<? else: ?>
                                    <img src="<?= SITE_TEMPLATE_PATH ?>/images/no_photo.jpg" itemprop="image"
                                         class="product-image">
								<? endif; ?>

                                <div class="overlay">
                                    <div class="zoom-btn"></div>
                                </div>
								<?php if ($product['PROPERTIES']['NO_SALE']['VALUE'] == 'Y'): ?>
                                <div title="<?= GetMessage("item_no_sale_title"); ?>"
                                     class="without-sale"></div><?php endif; ?>
								<? Bd\Deliverypizza\UncachedArea::startCapture(); ?>
                                <div class="likes">
                                    <div class="like-content">
                                        <div class="like-icon"></div>
                                        <span>#LIKES#</span>
                                    </div>
                                </div>
								<? $like_native = Bd\Deliverypizza\UncachedArea::endCapture(); ?>
								<? Bd\Deliverypizza\UncachedArea::show('likesCount', array('arItem' => $product, 'like_native' => $like_native)); ?>
                            </div>
                            <div class="product-info base-view">
                                <a href="<?= $product["DETAIL_PAGE_URL"] ?>" onclick="return false;"
                                   class="product-title font-fix base-view"><span
                                            itemprop="name"><?= $product["NAME"] ?></span></a>
                                <div itemprop="description" class="product-description base-view">
									<?= $product["PREVIEW_TEXT"] ?>
                                </div>

                            </div>
							<?php if (!empty($product["PRICE"]) && $product["PRICE"] != 0): ?>
                                <div class="product-footer<? if ($product["OLD_PRICE"]): ?><? else: ?> base-price<? endif; ?>">
                                    <div itemprop="offers" itemscope itemtype="http://schema.org/Offer"
                                         class="product-prices font-fix">

                          <span class="old-price" <? if (!$product["OLD_PRICE"]): ?>style="display: none;" <? endif; ?>>
                            <span class="line-through"><?= number_format($product["OLD_PRICE"], 0, '.', ' '); ?></span><span
                                      class="currency"><?= CURRENCY_FONT; ?></span>
                          </span>
                                        <span class="current-price"><span
                                                    itemprop="price"><?= number_format($product["PRICE"], 0, '.', ' '); ?></span><span
                                                    class="currency"><?= CURRENCY_FONT; ?></span>
                          <span itemprop="priceCurrency" class="text-hide"><?= CURRENCY_CODE ?></span>
                          </span>

                                        <span class="weight" <? if (!$product["G"]): ?> style="display: none;"<? endif; ?>><span><?= $product["G"] ?></span><span> <?= $product["G_UNITS"] ?></span></span>

                                    </div>
                                    <div class="product-actions clearfix <?php if (intval($product['PROPERTIES']['BUY_IT']['VALUE']) !== 0 && $product['PROPERTIES']['BUY_IT']['VALUE'] - $product['PROPERTIES']['BUY_IT_COMPLETE']['VALUE'] > 0): ?>with-progress<?php endif; ?> <?php if (intval($product['PROPERTIES']['BUY_IT']['VALUE']) !== 0 && ($product['PROPERTIES']['BUY_IT']['VALUE'] - $product['PROPERTIES']['BUY_IT_COMPLETE']['VALUE'] == 0 || $product['PROPERTIES']['BUY_IT']['VALUE'] - $product['PROPERTIES']['BUY_IT_COMPLETE']['VALUE'] < 0)): ?>progress-complete<?php endif; ?>">
										<?php
										$delta = Bd\Deliverypizza\Models\Product::GetProductDelta($product['ID']);
										if ($delta < 0) $delta = 0; ?>
										<?php if (!empty($product['PROPERTIES']['BUY_IT']['VALUE'])): ?>
											<? Bd\Deliverypizza\UncachedArea::startCapture(); ?>
                                            <div class="progress-container">
                                                <div style="width: #PERCENT#%;" class="progress-bar"></div>
                                                <div class="progress-bar-content font-fix">
                                                    <div>#PLURAL#</div>
                                                </div>
                                            </div>
											<? $delta_ = Bd\Deliverypizza\UncachedArea::endCapture(); ?>
											<? Bd\Deliverypizza\UncachedArea::show('productDelta', array('id' => $product['ID'], 'dc' => $delta_)); ?>
										<?php endif; ?>
										<? Bd\Deliverypizza\UncachedArea::startCapture(); ?>
                                        <a href="#" class="product-back pull-xs-left"></a>
                                        <a <?php if ($delta > 0): ?>data-max="<?= intval($delta); ?>"<?php endif; ?>
                                           data-id="<?php echo $product['ID']; ?>" href="#"
                                           class="add-to-cart-btn native choose_options pull-xs-right"><?php echo $prop_choose_label ?></a>
										<? $choose = Bd\Deliverypizza\UncachedArea::endCapture(); ?>
										<? Bd\Deliverypizza\UncachedArea::startCapture(); ?>
                                        <a <?php if ($delta > 0): ?>data-max="<?= intval($delta); ?>"<?php endif; ?>
                                           data-id="<?php echo $product['ID']; ?>" href="#"
                                           class="add-to-cart-btn native"><?php echo GetMessage("add_to_basket"); ?></a>
										<? $buy = Bd\Deliverypizza\UncachedArea::endCapture(); ?>

										<? Bd\Deliverypizza\UncachedArea::startCapture(); ?>
                                        <a <?php if ($delta > 0): ?>data-max="<?= intval($delta); ?>"<?php endif; ?>
                                           data-id="<?php echo $product['ID']; ?>" href="#"
                                           class="add-to-cart-btn native retry"><?= GetMessage("one_more_add_button"); ?></a>
										<? $inBasket = Bd\Deliverypizza\UncachedArea::endCapture(); ?>
										<? Bd\Deliverypizza\UncachedArea::show('productBuyBlock', array('id' => $product['ID'], 'buy' => $buy, 'inBasket' => $inBasket, 'choose' => $choose, 'props' => $product['PROPS'])); ?>
                                    </div>
                                </div>
							<?php endif; ?>
                        </div>
                    </div>
				<?php endforeach; ?>
            </div>
		<?php endif; ?>
    </div>

</div>