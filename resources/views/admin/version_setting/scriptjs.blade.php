<script>
    $(document).ready(function() {


        $("#version_setting").validate({
            rules: {
                android_version: {
                    required: true,
                    numeric: true
                },
                android_in_force: {
                    required: true,

                },

                ios_version: {

                    required: true,
                    numeric: true
                },

                ios_in_force: {

                    required: true,
                },
            },
            messages: {
                android_version: {
                    required: "Please enter android version",
                    numeric: "Please enter in digit"
                },
                android_in_force: {
                    required: "Please select android in force",

                },

                ios_version: {

                    required: "Please enter Ios version",
                    numeric: "Please enter in digit"
                },

                ios_in_force: {

                    required: "Please select Ios in force",
                },
            },
        });



    });
</script>