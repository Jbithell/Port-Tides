// Start with groundwork
var ua = navigator.userAgent.toLowerCase();
var isAndroid = ua.indexOf("android") > -1; //&& ua.indexOf("mobile");


//Begin if statements
if (navigator.userAgent.toLowerCase().indexOf("windows phone") != -1) {
    document.getElementById(windowsp8).style.visibility = "visible";
    document.getElementById(android).style.visibility = "hidden";
} else if (isAndroid) {
    document.getElementById(android).style.visibility = "visible";
    document.getElementById(windowsp8).style.visibility = "hidden";
}
else {
    document.getElementById(windowsp8).style.visibility = "hidden";
    document.getElementById(android).style.visibility = "hidden";
}



