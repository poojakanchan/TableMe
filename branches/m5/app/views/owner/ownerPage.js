
$(document).ready(function () {

    $("button#restaurant-detail-submit").click(function () {
        var description = $("textarea#restaurant-description").val();
        var address = $("textarea#restaurant-address").val();
        var phone = $("textarea#restaurant-phone").val();
        var validated = true;
        if (!validatePhoneNumber(phone)) {
            $('textarea#restaurant-phone').css("border", "#FF0000 1px solid");
            validated = false;
        }
        else {
            $('textarea#restaurant-phone').css("border", "");
        }

        if (!validateAddress(address)) {
            $('textarea#restaurant-address').css("border", "#FF0000 1px solid");
            validated = false;
        }
        else {
            $('textarea#restaurant-address').css("border", "");
        }
        if (validated) {
            submitRestaurantDetail(restaurantId, description, address, phone);
        }
    });

    $("button#operating-hours-submit").click(function () {
        updateOperatingHours($(this).data("restaurant-id"));
    });

    $("button#submit-change-profile").click(function () {
        var validated = true;
        if ($("#password1").val() != $("#password2").val()) {
            alert('Passwords do not match');
            validated = false;
        }
        if (!validateEmail($('input#email').val())) {
            $('input#email').css("border", "#FF0000 1px solid");
            validated = false;
        }
        else {
            $('input#email').css("border", "");
        }

        if (!validatePhoneNumber($('input#phone_number').val())) {
            $('input#phone_number').css("border", "#FF0000 1px solid");
            validated = false;
        }
        else {
            $('input#phone_number').css("border", "");
        }
        if (validated) {
            submitOwnerProfile();
        }
    });
    
    $("#add-event-button").click(function() {
       submitEvent(); 
    });
    
    $("button.remove-event").click(function() {
        var eventId = $(this).data("event-id");
        $("button#cancel-ok").data("event-id", eventId)
    });
    
    $("button.remove-hostess").click(function() {
        var hostessUsername = $(this).data("hostess-username");
        $("button#cancel-ok").data("hostess-username", hostessUsername);
    });
    
    $("button#cancel-ok").click(function() {
       if($(this).data("event-id") !== "") {
           removeEvent ($(this).data("event-id"));
           $(this).data("event-id", "");
       }
       else if ($(this).data("hostess-username") !== "") {
           removeHostess($(this).data("hostess-username"));
           $(this).data("hostess-username", "");
       }
    });
    
    $("button#add-host").click(function() {
        addHostess();
    });

});

function validateEmail(email) {
    var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    return re.test(email);
}

function validatePhoneNumber(phoneNumber) {
    var re = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
    return re.test(phoneNumber);
}

function validateAddress(address) {
    return address.length <= 100;
}

function validateDescription(description) {
    return address.length <= 150;
}

function submitRestaurantDetail(restaurantId, description, address, phone) {
    var request = $.ajax({
        method: "POST",
        url: '../../controllers/Owner_controller.php',
        data: {functionName: 'updateRestaurant', restaurantId: restaurantId, description: description, address: address, phoneNum: phone}
    });

    request.done(function (data) {
        if (data.success === '1') {
            alert("Successfully changed restaurant information");
        }
        else {
            console.log(data.error);
        }
    });

    request.fail(function (jqXHR, textStatus) {
        console.log(jqXHR);
    });
}

function submitEvent() {
    var title = $("#add-event-name");
    var description = $("#add-event-description");
    var date = $("add-event-date");
    if (title.val().length > 50) {
        title.css("border", "#FF0000 1px solid");
        return false;
    }
    else {
        title.css("border", "");
    }

    if (description.val().length > 200) {
        description.css("border", "#FF0000 1px solid");
        return false;
    }
    else {
        description.css("border", "");
    }

    submitImage("add-event-image", "add-event-form");
}

function submitImage(inputId, formId) {
    var fuData = document.getElementById(inputId);
    var fileUploadPath = fuData.value;

    if (typeof fileUploadPath == 'undefined' || fileUploadPath == '') {
        alert("Please upload an image");
        reutrn;
    }

    var extension = fileUploadPath.substring(fileUploadPath.lastIndexOf('.') + 1).toLowerCase();

    if (extension != "jpg" && extension != "jpeg") {
        alert("Photo only allows file types of JPG and JPEG.");
        return;
    }

    var fuFiles = fuData.files;
    if (!fuData.files || !fuData.files[0]) {
        alert("Image file cannot be empty.");
        return;
    }

    var size = fuData.files[0].size;

    if (size > 5242880) {
        alert("Image size cannot be more than 5MB");
        return;
    }

    $("form#" + formId).submit();
}

function updateOperatingHours(restaurantId) {
    var request = $.ajax({
        method: "POST",
        url: '../../controllers/Owner_controller.php',
        data: {functionName: 'updateOperatingHours',
            restaurantId: restaurantId,
            mondayFrom: $("input#monday-from").val(),
            mondayTo: $("input#monday-to").val(),
            tuesdayFrom: $("input#tuesday-from").val(),
            tuesdayTo: $("input#tuesday-to").val(),
            wednesdayFrom: $("input#wednesday-from").val(),
            wednesdayTo: $("input#wednesday-to").val(),
            thursdayFrom: $("input#thursday-from").val(),
            thursdayTo: $("input#thursday-to").val(),
            fridayFrom: $("input#friday-from").val(),
            fridayTo: $("input#friday-to").val(),
            saturdayFrom: $("input#saturday-from").val(),
            saturdayTo: $("input#saturday-to").val(),
            sundayFrom: $("input#sunday-from").val(),
            sundayTo: $("input#sunday-to").val()
        }
    });

    request.done(function (data) {
        if (data.success === '1') {
            alert("Successfully changed operating hours information");
        }
        else {
            console.log(data);
        }
    });

    request.fail(function (jqXHR, textStatus) {
        console.log(jqXHR);
    });
}

function submitOwnerProfile() {

    var request = $.ajax({
        url: '../../controllers/Owner_controller.php',
        method: 'POST',
        data: {functionName: 'changeOwnerProfile',
            username: $("button#submit-change-profile").data("username"),
            phoneNum: $("input#phone_number").val(),
            email: $("input#email").val(),
            password: $("input#password1").val()
        }
    });

    request.done(function (data) {
        if (data.success === '1') {
            alert("Successfully changed profile");
        }
        else {
            console.log(data);
        }
    });

    request.fail(function (jqXHR, textStatus) {
        console.log(jqXHR);
    });
}

function removeEvent(eventId) {
    
    var request = $.ajax({
        url: '../../controllers/Owner_controller.php',
        method: 'POST',
        data: {functionName: 'removeEvent',
            eventId: eventId
        }
    });

    request.done(function (data) {
        if (data.success === '1') {
            $("tr#event-id"+eventId).remove();
            alert("Successfully removed special event");
        }
        else {
            console.log(data);
        }
    });

    request.fail(function (jqXHR, textStatus) {
        console.log(jqXHR);
    });
}

function removeHostess(hostessUsername) {
    
    var request = $.ajax({
        url: '../../controllers/Owner_controller.php',
        method: 'POST',
        data: {functionName: 'removeHostess',
            hostessUsername: hostessUsername
        }
    });

    request.done(function (data) {
        if (data.success === '1') {
            $("tr#hostess-username-"+hostessUsername).remove();
            alert("Successfully removed hostess");
        }
        else {
            console.log(data);
        }
    });

    request.fail(function (jqXHR, textStatus) {
        console.log(jqXHR);
    });
}

function addHostess() {
    var username = $("#host-username").val();
    var password1 = $("#host-password1").val();
    var password2 = $("#host-password2").val();
    if (username.length > 20 || username.length===0) {
        $("#host-username").css("border", "#FF0000 1px solid");
        return false;
    }
    else {
        $("#host-username").css("border", "");
    }

    if (password1.length>20 || password1.length===0) {
        $("#host-password1").css("border", "#FF0000 1px solid");
        return false;
    }
    else {
        $("#host-password1").css("border", "");
    }
    
    if (password1 !== password2) {
        alert ("Passwords do not match");
        return false;
    }

    if (jQuery.inArray(username, existingUsernames) !== -1) {
        alert("Username already taken");
        return false;
    }

    var request = $.ajax({
        url: '../../controllers/Owner_controller.php',
        method: 'POST',
        data: {functionName: 'addHostess',
            username: username,
            password: password1,
            restaurantId: restaurantId
        }
    });

    request.done(function (data) {
        if (data.success === '1') {
            alert("Successfully added host account");
            var newRow = '<tr id="hostess-username-' + username + '"><td>' + username + '</td><td>' + password1 + '</td><td><button type="button" class="btn btn-danger remove-hostess" data-toggle="modal" data-target="#confirm-cancel" data-hostess-username="' + username + '">Remove</button></td></tr>';
            $("tr[id*='hostess-username-']").last().after(newRow);
            $("button.remove-hostess").click(function () {
                var hostessUsername = $(this).data("hostess-username");
                $("button#cancel-ok").data("hostess-username", hostessUsername);
            });
        }
        else {
            console.log(data);
        }
    });

    request.fail(function (jqXHR, textStatus) {
        console.log(jqXHR);
    });
}