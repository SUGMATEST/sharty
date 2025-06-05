function setupSWF(thumb, url) {
	if (thumb.swfAlreadySetUp) return;
	thumb.swfAlreadySetUp = true;

	var swfContainer, swfHide;
	var expanded = false;
	var rufflePlayer = null; 
	var oldParentWidth = 0;
	oldParentWidth = thumb.parentElement.style.width;
	function unexpand() {
		if (expanded) {
			expanded = false;
			swfContainer.style.display = "none";
			thumb.style.display = "inline";
			if (rufflePlayer) {
				swfContainer.removeChild(rufflePlayer);
				rufflePlayer = null;
			}
			thumb.parentElement.style.width = oldParentWidth;
		}
	}
	function getSWF() {
		if (swfContainer == null) {
			swfContainer = document.createElement("div");
			swfContainer.style.display = "none";
			swfContainer.setAttribute("class", "ruffle");
			swfContainer.style.paddingLeft = "15px";
			swfContainer.style.paddingRight = "15px";
			swfContainer.style.paddingBottom = "15px";

			swfHide = document.createElement("img");
			swfHide.src = configRoot + "static/collapse.gif";
			swfHide.alt = "[ - ]";
			swfHide.title = "Collapse SWF";
			swfHide.style.marginLeft = "-15px";
			swfHide.style.cssFloat = "left";
			swfHide.addEventListener("click", unexpand, false);

			thumb.parentNode.insertBefore(swfContainer, thumb.nextSibling);
			swfContainer.appendChild(swfHide); 
		}
	}

	thumb.addEventListener("click", function(e) {
		getSWF();
		expanded = true;
		thumb.style.display = "none";
		swfContainer.style.display = "block"; 
		thumb.parentElement.style.width = null;
		if (!rufflePlayer) {
			swfContainer.style.width = "550px";
			swfContainer.style.height = "400px";
			let ruffleInstance = window.RufflePlayer.newest();
			rufflePlayer = ruffleInstance.createPlayer();
			rufflePlayer.config = {
				autoplay: "off",
				openUrlMode: "confirm",
				allowNetworking: "none",
				showSwfDownload: true,
			};
			swfContainer.appendChild(rufflePlayer);
			
			rufflePlayer.addEventListener('loadedmetadata', () => {
				swfContainer.style.width = rufflePlayer.metadata.width + "px";
				swfContainer.style.height = rufflePlayer.metadata.height + "px";
				rufflePlayer.style.width = rufflePlayer.metadata.width + "px";
				rufflePlayer.style.height = rufflePlayer.metadata.height + "px";
			});
		}
		rufflePlayer.load({url: url});

		e.preventDefault();
	}, false);
}

function setupSWFsIn(element) {
	var thumbs = element.querySelectorAll("a.file");
	for (var i = 0; i < thumbs.length; i++) {
		if (/\.swf$/.test(thumbs[i].pathname)) {
			setupSWF(thumbs[i], thumbs[i].href);
		}
	}
}

onready(function(){

	setupSWFsIn(document);

	if (window.MutationObserver) {
		var observer = new MutationObserver(function(mutations) {
			for (var i = 0; i < mutations.length; i++) {
				var additions = mutations[i].addedNodes;
				if (additions == null) continue;
				for (var j = 0; j < additions.length; j++) {
					var node = additions[j];
					if (node.nodeType == 1) {
						setupSWFsIn(node);
					}
				}
			}
		});
		observer.observe(document.body, {childList: true, subtree: true});
	}
});

