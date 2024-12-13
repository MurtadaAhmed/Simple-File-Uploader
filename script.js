document.addEventListener('DOMContentLoaded', function () {
    // Function to fetch and display files
    function loadFiles(page = 1) {
        fetch(`scripts/list_files.php?page=${page}`)
            .then(response => response.json())
            .then(data => {
                const fileList = document.getElementById('fileList');
                fileList.innerHTML = ''; // Clear the current list

                if (data.files.length === 0) {
                    fileList.innerHTML = '<p>No files uploaded yet.</p>';
                    return;
                }

                data.files.forEach(file => {
                    const fileDiv = document.createElement('div');
                    fileDiv.className = 'file-item';
                    fileDiv.innerHTML = `
                        <p>${file.file_name}</p>
                        <button class="delete-btn" data-id="${file.id}">Delete</button>
                    `;
                    fileList.appendChild(fileDiv);
                });

                // Pagination controls
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

                // Add event listeners for delete buttons
                document.querySelectorAll('.delete-btn').forEach(button => {
                    button.addEventListener('click', function () {
                        const fileId = this.dataset.id;
                        deleteFile(fileId);
                    });
                });
            });
    }

    // Function to delete a file
    function deleteFile(fileId) {
        fetch('scripts/delete.php', {
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
                    loadFiles(); // Reload the files
                } else {
                    alert('Failed to delete file.');
                }
            });
    }

    // Initial file load
    loadFiles();
});
