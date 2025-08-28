document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.purchase__items-btn').forEach(link => {
        link.addEventListener('click', function (event) {
            event.preventDefault();

            const paySelect = document.getElementById('selectItem');
            const payValue = paySelect ? paySelect.value : '';

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = this.href;

            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const inputToken = document.createElement('input');
            inputToken.type = 'hidden';
            inputToken.name = '_token';
            inputToken.value = token;
            form.appendChild(inputToken);

            const inputPay = document.createElement('input');
            inputPay.type = 'hidden';
            inputPay.name = 'pay';
            inputPay.value = payValue;
            form.appendChild(inputPay);

            document.body.appendChild(form);
            form.submit();
        });
    });
});