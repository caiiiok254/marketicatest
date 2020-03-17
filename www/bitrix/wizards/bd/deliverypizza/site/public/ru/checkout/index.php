<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Оформление заказа");
$APPLICATION->SetTitle("Оформление заказа");

if(($_SESSION['IS_MOBILE'] == true && $_SESSION['IS_TABLET']==false)): ?>
<div class="content">
       <?$APPLICATION->IncludeComponent(
	"bd:checkout_pizza", 
	"mobile", 
	array(
		"COMPONENT_TEMPLATE" => "mobile",
		"IBLOCK_ID_PAY_METHOD" => \Bd\Deliverypizza\BdCache::$iblocks[SITE_ID]["bd_settings_pizza"]["bd_paymethod"][0],
		"IBLOCK_ID_DESTRICT" => \Bd\Deliverypizza\BdCache::$iblocks[SITE_ID]["bd_settings_pizza"]["bd_destrict"][0],
		"IBLOCK_ID_TAKE_AWAY" => \Bd\Deliverypizza\BdCache::$iblocks[SITE_ID]["bd_settings_pizza"]["bd_takeaway"][0]
	),
	false
);
?>
      </div>
<?else:?><!---ќсновна€ верси€ сайта ---->
      <main class="content container">
        <div class="row">
          <div class="col-lg-12 breadcrumb-box">
            <h1 class="font-fix"><?echo strip_tags($APPLICATION->GetTitle())?></h1>
            <div class="breadcrumb-container font-fix">
			  <?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "bread", Array(), false);?>
            </div>
          </div> 
        </div>
<?$APPLICATION->IncludeComponent(
	"bd:checkout_pizza", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"IBLOCK_ID_PAY_METHOD" => \Bd\Deliverypizza\BdCache::$iblocks[SITE_ID]["bd_settings_pizza"]["bd_paymethod"][0],
		"IBLOCK_ID_DESTRICT" => \Bd\Deliverypizza\BdCache::$iblocks[SITE_ID]["bd_settings_pizza"]["bd_destrict"][0],
		"IBLOCK_ID_TAKE_AWAY" => \Bd\Deliverypizza\BdCache::$iblocks[SITE_ID]["bd_settings_pizza"]["bd_takeaway"][0]
	),
	false
);
?>
      </main>
<?php endif;?> 
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>