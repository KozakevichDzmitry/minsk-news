jQuery(document).ready(function ($) {
    const districtTablet = $(".district-tablet-template")
    const districtTabletEls = $(".district-tablet-template .districts-list-container .district-item")
    const districtList = $(".districts-list .district-caption")
    let swiper = null;
    let initialSlide = 0;
    const changeActiveDistrictsListItem = (id)=>{
        $(districtList).each(function () {
            $(this).removeClass("active")
        })
        $(`.districts-list`).find("[data-id='" + id + "']").addClass('active')
    }
    const slideChangeEvent = ()=>{
        if (swiper !== null) {
            const id = swiper.activeIndex
            changeActiveDistrictsListItem(id)
        }
    }
    const swiperInit = () => {
        if (swiper === null) {
            swiper = new Swiper('.district-tablet-template', {
                wrapperClass: 'districts-list-container',
                slideClass: 'district-item',
                slideActiveClass: 'active',
                slidesPerView: 1,
                pagination: ".district-tablet__pagination",
                paginationClickable: true,
                clickable: true,
                loop: false,
                centeredSlides: true,
                initialSlide: initialSlide,
                paginationBulletRender: function (index, className) {
                    return '<span class="swiper-pagination-bullet"></span>';
                },
            });
            swiper.on('slideChangeEnd', slideChangeEvent);
        }
    }
    const swiperDestroy = () => {
        if (swiper !== null) {
            swiper.off('slideChangeEnd', slideChangeEvent);
            swiper.destroy()
            swiper = null
            $('.districts-list-container').removeAttr('style');
            $('.district-item').removeAttr('style');
        }
    }
    const getDevice = () => {
        let device = null
        const windowWidth = $(window).width()
        if (windowWidth > 768 && windowWidth <= 940) {
            device = 'tablet'
        } else if (windowWidth > 940) {
            device = 'desktop'
        } else if (windowWidth <= 768) {
            device = 'mobile'
        }
        return device
    }
    const initDistrict = () => {
        let hasActiveElem = false
        $(districtTabletEls).each(function () {
            if ($(this).hasClass("active")) hasActiveElem = true
        })
        if (!hasActiveElem) {
            $(districtTabletEls[0]).addClass("active");
            $(districtList[0]).addClass("active");
        }
    }
    const tabletAction = (e) => {
        if (e) {
            const target = $(e.currentTarget);
            const caption = target.closest(".district-caption");
            if (caption) {
                const id = Number(caption[0].dataset.id)
                initialSlide = id
                $(districtTabletEls).each(function () {
                    const isTarget = $(this).data("id") === id
                    if (isTarget) $(this).addClass("active")
                    else $(this).removeClass("active")
                })
                $(districtList).each(function () {
                    const isTarget = $(this).data("id") === id
                    if (isTarget) $(this).addClass("active")
                    else $(this).removeClass("active")
                })
            }
        }
    }
    const desktopAction = (e) => {
        if (e) {
            const target = $(e.currentTarget);
            const id = $(target).data("id")
            initialSlide = id
            $(districtTabletEls).each(function () {
                $(this).removeClass("active")
            })
            target.addClass("active")
            changeActiveDistrictsListItem(id)
        }
    }
    const toggleAction = () => {
        const device = getDevice()
        initDistrict()
        switch (device) {
            case 'desktop':
                swiperDestroy()
                districtList.off("click", tabletAction);
                districtTabletEls.on("click", desktopAction);
                break
            case 'tablet':
                swiperDestroy()
                districtTabletEls.off("click", desktopAction);
                districtList.on("click", tabletAction);
                break
            case 'mobile':
                districtTabletEls.off("click", desktopAction);
                districtList.off("click", tabletAction);
                swiperInit()
                break
        }
    }

    if (districtTablet.length && districtTabletEls.length && districtList.length) {
        toggleAction()
        $(window).on("resize", toggleAction);
    }


});