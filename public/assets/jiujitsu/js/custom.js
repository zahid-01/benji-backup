$(document).ready(() => {
    $("#toggleSideMenu").click(function () {
        $(".side-menu li a span").toggleClass("hidden");
        $("body").toggleClass("side-menu-open");
    });

    $("#toggleSideMenuMobile").click(function () {
        $(".side-menu").toggleClass("hidden");
        $("body").toggleClass("side-menu-open");
    });

    $(".filter-courses").click(async function () {
        $(".filter-courses").removeClass("active");
        $(this).addClass("active");
        showDuplicates();
        var filterTag = $(this).data("tag");
        await $(".filter-tabs > a").each(function () {
            if (!$(this).hasClass(filterTag)) {
                $(this).hide();
            }
        });
        hideDuplicates();
    });

    var tabs = $(".tabs");
    var panel = $(".tab-content");

    $(".change-tab").click(function () {
        var id = $(this).data("target");
        var parent = $(this).data("parent");

        $(`#${parent} .active`).removeClass("active");

        $(this).addClass("active");

        $(`#${parent} .content`).addClass("hidden");

        $(`#${parent} #${id}`).removeClass("hidden");
    });
});

function hideDuplicates() {
    var renderedWebinars = [];
    $(".filter-tabs > a").each(function () {
        var webinar = $(this).data("webinar");
        if (!renderedWebinars.includes(webinar)) {
            renderedWebinars.push(webinar);
        } else {
            $(this).hide();
        }
    });
}

function showDuplicates() {
    var renderedWebinars = [];
    $(".filter-tabs > a").each(function () {
        $(this).show();
    });
}
