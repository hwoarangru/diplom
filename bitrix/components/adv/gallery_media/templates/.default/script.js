// ******** media gallery page START ******** //
function mediaGalleryInitialise() {
  var lightboxAnimation, thisParameterNumber, visibleLightboxObjectNumber, newCategoryLayerHeight, newIconLayerTop;
  var $imageObj = $('div#mediaGalleryLightboxLayer div#lightbox img#bigImage');
  var $flashObj = $('div#mediaGalleryLightboxLayer div#lightbox div#flashLayer');
  var startPageTitle = document.title;
  var startPageUrl = self.location.href;

  if(confTrackingEnabled) {
    var contentPageDownloadPath   = "/" + confCountryTopic + "/" + confLanguageTopic + "/_common/shared/tracking_redirect/download.html";
    $("div#mediaGalleryLightboxLayer div.downloadLayer ul.linklist li a").click(function () {
      var trackingUrl = buildValidServerRelativeUrl( contentPageDownloadPath ) + '?file=' + escape( buildValidServerRelativeUrl($(this).attr("href"))) + '&source=' + escape(self.location.pathname);
      trackAbsolute(trackingUrl, '', false, false);
      return true;
    });
  }

  function mediaGallerySetCategoryLayerHeight() {
    newCategoryLayerHeight = Math.round($('div#sales_navigation').offset().top - $('div#mediaGalleryCategoriesLayer').offset().top - 42);
    newIconLayerTop = Math.round($('div#sales_navigation').offset().top + 14);
    $('div#mediaGalleryCategoriesLayer').css('height',newCategoryLayerHeight+'px');
    $('div#mediaGalleryDialogButtons').css('top',newIconLayerTop+'px');
  }
  mediaGallerySetCategoryLayerHeight();
  $(window).resize(function() {
    mediaGallerySetCategoryLayerHeight();
  });

  $("a#sales_navigation_button_favs").mouseover(function() {
    var newHeight = Math.round($('div#sales_navigation').offset().top - $('div#mediaGalleryCategoriesLayer').offset().top - 63);
    var newTop = Math.round($('div#sales_navigation').offset().top - 41);
    $('div#mediaGalleryCategoriesLayer').css('height',newHeight+'px');
    $('div#mediaGalleryDialogButtons').css('top',newTop+'px');
  });
  $('div#sales_navigation_layer_favs').mouseout(function() {
    $('div#mediaGalleryCategoriesLayer').css('height',newCategoryLayerHeight+'px');
    $('div#mediaGalleryDialogButtons').css('top',newIconLayerTop+'px');
  });

  $('div.category img').each(function(i) {
    if(lightboxContent[i]["subheadline"] != '') {
      $('div.category div.thumbImageBox').parent().addClass('hasSubheadline');
    }
  }).mousemove(function(e) {
    $('div.dialogbox').each(function(i) {
      $('div#mediaGalleryThumbnailsMouseoverLayer'+i).css({
        left: Math.round(e.pageX - 10) + 'px',
        top: Math.round(e.pageY - $('div#mediaGalleryThumbnailsMouseoverLayer'+i).height() - 5) + 'px'
      });
    });
  }).hover(
    function() {
      var thisThumbImage = $('div.category img').index(this);
      if(lightboxContent[thisThumbImage]["hoverText"] != '') {
        $('div#mediaGalleryThumbnailsMouseoverLayer'+thisThumbImage).css('visibility','visible');
      }
    },
    function() {
      $('div.dialogbox').css('visibility','hidden');
    }
  );

  $('div.category').each(function(i) {
    if($(this).hasClass('hasSubheadline')) {
      var newCategoryHeight = $('div.category:eq('+ i +')').children().next().height();
      $('div.category:eq('+ i +')').css('height',newCategoryHeight+'px');
    }
  });

  function mediaGalleryShareIconIsDisplayedCheck() {
    if($('a.dialogButtonShare').attr('id') == 'shareDialog') {
      $('a.dialogButtonShare').attr('id','');
    }
    if($('div#mediaGalleryLightboxLayer div#lightbox').is(':visible')) {
      $('div#mediaGalleryDialogButtons a.dialogButtonShare, div#textLayer img.shareButton').hide();
      $('div#textLayer a.dialogButtonShare').attr('id','shareDialog');
      $('div#mediaGalleryDialogButtons img.shareButton, div#textLayer a.dialogButtonShare').show();
      shareUrl = self.location.href;
      shareTitle = document.title;
    } else {
      $('div#mediaGalleryDialogButtons img.shareButton, div#textLayer a.dialogButtonShare').hide();
      $('div#mediaGalleryDialogButtons a.dialogButtonShare').attr('id','shareDialog');
      $('div#mediaGalleryDialogButtons a.dialogButtonShare, div#textLayer img.shareButton').show();
      shareUrl = startPageUrl;
      shareTitle = startPageTitle;
    }
  }
  mediaGalleryShareIconIsDisplayedCheck();

  function mediaGalleryInitLightbox() {
    $('div#mediaGalleryLightboxLayer div#lightbox div#embedLayer').children().remove();
    $('div#mediaGalleryLightboxLayer div#lightbox').css({
      left: Math.round(($('div#stage').width() - ($('div#vehicle_navigation').width() + $('div#vehicle_navigation').position().left))/2 + $('div#vehicle_navigation').width() + $('div#vehicle_navigation').position().left) + 'px',
      top: Math.round(($('div#stage').height() - $('div#mainNavigation').height() - $('div#sales_navigation').height())/2 + $('div#mainNavigation').height()) + 'px',
      width: '1px',
      height: '1px'
    });

    $('div#mediaGalleryLightboxLayer img.lightboxArrowLeft').hover(
      function() {
        $('div#mediaGalleryLightboxLayer img.leftWhiteArrow').css('display','none');
        $('div#mediaGalleryLightboxLayer img.leftBlueArrow').css('display','block');
      },
      function() {
        $('div#mediaGalleryLightboxLayer img.leftBlueArrow').css('display','none');
        $('div#mediaGalleryLightboxLayer img.leftWhiteArrow').css('display','block');
      }
    );
    $('div#mediaGalleryLightboxLayer img.lightboxArrowRight').hover(
      function() {
        $('div#mediaGalleryLightboxLayer img.rightWhiteArrow').css('display','none');
        $('div#mediaGalleryLightboxLayer img.rightBlueArrow').css('display','block');
      },
      function() {
        $('div#mediaGalleryLightboxLayer img.rightBlueArrow').css('display','none');
        $('div#mediaGalleryLightboxLayer img.rightWhiteArrow').css('display','block');
      }
    );

    $('div.category img').each(function(i) {
      var lightboxContentWidth = Number(lightboxContent[i]["width"]);
      var lightboxContentHeight = Number(lightboxContent[i]["height"]);
      if(lightboxContentWidth > 612 || lightboxContentHeight > 383) {
        var differenceValue = (lightboxContentWidth > 612) ? Math.round(lightboxContentWidth - 612) : Math.round(lightboxContentHeight - 383);
        lightboxContent[i]["width"] = Math.round(lightboxContentWidth - differenceValue);
        lightboxContent[i]["height"] = Math.round(lightboxContentHeight - differenceValue);
        if(lightboxContent[i]["width"] > 612 || lightboxContent[i]["height"] > 383) {
          var differenceValue = (lightboxContent[i]["width"] > 612) ? Math.round(lightboxContent[i]["width"] - 612) : Math.round(lightboxContent[i]["height"] - 383);
          lightboxContent[i]["width"] = Math.round(lightboxContent[i]["width"] - differenceValue);
          lightboxContent[i]["height"] = Math.round(lightboxContent[i]["height"] - differenceValue);
        }
      }
    });
  }
  mediaGalleryInitLightbox();

  for(i=0; i < $('div.category img').length; i++) {
    $('div.category img:eq('+ i +')').wrap('<a href="#mediaID-'+ i +'" onfocus="this.blur();"></a>');
  }

  function mediaGalleryWriteLightboxContentObject(nbr, arrowFunc) {
    $('div#mediaGalleryLightboxLayer div#lightbox').removeClass("lightboxNoPreloader");
    switch (lightboxContent[nbr]["type"]) {
      case 'image':
        $imageObj.attr({src: lightboxContent[nbr]['src'], width: Number(lightboxContent[nbr]["width"]), height: Number(lightboxContent[nbr]["height"]), alt: ""});
        break;
      case 'embed':
        $('div#mediaGalleryLightboxLayer div#lightbox div#embedLayer').children().remove();
        var embedObjContent = '';
        embedObjContent += '<object id="videoLayer" width="'+ lightboxContent[nbr]["width"] +'" height="'+ lightboxContent[nbr]["height"] +'">\r\n';
        embedObjContent += '  <param name="FlashVars" value="'+ lightboxContent[nbr]["embedParameter"] +'" />\r\n';
        embedObjContent += '  <param name="movie" value="'+ lightboxContent[nbr]["src"] +'" />\r\n';
        embedObjContent += '  <param name="wmode" value="transparent" />\r\n';
        embedObjContent += '  <embed src="'+ lightboxContent[nbr]["src"] +'" type="application/x-shockwave-flash" wmode="transparent" width="'+ lightboxContent[nbr]["width"] +'" height="'+ lightboxContent[nbr]["height"] +'" allowfullscreen="false" FlashVars="'+ lightboxContent[nbr]["embedParameter"] +'" />\r\n';
        embedObjContent += '</object>\r\n';
        $('div#mediaGalleryLightboxLayer div#lightbox div#embedLayer').html(embedObjContent);
        $('div#mediaGalleryLightboxLayer div#lightbox object#videoLayer').attr({width: lightboxContent[nbr]["width"], height: lightboxContent[nbr]["height"]});
        break;
      case 'flash':
        $('div#mediaGalleryLightboxLayer div#lightbox').addClass("lightboxNoPreloader");
        var flashLayer = new SWFObject(lightboxContent[nbr]["src"], "bmw_video", String(lightboxContent[nbr]["width"]), String(lightboxContent[nbr]["height"]), "9.0.115", "#ffffff");
        flashLayer.addParam("quality", "autohigh");
        flashLayer.addParam("allowScriptAccess", "sameDomain");
        flashLayer.addParam("wmode", "transparent");
        if(lightboxContent[nbr]["flashParameter"] != 'undefined') {
          flashLayer.addVariable("prm_flv_url", lightboxContent[nbr]["flashParameter"]);
          flashLayer.addVariable("prm_corelib", swf_corelib);
          flashLayer.addVariable("prm_components", swf_components);
          flashLayer.addVariable("prm_stage_width", String(lightboxContent[nbr]["width"]));
          flashLayer.addVariable("prm_stage_height", String(lightboxContent[nbr]["height"]));
          flashLayer.addVariable("prm_tracking_enabled", "true");
          flashLayer.addVariable("prm_version", "high");
        }
        flashLayer.write("flashLayer");
        break;
      default:
        break;
    }

    if(arrowFunc == 'true') {
      switch (lightboxContent[nbr]["type"]) {
        case 'image':
          $imageObj.fadeIn(200);
          break;
        case 'flash':
          $('div#flashLayer').css('display','block');
          break;
        default:
          break;
      }
      shareUrl = self.location.href;
      shareTitle = document.title;
      mediaGalleryReadImageParameter();
      initArrowLinks(nbr); /* visibleLightboxObjectNumber */
    }
  }

  function mediaGalleryHandleLayerVisibility() {
    $('div#lightbox > *').hide();
    $('div#lightbox div#closeButtonLayer, div#lightbox div#textLayer, div#mediaGalleryLightboxLayer img.leftWhiteArrow, div#mediaGalleryLightboxLayer img.rightWhiteArrow').show();
    if(lightboxContent[visibleLightboxObjectNumber]["type"] == 'image') {
      $imageObj.show();
    } else if(lightboxContent[visibleLightboxObjectNumber]["type"] == 'flash') {
      $flashObj.show();
    } else if(lightboxContent[visibleLightboxObjectNumber]["type"] == 'embed') {
      $('div#embedLayer').show();
    }
    mediaGalleryShareIconIsDisplayedCheck();
    initDownloadLinkList();
    lightboxAnimation = "finished";
  }

  if(startPageUrl.indexOf("?media_id=") != -1) {
    startPageUrl = startPageUrl.replace("?media_id=", "#");
    self.location.href = startPageUrl;
  }

  function mediaGalleryReadImageParameter() {
    var startNbr = Math.round(self.location.href.lastIndexOf("#mediaID-") + 9);
    var endNbr = (self.location.href.lastIndexOf("?") > self.location.href.lastIndexOf("#mediaID-")) ? self.location.href.lastIndexOf("?") : self.location.href.length;
    thisParameterNumber = ($('div.category img').length - 1 < self.location.href.substring(startNbr, endNbr)) ? 0 : self.location.href.substring(startNbr, endNbr);
  }

  if(self.location.href.lastIndexOf('#') != -1) {
    var titleEndNbr = document.title.lastIndexOf('#');
    document.title = document.title.slice(0, titleEndNbr);
    if(self.location.href.lastIndexOf("#mediaID-") != -1) {
      mediaGalleryReadImageParameter();
      for(i=0; i < lightboxContent.length; i++) {
        if(lightboxContent[i]['parameter'] == '#mediaID-'+thisParameterNumber) {
          visibleLightboxObjectNumber = i;
        }
        lightboxContent[i]["isVisible"] = 'false';
      }
      lightboxContent[visibleLightboxObjectNumber]["isVisible"] = 'true';
      initArrowLinks(visibleLightboxObjectNumber);
      $('div.downloadLayer').css('display','none');
      $('div.downloadLayer:eq('+ visibleLightboxObjectNumber +')').css('display','block');
      $('div#mediaGalleryLightboxLayer div#lightbox').addClass("lightboxNoPreloader");
      mediaGalleryWriteLightboxContentObject(visibleLightboxObjectNumber, 'false');
      $('div#mediaGalleryLightboxLayer').css('display','block');
      $('div#mediaGalleryLightboxLayer div#blackLayer').css({opacity: '0.5'});
      $('div#mediaGalleryLightboxLayer div#blackLayer').fadeIn(200, mediaGallerySetLightboxPosition(mediaGalleryHandleLayerVisibility,lightboxContent[visibleLightboxObjectNumber]["width"],lightboxContent[visibleLightboxObjectNumber]["height"]));
    } else {
      var endNbr = self.location.href.lastIndexOf('#');
      self.location.href = self.location.href.slice(0, endNbr);
    }
  }

  function mediaGallerySetLightboxPosition(callBackFunction, bigImageWidth, bigImageHeight) {
    $('div#mediaGalleryCategoriesLayer').css('overflow','hidden');
    var lightboxLeft = Math.round(($('div#stage').width() - ($('div#vehicle_navigation').width() + $('div#vehicle_navigation').position().left))/2 + $('div#vehicle_navigation').width() + $('div#vehicle_navigation').position().left - (bigImageWidth + 20)/2);
    var lightboxTop = Math.round(($('div#stage').height() - $('div#mainNavigation').height() - $('div#sales_navigation').height())/2 + $('div#mainNavigation').height() - (bigImageHeight + 75)/2);
    var lightboxWidth = Math.round(bigImageWidth + 20);
    var lightboxHeight = Math.round(bigImageHeight + 75);
    $('div#mediaGalleryLightboxLayer img.lightboxArrowLeft').animate({
      left: Math.round(lightboxLeft - $('div#mediaGalleryLightboxLayer img.lightboxArrowLeft').width() - 9) + 'px',
      top: Math.round(lightboxTop + lightboxHeight/2 - $('div#mediaGalleryLightboxLayer img.lightboxArrowLeft').height()/2) + 'px'
    }, 400);
    $('div#mediaGalleryLightboxLayer img.lightboxArrowRight').animate({
      left: Math.round(lightboxLeft + lightboxWidth + 9) + 'px',
      top: Math.round(lightboxTop + lightboxHeight/2 - $('div#mediaGalleryLightboxLayer img.lightboxArrowRight').height()/2) + 'px'
    }, 400);
    $('div#mediaGalleryLightboxLayer div#lightbox').animate({
      left: Math.round(($('div#stage').width() - ($('div#vehicle_navigation').width() + $('div#vehicle_navigation').position().left))/2 + $('div#vehicle_navigation').width() + $('div#vehicle_navigation').position().left - (bigImageWidth + 20)/2) + 'px',
      top: Math.round(($('div#stage').height() - $('div#mainNavigation').height() - $('div#sales_navigation').height())/2 + $('div#mainNavigation').height() - (bigImageHeight + 75)/2) + 'px',
      width: bigImageWidth + 20 + 'px',
      height: bigImageHeight + 75 + 'px'
    }, 400, callBackFunction);
  }

  function initDownloadLinkList() {
    for(a=0; a < $('div.downloadLayer').length; a++) {
      $('div.downloadLayer:eq('+ a +') ul.linklist').css('display','block');
    }
  }

  $('div#mediaGalleryCategoriesLayer div.category img').click(function() {
    mediaGalleryShareIconIsDisplayedCheck();
    visibleLightboxObjectNumber = $('div.category img').index(this);
    for(i=0; i < lightboxContent.length; i++) {
      lightboxContent[i]["isVisible"] = 'false';
    }
    lightboxContent[visibleLightboxObjectNumber]["isVisible"] = 'true';
    var thisCategoryNumber = lightboxContent[visibleLightboxObjectNumber]["category"];
    document.title = startPageTitle;

    $('div#mediaGalleryLightboxLayer div#lightbox').addClass("lightboxNoPreloader");
    $('div.downloadLayer').css('display','none');
    $('div.downloadLayer:eq('+ visibleLightboxObjectNumber +')').css('display','block');
    mediaGalleryReadImageParameter();
    initArrowLinks(visibleLightboxObjectNumber);
    mediaGalleryWriteLightboxContentObject(visibleLightboxObjectNumber, 'false');
    $('div#mediaGalleryLightboxLayer').css('display','block');
    $('div#mediaGalleryLightboxLayer div#blackLayer').css({opacity: '0.5'});
    $('div#mediaGalleryLightboxLayer div#blackLayer').fadeIn(200, handleLightboxPosition);

    function handleLightboxPosition() {
      mediaGallerySetLightboxPosition(showLightboxContent,lightboxContent[visibleLightboxObjectNumber]['width'],lightboxContent[visibleLightboxObjectNumber]['height']);
    }
    function showLightboxContent() {
      $('div#lightbox div#closeButtonLayer').fadeIn(100);
      $('div#lightbox img, div#mediaGalleryLightboxLayer div#lightbox div#textLayer').fadeIn(300);
      mediaGalleryHandleLayerVisibility();
      $('div#mediaGalleryLightboxLayer img.lightboxArrowLeft').css({
        left: Math.round($('div#mediaGalleryLightboxLayer div#lightbox').offset().left - $('div#mediaGalleryLightboxLayer img.lightboxArrowLeft').width() - 9) + 'px',
        top: Math.round($('div#mediaGalleryLightboxLayer div#lightbox').offset().top + $('div#mediaGalleryLightboxLayer div#lightbox').height()/2 - $('div#mediaGalleryLightboxLayer img.lightboxArrowLeft').height()/2) + 'px'
      });
      $('div#mediaGalleryLightboxLayer img.lightboxArrowRight').css({
        left: Math.round($('div#mediaGalleryLightboxLayer div#lightbox').offset().left + $('div#mediaGalleryLightboxLayer div#lightbox').width() + 9) + 'px',
        top: Math.round($('div#mediaGalleryLightboxLayer div#lightbox').offset().top + $('div#mediaGalleryLightboxLayer div#lightbox').height()/2 - $('div#mediaGalleryLightboxLayer img.lightboxArrowRight').height()/2) + 'px'
      });
      $('div#mediaGalleryLightboxLayer img.leftWhiteArrow, div#mediaGalleryLightboxLayer img.rightWhiteArrow').css('display','block');
    }
  });

  $('div#mediaGalleryLightboxLayer a.closeLink').click(function() {
    $('div#mediaGalleryCategoriesLayer').css('overflow','auto');
    if(lightboxAnimation == "finished") {
      lightboxAnimation = "start";
      $('div#mediaGalleryLightboxLayer div#lightbox').fadeOut(200);
      $('div#toggleLightboxLayer').css('display','none');
      $('div#mediaGalleryLightboxLayer div#blackLayer').fadeOut(250, hideMediaGalleryLightboxLayer);
    }
    function hideMediaGalleryLightboxLayer() {
      var flashLayer = new SWFObject("", "", "1", "1", "9.0.115", "#ffffff");
      flashLayer.write("flashLayer");
      $('div#mediaGalleryLightboxLayer').fadeOut(200, hideLightboxContent);
    }
    function hideLightboxContent() {
      mediaGalleryShareIconIsDisplayedCheck();
      $('div#mediaGalleryLightboxLayer div#lightbox > *, div#mediaGalleryLightboxLayer img').css('display','none');
      $('div#mediaGalleryLightboxLayer div#lightbox, div#toggleLightboxLayer').css('display','block');
      $('div#mediaGalleryLightboxLayer div#lightbox div#embedLayer, div#mediaGalleryLightboxLayer div#lightbox div#embedLayer > *').css('display','block');
      document.title = startPageTitle;
      mediaGalleryInitLightbox();
    }
  });

  $('div#toggleLightboxLayer img').click(function() {
    mediaGalleryReadImageParameter();
    for(i=0; i < lightboxContent.length; i++) {
      if(lightboxContent[i]['parameter'] == '#mediaID-'+thisParameterNumber) {
        visibleLightboxObjectNumber = i;
      }
      lightboxContent[i]["isVisible"] = 'false';
    }

    var thisNumber;
    if($(this).hasClass('lightboxArrowLeft')) {
      thisNumber = (visibleLightboxObjectNumber == 0) ? Math.round(lightboxContent.length - 1) : Math.round(visibleLightboxObjectNumber - 1);
    } else if($(this).hasClass('lightboxArrowRight')) {
      thisNumber = (visibleLightboxObjectNumber == Math.round($('div.category img').length - 1)) ? 0 : Math.round(visibleLightboxObjectNumber + 1);
    }

    lightboxContent[thisNumber]["isVisible"] = 'true';
    initDownloadLinkList();
    var thisCategoryNumber = lightboxContent[thisNumber]["category"];
    document.title = startPageTitle;
    $flashObj.css('display','none');
    $('div#mediaGalleryLightboxLayer div#lightbox div#embedLayer').children().remove();
    $('div.downloadLayer').css('display','none');
    $('div.downloadLayer:eq('+ thisNumber +')').css('display','block');
    $('div#lightbox img#bigImage').fadeOut(200, mediaGallerySetLightboxPosition(showPreviousLightboxContent,lightboxContent[thisNumber]["width"],lightboxContent[thisNumber]["height"]));
    function showPreviousLightboxContent() {
      $imageObj.attr({src: lightboxContent[thisNumber]['src'], width: lightboxContent[thisNumber]["width"], height: lightboxContent[thisNumber]["height"], alt: ""});
      $imageObj.hide();
      mediaGalleryWriteLightboxContentObject(thisNumber, 'true');
    }
  });

  function initArrowLinks(thisNumber) {
    var previousImageNumber = (thisNumber - 1 < 0) ? $('div.category img').length - 1 : thisNumber - 1;
    var nextImageNumber = (thisNumber + 1 > $('div.category img').length - 1) ? 0 : thisNumber + 1;
    if($('div#mediaGalleryLightboxLayer img.lightboxArrowRight').parent().is('a')) {
      $('div#mediaGalleryLightboxLayer img.lightboxArrowRight').parent().attr('href',lightboxContent[nextImageNumber]["parameter"]);
      $('div#mediaGalleryLightboxLayer img.lightboxArrowLeft').parent().attr('href',lightboxContent[previousImageNumber]["parameter"]);
    } else {
      $('div#mediaGalleryLightboxLayer img.lightboxArrowRight').wrap('<a href="'+ lightboxContent[nextImageNumber]["parameter"] + '" onfocus="this.blur();"></a>');
      $('div#mediaGalleryLightboxLayer img.lightboxArrowLeft').wrap('<a href="'+ lightboxContent[previousImageNumber]["parameter"] + '" onfocus="this.blur();"></a>');
    }
  }
}
// ******** media gallery page END ******** //
