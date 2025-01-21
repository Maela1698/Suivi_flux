<!DOCTYPE html>
<html>
<head>
    <title>Prendre une photo</title>
</head>
<body>
    <h1>Prendre une photo</h1>
    <video id="video" width="320" height="240" autoplay></video>
    <button id="snap">Prendre la photo</button>
    <canvas id="canvas" width="320" height="240"></canvas>

    <form id="photo-form" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="imageData" name="image">
        <button type="submit">Envoyer la photo</button>
    </form>

    <script>
        const video = document.querySelector('#video');
        const canvas = document.querySelector('#canvas');
        const snap = document.querySelector('#snap');
        const photoForm = document.querySelector('#photo-form');
        const imageData = document.querySelector('#imageData');

        // Accéder à la caméra
        navigator.mediaDevices.getUserMedia({ video: true })
            .then((stream) => {
                video.srcObject = stream;
            });

        // Prendre la photo
        snap.addEventListener('click', () => {
            const context = canvas.getContext('2d');
            context.drawImage(video, 0, 0, 320, 240);
            const dataUrl = canvas.toDataURL('image/png');
            imageData.value = dataUrl;
        });

        // Envoyer la photo à Laravel
        photoForm.addEventListener('submit', (event) => {
            event.preventDefault();

            fetch('/upload-photo', {
                method: 'POST',
                body: new FormData(photoForm)
            })
            .then(response => response.json())
            .then(data => console.log(data));
        });
    </script>
</body>
</html>
