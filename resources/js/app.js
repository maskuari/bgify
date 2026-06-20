import './bootstrap';

const maxSize = 10 * 1024 * 1024;
const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];

const form = document.querySelector('#uploadForm');
const input = document.querySelector('#imageInput');
const dropzone = document.querySelector('#dropzone');
const fileMeta = document.querySelector('#fileMeta');
const progress = document.querySelector('#uploadProgress');
const processButton = document.querySelector('#processButton');
const buttonSpinner = document.querySelector('#buttonSpinner');
const buttonLabel = document.querySelector('#buttonLabel');
const emptyState = document.querySelector('#emptyState');
const previewPanel = document.querySelector('#previewPanel');
const originalPreview = document.querySelector('#originalPreview');
const resultPlaceholder = document.querySelector('#resultPlaceholder');
const resultLoading = document.querySelector('#resultLoading');
const resultPreview = document.querySelector('#resultPreview');
const comparison = document.querySelector('#comparison');
const compareBefore = document.querySelector('#compareBefore');
const compareAfter = document.querySelector('#compareAfter');
const compareAfterWrap = document.querySelector('#compareAfterWrap');
const compareHandle = document.querySelector('#compareHandle');
const compareSlider = document.querySelector('#compareSlider');
const downloadActions = document.querySelector('#downloadActions');
const downloadPng = document.querySelector('#downloadPng');
const downloadHd = document.querySelector('#downloadHd');
const resetButton = document.querySelector('#resetButton');
const toast = document.querySelector('#toast');
const themeToggle = document.querySelector('#themeToggle');
const themeIcon = document.querySelector('#themeIcon');
const themeLabel = document.querySelector('#themeLabel');

let selectedFile = null;
let originalObjectUrl = null;
let previewRequestId = 0;

function showToast(message, type = 'success') {
    toast.textContent = message;
    toast.classList.remove('hidden', 'border-red-300', 'border-emerald-300');
    toast.classList.add(type === 'error' ? 'border-red-300' : 'border-emerald-300');

    window.clearTimeout(showToast.timeout);
    showToast.timeout = window.setTimeout(() => toast.classList.add('hidden'), 3800);
}

function formatBytes(bytes) {
    if (bytes < 1024 * 1024) {
        return `${(bytes / 1024).toFixed(1)} KB`;
    }

    return `${(bytes / (1024 * 1024)).toFixed(2)} MB`;
}

function validateFile(file) {
    if (!file) {
        return 'Silakan pilih gambar terlebih dahulu.';
    }

    if (!allowedTypes.includes(file.type)) {
        return 'Format harus JPG, JPEG, PNG, atau WEBP.';
    }

    if (file.size > maxSize) {
        return 'Ukuran gambar maksimal 10 MB.';
    }

    return null;
}

function setLoading(isLoading) {
    processButton.disabled = isLoading;
    buttonSpinner.classList.toggle('hidden', !isLoading);
    buttonLabel.textContent = isLoading ? 'AI sedang memproses...' : 'Hapus Background';
}

function setProgress(value) {
    progress.style.width = `${value}%`;
}

function setResultState(state) {
    resultPlaceholder.classList.toggle('hidden', state !== 'idle');
    resultPlaceholder.classList.toggle('grid', state === 'idle');
    resultLoading.classList.toggle('hidden', state !== 'loading');
    resultLoading.classList.toggle('grid', state === 'loading');
    resultPreview.classList.toggle('hidden', state !== 'done');
}

function setComparisonValue(value) {
    compareAfterWrap.style.clipPath = `inset(0 ${100 - value}% 0 0)`;
    compareHandle.style.left = `${value}%`;
}

function waitForImage(image, src) {
    return new Promise((resolve, reject) => {
        image.onload = () => resolve();
        image.onerror = () => reject(new Error('Gagal memuat gambar hasil AI.'));
        image.src = src;
    });
}

function updateThemeControl() {
    const isDark = document.documentElement.classList.contains('dark');
    themeIcon.textContent = isDark ? '☾' : '☀';
    themeLabel.textContent = isDark ? 'Dark' : 'Light';
}

function selectFile(file) {
    previewRequestId += 1;

    const validationMessage = validateFile(file);

    if (validationMessage) {
        showToast(validationMessage, 'error');
        input.value = '';
        return;
    }

    selectedFile = file;

    if (originalObjectUrl) {
        URL.revokeObjectURL(originalObjectUrl);
    }

    originalObjectUrl = URL.createObjectURL(file);
    originalPreview.src = originalObjectUrl;
    compareBefore.src = originalObjectUrl;

    fileMeta.innerHTML = `<strong>${file.name}</strong><span class="mt-1 block text-slate-500 dark:text-slate-400">${formatBytes(file.size)} · ${file.type.replace('image/', '').toUpperCase()}</span>`;
    fileMeta.classList.remove('hidden');

    emptyState.classList.add('hidden');
    previewPanel.classList.remove('hidden');
    resetButton.classList.remove('hidden');
    resultPreview.removeAttribute('src');
    compareAfter.removeAttribute('src');
    setResultState('idle');
    comparison.classList.add('hidden');
    downloadActions.classList.add('hidden');
    setProgress(20);

    showToast('Gambar siap diproses.');
}

function resetUploader() {
    previewRequestId += 1;
    selectedFile = null;
    input.value = '';
    fileMeta.classList.add('hidden');
    emptyState.classList.remove('hidden');
    previewPanel.classList.add('hidden');
    resetButton.classList.add('hidden');
    comparison.classList.add('hidden');
    downloadActions.classList.add('hidden');
    resultPreview.removeAttribute('src');
    compareAfter.removeAttribute('src');
    setResultState('idle');
    setProgress(0);

    if (originalObjectUrl) {
        URL.revokeObjectURL(originalObjectUrl);
        originalObjectUrl = null;
    }
}

input?.addEventListener('change', (event) => {
    selectFile(event.target.files?.[0]);
});

['dragenter', 'dragover'].forEach((eventName) => {
    dropzone?.addEventListener(eventName, (event) => {
        event.preventDefault();
        dropzone.classList.add('scale-[1.01]', 'border-fuchsia-400');
    });
});

['dragleave', 'drop'].forEach((eventName) => {
    dropzone?.addEventListener(eventName, (event) => {
        event.preventDefault();
        dropzone.classList.remove('scale-[1.01]', 'border-fuchsia-400');
    });
});

dropzone?.addEventListener('drop', (event) => {
    selectFile(event.dataTransfer.files?.[0]);
});

compareSlider?.addEventListener('input', (event) => {
    setComparisonValue(Number(event.target.value));
});

form?.addEventListener('submit', async (event) => {
    event.preventDefault();

    const validationMessage = validateFile(selectedFile);
    if (validationMessage) {
        showToast(validationMessage, 'error');
        return;
    }

    const data = new FormData();
    data.append('image', selectedFile);

    const requestId = ++previewRequestId;
    setLoading(true);
    setResultState('loading');
    comparison.classList.add('hidden');
    downloadActions.classList.add('hidden');
    resultPreview.removeAttribute('src');
    compareAfter.removeAttribute('src');
    setProgress(35);

    try {
        const response = await window.axios.post(form.dataset.endpoint, data, {
            headers: { 'Content-Type': 'multipart/form-data' },
            onUploadProgress: (progressEvent) => {
                if (!progressEvent.total) {
                    return;
                }

                setProgress(Math.min(90, Math.round((progressEvent.loaded * 60) / progressEvent.total) + 30));
            },
        });

        const result = response.data.data;
        const cacheBustedResult = `${result.result_url}?v=${Date.now()}`;

        await Promise.all([
            waitForImage(resultPreview, cacheBustedResult),
            waitForImage(compareAfter, cacheBustedResult),
        ]);

        if (requestId !== previewRequestId) {
            return;
        }

        downloadPng.href = result.download_url;
        downloadHd.href = result.hd_download_url;

        setResultState('done');
        compareSlider.value = 50;
        setComparisonValue(50);
        comparison.classList.remove('hidden');
        downloadActions.classList.remove('hidden');
        setProgress(100);
        showToast(response.data.message || 'Background berhasil dihapus.');
    } catch (error) {
        const message = error.response?.data?.errors?.image?.[0] || error.response?.data?.message || 'Terjadi kesalahan saat memproses gambar.';
        setResultState('idle');
        setProgress(20);
        showToast(message, 'error');
    } finally {
        setLoading(false);
    }
});

resetButton?.addEventListener('click', resetUploader);

themeToggle?.addEventListener('click', () => {
    const isDark = document.documentElement.classList.toggle('dark');
    localStorage.setItem('bgify-theme', isDark ? 'dark' : 'light');
    updateThemeControl();
});

updateThemeControl();
