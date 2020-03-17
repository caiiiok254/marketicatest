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