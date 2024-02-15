<script>
    $(document).ready(function() {
        // Validate the form with ID 'interest_and_hobbies'

        $(document).on('click', '#add', function(e) {
            e.preventDefault();
        });

        $(document).on('click', '#addMore', function() {
            var addMoreData = $("#addMoreData").html();
            $("#interest").append(addMoreData);
        });
        $(document).on('click', '.remove', function() {
            $(this).parent().parent().remove();
        });

        $("#interest .interest_and_hobby").focus(function() {
            $(this).next("span").text("").removeClass("text-danger");
        });

        $("#interest .icon").focus(function() {
            $(this).next("span").text("").removeClass("text-danger");;
        });


        function errorHandle() {
            var error = 0;
            $("#interest .interest_and_hobby").each(function() {
                var interest_and_hobby = $(this).val();
                if (interest_and_hobby.length == "") {
                    $(this)
                        .next("span")
                        .text("Please enter interest and hobbies")
                        .addClass("text-danger");
                    error++;
                }
            });

            $("#interest .icon").each(function() {
                var icon = $(this).val();
                if (icon.length == "") {
                    $(this)
                        .next("span")
                        .text("Please upload icon")
                        .addClass("text-danger");
                    error++;
                } else {
                    var allowedFormats = ['jpg', 'jpeg', 'png', 'gif']; // Add allowed file formats here
                    var fileName = files[0].name;
                    var fileExtension = fileName.split('.').pop().toLowerCase();

                    if (allowedFormats.indexOf(fileExtension) === -1) {
                        $(this)
                            .next("span")
                            .text("Please upload file in jpg,jpeg,png,gif" + allowedFormats.join(', '))
                            .addClass("text-danger");
                        error++;
                    }
                }
            });
            return error;
        }


        $('#add').click(function(e) {
            e.preventDefault();

            var error = errorHandle();

            if (error == 0) {
                $("#interest_and_hobbies").submit();
            }
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