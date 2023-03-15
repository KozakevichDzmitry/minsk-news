window.addEventListener('DOMContentLoaded', function (e) {
    function resizaIframe() {
        let frame = document.querySelectorAll(".page-content iframe:not(.instagram-media)");
        frame.forEach(elem => {
            let width = Math.max(elem.scrollWidth, elem.offsetWidth, elem.clientWidth);
            elem.style.height = (width / 16) * 9 + 'px';
        })
    }
    window.addEventListener("resize", resizaIframe);
    resizaIframe()
})