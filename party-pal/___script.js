/* Thank you for using Party Pal v1.0 */

/* Created by Sharty Themes https://github.com/ShartyThemes */

// CSS CHECK

const phrase = 'CSS-V1-CHECK';
const StorageKeyCSS = "user_css";
const newCSS = '/* CSS-V1-CHECK */ @import "/party-pal/__style.css";';

function checkForCSS() {
  if (localStorage.getItem(StorageKeyCSS) === null) {
      localStorage.setItem(StorageKeyCSS, newCSS);
      location.reload();
  } else {
      const existingCSS = localStorage.getItem(StorageKeyCSS);
      if (!existingCSS.includes(phrase)) {
          localStorage.setItem(StorageKeyCSS, newCSS);
          location.reload();
      }
  }
}

checkForCSS();

// Start Screen

function createBootup() {
  const bootScreen = document.createElement('div');
  bootScreen.id = "boot-screen";
  bootScreen.innerHTML = `
    <p>Initializing Code...</p>
  `;
  document.body.appendChild(bootScreen);
  const line2 = document.createElement('p');
  const line3 = document.createElement('p');
  line2.innerHTML = 'Installing Dataminers...';
  line3.innerHTML = 'Starting Party Pal Version 1.0.0-alpha...';
  setTimeout(() => {
    bootScreen.appendChild(line2);
  }, 2000);
  setTimeout(() => {
    bootScreen.appendChild(line3);
  }, 4000);
  setTimeout(() => {
    hideBootScreen();
  }, 7000);
};

createBootup();

const bootScreen = document.getElementById("boot-screen");

document.querySelector('input[value="Update custom Javascript"]').addEventListener('click', resetBootHidden);

function resetBootHidden() {
  localStorage.removeItem("bootUp");
};

var startupSound = new Audio("/party-pal/sounds/startup.mp3");
startupSound.volume = 0.3;
const isBootUp = localStorage.getItem("bootUp");

function hideBootScreen() {
  bootScreen.classList.add('hidden');
  localStorage.setItem("bootUp", true);
  if (!isBootUp) {
    startupSound.play();
    setTimeout(() => {
      showReadyPopup();
    }, 6000);
  }
};

if (!isBootUp) {
  bootScreen.classList.remove("hidden");
} else {
  bootScreen.classList.add("hidden");
};

// Box 

const boxWrap = document.querySelector("div.box-wrap");

if (boxWrap) {
  boxWrap.setAttribute('id', 'main-box-wrap');
  function createPalBox() {
    const mainBoxWrap = document.getElementById("main-box-wrap");
    boxMiddle = mainBoxWrap.firstChild;
    const palBox = document.createElement('div');
    palBox.innerHTML = `
      <div id="pal-box-left"></div>
      <div id="pal-box-right" style="width: 50%;">
        <h2>Thank you for installing Party Pal!</h2>
        <p style="margin-left: 15px;">You're very own personal soyjak.party assistant!</p>
        <p style="margin-left: 15px;">Created by Sharty Themes <a href="https://github.com/ShartyThemes">https://github.com/ShartyThemes</a></p>
      </div>
    `;
    palBox.id = "pal-box";
    boxWrap.insertBefore(palBox, boxMiddle);
  };

  createPalBox();
};

// popup 

function createPopup() {
  const popup = document.createElement('div');
  popup.id = "popup";
  popup.classList.add('hidden');
  popup.classList.add('popup-styles');
  document.body.appendChild(popup);
};

createPopup();

const popup = document.getElementById('popup');

function playPopup() {
  var popSound = new Audio("/party-pal/sounds/popup.mp3");
  popSound.volume = 0.2;
  const pulsateAnimation = popup.getAnimations()[0];
  if (pulsateAnimation) {
    pulsateAnimation.cancel();
    pulsateAnimation.play();
  }
  popSound.play();
};

// Position Popup

let offsetX = 0;
let offsetY = 0;
let isDragging = false;

const movePopup = (event) => {
  if (!isDragging) return;
  const newX = event.clientX - offsetX;
  const newY = event.clientY - offsetY;

  const windowWidth = window.innerWidth;
  const windowHeight = window.innerHeight;

  const limitedX = Math.min(Math.max(newX, 0), windowWidth - popup.offsetWidth);
  const limitedY = Math.min(Math.max(newY, 0), windowHeight - popup.offsetHeight);

  popup.style.left = `${limitedX}px`;
  popup.style.top = `${limitedY}px`;
};

const startDrag = (event) => {
  offsetX = event.clientX - popup.offsetLeft;
  offsetY = event.clientY - popup.offsetTop;
  isDragging = true;
  popup.style.cursor = "grabbing";
  document.addEventListener("mousemove", movePopup);
  document.addEventListener("mouseup", stopDrag);
};

const stopDrag = () => {
  isDragging = false;
  popup.style.cursor = "default";
  document.removeEventListener("mousemove", movePopup);
  document.removeEventListener("mouseup", stopDrag);
};

popup.addEventListener("mousedown", startDrag);

// Ready 

function showReadyPopup() {
  popup.innerHTML = `
    <p>Hi, I'm Party Pal! Ready to take your soyjak.party experience to the next level?</p> 
    <div class="popup-btn-container">
      <button id="yes-btn">Yes</button>
    </div>
  `;
  document.getElementById('yes-btn').addEventListener('click', updateReadyPopupToOK);
  popup.classList.remove('hidden');
  playPopup();
  updateDanceAnimation();
}

function updateReadyPopupToOK() {
  popup.innerHTML = `
    <p>As you browse the site, I'll offer helpful tips whenever I think you might need them!</p>
    <div class="popup-btn-container">
      <button id="ok-btn">OK</button>
    </div>
  `;
  document.getElementById('ok-btn').addEventListener('click', hidePopup);
  updateDanceAnimation();
}

// Help 

let isPopupActive = false;

let allowSelectionCheck = true;

function showPopup(text, yesText) {
  popup.innerHTML = `
    <p>${text}</p> 
    <button id="yes-btn">Yes</button>
    <button id="no-btn">No</button>
  `;
  document.getElementById('yes-btn').addEventListener('click', () => updatePopupToOK(yesText));
  document.getElementById('no-btn').addEventListener('click', hidePopup);
  popup.classList.remove('hidden');
  isPopupActive = true;
  playPopup();
  updateDanceAnimation();
  checkActive = false;
  computeCheck.pause();
};

function hidePopup() {
  popup.classList.add('hidden');
  isPopupActive = false;
  allowSelectionCheck = true;
  isTextSelected();
};

function updatePopupToOK(yesText) {
  const newContent = `
    <p>${yesText}</p> 
    <button id="ok-btn">OK</button>
  `;
  popup.innerHTML = newContent;
  document.getElementById('ok-btn').addEventListener('click', hidePopup);
  updateDanceAnimation();
};

// Fact Check 

let checkActive = false;

var computeCheck = new Audio("/party-pal/sounds/compute.mp3");
var computeDone = new Audio("/party-pal/sounds/done.mp3");
computeCheck.volume = 0.2;
computeDone.volume = 0.2;


function showFactCheckPopup(resultImage, selectedText) {
  popup.innerHTML = `
    <p>I see you've highlighted some text. Would you like to run a fact check?</p> 
    <button id="yes-btn">Yes</button>
    <button id="no-btn">No</button>
  `;
  document.getElementById('yes-btn').addEventListener('click', () => updatePopupToCheckResult(resultImage, selectedText));
  document.getElementById('no-btn').addEventListener('click', hideCheckPopup);
  popup.classList.remove('hidden');
  playPopup();
  updateDanceAnimation();
  checkActive = false;
  computeCheck.pause();
};

function hideCheckPopup() {
  popup.classList.add('hidden');
  isPopupActive = false;
  allowSelectionCheck = false;
  computeCheck.pause();
  computeDone.pause();
  checkActive = false;
};

function updatePopupToCheckResult(resultImage, selectedText) {
  const FactImageContent = `
    <img id="fact-check-image" src="${resultImage}" alt="Fact Check Image" />
    <button id="ok-btn">OK</button>
  `;
  popup.innerHTML = FactImageContent;
  document.getElementById('ok-btn').addEventListener('click', hideCheckPopup);
  updateDanceAnimation();
  const factCheckResult = document.getElementById('fact-check-image');
  factCheckResult.style['max-width'] = '60px';
  allowSelectionCheck = false;
  computeDone.currentTime=0;
  computeCheck.currentTime=0;
  computeCheck.play();
  checkActive = true;
  setTimeout(() => {
    if (factCheckResult) {
      const imageUrls = [
        '/party-pal/images/accurate.png',
        '/party-pal/images/unsubstantiated.png',
        '/party-pal/images/misleading.png', 
        '/party-pal/images/false.png' 
      ];
      const randomIndex = Math.floor(Math.random() * imageUrls.length);
      factCheckResult.style['max-width'] = '150px';
      factCheckResult.src = imageUrls[randomIndex];
      computeCheck.pause();
      setTimeout(() => {
        playComputeDone();
      }, 200)
    }
  }, 3000)
};

function playComputeDone() {
  if (checkActive) {
    computeDone.play();
  }
}

document.addEventListener('mouseup', function() {
  const selectedText = window.getSelection().toString();
  if (selectedText.length > 4 && !isPopupActive) {
    showFactCheckPopup('/party-pal/images/loading.gif', selectedText);
    isPopupActive = true;
  }
});

function isTextSelected() {
  const selectedText = window.getSelection().toString();
  if (selectedText.length > 4 && allowSelectionCheck) {
    showFactCheckPopup('/party-pal/images/loading.gif', selectedText);
    isPopupActive = true;
  }
};

// Code Popup 

const updateJsButton = document.querySelector('input[value="Update custom Javascript"]');
const updateCssButton = document.querySelector('input[value="Update custom CSS"]');

function showCodePopup() {
  popup.innerHTML = `
    <p>It looks like you are messing with my code. Are you sure you know what you are doing?</p> 
    <button id="yes-btn">Yes</button>
    <button id="no-btn">No</button>
  `;
  document.getElementById('yes-btn').addEventListener('click', updatePopupToCodeOK);
  document.getElementById('no-btn').addEventListener('click', noCodePopup);
  popup.classList.remove('hidden');
  playPopup();
  checkActive = false;
  computeCheck.pause();
};

function updatePopupToCodeOK() {
  const newContent = `
    <p>Don't do anything you will regret.</p> <button id="ok-btn">OK</button>
  `;
  popup.innerHTML = newContent;
  document.getElementById('ok-btn').addEventListener('click', hideCodeYesPopup);
};

function noCodePopup() {
  updateJsButton.classList.add('hidden');
  updateCssButton.classList.add('hidden');
  hidePopup();
};

function hideCodeYesPopup() {
  popup.classList.add('hidden');
  updateJsButton.classList.remove('hidden');
  updateCssButton.classList.remove('hidden');
}

// Help texts 

const postImageHover = document.querySelectorAll('.post-image');
postImageHover.forEach(element => {
  element.addEventListener('mouseover', () => showPopup("It looks like you're trying to view an image. Would you like some help with that?", "Images provide a visual element to posts. The most commonly posted images are of soyjaks, which can be used to represent the poster's own feelings, or more often to mock the opinions of others. Tip: try clicking on an image to enlarge it."));
});

const postImageClick = document.querySelectorAll('.post-image');
postImageClick.forEach(element => {
  element.addEventListener('click', () => showPopup("It seems you've opened an image. Would you like some help?", 'Enlarging an image helps you see it better. You can click on it again to minimize it. You can also save it to your computer by right clicking on it and selecting "save image as".'));
});

const spanNameHover = document.querySelectorAll('span.name');
spanNameHover.forEach(element => {
  element.addEventListener('mouseover', () => showPopup("It look's like you're viewing a poster's name. Would you like some help with that?", 'Usernames help distinguish between different posters. The most active user is "Chud", who has made over 7 million posts!'));
});

const boardlistHover = document.querySelectorAll('.boardlist a');
boardlistHover.forEach(element => {
  element.addEventListener('mouseover', () => showPopup("It looks like you're trying to find a board. Would you like some help with that?", "The boardlist provides a list available boards for you to visit. Try clicking on one of them to see what that board is about."));
});

const postReplyHover = document.querySelectorAll('.post .body');
postReplyHover.forEach(element => {
  element.addEventListener('mouseover', () => showPopup("I see you're reading a post. Would you like some help with that?", "Posts contain messages made by other users. The first post in a thread is made by the OP or \"original poster\". The posts below that are replies. If you like a post, you can upvote it by calling it a \"gem\", or you can call a post \"coal\" to downvote it."));
});

const textAreaClick = document.querySelectorAll('table textarea');
textAreaClick.forEach(element => {
  element.addEventListener('click', () => showPopup("It looks like you're trying to write a post. Would you like some help with that?", "Creating a post allows you to share your ideas and converse with others. Always be sure to check that your post follows the rules of the board before submitting."));
});

const optionsTabClick = document.querySelectorAll('.options_tab');
optionsTabClick.forEach(element => {
  element.addEventListener('click', showCodePopup);
});

const styleClick = document.querySelectorAll('#style-select');
styleClick.forEach(element => {
  element.addEventListener('click', () => showPopup("I see you're browsing the styles. Would you like some help with that?", "Styles allow you to change the appearance of the website to different themes. Mutt theme still broken btw FIX IT NOW FROOT."));
});

// Eye 

function createEyeContainer() {
  const eyeContainer = document.createElement('div');
  eyeContainer.id = "eye-container";
  eyeContainer.innerHTML = `
    <input id="eye" type="button">
    <img id="pupil" src="/party-pal/images/pupil.svg">
  `;
  document.querySelector("h1").appendChild(eyeContainer);
};

createEyeContainer();

document.addEventListener('mousemove', (event) => {
  const eye = document.getElementById('eye-container');
  const pupil = document.getElementById('pupil');
  const eyeRect = eye.getBoundingClientRect();
  const eyeCenterX = eyeRect.left + eyeRect.width / 2;
  const eyeCenterY = eyeRect.top + eyeRect.height / 2;
  const mouseX = event.clientX;
  const mouseY = event.clientY;
  const deltaX = mouseX - eyeCenterX;
  const deltaY = mouseY - eyeCenterY;
  const maxPupilMove = (eyeRect.width - pupil.offsetWidth) / 2;
  const angle = Math.atan2(deltaY, deltaX);
  const distance = Math.hypot(deltaX, deltaY);
  const threshold = 10;
  let pupilX, pupilY;

  if (distance < threshold) {
    pupilX = (deltaX / threshold) * maxPupilMove * -1;
    pupilY = (deltaY / threshold) * maxPupilMove * -1;
  } else {
    pupilX = maxPupilMove * Math.cos(angle) * -1;
    pupilY = maxPupilMove * Math.sin(angle) * -1;
  }

  pupil.style.transform = `translate(-50%, -50%) translate(${pupilX}px, ${pupilY}px)`;
});

// Boardlist pal 
function createBoardlistPal() {
  const BoardlistPal = document.createElement('span');
  BoardlistPal.id = "pal-boardlist";
  BoardlistPal.innerHTML = `
    [ <p style="display: inline-block; color: #34345C; margin:0;">Party Pal</p> ]
  `;
  const boardlist = document.querySelector('.boardlist');
  boardlist.appendChild(BoardlistPal);
  BoardlistPal.setAttribute("class", "sub");
  BoardlistPal.setAttribute("data-description", "13");
};

createBoardlistPal();

// Options 

function createOptionsContainer() {
  const optionsContainer = document.createElement('div');
  optionsContainer.id = "options-container";
  optionsContainer.innerHTML = `
    <div class="options-background"></div>
  `;
  optionsContainer.classList.add('hidden');
  document.body.appendChild(optionsContainer);
};

createOptionsContainer();

function createOptionsPopup() {
  const optionsPopup = document.createElement('div');
  optionsPopup.id = "options-popup";
  optionsPopup.classList.add('popup-styles');
  document.querySelector('#options-container').appendChild(optionsPopup);
};

createOptionsPopup();

// Options popup

var OptionsPopupSound = new Audio("/party-pal/sounds/options.mp3");
OptionsPopupSound.volume = 0.2;

const optionsContainer = document.getElementById('options-container');
const optionsPopup = document.getElementById('options-popup');

function showOptionsPopup() {
  optionsPopup.innerHTML = `
    <p>How may I help you?</p>
    <div class="popup-btn-container">
      <button id="wiki-btn">Wiki</button>
      <button id="ru-btn">'Ru</button>
      <button id="music-btn">Music</button>
      <button id="options-ok-btn">Ok</button>
    </div>
  `;
  optionsContainer.classList.remove('hidden');
  popup.classList.add('hidden');
  document.getElementById('options-ok-btn').addEventListener('click', hideOptionsPopup);
  document.getElementById('wiki-btn').addEventListener('click', () => updateOptionsToWiki());
  document.getElementById('ru-btn').addEventListener('click', () => updateOptionsToRu());
  document.getElementById('music-btn').addEventListener('click', () => updateOptionsToMusic());
  updateDanceAnimation();
  checkActive = false;
  computeCheck.pause();
};

function updateOptionsToWiki() {
  optionsPopup.innerHTML = `
    <iframe src="https://wiki.soyjak.party/" style="width: 300px; height: 150px;"></iframe>
    <button id="options-back-btn">Back</button>
    <button id="options-ok-btn">Ok</button>
  `;
  document.getElementById('options-ok-btn').addEventListener('click', hideOptionsPopup);
  document.getElementById('options-back-btn').addEventListener('click', showOptionsPopup);
  updateDanceAnimation();
};

function updateOptionsToRu() {
  optionsPopup.innerHTML = `
    <iframe src="https://booru.soy/" style="width: 300px; height: 150px;"></iframe>
    <button id="options-back-btn">Back</button>
    <button id="options-ok-btn">Ok</button>
  `;
  document.getElementById('options-ok-btn').addEventListener('click', hideOptionsPopup);
  document.getElementById('options-back-btn').addEventListener('click', showOptionsPopup);
  updateDanceAnimation();
};

let currentPlaying = null;
let lastClickedButton = null;

function updateOptionsToMusic() {
  optionsPopup.innerHTML = `
    <p>Care for some tunes?</p>
    <button class="music-btns" style="background-color:red;" id="song1-btn">1</button>
    <button class="music-btns" style="background-color:blue;" id="song2-btn">2</button>
    <button class="music-btns" style="background-color:#00ff00;" id="song3-btn">3</button>
    <button class="music-btns" style="background-color:yellow;" id="song4-btn">4</button>
    <button id="options-back-btn">Back</button>
    <button id="options-ok-btn">Ok</button>
  `;
  updateDanceAnimation();
  document.getElementById('options-ok-btn').addEventListener('click', hideOptionsPopup);
  document.getElementById('options-back-btn').addEventListener('click', showOptionsPopup);
  document.getElementById('song1-btn').addEventListener('click', () => 
    toggleSong('/party-pal/sounds/I-Fucking-Love-Science.mp3', 'song1-btn'));
  document.getElementById('song2-btn').addEventListener('click', () => 
    toggleSong('/party-pal/sounds/cobman.mp3', 'song2-btn'));
  document.getElementById('song3-btn').addEventListener('click', () => 
    toggleSong('/party-pal/sounds/Papers-Please-Theme-Song.mp3', 'song3-btn'));
  document.getElementById('song4-btn').addEventListener('click', () => 
    toggleSong('/party-pal/sounds/own_nothing.mp3', 'song4-btn'));
};

function toggleSong(selectedSong, buttonId) {
  if (lastClickedButton === buttonId) {
    if (currentPlaying && !currentPlaying.paused) {
      currentPlaying.pause();
      toggleDanceAnimation(false);
    } else if (currentPlaying) {
      currentPlaying.play();
      toggleDanceAnimation(true);
    }
    return;
  }
  if (currentPlaying) {
    currentPlaying.pause();
    currentPlaying.currentTime = 0;
    toggleDanceAnimation(false);
  }

  currentPlaying = new Audio(selectedSong);
  currentPlaying.volume = 0.2;

  currentPlaying.play();
  toggleDanceAnimation(true);
  lastClickedButton = buttonId;
  
  currentPlaying.addEventListener('ended', () => {
    toggleDanceAnimation(false);
  });
  currentPlaying.addEventListener('pause', () => {
    toggleDanceAnimation(false);
  });

  currentPlaying.addEventListener('play', () => {
    toggleDanceAnimation(true);
  });
};

function toggleDanceAnimation(isPlaying) {
  const pal = document.querySelectorAll('.popup-styles p');
  pal.forEach(element => {
    if (isPlaying) {
      element.classList.add('dance');
    } else {
      element.classList.remove('dance');
    }
  });
};

function updateDanceAnimation() {
  const isPlaying = currentPlaying && !currentPlaying.paused;
  toggleDanceAnimation(isPlaying);
};

function hideOptionsPopup() {
  optionsContainer.classList.add('hidden');
};

document.getElementById('pal-boardlist').addEventListener('click', showOptionsPopup);
document.getElementById('pal-boardlist').addEventListener('click', () => { OptionsPopupSound.play();});
