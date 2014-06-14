var videoLoaded;
var scrollBlinkCounter = 0;

var Highlight = function () {

  var BACKGROUND_OVERLAP = 400;
  var PARAGRAPH_HEIGHT = 1000;
  var COLUMN_ANIMATION_SPEED = 1250;
  var AUTO_SCROLL_SPEED = 400;
  var SHOW_CLOSE_BUTTON_TIMER = 500;
  var IS_POSITION_FIXED_SUPPORTED = null;
  var IS_MACINTOSH = (navigator.userAgent.indexOf('Mac') != -1) ? true : false;
  var IS_CHROME = /chrome/.test(navigator.userAgent.toLowerCase());
  var AUDIO_TAG_SUPPORT = !! (document.createElement('audio').canPlayType);
  var VIDEO_TAG_SUPPORT = !! (document.createElement('video').canPlayType);
  var CANVAS_TAG_SUPPORT =  !!document.createElement('CANVAS').getContext;
  var FLASH_VIDEO_ACTIVE = false;
  var videosLoaded = 0;
  var imagesLoaded = false;
  var currentColumnId;
  var currentParagraph = '';
  var page;

getWcmsPrefix = function(){return "";}

  //debug
  var validBrowser = false;
  splitSearchString();
  if(query.debug) {
    validBrowser = true;
  }

  var init = function () {

    $('#button_left, #button_right').click(function() {
      return true;
    });

    if (document.createElement) {
      var el = document.createElement('div');
      if (el && el.style) {
        el.style.position = 'fixed';
        el.style.top = '10px';
        var root = document.body;
        if (root && root.appendChild && root.removeChild) {
          root.appendChild(el);
          IS_POSITION_FIXED_SUPPORTED = (el.offsetTop === 10);
          root.removeChild(el);
        }
      }
    }

    wheely(40);

  	if(IS_CHROME || ($.browser.mozilla && parseFloat($.browser.version.replace(/\./,'')) > 19.2) || ($.browser.msie && parseInt($.browser.version, 10) >= 8) || validBrowser) {
	    if($.browser.mozilla && parseFloat($.browser.version.replace(/\./,'')) > 19.2) {
	      var videoCounter = 1;
	      $('.intro_video').each(function () {
	      	var video = '<video id="video_' + videoCounter + '" width="1440" height="810" preload>' +
	      			    '  <source src="' + getWcmsPrefix() + $(this).attr('data-mp4') + '"  type=\'video/mp4; codecs="avc1.42E01E, mp4a.40.2"\'>' +
	                    '  <source src="' + getWcmsPrefix() + $(this).attr('data-webm') + '" type=\'video/webm; codecs="vp8, vorbis"\'>' +
	                    '  <source src="' + getWcmsPrefix() + $(this).attr('data-ogv') + '"  type=\'video/ogg; codecs="theora, vorbis"\'>'+
	                    '</video>';
	       	$(this).html(video);

	      	document.getElementById('video_' + videoCounter).addEventListener('loadeddata', videoLoaded, false);
	        videoCounter++;
	      });
	    }
	    else {
	      VIDEO_TAG_SUPPORT = false;
	      var playerSWF = buildValidServerRelativeUrl("/_common/shared/newvehicles/mseries/m5sedan/2011/showroom/highlights/videos/video_player.swf");
	      $('.intro_video').each(function () {
	        var videoObject = new SWFObject(playerSWF, $(this).attr('id') + "_flash", "1440", "810", "10", "#000000");
	        videoObject.addParam("allowScriptAccess", "sameDomain");
	        videoObject.addParam("wmode", "opaque");
	        videoObject.addParam("quality", "autohigh");
	        videoObject.addVariable("video_url", $(this).attr('data-flash'));
	        FLASH_VIDEO_ACTIVE = videoObject.write($(this).attr('id'));
	      });
	      window.videoLoaded = function(){
	      	videosLoaded++;
    		preloadCheck();
	      }
	    }
	}else{
		  VIDEO_TAG_SUPPORT = false;
	}

      $.loadImages(preloadImages, function() {
        imagesLoaded = true;
        preloadCheck();
      });
  }

  videoLoaded = function() {
    videosLoaded++;
    preloadCheck();
  }

  var preloadCheck = function() {    
      
  	if(!page){
	    if(!FLASH_VIDEO_ACTIVE && !VIDEO_TAG_SUPPORT && imagesLoaded) {
	     page = new Page($('#highlight'));
	    }
	    else if(imagesLoaded && videosLoaded >= 2) {               
	     page = new Page($('#highlight'));
	    }
  	}
        
  }

  var Core = {};
  Core.Object = {};
  Core.Object.extend = function (subclass, superclass) {
    var Temp = function () {};
    Temp.prototype = superclass.prototype;
    subclass.prototype = new Temp();
    subclass.prototype.constructor = subclass;
    subclass.superclass = superclass.prototype;
    if (superclass.prototype.constructor == Object.prototype.constructor) {
      superclass.prototype.constructor = superclass;
    }
  }

  Core.EventDispatcher = function () {
    this.listeners = [];
    var ListenerVO = function (type, listener) {
      return {
        type: type,
        listener: listener
      }
    }

    Core.EventDispatcher.prototype.addEventListener = function (type, listener) {
      this.listeners.push(new ListenerVO(type, listener));
    }

    Core.EventDispatcher.prototype.removeEventListener = function (type, listener) {
      var i = this.listeners.length;
      while (--i >= 0) {
        if (this.listeners[i].type == type && this.listeners[i].listener == listener) {
          this.listeners.splice(i, 1);
        }
      }
    }

    Core.EventDispatcher.prototype.dispatchEvent = function (event) {
      var i = this.listeners.length;
      while (--i >= 0) {
        if (event != undefined && this.listeners[i] != undefined && this.listeners[i].type == event.getType()) {
          this.listeners[i].listener(event);
        }
      }
    }
  };

  Core.Event = function (type, target) {
    this.type = type;
    this.target = target;
    Core.Event.prototype.getType = function () {
      return this.type;
    }
    Core.Event.prototype.getTarget = function () {
      return this.target;
    }
  }

  Core.Timer = function Timer(time, repeat) {
    Core.Timer.superclass.constructor.call(this);
    var instance = this;
    var interval;
    var intervalHandler = function () {
      if (repeat == undefined) {
        instance.dispatchEvent(new Core.Event("TimerEvent", instance));
      } else if (repeat > 0) {
        instance.dispatchEvent(new Core.Event("TimerEvent", instance));
        --repeat;
      } else {
        clearInterval(interval);
      }
    }
    instance.start = function () {
      if (interval != null) {
        clearInterval(interval);
      }
      interval = setInterval(intervalHandler, time)
    }
    instance.stop = function () {
      clearInterval(interval);
    }
  }
  Core.Object.extend(Core.Timer, Core.EventDispatcher)


  var Page = function (node) {     
    this.id = node.attr('id');
    this.node = node;
    var columns = [];
    var instance = this;
    var scrollInterval = null;
    var init = function () {
      instance.node.find('.column').each(function () {
        var column = new PageColumn($(this));
        column.addEventListener('ActivationComplete', columnActivationCompleteHandler)
        columns[columns.length] = column;
      });
      $(window).bind('hashchange', hashChangeHandler);
      var hash = getHashValues();
      activate(hash.c, hash.p)
      $(window).bind('scroll', scrollHandler);
      $(window).bind('resize', showButtons);
      $(window).bind('resize', adjustStyle);
    }

    if (window.Touch) {
      instance.node.find('.paragraph').each(function () {
        $(this).css('background-attachment', 'scroll');
      });
    }

    var activate = function (columnId, paragraphId) {
      var direction;
      if (columnId != currentColumnId) {
        if(VIDEO_TAG_SUPPORT || FLASH_VIDEO_ACTIVE) {
          $('.intro_video').css('position','absolute').css('top', $(document).scrollTop());
          $('#' + columnId + ' .intro_video').css('top', 0);
        }
        $('html').css('cursor', 'wait');
        $('#button_right, #button_left').hide();
        $('.tooltip').css('visibility','hidden');
        if ($(document).scrollTop() > 100) {
          $('#mainNavigationContainer, #idModuls').css({
            'top': '-100px'
          });
        }
        if (currentColumnId) {
          direction = (getColumnIndex(currentColumnId) < getColumnIndex(columnId)) ? 'left' : 'right';
          getColumn(currentColumnId).deactivate(direction);
        } else {
          var columnIndex = getColumnIndex(columnId);
          var i = columns.length;
          while (--i >= 0) {
            if (columns[i].id != columnId) {
              columns[i].deactivate((i < columnIndex) ? 'left' : 'right');
            }
          }
        }
        currentColumnId = columnId;
      }
      var column = getColumn(currentColumnId);
      column.activate(paragraphId || '', direction);
    }

    var scrollHandler = function () {
      $('#scrolldown').fadeOut();

      $('#highlightCloseButton').stop().animate({
        left: '-167px'
      }, 250);
      $('#button_left').stop().animate({
        left: '-34px'
      }, 250);
      $('#button_right').stop().animate({
        right: '-34px'
      }, 250);
      clearInterval(scrollInterval);
      scrollInterval = setInterval(showButtons, SHOW_CLOSE_BUTTON_TIMER);
    }

    var columnActivationCompleteHandler = function (event) {
      if (event.target.id == currentColumnId) {
        if(VIDEO_TAG_SUPPORT || FLASH_VIDEO_ACTIVE) {
          $(' .intro_video').css('position','fixed').css('top', '0');
        }
        instance.node.css({
          'height': getColumn(currentColumnId).height
        });
        $('html').css('cursor', 'auto');
        $('#mainNavigationContainer, #idModuls').animate({
          'top': '0px'
        });
        showButtons();
        $('#page_loading').remove();

        //new
        scrollBlink();

      }
    }
    var getColumnIndex = function (id) {
      var i = columns.length
      while (--i >= 0) {
        if (columns[i].id == id) {
          return i;
        }
      }
      return 0;
    }

    var hashChangeHandler = function () {
      var hash = getHashValues();
      activate(hash.c, hash.p);
    }

    var getHashValues = function () {
      var tmp = {};
      tmp.c = ($.bbq.getState().c) ? $.bbq.getState().c : columns[0].id;
      tmp.p = ($.bbq.getState().p) ? $.bbq.getState().p : '';
      return tmp;
    }

    var getColumn = function (id) {
      var i = columns.length;
      while (--i >= 0) {
        if (columns[i].id == id) {
          return columns[i];
        }
      }
      return null;
    }

    var showButtons = function () {
      clearInterval(scrollInterval);
      var scrollTop = $(window).scrollTop();
      $('#highlightCloseButton').css('top', ($(window).height() - 70 + scrollTop) + 'px');
/*      $('#highlightCloseButton').stop().animate({
        left: '0px'
      }, 250, 'easeOutSine');*/
      var buttonTopPos = $(window).height() / 2 + scrollTop - 28 + 14;
      var columnIndex = 0;
      for (i = 0; i < columns.length; i++) {
        if (columns[i].id == currentColumnId) {
          columnIndex = i;
          break;
        }
      }

      if (columnIndex == columns.length - 1) {
        $('.button_right').hide();
      } else {
        $('#button_right').stop().show().css('top', buttonTopPos).animate({
          right: '0px'
        }, 250, function() {
          $('.tooltip').css('visibility','visible');
        });
      }
      if (columnIndex > 0) {
        $('#button_left').stop().show().css('top', buttonTopPos).animate({
          left: '0px'
        }, 250, function() {
          $('.tooltip').css('visibility','visible');
        });
      } else {
        $('#button_left').hide();
      }

    }

    init();
  }

  var PageColumn = function (node) {
    PageColumn.superclass.constructor.call(this);
    this.id = node.attr('id');
    this.top = node.position().top;
    this.left = node.position().left;
    this.node = node;
    this.active = false;
    var instance = this;
    var paragraphs = [];
    var paragraphChangeTimer;

    var init = function () {
      var height = 0;
      instance.node.find('.paragraph').each(function () {
        var paragraph = PageParagraphaFactory.getParagraph($(this));
        paragraph.addEventListener('ParagraphActiveEvent', paragraphActiveHandler)
        paragraphs[paragraphs.length] = paragraph;
        height += paragraph.height;
      })
      instance.height = ($(window).height() > PARAGRAPH_HEIGHT) ? height + $(window).height() - PARAGRAPH_HEIGHT : height;
      instance.node.css({
        'height': instance.height
      });
      paragraphChangeTimer = new Core.Timer(1000);
      paragraphChangeTimer.addEventListener('TimerEvent', paragraphChangeTimerHandler)
    }

    this.activate = function (value, direction) {
      instance = this;
      var paragraph = paragraph;
      if (!this.active) {
        paragraph = getParagraph(value) || getParagraph(paragraphs[0].id);
        paragraph.activate();
        /*
        this.node.show().css({
          'top': $(window).scrollTop()
        });
        */
        this.node.css({
         'visibility':'visible',
          'top': $(window).scrollTop()
        });
        var i = paragraphs.length;
        while (--i >= 0) {
          paragraphs[i].setScrollPosition(0);
        }
        var left = (direction == 'left') ? this.node.width() : -this.node.width();
        this.node.css({
          'left': left + 'px'
        }).stop().animate({
          'left': '0px'
        }, COLUMN_ANIMATION_SPEED, function () {
          instance.node.css({
            'top': '0px'
          });
          instance.dispatchEvent(new Core.Event('ActivationComplete', instance));
          $.scrollTo(parseInt(paragraph.top));
          scrollHandler();
          currentParagraph = paragraph.id;

        });

        $(window).bind('scroll', scrollHandler);
        this.active = true;
      } else {
        var id = value;
        if (id != currentParagraph) {
          paragraph = getParagraph(id) || getParagraph(paragraphs[0].id);
          paragraph.activate();
          $.scrollTo(paragraph.top);
          scrollHandler();
          currentParagraph = id;
        }
      }
    }

    this.deactivate = function (direction) {
      $(window).unbind('scroll', scrollHandler);
      this.active = false;
      var left = (direction == 'left') ? -this.node.width() : this.node.width();
      this.node.stop().delay(100).animate({
        'left': left + 'px'
      }, COLUMN_ANIMATION_SPEED, function () {
        var i = paragraphs.length;
        while (--i >= 0) {
          paragraphs[i].deactivate();

        }
        instance.node.css('visibility','hidden');
        //instance.nodehide();
        instance.dispatchEvent(new Core.Event('DeactivationComplete', instance));
      });
    }

    var getParagraph = function (id) {
      var i = paragraphs.length;
      while (--i >= 0) {
        if (paragraphs[i].id == id) {
          return paragraphs[i];
        }
      }
      return null;
    }

    var scrollHandler = function () {
      var scrollPosition = $(window).scrollTop();
      var i = paragraphs.length;
      while (--i >= 0) {
        if (scrollPosition + paragraphs[i].height >= paragraphs[i].top && scrollPosition - paragraphs[i].height < paragraphs[i].top) {
          paragraphs[i].setScrollPosition(scrollPosition);
          if(!paragraphs[i].active){
            paragraphs[i].activate();
          }

        } else {
          if(paragraphs[i].active){
            paragraphs[i].deactivate();
          }
        }
      }
    }
    var paragraphActiveHandler = function (event) {
      if (currentParagraph != event.target.id) {
        currentParagraph = event.target.id;
        paragraphChangeTimer.start();
      }
    }
    var paragraphChangeTimerHandler = function (event) {
      if (currentParagraph) {
        paragraphChangeTimer.stop();
        $.bbq.pushState({
          c: instance.id,
          p: currentParagraph
        });

      }
    }
    init();
  }
  Core.Object.extend(PageColumn, Core.EventDispatcher);

  var PageParagraphaFactory = {};

  PageParagraphaFactory.getParagraph = function (node) {
    var paragraph;
    switch ($(node).attr('data-paragraph-type')) {
      case 'moving-object':
        paragraph = new MovingObjectPageParagraph(node);
        break;
      case 'rotate-object':
        paragraph = new RotateObjectPageParagraph(node);
        break;
      case 'accordeon':
        paragraph = new AccordeonObjectPageParagraph(node);
        break;
      case 'x-ray':
        paragraph = new XRayObjectPageParagraph(node);
        break;
      case 'image-text-change':
        paragraph = new ImageTextChangePageParagraph(node);
        break;
      case 'image-text-grid-change':
        paragraph = CANVAS_TAG_SUPPORT ? new ImageTextGridChangePageParagraph(node) :  new ImageTextChangePageParagraph(node);
        break;
      case 'grid':
        paragraph = CANVAS_TAG_SUPPORT ? new GridPageParagraph(node) : new PageParagraph(node);
        break;
      case 'sound':
        paragraph = (CANVAS_TAG_SUPPORT && AUDIO_TAG_SUPPORT) ? new SoundEffectPageParagraph(node) : new SoundPageParagraph(node);
        break;
      case 'intro':
        paragraph = new IntroParagraph(node);
        break;
      default:
        paragraph = new PageParagraph(node);
        break;
    }
    return paragraph;
  }

  var PageParagraph = function (node) {
    PageParagraph.superclass.constructor.call(this);
    this.id = node.attr('id');
    this.top = node.position().top;
    this.left = node.position().left;
    this.width = node.width();
    this.height = PARAGRAPH_HEIGHT;
    this.active = false;
    this.node = node;
    this.backgroundImage = node.css('background-image')
    this.viewportPercent;
    PageParagraph.prototype.activate = function () {
      if (!this.active) {

        this.active = true;
      }
    }

    PageParagraph.prototype.deactivate = function () {
      if (this.active) {
        this.active = false;
      }
    }

    PageParagraph.prototype.setScrollPosition = function (value) {
      if (this.active && value > (this.top - this.height / 4) && value < (this.top + this.height / 2)) {
        this.dispatchEvent(new Core.Event('ParagraphActiveEvent', this));
      }
      if (!window.Touch && IS_POSITION_FIXED_SUPPORTED) {
        var viewportTop = this.top - value;
        this.viewportPercent = viewportTop / $(window).height();
        this.updateBackgroundPosition(Math.round(this.viewportPercent * BACKGROUND_OVERLAP));
      } else if (!window.Touch){
        var viewportTop = this.top - value;
        this.viewportPercent = viewportTop / $(window).height();
        this.updateBackgroundPosition(-(this.node.position().top-value)+Math.round(this.viewportPercent * BACKGROUND_OVERLAP));
      }
    }

    PageParagraph.prototype.updateBackgroundPosition = function(value){
      this.node.css('background-position', '0 ' + value + 'px');
    }

  }
  Core.Object.extend(PageParagraph, Core.EventDispatcher);

  var CanvasPageParagraph = function (node) {
    CanvasPageParagraph.superclass.constructor.call(this, node);
    this.context;
    this.canvas;
    this.framerate = 12;
    this.minframerate = 2;
    this.renderingactive = false;
    this.f = 0;
    this.initialized = false;

    CanvasPageParagraph.prototype.init = function () {
      this.canvas = this.node.find('canvas')[0];
      this.context = this.canvas.getContext('2d');
    }
    CanvasPageParagraph.prototype.activate = function () {
      if (!this.initialized && !this.active) {
        this.init();
        this.initialized = true;
      }
      if (!this.active) {
        this.startRendering();
      }
      CanvasPageParagraph.superclass.activate.call(this);
    }

    CanvasPageParagraph.prototype.deactivate = function () {
      this.stopRendering();
      CanvasPageParagraph.superclass.deactivate.call(this);
    }

    this.startRendering = function(){
      this.renderingactive = true;
      this.ticker();
    }

    this.stopRendering = function(){
      this.renderingactive = false;
    }

    CanvasPageParagraph.prototype.ticker = function(){
      if(this.renderingactive){
        if(this.f >= 100/this.framerate){
          this.render();
          if(this.framerate -2 > this.minframerate){
            this.framerate -= 2;
          }
          this.f = 0;
        }
        ++this.f;
        var instance = this;
        requestAnimationFrame(function(){
          instance.ticker()
        });
      }
    }

    CanvasPageParagraph.prototype.render = function () {
    }

    var requestAnimationFrame = (function(){
      return  window.requestAnimationFrame ||
      window.webkitRequestAnimationFrame ||
      window.mozRequestAnimationFrame    ||
      window.oRequestAnimationFrame      ||
      window.msRequestAnimationFrame     ||
      function(callback){
        window.setTimeout(callback, 1000 / 60);
      };
    })();

  }
  Core.Object.extend(CanvasPageParagraph, PageParagraph);

  var GridPageParagraph = function (node) {

    GridPageParagraph.superclass.constructor.call(this, node);

    this.data;
    this.stage;
    this.focallenght = 200;
    this.viewportX = 0;
    this.viewportY = 0;
    this.interactionX = -500;
    this.interactionY = -500;
    this.mouse;
    this.accelermeter
    this.easing = 0.5;
    this.dots;
    this.rects;
    this.w;
    this.h;
    this.black;
    this.p = node.position();
    this.offset = 0;
    this.tracked = false;
    var instance = this;

    GridPageParagraph.prototype.init = function () {


      GridPageParagraph.superclass.init.call(this);

      this.w = this.canvas.width;
      this.h = this.canvas.height;
      this.viewportX = this.width/2;
      this.viewportY = this.height/2;
      this.stage = new Stage(this.canvas);

      this.rects = new Container();
      this.stage.addChild(this.rects)

      this.dots = new Container();
      this.stage.addChild(this.dots);

      this.black = this.node.find('.black');
      this.black.show();

      var d = node.find('#grid').html();
      if(d){
        this.setData($.parseJSON(d));
      }
    }

    GridPageParagraph.prototype.setData = function(value){
      if(this.data){
        this.dots.removeAllChildren();
        this.rects.removeAllChildren();
        this.stage.update();
        for(var key in this.data.points){
          var point = this.data.points[key];
          if(point.graphic){
            delete point.graphic;
          }
        }
        this.data = null;
      }
      this.data = value;
    }

    GridPageParagraph.prototype.render = function(){
      var numVisiblePoints = 0;
      if(this.data){
        if(this.accelerometer){
          this.interactionX += this.accelerometer.x;
          this.interactionY += this.accelerometer.y;
        }

        for(var key in   this.data.points){
          var point =   this.data.points[key];
          var dot = point.graphic;
          if(!dot){
            point.x -= this.viewportX;
            point.y -= this.viewportY;
            if(point.fixed){
              dot = new Dot(point);
            } else{
              dot = new Cross(point);
            }
            dot.alpha = 0;
            point.graphic = dot;
            this.dots.addChild(dot)
          }
          var dx = dot.x - this.interactionX;
          var dy = dot.y - this.interactionY;
          var dist = Math.sqrt(dx * dx + dy * dy);
          if (!dot.fixed) {
            var maxDx = dot.x - this.w*2;
            var maxDy = dot.y - this.h*2;
            var maxDist = Math.sqrt(maxDx * maxDx + maxDy * maxDy);
            dot.zp += ((this.focallenght/maxDist*dist)*(40/maxDist*dist)- dot.zp)*this.easing;
            if(dot.zp < - this.focallenght){
              dot.zp = 0;
            }
          }
          dot.alpha = 1 / this.w * (this.w - dist*5);
          numVisiblePoints += (dot.alpha >0.1)? 1 : 0;
          if(dot.zp > -this.focallenght ){
            var scale = this.focallenght / (this.focallenght + dot.zp);
            dot.scaleX = dot.scaleY = scale;
            dot.x = this.viewportX + dot.xp * scale;
            dot.y = this.viewportY + dot.yp * scale;
          }
        }

        this.rects.removeAllChildren();
        var i = this.data.rects.length;
        while (--i >= 0) {
          var rectData = this.data.rects[i];
          if(this.data.points[rectData[0]].graphic.alpha >0){
            var j = rectData.length;
            var rect = new Shape();
            rect.graphics.beginRadialGradientFill(['rgba(255, 255, 255, 0)','rgba(255, 255, 255, 1)'], [0, 1], this.interactionX, this.interactionY, 500, this.interactionX,  this.interactionY, 0)
            rect.graphics.beginStroke('rgb(255, 255, 255)');
            var sx, mx , sy , my;
            while (--j >= 0) {
              var dot = this.data.points[rectData[j]].graphic;
              if(j == rectData.length-1){
                sx =  dot.x;
                mx =  dot.x;
                sy =  dot.y;
                my =  dot.y;
              }else{
                sx = Math.min(sx,  dot.x);
                mx = Math.max(mx,  dot.x);
                sy = Math.min(sy,  dot.y);
                my = Math.max(my,  dot.y);
              }
              rect.graphics.lineTo(dot.x, dot.y)
            }

            var rdx = ((mx-sx)/2+sx) - this.interactionX;
            var rdy = ((my-sy)/2+sy) - this.interactionY;
            rect.alpha = 1 / this.width * (this.width - Math.sqrt(rdx * rdx + rdy * rdy)*3) -0.5;

            rect.graphics.closePath();
            rect.graphics.endStroke();

            this.rects.addChild(rect);

          }
        }

        this.stage.update();
      }
      if(numVisiblePoints > 4){
        if( this.black && !this.black.visible ){
          this.black.stop().animate({
            'opacity':0.3
          });
          this.black.visible = true;
        }
      }else{
        if( this.black &&  this.black.visible){
          this.black.stop().animate({
            'opacity':0
          });
          this.black.visible = false;
        }
      }
      GridPageParagraph.superclass.render.call(this);
    }

    GridPageParagraph.prototype.setScrollPosition = function (value) {
      GridPageParagraph.superclass.setScrollPosition.call(this,value);
      this.offset = Math.round(this.viewportPercent * BACKGROUND_OVERLAP);
      this.p = node.position();
    }

    GridPageParagraph.prototype.activate = function () {
      GridPageParagraph.superclass.activate.call(this);
      instance = this;
      this.tracked = false;
      if (!window.Touch) {
        this.node.bind('mousemove', this.interactionHandler)
      } else if(this.canvas){
        this.node[0].addEventListener('touchstart', this.interactionHandler)
      }
    }

    GridPageParagraph.prototype.deactivate = function () {
      if (!window.Touch) {
        this.node.unbind('mousemove', this.interactionHandler)
      } else if(this.canvas){
        this.node[0].removeEventListener('touchstart', this.interactionHandler)
      }

      GridPageParagraph.superclass.deactivate.call(this);
    }


    GridPageParagraph.prototype.trackInteraction = function(){

    }

    this.interactionHandler = function (event) {
      if (event.touches) {
        var i = event.touches.length;
        while (--i >= 0) {
          var touch = event.touches[i];
          instance.interactionX = touch.pageX;
          instance.interactionY = touch.pageY;
          if (!isNaN(instance.interactionX ) && instance.interactionX != 0 && !isNaN(instance.interactionY) && instance.interactionY != 0) {
            break;
          }
        }
      } else {
        instance.interactionX = event.pageX;
        instance.interactionY = event.pageY;
      }

      instance.interactionX -= instance.p.left;
      instance.interactionY -= instance.p.top;
      instance.framerate = 25;

	  if(!instance.tracked && instance.black.visible){
        instance.tracked = true;
        instance.trackInteraction();
      }
    }

    var Cross = function (data) {

      var size = 10;
      var color = '#FFFFFF';

      this.fixed = data.fixed;

      this.xp = data.x;
      this.yp = data.y;
      this.zp = 0;

      this.vx = 0;
      this.vy = 0;
      this.vz = 0;

      this.initialize = function (graphics) {
        Cross.superclass.initialize.call(this, graphics);
        this.graphics.beginStroke(color);
        this.graphics.moveTo(-size/2, 0);
        this.graphics.lineTo(size/2, 0);
        this.graphics.moveTo(0, -size/2);
        this.graphics.lineTo(0, size/2);
        this.graphics.endStroke();
      }
      Cross.superclass.constructor.call(this);

    }
    Core.Object.extend(Cross, Shape)


    var Dot = function (data) {

      var size = 5;
      var color = '#FFFFFF';

      this.fixed = data.fixed;

      this.xp = data.x;
      this.yp = data.y;
      this.zp = 0;

      this.vx = 0;
      this.vy = 0;
      this.vz = 0;

      this.initialize = function () {

        Dot.superclass.initialize.call(this);

        var circle = new Shape();
        circle.graphics.beginFill(color);
        circle.graphics.arc(0, 0, size, 0, Math.PI * 2)
        circle.graphics.endFill();
        this.addChild(circle);
        if(data.text){
          var text =  new Text(data.text, "bold 10px BMWType_Bold, Arial, sans-serif", "#FFF");
          text.x = 8;
          text.y = 2.5;
          this.addChild(text);
        }


      }
      Cross.superclass.constructor.call(this);

    }
    Core.Object.extend(Dot, Container)

    var Point = function(x,y){
      this.x = x;
      this.y = y;
    }
  }
  Core.Object.extend(GridPageParagraph, CanvasPageParagraph);

  var ImageTextGridChangePageParagraph = function (node) {

    ImageTextGridChangePageParagraph.superclass.constructor.call(this, node);

    var activeHeadline = 0;
    var instance = this;
    var activeItem = 0;
    var imageTextArray;

    this.init = function () {

      ImageTextGridChangePageParagraph.superclass.init.call(this);

      try {
        imageTextArray = $.parseJSON(this.node.find('#data').html());
      } catch (e) {}

      var navigation = instance.node.find('.dot_nav');
      navigation.css('width',(imageTextArray.length*33)+'px');
      for(var i=0,length = imageTextArray.length; i<length;i++){
        navigation.append('<li><a id="dotnavitem'+i+'" data-index="'+i+'"></a></li>');
      }
      navigation.find('a').click(function(){
        instance.changeContent(parseInt($(this).attr('data-index')));
        return false;
      })
      instance = this;
      trackingId = imageTextArray[activeItem].image.substring(imageTextArray[activeItem].image.lastIndexOf("/") + 1, imageTextArray[activeItem].image.lastIndexOf("."));
      this.changeContent(0)
    }

    this.changeContent = function(index){
      var navitem = this.node.find('#dotnavitem'+index);
      if(!navitem.hasClass('active')){
        navitem.parent().parent().find('a').removeClass('active');
        navitem.addClass('active');
      }
      if(imageTextArray[index].grid){
          this.setData($.parseJSON(this.node.find('#'+imageTextArray[index].grid).html()));
        }else{
          this.setData(null)
        }
      if(index != activeItem){
        activeItem = index;
       $('<div class="black"></div>').appendTo(this.node).stop().animate({
          opacity: '1'
        }, 500, function () {
          //$('<img src="' + loadingBoxGif + '" class="loading">').appendTo(instance.node);
          $('<img />').bind('load', changeBackground).attr("src", getWcmsPrefix()+imageTextArray[activeItem].image);

          instance.node.find('h1').html(imageTextArray[activeItem].text);
          instance.node.find('.image_text_headline div').stop().animate({
            top: '0px'
          }, 500);
        });
      }
    }

    var changeBackground = function (event) {
      var imageSource = (event.target.src) ? event.target.src : event.currentTarget.href;
      instance.node.css('background-image', 'url(' + imageSource + ')');
      instance.node.find('.loading, #loading').remove();
      instance.node.find('.black').animate({
        opacity: 0
      }, 500);

      trackingId = imageSource.substring(imageSource.lastIndexOf("/") + 1, imageSource.lastIndexOf("."));
      instance.tracked = false;
    }


    ImageTextGridChangePageParagraph.prototype.setScrollPosition = function (value) {
      ImageTextGridChangePageParagraph.superclass.setScrollPosition.call(this,value);
      if(!window.Touch){
        $(this.canvas).css('top', (-(this.node.position().top-value)+this.offset)+ 'px');
      }else{
        this.offset = 0;
      }
      this.p.top += parseInt(this.offset);
    }

    this.activate = function () {
      ImageTextGridChangePageParagraph.superclass.activate.call(this);
      instance = this;
       this.changeContent(activeItem)
    }

    this.deactivate = function () {
      if(imageTextArray){
        activeItem = 0;
        instance.node.css('background-image', 'url(' + getWcmsPrefix()+ imageTextArray[activeItem].image + ')');
      }
      ImageTextGridChangePageParagraph.superclass.deactivate.call(this)
    }

    this.trackInteraction = function(){
      trackPage(self.location.pathname.substring(0, self.location.pathname.lastIndexOf("/")) + '/mouse_over_canvas.html?mo=' + currentColumnId + '-' + instance.id+'-' + trackingId);
    }

  }
  Core.Object.extend(ImageTextGridChangePageParagraph, GridPageParagraph);

  var MovingObjectPageParagraph = function (node) {
    MovingObjectPageParagraph.superclass.constructor.call(this, node);
    var instance = this;
    var objects = [];
    var initialized = false;
    var init = function(){
      if(!initialized){
        instance.node.find('.moving_object').each(function () {
          objects.push(new MovingObject($(this)))
        });
      }
    }

    this.setScrollPosition = function (value) {
      MovingObjectPageParagraph.prototype.setScrollPosition.call(this, value);
      var i = objects.length;
      var css = {};
      while(--i>=0){
        if (instance.viewportPercent >= 0) {
          objects[i].position = objects[i].endPosition+Math.abs(instance.viewportPercent*objects[i].factor)/1*(objects[i].startPosition-objects[i].endPosition)
          css[objects[i].direction] = objects[i].position;
          objects[i].node.css(css);
        } else {
          objects[i].position = objects[i].position;
          css [objects[i].direction] = objects[i].position;
          objects[i].node.css(css);
        }
      }
    }

    var MovingObject = function(node){
      this.node = node
      this.factor = Number(this.node.attr('data-moving-factor'));
      this.direction =  this.node.attr('data-moving-direction');
      this.startPosition = (this.direction == 'left' || this.direction == 'right')? -this.node.width() : -this.node.height();
      this.endPosition =  parseInt(this.node.css(this.direction).substr(0, this.node.css(this.direction).length - 2));
    }

    var activated = false;
    var container = instance.node.find('.video_container');
    //var embedCode = '<iframe width="' + container.width() + '" height="' + container.height() + '" frameborder="0" src="http://bmw.tv/com/embed-player/embed.html?articleID=' + container.attr('data-video-id') + '&context=' + confCountryTopic + '&q=h&ap=1"></iframe>';
    var embedCode = '<iframe width="' + container.width() + '" height="' + container.height() + '" frameborder="0" src="http://bmw.tv/com/embed-player/embed.html?articleID=' + container.attr('data-video-id') + '&context=com&q=h&ap=1"></iframe>';
    var defaultCode = instance.node.find('.video_container').html();
    instance.node.find('.video_container').click(function () {
      $(this).html(embedCode);
      return false;
    });

    if(/chrome/.test(navigator.userAgent.toLowerCase())){
    	instance.node.css({'background-attachment':'initial'});
    	this.updateBackgroundPosition = function (value){}
    }

    this.deactivate = function () {
      instance.node.find('.video_container').each(function () {
        $(this).html(defaultCode);
      });
      activated = false;
      MovingObjectPageParagraph.superclass.deactivate.call(this);
    }



    init();
  }
  Core.Object.extend(MovingObjectPageParagraph, PageParagraph);

  var RotateObjectPageParagraph = function (node) {
    RotateObjectPageParagraph.superclass.constructor.call(this, node);
    var instance = this,
    initialized = false;

    var init = function () {
      if (!initialized) {
        instance.node.find('.rotate_object').j360();
        instance.node.find('.rotate_object').mousedown(function () {
          $('.icon360').fadeOut();
        });
        initialized = true;
      }
    }

    this.activate = function () {
      $('.icon360').show();
      RotateObjectPageParagraph.prototype.activate.call(this);
      init();
    }

    this.deactivate = function () {
      RotateObjectPageParagraph.prototype.deactivate.call(this);
    }

    this.updateBackgroundPosition = function (value){
      //
    }

  }
  Core.Object.extend(RotateObjectPageParagraph, PageParagraph);


  var AccordeonObjectPageParagraph = function(node) {
    AccordeonObjectPageParagraph.superclass.constructor.call(this, node);
    var instance = this;
    var init = function () {
      instance.node.find('h3 a').click(function () {
        var imageSource = $(this).attr('data-background-image');
        if (!$(this).hasClass('active')) {
          var background = getWcmsPrefix() + $(this).attr('data-background-image');
          if ($(this).attr('data-background-image')) {
            $('<div class="black"></div>').appendTo(instance.node).stop().animate({
              opacity: '1'
            }, 500, function () {
              //$('<img src="' + loadingBoxGif + '" class="loading">').appendTo(instance.node);
              $('<img />').bind('load', changeBackground).attr("src", background);
            });
          }
          $(this).parent().parent().find('a').removeClass('active');
          $(this).parent().parent().find('p:visible').stop(true, true).slideUp('fast');
          $(this).next('p').stop(true, true).slideDown('fast');
          $(this).addClass('active');
        }
        trackPage(self.location.pathname.substring(0, self.location.pathname.lastIndexOf("/")) + '/' + currentColumnId + '/' + instance.id + '/' + imageSource.substring(imageSource.lastIndexOf("/") + 1, imageSource.lastIndexOf(".")) + '.html');
        return false;

      });
    }

    var changeBackground = function (event) {
      instance.node.css('background-image', 'url(' + ((event.target.src) ? event.target.src : event.currentTarget.href) + ')');
      instance.node.find('.loading, .black').remove();
      instance.node.find('.black').animate({
        opacity: 0
      }, 500);
    }

    this.deactivate = function () {
      instance.node.find('.accordeon_headline').show();
      instance.node.find('a').removeClass('active');
      instance.node.find('h3 p').hide();
      instance.node.find('a:first').addClass('active');
      instance.node.find('h3 p:first').show();
      if(instance.node.find('a:first').attr('data-background-image')) {
        instance.node.css('background-image', 'url(' + getWcmsPrefix() + instance.node.find('a:first').attr('data-background-image') + ')');
      }
      AccordeonObjectPageParagraph.superclass.deactivate.call(this);
    }
    init();
  }
  Core.Object.extend(AccordeonObjectPageParagraph, PageParagraph);


  var ImageTextChangePageParagraph = function (node) {
    ImageTextChangePageParagraph.superclass.constructor.call(this, node);
    var activeHeadline = 0;
    var instance = this;
    var activeItem = 0;
    var imageTextArray;

    this.init = function () {
      try {
        imageTextArray = jQuery.parseJSON(instance.node.find('script').html());
      }catch(e){}

      var navigation = instance.node.find('.dot_nav');
      navigation.css('width',(imageTextArray.length*33)+10+'px');
      for(var i=0,length = imageTextArray.length; i<length;i++){
        navigation.append('<li><a id="dotnavitem'+i+'" data-index="'+i+'"></a></li>');
      }
      navigation.find('a').click(function(){
        instance.changeContent(parseInt($(this).attr('data-index')));
        return false;
      })
      this.changeContent(0);
    }

    this.changeContent = function(index){
      var navitem = this.node.find('#dotnavitem'+index);
      if(!navitem.hasClass('active')){
        navitem.parent().parent().find('a').removeClass('active');
        navitem.addClass('active');
      }
      if(index != activeItem){
        activeItem = index;
        instance.node.find('.image_text_headline div').stop().animate({
          top: '150px'
        }, 500);

        $('<div class="black"></div>').appendTo(instance.node).stop().animate({
          opacity: '1'
        }, 500, function () {
          //$('<img src="' + loadingBoxGif + '" class="loading">').appendTo(instance.node);
          $('<img />').bind('load', changeBackground).attr("src",getWcmsPrefix()+imageTextArray[activeItem].image);

          instance.node.find('h1').html(imageTextArray[activeItem].text);
          instance.node.find('.image_text_headline div').stop().animate({
            top: '0px'
          }, 500);
        });
      }
    }

    var changeBackground = function (event) {
      instance.node.css('background-image', 'url(' + ((event.target.src) ? event.target.src : event.currentTarget.href) + ')');
      instance.node.find('.loading, .black').remove();
      instance.node.find('.black').animate({
        opacity: 0
      }, 500);
    }

    this.deactivate = function () {
      if(imageTextArray){
      	this.changeContent(0);
      }
      ImageTextChangePageParagraph.superclass.deactivate.call(this)
    }
    this.init();
  }
  Core.Object.extend(ImageTextChangePageParagraph, PageParagraph);


  var XRayObjectPageParagraph = function(node) {
    XRayObjectPageParagraph.superclass.constructor.call(this, node);
    if(!$.browser.msie || ($.browser.msie && parseInt($.browser.version, 10) > 8)) {
      var instance = this;
      var xray = this.node.find('#x-ray');
      var effect = false;
      var factor = 1;

      this.setScrollPosition = function (value) {
        if (value > (this.top -  this.height) && value < (this.top + this.height)) {
          if(!effect){
            factor = Math.round(this.viewportPercent);
            factor = (factor >= 1)? 1 : -1;
            effect = true;
          }
        }else{
          effect = false;
        }
        XRayObjectPageParagraph.prototype.setScrollPosition.call(this, value);
        var alpha = (this.viewportPercent*factor)*3;
        alpha = (alpha<=1)?((alpha>=0)? alpha : 0) : 1;
        xray.css('opacity', alpha).css('filter','alpha(opacity=' + alpha*100 + ')');

      }

      this.activate = function(){
        XRayObjectPageParagraph.superclass.activate.call(this);
        effect = false;

      }

      this.updateBackgroundPosition  = function (value){
        //
      }
    }
  }
  Core.Object.extend(XRayObjectPageParagraph, PageParagraph);


  var SoundEffectPageParagraph = function (node) {
    SoundEffectPageParagraph.superclass.constructor.call(this, node);
    var instance = this;
    var audioData;
    var spectrum;
    var temp = new Array(512);
    var slice;
    var paused = true;
    var initialized = false;
    var width = 600;
    var height = 300;
    this.init = function() {
      width = this.node.find('h1').width();
      this.canvas = this.node.find('canvas')[0];
      this.canvas.setAttribute('width',  width);
      this.context = this.canvas.getContext('2d');
      this.context.strokeStyle = '#fff'
      this.context.fillStyle = '#fff'
      audioData = new AudioData(getWcmsPrefix() + instance.node.find('a.play').attr('data-mp3'), getWcmsPrefix() + instance.node.find('a.play').attr('data-ogg'), instance.node.find('a.play').attr('data-jpg'))
      this.framerate = 25;
      this.minframerate = 25;
      this.node.find('a.play').bind('click',playPauseclickHandler);
      pause();
    }

    this.activate = function () {
      SoundEffectPageParagraph.superclass.activate.call(this);
      if(audioData && audioData.audioFile.readyState >= 4 && audioData.audioFile.currentTime != 0){
      	audioData.audioFile.currentTime = 0;
      }
      this.stopRendering();
    }

    this.deactivate = function () {
      pause();
      SoundEffectPageParagraph.superclass.deactivate.call(this);
    }

    this.render = function(){
      if (!initialized && audioData.audioImage.complete && audioData.audioFile.readyState >= 4) {
        initialized = true;
        audioData.audioFile.volume = 1;
        spectrum = new Spectrum(audioData);
      }else if(!initialized){
        SoundEffectPageParagraph.superclass.render.call(this)
        return;
      }
      if(!paused && audioData.audioFile.currentTime < audioData.audioFile.duration){
        //Clear
        this.context.clearRect(0, 0, this.canvas.width , this.canvas.height);
        var s = spectrum.getData(audioData.audioFile.currentTime*1000);
        var length = s.length/8;
        var halflength = length/8;
        var barWidth = width/length;
        var i = length;
        var j = halflength;
        var f = 0;
        var x = 0;
        var y = 0
        this.context.beginPath();

        while(--i>=0){

          if(temp[i]){
            temp[i] += (s[i] - temp[i])*0.05;
          }else{
            temp[i] = s[i];
          }
          j += (i>halflength)? -1 : 1;
          f = 1-(j/halflength)*(j/halflength)*(j/halflength);
          x = (barWidth)*i;
          y = height-(Math.abs(temp[i]*4)*height)-1;
          this.context.lineTo(x,height-13);
          this.context.lineTo(x,y-13);
          this.context.lineTo(x+barWidth-1,y-13);
          this.context.lineTo(x+barWidth-1,height-13);
        }
        this.context.fill();
      }else if(!paused){
        pause();
      }
      SoundEffectPageParagraph.superclass.render.call(this)
    }

    this.reset = function(){

      if(this.context){
        var i = 512;
        var barWidth = width/512
        var x;
        var y;
        while(--i>=0){
          x = (barWidth)*i;
          y = height-1;
          this.context.lineTo(x,height);
          this.context.lineTo(x,y);
          this.context.lineTo(x+barWidth-1,y);
          this.context.lineTo(x+barWidth-1,height);
        }
        this.context.fill();
        this.context.clearRect(0, 0, this.canvas.width , this.canvas.height);

      }
    }

    var playPauseclickHandler = function(event){
      if(!paused){
        pause();
      }else{
        play();

      }
      return false;
    }

    var play = function() {
      trackPage(self.location.pathname.substring(0, self.location.pathname.lastIndexOf("/")) + '/' + currentColumnId + '/' + instance.id + '/play.html');
      instance.startRendering();
      paused = false;
      instance.node.find('canvas').stop().animate({
        'bottom':'0px'
      },'fast');
      instance.node.find('h1').stop().animate({
        'bottom':'-300px'
      },'fast');
      $('a.play').removeClass('play').addClass('pause');
      if(audioData && audioData.audioFile){
        audioData.audioFile.play();
      }
    }

    var pause = function(){
      instance.stopRendering();
      instance.reset();
      paused = true;
      $('a.pause').removeClass('pause').addClass('play');
      instance.node.find('canvas').stop().animate({
        'bottom':'-350px'
      },'fast');
      instance.node.find('h1').stop().animate({
        'bottom':'0px'
      },'fast');
      if(audioData && audioData.audioFile){
        audioData.audioFile.pause();
      }

    }


    var AudioData = function(mp3,ogg,jpg){
      this.audioFile = new Audio();
      if (this.audioFile .canPlayType('audio/mpeg') != 'no'  && this.audioFile .canPlayType('audio/mpeg') != '') {
        this.audioFile.src = mp3;
      } else {
        this.audioFile.src = ogg
      }
      this.audioImage = new Image() ;
      this.audioImage.src = jpg;
    }

    var Spectrum = function(audioData){

      var fps = 1000/25;
      var spectrum;

      var init = function(audioData){
        if(audioData instanceof AudioData){
          spectrum = getImageData(audioData.audioImage);

        }else{
          throw new Error('AudioData needs to be an instance of AudioData');
        }
      }


      this.getData = function(time){
        if(spectrum){
          var t = time/fps;
          var d = [];
          var i = spectrum.width;
          while(--i>=0){
            d[d.length] = (spectrum.data[((parseInt(t)*(spectrum.width*4)) + (i*4))+2]/127.5)-1;
          }
        }
        return d;
      }

      var getImageData = function(image){
        var itemCanvas = document.createElement('CANVAS');
        itemCanvas.width = image.width;
        itemCanvas.height = image.height;
        var itemContext = itemCanvas.getContext('2d');
        itemContext.drawImage(image,0,0);
        var data = itemContext.getImageData(0, 0,  itemCanvas.width , itemCanvas.height);
        itemContext = null;
        itemCanvas = null;
        return data;
      }
      init(audioData);
    };
  }
  Core.Object.extend(SoundEffectPageParagraph, CanvasPageParagraph);

  var SoundPageParagraph = function (node) {
    SoundPageParagraph.superclass.constructor.call(this, node);
    var instance = this;
    var audioData;
    var paused = true;
    this.init = function() {
      if (AUDIO_TAG_SUPPORT) {
        audioData = new AudioData(getWcmsPrefix() + instance.node.find('a.play').attr('data-mp3'), getWcmsPrefix() + instance.node.find('a.play').attr('data-ogg'), instance.node.find('a.play').attr('data-jpg'));
      }
      else {
        var flash = new SWFObject(audioPlayerSwf, "flashAudioMovie", "430", "20", "9", "#ffffff");
        flash.addParam("allowScriptAccess", "sameDomain");
        flash.addParam("wmode", "opaque");
        flash.addVariable("prm_audiofile", getWcmsPrefix() + instance.node.find('a.play').attr('data-mp3'));
        audioData = flash.write("flashAudioContainer");
      }
      this.node.find('a.play').bind('click',playPauseclickHandler);
    }


    this.activate = function () {
      SoundPageParagraph.superclass.activate.call(this);
    }

    this.deactivate = function () {
      pause();
      SoundPageParagraph.superclass.deactivate.call(this);
    }

    var playPauseclickHandler = function(event){
      if(!paused) {
        pause();
      }
      else {
        play();
      }
      return false;
    }

    var play = function(){
      trackPage(self.location.pathname.substring(0, self.location.pathname.lastIndexOf("/")) + '/' + currentColumnId + '/' + instance.id + '/play.html');
      paused = false;
      $('a.play').removeClass('play').addClass('pause');
      if (AUDIO_TAG_SUPPORT) {
        audioData.audioFile.play();
      }else{
        try {
          thisMovie("flashAudioMovie").startPlayback();
        } catch (e) {
        }
      }
    }
    var pause = function(){
      paused = true;
      $('a.pause').removeClass('pause').addClass('play');
      if (AUDIO_TAG_SUPPORT) {
        if(audioData && audioData.audioFile){
          audioData.audioFile.pause();
        }
      }else{
        try {
          thisMovie("flashAudioMovie").stopPlayback();
        } catch (e) {
        }
      }
    }

    var AudioData = function(mp3,ogg,jpg) {
      this.audioFile = new Audio();
      if (this.audioFile .canPlayType('audio/mpeg') != 'no'  && this.audioFile .canPlayType('audio/mpeg') != '') {
        this.audioFile.src = mp3;
      } else {
        this.audioFile.src = ogg
      }
      this.audioImage = new Image();
    }

    this.init();

  }
  Core.Object.extend(SoundPageParagraph, PageParagraph);


  var IntroParagraph = function(node) {

    IntroParagraph.superclass.constructor.call(this, node);

    this.height = PARAGRAPH_HEIGHT * 2;

    var instance = this;

    if(VIDEO_TAG_SUPPORT) {

      var videoElement = document.getElementById(instance.node.find('.intro_video video').attr('id'));

      this.activate = function () {
        videoElement.currentTime = 1.0;
        videoElement.play();
        IntroParagraph.superclass.activate.call(this);
      }

      this.deactivate = function () {
        videoElement.pause();
        IntroParagraph.superclass.deactivate.call(this);
      }

    } else if(FLASH_VIDEO_ACTIVE) {

      this.activate = function () {
      	IntroParagraph.superclass.activate.call(this);
    	try{
        	getFlashObject(this.node.find('.intro_video').attr('id') + '_flash').playVideo();
    	}catch(e){
    	}
      }


      this.deactivate = function () {
      	try{
       		getFlashObject(this.node.find('.intro_video').attr('id') + '_flash').stopVideo();
       	}catch(e){
    	}
        IntroParagraph.superclass.deactivate.call(this);
      }

    }

	var getFlashObject = function(id) {
        if (document.embeds && document.embeds[id]) {
          return document.embeds[id];
        } else {
         return document.getElementById(id);
        }
        return null;
	}


    this.updateBackgroundPosition  = function (value){
      //
    }


  }
  Core.Object.extend(IntroParagraph, PageParagraph);


  function wheely(speed){

    function wheelScrollHandler(event){
      var delta = 0;
      if (!event){
        event = window.event;
      }
      if (event.wheelDelta) {
        delta = event.wheelDelta/120;
        if (window.opera){
          delta = -delta;
        }
      }
      else if (event.detail){
        delta = -event.detail/3;
      }
      if (delta){
        var scrolltop =  window.pageYOffset || document.body.scrollTop || document.documentElement.scrollTop;
        window.scrollTo(0,scrolltop-delta*speed,0);
      }
      if (event.preventDefault){
        event.preventDefault();
      }else{
        event.returnValue = false;
      }
    }
 
    if (window.addEventListener){
      window.addEventListener('DOMMouseScroll', wheelScrollHandler, false);
    }else{
      window.onmousewheel = document.onmousewheel = wheelScrollHandler;
    }
  };

  init();
};

function adjustStyle() {
  var screenWidth = $(this).width();
  if (screenWidth < 1025) {
    $("#f10m_stylesheet").attr("href", smallCss);
  }
  else {
    $("#f10m_stylesheet").attr("href", largeCss);
  }
}



function closeM5sedanHiglight() {
  var referrerUrl = document.referrer.substring(0, document.referrer.lastIndexOf("/"));
  if(typeof(close_back_link_url_highlight) != "undefined") {
    var targetUrl = close_back_link_url_highlight;
    if(typeof(close_back_link_url_design_absolute) != "undefined") {
      if(referrerUrl.indexOf(close_back_link_url_design_absolute) != -1) {
        targetUrl = close_back_link_url_design;
      }
    }
    if(typeof(close_back_link_url_driving_dynamics_absolute) != "undefined") {
      if(referrerUrl.indexOf(close_back_link_url_driving_dynamics_absolute) != -1) {
        targetUrl = close_back_link_url_driving_dynamics;
      }
    }
    self.location.href = targetUrl;
  }
}

function scrollBlink() {
  if(scrollBlinkCounter == 3) {
    //$('#scrolldown img').css('visibility','hidden');
  }
  else {
    $('#scrolldown img:eq(' + scrollBlinkCounter + ')').css('visibility','visible');
  }
  scrollBlinkCounter++;
  if(scrollBlinkCounter > 4) {
    window.clearTimeout(scrollBlinkTimer);
  }
  else {
    scrollBlinkTimer = window.setTimeout("scrollBlink()", 250);
  }
}