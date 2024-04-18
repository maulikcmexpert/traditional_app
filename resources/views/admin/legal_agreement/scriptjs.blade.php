<script>
    $(document).ready(function() {

        $('.ckeditor').ckeditor();
        CKEDITOR.replace('privacy_policy');
        // Form Validation
        $("#legal_agreement").validate({
            ignore: [],
            rules: {

                privacy_policy: {
                    required: true


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