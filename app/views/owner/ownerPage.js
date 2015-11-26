$(document).ready(function () {
    $("#restaurant_detail_submit").click(function () {
        var validated = true;

        if (!validatePhoneNumber($('#restaurantPhone').val())) {
            $('#restaurantPhone').css("border", "#FF0000 1px solid");
            validated = false;
        }
        else {
            $('#restaurantPhone').css("border", "");
        }

        if (!validateAddress($('#restaurantAddress').val())) {
            $('#restaurantAddress').css("border", "#FF0000 1px solid");
            validated = false;
        }
        else {
            $('#restaurantAddress').css("border", "");
        }

        if (!validateDescription($('#restaurantDescription').val())) {
            $('#restaurantDescription').css("border", "#FF0000 1px solid");
            validated = false;
        }
        else {
            $('#restaurantDescription').css("border", "");
        }

        return validated;
    });

    $("button#restaurant-detail-submit").click(function () {
        var description = $("textarea#restaurant-description").val();
        var address = $("textarea#restaurant-address").val();
        var phone = $("textarea#restaurant-phone").val();
        var restaurantId = $(this).data("restaurant-id");
        submitRestaurantDetail(restaurantId, description, address, phone);
    });

    $("button#operating-hours-submit").click(function() {
       updateOperatingHours($(this).data("restaurant-id")); 
    });
});

function validateAddress(address) {
    return address.length <= 100;
}

function validateDescription(description) {
    return address.length <= 150;
}

function validatePhoneNumber(phoneNumber) {
    var re = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
    return re.test(phoneNumber);
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

    if (typeof fileUploadPath =='undefined' || fileUploadPath == '') {
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
