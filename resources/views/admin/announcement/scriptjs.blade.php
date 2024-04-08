<script>
    $(document).ready(function() {


        $("#announcement").validate({
            rules: {
                message: {
                    required: true,

                },

            },
            messages: {
                message: {
                    required: "Please enter message",

                },

            },
        });



    });
</script>