import { postJson, clearFieldErrors } from '../http.js';
import { formatINR, formatNumber } from '../format.js';

const form = document.getElementById('discount-form');
if (form) {
    const modeInput = document.getElementById('discount-mode-input');
    const modeButtons = form.querySelectorAll('[data-discount-mode]');
    const panels = form.querySelectorAll('[data-discount-panel]');
    const resultCard = document.getElementById('discount-result');

    function setMode(mode) {
        modeInput.value = mode;

        modeButtons.forEach((button) => {
            const active = button.dataset.discountMode === mode;
            button.classList.toggle('bg-white', active);
            button.classList.toggle('shadow-sm', active);
            button.classList.toggle('text-indigo-700', active);
            button.setAttribute('aria-pressed', active ? 'true' : 'false');
        });

        panels.forEach((panel) => {
            const active = panel.dataset.discountPanel === mode;
            panel.classList.toggle('hidden', !active);
            panel.querySelectorAll('input').forEach((input) => {
                input.disabled = !active;
            });
        });
    }

    modeButtons.forEach((button) => {
        button.addEventListener('click', () => setMode(button.dataset.discountMode));
    });
    setMode('percent');

    function showErrors(errors) {
        Object.entries(errors).forEach(([field, messages]) => {
            const el = document.getElementById(`${field}-error`);
            if (el) {
                el.textContent = Array.isArray(messages) ? messages[0] : messages;
                el.classList.remove('hidden');
            }
        });
    }

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        clearFieldErrors(form);

        const formData = new FormData(form);
        const payload = Object.fromEntries(formData.entries());

        try {
            const result = await postJson(form.dataset.action, payload);

            document.getElementById('discount-amount').textContent = formatINR(result.discount_amount);
            document.getElementById('discount-percent-out').textContent = `${formatNumber(result.discount_percent)}%`;
            document.getElementById('discount-final-price').textContent = formatINR(result.final_price ?? result.sale_price);

            resultCard.classList.remove('hidden');
            resultCard.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        } catch (error) {
            if (error.status === 422) {
                showErrors(error.errors);
            }
        }
    });
}
