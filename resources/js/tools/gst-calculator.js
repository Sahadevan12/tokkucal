import { postJson, showFieldErrors, clearFieldErrors } from '../http.js';
import { formatINR } from '../format.js';

const form = document.getElementById('gst-form');
if (form) {
    const modeInput = document.getElementById('gst-mode-input');
    const modeButtons = form.querySelectorAll('[data-gst-mode]');
    const rateChips = form.querySelectorAll('[data-gst-rate]');
    const gstPercentInput = document.getElementById('gst_percent');
    const resultCard = document.getElementById('gst-result');

    modeButtons.forEach((button) => {
        button.addEventListener('click', () => {
            modeButtons.forEach((b) => {
                b.classList.remove('bg-white', 'shadow-sm', 'text-indigo-700');
                b.setAttribute('aria-pressed', 'false');
            });
            button.classList.add('bg-white', 'shadow-sm', 'text-indigo-700');
            button.setAttribute('aria-pressed', 'true');
            modeInput.value = button.dataset.gstMode;
        });
    });
    form.querySelector('[data-gst-mode="exclusive"]')?.click();

    rateChips.forEach((chip) => {
        chip.addEventListener('click', () => {
            rateChips.forEach((c) => c.classList.remove('active', 'border-indigo-600', 'bg-indigo-600', 'text-white'));
            chip.classList.add('active', 'border-indigo-600', 'bg-indigo-600', 'text-white');
            gstPercentInput.value = chip.dataset.gstRate;
        });
    });

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        clearFieldErrors(form);

        const formData = new FormData(form);
        const payload = Object.fromEntries(formData.entries());

        try {
            const result = await postJson(form.dataset.action, payload);

            document.getElementById('gst-base-amount').textContent = formatINR(result.base_amount);
            document.getElementById('gst-gst-amount').textContent = formatINR(result.gst_amount);
            document.getElementById('gst-total-amount').textContent = formatINR(result.total_amount);
            resultCard.classList.remove('hidden');
            resultCard.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        } catch (error) {
            if (error.status === 422) {
                showFieldErrors(error.errors);
            }
        }
    });
}
