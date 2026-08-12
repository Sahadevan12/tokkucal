import { postForm } from '../http.js';

const dropzone = document.getElementById('compressor-dropzone');
if (dropzone) {
    const fileInput = document.getElementById('compressor-file-input');
    const fileError = document.getElementById('compressor-file-error');
    const controls = document.getElementById('compressor-controls');
    const preview = document.getElementById('compressor-preview');
    const filenameEl = document.getElementById('compressor-filename');
    const originalSizeEl = document.getElementById('compressor-original-size');
    const qualityInput = document.getElementById('compressor-quality');
    const qualityValue = document.getElementById('compressor-quality-value');
    const compressBtn = document.getElementById('compressor-compress-btn');
    const resetBtn = document.getElementById('compressor-reset-btn');
    const resultCard = document.getElementById('compressor-result');
    const downloadBtn = document.getElementById('compressor-download-btn');
    const actionUrl = dropzone.dataset.action;

    const MAX_SIZE = 10 * 1024 * 1024;
    const ALLOWED_TYPES = ['image/jpeg', 'image/png', 'image/webp'];

    let currentFile = null;

    function formatBytes(bytes) {
        if (bytes < 1024) return `${bytes} B`;
        if (bytes < 1024 * 1024) return `${(bytes / 1024).toFixed(1)} KB`;
        return `${(bytes / (1024 * 1024)).toFixed(2)} MB`;
    }

    function showError(message) {
        fileError.textContent = message;
        fileError.classList.remove('hidden');
    }

    function clearError() {
        fileError.textContent = '';
        fileError.classList.add('hidden');
    }

    function selectFile(file) {
        clearError();
        resultCard.classList.add('hidden');

        if (!file) return;
        if (!ALLOWED_TYPES.includes(file.type)) {
            showError('Please choose a JPG, PNG or WebP image.');
            return;
        }
        if (file.size > MAX_SIZE) {
            showError('That file is larger than 10MB. Please choose a smaller image.');
            return;
        }

        currentFile = file;
        preview.src = URL.createObjectURL(file);
        filenameEl.textContent = file.name;
        originalSizeEl.textContent = formatBytes(file.size);
        controls.classList.remove('hidden');
    }

    dropzone.addEventListener('click', () => fileInput.click());
    dropzone.addEventListener('keydown', (event) => {
        if (event.key === 'Enter' || event.key === ' ') {
            event.preventDefault();
            fileInput.click();
        }
    });
    dropzone.addEventListener('dragover', (event) => {
        event.preventDefault();
        dropzone.classList.add('border-indigo-500');
    });
    dropzone.addEventListener('dragleave', () => dropzone.classList.remove('border-indigo-500'));
    dropzone.addEventListener('drop', (event) => {
        event.preventDefault();
        dropzone.classList.remove('border-indigo-500');
        selectFile(event.dataTransfer.files[0]);
    });
    fileInput.addEventListener('change', () => selectFile(fileInput.files[0]));

    qualityInput.addEventListener('input', () => {
        qualityValue.textContent = qualityInput.value;
    });

    resetBtn.addEventListener('click', () => {
        currentFile = null;
        fileInput.value = '';
        controls.classList.add('hidden');
        resultCard.classList.add('hidden');
        clearError();
    });

    compressBtn.addEventListener('click', async () => {
        if (!currentFile) return;
        clearError();

        const formData = new FormData();
        formData.append('image', currentFile);
        formData.append('quality', qualityInput.value);

        compressBtn.disabled = true;
        compressBtn.textContent = 'Compressing…';

        try {
            const result = await postForm(actionUrl, formData);

            document.getElementById('compressor-result-original').textContent = formatBytes(result.original_size);
            document.getElementById('compressor-result-compressed').textContent = formatBytes(result.compressed_size);
            document.getElementById('compressor-result-saved').textContent = `${result.percent_saved}%`;

            const extension = result.mime.split('/')[1] ?? 'jpg';
            downloadBtn.href = result.data_uri;
            downloadBtn.download = currentFile.name.replace(/\.[^.]+$/, '') + `-compressed.${extension}`;

            resultCard.classList.remove('hidden');
            resultCard.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        } catch (error) {
            showError(error.message || 'Something went wrong while compressing that image.');
        } finally {
            compressBtn.disabled = false;
            compressBtn.textContent = 'Compress Image';
        }
    });
}
