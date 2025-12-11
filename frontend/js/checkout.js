document.addEventListener('DOMContentLoaded', function() {
    var paymentMethodRadios = document.querySelectorAll('input[name="payment_method"]');
    var qrCodeDisplay = document.getElementById('qr-code-display');

    paymentMethodRadios.forEach(function(radio) {
        radio.addEventListener('change', function(event) {
            var currentRadio = event.target;
            if (currentRadio.dataset.qrCode === 'true') {
                qrCodeDisplay.style.display = 'block';
            } else {
                qrCodeDisplay.style.display = 'none';
            }
        });
    });
});
