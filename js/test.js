<!--
// Random Image Generator
// Array with random image links is created. You can add as many links as you want/need.

// Regular Array

var randomImage = new Array();

randomImage[0] = "https://soyjak.party/static/banner/1.png";
randomImage[1] = "https://soyjak.party/static/banner/2.png";
randomImage[2] = "https://soyjak.party/static/banner/3.png";
randomImage[3] = "https://soyjak.party/static/banner/4.png";
randomImage[4] = "https://soyjak.party/static/banner/5.png";
randomImage[5] = "https://soyjak.party/static/banner/6.png";
randomImage[6] = "https://soyjak.party/static/banner/7.png";
randomImage[7] = "https://soyjak.party/static/banner/8.gif";
randomImage[8] = "https://soyjak.party/static/banner/9.png";
randomImage[9] = "https://soyjak.party/static/banner/10.png";
randomImage[10] = "https://soyjak.party/static/banner/11.png";
randomImage[11] = "https://soyjak.party/static/banner/12.png";
randomImage[12] = "https://soyjak.party/static/banner/13.gif";
randomImage[13] = "https://soyjak.party/static/banner/14.png";
randomImage[14] = "https://soyjak.party/static/banner/15.png";
randomImage[15] = "https://soyjak.party/static/banner/16.png";
randomImage[16] = "https://soyjak.party/static/banner/61.png";
randomImage[17] = "https://soyjak.party/static/banner/18.png";
randomImage[18] = "https://soyjak.party/static/banner/19.png";
randomImage[19] = "https://soyjak.party/static/banner/20.png";
randomImage[20] = "https://soyjak.party/static/banner/21.gif";
randomImage[21] = "https://soyjak.party/static/banner/22.gif";
randomImage[22] = "https://soyjak.party/static/banner/23.png";
randomImage[23] = "https://soyjak.party/static/banner/24.png";
randomImage[24] = "https://soyjak.party/static/banner/25.png";
randomImage[25] = "https://soyjak.party/static/banner/26.png";
randomImage[26] = "https://soyjak.party/static/banner/27.png";
randomImage[27] = "https://soyjak.party/static/banner/28.png";
randomImage[28] = "https://soyjak.party/static/banner/29.png";
randomImage[29] = "https://soyjak.party/static/banner/30.png";
randomImage[30] = "https://soyjak.party/static/banner/31.png";
randomImage[31] = "https://soyjak.party/static/banner/32.png";
randomImage[32] = "https://soyjak.party/static/banner/33.gif";
randomImage[33] = "https://soyjak.party/static/banner/34.png";
randomImage[34] = "https://soyjak.party/static/banner/35.png";
randomImage[35] = "https://soyjak.party/static/banner/36.png";
randomImage[36] = "https://soyjak.party/static/banner/37.gif";
randomImage[37] = "https://soyjak.party/static/banner/38.gif";
randomImage[38] = "https://soyjak.party/static/banner/39.png";
randomImage[39] = "https://soyjak.party/static/banner/40.gif";
randomImage[40] = "https://soyjak.party/static/banner/41.png";
randomImage[41] = "https://soyjak.party/static/banner/42.png";
randomImage[42] = "https://soyjak.party/static/banner/43.png";
randomImage[43] = "https://soyjak.party/static/banner/44.png";
randomImage[44] = "https://soyjak.party/static/banner/62.png";
randomImage[45] = "https://soyjak.party/static/banner/46.png";
randomImage[46] = "https://soyjak.party/static/banner/47.png";
randomImage[47] = "https://soyjak.party/static/banner/48.png";
randomImage[48] = "https://soyjak.party/static/banner/49.png";
randomImage[49] = "https://soyjak.party/static/banner/50.png";
randomImage[50] = "https://soyjak.party/static/banner/51.png";
randomImage[51] = "https://soyjak.party/static/banner/52.png";
randomImage[52] = "https://soyjak.party/static/banner/53.png";
randomImage[53] = "https://soyjak.party/static/banner/54.png";
randomImage[54] = "https://soyjak.party/static/banner/55.gif";
randomImage[55] = "https://soyjak.party/static/banner/56.png";
randomImage[56] = "https://soyjak.party/static/banner/57.gif";
randomImage[57] = "https://soyjak.party/static/banner/58.png";
randomImage[58] = "https://soyjak.party/static/banner/59.png";
randomImage[59] = "https://soyjak.party/static/banner/60.gif";
//skip 61 and 62's files
randomImage[60] = "https://soyjak.party/static/banner/63.png";
randomImage[61] = "https://soyjak.party/static/banner/64.png";
randomImage[62] = "https://soyjak.party/static/banner/65.png";
randomImage[63] = "https://soyjak.party/static/banner/66.png";
randomImage[64] = "https://soyjak.party/static/banner/67.png";
randomImage[65] = "https://soyjak.party/static/banner/68.jpg";
randomImage[66] = "https://soyjak.party/static/banner/69.png";
randomImage[67] = "https://soyjak.party/static/banner/70.png";
randomImage[68] = "https://soyjak.party/static/banner/71.png";
randomImage[69] = "https://soyjak.party/static/banner/72.png";
if(window.location.href.includes('/qa/')) {
    randomImage[70] = "https://soyjak.party/static/banner/45.png";
}
else {
    randomImage[70] = "https://soyjak.party/static/banner/1.png";
}


function getRandomImage() { 
var number = Math.floor(Math.random()*randomImage.length);
document.write('<img border="1" src="'+randomImage[number]+'" style="max-width: 300px;" />');
}
getRandomImage()
//-->
