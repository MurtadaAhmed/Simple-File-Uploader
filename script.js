document.addEventListener("DOMContentLoaded", function (){
    const fileList = document.getElementById('fileList');
    const uploadForm = document.getElementById('uploadForm');

    async function loadFiles(page = 1) {
        const response = await fetch(`scripts/list_files.php?page=${page}`);
        const files = await response.json();
        fileList.innerHTML = files.map(file => `<div><a href="uploads/user_${user_id}/${file}" download>${file}</a> </div>`).join("");
    }

    uploadForm.addEventListener("submit", async (e) => {
        e.preventDefault();
        const formData = new FormData(uploadForm);
        const response = await fetch("scripts/upload.php", {method: "POST", body: formData});
        const result = await response.text();
        alert(result)
        loadFiles();
    });
    loadFiles();
});