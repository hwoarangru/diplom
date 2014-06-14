function setBorder(object,id,active) {
    activeImage = "";
    var borderName = "";


    if(id != false) {
      contentId = id;
    }

    if(active == true) {
      showContent(contentId);
      borderName = "activeborder"
      borderObject = document.getElementById(borderName).style;
      borderObject.top = object.offsetTop;
      borderObject.left = object.offsetLeft;
    }
    else {
      borderName = "mouseoverborder"
      borderObject = document.getElementById(borderName).style;
      borderObject.top = object.offsetTop-3;
      borderObject.left = object.offsetLeft-3;
    }
    borderObject.visibility = "visible";
  }

  function dropBorder(id) {
    document.getElementById(id).style.visibility = "hidden";
  }

  function showContent(id) {
    document.getElementById("startLayer").style.visibility = "hidden";

    for (i=1; i<contentCounter+1; i++) {
      if(id==i) {
        document.getElementById("content" + i).style.visibility = "visible";
        if(document.getElementById("image" + i)) {
          document.getElementById("image" + i).style.visibility = "visible";
        }
      }
      else {
        document.getElementById("content" + i).style.visibility = "hidden";
        if(document.getElementById("image" + i)) {
          document.getElementById("image" + i).style.visibility = "hidden";
        }
      }
    }
  }

  function closeLayer() {
    showContent(0);
    document.getElementById("activeborder").style.visibility = "hidden";
    document.getElementById("startLayer").style.visibility = "visible";
  }


  function checkHeadlines() {
    for (i=1; i<contentCounter+1; i++) {
      if(getDivInformation("headline"+i,"height") > 30 && getDivInformation("headline"+i,"height") < 40) {
        resizeLayer("copxtext"+i, false, getDivInformation("copxtext"+i,"height") - 12);
      }
      else if (getDivInformation("headline"+i,"height") > 40) {
        resizeLayer("copxtext"+i, false, getDivInformation("copxtext"+i,"height") - 24);
      }
    }
  }