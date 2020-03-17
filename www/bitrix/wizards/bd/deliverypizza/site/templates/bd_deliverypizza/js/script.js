function registerPopovers(){
    $('a[data-handler="popover"]').each(function(){
        var $id = $(this).data('id');
        var $target = '#'+$id;
        $(this).blur()
        var onS = function(e){
            if($('#auth').hasClass('is_auth')){
                $('#popover-auth').addClass('is_auth');
            }
            if ($('#auth').hasClass('bonuses-disabled')) {
                $('#popover-auth').addClass('bonuses-disabled');
            }
            var $id_ = $(e).attr('id').replace('popover-','');
            $('[data-id="'+$id_+'"]').addClass('pop-active');
        };
        var onH = function(){$('a[data-handler="popover"]').removeClass('pop-active');};
        if($id=='basket'){
            onS = function(){
                if(window.yaCounter!=undefined && window.yaCounter != null){
                    yaCounter.reachGoal('go-to-basket',{});
                }
                if(ga!=undefined){
                    ga('send', 'event', 'basket', 'view');
                }
	            renderBasket();
                $('.basket-btn .not-empty-basket').hide();
                $('.basket-btn .empty-basket').hide();
                $('.basket-btn .close-basket').show();
            }
            onH = function(){
                $('.basket-btn .not-empty-basket').show();
                $('.basket-btn .empty-basket').hide();
                $('.basket-btn .close-basket').hide();
                if($('.product-info-cont .close-view').is(':visible'))
                    $('.product-info-cont .close-view').trigger('click');
            }
        }
        if ($id == 'basket') {
            onS = function () {
                if (window.yaCounter != undefined && window.yaCounter != null) {
                    yaCounter.reachGoal('go-to-basket', {});
                }
                if (ga != undefined) {
                    ga('send', 'event', 'basket', 'view');
                }
                renderBasket();
                $('.basket-btn .not-empty-basket').hide();
                $('.basket-btn .empty-basket').hide();
                $('.basket-btn .close-basket').show();
            }
            onH = function () {
                $('.basket-btn .not-empty-basket').show();
                $('.basket-btn .empty-basket').hide();
                $('.basket-btn .close-basket').hide();
                if ($('.product-info-cont .close-view').is(':visible'))
                    $('.product-info-cont .close-view').trigger('click');
            }
        }

        if ($id == 'constructor-ingredients') {
            onS = function () {
                $('.add-ingredient').addClass('active')
            }
            onH = function () {
                $('.add-ingredient').removeClass('active')
            }
        }

        if ($id == 'constructor-presets') {
            onS = function () {
                $('.get-preset').addClass('active')
            }
            onH = function () {
                $('.get-preset').removeClass('active')
            }
        }
        var plac = 'bottom-left';
        if($id.indexOf('history-pop') !== -1){
		    plac = 'bottom';
	    }
        if ($id == 'auth' && $('#' + $id).hasClass('is_auth')) {
            plac = 'bottom';
        }
        $(this).webuiPopover({url:$target,id_:$id,animation: 'fade',onShow: onS,onHide: onH,cache: true,placement: plac});
    });
}
function renderBasket(){
	$(".products-list.scroll-content").html('');
    $('.basket-items-col .spinner').show();
	$.ajax({
      dataType: "json",
      url: '/bitrix/components/bd/basket_pizza/component.php?action=getBasket',
      success: renderBasketItems
    });
}
function renderBasketItems(data){
    animateNumbers($('.basket-actions .order-sum span').first(),data.basket_sum);
    animateNumbers($('.payment-footer .order-sum span').first(),data.basket_sum);

    if(data.cashback){
        animateNumbers($('.basket-actions .bonuses-info span').first(),data.cashback);
        animateNumbers($('.payment-footer .bonuses-info span').first(),data.cashback);
        $('.summary-label.user-bonus-append .meta-value_ span').first().text(data.cashback).closest('.summary-label.user-bonus-append').show()
      }else{
        $('.summary-label.user-bonus-append').hide()
      }
    if(data.promo || data.discount){
        if(data.discount && data.discount!==null){
            $('.basket-actions .order-discount .meta-value span').first().parent().show();
            animateNumbers($('.basket-actions .order-discount span').first(),data.discount);
            animateNumbers($('.payment-footer .order-discount .meta-value span').first(),data.discount);
            $('.payment-footer .order-discount span').first().parent().show();
            $('.basket-actions .order-discount span').first().parent().show();
            $('.basket-actions .order-total').find('.summary-label').hide();
            //$('.payment-footer .order-total').find('.summary-label').hide();
            $('.basket-actions .apply-code-btn').addClass('ok');
        }else{
            $('.basket-actions .order-discount span').first().parent().hide();
            $('.payment-footer .order-total').find('.summary-label.order-discount').show();
            $('.basket-actions .order-total').find('.summary-label').show();
        }
        if(data.promo){
            $('.basket-promo-code').val(data.promo).parent().addClass('filled ok');
        }else{
            $('.basket-promo-code').val('').parent().removeClass('filled ok');
        }
    }else{
        $('.basket-actions .order-discount span').first().parent().hide();
        $('.payment-footer .order-total').find('.summary-label.order-discount').show();
        $('.basket-actions .order-total').find('.summary-label').show();
        $('.payment-footer .order-discount').hide();
        $('.basket-actions .order-discount').hide();
        $('.basket-actions .apply-code-btn').removeClass('ok');
    }
    $(".products-list.scroll-content").html('');
    $.each(data.products, function (i, item) {
        if (item.OPTIONS !== undefined && item.OPTIONS[1] !== null) {
            item.SECTION = '<span>' + item.OPTIONS_NATIVE[0][item.OPTIONS[1]].VALUE;

            if (item.OPTIONS[2] !== undefined && item.OPTIONS[2] !== null) {
                item.SECTION += ', ' + item.OPTIONS_NATIVE[1][item.OPTIONS[2]].VALUE;
            }
            item.SECTION += '</span>'
        }
    })
    $.tmpl("basketTemplate", data.products).appendTo(".products-list.scroll-content");
    $('.basket-items-col .spinner').hide();


    setTimeout(function(){
        $('.basket-item .change-amount-btn').off().on('click',function(e){
            e.preventDefault();
            var $basket_item = $(this).closest('.basket-item');
            var current_val = $basket_item.find('.buttons').find('input[type="hidden"]').val();
            var new_val = parseInt(current_val);
            var product_id = $basket_item.data('id');
            var price = parseInt($basket_item.data('price'));
            if($(this).hasClass('plus')){
                new_val++;
            }else{
                new_val--;
            }
            if(new_val==0)
                new_val = 1;
            $.ajax({
                type: 'post',
                data: {'PRODUCT_ID': product_id, 'AMOUNT': new_val},
                dataType: "json",
                url: '/bitrix/components/bd/basket_pizza/component.php?action=changeAmount',
                success: function(data){
                    var has_gift = false;
                    $.each(data.products,function(i,item){
                        if(item.INDEX=='gift'){
                            has_gift = true;
                        }
                        $basket_item = $('.basket-item[data-id="'+item.INDEX+'"]');
                        $basket_item.find('.buttons .amount').text(item.AMOUNT);
                        $basket_item.find('.buttons input[type="hidden"]').val(item.AMOUNT);
                        animateNumbers($basket_item.find('.product-sum span').first(),item.LOCAL_SUM.replace(' ',''));
                    });
                    var $gift_item = $('.basket-item[data-id="gift"]');
                    if($gift_item.length>0 && !has_gift){
                        $gift_item.remove();
                        if($('.get-another-gift-btn').length){
                            $('.get-another-gift-btn').trigger('click')
                        }
                    }

                    renderSummary(data);
                }
            });
            if($('select[name="ORDER[DISTRICT_ID]"]').length)
                $('select[name="ORDER[DISTRICT_ID]"]').trigger('change')
            return false;
        });
        $('.remove-basket-item a').off().on('click',function(e){

            if($('.constructor-view').is(':visible')){
                $('.constructor-view .close-view').trigger('click');
            }
            e.preventDefault();
            var $basket_item = $(this).closest('.basket-item');
            var product_id = $basket_item.attr('data-id');
            if (window.yaCounter != undefined && window.yaCounter != null) {
                window.dataLayer.push({
                    "ecommerce": {
                        "remove": {
                            "products": [
                                {
                                    "id": product_id,
                                    "name": $basket_item.find('.name').text(),
                                    "price": $basket_item.attr('data-price'),
                                    "quantity": $basket_item.find('.amount').text()
                                }
                            ]
                        }
                    }
                });

            }
            if(product_id=='gift' && $('.get-another-gift-btn').length){
                $('.product.gift').removeClass('active');
            }

                $('.product[data-id="'+$basket_item.attr('data-pid')+'"]').find('.add-to-cart-btn').removeClass('retry').text(BX.message('add_basket'));
                $.ajax({
                    type: 'post',
                    data: {'PRODUCT_ID': product_id},
                    dataType: "json",
                    url: '/bitrix/components/bd/basket_pizza/component.php?action=remove',
                    success: function(data){
                        var has_gift = false;
                        $.each(data.products,function(i,item) {
                            if (item.INDEX == 'gift') {
                                has_gift = true;
                            }
                            if(item.ID.indexOf('additional_')!==-1){
                                $('.basket_item_is_additional[data-id="'+item.ID+'"] .buttons').find('.amount').text(item.AMOUNT);
                                $('.basket_item_is_additional[data-id="'+item.ID+'"] .buttons').find('input[type="hidden"]').val(item.AMOUNT);
                            }
                        });

                        $('.order-content li[data-pid="'+$basket_item.attr('data-pid')+'"]').remove();

                        $basket_item.remove();
                        var $gift_item = $('.basket-item[data-id="gift"]');
                        if($gift_item.length>0 && !has_gift){
                            $gift_item.remove();
                            if($('.get-another-gift-btn').length){
                                $('.get-another-gift-btn').trigger('click')
                            }
                        }
                        renderSummary(data);
                    }
                });

            if($('select[name="ORDER[DISTRICT_ID]"]').length)
                $('select[name="ORDER[DISTRICT_ID]"]').trigger('change')
            return false;
        });
        $('.basket-item .name,.basket-item .product-image').off().on('click',function(){
            if(!$(this).closest('.basket-item').hasClass('without_detail')){
                if(!$('.product-info-cont').is(':visible'))
                    $('#popover-basket').addClass('product-information-open').css( 'left', '-=78px' );
                var id = $(this).closest('.basket-item').data('id');
                $('.recommendation-container').hide();
                $('.basket-gift-container').hide();
                $.ajax({
                type: 'post',
                data: {PRODUCT_ID: id},
                dataType: "json",
                url: '/bitrix/components/bd/basket_pizza/component.php?action=getBasketItemDetail',
                success: function(data){
                    $('.information-col .close-view').show();
                    $('.information-col .apply-view').hide();
                    $('.product-info-cont .constructor-view .product-image img').attr('src',data.PREVIEW_PICTURE.src);
                    $('.product-info-cont .constructor-view .name').attr('data-id',id).html(data.NAME);
                    if(data.TYPE=='native'){
                        $('.product-info-cont .like-content span').text(data.LIKE_COUNTER);
                        $('.product-info-cont .constructor-view .product-scroll-content .product-description').html(data.PREVIEW_TEXT);
                        $('.product-info-cont .likes').attr('data-id',data.ID).show();
                        if(data.isLiked==1){
                            $('.product-info-cont .likes').addClass('liked');
                        }else{
                            $('.product-info-cont .likes').removeClass('liked');
                        }
                        $('.product-info-cont .constructor-view .product-scroll-content .product-options').html('');
                        if(data.BD_PROPS!=null){
                            var ji = 0;

                            $.each(data.BD_PROPS,function(key,item){
                                var content = '<div class="options-row-select col-xl-'+parseInt(12/parseInt(data.BD_PROPS.length))+' col-lg-12"><select data-placeholder-option="true">';
                                content += '<option value="null">'+data.OPTIONS_NAME[ji+1]+'</option>';
                                $.each(item,function(skey,sitem){
                                    var selected = '';
                                    if(ji==0 && skey==parseInt(data.OPTIONS.OPTION_1)){
                                        selected = 'selected="selected"';
                                    }
                                    if(ji==1 && skey==parseInt(data.OPTIONS.OPTION_2)){
                                        selected = 'selected="selected"';
                                    }
                                    content+= '<option '+selected+' value="'+skey+'" data-price="'+sitem.PRICE+'" data-old-price="'+sitem.OLD_PRICE+'" data-weight="'+sitem.WEIGHT+'">'+sitem.VALUE+'</option>';
                                });
                                content +="</select></div>";
                                $('.product-info-cont .constructor-view .product-scroll-content .product-options').append(content);
                                ji++;
                            });
                        }
                        $('.product-info-cont .constructor-view .product-scroll-content .product-options select').on('change',function(){
                            $('.information-col .close-view').hide();
                            $('.information-col .apply-view').show();
                        }).selectOrDie();
                        $('.product-info-cont .constructor-view .product-scroll-content .product-prices .weight').text(data.G);
                        registerLikes();
                        $('.product-info-cont .constructor-view .constructor-scroll-content').hide();
                        $('.product-info-cont .constructor-view .product-scroll-content').show();
                    }else{
                        $('.product-info-cont .likes').hide();
                        $('.product-info-cont .constructor-content .ingredients_list_').html('');
                        $('.product-info-cont .constructor-content .base_value_').text(data.BASE);
                        $('.product-info-cont .constructor-content .souse_value_').text(data.SOUSE);
                        $.each(data.INGREDIENTS,function(i,item){
                            $('.product-info-cont .constructor-content .ingredients_list_').append('<div class="property-value">'+item+'</div>')
                        })
                        $('.product-info-cont .constructor-view .product-scroll-content').hide();
                        $('.product-info-cont .constructor-view .constructor-scroll-content').show();
                    }
                    $('.product-info-cont').show();
                }
            });
            }
        });
    },500)
    renderSummary(data);
}
function renderSummary(data){
    if(data.basket_sum < window.limit1 && $('.order-content li[data-pid="gift"]'))
        $('.order-content li[data-pid="gift"]').remove()
    if(data.products.length>0){
      $.each(data.products,function(i,item){
        $('.order-content li[data-pid="'+item.ID+'"] .amount span').first().text(item.AMOUNT);
        $('.order-content li[data-pid="'+item.ID+'"] .price span').first().text(item.LOCAL_SUM);
      });
    }
    if(data.delivery_price == null){
        $('.summary-label.delivery-sum').hide();
    }
    var min_order = parseInt($('.min-order-progress').data('min-order'));
    if (data.basket_sum_native >= min_order) {
        if($('.send-order').length){
	        $('.checkout-min-order-label').hide();
            $('.send-order').removeAttr('disabled');
        }
        $('.min-order-progress').hide();
        $('.min-order-progress').find('.progress-bar').css('width','100%');
        $('.basket-checkout-btn').css('display','block');;
    }else{
		$('.checkout-min-order-label').show();
        $('.send-order').attr('disabled','disabled');
        $('.min-order-progress').show();
        $('.min-order-progress').find('.progress-bar').css('width',parseInt(data.basket_sum/min_order*100)+'%');
        $('.basket-checkout-btn').css('display','none');
    }
    if(data.products.length>0){
        if(data.basket_sum == 0){
            // && data.discount!==null && data.discount!==undefined
            if(!isNaN(parseInt($('[name="ORDER[DISCOUNT_BONUSES]"]').val()) + data.basket_sum - window.prev_delta))
                $('[name="ORDER[DISCOUNT_BONUSES]"]').val(parseInt($('[name="ORDER[DISCOUNT_BONUSES]"]').val()) + data.basket_sum - window.prev_delta);

            window.prev_delta = 0;
            if(parseInt($('[name="ORDER[DISCOUNT_BONUSES]"]').val())+data.basket_sum > min_order){
                $('.send-order').removeAttr('disabled');
            }
        }
        if(data.basket_sum < 0){
            $('[name="ORDER[DISCOUNT_BONUSES]"]').val(parseInt($('[name="ORDER[DISCOUNT_BONUSES]"]').val()) + data.basket_sum );
            window.prev_delta = data.basket_sum;
            data.basket_sum = 0;
            $('.send-order').removeAttr('disabled');
        }
        if(parseInt($('[name="ORDER[DISCOUNT_BONUSES]"]').val()) + data.basket_sum > 0){
            $('.send-order').removeAttr('disabled');
        }

        animateNumbers($('.summary-label.basket-sum .meta-value_ span').first(),data.basket_sum_native);
        animateNumbers($('.order-total .order-sum span').first(),data.basket_sum);
        animateNumbers($('.basket-actions .bonuses-info span').first(),data.cashback);
        animateNumbers($('.payment-footer .bonuses-info span').first(),data.cashback);
        if(data.promo!==undefined && $('.bonuses-with-promo-disabled').length){
            $('.bonuses-with-promo-disabled').show();
            $('.payment-footer .bonuses-info .default-text').hide();
            $('.basket-actions .bonuses-info .default-text').hide();
        }else{
            $('.bonuses-with-promo-disabled').hide();
            $('.payment-footer .bonuses-info .default-text').show();
            $('.basket-actions .bonuses-info .default-text').show();
        }
        animateNumbers($('.not-empty-basket').find('.basket-sum span').first(),data.basket_sum);
        animateNumbers($('.basket-actions .order-sum span').first(),data.basket_sum);
        if(data.basket_sum_gift < window.limit1){
            var percent = parseInt(data.basket_sum_gift/window.limit1*100);

            $('.basket-gift-container .progress-container.in-progress').show().find('.progress-bar').css('width',percent+'%');
        animateNumbers($('.basket-gift-container .progress-container.in-progress .sum-to-gift span').first(),window.limit1-data.basket_sum_gift);

            $('.basket-gift-container .progress-container.progress-completed').hide();
            $('.basket-gift-container .progress-container.progress-get-another').hide();

        }else{
            var basket_has_gift = false;
            for(prod in data.products){
                if(data.products[prod].INDEX=='gift'){
                    basket_has_gift = true;
                }
            }

            $('.basket-gift-container .progress-container.in-progress').hide();

            if(basket_has_gift==true){
                $('.basket-gift-container .progress-container.progress-completed').hide();
                $('.basket-gift-container .progress-container.progress-get-another').show();
            }else{
                $('.product.gift').removeClass('active');
                $('.basket-gift-container .progress-container.progress-completed').show();
                $('.basket-gift-container .progress-container.progress-get-another').hide();
            }
        }
        if(!$('.product-info-cont').is(':visible')){
            $('.recommendation-container.no-recommendation').show();
            $('.recommendation-container.recommendation-list .rc-list').html('');
            $('.recommendation-container.recommendation-list .rc-nav').html('');
            $('.recommendation-container.static-banner').show().html('');

            if(data.recommendation.single!==undefined && (data.recommendation.list==undefined && data.recommendation.list==null || data.recommendation.list.length == 0)){
                    $('.recommendation-container.no-recommendation').hide();
                    $('.recommendation-container.recommendation-list').hide();
                    $('.recommendation-container.static-banner').html('<a href="'+data.recommendation.single.URL+'"><img src="'+data.recommendation.single.IMAGE.SRC+'" /></a>').show();
            }
            if(data.recommendation.list!==undefined && data.recommendation.list!==null && data.recommendation.list.length>0){
                $('.recommendation-container.no-recommendation').hide();
                $('.recommendation-container.static-banner').hide();
                $('.recommendation-container.recommendation-list').show();
                var pages = Math.ceil(data.recommendation.list.length/3);
                for (var j = 0; j < pages; j++) {
                    var clas_ = '';
                    $('.recommendation-container.recommendation-list .rc-list').append('<div class="recommendation-tab" data-index="'+(j+1)+'"></div>');
                    if(pages>1){
                        if(j==0){
                            clas_ = 'class="active"'
                        }
                        $('.recommendation-container.recommendation-list .rc-nav').append('<li '+clas_+'><a href="#" data-index="'+(j+1)+'"><div class="rc-bull"></div></a></li>');
                    }
                }
                $.each(data.recommendation.list,function(i,item){
                    var bgi = '';

                    if(item.IMAGE.SRC!==undefined){
                        bgi = 'background-image: url('+item.IMAGE.SRC+');';
                    }
                    $('.recommendation-container.recommendation-list .rc-list .recommendation-tab[data-index="'+Math.ceil((i+1)/3)+'"]').append('<div class="rc-item" style="background-color: '+item.PROPERTY_BG_COLOR_VALUE+';'+bgi+'"><a href="'+item.URL+'" class="go-rc-btn" style="color: '+item.PROPERTY_BUTTON_FONT_COLOR_VALUE+';background-color: '+item.PROPERTY_BUTTON_COLOR_VALUE+';">'+item.NAME+'</a></div>');
                });
                $('.recommendation-container.recommendation-list .rc-nav li a').off().on('click',function(e){
                    $('.recommendation-container.recommendation-list .rc-nav li').removeClass('active');
                    $(this).parent().addClass('active');
                    e.preventDefault();
                    $('.recommendation-container.recommendation-list .recommendation-tab').hide();
                    $('.recommendation-container.recommendation-list .recommendation-tab[data-index="'+$(this).attr('data-index')+'"]').show();
                    return false;
                })
            }
        }

        if(!$('#basket').is(':visible')){
            $('.not-empty-basket').show()
            $('.empty-basket').hide();
        }
    }else{
        $('body').trigger('click');
        $('.basket-sum span').first().text(0);
        $('.empty-basket').show();
        $('.not-empty-basket').hide()
    }
    calcGifts(data.basket_sum_gift);
}
function calcGifts(sum){
    var percent = sum/window.limit3*100;
    $('.gift-sticky .grade').css('height',percent+'%');
    $('.grade-cont .gift-item').removeClass('active');

    var btn_showed = 0;
    $('.gift-sticky .gift-toggle').removeClass('active');
    clearInterval(window.giftToggleAnimateTimer);
    if(sum >= window.limit1){
        window.giftToggleAnimateTimer = setInterval(function(){
            $('.collapsed-gift .gift-toggle svg').addClass('animated infinite tada');
            setTimeout(function(){
                $('.collapsed-gift .gift-toggle svg').removeClass('animated infinite tada');
            },1000);
        },5000);
        $('.gift-sticky .gift-toggle').addClass('active');

        $('.grade-cont .gift-item.limit1').addClass('active').removeClass('not-animate');
        $('.grade-cont .gift-item.limit1 .get-gift').show();
        $('.grade-cont .gift-item.limit3 .get-gift').hide();
        $('.grade-cont .gift-item.limit2 .get-gift').hide();
    }else{
        $('.grade-cont .gift-item.limit1').addClass('not-animate');
        $('.grade-cont .gift-item.limit1 .get-gift').hide();
    }

    if(sum >= window.limit2){
        $('.grade-cont .gift-item.limit2').addClass('active').removeClass('not-animate');
        $('.grade-cont .gift-item.limit1').addClass('not-animate');
        $('.grade-cont .gift-item.limit2 .get-gift').show();
        $('.grade-cont .gift-item.limit1 .get-gift').hide();
        $('.grade-cont .gift-item.limit3 .get-gift').hide();
    }else{
        $('.grade-cont .gift-item.limit2').addClass('not-animate');
    }
    if(sum >= window.limit3){
        $('.grade-cont .gift-item.limit3').addClass('active').removeClass('not-animate');;
        $('.grade-cont .gift-item.limit2').addClass('not-animate');
        $('.grade-cont .gift-item.limit3 .get-gift').show();
        $('.grade-cont .gift-item.limit2 .get-gift').hide();
        $('.grade-cont .gift-item.limit1 .get-gift').hide();
    }else{
        $('.grade-cont .gift-item.limit3').addClass('not-animate');
    }

    if($('.product.gift').length){
        $('.product.gift').each(function(i,item){
            var limit = parseInt($(item).find('.gift-progress-info').data('limit'));
            var percent = sum/limit*100;

            if(limit > sum){
                $(item).find('.gift-progress-value').text(limit-sum);
                $(item).find('.progress-container .progress-bar').css('width',percent+'%');
                $(item).find('.gift-progress-info').show();
                $(item).find('.get-gift-btn').hide();
            }else{
                $(item).find('.gift-progress-info').hide();
                $(item).find('.get-gift-btn').show();
            }
        });
    }
    if(sum < window.limit1){
        var percent = parseInt(sum/window.limit1*100);

        $('.gift-progress').show().find('.progress-bar').css('width',percent+'%');
        animateNumbers($('.gift-progress .sum-to-gift span').first(),window.limit1-sum);

        $('.gift-progress-complete').hide();
    }
}
function registerControls(){

    if ($('.main-last-container .tabs-style-flip li').length > 0) {
        [].slice.call(document.querySelectorAll('.tabs')).forEach(function (el) {
            new CBPFWTabs(el);
        });
    }
    $('.bd-input input,.bd-input textarea').off('focus').on('focus',function(){


        if($(this).attr('name') == 'USER[PHONE]' || $(this).attr('name') == 'ORDER[USER_PHONE]'  || $(this).attr('name') == 'PHONE'){
            var focusText = $(this).val() || '+'+window.phone_code;
            $(this).val(focusText);
        }
        var $cont = $(this).parents('.bd-input');
        if ($(this).attr('readonly') == undefined)
            $cont.addClass('focused').removeClass('error ok');
        ;
        $cont.removeClass('filled');
        if($cont.closest('.input-row')){
            //$cont.closest('.input-row').css('margin-top',0);
        }
        if($cont.closest('.input-row-last')){
            //$cont.closest('.input-row-last').css('margin-top',0);
        }
    });
    $('.bd-input input,.bd-input textarea').off('blur').on('blur',function(){
        var $cont = $(this).parents('.bd-input');
        $cont.removeClass('focused');
        if($(this).val().trim().length>0){
            $cont.addClass('filled')
        }else{
            $cont.removeClass('filled');
        }
    });
    if($('.delivery-type-toggle').length>0){
        $('.delivery-type-toggle a').on('click',function(e){
            e.preventDefault();
            var type = parseInt($(this).data('type'));
            if (type == 2) {
                $('.payment-fields').hide();
                $('[name="ORDER[PAYMENT_TYPE]"]').first().parent().trigger('click');
                if($('[name="ORDER[DELIVERY_PICKUP_ID]"] option').length == 2){
                    $('[name="ORDER[DELIVERY_PICKUP_ID]"]').val($('[name="ORDER[DELIVERY_PICKUP_ID]"] option').last().attr('value')).trigger('change').selectOrDie('update')
                }
            } else {
                $('.payment-fields').show();
            }
            $('.delivery-type-toggle a').removeClass('active');
            $(this).addClass('active');
            $('.delivery-type-content > div').hide();
            $('[name="ORDER[DELIVERY_TYPE]"]').val($(this).data('type'));
            $('.delivery-type-tab-'+$(this).data('type')).show();
            $.ajax({
                type: 'post', 
                data: {TYPE: type},
                dataType: "json",
                url: '/bitrix/components/bd/checkout_pizza/component.php?action=checkPickupDiscount',
                success: function(data){
                    renderBasket();
                }
            });
        });
    }
    $("select").selectOrDie({placeholderOption:true});
    $('.scrollbar-macosx').scrollbar({"scrollx": false});
}
function resizeHandler(){

    if($('.bonuses-block').length > 0){
	    if($(window).width() < 1200){
		    $('.bonuses-block .bd-input label').css('font-size','12px');
		    $('.bonuses-block .col-xs-12').css('margin-top','90px');
		    $('.bonuses-block .title,.bonuses-block .value').css('left','31px');
	    }else{
		    $('.bonuses-block .bd-input label').css('font-size','14px');
		    $('.bonuses-block .col-xs-12').css('margin-top','0');
		    $('.bonuses-block .title,.bonuses-block .value').css('left','137px');
	    }
    }
    
    if($(window).width() < 992){
	    $('.order-content-cont').addClass('nopad');
	    $('.order-content-cont .checkout-title').addClass('linkify')
    }else{
	    $('.order-content-cont').removeClass('nopad');
	    $('.order-content-cont .checkout-title').removeClass('linkify')
    }
}
function getMenuWidth(){
    var totalWidth = 0;

    $('.menu-general li').each(function(index) {
        totalWidth += parseInt($(this).width(), 10);
    });

    return totalWidth;
}
function openPanel(tab){
    $('.constructor-panel').addClass('open');
    $('body').addClass('panel-opened');
    $('.constructor-panel .section').hide();
    $('.constructor-panel .'+tab).show();
}
function closePanel(){
    $('.constructor-panel').removeClass('open');
    $('body').removeClass('panel-opened');
}
function registerRemoveAddressHandlers(){
    $('.remove-address').off().on('click',function(e){
        e.preventDefault();
        var $addr_cont = $(this).closest('.address-item');
        $addr_cont.find('.to_delete').val(1);
        $addr_cont.hide();
        return false;
    })
}
function getProductDetail(id){
    $('#product-detail .spinner').show();
    $('#product-detail .product.product-detail').hide();
    $.ajax({
        type: 'post',
        data: {PRODUCT_ID: id},
        dataType: "json",
        url: '?action=getDetail',
        success: function(data){
            if (window.yaCounter != undefined && window.yaCounter != null) {
                window.dataLayer.push({
                    "ecommerce": {
                        "detail": {
                            "products": [
                                {
                                    "id": data.ID,
                                    "name": data.NAME,
                                    "price": parseInt(data.PRICE),
                                    "category": data.SECTION.NAME,
                                }
                            ]
                        }
                    }
                });
            }
	        $('#product-detail').css('top',$(window).scrollTop()+30+'px');
            $('#product-detail .product-actions .add-to-cart-btn').removeClass('retry').text(BX.message('add_basket'));
            if($('.add-to-cart-btn[data-id="'+id+'"]').hasClass('retry')){
                $('#product-detail .product-actions .add-to-cart-btn').addClass('retry').text(BX.message('get_more'));
            }
            $('#product-detail .product-actions .progress-container').hide();
            if(data.BUY_IT!==null && data.BUY_IT.length > 0){
                var delta = parseInt(data.BUY_IT) - parseInt(data.BUY_IT_COMPLETE || 0);
                if(delta < 0) delta = 0;

                var text = plural(delta,BX.message('remaind'),BX.message('remainded'),BX.message('remainded'))+' '+delta+' '+ plural(delta,BX.message('quan'),BX.message('quanti'),BX.message('quantitys'));
                $('#product-detail .product-actions').removeClass('with-progress').removeClass('progress-complete');
                $('#product-detail .product-actions').addClass('with-progress')
                if(parseInt(data.BUY_IT) - parseInt(data.BUY_IT_COMPLETE) <= 0){
                    $('#product-detail .product-actions').addClass('progress-complete')
                }
                $('#product-detail .product-actions .progress-container .progress-bar').css('width',(100-(data.BUY_IT_COMPLETE/data.BUY_IT*100))+'%');
                $('#product-detail .product-actions .progress-container .progress-bar-content div').text(text);
                $('#product-detail .product-actions .progress-container').show();
            }else{
                $('#product-detail .product-actions').removeClass('with-progress progress-complete');
            }
            if(data.NO_SALE != null){
                $('#product-detail .without-sale').show();
            }else{
                $('#product-detail .without-sale').hide();
            }
            $('#product-detail .product-labels').html('');
            if(data.BADGES.length > 0){
                $.each(data.BADGES,function(i,_item){
                    $('#product-detail .product-labels').append('<div title="'+_item.NAME+'" class="product-label" style="z-index: '+(data.BADGES.length-i)+';"><img src="'+_item.ICON+'"></div>');
                });
            }
            $('#product-detail .product,#product-detail .add-to-cart-btn').attr('data-id',data.ID);
            if(data.nutrients.protein!=null || data.nutrients.fats!=null || data.nutrients.carbo!=null || data.nutrients.energy!=null){
                for(index in data.nutrients){
                    if(data.nutrients[index]!=null){
                        $('#product-detail .meta-property.'+index).parent().show().find('.meta-value').text(data.nutrients[index]);
                    }else{
                        $('#product-detail .meta-property.'+index).parent().hide();
                    }
                }
                $('#product-detail .product-energy').show();
            }else{
                $('#product-detail .product-energy').hide();
            }

            $('#product-detail .preview .prod-image-l').attr('src',data.PREVIEW_PICTURE.SRC);
            $('#product-detail .product-info h3').html(data.NAME);
            $('#product-detail .like-content span').text(data.LIKE_COUNTER);
            if(data.DETAIL_TEXT!==null && data.DETAIL_TEXT.length > 0){
                $('#product-detail .product-info p').html(data.DETAIL_TEXT);
            }else{
                $('#product-detail .product-info p').html(data.PREVIEW_TEXT);
            }
            $('#product-detail .product-prices .current-price span').first().text(number_format(data.PRICE, (parseFloat(data.PRICE).toString().indexOf('.') == -1) ? 0 : 2, '.', ' '));
            if(data.OLD_PRICE!=null){
                $('#product-detail .product-prices .line-through').text(number_format(data.OLD_PRICE, (parseFloat(data.OLD_PRICE).toString().indexOf('.') == -1) ? 0 : 2, '.', ' ')).parent().show();
                $('._detail-price-cont').removeClass('base-price');
            }else{
                $('._detail-price-cont').addClass('base-price');
                $('#product-detail .product-prices .old-price').hide();
            }
            if(data.isLiked==1){
                $('#product-detail .likes').addClass('liked');
            }else{
                $('#product-detail .likes').removeClass('liked');
            }
            $('#product-detail .product-options').html('');
            if(data.BD_PROPS!=null){

	            var i_ = 0;
                $.each(data.BD_PROPS,function(key,item){
                    var content = '<div class="options-row-select"><select data-placeholder-option="true">';
                    var default_append = false;
                    $.each(item,function(skey,sitem){
                        if(!default_append){
                            content+= '<option value="null">'+key+'</option>';
                            default_append = true;
                        }
                        content+= '<option value="'+skey+'" data-price="'+sitem.PRICE+'" data-old-price="'+sitem.OLD_PRICE+'" data-weight="'+sitem.WEIGHT+'">'+sitem.VALUE+'</option>';
                    });
                    content +="</select></div>";
                    $('#product-detail .product-options').append(content);
                    i_++;
                });
            }
            $('#product-detail .product-options .options-row-select').addClass('col-xl-'+parseInt(12/i_));
            $('#product-detail').attr('data-unit',data.UNIT);
            $('#product-detail select').off().on('change',function(){
                var mode = $('#product-detail select').length;
                var $product = $(this).closest('#product-detail');
                var $prices = $(this).closest('#product-detail').find('.product-prices');
                new_price = parseInt($product.find('select').first().find('option:selected').data('price'));
                new_old_price = parseInt($product.find('select').first().find('option:selected').data('old-price'));
                new_weight = parseInt($product.find('select').first().find('option:selected').data('weight'));
                if(mode==2){
                    new_price += parseInt($product.find('select').last().find('option:selected').data('price'));
                    if(!isNaN(parseInt($product.find('select').last().find('option:selected').data('old-price'))))
                        new_old_price += parseInt($product.find('select').last().find('option:selected').data('old-price'));
                    new_weight += parseInt($product.find('select').last().find('option:selected').data('weight'));
                }
                if(!isNaN(new_price)){
                    $prices.find('.current-price span').first().text(number_format(new_price, 0, '.', ' '));
                }
                if(!isNaN(new_old_price)){
                    $product.find('._detail-price-cont').removeClass('base-price');
                    $prices.find('.old-price .line-through').text(number_format(new_old_price, 0, '.', ' ')).parent().show();
                }else{
                    $product.find('._detail-price-cont').addClass('base-price');
                    $product.find('.old-price').hide();
                }
                if(!isNaN(new_weight)){
                    $prices.find('.weight span').first().text(new_weight);
                    $prices.find('.weight span').last().text(' '+$('#product-detail').attr('data-unit'));
                }

            });
            $('#product-detail .product-options select').selectOrDie();
            if(data.G!==null){
                $('#product-detail .product-prices .weight span').first().text(data.G);
                $('#product-detail .product-prices .weight span').last().text(' '+data.UNIT);
            }else{
                $('#product-detail .product-prices .weight span').first().text('');
                $('#product-detail .product-prices .weight span').last().text(' ');
            }

            registerLikes();
            setTimeout(function(){
                $('#product-detail .spinner').hide();
                $('#product-detail .product.product-detail').show();
            },500);
        }
    });
}
function changeIngredientAmount(id, type) {
    var new_val = $('input[name="ING_AMOUNT[' + window.edit_ingredient + ']"]').val()

    if (type == 0)
        new_val--;
    else
        new_val++;
    if (new_val <= 0)
        new_val = 1

    $('#popover-constructor-change-amount-' + window.edit_ingredient).find('input[type="text"]').val(new_val)
    $('input[name="ING_AMOUNT[' + window.edit_ingredient + ']"]').val(new_val)
    calculateConstructor();
}
function calculateConstructor(){
    $.ajax({
        type: 'post',
        data: $('#constructor_form').serialize(),
        dataType: "json",
        url: '/bitrix/components/bd/constructor_pizza/component.php?action=calculateConstructor',
        success: function(data){
            validateConstructor();
            if (data.BASE != undefined) {
                var has_base = true;
                var base_html = '<div class="row constructor-ingredient-basket-item exclude __base-item" data-id="' + data.BASE.ID + '" data-auto="false">' +
                    '<div class="col-xs-9 name-cont"><div class="name">' + data.BASE.NAME + '</div><div class="category">' + data.BASE.TYPE + '</div></div> ' +

                    '<div class="col-xs-3 text-xs-right nopad">' +
                    '<div class="product-sum"><span>' + data.BASE.PRICE + '</span><span class="currency">' + window.currencyFont + '</span></div>' +
                    '<div class="weight"><span>' + data.BASE.GRAMM + '</span> ' + BX.message('gramm') + '</div>' +
                    '</div> ' +
                    '</div>';
                if ($('.constructor-ingredient-basket-item').length == 0) {
                    $('.ingredients-list').append(base_html)
                } else {
                    $('.constructor-ingredient-basket-item.__base-item').remove();
                    $('.constructor-ingredient-basket-item').first().before(base_html)
                }
            } else {
                var has_base = false;
            }
            if (data.SOUSE != undefined) {
                var has_souse = true;
                var souse_html = '<div class="row constructor-ingredient-basket-item exclude __souse-item" data-id="' + data.SOUSE.ID + '" data-auto="false">' +
                    '<div class="col-xs-9 name-cont"><div class="name">' + data.SOUSE.NAME + '</div><div class="category">' + data.SOUSE.TYPE + '</div></div> ' +

                    '<div class="col-xs-3 text-xs-right nopad">' +
                    '<div class="product-sum"><span>' + data.SOUSE.PRICE + '</span><span class="currency">' + window.currencyFont + '</span></div>' +
                    '<div class="weight"><span>' + data.SOUSE.GRAMM + '</span> ' + BX.message('gramm') + '</div>' +
                    '</div> ' +
                    '</div>';
                if ($('.constructor-ingredient-basket-item').length == 0) {
                    $('.ingredients-list').append(souse_html)
                } else {
                    $('.constructor-ingredient-basket-item.__souse-item').remove();
                    if ($('.constructor-ingredient-basket-item.__base-item').length == 0) {
                        $('.constructor-ingredient-basket-item').first().before(souse_html)
                    } else {
                        $('.constructor-ingredient-basket-item.__base-item').after(souse_html);
                    }
                }
            } else {
                var has_souse = false;
            }
            if (!has_base || !has_souse) {
                $('.ingrs-cont.empty .constructor-base-error').show();
                if (has_souse) {
                    $('.wok_error_souse').hide();
                    $('.wok_error_and').hide();
                }
                if (has_base) {
                    $('.wok_error_base').hide();
                    $('.wok_error_and').hide();
                }
            }
            if (has_base && has_souse) {
                $('.constructor-base-error').hide()
            }
            if(data.INGREDIENTS!=null){
                $('.constructor-ingredient-basket-item').not('.exclude').each(function (j, jitem) {
                    var none = true;
                    $.each(data.INGREDIENTS, function (i, item) {
                        if (item.ID == $(jitem).data('id')) {
                            none = false
                            $(jitem).find('.product-sum span').first().text(item.LOCAL_PRICE)
                            $(jitem).find('.weight span').first().text(item.GRAMM)
                        }
                    })
                    if (none && item.ID !=='base' && item.ID!=='souse')
                        $('.constructor-ingredient-basket-item[data-id="' + item.ID + '"]').remove();
                });

                $.each(data.INGREDIENTS, function (i, item) {
                    if ($('input[name="INGREDIENTS[]"][value="' + item.ID + '"]').length == 0) {
                        $('#constructor_form').append('<input type="hidden" name="INGREDIENTS[]" value="' + item.ID + '">');
                        $('.ingredient-item[data-id="' + item.ID + '"]').addClass('active');
                    }
                    if ($('.constructor-ingredient-basket-item[data-id="' + item.ID + '"]').length == 0)
                        $.tmpl("constructorIngredientBasketTemplate", item).appendTo(".ingredients-list");

                });

                var onS = function (e) {
                    window.edit_ingredient = $(this)[0].id_.split('-')[3];

                    if ($('#popover-constructor-change-amount-' + window.edit_ingredient).length > 1) {
                        $('#popover-constructor-change-amount-' + window.edit_ingredient).not(':last').remove();
                    }
                    $('#popover-constructor-change-amount-' + window.edit_ingredient).find('.ingredient-name').text($('.constructor-ingredient-basket-item[data-id="' + window.edit_ingredient + '"]').find('.name').text());

                    $('#popover-constructor-change-amount-' + window.edit_ingredient).find('input[type="text"]').val($('input[name="ING_AMOUNT[' + window.edit_ingredient + ']"]').val());
                }
                $('.constructor-ingredient-basket-item').not('.exclude').each(function () {
                    $('.constructor-ingredient-basket-item[data-id="' + $(this).attr('data-id') + '"]').webuiPopover({
                        trigger: 'hover',
                        placement: 'left',
                        id_: "constructor-change-amount-" + $(this).attr('data-id'),
                        id: "constructor-change-amount-" + $(this).attr('data-id'),
                        url: '#constructor-change-amount',
                        cache: false,
                        onShow: onS,
                        animation: 'fade'
                    });
                })
                registerIngredientChangeAmountListener();
            }
            if(parseInt(data.SUM)){
                $('.clear-constructor').show();
                $('.ingrs-cont').removeClass('empty');
            } else {
                $('.ingrs-cont').addClass('empty');
                $('.constructor-base-error').hide()
            }
            $('.constructor-summary .sum-value span.constructor-summary-value').text(data.SUM);
            $('.constructor-summary .weight span.constructor-summary-value').text(data.WEIGHT);
            $('#constructor_form input[name="PRICE"]').val(data.SUM);
            $('#constructor_form input[name="WEIGHT"]').val(data.WEIGHT);
        }
    });
}
function registerIngredientChangeAmountListener(){
    $('.constructor-ingredient-basket-item .change-cons-amount-btn').off().on('click', function (e) {
        e.preventDefault();
        var $basket_item = $(this).closest('.constructor-ingredient-basket-item');
        var current_val = $basket_item.find('.buttons').find('input[type="hidden"]').val();
        var new_val = parseInt(current_val);
        if($(this).hasClass('plus')){
            new_val++;
        }else{
            new_val--;
        }
        if(new_val==0)
            new_val = 1;

        $basket_item.find('.buttons').find('input[type="hidden"]').val(new_val)
        calculateConstructor();
        return false;
    });
    $('.constructor-ingredient-basket-item .remove-basket-item a').off().on('click',function(e){
        removeFromConstructor($(this).parent().data('id'));
        return false;
    });
}
function registerLikes(){
    if($('.likes').length){
        $('.likes').off().on('click',function(e){
            e.preventDefault();
            var $cont = $(this).closest('.preview');
            if($cont.length == 0){
                $cont = $(this);
            }
            if(window.user_id!=0){
                if($(this).hasClass('liked')){
	                $(this).removeClass('liked');
	            }else{
	                $(this).addClass('liked');
	            }
            }
            var product_id = $(this).closest('.product').attr('data-id');
            if(product_id == undefined){
                product_id = $(this).attr('data-id');
            }

            $.ajax({
                type: 'post',
                data: {'PRODUCT_ID': product_id},
                dataType: "json",
                url: '?action=likeItem',
                success: function(data){
                    $cont.find('.like-content span').text(data);
                }
            });
            return false;
        })
    }
}
function removeFromConstructor(id){
    var id = window.edit_ingredient;
    if($('.constructor-ingredient-basket-item[data-id="'+id+'"]').attr('data-auto') == 'true'){
        $('#constructor_form').append('<input type="hidden" name="EXCLUDE_AUTO[]" value="'+id+'" />');
    }
    $('input[name="INGREDIENTS[]"][value="'+id+'"]').remove();
    $('.constructor-ingredient-basket-item[data-id="'+id+'"]').remove();
    $('.ingredient-item[data-id="'+id+'"]').removeClass('active');
    $('#popover-constructor-change-amount-' + id).remove()
    calculateConstructor();
    return false;
}
function validateConstructor(){
    if(
        $('[name="BASE_ID"]').val().trim().length > 0 &&
        $('[name="SOUSE_ID"]').val().trim().length > 0
    ){
        $('.add-to-cart-constructor').removeAttr('disabled');
        return true;
    }else{
        $('.add-to-cart-constructor').attr('disabled','disabled');
        return false;
    }
}
function registerProductListeners(){
    if(window.user_id == 0 && $('.likes').length > 0){
        $('.likes').addClass('guest-likes');
    }
    $('.information-col .apply-view').off().on('click',function (e) {
        e.preventDefault();
        var options = {};
        if($('.product-info-cont .constructor-view .product-scroll-content .product-options select').length==1){
            options.OPTION_1 = $('.product-info-cont .constructor-view .product-scroll-content .product-options select').first().val();
        }
        if($('.product-info-cont .constructor-view .product-scroll-content .product-options select').length==2){
            options.OPTION_1 = $('.product-info-cont .constructor-view .product-scroll-content .product-options select').first().val();
            options.OPTION_2 = $('.product-info-cont .constructor-view .product-scroll-content .product-options select').last().val();
        }
        $.ajax({
            type: 'post',
            data: {'PRODUCT_ID': $('.product-info-cont .constructor-view .name').attr('data-id'), 'OPTIONS': options},
            dataType: "json",
            url: '/bitrix/components/bd/basket_pizza/component.php?action=updateOptions',
            success: function(data){
                $('.information-col .close-view').trigger('click');
                renderBasket();
            }
        });
        return false;
    })
    $('.product input').off().on('change', function () {
        var $product = $(this).closest('.product');
        var $prices = $(this).closest('.product').find('.product-prices');
        var mode = 1;
        if($(this).closest('.options-row-select').hasClass('options-length-2')){
            mode = 2;
        }
        var new_price, new_old_price, new_weight;


        new_price = parseFloat($product.find('[name="OPTION_1"]:checked').data('price'));
        new_old_price = parseFloat($product.find('[name="OPTION_1"]:checked').data('old-price'));
        new_weight = parseFloat($product.find('[name="OPTION_1"]:checked').data('weight'));

        if(mode==2){
            new_price += parseFloat($product.find('[name="OPTION_2"]:checked').data('price'));
            if (!isNaN(parseFloat($product.find('[name="OPTION_2"]:checked').data('old-price'))))
                new_old_price += parseFloat($product.find('[name="OPTION_2"]:checked').data('old-price'));
            new_weight += parseFloat($product.find('[name="OPTION_2"]:checked').data('weight'));
        }

        if(!isNaN(new_price)){
            animateNumbers($prices.find('.current-price span').first(), new_price)
        }
        if(!isNaN(new_old_price)){
            $product.find('.product-footer').removeClass('base-price');
            animateNumbers($prices.find('.old-price .line-through'), new_old_price)
            $prices.find('.old-price .line-through').parent().show();
        }else{
            $product.find('.product-footer').addClass('base-price');
            $prices.find('.old-price').hide();
        }

        if(!isNaN(new_weight)){
            animateNumbers($prices.find('.weight').find('span').first(), new_weight);
        }
        $(this).selectOrDie('update');

    });
    $('.preview').on('click',function(e){
        if($(this).closest('#product-detail').length == 0){
            e.preventDefault();
            var pid = $(this).closest('.product').data('id');
            getProductDetail(pid);
        }
    });
    $('.product-back').off().on('click', function () {
        var $self = $(this);
        $self.closest('.product').find('.add-to-cart-btn').addClass('choose_options').text($self.closest('.product').data('choose-label'));
        $self.closest('.product').removeClass('choose_option_state');
        $self.closest('.product').find('.product-options').addClass('animated slideOutRight').delay(1000).hide();
        $self.closest('.product').find('.base-view').show().addClass('animated slideInLeft');
        setTimeout(function () {
            $self.closest('.product').find('.base-view').removeClass('animated slideOutRight slideInLeft');
            $self.closest('.product').find('.product-options').removeClass('animated slideInLeft slideOutRight');
        }, 400)
        return false;
    });

    $('.product-actions .add-to-cart-btn').off().on('click',function(e){
        var $self = $(this);


        if(ga!=undefined){
            ga('send', 'event', 'basket', 'add');
        }

        if ($(this).hasClass('choose_options')) {
            $(this).removeClass('choose_options').text(BX.message('add_basket'));
            $self.closest('.product').addClass('choose_option_state');
            $self.closest('.product').find('.base-view').addClass('animated slideOutLeft').delay(1000).hide();
            $self.closest('.product').find('.product-options').show().addClass('animated slideInRight');
            setTimeout(function () {
                $self.closest('.product').find('.base-view').removeClass('animated slideOutLeft');
                $self.closest('.product').find('.product-options').removeClass('animated slideInRight');
            }, 400)
            return false;

        }

        $('.basket-btn').webuiPopover('hide');
        e.preventDefault();

        var options = {};
        if ($self.closest('.product').find('.options-row-select').length == 1) {
            options.OPTION_1 = $self.closest('.product').find('[name="OPTION_1"]:checked').val();
        }
        if ($self.closest('.product').find('.options-row-select').length == 2) {
            options.OPTION_1 = $self.closest('.product').find('[name="OPTION_1"]:checked').val();
            options.OPTION_2 = $self.closest('.product').find('[name="OPTION_2"]:checked').val();
        }
        var $prod = $self.closest('.product');
        if (window.yaCounter != undefined && window.yaCounter != null) {
            yaCounter.reachGoal('add-to-basket', {});
            window.dataLayer.push({
                "ecommerce": {
                    "add": {
                        "products": [
                            {
                                "id": $prod.data('id'),
                                "name": $prod.find('.product-title .name').text(),
                                "price": $prod.find('span[itemprop="price"]').text().replace(' ', ''),
                                "quantity": 1
                            }
                        ]
                    }
                }
            });

        }
        if(validateProperties($prod)){
            var imgtodrag = $prod.find('.preview img').last().eq(0);
            var cart = $('.basket-btn-container');
            if (imgtodrag) {
                var imgclone = imgtodrag.clone()
                    .css({
                        'opacity': '1',
                        'position': 'absolute',
                        'z-index': '100',
                        'visibility': 'visible',
                        'display': 'block',
                        'border-radius':'50%',
                        'top': $prod.offset().top,
                        'left': $prod.offset().left,
                        'width': '300px'
                    })
                    .appendTo('body')
                    .animate({
                        'top': cart.offset().top,
                        'left': cart.offset().left+100,
                        'width': '50px'
                    }, 1000);

                imgclone.fadeOut('fast', function () {
                    $(this).detach()
                });
            }
            $.ajax({
                type: 'post',
                data: {'PRODUCT_ID': $self.data('id'),options:options},
                dataType: "json",
                url: '/bitrix/components/bd/basket_pizza/component.php?action=addToBasket',
                success: function(data){


                    renderSummary(data);
                }
            });
            $('.product[data-id="'+$self.data('id')+'"]').find('.add-to-cart-btn').addClass('retry').text(BX.message('get_more'));
            $self.closest('.product').find('.product-back').trigger('click');
            if(!$self.hasClass('retry'))
                $self.addClass('retry').text(BX.message('get_more'));
        }
        return false;
    });
}
function animateNumbers(elem,new_val){

    var cad = (parseFloat(new_val).toString().indexOf('.') == -1) ? 0 : 2;
    $({val_i: $(elem).text().split(' ').join('')}).animate({val_i: new_val}, {
        duration: 500,
        easing: 'swing',
        step: function () {
            $(elem).text(number_format(this.val_i, cad, '.', ' '));
        },
        complete: function () {
            $(elem).text(number_format(new_val, cad, '.', ' '));
        }
    })
}
function number_format( number, decimals, dec_point, thousands_sep ) {

    var i, j, kw, kd, km;
    if( isNaN(decimals = Math.abs(decimals)) ){
        decimals = 2;
    }
    if( dec_point == undefined ){
        dec_point = ",";
    }
    if( thousands_sep == undefined ){
        thousands_sep = ".";
    }

    i = parseInt(number = (+number || 0).toFixed(decimals)) + "";

    kw = i.split( /(?=(?:\d{3})+$)/ ).join( thousands_sep );
    kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).replace(/-/, 0).slice(2) : "");


    return kw + kd;
}
function validateProperties(product){
    var valid = [];
    if (product.find('.options-row-select').length) {
        product.find('.options-row-select').each(function (i, item) {

            if ($('[name="OPTION_' + (i + 1) + '"]:checked').val() == undefined) {
                valid.push(false);
                /* $(item).closest('.sod_select').addClass('error_ shake');
                 setTimeout(function(){
                     $(item).closest('.sod_select').removeClass('shake');
                 },1500);*/
            }else{
                valid.push(true)
                // $(item).closest('.sod_select').removeClass('error_ shake');
            }
        });
    }else{
        valid.push(true)
    }

    if(valid.indexOf(false)!==-1){
        return false;
    }else{
        return true;
    }
}
function checkPromoAjax(){
    var $input = $('.basket-promo-code');
    var code_ = $input.val();
    $.ajax({
        type: 'post',
        data: {CODE: code_},
        dataType: "json",
        url: '/bitrix/components/bd/basket_pizza/component.php?action=checkPromo',
        success: function(data){
            if(data.status==1){
                $input.closest('.bd-input').removeClass('error').addClass('ok');
            }
            if(data.status==0){
                $input.closest('.bd-input').removeClass('ok').addClass('error');
            }
            renderBasket();
            if($('select[name="ORDER[DISTRICT_ID]"]').length){
                $('select[name="ORDER[DISTRICT_ID]"]').trigger('change');
            }
        }
    });
}

function registerAddressListeners() {
    $('.address_private input[type="checkbox"]').off().on('change', function (e) {
        if ($(this).is(':checked')) {
            $(this).closest('.address-item').find('.not_private_house_fields').hide();
        } else {
            $(this).closest('.address-item').find('.not_private_house_fields').show();
        }
    })
}
function processPreloadImages(){
    $('.progressiveLoad').each(function(i,item){
        var image = new Image();
        var $self = $(item);
        image.onload = function(){
            $self.attr('srcset', this.src);
            $self.removeClass('progressiveLoad');
            $self.parent().prepend($self.closest('.product').find('.image-tmp').html());
            $self.closest('.product').find('.image-tmp').remove();
            $self.removeAttr('style');
        };
        image.src = $self.data('full');
    });
    if($('.index-sections-list').length){
        $('.index-sections-list__item').each(function(i, item){
            var image = new Image();

            var $self = $(item);

            image.onload = function(){
                $self.css('background-image', 'url('+this.src+')');
                $self.find('.section-bg').css('opacity',0);
                setTimeout(function(){
                    $self.find('.section-bg').remove()
                },300)

            };

            image.src = $self.data('bg');
        })
    }
}
$(document).ready(function(){
    $('body').on('keyup',function(e){
        if(e.keyCode === 13)
            e.preventDefault()
    });
    processPreloadImages();
    registerAddressListeners();
    var nav = priorityNav.init({
        navDropdownLabel: BX.message('menu_more'),
        mainNavWrapper: '.product-categories-container  nav',
        breakPoint: 10
    });
    if ($('.news-masonry .news-list').length) {
        window.msnry = new Masonry('.news-masonry .news-list', {itemSelector: '.news-masonry article'});
    }
    if ($('.category-masonry').length) {
        window.msnry = new Masonry('.category-masonry', {itemSelector: '.category-masonry .category-view-item'});
    }

    $('.edit-address').on('click', function (e) {
        e.preventDefault();
        $(this).closest('.address-item').addClass('opened');
        $(this).closest('.address-item').find('input').removeAttr('readonly')
        return false;
    })

	$('.order-content-cont .checkout-title').on('click',function(e){
		if($(this).hasClass('linkify')){
			$('.order-content-cont .order-content').toggleClass('hidden-md-down' );
		}
	})
	
	var clipboard = new Clipboard('.user-info-element .promo,#gift-info .promo');
    clipboard.on('success', function(e) {
        $(e.trigger).addClass('copied');
    });


    $('[name="ORDER[ODD_MONEY]"]').on('keypress',function(e){
      if (e.which < 48 || e.which > 57)
      {
          e.preventDefault();
      }
    });


    $('[name="PRIVATE_HOUSE"]').on('change',function(e){
	    if($(this).is(':checked')){
		    $('.not_private_house_fields').hide();
	    }else{
		    $('.not_private_house_fields').show();
	    }
    })

    registerProductListeners();

    if($('body').hasClass('fixed-header')){
        $(window).on('scroll',function(){
           if($(this).scrollTop() > 75){
               $('.product-categories-container').addClass('fixed');
               $('.top-line').css('margin-bottom','60px');
           }else{
               $('.product-categories-container').removeClass('fixed');
               $('.top-line').css('margin-bottom','0');
           }
        });
    }
    sbjs.init();
    $.cookie('t_source', sbjs.get.current.typ+'|'+sbjs.get.current.src,{path: '/'});
	//$('.order-detail-btn').webuiPopover({animation: 'fade'});

    var ua = navigator.userAgent.toLowerCase();
	var isAndroid = ua.indexOf("android") > -1;
	if(!isAndroid){
    	$('input[name="PHONE"],input[name="USER[PHONE]"],input[name="ORDER[USER_PHONE]"]').mask(window.phone_mask,{placeholder:" "});
    }else{
	    var country_code = window.phone_mask.replace(RegExp(' ','g'), '').replace('(','').replace(')', '').replace(new RegExp('9','g'),'').replace(new RegExp('-','g'),'');
	    var cleared_mask_length = window.phone_mask.replace(RegExp(' ','g'), '').replace('(','').replace(')', '').replace(new RegExp('-','g'),'').length;

	    $('input[name="PHONE"],input[name="USER[PHONE]"],input[name="ORDER[USER_PHONE]"]').each(function(){
		    if($(this).val().length){
			    $(this).val('+'+$(this).val())
		    }else{
				$(this).val(country_code);
			}
	    })
		$('input[name="PHONE"],input[name="USER[PHONE]"],input[name="ORDER[USER_PHONE]"]').attr('maxlength',cleared_mask_length);
	    $('input[name="PHONE"],input[name="USER[PHONE]"],input[name="ORDER[USER_PHONE]"]').on('keyup',function(){
		    if($(this).val().indexOf(country_code)){
			    $(this).val(country_code);
		    }
	    });
    }
    if(isAndroid){
		$('input[name="ORDER[DELIVERY_TIME]"],input[name="ORDER[DELIVERY_TIME_2]"]').off('keyup').on('keyup',function(){
	        var parsed_time = $(this).val().split(':');
			if($(this).val().length==2){
				$(this).val($(this).val()+':')
			}
	        if(parseInt(parsed_time[0])>23)
	            parsed_time[0] = 23;

	        if(parseInt(parsed_time[1])>59)
	            parsed_time[1] = 59;

//	        $(this).val(parsed_time[0]+':'+parsed_time[1]);

	    });
	}else{
		$('input[name="ORDER[DELIVERY_TIME]"],input[name="ORDER[DELIVERY_TIME_2]"]').mask("99:99",{placeholder:" "});
	}
	if(!isAndroid)
	    $('.delivery_time').mask('99:99');
    $('input[name="USER[BIRTHDAY]"]').mask("99.99.9999",{placeholder:" "});
    if ($('.product-banner-slider').length) {
        var $carousel_b = $('.product-banner-slider').flickity({
            cellAlign: 'center',
            contain: true,
            autoPlay: 3000,
            percentPosition: false,
        });
        var flkty_b = $carousel_b.data('flickity');
        $($('.product-banner-slider .flickity-page-dots .dot')[flkty_b.selectedIndex]).addClass('completed');

        $carousel_b.on('select.flickity', function () {
            $('.product-banner-slider .flickity-page-dots .dot').removeClass('completed');

            $($('.product-banner-slider .flickity-page-dots .dot')[flkty_b.selectedIndex]).addClass('completed');
        });
    }
    if($('.carousel').length){
        var $carousel = $('.carousel').flickity({
            cellAlign: 'center',
            contain: true,
            autoPlay: 3000,
            percentPosition: false,
        });
        $('.bd-slider').css('opacity','1');
        $('.slider-container .spinner').hide();
        setTimeout(function(){
            $('.slider-container').removeClass('slider-height-fix');
        },500);
        var flkty = $carousel.data('flickity');
        $($('.carousel .flickity-page-dots .dot')[flkty.selectedIndex]).addClass('completed');

        $carousel.on('select.flickity', function() {
            $('.carousel .flickity-page-dots .dot').removeClass('completed');

            $($('.carousel .flickity-page-dots .dot')[flkty.selectedIndex]).addClass('completed');
        });
    }
    $('.related-product a').on('click',function(e){
        e.preventDefault();

        getProductDetail(parseInt($(this).attr('data-id')));

        return false;
    })
    $(".fancybox").fancybox({
        openEffect	: 'none',
        closeEffect	: 'none'
    });
    resizeHandler();
    if($('select[name="ORDER[DISTRICT_ID]"]').length){

        $('select[name="ORDER[DISTRICT_ID]"]').on('change', function () {

                var $self = $(this);
                $.ajax({
                    type: 'post',
                    data: {ID: $self.val()},
                    dataType: "json",
                    url: '/bitrix/components/bd/checkout_pizza/component.php?action=calculateDelivery',
                    success: function(data){
                        $('.delivery-price').show();
                        if(data.DELIVERY_PRICE>0){
                            $('.delivery-price').removeClass('is_free');
                            $('.summary-label.delivery-sum .meta-value_ span').first().text(data.DELIVERY_PRICE).closest('.summary-label.delivery-sum').show();
                            $('._delivery-price-value span').first().text(data.DELIVERY_PRICE).parent().show().find('.currency').show();

                            $('.delivery-price  .progress-container').show();
                            $('.delivery-price .progress-container .progress-bar').css('width',data.BASKET_SUM/data.FREE_DELIVERY*100+'%');
                            $('.delivery-price .progress-container .progress-bar-content').find('span').first().text(number_format(data.FREE_DELIVERY - data.BASKET_SUM,(parseFloat(data.FREE_DELIVERY - data.BASKET_SUM).toString().indexOf('.') == -1) ? 0 : 2, '.', ' '))
                        }else{
                            $('.delivery-price').addClass('is_free');
                            $('.summary-label.delivery-sum').hide();
                            $('._delivery-price-value').hide();
                            $('.delivery-price  .progress-container').hide();
                            $('._delivery-price-value span').first().text($('.delivery-price').attr('data-free')).parent().show().find('.currency').hide();
                        }
                        renderBasket();
                    }
                });
        })
    }
    if($('select[name="ORDER[DELIVERY_PICKUP_ID]"]').length){
        $('select[name="ORDER[DELIVERY_PICKUP_ID]"]').on('change',function(){
            if(!$('body').hasClass('country-ua')) {
                $('.map-row').show();
                myMap.setCenter(window['myPlacemark_' + $(this).val()].geometry.getCoordinates(), 16, {duration: 1000})
            }
        })
    }
    if($('[name="ORDER[PAYMENT_TYPE]"]').length){
        $('[name="ORDER[PAYMENT_TYPE]"]').on('change',function(){
            $('[name="ORDER[PAY_IDENT]"]').val($(this).data('type'));
            if($(this).data('change')=='Y'){
                $('._change_row').show();
            }else{
                $('._change_row').hide();
            }
            if($(this).data('type')=='offline'){
                $('.send-order').text(BX.message('submit_order'));
            }else{
                $('.send-order').text(BX.message('pay_order'));
            }
        })
    }
    if($('input[name="ORDER[DISCOUNT_BONUSES]"]').length){
        $('input[name="ORDER[DISCOUNT_BONUSES]"]').on('change',function(){

            var $self = $(this);
            $self.val(number_format($self.val(),2,'.',''));
            $.ajax({
                type: 'post',
                data: {AMOUNT: $self.val()},
                dataType: "json",
                url: '/bitrix/components/bd/checkout_pizza/component.php?action=calculateBonuses',
                success: function(data){
                    $('input[name="ORDER[DISCOUNT_BONUSES]"]').val(data.status);
                    if(data.status > 0){
                      $('.summary-label.user-bonus-sum .meta-value_ span').first().text(data.status).closest('.summary-label.user-bonus-sum').show()
                    }else{
                      $('.summary-label.user-bonus-sum').hide();
                    }
                    renderBasket();
                }
            });
        });
    }
    $('.basket-promo-code').on('keyup',function(e){
        if(e.keyCode==13){
            checkPromoAjax();
        }
    })
    $('.apply-code-btn').on('click',function(e){
        checkPromoAjax();
        return false;
    })
    $('#constructor_form').on('submit',function(e){
        e.preventDefault();
        if(validateConstructor()){
            $.ajax({
                type: 'post',
                data: $('#constructor_form').serialize(),
                dataType: "json",
                url: '/bitrix/components/bd/basket_pizza/component.php?action=addToBasket',
                success: function(data){
                    renderSummary(data);
                    $('.clear-constructor').trigger('click');
                    var imgtodrag = $('.preset-image-big img').eq(0);
                    var cart = $('.basket-btn');
                    if (imgtodrag && $('.preset-image-big img').offset()!==undefined) {
                        var imgclone = imgtodrag.clone()
                            .css({
                                'opacity': '1',
                                'position': 'absolute',
                                'z-index': '100',
                                'visibility': 'visible',
                                'display': 'block',
                                'top': $('.preset-image-big img').offset().top,
                                'left': $('.preset-image-big img').offset().left,
                                'width': '300px'
                            })
                            .appendTo('body')
                            .animate({
                                'top': cart.offset().top,
                                'left': cart.offset().left+50,
                                'width': '50px'
                            }, 1000);

                        imgclone.fadeOut('fast', function () {
                            $(this).detach()
                        });
                    }
                }
            });
        }
    });
    $('.clear-constructor').on('click',function(e){
        e.preventDefault();
        $(this).hide();
        $('.preset-item').removeClass('active');
        $('input[name="INGREDIENTS[]"]').remove();
        $('input[name="EXCLUDE_AUTO[]"]').remove();
        $('.constructor-ingredient-basket-item').remove();
        $('.constructor-item').removeClass('active');
        $('.ingredient-item').removeClass('active');
        $('input[name="BASE_ID"]').val('');
        $('input[name="SOUSE_ID"]').val('');
        $('input[name="WEIGHT"]').val('');
        $('input[name="PRICE"]').val('');
        $('input[name="IMAGE"]').val(window.template_path+'/images/constructor-image.jpg');
        $('input[name="NAME"]').val(BX.message('wok_js_box'));
        $('.preset-image-big img').attr('src',window.template_path+'/images/constructor-image.jpg');
        calculateConstructor();
        return false;
    });
    $('.ingredient-item').on('click',function(e){
        if (!$(this).hasClass('active')) {
            $(this).addClass('active');
            if($('input[name="INGREDIENTS[]"][value="'+$(this).data('id')+'"]').length == 0){
            	$('#constructor_form').append('<input type="hidden" name="INGREDIENTS[]" value="'+$(this).data('id')+'"/>');

            }
            if($('[name="EXCLUDE_AUTO[]"][value="'+$(this).data('id')+'"]')){
		            $('[name="EXCLUDE_AUTO[]"][value="'+$(this).data('id')+'"]').remove();
	            }

            calculateConstructor();
        } else {
            $(this).removeClass('active');
            removeFromConstructor($(this).data('id'));
        }
    });

    var constructorIngredientBasketTemplate = '<div class="row constructor-ingredient-basket-item" data-id="${ID}" data-auto="${IS_AUTO}">' +
        '<div class="col-xs-9 name-cont"><div class="name">${NAME}</div><div class="category">${SECTION}</div></div> ' +
        '<div class="col-xs-2 buttons" style="display: none;">' +
        '<input type="hidden" name="ING_AMOUNT[${ID}]" value="${AMOUNT}"/>' +
        '<a href="#" class="change-amount-btn minus">-</a><span class="amount">${AMOUNT}</span>' +
        '<input type="hidden"><a href="#" class="change-amount-btn plus">+</a>' +
    '</div> ' +
        '<div class="col-xs-3 text-xs-right nopad">' +
        '<div class="product-sum"><span>${LOCAL_PRICE}</span><span class="currency">' + window.currencyFont + '</span></div>' +
        '<div class="weight"><span>${GRAMM}</span> ' + BX.message('gramm') + '</div>' +
        '</div> ' +
        '<div style="display: none;" class="col-xs-1 text-xs-left remove-basket-item" data-id="${ID}"><a href="#"> ' +
        '<svg viewBox="0 0 38.0919 40.5429"><path class="cls-1" d="M35.1491,39.3951V60.8883a6.2561,6.2561,0,0,0,6.2366,6.2366H59.81a6.2549,6.2549,0,0,0,6.2366-6.2366V39.3951H35.1491ZM57.8477,31.016c-0.5913-5.912-13.9111-5.912-14.5019,0H33.838a2.2942,2.2942,0,0,0-2.2875,2.2868h0A2.2939,2.2939,0,0,0,33.838,35.59H67.3556a2.2938,2.2938,0,0,0,2.2868-2.2875h0a2.2941,2.2941,0,0,0-2.2868-2.2868h-9.508ZM43.9426,60.6523c-0.8815,0-1.5868-.3957-1.5868-0.89V45.9838c0-.4947.7053-0.8907,1.5868-0.8907s1.587,0.396,1.587.8907v13.778c0,0.4947-.7053.89-1.587,0.89h0Zm6.6539,0c-0.8817,0-1.587-.3957-1.587-0.89V45.9838c0-.4947.7053-0.8907,1.587-0.8907s1.5868,0.396,1.5868.8907v13.778c0,0.4947-.7053.89-1.5868,0.89h0Zm6.6551,0c-0.8817,0-1.587-.3957-1.587-0.89V45.9838c0-.4947.7053-0.8907,1.587-0.8907s1.5868,0.396,1.5868.8907v13.778C58.8383,60.2565,58.133,60.6523,57.2515,60.6523Z" transform="translate(-31.5505 -26.5819)"/></svg></a></div> ' +
        '</div>';
    $.template( "constructorIngredientBasketTemplate", constructorIngredientBasketTemplate );
    $('.constructor_cats_select').on('change',function(){
        $('.ingredient-item').hide();
        $('.ingredient-item[data-section="'+$(this).val()+'"]').show();
    });
    $('.checkout-user-addresses').on('change',function(e){
        $('[name="ORDER[DISTRICT_ID]"]').val($(this).find('option:selected').data('district')).trigger('change').selectOrDie("update");
        if($(this).find('option:selected').data('street').toString().length)
            $('[name="ORDER[STREET]"]').val($(this).find('option:selected').data('street')).parent().addClass('filled');

        if($(this).find('option:selected').data('house').toString().length)
            $('[name="ORDER[HOUSE]"]').val($(this).find('option:selected').data('house')).parent().addClass('filled');

        if($(this).find('option:selected').data('apartment').toString().length)
            $('[name="ORDER[APARTMENT]"]').val($(this).find('option:selected').data('apartment')).parent().addClass('filled');
    });
    $('._address_config input').on('change',function(e){
        $('.checkout-user-addresses').val('null').selectOrDie("update");
    });
    $('input[name="ORDER[DISCOUNT_BONUSES]"]').on('keypress',function(e){
        return (e.charCode >= 48 && e.charCode <= 57)  || e.keyCode == 46;
    });
    $('.reorder-btn').on('click',function(e){
        e.preventDefault();
        var $self = $(this);
        $.ajax({
            type: 'post',
            data: {'ORDER_ID': $self.data('id')},
            dataType: "json",
            url: '/bitrix/components/bd/checkout_pizza/component.php?action=reorder',
            success: function(data){
                renderSummary(data);
                $('.basket-btn').trigger('click');
            }
        });
        return false;
    })
    $('.gender_cont input').on('change',function(){
        $('[name="USER[GENDER]"]').val($(this).attr('id'));
    });
    $('.notify-config input[type="checkbox"]').on('change',function(){
        if($(this).is(':checked')){
            $('[name="USER['+$(this).data('target')+']"]').val(1);
        }else{
            $('[name="USER['+$(this).data('target')+']"]').val(0);
        }
    })
    $('.auth-tabs a').on('click',function(e){
        e.preventDefault();
        $('.auth-state').hide();
        $('.auth-state.'+$(this).data('target')).show();
        $('.auth-tabs li').removeClass('active');
        $(this).parent().addClass('active');
        return false;
    });
    $('.forgot').on('click',function(e){
        e.preventDefault();
        $('.auth-state').hide();
        $('.auth-state.forgot-password-state').show();

        return false;
    });
    $('#inp_agree').on('change',function(){
        var $form = $(this).closest('form');
        if($(this).is(':checked')){
            $form.find('button').removeAttr('disabled');
        }else{
            $form.find('button').attr('disabled','disabled');
        }
    });
    $('[name="PHONE"],[name="EMAIL"],[name="PASSWORD"]').on(' keypress',function(e){
        if($('#popover-auth').is(':visible') && e.keyCode == 13){
            e.preventDefault();
            $(this).closest('form').submit()
        }
    })
    $('.auth-state form').on('submit',function(e){
        e.preventDefault();

        $('#popover-auth').focus();



        $('.auth-tabs li.active a').trigger('click');
        var $form = $(this);
        if($('[name="PHONE"]').length>1 && $(this).find('[name="ACTION"]').val()!='RESET_PASSWORD'){
            $('[name="PHONE"]').val($form.find('[name="PHONE"]').val()).closest('.bd-input').addClass('filled');
        }
        if($('[name="EMAIL"]').length>1 && $(this).find('[name="ACTION"]').val()!='RESET_PASSWORD'){
            $('[name="EMAIL"]').val($form.find('[name="EMAIL"]').val()).closest('.bd-input').addClass('filled');
        }
        $('[name="PASSWORD"]').val($form.find('[name="PASSWORD"]').val()).closest('.bd-input').addClass('filled');

        if($(this).find('[name="ACTION"]').val()=='RESET_PASSWORD'){
            $('.phone-confirm-password-state').find('[name="PHONE"]').val($(this).find('[name="PHONE"]').val()).closest('.bd-input').addClass('filled');
            $('.set-new-password-state').find('[name="PHONE"]').val($(this).find('[name="PHONE"]').val()).closest('.bd-input').addClass('filled');

            $('.phone-confirm-password-state').find('[name="EMAIL"]').val($(this).find('[name="EMAIL"]').val()).closest('.bd-input').addClass('filled');
            $('.set-new-password-state').find('[name="EMAIL"]').val($(this).find('[name="EMAIL"]').val()).closest('.bd-input').addClass('filled');
        }

        $.ajax({
            type: 'post',
            data: $form.serialize(),
            dataType: "json",
            url: '?action=auth',
            success: function(data){
                $form.find('.bd-error').html('');
                if(data.ERRORS!=undefined){
                    $.each(data.ERRORS,function(i,item){
                        $form.find('input[name="'+item.FIELD+'"]').closest('.bd-input').addClass('error');
                        $form.find('.bd-error').append('<div>'+item.MESSAGE+'</div>');
                    });
                    var cont_ = '#sms_reg';
                    if($('#sms_reg').length == 0){
                        cont_ = '#sign-up-email-form';
                    }
                    if(
                        $(cont_+' .input-row-first .bd-input').hasClass('error') &&
                        $(cont_+' .input-row .bd-input').hasClass('error') &&
                        !$(cont_+' .input-row-last .bd-input').hasClass('error')
                    ){
                        $(cont_+' .input-row-last').css('margin-top',0);
                    }else{
                        $(cont_+' .input-row-last').css('margin-top','-1px');
                        $(cont_+' .input-row').css('margin-top','-1px');
                    }
                    if(
                        $(cont_+' .input-row-first .bd-input').hasClass('error') &&
                        !$(cont_+' .input-row .bd-input').hasClass('error') &&
                        $(cont_+' .input-row-last .bd-input').hasClass('error')
                    ){
                        $(cont_+' .input-row').css('margin-top',0);
                    }
                }else{
                    if(data.TYPE=='ERROR'){
                        $form.find('.bd-error').html(data.MESSAGE).show();
                    }else{
                        if(data.next!=='auth-success'){
                            $('.auth-state').hide();
                            $('.auth-state.'+data.next+'-state').show();
                            $form.find('.bd-error').html('').hide();
                        }else{
                            window.location.reload();
                        }
                    }
                }
            }
        })

        return false;
    })
    $('#checkout-form').on('submit',function(e){
        var $form = $(this);
        e.preventDefault();
        $('.send-order').attr('disabled','disabled');
        $.ajax({
            type: 'post',
            data: $form.serialize(),
            dataType: "json",
            url: '/bitrix/components/bd/checkout_pizza/component.php?action=validate',
            success: function(data){
                if(data.status==0){
                    $('.bd-input,.sod_select').removeClass('error shake');
                    $.each(data.errors,function(i,item){
                        $('[name="ORDER['+item+']"]').parent().addClass('error shake');
                        setTimeout(function(){
                            $('[name="ORDER['+item+']"]').parent().removeClass('shake');
                        },1000);
                    })
                    $('.send-order').removeAttr('disabled');
                }else{

                    if(window.yaCounter!=undefined && window.yaCounter != null){
                        yaCounter.reachGoal('order-submit',{});
                        var products = [];
                        $('.checkout-form .order-content li').each(function () {
                            products.push({
                                "id": $(this).data('pid'),
                                "name": $(this).find('.name').text(),
                                "price": $(this).find('.price span').first().text().replace(' ', ''),
                                "category": $(this).find('.section').text(),
                                "quantity": $(this).find('.amount span').text()
                            });
                        })
                        window.dataLayer.push({
                            "ecommerce": {
                                "purchase": {
                                    "actionField": {
                                        "id": new Date().getTime()
                                    },
                                    "products": products
                                }
                            }
                        });
                    }
                    if(ga!=undefined){
                        ga('send', 'event', 'order', 'submit');
                    }
                    $form[0].submit()
                }
            }
        });
    });
    $.ajax({
        dataType: "json",
        url: '/bitrix/components/bd/basket_pizza/component.php?action=getBasket',
        success: function(data){
            renderBasket(data);
            renderSummary(data);
        }
    });

    registerRemoveAddressHandlers();
    $('.add-address').on('click',function(e){
        e.preventDefault()
        if ($('.address-template_').find('.sod_select').length > 0) {
            $('.address-template_').find('.sod_select').parent().html('<div class="label">' + $('.address-template_').find('.bd-select').find('.label').text() + '</div>' + $('.address-template_ select')[0].outerHTML);
        }
        var ran_ = new Date().getTime();
        var $new_address = $('.address-template_').html().replace('id="PRIVATE_"', 'id="PRIVATE_' + ran_ + '"').replace('data-target="PRIVATE_"', 'data-target="PRIVATE_' + ran_ + '"').replace('for="PRIVATE_"', 'for="PRIVATE_' + ran_ + '"');

        $('.address-list').append($new_address);

        registerRemoveAddressHandlers();
        registerControls();
        registerAddressListeners();
        return false;
    });
	var basketTemplate = '<div class="basket-item row ${CLASSES}" data-pid="${ID}" data-id="${INDEX}" data-price="${PRICE}"> ' +
    '<div class="col-xs-2"> ' +
    '<div class="product-image"><img src="${IMAGE}"><div class="${APPEND_WITHOUT_SALE}" title="'+BX.message('no_sale_title')+'"></div></div> ' +
    '</div> ' +
    '<div class="col-xs-4"> ' +
    '<div class="name">${NAME}</div> ' +
        '<div class="section">{{html SECTION}}</div> ' +
    '</div> ' +
        '<div class="col-xs-2 buttons"><a href="#" class="change-amount-btn minus">-</a><span class="amount">${AMOUNT}</span> ' +
    '<input type="hidden" value="${AMOUNT}"><a href="#" class="change-amount-btn plus">+</a> ' +
    '</div> ' +
        '<div class="col-xs-3 text-xs-right nopad"><span class="product-sum font-fix"><span>${LOCAL_SUM}</span><span class="currency">' + window.currencyFont + '</span></span></div> ' +
    '<div class="col-xs-1 text-xs-left remove-basket-item"><a href="#"> ' +
    '<svg viewBox="0 0 38.0919 40.5429"><path class="cls-1" d="M35.1491,39.3951V60.8883a6.2561,6.2561,0,0,0,6.2366,6.2366H59.81a6.2549,6.2549,0,0,0,6.2366-6.2366V39.3951H35.1491ZM57.8477,31.016c-0.5913-5.912-13.9111-5.912-14.5019,0H33.838a2.2942,2.2942,0,0,0-2.2875,2.2868h0A2.2939,2.2939,0,0,0,33.838,35.59H67.3556a2.2938,2.2938,0,0,0,2.2868-2.2875h0a2.2941,2.2941,0,0,0-2.2868-2.2868h-9.508ZM43.9426,60.6523c-0.8815,0-1.5868-.3957-1.5868-0.89V45.9838c0-.4947.7053-0.8907,1.5868-0.8907s1.587,0.396,1.587.8907v13.778c0,0.4947-.7053.89-1.587,0.89h0Zm6.6539,0c-0.8817,0-1.587-.3957-1.587-0.89V45.9838c0-.4947.7053-0.8907,1.587-0.8907s1.5868,0.396,1.5868.8907v13.778c0,0.4947-.7053.89-1.5868,0.89h0Zm6.6551,0c-0.8817,0-1.587-.3957-1.587-0.89V45.9838c0-.4947.7053-0.8907,1.587-0.8907s1.5868,0.396,1.5868.8907v13.778C58.8383,60.2565,58.133,60.6523,57.2515,60.6523Z" transform="translate(-31.5505 -26.5819)"/></svg></a></div> ' +
    '</div>';
	$.template( "basketTemplate", basketTemplate );

    if($('.constructor-panel').length){
        $('body').on('click',function(e){
            if($('.constructor-panel').is(':visible') && $(e.target).closest('.constructor-panel').length==0)
                closePanel();
        });
    }
    if($('.gift-sticky').length){
        $('body').on('click',function(e){
            if($('.expanded-gift').is(':visible') && $(e.target).closest('.expanded-gift').length==0)
                $('.gift-toggle').trigger('click');
        });
    }
    $(window).on('resize',resizeHandler);
    resizeHandler();

    $('.constructor-view .close-view,.constructor-view .product-image').on('click',function(e){
        e.preventDefault();
        $('#popover-basket').removeClass('product-information-open').css( 'left', '+=78px' );
        $('.product-info-cont').hide();
        if($('.recommendation-container.static-banner').html()!=''){
            $('.recommendation-container.static-banner').show();
        }
        if($('.recommendation-container.recommendation-list .rc-list .recommendation-tab').length>0){
            $('.recommendation-container.recommendation-list').show();
        }
        if($('.recommendation-container.static-banner').html()=='' && $('.recommendation-container.recommendation-list .rc-list .recommendation-tab').length==0){
            $('.recommendation-container.no-recommendation').show();
        }
        $('.basket-gift-container').show();
        return false;
    });
    if($('.resend-cont').length){
        $('.code-resend').on('click',function(e){
            e.preventDefault();

            var $cont = $(this).parent();
            $.ajax({
                type: 'post',
                data:{ACTION: 'RESEND',PHONE: $cont.closest('.auth-state').find('input[name="PHONE"]').val()},
                dataType: "json",
                url: '?action=auth',
                success: function(data){
                    $cont.find('.resend-status').show();
                    $cont.find('.code-resend').hide();
                    $cont.find('.resend-status .timer').html('0:59');
                    var seconds = 59;
                    var interval = setInterval(function() {
                        seconds--;
                        $cont.find('.resend-status .timer').html('0:' + (seconds).pad());
                        if (seconds == 0){
                            clearInterval(interval);
                            $cont.find('.resend-status').hide();
                            $cont.find('.code-resend').show();
                        }
                    }, 1000);
                }
            })

            return false;
        });
    }

    
    registerPopovers();
    registerControls();
    registerLikes();
    if($('.product-labels').length){
        $('.product-labels').each(function(){
            var _this = $(this);
            $(this).find('.product-label').each(function (i, val ) {
                var j = i+1;
                $(val).css('z-index',_this.find('.product-label').length - j);
            })
        })
    }
    if($('.gift-sticky').length){
        $(window).on('scroll',function(e){
            var window_top = $(window).scrollTop();
            if (window_top > 0) {
                $('.gift-sticky').addClass('sticky');
            } else {
                $('.gift-sticky').removeClass('sticky');
            }
        });
        $('.collapsed-gift').on('click',function(e){
            e.preventDefault();
            $('.expanded-gift').show().addClass('open');
            $('.collapsed-gift').hide();
            return false;
        })
        $('.expanded-gift .gift-toggle').on('click',function(e){
            e.preventDefault();
            $('.expanded-gift').removeClass('open').hide();
            $('.collapsed-gift').show();
            return false;
        })
    }
    //filters
    if($('.filter-params').length){
        $('.param-item .icon-param,.param-item span').on('click',function(e){
            e.preventDefault();
            var $parent = $(this).parent();
            var $param = $(this).closest('.param-item');
            var $form = $('#ingridients-filter form');
            if(!$(this).hasClass('selected')){
                $param.find('.icon-param').removeClass('selected');
                $(this).addClass('selected');
                $param.find('input[type="hidden"]').val('Y');
                if($(this)[0].tagName=='SPAN'){
                    $param.find('.add_param').addClass('selected');
                }
                if($(this).hasClass('remove-param')){
                    $param.find('input[type="hidden"]').val('E');
                    $param.find('span').removeClass('checked');
                    $param.find('span').addClass('unchecked');
                }else{
                    $param.find('input[type="hidden"]').val('Y');
                    $param.find('span').removeClass('unchecked');
                    $param.find('span').addClass('checked');
                }
            }else{
                $param.find('input[type="hidden"]').val('N');
                $(this).removeClass('selected');
                if($(this)[0].tagName=='SPAN'){
                    $param.find('.add_param').removeClass('selected');
                }
                $param.find('span').removeClass('unchecked');
                $param.find('span').removeClass('checked');
            }
            smartFilter.click($param.find('input[type="hidden"]')[0]);
            return false;
        });
        $('.apply-filter').on('click',function(e){
           $('.clear-filter-btn').show();
           $('.ingridients-filter-btn').addClass('active');
        });
        $('.clear-filter-btn,.clear-filter').on('click',function(e){
            $('.clear-filter-btn').hide();
            $('.ingridients-filter-btn').removeClass('active');
            $('.icon-param').removeClass('selected');
            $('.unchecked').removeClass('unchecked');
            $('.checked').removeClass('checked');
        });
    }
    //energy
    if($('.product-energy').length){
        $('.product-energy a').on('click',function(e){
            e.preventDefault();
            $(this).toggleClass('pop-active');
            $(this).parent().find('.energy-value-content').slideToggle();
            return false;
        });
    }
    //tabs
    $('.products-sub-menu-main a').on('click',function(e){
        e.preventDefault();
        $('.product-list').hide();
        $('.product-list[data-section="'+$(this).attr('data-section')+'"]').show();
        window.location.hash = '#section-'+$(this).attr('data-section');
        $(this).closest('ul').find('li').removeClass('active');
        $(this).parent().addClass('active');
        $(window).scrollTop($('.products-sub-menu-main').offset().top)

        return false;
    });
    $('.go-to-love').on('click',function(){
        $('.products-sub-menu-main li').removeClass('active');
        $('.products-sub-menu-main li a[data-section="whatIsLove"]').parent().addClass('active');
        $('.product-list').hide();
        $('.product-list[data-section="whatIsLove"]').show();
    });
    //constructor
    if($('.constructor-item').length){
        $('.constructor-item').on('click',function(e){

            $(this).closest('.base-list').find('.constructor-item').removeClass('active');
            $(this).addClass('active');
            $('input[name="'+$(this).data('target')+'"]').val($(this).data('id'));
            calculateConstructor();
        });

        $('.preset-item').on('click',function(e){
            if ($(this).hasClass('active')) {
                $('input[name="INGREDIENTS[]"]').remove();
                $(this).closest('.preset-item').removeClass('active');
                $('.ingredient-item').removeClass('active');
                $('.constructor-ingredient-basket-item').not('.exclude').remove();
                calculateConstructor();
                return false;
            } else {
                $('input[name="INGREDIENTS[]"]').remove();
                $('#constructor_form input[name="NAME"]').val($(this).find('.name').text());
                $('#constructor_form input[name="IMAGE"]').val($(this).data('big-image'));
                $('.constructor-ingredient-basket-item').remove();
                $(this).closest('.select-preset-list').find('.preset-item').removeClass('active');
                $(this).addClass('active');

                $('.preset-image-big img').attr('src', $(this).data('big-image'));
                var ids = $(this).data('filling').split(',');
                $.each(ids, function (i, item) {
                    $('.ingredient-item[data-id="' + item + '"]').addClass('active')
                    if ($('input[name="INGREDIENTS[]"][value="' + item + '"]').length == 0) {
                        $('#constructor_form').append('<input type="hidden" name="INGREDIENTS[]" value="' + item + '"/>');
                    }
                });
                calculateConstructor();
                return false;
            }
        });

    }
    
    $('[name="ORDER[DELIVERY_DATE]"]').on('change',function(e){
	    $('.hour-select-1 .sod_option').show();
	    if($(this).find('option:selected').data('date') == new Date().getDate()){
		    $('.hour-select-1 .sod_option').each(function(){
			    if(parseInt($(this).attr('data-value')) < new Date().getHours()){
				    $(this).hide();
			    }
		    })
	    }
    });
    
    //breadcrumb
    if($('.breadcrumb-toggle').length){
        $('.breadcrumb-container').on('click',function(e){
            if(
                $(e.target).parent()[0].tagName!=='A' ||
                ($(e.target).parent()[0].tagName=='A' && $(e.target).parent().attr('href')=='#')
            ){
                e.preventDefault();
                $('.breadcrumb-container').addClass('open');
                return false;
            }
        })
        $('.breadcrumb-path-container .close').on('click',function(e){
            e.preventDefault();
            $('.breadcrumb-container').removeClass('open');
            return false;
        })
    }
    //gift
    if($('.get-gift-btn').length){
        $('.get-gift-btn').on('click',function(e){
            e.preventDefault();
            var $self = $(this).closest('.product');
            $.ajax({
                type: 'post',
                data: {'PRODUCT_ID': $self.parent().data('id'),IS_GIFT: 1,GIFT_LIMIT: $self.find('.gift-progress-info').data('limit')},
                dataType: "json",
                url: '/bitrix/components/bd/basket_pizza/component.php?action=addToBasket',
                success: function(data){
                    if(data.basket_sum!=undefined){
                        renderBasket();
                        $self.addClass('active');
                        $('.product.gift').addClass('masked');
                        $('.product.gift[data-id="'+$self.parent().data('id')+'"]').removeClass('masked');
                        $('.get-gift').text(BX.message('get_another_gift'));
                    }else{
                        alert(BX.message('good_luck_bitch'))
                    }
                }
            });
        });
        $('.get-another-gift-btn').on('click',function(e){
            e.preventDefault();
            var $self = $(this).closest('.product');
            $.ajax({
                type: 'post',
                data: {'PRODUCT_ID': $self.data('id'),IS_GIFT: 1},
                dataType: "json",
                url: '/bitrix/components/bd/basket_pizza/component.php?action=removeGift',
                success: function(data){
                    renderBasketItems(data);
                    if(data.basket_sum!=undefined){
                        $self.closest('.gift').removeClass('active');
                        $('.product.gift').removeClass('masked');
                        $('.get-gift').text(BX.message('choise'));
                    }
                }
            });

        });
    }
    //
    if($('.delivery-time-type_').length){
        $('[name="ORDER[DELIVERY_TIME_TYPE]"]').on('change',function(e){
	      
          if($(this).prop('checked')){
            //$('.delivery-time-type_').addClass('nopadl');
            $('.delivery-time-type_').addClass('current_')
            $('.hour-select-cont').hide();
          }else{
            //$('.delivery-time-type_').removeClass('nopadl');
            $('.delivery-time-type_').removeClass('current_')
            $('.hour-select-cont').show();
            $('select[name="ORDER[HOUR]"]').val(window.currentHour).trigger('change');
            $('select[name="ORDER[HOUR]"]').parent().find('.sod_option[data-value="'+window.currentHour+'"]').trigger('click');

            
            $('select[name="ORDER[MINUTE]"]').val('00').trigger('change');
            $('select[name="ORDER[MINUTE]"]').parent().find('.sod_option[data-value="00"]').trigger('click')

          }
          $('[name="ORDER[DELIVERY_DATE]"]').trigger('change')
        })
    }

    if(window.location.hash.length>0 && window.location.hash.indexOf('section-') !== -1){
        var section = window.location.hash.substr(1).split('-')[1];
        $('.products-sub-menu-main a[data-section="'+section+'"]').trigger('click');
    }
});
( function( window ) {
// class helper functions from bonzo https://github.com/ded/bonzo

    function classReg( className ) {
        return new RegExp("(^|\\s+)" + className + "(\\s+|$)");
    }

// classList support for class management
// altho to be fair, the api sucks because it won't accept multiple classes at once
    var hasClass, addClass, removeClass;

    if ( 'classList' in document.documentElement ) {
        hasClass = function( elem, c ) {
            return elem.classList.contains( c );
        };
        addClass = function( elem, c ) {
            elem.classList.add( c );
        };
        removeClass = function( elem, c ) {
            elem.classList.remove( c );
        };
    }
    else {
        hasClass = function( elem, c ) {
            return classReg( c ).test( elem.className );
        };
        addClass = function( elem, c ) {
            if ( !hasClass( elem, c ) ) {
                elem.className = elem.className + ' ' + c;
            }
        };
        removeClass = function( elem, c ) {
            elem.className = elem.className.replace( classReg( c ), ' ' );
        };
    }

    function toggleClass( elem, c ) {
        var fn = hasClass( elem, c ) ? removeClass : addClass;
        fn( elem, c );
    }

    var classie = {
        // full names
        hasClass: hasClass,
        addClass: addClass,
        removeClass: removeClass,
        toggleClass: toggleClass,
        // short names
        has: hasClass,
        add: addClass,
        remove: removeClass,
        toggle: toggleClass
    };

// transport
    if ( typeof define === 'function' && define.amd ) {
        // AMD
        define( classie );
    } else {
        // browser global
        window.classie = classie;
    }

})( window );
(function(){

    var ajaxPagerLoadingClass   = 'ajax-pager-loading',
        ajaxPagerWrapClass      = 'ajax-pager-wrap',
        ajaxPagerLinkClass      = 'ajax-pager-link',
        ajaxWrapAttribute       = 'wrapper-class',
        ajaxPagerLoadingTpl     = ['<span class="' + ajaxPagerLoadingClass + '">',
            '',
            '</span>'].join(''),
        busy = false,


        attachPagination = function (wrapperClass){
            var $wrapper = $('.' + wrapperClass),
                $window  = $(window);

            if($wrapper.length && $('.' + ajaxPagerWrapClass).length){
                $window.on('scroll', function() {
                    if(($window.scrollTop() + $window.height()) >
                        ($wrapper.offset().top + $wrapper.height()) && !busy) {
                        busy = true;
                        $('.' + ajaxPagerLinkClass).click();
                    }
                });
            }
        },

        ajaxPagination = function (e){
            e.preventDefault();

            busy = true;
            var wrapperClass = $('.'+ajaxPagerLinkClass).data(ajaxWrapAttribute),
                $wrapper = $('.' + wrapperClass),
                $link = $(this);

            if($wrapper.length){
                $('.' + ajaxPagerWrapClass).append(ajaxPagerLoadingTpl);
                $.get($link.attr('href'), {'AJAX_PAGE' : 'Y'}, function(data) {
                    $('.' + ajaxPagerWrapClass).remove();

                    $wrapper.append($(data).filter('.product-ajax-cont'));
                    $wrapper.append($(data).find('.product-ajax-cont'));
                    $wrapper.append($(data).filter('article'));
                    $wrapper.append($(data).find('article'));
                    $wrapper.append($(data).filter('.ajax-pager-wrap'));
                    $wrapper.append($(data).find('.ajax-pager-wrap'));
                    setTimeout(function(){
                        if ($('.news-masonry .news-list').length) {
                            window.msnry = new Masonry('.news-masonry .news-list', {itemSelector: '.news-masonry article'});
                            //window.msnry = new Masonry( '.news-masonry .news-list', {itemSelector: '.news-masonry article'});
                        }
                    }, 10);
                    setTimeout(function () {
                        $wrapper.find('.product-ajax-cont').removeClass('animate');
                    },1000);
                    setTimeout(function () {
                        var t_ = data.split('</html>');
                        if(t_[1]!==undefined && t_[1]!==null){
                            if($(t_[1]).html()!==undefined){
                                var script = $(t_[1]).html().replace(new RegExp('%26AJAX_PAGE%3DY','g'),'');
                                script = script.replace(new RegExp('&AJAX_PAGE%3DY','g'),'');
                                script = script.replace(new RegExp('PAGEN_[0-9][0-9]%3D[0-9]','g'),'');
                                script = script.replace(new RegExp('PAGEN_[0-9]%3D[0-9]','g'),'');
                                eval(script);
                            }
                        }
                    },1000)

                    attachPagination(wrapperClass);
                    registerProductListeners();
                    processPreloadImages();
                    $("select").selectOrDie({placeholderOption:true});

                    var overlay = document.querySelector( '.md-overlay' );

                    [].slice.call( document.querySelectorAll( '.md-trigger' ) ).forEach( function( el, i ) {

                        var modal = document.querySelector( '#' + el.getAttribute( 'data-modal' ) ),
                            close = modal.querySelector( '.md-close' );

                        function removeModal( hasPerspective ) {
                            classie.remove( modal, 'md-show' );
                            classie.remove( overlay, 'md-show' );

                            if( hasPerspective ) {
                                classie.remove( document.documentElement, 'md-perspective' );
                            }
                        }

                        function removeModalHandler() {
                            removeModal( classie.has( el, 'md-setperspective' ) );
                        }

                        el.addEventListener( 'click', function( ev ) {
                            classie.add( modal, 'md-show' );
                            classie.add( overlay, 'md-show' );
                            overlay.removeEventListener( 'click', removeModalHandler );
                            overlay.addEventListener( 'click', removeModalHandler );

                            if( classie.has( el, 'md-setperspective' ) ) {
                                setTimeout( function() {
                                    classie.add( document.documentElement, 'md-perspective' );
                                }, 25 );
                            }
                        });
                        if(close!==null){
                            close.addEventListener( 'click', function( ev ) {
                                ev.stopPropagation();
                                removeModalHandler();
                            });
                        }

                    } );

					if(window.picturefill!=undefined){
						window.picturefill();
					}

                    busy = false;
                });
            }
        };

    $(function() {
        if($('.'+ajaxPagerLinkClass).length
            && $('.'+ajaxPagerLinkClass).data(ajaxWrapAttribute).length){
            attachPagination($('.'+ajaxPagerLinkClass).data(ajaxWrapAttribute));
            $(document).on('click', '.' + ajaxPagerLinkClass, ajaxPagination);
        }
    });

})();
!function (a, b) {
    "function" == typeof define && define.amd ? define("priorityNav", b(a)) : "object" == typeof exports ? module.exports = b(a) : a.priorityNav = b(a)
}(window || this, function (a) {
    "use strict";

    function b(a, b, c) {
        var d;
        return function () {
            var e = this, f = arguments, g = function () {
                d = null, c || a.apply(e, f)
            }, h = c && !d;
            clearTimeout(d), d = setTimeout(g, b), h && a.apply(e, f)
        }
    }

    var c, d, e, f, g, h, i, j, k = {}, l = [], m = !!document.querySelector && !!a.addEventListener, n = {}, o = 0,
        p = 0, q = 0, r = {
            initClass: "js-priorityNav",
            mainNavWrapper: "nav",
            mainNav: "ul",
            navDropdownClassName: "nav__dropdown",
            navDropdownToggleClassName: "nav__dropdown-toggle",
            navDropdownLabel: "more",
            navDropdownBreakpointLabel: "menu",
            breakPoint: 500,
            throttleDelay: 50,
            offsetPixels: 0,
            count: !0,
            moved: function () {
            },
            movedBack: function () {
            }
        }, s = function (a, b, c) {
            if ("[object Object]" === Object.prototype.toString.call(a)) for (var d in a) Object.prototype.hasOwnProperty.call(a, d) && b.call(c, a[d], d, a); else for (var e = 0, f = a.length; f > e; e++) b.call(c, a[e], e, a)
        }, t = function (a, b) {
            for (var c = b.charAt(0); a && a !== document; a = a.parentNode) if ("." === c) {
                if (a.classList.contains(b.substr(1))) return a
            } else if ("#" === c) {
                if (a.id === b.substr(1)) return a
            } else if ("[" === c && a.hasAttribute(b.substr(1, b.length - 2))) return a;
            return !1
        }, u = function (a, b) {
            var c = {};
            return s(a, function (b, d) {
                c[d] = a[d]
            }), s(b, function (a, d) {
                c[d] = b[d]
            }), c
        }, v = function (a, b) {
            if (a.classList) a.classList.toggle(b); else {
                var c = a.className.split(" "), d = c.indexOf(b);
                d >= 0 ? c.splice(d, 1) : c.push(b), a.className = c.join(" ")
            }
        }, w = function (a, b) {
            return j = document.createElement("span"), g = document.createElement("ul"), h = document.createElement("button"), h.innerHTML = b.navDropdownLabel, h.setAttribute("aria-controls", "menu"), h.setAttribute("type", "button"), g.setAttribute("aria-hidden", "true"), a.querySelector(f).parentNode !== a ? void console.warn("mainNav is not a direct child of mainNavWrapper, double check please") : (a.insertAfter(j, a.querySelector(f)), j.appendChild(h), j.appendChild(g), g.classList.add(b.navDropdownClassName), g.classList.add("priority-nav__dropdown"), h.classList.add(b.navDropdownToggleClassName), h.classList.add("priority-nav__dropdown-toggle"), j.classList.add(b.navDropdownClassName + "-wrapper"), j.classList.add("priority-nav__wrapper"), void a.classList.add("priority-nav"))
        }, x = function (a) {
            var b = window.getComputedStyle(a), c = parseFloat(b.paddingLeft) + parseFloat(b.paddingRight);
            return a.clientWidth - c
        }, y = function () {
            var a = document, b = window, c = a.compatMode && "CSS1Compat" === a.compatMode ? a.documentElement : a.body,
                d = c.clientWidth, e = c.clientHeight;
            return b.innerWidth && d > b.innerWidth && (d = b.innerWidth, e = b.innerHeight), {width: d, height: e}
        }, z = function (a) {
            d = x(a), i = a.querySelector(g).parentNode === a ? a.querySelector(g).offsetWidth : 0, e = D(a) + n.offsetPixels, q = y().width
        };
    k.doesItFit = function (a) {
        var c = 0 === a.getAttribute("instance") ? c : n.throttleDelay;
        o++, b(function () {
            var b = a.getAttribute("instance");
            for (z(a); e >= d && a.querySelector(f).children.length > 0 || q < n.breakPoint && a.querySelector(f).children.length > 0;) k.toDropdown(a, b), z(a, b), q < n.breakPoint && C(a, b, n.navDropdownBreakpointLabel);
            for (; d >= l[b][l[b].length - 1] && q > n.breakPoint;) k.toMenu(a, b), q > n.breakPoint && C(a, b, n.navDropdownLabel);
            l[b].length < 1 && (a.querySelector(g).classList.remove("show"), C(a, b, n.navDropdownLabel)), a.querySelector(f).children.length < 1 ? (a.classList.add("is-empty"), C(a, b, n.navDropdownBreakpointLabel)) : a.classList.remove("is-empty"), A(a, b)
        }, c)()
    };
    var A = function (a, b) {
        l[b].length < 1 ? (a.querySelector(h).classList.add("priority-nav-is-hidden"), a.querySelector(h).classList.remove("priority-nav-is-visible"), a.classList.remove("priority-nav-has-dropdown"), a.querySelector(".priority-nav__wrapper").setAttribute("aria-haspopup", "false")) : (a.querySelector(h).classList.add("priority-nav-is-visible"), a.querySelector(h).classList.remove("priority-nav-is-hidden"), a.classList.add("priority-nav-has-dropdown"), a.querySelector(".priority-nav__wrapper").setAttribute("aria-haspopup", "true"))
    }, B = function (a, b) {
        a.querySelector(h).setAttribute("priorityNav-count", l[b].length)
    }, C = function (a, b, c) {
        a.querySelector(h).innerHTML = c
    };
    k.toDropdown = function (a, b) {
        a.querySelector(g).firstChild && a.querySelector(f).children.length > 0 ? a.querySelector(g).insertBefore(a.querySelector(f).lastElementChild, a.querySelector(g).firstChild) : a.querySelector(f).children.length > 0 && a.querySelector(g).appendChild(a.querySelector(f).lastElementChild), l[b].push(e), A(a, b), a.querySelector(f).children.length > 0 && n.count && B(a, b), n.moved()
    }, k.toMenu = function (a, b) {
        a.querySelector(g).children.length > 0 && a.querySelector(f).appendChild(a.querySelector(g).firstElementChild), l[b].pop(), A(a, b), a.querySelector(f).children.length > 0 && n.count && B(a, b), n.movedBack()
    };
    var D = function (a) {
        for (var b = a.childNodes, c = 0, d = 0; d < b.length; d++) 3 !== b[d].nodeType && (isNaN(b[d].offsetWidth) || (c += b[d].offsetWidth));
        return c
    }, E = function (a, b) {
        window.attachEvent ? window.attachEvent("onresize", function () {
            k.doesItFit && k.doesItFit(a)
        }) : window.addEventListener && window.addEventListener("resize", function () {
            k.doesItFit && k.doesItFit(a)
        }, !0), a.querySelector(h).addEventListener("click", function () {
            v(a.querySelector(g), "show"), v(this, "is-open"), v(a, "is-open"), -1 !== a.className.indexOf("is-open") ? a.querySelector(g).setAttribute("aria-hidden", "false") : (a.querySelector(g).setAttribute("aria-hidden", "true"), a.querySelector(g).blur())
        }), document.addEventListener("click", function (c) {
            t(c.target, "." + b.navDropdownClassName) || c.target === a.querySelector(h) || (a.querySelector(g).classList.remove("show"), a.querySelector(h).classList.remove("is-open"), a.classList.remove("is-open"))
        }), document.onkeydown = function (a) {
            a = a || window.event, 27 === a.keyCode && (document.querySelector(g).classList.remove("show"), document.querySelector(h).classList.remove("is-open"), c.classList.remove("is-open"))
        }
    };
    Element.prototype.remove = function () {
        this.parentElement.removeChild(this)
    }, NodeList.prototype.remove = HTMLCollection.prototype.remove = function () {
        for (var a = 0, b = this.length; b > a; a++) this[a] && this[a].parentElement && this[a].parentElement.removeChild(this[a])
    }, k.destroy = function () {
        n && (document.documentElement.classList.remove(n.initClass), j.remove(), n = null, delete k.init, delete k.doesItFit)
    }, m && "undefined" != typeof Node && (Node.prototype.insertAfter = function (a, b) {
        this.insertBefore(a, b.nextSibling)
    });
    var F = function (a) {
        var b = a.charAt(0);
        return "." === b || "#" === b ? !1 : !0
    };
    return k.init = function (a) {
        if (n = u(r, a || {}), !m && "undefined" == typeof Node) return void console.warn("This browser doesn't support priorityNav");
        if (!F(n.navDropdownClassName) || !F(n.navDropdownToggleClassName)) return void console.warn("No symbols allowed in navDropdownClassName & navDropdownToggleClassName. These are not selectors.");
        var b = document.querySelectorAll(n.mainNavWrapper);
        s(b, function (a) {
            return l[p] = [], a.setAttribute("instance", p++), (c = a) ? (f = n.mainNav, a.querySelector(f) ? (w(a, n), g = "." + n.navDropdownClassName, a.querySelector(g) ? (h = "." + n.navDropdownToggleClassName, a.querySelector(h) ? (E(a, n), void k.doesItFit(a)) : void console.warn("couldn't find the specified navDropdownToggle element")) : void console.warn("couldn't find the specified navDropdown element")) : void console.warn("couldn't find the specified mainNav element")) : void console.warn("couldn't find the specified mainNavWrapper element")
        }), o++, document.documentElement.classList.add(n.initClass)
    }, k
});
Number.prototype.pad = function(size) {
    var s = String(this);
    while (s.length < (size || 2)) {s = "0" + s;}
    return s;
}
function plural(number, one, two, five) {
    number = Math.abs(number);
    number %= 100;
    if (number >= 5 && number <= 20) {
        return five;
    }
    number %= 10;
    if (number == 1) {
        return one;
    }
    if (number >= 2 && number <= 4) {
        return two;
    }
    return five;
}
