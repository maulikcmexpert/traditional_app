<script>
    $(document).ready(function() {
        // Validate the form with ID 'interest_and_hobbies'



        $(document).on('click', '#addMore', function() {


            var addMoreData = $("#addMoreData").html();
            $("#curse_word").append(addMoreData);
        });
        $(document).on('click', '.remove', function() {
            $(this).parent().parent().remove();
        });
        $("#curse_word .words").each(function() {
            $(this).focus(function() {
                $(this).next("span").text("");
            });
        });


        $('#add').click(function(e) {
            e.preventDefault();
            var promises = [];
            var isValid = true;
            $('#curse_word .words').each(function() {
                var that = $(this);
                var thatVal = that.val().trim();
                var charCount = 0;
                for (var i = 0; i < thatVal.length; i++) {
                    var char = thatVal.charAt(i);
                    if (/[a-zA-Z]/.test(char)) { // Check if the character is a letter using regex
                        charCount++;
                    }
                }
                if (thatVal === '') {
                    that.next('.text-danger').text('Please enter Curse Word');
                    isValid = false;

                } else if (charCount < 2) {
                    that.next('.text-danger').text('Please enter valid Curse Word');
                    isValid = false;
                } else if (/^[0-9@#$%^&*()_+=\[\]{};:,.<>?|\\/-]+$/.test(thatVal)) {
                    that.next('.text-danger').text('Please enter valid Curse Word');
                    isValid = false;

                } else if (/^\d+$/.test(thatVal)) {
                    that.next('.text-danger').text('Please enter valid Curse Word');
                    isValid = false;
                } else if (/^[^a-zA-Z0-9 ]+$/.test(thatVal)) {
                    that.next('.text-danger').text('Please enter valid Curse Word');
                    isValid = false;
                } else {
                    var promise = new Promise(function(resolve, reject) {
                        $.ajax({
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                            },
                            dataType: 'Json',
                            type: "POST",
                            url: "{{route('curseword.exist')}}",
                            data: {
                                words: thatVal
                            },
                            success: function(output) {
                                if (output == false) {
                                    that.next('.text-danger').text('Curse Word already exist');
                                    isValid = false;
                                    resolve(false);
                                } else {
                                    that.next('.text-danger').text('');
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
            if (!isValid) {
                console.log("Validation failed, cannot submit the form");
                return;
            }
            Promise.all(promises).then(function(results) {
                if (results.includes(false)) {
                    // If any result is false, do not submit the form
                    console.log("Duplicate Curse Word found");
                } else if (results.includes(true)) {
                    // If all results are true, submit the form
                    console.log("No duplicate Curse Word, submitting form");
                    $("#curseword").submit();
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
        }, 'Please enter valid Curse Word');

        $("#curseword").validate({
            rules: {
                words: {
                    required: true,
                    remote: {
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        url: "{{route('curseword.exist')}}",
                        method: "POST",
                        data: {
                            words: function() {
                                return $("input[name='words']").val();
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
                words: {
                    required: "Please enter Curse Word",
                    remote: "Curse Word already exist",
                    customValidation: "Please enter vaild Curse Word"
                },

            },


        });



        $(document).on('click', '#edit', function() {
            if ($("#curseword").valid()) {
                $("#curseword").submit();
            }
        })


        $(document).on("click", "#delete", function(event) {
            var userURL = $(this).data("url");

            event.preventDefault();
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
                                toastr.error("Curse Word don't Deleted !");
                            }
                        },
                    });
                }
            });
        });
        if (sessionStorage.getItem('showSuccessNotification')) {
            // Show the success notification using Toastr

            toastr.success("Curse Word deleted successfully!");
            // Remove the flag from sessionStorage
            sessionStorage.removeItem('showSuccessNotification');
        }

    });
</script>