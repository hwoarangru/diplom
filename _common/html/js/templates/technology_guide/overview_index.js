function getArraySums(Array1,Array2,Array3){
  Array1Sum = 0;
  Array2Sum = 0;
  Array3Sum = 0;
  Array1Counter = 0;
  Array2Counter = 0;
  Array3Counter = 0;
  for(i=0;i<Array1.length;i++){
    if(Array1[i][6]!=""){
      writeIntoLayer("hiddenlayersmall",Array1[i][1]);
      Array1Sum = Array1Sum+(getDivInformation("hiddenlayersmall","height")/14);
    }else{
      writeIntoLayer("hiddenlayer",Array1[i][1]);
      Array1Sum = Array1Sum+(getDivInformation("hiddenlayer","height")/12);
    }
    Array1Counter = Array1Counter+1;
  }
  for(i=0;i<Array2.length;i++){
    if(Array2[i][6]!=""){
      writeIntoLayer("hiddenlayersmall",Array2[i][1]);
      Array2Sum = Array2Sum+(getDivInformation("hiddenlayersmall","height")/14);
    }else{
      writeIntoLayer("hiddenlayer",Array2[i][1]);
      Array2Sum = Array2Sum+(getDivInformation("hiddenlayer","height")/12);
    }
    Array2Counter = Array2Counter+1;
  }
  for(i=0;i<Array3.length;i++){
    if(Array3[i][6]!=""){
      writeIntoLayer("hiddenlayersmall",Array3[i][1]);
      Array3Sum = Array3Sum+(getDivInformation("hiddenlayersmall","height")/14);
    }else{
      writeIntoLayer("hiddenlayer",Array3[i][1]);
      Array3Sum = Array3Sum+(getDivInformation("hiddenlayer","height")/12);
    }
    Array3Counter = Array3Counter+1;
  }
}

function writeModelLayerContent(highlight) {
     var relatedModels = new Array();
     modelCounter = 0;
     for(i=0;i<TLmodelMatching.length;i++) {
      if(query["code"] == TLmodels[TLmodelMatching[i]][0]&& TLmodels[TLmodelMatching[i]][1]!=""){
         relatedModels[modelCounter] = new Array();
         relatedModels[modelCounter][0] = TLmodels[TLmodelMatching[i]][1];
         relatedModels[modelCounter][1] = TLmodels[TLmodelMatching[i]][2];
         relatedModels[modelCounter][2] = TLmodels[TLmodelMatching[i]][3];
         relatedModels[modelCounter][3] = TLmodelMatching[i];
         modelCounter++;
      }   
    }

    var HTMLCode = "";
    for(i=0; i<relatedModels.length; i++) {
      if(relatedModels[i][1]!=""){
      if(relatedModels[i][3]==highlight||(highlight=="" && i==0)){
        HTMLCode+='<a href="javascript:parseContent(\'models\',\''+relatedModels[i][3]+'\',\''+i+'\')" class="menu linkHighlight"><img src="../../../img/palette/1x1_trans.gif" class="arrow linkHighlight">' + relatedModels[i][0] + '</a>';
      }else{
        HTMLCode+='<a href="javascript:parseContent(\'models\',\''+relatedModels[i][3]+'\',\''+i+'\')" class="menu"><img src="../../../img/palette/1x1_trans.gif" class="arrow">' + relatedModels[i][0] + '</a>';
      }
      }
    }
    writeIntoLayer("modelNavi",HTMLCode);
   }
   
 function parseContent(contentTp,cID,arr){

  var pgContent = "";
  var categories = new Array();
  var arrayLayer1 = new Array();
  var arrayLayer2 = new Array();
  var arrayLayer3 = new Array();
  var categLetter = new Array();

  if(contentTp=="categories"){
    for(i=0; i < TLdatabase.length; i++){
      for(a=0; a < TLdatabase[i][3].length; a++){
        if(TLdatabase[i][3][a]==cID){
          if(!categLetter[TLdatabase[i][0]]){
            categLetter[TLdatabase[i][0]] = new Array();
          }
          categories.push(TLdatabase[i]);
        }
      }
   }
  }else if(contentTp=="models"){
    var relModels = new Array();
    modCounter = 0;
     for(i=0;i<TLmodelMatching.length;i++) {
      if(codeid == TLmodels[TLmodelMatching[i]][0] && TLmodels[TLmodelMatching[i]][1]!=""){
         relModels[modCounter] = new Array();
         relModels[modCounter][0] = TLmodels[TLmodelMatching[i]][1];
         relModels[modCounter][1] = TLmodels[TLmodelMatching[i]][2];
         relModels[modCounter][2] = TLmodels[TLmodelMatching[i]][3];
         relModels[modCounter][3] = TLmodelMatching[i];
         modCounter++;
      }   
    }


    if(arr=="" || !arr){
      actualCar = relModels[0][3];
    }else{
      actualCar =  relModels[arr][3];
    }

    for(i=0; i < TLdatabase.length; i++){
      for(a=0; a < TLdatabase[i][2].length; a++){
        if(TLdatabase[i][2][a]==actualCar){
          if(!categLetter[TLdatabase[i][0]]){
            categLetter[TLdatabase[i][0]] = new Array();
          }
          categories.push(TLdatabase[i]);
        }
      }
    }

  }else if(contentTp=="index"){
    for(i=0; i< TLindexList.length; i++){
      var currentGroup;
      if(TLindexList[i][1]==cID){
        currentGroup = TLindexList[i][0];
      }
    }

    for(a=0; a < TLdatabase.length; a++){
      if((TLdatabase[a][0]==cID)){
        categories.push(TLdatabase[a]);
          for(i=0; i < TLdatabase.length; i++){
            if(TLdatabase[a][6]!="" && (TLdatabase[a][6]==TLdatabase[i][5])){
              categories.push(TLdatabase[i]);
            }
         }
      }
    }
  }

  if(contentTp=="index"){
    function random2(n){
      return Math.floor((n+1)*Math.random())
    }

    if(TLindexImages[random2(TLindexImages.length)]){
      var zufallsurl = TLindexImages[random2(TLindexImages.length)];
    }
    pgContent+="<div id=\"mood\"><img src=\""+zufallsurl+"\" height=\"\" width=\"\" border=\"0\"></div>";

  }else if (contentTp=="models"){
     pgContent+="<div id=\"mood\"><img src=\""+TLmodels[actualCar][4]+"\" height=\"\" width=\"\" border=\"0\"></div>";
  }else if (contentTp=="categories"){
     pgContent+="<div id=\"mood\"><img src=\""+TLcategoriesImages[cID]+"\" height=\"\" width=\"\" border=\"0\"></div>";
  }

  if(contentTp=="models"||contentTp=="categories"||contentTp=="index"){
    if(categories.length >=0){
      pgContent+="<div id=\"indexRubricBox\">";
      pgContent+="<div id=\"modelNavi\" class=\"modelNavigation\"></div>";
      if(contentTp=="models"){
        pgContent+="<div id=\"indexRubricBoxHeadline\"><h2>"+TLmodels[actualCar][3]+"</h2></div>";
      }else if(contentTp=="categories"){
        pgContent+="<div id=\"indexRubricBoxHeadline\"><h2>"+TLrubricHeadline+" "+TLcategoriesList[cID]+"</h2></div>";
      }else if(contentTp=="index"){
        pgContent+="<div id=\"indexRubricBoxHeadline\"><h2>"+TLindexHeadline+" "+currentGroup+"</h2></div>";
      }
    }else{
      pgContent+="<div id=\"indexRubricBox\">";
      pgContent+="<div id=\"modelNavi\" class=\"modelNavigation\"></div>";
      if(contentTp=="models"){
        pgContent+="<div id=\"indexRubricBoxHeadline\"><h2>"+TLmodels[actualCar][3]+"</h2></div>";
      }else if(contentTp=="categories"){
        pgContent+="<div id=\"indexRubricBoxHeadline\"><h2>"+TLrubricHeadline+" "+TLcategoriesList[cID]+"</h2></div>";
      }else if(contentTp=="index"){
        pgContent+="<div id=\"indexRubricBoxHeadline\"><h2>"+TLindexHeadline+" "+currentGroup+"</h2></div>";
      }
      pgContent+="Zu diesem Buchstaben wurden keine Eintraege gefunden";
    }
  }

  if(contentTp=="models"||contentTp=="categories"){
    var helpLetter ="";
    for(a=0; a < categories.length; a++){
      var helpNr = a-1;
      if(helpNr>=0){
        if (categories[a][0]==categories[helpNr][0]){
          categLetter[categories[a][0]].push(categories[a]);
          for(i=0; i < TLdatabase.length; i++){
            if((categories[a][6]!="")&&(categories[a][6]==TLdatabase[i][5])){
              categLetter[categories[a][0]].push(TLdatabase[i]);
            }
          }
        }else{
          categLetter[categories[a][0]].push(categories[a]);
          for(i=0; i < TLdatabase.length; i++){
            if((categories[a][6]!="")&&(categories[a][6]==TLdatabase[i][5])){
              categLetter[categories[a][0]].push(TLdatabase[i]);
            }
          }
        }
      }else{
        categLetter[categories[a][0]].push(categories[a]);
        for(i=0; i < TLdatabase.length; i++){
          if((categories[a][6]!="")&&(categories[a][6]==TLdatabase[i][5])){
            categLetter[categories[a][0]].push(TLdatabase[i]);
          }
        }
      }
    }

    for (i=0; i < TLindexList.length;i++){
      if(categLetter[TLindexList[i][1]]){
        var helpSw = categLetter[TLindexList[i][1]].length/3;
        arrayLayer1[TLindexList[i][1]]=new Array();
        arrayLayer2[TLindexList[i][1]]=new Array();
        arrayLayer3[TLindexList[i][1]]=new Array();
        for (a=0; a < categLetter[TLindexList[i][1]].length; a++){
          if(a < (helpSw)){
            arrayLayer1[TLindexList[i][1]].push(categLetter[TLindexList[i][1]][a]);
          }else if(a < (helpSw*2)){
            arrayLayer2[TLindexList[i][1]].push(categLetter[TLindexList[i][1]][a]);
          }else if(a < (helpSw*3)){
            arrayLayer3[TLindexList[i][1]].push(categLetter[TLindexList[i][1]][a]);
          }
        }
      }
    }

  function getItEven (Array1,Array2,Array3,counter,helpKey,imgLine) {
    try {
      if (((Array1Sum >= Array2Sum)&& (Array2Sum >= Array3Sum))||(counter == 100)){
        throw "richtig";
      } else {
        if(Array1Sum < Array2Sum){
          if((Array2.length > 0 &&(Array1.length < Array2.length))||Array1.length==0){
            if((Array1[1] &&Array2[1][6]!="")){
              Array1.push(Array2[0]);
              Array1.push(Array2[1]);
              Array2.splice(0,2);
            }else if((Array2[0] &&Array2[0][6]=="")){
              Array1.push(Array2[0]);
              Array2.splice(0,1);

            if(Array2.length<=1 && Array2[0][6]=="" ){
              Array1.push(Array2[0]);
              Array2.splice(0,1);
            }

            }
          }
        }else if(Array2Sum < Array3Sum){

          if((Array3[1] &&Array3[1][6]!="")){
            Array2.push(Array3[0]);
            Array2.push(Array3[1]);
            Array3.splice(0,2);
          }else if((Array3[0] &&Array3[0][6]=="")){
            Array2.push(Array3[0]);
            Array3.splice(0,1);


          if(Array3.length<=1 && Array3[0][6]=="" ){
            Array2.push(Array3[0]);
            Array3.splice(0,1);
          }

          }
        }
        throw "falsch";
      }
    } catch (e) {
      if (e == "richtig") {
        if(Array1.length > 0||Array2.length > 0||Array3.length > 0){
          pgContent+="<div id=\"indexRubricRow\">";
          pgContent+="<h2>"+TLindexList[helpKey][0]+"</h2>";

         if(Array1.length > 0){
           pgContent+="<div id=\"indexRubricColumnEntry\"><ul class=\"indexRubric\">";
          for (i=0; i < Array1.length; i++){
          help = (i-1);
              if(Array1[i][6]!=""){
                  pgContent+="<li class=\"synonymTextLi\"><span class=\"synonymText\">"+Array1[i][1]+" "+ TLsynonymText +"</span></li>";
                }else{
                  if(Array1[help]&&Array1[help][6]!=""){
                    pgContent+="<li class=\"synonym\">";
                    pgContent+="<ul class=\"indexRubricSynonym\">";
                    pgContent+="<li><a href=\""+ buildValidServerRelativeUrl(Array1[i][4]) + "?source=" + contentTp +"&article="+getFileName(Array1[i][4])+"\"><img src=\"http://wcms10.bmwgroup.com/bmw_edit/_common/html/img/palette/1x1_trans.gif\" alt=\"\" class=\"arrow\">"+Array1[i][1]+"</a></li></ul></li>";
                  }else{
                    pgContent+="<li><a href=\""+ buildValidServerRelativeUrl(Array1[i][4]) + "?source=" + contentTp +"&article="+getFileName(Array1[i][4])+"\"><img src=\"http://wcms10.bmwgroup.com/bmw_edit/_common/html/img/palette/1x1_trans.gif\" alt=\"\" class=\"arrow\">"+Array1[i][1]+"</a></li>";
                  }
              }
            }
            pgContent+="</ul></div>";
          }
          if(Array1.length > 0){
            pgContent+="<div id=\"indexRubricColumnEntry\">";
            if(Array2.length > 0){
              pgContent+="<ul class=\"indexRubric\">";
              for (i=0; i < Array2.length; i++){
                help = (i-1);
                 if(Array2[i][6]!=""){
                    pgContent+="<li class=\"synonymTextLi\"><span class=\"synonymText\">"+Array2[i][1]+" "+ TLsynonymText +"</span></li>";
                  }else{
                    if(Array2[help]&&Array2[help][6]!=""){
                      pgContent+="<li class=\"synonym\">";
                      pgContent+="<ul class=\"indexRubricSynonym\">";
                      pgContent+="<li><a href=\""+ buildValidServerRelativeUrl(Array2[i][4]) + "?source=" + contentTp +"&article="+getFileName(Array2[i][4])+"\"><img src=\"http://wcms10.bmwgroup.com/bmw_edit/_common/html/img/palette/1x1_trans.gif\" alt=\"\" class=\"arrow\">"+Array2[i][1]+"</a></li></ul></li>";

                    }else{
                      pgContent+="<li><a href=\""+ buildValidServerRelativeUrl(Array2[i][4]) + "?source=" + contentTp +"&article="+getFileName(Array2[i][4])+"\"><img src=\"http://wcms10.bmwgroup.com/bmw_edit/_common/html/img/palette/1x1_trans.gif\" alt=\"\" class=\"arrow\">"+Array2[i][1]+"</a></li>";
                    }
                }
              }
              pgContent+="</ul>";
            }
            pgContent+="</div>";
          }


          if(Array1.length > 0){
            pgContent+="<div id=\"indexRubricColumnEntry\">";
            if(Array3.length > 0){
              pgContent+="<ul class=\"indexRubric\">";
              for (i=0; i < Array3.length; i++){
                help = (i-1);
                    if(Array3[i][6]!=""){
                    pgContent+="<li class=\"synonymTextLi\"><span class=\"synonymText\">"+Array3[i][1]+" "+ TLsynonymText +"</span></li>";
                  }else{
                    if(Array3[help]&&Array3[help][6]!=""){
                      pgContent+="<li class=\"synonym\">";
                      pgContent+="<ul class=\"indexRubricSynonym\">";
                      pgContent+="<li><a href=\""+ buildValidServerRelativeUrl(Array3[i][4]) + "?source=" + contentTp +"&article="+getFileName(Array3[i][4])+"\"><img src=\"http://wcms10.bmwgroup.com/bmw_edit/_common/html/img/palette/1x1_trans.gif\" alt=\"\" class=\"arrow\">"+Array3[i][1]+"</a></li></ul></li>";
                    }else{
                      pgContent+="<li><a href=\""+ buildValidServerRelativeUrl(Array3[i][4]) + "?source=" + contentTp +"&article="+getFileName(Array3[i][4])+"\"><img src=\"http://wcms10.bmwgroup.com/bmw_edit/_common/html/img/palette/1x1_trans.gif\" alt=\"\" class=\"arrow\">"+Array3[i][1]+"</a></li>";
                    }
                  }
             }
             pgContent+="</ul>";
           }
           pgContent+="</div>";
         }

           pgContent+=" </div>";
           if(imgLine=="y"){
              pgContent+="<div id=\"imgLine\">";
              pgContent+="<img src=\"http://wcms10.bmwgroup.com/bmw_edit/_common/html/img/palette/1x1_afafaf.gif\" alt=\"\" width=\"662\" height=\"1\"><br>";
            }
            if(contentType=="models" && imgLine=="n"){
              pgContent+="<div id=\"imgLine\">";
              pgContent+="<img src=\"http://wcms10.bmwgroup.com/bmw_edit/_common/html/img/palette/1x1_trans.gif\" alt=\"\" width=\"662\" height=\"1\"><br></div>";
              pgContent+="<div class=\"footNote\">"+TLseriesDisclaimer+"</div>";
            } else if(imgLine=="n"){
              pgContent+="<div style=\"height:7px;overflow:hidden;clear:both;\"></div>";

             }
            pgContent+="</div>";
          }
      return;
    } else{
      counter++;
      getArraySums(Array1,Array2,Array3);
      getItEven(Array1,Array2,Array3,counter,helpKey,imgLine);
      return;
    }
  } finally {
  }
counter++;
}

      for (l=0; l < TLindexList.length;l++){
        if(arrayLayer1[TLindexList[l][1]]||arrayLayer2[TLindexList[l][1]]||arrayLayer3[TLindexList[l][1]]){
          if(l < (arrayLayer1.length-1)){imgLine = "y"; }else{imgLine = "n";}
          getArraySums(arrayLayer1[TLindexList[l][1]],arrayLayer2[TLindexList[l][1]],arrayLayer3[TLindexList[l][1]]);
          getItEven(arrayLayer1[TLindexList[l][1]],arrayLayer2[TLindexList[l][1]],arrayLayer3[TLindexList[l][1]],0,l,imgLine);
        }
      }

  }else if(contentTp=="index"){

        var helpSw = categories.length/3;
        for (a=0; a < categories.length; a++){
          if(a<helpSw){
            arrayLayer1.push(categories[a]);
          }else if(a<(helpSw*2)){
            arrayLayer2.push(categories[a]);
          }else if(a<(helpSw*3)){
            arrayLayer3.push(categories[a]);
          }
        }

  if(arrayLayer1.length > 0 && arrayLayer1[arrayLayer1.length-1][6]!=""){
    arrayLayer1.push(arrayLayer2[0]);
    arrayLayer2.splice(0,1);
  }

  if(arrayLayer2.length > 0 && arrayLayer2[arrayLayer2.length-1][6]!=""){
    arrayLayer2.push(arrayLayer3[0]);
    arrayLayer3.splice(0,1);
  }

function getItEvenIndex (Array1,Array2,Array3,counter) {
  try {
    if (((Array1Sum >= Array2Sum)&& (Array2Sum >= Array3Sum))||(counter == TLindexList.length)){
      throw "richtig";
    } else {
      if(Array1Sum < Array2Sum){

        if((Array2.length > 0 &&(Array1.length < Array2.length))||Array1.length==0){
          if((Array1[1] &&Array2[1][6]!="")){
            Array1.push(Array2[0]);
            Array1.push(Array2[1]);
            Array2.splice(0,2);
          }else if((Array2[0] && Array2[0][6]=="")){
            Array1.push(Array2[0]);
            Array2.splice(0,1);


            if(Array2.length<=1 && Array2[0][6]=="" ){
              Array1.push(Array2[0]);
              Array2.splice(0,1);
            }
          }

        }

      }else if(Array2Sum < Array3Sum){

        if((Array3[1] &&Array3[1][6]!="")){
          Array2.push(Array3[0]);
          Array2.push(Array3[1]);
          Array3.splice(0,2);
        }else if((Array3[0] &&Array3[0][6]=="")){
          Array2.push(Array3[0]);
          Array3.splice(0,1);


            if(Array3.length<=1 && Array3[0][6]=="" ){
              Array2.push(Array3[0]);
              Array3.splice(0,1);
            }
        }
      }

        if(Array2.length>1 && Array2[0][6]=="" && Array1[Array1.length-1][6]!=""){
            Array1.push(Array2[0]);
            Array2.splice(0,1);
          }
          if(Array3.length>1 && Array3[0][6]=="" && Array2[Array2.length-1][6]!=""){
            Array2.push(Array3[0]);
            Array3.splice(0,1);
          }

      throw "falsch";
    }
  } catch (e) {
    if (e == "richtig") {
      if(Array1.length > 0){
          pgContent+="<div id=\"indexRubricRow\">";
          pgContent+="<div id=\"indexRubricColumnEntry\">";
          pgContent+="<ul class=\"indexRubric\">";
          for (i=0; i < Array1.length; i++){
            help = (i-1);
            if(Array1[i][6]!=""){
              pgContent+="<li class=\"synonymTextLi\"><span class=\"synonymText\">"+Array1[i][1]+" "+ TLsynonymText +"</span></li>";
            }else{
              if(Array1[help]&&Array1[help][6]!=""){
                pgContent+="<li class=\"synonym\">";
                pgContent+="<ul class=\"indexRubricSynonym\">";
                pgContent+="<li><a href=\""+ buildValidServerRelativeUrl(Array1[i][4]) + "?source=" + contentTp +"&article="+getFileName(Array1[i][4])+"\"><img src=\"http://wcms10.bmwgroup.com/bmw_edit/_common/html/img/palette/1x1_trans.gif\" alt=\"\" class=\"arrow\">"+Array1[i][1]+"</a></li></ul></li>";
              }else{
                pgContent+="<li><a href=\""+ buildValidServerRelativeUrl(Array1[i][4]) + "?source=" + contentTp +"&article="+getFileName(Array1[i][4])+"\"><img src=\"http://wcms10.bmwgroup.com/bmw_edit/_common/html/img/palette/1x1_trans.gif\" alt=\"\" class=\"arrow\">"+Array1[i][1]+"</a></li>";
              }
            }
          }
          pgContent+="</ul><br></div>";
        }
        if(Array1.length > 0){
          pgContent+="<div id=\"indexRubricColumnEntry\">";
          if(Array2.length > 0){
            pgContent+="<ul class=\"indexRubric\">";
            for (i=0; i < Array2.length; i++){
              help = (i-1);
              if(Array2[i][6]!=""){
                pgContent+="<li class=\"synonymTextLi\"><span class=\"synonymText\">"+Array2[i][1]+" "+ TLsynonymText +"</span></li>";
              }else{
                if(Array2[help]&&Array2[help][6]!=""){
                  pgContent+="<li class=\"synonym\">";
                  pgContent+="<ul class=\"indexRubricSynonym\">";
                  pgContent+="<li><a href=\""+ buildValidServerRelativeUrl(Array2[i][4]) + "?source=" + contentTp +"&article="+getFileName(Array2[i][4])+"\"><img src=\"http://wcms10.bmwgroup.com/bmw_edit/_common/html/img/palette/1x1_trans.gif\" alt=\"\" class=\"arrow\">"+Array2[i][1]+"</a></li></ul></li>";
                }else{
                  pgContent+="<li><a href=\""+ buildValidServerRelativeUrl(Array2[i][4]) + "?source=" + contentTp +"&article="+getFileName(Array2[i][4])+"\"><img src=\"http://wcms10.bmwgroup.com/bmw_edit/_common/html/img/palette/1x1_trans.gif\" alt=\"\" class=\"arrow\">"+Array2[i][1]+"</a></li>";
                }
              }
            }
            pgContent+="</ul><br>";
          }
          pgContent+="</div>";
        }


        if(Array1.length > 0){
          pgContent+="<div id=\"indexRubricColumnEntry\">";
          if(Array3.length > 0){
            pgContent+="<ul class=\"indexRubric\">";
            for (i=0; i < Array3.length; i++){
              help = (i-1);
              if(Array3[i][6]!=""){
                pgContent+="<li class=\"synonymTextLi\"><span class=\"synonymText\">"+Array3[i][1]+" "+ TLsynonymText +"</span></li>";
              }else{
               if(Array3[help]&&Array3[help][6]!=""){
                 pgContent+="<li class=\"synonym\">";
                 pgContent+="<ul class=\"indexRubricSynonym\">";
                 pgContent+="<li><a href=\""+ buildValidServerRelativeUrl(Array3[i][4]) + "?source=" + contentTp +"&article="+getFileName(Array3[i][4])+"\"><img src=\"http://wcms10.bmwgroup.com/bmw_edit/_common/html/img/palette/1x1_trans.gif\" alt=\"\" class=\"arrow\">"+Array3[i][1]+"</a></li></ul></li>";
               }else{
                 pgContent+="<li><a href=\""+ buildValidServerRelativeUrl(Array3[i][4]) + "?source=" + contentTp +"&article="+getFileName(Array3[i][4])+"\"><img src=\"http://wcms10.bmwgroup.com/bmw_edit/_common/html/img/palette/1x1_trans.gif\" alt=\"\" class=\"arrow\">"+Array3[i][1]+"</a></li>";
               }
             }
           }
           pgContent+="</ul><br>";
         }
         pgContent+="</div>";
       }

       pgContent+="</div>";
       pgContent+="</div>";
      return;
    } else{
      counter++;
      getArraySums(Array1,Array2,Array3);
      getItEvenIndex(Array1,Array2,Array3,counter);
      return;
    }
  } finally {
  }

counter++;
}

getArraySums(arrayLayer1,arrayLayer2,arrayLayer3);
getItEvenIndex(arrayLayer1,arrayLayer2,arrayLayer3,0);

     }
     writeIntoLayer("completePageContent",pgContent);
     if(contentTp=="models"){
       writeModelLayerContent(actualCar);
     }
}