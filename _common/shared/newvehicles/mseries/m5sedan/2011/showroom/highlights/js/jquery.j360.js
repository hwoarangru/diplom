/**
 * j360 jQuery plugin
 * author     Stable Flow
 * copyright  (c) 2009-2010 by StableFlow
 * link       http://www.stableflow.com/downloads/jquery-plugins/360-degrees-product-view/
 *
 * Version: 1.0.0 (12/13/2010)
 * (modified by raust/interone)
 * Requires: jQuery v1.3+
 *
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 */
(function($){
  $.fn.j360 = function(options) {
    var defaults = {
      clicked: false,
      currImg: 1
    }
    var options = jQuery.extend(defaults, options);
    return this.each(function() {
      var $obj = jQuery(this);
      var aImages = {};
      var bImages = {};
      var currentImages = {};
      $overlay = $obj.clone(true);
      $overlay.html('<img src="' + getWcmsPrefix() + '/_common/shared/newvehicles/mseries/m5sedan/2011/showroom/highlights/img/loader.gif' + '" class="loader" style="margin-top:' + ($obj.height()/2 - 15) + 'px; margin-left:' + ($obj.width()/2 - 15) + 'px" />');
      $overlay.attr('id', 'view_overlay');
      $overlay.css({
        'position' : 'absolute',
        'background-color' : '#fff',
        'z-index': '5',
        'top' : $obj.position().top,
        'left' : $obj.position().left
      });
      $obj.after($overlay);

      var imageTotal = 0;
      var imageSource = $obj.find('img').attr('src');
      var imageLength = parseInt($obj.find('img').attr('length'));

      for(i = 1; i <= imageLength; i++) {
        var source = imageSource.replace('_1.','_' + i + '.');
        var sourceLarge = source.replace('/engine/','/engine_large/');
        ++imageTotal;
        aImages[imageTotal] = source;
        bImages[imageTotal] = sourceLarge;
        preload(sourceLarge);
        preload(source);
      }

      var size = 's';
      if ($(window).width() >= 1025) {
        currentImages = bImages;
        size = 'l';
      }
      else {
        currentImages = aImages;
      }



      var imageCount = 0;
      jQuery('.preload_img').load(function() {
        if (++imageCount == imageTotal) {
          $overlay.css('opacity','0').css('cursor','w-resize');
          $obj.html('<img src="' + currentImages[1] + '" />');
          $overlay.bind('mousedown touchstart', function(e) {
            if (e.type == "touchstart") {
              options.currPos = window.event.touches[0].pageX;
            } else {
              options.currPos = e.pageX;
            }
            options.clicked = true;
            return false;
          });
          jQuery(document).bind('mouseup touchend', function() {
            options.clicked = false;
          });
          jQuery(document).bind('mousemove touchmove', function(e) {
            if (options.clicked) {
              var pageX;
              if (e.type == "touchmove") {
                pageX = window.event.targetTouches[0].pageX;
              } else {
                pageX = e.pageX;
              }
              var width_step = 4;
              if (Math.abs(options.currPos - pageX) >= width_step) {
                if (options.currPos - pageX >= width_step) {
                  options.currImg++;
                  if (options.currImg > imageTotal) {
                    options.currImg = 1;
                  }
                } else {
                  options.currImg--;
                  if (options.currImg < 1) {
                    options.currImg = imageTotal;
                  }
                }
                options.currPos = pageX;
                $obj.html('<img src="' + currentImages[options.currImg] + '" />');
              }
            }
          });
        }
      });

      var resizeRotateObject = function() {
        if ($(window).width() >= 1025 && size == 's') {
          currentImages = bImages;
          $obj.html('<img src="' + currentImages[options.currImg] + '" />');
          size = 'l';
        }
        else if($(window).width() < 1025 && size == 'l') {
          currentImages = aImages;
          $obj.html('<img src="' + currentImages[options.currImg] + '" />');
          size = 's';
        }
      }

      $(window).bind('resize', resizeRotateObject);

    });
  };
})(jQuery)


function preload(image) {
  if (typeof document.body == "undefined") return;
    try {
      var div = document.createElement("div");
      var s = div.style;
      s.position = "absolute";
      s.top = s.left = 0;
      s.visibility = "hidden";
      document.body.appendChild(div);
      div.innerHTML = "<img class=\"preload_img\" src=\"" + image + "\" />";
  } catch(e) {
  }
}