async function zipAndUpload() {
    try {
        const zipBlob = await createZip();
        if (!zipBlob) {
            console.error("ZIP creation failed.");
            return;
        }

        const formData = new FormData();
        formData.append('file', new Blob([zipBlob], { type: 'application/zip' }), 'files.zip');

        const csrfToken = document.querySelector('input[name="_token"]').value;
        if (!csrfToken) {
            console.error("CSRF token is missing.");
            return;
        }
        formData.append('_token', csrfToken);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/upload-zip', true);

        xhr.upload.addEventListener('progress', function (e) {
            if (e.lengthComputable) {
                const percentComplete = (e.loaded / e.total) * 100;
                document.getElementById('progress-bar').style.width = `${percentComplete}%`;
            }
        });

        xhr.onload = function () {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                document.getElementsByClassName('url-placeholder')[0].textContent = response.downloadLink;
            } else {
                console.error(`Error: ${xhr.status} - ${xhr.statusText}`);
                console.error("Response:", xhr.responseText);
            }
        };

        xhr.onerror = function () {
            console.error("A network error occurred.");
        };

        xhr.send(formData);
    } catch (error) {
        console.error("An unexpected error occurred:", error);
    }
}
