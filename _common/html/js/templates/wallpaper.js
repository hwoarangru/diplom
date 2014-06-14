  function onUnloadFunctions(){
    resetBottomNavigation();
  }

  myId = "";
  mySource = "";

  function restoreThumbs() {
    for (i=0;i<thumbs.length;i++) {
      imgWallpaper = "wallpaper" + i;
      divLense     = "lense" + i;
      document.images[imgWallpaper].src = thumbs[i];
      setVisibility(divLense,1);
    }
  }

  function restoreLenses() {
    for (i=0;i<thumbs.length;i++) {
      divLense     = "lense" + i;
      setVisibility(divLense,1);
    }
  }

  function openDialog(thisDialog) {
    setVisibility("dialog" + thisDialog,1);
    for(i=0;i<thumbs.length;i++) {
      if (i != thisDialog) {
        layerName = "dialog" + i;
        setVisibility(layerName,0);
      }
    }
  }

  function preLoadBigImage(id) {
    myId = id;
    bigImage          = new Image();
    bigImage.onabort  = loadUpdate;
    bigImage.onerror  = loadUpdate;
    bigImage.onload   = loadUpdate;
    bigImage.src      = big_standard_url[id];
  }

  function loadUpdate() {
    if (checkObject()) {
      setVisibility("bigImageLoader",0);
      setClassName("wallpaperBody","");
      rewriteBigImageNavi(myId);
      document.images["bigImageDummy"].src = bigImage.src;
      setVisibility("bigImageLayer",1);
      setVisibility("bigImageNavi",1);
      //closeModulNavi();
      moduleNavigation.startFold( true );
      restoreLenses();
      restoreThumbs();
    }
  }

  function checkObject() {
    actualImageSrc = big_standard_url[myId].replace(/\.\.\//g,"");
    if (bigImage.src.indexOf(actualImageSrc) != -1) {
      return true;
    }
    else {
      return false;
    }
  }

  function nextImage(currentId, direction) {
    setVisibility("bigImageLoader",1);
    setClassName("wallpaperBody","loading");
    if(direction == "next") {
      if(currentId >= thumbs.length-1) {thisId = 0;} else {thisId = currentId + 1;}
    }
    else {
      if(currentId == 0) {thisId = thumbs.length-1;} else {thisId = currentId - 1;}
    }
    preLoadBigImage(thisId);
  }

  function closeMediaView() {
    restoreLenses();
    restoreThumbs();
    setVisibility('bigImageLayer',0);
    setVisibility('bigImageNavi',0);
    //openModulNavi();
    moduleNavigation.startFold( false );
  }

  function abortPreload() {
    setVisibility("bigImageLoader",0);
    setClassName("wallpaperBody","");
  }

  function closeNaviEvent() {
    setClassName("bigImageNavi","bigImageNaviTop");
  }

  function openNaviEvent() {
    setClassName("bigImageNavi","bigImageNaviBottom");
  }

  function setBigImageLayer() {
    getWindowInformation('winHeight');
    topSize = (getWindowInformation('winHeight') - 14 - 29) - 768;

    if(topSize < 0) {
      moveObject(bigImageLayer,0,topSize);
    }
  }