function trackAbsolute(objectReference,objectTitle){
  if(objectReference.substr(0,4) == "http") {
    objectReference = objectReference.replace(/\/\//,"");
    objectReference = objectReference.substring(objectReference.indexOf("/"));
  }
  if(objectReference.indexOf('?') != -1){
    var splitted = objectReference.split('?');
    var path = splitted[0];
    if (splitted[1].substr(splitted[1].length - 1)!="&") {
      splitted[1] += "&";
    }
    splitted[1] += "highbandUser=" + highbandUser;

    queryString = "?" + splitted[1];

    dcsMultiTrack('DCS.dcsuri',path,'WT.ti','-', 'DCS.dcsqry', queryString);
  }
  else {
    queryString = "?" + "highbandUser=" + highbandUser;
    dcsMultiTrack('DCS.dcsuri', objectReference, 'WT.ti', '-', 'DCS.dcsqry', queryString);
  }
}

function trackHighend(trackingType, source, target){
  if(confTrackingEnabled){
    var targetParamName = "target";
    if(trackingType=="download" || trackingType=="small_download"){
      targetParamName="file";
    }
    var objectReference = buildValidServerRelativeUrl(trackingPages[trackingType][0]) + "?source=" + source + "&" + targetParamName + "=" + target;
    var objectTitle     = trackingPages[trackingType][1];
    trackAbsolute(objectReference, objectTitle);
  }
}

function trackEvent(pagetype, sourceurl, targeturl){
  if (confTrackingEnabled) {
    var substract = self.location.host;

    var targetparam = "target";
    if(pagetype == "download") {
      targetparam = "file";
    }

    if(sourceurl.substr(0, 1) != "/" ) {
      sourceurl = getFullPath(self.location.href, sourceurl);
      sourceurl = sourceurl.substring(sourceurl.indexOf(substract) + substract.length, sourceurl.length);
    }

    if(pagetype != "bandwidth" && pagetype != "click_event" && targeturl.substr(0, 1) != "/") {
      targeturl = getFullPath(self.location.href, targeturl);
      targeturl = targeturl.substring(targeturl.indexOf(substract) + substract.length, targeturl.length);
    }

    if (pagetype != "bandwidth" && pagetype != "click_event") {
      targeturl = escape(buildValidServerRelativeUrl(targeturl));
    }

    var trackingUrl = buildValidServerRelativeUrl(trackingPages[pagetype][0]) + '?' + targetparam + '=' + targeturl + '&source=' + escape(buildValidServerRelativeUrl(sourceurl));
    trackAbsolute(trackingUrl, '-');

  }

  else {
    return true;
  }
}

function trackPage(url) {
  if (confTrackingEnabled) {
    trackAbsolute(url,'-');
  }
}

function trackRelative(objectReference,objectTitle,keepLastReferrer){
  thisFolder = self.location.pathname.substring(0,self.location.pathname.lastIndexOf('/')+1);
  path = thisFolder + objectReference;
  dcsMultiTrack('DCS.dcsuri',path,'WT.ti',objectTitle);
}