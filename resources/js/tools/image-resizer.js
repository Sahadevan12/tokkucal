import { postForm } from '../http.js';

const dropzone = document.getElementById('resizer-dropzone');
if (dropzone) {
    const fileInput = document.getElementById('resizer-file-input');
    const fileError = document.getElementById('resizer-file-error');
    const controls = document.getElementById('resizer-controls');
    const preview = document.getElementById('resizer-preview');
    const filenameEl = document.getElementById('resizer-filename');
    const originalDimsEl = document.getElementById('resizer-original-dims');
    const widthInput = document.getElementById('width');
    const heightInput = document.getElementById('height');
    const maintainRatioInput = document.getElementById('resizer-maintain-ratio');
    const outputFormatSelect = document.getElementById('resizer-output-format');
    const presetButtons = document.querySelectorAll('.resizer-preset-btn');
    const resizeBtn = document.getElementById('resizer-resize-btn');
    const resetBtn = document.getElementById('resizer-reset-btn');
    const resultCard = document.getElementById('resizer-result');
    const downloadBtn = document.getElementById('resizer-download-btn');
    const actionUrl = dropzone.dataset.action;

    const MAX_SIZE = 10 * 1024 * 1024;
    const ALLOWED_TYPES = ['image/jpeg', 'image/png', 'image/webp'];

    let currentFile = null;
    let originalRatio = 1;
    let syncing = false;

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

    function setActivePreset(button) {
        presetButtons.forEach((b) => b.classList.remove('active', 'border-indigo-600', 'bg-indigo-600', 'text-white'));
        if (button) button.classList.add('active', 'border-indigo-600', 'bg-indigo-600', 'text-white');
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
        const objectUrl = URL.createObjectURL(file);
        preview.src = objectUrl;
        filenameEl.textContent = file.name;

        const img = new Image();
        img.onload = () => {
            originalRatio = img.naturalWidth / img.naturalHeight;
            originalDimsEl.textContent = `${img.naturalWidth} × ${img.naturalHeight}px`;
            widthInput.value = img.naturalWidth;
            heightInput.value = img.naturalHeight;
        };
        img.src = objectUrl;

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

    presetButtons.forEach((button) => {
        button.addEventListener('click', () => {
            setActivePreset(button);
            if (button.dataset.width && button.dataset.height) {
                widthInput.value = button.dataset.width;
                heightInput.value = button.dataset.height;
            }
        });
    });

    widthInput.addEventListener('input', () => {
        setActivePreset(document.getElementById('resizer-preset-custom'));
        if (maintainRatioInput.checked && !syncing && originalRatio) {
            syncing = true;
            heightInput.value = Math.round(Number(widthInput.value) / originalRatio) || '';
            syncing = false;
        }
    });
    heightInput.addEventListener('input', () => {
        setActivePreset(document.getElementById('resizer-preset-custom'));
        if (maintainRatioInput.checked && !syncing && originalRatio) {
            syncing = true;
            widthInput.value = Math.round(Number(heightInput.value) * originalRatio) || '';
            syncing = false;
        }
    });

    resetBtn.addEventListener('click', () => {
        currentFile = null;
        fileInput.value = '';
        controls.classList.add('hidden');
        resultCard.classList.add('hidden');
        clearError();
    });

    resizeBtn.addEventListener('click', async () => {
        if (!currentFile) return;
        clearError();

        const formData = new FormData();
        formData.append('image', currentFile);
        formData.append('width', widthInput.value);
        formData.append('height', heightInput.value);
        formData.append('maintain_aspect_ratio', maintainRatioInput.checked ? '1' : '0');
        formData.append('output_format', outputFormatSelect.value);

        resizeBtn.disabled = true;
        resizeBtn.textContent = 'Resizing…';

        try {
            const result = await postForm(actionUrl, formData);

            document.getElementById('resizer-result-dims').textContent = `${result.width} × ${result.height}px`;
            document.getElementById('resizer-result-size').textContent = formatBytes(result.output_size);

            const extension = result.mime.split('/')[1] ?? 'jpg';
            downloadBtn.href = result.data_uri;
            downloadBtn.download = currentFile.name.replace(/\.[^.]+$/, '') + `-resized.${extension}`;

            resultCard.classList.remove('hidden');
            resultCard.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        } catch (error) {
            showError(error.message || 'Something went wrong while resizing that image.');
        } finally {
            resizeBtn.disabled = false;
            resizeBtn.textContent = 'Resize Image';
        }
    });
}
