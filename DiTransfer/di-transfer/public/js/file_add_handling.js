let selectedFiles = [];
const MAX_SPACE_GB = 2;
const MAX_SPACE_BYTES = MAX_SPACE_GB * 1024 * 1024 * 1024;

function addFiles(event) {
    const files = Array.from(event.target.files);
    selectedFiles = [...selectedFiles, ...files];
    displayFileNames();
    updateSpaceLeft();
}

function displayFileNames() {
    const fileList = document.getElementById('file-list');
    fileList.innerHTML = '';
    selectedFiles.forEach((file, idx) => {
        const fileItem = document.createElement('div');
        const line = document.createElement('div');
        const icon = document.createElement('img');

        icon.src = '/images/verified.png';
        icon.alt = 'Verified';
        icon.classList.add('inline-block', 'w-4', 'h-4', '-mt-1', 'mr-2');

        line.classList.add('bg-gray-100', 'min-h-0.5');
        fileItem.textContent = file.name;
        fileItem.classList.add('rounded', 'whitespace-nowrap');
        fileItem.prepend(icon);
        fileList.appendChild(fileItem);

        if (idx !== selectedFiles.length - 1) {
            fileList.appendChild(line);
        }
        fileList.scrollTop = fileList.scrollHeight;
    });
}

function updateSpaceLeft() {
    const totalSize = selectedFiles.reduce((acc, file) => acc + file.size, 0);
    const spaceLeftBytes = MAX_SPACE_BYTES - totalSize;
    const spaceLeftGB = (spaceLeftBytes / (1024 * 1024 * 1024)).toFixed(2);
    const notEnoughSpaceText = document.querySelector('.no-space');
    const progressBarWrapper = document.querySelector('.progress-bar');
    const progressBarFilled = document.querySelector('.progress-bar-filled');

    if (spaceLeftBytes < 0) {
        notEnoughSpaceText.style.display = 'block';
        progressBarWrapper.style.display = 'none';
        progressBarFilled.style.display = 'none';
        selectedFiles.pop();
        displayFileNames();
        return;
    } else {
        progressBarWrapper.style.display = 'flex';
        notEnoughSpaceText.style.display = 'none';
        progressBarFilled.style.display = 'flex';
    }

    const spaceLeftText = document.getElementById('space-left');
    spaceLeftText.textContent = `${spaceLeftGB} GB`;

    const progressBar = document.getElementById('progress-bar');
    const usedSpacePercentage = ((MAX_SPACE_BYTES - spaceLeftBytes) / MAX_SPACE_BYTES) * 100;
    progressBar.style.width = `${usedSpacePercentage}%`;
}
