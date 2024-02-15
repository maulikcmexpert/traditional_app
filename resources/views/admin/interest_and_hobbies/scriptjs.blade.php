<script>
    $(document).ready(function() {
        // Validate the form with ID 'interest_and_hobbies'



        $(document).on('click', '#addMore', function() {
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
            $('#interest .interest_and_hobby').each(function() {
                var that = $(this);
                var thatVal = that.val().trim();

                if (thatVal == '') {
                    that.next('.text-danger').text('Please enter interest and hobby');
                } else {
                    var promise = new Promise(function(resolve, reject) {
                        $.ajax({
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                            },
                            dataType: 'Json',
                            type: "POST",
                            url: "{{route('interest_and_hobby.exist')}}",
                            data: {
                                interest_and_hobby: thatVal
                            },
                            success: function(output) {
                                if (output == false) {
                                    that.next('.text-danger').text('interest and hobby already exist');
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
                    console.log("Duplicate interest and hobby found");
                } else if (results.includes(true)) {
                    // If all results are true, submit the form
                    console.log("No duplicate interest and hobby, submitting form");
                    $("#interest_and_hobbies").submit();
                }
            }).catch(function(error) {
                console.error("Error occurred during AJAX request:", error);
            });
        });




        // $(document).on('click', '#add', function(e) {
        //     e.preventDefault();

        //     var error = 0;
        //     $(".interest_and_hobby").each(function() {
        //         $(this).next().html("");
        //         if ($(this).val() == "") {
        //             $(this).next().html("<span class='text-danger'>Please enter interest and hobby </span>")
        //             error++;
        //         }
        //     });

        //     $(".icon").each(function() {
        //         $(this).next().html("");
        //         if ($(this).val() == "") {
        //             $(this).next().html("<span class='text-danger'>Please upload icon </span>")
        //             error++;
        //         }
        //     });


        //     if (error == 0) {
        //         $("#interest_and_hobbies").submit();
        //     }
        // });

    });
</script>