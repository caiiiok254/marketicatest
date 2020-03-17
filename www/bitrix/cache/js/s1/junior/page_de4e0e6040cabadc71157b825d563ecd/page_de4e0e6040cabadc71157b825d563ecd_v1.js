
; /* Start:"a:4:{s:4:"full";s:80:"/local/components/junior/product.list/templates/.default/script.js?1584434930344";s:6:"source";s:66:"/local/components/junior/product.list/templates/.default/script.js";s:3:"min";s:0:"";s:3:"map";s:0:"";}"*/
$(document).ready(function(){
    
    /*
     *  Open popup of picture
     */

    $(".onSpoiler").click(function() {
        
		var p = $(this).parent().find('.product__spoilerbox');
		
		if(p.hasClass('spoiler-hide')){
			
			p.removeClass('spoiler-hide');
		}else{
			p.addClass('spoiler-hide');
			
		}
    });
    
});
/* End */
;; /* /local/components/junior/product.list/templates/.default/script.js?1584434930344*/
