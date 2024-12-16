function sendToServer(fileUrl) {
    fetch('/save-file-url', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
        },
        body: JSON.stringify({ fileUrl: fileUrl }),
    })
        .then(response => response.json())
        .then(data => console.log(data.message))
        .catch(error => console.error('Error sending URL to server:', error));
}
