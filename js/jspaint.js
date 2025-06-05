window.jspaint = (function(){
"use strict";

var jspaint = {};

function dataURItoBlob(dataURI) {
    var binary = atob(dataURI.split(',')[1]);
    var array = new Array(binary.length);
    for(var i = 0; i < binary.length; i++) {
        array[i] = binary.charCodeAt(i);
    }
    return new Blob([new Uint8Array(array)], {type: 'image/png'});
}

jspaint.init = function() {
  var width = window.innerWidth * 0.80
  var height = window.innerHeight * 0.80 > 400 ? window.innerHeight * 0.80 : 400
  var iframe = '<tr id="jspaint-container"><th>JS Paint</th><td><iframe id="jspaint-iframe" style="width: ' + width + 'px; height: ' + height + 'px;" src="/js/jspaint/index.html" width="100%" height="100%"></iframe></td></tr>';
  $('form[name="post"]:not(#quick-reply) [id="upload"]').after(iframe);

  $(document).on("ajax_before_post.jspaint", function(e, postData) {
    var iframe = document.getElementById("jspaint-iframe");
    var canvas = iframe.contentDocument.querySelector(".main-canvas");
    postData.append("file", dataURItoBlob(canvas.toDataURL("image/png")), "JS Paint.png");
  });

  jspaint.initialized = true;
};

jspaint.deinit = function() {
  $('#jspaint-iframe, #jspaint-container').remove();

  $(document).off("ajax_before_post.jspaint");

  jspaint.initialized = false;
};

jspaint.initialized = false;
return jspaint;
})();
