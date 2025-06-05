// Execute JS required for special effects on certain themes
$(function() {
    switch (localStorage.stylesheet) {
        case 'Frooty':
            document.body.insertAdjacentHTML('beforeend',
                `<div class="snowflakes">
                <img class="snowflake" src="/static/froot/froot1.png" style="width:50px;">
                <img class="snowflake" src="/static/froot/froot2.png" style="width:50px;">
                <img class="snowflake" src="/static/froot/froot3.png" style="width:70px;">
                <img class="snowflake" src="/static/froot/froot4.png" style="width:50px;">
                <img class="snowflake" src="/static/froot/froot5.png" style="width:50px;">
                <img class="snowflake" src="/static/froot/froot6.png" style="width:50px;">
                <img class="snowflake" src="/static/froot/froot7.png" style="width:50px;">
                <img class="snowflake" src="/static/froot/froot8.png" style="width:50px;">
                <img class="snowflake" src="/static/froot/froot9.png" style="width:50px;">
                <img class="snowflake" src="/static/froot/froot10.png" style="width:50px;">
                <img class="snowflake" src="/static/froot/froot11.gif" style="width:50px;">
                <img class="snowflake" src="/static/froot/froot12.png" style="width:50px;">
                </div>`
            );

            break;
        
        case 'Ocean':
            const soislug = document.createElement("img");
            soislug.setAttribute('src', '/static/ocean/slug.png');
            soislug.setAttribute('class', 'soislug');

            const soifish = document.createElement("img");
            soifish.setAttribute('src', '/static/ocean/fish.png');
            soifish.setAttribute('class', 'soifish');

            document.body.append(soislug, soifish);

            break;
    }
});