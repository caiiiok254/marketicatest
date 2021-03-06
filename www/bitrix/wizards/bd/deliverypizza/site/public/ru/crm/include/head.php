<?	 
	    $APPLICATION->AddHeadString('<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">');
	    $APPLICATION->AddHeadString('<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />');
	    $APPLICATION->AddHeadString('<meta name="format-detection" content="telephone=no" />');
	    $APPLICATION->AddHeadString('<link rel="shortcut icon" href="/crm/static/favicon.ico" type="image/x-icon" />');
	    $APPLICATION->SetAdditionalCSS(SITE_DIR.'crm/static/css/style.css');
	    $APPLICATION->SetAdditionalCSS(SITE_DIR.'crm/static/css/jquery.webui-popover.css');
	    $APPLICATION->SetAdditionalCSS(SITE_DIR.'crm/static/css/c3.min.css');
	    $APPLICATION->SetAdditionalCSS(SITE_DIR.'crm/static/css/select2.min.css');
	    $APPLICATION->ShowHead();

?>
<!--[if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script><![endif]-->
<script type="text/javascript">
	window.currency_f = '<?=CURRENCY_FONT;?>';
	window.phone_mask = '<?=COption::GetOptionString('bd.deliverypizza','BD_DELIVER_PHONE_MASK','',SITE_ID);?>';
	window.notAppendBonusesWithPromo = '<?=COption::GetOptionString('bd.deliverypizza','BD_SUB_MODULE_BONUSES_NOT_APPEND_BONUSES_PROMO','',SITE_ID);?>';
</script>
<script type="text/javascript">
	<?php if(COption::GetOptionString('bd.deliverypizza','BD_CF_BASKET_PICKUP_DISCOUNT_ENABLED','',SITE_ID) == 'Y'): ?>
	window.pickupDiscount = <?=COption::GetOptionInt('bd.deliverypizza','BD_CF_BASKET_PICKUP_DISCOUNT_VALUE','',SITE_ID);?>;
	
	<?php else: ?>
	window.pickupDiscount = 0;
	<?php endif; ?>
	
	window.product_categories = {};
	<?php foreach ($product_categories as $key=>$cat):?>
	window.product_categories['<?=$key?>'] = {name: '<?=$cat?>',products: []};
	<?php foreach($products[$key] as $pkey=>$prod): ?>
	window.product_categories['<?=$key?>'].products[<?=$pkey;?>] = {name:'<?=str_replace("'",'',$prod['name'])?>',options:{'1': <?=CUtil::PhpToJSObject($prod['option_1'])?>,'2':<?=CUtil::PhpToJSObject($prod['option_2'])?>},price: '<?=$prod['price'];?>',no_sale: '<?=$prod['no_sale'];?>'};
	<?php endforeach; ?>
	<?php endforeach; ?>
</script>