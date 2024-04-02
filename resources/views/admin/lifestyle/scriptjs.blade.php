<script>
    $(document).ready(function() {
        // Validate the form with ID 'interest_and_hobbies'



        $(document).on('click', '#addMore', function() {
            var addMoreData = $("#addMoreData").html();
            $("#life_style").append(addMoreData);
        });
        $(document).on('click', '.remove', function() {
            $(this).parent().parent().remove();
        });
        $("#life_style .lifestyle").each(function() {
            $(this).focus(function() {
                $(this).next("span").text("");
            });
        });


        $('#add').click(function(e) {
            e.preventDefault();
            var promises = [];
            $('#life_style .lifestyle').each(function() {
                var that = $(this);
                var thatVal = that.val().trim();

                if (thatVal == '') {
                    that.next('.text-danger').text('Please enter lifestyle');
                } else {
                    var promise = new Promise(function(resolve, reject) {
                        $.ajax({
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                            },
                            dataType: 'Json',
                            type: "POST",
                            url: "{{route('lifestyle.exist')}}",
                            data: {
                                lifestyle: thatVal
                            },
                            success: function(output) {
                                if (output == false) {
                                    that.next('.text-danger').text('Lifestyle already exist');
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
                    console.log("Duplicate lifestyle found");
                } else if (results.includes(true)) {
                    // If all results are true, submit the form
                    console.log("No duplicate lifestyle, submitting form");
                    $("#lifestyle").submit();
                }
            }).catch(function(error) {
                console.error("Error occurred during AJAX request:", error);
            });
        });





        $("#lifestyle").validate({
            rules: {
                lifestyle: {
                    required: true,
                    remote: {
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        url: "{{route('lifestyle.exist')}}",
                        method: "POST",
                        data: {
                            lifestyle: function() {
                                return $("input[name='lifestyle']").val();
                            },
                            id: function() {
                                return $("input[name='id']").val();
                            },
                        },
                    },
                },

            },
            messages: {
                lifestyle: {
                    required: "Please enter lifestyle",
                    remote: "Iifestyle already exist",
                },

            },


        });



        $(document).on('click', '#edit', function() {
            if ($("#lifestyle").valid()) {
                $("#lifestyle").submit();
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
                                table.ajax.reload();
                                toastr.success("Lifestyle deleted successfully !");
                            } else {
                                toastr.error("Lifestyle don't Deleted !");
                            }
                        },
                    });
                }
            });
        });


    });
</script>