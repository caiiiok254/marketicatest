!function($){"use strict";$.fn.selectOrDie=function(e){var t={customID:null,customClass:"",placeholder:null,placeholderOption:!1,prefix:null,cycle:!1,stripEmpty:!1,links:!1,linksExternal:!1,size:0,tabIndex:0,onChange:$.noop},a={},o=!1,s,l,d={initSoD:function(e){return a=$.extend({},t,e),this.each(function(){if($(this).parent().hasClass("sod_select"))console.log("Select or Die: It looks like the SoD already exists");else{var e=$(this),t=e.data("custom-id")?e.data("custom-id"):a.customID,o=e.data("custom-class")?e.data("custom-class"):a.customClass,s=e.data("prefix")?e.data("prefix"):a.prefix,l=e.data("placeholder")?e.data("placeholder"):a.placeholder,i=e.data("placeholder-option")?e.data("placeholder-option"):a.placeholderOption,n=e.data("cycle")?e.data("cycle"):a.cycle,c=e.data("links")?e.data("links"):a.links,r=e.data("links-external")?e.data("links-external"):a.linksExternal,p=parseInt(e.data("size"))?e.data("size"):a.size,h=parseInt(e.data("tabindex"))?e.data("tabindex"):a.tabIndex?a.tabIndex:e.attr("tabindex")?e.attr("tabindex"):a.tabIndex,u=e.data("strip-empty")?e.data("strip-empty"):a.stripEmpty,f=e.prop("title")?e.prop("title"):null,b=e.is(":disabled")?" disabled":"",C="",v="",g=0,m,_,x;s&&(C='<span class="sod_prefix">'+s+"</span> "),v+=l&&!s?'<span class="sod_label sod_placeholder">'+l+"</span>":'<span class="sod_label">'+C+"</span>",m=$("<span/>",{id:t,class:"sod_select "+o+b,title:f,tabindex:h,html:v,"data-cycle":n,"data-links":c,"data-links-external":r,"data-placeholder":l,"data-placeholder-option":i,"data-prefix":s,"data-filter":""}).insertAfter(this),d.isTouch()&&m.addClass("touch"),_=$("<span/>",{class:"sod_list_wrapper"}).appendTo(m),x=$("<span/>",{class:"sod_list"}).appendTo(_),$("option, optgroup",e).each(function(e){var t=$(this);u&&!$.trim(t.text())?t.remove():0===e&&i&&!C?d.populateSoD(t,x,m,!0):d.populateSoD(t,x,m,!1)}),p&&(_.show(),$(".sod_option:lt("+p+")",x).each(function(){g+=$(this).outerHeight()}),_.removeAttr("style"),x.css({"max-height":g})),e.appendTo(m),m.on("focusin",d.focusSod).on("click",d.triggerSod).on("click",".sod_option",d.optionClick).on("mousemove",".sod_option",d.optionHover).on("keydown",d.keyboardUse),e.on("change",d.selectChange),$(document).on("click","label[for='"+e.attr("id")+"']",function(e){e.preventDefault(),m.focus()})}})},populateSoD:function(e,t,a,o){var s=a.data("placeholder"),l=a.data("placeholder-option"),d=a.data("prefix"),i=a.find(".sod_label"),n=e.parent(),c=e.text(),r=e.val(),p=e.data("custom-id")?e.data("custom-id"):null,h=e.data("custom-class")?e.data("custom-class"):"",u=e.is(":disabled")?" disabled ":"",f=e.is(":selected")?" selected active ":"",b=e.data("link")?" link ":"",C=e.data("link-external")?" linkexternal":"",v=e.prop("label");e.is("option")?($("<span/>",{class:"sod_option "+h+u+f+b+C,id:p,title:c,html:c,"data-value":r}).appendTo(t),o&&!d?(a.data("label",c),a.data("placeholder",c),e.prop("disabled",!0),t.find(".sod_option:last").addClass("is-placeholder disabled"),f&&i.addClass("sod_placeholder")):f&&s&&!l&&!d?a.data("label",s):f&&a.data("label",c),(f&&!s||f&&l||f&&d)&&i.append(c),n.is("optgroup")&&(t.find(".sod_option:last").addClass("groupchild"),n.is(":disabled")&&t.find(".sod_option:last").addClass("disabled"))):$("<span/>",{class:"sod_option optgroup "+u,title:v,html:v,"data-label":v}).appendTo(t)},focusSod:function(){var e=$(this);e.hasClass("disabled")?d.blurSod(e):(d.blurSod($(".sod_select.focus").not(e)),e.addClass("focus"),$("html").on("click.sodBlur",function(){d.blurSod(e)}))},triggerSod:function(e){e.stopPropagation();var t=$(this),a=t.find(".sod_list"),o=t.data("placeholder"),s=t.find(".active"),i=t.find(".selected");t.hasClass("disabled")||t.hasClass("open")||t.hasClass("touch")?(clearTimeout(l),t.removeClass("open"),o&&(t.find(".sod_label").get(0).lastChild.nodeValue=s.text())):(t.addClass("open"),o&&!t.data("prefix")&&t.find(".sod_label").addClass("sod_placeholder").html(o),d.listScroll(a,i),d.checkViewport(t,a))},keyboardUse:function(e){var t=$(this),a=t.find(".sod_list"),l=t.find(".sod_option"),i=t.find(".sod_label"),n=t.data("cycle"),c=l.filter(".active"),r,p,h;return e.which>36&&e.which<41?(37===e.which||38===e.which?(p=c.prevAll(":not('.disabled, .optgroup')").first(),h=l.not(".disabled, .optgroup").last()):39!==e.which&&40!==e.which||(p=c.nextAll(":not('.disabled, .optgroup')").first(),h=l.not(".disabled, .optgroup").first()),!p.hasClass("sod_option")&&n&&(p=h),(p.hasClass("sod_option")||n)&&(c.removeClass("active"),p.addClass("active"),i.get(0).lastChild.nodeValue=p.text(),d.listScroll(a,p),t.hasClass("open")||(o=!0)),!1):(13===e.which||32===e.which&&t.hasClass("open")&&(" "===t.data("filter")[0]||""===t.data("filter"))?(e.preventDefault(),c.click()):32!==e.which||t.hasClass("open")||" "!==t.data("filter")[0]&&""!==t.data("filter")?27===e.which&&d.blurSod(t):(e.preventDefault(),o=!1,t.click()),void(0!==e.which&&(clearTimeout(s),t.data("filter",t.data("filter")+String.fromCharCode(e.which)),r=l.filter(function(){return 0===$(this).text().toLowerCase().indexOf(t.data("filter").toLowerCase())}).not(".disabled, .optgroup").first(),r.length&&(c.removeClass("active"),r.addClass("active"),d.listScroll(a,r),i.get(0).lastChild.nodeValue=r.text(),t.hasClass("open")||(o=!0)),s=setTimeout(function(){t.data("filter","")},500))))},optionHover:function(){var e=$(this);e.hasClass("disabled")||e.hasClass("optgroup")||e.siblings().removeClass("active").end().addClass("active")},optionClick:function(e){e.stopPropagation();var t=$(this),a=t.closest(".sod_select"),o=t.hasClass("disabled"),s=t.hasClass("optgroup"),d=a.find(".sod_option:not('.optgroup')").index(this);a.hasClass("touch")||(o||s||(a.find(".selected, .sod_placeholder").removeClass("selected sod_placeholder"),t.addClass("selected"),a.find("select option")[d].selected=!0,a.find("select").change()),clearTimeout(l),a.removeClass("open"))},selectChange:function(){var e=$(this),t=e.find(":selected"),o=t.text(),s=e.closest(".sod_select");s.find(".sod_label").get(0).lastChild.nodeValue=o,s.data("label",o),a.onChange.call(this),!s.data("links")&&!t.data("link")||t.data("link-external")?(s.data("links-external")||t.data("link-external"))&&window.open(t.val(),"_blank"):window.location.href=t.val()},blurSod:function(e){if($("body").find(e).length){var t=e.data("label"),a=e.data("placeholder"),s=e.find(".active"),d=e.find(".selected"),i=!1;clearTimeout(l),o&&!s.hasClass("selected")?(s.click(),i=!0):s.hasClass("selected")||(s.removeClass("active"),d.addClass("active")),!i&&a?e.find(".sod_label").get(0).lastChild.nodeValue=d.text():i||(e.find(".sod_label").get(0).lastChild.nodeValue=t),o=!1,e.removeClass("open focus"),e.blur(),$("html").off(".sodBlur")}},checkViewport:function(e,t){var a=e[0].getBoundingClientRect(),o=t.outerHeight();a.bottom+o+10>$(window).height()&&a.top-o>10?e.addClass("above"):e.removeClass("above"),l=setTimeout(function(){d.checkViewport(e,t)},200)},listScroll:function(e,t){var a=e[0].getBoundingClientRect(),o=t[0].getBoundingClientRect();a.top>o.top?e.scrollTop(e.scrollTop()-a.top+o.top):a.bottom<o.bottom&&e.scrollTop(e.scrollTop()-a.bottom+o.bottom)},isTouch:function(){return"ontouchstart"in window||navigator.MaxTouchPoints>0||navigator.msMaxTouchPoints>0}},i={destroy:function(){return this.each(function(){var e=$(this),t=e.parent();t.hasClass("sod_select")?(e.off("change"),t.find("span").remove(),e.unwrap()):console.log("Select or Die: There's no SoD to destroy")})},update:function(){return this.each(function(){var e=$(this),t=e.parent(),a=t.find(".sod_list:first");t.hasClass("sod_select")?(a.empty(),t.find(".sod_label").get(0).lastChild.nodeValue="",e.is(":disabled")&&t.addClass("disabled"),$("option, optgroup",e).each(function(){d.populateSoD($(this),a,t)})):console.log("Select or Die: There's no SoD to update")})},disable:function(e){return this.each(function(){var t=$(this),a=t.parent();a.hasClass("sod_select")?"undefined"!=typeof e?(a.find(".sod_list:first .sod_option[data-value='"+e+"']").addClass("disabled"),a.find(".sod_list:first .sod_option[data-label='"+e+"']").nextUntil(":not(.groupchild)").addClass("disabled"),$("option[value='"+e+"'], optgroup[label='"+e+"']",this).prop("disabled",!0)):a.hasClass("sod_select")&&(a.addClass("disabled"),t.prop("disabled",!0)):console.log("Select or Die: There's no SoD to disable")})},enable:function(e){return this.each(function(){var t=$(this),a=t.parent();a.hasClass("sod_select")?"undefined"!=typeof e?(a.find(".sod_list:first .sod_option[data-value='"+e+"']").removeClass("disabled"),a.find(".sod_list:first .sod_option[data-label='"+e+"']").nextUntil(":not(.groupchild)").removeClass("disabled"),$("option[value='"+e+"'], optgroup[label='"+e+"']",this).prop("disabled",!1)):a.hasClass("sod_select")&&(a.removeClass("disabled"),t.prop("disabled",!1)):console.log("Select or Die: There's no SoD to enable")})}};return i[e]?i[e].apply(this,Array.prototype.slice.call(arguments,1)):"object"!=typeof e&&e?void $.error('Select or Die: Oh no! No such method "'+e+'" for the SoD instance'):d.initSoD.apply(this,arguments)}}(jQuery);