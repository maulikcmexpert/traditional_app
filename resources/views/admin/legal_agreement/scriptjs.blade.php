<script>
    $(document).ready(function() {


        $("#legal_agreement").validate({
            rules: {
                privacy_policy: {
                    required: true,

                },
                term_and_condition: {
                    required: true,

                },

            },
            messages: {
                privacy_policy: {
                    required: "Please enter Privacy Policy",

                },
                term_and_condition: {
                    required: "Please select Term And Condition",

                }
            },
        });



    });
</script>