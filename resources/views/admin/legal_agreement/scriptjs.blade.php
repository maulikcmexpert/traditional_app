<script>
    $(document).ready(function() {

        $('.ckeditor').ckeditor();

        // Form Validation
        $("#legal_agreement").validate({
            ignore: [],
            debug: false,
            rules: {

                privacy_policy: {
                    required: function() {
                        CKEDITOR.instances.privacy_policy.updateElement();
                    },


                }
            },
            messages: {

                privacy_policy: {
                    required: "Please enter Text",



                }
            }
        });
    });
</script>