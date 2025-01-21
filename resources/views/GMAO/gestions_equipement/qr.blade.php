<script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>

<div id="qr-reader" style="width: 500px"></div>
<div id="qr-reader-results"></div>

<script>
    function onScanSuccess(decodedText, decodedResult) {
        // Traite le texte du QR code (decodedText)
        document.getElementById('qr-reader-results').innerText = `QR Code Scanned: ${decodedText}`;

        // Par exemple, envoie les données via AJAX à Laravel
        fetch('/process-qr-code', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({qr_data: decodedText})
        })
        .then(response => response.json())
        .then(data => {
            console.log('Success:', data);
        })
        .catch((error) => {
            console.error('Error:', error);
        });
    }

    var html5QrcodeScanner = new Html5QrcodeScanner(
        "qr-reader", { fps: 10, qrbox: 250 });
    html5QrcodeScanner.render(onScanSuccess);
</script>
