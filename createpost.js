$(document).ready(function() {
    var postCreateOpen = false;

    $("#postCreate").click(function() {
        if (postCreateOpen == false){
            postCreateOpen = true;
            $("#postCreate").html("<p>&nbsp;--</p>");
            $("#postBox").fadeIn(100);
        }
        else{
            postCreateOpen = false;
            $("#postCreate").html("<p>&nbsp;+</p>");
            $("#postBox").fadeOut(100);
        }
    });
});