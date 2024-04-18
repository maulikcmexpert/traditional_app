<script>
    $(document).ready(function() {

        $("#legal_agreement").validate({

            rules: {
                privacy_policy: {
                    required: true
                }
            },
            messages: {

                privacy_policy: {
                    required: "Please enter Privacy Policy"

                }
            }
        });
    });
</script>