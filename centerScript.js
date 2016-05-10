// Declaring variables that are not local to certain functions
var parentDiv;
// The function that is applied to the body tag
function start() {
    var targets = document.getElementsByClassName("centerDiv");
    var number = targets.length;
    var tracker = 0;
    for (targets[tracker]; tracker <= (number - 1) ; tracker++) {
        parentDiv = targets[tracker].parentNode;
        centering(targets[tracker], parentDiv);
    }
}
// This function is called for each div with the class of "centerDiv" and will center that div inside of its parent div
function centering(input, parent) {
    var w = input.style.width;
    var wLength = w.length;
    w = Number(w.substring(0, (wLength - 2)));
    var PW = parent.style.width;
    var PWLength = PW.length;
    PW = Number(PW.substring(0, (PWLength - 2)));
    input.style.marginLeft = (String((PW / 2) - (w / 2)) + "px");
}