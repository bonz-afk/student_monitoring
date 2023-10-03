function setActive(id){
    $(".top-right-container .landing").removeClass("active");

    // Add the 'active' class to the specific <span> element
    $("#" + id).addClass("active");
}

function toggleMenu() {
    $('.nav-links').toggleClass('menu-active');
    $('.top-right-container').toggleClass('menu-active');
    $('.top-logo').toggleClass('menu-active');
    $('.right-container').toggleClass('menu-active');
    $('.top-container').toggleClass('menu-active');
}