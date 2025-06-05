function doQuote(obj) {
	$(window).trigger('cite', [0, false]);
	var text = ">" + obj.closest(".post").querySelector(".body").innerText.split("\n").join("\n>");
	var textareas = document.getElementsByName("body");
	var scrollX = window.scrollX || window.pageXOffset;
	var scrollY = window.scrollY || window.pageYOffset;
	
	for (var i = 0; i < textareas.length; i++) {
	  textareas[i].value = text;

	  if (i + 1 == textareas.length){
	  	textareas[i].trigger('focus');
	  }
	}	
	window.scrollTo(scrollX, scrollY);
}
