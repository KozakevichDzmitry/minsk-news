window.onload=()=>{
    new Swiper('.category-select-slider', {
        speed: 400,
        loop: true,
        slidesPerView: 5,
        spaceBetween: 15,
        wrapperClass: 'slider-container',
        slideClass: 'category-select-btn',
    });
};