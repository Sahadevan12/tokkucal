import { postJson, showFieldErrors, clearFieldErrors } from '../http.js';

const form = document.getElementById('age-form');
if (form) {
    const targetDateInput = document.getElementById('target_date');
    const dobInput = document.getElementById('date_of_birth');
    const resultCard = document.getElementById('age-result');

    const today = new Date();
    const todayIso = today.toISOString().slice(0, 10);
    targetDateInput.max = todayIso;
    dobInput.max = todayIso;
    if (!targetDateInput.value) {
        targetDateInput.placeholder = todayIso;
    }

    function formatDate(isoDate) {
        return new Date(`${isoDate}T00:00:00`).toLocaleDateString('en-IN', {
            day: 'numeric',
            month: 'long',
            year: 'numeric',
        });
    }

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        clearFieldErrors(form);

        const formData = new FormData(form);
        const payload = Object.fromEntries(formData.entries());
        if (!payload.target_date) delete payload.target_date;

        try {
            const result = await postJson(form.dataset.action, payload);

            document.getElementById('age-headline').textContent =
                `${result.years} years, ${result.months} months, ${result.days} days`;
            document.getElementById('age-total-days').textContent = result.total_days.toLocaleString('en-IN');
            document.getElementById('age-total-weeks').textContent = result.total_weeks.toLocaleString('en-IN');
            document.getElementById('age-total-months').textContent = result.total_months.toLocaleString('en-IN');
            document.getElementById('age-next-birthday').textContent =
                result.days_to_next_birthday === 0
                    ? 'Today!'
                    : `${result.days_to_next_birthday} days (${formatDate(result.next_birthday_date)})`;

            resultCard.classList.remove('hidden');
            resultCard.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        } catch (error) {
            if (error.status === 422) {
                showFieldErrors(error.errors);
            }
        }
    });
}
