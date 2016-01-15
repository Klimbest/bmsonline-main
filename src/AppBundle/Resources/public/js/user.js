//src/AppBundle/Resources/public/js/user.js

$(document).ready(function () {
    $('#user_control_window').delay(500).slideDown();

    var dialog,
            name = $('#offer_name'),
            contact = $('#offer_contact'),
            allFields = $([]).add(name).add(contact),
            tips = $(".validateTips");
    ;

    function updateTips(t) {
        tips.text(t).addClass("ui-state-highlight");
        
    }

    function checkLength(o, n) {
        if (o.val().length === 0) {
            o.addClass("ui-state-error");
            updateTips("Pole " + n + " nie może być puste.");
            return false;
        } else {
            return true;
        }
    }

    dialog = $("#dialog-form").dialog({
        autoOpen: false,
        height: 410,
        width: 500,
        modal: true,
        buttons: [
            {
                text: "Wyślij",
                click: function () {
                    var valid = true;
                    allFields.removeClass("ui-state-error");
                    valid = valid && checkLength(name, "imię");
                    valid = valid && checkLength(contact, "numer lub e-mail");
                    if(valid){
                        $("#contact").submit();
                    }
                }
            },
            {
                text: "Anuluj",
                click: function () {
                    $(this).dialog("close");

                }
            }],
        close: function () {
            dialog.dialog("close");
        }
    });


    $("#create-user").click(function () {
        dialog.dialog("open");
    });


});
