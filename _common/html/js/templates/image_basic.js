infoState = 0;
legalDisclaimerState = 0;

function toggleInfo(order) {
  if (infoState == 0) {
    if(legalDisclaimerState == 1){
      legalDisclaimerState = 0;
      setVisibility('legalDisclaimer',0);
    }
    infoState = 1;
    setVisibility('info',1);
    switchImage('infoImg',1);
  }
  else if(infoState == 1 || order == 1){
    infoState = 0;
    setVisibility('info',0);
    switchImage('infoImg',0);
  }
}

function toggleLegalDisclaimer(order) {
  if (legalDisclaimerState == 0) {
    if(infoState == 1){
      infoState = 0;
      setVisibility('info',0);
      switchImage('infoImg',0);
    }
    legalDisclaimerState = 1;
    setVisibility('legalDisclaimer',1);
  }
  else if(legalDisclaimerState == 1 || order == 1){
    legalDisclaimerState = 0;
    setVisibility('legalDisclaimer',0);
  }
}

function selectBoxNotify(formField,formFieldValue) {
  if(formFieldValue.indexOf('http://') != -1 || formFieldValue.indexOf('https://') != -1) {
    window.open(formFieldValue,"_blank");
    trackExternalLink(formFieldValue);
  }
  else if(formFieldValue != "") {
    location.href = getFullPath(window.location.href,formFieldValue);
  }
}