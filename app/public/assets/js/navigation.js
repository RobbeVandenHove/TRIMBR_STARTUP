let last_known_scroll_position = 0;
let ticking = false;
var topBar = document.querySelector('.top-bar');
var ul = document.querySelector('.top-bar .nav-bar ul');
var img = document.querySelector('.top-bar .logo');
var navBarMobile = document.querySelector('.mobile-nav');

function doSomething(scroll_pos) {
    if (scroll_pos > 0) {
        topBar.style.height = "10vh";
        ul.style.lineHeight = "10vh";
        img.style.height = "10vh";
        img.style.margin = "0vh";
        navBarMobile.style.height = "90vh";
        navBarMobile.style.top = "10vh";
    }
    else if (scroll_pos === 0) {
        topBar.style.height = "20vh";
        ul.style.lineHeight = "20vh";
        img.style.height = "14vh";
        img.style.margin = "3vh";
        navBarMobile.style.height = "80vh";
        navBarMobile.style.top = "20vh";
    }
}

document.addEventListener('scroll', function(e) {
    last_known_scroll_position = window.scrollY;

    if (!ticking) {
        window.requestAnimationFrame(function() {
            doSomething(last_known_scroll_position);
            ticking = false;
        });

        ticking = true;
    }
});

function navOpen(x) {
    x.classList.toggle('active');
    navBarMobile.classList.toggle('active');
}