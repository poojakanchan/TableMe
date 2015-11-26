$(document).ready(function () {

    $("button#restaurant-detail-submit").click(function () {
        var description = $("textarea#restaurant-description").val();
        var address = $("textarea#restaurant-address").val();
        var phone = $("textarea#restaurant-phone").val();
        var restaurantId = $(this).data("restaurant-id");
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
        url: 'ownerPageAjax.php',
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

function submitImage(inputName, formId) {
    var fuData = document.getElementById(inputName);
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
        url: 'ownerPageAjax.php',
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
       url: 'ownerPageAjax.php',
       method: 'POST',
       data: { functionName: 'changeOwnerProfile',
               username: $("button#submit-change-profile").data("username"),
               phoneNum: $("input#phone_number").val(),
               email: $("input#email").val(),
               password: $("input#password1").val()
       }
    });
    
    request.done(function(data) {
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