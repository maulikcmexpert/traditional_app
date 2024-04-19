<script>
    $(document).ready(function() {
        $("#changePasswordForm").validate({
            rules: {

                current_password: {
                    required: true,
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
                    equalTo: "#new_password"
                }
            },
            messages: {
                current_password: {
                    required: "Please enter Current Password",
                    remote: "The Current Password is incorrect."
                },
                new_password: {
                    required: "Please enter New Password",
                    minlength: "New Password must be at least 8 characters long.",
                    notEqualTo: "New Password must be different from Current Password"
                },
                confirm_password: {
                    required: "Please enter Confirm Password",
                    equalTo: "Confirm Password does not match with New Password"
                }
            }
        });
    });
</script>