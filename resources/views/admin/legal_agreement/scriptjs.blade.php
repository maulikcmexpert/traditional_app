<script>
    $(document).ready(function() {


        $("#version_setting").validate({
            rules: {
                android_version: {
                    required: true,

                },
                android_in_force: {
                    required: true,

                },

                ios_version: {

                    required: true,

                },

                ios_in_force: {

                    required: true,
                },
            },
            messages: {
                android_version: {
                    required: "Please enter android version",

                },
                android_in_force: {
                    required: "Please select android in force",

                },

                ios_version: {

                    required: "Please enter Ios version",

                },

                ios_in_force: {

                    required: "Please select Ios in force",
                },
            },
        });



    });
</script>