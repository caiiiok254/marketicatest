<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", GetMessage("ls_history"));
$APPLICATION->SetTitle(GetMessage("ls_history"));
global $USER;
?>
<?php
if($USER->IsAuthorized()): ?>
<?php if(($_SESSION['IS_MOBILE'] == true && $_SESSION['IS_TABLET']==false)):  ?>
      <div class="content">
        <div class="status-bar"><a href="#" onclick="openMainProfileNav()" class="back"></a>
          <div class="title"><?=GetMessage("my_history_title");?></div>
        </div>

        <?$APPLICATION->IncludeComponent(
				"bd:profile.history_pizza", 
				"mobile", 
				array(
				),
				false
			);
		?>
       </div>
<?php else:?><!---Основная версия сайта ---->
      <main class="content container">
        <div class="row">
	      
        <div class="col-xl-3 col-lg-4 col-md-12 profile-nav"><?php include_once 'menu.php'; ?></div>
        <div class="col-xl-9 col-lg-8 col-md-12">
	        <div class="col-xl-12 col-lg-12 breadcrumb-box">
            <h1 class="font-fix"><?echo strip_tags($APPLICATION->GetTitle())?></h1>
            <div class="breadcrumb-container font-fix">
			  <?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "bread", Array(), false);?>
            </div>
      		</div>
        <div class="profile-form"> 
          <?$APPLICATION->IncludeComponent(
	"bd:profile.history_pizza", 
	".default", 
	array(
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