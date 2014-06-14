         var vehicle_navigation_teaser = "r";
          var userHovered = false;
        $(document).ready(function() {
          $("#overview_linklist div.overviewLink").mouseover(
            function () {
              overviewResetLinklist();
              $(this).hide();
              $(this).next().show();
          });
  
        $('ul#map li').hover(function(e) {
            $('.ul#map li a').removeClass('active');
            $('.carlink').hide();
            userHovered = true;
            $(this).find('.carlink').show();
            $(this).find('.carlink').addClass('active');
        }, function(e) {
            $(this).find('a:first-child').removeClass('active');
            $(this).find('.carlink').removeClass('active');
            $(this).find('.carlink').hide();
        })
       $('ul#map li a.carlink').hover(function(e) {
             $(this).parent().find('a:first-child').addClass('active');
             e.stopPropagation();
        }, function(e) {
             e.stopPropagation();
        });
if(highbandUser && !getCookieValue('mperformanceaccessories2012flash')) {
    var flashMovie = /* VIPURL */"../../../../../../_common/shared/owners/accessories/performance/phase5/swf/m_performance_videoplayer.swf";
    var flashObject = new SWFObject(flashMovie, "flashcontent", "1024", "634", "9.0.124", "#000000");
    flashObject.addVariable("video_url", "../../../../../../../ru/ru/owners/accessories/performance/phase_5/_shared/swf/mperformance_intro.flv");
    flashObject.addVariable("on_video_complete", "videoCompleteHandler");
    flashObject.addParam("allowFullScreen","true");
    flashObject.addParam("quality","high");
    flashObject.addParam("allowScriptAccess","sameDomain");
    flashObject.addParam("menu","false");
    flashObject.addParam("wmode", "transparent");
    flashObject.addParam("bgcolor", "#000000");
flashActive = flashObject.write("stage_flash");
    if(flashActive){
    $("#stage_flash").show();
    setCookie('mperformanceaccessories2012flash', "true", "", "/");
    }else{
     $("#stage").show();
    }
		
		
  }else{
     $("#stage").show('fast', function(){
          if(!getCookieValue('mperformanceaccessories2012')) {
           animateNextCar(0);
           setCookie('mperformanceaccessories2012', "true", "", "/");
          }          
        });
  }
         
        });
        
        function animateNextCar(slideTimer) {
            var navigationLength = $("ul#map li").length;
            var j = slideTimer + 1;
            $.doTimeout('nextimage',1500,
                    function(elem) {
                    if (userHovered) {
                        $.doTimeout('removeclass');
                        $.doTimeout('removecarlinkclass');
                        $.doTimeout('nextimage');
                        return false;
                    }
                        $('ul#map li:eq(' + slideTimer + ') a').doTimeout('removeclass', 1500, 'removeClass', 'active')
                                .addClass('active');
                        $('ul#map li:eq(' + slideTimer + ') .carlink').doTimeout('removecarlinkclass', 1500, 'hide')
                                .show();
                        if (j < navigationLength) {
                            animateNextCar(j);
                        }
                    });
        }
        function overviewResetLinklist() {
          $("#overview_linklist a.overview_white").each(function() {
            $(this).parent().show();
            $(this).parent().next().hide();
          });
        }
      
      function videoCompleteHandler(){
        
        $('#stage_flash').fadeOut();
        $('#stage').fadeIn('slow', function(){
          if(!getCookieValue('mperformanceaccessories2012')) {
           animateNextCar(0);
           setCookie('mperformanceaccessories2012', "true", "", "/");
          }          
        });
      }
      /*
     * jQuery doTimeout: Like setTimeout, but better! - v1.0 - 3/3/2010
     * http://benalman.com/projects/jquery-dotimeout-plugin/
     * 
     * Copyright (c) 2010 "Cowboy" Ben Alman
     * Dual licensed under the MIT and GPL licenses.
     * http://benalman.com/about/license/
     */
    (function($){var a={},c="doTimeout",d=Array.prototype.slice;$[c]=function(){return b.apply(window,[0].concat(d.call(arguments)))};$.fn[c]=function(){var f=d.call(arguments),e=b.apply(this,[c+f[0]].concat(f));return typeof f[0]==="number"||typeof f[1]==="number"?this:e};function b(l){var m=this,h,k={},g=l?$.fn:$,n=arguments,i=4,f=n[1],j=n[2],p=n[3];if(typeof f!=="string"){i--;f=l=0;j=n[1];p=n[2]}if(l){h=m.eq(0);h.data(l,k=h.data(l)||{})}else{if(f){k=a[f]||(a[f]={})}}k.id&&clearTimeout(k.id);delete k.id;function e(){if(l){h.removeData(l)}else{if(f){delete a[f]}}}function o(){k.id=setTimeout(function(){k.fn()},j)}if(p){k.fn=function(q){if(typeof p==="string"){p=g[p]}p.apply(m,d.call(n,i))===true&&!q?o():e()};o()}else{if(k.fn){j===undefined?e():k.fn(j===false);return true}else{e()}}}})(jQuery);
      
     /*
    * jQuery css clip animation support -- Jim Palmer
    * version 0.1.2b
    * idea spawned from jquery.color.js by John Resig
    * Released under the MIT license.
    */
    (function(jQuery) {
    jQuery.fx.step.clip = function(fx) {
    if (fx.state == 0) {
    /* handle three valid possibilities
    * val val val val
    * val, val, val, val
    * val,val,val,val
    */
    var cRE = /rect\(([0-9]{1,})(px|em)[,\s]+([0-9]{1,})(px|em)[,\s]+([0-9]{1,})(px|em)[,\s]+([0-9]{1,})(px|em)\)/;
    // no longer replace commas - they may not exist and the regex compensates for them anyway
    //grab the curent clip region of the element
    $elem = $(fx.elem);
    var clip = cRE.test(fx.elem.style.clip) ? fx.elem.style.clip : 'rect(0px ' + $elem.width() + 'px ' + $elem.height() + 'px 0px)';
    fx.start = cRE.exec(clip.replace(/,/g, " "));
    // handle the fx.end error
    try {
    fx.end = cRE.exec(fx.end.replace(/,/g, ''));
    } catch (e) {
    return false;
    }
    }
    var sarr = new Array(), earr = new Array(), spos = fx.start.length, epos = fx.end.length,
    emOffset = fx.start[ss + 1] == 'em' ? (parseInt($(fx.elem).css('fontSize')) * 1.333 * parseInt(fx.start[ss])) : 1;
    for (var ss = 1; ss < spos; ss += 2) { sarr.push(parseInt(emOffset * fx.start[ss])); }
    for (var es = 1; es < epos; es += 2) { earr.push(parseInt(emOffset * fx.end[es])); }
    fx.elem.style.clip = 'rect(' +
    parseInt((fx.pos * (earr[0] - sarr[0])) + sarr[0]) + 'px ' +
    parseInt((fx.pos * (earr[1] - sarr[1])) + sarr[1]) + 'px ' +
    parseInt((fx.pos * (earr[2] - sarr[2])) + sarr[2]) + 'px ' +
    parseInt((fx.pos * (earr[3] - sarr[3])) + sarr[3]) + 'px)';
    }
    })(jQuery);
    var userAction = false;
    var currentProduct = null;
    var currentProductDetail = null;
    var currentProductImage = 1;
    var maxProductImages = 1;
    var slideTimer = 0;
    var flashvars = {};
    var params = {};
    params.scale = "noscale";
    params.allowFullScreen = "true";
    params.allowScriptAccess = "always";
    params.menu = "false";
    params.bgcolor = "#000000";
    params.wmode = "opaque";
    var attributes = {};
   $(document).ready(function(){
      
 $.each($('.product_detail_image'), function() {
     if ($(this).attr('preloadlarge')!='') {    
          var rightPosition = 0;
          if($(this).parent().find('.product_detail_image').length > 1){ 
           rightPosition = 47;            
          }
         $(this).css('cursor','pointer');
         $(this).append('<div class="zoomwrapper" style="right:'+rightPosition+'px;"><a href="javascript:void(0)" class="zoom"></a></div>');
     }
 });
   $('#highlights_accordion .highlight div.title').mouseover(function() {
       $('div.title h1').css("color", "#ffffff");
        $.each($('div.title'), function() {
            if ($(this).parent().attr('id') != currentProduct) {
                $('.title h1').css("color", "#ffffff");
            }
        });
        if ($(this).parent().attr('id') != currentProduct) {
            $(this).parent().children('div.title').removeClass('semitransparent').addClass('active');
        }
    });
    $('#highlights_accordion .highlight .title').mouseout(function() {
        $('div.title h1').css("color", "#ffffff");
        if (currentProduct != null) {
            $('div.title').addClass('semitransparent');
            $.each($('div.title'), function() {
                if ($(this).parent().attr('id') == currentProduct) {
                    $(this).parent().children('div.title').removeClass('semitransparent').addClass('active');
                } else {
                    $(this).parent().children('div.title').removeClass('active');
                }
            });
        } else {
            $('div.title').removeClass('active');
        }
    });
    $('#highlights_accordion .highlight div.title').click(function() {
        userAction = true;
        if ($(this).parent().attr('id') != currentProduct) {
            currentProduct = $(this).parent().attr('id');
            $('.products').hide();
            $(this).parent().children('.products').slideDown();
            $('div.title').addClass('semitransparent').removeClass('active');
            $(this).parent().children('div.title').removeClass('semitransparent').addClass('active');
            $('#stage #background img').attr('src', $(this).parent().children('div.title').attr('background-img'));
            $('#stage #overlay img').attr('src', $(this).parent().children('div.title').attr('background-img-dark'));
            $('#overlay').show();
        }
    });
    $('#highlights_accordion .highlight .products .productimage a').mouseover(function() {
        $('.blend').stop().css({
            display: 'block'
        }).animate({
                opacity: 0.5
            }, 500);
        $(this).find('.blend').hide();
    });
    $('#highlights_accordion .highlight .products .productimage a').mouseout(function() {
        $('.blend').stop().animate({
            opacity: 0
        }, 500, function() {
            $('.blend').hide();
        });
    });
      $('.product_detail_image').click(function(event) {
       if($(this).attr('preloadlarge')!=""){
          $('div#mediaGalleryLightboxLayer #bigImage').attr('src', $(this).attr('preloadlarge'));
          $('div#mediaGalleryLightboxLayer #textLayer').html('<h3>'+$(this).parent().parent().find('.product_text').find('h3:first-child').html()+'</h3>');
          $('div#mediaGalleryLightboxLayer').css('z-index','1000').show();  
          $('div#mediaGalleryLightboxLayer div#blackLayer').css({opacity: '0.5'});
          $('div#mediaGalleryLightboxLayer div#blackLayer,div#mediaGalleryLightboxLayer div#lightbox,div#mediaGalleryLightboxLayer #bigImage,div#mediaGalleryLightboxLayer,div#mediaGalleryLightboxLayer div#lightbox div.closeButtonLayer').fadeIn(200);
       }
      });
      $('div#mediaGalleryLightboxLayer a.closeLink,div#mediaGalleryLightboxLayer div#blackLayer').click(function() {
          $('div#mediaGalleryLightboxLayer #bigImage,div#mediaGalleryLightboxLayer div#lightbox div.closeButtonLayer').css('display','none');
          $('div#mediaGalleryLightboxLayer #textLayer').html('');
          $('div#mediaGalleryLightboxLayer div#lightbox,div#mediaGalleryLightboxLayer div#blackLayer').fadeOut(200);
          $('div#mediaGalleryLightboxLayer #bigImage').attr('src', '');
          $('div#mediaGalleryLightboxLayer').css('z-index','0').hide();
      });
    $('.detaillink').click(function(event) {
        event.preventDefault();
        currentProductImage = 0;
        maxProductImages = $('#details_' + $(this).attr('id') + ' .product_detail_image').length;
        $('#details_' + $(this).attr('id') + ' .teaser_image_icon_counter').html('1/' + maxProductImages);
        writeImages($('#details_' + $(this).attr('id') + ' .product_detail_image'));
        $('#highlight_overview').hide();
        $('#highlights_accordion h3.joy_small').hide();
        $('#highlight_details').show();
        $('#details_' + $(this).parent().parent().parent().attr('id')).show();
        currentProductDetail = '#details_' + $(this).attr('id');
        $('#details_' + $(this).attr('id')).show();
        if ($('#details_' + $(this).attr('id') + ' .product_detail_image').length > 0) {
            $('#details_' + $(this).attr('id') + ' .product_detail_image:eq(0)').show();
        }
        if ($('#details_' + $(this).attr('id') + ' .product_detail_image').length > 1) {
            $('#details_' + $(this).attr('id') + ' .teaser_image_icon').show();
        }
        if ($('#details_' + $(this).parent().parent().parent().attr('id') + ' .product_detail').length <= 1) {
            $('#next_details').hide();
            $('#prev_details').hide();
        } else {
            $('#next_details').show();
            $('#prev_details').show();
        }
        if (($(this).attr('background-img') && $(this).attr('background-img') != '') && ($(this).attr('background-img-dark') && $(this).attr('background-img-dark') != '')) {
            $('#stage #background img').attr('src', $(this).attr('background-img'));
            $('#stage #overlay img').attr('src', $(this).attr('background-img-dark'));
        } else {
            $('#stage #background img').attr('src', $(this).parent().parent().parent().children('div.title').attr('background-img'));
            $('#stage #overlay img').attr('src', $(this).parent().parent().parent().children('div.title').attr('background-img-dark'));
        }
        $('#overlay').show();
        if ($(this).attr('pos1') && $(this).attr('pos2') && $(this).attr('pos3') && $(this).attr('pos4') && $(this).attr('pos1') != '' && $(this).attr('pos2') != '' && $(this).attr('pos3') != '' && $(this).attr('pos4') != '') {
            $('#overlayborder').show();
            $('#background').show();
            animateBackground($(this).attr('pos1'),$(this).attr('pos2'),$(this).attr('pos3'),$(this).attr('pos4'));
        } else {
            $('#background').hide();
            $('#overlayborder').hide(); 
            $('#background').stop().animate({'clip':'rect(0px 0px 0px 0px)'});
            $('#overlayborder').css({'height': '0px','width': '0px','left':  '0px','top':  '0px'});
        }
    });
    $('#close_details').click(function(event) {
        event.preventDefault();
        currentProductImage = 0;
        $('#background').css({'clip':'rect(0px 1024px 634px 0px)'}).show();
        $('#highlight_overview').show();
        $('#highlights_accordion h3.joy_small').show();
        $('#highlight_details').hide();
        $('.product_details').hide();
        $('.product_detail').hide();
        $('#overlayborder').hide();
        $('#next_details').hide();
        $('#prev_details').hide();
        $('#overlay').hide();
        stopFlash();
    });
    $('#next_details').click(function(event) {
        event.preventDefault();
        $(currentProductDetail).hide();
        stopFlash();
        nextDivIsDefined = $(currentProductDetail).next().attr('class');
        currentProductImage = 0;
        nextDivPosition = $(currentProductDetail).next();
        if (nextDivIsDefined != 'product_detail') {
            nextDivPosition = $(currentProductDetail).parent().find('.product_detail:first-child');
        }        
        maxProductImages = nextDivPosition.find('.teaser_image').find('.product_detail_image').length;
        nextDivPosition.find('.teaser_image').find('.teaser_image_icon_counter').html('1/' + maxProductImages);
        writeImages(nextDivPosition.find('.teaser_image').find('.product_detail_image'));
        nextDivPosition.show();
        if ((nextDivPosition.attr('background-img') && nextDivPosition.attr('background-img') != '') && (nextDivPosition.attr('background-img-dark') && nextDivPosition.attr('background-img-dark') != '')) {
            $('#stage #background img').attr('src', nextDivPosition.attr('background-img'));
            $('#stage #overlay img').attr('src', nextDivPosition.attr('background-img-dark'));
        } else {
            var currentParentId = $(currentProductDetail).parent().attr('id').replace('details_', '');
            $('#stage #background img').attr('src', $('#' + currentParentId).find('div.title').attr('background-img'));
            $('#stage #overlay img').attr('src', $('#' + currentParentId).find('div.title').attr('background-img-dark'));
        }
        currentProductDetail = '#' + nextDivPosition.attr('id');
        if ($(currentProductDetail + ' .product_detail_image').length > 0) {
            $(currentProductDetail + ' .product_detail_image:eq(0)').show();
        }
        if ($(currentProductDetail + ' .product_detail_image').length > 1) {
            $(currentProductDetail + ' .teaser_image_icon').show();
        }
        var pos1 = nextDivPosition.attr("pos1");
        var pos2 = nextDivPosition.attr("pos2");
        var pos3 = nextDivPosition.attr("pos3");
        var pos4 = nextDivPosition.attr("pos4");
        if (pos1 && pos2 && pos3 && pos4 && pos1 != '' && pos2 != '' && pos3 != '' && pos4 != '') {
            $('#overlayborder').show();
            $('#background').show();
            $('#overlay').show();
            animateBackground(pos1,pos2,pos3,pos4);
        } else {
            $('#background').hide();
            $('#overlayborder').hide();
            $('#background').stop().animate({'clip':'rect(0px 0px 0px 0px)'});
            $('#overlayborder').css({'height': '0px','width': '0px','left':  '0px','top':  '0px'});
        }
    });
    $('#prev_details').click(function(event) {
        event.preventDefault();
        $(currentProductDetail).hide();
        stopFlash();
        prevDivIsDefined = $(currentProductDetail).prev().attr('class');
        currentProductImage = 0;
        prevDivPosition = $(currentProductDetail).prev();
        if (prevDivIsDefined != 'product_detail') {
            prevDivPosition = $(currentProductDetail).parent().find('.product_detail:eq('+(($(currentProductDetail).parent().find('.product_detail').length)-1) +')')
        }        
        maxProductImages = prevDivPosition.find('.teaser_image').find('.product_detail_image').length;
        prevDivPosition.find('.teaser_image').find('.teaser_image_icon_counter').html('1/' + maxProductImages);
        writeImages(prevDivPosition.find('.teaser_image').find('.product_detail_image'));
        prevDivPosition.show();
        if ((prevDivPosition.attr('background-img') && prevDivPosition.attr('background-img') != '') && (prevDivPosition.attr('background-img-dark') && prevDivPosition.attr('background-img-dark') != '')) {
            $('#stage #background img').attr('src', prevDivPosition.attr('background-img'));
            $('#stage #overlay img').attr('src', prevDivPosition.attr('background-img-dark'));
        } else {
            var currentParentId = $(currentProductDetail).parent().attr('id').replace('details_', '');
            $('#stage #background img').attr('src', $('#' + currentParentId).find('div.title').attr('background-img'));
            $('#stage #overlay img').attr('src', $('#' + currentParentId).find('div.title').attr('background-img-dark'));
        }
        currentProductDetail = '#' + prevDivPosition.attr('id');
        if ($(currentProductDetail + ' .product_detail_image').length > 0) {
            $(currentProductDetail + ' .product_detail_image:eq(0)').show();
        }
        if ($(currentProductDetail + ' .product_detail_image').length > 1) {
            $(currentProductDetail + ' .teaser_image_icon').show();
        }
        var pos1 = prevDivPosition.attr("pos1");
        var pos2 = prevDivPosition.attr("pos2");
        var pos3 = prevDivPosition.attr("pos3");
        var pos4 = prevDivPosition.attr("pos4");
        if (pos1 && pos2 && pos3 && pos4 && pos1 != '' && pos2 != '' && pos3 != '' && pos4 != '') {
            $('#overlayborder').show();
            $('#background').show();
            $('#overlay').show();
            animateBackground(pos1,pos2,pos3,pos4);
        } else {
            $('#background').hide();
            $('#overlayborder').hide();
            $('#background').stop().animate({'clip':'rect(0px 0px 0px 0px)'});
            $('#overlayborder').css({'height': '0px','width': '0px','left':  '0px','top':  '0px'});
        }
    });
   $('.vehicle_navigation_teaser_button').click(function(event) {
         event.preventDefault();
         var prodImg = $('#' + $(this).parent().parent().parent().attr('id') + ' .product_detail_image:eq(' + currentProductImage + ')');
         stopFlash();
         if (currentProductImage < (maxProductImages - 1)) {
             $(prodImg).hide();
             if($(prodImg).next().attr('preloadflash')!=''){
               swfobject.embedSWF($(prodImg).next().attr('preloadflash'), $(prodImg).next().children('div').attr('id'), "274", "151", "9.0.124", null, flashvars, params, attributes);
              }
             $(prodImg).next().show();
             $(this).parent().find('.teaser_image_icon_counter').html((currentProductImage + 2) + '/' + maxProductImages);
             currentProductImage++;
         } else {
             $(prodImg).hide();
             if($('#' + $(this).parent().parent().parent().attr('id') + ' .product_detail_image:eq(0)').attr('preloadflash')!=''){
               swfobject.embedSWF($('#' + $(this).parent().parent().parent().attr('id') + ' .product_detail_image:eq(0)').attr('preloadflash'), $('#' + $(this).parent().parent().parent().attr('id') + ' .product_detail_image:eq(0)').find('div').attr('id'), "274", "151", "9.0.124", null, flashvars, params, attributes);
             }
             $('#' + $(this).parent().parent().parent().attr('id') + ' .product_detail_image:eq(0)').show();
             $(this).parent().find('.teaser_image_icon_counter').html('1/' + maxProductImages);
             currentProductImage = 0;
         }
     });
    animateNext(0);
});
function animateNext(slideTimer) {
    var navigationLength = $('#highlights_accordion').find('div.title').length;
    var j = slideTimer + 1;
    if (j >= navigationLength) {
        currentAnimation = $('div.title:eq(' + slideTimer + ')').delay(slideTimer + 250).animate({'marginLeft':'0px'}, 250);
        setTimeout("initializeSlide()", 4000);
    }
    currentAnimation = $('div.title:eq(' + slideTimer + ')').delay(slideTimer + 250).animate({'marginLeft':'0px'}, 250, function() {
        animateNext(j)
    });
}function writeImages(target){  
        $.each(target, function() {
            if ($(this).find('div:first-child').html() == '') {
                $(this).find('div:first-child').append('<img src="' + $(this).attr('preload') + '" />');
                if ($(this).attr('preloadflash')!='') {
                  $(this).html('<div id="'+$(this).find('div:first-child').attr('id')+'"></div>');
                }
            }
        });
    }
function stopFlash(){
 $.each($('.product_detail_image'), function() {
     if ($(this).attr('preloadflash')!='') {             
         $(this).html('<div id="'+$(this).children().attr('id')+'"></div>');
     }
 });
}function animateBackground(position1,position2,position3,position4){
            var topPos = (position1 * 1);
            var leftPos = (position4 * 1);
            var width = position2 - position4;
            var height = position3 - position1;
            $('#background').show().stop().animate({'clip':'rect(' + position1 + 'px ' + position2 + 'px ' + position3 + 'px ' + position4 + 'px)'},
                1000
            );
            $('#overlayborder').stop().animate({
                height: height,
                width: width,
                left: leftPos,
                top: topPos
            }, 1000);
}function initializeSlide() {
    if (!userAction) {
        currentProduct = 1;
        $('div.title:eq(' + (currentProduct - 1) + ')').parent().children('.products').slideDown();
        $('div.title').removeClass('active').addClass('semitransparent');
        $('#stage #background img').attr('src', $('div.title:eq(' + (currentProduct - 1) + ')').attr('background-img'));
        $('#stage #overlay img').attr('src', $('div.title:eq(' + (currentProduct - 1) + ')').attr('background-img-dark'));
        $('div.title:eq(' + (currentProduct - 1) + ')').removeClass('semitransparent').addClass('active');
    }
}      