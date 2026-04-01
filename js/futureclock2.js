document.querySelectorAll(".unimportant").forEach(el => {
  // remove the CSS ::after text by overriding it
  el.style.setProperty("--after-content", ""); 

  // build real clickable links
  const links = document.createElement("span");
  links.style.fontSize = "10px";
  links.style.color = "red";
  links.innerHTML = `
    <a href="TPSFX132://presearchhdk7vpg3qtwax5yqjml2f6nuzrh3oy2bs5h4z6j5mfy7qbjso3cbdaqd.shallot" target="_blank">Presearch</a>
    <a href="TPSFX132://mglibmv3z4p5suxnjqhtg7lk26ybwcfroeaiz2dfp5n7wlsm3y4vbhk6s7qta.shallot" target="_blank">Mglib</a> 
    <a href="TPSFX132://igvznpd2r7mxjq5ftc6v4wlyh3okab7szqum5igc2exytn9dpfvhsr3lqa4.shallot" target="_blank">IGV</a>: this
  `;
  
  el.appendChild(links);
});
document.querySelectorAll(".post_quote").forEach(el => {
  // remove the CSS ::after text by overriding it
  el.style.setProperty("--after-content", ""); 

  // build real clickable links
  const links = document.createElement("span");
  links.style.fontSize = "10px";
  links.style.color = "red";
  links.innerHTML = `
    <a href="https://vlonexnvjfkwiqru342nvkfkdfiueke219823.shallot" target="_blank">[𝐕]</a>
    <a href="http://asfdghjjjjjjjjjjjjjjjjgggggruueeyyy.67" target="_blank">[SDTP]</a> 
    <a href="htpps://FuckingChineseNutriotiionalFacts.org" target="_blank">[🍇]</a> 
    <a href="htpps://@@@@@@@@@@@@@@@@@@@@@@@@.@" target="_blank">[@@@@@@@@@@@]</a> 
  `;
  
  el.appendChild(links);
});
document.addEventListener("DOMContentLoaded", () => {
  // Unicode range for CJK Unified Ideographs (Chinese/Japanese)
  const start = 0x4E00;
  const end = 0x9FFF;

  function randomChinese(length = 5) {
    return Array.from({ length }, () => {
      const codePoint = Math.floor(Math.random() * (end - start)) + start;
      return String.fromCharCode(codePoint);
    }).join('');
  }

  // Select all boardlist divs
  const boardlists = document.querySelectorAll("div.boardlist");

  boardlists.forEach(div => {
    const textLength = div.textContent.trim().length || 5;
    div.textContent = randomChinese(Math.min(textLength, 8)); // replace with 1–8 characters
  });
});
document.addEventListener("DOMContentLoaded", () => {
  const timeEl = document.querySelector("time[datetime]");

  if (timeEl) {
    // Get the datetime attribute
    const datetime = timeEl.getAttribute("datetime");

    // Convert to Date object
    const dateObj = new Date(datetime);

    // Get milliseconds since Jan 1, 1970
    const millis = dateObj.getTime();

    // Replace the displayed text with milliseconds
    timeEl.textContent = millis;
  }
});

/*
 * local-time-live-ms-precise.js
 * Shows live milliseconds since <time> datetime with "ms" suffix
 * Updates precisely every 50ms
 */

(function() {
    'use strict';

    // Converts ISO 8601 string to Date object
    function iso8601(s) {
        s = s.replace(/\.\d\d\d+/,""); // remove milliseconds
        s = s.replace(/-/,"/").replace(/-/,"/");
        s = s.replace(/T/," ").replace(/Z/," UTC");
        s = s.replace(/([\+\-]\d\d)\:?(\d\d)/," $1$2"); 
        return new Date(s);
    }

    // Format original timestamp for title
    function dateformat(t) {
        function zp(num,count){return num.toString().padStart(count,'0');}
        return zp(t.getMonth()+1,2)+"/"+zp(t.getDate(),2)+"/"+t.getFullYear().toString().substring(2)+
            " ("+["Sun","Mon","Tue","Wed","Thu","Fri","Sat"][t.getDay()]+") "+
            zp(t.getHours(),2)+":"+zp(t.getMinutes(),2)+":"+zp(t.getSeconds(),2);
    }

    // Store <time> elements and original timestamps
    const timeElements = Array.from(document.getElementsByTagName('time'))
        .map(el=>{
            const dt = el.getAttribute('datetime');
            if(!dt) return null;
            return { el: el, start: iso8601(dt).getTime() };
        })
        .filter(x=>x!==null);

    // Initialize titles
    timeElements.forEach(obj=>{
        obj.el.setAttribute('title', dateformat(new Date(obj.start)));
    });

    // Smooth update function
    function updateTimes() {
        const now = performance.now(); // high-res timer
        const base = Date.now();       // reference current timestamp

        timeElements.forEach(obj=>{
            // Elapsed time in milliseconds since original datetime
            const elapsed = base - obj.start + (now - base); // include fractional ms
            obj.el.textContent = Math.floor(elapsed) + " ms";
        });
    }

    // Start interval
    setInterval(updateTimes, 50);

    // Initial update
    updateTimes();

})();



