    const images = [
        {
            imageUrl: 'https://example.com/image1.jpg',
            linkUrl: 'https://soyjaks.party/'
        },
        {
            imageUrl: 'https://example.com/image2.jpg',
            linkUrl: 'https://link2.com'
        },
        {
            imageUrl: 'https://example.com/image3.jpg',
            linkUrl: 'https://link3.com'
        }
    ];

    function selectRandomImage() {
        const randomIndex = Math.floor(Math.random() * images.length);
        
        const randomImage = images[randomIndex];
        
        const imageElement = document.getElementById('randomImage');
        const linkElement = document.getElementById('imageLink');
        
        imageElement.src = randomImage.imageUrl;
        
        linkElement.href = randomImage.linkUrl;
    }

    window.onload = selectRandomImage;