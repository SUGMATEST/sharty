<?php
include_once "inc/bootstrap.php";

if (isset($_POST['integrity-v2'])) {
	$decryptedData = decrypt_integrity($_POST['integrity-v2']);
	if (is_array($decryptedData)) {
		insert_integrity($decryptedData);

		if (
			$decryptedData['lsf'] == array(-364725366,-259055925,1991645439,1222367517) ||
			$decryptedData['lsf'] == array(-1142913819,-1238234588,-1634171440,1178897608)
		) {
			error_log("ACK!");
			http_response_code(234);
			header("Content-Type: text/javascript; charset=utf-8");
			echo "document.body.remove(); location = \"https://files.catbox.moe/p4iewf.mp4\";";
		}
	}
}

