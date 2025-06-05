window.voice_integration = (function () {
	"use strict";

	var voice_integration = {};
	var isRecording = false;
	var mediaRecorder;
	var audioChunks = [];

	function createButton(id, text, onClick) {
		var button = document.createElement("button");
		button.id = id;
		button.className = "btn";
		button.innerText = text;
		button.onclick = onClick;
		return button;
	}

	function startRecording() {
		isRecording = true;
		navigator.mediaDevices.getUserMedia({ audio: true })
			.then(stream => {
				mediaRecorder = new MediaRecorder(stream);
				mediaRecorder.ondataavailable = event => {
					audioChunks.push(event.data);
				};
				mediaRecorder.start();
			});
		$("#btnRecord").prop('disabled', true);
		$("#btnFinish").prop('disabled', false);
		$("#btnAbort").prop('disabled', false);
	}

	function finishRecording() {
		isRecording = false;
		mediaRecorder.stop();
		mediaRecorder.onstop = () => {
			var audioBlob = new Blob(audioChunks, { type: 'audio/wav' });
			var fileName = "Voice - " + new Date().toISOString().replace(/:/g, "-") + ".wav";
			var file = new File([audioBlob], fileName, { type: "audio/wav" });
			window.addFile(file);
			audioChunks = [];
			clearWidget();
		};
		$("#btnRecord").prop('disabled', false);
		$("#btnFinish").prop('disabled', true);
		$("#btnAbort").prop('disabled', true);
	}

	function abortRecording() {
		isRecording = false;
		mediaRecorder.stop();
		audioChunks = [];
		clearWidget();
		$("#btnRecord").prop('disabled', false);
		$("#btnFinish").prop('disabled', true);
		$("#btnAbort").prop('disabled', true);
	}

	function clearWidget() {
		$("#voice_integration").remove();
		$("#upload_voice").hide();
	}

	voice_integration.show = function () {
		var container = $("<div>", { id: "voice_integration" });

		var btnRecord = createButton("btnRecord", "Record", startRecording);
		var btnFinish = createButton("btnFinish", "Finish", finishRecording);
		var btnAbort = createButton("btnAbort", "Abort", abortRecording);

		btnFinish.disabled = true;
		btnAbort.disabled = true;

		container.append(btnRecord);
		container.append(btnFinish);
		container.append(btnAbort);

		$("#upload_voice td").append(container);
		$("#upload_voice").show();
	};

	return voice_integration;
})();