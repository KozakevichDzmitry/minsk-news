document.addEventListener('DOMContentLoaded', () => {
    window._gallery = {
        ids: [],
        getSlidersIds: function() {
            const sliders = document.querySelectorAll('.gl-slider') || []
            sliders.forEach(elem => {
                const id = elem.id
                if(!this.ids.includes(id)) this.ids.push(id)

            })
        },
        initSlider: function() {
            this.getSlidersIds()
            this.ids.forEach(id => {
                const sliderThumbs = new Swiper(`#thumb_${id}`, {
                    speed: 400,
                    slidesPerView: 2,
                    spaceBetween: 20,
                    wrapperClass: `thumb-swiper-wrapper-${id}`,
                    slideClass: `thumb-swiper-slide-${id}`,
                    grabCursor: true,
                    preloadImages: false,
                    lazy: {
                        loadPrevNext: true,
                    },
                    navigation: {
                        nextEl: `.button-next-${id}`,
                        prevEl: `.button-prev-${id}`,
                    },
                    breakpoints: {
                        420: {
                            slidesPerView: 3,
                            spaceBetween: 10
                        },
                        580: {
                            slidesPerView: 4,
                            spaceBetween: 10
                        },
                    },
                    freeMode: true, // при перетаскивании превью ведет себя как при скролле
                });
                const swiper = new Swiper(`#gl_${id}`, {
                    speed: 800,
                    spaceBetween: 24,
                    slidesPerView: 1,
                    wrapperClass: `gl-swiper-wrapper-${id}`,
                    slideClass: `gl-swiper-slide-${id}`,
                    grabCursor: true,
                    preloadImages: false,
                    lazy: {
                        loadPrevNext: true,
                    },
                    mousewheel: {
                        sensitivity: 3,
                        eventsTarget: `.gl-swiper-slide-${id}`
                    },
                    thumbs: {
                        swiper: sliderThumbs
                    },
                });
                swiper.updateAutoHeight(800)
            })
        }
    }
    window._gallery.initSlider()
})