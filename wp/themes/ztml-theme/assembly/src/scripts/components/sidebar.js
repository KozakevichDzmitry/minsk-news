jQuery(document).ready(function ($) {
    const sidebarLabel = $("#sidebar-label");
    const sidebar = $("#sidebar-wrapper");

    let sidebarOn = false;
    sidebarLabel.on("click", function (e) {
        sidebarOn = !sidebarOn;
        sidebarOn ? sidebar.addClass("active") : sidebar.removeClass("active");
        sidebar.css("right", sidebarOn ? "0px" : "-320px");
    });
});