<script>
    $(document).ready(function() {
        $("#changePasswordForm").validate({
            rules: {
                current_password: {
                    required: true,
                    remote: {
                        url: "/check-current-password",
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
                    required: "Please enter your current password.",
                    remote: "The current password is incorrect."
                },
                new_password: {
                    required: "Please enter a new password.",
                    minlength: "Password must be at least 8 characters long.",
                    notEqualTo: "New password must be different from the current password."
                },
                confirm_password: {
                    required: "Please confirm your new password.",
                    equalTo: "Passwords do not match."
                }
            }
        });
    });
</script>