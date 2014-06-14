/** this javascript is for to prevent errors from remaining code of the old module or main navigation */
var isFolding, resetModulNaviTimer, moduleHeader;
function moduleNaviReset(){}

function highlightNavigations(moduleNaviFolded, initModuleNavigation, startCounter){
  changeLinksAccordingToStage();
  if (document.getElementById('mainNavigation') !== undefined) {
    //mainNavigation = new MainNavigation('mainNavigation');
    //mainNavigation.initFolding( 10, 50 );
    //mainNavigation.init();
  }
  if (document.getElementById('moduleNavigation') != undefined) {
    moduleNavigation = new ModuleNavigation('moduleNavigation', moduleNaviFolded);
    moduleNavigation.init();
    clearTimeout(isFolding);
  }
  // There is a bug in Firefox on Macintosh. If a flash movie is overlayed by a
  // semi-transparent HTML layer set with -moz-opacity the flash movie is not visible
  // Therefor we remove this setting on firefox mac, if the page contains an embed tag
  if (browserId == "Firefox" && platform == "mac os x" && document.getElementsByTagName('embed').length > 0) {
    document.getElementById('moduleNavigation').style.MozOpacity = "1";
    document.getElementById('moduleNavigation').style.opacity = "1";
  }
  highlightBottomNavigation();
}
function highlightBottomNavigation(){
  var currentLinkList = document.getElementById('metaNavigationInline').getElementsByTagName('a');
  var links = new Array(currentLinkList.length);
  for (var i = 0; i < currentLinkList.length; i++) {
    if (currentLinkList[i].href.indexOf('javascript:') == -1 && currentLinkList[i].href.indexOf('http://') == -1) {
      links[i] = 'http://' + window.location.hostname + '' + currentLinkList[i].href;
    } else {
      links[i] = currentLinkList[i].href;
    }
  }
  var evaluatedLinks = evaluateHighlighting(location.href, links);
  var highlightedIndex = -1;
  var bestmatch = 999;
  for (var i = 0; i < evaluatedLinks.length; i++) {
    if (evaluatedLinks[i] < bestmatch) {
      bestmatch = evaluatedLinks[i];
      highlightedIndex = i;
      if (evaluatedLinks[i] == -2) {
        break;
      }
    }
  }
  if (highlightedIndex != -1) {
    currentLinkList[highlightedIndex].style.color = '#003399';
  }
}

function resetBottomNavigation(){}

function openChooseBandLayer(headline, copy, linktext_start, linktext_back){
  var chooseBandLayer = '<' + 'div id="contentHiBand">' +
  '<' + 'h2>' + headline + '</h2>' +
  '<' + 'span id="vSpace" style="padding-bottom:2px;"></span>' +
  '<' + 'p>' + copy + '</p>' +
  '<' + 'span id="vSpace" style="padding-bottom:19px;"></span>' +
  '<' + 'ul class="linkList">' +
  '<' + 'li><' + 'a href="javascript:changeToHiEndVersion();"><' + 'img src="' + transGif + '" class="arrow" alt="" />' + linktext_start + '</a></li>' +
  '<' + 'li><' + 'a href="javascript:closeChooseBandLayer();"><' + 'img src="' + transGif + '" class="arrow" alt="" />' + linktext_back + '</a></li>' +
  '</ul>' + '</div>' +
  '<' + 'div style="position:absolute; top:2px; right:2px; width:13px; height:12px;">' +
  '<' + 'a href="javascript:closeChooseBandLayer();" onMouseOver="document.getElementsByTagName(\'img\')[\'closeImgHighendLayer\'].src=\'' + close2Gif + '\';" onMouseOut="document.getElementsByTagName(\'img\')[\'closeImgHighendLayer\'].src=\'' + closeGif + '\';">' +
  '<' + 'img src="' + closeGif + '" id="closeImgHighendLayer" preload="' + close2Gif + '" width="13" height="12" />' + '</a>' +
  '</div>';
  var pos = getWindowInformation('scrollTop');
  var newDiv = document.createElement('div');
  newDiv.id = 'changeToHighend';
  newDiv.style.position = 'absolute';
  newDiv.style.top = 157 + pos + 'px';
  newDiv.style.left = '194px';
  newDiv.style.width = '632px';
  newDiv.style.height = '305px';
  newDiv.style.border = '1px solid #acacac';
  //newDiv.style.border = '1px solid #acacac';
  newDiv.style.backgroundColor = '#ffffff';

  newDiv.style.zIndex = 922;
  newDiv.innerHTML = chooseBandLayer;

  if (!document.getElementById('changeToHighend')) {
    document.getElementsByTagName('body')[0].appendChild(newDiv);
    document.getElementById('changeVersionLink').className = 'menu linkHighlight';
    setCurtain(1);
    curtainInUse = true;
  } else {
    closeChooseBandLayer();
    setCurtain(0);
    curtainInUse = false;
  }
}
/** This class handles the complete functionality of the main navigation
 * @projectDescription Main Navigation Class. This class handles the complete functionality of the main navigation
 * @author Marcello di Simonoe, marcello.disimone@interone.de
 * @version 1.0
 */
var mainNavigation;
/** This class handles all functionality of the main navigation
 * @classDescription This class handles all functionality of the main navigation
 * @param {String} mainNavigationId is the ID of the element that contains the modulenavigation or otherwise the HTML of the navigation should be written in
 * @constructor
 */
var MainNavigation = (function(){
  var _maxFold = 75;
  /** Boolean value if the hoover for folding is activated
   * @type {Boolean}
   */
  var hoverActive = false;
  /** Boolean value if the menu is active which means currently clicked or hovered
   * @type {Boolean}
   */
  var menuActive = false;
  /** Boolean value if the folding of the navigation is activated
   * @type {Boolean}
   */
  var foldingActive = false;
  /** Object of the last/current active menu topic
   * @type {Object}
   */
  var oldMenuObject;
  /** Object of the encapsulating div in which the HTML code of the navigation will be writen
   * @type {Object}
   */
  var mnContainer;
  /** Event Object, needs to be set after DOM initialisation.
   * @type {Object}
   * @see #init
   */
  var idModules;
  var eventObj;
  /** Number of the folding animation intervall
   * @type {Number}
   */
  var foldIntId;
  /** Number of the mouse position controll intervall
   * @type {Number}
   */
  var mouseIntId;
  /** Number of steps the folding animation should make
   * @type {Number}
   */
  var _foldingSteps = 1;
  /** Number of milliseconds to wait between the animation steps
   * @type {Number}
   */
  var _foldInterval = 10;
  /** Current top position of the navigation container div
   * @type {Number}
   * @see #mnContainer
   */
  var currentTop;
  /** Current position of the mouse, determined by onMouseMoveEvent
   * @type {Number}
   * @see #onMouseMoveEvent
   */
  var currentMouseY = 400;
  return (function(mainNavigationId){
    /** because private functions do not know the selfreferenzing variable 'this' (only public functions do), self is defined as placeholder that is used by both types of functions
     * @type {Object}
     */
    var self = this;
    /** initializes the main navigation
     * @alias mainNavigation.init
     */
    this.init = function(){
      mnContainer = document.getElementById('mainNavigationContainer');
      idModules = document.getElementById('idModuls');
      var mnTopicUsedVehicles = document.getElementById('topic_usedvehicle');
      var mnTopicOwner = document.getElementById('topic_owner');
      var mnTopicInsights = document.getElementById('topic_insights');

      var firstWidth = mnTopicUsedVehicles.offsetWidth + 1;
      var secondWidth = mnTopicOwner.offsetWidth + 1;

      mnTopicOwner.getElementsByTagName('div')[0].style.left = -firstWidth;
      mnTopicInsights.getElementsByTagName('div')[0].style.left = -(firstWidth + secondWidth);

      if (window.addEventListener) {
        document.addEventListener("click", function(){ self.closeMenu(); }, false);
      } else if (window.attachEvent) {
        document.attachEvent("onclick", function(){ self.closeMenu(); });
      }
      highlightNavigation();
    };
    /** starts the folding animation of the main navigation
     * @alias mainNavigation.initFolding
     * @param {Number} foldingSteps   amount of steps the animation should run
     * @param {Number} foldInterval   amount of seconds to wait between the steps
     */
    this.initFolding = function(foldingSteps, foldInterval){
      if( modulenaviAnimation != false ){
        _foldingSteps = (foldingSteps !== undefined && typeof foldingSteps == 'number') ? foldingSteps : _foldingSteps;
        _foldInterval = (foldInterval !== undefined && typeof foldInterval == 'number' && foldInterval > 200) ? foldInterval : _foldInterval;
      }

      if(!foldingActive){
        mnContainer.style.top = 0;
        currentTop = parseInt(mnContainer.style.top, 10);

        eventObj = (window.document.compatMode && window.document.compatMode == "CSS1Compat") ? window.document.documentElement : window.document.body || null;
        document.onmousemove = onMouseMoveEvent;
        mouseIntId = window.setInterval( function(){ triggerFolding(); }, 200 );
        foldingActive = true;
      }
      triggerFolding();
    };
    /** resets the navigation to normal and removes folding functionality */
    this.stopFolding = function(){
      mnContainer.style.top = 0;
      document.onmousemove = undefined;
      foldingActive = false;
      idModules.style.position = 'absolute';
      window.clearInterval(mouseIntId);
      window.clearInterval(foldIntId);
    }
    /** highlights the current active menu topic */
    var highlightNavigation = function(){
      var mnObj = document.getElementById(mainNavigationId);
      var currentHighlightLinks = mnObj.getElementsByTagName('a');
      var linksMain = [];
      for (var i = 0; i < currentHighlightLinks.length; i++) {
        if (currentHighlightLinks[i].href.indexOf('javascript:') == -1 && currentHighlightLinks[i].href.indexOf('http://') == -1) {
          linksMain[i] = 'http://' + window.location.hostname + '' + currentHighlightLinks[i].href;
        } else {
          linksMain[i] = currentHighlightLinks[i].href;
        }
      }
      var evaluatedLinks = evaluateHighlighting(window.location.href, linksMain);
      var highlightedIndex = -1;
      var bestmatch = 999;
      for (var j = 0; j < evaluatedLinks.length; j++) {
        if (evaluatedLinks[j] < bestmatch) {
          bestmatch = evaluatedLinks[j];
          highlightedIndex = j;
          if (evaluatedLinks[j] == -2) {
            break;
          }
        }
      }
      if (highlightedIndex != -1) {
        var currentLink = currentHighlightLinks[highlightedIndex];
        addClassName(currentLink, 'mainNaviHighlight');
        var currentNavParent = currentLink.getAttribute('navParent');
        if (currentNavParent) {
          addClassName(document.getElementById(currentNavParent), 'mainNaviHighlight');
        }
        if ( hasClassName( currentLink, 'topicHeader' ) ) {
          if (currentHighlightLinks[ highlightedIndex + 1 ] ) {
            addClassName(currentHighlightLinks[highlightedIndex + 1], 'mainNaviHighlight');
          }
        }
      }
    };
    /** checks the position of the mouse coursor on every mousemove event this is a walkaround for an onmouseover event on the main navigation, wich leads to jittering animation
     * @param {Event} e   current event
     */
    var onMouseMoveEvent = function(e){
      if (!e) {
        e = window.event;
      }
      currentMouseY = e.pageY ? e.pageY : e.clientY + eventObj.scrollTop;
    };
    /** checks if the mouse position is over the active hover area or not and triggers the apropriate folding animation */
    var triggerFolding = function(){
      var currentHover = currentTop + parseInt(mnContainer.offsetHeight, 10) + 30;
      // if the moduleNavigation is folded out, add the height of it to the active hover area
      if (!moduleNavigation.folded) {
        currentHover += parseInt(moduleNavigation.offsetHeight, 10);
      }
      if (currentMouseY < currentHover && currentTop < 0) {
        window.clearInterval(foldIntId);
        foldIntId = window.setInterval( function(){ moveDown(); }, _foldInterval);
      } else if (currentMouseY > currentHover && currentTop > -_maxFold) {
        if (!moduleNavigation.folded) {
          moduleNavigation.startFold( false );
        }
        window.clearInterval(foldIntId);
        foldIntId = window.setInterval( function(){ moveUp(); }, _foldInterval);
      }
    };
    /** moves the animation stepwise until it reaches the lowest possible position */
    var moveDown = function(){
      currentTop = parseInt(mnContainer.style.top, 10);
      if (currentTop < 0) {
        var nextPos = (currentTop + (_maxFold / _foldingSteps));
        mnContainer.style.top = ( nextPos > 0 )?  '0px':nextPos + 'px';
        idModules.style.top = ( nextPos > 0 )?  '0px': nextPos * (-1);
      } else {
        window.clearInterval(foldIntId);
      }
    };
    /** moves the animation stepwise until it reaches the highest possible position */
    var moveUp = function(){
      currentTop = parseInt(mnContainer.style.top, 10);
      if (currentTop > -_maxFold) {
        var nextPos = (currentTop - (_maxFold / _foldingSteps));
        mnContainer.style.top = ( nextPos < -_maxFold )?  -_maxFold + 'px':nextPos + 'px';
        idModules.style.top = ( nextPos < -_maxFold )?  _maxFold + 'px': nextPos * (-1);
      } else {
        window.clearInterval(foldIntId);
      }
    };
    /** this function closes the currently active subtopic layer
     * @alias mainNavigation.closeMenu
     */
    this.closeMenu = function(){
      if (!hoverActive && oldMenuObject !== undefined) {
        this.nodeAction(oldMenuObject, 'click');
      }
    };
    /** This function will be called by the topic links in the navigation to handle opening and closing of subtopics
     * @alias mainNavigation.nodeAction
     * @param {Object} nodeObject   object reference to the clicked link element
     * @param {String} eventType    string of event type 'click', 'mouseover' and 'mouseout' are possible values
     */
    this.nodeAction = function(nodeObject, eventType){
      if ((oldMenuObject == nodeObject && eventType == 'click')) {
        setCurtain(0);
        if (foldingActive && eventType == 'click') {
          mouseIntId = window.setInterval(function(){ triggerFolding(); }, 200);
        }
        removeClassName(nodeObject.parentNode, 'active');
        oldMenuObject = undefined;
        menuActive = false;
      } else {
        if( eventType == 'click' ){
          setCurtain(1);
          if (foldingActive) {
            clearInterval(mouseIntId);
          }
        }
        if (eventType == 'click' || (eventType == 'mouseover' && menuActive)) {
          if (oldMenuObject !== undefined) {
            removeClassName(oldMenuObject.parentNode, 'active');
          }
          addClassName(nodeObject.parentNode, 'active');
          oldMenuObject = nodeObject;
          menuActive = true;
        }
      }
      if (eventType == 'mouseover') {
        hoverActive = true;
      } else if (eventType == 'mouseout') {
        hoverActive = false;
      }
      return false;
    };
  });
})();
/** Module Navigation Class. This class handles all functionality of the module navigation
 * @projectDescription Module Navigation Class. This class handles all functionality of the module navigation
 * @author Marcello di Simone
 * @namespace ModuleNavigation
 * @version 1.0
 */
var modulenaviAnimation = true;
var hiddenModuleNavigation = false;
var moduleNavigation;
/** This class handles all functionality of the module navigation
 * @classDescription This class handles all functionality of the module navigation
 * @constructor
 * @return {ModuleNavigation}
 */
var ModuleNavigation = (function(){
  var _normalHeight = 460;
  var _teaserHeight = 300;
  var _closedHeight = 42;
  var _hiddenHeight = 22;
  /** maximum height of the entire module navigation
   * @type {Number}
   */
  var _maxHeight;
  /** minimum height of the entire module navigation
   * @type {Number}
   */
  var _minHeight = 42;
  /** height of the subtopic element
   * @type {Number}
   */
  var _subtopicHeight = 0;
  /** Number of steps the folding animation should make
   * @type {Number}
   */
  var _foldingSteps = 10;
  /** Number of milliseconds to wait between the folding animation steps
   * @type {Number}
   */
  var _foldInterval = 20;
  /** Number of steps the scroll animation should make
   * @type {Number}
   */
  var _scrollSteps = 100;
  /** Number of milliseconds to wait between the scroll animation steps
   * @type {Number}
   */
  var _scrollInterval = 20;
  /** Number of the scroll animation intervall
   * @type {Number}
   */
  var scrollIntId;
  /** Number of the fold animation intervall
   * @type {Number}
   */
  var foldIntId;
  /** current active node element test bla @see init
   * @type {DOMElement}
   * @see init
   */
  var activeNode;
  /** current active parent node element
   * @type {DOMElement}
   */
  var activeTopNode;
  /** the last node which has been activated
   * @type {DOMElement}
   */
  var oldNode;
  /** the current active list element with scrollable content
   * @type {DOMElement}
   */
  var currentScrollContent;
  /** the container holding the scroll controll elements
   * @type {DOMElement}
   */
  var scrollControll;
  /** the list element containing the module navigation list
   * @type {DOMElement}
   */
  var moduleNavigationList;
  /** HTML element to write the final code into
   * @type {DOMElement}
   */
  var outputObject;
  var scrollState = false;
  return (function(outputObjectId, startFolded){
    outputObject = document.getElementById(outputObjectId);
    this.folded = false;
    var self = this;
    /** initialize the current module navigation
     * @alias moduleNavigation.init
     */
    this.init = function(){
      scrollControll = document.getElementById('scrollControll');
      moduleNavigationList = document.getElementById('moduleNavigationList');
      _maxHeight = _normalHeight;
      if( moduleNavigationList != undefined ){
        // style attribute needs to be set for later use, cause it's not initialized
        // with the css class value by default
        _subtopicHeight = moduleNavigationList.offsetHeight + moduleNavigationList.offsetTop;
        if (startFolded) {
          addClassName(outputObject, 'closed');
          this.folded = true;
        }
        highlightNavigation();
        if( modulenaviAnimation == false ){
          this.configureFoldingAnimation( 1, 10 );
        }
        if( hiddenModuleNavigation ){
          outputObject.style.height = 'auto';
          this.hideModuleNavigation( hiddenModuleNavigation )
        } else {
          outputObject.style.height = (startFolded) ? _minHeight + 'px' : _maxHeight + 'px';
        }
      }
    };
    /** Switchs the module navigation to teaser mode and back to normal
     * @param {Boolean} setActive defines if the Teaser Mode should be activated or not
     */
    var setTeaserMode = function( setActive ){
      if( setActive ){
        _maxHeight = _teaserHeight;
        outputObject.style.height = _maxHeight;
        addClassName(outputObject, 'teaserMode');
      }else{
        _maxHeight = _normalHeight;
        outputObject.style.height = _maxHeight;
        removeClassName(outputObject, 'teaserMode');
      }
    };
    /** This method gets a list of all links inside the module navigation and checks the link url against the windows location */
    var highlightNavigation = function(){
      var currentHighlightLinks = moduleNavigationList.getElementsByTagName('a');
      var linksMain = [];
      for (var i = 0; i < currentHighlightLinks.length; i++) {
        if (currentHighlightLinks[i].href.indexOf('javascript:') == -1 && currentHighlightLinks[i].href.indexOf('http://') == -1) {
          linksMain[i] = 'http://' + window.location.hostname + '' + currentHighlightLinks[i].href;
        } else {
          linksMain[i] = currentHighlightLinks[i].href;
        }
      }
      var evaluatedLinks = evaluateHighlighting(window.location.href, linksMain);
      var highlightedIndex = -1;
      var bestmatch = 999;
      for (var j = 0; j < evaluatedLinks.length; j++) {
        if (evaluatedLinks[j] < bestmatch) {
          bestmatch = evaluatedLinks[j];
          highlightedIndex = j;
          if (evaluatedLinks[j] == -2) {
            break;
          }
        }
      }
      if (highlightedIndex != -1) {
        if( currentHighlightLinks[highlightedIndex].getAttribute('teasermode') == "true" ){
          setTeaserMode( true );
        }
        self.highlightCurrentLink(currentHighlightLinks[highlightedIndex]);
      }
    };
    /** This method adds the hightlighting class to the link element passed by currentLink
     * @alias moduleNavigation.highlightCurrentLink
     * @param {DOMElement} currentLink is a reference to the link element to be highlighted
     */
    this.highlightCurrentLink = function(currentLink){
      addClassName(currentLink, 'moduleNaviHighlight');
      var currentNavParentID = currentLink.getAttribute('navParent');
      if (currentNavParentID != undefined) {
        var currentNavParent = document.getElementById(currentNavParentID);
        this.nodeAction(currentLink, false);
        this.highlightCurrentLink(currentNavParent);
      } else {
        var nextNode = getNextSibling(currentLink);
        if (nextNode !== null) {
          activeNode = currentLink.parentNode;
          initScrollControll(true);
        } else {
          initScrollControll(false);
        }
      }
    };
    /** Firefox walkaround to determin the next sibbling DOM node. Because Firefox defines formating whitespaces between tags as a textnode
     * @param {DOMElement} currentLink is a reference to an object to start with
     */
    var getNextSibling = function(currentLink){
      if( currentLink.nextSibling != undefined ){
        var nextNode = currentLink.nextSibling;
        while (nextNode.nodeType != 1) {
          if (nextNode.nextSibling != null) {
            nextNode = nextNode.nextSibling;
          } else {
            return null;
          }
        }
        return nextNode;
      } else {
        return null;
      }
    };
    /** initialize the folding animation of the menu
     * @param {Number} step is the value to alter the height of the navigation on each repeat
     */
    var foldNavigation = function(step){
      var currentHeight = outputObject.offsetHeight;
      if ((!self.folded && currentHeight > _minHeight) || (self.folded && currentHeight < _maxHeight)) {
        if (currentHeight + step < _minHeight) {
          outputObject.style.height = _minHeight + 'px';
        } else if (currentHeight + step > _maxHeight) {
          outputObject.style.height = _maxHeight + 'px';
        } else {
          outputObject.style.height = (currentHeight + step) + 'px';
          return true;
        }
      }
      stopFold();
    };
    /** This function initialize the folding animation of the module navigation
     * @alias moduleNavigation.startFold
     * @param {Boolean} forceAction is a boolean Value if the module navigation should be explizitly closed or opend
     */
    this.startFold = function( forceAction ){
      window.clearInterval(foldIntId);
      var step;
      if ( !this.folded && ( forceAction == undefined || forceAction === true ) ) {
        step = Math.round((_minHeight - outputObject.offsetHeight) / _foldingSteps);
      } else if( this.folded && ( forceAction == undefined || forceAction === false ) ) {
        step = Math.round((_maxHeight - outputObject.offsetHeight) / _foldingSteps);
      }
      if( step != null && step != 0 ){
        foldIntId = window.setInterval(function(){
          foldNavigation(step);
        }, _foldInterval);
      }
    };
    /** This function stops the folding animation of the module navigation */
    var stopFold = function(){
      window.clearTimeout(foldIntId);
      if (self.folded) {
        removeClassName(outputObject, 'closed');
      } else {
        addClassName(outputObject, 'closed');
      }
      self.folded = !self.folded;
    };
    /** with this method you're able to set the speed of the folding animation
     * @alias moduleNavigation.configureFoldingAnimation
     * @param {Number} foldingSteps defines how many steps the animation takes to finish
     * @param {Number} foldingIntervall defines the time to wait until the next step
     */
    this.configureFoldingAnimation = function(foldingSteps, foldingIntervall){
      _foldingSteps = foldingSteps;
      _foldInterval = foldingIntervall;
    };
    /** Shows and positions or hides the scollControll layer
     * @todo same like in nodeAction
     * @see BMW.ModuleNavigation.nodeAction
     * @param {Boolean} scrollState is a boolean value if the subtopic scoller will be displayed or hidden
     */
    var initScrollControll = function(scrollState){
      if (scrollState) {
        activeTopNode = activeNode;
        scrollControll.style.top = activeTopNode.offsetTop + 'px';
        scrollControll.style.height = activeTopNode.offsetHeight - 10 + 'px';
        currentScrollContent = activeTopNode.getElementsByTagName('ul')[0];
        showScrollIfNeeded();
      } else {
        activeTopNode = null;
        scrollControll.style.display = 'none';
      }
    };
    /** checks the height of the child elements of scrollable container and shows/hides the scoll controll if needed */
    var showScrollIfNeeded = function(){
      if ( activeTopNode != undefined ) {
        currentScrollContent.scrollTop = 0;
        var currentContent = activeTopNode.getElementsByTagName('ul')[0].firstChild;
        var currentHeight = 0;
        while( currentContent != null ){
          currentHeight += ( currentContent.offsetHeight != undefined )? currentContent.offsetHeight + 5:0;
          currentContent = currentContent.nextSibling;
        }
        if ( currentHeight > activeTopNode.offsetHeight ) {
          setTimeout( function(){ scrollControll.style.display = 'block'; scrollState = true; }, 50 );
        }else{
          setTimeout( function(){ scrollControll.style.display = 'none'; scrollState = false; }, 50 );
        }
      }
    };
    /** scrolls the content of the currentScrollContent
     * @param {Number} step defines a value to alter the scroll position of the element
     */
    var scrollContent = function(step){
      if ((step > 0 && activeTopNode.scrollTop < currentScrollContent.offsetHeight ) || (step < 0 && currentScrollContent.scrollTop > 0)) {
        currentScrollContent.scrollTop += step;
      } else {
        self.stopScroll();
      }
    };
    /** Sets an interval to scroll the current subtopic content up or down
     * @alias moduleNavigation.startScroll
     * @param {Number} scrollDirection is a positive or negative value to define the direction of the animation
     */
    this.startScroll = function(scrollDirection){
      this.stopScroll();
      var step = (activeTopNode.offsetHeight / _scrollSteps) * scrollDirection;
      scrollIntId = window.setInterval(function(){ scrollContent(step); }, _scrollInterval);
    };
    /** Stops the current scroll animation interval
     * @alias moduleNavigation.stopScroll
     */
    this.stopScroll = function(){
      window.clearInterval(scrollIntId);
    };
    /** with this method you're able to set the speed of the scroll animation
     * @alias moduleNavigation.configureScrollAnimation
     * @param {Number} scrollSteps defines how many steps the animation takes to finish
     * @param {Number} scrollIntervall defines the time to wait until the next step
     */
    this.configureScrollAnimation = function(scrollSteps, scrollIntervall){
      _scrollSteps = scrollSteps;
      _scrollInterval = scrollIntervall;
    };
    /** Switches the module navigation to hidden or back to normal
     * @param {Boolean} hideNavi defines if the module navigation should be hidden or not
     */
    this.hideModuleNavigation = function( hideNavi ){
      if( hideNavi ){
        addClassName( outputObject, 'hidden' );
      }else{
        removeClassName( outputObject, 'hidden' );
      }
    };
    /** loops through the DOM upwards to find all parent nodes in the list
     * @param {DOMElement} childObject is the object to start with
     * @param {Boolean} setActive defines if the parent element should be set to active or not
     * @return {DOMElement} returns the last parent element that has been found
     */
    var switchParentsActive = function( childObject, setActive ){
      var tmpNodeObj = childObject;
      while (tmpNodeObj.parentNode.id != 'moduleNavigationList') {
        tmpNodeObj = tmpNodeObj.parentNode.parentNode;
        if (setActive) {
          addClassName(tmpNodeObj, 'active');
        } else {
          removeClassName(tmpNodeObj, 'active');
        }
      }
      return tmpNodeObj;
    };
    /** This function will be called by the topic links in the navigation to handle opening and closing of subtopics
     * @alias moduleNavigation.nodeAction
     * @todo find a better way to determin the current parent node element
     * @param {DOMElement} nodeObject is a object reference to the clicked link element
     * @param {Boolean} scrollState is a boolean value if the subtopic scoller should be initialized
     * @return {Boolean} returns false to stop the link to fire
     */
    this.nodeAction = function(nodeObject, scrollState){
      var hasBeenActive = hasClassName( nodeObject.parentNode, 'active' );
      if (typeof oldNode == 'object' && oldNode !== null) {
        var oldNodeObj = switchParentsActive( oldNode, false );
        oldNodeObj.style.height = "auto";
        removeClassName(oldNode, 'active');
      }
      activeNode = nodeObject.parentNode;
      // if scrollState is true, this means it's a 1st level element.
      // and if oldNode and activeNode pointing on the same object,
      // close the current opened element and remove the scrollControll
      if (oldNode == activeNode && scrollState) {
        setTeaserMode( true );
        if (scrollState) {
          initScrollControll(false);
        }
        oldNode = null;
      } else if(oldNode != activeNode && scrollState && hasBeenActive ){
        setTeaserMode( false );
        switchParentsActive( oldNode, false );
        if (scrollState) {
          initScrollControll(false);
        }
        oldNode = null;
      } else if(oldNode == activeNode && !scrollState && hasBeenActive ) {
        setTeaserMode( false );
        var newNodeObj = switchParentsActive( activeNode, true );
        removeClassName( oldNode, 'active');
        oldNode = newNodeObj;
        if (scrollState) {
          initScrollControll(false);
        }else{
          showScrollIfNeeded();
        }
        if( currentScrollContent != undefined ){
          currentScrollContent.style.position = 'static';
          currentScrollContent.style.position = 'relative';
        }
      } else {
        setTeaserMode( false );
        var newNodeObj = switchParentsActive( activeNode, true );
        var newHeight = (_maxHeight - _subtopicHeight);
        newNodeObj.style.height = newHeight + "px";
        newNodeObj.getElementsByTagName('ul')[0].style.height = newHeight - 27 + 'px';
        addClassName(activeNode, 'active');
        if (scrollState) {
          initScrollControll(true);
        }else{
          showScrollIfNeeded();
        }
        oldNode = activeNode;
      }
      return false;
    };
  });
})();