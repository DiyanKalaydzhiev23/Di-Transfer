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

        // Add the whole file to the ZIP archive
        const fileData = await file.arrayBuffer();
        zip.file(file.name, fileData);

        processedFiles++;
        console.log(`Processed ${processedFiles} of ${totalFiles} files.`);
    }

    console.log("All files added to ZIP. Starting compression...");

    const zipBlob = await zip.generateAsync(
        { type: "blob", streamFiles: true },
        function updateCallback(metadata) {
            console.log(`Zipping progress: ${metadata.percent.toFixed(2)}%`);
        }
    );

    console.log(`ZIP Blob Size: ${zipBlob.size} bytes`);
    if (zipBlob.size === 0) {
        console.error("ZIP creation failed: File is empty.");
        return null;
    }

    console.log("ZIP file created successfully!");
    console.log(`ZIP Blob Size: ${zipBlob.size} bytes`);
    return zipBlob;
}
