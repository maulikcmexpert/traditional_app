<script>
    $.validator.addMethod("minMaxAgeComparison", function(value, element) {
        var minAge = parseInt($("#min_age").val());
        var maxAge = parseInt($("#max_age").val());
        return minAge < maxAge;
    }, "Minimum age must be less than maximum age");
    $(document).ready(function() {


        $("#generalsetting").validate({
            rules: {
                min_age: {
                    required: true,
                    minMaxAgeComparison: true
                },
                max_age: {
                    required: true,
                    minMaxAgeComparison: true
                },

                ghost_count: {

                    required: true,
                },

                ghost_day: {

                    required: true,
                },
            },
            messages: {
                min_age: {
                    required: "Please enter minimum age",

                },
                max_age: {
                    required: "Please enter maximum age",

                },

                ghost_count: {

                    required: "Please enter ghost count",
                },

                ghost_day: {

                    required: "Please enter ghost day",
                },
            },
        });



    });
</script>