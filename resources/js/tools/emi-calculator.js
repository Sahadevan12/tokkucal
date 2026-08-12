import { postJson, showFieldErrors, clearFieldErrors } from '../http.js';
import { formatINR } from '../format.js';

const form = document.getElementById('emi-form');
if (form) {
    const resultCard = document.getElementById('emi-result');
    const breakdownBody = document.getElementById('emi-breakdown');

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        clearFieldErrors(form);

        const formData = new FormData(form);
        const payload = Object.fromEntries(formData.entries());

        try {
            const result = await postJson(form.dataset.action, payload);

            document.getElementById('emi-monthly').textContent = formatINR(result.emi);
            document.getElementById('emi-interest').textContent = formatINR(result.total_interest);
            document.getElementById('emi-total').textContent = formatINR(result.total_payment);

            breakdownBody.innerHTML = result.yearly_breakdown
                .map(
                    (row) => `<tr>
                        <td class="py-2 pr-4">${row.year}</td>
                        <td class="py-2 pr-4">${formatINR(row.principal_paid)}</td>
                        <td class="py-2 pr-4">${formatINR(row.interest_paid)}</td>
                        <td class="py-2">${formatINR(row.balance)}</td>
                    </tr>`
                )
                .join('');

            resultCard.classList.remove('hidden');
            resultCard.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        } catch (error) {
            if (error.status === 422) {
                showFieldErrors(error.errors);
            }
        }
    });
}
