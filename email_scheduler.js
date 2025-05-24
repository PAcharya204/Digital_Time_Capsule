function sendEmails() {
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "send_capsule.php", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let response = JSON.parse(xhr.responseText);
            if (response.status === "success") {
                console.log(`✅ Emails Sent: ${response.emails_sent}`);
            } else {
                console.error(`❌ Error: ${response.message}`);
            }
        }
    };
    xhr.send();
}

// Run sendEmails() **every 30 seconds** in the background
setInterval(sendEmails, 30000);
