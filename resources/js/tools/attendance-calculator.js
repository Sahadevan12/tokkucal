import { postJson, showFieldErrors, clearFieldErrors } from '../http.js';
import { formatNumber } from '../format.js';

const form = document.getElementById('attendance-form');
if (form) {
    const resultCard = document.getElementById('attendance-result');
    const headlineCard = document.getElementById('attendance-headline-card');
    const adviceCard = document.getElementById('attendance-advice-card');

    const goodClasses = ['bg-emerald-50', 'text-emerald-700'];
    const badClasses = ['bg-amber-50', 'text-amber-700'];

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        clearFieldErrors(form);

        const formData = new FormData(form);
        const payload = Object.fromEntries(formData.entries());

        try {
            const result = await postJson(form.dataset.action, payload);

            document.getElementById('attendance-current-percent').textContent = `${formatNumber(result.current_percent)}%`;
            document.getElementById('attendance-attended').textContent = result.classes_attended;
            document.getElementById('attendance-missed').textContent = result.classes_missed;

            headlineCard.classList.remove(...goodClasses, ...badClasses);
            headlineCard.classList.add(...(result.meets_target ? goodClasses : badClasses));

            const adviceLabel = document.getElementById('attendance-advice-label');
            const adviceValue = document.getElementById('attendance-advice-value');

            if (result.meets_target) {
                adviceLabel.textContent = 'Classes You Can Miss';
                adviceValue.textContent = result.can_miss;
            } else if (!result.achievable) {
                adviceLabel.textContent = 'Classes Required';
                adviceValue.textContent = 'Not achievable';
            } else {
                adviceLabel.textContent = 'Classes Required to Attend';
                adviceValue.textContent = result.required_to_attend;
            }

            resultCard.classList.remove('hidden');
            resultCard.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        } catch (error) {
            if (error.status === 422) {
                showFieldErrors(error.errors);
            }
        }
    });
}
