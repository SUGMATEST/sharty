const buttons = document.querySelectorAll('.show-ips');
for (const button of buttons) {
    button.addEventListener('click', function(e) {
        const ips = e.target.nextElementSibling;

        if (e.target.innerHTML == '[+]') {
            ips.removeAttribute('hidden');
            e.target.innerHTML = '[-]';
        }
        else {
            ips.setAttribute('hidden', '');
            e.target.innerHTML = '[+]';
        }
    });
}
