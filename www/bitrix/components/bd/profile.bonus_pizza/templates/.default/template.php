<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?php if(\COption::GetOptionString('bd.deliverypizza', 'BD_SUB_MODULE_BONUSES_ENABLED','',SITE_ID) == 'Y'): ?>
<div class="profile-content bonuses font-fix">
            <div class="row">
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 progress-main">
	              <div class="bonuses-progress-cont">
		              <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
<g>
	<g>
		<path d="M442.491,241.824l-15.808-27.088c-2.08-3.564-6.655-4.766-10.22-2.687c-3.564,2.08-4.768,6.656-2.687,10.22l10.158,17.406
			h-96.192l48.099-82.408l14.088,24.139c2.08,3.565,6.657,4.768,10.22,2.687c3.564-2.08,4.768-6.656,2.687-10.22l-19.712-33.777
			c-1.845-3.161-5.266-5.126-8.927-5.126H137.804c-3.661,0-7.082,1.964-8.926,5.126L69.511,241.821
			c-2.132,3.651-1.842,8.174,0.741,11.525l103.663,134.399c1.472,1.909,3.685,2.909,5.922,2.909c1.593,0,3.199-0.507,4.558-1.556
			c3.268-2.52,3.873-7.213,1.353-10.481l-95.64-123.998h101.311l49.223,195.168l-26.057-33.784
			c-2.519-3.266-7.213-3.873-10.481-1.352c-3.268,2.52-3.873,7.213-1.353,10.48l45.063,58.426c1.972,2.558,4.956,4.025,8.186,4.025
			c3.23,0,6.213-1.467,8.185-4.024L441.75,253.345C444.332,249.995,444.622,245.472,442.491,241.824z M362.827,149.915
			l-47.921,82.104l-46.136-82.104H362.827z M302.065,239.675h-92.13L256,157.696L302.065,239.675z M88.067,239.675l48.093-82.408
			l48.099,82.408H88.067z M149.173,149.915h94.057l-46.136,82.104L149.173,149.915z M256,449.569l-49.168-194.95h98.336L256,449.569
			z M271.358,449.789l49.223-195.169h101.311L271.358,449.789z"/>
	</g>
</g>
<g>
	<g>
		<path d="M256,24.418c-4.126,0-7.472,3.345-7.472,7.472v33.875c0,4.127,3.345,7.472,7.472,7.472s7.472-3.345,7.472-7.472V31.89
			C263.472,27.763,260.126,24.418,256,24.418z"/>
	</g>
</g>
<g>
	<g>
		<path d="M437.019,82.794c-2.918-2.917-7.649-2.917-10.567,0l-23.953,23.952c-2.918,2.919-2.918,7.649,0,10.568
			c1.459,1.458,3.371,2.188,5.283,2.188c1.912,0,3.825-0.73,5.284-2.188l23.953-23.952
			C439.937,90.443,439.937,85.713,437.019,82.794z"/>
	</g>
</g>
<g>
	<g>
		<path d="M504.528,256.34h-33.875c-4.127,0-7.472,3.345-7.472,7.472s3.346,7.472,7.472,7.472h33.875
			c4.127,0,7.472-3.345,7.472-7.472C512,259.685,508.654,256.34,504.528,256.34z"/>
	</g>
</g>
<g>
	<g>
		<path d="M41.347,256.34H7.472c-4.127,0-7.472,3.345-7.472,7.472s3.346,7.472,7.472,7.472h33.875c4.127,0,7.472-3.345,7.472-7.472
			C48.819,259.685,45.474,256.34,41.347,256.34z"/>
	</g>
</g>
<g>
	<g>
		<path d="M109.502,106.746L85.548,82.793c-2.918-2.917-7.649-2.917-10.567,0c-2.918,2.919-2.918,7.649,0,10.568l23.953,23.953
			c1.459,1.458,3.371,2.188,5.284,2.188c1.913,0,3.825-0.73,5.284-2.188C112.42,114.395,112.42,109.665,109.502,106.746z"/>
	</g>
</g>
</svg>
				  	<div class="bonuses-progress">
                  <div class="bonuses-progress-item got"><?php echo COption::GetOptionInt('bd.deliverypizza','BD_SUB_MODULE_BONUSES_1_LEVEL_CASHBACK', '', SITE_ID); ?>%</div>
                  <div class="bonuses-progress-item <?php if(COption::GetOptionInt('bd.deliverypizza','BD_SUB_MODULE_BONUSES_2_LEVEL_ORDERS_SUM', '', SITE_ID) <= $arResult['ORDERS_SUM'] ): ?>got<?php endif; ?>"><?php echo COption::GetOptionInt('bd.deliverypizza','BD_SUB_MODULE_BONUSES_2_LEVEL_CASHBACK', '', SITE_ID); ?>%</div>
                  <div class="bonuses-progress-item <?php if(COption::GetOptionInt('bd.deliverypizza','BD_SUB_MODULE_BONUSES_3_LEVEL_ORDERS_SUM', '', SITE_ID) <= $arResult['ORDERS_SUM'] ): ?>got<?php endif; ?>"><?php echo COption::GetOptionInt('bd.deliverypizza','BD_SUB_MODULE_BONUSES_3_LEVEL_CASHBACK', '', SITE_ID); ?>%</div>
                </div>
	              </div>
              </div>
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 nopadl progress-information">
                <?php if(COption::GetOptionInt('bd.deliverypizza','BD_SUB_MODULE_BONUSES_3_LEVEL_ORDERS_SUM', '', SITE_ID) <= $arResult['ORDERS_SUM'] ){ ?>
                <div class="progress-stat"><strong><?= GetMessage("bonuses_top_discount"); ?></strong></div>
                <?php }elseif(COption::GetOptionInt('bd.deliverypizza','BD_SUB_MODULE_BONUSES_1_LEVEL_ORDERS_SUM', '', SITE_ID) <= $arResult['ORDERS_SUM'] ){ ?>
                  <div class="progress-stat"><?= GetMessage("bonuses_you_order"); ?> <span class="orders-totals"><?php echo number_format($arResult['ORDERS_SUM'],0,'.',' '); ?></span> <span class="currency"><?=CURRENCY_FONT; ?></span> <?= GetMessage("bonuses_left"); ?> <span class="span orders-totals-need"><?php echo number_format($arResult['NEED_SUM'],0,'.',' '); ?> </span><span class="currency"><?=CURRENCY_FONT; ?></span> <?= GetMessage("bonuses_for_next_lever_discount"); ?></div>
                <?php }elseif(COption::GetOptionInt('bd.deliverypizza','BD_SUB_MODULE_BONUSES_1_LEVEL_ORDERS_SUM', '', SITE_ID) > $arResult['ORDERS_SUM'] ){ ?>
                  <div class="progress-stat"><?= GetMessage("bonuses_you_order"); ?> <span class="orders-totals"><?php echo number_format($arResult['ORDERS_SUM'],0,'.',' '); ?></span> <span class="currency"><?=CURRENCY_FONT; ?></span> <?= GetMessage("bonuses_left"); ?> <span class="span orders-totals-need"><?php echo number_format($arResult['NEED_SUM'],0,'.',' '); ?> </span><span class="currency"><?=CURRENCY_FONT; ?></span> <?= GetMessage("bonuses_for_next_lever_discount"); ?></div>
                <?php } ?>

              </div>
            </div>
            <div class="bonus-rules-cont col-xs-9">
	            <div class="title"><?= GetMessage("rules_title"); ?></div>
	            <ul>
		            <li><?= GetMessage("prog_desc_1"); ?></li>
		            <li><?= GetMessage("prog_desc_2"); ?></li>
		            <li><?= GetMessage("prog_desc_3"); ?></li>
		            <li><?= GetMessage("prog_desc_4"); ?></li>
		            <li><?= GetMessage("prog_desc_5"); ?></li>
		            <li><?= GetMessage("prog_desc_6"); ?></li>
	            </ul>
            </div>
          </div>
<?php else: ?>
  <div class="content-page page-404 font-fix error_text page-403">
    <div class="status-title"><?=GetMessage("sub_module_disabled");?></div>
  </div>
<?php endif; ?>