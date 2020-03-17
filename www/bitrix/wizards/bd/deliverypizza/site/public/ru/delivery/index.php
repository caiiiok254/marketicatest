<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Доставка");
$APPLICATION->SetTitle("Доставка");
?>
<?php if(($_SESSION['IS_MOBILE'] == true && $_SESSION['IS_TABLET']==false)):  ?>
<div class="content">
        <div class="status-bar detail-shadow"><a href="<?=SITE_DIR?>" class="back"></a>
          <div class="title"><?echo strip_tags($APPLICATION->GetTitle())?></div>
        </div>
        <div class="static-page">
          <p class="title"><?=GetMessage("work_time_delivery");?></p>
          <p><?$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."/include/work_time.php", "EDIT_TEMPLATE" => ""),false);?></p>
          <p class="title"><?=GetMessage("get_points_delivery");?></p>
          <div class="map-placeholder" id="map">
	          <?$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."/include/delivery_map.php", "EDIT_TEMPLATE" => ""),false);?>
	       </div>
        </div>
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
        <div class="row">
          <div class="col-lg-12 breadcrumb-box">
            <h1 class="font-fix"><?echo strip_tags($APPLICATION->GetTitle())?></h1>
            <div class="breadcrumb-container font-fix">
			  <?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "bread", Array(), false);?>
            </div>
          </div> 
        </div>
        <div class="content-page page-simple delivery-page">
          <p><span><?=GetMessage("work_time_delivery");?></span></p> 
          <?$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."/include/work_time.php", "EDIT_TEMPLATE" => ""),false);?>
          <h2><?=GetMessage("get_points_delivery");?></h2>
          <div class="map-placeholder" id="map">
	          <?$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."/include/delivery_map.php", "EDIT_TEMPLATE" => ""),false);?></div>
        </div>
      </main>
<?php endif;?> 
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>