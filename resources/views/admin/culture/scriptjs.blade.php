<script>
    $(document).ready(function() {
        // Validate the form with ID 'interest_and_hobbies'



        $(document).on('click', '#addMore', function() {
            var addMoreData = $("#addMoreData").html();
            $("#cultures").append(addMoreData);
        });
        $(document).on('click', '.remove', function() {
            $(this).parent().parent().remove();
        });
        $("#cultures .culture").each(function() {
            $(this).focus(function() {
                $(this).next("span").text("");
            });
        });


        $('#add').click(function(e) {
            e.preventDefault();
            var promises = [];
            $('#cultures .culture').each(function() {
                var that = $(this);
                var thatVal = that.val().trim();

                if (thatVal == '') {
                    that.next('.text-danger').text('Please enter Culture');
                } else {
                    var promise = new Promise(function(resolve, reject) {
                        $.ajax({
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                            },
                            dataType: 'Json',
                            type: "POST",
                            url: "{{route('culture.exist')}}",
                            data: {
                                culture: thatVal
                            },
                            success: function(output) {
                                if (output == false) {
                                    that.next('.text-danger').text('Culture already exist');
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

            Promise.all(promises).then(function(results) {
                if (results.includes(false)) {
                    // If any result is false, do not submit the form
                    console.log("Duplicate Culture found");
                } else if (results.includes(true)) {
                    // If all results are true, submit the form
                    console.log("No duplicate Culture, submitting form");
                    $("#culture").submit();
                }
            }).catch(function(error) {
                console.error("Error occurred during AJAX request:", error);
            });
        });





        $("#culture").validate({
            rules: {
                culture: {
                    required: true,
                    remote: {
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        url: "{{route('culture.exist')}}",
                        method: "POST",
                        data: {
                            culture: function() {
                                return $("input[name='culture']").val();
                            },
                            id: function() {
                                return $("input[name='id']").val();
                            },
                        },
                    },
                },

            },
            messages: {
                culture: {
                    required: "Please enter Culture",
                    remote: "Culture already exist",
                },

            },


        });



        $(document).on('click', '#edit', function() {
            if ($("#culture").valid()) {
                $("#culture").submit();
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
                url: "{{route('culture.selectedbyuser')}}",
                data: {

                    id: id
                },
                dataType: "json",
                success: function(output) {
                    if (output == false) {
                        errorAlert('Culture');

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
                                            errorAlert('Culture');
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

            toastr.success("Culture deleted successfully !");
            // Remove the flag from sessionStorage
            sessionStorage.removeItem('showSuccessNotification');
        }

    });
</script>