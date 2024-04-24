<script>
    $(document).ready(function() {
        // Validate the form with ID 'interest_and_hobbies'
        $('#interest_and_hobby').on('keypress', 'input', function(e) {
            // Check if the Enter key is pressed (key code 13)
            console.log("Key pressed");
            if (e.which === 13) {
                // Trigger click event of the "Add More" button
                $('#add').click();
            }
        });


        $(document).on('click', '#addMore', function() {

            $("#parentAddBtn").hide();
            var addMoreData = $("#addMoreData").html();
            $("#interest").append(addMoreData);
        });
        $(document).on('click', '.remove', function() {
            $(this).parent().parent().remove();
        });
        $("#interest .interest_and_hobby").each(function() {
            $(this).focus(function() {
                $(this).next("span").text("");
            });
        });


        $('#add').click(function(e) {
            e.preventDefault();
            var promises = [];
            var isValid = true; // Flag to track overall form validity

            $('#interest .interest_and_hobby').each(function() {
                var that = $(this);
                var thatVal = that.val().trim();

                // Reset previous error messages
                that.next('.text-danger').text('');

                // Validation checks
                var charCount = 0;
                for (var i = 0; i < thatVal.length; i++) {
                    var char = thatVal.charAt(i);
                    if (/[a-zA-Z]/.test(char)) { // Check if the character is a letter using regex
                        charCount++;
                    }
                }


                if (thatVal === '') {
                    that.next('.text-danger').text('Please enter Interest and Hobby');
                    isValid = false;

                } else if (charCount < 2) {
                    that.next('.text-danger').text('Please enter valid Interest and Hobby');
                    isValid = false;
                } else if (/^[0-9@#$%^&*()_+=\[\]{};:,.<>?|\\/-]+$/.test(thatVal)) {
                    that.next('.text-danger').text('Please enter valid Interest and Hobby');
                    isValid = false;

                } else if (/^\d+$/.test(thatVal)) {
                    that.next('.text-danger').text('Please enter valid Interest and Hobby');
                    isValid = false;
                } else if (/^[^a-zA-Z0-9 ]+$/.test(thatVal)) {
                    that.next('.text-danger').text('Please enter valid Interest and Hobby');
                    isValid = false;
                } else {
                    var promise = new Promise(function(resolve, reject) {
                        $.ajax({
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                            },
                            dataType: 'json',
                            type: "POST",
                            url: "{{ route('interest_and_hobby.exist') }}",
                            data: {
                                interest_and_hobby: thatVal
                            },
                            success: function(output) {
                                if (output == false) {
                                    that.next('.text-danger').text('Interest and Hobby already exist');
                                    isValid = false;
                                    resolve(false);
                                } else {
                                    resolve(true);
                                }
                            },
                            error: function() {
                                reject("Error occurred");
                            }
                        });
                    });
                    promises.push(promise);
                }
            });

            // If any validation failed, do not submit the form
            if (!isValid) {
                console.log("Validation failed, cannot submit the form");
                return;
            }

            // If all validations passed, wait for AJAX requests to complete
            Promise.all(promises).then(function(results) {
                if (results.includes(false)) {
                    // If any result is false, do not submit the form
                    console.log("Duplicate interest and hobby found");
                } else {
                    // If all results are true, submit the form
                    console.log("No duplicate interest and hobby, submitting form");
                    $("#interest_and_hobby").submit();
                }
            }).catch(function(error) {
                console.error("Error occurred during AJAX request:", error);
            });
        });




        $.validator.addMethod("customValidation", function(value, element) {
            var thatVal = value.trim();
            if (thatVal === '') {
                return false; // Empty input is invalid
            }
            // Check if input consists only of special characters or digits
            if (/^[0-9@#$%^&*()_+=\[\]{};:,.\/<>?|\\/-]+$/.test(thatVal)) {
                return false;
            }
            // Check if input consists only of digits
            if (/^\d+$/.test(thatVal)) {
                return false;
            }
            // Check if input consists only of non-alphanumeric characters
            if (/^[^a-zA-Z0-9 ]+$/.test(thatVal)) {
                return false;
            }
            // Check if input contains at least 2 alphabetical characters
            var charCount = 0;
            for (var i = 0; i < thatVal.length; i++) {
                var char = thatVal.charAt(i);
                if (/[a-zA-Z]/.test(char)) { // Check if the character is a letter using regex
                    charCount++;
                }
            }
            if (charCount < 2) {
                return false;
            }
            return true; // If none of the above conditions are met, input is valid
        }, 'Please enter valid Interest and Hobby');

        $("#interest_and_hobby").validate({
            rules: {
                interest_and_hobby: {
                    required: true,
                    remote: {
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        url: "{{route('interest_and_hobby.exist')}}",
                        method: "POST",
                        data: {
                            interest_and_hobby: function() {
                                return $("input[name='interest_and_hobby']").val();
                            },
                            id: function() {
                                return $("input[name='id']").val();
                            },
                        },
                    },
                    customValidation: true
                },

            },
            messages: {
                interest_and_hobby: {
                    required: "Please enter Interest and Hobby",
                    remote: "Interest and Hobby already exist",
                    customValidation: "Please enter valid Interest and Hobby "
                },

            },


        });



        $(document).on('click', '#edit', function() {
            if ($("#interest_and_hobby").valid()) {
                $("#interest_and_hobby").submit();
            }
        })


        $(document).on("click", "#delete", function(event) {
            var userURL = $(this).data("url");
            var id = $(this).data("id");

            event.preventDefault();
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                method: "post",
                url: "{{route('interest_and_hobby.selectedbyuser')}}",
                data: {

                    id: id
                },
                dataType: "json",
                success: function(output) {
                    if (output == false) {
                        errorAlert("Interest and Hobby");

                    } else {
                        swal({
                            title: `Are you sure you want to delete this record?`,
                            text: "If you delete this, it will be gone forever.",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        }).then((willDelete) => {
                            if (willDelete) {


                                $.ajax({
                                    headers: {
                                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                            "content"
                                        ),
                                    },
                                    method: "DELETE",
                                    url: userURL,
                                    dataType: "json",
                                    success: function(output) {
                                        if (output == true) {

                                            sessionStorage.setItem('showSuccessNotification', 'true');
                                            location.reload();


                                        } else {
                                            errorAlert("Interest and Hobby");

                                        }
                                    },
                                });
                            }
                        });
                    }
                }
            });


        });
        if (sessionStorage.getItem('showSuccessNotification')) {
            // Show the success notification using Toastr

            toastr.success("Interest and Hobby deleted successfully!");
            // Remove the flag from sessionStorage
            sessionStorage.removeItem('showSuccessNotification');
        }

    });
</script>