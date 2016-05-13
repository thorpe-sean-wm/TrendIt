$(document).ready(function() {
    var postCreateOpen = false;

    $("#postCreate").click(function() {
        if (postCreateOpen == false){
            postCreateOpen = true;
            $("#postBox").fadeIn(100);
        }
        else{
            postCreateOpen = false;
            $("#postBox").fadeOut(100);
        }
    });
});