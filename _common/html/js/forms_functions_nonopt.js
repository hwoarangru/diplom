  selectBoxes = new Array();
  directOrder = new Array();
  function selectBoxNotify(formField) {
   ;
  }
   function setOption(text, value, formField, notify, index, formName) {
    formFieldValue = value;
    activeText = text;
    setVisibility('selectBoxContent'+formField,0,'none');
    writeIntoLayer('selectedValue'+formField, "&nbsp; " + text);

    if(formName != 'none') {
      if(typeof formName != 'undefined' && formName!=null && formName!=""){
        if(document.forms.length > 0) {
          document.forms[formName][formField].value = formFieldValue;
        }
      }else{
        if(document.forms.length > 0) {
          document.forms[0][formField].value = formFieldValue;
        }
      }
    }

    if(notify) {
      selectBoxNotify(formField,formFieldValue,index);
    }
  }
  function writeSelectBox(formField, keyValueArray, zIndex, elementWidth, visibleEntries, selectedValue, notify, error, readonly, direction, sublayerwidth) {
    var formValue = "";
    entryFound = false;
    var bgcolorBorder  = "#003399";
    var bgcolorBorder1 = "#FF6600";
    var borderGif      = p003399Gif;
    var pulldownImage  = pulldownGif;
    if(error == true) {
      bgcolorBorder = "#ff0000";
      pulldownImage = pulldownErrorGif;
      borderGif     = pff0000Gif;
    }
    for(i=0;i<keyValueArray.length;i++) {
      if(keyValueArray[i+1] == selectedValue) {
        selectText = keyValueArray[i];
        formValue  = keyValueArray[i+1];
        entryFound = true;
        break;
      }
      i++;
    }
    if(!entryFound) {
      selectText = keyValueArray[0];
      formValue  = keyValueArray[1];
    }
    selectBoxes.push(formField);
    directOrder[formField]=false;
    tdWidth = elementWidth-20;
    if(visibleEntries > (keyValueArray.length / 2)) {
      visibleEntries = (keyValueArray.length / 2);
    }
    deep = (visibleEntries * 16) + 14;
    selectBox = '';
    if (readonly == true) {
      selectBox += '<input type="text" class="defaultReadonly" readonly="readonly" value="' + selectText + '">';
      selectBox += '<input type="hidden" name="' + formField + '" value="' + formValue + '">';
    } else {
      if(ua.indexOf("opera")!= -1){
        selectBox += '<div style="position:static;z-index:' + zIndex +';">'; // 1
      }else{
        selectBox += '<div style="position:relative;z-index:' + zIndex +';">';
      }
      selectBox += '<table width="' + elementWidth + '" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff">';
      selectBox += '<colgroup><col width="1"><col width="' + tdWidth + '"><col width="18"><col width="1"></colgroup>';
      selectBox += '<tr><td colspan="4" bgcolor="' + bgcolorBorder + '"><img src="' + borderGif + '" width="' + elementWidth +'" height="1"></td></tr>';
      selectBox += '<tr>';
      selectBox += '<td bgcolor="' + bgcolorBorder + '"><img src="' + borderGif + '" width="1" height="16"></td>';
      selectBox += '<td valign="middle" onClick="setVisibility(\'selectBoxContent' + formField + '\');" onMouseover="directOrder[\'' + formField + '\']=true;" onMouseout="directOrder[\'' + formField + '\']=false;" style="cursor:pointer;"><span id="selectedValue' + formField + '">&nbsp; ' + selectText + '</span></td>';
      selectBox += '<td><a href="javascript:setVisibility(\'selectBoxContent' + formField + '\');" onMouseover="directOrder[\'' + formField + '\']=true;" onMouseout="directOrder[\'' + formField + '\']=false;"><img src="' + pulldownImage + '" width="18" height="16" border="0"></a></td>';
      selectBox += '<td  bgcolor="' + bgcolorBorder + '"><img src="' + borderGif + '" width="1" height="16"></td>';
      selectBox += '</tr>';
      selectBox += '<tr><td colspan="4" bgcolor="' + bgcolorBorder + '"><img src="' + borderGif + '" width="' + elementWidth + '" height="1"></td></tr>';
      selectBox += '</table>';
      if (sublayerwidth) {
        if(direction == "above"){
    			selectBox += '<div id="selectBoxContent' + formField + '" class="selectBoxContent" style="width:'+ sublayerwidth +'; top:' + -(deep+1) + 'px;" >';
        } else {
        	selectBox += '<div id="selectBoxContent' + formField + '" class="selectBoxContent" style="width:'+ sublayerwidth +'; border-top:1px solid '+ bgcolorBorder +'; top:17px;">';
        }
        selectBox += '<table width="' + sublayerwidth + '" cellspacing="0" cellpadding="0" border="0">';
      } else {
        if(direction == "above"){
    			selectBox += '<div id="selectBoxContent' + formField + '" class="selectBoxContent" style="top:' + -(deep+1) + 'px;" >';
        } else {
        	selectBox += '<div id="selectBoxContent' + formField + '" class="selectBoxContent">';
        }
        selectBox += '<table width="' + elementWidth + '" cellspacing="0" cellpadding="0" border="0">';
      }
      if(direction == "above"){
        if (sublayerwidth) {
          selectBox += '<tr><td colspan="3" bgcolor="' + bgcolorBorder + '"><img src="' + borderGif + '" width="' + sublayerwidth + '" height="1"></td></tr>';
        } else {
          selectBox += '<tr><td colspan="3" bgcolor="' + bgcolorBorder + '"><img src="' + borderGif + '" width="' + elementWidth + '" height="1"></td></tr>';
        }
      }
      selectBox += '<tr>';
      selectBox += '<td width="1" bgcolor="' + bgcolorBorder + '"><img src="' + transGif + '" width="1" height="1"></td>';
      selectBox += '<td width="' + (tdWidth-2) + '" valign="top">';
      if (sublayerwidth) {
        selectBox += '<div style="width:' + (sublayerwidth-2) + 'px; height:' + deep + 'px; background-color:#ffffff; overflow:auto;">';
      }
      else {
        selectBox += '<div style="width:' + (elementWidth-2) + 'px; height:' + deep + 'px; background-color:#ffffff; overflow:auto;">';
      }
      selectBox += '<span id="vSpace" style="padding-bottom:7px;"></span>';
      for(i=0;i<keyValueArray.length;i++) {
        keyValueArray[i+1] = keyValueArray[i+1].replace(/'/g,"\\\'");
        var tempValue = keyValueArray[i].replace(/'/g,"\\\'");
        selectBox += '<a href="javascript:setOption(\'' + tempValue + '\',\'' + keyValueArray[i+1] + '\',\'' + formField + '\',' + notify + ',' + zIndex +');" class="selectboxEntry">&nbsp; ' + keyValueArray[i] + '</a>';
        i++;
      }
      selectBox += '</div>';
      selectBox += '</td>';
      selectBox += '<td width="1" bgcolor="' + bgcolorBorder + '"><img src="' + transGif + '" width="1" height="1"></td>';
      selectBox += '</tr>';
      if (sublayerwidth) {
        selectBox += '<tr><td colspan="3" bgcolor="' + bgcolorBorder + '"><img src="' + borderGif + '" width="' + sublayerwidth + '" height="1"></td></tr>';
      }
      else {
        selectBox += '<tr><td colspan="3" bgcolor="' + bgcolorBorder + '"><img src="' + borderGif + '" width="' + elementWidth + '" height="1"></td></tr>';
      }
      selectBox += '</table>';
      selectBox += '</div>';
      selectBox += '</div>';
      selectBox += '<div style="width:2px;height:2px;overflow:hidden;"></div>';
      selectBox += '<input type="hidden" name="' + formField + '" value="' + formValue + '">';
    }
    return selectBox;
  }
  function checkSelectBoxStatus() {
    for(j=0;j<selectBoxes.length;j++) {
      if(!directOrder[selectBoxes[j]]) {
        setVisibility('selectBoxContent'+selectBoxes[j],0,'none');
      }
    }
  }
  var scriptedCheckbox = "";
  function writeCheckbox(formField, description, boxInputValue, boxInputName, boxIndex, zIndex, elementWidth, notify, error, className, mandatory, readonly) {
    var currentGifDefault;
    var currentGifSwitch;
    var currentTextStyle  = "padding-left:23px;";
    var mandatoryStyle;
    if (boxInputValue     != "true") {
      currentGifDefault   = checkboxGif;
      currentGifSwitch    = checkboxGifHigh;
      if (error) {
        currentGifDefault = checkboxErrorGif;
        currentGifSwitch  = checkboxErrorGifHigh;
        currentTextStyle  = "padding-left:23px;color:#ff0000;";
      }
      if (readonly) {
        currentGifDefault = checkboxDisabledGif;
        currentGifSwitch  = checkboxDisabledGifHigh;
        currentTextStyle  = "padding-left:23px;color:#333333;";
        checkReadOnly.push(formField);
      } else {
        for (i = 0; i < checkReadOnly.length; i++) {
          if (checkReadOnly[i] == formField) {
            checkReadOnly.slice(i,1);
          }
        }
      }
    } else {
      currentGifDefault   = checkboxGifHigh;
      currentGifSwitch    = checkboxGif;
      if (error) {
        currentGifDefault = checkboxErrorGifHigh;
        currentGifSwitch  = checkboxErrorGif;
        currentTextStyle  = "padding-left:23px;color:#ff0000;";
      }
      if (readonly) {
        currentGifDefault = checkboxDisabledGifHigh;
        currentGifSwitch  = checkboxDisabledGif;
        currentTextStyle  = "padding-left:23px;color:#333333;";
        checkReadOnly.push(formField);
      } else {
        for (i = 0; i < checkReadOnly.length; i++) {
          if (checkReadOnly[i] == formField) {
            checkReadOnly.slice(i,1);
          }
        }
      }
    }
    if (mandatory) {
      mandatoryStyle = "display:inline;";
    } else {
      mandatoryStyle = "display:none;";
    }
    description = description.replace(/\n/g,'<br><br>');
    checkClient();
    if (browserId=='Safari') {
      var descriptionWidth = elementWidth - 19;
      scriptedCheckbox =  '<span id="vSpace" class="formOffset2"></span><br>'
                     +  '<div class="'+ className +'" style="position:relative; display: inline; width:' + elementWidth + 'px; height:auto; z-index:' + zIndex + ';">'
                     +    '<div style="position:absolute; display:inline; top:13px; left:0; width:23px;"><img src="' + currentGifDefault + '" vspace="1" style="cursor:pointer;" id="checkboxImage'+boxIndex+'" preload="' + currentGifSwitch + '" onClick="setCheckbox(this,\''+formField+'\',\''+boxInputName+'\');"></div>'
                     +    '<div style="display:inline;float:left;"><div style="'+currentTextStyle+';display: block;width:'+descriptionWidth+'px;">'
                     +      description
                     +    '<span id="mandatory_'+formField+'" style="'+mandatoryStyle+'">*</span></div></div>'
                     +    '<input type="hidden" name="' + boxInputName + '" value="'+boxInputValue+'">'
                     +  '</div>';
    }else{
      var descriptionWidth = elementWidth - 19;
      scriptedCheckbox =  '<span id="vSpace" class="formOffset2"></span><br>'
                     +  '<div class="'+ className +'" style="position:relative; display: inline; width:' + elementWidth + 'px; height:auto; z-index:' + zIndex + ';">'
                     +    '<div style="display:inline;"><div style="'+currentTextStyle+';display: block;width:'+descriptionWidth+'px;">'
                     +      description
                     +    '<span id="mandatory_'+formField+'" style="'+mandatoryStyle+'">*</span></div></div>'
                     +    '<div style="position:absolute; top:0; left:0; width:23px;"><img src="' + currentGifDefault + '" vspace="1" style="cursor:pointer;" id="checkboxImage'+boxIndex+'" preload="' + currentGifSwitch + '" onClick="setCheckbox(this,\''+formField+'\',\''+boxInputName+'\');"></div>'
                     +    '<input type="hidden" name="' + boxInputName + '" value="'+boxInputValue+'">'
                     +  '</div>';
    }
    return scriptedCheckbox;
  }
  var allowSend = true;
  function handleSubmit(cValue) {
   if (allowSend == true) {
     allowSend = false;
     if(cValue) {
       document.forms[0].elements['action'].value = cValue;
     }
     document.forms[0].submit();
   }
   return false;
  }
  function writeButton (formId, formName, className, currentValue, label) {
    var scriptedButton = '<a href="#" onclick="return handleSubmit(\'' + currentValue + '\')" id="defaultAnchorButton">'+label+'</a>';
    return scriptedButton;
  }
