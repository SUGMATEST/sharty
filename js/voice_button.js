function openPopup(url) {
	const width = 800;
	const height = 600;
	const left = (screen.width - width) / 2;
	const top = (screen.height - height) / 2;
	window.open(url, 'voice-popup', `width=${width},height=${height},top=${top},left=${left}`);
}

async function getUserCountOfRoom(roomName) {
	var url = "/voice_room_data.php?room=" + roomName;
	var response = await fetch(url);
	var data = await response.text();
	return data;
}

function createVoiceChatButton() {
    if (typeof thread_id == "undefined") {
        return;
    }
    
    var str = "op_" + thread_id;
    const threadElement = document.getElementById(str);
    if (!threadElement) return;

    const firstP = threadElement.querySelector('p');
    if (!firstP) return;

    const quoteLink = firstP.querySelector('a.post_quote');
    if (!quoteLink) return;

    const voiceSpan = document.createElement('span');
    voiceSpan.id = 'voice-channel';

	let room = board_name + "-" + thread_id; 
	let href = "/voice2.html?room=" + room;

    const button = document.createElement('a');
    button.id = 'subscribe-button';
    button.href = 'javascript:void(0);';
    button.onclick = () => openPopup(href);
    

    voiceSpan.appendChild(button);

    quoteLink.insertAdjacentElement('afterend', voiceSpan);
    quoteLink.insertAdjacentText('afterend', ' ');

	button.innerText = '[Voice Chat]';

	getUserCountOfRoom(room).then((count) => {
		if (count > 0) {
			button.innerText = '[Voice Chat (' + count + ')]';
		}
	});
}
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        createVoiceChatButton();
    });
} else {
    createVoiceChatButton();
}
