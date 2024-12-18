document.getElementById("copyIcon").addEventListener("click", function () {
    const icon = document.getElementById("copyIcon");
    const old_icon_height = icon.height;
    const old_icon_width = icon.width;

    icon.src = "/images/ready-copy.png";
    icon.style.height = old_icon_height + 1 + "px";
    icon.style.width = old_icon_width + 1 + "px";

    const textToCopy = document.querySelector(".url-placeholder").textContent;
    navigator.clipboard.writeText(textToCopy).then(() => {
        setTimeout(() => {
            icon.style.height = old_icon_height + "px";
            icon.style.width = old_icon_width + "px";
            icon.src = "/images/copy.png";
        }, 2000);
    }).catch(err => {
        console.error("Failed to copy text: ", err);
    });
});
