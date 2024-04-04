<script>
    $(document).ready(function() {
        // Validate the form with ID 'interest_and_hobbies'



        $(document).on('click', '#addMore', function() {


            var addMoreData = $("#addMoreData").html();
            $("#curse_word").append(addMoreData);
        });
        $(document).on('click', '.remove', function() {
            $(this).parent().remove();
        });
        $("#curse_word .words").each(function() {
            $(this).focus(function() {
                $(this).next("span").text("");
            });
        });


        $('#add').click(function(e) {
            e.preventDefault();
            var promises = [];
            $('#curse_word .words').each(function() {
                var that = $(this);
                var thatVal = that.val().trim();

                if (thatVal == '') {
                    that.next('.text-danger').text('Please enter Curse Word');
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
                },

            },
            messages: {
                words: {
                    required: "Please enter Curse Word",
                    remote: "Curse Word already exist",
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

            toastr.success("Curse Word deleted successfully !");
            // Remove the flag from sessionStorage
            sessionStorage.removeItem('showSuccessNotification');
        }

    });
</script>