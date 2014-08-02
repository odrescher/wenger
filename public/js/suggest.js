var delay = (function(){
	var timer = 0;
	return function(callback, ms){
		clearTimeout (timer);
		timer = setTimeout(callback, ms);
	};
})();
var getMSIEVersion = function() {
	if(navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion.indexOf("MSIE") != -1) {
		var tmpstring = navigator.appVersion.substring(navigator.appVersion.indexOf("MSIE"));
		return parseInt(tmpstring.substring(4,tmpstring.indexOf(";"))) || false;
	}
	return false;
};
var placeHold = function(element,text,parentForm) {
	if(navigator.appName == "Microsoft Internet Explorer" && getMSIEVersion() <= 9) {
		if($("input#"+element.attr("id")).attr("value") == ""){
			$("input#"+element.attr("id")).attr("value",text);
		}
		// Adding Handler
		$("input#"+element.attr("id")).on("blur",function() {
			if($(this).attr("value") == ""){
				$(this).attr("value",text);
			}
		});
		$("input#"+element.attr("id")).on("focus",function() {
			if($(this).attr("value") == text){
				$(this).attr("value","");
			}
		});
		$("form#"+parentForm.attr("id")).on("submit",function() {
			if(element.attr("value") == text){
				element.attr("value","");
			}
		});
	}
	return false;
};
var removeList = function() {
	if($("div.suggestbox").length > 0) {
		$("div.suggestbox").remove();
	}
};