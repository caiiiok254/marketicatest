<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Личные данные");
$APPLICATION->SetTitle("Личный кабинет");
global $USER;
if($USER->IsAuthorized()): ?>
<?php if(($_SESSION['IS_MOBILE'] == true && $_SESSION['IS_TABLET']==false)):  ?>
      <div class="content">
        <div class="status-bar"><a href="#" onclick="openMainProfileNav()" class="back"></a>
          <div class="title"><?=GetMessage("my_edit_title");?></div>
        </div>
          <div class="profile">

          <?$APPLICATION->IncludeComponent(
	"bd:profile.edit_pizza", 
	"mobile", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"IBLOCK_TYPE_DESTRICT" => "settings",
		"IBLOCK_ID_DESTRICT" => (int)\Bd\Deliverypizza\BdCache::$iblocks[SITE_ID]["bd_settings_pizza"]["bd_destrict"][0]
	),
	false
);
?>
        </div>
      </div>   
<?php else:?><!---Основная версия сайта ---->
      <main class="content container">
        <div class="row">
          
        
        <div class="col-xl-3 col-lg-4 col-md-12 profile-nav"><?php include_once '../menu.php'; ?></div>
            <div class="col-xl-9 col-lg-8 col-md-12 profile-bread">
	        <div class="col-xl-12 col-lg-12 breadcrumb-box">
            <h1 class="font-fix"><?echo strip_tags($APPLICATION->GetTitle())?></h1>
            <div class="breadcrumb-container font-fix">
			  <?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "bread", Array(), false);?>
            </div>
          </div> 
                    <?

                    $APPLICATION->IncludeComponent(
	"bd:profile.edit_pizza", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"IBLOCK_TYPE_DESTRICT" => "bd_settings",
		"IBLOCK_ID_DESTRICT" => (int)\Bd\Deliverypizza\BdCache::$iblocks[SITE_ID]["bd_settings_pizza"]["bd_destrict"][0]
	),
	false
);
?>
        </div>
        </div>
        </div>
      </main>
<?php endif; ?>      
      <?php else: ?>
<main class="content container">
  <div class="content-page page-404 font-fix error_text page-403">
    <h1><?=GetMessage("my_sorry_title");?></h1>
    <div class="status-icon icon-403"><span>403</span></div>
    <div class="status-title"><?=GetMessage("my_sorry_text");?></div>
  </div>
</main>
<?php endif; ?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>