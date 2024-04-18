<script>
    $(document).ready(function() {

        $('.ckeditor').ckeditor();

        CKEDITOR.replace('privacy_policy');
        CKEDITOR.replace('term_and_condition');

        // Form Validation
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
                    required: "Please enter Term And Condition",
                }
            },
            errorPlacement: function(error, element) {
                error.appendTo(element.closest(".position-relative").find(".text-danger"));
            }
        });




    });
</script>