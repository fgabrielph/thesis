import '../sass/storefront.scss';
import * as bootstrap from 'bootstrap';
import '@fortawesome/fontawesome-free/css/all.min.css';

window.bootstrap = bootstrap;

document.addEventListener('DOMContentLoaded', () => {
    const checker = document.getElementById('checker');

    if (!checker) {
        return;
    }

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
});
