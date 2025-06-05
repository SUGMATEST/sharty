document.addEventListener("DOMContentLoaded", function(event) {
const thr_lut = ['0', '1', '2', '3', '4', '5', '6', 'Ϫ', '7', '8', '9'];
function thr_cnv(num) {
  if (num === 0) {
    return '0';
  }
  let result = '';
  while (num !== 0) {
    const remainder = num % 11;
    result = thr_lut[remainder] + result;
    num = Math.floor(num / 11);
  }
  return result;
}
function thr_up() {
    console.log('updating');
    document.querySelectorAll('.post_no').forEach((el) => {
        if (el.classList.contains('thr_ok')) { return; }
        el.classList.add('thr_ok');
        if (el.innerText == '№') { return; }
        const res = thr_cnv(parseInt(el.innerText));
        el.innerText = res;
    });
    document.querySelectorAll('a[class^="mentioned-"]').forEach((el) => {
        if (el.classList.contains('thr_ok')) { return; }
        el.classList.add('thr_ok');
        const res = thr_cnv(parseInt(el.innerText.substring(2)));
        el.innerText = `>>${res}`;
    });
    document.querySelectorAll('a[onclick^="highlightReply"][href*="/thread"]').forEach((el) => {
        if (el.classList.contains('thr_ok')) { return; }
        el.classList.add('thr_ok');
        if (el.innerText == '№') { return; }
        const res = thr_cnv(parseInt(el.innerText.substring(2)));
        el.innerText = `>>${res}`;
    });
}
const observer = new MutationObserver((mutationsList, observer) => {
    for (let mutation of mutationsList) {
        if (mutation.type === 'childList') {
            thr_up();
            return;
        }
    }
});
const config = { childList: true, subtree: true };
observer.observe(document.body, config);
thr_up();
});