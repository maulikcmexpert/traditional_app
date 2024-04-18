<script>
    $(document).ready(function() {
        $.validator.addMethod("ckeditor_required", function(value, element) {
            var ckeditorContent = CKEDITOR.instances[element.id].getData().trim();
            return ckeditorContent !== "";
        }, "Please enter content in this field");

        $("#legal_agreement").validate({
            rules: {
                privacy_policy: {
                    ckeditor_required: true,

                },
                term_and_condition: {
                    ckeditor_required: true,

                },

            },
            messages: {
                privacy_policy: {
                    ckeditor_required: "Please enter Privacy Policy",

                },
                term_and_condition: {
                    ckeditor_required: "Please select Term And Condition",

                }
            },
        });



    });
</script>