<script>
    $(document).ready(function() {
        // Validate the form with ID 'interest_and_hobbies'



        $(document).on('click', '#addMore', function() {
            var addMoreData = $("#addMoreData").html();
            $("#exercises").append(addMoreData);
        });
        $(document).on('click', '.remove', function() {
            $(this).parent().parent().remove();
        });
        $("#exercises .exercise").each(function() {
            $(this).focus(function() {
                $(this).next("span").text("");
            });
        });


        $('#add').click(function(e) {
            e.preventDefault();
            var promises = [];
            var isValid = true;
            $('#exercises .exercise').each(function() {
                var that = $(this);
                var thatVal = that.val().trim();

                if (thatVal == '') {
                    that.next('.text-danger').text('Please enter Exercise');
                } else if (/^[0-9@#$%^&*()_+=\[\]{};:,.\/<>?|\\/-]+$/.test(thatVal)) {
                    that.next('.text-danger').text('Please enter valid Exercise');
                    isValid = false;

                } else if (/^\d+$/.test(thatVal)) {
                    that.next('.text-danger').text('Please enter valid Exercise');
                    isValid = false;
                } else if (/^[^a-zA-Z0-9 ]+$/.test(thatVal)) {
                    that.next('.text-danger').text('Please enter valid Exercise');
                    isValid = false;
                } else {
                    var promise = new Promise(function(resolve, reject) {
                        $.ajax({
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                            },
                            dataType: 'Json',
                            type: "POST",
                            url: "{{route('exercise.exist')}}",
                            data: {
                                exercise: thatVal
                            },
                            success: function(output) {
                                if (output == false) {
                                    that.next('.text-danger').text('Exercise already exist');
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
                    console.log("Duplicate Exercise found");
                } else if (results.includes(true)) {
                    // If all results are true, submit the form
                    console.log("No duplicate Exercise, submitting form");
                    $("#exercise").submit();
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


        $("#exercise").validate({
            rules: {
                exercise: {
                    required: true,
                    remote: {
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        url: "{{route('exercise.exist')}}",
                        method: "POST",
                        data: {
                            exercise: function() {
                                return $("input[name='exercise']").val();
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
                exercise: {
                    required: "Please enter Exercise",
                    remote: "Exercise already exist",
                    customValidation: "Please enter valid Exercise"
                },

            },


        });



        $(document).on('click', '#edit', function() {
            if ($("#exercise").valid()) {
                $("#exercise").submit();
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
                url: "{{route('exercise.selectedbyuser')}}",
                data: {

                    id: id
                },
                dataType: "json",
                success: function(output) {
                    if (output == false) {
                        errorAlert('Exercise');

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
                                            errorAlert('Exercise');
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

            toastr.success("Exercise deleted successfully !");
            // Remove the flag from sessionStorage
            sessionStorage.removeItem('showSuccessNotification');
        }

    });
</script>