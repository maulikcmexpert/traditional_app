<script>
    $(document).ready(function() {

        // $("#legal_agreement").validate({

        //     rules: {
        //         privacy_policy: {
        //             required: true
        //         }
        //     },
        //     messages: {

        //         privacy_policy: {
        //             required: "Please enter Privacy Policy"

        //         }
        //     }
        // });


        $("#legal_agreement").validate({
            ignore: [],
            debug: true,
            rules: {

                privacy_policy: {
                    required: function() {
                        CKEDITOR.instances.privacy_policy.updateElement();
                    },


                }
            },
            messages: {

                privacy_policy: {
                    required: "Please enter Privacy Policy",
                }
            }
        });
    });
</script>