async function createZip() {
    if (!selectedFiles || selectedFiles.length === 0) {
        console.error("No files selected for zipping.");
        return null;
    }

    const zip = new JSZip();
    const totalFiles = selectedFiles.length;

    console.log("Starting to add files to ZIP...");

    let processedFiles = 0;

    for (const file of selectedFiles) {
        console.log(`Processing file: ${file.name}, Size: ${file.size} bytes`);

        const fileData = await file.arrayBuffer();
        zip.file(file.name, fileData);

        processedFiles++;
        console.log(`Processed ${processedFiles} of ${totalFiles} files.`);
    }

    console.log("All files added to ZIP. Starting compression...");

    const progressBarLeft = document.querySelector(".progress-bar-left-text");
    const progressBarRight = document.querySelector(".progress-bar-right-text");

    progressBarLeft.textContent = "Zipping file:";

    const zipBlob = await zip.generateAsync(
        { type: "blob", streamFiles: true },
        function updateCallback(metadata) {
            progressBarRight.textContent = `${metadata.percent.toFixed(2)}%`;
            document.getElementById('progress-bar').style.width = `${metadata.percent.toFixed(2)}%`;
        }
    );

    if (zipBlob.size === 0) {
        console.error("ZIP creation failed: File is empty.");
        return null;
    }

    const uploadElements = document.querySelectorAll(".upload");
    const resultElements = document.querySelectorAll(".results");

    uploadElements.forEach(e => {
        e.style.display = "none";
    })

    resultElements.forEach(e => {
        e.style.display = "flex";
    })

    return zipBlob;
}
