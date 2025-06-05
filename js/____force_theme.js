window.addEventListener('load', function () {
var styleName = 'FrootigerAerthough';
	document.getElementById('stylesheet').href = styles[styleName];
	selectedstyle = styleName;
	
	if (document.getElementsByClassName('styles').length != 0) {
		var styleLinks = document.getElementsByClassName('styles')[0].childNodes;
		for (var i = 0; i < styleLinks.length; i++) {
			styleLinks[i].className = '';
		}
	}
	
	
	if (typeof $ != 'undefined')
		$(window).trigger('stylesheet', styleName);
});