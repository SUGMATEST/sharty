
window.tegaki_integration = (function(){
	"use strict";
	
	var tegaki_integration = {};
	
	tegaki_integration.settings = new script_settings('wpaint');
	tegaki_integration.height = tegaki_integration.settings.get("height", 250);
	tegaki_integration.width = tegaki_integration.settings.get("width", 500);
	
	$('<link class="wpaintcss" rel="stylesheet" href="'+configRoot+'stylesheets/tegaki/tegaki.css" />').appendTo($("head"));
	function canvasToFile(canvas, fileName) {
		let dataURL = canvas.toDataURL('image/png');
	
		let arr = dataURL.split(','), mime = arr[0].match(/:(.*?);/)[1],
			bstr = atob(arr[1]), n = bstr.length, u8arr = new Uint8Array(n);
		while(n--){
			u8arr[n] = bstr.charCodeAt(n);
		}
		let blob = new Blob([u8arr], {type:mime});
	
		let file = new File([blob], fileName, {type: "image/png"});
	
		return file;
	}
	tegaki_integration.show = function () {
		Tegaki.open({
			// when the user clicks on Finish
			onDone: function() {
			  // Tegaki.flatten() returns a <canvas>
			  var canv = Tegaki.flatten();
			  window.addFile(canvasToFile(canv, "Tegaki.png"));
			},
			
  			onCancel: function() { console.log('Closing...')},
			// initial canvas size
			width: 400,
			height: 400
		  });
	}
	
	return tegaki_integration;
	})();
	