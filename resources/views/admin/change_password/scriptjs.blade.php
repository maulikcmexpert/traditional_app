<script>
    $(document).ready(function() {

        $("#add").on('click', function() {
            $("span .text-danger").html("");
        });
        $("#changePasswordForm").validate({
            rules: {

                current_password: {
                    required: true,
                    minlength: 8,
                    remote: {
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        url: "{{route('checkCurrentPass.exist')}}",
                        type: "post",
                        data: {
                            current_password: function() {
                                return $("#current_password").val();
                            }
                        }
                    }
                },
                new_password: {
                    required: true,
                    minlength: 8,
                    notEqualTo: "#current_password"
                },
                confirm_password: {
                    required: true,
                    minlength: 8,
                    equalTo: "#new_password"
                }
            },
            messages: {
                current_password: {
                    required: "Please enter Current Password",
                    minlength: "Current Password must be at least 8 characters",
                    remote: "The Current Password is incorrect."
                },
                new_password: {
                    required: "Please enter New Password",
                    minlength: "New Password must be at least 8 characters",
                    notEqualTo: "New Password must be different from Current Password"
                },
                confirm_password: {
                    required: "Please enter Confirm Password",
                    minlength: "Confirm Password must be at least 8 characters",
                    equalTo: "Confirm Password does not match with New Password"
                }
            }
        });
    });
</script>