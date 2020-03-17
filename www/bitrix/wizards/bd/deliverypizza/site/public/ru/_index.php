<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
$APPLICATION->SetPageProperty("description", "342234324");
$APPLICATION->SetPageProperty("keywords", "423432");
$APPLICATION->SetPageProperty("title", "Delivery pizza. Доставка пицца – самая вкусная пицца в Новосибирске!");
$APPLICATION->SetTitle("Delivery pizza. Доставка пицца – самая вкусная пицца в Новосибирске!");
?> 

<?php if(($_SESSION['IS_MOBILE'] == true && $_SESSION['IS_TABLET']==false)): ?>
<div class="content">
	<?$APPLICATION->IncludeComponent(
	"bd:slider_pizza", 
	"mobile", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"IBLOCK_TYPE" => "information",
		"IBLOCK_ID_SLIDER" => \Bd\Deliverypizza\BdCache::$iblocks[SITE_ID]["bd_information_pizza"]["bd_slider"][0]
	),
	false
);
?>
	 <?$APPLICATION->IncludeComponent(
	"bitrix:catalog", 
	"top_item", 
	array(
		"COMPONENT_TEMPLATE" => "top_item",
		"IBLOCK_TYPE" => "bd_content",
		"IBLOCK_ID" => \Bd\Deliverypizza\BdCache::$iblocks[SITE_ID]["bd_content_pizza"]["bd_catalog"][0],
		"TEMPLATE_THEME" => "blue",
		"ADD_PICT_PROP" => "-",
		"LABEL_PROP" => "-",
		"DETAIL_USE_VOTE_RATING" => "N",
		"DETAIL_USE_COMMENTS" => "N",
		"DETAIL_BRAND_USE" => "N",
		"SIDEBAR_SECTION_SHOW" => "N",
		"SIDEBAR_DETAIL_SHOW" => "N",
		"SIDEBAR_PATH" => "",
		"SEF_MODE" => "Y",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"USE_MAIN_ELEMENT_SECTION" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_TITLE" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"ADD_ELEMENT_CHAIN" => "N",
		"USE_FILTER" => "N",
		"FILTER_VIEW_MODE" => "VERTICAL",
		"INSTANT_RELOAD" => "N",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"USE_COMPARE" => "N",
		"PRICE_CODE" => array(
		),
		"USE_PRICE_COUNT" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "N",
		"PRICE_VAT_SHOW_VALUE" => "N",
		"BASKET_URL" => "/personal/basket.php",
		"USE_PRODUCT_QUANTITY" => "N",
		"PRODUCT_QUANTITY_VARIABLE" => "",
		"ADD_PROPERTIES_TO_BASKET" => "N",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRODUCT_PROPERTIES" => array(
		),
		"SHOW_TOP_ELEMENTS" => "Y",
		"SECTION_COUNT_ELEMENTS" => "N",
		"SECTION_TOP_DEPTH" => "2",
		"SECTIONS_VIEW_MODE" => "LIST",
		"SECTIONS_SHOW_PARENT_NAME" => "N",
		"PAGE_ELEMENT_COUNT" => "30",
		"LINE_ELEMENT_COUNT" => "3",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER2" => "desc",
		"LIST_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"INCLUDE_SUBSECTIONS" => "Y",
		"LIST_META_KEYWORDS" => "-",
		"LIST_META_DESCRIPTION" => "-",
		"LIST_BROWSER_TITLE" => "-",
		"SECTION_BACKGROUND_IMAGE" => "-",
		"DETAIL_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"DETAIL_META_KEYWORDS" => "-",
		"DETAIL_META_DESCRIPTION" => "-",
		"DETAIL_BROWSER_TITLE" => "-",
		"DETAIL_SET_CANONICAL_URL" => "N",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"DETAIL_CHECK_SECTION_ID_VARIABLE" => "N",
		"DETAIL_BACKGROUND_IMAGE" => "-",
		"SHOW_DEACTIVATED" => "N",
		"DETAIL_DISPLAY_NAME" => "Y",
		"DETAIL_DETAIL_PICTURE_MODE" => "IMG",
		"DETAIL_ADD_DETAIL_TO_SLIDER" => "N",
		"DETAIL_DISPLAY_PREVIEW_TEXT_MODE" => "E",
		"LINK_IBLOCK_TYPE" => "",
		"LINK_IBLOCK_ID" => "",
		"LINK_PROPERTY_SID" => "",
		"LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#",
		"USE_STORE" => "N",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"PAGER_TITLE" => "Товары",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SET_STATUS_404" => "N",
		"SHOW_404" => "N",
		"MESSAGE_404" => "",
		"USE_ELEMENT_COUNTER" => "N",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
		"TOP_ELEMENT_COUNT" => "8",
		"TOP_LINE_ELEMENT_COUNT" => "4",
		"TOP_ELEMENT_SORT_FIELD" => "sort",
		"TOP_ELEMENT_SORT_ORDER" => "asc",
		"TOP_ELEMENT_SORT_FIELD2" => "id",
		"TOP_ELEMENT_SORT_ORDER2" => "desc",
		"TOP_PROPERTY_CODE" => array(
			0 => "OLD_PRICE",
			1 => "PRICE",
			2 => "G",
			3 => "RECOMEND",
			4 => "UNITS",
			5 => "INGREDIENTS",
			6 => "LIKE_COUNTER",
			7 => "NO_SALE",
			8 => "BUY_IT",
			9 => "BUY_IT_COMPLETE",
			10 => "BD_PROPS_1",
			11 => "BD_PROPS_2",
			12 => "BADGES",
			13 => "BD_PROPS",
			14 => "",
		),
		"TOP_VIEW_MODE" => "SECTION",
		"SEF_FOLDER" => SITE_DIR."catalog/",
		"SEF_URL_TEMPLATES" => array(
			"sections" => "",
			"section" => "#SECTION_CODE_PATH#/",
			"element" => "#SECTION_CODE_PATH#/#ELEMENT_CODE#/",
			"compare" => "",
			"smart_filter" => "",
		)
	),
	false
);?>
 <?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"tabs", 
	array(
		"COMPONENT_TEMPLATE" => "tabs",
		"IBLOCK_TYPE" => "information",
		"IBLOCK_ID" => \Bd\Deliverypizza\BdCache::$iblocks[SITE_ID]["bd_information_pizza"]["bd_tabs"][0],
		"NEWS_COUNT" => "4",
		"SORT_BY1" => "ACTIVE_FROM",
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
			1 => "ICON",
		),
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"SET_TITLE" => "N",
		"SET_BROWSER_TITLE" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_LAST_MODIFIED" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "N",
		"DISPLAY_DATE" => "N",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Новости",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SET_STATUS_404" => "N",
		"SHOW_404" => "N",
		"MESSAGE_404" => ""
	),
	false
);?>
<footer class="font-fix">
	<div class="container">
		<div class="text-block">
			<div class="phone"><a href="tel:+<?=preg_replace('/\D/', '', \COption::GetOptionString('bd.deliverypizza','BD_SITE_PHONE','',SITE_ID))?>"><?php echo \COption::GetOptionString('bd.deliverypizza','BD_SITE_PHONE','',SITE_ID) ?></a></div>
			<div class="phone-desc"><?=GetMessage("delivery_fcng_awesome");?></div>
		</div>
		<div class="social-icons-footer">
<?$APPLICATION->IncludeComponent("bd:social_pizza", ".default", Array(
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);?>
		</div>
	</div>
</footer>

</div>
      
<?php else:?><!---Основная версия сайта ---->
      <main class="content container">
<?$APPLICATION->IncludeComponent(
	"bd:slider_pizza", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"IBLOCK_TYPE" => "information",
		"IBLOCK_ID_SLIDER" => \Bd\Deliverypizza\BdCache::$iblocks[SITE_ID]["bd_information_pizza"]["bd_slider"][0]
	),
	false
);
?>
   <?$APPLICATION->IncludeComponent(
	"bitrix:catalog", 
	"top_item", 
	array(
		"COMPONENT_TEMPLATE" => "top_item",
		"IBLOCK_TYPE" => "bd_content",
		"IBLOCK_ID" => \Bd\Deliverypizza\BdCache::$iblocks[SITE_ID]["bd_content_pizza"]["bd_catalog"][0],
		"TEMPLATE_THEME" => "blue",
		"ADD_PICT_PROP" => "-",
		"LABEL_PROP" => "-",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_COMPARE" => "Сравнение",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"DETAIL_USE_VOTE_RATING" => "N",
		"DETAIL_USE_COMMENTS" => "N",
		"DETAIL_BRAND_USE" => "N",
		"SIDEBAR_SECTION_SHOW" => "N",
		"SIDEBAR_DETAIL_SHOW" => "N",
		"SIDEBAR_PATH" => "",
		"SEF_MODE" => "Y",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"USE_MAIN_ELEMENT_SECTION" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_TITLE" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"ADD_ELEMENT_CHAIN" => "N",
		"USE_FILTER" => "N",
		"FILTER_VIEW_MODE" => "VERTICAL",
		"INSTANT_RELOAD" => "N",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"USE_COMPARE" => "N",
		"PRICE_CODE" => array(
		),
		"USE_PRICE_COUNT" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "N",
		"PRICE_VAT_SHOW_VALUE" => "N",
		"BASKET_URL" => "/personal/basket.php",
		"USE_PRODUCT_QUANTITY" => "N",
		"PRODUCT_QUANTITY_VARIABLE" => "",
		"ADD_PROPERTIES_TO_BASKET" => "N",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRODUCT_PROPERTIES" => array(
		),
		"SHOW_TOP_ELEMENTS" => "Y",
		"SECTION_COUNT_ELEMENTS" => "N",
		"SECTION_TOP_DEPTH" => "2",
		"SECTIONS_VIEW_MODE" => "LIST",
		"SECTIONS_SHOW_PARENT_NAME" => "N",
		"PAGE_ELEMENT_COUNT" => "30",
		"LINE_ELEMENT_COUNT" => "3",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER2" => "desc",
		"LIST_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"INCLUDE_SUBSECTIONS" => "Y",
		"LIST_META_KEYWORDS" => "-",
		"LIST_META_DESCRIPTION" => "-",
		"LIST_BROWSER_TITLE" => "-",
		"SECTION_BACKGROUND_IMAGE" => "-",
		"DETAIL_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"DETAIL_META_KEYWORDS" => "-",
		"DETAIL_META_DESCRIPTION" => "-",
		"DETAIL_BROWSER_TITLE" => "-",
		"DETAIL_SET_CANONICAL_URL" => "N",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"DETAIL_CHECK_SECTION_ID_VARIABLE" => "N",
		"DETAIL_BACKGROUND_IMAGE" => "-",
		"SHOW_DEACTIVATED" => "N",
		"DETAIL_DISPLAY_NAME" => "Y",
		"DETAIL_DETAIL_PICTURE_MODE" => "IMG",
		"DETAIL_ADD_DETAIL_TO_SLIDER" => "N",
		"DETAIL_DISPLAY_PREVIEW_TEXT_MODE" => "E",
		"LINK_IBLOCK_TYPE" => "",
		"LINK_IBLOCK_ID" => "",
		"LINK_PROPERTY_SID" => "",
		"LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#",
		"USE_STORE" => "N",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"PAGER_TITLE" => "Товары",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SET_STATUS_404" => "N",
		"SHOW_404" => "N",
		"MESSAGE_404" => "",
		"USE_ELEMENT_COUNTER" => "N",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
		"TOP_ELEMENT_COUNT" => "6",
		"TOP_LINE_ELEMENT_COUNT" => "3",
		"TOP_ELEMENT_SORT_FIELD" => "sort",
		"TOP_ELEMENT_SORT_ORDER" => "asc",
		"TOP_ELEMENT_SORT_FIELD2" => "id",
		"TOP_ELEMENT_SORT_ORDER2" => "desc",
		"TOP_PROPERTY_CODE" => array(
			0 => "",
			1 => "OLD_PRICE",
			2 => "PRICE",
			3 => "G",
			4 => "RECOMEND",
			5 => "UNITS",
			6 => "INGREDIENTS",
			7 => "LIKE_COUNTER",
			8 => "NO_SALE",
			9 => "BUY_IT",
			10 => "BUY_IT_COMPLETE",
			11 => "BD_PROPS_1",
			12 => "BD_PROPS_2",
			13 => "BADGES",
			14 => "BD_PROPS",
			15 => "",
		),
		"TOP_VIEW_MODE" => "SECTION",
		"SEF_FOLDER" => SITE_DIR."catalog/",
		"USER_CONSENT" => "N",
		"USER_CONSENT_ID" => "0",
		"USER_CONSENT_IS_CHECKED" => "Y",
		"USER_CONSENT_IS_LOADED" => "N",
		"DETAIL_STRICT_SECTION_CHECK" => "N",
		"USE_REVIEW" => "N",
		"COMPATIBLE_MODE" => "Y",
		"SEF_URL_TEMPLATES" => array(
			"sections" => "",
			"section" => "#SECTION_CODE_PATH#/",
			"element" => "#SECTION_CODE_PATH#/#ELEMENT_CODE#/",
			"compare" => "",
			"smart_filter" => "",
		)
	),
	false
);?>

		<?php if(COption::GetOptionString('bd.deliverypizza','BD_SUB_MODULE_SOCIAL_REPOST', '', SITE_ID) == 'Y'): ?>
        <!--- SOCIAL REPOST SECTION ---->
        <div class="row information-block hidden-md-down common-block">
          <div class="information-text font-fix col-xl-8 col-lg-8">
            <h2 class="social-repost"><?$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/social_repost_title.php", "EDIT_TEMPLATE" => ""),false);?></h2>
            <div class="social-repost-text"><?$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/social_repost_desc.php", "EDIT_TEMPLATE" => ""),false);?></div>
          </div>
          <div class="information-icons col-xl-4 col-lg-4 text-xs-right">
            <a class="sprite sprite-repost_vk" data-id="vk" href="#"></a>
            <a class="sprite sprite-repost_fb" data-id="fb" href="#"></a>
            <a class="sprite sprite-repost_twitter"  data-id="tw" href="#"></a>
			<a class="sprite sprite-repost_od" data-id="ok" href="#"></a>
          </div>
        </div>
        <?php endif; ?>
      </main>
      
      
	      
	      <?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"tabs", 
	array(
		"COMPONENT_TEMPLATE" => "tabs",
		"IBLOCK_TYPE" => "information",
		"IBLOCK_ID" => \Bd\Deliverypizza\BdCache::$iblocks[SITE_ID]["bd_information_pizza"]["bd_tabs"][0],
		"NEWS_COUNT" => "4",
		"SORT_BY1" => "ACTIVE_FROM",
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
			1 => "ICON",
		),
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"SET_TITLE" => "N",
		"SET_BROWSER_TITLE" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_LAST_MODIFIED" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "N",
		"DISPLAY_DATE" => "N",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Новости",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SET_STATUS_404" => "N",
		"SHOW_404" => "N",
		"MESSAGE_404" => ""
	),
	false
);?>

          <?php if(!isset($_GET['bitrix_include_areas']) || $_GET['bitrix_include_areas']=='N'): ?>

        <?php endif; ?>  
<?php endif;?>          
<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');
?>