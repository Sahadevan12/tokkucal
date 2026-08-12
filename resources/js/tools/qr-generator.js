import QRCode from 'qrcode';

const canvas = document.getElementById('qr-canvas');
if (canvas) {
    const typeButtons = document.querySelectorAll('[data-qr-type]');
    const panels = document.querySelectorAll('[data-qr-panel]');
    const errorEl = document.getElementById('qr-error');
    const sizeSelect = document.getElementById('qr_size');
    const marginSelect = document.getElementById('qr_margin');
    const fgColorInput = document.getElementById('qr_fg_color');
    const bgColorInput = document.getElementById('qr_bg_color');
    const downloadPngBtn = document.getElementById('qr-download-png');
    const downloadSvgBtn = document.getElementById('qr-download-svg');

    let activeType = 'url';
    let lastPayload = '';

    function escapeWifiValue(value) {
        return value.replace(/([\\;,:"])/g, '\\$1');
    }

    function buildPayload() {
        switch (activeType) {
            case 'url': {
                const url = document.getElementById('qr_url').value.trim();
                return url;
            }
            case 'text':
                return document.getElementById('qr_text').value;
            case 'email': {
                const to = document.getElementById('qr_email_to').value.trim();
                const subject = document.getElementById('qr_email_subject').value.trim();
                if (!to) return '';
                return subject ? `mailto:${to}?subject=${encodeURIComponent(subject)}` : `mailto:${to}`;
            }
            case 'phone': {
                const phone = document.getElementById('qr_phone').value.trim();
                return phone ? `tel:${phone}` : '';
            }
            case 'wifi': {
                const ssid = document.getElementById('qr_wifi_ssid').value;
                const password = document.getElementById('qr_wifi_password').value;
                const encryption = document.getElementById('qr_wifi_encryption').value;
                if (!ssid) return '';
                const passSegment = encryption === 'nopass' ? '' : `P:${escapeWifiValue(password)};`;
                return `WIFI:T:${encryption};S:${escapeWifiValue(ssid)};${passSegment};`;
            }
            default:
                return '';
        }
    }

    function currentOptions() {
        return {
            width: Number(sizeSelect.value),
            margin: Number(marginSelect.value),
            color: {
                dark: fgColorInput.value,
                light: bgColorInput.value,
            },
            errorCorrectionLevel: 'M',
        };
    }

    function clearError() {
        errorEl.textContent = '';
        errorEl.classList.add('hidden');
    }

    function showError(message) {
        errorEl.textContent = message;
        errorEl.classList.remove('hidden');
    }

    function render() {
        const payload = buildPayload();
        lastPayload = payload;
        clearError();

        if (!payload) {
            const ctx = canvas.getContext('2d');
            canvas.width = 300;
            canvas.height = 300;
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            return;
        }

        QRCode.toCanvas(canvas, payload, currentOptions(), (error) => {
            if (error) showError('Could not generate a QR code for this input — it may be too long.');
        });
    }

    typeButtons.forEach((button) => {
        button.addEventListener('click', () => {
            activeType = button.dataset.qrType;
            typeButtons.forEach((b) => {
                const active = b === button;
                b.classList.toggle('bg-white', active);
                b.classList.toggle('shadow-sm', active);
                b.classList.toggle('text-indigo-700', active);
                b.setAttribute('aria-pressed', active ? 'true' : 'false');
            });
            panels.forEach((panel) => {
                panel.classList.toggle('hidden', panel.dataset.qrPanel !== activeType);
            });
            render();
        });
    });
    document.querySelector('[data-qr-type="url"]')?.classList.add('bg-white', 'shadow-sm', 'text-indigo-700');

    document.querySelectorAll('[data-qr-panel] input, [data-qr-panel] textarea, [data-qr-panel] select').forEach((el) => {
        el.addEventListener('input', render);
    });
    [sizeSelect, marginSelect, fgColorInput, bgColorInput].forEach((el) => el.addEventListener('input', render));

    downloadPngBtn.addEventListener('click', () => {
        if (!lastPayload) {
            showError('Enter some content above before downloading.');
            return;
        }
        const link = document.createElement('a');
        link.href = canvas.toDataURL('image/png');
        link.download = 'qrcode.png';
        link.click();
    });

    downloadSvgBtn.addEventListener('click', () => {
        if (!lastPayload) {
            showError('Enter some content above before downloading.');
            return;
        }
        QRCode.toString(lastPayload, { ...currentOptions(), type: 'svg' }, (error, svg) => {
            if (error) {
                showError('Could not generate an SVG for this input.');
                return;
            }
            const blob = new Blob([svg], { type: 'image/svg+xml' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = 'qrcode.svg';
            link.click();
            URL.revokeObjectURL(url);
        });
    });

    render();
}
