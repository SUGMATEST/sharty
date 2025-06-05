document.addEventListener("DOMContentLoaded", function () {
    MathJax.typesetPromise().catch((err) => console.error(err));
});


$(function () {
    $(document).on('new_post', function (e, post) {
        MathJax.typesetPromise().catch((err) => console.error(err));
    });
});