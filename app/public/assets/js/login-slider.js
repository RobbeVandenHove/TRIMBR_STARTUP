var x = document.getElementById("login");
var y = document.getElementById("register");
var z = document.getElementById("btn-state");

var log = document.querySelector(".button-box button:nth-child(2)");
var reg = document.querySelector(".button-box button:nth-child(3)");

function register() {
    x.style.left = "-400px";
    y.style.left = "50px";
    z.style.left = "110px";
    log.style.color = "rgb(255, 0, 0)";
    reg.style.color = "white";
}

function login() {
    x.style.left = "50px";
    y.style.left = "450px";
    z.style.left = "0";
    log.style.color = "white";
    reg.style.color = "rgb(255, 0, 0)";
}