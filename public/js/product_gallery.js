(function() {
    const mainImage = document.querySelector('.product-page .product #main-image'),
        allImagesContainers = document.querySelectorAll('.product-page .product .multiple-images .image-container');

    // Change Main Image With Clicked One From The Gallery
    allImagesContainers.forEach(imageContainer => {

        imageContainer.addEventListener('click', changeMainImage);

    });

    function changeMainImage() {

        mainImage.classList.remove('active');

        mainImage.addEventListener('transitionend', () => {

            mainImage.src = this.querySelector('img').src;

            mainImage.classList.add('active');

        });

        allImagesContainers.forEach((imageContainer) => imageContainer.classList.remove('selected'));


        this.classList.add('selected');


    }
})();
