<script>
    $(document).ready(function() {
        // Validate the form with ID 'interest_and_hobbies'



        $(document).on('click', '#addMore', function() {
            var addMoreData = $("#addMoreData").html();
            $("#body_types").append(addMoreData);
        });
        $(document).on('click', '.remove', function() {
            $(this).parent().parent().remove();
        });
        $("#body_types .body_type").each(function() {
            $(this).focus(function() {
                $(this).next("span").text("");
            });
        });


        $('#add').click(function(e) {
            e.preventDefault();
            var promises = [];
            var isValid = true;
            $('#body_types .body_type').each(function() {
                var that = $(this);
                var thatVal = that.val().trim();

                if (thatVal == '') {
                    that.next('.text-danger').text('Please enter Body Type');
                } else if (/^[0-9@#$%^&*()_+=\[\]{};:,.\/<>?|\\/-]+$/.test(thatVal)) {
                    that.next('.text-danger').text('Please enter valid Culture');
                    isValid = false;

                } else if (/^\d+$/.test(thatVal)) {
                    that.next('.text-danger').text('Please enter valid Culture');
                    isValid = false;
                } else if (/^[^a-zA-Z0-9 ]+$/.test(thatVal)) {
                    that.next('.text-danger').text('Please enter valid Culture');
                    isValid = false;
                } else {
                    var promise = new Promise(function(resolve, reject) {
                        $.ajax({
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                            },
                            dataType: 'Json',
                            type: "POST",
                            url: "{{route('body_type.exist')}}",
                            data: {
                                body_type: thatVal
                            },
                            success: function(output) {
                                if (output == false) {
                                    that.next('.text-danger').text('Body Type already exist');
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
                    console.log("Duplicate Body Type found");
                } else if (results.includes(true)) {
                    // If all results are true, submit the form
                    console.log("No duplicate Body Type, submitting form");
                    $("#body_type").submit();
                }
            }).catch(function(error) {
                console.error("Error occurred during AJAX request:", error);
            });
        });



        $.validator.addMethod("customValidation", function(value, element) {
            var isValid = true;
            var thatVal = value.trim();
            if (/^[0-9@#$%^&*()_+=\[\]{};:,.\/<>?|\\/-]+$/.test(thatVal) || /^\d+$/.test(thatVal) || /^[^a-zA-Z0-9 ]+$/.test(thatVal)) {
                isValid = false;
            }
            return isValid;
        });

        $("#body_type").validate({
            rules: {
                body_type: {
                    required: true,
                    remote: {
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        url: "{{route('body_type.exist')}}",
                        method: "POST",
                        data: {
                            body_type: function() {
                                return $("input[name='body_type']").val();
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
                body_type: {
                    required: "Please enter Body Type",
                    remote: "Body Type already exist",
                    customValidation: "Please enter valid Body Type"
                },

            },


        });



        $(document).on('click', '#edit', function() {
            if ($("#body_type").valid()) {
                $("#body_type").submit();
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
                url: "{{route('body_type.selectedbyuser')}}",
                data: {

                    id: id
                },
                dataType: "json",
                success: function(output) {
                    if (output == false) {
                        errorAlert('Body Type');

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
                                            errorAlert('Body Type');
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

            toastr.success("Body Type deleted successfully !");
            // Remove the flag from sessionStorage
            sessionStorage.removeItem('showSuccessNotification');
        }

    });
</script>