<?php

require_once 'inc/bootstrap.php';

//var_dump(decrypt_prick('{"iv":"f/3kfHYbN17f5lE5","data":"Kz5y2gOcG6J6gTeZTFa0AhcgptlAbMQpX4S13Ritv9BlRkhMKqhPEr9r3hIAz2c2tYjHv4y0K1i7+59shyEcUgVfQSumusYa67qeJOjwbWcHgcQ6jABf0a9SuWqP7OMIwxg/lKnh//dIcpU1OcP0Zk1zyJaMAk3mEofsGYIn0ou0P5ku1jjST0gTA3EaFzw48V/rsjh3ctUhtP1LsyxQU7aBYsTK/edRwPCQhEHWrHYk3vDW/wov7dWWzLSG1mf7JZuGZnsW"}'));
var_dump(decrypt_integrity('{"iv": "wz+J3TIrow0MD5jjWFe+Sw==","data": "cmVhZCB0aGlzIGlmIHlvdSdyZSBidWlsdCA0IGJiYw=="}'));
