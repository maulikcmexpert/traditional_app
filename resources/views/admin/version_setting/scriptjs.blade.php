<script>
    $(document).ready(function() {


        $("#version_setting").validate({
            rules: {
                android_version: {
                    required: true,

                },


                ios_version: {

                    required: true,

                },


            },
            messages: {
                android_version: {
                    required: "Please enter android version",

                },


                ios_version: {

                    required: "Please enter Ios version",

                },


            },
        });



    });
</script>