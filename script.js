console.log('Script loaded');
document.addEventListener('DOMContentLoaded', function () {
    function loadFiles(page = 1) {
        fetch(`../scripts/list_files.php?page=${page}`)
            .then(response => response.json())
            .then(data => {
                const fileList = document.getElementById('fileList');
                fileList.innerHTML = '';

                if (data.files.length === 0) {
                    fileList.innerHTML = '<p>No files uploaded yet.</p>';
                    return;
                }

                function formatFileSize(bytes) {
                    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                    if (bytes === 0) return '0 Bytes';
                    const i = Math.floor(Math.log(bytes) / Math.log(1024));
                    return (bytes / Math.pow(1024, i)).toFixed(2) + " " + sizes[i];
                }

                data.files.forEach(file => {
                    const fileDiv = document.createElement('div');
                    fileDiv.className = 'col-md-4 mb-4';
                    fileDiv.innerHTML = `
                        <div class="card shadow-sm h-100">
                        <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                        <h5 class="card-title text-truncate" title="${file.file_name}">${file.file_name}</h5>
                        <p class="text-muted small">
                        Size: ${formatFileSize(file.file_size)} <br>
                        Uploaded: ${new Date(file.upload_date).toLocaleString()}
                        </p>
                        </div>
                        <div class="mt-3">
                        <a href="${file.file_url}" target="blank" class="btn btn-primary btn-sm mb-2 w-100" download>Download</a> 
                        <button class="delete-btn btn btn-danger btn-sm w-100" data-id="${file.id}">Delete</button>
                        </div>
                        </div>
                        </div>
                    `;
                    fileList.appendChild(fileDiv);
                });

                const pagination = document.createElement('div');
                pagination.className = 'pagination';

                for (let i = 1; i <= data.total_pages; i++) {
                    const pageButton = document.createElement('button');
                    pageButton.textContent = i;
                    pageButton.className = (i === page) ? 'active' : '';
                    pageButton.addEventListener('click', () => loadFiles(i));
                    pagination.appendChild(pageButton);
                }

                fileList.appendChild(pagination);


                document.querySelectorAll('.delete-btn').forEach(button => {
                    button.addEventListener('click', function () {
                        const fileId = this.dataset.id;
                        deleteFile(fileId);
                    });
                });
            });
    }


    function deleteFile(fileId) {
        fetch('../scripts/delete.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id: fileId }),
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('File deleted successfully!');
                    loadFiles();
                } else {
                    alert('Failed to delete file.');
                }
            });
    }


    document.getElementById('uploadForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(this);
        const progressBar = document.getElementById('uploadProgress');
        progressBar.style.width = '0%';
        progressBar.parentElement.style.display = 'block';

        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../scripts/upload.php', true)

        xhr.upload.onprogress = function (event) {
            if (event.lengthComputable) {
            const percentageComplete = Math.round((event.loaded / event.total) * 100);
            progressBar.style.width = percentageComplete + '%';
            progressBar.textContent = percentageComplete + '%';
            }
        };

        xhr.onload = function () {
            const uploadMessage = document.getElementById('uploadMessage');
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    uploadMessage.textContent = 'File uploaded successfully!'
                    loadFiles();
                } else {
                    uploadMessage.textContent = 'Failed to upload file.';
                }
            } else {
                uploadMessage.textContent = 'An error occurred during the upload.';
            }
            progressBar.parentElement.style.display = 'none';
        };

        xhr.send(formData)

    });

    loadFiles();
});