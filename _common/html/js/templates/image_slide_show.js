scrollerCheckElements = new Array("completePageContent");
scrollerSize = scrollerDefaultSize;
window.onresize = checkWindowSize;
flashDetected = false;
var currentImageIndexToDisplay=0;

function displaySlide(slideIndex){
  var slide;

  if(!highbandUser) {
    prepareBigImage(slideIndex);
  }
  for (var x = 0; x< slideCount; x++){
    if(oneTextOnly) {
      slide = 0;
    }
    else {
      slide = x;
    }

    if(document.getElementById("completeText" + x)!= null && !oneTextOnly){
      document.getElementById("completeText" + x).style.visibility = "hidden";
    }

    if(x == slideIndex){
      if(highbandUser && flashDetected) {
        if(typeof(document.getElementById("imageSlideShowSwf").scrollTo) == "function") {
          document.getElementById("imageSlideShowSwf").scrollTo(slideIndex);
        }
      }
      else {
        document.images["displayedImage"].src = imageDatabase.images[slideIndex];
      }
      document.getElementById("completeText" + slide).style.visibility = "visible";
    }
  }
  setImgBorderPermanent(slideIndex);
  if(confTrackingEnabled) {
    var trackingUrl = window.location.pathname.replace(/\./g, "_slide_" + slideIndex + ".");
    trackAbsolute(trackingUrl,'');
  }
}

function onUnloadFunctions(){
  resetBottomNavigation();
}


function setImgBorder(divNr){
  posX = 317 + ((divNr * 33) + divNr)
  moveObject('imgBorder',posX,361);
  content='<a href="javascript:displaySlide('+divNr+');" onmouseout="deleteImgBorder();"><img src="' + highlightBoxSmall + '" border="0" width="37" height="29"></a><br>';
  writeIntoLayer('imgBorder' ,content);
  setVisibility("imgBorder",1);
}

function setImgBorderPermanent(divNr){
  if (slideCount > 1) {
    posX = 317 + ((divNr * 33) + divNr)
    moveObject('imgBorderPermanent',posX,361);
    setVisibility("imgBorderPermanent",1);
    setVisibility("imgBorder",0);
  }
}

function deleteImgBorder(){
  setVisibility("imgBorder",0);
}

function prepareBigImage(id) {
  setClassName("equipmentBody","loading");
  setVisibility("bigImageLoader",1);
  preLoadBigImage(id);
}

function preLoadBigImage(id) {
  myId = id;
  bigImage = new Image();
  bigImage.onabort = loadUpdate;
  bigImage.onerror = loadUpdate;
  bigImage.onload = loadUpdate;
  bigImage.src = imageDatabase.images[id];
}

function loadUpdate() {
  if (checkObject()) {
    setVisibility("bigImageLoader",0);
    setClassName("equipmentBody","");
    document.images["displayedImage"].src = bigImage.src;
  }
}

function checkObject() {
  actualImageSrc = imageDatabase.images[myId];
  if (bigImage.src == getFullPath(self.location.href, actualImageSrc)) {
    return true;
  }
  else {
    return false;
  }
}

function imageSlideShowGetFlashContent()  {
  return imageDatabase;
}
