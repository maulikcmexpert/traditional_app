<script>
    $(document).ready(function() {
        // Validate the form with ID 'interest_and_hobbies'



        $("#verificationobject").validate({
            rules: {
                object_type: {
                    required: true,
                    remote: {
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        url: "{{route('verificationobject.exist')}}",
                        method: "POST",
                        data: {
                            object_type: function() {
                                return $("input[name='object_type']").val();
                            },
                            id: function() {
                                return $("input[name='id']").val();
                            },
                        },
                    },
                },
                object_image: {
                    required: true,
                    extension: "jpg|jpeg|png|gif", // allowed image extensions
                    filesize: 1048576, // max file size in bytes (1MB)
                },

            },
            messages: {
                object_type: {
                    required: "Please enter Object Type",
                    remote: "Object Type already exist",
                },
                object_image: {
                    required: "Please upload Object Image",
                    extension: "Please upload a valid image file (jpg, jpeg, png, or gif)",
                    filesize: "Maximum file size allowed is 1MB",
                },
            },
        });
        $.validator.addMethod("filesize", function(value, element, param) {
            // Convert file size to bytes
            var size = element.files[0].size;
            return size <= param;
        });


        $(document).on('click', '#edit', function() {
            if ($("#interest_and_hobby").valid()) {
                $("#interest_and_hobby").submit();
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
                                toastr.error("Interest and hobby don't Deleted !");
                            }
                        },
                    });
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



    // file upload //

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#blah')
                    .attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>