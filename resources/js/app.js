import 'admin-lte/dist/css/adminlte.css';
import 'admin-lte/dist/css/adminlte-colors.css';
import 'overlayscrollbars/styles/overlayscrollbars.css';
import '@fortawesome/fontawesome-free/css/all.min.css';
import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css';
import 'flatpickr/dist/flatpickr.min.css';

import './bootstrap';

import 'admin-lte';
import 'datatables.net-bs5';

import flatpickr from 'flatpickr';
import Chart from 'chart.js/auto';

import '../sass/app.scss';

window.flatpickr = flatpickr;
window.Chart = Chart;

document.addEventListener('DOMContentLoaded', () => {
    const credit = document.getElementById('credit');
    const bank = document.getElementById('bank');
    const bankFields = document.getElementById('bankt');

    if (credit && bank && bankFields) {
        const syncPaymentMethod = () => {
            bankFields.hidden = !bank.checked;
        };

        credit.addEventListener('change', syncPaymentMethod);
        bank.addEventListener('change', syncPaymentMethod);
        syncPaymentMethod();
    }

    for (const input of document.querySelectorAll('input[type="file"][data-preview]')) {
        input.addEventListener('change', () => {
            const file = input.files?.[0];
            const target = document.querySelector(input.dataset.preview);

            if (!file || !target) {
                return;
            }

            const reader = new FileReader();
            reader.onload = (event) => {
                target.src = event.target.result;
                target.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        });
    }
});
