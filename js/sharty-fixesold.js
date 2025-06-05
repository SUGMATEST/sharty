// ==UserScript==
// @name        Sharty fixes
// @namespace   soyjak.party
// @match       http*://soyjak.party/*
// @match       http*://www.soyjak.party/*
// @grant       GM_getValue
// @grant       GM_setValue
// @version     2.8.5
// @author      Xyl
// @description Enhancements for the 'ty
// ==/UserScript==

const version = "v2.8.5";
console.log(`Sharty fixes ${version}`);

const namespace = "ShartyFixes.";
function setValue(key, value) {
  if (key == "hiddenthreads" || key == "hiddenimages") {
    if (typeof GM_setValue == "function") {
      GM_setValue(key, value);
    }
    localStorage.setItem(key, value);
  } else {
    if (typeof GM_setValue == "function") {
      GM_setValue(namespace + key, value);
    } else {
      localStorage.setItem(namespace + key, value);
    }
  }
}

function getValue(key) {
  if (key == "hiddenthreads" || key == "hiddenimages") {
    if (typeof GM_getValue == "function" && GM_getValue(key)) {
      localStorage.setItem(key, GM_getValue(key).toString());
    }
    return localStorage.getItem(key);
  }
  if (typeof GM_getValue == "function") {
    return GM_getValue(namespace + key);
  } else {
    return localStorage.getItem(namespace + key);
  }
}

function isEnabled(key) {
  let value = getValue(key);
  if (value == null) {
    value = optionsEntries[key][2];
    setValue(key, value);
  }
  return value.toString() == "true";
}

function getNumber(key) {
  let value = parseInt(getValue(key));
  if (Number.isNaN(value)) {
    value = 0;
  }
  return value;
}

function getJson(key) {
  let value = getValue(key);
  if (value == null) {
    value = "{}";
  }
  return JSON.parse(value);
}

function addToJson(key, jsonKey, value) {
  let json = getJson(key);
  let parent = json;
  jsonKey.split(".").forEach((e, index, array) => {
    if (index < array.length - 1) {
      if (!parent.hasOwnProperty(e)) {
        parent[e] = {};
      }
      parent = parent[e];
    } else {
      parent[e] = value;
    }
  });
  setValue(key, JSON.stringify(json));
  return json;
}

function removeFromJson(key, jsonKey) {
  let json = getJson(key);
  let parent = json;
  jsonKey.split(".").forEach((e, index, array) => {
    if (index < array.length - 1) {
      parent = parent[e];
    } else {
      delete parent[e];
    }
  });
  setValue(key, JSON.stringify(json));
  return json;
}

const optionsEntries = {
  "autofill-captcha": ["checkbox", "Autofill text captcha when in use (recommended, only disable if causing issues)", true],
  // "bypass-filter": ["checkbox", "Try to bypass word filter when posting", false],
  // "restore-filtered": ["checkbox", "Try to restore filtered words", false],
  "show-quote-button": ["checkbox", "Show quick quote button", true],
  "mass-reply-quote": ["checkbox", "Enable mass reply and mass quote buttons", false],
  "anonymise": ["checkbox", "Anonymise name and tripfags", false],
  "hover-images": ["checkbox", "Popup image on hover", true],
  "hover-on-catalog": ["checkbox", "Show image hover on the catalog", true],
  "hide-blotter": ["checkbox", "Always hide blotter", false],
  "truncate-long-posts": ["checkbox", "Truncate line spam", false],
  "disable-submit-on-cooldown": ["checkbox", "Disable submit button on cooldown", false],
  "desktop-triple-click": ["checkbox", "Enable triple click to hide catalog thread on desktop", false],
  "force-exact-time": ["checkbox", "Show exact time", false]
}
let options = Options.add_tab("sharty-fixes", "gear", "Sharty Fixes").content[0];
let optionsHTML = `<span style="display: block; text-align: center">${version}</span><br>`;
for ([optKey, optValue] of Object.entries(optionsEntries)) {
  optionsHTML += `<input type="${optValue[0]}" id="${optKey}" name="${optKey}"><label for="${optKey}">${optValue[1]}</label><br>`;
}
options.insertAdjacentHTML("beforeend", optionsHTML);

options.querySelectorAll("input[type=checkbox]").forEach(e => {
  e.checked = isEnabled(e.id);
  e.addEventListener("change", e => {
    setValue(e.target.id, e.target.checked);
  });
});

// redirect
if (location.origin.match(/(http:|\/www)/g)) {
  location.replace(`https://soyjak.party${location.pathname}${location.hash}`);
}

const board = window.location.pathname.split("/")[1];

// post fixes
const weekdays = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
if (document.body.classList.contains("active-thread")) {
  const updateObserver = new MutationObserver(list => {
    const evt = new CustomEvent("post_update", {
      detail: list
    });
    document.dispatchEvent(evt);
  });
  updateObserver.observe(document.querySelector(".thread"), {
    childList: true
  });
}

function fixPost(post) {
  let timeElement = post.querySelector("[datetime]");
  let time = new Date(Date.parse(timeElement.getAttribute("datetime")));
  let isOwnPost;
  try { isOwnPost = JSON.parse(localStorage.getItem("own_posts"))[board].includes(post.querySelector(".post_no[onclick*=cite]").innerText) } catch { isOwnPost = false };
  if (isOwnPost && getNumber("lastTime") < time.getTime()) {
    setValue("lastTime", time.getTime());
  }
  timeElement.outerHTML = `<span datetime=${timeElement.getAttribute("datetime")}>${timeElement.innerText}</span>`;
  post.querySelector(".intro").insertAdjacentHTML("beforeend", `<span class="quote-buttons"></span>`);
  if (isEnabled("show-quote-button")) {
    post.querySelector(".quote-buttons").insertAdjacentHTML("beforeend", `<a href="javascript:void(0);" class="quick-quote">[>]</a>`);
  }
  if (isEnabled("mass-reply-quote") && post.classList.contains("op") && post.closest(".active-thread")) {
    document.querySelector(".quote-buttons").insertAdjacentHTML("beforeend", `<a href="javascript:void(0);" id="mass-reply">[Mass Reply]</a><a href="javascript:void(0);" id="mass-quote">[Mass Quote]</a>`);
  }
  let body = post.querySelector(".body");
  body.childNodes.forEach(e => {
    if (e.nodeType == 3) {
      let span = document.createElement("span");
      span.innerText = e.textContent;
      e.parentNode.replaceChild(span, e);
    }
  });
  if (document.body.classList.contains("active-thread")) {
    let postNumber = post.getElementsByClassName("post_no")[1];
    postNumber.href = `#q${postNumber.textContent}`;
    postNumber.setAttribute("onclick", `$(window).trigger('cite', [${postNumber.textContent, null}]);`);
    postNumber.addEventListener("click", () => {
      let selection = window.getSelection().toString();
      document.querySelectorAll("textarea[name=body]").forEach(e => {
        e.value += `>>${postNumber.textContent}\n${selection != "" ? selection.replace(/(\r\n|\r|\n|^)/g, "$1>") : ""}`;
      });
    });
  }
  if (isEnabled("anonymise")) {
    post.querySelector(".name").textContent = "Chud";
    if (trip = post.querySelector(".trip")) {
      trip.remove();
    }
  }
  undoFilter(post);
}

function addExpandos() {
  if (isEnabled("truncate-long-posts")) {
    document.querySelectorAll(".post").forEach(e => {
      let body = e.querySelector(".body");
      e.classList.add("sf-cutoff");
      if (body.scrollHeight > body.offsetHeight) {
        if (!e.querySelector(".sf-expander")) {
          body.insertAdjacentHTML("afterend", `<br><a href="javascript:void(0)" class="sf-expander"></a>`);
        }
        if (e.getAttribute("manual-cutoff") == "false" || (window.location.hash.includes(e.id.split("_")[1]) && !e.getAttribute("manual-cutoff"))) {
          e.classList.remove("sf-cutoff");
        }
      } else if (body.scrollHeight == body.offsetHeight) {
        if (expander = e.querySelector(".sf-expander")) {
          expander.remove();
        }
        e.classList.remove("sf-cutoff");
      }
    });
  }
}

window.addEventListener("resize", () => addExpandos());


function fixTime() {
  document.querySelectorAll(".post").forEach(e => {
    let timeElement = e.querySelector("[datetime]");
    let time = new Date(Date.parse(timeElement.getAttribute("datetime")));
    let exactTime = `${("0" + (time.getMonth() + 1)).slice(-2)}/${("0" + time.getDate()).slice(-2)}/${time.getYear().toString().slice(-2)} (${weekdays[time.getDay()]}) ${("0" + time.getHours()).slice(-2)}:${("0" + time.getMinutes()).slice(-2)}:${("0" + time.getSeconds()).slice(-2)}`;
    let relativeTime;
    let difference = (Date.now() - time.getTime()) / 1000;
    if (difference < 10) {
      relativeTime = "Just now";
    } else if (difference < 60) {
      relativeTime = `${Math.floor(difference)} seconds ago`;
    } else if (difference < 120) {
      relativeTime = `1 minute ago`;
    } else if (difference < 3600) {
      relativeTime = `${Math.floor(difference/60)} minutes ago`;
    } else if (difference < 7200) {
      relativeTime = `1 hour ago`;
    } else if (difference < 86400) {
      relativeTime = `${Math.floor(difference/3600)} hours ago`;
    } else if (difference < 172800) {
      relativeTime = `1 day ago`;
    } else if (difference < 2678400) {
      relativeTime = `${Math.floor(difference/86400)} days ago`;
    } else if (difference < 5356800) {
      relativeTime = `1 month ago`;
    } else if (difference < 31536000) {
      relativeTime = `${Math.floor(difference/2678400)} months ago`;
    } else if (difference < 63072000) {
      relativeTime = `1 year ago`;
    } else {
      relativeTime = `${Math.floor(difference/31536000)} years ago`;
    }
    if (isEnabled("force-exact-time")) {
      timeElement.innerText = exactTime;
      timeElement.setAttribute("title", relativeTime);
    } else {
      timeElement.innerText = relativeTime;
      timeElement.setAttribute("title", exactTime);
    }
  });
}

function initFixes() {
  document.addEventListener("dyn_update", e => {
    e.detail.forEach(e => fixPost(e));
    fixTime();
    addExpandos();
  })

  document.addEventListener("post_update", e => {
    e.detail.forEach(node => {
      if (node.addedNodes[0].nodeName == "DIV") {
        fixPost(node.addedNodes[0]);
      }
    });
    fixTime();
    addExpandos();
  });
  [...document.getElementsByClassName("post")].forEach(e => {
    fixPost(e);
  });
  fixTime();
  addExpandos();
}

// undo filter
function undoFilter(post) {
  // if (isEnabled("restore-filtered")) {
  //   post.querySelectorAll(".body, .body *, .replies, .replies *").forEach(e => {
  //     e.childNodes.forEach(e => {
  //       if (e.nodeName == "#text") {
  //         e.nodeValue = e.nodeValue.replaceAll("im trans btw", "kuz");
  //       }
  //     });
  //   });
  // }
}

// catalog time fix
document.querySelectorAll("#Grid > div").forEach(e => {
  let threadTime = new Date(parseInt(e.getAttribute("data-time")) * 1000);
  e.getElementsByClassName("thread-image")[0].setAttribute("title", `${months[threadTime.getMonth()]} ${("0" + threadTime.getDate()).slice(-2)}` +
    ` ${("0" + threadTime.getHours()).slice(-2)}:${("0" + threadTime.getMinutes()).slice(-2)}`);
  undoFilter(e);
});

// overboard reporting
if (document.body.classList.contains("active-ukko")) {
  const overboardObserver = new MutationObserver(list => {
    const evt = new CustomEvent("overboard_load", {
      detail: list
    });
    document.dispatchEvent(evt);
  });
  overboardObserver.observe(document.querySelector("form[name=postcontrols]"), {
    childList: true,
    subtree: true
  });

  let fixOverboardReport = node => {
    node.setAttribute("action", "/post.php");
    node.lastChild.value = node.closest(".thread").getAttribute("data-board");
  };

  document.addEventListener("overboard_load", e => {
    e.detail.forEach(mut => {
      if (mut.addedNodes.length == 1) {
        let node = mut.addedNodes[0];
        if (node.classList && node.classList.contains("post-actions")) {
          fixOverboardReport(node);
        }
      }
    });
  });
  [...document.getElementsByClassName("post-actions")].forEach(e => {
    fixOverboardReport(e);
  });
}

// ctrl + enter to post
window.addEventListener("keydown", e => {
  if (e.key == "Enter" && (e.ctrlKey || e.metaKey)) {
    if (form = e.target.closest("form[name=post]")) {
      form.querySelector("input[type=submit]").click();
    }
  }
});

// autofocus textarea
if ((textarea = document.querySelector("textarea[name=body]")) && document.documentElement.classList.contains("desktop-style") && window.location.hash[1] != "q") {
  textarea.focus({
    preventScroll: true
  });
}

// automatically load text captcha
if (script = document.querySelector("td > script")) {
  console.log("Loading captcha...");
  let variables = Array.from(script.textContent.matchAll(/(?<=")[^",]*(?=")/g), m => m[0]);
  actually_load_captcha(variables[0], variables[1]);
}

// text captcha solver
function solveCaptcha() {
  let bodyColour = window.getComputedStyle(document.body).getPropertyValue("color");
  let captcha = document.querySelector(".captcha_html > div");
  let captchaBox = captcha.getBoundingClientRect();
  let rotationDict = {
    "ɐ": "a",
    "ə": "e",
    "b": "q",
    "d": "p",
    "n": "u",
    "p": "d",
    "q": "b",
    "u": "n",
    6: 9,
    9: 6,
  };
  let chars = [];
  document.querySelectorAll(".captcha_html div").forEach(e => {
    let charBox = e.getBoundingClientRect();
    let charStyle = window.getComputedStyle(e);
    if (e.innerText.length == 1 &&
        charBox.left > captchaBox.left - 5 &&
        charBox.right < captchaBox.right + 5 &&
        charBox.top > captchaBox.top - 5 &&
        charBox.bottom < captchaBox.bottom + 5 &&
        parseInt(charStyle.getPropertyValue("font-size")) > 15 &&
        parseInt(charStyle.getPropertyValue("height")) > 5 &&
        charStyle.getPropertyValue("overflow") != "hidden" &&
        charStyle.getPropertyValue("color") == bodyColour) {
      let character = e.innerText;
      if (charStyle.getPropertyValue("transform").match(/\(-/)) {
        if (rotationDict[e.innerText]) {
          character = rotationDict[e.innerText];
        }
      }
      chars.push([character, charBox.left]);
    }
  });
  if (chars.length == 3) {
    chars.sort((a, b) => (a[1] > b[1]) ? 1 : -1);
    document.querySelectorAll(".captcha_text").forEach(e => {
      e.value = `${chars[0][0]}${chars[1][0]}${chars[2][0]}`;
    });
  } else {
    console.log(`Failed to solve captcha, got ${chars.length} characters instead of 3.`);
    captcha.parentElement.click();
  }
}

if (passwordBox = document.querySelector("form[name=post] input[name=password]")) {
  passwordBox.setAttribute("type", "password");
  passwordBox.insertAdjacentHTML("afterend", `<input type="button" name="toggle-password" value="Show">`);
}

document.querySelectorAll("form[name=post] input[type=submit]").forEach(e => {
  e.setAttribute("og-value", e.getAttribute("value"));
});
setInterval(() => {
  let lastTime = getNumber("lastTime");
  let difference = 30 - Math.ceil((Date.now() - lastTime) / 1000);
  let buttons = document.querySelectorAll("form[name=post] input[type=submit]");
  if ([...buttons].find(e => e.value.includes("Post"))) {
    return;
  } else if (difference > 0) {
    let disableButton = isEnabled("disable-submit-on-cooldown");
    buttons.forEach(e => {
      e.value = `${e.getAttribute("og-value")} (${difference})`;
      if (disableButton) {
        e.setAttribute("disabled", "disabled");
      }
    });
  } else {
    buttons.forEach(e => {
      e.value = e.getAttribute("og-value");
      e.removeAttribute("disabled");
    });
  }
}, 100);

function areHiddenThreads() {
  let threadGrid = document.getElementById("Grid");
  if (document.querySelector(".catty-thread.hidden")) {
    if (!document.getElementById("toggle-hidden")) {
      document.querySelector(".desktop-style #image_size, .mobile-style header").insertAdjacentHTML("afterend", `<span id="toggle-hidden"></span>`); 
    }
  } else if (toggleButton = document.getElementById("toggle-hidden")) {
    toggleButton.remove();
    document.body.classList.remove("showing-hidden");
  }
}

if (document.body.classList.contains("active-catalog")) {
  document.querySelector("#image_size").insertAdjacentHTML("afterend", `
    <form style="display: inline-block; margin-bottom: 0px;" action="/search.php">
      <p>
        <input type="text" name="search" placeholder="${board} search">
        <input type="hidden" name="board" value="${board}">
        <input type="submit" value="Search">
      </p>
    </form>
  `);
  let hiddenThreads = getJson("hiddenthreads");
  let hasThreads = hiddenThreads.hasOwnProperty(board);
  document.querySelectorAll(".mix").forEach(e => {
    e.classList.replace("mix", "catty-thread");
    if (hasThreads && hiddenThreads[board].hasOwnProperty(e.getAttribute("data-id"))) {
      e.classList.add("hidden");
      delete hiddenThreads[board][e.getAttribute("data-id")];
    }
    if (e.getAttribute("data-sticky") == "true") {
      e.parentNode.prepend(e);
    }
  });
  
  if (hasThreads) {
    Object.keys(hiddenThreads[board]).forEach(e => {
      removeFromJson("hiddenthreads", `${board}.${e}`);
    });    
  }
  areHiddenThreads();
}

document.addEventListener("click", e => {
  let t = e.target;
  if (t.matches("input[type=submit]")) {
    // if (isEnabled("bypass-filter")) {
    //   let textbox = t.closest("tbody").querySelector("textarea[name=body]");
    //   textbox.value = textbox.value.replaceAll(/(kuz|bbc|bwc|tbp|twp)/ig, str => {
    //       return str.substr(0, 1) + "​" + str.substr(1);
    //   });
    // }
  } else if (t.matches("input[name=toggle-password]")) {
    if (passwordBox.getAttribute("type") == "password") {
      passwordBox.setAttribute("type", "text");
      t.value = "Hide";
    } else {
      passwordBox.setAttribute("type", "password");
      t.value = "Show";
    }
  } else if (t.id == "mass-reply") {
    let massReply = "";
    document.querySelectorAll("[href*='#q']").forEach(e => {
      massReply += `>>${e.textContent}\n`;
    });
    document.querySelectorAll("textarea[name=body]").forEach(e => {
      e.value += massReply;
      e.focus();
    });
  } else if (t.id == "mass-quote") {
    document.body.classList.add("hide-quote-buttons");
    let selection = window.getSelection();
    let range = document.createRange();
    range.selectNodeContents(document.body);
    selection.removeAllRanges();
    selection.addRange(range);
    let massQuote = window.getSelection().toString().replace(/(\r\n|\r|\n|^)/g, "$1>") + "\n";
    selection.removeAllRanges();
    document.body.classList.remove("hide-quote-buttons");
    document.querySelectorAll("textarea[name=body]").forEach(e => {
      e.value += massQuote;
      e.focus();
    });
  } else if (t.classList.contains("quick-quote")) {
    let quote = t.closest(".post").querySelector(".body").innerText.replace(/(\r\n|\r|\n|^)/g, "$1>") + "\n";
    document.querySelectorAll("textarea[name=body]").forEach(e => {
      e.value += quote;
      e.focus();
    });
  } else if ((e.shiftKey || (e.detail == 3 && (document.documentElement.matches(".mobile-style") || isEnabled("desktop-triple-click")))) &&
             t.matches(".active-catalog .catty-thread *, .active-catalog .catty-thread")) {
    e.preventDefault();
    let thread = t.closest(".catty-thread");
    thread.classList.toggle("hidden");
    if (thread.classList.contains("hidden")) {
      addToJson("hiddenthreads", `${board}.${thread.getAttribute("data-id")}`, Math.floor(Date.now() / 1000));
    } else {
      removeFromJson("hiddenthreads", `${board}.${thread.getAttribute("data-id")}`);
    }
    areHiddenThreads();
  } else if (t.id == "toggle-hidden") {
    document.body.classList.toggle("showing-hidden");
  } else if (t.classList.contains("hide-thread-link") || t.classList.contains("unhide-thread-link")) {
    setValue("hiddenthreads", localStorage.getItem("hiddenthreads"));
  } else if (t.classList.contains("hide-blotter")) {
    setValue("hidden-blotter", document.querySelector(".blotter").innerText);
    document.body.classList.add("hidden-blotter");
  } else if (t.classList.contains("sf-expander")) {
    t.closest(".post").setAttribute("manual-cutoff", t.closest(".post").classList.toggle("sf-cutoff"));
  } else if (t.matches("form[name=post] input[type=submit]")) {
    t.value = t.getAttribute("og-value");
  }
});

document.addEventListener("input", e => {
  let t = e.target;
  if (t.matches("input[name=search]") && document.querySelector(".sf-catty, .active-catalog")) {
    document.querySelectorAll(".catty-thread").forEach(e => {
      if (e.innerText.toLowerCase().includes(t.value.toLowerCase())) {
        e.classList.remove("sf-filtered");
      } else {
        e.classList.add("sf-filtered");
      }
    });
  }
});

window.addEventListener("load", () => {
  if (isEnabled("autofill-captcha") && document.querySelector(".captcha_html")) {
    const captchaObserver = new MutationObserver(list => {
      const evt = new CustomEvent("captcha_load", {
        detail: list
      });
      document.dispatchEvent(evt);
    });
    captchaObserver.observe(document.querySelector(".captcha_html"), {
      childList: true
    });

    if (document.querySelector(".captcha_html > div")) {
      console.log("Captcha already exists, solving.");
      solveCaptcha();
    }
    document.addEventListener("captcha_load", () => {
      solveCaptcha();
    });
  }
});

if (getValue("hover-images") && document.documentElement.matches(".desktop-style")) {
  let adjustHoverPos = (hover, x, y) => {
    if (!document.querySelector(".post-image:hover, .thread-image:hover")) {
      hover.remove();
    }
    if (x > document.documentElement.clientWidth / 2) {
      hover.style.maxWidth = `${x - 5}px`;
      hover.style.left = "";
      hover.style.right = `${document.documentElement.clientWidth - x + 5}px`
    } else {
      hover.style.left = `${x + 5}px`
      hover.style.right = "";
      hover.style.maxWidth = `${document.documentElement.clientWidth - x + 5}px`;
    }
    hover.style.maxHeight = `${document.documentElement.clientHeight}px`;
    if (hover.naturalHeight > document.documentElement.clientHeight) {
      hover.style.top = "0px";
    } else {
      if (y < hover.naturalHeight / 2) {
        hover.style.top = `0px`;
      } else if (document.documentElement.clientHeight - y < hover.naturalHeight / 2) {
        hover.style.top = `${document.documentElement.clientHeight - (hover.naturalHeight)}px`;
      } else {
        hover.style.top = `${y - (hover.naturalHeight / 2)}px`;
      }
    }
  }
  
  document.addEventListener("mouseover", e => {
    let t = e.target;
    if (((!document.body.classList.contains("active-catalog") && !document.querySelector("#dyn-content.theme-catalog")) || isEnabled("hover-on-catalog")) && 
        t.matches(".post-image, .thread-image") && !t.closest(".image-hidden") && !document.querySelector("#sharty-hover")) {
      let srcImg = t.getAttribute("src").replace("thumb", "src");
      if (srcImg.match("spoiler") && !document.body.classList.contains("active-catalog")) {
        srcImg = t.closest("#dyn-content.theme-catalog") ? t.parentNode.getAttribute("file-source") : t.parentNode.href;
      } else if (srcImg.match("deleted") || srcImg.match("spoiler")) {
        return;
      }
      document.body.insertAdjacentHTML("beforeend", `<img id="sharty-hover" onerror="this.style.display='none'" src=${srcImg}>`);
      let hover = document.getElementById("sharty-hover");
      let poll = setInterval(() => {
        if (hover.naturalWidth && hover.naturalHeight) {
          clearInterval(poll);
          adjustHoverPos(hover, e.x, e.y);
        }
      }, 10);
    }
  });
  
  document.addEventListener("mousemove", e => {
    if (hover = document.querySelector("#sharty-hover")) {
      adjustHoverPos(hover, e.x, e.y);
    }
  });
  
  document.addEventListener("mouseout", e => {
    let t = e.target;
    if ((hover = document.querySelector("#sharty-hover")) && t.matches(".post-image, .thread-image")) {
      hover.remove();
    }
  });
}

if (blotter = document.querySelector(".blotter")) {
  blotter.insertAdjacentHTML("beforebegin", `<a class="hide-blotter" href="javascript:void(0)">[–]</a>`);
  if (blotter.innerText == getValue("hidden-blotter") || isEnabled("hide-blotter")) {
    document.body.classList.add("hidden-blotter");
  }
}


document.head.insertAdjacentHTML("beforeend", `
<style>
  .hide-blotter {
    float: left;
  }
  
  .hidden-blotter .blotter,
  .hidden-blotter .blotter + hr,
  .hidden-blotter .hide-blotter,
  .catty-thread.hidden,
  .showing-hidden .catty-thread,
  .mobile-style .g-recaptcha-bubble-arrow,
  .catty-thread.sf-filtered,
  .showing-hidden .catty-thread.hidden.sf-filtered,
  .hide-quote-buttons .quote-buttons {
    display: none;
  }
  
  .reply .sf-expander {
    margin-left: 1.8em;
    padding-right: 3em;
    padding-bottom: 0.3em;
  }
  
  .sf-expander::after {
    content: "[Hide Full Text]"
  }
  
  .sf-cutoff .sf-expander::after {
    content: "[Show Full Text]"
  }
  
  #sharty-hover {
    pointer-events: none;
    position: fixed;
    z-index: 500;
  }
  
  .catty-thread, .showing-hidden .catty-thread.hidden {
    display: inline-block;
  }
  
  #toggle-hidden {
    text-decoration: underline;
    color: #34345C;
    cursor: pointer;
    user-select: none;
  }
  
  #toggle-hidden::before {
    content: "[Show Hidden]"
  }
  
  .showing-hidden #toggle-hidden::before {
    content: "[Hide Hidden]"
  }
  
  #image_size + #toggle-hidden {
    display: inline-block;
    padding-left: 5px;
  }
  
  header + #toggle-hidden {
    display: block;
    margin: 1em auto;
    width: fit-content;
  }
  
  .mobile-style .g-recaptcha-bubble-arrow + div {
    position: fixed !important;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    -webkit-transform: translate(-50%, -50%);
  }
  
  input[name=toggle-password] {
    margin-left: 2px;
  }
  
  ${isEnabled("truncate-long-posts") ? `
  .sf-cutoff:not(.post-hover) .body {
    overflow: hidden;
    word-break: break-all;
    display: -webkit-box;
    min-width: min-content;
    -webkit-line-clamp: 20;
    -webkit-box-orient: vertical;
  }
  
  .sf-cutoff.post-hover .sf-expander {
    display: none !important;
  }
  
  div.post.reply.sf-cutoff div.body {
    margin-bottom: 0.3em;
    padding-bottom: unset;
  }
  ` : ""};
</style>
`);

initFixes();


