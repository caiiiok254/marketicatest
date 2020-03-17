<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
<div class="row news-list">
    <!--RestartBuffer-->
	<?
	if (isset($_GET['AJAX_PAGE'])) {
		$APPLICATION->RestartBuffer();
	}
	if (!empty($arResult['ITEMS'])): ?>
		<? foreach ($arResult["ITEMS"] as $arItem): ?>
			<?
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
			$arItem['PREVIEW_PICTURE_R'] = CFile::ResizeImageGet(
				$arItem['PREVIEW_PICTURE'],
				array('height' => 500, "width" => 300),
				BX_RESIZE_IMAGE_PROPORTIONAL_ALT,
				true,
				false
			);
			$arItem['PREVIEW_PICTURE_B'] = CFile::ResizeImageGet(
				$arItem['PREVIEW_PICTURE'],
				array('height' => 50, "width" => 30),
				BX_RESIZE_IMAGE_PROPORTIONAL_ALT,
				true,
				false
			);


			?>

            <article itemscope itemtype="http://schema.org/Article"
                     class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-12  <?php if (isset($_GET['AJAX_PAGE'])): ?>animate<?php endif; ?>"
                     id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
                <div class="news-item <? if ($arItem["PREVIEW_PICTURE"]): ?>with-photo<? else: ?>without-photo<? endif; ?>">
                    <div class="news-content row">
					<? if ($arItem["PREVIEW_PICTURE"]): ?>
                        <div class="col-xs-12 news-photo"
                             style="max-height: <?= $arItem["PREVIEW_PICTURE_R"]['height'] + 50 ?>px;">
							<? if ($arItem["DETAIL_TEXT"]): ?><a
                                    href="<?= $arItem["DETAIL_PAGE_URL"] ?>"><? else: ?><? endif; ?>


                                <img
                                        data-full = "<?= CUtil::GetAdditionalFileURL($arItem["PREVIEW_PICTURE_R"]["src"]) ?>"
                                        style="float:left; width: <?=$arItem["PREVIEW_PICTURE_R"]['width']?>px;height: <?=$arItem["PREVIEW_PICTURE_R"]['height']?>px;"
                                        srcset="<?= CUtil::GetAdditionalFileURL($arItem["PREVIEW_PICTURE_B"]["src"]) ?>"
                                        alt="<?= $arItem["PREVIEW_PICTURE"]["ALT"] ?>"
                                        title="<?= $arItem["PREVIEW_PICTURE"]["TITLE"] ?>"
                                        class="preview_picture progressiveLoad"
                                        itemprop="image"
                                />
								<? if ($arItem["DETAIL_TEXT"]): ?></a><? else: ?><? endif; ?>
                        </div>
					<? endif; ?>
					<? if ($arItem["PREVIEW_PICTURE"]): ?>
                    <div class="col-xs-12 news-text">
						<? else: ?>
                        <div class="col-xs-12">
							<? endif; ?>
                            <div class="news-title">
								<? if ($arItem["DETAIL_TEXT"]): ?><a
                                        href="<?= $arItem["DETAIL_PAGE_URL"] ?>"><? else: ?><? endif; ?>
                                    <span itemprop="headline name"><? echo $arItem["NAME"] ?></span>
									<? if ($arItem["DETAIL_TEXT"]): ?></a><? else: ?><? endif; ?>
                            </div>
                            <div class="news-date" itemprop="datePublished"
                                 content="<?php echo date('Y-m-d', strtotime($arItem["PROPERTIES"]['DATE']["VALUE"])); ?>"><? echo $arItem["PROPERTIES"]['DATE']["VALUE"] ?></div>
                            <div class="news-text" itemprop="articleBody"><? echo $arItem["PREVIEW_TEXT"]; ?></div>
                        </div>
                    </div>

                    </div>

            </article>
		<? endforeach; ?>
	<?php else: ?>
        <div class="content-page page-404 font-fix empty-items">
            <div class="status-title">
				<?php if ($arParams['IBLOCK_URL'] == '/news/'): ?>
					<?= GetMessage("sorry_empty_news"); ?>
				<?php else: ?>
					<?= GetMessage("sorry_empty_sales"); ?>
				<?php endif; ?>
            </div>
        </div>
	<?php endif; ?>
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
                  <a class="ajax-pager-link" data-wrapper-class="news-list" href="%s"></a>
              </div>',
			$url);
	}
	if (isset($_GET['AJAX_PAGE'])) {
	}
	?>
    <!--RestartBuffer-->
</div>