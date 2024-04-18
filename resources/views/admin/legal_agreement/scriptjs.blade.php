<script>
    $(document).ready(function() {

        $('.ckeditor').ckeditor();
        CKEDITOR.replace('privacy_policy');
        // Form Validation
        $("#legal_agreement").validate({
            ignore: [],
            rules: {

                privacy_policy: {
                    required: function() {
                        CKEDITOR.instances.privacy_policy.updateElement(); // Update the textarea value before validation
                        return CKEDITOR.instances.editor1.getData().trim() === '';
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