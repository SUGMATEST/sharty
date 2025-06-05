// initialize
var UNIQUE_KEY;
var k;
if (typeof(k) === "undefined") {
	document.head.insertAdjacentHTML('beforeEnd', '<link rel="stylesheet" href="https://sys.kolyma.net/kaptcha/kaptcha.css">');
	k = 0;
}
k++;
var tout;

// setup
UNIQUE_KEY = gen_key();

function redo_events(provider, extra) {
  $('.captcha ._KAPTCHA, textarea[id="body"]').off("focus").one("focus", function() { actually_load_captcha(provider, extra); });
}

function actually_load_captcha(provider, extra) {
  $('.captcha ._KAPTCHA, textarea[id="body"]').off("focus");

  if (tout !== undefined) {
    clearTimeout(tout);
  }

  $.getJSON(provider, {mode: 'get', extra: extra}, function(json) {
    $(".captcha ._KAPTCHA_KEY").val(json.cookie);
    $(".captcha .captcha_html").html(json.captchahtml);

    setTimeout(function() {
      redo_events(provider, extra);      
    }, json.expires_in * 1000);
  });
}

function load_captcha(provider, extra) {
  $(function() {
    $(".captcha>td").html("<table id='ka"+k+"' class='kaptcha' cellspacing='3' cellpadding='0'><tbody>"+
	"<tr><td class='ka_challenge'><img src='' alt='' width='180' height='60'></td>"+
		"<td class='k_btns' rowspan='2' width='64' height='64' valign='TOP'>"+
			"<small>[<a href='javascript:void(0);' onclick='ka_reload(false);'>Reload</a>]</small>"+
			"<a href='https://www.kolyma.net/software/kaptcha' target='_blank' class='ka_q'>?</a>"+
			"<small>[<a href='javascript:void(0);' onclick='ka_check(this);'>Check</a>]</small>"+
		"</td>"+
	"</tr>"+
	"<tr>"+
		"<td valign='BOTTOM'>"+
			"<input size='10' type='text' name='_KAPTCHA' value='' class='ka_input' placeholder='Please enter the text above' autocomplete='off' />"+
			"<input type='hidden' name='_KAPTCHA_KEY' value='"+UNIQUE_KEY+"'>"+
		"</td>"+
	"</tr>"+
"</tbody></table>");

    $("#quick-reply .captcha ._KAPTCHA").prop("placeholder", _("Verification"));

    $(".captcha .captcha_html").on("click", function() { actually_load_captcha(provider, extra); });
    $(document).on("ajax_after_post",       function() { actually_load_captcha(provider, extra); });
    redo_events(provider, extra);

    $(window).on("quick-reply", function() {
      redo_events(provider, extra);
      $("#quick-reply .captcha .captcha_html").html($("form:not(#quick-reply) .captcha .captcha_html").html());
      $("#quick-reply .captcha ._KAPTCHA_KEY").val($("form:not(#quick-reply) .captcha ._KAPTCHA_KEY").html());
      $("#quick-reply .captcha .captcha_html").on("click", function() { actually_load_captcha(provider, extra); });
    });
  });
}

//Kaptcha
async function ka_reload(a = true) {
		var xhttp;
	if (window.XMLHttpRequest)
		xhttp = new XMLHttpRequest();
	else
		xhttp = new ActiveXObject("Microsoft.XMLHTTP");
	xhttp.onload = function () {
		for (var i = k; i; i--) {
			var ka = document.getElementById("ka"+i);
			if (typeof(ka) === "undefined") continue;
				if (xhttp.responseText.startsWith("NONE"))
				ka.getElementsByClassName("ka_challenge")[0].querySelector("img").src = "https://sys.kolyma.net/kaptcha/vip.png";
			if (!xhttp.responseText.startsWith("NEW")) return;
 			ka.getElementsByClassName("ka_challenge")[0].querySelector("img").src = xhttp.responseText.slice(4);
			ka.getElementsByClassName("ka_input")[0].value = "";
		}
	};
	xhttp.open("GET", "https://sys.kolyma.net/kaptcha/kaptcha.php?key="+UNIQUE_KEY);
	xhttp.send();

	if (a) setTimeout(ka_reload, 300000);
}

async function ka_check(form) {
	var guess = document.querySelector("#ka"+k+" input").value;
		var xhttp;
	if (window.XMLHttpRequest)
		xhttp = new XMLHttpRequest();
	else
		xhttp = new ActiveXObject("Microsoft.XMLHTTP");
	xhttp.onload = function () {
		if (!xhttp.responseText.startsWith("CHECK")) return;
		if (xhttp.responseText.search("CHECK correct") != -1) {
		for (var i = k; i > 0; i--) {
				var ka = document.getElementById("ka"+i);
				if (typeof(ka) === "undefined") continue;
				ka.getElementsByClassName("ka_challenge")[0].querySelector("img").src = "https://sys.kolyma.net/kaptcha/complete.png";
			}
		} else {
			ka_reload(false);
		}
	};
	xhttp.open("GET", "https://sys.kolyma.net/kaptcha/kaptcha.php?key="+UNIQUE_KEY+"&_KAPTCHA="+guess);
	xhttp.send();
}

function gen_key() {
	var result = "";
	var characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789=-";
	for (var i = 0; i < 64; i++)
		result += characters.charAt(Math.floor(Math.random() * 64));
	return result;
}

window.addEventListener("DOMContentLoaded", function () {
	ka_reload();
});


