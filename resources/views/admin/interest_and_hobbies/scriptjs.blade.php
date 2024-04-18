<script>
    $(document).ready(function() {
        // Validate the form with ID 'interest_and_hobbies'



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
                if (thatVal === '') {
                    that.next('.text-danger').text('Please enter interest and hobby');
                    isValid = false;
                } else if (/^[0-9@#$%^&*()_+=\[\]{};:,.\/<>?|\\/-]+$/.test(thatVal)) {
                    that.next('.text-danger').text('Please enter valid interest and hobby');
                    isValid = false;

                } else if (/^\D*$/.test(thatVal)) {
                    that.next('.text-danger').text('Please enter valifffd interest and hobby');
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
                                    that.next('.text-danger').text('Interest and hobby already exist');
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
                },

            },
            messages: {
                interest_and_hobby: {
                    required: "Please enter interest and hobby",
                    remote: "Interest and hobby already exist",
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
                        errorAlert("Inerest And Hobby");

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
                                            errorAlert("Inerest And Hobby");

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

            toastr.success("Interest and hobby deleted successfully !");
            // Remove the flag from sessionStorage
            sessionStorage.removeItem('showSuccessNotification');
        }

    });
</script>