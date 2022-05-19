$(document).ready(function(){
    // Display or Hide background color for navbar when window is scrolled
    $(window).scroll(function() {
        if ($(document).scrollTop() > 50) {
            $(".navbar.fixed-top").css("background-color", "#325785");
        } else {
            $(".navbar.fixed-top").css("background-color", "transparent");
        }
    });
});