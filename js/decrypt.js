if (Uint8Array.fromBase64 === undefined) {
  Uint8Array.fromBase64 = (b64) => { return Uint8Array.from(atob(b64), c => c.charCodeAt(0)); };
}

$(async() => {
  const isMod = document.querySelector(".is-moderator") !== null;
  if (active_page != "thread" && !isMod) {
    return;
  }

  const encryptedBodies = document.querySelectorAll(".encrypted-body");
  if (encryptedBodies.length == 0 && document.querySelector(".encrypted-thread-icon") === null) {
    return;
  }

  async function getKey(b64Key) {
    return await window.crypto.subtle.importKey(
      "raw",
      Uint8Array.fromBase64(b64Key),
      "AES-CBC",
      false,
      ["decrypt"]
    );
  }

  async function decryptMessage(b64Cipher, b64Iv, key) {
    const decrypted = await window.crypto.subtle.decrypt(
      {
        name: "AES-CBC",
        iv: Uint8Array.fromBase64(b64Iv),
      },
      key,
      Uint8Array.fromBase64(b64Cipher),
    );

    return new TextDecoder().decode(decrypted);
  }

  async function decryptBody(encryptedBody, key) {
    const cipherText = JSON.parse(encryptedBody.innerHTML);
    const decryptedBody = await decryptMessage(cipherText["data"], cipherText["iv"], key);
    encryptedBody.parentElement.innerHTML = decryptedBody;
  }

  if (active_page == "thread") {
    const r = await fetch("/decrypt.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: new URLSearchParams({ board: board_name, thread: thread_id, json_response: 1 }),
    });
    if (!r.ok) {
      throw new Error("Couldn't get key, response code: " + r.status);
    }

    const keyJson = await r.json();
    if (!keyJson["success"]) {
      throw new Error("Couldn't get key, response: " + await r.text());
    }

    const key = await getKey(keyJson["key"]);

    $(document).on("new_post", async(e,post) => {
      const encryptedBody = post.querySelector(".encrypted-body");
      await decryptBody(encryptedBody, key);
    });

    for (let i = 0; i < encryptedBodies.length; i++) {
      await decryptBody(encryptedBodies[i], key);
    }
  }
  else if (isMod) {
    for (let i = 0; i < encryptedBodies.length; i++) {
      const body = encryptedBodies[i].parentElement;
      const report = body.querySelector(".report");

      const b64Key = body.parentElement.querySelector(".encryption-key").innerHTML;
      const key = await getKey(b64Key);
      await decryptBody(encryptedBodies[i], key);

      if (report !== null) {
        body.innerHTML += report.innerHTML;
      }
    }
  }
});
