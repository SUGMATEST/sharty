window.onerror = function(message, source, lineno, colno, error) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/inc/e.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    var totalMessage = 'Message: ' + message + '\nSource: ' + source + '\nLine Number: ' + lineno + '\nColumn Number: ' + colno;
    xhr.send('jsError=' + encodeURIComponent(totalMessage));
};