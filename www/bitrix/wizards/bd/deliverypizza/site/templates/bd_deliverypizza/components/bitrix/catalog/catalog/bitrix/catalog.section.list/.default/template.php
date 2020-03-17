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
$this->setFrameMode(true);

$arViewModeList = $arResult['VIEW_MODE_LIST'];

$arViewStyles = array(
	'LIST' => array(
		'CONT' => 'bx_sitemap',
		'TITLE' => 'bx_sitemap_title',
		'LIST' => 'bx_sitemap_ul',
	),
	'LINE' => array(
		'CONT' => 'bx_catalog_line',
		'TITLE' => 'bx_catalog_line_category_title',
		'LIST' => 'bx_catalog_line_ul',
		'EMPTY_IMG' => $this->GetFolder() . '/images/line-empty.png'
	),
	'TEXT' => array(
		'CONT' => 'bx_catalog_text',
		'TITLE' => 'bx_catalog_text_category_title',
		'LIST' => 'bx_catalog_text_ul'
	),
	'TILE' => array(
		'CONT' => 'bx_catalog_tile',
		'TITLE' => 'bx_catalog_tile_category_title',
		'LIST' => 'bx_catalog_tile_ul',
		'EMPTY_IMG' => $this->GetFolder() . '/images/tile-empty.png'
	)
);
$arCurView = $arViewStyles[$arParams['VIEW_MODE']];

$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));

?>

<?php
if (0 < $arResult["SECTIONS_COUNT"])
{
?>
<div class="row category-masonry">
	<?php if (COption::GetOptionString('bd.deliverypizza', 'BD_SUB_MODULE_CONSTRUCTOR', '', SITE_ID) == 'Y'): ?>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-12 category-view-item">
            <div class="common-block category-view-item-inner">
                <div class="col-xs-12 category-view-image">
                    <img src="<?= CUtil::GetAdditionalFileURL(SITE_TEMPLATE_PATH . '/images/new-constructor-big.png'); ?>"
                         alt="<?= GetMessage("WOK_BOX"); ?>" title="<?= GetMessage("WOK_BOX"); ?>"
                    />
                </div>
                <div class="col-xs-12 category-view-name">
                    <div class="name-cont">
                        <a href="<? SITE_DIR ?>/catalog/wok/"><?= GetMessage("WOK_BOX"); ?></a>
                    </div>
                </div>
                <div class="col-xs-12 category-view-description"><?= GetMessage("WOK_BOX_DESC"); ?></div>
                <div class="clearfix"></div>
            </div>
        </div>
	<?php endif; ?>
	<?php foreach ($arResult['SECTIONS'] as &$arSection): if ($arSection['DEPTH_LEVEL'] > 1) continue; ?>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-12 category-view-item">
            <div class="common-block category-view-item-inner">
				<?php

				$sub_categories = array();
				$rsParentSection = CIBlockSection::GetByID($arSection['ID']);
				if ($arParentSection = $rsParentSection->GetNext()) {
					$arFilter = array('IBLOCK_ID' => $arParentSection['IBLOCK_ID'], '>LEFT_MARGIN' => $arParentSection['LEFT_MARGIN'], '<RIGHT_MARGIN' => $arParentSection['RIGHT_MARGIN'], '>DEPTH_LEVEL' => $arParentSection['DEPTH_LEVEL']);
					$rsSect = CIBlockSection::GetList(array('left_margin' => 'asc'), $arFilter);
					while ($arSect = $rsSect->GetNext()) {
						$sub_categories[] = $arSect;
					}
				}
				if (!empty($arSection['PICTURE'])) {
					$preload_img = CFile::ResizeImageGet($arSection['PICTURE'], array('width' => '29', 'height' => '16'), BX_RESIZE_IMAGE_EXACT, true);
					$img = CFile::ResizeImageGet($arSection['PICTURE'], array('width' => '290', 'height' => '160'), BX_RESIZE_IMAGE_EXACT, true);

				}
				?>
                <div class="col-xs-12 category-view-image">
                    <picture>
                        <img
                                data-full = "<?= CUtil::GetAdditionalFileURL($img['src']); ?>"
                                srcset="<?= CUtil::GetAdditionalFileURL($preload_img['src']); ?>"
                                alt="<?= $arSection['PICTURE']["ALT"] ?>"
                                title="<?= $arSection['PICTURE']["TITLE"] ?>"
                                class="progressiveLoad"
                                style="width: <?=$img['width']?>px; height: <?=$img['height']?>px;"
                        />
                    </picture>
                </div>
                <div class="col-xs-12 category-view-name <?php if (empty($sub_categories) && empty($arSection['DESCRIPTION'])) { ?>without-border<?php } ?>">
                    <div class="name-cont">
                        <a href="<?php echo $arSection['SECTION_PAGE_URL']; ?>"><?php echo $arSection['NAME']; ?></a>
                    </div>
                </div>
				<?php if (!empty($sub_categories)): ?>
                    <div class="col-xs-12 sub-categories-cont">
                        <ul class="sub-categories">
							<?php foreach ($sub_categories as $sc): ?>
                                <li>
                                    <a href="<?php echo $arSection['SECTION_PAGE_URL']  . $sc['CODE'] . '/'; ?>"><?php echo $sc['NAME']; ?></a>
                                </li>
							<?php endforeach; ?>
                        </ul>
                    </div>
				<?php endif; ?>
				<?php if (!empty($arSection['DESCRIPTION'])): ?>
                    <div class="col-xs-12 category-view-description"><?php echo $arSection['DESCRIPTION']; ?></div>
				<?php endif; ?>
                <div class="clearfix"></div>
            </div>
        </div>
	<?php endforeach; ?>
	<?php } ?>
