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

use Bd\Deliverypizza;

$this->setFrameMode(true);
$sections = array();
$stickers = array();
$slides = array();
$arFilter = Array('IBLOCK_ID' => (int)\Bd\Deliverypizza\BdCache::$iblocks[SITE_ID]["bd_content_pizza"]["bd_catalog"][0], 'DEPTH_LEVEL' => 1, 'ACTIVE' => 'Y');
$sections_count = (COption::GetOptionString('bd.deliverypizza','BD_SUB_MODULE_CONSTRUCTOR','',SITE_ID) == 'Y')?8:9;

$rsSections = CIBlockSection::GetList(array('SORT' => 'ASC'), $arFilter, array(), array(), array('nPageSize' => $sections_count));
while ($arSection = $rsSections->Fetch()) {
	$arSection['IMG_SMALL'] = CFile::ResizeImageGet($arSection['PICTURE'], array("width" => 255, "height" => 140), BX_RESIZE_IMAGE_EXACT, true);
	$arSection['IMG_SMALL_B'] = CFile::ResizeImageGet($arSection['PICTURE'], array("width" => 25, "height" => 14), BX_RESIZE_IMAGE_EXACT, true);

	$arSection['IMG_BIG'] = CFile::ResizeImageGet($arSection['PICTURE'], array("width" => 540, "height" => 300), BX_RESIZE_IMAGE_EXACT, true);
	$arSection['IMG_BIG_B'] = CFile::ResizeImageGet($arSection['PICTURE'], array("width" => 54, "height" => 30), BX_RESIZE_IMAGE_EXACT, true);

	$sections[] = $arSection;
}
if(COption::GetOptionString('bd.deliverypizza','BD_SUB_MODULE_CONSTRUCTOR','',SITE_ID) == 'Y'){
    $sections[] = array(
        'NAME' => GetMessage('wok_title'),
        'CODE' => 'constructor',
        'IMG_SMALL' => array('src' => SITE_TEMPLATE_PATH . '/images/new-constructor.png'),
        'IMG_SMALL_B' => array('src' => SITE_TEMPLATE_PATH . '/images/new-constructor.png')
    );
}

$arFilter = Array('IBLOCK_ID' => (int)\Bd\Deliverypizza\BdCache::$iblocks[SITE_ID]["bd_content_pizza"]["bd_stickers"][0], 'ACTIVE' => 'Y');
$arSelect = array('ID', 'NAME', 'CODE', 'PROPERTY_ICON');
$res = CIBlockElement::GetList(Array('SORT' => 'ASC'), $arFilter, false, Array("nPageSize" => 50), $arSelect);
while ($ob = $res->GetNextElement()) {
	$arFields = $ob->GetFields();
	$arFields['IMG'] = CFile::GetFileArray($arFields['PROPERTY_ICON_VALUE']);
	$stickers[] = $arFields;
}

$arFilter = Array('IBLOCK_ID' => (int)\Bd\Deliverypizza\BdCache::$iblocks[SITE_ID]["bd_content_pizza"]["bd_catalog"][0], 'ACTIVE' => 'Y', '!PROPERTY_BANNER_URL' => false);
$arSelect = array('ID', 'PROPERTY_BANNER', 'PROPERTY_BANNER_URL');
$res = CIBlockElement::GetList(Array('SORT'=>"ASC"), $arFilter, false, Array("nPageSize" => 50), $arSelect);
while ($ob = $res->GetNextElement()) {
	$arFields = $ob->GetFields();
	$arFields['IMG'] = CFile::ResizeImageGet($arFields['PROPERTY_BANNER_VALUE'], array("width" => 255, "height" => 435), BX_RESIZE_IMAGE_EXACT, true);
	$arFields['IMG_PRELOAD'] = CFile::ResizeImageGet($arFields['PROPERTY_BANNER_VALUE'], array("width" => 25, "height" => 43), BX_RESIZE_IMAGE_EXACT, true);
	$slides[] = $arFields;
}

?>
<?php if (\COption::GetOptionString('bd.deliverypizza', 'BD_DELIVERY_MAIN_PAGE_SECTIONS', '', SITE_ID) == 'Y'): ?>
    <div class="row index-navigation">
        <div class="col-xl-3 col-lg-3 push-xl-9 push-lg-9">
            <div class="common-block product-badges">
                <ul>
					<?php foreach ($stickers as $sticker): ?>

                        <?php
                        $sticker_prods = array();
                        $arSelect = Array("ID");
						$arFilter = Array("IBLOCK_ID"=>(int)\Bd\Deliverypizza\BdCache::$iblocks[SITE_ID]["bd_content_pizza"]["bd_catalog"][0], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y",'PROPERTY_BADGES.ID'=>$sticker['ID']);
						$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect);
						while($ob = $res->GetNextElement())
						{
						    $sticker_prods[] = $ob->GetFields();
						}
						if(count($sticker_prods) == 0) continue;

						?>
                        <li>
                            <a style="background-image: url(<?= $sticker['IMG']['SRC'] ?>)"
                               href="/catalog/its-<?= $sticker['CODE'] ?>/"><span><?= $sticker['NAME'] ?></span></a>
                        </li>
					<?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="col-xl-9 col-lg-9 pull-xl-3 pull-lg-3">
            <div class="index-sections-list row">
				<?php foreach ($sections as $key => $section_item): ?>
                    <div class="<?= ($key == 0) ? 'col-xl-8 col-sm-12' : 'col-sm-6 col-xl-4' ?>">
                        <a href="/catalog/<?= $section_item['CODE'] ?>/"
                           data-bg="<?= ($key == 0) ? $section_item['IMG_BIG']['src'] : $section_item['IMG_SMALL']['src'] ?>"
                           class="common-block index-sections-list__item <?= ($key == 0) ? 'index-sections-list__item--big col-xs-9' : 'index-sections-list__item--small col-xs-3' ?>">
                            <span><?= $section_item['NAME'] ?></span>
                            <div style="background-image: url('<?= ($key == 0) ? $section_item['IMG_BIG_B']['src'] : $section_item['IMG_SMALL_B']['src'] ?>')"
                                 class="section-bg blured"></div>
                        </a>
                    </div>
				<?php endforeach; ?>
                <div class="col-xs-12">
                    <a class="all-categories-button" href="/catalog/"><?= GetMessage('all_categories') ?></a>
                </div>
            </div>

        </div>
    </div>
<?php endif; ?>

<div class="row products-sub-menu-main">
    <div class="col-lg-12">
        <nav>
            <ul>
				<?php
				$arSelect = Array("ID", "NAME", "PROPERTY_RECOMEND");
				$arFilter = Array("IBLOCK_ID" => (int)\Bd\Deliverypizza\BdCache::$iblocks[SITE_ID]["bd_content_pizza"]["bd_catalog"][0], "ACTIVE_DATE" => "Y", "ACTIVE" => "Y", 'PROPERTY_RECOMEND_VALUE' => 'Y');
				$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize" => 50), $arSelect);
				$recCount = 0;
				while ($ob = $res->GetNext()) {
					$rec_ids[] = $ob['ID'];
				}

				?>
				<?php if (!empty($rec_ids)): ?>
                    <li class="active"><a href="#" data-section="recommend"><?= GetMessage("recommend"); ?></a></li>
				<?php endif; ?>
                <li <?php if (empty($rec_ids)): ?>class="active"<?php endif; ?>><a href="#"
                                                                                   data-section="popular"><?= GetMessage("popular"); ?></a>
                </li>
				<?
				global $arrFilter, $USER;
				$liked = Deliverypizza\Entity\LikeTable::getList(array('filter' => array('=USER_ID' => $USER->GetID(), 'SITE_ID' => SITE_ID)))->fetchAll();
				$ids = array();

				foreach ($liked as $item) {
					if ($item['PRODUCT_ID'] != 0)
						$ids[] = $item['PRODUCT_ID'];
				}
				if ($USER->IsAuthorized() && !empty($ids)) {
					?>
                    <li><a href="#" data-section="whatIsLove"><?= GetMessage("whatIsLove"); ?></a></li>
				<? } else {
				} ?>
            </ul>
        </nav>
    </div>
</div>
<div class="row">
    <div class="<?php if(\COption::GetOptionString('bd.deliverypizza','BD_DELIVERY_MAIN_PAGE_STATIC_BLOCKS','',SITE_ID) == 'Y'): ?>col-xl-9 col-lg-12<?php else: ?>col-xs-12<?php endif; ?>">
		<?php if (!empty($rec_ids)): ?>
            <div data-section="recommend" class="row product-list index-products first">
				<?
				$arrFilter['ID'] = $rec_ids;
				$arrFilter['PROPERTY_BANNER'] = '';

				$APPLICATION->IncludeComponent(
					"bitrix:catalog.top",
					"",
					array(
						"FILTER_NAME" => "arrFilter",
						"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
						"IBLOCK_ID" => $arParams["IBLOCK_ID"],
						"ELEMENT_SORT_FIELD" => "PROPERTY_RECOMEND",
						"ELEMENT_SORT_ORDER" => "DESC",
						"ELEMENT_SORT_FIELD2" => "SORT",
						"ELEMENT_SORT_ORDER2" => "ASC",
						"SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
						"DETAIL_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["element"],
						"BASKET_URL" => $arParams["BASKET_URL"],
						"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
						"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
						"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
						"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
						"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
						"DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
						"ELEMENT_COUNT" => $arParams["TOP_ELEMENT_COUNT"],
						"LINE_ELEMENT_COUNT" => $arParams["TOP_LINE_ELEMENT_COUNT"],
						"PROPERTY_CODE" => $arParams["TOP_PROPERTY_CODE"],
						"PRICE_CODE" => $arParams["PRICE_CODE"],
						"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
						"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
						"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
						"PRICE_VAT_SHOW_VALUE" => $arParams["PRICE_VAT_SHOW_VALUE"],
						"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
						"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
						"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
						"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
						"CACHE_TYPE" => $arParams["CACHE_TYPE"],
						"CACHE_TIME" => $arParams["CACHE_TIME"],
						"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
						"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
						"OFFERS_FIELD_CODE" => $arParams["TOP_OFFERS_FIELD_CODE"],
						"OFFERS_PROPERTY_CODE" => $arParams["TOP_OFFERS_PROPERTY_CODE"],
						"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
						"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
						"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
						"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
						"OFFERS_LIMIT" => $arParams["TOP_OFFERS_LIMIT"],
						'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
						'CURRENCY_ID' => $arParams['CURRENCY_ID'],
						'HIDE_NOT_AVAILABLE' => $arParams['HIDE_NOT_AVAILABLE'],
						'VIEW_MODE' => (isset($arParams['TOP_VIEW_MODE']) ? $arParams['TOP_VIEW_MODE'] : ''),
						'ROTATE_TIMER' => (isset($arParams['TOP_ROTATE_TIMER']) ? $arParams['TOP_ROTATE_TIMER'] : ''),
						'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
						'LABEL_PROP' => $arParams['LABEL_PROP'],
						'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
						'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],

						'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
						'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
						'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
						'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
						'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
						'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
						'MESS_BTN_ADD_TO_BASKET' => $arParams['MESS_BTN_ADD_TO_BASKET'],
						'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
						'MESS_BTN_DETAIL' => $arParams['MESS_BTN_DETAIL'],
						'MESS_NOT_AVAILABLE' => $arParams['MESS_NOT_AVAILABLE'],
						'ADD_TO_BASKET_ACTION' => $basketAction,
						'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
						'COMPARE_PATH' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['compare']
					),
					$component
				); ?>
            </div>
		<?php endif; ?>
        <div data-section="popular"
             class="row product-list index-products <?php if (empty($rec_ids)): ?>first<?php endif; ?>">
			<?
			unset($arrFilter['ID']);
			$arrFilter['PROPERTY_BANNER_URL'] = false;
			$APPLICATION->IncludeComponent(
				"bitrix:catalog.top",
				"",
				array(
					"FILTER_NAME" => "arrFilter",
					"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
					"IBLOCK_ID" => $arParams["IBLOCK_ID"],
					"ELEMENT_SORT_FIELD" => "PROPERTY_LIKE_COUNTER",
					"ELEMENT_SORT_ORDER" => "DESC",
					"ELEMENT_SORT_FIELD2" => "PROPERTY_LIKE_COUNTER",
					"ELEMENT_SORT_ORDER2" => "DESC",
					"SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
					"DETAIL_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["element"],
					"BASKET_URL" => $arParams["BASKET_URL"],
					"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
					"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
					"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
					"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
					"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
					"DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
					"ELEMENT_COUNT" => $arParams["TOP_ELEMENT_COUNT"],
					"LINE_ELEMENT_COUNT" => $arParams["TOP_LINE_ELEMENT_COUNT"],
					"PROPERTY_CODE" => $arParams["TOP_PROPERTY_CODE"],
					"PRICE_CODE" => $arParams["PRICE_CODE"],
					"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
					"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
					"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
					"PRICE_VAT_SHOW_VALUE" => $arParams["PRICE_VAT_SHOW_VALUE"],
					"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
					"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
					"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
					"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
					"CACHE_TYPE" => $arParams["CACHE_TYPE"],
					"CACHE_TIME" => $arParams["CACHE_TIME"],
					"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
					"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
					"OFFERS_FIELD_CODE" => $arParams["TOP_OFFERS_FIELD_CODE"],
					"OFFERS_PROPERTY_CODE" => $arParams["TOP_OFFERS_PROPERTY_CODE"],
					"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
					"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
					"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
					"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
					"OFFERS_LIMIT" => $arParams["TOP_OFFERS_LIMIT"],
					'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
					'CURRENCY_ID' => $arParams['CURRENCY_ID'],
					'HIDE_NOT_AVAILABLE' => $arParams['HIDE_NOT_AVAILABLE'],
					'VIEW_MODE' => (isset($arParams['TOP_VIEW_MODE']) ? $arParams['TOP_VIEW_MODE'] : ''),
					'ROTATE_TIMER' => (isset($arParams['TOP_ROTATE_TIMER']) ? $arParams['TOP_ROTATE_TIMER'] : ''),
					'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
					'LABEL_PROP' => $arParams['LABEL_PROP'],
					'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
					'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],

					'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
					'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
					'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
					'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
					'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
					'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
					'MESS_BTN_ADD_TO_BASKET' => $arParams['MESS_BTN_ADD_TO_BASKET'],
					'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
					'MESS_BTN_DETAIL' => $arParams['MESS_BTN_DETAIL'],
					'MESS_NOT_AVAILABLE' => $arParams['MESS_NOT_AVAILABLE'],
					'ADD_TO_BASKET_ACTION' => $basketAction,
					'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
					'COMPARE_PATH' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['compare']
				),
				$component
			); ?>
        </div>

		<? global $USER;
		if ($USER->IsAuthorized()) { ?>
            <div data-section="whatIsLove" class="row product-list index-products">
				<?

				$arrFilter['ID'] = $ids;
				$APPLICATION->IncludeComponent(
					"bitrix:catalog.top",
					"",
					array(
						"FILTER_NAME" => "arrFilter",
						"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
						"IBLOCK_ID" => $arParams["IBLOCK_ID"],
						"ELEMENT_SORT_FIELD" => $arParams["TOP_ELEMENT_SORT_FIELD"],
						"ELEMENT_SORT_ORDER" => $arParams["TOP_ELEMENT_SORT_ORDER"],
						"ELEMENT_SORT_FIELD2" => $arParams["TOP_ELEMENT_SORT_FIELD2"],
						"ELEMENT_SORT_ORDER2" => $arParams["TOP_ELEMENT_SORT_ORDER2"],
						"SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
						"DETAIL_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["element"],
						"BASKET_URL" => $arParams["BASKET_URL"],
						"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
						"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
						"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
						"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
						"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
						"DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
						"ELEMENT_COUNT" => $arParams["TOP_ELEMENT_COUNT"],
						"LINE_ELEMENT_COUNT" => $arParams["TOP_LINE_ELEMENT_COUNT"],
						"PROPERTY_CODE" => $arParams["TOP_PROPERTY_CODE"],
						"PRICE_CODE" => $arParams["PRICE_CODE"],
						"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
						"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
						"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
						"PRICE_VAT_SHOW_VALUE" => $arParams["PRICE_VAT_SHOW_VALUE"],
						"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
						"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
						"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
						"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
						"CACHE_TYPE" => $arParams["CACHE_TYPE"],
						"CACHE_TIME" => $arParams["CACHE_TIME"],
						"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
						"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
						"OFFERS_FIELD_CODE" => $arParams["TOP_OFFERS_FIELD_CODE"],
						"OFFERS_PROPERTY_CODE" => $arParams["TOP_OFFERS_PROPERTY_CODE"],
						"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
						"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
						"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
						"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
						"OFFERS_LIMIT" => $arParams["TOP_OFFERS_LIMIT"],
						'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
						'CURRENCY_ID' => $arParams['CURRENCY_ID'],
						'HIDE_NOT_AVAILABLE' => $arParams['HIDE_NOT_AVAILABLE'],
						'VIEW_MODE' => (isset($arParams['TOP_VIEW_MODE']) ? $arParams['TOP_VIEW_MODE'] : ''),
						'ROTATE_TIMER' => (isset($arParams['TOP_ROTATE_TIMER']) ? $arParams['TOP_ROTATE_TIMER'] : ''),
						'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
						'LABEL_PROP' => $arParams['LABEL_PROP'],
						'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
						'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],

						'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
						'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
						'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
						'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
						'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
						'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
						'MESS_BTN_ADD_TO_BASKET' => $arParams['MESS_BTN_ADD_TO_BASKET'],
						'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
						'MESS_BTN_DETAIL' => $arParams['MESS_BTN_DETAIL'],
						'MESS_NOT_AVAILABLE' => $arParams['MESS_NOT_AVAILABLE'],
						'ADD_TO_BASKET_ACTION' => $basketAction,
						'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
						'COMPARE_PATH' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['compare']
					),
					$component
				); ?>
            </div>
		<? } else {
		} ?>
    </div>
	<?php if(\COption::GetOptionString('bd.deliverypizza','BD_DELIVERY_MAIN_PAGE_STATIC_BLOCKS','',SITE_ID) == 'Y'): ?>
    <div class="col-xl-3  hidden-lg-down">
		<?php if (count($slides)): ?>
            <div class="common-block product product-banner-slider">
				<?php foreach ($slides as $slide): ?>
                    <div class="carousel-cell">
                        <a href="<?= $slide['PROPERTY_BANNER_URL_VALUE'] ?>">
                            <img style="width: <?= $slide['IMG']['width'] ?>px;" class="progressiveLoad" srcset="<?= $slide['IMG_PRELOAD']['src'] ?>" data-full="<?= $slide['IMG']['src'] ?>">
                        </a>
                    </div>
				<?php endforeach; ?>
            </div>
		<?php endif; ?>

            <?php if (count($slides) == 0): ?>
               <div class="blocks-without-banners">
            <?php endif; ?>
                <? $APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR . "include/offer_1_index.php", "EDIT_TEMPLATE" => ""), false); ?>
                <? $APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR . "include/offer_2_index.php", "EDIT_TEMPLATE" => ""), false); ?>
                <? $APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR . "include/offer_3_index.php", "EDIT_TEMPLATE" => ""), false); ?>
            <?php if (count($slides) == 0): ?>
              </div>
            <?php endif; ?>
    </div>
	<?php endif; ?>
</div>
<!--- LOADMORE SECTION ---->
