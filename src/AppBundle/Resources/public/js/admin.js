//src/AppBundle/Resources/public/js/admin.js

$(document).ready(function () {

    var h = $("#roleBlock").css("height");
    $(".controls").css("line-height", h).show();

    $("#addButton").click(function () {
        document.getElementById("addForm").submit();
    });
    $("#addButton, #removeButton").hover(function () {
        $(this).removeClass("fa-2x").addClass("fa-3x");
    }, function () {
        $(this).removeClass("fa-3x").addClass("fa-2x");
    });
    $("#removeButton").click(function () {
        document.getElementById("removeForm").submit();
    });
    $(".obiekt").hover(function () {
        $(this).css("background-color", "#AAA");
    }, function () {
        $(this).css("background-color", "#DDD");
    });
    $("#datepicker").datepicker();


});