import '../sass/storefront.scss';
import * as bootstrap from 'bootstrap';
import '@fortawesome/fontawesome-free/css/all.min.css';

window.bootstrap = bootstrap;

document.addEventListener('DOMContentLoaded', () => {
    const checker = document.getElementById('checker');

    if (checker) {
        const receiver = document.getElementById('receiver');
        const receiverAddress = document.getElementById('receiver_address');
        const deliverTo = document.getElementById('deliver_to');
        const deliverToAddress = document.getElementById('deliver_to_address');

        const syncReceiver = () => {
            const enabled = checker.checked;

            receiver.hidden = !enabled;
            receiverAddress.hidden = !enabled;

            for (const input of [deliverTo, deliverToAddress]) {
                input.required = enabled;

                if (!enabled) {
                    input.value = '';
                }
            }
        };

        checker.addEventListener('change', syncReceiver);
        syncReceiver();
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
});
