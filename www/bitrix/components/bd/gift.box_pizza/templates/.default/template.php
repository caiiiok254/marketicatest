<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);

?>
<script type="text/javascript">
  <?php foreach($arResult["GIFT_BOX"] as $key=>$gb): ?>
    window.limit<?php echo $key+1; ?> = <?php echo intval($gb['ORDER_FROM']); ?>;
  <?php endforeach; ?>
</script>
	<div id="gift-modal" class="md-modal md-effect-3">
		<div class="md-content">
			<div class="modal-title"><?= GetMessage('GET_GIFT_TITLE') ?></div>
			<div class="bd-scrollbar scrollbar-macosx">
				<? $APPLICATION->IncludeComponent(
					"bitrix:news.list",
					"gifts",
					array(
						"COMPONENT_TEMPLATE" => "gifts",
						"IBLOCK_ID" => \Bd\Deliverypizza\BdCache::$iblocks[SITE_ID]["bd_gifts_pizza"]["bd_gifts"][0],
						"NEWS_COUNT" => "999",
						"SORT_BY1" => "SORT",
						"SORT_ORDER1" => "DESC",
						"SORT_BY2" => "SORT",
						"SORT_ORDER2" => "ASC",
						"FILTER_NAME" => "",
						"FIELD_CODE" => array(
							0 => "",
							1 => "",
						),
						"PROPERTY_CODE" => array(
							0 => "",
							1 => "STICKER",
							2 => "",
						),
						"CHECK_DATES" => "Y",
						"DETAIL_URL" => "",
						"AJAX_MODE" => "N",
						"AJAX_OPTION_JUMP" => "N",
						"AJAX_OPTION_STYLE" => "Y",
						"AJAX_OPTION_HISTORY" => "N",
						"AJAX_OPTION_ADDITIONAL" => "",
						"CACHE_TYPE" => "N",
						"CACHE_TIME" => "36000000",
						"CACHE_FILTER" => "N",
						"CACHE_GROUPS" => "Y",
						"PREVIEW_TRUNCATE_LEN" => "",
						"ACTIVE_DATE_FORMAT" => "d.m.Y",
						"SET_TITLE" => "Y",
						"SET_BROWSER_TITLE" => "Y",
						"SET_META_KEYWORDS" => "Y",
						"SET_META_DESCRIPTION" => "Y",
						"SET_LAST_MODIFIED" => "N",
						"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
						"ADD_SECTIONS_CHAIN" => "N",
						"HIDE_LINK_WHEN_NO_DETAIL" => "N",
						"PARENT_SECTION" => "",
						"PARENT_SECTION_CODE" => "",
						"INCLUDE_SUBSECTIONS" => "Y",
						"DISPLAY_DATE" => "Y",
						"DISPLAY_NAME" => "Y",
						"DISPLAY_PICTURE" => "Y",
						"DISPLAY_PREVIEW_TEXT" => "Y",
						"PAGER_TEMPLATE" => ".default",
						"DISPLAY_TOP_PAGER" => "N",
						"DISPLAY_BOTTOM_PAGER" => "N",
						"PAGER_TITLE" => "Новости",
						"PAGER_SHOW_ALWAYS" => "N",
						"PAGER_DESC_NUMBERING" => "N",
						"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
						"PAGER_SHOW_ALL" => "N",
						"PAGER_BASE_LINK_ENABLE" => "N",
						"SET_STATUS_404" => "N",
						"SHOW_404" => "N",
						"FILE_404" => "/404.php",
						"MESSAGE_404" => ""
					),
					false
				); ?>
			</div>
		</div>
	</div>

<?php
$percent = $_SESSION['BASKET_SUM_GIFT']/$arResult["GIFT_BOX"][2]['ORDER_FROM']*100;

$isActive = ($_SESSION['BASKET_SUM_GIFT']>$arResult["GIFT_BOX"][0]['ORDER_FROM']);
if(\COption::GetOptionString('bd.deliverypizza', 'BD_SUB_MODULE_GIFT_ENABLED','',SITE_ID) == 'Y'):
?>
	<?php if($_SERVER['REQUEST_URI']!=='/gifts/' && $_SERVER['REQUEST_URI']!=='/checkout/' && substr_count($_SERVER['REQUEST_URI'], '/my/') == 0): ?>
	<div class="gift-sticky hidden-md-down">
	          <div class="collapsed-gift">
	            <div class="gift-toggle <?php if($isActive): ?>active<?php endif; ?>">
	              <svg viewBox="0 0 512 512"><path d="m393.2,105.9c9.3-10 15.1-23.6 15.1-38.6 0-31.3-25-56.3-55.3-56.3-23,0-76,34.4-97.2,65.3-21.9-30.9-74.7-64.3-96.8-64.3-30.2,0-55.3,25-55.3,56.3 0,14.5 5.4,27.6 14.1,37.5h-106.8v134.5h29.2v260.7h153.3 125.1 153.3v-260.6h29.1v-134.5h-107.8zm-40.2-74c18.8-7.10543e-15 34.4,15.6 34.4,36.5 0,17.6-12.3,32.7-28.2,35.9h-84.6c-5.4-1.6-7.1-3.5-7.1-4.6 0-17.8 62.5-67.8 85.5-67.8zm-194-0c21.9,0 85.5,50 85.5,67.8 0,1.6-3.7,3.4-6.4,4.6h-85.2c-15.9-3.2-28.2-18.3-28.2-35.9-0.1-19.9 15.6-36.5 34.3-36.5zm34.4,448.2h-132.4v-239.7h132.4v239.7zm0-259.5h-161.5v-93.8h161.6v93.8zm104.2,259.5h-83.4v-353.4h83.4v353.4zm153.3,0h-132.4v-239.7h132.4v239.7zm29.1-259.5h-161.5v-93.8h161.6v93.8z"/></svg>
	            </div>
	            <div class="grade-cont">
	              <div class="grade" style="height: <?php echo $percent; ?>%;"></div>
	            </div>
	          </div>
	          <div class="expanded-gift open font-fix">
	            <div class="title"><?=GetMessage("GET_GIFT");?></div>
	            <div class="description"><?=GetMessage("GET_GIFT_DESC");?></div>
	            <div class="gift-toggle">
	              <svg viewBox="0 0 66.037 66.9657">
	                <svg viewBox="0 0 129 129" enable-background="new 0 0 129 129">
	                  <path d="M7.6,121.4c0.8,0.8,1.8,1.2,2.9,1.2s2.1-0.4,2.9-1.2l51.1-51.1l51.1,51.1c0.8,0.8,1.8,1.2,2.9,1.2c1,0,2.1-0.4,2.9-1.2   c1.6-1.6,1.6-4.2,0-5.8L70.3,64.5l51.1-51.1c1.6-1.6,1.6-4.2,0-5.8s-4.2-1.6-5.8,0L64.5,58.7L13.4,7.6C11.8,6,9.2,6,7.6,7.6   s-1.6,4.2,0,5.8l51.1,51.1L7.6,115.6C6,117.2,6,119.8,7.6,121.4z"></path>
	                </svg>
	              </svg>
	            </div>
	            <div class="grade-cont">
	              <div class="grade"></div>
	              <div class="gifts-list">
	                <div class="gift-item limit3 not-animate">
	                  <div class="badge">
	                    <svg viewBox="0 0 32 32"><path d="M26.899,9C26.436,6.718,24.419,5,22,5H10C7.581,5,5.564,6.718,5.101,9H0l3,13c0,2.761,2.239,5,5,5h16c2.761,0,5-2.239,5-5 l3-13H26.899z M10,7h12c1.304,0,2.403,0.837,2.816,2H7.184C7.597,7.837,8.696,7,10,7z M27,22c-0.398,1.838-1.343,3-3,3H8 c-1.657,0-2.734-1.343-3-3L2.563,11H5v1h2v-1h18v1h2v-1h2.437L27,22z M10,21h12v-2H10V21z M9,17h14v-2H9V17z"/></svg><span class="price">> <?php echo number_format($arResult["GIFT_BOX"][2]['ORDER_FROM'],0,'.',' '); ?><span class="currency"><?=CURRENCY_FONT; ?></span></span>
	                  </div>
		                <a data-modal="gift-modal" href="#"
		                   class="get-gift md-trigger"><?= GetMessage("GIFT_BUTTON"); ?></a>
	                </div>
	                <div class="gift-item limit2 not-animate">
	                  <div class="badge">
	                    <svg viewBox="0 0 32 32"><path d="M26.899,9C26.436,6.718,24.419,5,22,5H10C7.581,5,5.564,6.718,5.101,9H0l3,13c0,2.761,2.239,5,5,5h16c2.761,0,5-2.239,5-5 l3-13H26.899z M10,7h12c1.304,0,2.403,0.837,2.816,2H7.184C7.597,7.837,8.696,7,10,7z M27,22c-0.398,1.838-1.343,3-3,3H8 c-1.657,0-2.734-1.343-3-3L2.563,11H5v1h2v-1h18v1h2v-1h2.437L27,22z M10,21h12v-2H10V21z M9,17h14v-2H9V17z"/></svg><span class="price">> <?php echo number_format($arResult["GIFT_BOX"][1]['ORDER_FROM'],0,'.',' '); ?><span class="currency"><?=CURRENCY_FONT; ?></span></span>
	                  </div>
		                <a data-modal="gift-modal" href="#"
		                   class="get-gift md-trigger"><?= GetMessage("GIFT_BUTTON"); ?></a>
	                </div>
	                <div class="gift-item limit1 not-animate">
	                  <div class="badge">
	                    <svg viewBox="0 0 32 32"><path d="M26.899,9C26.436,6.718,24.419,5,22,5H10C7.581,5,5.564,6.718,5.101,9H0l3,13c0,2.761,2.239,5,5,5h16c2.761,0,5-2.239,5-5 l3-13H26.899z M10,7h12c1.304,0,2.403,0.837,2.816,2H7.184C7.597,7.837,8.696,7,10,7z M27,22c-0.398,1.838-1.343,3-3,3H8 c-1.657,0-2.734-1.343-3-3L2.563,11H5v1h2v-1h18v1h2v-1h2.437L27,22z M10,21h12v-2H10V21z M9,17h14v-2H9V17z"/></svg><span class="price">> <?php echo number_format($arResult["GIFT_BOX"][0]['ORDER_FROM'],0,'.',' '); ?><span class="currency"><?=CURRENCY_FONT; ?></span></span>
	                  </div>
		                <a data-modal="gift-modal" href="#"
		                   class="get-gift md-trigger"><?= GetMessage("GIFT_BUTTON"); ?></a>
	                </div>
	              </div>
	            </div>
	          </div>
	        </div>
	<?php endif; ?>
<?php endif; ?>