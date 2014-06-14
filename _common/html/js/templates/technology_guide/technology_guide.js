// ********************************************
// ALT - Bitte löschen sobald möglich
// ********************************************
infoState = 0;

function toggleRelatedModels(order) {
  if (infoState == 0) {
    infoState = 1;
    setVisibility('relatedModels',1);
    document.getElementById("linkRelatedModels").style.color="#003399";
  }
  else if(infoState == 1 || order == 1){
    infoState = 0;
    setVisibility('relatedModels',0);
    document.getElementById("linkRelatedModels").style.color="#4c4c4c";
  }
}


function getRelatedModelsContent() {
  var contentPart = new Array();

  for(i=0;i<=TLmodelMatching.length;i++) {
    if(relatedModelsArray[TLmodelMatching[i]]) {
      contentPart.push('<li><a href="../' + buildValidServerRelativeUrl(TLmodels[TLmodelMatching[i]][2]) + '" class="arrowWhite"><img src="' + transGif + '" alt="" class="arrowWhite">' + TLmodels[TLmodelMatching[i]][1] + '</a></li>');
    }
  }
  var rmHeadline = '<h2>' + TLrelatedModelsHeadline + '</h2>';
  var content = TLrelatedModelsCopy + '<div style="height:12px;overflow:hidden;"></div>';
  content += '<table width="100%" cellspacing="0" cellpadding="0" border="0"><tr><td width="180" valign="top"><ul class="linkList">';
  var tableBreak = Math.ceil(contentPart.length/2);
  if(contentPart.length == 1) {
    tableBreak = -1;
  }

  for(i=0;i<contentPart.length;i++) {
    if(i == tableBreak) {
      content += '</ul></td><td width="12">&nbsp;</td><td width="180" valign="top"><ul class="linkList">';
    }
    content += contentPart[i];
  }
  content += '</ul></td></table>';
  writeIntoLayer("relatedModelsContent",content);
  writeIntoLayer("relatedModelsHeadline",rmHeadline);
}


String.prototype.toRegExpString = function () {
  return this.replace(/([\^\$\.\*\+\?\=\!\:\|\\\/\(\)\[\]\{\}])/g, "\\$1");
};

function getItReplaced(searchtext, keyword, stringBeforeKeyword, stringAfterKeyword, doesIgnoreCase) {
  var txt = String(searchtext);
  var key = String(keyword);
  var txtBefore = String(stringBeforeKeyword);
  var txtAfter = String(stringAfterKeyword);
  var iFlag = ((Boolean(doesIgnoreCase)) ? ("i") : (""));

  var doSurgery = function (str, $1) {return (txtBefore + $1 + txtAfter);};

  var regXSearch = new RegExp(("\\b\(" + key.toRegExpString().replace((/\s+/g), "\\s+") + "[a-zA-Z]{0,4})\\b"), iFlag);
//var regXSearch = new RegExp(("(\\b|\\s)\(" + key.toRegExpString().replace((/\s+/g), "\\s+") + "[a-zA-Z]{0,4})(\\b|\\s|\\.|\\:|,|;)"), iFlag);

  return txt.replace(regXSearch, doSurgery);
}




 function loadContent(file){
    var head = document.getElementsByTagName('head').item(0)
    var scriptTag = document.getElementById('loadScript');
    if(scriptTag) head.removeChild(scriptTag);
      script = document.createElement('script');
      script.src = file;
      script.type = 'text/javascript';
      script.id = 'loadScript';
      head.appendChild(script);
      loadedFile (0);
  }

  var currentObj = "";
  var currentImg = "";
  var infoState = 0;


  function toogleLayer(obj,img,infoParam, page) {
    if (currentObj != "") {
      setVisibility(currentObj,null,"none");
      document.getElementById("showroomIFrame").src=buildValidServerRelativeUrl("/_common/shared/blank_frame.html");
        if (infoState == 1) {
          switchImage(img,0);
        }
        else {
          switchImage(img,1);
        }
    }

    if (currentObj == "" || currentObj != obj) {

    if(page!=""){
      document.getElementById("showroomIFrame").src=page;
    }

      setVisibility(obj,null,"block");

      if (infoParam == 1) {
        infoState = 1;
        switchImage(img,1);
      } else {
        infoState = 0;
        switchImage(img,0);
      }
      currentObj = obj;
      currentImg = img;
      } else {
        currentObj = "";
        currentImg = "";
    }
  }

  function prepareCopytext() {
    var myCopytext = document.getElementById("copyTextP").innerHTML;
    for(i=0;i<TLdatabase.length;i++) {
      if(TLdatabase[i][6] == "") {
        var source = self.location.pathname;
        var address = buildValidServerRelativeUrl(TLbaseUrl+'articles/_narrowband/iframes/'+ getFileName(TLdatabase[i][4]) + '.htm?source='+source+'&article='+getFileName(TLdatabase[i][4]));
        var textBefore = '<a href="javascript:toogleLayer(\'showroomLayer\',\'closeIm3\',\'0\', \''+address+'\');" onMouseOver=\"switchImage(\'closeIm3\',1);\" onMouseOut=\"switchImage(\'closeIm3\',0);\"  class=\"TLcontextlink\">';
        var textBeyond = '</a>';
        myCopytext = getItReplaced(myCopytext, TLdatabase[i][1], textBefore, textBeyond);
      }
    }
    document.getElementById("copyTextP").innerHTML = myCopytext;
  }


  function loadedFile (startCounter) {
   if((startCounter*100)< 5000){
    try {
      if (!TLjsLoaded) {
        throw "unloaded";
      }else if (TLjsLoaded==true){
        throw "loaded";
      }
    } catch (e) {
      if (e == "loaded") {
        prepareCopytext();
       return;
      }
    } finally {
      startCounter++;

    }
    setTimeout("loadedFile(" + startCounter + ")", 100);
   }
  }



// ********************************************
// NEU
// ********************************************
infoState = 0;

function technologyGuideToggleRelatedModels(order) {
  if (infoState == 0) {
    infoState = 1;
    setVisibility('relatedModels',1);
    document.getElementById("linkRelatedModels").style.color="#003399";
  }
  else if(infoState == 1 || order == 1){
    infoState = 0;
    setVisibility('relatedModels',0);
    document.getElementById("linkRelatedModels").style.color="#4c4c4c";
  }
}

function technologyGuideGetRelatedModelsContent() {
  var contentPart = new Array();

  for(i=0;i<=TLmodelMatching.length;i++) {
    if(relatedModelsArray[TLmodelMatching[i]]) {
      contentPart.push('<li><a href="../' + buildValidServerRelativeUrl(TLmodels[TLmodelMatching[i]][2]) + '" class="arrowWhite"><img src="' + transGif + '" alt="" class="arrowWhite">' + TLmodels[TLmodelMatching[i]][1] + '</a></li>');
    }
  }
  var rmHeadline = '<h2>' + TLrelatedModelsHeadline + '</h2>';
  var content = TLrelatedModelsCopy + '<div style="height:12px;overflow:hidden;"></div>';
  content += '<table width="100%" cellspacing="0" cellpadding="0" border="0"><tr><td width="180" valign="top"><ul class="linkList">';
  var tableBreak = Math.ceil(contentPart.length/2);
  if(contentPart.length == 1) {
    tableBreak = -1;
  }

  for(i=0;i<contentPart.length;i++) {
    if(i == tableBreak) {
      content += '</ul></td><td width="12">&nbsp;</td><td width="180" valign="top"><ul class="linkList">';
    }
    content += contentPart[i];
  }
  content += '</ul></td></table>';
  writeIntoLayer("relatedModelsContent",content);
  writeIntoLayer("relatedModelsHeadline",rmHeadline);
}


function technologyGuideReplace(searchtext, keyword, stringBeforeKeyword, stringAfterKeyword, doesIgnoreCase) {
  var txt = String(searchtext);
  var key = String(keyword);
  var txtBefore = String(stringBeforeKeyword);
  var txtAfter = String(stringAfterKeyword);
  var iFlag = ((Boolean(doesIgnoreCase)) ? ("i") : (""));
  var doSurgery = function (str, $1, $2, $3) {return (txtBefore + $1 + $2 + $3 + txtAfter);};
//var regXSearch = new RegExp(("\\b\(" + key.toRegExpString().replace((/\s+/g), "\\s+") + "[a-zA-Z]{0,4})\\b"), iFlag);
  var regXSearch = new RegExp(("(\\b|\\s)\(" + key.toRegExpString().replace((/\s+/g), "\\s+") + "[a-zA-Z]{0,4})(\\b|\\s|\\.|\\:|,|;)"), iFlag);
  return txt.replace(regXSearch, doSurgery);
}


function technologyGuideToggleLayer(obj,img,infoParam, page) {
  if (currentObj != "") {
    setVisibility(currentObj,null,"none");
    document.getElementById("showroomIFrame").src=buildValidServerRelativeUrl("/_common/shared/blank_frame.html");
      if (infoState == 1) {
        switchImage(img,0);
      }
      else {
        switchImage(img,1);
      }
  }
  if (currentObj == "" || currentObj != obj) {
  if(page!=""){
    document.getElementById("showroomIFrame").src=page;
  }
    setVisibility(obj,null,"block");
    if (infoParam == 1) {
      infoState = 1;
      switchImage(img,1);
    } else {
      infoState = 0;
      switchImage(img,0);
    }
    currentObj = obj;
    currentImg = img;
    } else {
      currentObj = "";
      currentImg = "";
  }
}


function technologyGuidePrepareCopytext() {
  var myCopytext = document.getElementById("copyTextP").innerHTML;
  for(i=0;i<TLdatabase.length;i++) {
    if(TLdatabase[i][6] == "") {
      var source = self.location.pathname;
      var address = buildValidServerRelativeUrl(TLbaseUrl+'articles/_narrowband/iframes/'+ getFileName(TLdatabase[i][4]) + '.htm?source='+source+'&article='+getFileName(TLdatabase[i][4]));
      var textBefore = '<a href="javascript:toogleLayer(\'showroomLayer\',\'closeIm3\',\'0\', \''+address+'\');" onMouseOver=\"switchImage(\'closeIm3\',1);\" onMouseOut=\"switchImage(\'closeIm3\',0);\"  class=\"TLcontextlink\">';
      var textBeyond = '</a>';
      myCopytext = technologyGuideReplace(myCopytext, TLdatabase[i][1], textBefore, textBeyond);
    }
  }
  document.getElementById("copyTextP").innerHTML = myCopytext;
}


function technologyGuideCheckDatabase(startCounter) {
 if((startCounter*100)< 5000){
  try {
    if (!TLjsLoaded) {
      throw "unloaded";
    }else if (TLjsLoaded==true){
      throw "loaded";
    }
  } catch (e) {
    if (e == "loaded") {
      technologyGuidePrepareCopytext();
     return;
    }
  } finally {
    startCounter++;

  }
  setTimeout("technologyGuideCheckDatabase(" + startCounter + ")", 100);
 }
}

function addJavascriptLibrary(scriptUrl,scriptId) {
  var head = document.getElementsByTagName('head').item(0);
  var scriptTag = document.getElementById(scriptId);
  if ( scriptTag ) {head.removeChild(scriptTag);}
  script = document.createElement('script');
  script.src = scriptUrl;
  script.type = 'text/javascript';
  script.id = scriptId;
  head.appendChild(script);
  technologyGuideCheckDatabase(0);
}