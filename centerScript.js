var contentDiv;

function start() {
    contentDiv = document.getElementById("main");
    var targets = document.getElementsByClassName("centerDiv");
    var number = targets.length;
    var tracker = 0;
    for (targets[tracker]; tracker <= (number - 1) ; tracker++) {
        centering(targets[tracker]);
    }
}


function centering(input) {
    var w = input.style.width;
    var wLength = w.length;
    w = Number(w.substring(0 , (wLength - 2)));
    var CW = contentDiv.style.width;
    var CWLength = CW.length;
    CW = Number(CW.substring(0, (CWLength - 2)));
    console.log(CW);

//    console.log(LMar);
}