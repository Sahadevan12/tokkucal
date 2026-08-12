import { postJson, showFieldErrors, clearFieldErrors } from '../http.js';
import { formatINR } from '../format.js';

const form = document.getElementById('salary-form');
if (form) {
    const resultCard = document.getElementById('salary-result');

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        clearFieldErrors(form);

        const formData = new FormData(form);
        const payload = Object.fromEntries(formData.entries());

        try {
            const result = await postJson(form.dataset.action, payload);

            document.getElementById('salary-monthly-take-home').textContent = formatINR(result.monthly_take_home);
            document.getElementById('salary-annual-take-home').textContent = `${formatINR(result.estimated_take_home)} / year`;
            document.getElementById('salary-annual-ctc').textContent = formatINR(result.annual_ctc);
            document.getElementById('salary-monthly-ctc').textContent = `${formatINR(result.monthly_ctc)} / month`;
            document.getElementById('salary-gross').textContent = formatINR(result.gross_salary);
            document.getElementById('salary-monthly-gross').textContent = `${formatINR(result.monthly_gross)} / month`;
            document.getElementById('salary-deductions').textContent = formatINR(result.estimated_deductions);

            resultCard.classList.remove('hidden');
            resultCard.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        } catch (error) {
            if (error.status === 422) {
                showFieldErrors(error.errors);
            }
        }
    });
}
