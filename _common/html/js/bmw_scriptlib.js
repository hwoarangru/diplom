resetModulNaviTimer = 5000;
hideCo2LayerTimer = 5000;

var i, e;
var browserAtributeLength, browserId, platform;
var imgCountTotal, lowImageSrc, highImageSrc, currentImg, currentState, currentAct, currentPerm, checkLoad;
var slideAmount;
var divNum, documentLeftScroll, documentTopScroll, mouseX, mouseY, loopDragging;
var speedHorizontal, speedVertical, currentBack, goup, godown, speed, currentObjNo;
var setDivPosition, setBackPosition, currentObjId, currentSpeed, currenDirection, currentDelay;
var diffWidth, diffHeight, lastWidth, lastHeight, currentDiv;
var popupWindow, winUrl;
var ua = navigator.userAgent.toLowerCase();
var an = navigator.appName.toLowerCase();
var framesetPage = "index_narrowband.html";
var framesetPageHighend = "index_highend.html";
var currentStep = 0;
var windowWidth = 0;
var windowHeight = 0;
var browserVersion = 0;
var loaded = 0;
var divLeft = 0;
var divTop = 0;
var looping = -1;
var slideCount = -1;
var writeBrowser = "";
var tempAct = "";
var slideNumber = "";
var slideDescription = "";
var preLoadArray = [];
var preLoadCounter = [];
var highImages = [];
var lowImages = [];
var slideText = [];
var permanentActive = [];
var slideImages = [];
var allowedDomain = ["://www.bmw.", "://bmw.", "://origin.bmw.", "://secure.bmw.", "://wcms10.bmwgroup.com", "://liintra.muc", "://ltintra.muc", "://www-at.bmw", "://www-nl.bmw", "://www-be.bmw", "://www-lu.bmw", "://www-pt.bmw", "://www-ie.bmw", "://www-jp.bmw", "://www-fr.bmw", "://www-cz.bmw", "://www-sk.bmw", "://www-se.bmw", "://www-it.bmw", "://ecom.bmwgroup", "://ecomi.bmwgroup", "localhost"]
var supportedOS = false;
var supportedVersion = false;
var currentLoop = false;
var dragAllowed = false;
var divIsMoving = false;
var flashversion = false;
var topFrame = null;
var contentFrame = null;
var bottomFrame = null;
var historyFrame = null;
var hiddenFrame = null;
var allowClose = true;
var modulNaviOverImage = true;
var idmodulsSpecial = "";
var minFlashVersion = 7;
var isMainnavigation = false;
var indexParameters = "";
var query = {};
var parameterArray = [];
var scrollerDefaultSize = 1024;
var scrollerCheckElements = [];
var scrollerSize = scrollerDefaultSize;
var scrollerBgImage;
var scrollerSliderImage;
var scrollerImageUp;
var scrollerImageDown;
var persoEventType = "";
var persoSeries, persoBodytype, persoModel, persoColor, persoRim;
var cookieName = "bmw_bbDetection";
var chosenConnection = "";
var akamaiCookieName = "bandwidth";
var prmContent = "";
var divsToBeAltered = [];
var useCurtain = false;

/*** Function to filter doublets from an array. Use: myArray = myArray.unique(); */
Array.prototype.unique = function() {
  var o = {};
  for(var i = 0 ; i < this.length; i++)
  o[this[i]] = true;
  var tmp = new Array();
  for(var i in o) tmp[tmp.length] = i;
  return tmp;
}

if (typeof browser != 'object') {
  browser = [['Opera', 'opera ', '9.0', 'windows', 'mac os x', 'other'], ['Safari', 'safari/', '125', '', 'mac os x', ''], ['Netscape', 'netscape/', '7.1', 'windows', 'mac os x', 'other'], ['Firefox', 'firefox/', '1.0', 'windows', 'mac os x', 'other'], ['Mozilla', 'rv:', '1.7', 'windows', 'mac os x', 'other'], ['MSIE', 'msie ', '5.5', 'windows', '', ''], ['Netscape4', 'mozilla/', '4.0', '', '', '']];
}
/***/
function openQuestionnaire(){
  //Leere Funktion f?r eine spezielle bmw.at-Anpassung
  //Bitte nicht entfernen, da diese generell von dem Frameset innerhalb index_highend bei onunload aufgerufen wird!
  //Wird wieder entfernt
  //R. Aust, 28.11.05
}
/***/
function ssoCloseDialog(){
}
/** Checks the compatibility of the client browser against a predefined list of possible browsers */
function checkClient(){
  var browserLength = browser.length;
  for (i = 0; i < browserLength; i++) {
    browserAtributeLength = browser[i].length;
    if (ua.indexOf(browser[i][1]) != -1) {
      browserId = browser[i][0];
      for (e = 3; e < browserAtributeLength; e++) {
        if (browser[i][e] != '' && (ua.indexOf(browser[i][e]) != -1 || browser[i][e] == 'other')) {
          supportedOS = true;
          platform = browser[i][e];
          break;
        } else {
          supportedOS = false;
        }
      }
      browserVersion = ua.split(browser[i][1]);
      browserVersion = parseFloat(browserVersion[1].slice(0, 3));
      if (browserVersion >= browser[i][2]) {
        supportedVersion = true;
      } else {
        supportedVersion = false;
      }
      break;
    } else {
      browserId = 'unknown';
    }
  }
  browserId = ((browserId == "MSIE") ? (((/\s+msie\s+7\.\d+/).test(navigator.appVersion.toLowerCase())) ? ("MSIE7") : (browserId)) : (browserId));
}
/** Returns true if the client browser is compatible or redirects to a fallback site given by incompatibleBrowserUrl
 * @param {String} incompatibleBrowserUrl is the URL to the site, incompatiblle browser should be redirected to
 * @return {Boolean}
 */
function checkBrowser(incompatibleBrowserUrl){
  checkClient();
  return true;
}
/** Checks if the current site is loaded in the appropriate frameset and reloads it otherwise within the frameset */
function checkFrameset(){
  /*removed: function checkFrameset()*/
}
/** This method removes a single class from the given object
 * @param {DOMElement} obj defines the element to remove the class from
 * @param {String} cssClass is the name of the class to be removed
 */
function removeClassName(obj, cssClass){
  if (hasClassName(obj, cssClass)) {
    obj.className = obj.className.replace(new RegExp(cssClass), '');
  }
}
/** This method replaces a single class of the given object with a new class
 * @param {DOMElement} obj defines the element to replace the class from
 * @param {String} oldCssClass is the name of the class to be replaced
 * @param {String} newCssClass is the name of the class will be added instead
 */
function replaceClassName(obj, oldCssClass, newCssClass){
  if (hasClassName(obj, oldCssClass)) {
    obj.className = obj.className.replace(new RegExp(oldCssClass), newCssClass);
  }
}
/** This method checks if the given objects has a specific class defined
 * @param {DOMElement} obj defines the element to check for the class
 * @param {String} cssClass is the name of the class to look for
 * @return {Boolean}
 */
function hasClassName(obj, cssClass){
  return (obj.className.indexOf(cssClass) != -1);
}
/** This method adds a class to a specific objects
 * @param {DOMElement} obj defines the element to add the class
 * @param {String} cssClass is the name of the class to add
 */
function addClassName(obj, cssClass){
  if (!hasClassName(obj, cssClass)) {
    obj.className += ' ' + cssClass;
  }
}
/***/
function pageHandler(){
  splitSearchString();
  if (query.content) {
    if (query.content.indexOf("://") != -1) {
      var domainIsAllowed = false;
      for (i = 0; i < allowedDomain.length; i++) {
        if (query.content.indexOf(allowedDomain[i]) != -1) {
          domainIsAllowed = true;
          break;
        }
      }
      if (domainIsAllowed) {
        initContentURL = query.content;
        indexParameters = "";
        for (var x in query) {
          if (x == "content")
            continue;
          if (indexParameters == "") {
            indexParameters += "?";
          } else {
            indexParameters += "&";
          }
          indexParameters += x + "=" + query[x];
        }
      }
    } else {
      initContentURL = query.content;
      indexParameters = "";
      for (x in query) {
        if (x == "content")
          continue;
        if (indexParameters == "") {
          indexParameters += "?";
        } else {
          indexParameters += "&";
        }
        indexParameters += x + "=" + query[x];
      }
    }
  }
}
/* removed: function setFrameVariables()*/
/* removed: function getFrameset(version)*/
/***/
function preload(){
  if (typeof slideImagesCollection != 'undefined') {
    slideAmount = slideImagesCollection.length;
  }
  for (i = 0; i < slideAmount; i++) {
    slideImages[i] = new Image();
    slideImages[i].src = slideImagesCollection[i];
  }
  loaded = 2;
  imgCountTotal = document.images.length;
  for (i = 0; i < imgCountTotal; i++) {
    if (typeof document.getElementsByTagName('img')[i].getAttribute('preload') == 'string') {
      lowImageSrc = document.getElementsByTagName('img')[i].src;
      if (document.getElementsByTagName('img')[i].getAttribute('preload').indexOf('/') != -1) {
        highImageSrc = document.getElementsByTagName('img')[i].getAttribute('preload');
      } else {
        var highImageUrl = lowImageSrc.split('/');
        var fileLevel = highImageUrl.length;
        var highImagePath = '';
        for (e = 0; e < fileLevel - 1; e++) {
          highImagePath += highImageUrl[e] + '/';
        }
        highImageSrc = highImagePath + document.getElementsByTagName('img')[i].getAttribute('preload');
      }
      highImages[document.images[i].id] = new Image();
      highImages[document.images[i].id].src = highImageSrc;
      lowImages[document.images[i].id] = new Image();
      lowImages[document.images[i].id].src = lowImageSrc;
    }
    if (i < imgCountTotal - 1) {
      loaded = 3;
    }
    if (i == imgCountTotal - 1) {
      loaded = 1;
    }
  }
}
/** Method for image rollover effects
 * @param {String} imgId is the ID of the image to switch
 * @param {Number} state defines the state of the image to show
 * @param {String} act
 * @param {Boolean} permanent is true if the image will be switched permanently
 * @param {Boolean} dropPerm is true if true the current permanent status of the image will be removed
 */
function switchImage(imgId, state, act, permanent, dropPerm){
  currentImg = imgId;
  currentState = state;
  currentAct = act;
  currentPerm = permanent;
  if (typeof dropPerm == 'string' && dropPerm != 'all') {
    document.getElementsByTagName('img')[dropPerm].src = lowImages[dropPerm].src;
    delete permanentActive[dropPerm];
    if (dropPerm == tempAct) {
      tempAct = '';
    }
  } else if (dropPerm == 'all') {
    dropPermanentAll();
  }
  if (loaded == 1) {
    clearTimeout(checkLoad);
    if (tempAct != '' && imgId != tempAct && act == 1 && !permanentActive[tempAct]) {
      document.getElementsByTagName('img')[tempAct].src = lowImages[tempAct].src;
    }
    if ((tempAct == '' || imgId != tempAct) && !permanentActive[imgId]) {
      if (state == 1) {
        document.getElementsByTagName('img')[imgId].src = highImages[imgId].src;
      } else {
        document.getElementsByTagName('img')[imgId].src = lowImages[imgId].src;
      }
    }
    if (act == 1) {
      tempAct = imgId;
    }
    if (permanent == 1) {
      permanentActive[imgId] = imgId;
    }
  } else if (loaded == 2) {
    checkLoad = setTimeout('switchImage(currentImg,currentState,currentAct,currentPerm)', 50);
  } else if (loaded == 3) {
    preload();
    checkLoad = setTimeout('switchImage(currentImg,currentState,currentAct,currentPerm)', 50);
  }
}
/** Removes all images from the permanentActive Array who are blocked for changes via the switchImage function */
function dropPermanentAll(){
  for (var dropImg in permanentActive) {
    document.getElementsByTagName('img')[dropImg].src = lowImages[dropImg].src;
    delete permanentActive[dropImg];
  }
  if (tempAct != '') {
    document.getElementsByTagName('img')[tempAct].src = lowImages[tempAct].src;
    tempAct = '';
  }
}
/**
 * @param {String} direction
 * @param {Number} delay
 */
function setSlideshow(direction, delay){
  currenDirection = direction;
  currentDelay = delay;
  if (direction == "forward") {
    slideCount++;
    if (slideCount > slideAmount - 1) {
      slideCount = 0;
    }
  } else if (direction == "backward") {
    slideCount--;
    if (slideCount < 0) {
      slideCount = slideAmount - 1;
    }
  } else {
    slideCount = 0;
  }
  if (delay) {
    looping = setTimeout("setSlideshow(currenDirection,currentDelay)", currentDelay);
  } else {
    clearTimeout(looping);
    looping = -1;
  }
  document.getElementById('slideshow').src = slideImages[slideCount].src;
}
/** reverses the direction of the slideshow and stops the timeout if looping of the images has finished
 * @param {String} direction
 * @param {Number} delay
 */
function toggleSlideshow(direction, delay){
  if (!direction) {
    direction = currenDirection;
  }
  if (!delay) {
    delay = currentDelay;
  }
  if (looping > -1) {
    clearTimeout(looping);
    looping = -1;
  } else {
    setSlideshow(direction, delay);
  }
}
/** sets the className of the given element
 * @param {String} elementId
 * @param {String} newClassName
 */
function setClassName(elementId, newClassName){
  if (typeof elementId != 'object') {
    elementId = document.getElementById(elementId);
  }
  if (elementId) {
    elementId.className = newClassName;
  }
}
/** sets the colour of the given element
 * @param {String} elementId
 * @param {String} newColor
 */
function setColor(elementId, newColor){
  if (typeof elementId != 'object') {
    elementId = document.getElementById(elementId);
  }
  if (elementId) {
    elementId.style.color = newColor;
  }
}
/** returns the absolute left position of the given element
 * @param {String} elementId
 * @return {Number} currentLeft
 */
function getAbsoluteLeft(elementId){
  if (typeof elementId != 'object') {
    elementId = document.getElementById(elementId);
  }
  var currentLeft = 0;
  if (elementId) {
    while (elementId.offsetParent !== null) {
      currentLeft += elementId.offsetLeft;
      elementId = elementId.offsetParent;
    }
    currentLeft += elementId.offsetLeft;
  }
  return currentLeft;
}
/** returns the absolute top position of the given element
 * @param {String} elementId
 * @return {Number} currentTop
 */
function getAbsoluteTop(elementId){
  if (typeof elementId != 'object') {
    elementId = document.getElementById(elementId);
  }
  var currentTop = 0;
  if (elementId) {
    while (elementId.offsetParent !== null) {
      currentTop += elementId.offsetTop;
      elementId = elementId.offsetParent;
    }
    currentTop += elementId.offsetTop;
  }
  return currentTop;
}
/** This method stores a list of predefined attributes of the given element in an Array and returns the value of the attribute given by attributeName
 * @param {String} elementId is the ID or object reference of the element
 * @param {String} attributeName defines the attribute name to be returned
 * @return {Array} divInformation contains the values of the requested element
 */
function getDivInformation(elementId, attributeName){
  divInformation = [];
  if (typeof elementId != 'object') {
    elementId = document.getElementById(elementId);
  }
  if (elementId) {
    divInformation['offsetLeft'] = elementId.offsetLeft;
    divInformation['offsetTop'] = elementId.offsetTop;
    divInformation['styleLeft'] = parseInt(elementId.style.left);
    divInformation['styleTop'] = parseInt(elementId.style.top);
    divInformation['width'] = elementId.offsetWidth;
    divInformation['height'] = elementId.offsetHeight;
    divInformation['visibility'] = elementId.style.visibility;
    divInformation['display'] = elementId.style.display;
    divInformation['zIndex'] = elementId.style.zIndex;
    return divInformation[attributeName];
  }
}
/** writes the value of the attribute content into the given element using the innerHTML method
 * @param {String} elementId is an ID or object reference of the element
 * @param {String} content contains the String to be writen into the element defined by elementId
 */
function writeIntoLayer(elementId, content){
  if (typeof elementId != 'object') {
    elementId = document.getElementById(elementId);
  }
  if (elementId) {
    elementId.innerHTML = content;
  }
}
/** alters the position of an object to the given position in a step by step animation
 * @param {String} elementId is an ID or object reference of the element
 * @param {Number} newLeft is the new value for attribute left
 * @param {Number} newTop is the new value for attribute top
 * @param {Number} speed defines the velocity of the animation
 * @param {String} backLink
 */
lastPositions = [];
currentPositions = [];
currentPositions['navigation'] = [,];
function moveObject(elementId, newLeft, newTop, speed, backLink){
  if (typeof elementId != 'object') {
    elementId = document.getElementById(elementId);
  }
  if (elementId) {
    if (newLeft) {
      divLeft = newLeft;
    } else if ((typeof newLeft == 'undefined' || typeof newLeft == 'string') && (typeof backLink == 'undefined' || backLink == 0)) {
      divLeft = getDivInformation(elementId, 'offsetLeft');
    }
    if (newTop) {
      divTop = newTop;
    } else if ((typeof newTop == 'undefined' || typeof newTop == 'string') && (typeof backLink == 'undefined' || backLink == 0)) {
      divTop = getDivInformation(elementId, 'offsetTop');
    }
    if (!lastPositions[elementId.id]) {
      lastPositions[elementId.id] = [, ];
    }
    if (typeof backLink != 'undefined' && backLink == 1 && newLeft == lastPositions[elementId.id][0] && newTop == lastPositions[elementId.id][1]) {
      currentBack = backLink;
      divLeft = currentPositions[elementId.id][0];
      divTop = currentPositions[elementId.id][1];
    }
    if (!divIsMoving) {
      currentPositions[elementId.id] = [getDivInformation(elementId, 'offsetLeft'), getDivInformation(elementId, 'offsetTop')];
    }
    if (speed) {
      var horizontalRange = currentPositions[elementId.id][0] - divLeft;
      var verticalRange = currentPositions[elementId.id][1] - divTop;
      currentObjId = elementId;
      currentSpeed = speed;
      currentStep++;
      if (newLeft != '' || newLeft == 0) {
        if (horizontalRange > 0) {
          elementId.style.left = (currentPositions[elementId.id][0] - Math.round(currentStep * speed)) + 'px';
          if (divLeft - getDivInformation(elementId, 'offsetLeft') > 5) {
            elementId.style.left = divLeft + 'px';
          }
        } else if (horizontalRange < 0) {
          elementId.style.left = (currentPositions[elementId.id][0] + Math.round(currentStep * speed)) + 'px';
          if (divLeft - getDivInformation(elementId, 'offsetLeft') < 5) {
            elementId.style.left = divLeft + 'px';
          }
        }
      }
      if (newTop != '' || newTop == 0) {
        if (verticalRange > 0) {
          elementId.style.top = (currentPositions[elementId.id][1] - Math.round(currentStep * speed)) + 'px';
          if (divTop - getDivInformation(elementId, 'offsetTop') > 5) {
            elementId.style.top = divTop + 'px';
          }
        } else if (verticalRange < 0) {
          elementId.style.top = (currentPositions[elementId.id][1] + Math.round(currentStep * speed)) + 'px';
          if (divTop - getDivInformation(elementId, 'offsetTop') < 5) {
            elementId.style.top = divTop + 'px';
          }
        }
      }
      if (getDivInformation(elementId, 'offsetLeft') == newLeft && getDivInformation(elementId, 'offsetTop') == newTop) {
        divIsMoving = false;
        currentStep = 0;
        currentBack = 0;
        divLeft = 0;
        divTop = 0;
        lastPositions[elementId.id] = [newLeft, newTop];
        clearTimeout(setDivPosition);
      } else {
        divIsMoving = true;
        setDivPosition = setTimeout('moveObject(currentObjId,divLeft,divTop,currentSpeed)', 10);
      }
    } else {
      if (divLeft != '' || divLeft == 0) {
        elementId.style.left = divLeft + 'px';
      }
      if (divTop != '' || divTop == 0) {
        elementId.style.top = divTop + 'px';
      }
      currentBack = 0;
      divLeft = 0;
      divTop = 0;
      lastPositions[elementId.id] = [newLeft, newTop];
    }
  }
}
/** stores the current mouse position in the mouseX and mouseY variables
 * @param {String} currentEvent
 */
function mousePosition(currentEvent){
  if (window.event) {
    currentEvent = window.event;
  }
  mouseX = currentEvent.clientX;
  mouseY = currentEvent.clientY;
}
/** This method sores a list of predefined attributes of the current window in an Array and returns the value of the attribute given by attributeName
 * @param {String} attributeName defines the attribute name to be returned
 * @return {String} windowInformation is the value of the requested attribute
 */
function getWindowInformation(attributeName){
  var windowInformation = [];
  windowInformation['winWidth'] = document.body.clientWidth;
  if (document.body.clientHeight == 0) {
    windowInformation['winHeight'] = window.innerHeight;
  } else {
    windowInformation['winHeight'] = document.body.clientHeight;
  }
  windowInformation['docWidth'] = document.body.scrollWidth;
  windowInformation['docHeight'] = document.body.scrollHeight;
  windowInformation['scrollLeft'] = document.body.scrollLeft;
  windowInformation['scrollTop'] = document.body.scrollTop;
  return windowInformation[attributeName];
}
/**
 * @param {DOMElement} nodeObject
 * @param {String} propertyName
 * @return {String} propertyValue
 */
function getCurrentStyle(nodeObject, propertyName){
  var propertyValue;
  if (document.documentElement && document.defaultView) {
    propertyValue = document.defaultView.getComputedStyle(nodeObject, "").getPropertyValue(propertyName);
  } else if (document.documentElement && document.documentElement.currentStyle) {
    var regX = /([ a-z ]*)\-([ a-z ])([ a-z ]*)/;
    while (regX.test(propertyName)) {
      regX.exec(propertyName);
      propertyName = RegExp.$1 + RegExp.$2.toUpperCase() + RegExp.$3;
    }
    propertyValue = nodeObject.currentStyle[propertyName];
  }
  return propertyValue;
}
/**
 * @param {String} elementId is the ID or object reference of the element
 * @param {String} visibilityValue defines the new value of the attribute visibility
 * @param {String} displayValue defines the new value of the attribute display
 * @param {Boolean} initialSet
 */
var currentState, currentDisplayState;
function setVisibility(elementId, visibilityValue, displayValue, initialSet){
  if (typeof elementId != 'object') {
    elementId = document.getElementById(elementId);
  }
  if (elementId) {
    if (typeof visibilityValue == 'undefined' && typeof displayValue == 'undefined') {
      currentState = getDivInformation(elementId, 'visibility');
      currentDisplayState = getDivInformation(elementId, 'display');
      if (currentState == '') {
        if (initialSet) {
          currentState = 'visible';
        } else {
          currentState = 'hidden';
        }
      }
      if (currentDisplayState == '') {
        if (initialSet) {
          currentDisplayState = initialSet;
        } else {
          currentDisplayState = 'none';
        }
      }
      if (currentState == 'hidden') {
        elementId.style.visibility = 'visible';
      } else if (currentState == 'visible') {
        elementId.style.visibility = 'hidden';
      }
      if (currentDisplayState == 'none') {
        elementId.style.display = 'block';
        elementId.style.visibility = 'visible';
      } else if (currentDisplayState == 'block' || currentDisplayState == 'inline') {
        elementId.style.display = 'none';
      }
    } else if (visibilityValue == 1) {
      elementId.style.visibility = 'visible';
    } else if (visibilityValue == 0) {
      elementId.style.visibility = 'hidden';
    }
    if (displayValue) {
      elementId.style.display = displayValue;
    }
  }
}
/**
 * @param {String} elementId is the ID or object reference of the element
 * @param {Number} newZIndex defines the new value of the attribute zIndex
 */
function setZIndex(elementId, newZIndex){
  if (typeof elementId != 'object') {
    elementId = document.getElementById(elementId);
  }
  if (elementId) {
    elementId.style.zIndex = newZIndex;
  }
}
/**
 * @param {String} elementId is the ID or object reference of the element
 * @param {Number} newWidth defines the new value of the attribute width
 * @param {Number} newHeight defines the new value of the attribute height
 */
function resizeLayer(elementId, newWidth, newHeight){
  if (typeof elementId != 'object') {
    elementId = document.getElementById(elementId);
  }
  if (elementId) {
    currentDiv = elementId;
    lastWidth = getDivInformation(elementId, 'width');
    lastHeight = getDivInformation(elementId, 'height');
    if (newWidth) {
      if (typeof newWidth == 'string') {
        elementId.style.width = newWidth;
      } else {
        elementId.style.width = newWidth + 'px';
      }
    }
    if (newHeight) {
      if (typeof newHeight == 'string') {
        elementId.style.height = newHeight;
      } else {
        elementId.style.height = newHeight + 'px';
      }
    }
  }
}
/**
 * @param {String} elementId is the ID or object reference of the element
 * @param {Number} newTop defines the new value of the attribute top
 * @param {Number} newRight defines the new value of the attribute right
 * @param {Number} newBottom defines the new value of the attribute bottom
 * @param {Number} newLeft defines the new value of the attribute left
 */
function clipLayer(elementId, newTop, newRight, newBottom, newLeft){
  if (typeof elementId != 'object') {
    elementId = document.getElementById(elementId);
  }
  if (elementId) {
    currentDiv = elementId;
    lastWidth = getDivInformation(elementId, 'width');
    lastHeight = getDivInformation(elementId, 'height');
    elementId.style.clip = "rect(" + newTop + "px " + newRight + "px " + newBottom + "px " + newLeft + "px)";
  }
}
/** returns the clipping area of a given element
 * @param {Number} elementId is the ID or object reference of the element
 * @return {Array} an Array of clipping values
 */
function getClipping(elementId){
  if (typeof elementId != 'object') {
    elementId = document.getElementById(elementId);
  }
  if (elementId) {
    return elementId.style.clip;
  }
}
/***/
function restoreLayer(){
  if (typeof currentDiv == 'object') {
    if (typeof currentDiv.style.width != 'undefined') {
      currentDiv.style.width = lastWidth + 'px';
    }
    if (typeof currentDiv.style.height != 'undefined') {
      currentDiv.style.height = lastHeight + 'px';
    }
    if (typeof currentDiv.style.clip != 'undefined') {
      currentDiv.style.clip = "rect(" + 0 + "px " + lastWidth + "px " + lastHeight + "px " + 0 + "px)";
    }
  }
}
/** opens a popup window in the middle of the screen
 * @param {String} popupUrl is the Url of the site to be opened in a popup
 * @param {String} popupName is the Name of the popup to be opened
 * @param {Number} popupWidth is the Width of the popup to be opened
 * @param {Number} popupHeight is the Height of the popup to be opened
 * @param {Boolean} reopen defines if the site should be reloaded if allready opend in a popup
 * @param {Boolean} showScrollbar defines if the popup should be opend with scrollbars
 * @param {Number} popupLeftPos defines the left position of the popup
 * @param {Number} popupTopPos defines the top position of the popup
 */
function centerPopup(popupUrl, popupName, popupWidth, popupHeight, reopen, showScrollbar, popupLeftPos, popupTopPos){
  if (!popupLeftPos) {
    popupLeftPos = 5;
  }
  if (!popupTopPos) {
    popupTopPos = 15;
  }
  if (!showScrollbar) {
    showScrollbar = 0;
  }
  var popup_left = (window.screen.width / 2) - (popupWidth / 2 + popupLeftPos);
  var popup_top = (window.screen.height / 2) - (popupHeight / 2 + popupTopPos);
  if ((typeof popupWindow != 'object') || (typeof popupWindow == 'object' && popupWindow.closed)) {
    if (document.all) {
      var xyPos = 'left=' + popup_left + ',top=' + popup_top;
    } else {
      var xyPos = 'screenX=' + popup_left + ',screenY=' + popup_top;
    }
    popupWindow = window.open(popupUrl, popupName, "toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=" + showScrollbar + ",resizable=no,width=" + popupWidth + ",height=" + popupHeight + ",copyhistory=no," + xyPos + "");
    popupWindow.opener = self;
    popupWindow.focus();
    winUrl = popupUrl;
    windowWidth = popupWidth;
    windowHeight = popupHeight;
  } else {
    if ((winUrl != popupUrl) || reopen) {
      popupWindow.location.href = popupUrl;
    }
    if ((windowWidth + windowHeight > 0) && (popupWidth != windowWidth || popupHeight != windowHeight || popupLeftPos != diffWidth || popupTopPos != diffHeight)) {
      var newWidth = popupWidth - windowWidth;
      var newHeight = popupHeight - windowHeight;
      popupWindow.resizeBy(newWidth, newHeight);
      popupWindow.moveTo(popup_left, popup_top);
    }
    popupWindow.focus();
    winUrl = popupUrl;
    windowWidth = popupWidth;
    windowHeight = popupHeight;
  }
  diffWidth = popupLeftPos;
  diffHeight = popupTopPos;
}
/**
 * @param {String} popupUrl
 * @param {String} popupString
 */
function openPopupLink(popupUrl, popupString){
  var params = popupString.split(",");
  if (params.length == 3) {
    centerPopup(popupUrl, params[0], params[1], params[2], false, false);
  } else {
    centerPopup(popupUrl, "searchwin", 800, 600, false, false);
  }
}
/**
 * @param {String} popupUrl
 * @param {String} popupName
 * @param {String} popupParams
 */
function openPopupParams(popupUrl, popupName, popupParams){
  if ((typeof popupWindow != 'object') || (typeof popupWindow == 'object' && popupWindow.closed)) {
    if (popupParams) {
      popupWindow = window.open(popupUrl, popupName, popupParams);
    } else {
      popupWindow = window.open(popupUrl, popupName);
    }
    popupWindow.opener = self;
    popupWindow.focus();
    winUrl = popupUrl;
  } else {
    if (winUrl != popupUrl) {
      popupWindow.location.href = popupUrl;
    }
    popupWindow.focus();
    winUrl = popupUrl;
  }
}
/***/
function splitSearchString(){
  if (self.location.search.indexOf("=") == -1)
    return;
  parameterArray = self.location.search.substring(1).split("&");
  for (var i = 0; i < parameterArray.length; i++) {
    pair = parameterArray[i].split("=");
    query[unescape(pair[0])] = (pair[1] ? unescape(pair[1]) : "");
  }
}
/** walkaround: import of the function getCookieVal() from bmw.de
 * @param {Number} offset
 * @return {String}
 */
function getCookieValue(name){
  var arg = name + "=";
  var alen = arg.length;
  var i = 0;
  while (i < document.cookie.length) {
    var j = i + alen;
    if (document.cookie.substring(i, j) == arg) {
      var endstr = document.cookie.indexOf(";", j);
      if (endstr == -1) {
        endstr = document.cookie.length;
      }
      return unescape(document.cookie.substring(j, endstr));
    }
    i = document.cookie.indexOf(" ", i) + 1;
    if (i == 0) {
      break;
    }
  }
  return false;
}
/**
 * @return {Boolean}
 */
function isCookiesEnabled(){
  document.cookie = "bmwCookieEnabled=true";
  if (document.cookie.indexOf("bmwCookieEnabled=true") != -1) {
    var expire = new Date();
    document.cookie = "bmwCookieEnabled=;expires=" + expire.toGMTString();
    return true;
  } else {
    return false;
  }
}
/** Dummy onload function that will be called in every page per default. Overwrite this if needed with an own version */
function onLoadFunctions(){
}
/** Dummy onunload function that will be called in every page per default. Overwrite this if needed with an own version */
function onUnloadFunctions(){
}
/***/


/*** DIVs that has to be resized if screen resolution <= 1024 */
var resizeDivs = new Array("mainNavigationContainer","mainContainer", "mainImages", "mainImage");

/*** Function to resize common DIVs if screen resolution <= 1024 */
function checkWindowSize(){
  resizeDivs = resizeDivs.concat(scrollerCheckElements);
  resizeDivs = resizeDivs.unique();
  var i;
  var newSize;
  if (getWindowInformation('winWidth') < scrollerSize) {
    for (i = 0; i < resizeDivs.length; i++) {
      if (document.getElementById(resizeDivs[i])) {
        newSize = 1000 - document.getElementById(resizeDivs[i]).offsetLeft;
        resizeLayer(resizeDivs[i], newSize + "px");
        if(resizeDivs[i] != "mainNavigationContainer" && resizeDivs[i] != "completePageContent") {
          document.getElementById(resizeDivs[i]).style.overflow = "hidden";
        }
      }
    }
  } else {
    if (document.getElementById('mainNavi')) {
      resizeLayer('mainNavi', '100%');
    }
    for (i = 0; i < resizeDivs.length; i++) {
      if (document.getElementById(resizeDivs[i])) {
        if(!document.getElementById(resizeDivs[i]).offsetLeft) {
          resizeLayer(resizeDivs[i], '100%');
        }
      }
    }
  }
}

/***/
function changeToHiEndVersion(){
  var xmlMetaNew;
  if (document.getElementsByTagName('meta')['target-url-swf']) {
    xmlMeta = document.getElementsByTagName('meta')['target-url-swf'].content;
    if (xmlMeta.indexOf('../') != -1) {
      pos1 = xmlMeta.lastIndexOf('../') + 2;
      pos2 = xmlMeta.lastIndexOf('.')
      xmlMetaNew = buildValidServerRelativeUrl(xmlMeta.slice(pos1, pos2));
    }
  }
  xmlMetaNew = (xmlMetaNew.indexOf('/bmw_edit/') != -1) ? xmlMetaNew.replace("/bmw_edit/", "/") : xmlMetaNew;
  xmlMetaNew = (xmlMetaNew.indexOf('/bmw_qa/') != -1) ? xmlMetaNew.replace("/bmw_qa/", "/") : xmlMetaNew;
  xmlMetaNew = (xmlMetaNew.indexOf('/bmw_prod/') != -1) ? xmlMetaNew.replace("/bmw_prod/", "/") : xmlMetaNew;
  xmlMeta = "../.." + xmlMetaNew + ".xml";


  if (typeof confCountryTopic != 'undefined' && confCountryTopic != null && typeof confLanguageTopic != 'undefined' && confLanguageTopic != null) {
    var basePath = self.location.href.substring(0, self.location.href.indexOf("/" + confCountryTopic + "/" + confLanguageTopic + "/"));
    var countryLanguagePath = basePath + "/" + confCountryTopic + "/" + confLanguageTopic + "/";
    var highendUrl = countryLanguagePath + framesetPageHighend + '?prm_content=' + xmlMeta;
    parent.location.href = highendUrl;

    //later (highendUrl not needed anymore as soon as flash is seo-compatible):
    // parent.location.href = xmlMeta;
  }
}
/**
 * @param {String} alertText
 */
function myAlert(alertText){
  if (top.location.search.indexOf("debug") != -1) {
    alert(alertText);
  }
}
/***/
function closeChooseBandLayer(){
  oldDiv = document.getElementById('changeToHighend');
  document.getElementsByTagName("body")[0].removeChild(oldDiv);
  document.getElementById('changeVersionLink').className = "menu";
  if ((parent.useCurtain) && (parent.useCurtain == "true")) {
    setVisibility(document.getElementById('iFrameContainer'), 1);
    if (typeof leftPos != 'undefined') {
      moveObject(document.getElementById('iFrameContainer'), leftPos);
    } else {
      moveObject(document.getElementById('iFrameContainer'), 0);
    }
    setVisibility(document.getElementById('curtain'), null, 'none');
  }
}
/** Returns a list of all links on the current site
 * @return {Array} an Array containing all link hrefs of the current site
 */
function buildLinkList(){
  var links = new Array(document.getElementsByTagName('a').length);
  for (var i = 0; i < document.getElementsByTagName('a').length; i++) {
    links[i] = document.getElementsByTagName('a')[i].href;
  }
  return links;
}
/**
 * @param {String} contentUrl
 * @param {Array} linkList
 * @return {Array} evaluatedLinks
 */
function evaluateHighlighting(contentUrl, linkList){
  var navLinkFull = "";
  var navLinkPath = "";
  var navLinkFile = "";
  var navLinkQuery = "";
  var navLinkPathParts = [];
  var contentLinkFull = "";
  var contentLinkPath = "";
  var contentLinkFile = "";
  var contentLinkQuery = "";
  var contentLinkPathParts = [];
  var evaluatedLinks = [];
  if (contentUrl.indexOf('?') != -1) {
    contentLinkFull = contentUrl.substring(0, contentUrl.lastIndexOf('?'));
    contentLinkQuery = contentUrl.substring(contentUrl.lastIndexOf('?'), contentUrl.length);
    if (contentLinkQuery.indexOf("&") != -1) {
      contentLinkQuery = contentLinkQuery.substring(0, contentLinkQuery.indexOf("&"));
    }
  } else {
    contentLinkFull = contentUrl;
  }
  if (contentLinkFull.charAt(contentLinkFull.length - 1) == '/') {
    contentLinkFull = contentLinkFull.substring(0, contentLinkFull.length - 1);
  }
  if (contentLinkFull.lastIndexOf('/') < contentLinkFull.lastIndexOf('.')) {
    contentLinkFile = contentLinkFull.substring(contentLinkFull.lastIndexOf('/') + 1, contentLinkFull.length);
    contentLinkPath = contentLinkFull.substring(0, contentLinkFull.lastIndexOf('/'));
  } else {
    contentLinkPath = contentLinkFull;
    contentLinkFile = "";
  }
  contentLinkPathParts = contentLinkPath.split('/');
  for (var i = 0; i < linkList.length; i++) {
    navLinkFull = linkList[i];
    if (navLinkFull.indexOf('javascript:') != -1 || navLinkFull == '') {
      evaluatedLinks.push(999);
      continue;
    }
    if (navLinkFull.indexOf('?') != -1) {
      navLinkQuery = navLinkFull.substring(navLinkFull.lastIndexOf('?'), navLinkFull.length);
      if (navLinkQuery.indexOf("&") != -1) {
        navLinkQuery = navLinkQuery.substring(0, navLinkQuery.indexOf("&"));
      }
      navLinkFull = navLinkFull.substring(0, navLinkFull.lastIndexOf('?'));
    } else {
      navLinkQuery = "";
    }
    if (navLinkFull.charAt(navLinkFull.length - 1) == '/') {
      navLinkFull = navLinkFull.substring(0, navLinkFull.length - 1);
    }
    if (navLinkFull.lastIndexOf('/') < navLinkFull.lastIndexOf('.')) {
      navLinkFile = navLinkFull.substring(navLinkFull.lastIndexOf('/') + 1, navLinkFull.length);
      navLinkPath = navLinkFull.substring(0, navLinkFull.lastIndexOf('/'));
    } else {
      navLinkPath = navLinkFull;
      navLinkFile = "";
    }
    navLinkPathParts = navLinkPath.split('/');

    var contentIndex = 0;
    var navIndex = 0;
    var bestmatchFound = false;
    var charMatch = null;

    while (navLinkPathParts[navIndex] == contentLinkPathParts[contentIndex]) {
      navIndex++;
      contentIndex++;
      if (contentIndex == contentLinkPathParts.length && navIndex == navLinkPathParts.length) {
        if (navLinkFile == contentLinkFile) {
          if (navLinkQuery == contentLinkQuery) {
            evaluatedLinks.push(-2);
            bestmatchFound = true;
          } else {
            evaluatedLinks.push(-1);
          }
        } else {
          charMatch = stringCompare(navLinkFile, contentLinkFile);
          evaluatedLinks.push(0.99 - (charMatch / 100));
        }
        break;

      } else if (contentIndex == contentLinkPathParts.length) {
        evaluatedLinks.push(999);
        break;

      } else if (navIndex == navLinkPathParts.length) {
        if (confCountryTopic != null &&
        confLanguageTopic != null &&
        navLinkPathParts.length >= 2 &&
        navLinkPathParts[navLinkPathParts.length - 1] == confLanguageTopic &&
        navLinkPathParts[navLinkPathParts.length - 2] == confCountryTopic) {
          evaluatedLinks.push(999);
        } else if (confCountryTopic != null && navLinkPath.indexOf("/" + confCountryTopic + "/") == -1) {
          evaluatedLinks.push(999);
        } else {
          evaluatedLinks.push(contentLinkPathParts.length - contentIndex);
        }
        break;

      } else if (navLinkPathParts[navIndex] != contentLinkPathParts[contentIndex]) {
        evaluatedLinks.push(999);
        break;
      }
    }
    if (bestmatchFound) {
      break;
    }
  }
  return evaluatedLinks;
}
/** compares to string with each other and returns the number of matching letters
 * @param {String} comparator1 is the first Sting to be compared
 * @param {String} comparator2 is the second Sting to be compared
 * @return {Number} Number of matching letters
 */
function stringCompare(comparator1, comparator2){
  var shorter = null;
  var longer = null;
  if (comparator1.length > comparator2.length) {
    longer = comparator1.toLowerCase();
    shorter = comparator2.toLowerCase();
  } else {
    longer = comparator2.toLowerCase();
    shorter = comparator1.toLowerCase();
  }
  var matchCount = 0;
  for (var x = 0; x < shorter.length; x++) {
    if (shorter.charAt(x) == longer.charAt(x)) {
      matchCount++;
    } else {
      break;
    }
  }
  return matchCount;
}
/**
 * @param {String} simpleServerRelativeUrl
 * @return {String}
 */
function buildValidServerRelativeUrl(simpleServerRelativeUrl){
  if (simpleServerRelativeUrl == '') {
    return '';
  }
  if (simpleServerRelativeUrl.charAt(0) != '/') {
    return simpleServerRelativeUrl;
  }
  var validServerRelativeUrl = '';
  var simpleSeverrelativeUrlNoParams = '';

  if (simpleServerRelativeUrl.indexOf('?') != -1) {
    simpleSeverrelativeUrlNoParams = simpleServerRelativeUrl.substring(0, simpleServerRelativeUrl.indexOf('?'));
  } else {
    simpleSeverrelativeUrlNoParams = simpleServerRelativeUrl;
  }
  if (self.location.href.indexOf('/bmw_edit/') != -1 && simpleSeverrelativeUrlNoParams.indexOf('/bmw_edit/') == -1) {
    validServerRelativeUrl = '/bmw_edit' + simpleServerRelativeUrl;
  } else if (self.location.href.indexOf('/bmw_qa/') != -1 && simpleSeverrelativeUrlNoParams.indexOf('/bmw_qa/') == -1) {
    validServerRelativeUrl = '/bmw_qa' + simpleServerRelativeUrl;
  } else if (self.location.href.indexOf('/bmw_prod/') != -1 && simpleSeverrelativeUrlNoParams.indexOf('/bmw_prod/') == -1) {
    validServerRelativeUrl = '/bmw_prod' + simpleServerRelativeUrl;
  } else {
    validServerRelativeUrl = simpleServerRelativeUrl;
  }
  return validServerRelativeUrl;
}

/**
 * @param {String} basePath
 * @param {String} relativePath
 * @return {String}
 */
function getFullPath(basePath, relativePath){
  var fullPath = basePath.substring(0, (basePath.lastIndexOf("/") + 1));
  var regXHostPath = /((^(https{0,1}\:\/\/[ ^\/ ]*\/))|(^(file\:\/\/[ ^\: ]*\:\/))|(^([ a-z ]+\:\\))|(^([ a-z ]+\:\/))|(^(\\\\))|(^(\/\/)))/i;
  if (regXHostPath.test(relativePath)) {
    fullPath = relativePath;
  } else {
    var regXGoingUp = /(\.\.\/)/g, goingUpArr = [], i;
    if (regXGoingUp.test(relativePath)) {
      goingUpArr = relativePath.match(regXGoingUp);
    }
    for (var i = 0; i < goingUpArr.length; ++i) {
      fullPath = fullPath.substring(0, (fullPath.lastIndexOf("/", (fullPath.length - 2)) + 1));
    }
    fullPath += relativePath.replace(regXGoingUp, "");
  }
  return fullPath;
}
/***/
function getServerRelativeContentUrl(){
  var contentPage = self.location.href;
  var substract = self.location.host;
  return contentPage.substring(contentPage.indexOf(substract) + substract.length, contentPage.length);
}
/**
 * @param {Boolean} hasLink
 */
function setModuleHeader(hasLink){
  var headerHTML = "";
  if (hasLink) {
    headerHTML = '<a href="javascript:moveMenu();" style="position:relative;display:block;margin-top:1px;">' + moduleHeader + '</a>';
  } else {
    headerHTML = '<span style="position:relative;display:block;margin-top:1px;">' + moduleHeader + '</span>';
  }
  if (typeof document.getElementsByTagName('div')['moduleHeaderContainerSeo'] == 'object') {
    writeIntoLayer('moduleHeaderContainerSeo', headerHTML);
    setVisibility('moduleHeaderContainerSeo', 1);
  } else {
    moveObject(document.getElementsByTagName('div')['naviClipAreaSeo'], null, 0);
  }
}
/** delegates the url of the downloadable file to an download script and sends a request to the current frame
 * @param {String} fileUrl is the URL of the downloadable file
 */
function download(fileUrl){
  if (confPersoEngineEnabled) {
    if (typeof parent.persoDownloadEventType != "undefined") {
      if (parent.persoDownloadEventType) {
        var persoDownloadEventType = parent.persoDownloadEventType;
        var persoSeries = parent.persoSeries;
        var persoBodytype = parent.persoBodytype;
        var persoModel = parent.persoModel;
        var persoColor = parent.persoColor;
        var persoRim = parent.persoRim;
        parent.createPersoEvent(persoDownloadEventType, persoSeries, persoBodytype, persoModel, persoColor, persoRim);
      }
    } else if (typeof self.persoDownloadEventType != "undefined") {
      if (self.persoDownloadEventType) {
        var persoDownloadEventType = self.persoDownloadEventType;
        var persoSeries = self.persoSeries;
        var persoBodytype = self.persoBodytype;
        var persoModel = self.persoModel;
        var persoColor = self.persoColor;
        var persoRim = self.persoRim;
        createPersoEvent(persoDownloadEventType, persoSeries, persoBodytype, persoModel, persoColor, persoRim);
      }
    }
  }
  var downloadUrl = buildValidServerRelativeUrl(fileUrl) + "?download=true";
  self.location.href = downloadUrl;
}
/**
 * @param {String} titleText
 */
function writeFramesetTitle(titleText){
}
/**
 * @param {String} ticketId
 */
function preloader(ticketId){
  preLoadCounter[ticketId] = 0;
  preload[ticketId] = [];
  for (var j = 0; j < preLoadArray[ticketId].length; j++) {
    preload[ticketId][j] = new Image();
    preload[ticketId][j].onabort = function(){
      loadUpdate(ticketId, j);
    }
    preload[ticketId][j].onerror = function(){
      loadUpdate(ticketId, j);
    }
    preload[ticketId][j].onload = function(){
      loadUpdate(ticketId, j);
    }
    preload[ticketId][j].src = preLoadArray[ticketId][j];
  }
}
/**
 * @param {String} ticketId
 * @param {String} imageId
 */
function loadUpdate(ticketId, imageId){
  preLoadCounter[ticketId]++;
  if (preLoadCounter[ticketId] == preLoadArray[ticketId].length) {
    preLoadReady(ticketId);
  }
}
/**
 * @param {String} ticketId
 */
function preLoadReady(ticketId){
}
/***/
function showCo2(){
  setVisibility('co2HeaderOn', 1);
  setVisibility('co2HeaderOff', 0);
  setVisibility('co2body', 1);
}
/***/
function hideCo2(){
  setVisibility('co2HeaderOn', 0);
  setVisibility('co2HeaderOff', 1);
  setVisibility('co2body', 0);
}
/***/
function stopPlayingMp3(){
}
/***/
function setElementClass(elementTagName, currentClass, newClass){
  for (var i = 0; i < document.getElementsByTagName(elementTagName).length; i++) {
    if (document.getElementsByTagName(elementTagName)[i].className == currentClass) {
      document.getElementsByTagName(elementTagName)[i].className = newClass;
    }
  }
}
/***/
function dialogClosed(){
}
/**
 * @param {String} name
 * @param {String} value
 * @param {String} expires
 * @param {String} path
 * @param {String} domain
 * @param {String} secure
 */
function setCookie(name, value, expires, path, domain, secure){
  document.cookie = name + "=" + escape(value) +
  ((expires) ? "; expires=" + expires : "") +
  ((path) ? "; path=" + path : "") +
  ((domain) ? "; domain=" + domain : "") +
  ((secure) ? "; secure" : "");
}
/***/
function setCookieFromLayer(){
  if (document.getElementsByName("connectionSave")[0].checked) {
    chosenConnection = "broadBand";
  } else if (document.getElementsByName("connectionSave")[1].checked) {
    chosenConnection = "narrowBand";
  } else {
    chosenConnection = "detect";
  }
  setCookie(cookieName, chosenConnection, "Sun, 31-Dec-2007 00:00:00 GMT", "/");
}
/**
 * @param {Number} offset
 */
function getCookieVal(offset){
  var endstr = document.cookie.indexOf(";", offset);
  if (endstr == -1)
    endstr = document.cookie.length;
  return unescape(document.cookie.substring(offset, endstr));
}
/**
 * @param {String} name
 */
function getCookie(name){
  var arg = name + "=";
  var alen = arg.length;
  var clen = document.cookie.length;
  var i = 0;
  while (i < clen) {
    var j = i + alen;
    if (document.cookie.substring(i, j) == arg)
      return getCookieVal(j);
    i = document.cookie.indexOf(" ", i) + 1;
    if (i == 0)
      break;
  }
  return null;
}
/**
 * @param {String} text
 * @param {String} userBandwidth
 * @param {String} formField
 */
//broadband new
function setBandwidthOption(text, userBandwidth, formField){
  setVisibility('selectBoxContent' + formField, 0, 'none');
  writeIntoLayer('selectedValue' + formField, "&nbsp; " + text);
  selectedBandwidth = userBandwidth;
}
/**
 * @param {String} URL1
 */
function getCorrectPath(URL1){
  targetUrl = "http://" + window.location.hostname + "" + buildValidServerRelativeUrl(URL1);
  self.location.href = buildValidServerRelativeUrl(targetUrl);
}
/***/
function changeLinksAccordingToStage(){
  var prefix = "";
  if (self.location.href.indexOf('/bmw_edit/') != -1) {
    prefix = "/bmw_edit";
  } else if (self.location.href.indexOf('/bmw_qa/') != -1) {
    prefix = "/bmw_qa";
  } else if (self.location.href.indexOf('/bmw_prod/') != -1) {
    prefix = "/bmw_prod";
  }
  if (prefix != "") {
    divsToBeAltered.push("naviClipAreaSeo");
    divsToBeAltered.push("metaNavigationText");
    divsToBeAltered.push("mainNavi");
    divsToBeAltered.push("mainNavigationContainer");
    divsToBeAltered.push("teaserContainer");
    divsToBeAltered.push("teaserContainer1");
    divsToBeAltered.push("teaserContainer2");
    divsToBeAltered.push("downloadMainTeaser");
    for (var x = 0; x < divsToBeAltered.length; x++) {
      if (document.getElementById(divsToBeAltered[x]) && document.getElementById(divsToBeAltered[x]) != null && document.getElementById(divsToBeAltered[x]).getElementsByTagName('a').length != 0) {
        if (divsToBeAltered[x] != "downloadMainTeaser") {
          for (var i = 0; i < document.getElementById(divsToBeAltered[x]).getElementsByTagName('a').length; i++) {
            evaluatedLink = document.getElementById(divsToBeAltered[x]).getElementsByTagName('a')[i].href;
            if (evaluatedLink.indexOf('javascript:') == -1 && evaluatedLink != '' && evaluatedLink.indexOf(prefix) == -1) {
              toBeReplaced = "http://" + window.location.hostname;
              document.getElementById(divsToBeAltered[x]).getElementsByTagName('a')[i].href = evaluatedLink.replace(toBeReplaced, prefix);
            }
          }
        }
        for (var i = 0; i < document.getElementById(divsToBeAltered[x]).getElementsByTagName('img').length; i++) {
          evaluatedLink = document.getElementById(divsToBeAltered[x]).getElementsByTagName('img')[i].src;
          toBeReplaced = "http://" + window.location.hostname;
          if (evaluatedLink.indexOf(prefix) == -1) {
            document.getElementById(divsToBeAltered[x]).getElementsByTagName('img')[i].src = evaluatedLink.replace(toBeReplaced, prefix);
          }
        }
      }
    }
  }
  changeLinksAccordingToStageDone = true;
}
/**
 * @param {String} objId
 * @param {String} content
 */
function writeIntoLayerBBDetection(objId, content){
  if (typeof objId != 'object') {
    objId = document.getElementById(objId);
  }
  if (objId) {
    objId.innerHTML = content;
  }
}
/**
 * @param {Number} mode
 */
function setCurtain(mode){
  if ((useCurtain) && (useCurtain == "true")) {
    if (mode == 1) {
      setVisibility(document.getElementById('iFrameContainer'), 0);
      moveObject(document.getElementById('iFrameContainer'), ((window.screen.width * 2) * (-1)));
      setVisibility(document.getElementById('curtain'), null, 'block');
    } else {
      setVisibility(document.getElementById('curtain'), null, 'none');
      if (typeof leftPos != 'undefined') {
        moveObject(document.getElementById('iFrameContainer'), leftPos);
      } else {
        moveObject(document.getElementById('iFrameContainer'), 0);
      }
      setVisibility(document.getElementById('iFrameContainer'), 1);
    }
  }
}
/**
 * @param {String} trackingPage
 * @param {String} trackingPageTitel
 * @param {String} targetPageUrl
 */
function trackTeaserClick(trackingPage, trackingPageTitel, targetPageUrl){
  if (confTrackingEnabled) {
    var trackingUrl = buildValidServerRelativeUrl(trackingPage) + '?target=' + escape(buildValidServerRelativeUrl(targetPageUrl)) + '&source=' + escape(self.location.pathname);
    trackAbsolute(trackingUrl, trackingPageTitel, false, false);
  }
  return true;
}
/**
 * @param {String} trackingPage
 * @param {String} trackingPageTitel
 * @param {String} targetFileUrl
 */
function trackDownloadClick(trackingPage, trackingPageTitel, targetFileUrl){
  if (confTrackingEnabled) {
    var trackingUrl = buildValidServerRelativeUrl(trackingPage) + '?file=' + escape(buildValidServerRelativeUrl(targetFileUrl)) + '&source=' + escape(self.location.pathname);
    trackAbsolute(trackingUrl, trackingPageTitel, false, false);
  }
  return true;
}
/**
 * @param {String} ConnectionInfo
 * @param {String} redirectHighbandUrl
 */
function redirectViaCookie(ConnectionInfo, redirectHighbandUrl){
  splitSearchString();
  if (query.prm_content) {
    prmContent = query.prm_content;
  }
  if ((getCookie(cookieName) && ConnectionInfo == "broadBand") || (ConnectionInfo == "broadBand")) {
    top.location.href = redirectHighbandUrl + '?prm_content=' + prmContent;
  } else if ((getCookie(cookieName) != "" && getCookie(cookieName) != null && ConnectionInfo == "narrowBand") || (ConnectionInfo == "narrowBand")) {
  } else {
    if (getCookie(akamaiCookieName) != "" && getCookie(akamaiCookieName) != null && getCookie(akamaiCookieName).toLowerCase() == "vhigh") {
      top.location.href = redirectHighbandUrl + '?prm_content=' + prmContent;
    }
  }
}
//Bandwidth-Detection
splitSearchString();
highbandUser = false;
var detectedBandwidth = "low";
var userbandwidth = getCookieValue("userbandwidth");
var bandwidth = getCookieValue("bandwidth");
if (query.bandwidth) {
  if (query.bandwidth == "vhigh") {
    detectedBandwidth = "vhigh";
    setCookie("userbandwidth", "vhigh", "", "/");
  } else {
    setCookie("userbandwidth", "low", "", "/");
  }
} else if (userbandwidth) {
  detectedBandwidth = userbandwidth;
} else if (bandwidth) {
  detectedBandwidth = bandwidth;
}
if (detectedBandwidth == "vhigh") {
  highbandUser = true;
}

/**
 * @param {String} selectedBandwidth
 */
var selectedBandwidth = "";
function setUserBandwidth(selectedBandwidth){
  var replyText = bandwidth_save_error_no_selection;
  var replyColor = "#000000";

  if (!navigator.cookieEnabled) {
    replyText = bandwidth_save_error_no_cookies;
    replyColor = "#ff0000";
  } else if (selectedBandwidth == "vhigh" || selectedBandwidth == "low") {
    setCookie("userbandwidth", selectedBandwidth, "Sun, 31-Dec-2100 00:00:00 GMT", "/");
    replyText = bandwidth_save_confirm;
  } else if (selectedBandwidth == "auto") {
    setCookie("userbandwidth", "", "Wed, 31-Dec-1980 00:00:00 GMT", "/");
    replyText = bandwidth_save_confirm;
  } else if (selectedBandwidth == "") {
    replyText = bandwidth_save_error_no_selection;
    replyColor = "#ff0000";
  }
  document.getElementById("bandwidthReply").style.color = replyColor;
  writeIntoLayer("bandwidthReply", replyText);
}
/***/
function resetBandwidthReply(){
  writeIntoLayer("bandwidthReply", "");
}
/**
 * @param {Boolean} highbandUser
 */
function changeBandwidth(highbandUser){
  var reloadUrl = self.location.href;
  var bandwidthParameter;
  if (highbandUser) {
    bandwidthParameter = "bandwidth=low";
  } else {
    bandwidthParameter = "bandwidth=vhigh";
  }
  if (reloadUrl.indexOf("bandwidth=") != -1) {
    if (reloadUrl.indexOf("bandwidth=low") != -1 && bandwidthParameter == "bandwidth=vhigh") {
      reloadUrl = reloadUrl.replace(/bandwidth=low/g, "bandwidth=vhigh");
    } else {
      reloadUrl = reloadUrl.replace(/bandwidth=vhigh/g, "bandwidth=low");
    }
  } else {
    if (reloadUrl.indexOf("?") != -1) {
      if (reloadUrl.charAt(self.location.href.length) != "&") {
        reloadUrl += "&";
      }
    } else {
      reloadUrl += "?";
    }
    reloadUrl += bandwidthParameter;
  }
  self.location.href = reloadUrl;
}
/***/
function closeBandwidthLayer(){
  setCurtain(0);
  setVisibility("bandwidthlayer", 0);
  setVisibility("selectBoxContentBandwidth", 0);
  document.getElementById('changeVersionLink').className = "menu";
  bandwidthLayerState = 0;
}
/***/
function showBandwidthLayer(){
  setCurtain(1);
  selectedBandwidth = "";
  if (highbandUser) {
    bandwidth_headline = bandwidth_headline_low;
    bandwidth_copy = bandwidth_copy_low;
    bandwidth_link = bandwidth_link_low;
  } else {
    bandwidth_headline = bandwidth_headline_high;
    bandwidth_copy = bandwidth_copy_high;
    bandwidth_link = bandwidth_link_high;
  }
  var layerContent = '' +
  '  <div id="bandwidthClose"><a href="javascript:closeBandwidthLayer();" onmouseover="switchImage(\'closeImg\',1);" onmouseout="switchImage(\'closeImg\',0);"><img src="' + closeGif + '" id="closeImg" preload="' + close2Gif + '" width="13" height="12"></a></div>' +
  '  <div id="bandwidthlayerLeft">' +
  '    <h3>' + bandwidth_headline + '</h3>' +
  '    <div style="height:6px; overflow:hidden;"></div>' + bandwidth_copy +
  '    <div style="height:15px; overflow:hidden;"></div>' +
  '    <a href="javascript:changeBandwidth(highbandUser);" class="arrow" target="_self"><img src="' + transGif + '">' + bandwidth_link + '</a>' +
  '  </div>' +
  '  <div id="bandwidthlayerSeperator"></div>' +
  '  <div id="bandwidthlayerRight">' +
  '    <h3>' + bandwidth_save_headline + '</h3>' +
  '    <div style="height:6px; overflow:hidden;"></div>' + bandwidth_save_copy +
  '    <div style="height:2px; overflow:hidden;"></div>' +
  '    <div style="position:relative; z-index:1000;">' +
  '      <table width="182" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff">' +
  '        <colgroup><col width="1"><col width="162"><col width="18"><col width="1"></colgroup>' +
  '        <tr>' +
  '          <td colspan="4" bgcolor="#003399"><img src="' + p003399Gif + '" width="182" height="1"></td>' +
  '        </tr>' +
  '        <tr>' +
  '          <td bgcolor="#003399"><img src="' + p003399Gif + '" width="1" height="16"></td>' +
  '          <td valign="middle" onClick="setVisibility(\'selectBoxContentBandwidth\');" onMouseover="directOrder[ \'Bandwidth\' ]=true;" onMouseout="directOrder[ \'Bandwidth\' ]=false;" style="cursor:pointer;"><span id="selectedValueBandwidth">&nbsp; ' + bandwidth_save_select + '</span></td>' +
  '          <td><a href="javascript:setVisibility(\'selectBoxContentBandwidth\');" onMouseover="directOrder[ \'Bandwidth\' ]=true;" onMouseout="directOrder[ \'Bandwidth\' ]=false;" onFocus="this.blur();"><img src="' + pulldownGif + '" width="18" height="16" border="0"></a></td>' +
  '          <td bgcolor="#003399"><img src="' + p003399Gif + '" width="1" height="16"></td>' +
  '        </tr>' +
  '        <tr>' +
  '          <td colspan="4" bgcolor="#003399"><img src="' + p003399Gif + '" width="182" height="1"></td>' +
  '        </tr>' +
  '      </table>' +
  '      <div id="selectBoxContentBandwidth" class="selectBoxContent" style="top:17px; background-color:#ffffff">' +
  '        <table cellspacing="0" cellpadding="0" border="0" width="182">' +
  '          <tr><td colspan="3" bgcolor="#003399"><img src="' + p003399Gif + '" width="182" height="1"></td></tr>' +
  '          <tr>' +
  '            <td width="1" bgcolor="#003399"><img src="' + transGif + '"></td>' +
  '            <td width="180" valign="top">' +
  '              <div id="block1Select" style="width:180px; background-color:#ffffff; height:84px; overflow:auto;">' +
  '                <div style="height:7px; overflow:hidden;"></div>' +
  '                <a href="javascript://" class="selectboxEntry" onclick="setOption(\'' + bandwidth_save_select + '\',\'\',\'Bandwidth\',\'\',\'\',\'none\');selectedBandwidth=\'\';resetBandwidthReply();">&nbsp; ' + bandwidth_save_select + '</a>' +
  '                <a href="javascript://" class="selectboxEntry" onclick="setOption(\'' + bandwidth_save_highband + '\',\'\',\'Bandwidth\',\'\',\'\',\'none\');selectedBandwidth=\'vhigh\';resetBandwidthReply();">&nbsp; ' + bandwidth_save_highband + '</a>' +
  '                <a href="javascript://" class="selectboxEntry" onclick="setOption(\'' + bandwidth_save_lowband + '\',\'\',\'Bandwidth\',\'\',\'\',\'none\');selectedBandwidth=\'low\';resetBandwidthReply();">&nbsp; ' + bandwidth_save_lowband + '</a>' +
  '                <a href="javascript://" class="selectboxEntry" onclick="setOption(\'' + bandwidth_save_auto + '\',\'\',\'Bandwidth\',\'\',\'\',\'none\');selectedBandwidth=\'auto\';resetBandwidthReply();">&nbsp; ' + bandwidth_save_auto + '</a><br>' +
  '              </div>' +
  '            </td>' +
  '            <td width="1" bgcolor="#003399"><img src="' + transGif + '" width="1" height="1"></td>' +
  '          </tr>' +
  '          <tr><td colspan="3" bgcolor="#003399"><img src="' + p003399Gif + '" width="182" height="1"></td></tr>' +
  '        </table>' +
  '      </div>' +
  '    </div>' +
  '    <a href="javascript:setUserBandwidth(selectedBandwidth);" id="bandwidthBoxlink">' + bandwidth_save_button + '</a><br>' +
  '    <div id="bandwidthReply"></div>' +
  '  </div>' +
  '</div>';

  bandwidthlayerPos = getWindowInformation('scrollTop');
  if (bandwidthlayerPos > 0) {
    document.getElementById("bandwidthlayer").style.top = (162 + bandwidthlayerPos) + "px";
  }
  writeIntoLayer(bandwidthlayer, layerContent)
  setVisibility("bandwidthlayer", 1);
  preload();
  document.getElementById('changeVersionLink').className = "menu linkHighlight";
  bandwidthLayerState = 1;
}
/***/
var bandwidthLayerState = 0;
function toggleBandwidthLayer(){
  if (bandwidthLayerState == 0) {
    showBandwidthLayer();
  } else {
    closeBandwidthLayer()
  }
}
/***/
var videoTeasers = [];
var currentVideoTeaser = false;
function showVideoTeaser(videoTeaserId, videoTeaserWidth, videoTeaserHeight, layerTop, layerLeft){
  currentVideoTeaser = "videoTeaser" + videoTeaserId;
  var videoTeaser = new SWFObject(videoTeaserFlashWrapper, "videoTeaser" + videoTeaserId + "FlashID", videoTeaserWidth, videoTeaserHeight + 16, "8.0.22", "#ffffff");
  videoTeaser.addParam("quality", "high");
  videoTeaser.addParam("allowScriptAccess", "always");
  videoTeaser.addParam("wmode", "transparent");
  videoTeaser.addVariable("prm_contentgetter", "videoTeaserGetContent");

  var originalObj = document.getElementById(currentVideoTeaser);
  var clonedObj = originalObj.cloneNode(true);
  originalObj.parentNode.removeChild(originalObj);
  document.body.appendChild(clonedObj);
  videoTeaser.write("videoTeaser" + videoTeaserId + "Player");
  setVisibility("videoTeaser" + videoTeaserId, 1, 'block');
}
/***/
function videoTeaserGetContent(){
  if (currentVideoTeaser) {
    return videoTeasers[currentVideoTeaser];
  }
}
/**
 * @param {String} fileName
 * @param {Number} videoStatus
 */
function videoTeaserTracking(fileName, videoStatus){
  var trackingUrl = self.location.href.substring(0, self.location.href.lastIndexOf("/"));
  var pageName = self.location.href.substring(self.location.href.lastIndexOf("/") + 1, self.location.href.lastIndexOf("."));
  var flvName = fileName.substring(fileName.lastIndexOf("/") + 1, fileName.lastIndexOf("."));
  trackingUrl = trackingUrl + "/" + pageName + "_video_" + flvName + "_" + videoStatus + ".html";
  if (confTrackingEnabled) {
    trackAbsolute(trackingUrl, '', true);
  }
}
/**
 * SWFObject v1.5: Flash Player detection and embed - http://blog.deconcept.com/swfobject/
 *
 * SWFObject is (c) 2007 Geoff Stearns and is released under the MIT License:
 * http://www.opensource.org/licenses/mit-license.php
 *
 */
if (typeof deconcept == "undefined") {
  var deconcept = new Object();
}
if (typeof deconcept.util == "undefined") {
  deconcept.util = new Object();
}
if (typeof deconcept.SWFObjectUtil == "undefined") {
  deconcept.SWFObjectUtil = new Object();
}
deconcept.SWFObject = function(_1, id, w, h, _5, c, _7, _8, _9, _a){
  if (!document.getElementById)
    return;
  this.DETECT_KEY = (_a) ? _a : "detectflash";
  this.skipDetect = deconcept.util.getRequestParameter(this.DETECT_KEY);
  this.params = new Object();
  this.variables = new Object();
  this.attributes = new Array();
  if (_1) {
    this.setAttribute("swf", _1);
  }
  if (id) {
    this.setAttribute("id", id);
  }
  if (w) {
    this.setAttribute("width", w);
  }
  if (h) {
    this.setAttribute("height", h);
  }
  if (_5) {
    this.setAttribute("version", new deconcept.PlayerVersion(_5.toString().split(".")));
  }
  this.installedVer = deconcept.SWFObjectUtil.getPlayerVersion();
  if (!window.opera && document.all && this.installedVer.major > 7) {
    deconcept.SWFObject.doPrepUnload = true;
  }
  if (c) {
    this.addParam("bgcolor", c);
  }
  var q = (_7) ? _7 : "high";
  this.addParam("quality", q);
  this.setAttribute("useExpressInstall", false);
  this.setAttribute("doExpressInstall", false);
  var _c = (_8) ? _8 : window.location;
  this.setAttribute("xiRedirectUrl", _c);
  this.setAttribute("redirectUrl", "");
  if (_9) {
    this.setAttribute("redirectUrl", _9);
  }
};
deconcept.SWFObject.prototype = {
  useExpressInstall: function(_d){
    this.xiSWFPath = !_d ? "expressinstall.swf" : _d;
    this.setAttribute("useExpressInstall", true);
  },
  setAttribute: function(_e, _f){
    this.attributes[_e] = _f;
  },
  getAttribute: function(_10){
    return this.attributes[_10];
  },
  addParam: function(_11, _12){
    this.params[_11] = _12;
  },
  getParams: function(){
    return this.params;
  },
  addVariable: function(_13, _14){
    this.variables[_13] = _14;
  },
  getVariable: function(_15){
    return this.variables[_15];
  },
  getVariables: function(){
    return this.variables;
  },
  getVariablePairs: function(){
    var _16 = new Array();
    var key;
    var _18 = this.getVariables();
    for (key in _18) {
      _16[_16.length] = key + "=" + _18[key];
    }
    return _16;
  },
  getSWFHTML: function(){
    var _19 = "";
    if (navigator.plugins && navigator.mimeTypes && navigator.mimeTypes.length) {
      if (this.getAttribute("doExpressInstall")) {
        this.addVariable("MMplayerType", "PlugIn");
        this.setAttribute("swf", this.xiSWFPath);
      }
      _19 = "<embed type=\"application/x-shockwave-flash\" src=\"" + this.getAttribute("swf") + "\" width=\"" + this.getAttribute("width") + "\" height=\"" + this.getAttribute("height") + "\" style=\"" + this.getAttribute("style") + "\"";
      _19 += " id=\"" + this.getAttribute("id") + "\" name=\"" + this.getAttribute("id") + "\" ";
      var _1a = this.getParams();
      for (var key in _1a) {
        _19 +=[key]  + "=\"" + _1a[key] + "\" ";
      }
      var _1c = this.getVariablePairs().join("&");
      if (_1c.length > 0) {
        _19 += "flashvars=\"" + _1c + "\"";
      }
      _19 += "/>";
    } else {
      if (this.getAttribute("doExpressInstall")) {
        this.addVariable("MMplayerType", "ActiveX");
        this.setAttribute("swf", this.xiSWFPath);
      }
      _19 = "<object id=\"" + this.getAttribute("id") + "\" classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" width=\"" + this.getAttribute("width") + "\" height=\"" + this.getAttribute("height") + "\" style=\"" + this.getAttribute("style") + "\">";
      _19 += "<param name=\"movie\" value=\"" + this.getAttribute("swf") + "\" />";
      var _1d = this.getParams();
      for (var key in _1d) {
        _19 += "<param name=\"" + key + "\" value=\"" + _1d[key] + "\" />";
      }
      var _1f = this.getVariablePairs().join("&");
      if (_1f.length > 0) {
        _19 += "<param name=\"flashvars\" value=\"" + _1f + "\" />";
      }
      _19 += "</object>";
    }
    return _19;
  },
  write: function(_20){
    if (this.getAttribute("useExpressInstall")) {
      var _21 = new deconcept.PlayerVersion([6, 0, 65]);
      if (this.installedVer.versionIsValid(_21) && !this.installedVer.versionIsValid(this.getAttribute("version"))) {
        this.setAttribute("doExpressInstall", true);
        this.addVariable("MMredirectURL", escape(this.getAttribute("xiRedirectUrl")));
        document.title = document.title.slice(0, 47) + " - Flash Player Installation";
        this.addVariable("MMdoctitle", document.title);
      }
    }
    if (this.skipDetect || this.getAttribute("doExpressInstall") || this.installedVer.versionIsValid(this.getAttribute("version"))) {
      var n = (typeof _20 == "string") ? document.getElementById(_20) : _20;
      n.innerHTML = this.getSWFHTML();
      return true;
    } else {
      if (this.getAttribute("redirectUrl") != "") {
        document.location.replace(this.getAttribute("redirectUrl"));
      }
    }
    return false;
  }
};
deconcept.SWFObjectUtil.getPlayerVersion = function(){
  var _23 = new deconcept.PlayerVersion([0, 0, 0]);
  if (navigator.plugins && navigator.mimeTypes.length) {
    var x = navigator.plugins["Shockwave Flash"];
    if (x && x.description) {
      _23 = new deconcept.PlayerVersion(x.description.replace(/([ a-zA-Z ]|\s)+/, "").replace(/(\s+r|\s+b[ 0-9 ]+)/, ".").split("."));
    }
  } else {
    if (navigator.userAgent && navigator.userAgent.indexOf("Windows CE") >= 0) {
      var axo = 1;
      var _26 = 3;
      while (axo) {
        try {
          _26++;
          axo = new ActiveXObject("ShockwaveFlash.ShockwaveFlash." + _26);
          _23 = new deconcept.PlayerVersion([_26, 0, 0]);
        } catch (e) {
          axo = null;
        }
      }
    } else {
      try {
        var axo = new ActiveXObject("ShockwaveFlash.ShockwaveFlash.7");
      } catch (e) {
        try {
          var axo = new ActiveXObject("ShockwaveFlash.ShockwaveFlash.6");
          _23 = new deconcept.PlayerVersion([6, 0, 21]);
          axo.AllowScriptAccess = "always";
        } catch (e) {
          if (_23.major == 6) {
            return _23;
          }
        }
        try {
          axo = new ActiveXObject("ShockwaveFlash.ShockwaveFlash");
        } catch (e) {
        }
      }
      if (axo != null) {
        _23 = new deconcept.PlayerVersion(axo.GetVariable("$version").split(" ")[1].split(","));
      }
    }
  }
  return _23;
};
deconcept.PlayerVersion = function(_29){
  this.major = _29[0] != null ? parseInt(_29[0]) : 0;
  this.minor = _29[1] != null ? parseInt(_29[1]) : 0;
  this.rev = _29[2] != null ? parseInt(_29[2]) : 0;
};
deconcept.PlayerVersion.prototype.versionIsValid = function(fv){
  if (this.major < fv.major) {
    return false;
  }
  if (this.major > fv.major) {
    return true;
  }
  if (this.minor < fv.minor) {
    return false;
  }
  if (this.minor > fv.minor) {
    return true;
  }
  if (this.rev < fv.rev) {
    return false;
  }
  return true;
};
deconcept.util = {
  getRequestParameter: function(_2b){
    var q = document.location.search || document.location.hash;
    if (_2b == null) {
      return q;
    }
    if (q) {
      var _2d = q.substring(1).split("&");
      for (var i = 0; i < _2d.length; i++) {
        if (_2d[i].substring(0, _2d[i].indexOf("=")) == _2b) {
          return _2d[i].substring((_2d[i].indexOf("=") + 1));
        }
      }
    }
    return "";
  }
};
deconcept.SWFObjectUtil.cleanupSWFs = function(){
  var _2f = document.getElementsByTagName("OBJECT");
  for (var i = _2f.length - 1; i >= 0; i--) {
    _2f[i].style.display = "none";
    for (var x in _2f[i]) {
      if (typeof _2f[i][x] == "function") {
        _2f[i][x] = function(){
        };
      }
    }
  }
};
if (deconcept.SWFObject.doPrepUnload) {
  if (!deconcept.unloadSet) {
    deconcept.SWFObjectUtil.prepUnload = function(){
      __flash_unloadHandler = function(){
      };
      __flash_savedUnloadHandler = function(){
      };
      window.attachEvent("onunload", deconcept.SWFObjectUtil.cleanupSWFs);
    };
    window.attachEvent("onbeforeunload", deconcept.SWFObjectUtil.prepUnload);
    deconcept.unloadSet = true;
  }
}
if (!document.getElementById && document.all) {
  document.getElementById = function(id){
    return document.all[id];
  };
}
var getQueryParamValue = deconcept.util.getRequestParameter;
var FlashObject = deconcept.SWFObject;
var SWFObject = deconcept.SWFObject;
/**
 * @param {String} file
 */
function getFileName(file){
  var result, pathDiv, fileNameExt, extPos;
  pathDiv = (file.indexOf("/") >= 0) ? "/" : "\\"
  fileNameExt = file.substring(file.lastIndexOf(pathDiv) + 1);
  extPos = fileNameExt.lastIndexOf('.');
  result = (extPos > 1) ? fileNameExt.substring(0, extPos) : fileNameExt;
  return result;
}
/***/
function scrollToTop(){
  window.scrollTo(0, 0);
}
/** Sulzer Visualizer e82 */
function e82VizPrintPopup(printUrl){
  setTimeout("centerPopup('" + printUrl + "', 'Print', 800, 500, false, 1)", 1);
}
/**
 * @param {String} image
 * @param {String} title
 */
function e88deVizDetailPopup(image, title){
  setTimeout("e88deVizDetailPopupAsync('" + image + "', '" + title +
  "')", 1);
}
/**
 * @param {String} image
 * @param {String} title
 */
function e88deVizDetailPopupAsync(image, title){
  zoom = window.open('', 'zoom', 'status = no,toolbar = no,menubar =no,location = no,resizable = yes,titlebar = no,fullscreen = yes');
  zoom.document.open('text/html');
  zoom.document.write("<html>");
  zoom.document.write("<head>");
  zoom.document.write("<title>" + title + "<\/title>");
  zoom.document.write("<SCRIPT LANGUAGE=JavaScript>");
  zoom.document.write("function closeWindow() ");
  zoom.document.write("{");
  zoom.document.write("    window.close();     ");
  zoom.document.write("}");
  zoom.document.write("<\/SCRIPT>");
  zoom.document.write("<\/head>");
  zoom.document.write("");
  zoom.document.write("<body bgcolor='#000000'>");
  zoom.document.write("<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" ");
  zoom.document.write("codebase=\"http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0\"");
  zoom.document.write("width=\"100%\" height=\"100%\" id=\"Zoom\"align=\"middle\">  ");
  zoom.document.write("<param name=\"allowScriptAccess\"value=\"always\" />  ");
  zoom.document.write("<param name=\"movie\" value=\"http://www.bmw.de/de/de/bvcov1e88/Zoom.swf?image=" + image + "\" />  ");
  zoom.document.write("<param name=\"quality\" value=\"high\" /><paramname=\"bgcolor\" value=\"#000000\" />  ");
  zoom.document.write("<embed src=\"http://www.bmw.de/de/de/bvcov1e88/Zoom.swf?image=" + image + "\"  ");
  zoom.document.write("quality=\"high\" bgcolor=\"#000000\" width=\"100%\" height=\"100%\" name=\"Zoom\" align=\"middle\"  ");
  zoom.document.write("allowScriptAccess=\"always\"  ");
  zoom.document.write("type=\"application/x-shockwave-flash\"  ");
  zoom.document.write("pluginspage=\"http://www.macromedia.com/go/getflashplayer\"/>  ");
  zoom.document.write("<\/body>");
  zoom.document.write("");
  zoom.document.write("<\/html>");
  zoom.document.write("");
  zoom.document.close();
};
/** Alters an existing css class definition
 * @param {String} className
 * @param {String} cssRule
 * @param {String} cssValue
 */
function alterCSSClass( className, cssArgument, cssValue ) {
  var cssRules = ( document.all )? 'rules':( document.getElementById )? 'cssRules':false;
  if ( cssRules != false ) {
    for ( var i = 0; i < document.styleSheets.length; i++ ) {
      var currentStyle = document.styleSheets[ i ];
      for ( var j = 0; j < currentStyle[ cssRules ].length; j++ ) {
        var currentRule = currentStyle[ cssRules ][ j ];
        if ( currentRule.selectorText == className ) {
          currentRule.style[ cssArgument ] = cssValue;
        }
      }
    }
  }
}

/** Enable/Disable if the main navigation is folding
 * @param {Boolean} state
 */
function setMainNavigationFolded(state, foldingSteps, foldInterval) {
}

/** Fix display problems with the bottom navigation with small screen resolutions
 *  onResize-Action
 */
function checkBottomNavi() {
  var currentWindowWith = getWindowInformation("winWidth");
  if(currentWindowWith < 982) {
    document.getElementById('metaNavigationInline').style.width = currentWindowWith + "px";
  }
  else {
    document.getElementById('metaNavigationInline').style.width = "982px";
  }
}
