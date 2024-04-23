<script>
    $.validator.addMethod("customValidation", function(value, element) {
        var thatVal = value.trim();
        // Check if input consists only of digits
        if (/^\d+$/.test(thatVal)) {
            return false;
        }

        return true; // If none of the above conditions are met, input is valid
    }, 'Please enter valid Email');

    $("#loginForm").validate({
        rules: {
            email: {
                required: true,
                email: true,
                customValidation: true
            },

        },
        messages: {
            email: {
                required: "Please enter Email",
                email: "Please enter valid Email",
                customValidation: "Please enter vaild Email"
            },
        },


    });
</script>