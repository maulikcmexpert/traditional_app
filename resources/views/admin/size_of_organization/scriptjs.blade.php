<script>
    $(document).ready(function() {
        // Validate the form with ID 'interest_and_hobbies'



        $(document).on('click', '#addMore', function() {


            var addMoreData = $("#addMoreData").html();
            $("#size_of_organization").append(addMoreData);
        });
        $(document).on('click', '.remove', function() {
            $(this).parent().parent().remove();
        });
        $("#sizeoforganization .size_range").each(function() {
            $(this).focus(function() {
                $(this).next("span").text("");
            });
        });


        $('#add').click(function(e) {
            e.preventDefault();
            var promises = [];
            $('#sizeoforganization .size_range').each(function() {
                var that = $(this);
                var thatVal = that.val().trim();
                var pattern = /^(\d+\.?\d*) ?- ?(\d+\.?\d*)$/;

                if (thatVal == '') {
                    that.next('.text-danger').text('Please enter Size Of Organization');
                } else if (!pattern.test(thatVal)) {

                    that.next('.text-danger').text('The value must be in the format 0-50, and is a digit.');
                } else {
                    var promise = new Promise(function(resolve, reject) {
                        $.ajax({
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                            },
                            dataType: 'Json',
                            type: "POST",
                            url: "{{route('sizeoforganization.exist')}}",
                            data: {
                                size_range: thatVal
                            },
                            success: function(output) {
                                if (output == false) {
                                    that.next('.text-danger').text('Religion already exist');
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
                    console.log("Duplicate Size Of Organization found");
                } else if (results.includes(true)) {
                    // If all results are true, submit the form
                    console.log("No duplicate Size Of Organization, submitting form");
                    $("#sizeoforganization").submit();
                }
            }).catch(function(error) {
                console.error("Error occurred during AJAX request:", error);
            });
        });





        $("#sizeoforganization").validate({
            rules: {
                size_range: {
                    required: true,
                    pattern: /^(\d+\.?\d*) ?- ?(\d+\.?\d*)$/,
                    remote: {
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        url: "{{route('sizeoforganization.exist')}}",
                        method: "POST",
                        data: {
                            size_range: function() {
                                return $("input[name='size_range']").val();
                            },
                            id: function() {
                                return $("input[name='id']").val();
                            },
                        },
                    },
                },

            },
            messages: {
                size_range: {
                    required: "Please enter Size Of Organization",
                    pattern: "The value must be in the format 0-50, and is a digit",
                    remote: "Size Of Organization already exist",
                },

            },


        });



        $(document).on('click', '#edit', function() {
            if ($("#sizeoforganization").valid()) {
                $("#sizeoforganization").submit();
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
                url: "{{route('sizeoforganization.selectedbyuser')}}",
                data: {

                    id: id
                },
                dataType: "json",
                success: function(output) {
                    if (output == false) {
                        errorAlert("Size Of Organization");

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
                                            errorAlert("Size Of Organization");
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

            toastr.success("Size Of Organization deleted successfully !");
            // Remove the flag from sessionStorage
            sessionStorage.removeItem('showSuccessNotification');
        }

    });
</script>