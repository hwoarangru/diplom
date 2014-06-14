if (typeof Array.prototype.indexOf != "function") {Array.prototype.indexOf = function (obj, idx) {idx=((idx&&isNaN(Number(idx)))?(parseInt(Number(idx),10)):(0));idx=((idx<0)?(Math.max(0,(this.length+idx))):(idx));var k,i=-1;for(k=idx;k<this.length;++k){if(this[k]===obj){i=k;break;}}return i;};}
if (typeof Array.prototype.lastIndexOf != "function") {Array.prototype.lastIndexOf = function (obj, idx) {idx=((idx&&isNaN(Number(idx)))?(parseInt(Number(idx),10)):(this.length-1));idx=((idx<0)?(Math.max(0,(this.length+idx))):(idx));idx=((idx>this.length)?(this.length):(idx));var k,i=-1;for(k=idx;k>=0;--k){if(this[k]===obj){i=k;break;}}return i;};}
if (typeof Array.prototype.contains != "function") {Array.prototype.contains = function (obj) {return(this.indexOf(obj)>=0);};}
if (typeof Array.prototype.forEach != "function") {Array.prototype.forEach = function (fct, thisArr) {if(typeof fct=="function"){thisArr=((thisArr&&(typeof thisArr=="object")&&(thisArr instanceof Array))?(thisArr):(null));var i,l=this.length;for(i=0;i<l;++i){fct.call(thisArr,this[i],i,this);}}};}
if (typeof Array.prototype.every != "function") {Array.prototype.every = function (fct, thisArr) {var isAnd=false;if(typeof fct=="function"){thisArr=((thisArr&&(typeof thisArr=="object")&&(thisArr instanceof Array))?(thisArr):(null));isAnd=true;var i,l=this.length;for(i=0;i<l;++i){if(!fct.call(thisArr,this[i],i,this)){isAnd=false;break;}}}return isAnd;};}
if (typeof Array.prototype.some != "function") {Array.prototype.some = function (fct, thisArr) {var isOr=false;if(typeof fct=="function"){thisArr=((thisArr&&(typeof thisArr=="object")&&(thisArr instanceof Array))?(thisArr):(null));var i,l=this.length;for(i=0;i<l;++i){if(fct.call(thisArr,this[i],i,this)){isOr=true;break;}}}return isOr;};}
if (typeof Array.prototype.map != "function") {Array.prototype.map = function (fct, thisArr) {var arr=[];if(typeof fct=="function"){thisArr=((thisArr&&(typeof thisArr=="object")&&(thisArr instanceof Array))?(thisArr):(null));var i,l=this.length;for(i=0;i<l;++i){arr.push(fct.call(thisArr,this[i],i,this));}}return arr;};}
if (typeof Array.prototype.filter != "function") {Array.prototype.filter = function (fct, thisArr) {var arr=[];if(typeof fct=="function"){thisArr=((thisArr&&(typeof thisArr=="object")&&(thisArr instanceof Array))?(thisArr):(null));var i,l=this.length;for(i=0;i<l;++i){if(fct.call(thisArr,this[i],i,this)){arr.push(this[i]);}}}return arr;};}

String.prototype.basicTrim = function () {return this.replace((/^\s+|\s+$/), "");};
String.prototype.superTrim = function () {return this.basicTrim().replace((/\s+/g), " ")};

document.getCurrentStyle = function (nodeObj/*:HTMLElement*/, cssScheme/*:String*/)/*:String*/ {var currStyle;if(nodeObj&&(typeof nodeObj.nodeType=="number")&&(nodeObj.nodeType>=1)&&(nodeObj.nodeType<=12)){cssScheme=String(cssScheme);if(document.defaultView&&document.defaultView.getComputedStyle){currStyle=document.defaultView.getComputedStyle(nodeObj,"").getPropertyValue(cssScheme);}else if(document.documentElement&&document.documentElement.currentStyle){currStyle=nodeObj.currentStyle[cssScheme.replace((/\-(\w)/g),(function(str,$1){return $1.toUpperCase();}))];}}return currStyle;};


var TGModuleNavigation = new function ()/*:TGModuleNavigation*/ { // [[Singleton]] design pattern;

	this.constructor = Object;

	var _self = this;				// reference to the objct itself in order to preserve it internally for methods of this object;

	var node/*:HTMLElement*/, contentNode/*HTMLUlElement*/, dropperNode/*:HTMLImgElement*/, cssTop/*:Number*/, timeoutIdDropper/*:Object*/;

	var firstLevelCategoriesMap/*:Object*/; // internal mapper in order to trigger "expand" calls automatically;

	this.categoryList = [];	// list referencing the navigation objects category and sub category levels;

	var mapCategoryList = function (obj/*:HTMLUlElement*/)/*:Void*/ {

		//alert("TGModuleNavigation - mapCategoryList\n\nobj.childNodes.length : " + obj.childNodes.length + "\n(obj.childNodes instanceof Array) ? " + (obj.childNodes instanceof Array));
		obj = obj.firstChild;
		while (obj) {
			_self.categoryList.push(new TGModuleNavigationCategory(_self, obj));
			obj = obj.nextSibling;
		}
		_self.categoryList.forEach(function (elm, idx, arr) {
		//alert("elm.node.innerHTML : " + elm.node.innerHTML);
			obj = elm.nodeSubList;
			if (obj && obj.firstChild && obj.firstChild.nodeName.toLowerCase("li")) {
			//alert("obj.firstChild : " + obj.firstChild);
				elm.mapCategoryList(obj); // every [TGModuleNavigationCategory] objects "mapCategoryList" method;
			}
		});
	};
	var compile = function ()/*:Void*/ { // private method - builds the [[TGModuleNavigation]]s initial HTML-code right from the scratch;

		firstLevelCategoriesMap = {

			"overview": {
				"href": buildValidServerRelativeUrl(TLbaseUrl + TLoverviewLink),
				"id": "gotoOverview"
			},
			"index": {
				"href": buildValidServerRelativeUrl(TLbaseUrl + TLindexLink),
				"id": "searchByIndex"
			},
			"categories": {
				"href": buildValidServerRelativeUrl(TLbaseUrl + TLcategoryLink),
				"id": "searchByCategories"
			},
			"models": {
				"href": buildValidServerRelativeUrl(TLbaseUrl + TLseriesLink),
				"id": "searchBySeries"
			}
		};

		var elmA = document.createElement("a");
		elmA.href = firstLevelCategoriesMap.overview.href;
		elmA.appendChild(document.createTextNode(TLoverviewText));

		var elmLI = document.createElement("li");
		elmLI.id = firstLevelCategoriesMap.overview.id; // "gotoOverview";
		elmLI.appendChild(elmA);

		var elmUL = document.createElement("ul");
		elmUL.appendChild(elmLI);

		var compileIndexEntries = function (arr) { // build an array of [HTMLLiElements] according to entries of "TLindexList" array;
			var elm, elmLI;
			if (arr[2]) {
				elm = document.createElement("a");
				elm.href = firstLevelCategoriesMap.index.href + "?code=" + arr[1] + "&view=" + arr[0];
				elm.searchCode = Number(parseInt(arr[1], 10));
				elm.appendChild(document.createTextNode(arr[0]));
			} else {
				elm = document.createElement("span");
				elm.className = "disabled";
				elm.appendChild(document.createTextNode(arr[0]));
			}
			elmLI = document.createElement("li");
			elmLI.appendChild(elm);
			return elmLI;
		};
		var compileOtherEntries = function (str) { // build an array of [HTMLLiElements] according to entries of "TLcategoriesList" array and "TLseriesList" array;
			var elmA = document.createElement("a");
		//elmA.href = null; // as soon as the "href" attribute of a newly created anchor-element gets refered to, this element becomes a link-element - though DONT'TOUCH IT!
			elmA.appendChild(document.createTextNode(str));
			var elmLI = document.createElement("li");
			elmLI.appendChild(elmA);
			return elmLI;
		};
		var appendToSublist = function (elm, idx, arr) { // append all nodes of the just mapped array onto its responding sublist;

			if ((elm.firstChild.nodeName.toLowerCase() == "a") && !elm.firstChild.href) {

			//"elmA" has scope of the private function "compile" - though it refers to "TLcategoryLink" as well as to "TLseriesLink";
				elm.firstChild.href = elmA.href + "?code=" + idx + "&view=" + (elm.firstChild.innerHTML || elm.firstChild.firstChild.data);
				elm.firstChild.searchCode = Number(parseInt(idx));
				elm.className = "collapsed"; // "expanded";
			}
			elmSubUL.appendChild(elm);
		};
		var elmSubUL;

	//build complete list according to "TLindexList" array - "searchByIndex";
		elmLI = document.createElement("li"); elmLI.id = firstLevelCategoriesMap.index.id; elmLI.className = "collapsed"; // "expanded";
		elmA = document.createElement("a"); elmA.href = firstLevelCategoriesMap.index.href;
		elmA.appendChild(document.createTextNode(TLindexText));
		elmLI.appendChild(elmA);

		elmSubUL = document.createElement("ul");
		TLindexList.map(compileIndexEntries).forEach(appendToSublist);
		elmLI.appendChild(elmSubUL);

		elmUL.appendChild(elmLI);

	//build complete list according to "TLcategoriesList" array - "searchByCategories";
		elmLI = document.createElement("li"); elmLI.id = firstLevelCategoriesMap.categories.id; elmLI.className = "collapsed"; // "expanded";
		elmA = document.createElement("a"); elmA.href = firstLevelCategoriesMap.categories.href;
		elmA.appendChild(document.createTextNode(TLcategoryText));
		elmLI.appendChild(elmA);

		elmSubUL = document.createElement("ul");
		TLcategoriesList.map(compileOtherEntries).forEach(appendToSublist);
		elmLI.appendChild(elmSubUL);

		elmUL.appendChild(elmLI);

	//build complete list according to "TLseriesList" array - "searchBySeries";
		elmLI = document.createElement("li"); elmLI.id = firstLevelCategoriesMap.models.id; elmLI.className = "collapsed"; // "expanded";
		elmA = document.createElement("a"); elmA.href = firstLevelCategoriesMap.models.href;
		elmA.appendChild(document.createTextNode(TLseriesText));
		elmLI.appendChild(elmA);

		elmSubUL = document.createElement("ul");
		TLseriesList.map(compileOtherEntries).forEach(appendToSublist);
		elmLI.appendChild(elmSubUL);

		elmUL.appendChild(elmLI);

	//parses elmUl and maps the private "categoryList" that is essential for the objects internal processes;
		mapCategoryList(elmUL);


	//navigation gets created as unordered list wrapped by its identifying parent DIV-node;
		cssTop = node.offsetTop;
		contentNode = elmUL;

		node.appendChild(elmUL);


	//dropper needs to be sticked to the bottom of the module navigation as well;
		elmA = document.createElement("a");
		elmA.href = "#";
		elmA.onclick = function (evt) {return _self.onDropperReleased(evt || window.event);};

		dropperNode = document.createElement("img");
		dropperNode.id = "moduleNaviDropper";
		dropperNode.src = dropperGif;
		elmA.appendChild(dropperNode);

		node.appendChild(elmA);

		node.style.visibility = "visible";
	};
	var expand = function (cat, subCat) { // internal "expand" method in order to highlight this functions arguments matching category (or categories);

		cat = String(cat);
		subCat = Number(parseInt(subCat, 10));

		var collapseSameLevelCategories = function () {

			catObj.parent.categoryList.forEach(function (elm, idx, arr) {
				if (elm.collapse && (elm != catObj)) {
					elm.collapse();
				}
			});
		};
		var expandCategoryLevel = function () {

			var isCollapsed = catObj.getIsCollapsed();
	
			if (typeof isCollapsed != "undefined") { // catObj.nodeSubList exists;
				if (isCollapsed) {
					collapseSameLevelCategories();
					catObj.node.className = "expanded selected"; // "expanded selected";
				} else {
					catObj.node.className = "collapsed";
				}
			} else {
				collapseSameLevelCategories();
				catObj.node.className = "selected";
			}
		//alert("expandCategoryLevel:\n\ncatObj.node.className = " + catObj.node.className);
		};
		var catId = (((firstLevelCategoriesMap[cat]) ? (firstLevelCategoriesMap[cat].id) : (false)) || firstLevelCategoriesMap.overview.id);
		var catObj = _self.categoryList.filter(function (elm, idx, arr) {return (elm.node.id == catId);})[0];

		if (catObj) {
			expandCategoryLevel(); // executes within context of [catObj];
		}
		if (!isNaN(subCat)) {

			catObj = catObj.categoryList.filter(function (elm, idx, arr) {return (elm.node && elm.node.firstChild && (elm.node.firstChild.searchCode == subCat));})[0];

			if (catObj) {
				expandCategoryLevel(); // executes within context of [catObj];
			}
		}
	};


	this.onDropperReleased = function (evtObj)/*:Boolean*/ {

	//alert("TGModuleNavigation.onDropperReleased(" + evtObj + ")");
		if (node.offsetTop >= 0) {
			_self.collapse();
		} else {
			_self.expand();
		}
		return false;
	};
	this.collapse = function ()/*:Void*/ { // public method that collapses the module navigation;

		clearTimeout(timeoutIdDropper);

		var timeout = 20;
		var stepWidth = 60;
		var dropperGap = 6; // 3;

		if ((cssTop - node.offsetTop) >= (node.offsetHeight - dropperNode.offsetHeight - dropperGap - stepWidth + cssTop)) {
			node.style.top = cssTop - (node.offsetHeight - dropperNode.offsetHeight - dropperGap) + "px";
		} else {
			node.style.top = (node.offsetTop - stepWidth) + "px";
			timeoutIdDropper = setTimeout((function () {_self.collapse();}), timeout);
		}
	};
	this.expand = function (cat/*:String[optional]*/, subCat/*:String[optional]*/)/*:Void*/ { // public method that expands the module navigation and/or highlights its categories;

		clearTimeout(timeoutIdDropper);

		var timeout = 20;
		var stepWidth = 60;

		if (cat || (typeof cat == "string")) {expand(cat, subCat);}

		if (node.offsetTop >= (cssTop - stepWidth)) {
			node.style.top = cssTop + "px";
		} else {
			node.style.top = (node.offsetTop + stepWidth) + "px";
			timeoutIdDropper = setTimeout((function () {_self.expand();}), timeout);
		}
	};
	this.compile = function ()/*:Void*/ {

		if (window.opera && document.getElementsByTagName("li")["gotoOverview"]) {return;} // patches an opera onload bug;

		node = document.getElementsByTagName("div");
		node = ((node.namedItem) ? (node.namedItem("TGModuleNavi")) : (node["TGModuleNavi"] || document.getElementById("TGModuleNavi")));

		if (node && document.createElement && document.createTextNode && node.appendChild) {

			compile();
		//_self.expand();
		}
	};


	var TGModuleNavigationCategory = function (parentObj/*:(TGModuleNavigation|TGModuleNavigationCategory)*/, elmNode/*:HTMLElement*/)/*:TGModuleNavigationCategory*/ { // constructor in order to create more than one [[TGModuleNavigationCategory]] object;

	//alert("(parentObj === TGModuleNavigation) ? " + (parentObj === TGModuleNavigation) + "\n(parentObj instanceof TGModuleNavigation) ? " + (parentObj instanceof TGModuleNavigation) + "\n(parentObj === TGModuleNavigationCategory) ? " + (parentObj === TGModuleNavigationCategory) + "\n(parentObj instanceof TGModuleNavigationCategory) ? " + (parentObj instanceof TGModuleNavigationCategory));
		if (((parentObj === TGModuleNavigation) || (parentObj instanceof TGModuleNavigationCategory)) && elmNode && elmNode.nodeName && (elmNode.nodeName.toLowerCase() == "li") && (elmNode.firstChild.nodeName.toLowerCase() == "a")) {

			var _self = this; // reference to the objcts itself in order to preserve it internally for methods of this object;

			this.constructor = arguments.callee;
			this.parent = parentObj;
			this.node = elmNode;

			var elm = this.node.getElementsByTagName("a");
			elm = ((elm.item) ? (elm.item(0)) : (elm[0]));

			elm.onmouseover = function (evt) {return _self.onCategoryRollOver(evt || window.event);};
			elm.onmouseout = function (evt) {return _self.onCategoryRollOut(evt || window.event);};
			elm.onclick = function (evt) {return _self.onCategoryReleased(evt || window.event);};

			this.text = (elm.innerHTML || elm.firstChild.data);
			this.nodeLink = elm;

			elm = this.node.getElementsByTagName("ul");
			elm = ((elm.item) ? (elm.item(0)) : (elm[0]));
			if (elm) {
				
				this.nodeSubList = elm;
			}
			elm = null; delete elm;

			this.onCategoryRollOver = function (evtObj)/*:Boolean*/ {

				var str = _self.text;
				var obj = _self.parent;
				while (obj && obj.text) {
					str += "$$$" + obj.text;
					obj = obj.parent;
				}
				window.top.status = str.split("$$$").reverse().join(" / ");
				return true;
			};
			this.onCategoryRollOut = function (evtObj)/*:Boolean*/ {

				window.top.status = "";
				return true;
			};
			this.onCategoryReleased = function (evtObj)/*:Boolean*/ {

			//alert(_self + ".onCategoryReleased(" + evtObj + ")");
			//alert("(" + _self + ".getIsCollapsed()) ? " + _self.getIsCollapsed());
				var collapseSameLevelCategories = function () {
					_self.parent.categoryList.forEach(function (elm, idx, arr) {
						if (elm.collapse && (elm != _self)) {
							elm.collapse();
						}
					});
				};
				var isCollapsed = _self.getIsCollapsed();
				var triggerHref = false;

				if (typeof isCollapsed != "undefined") { // _self.nodeSubList exists;
					if (isCollapsed) {
						collapseSameLevelCategories();
					//_self.nodeSubList.style.display = "block";
					//_self.node.className = "expanded";
					//alert("_self.node.className -\n\nbefore : \"" + _self.node.className + "\"\nafter : \"" + ("expanded " + _self.node.className.replace((/\b(?:expanded|collapsed)\b/g), "")).superTrim());
						_self.node.className = ("expanded " + _self.node.className.replace((/\b(?:expanded|collapsed)\b/g), "")).superTrim();
					//alert("_self.node.className = \"" + _self.node.className + "\"");
						triggerHref = false; // [true] - for js-testing it is recommended to be set to [false];
					} else {
					//_self.nodeSubList.style.display = "none";
					//_self.node.className = "collapsed";
					//alert("_self.node.className -\n\nbefore : \"" + _self.node.className + "\"\nafter : \"" + ("collapsed " + _self.node.className.replace((/\b(?:collapsed|expanded)\b/g), "")).superTrim());
						_self.node.className = ("collapsed " + _self.node.className.replace((/\b(?:collapsed|expanded)\b/g), "")).superTrim();
					//alert("_self.node.className = \"" + _self.node.className + "\"");
						triggerHref = false;
					}
				} else {
				//alert("(window.location.pathname == _self.nodeLink.pathname) ? " + (window.location.pathname == _self.nodeLink.pathname));
				//if ((window.location.pathname + window.location.search) == (_self.nodeLink.pathname + _self.nodeLink.search)) {}
				//collapseSameLevelCategories();
					triggerHref = true; // [true] - for js-testing it is recommended to be set to [false];
				}
				return triggerHref;
			};
			this.categoryList = [];	// list referencing the category objects sub category levels;

			this.mapCategoryList = function (obj/*:HTMLUlElement*/)/*:Void*/ {

			//alert("TGModuleNavigationCategory - mapCategoryList\n\nobj.childNodes.length : " + obj.childNodes.length + "\n(obj.childNodes instanceof Array) ? " + (obj.childNodes instanceof Array));
				obj = obj.firstChild;
				while (obj) {
					_self.categoryList.push(new TGModuleNavigationCategory(_self, obj));
					obj = obj.nextSibling;
				}
				_self.categoryList.forEach(function (elm, idx, arr) {
				//alert("elm.node.innerHTML : " + elm.node.innerHTML);
					obj = elm.nodeSubList;
					if (obj && obj.firstChild && obj.firstChild.nodeName.toLowerCase("li")) {
					//alert("obj.firstChild : " + obj.firstChild);
						elm.mapCategoryList(obj); // every [TGModuleNavigationCategory] objects "mapCategoryList" method;
					}
				});
			//alert("TGModuleNavigationCategory - _self.categoryList.length : " + _self.categoryList.length);
			};
			this.getIsCollapsed = function ()/*Boolean|[undefined]*/ {

			//alert("document.getCurrentStyle(" + _self.nodeSubList + ", \"display\") : " + document.getCurrentStyle(_self.nodeSubList, "display"));
				return ((!_self.nodeSubList) ? (_self.nodeSubList) : (document.getCurrentStyle(_self.nodeSubList, "display") == "none"));
			};
			this.collapse = function ()/*:Void*/ {

				if (_self.getIsCollapsed() === false) {
				//_self.nodeSubList.style.display = "none";
				//_self.node.className = "collapsed";
				//alert("_self.node.className -\n\nbefore : \"" + _self.node.className + "\"\nafter : \"" + ("collapsed " + _self.node.className.replace((/\b(?:collapsed|expanded)\b/g), "")).superTrim());
					_self.node.className = ("collapsed " + _self.node.className.replace((/\b(?:collapsed|expanded)\b/g), "")).superTrim();
				//alert("_self.node.className = \"" + _self.node.className + "\"");
				}
			};
			this.expand = function ()/*:Void*/ {

				if (_self.getIsCollapsed() === true) {
				//_self.nodeSubList.style.display = "block";
				//_self.node.className = "expanded";
				//alert("_self.node.className -\n\nbefore : \"" + _self.node.className + "\"\nafter : \"" + ("expanded " + _self.node.className.replace((/\b(?:expanded|collapsed)\b/g), "")).superTrim());
					_self.node.className = ("expanded " + _self.node.className.replace((/\b(?:expanded|collapsed)\b/g), "")).superTrim();
				//alert("_self.node.className = \"" + _self.node.className + "\"");
				}
			};
		}
	};
}();/*


if (window.addEventListener) {
	window.addEventListener("load", TGModuleNavigation.compile, true);
} else if (window.attachEvent) {
	window.attachEvent("onload", TGModuleNavigation.compile);
}*/