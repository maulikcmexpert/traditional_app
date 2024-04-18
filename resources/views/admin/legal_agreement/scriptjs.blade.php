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
                },
                term_and_condition: {
                    required: function() {
                        CKEDITOR.instances.term_and_condition.updateElement();
                    },
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