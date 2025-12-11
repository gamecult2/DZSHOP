document.addEventListener('DOMContentLoaded', () => {
    const paymentMethodRadios = document.querySelectorAll('input[name="payment_method"]');
    const qrCodeDisplay = document.getElementById('qr-code-display') as HTMLElement;

    paymentMethodRadios.forEach(radio => {
        radio.addEventListener('change', (event) => {
            const currentRadio = event.target as HTMLInputElement;
            if (currentRadio.dataset.qrCode === 'true') {
                qrCodeDisplay.style.display = 'block';
            } else {
                qrCodeDisplay.style.display = 'none';
            }
        });
    });
});
