import { postJson, clearFieldErrors } from '../http.js';
import { formatNumber } from '../format.js';

const form = document.getElementById('percentage-form');
if (form) {
    const modeInput = document.getElementById('percentage-mode-input');
    const modeButtons = form.querySelectorAll('[data-percentage-mode]');
    const panels = form.querySelectorAll('[data-percentage-panel]');
    const resultCard = document.getElementById('percentage-result');
    const resultLabel = document.getElementById('percentage-result-label');
    const resultValue = document.getElementById('percentage-result-value');

    // Maps each mode to { backendField: domElementId } so validation errors
    // (keyed by backend field name) can be shown next to the right input.
    const fieldMap = {
        of: { percent: 'of_percent', of_value: 'of_of_value' },
        'is-percent': { value: 'isp_value', of_value: 'isp_of_value' },
        change: { old_value: 'chg_old_value', new_value: 'chg_new_value' },
    };

    function setMode(mode) {
        modeInput.value = mode;
        resultCard.classList.add('hidden');

        modeButtons.forEach((button) => {
            const active = button.dataset.percentageMode === mode;
            button.classList.toggle('bg-white', active);
            button.classList.toggle('shadow-sm', active);
            button.classList.toggle('text-indigo-700', active);
            button.setAttribute('aria-pressed', active ? 'true' : 'false');
        });

        panels.forEach((panel) => {
            const active = panel.dataset.percentagePanel === mode;
            panel.classList.toggle('hidden', !active);
            panel.querySelectorAll('input').forEach((input) => {
                input.disabled = !active;
            });
        });
    }

    modeButtons.forEach((button) => {
        button.addEventListener('click', () => setMode(button.dataset.percentageMode));
    });
    setMode('of');

    function buildPayload(mode) {
        if (mode === 'of') {
            return {
                mode,
                percent: document.getElementById('of_percent').value,
                of_value: document.getElementById('of_of_value').value,
            };
        }
        if (mode === 'is-percent') {
            return {
                mode,
                value: document.getElementById('isp_value').value,
                of_value: document.getElementById('isp_of_value').value,
            };
        }
        return {
            mode,
            old_value: document.getElementById('chg_old_value').value,
            new_value: document.getElementById('chg_new_value').value,
        };
    }

    function showErrors(mode, errors) {
        const map = fieldMap[mode];
        Object.entries(errors).forEach(([backendField, messages]) => {
            const domId = map[backendField];
            if (!domId) return;
            const el = document.getElementById(`${domId}-error`);
            if (el) {
                el.textContent = Array.isArray(messages) ? messages[0] : messages;
                el.classList.remove('hidden');
            }
        });
    }

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        clearFieldErrors(form);

        const mode = modeInput.value;
        const payload = buildPayload(mode);

        try {
            const result = await postJson(form.dataset.action, payload);

            if (mode === 'change') {
                resultLabel.textContent = `Percentage ${result.direction === 'decrease' ? 'Decrease' : 'Increase'}`;
                resultValue.textContent = `${result.direction === 'decrease' ? '-' : '+'}${formatNumber(result.result)}%`;
            } else {
                resultLabel.textContent = 'Result';
                resultValue.textContent = `${formatNumber(result.result)}${mode === 'of' ? '' : '%'}`;
            }

            resultCard.classList.remove('hidden');
            resultCard.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        } catch (error) {
            if (error.status === 422) {
                showErrors(mode, error.errors);
            }
        }
    });
}
