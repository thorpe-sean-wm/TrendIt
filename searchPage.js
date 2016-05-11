/*
function hoverControl(mouse) {
    if (mouse == 'on') {
        searchBtn.style.webkitAnimationPlayState = "running";
        clock = 0;
        time = setInterval(function() {clock = clock + 20;}, 20);
    }
    if (mouse == 'off') {
        //var test = document.getElementById("searchSubmit");
        //var result = getStyle(test, '-webkit-animation');
        console.log(clock % 2000);
        clearInterval(time);
        time2 = setInterval(function() {magic();}, (2000 - (clock % 2000)));
    }
}
function magic() {
    searchBtn.style.webkitAnimationPlayState = "paused";
    clearInterval(time2);
}
*/
// FUNCTION TO DO WHAT JAVASCRIPT SHOULD ALREADY DO. THANKS RANDOM PERSON ON THE INTERNET FOR SOLVING THIS.
function getStyle(el, styleProp) {
    var value, defaultView = (el.ownerDocument || document).defaultView;
    // W3C standard way:
    if (defaultView && defaultView.getComputedStyle) {
        // sanitize property name to css notation
        // (hypen separated words eg. font-Size)
        styleProp = styleProp.replace(/([A-Z])/g, "-$1").toLowerCase();
        return defaultView.getComputedStyle(el, null).getPropertyValue(styleProp);
    } else if (el.currentStyle) { // IE
        // sanitize property name to camelCase
        styleProp = styleProp.replace(/\-(\w)/g, function(str, letter) {
            return letter.toUpperCase();
        });
        value = el.currentStyle[styleProp];
        // convert other units to pixels on IE
        if (/^\d+(em|pt|%|ex)?$/i.test(value)) {
            return (function(value) {
                var oldLeft = el.style.left, oldRsLeft = el.runtimeStyle.left;
                el.runtimeStyle.left = el.currentStyle.left;
                el.style.left = value || 0;
                value = el.style.pixelLeft + "px";
                el.style.left = oldLeft;
                el.runtimeStyle.left = oldRsLeft;
                return value;
            })(value);
        }
        return value;
    }
}