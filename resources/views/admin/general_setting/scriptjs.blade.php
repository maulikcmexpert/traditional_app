<script>
    $.validator.addMethod("minMaxAgeComparison", function(value, element) {
        var minAge = parseInt($("#min_age").val());
        var maxAge = parseInt($("#max_age").val());
        return minAge < maxAge;
    }, function(params, element) {

        var minAge = parseInt($("#min_age").val());
        var maxAge = parseInt($("#max_age").val());
        if (minAge >= maxAge) {
            return "Min Age must be less than max age";
        } else {
            return "Max Age must be greater than min age";
        }
    });
    $(document).ready(function() {


        $("#generalsetting").validate({
            rules: {
                min_age: {
                    required: true,
                    minMaxAgeComparison: true,
                    numeric: true
                },
                max_age: {
                    required: true,
                    minMaxAgeComparison: true,
                    numeric: true
                },

                ghost_count: {

                    required: true,
                    numeric: true
                },

                ghost_day: {
                    required: true,
                    numeric: true
                },
                no_chat_day_duration: {
                    required: true,
                    numeric: true
                },
            },
            messages: {
                min_age: {
                    required: "Please enter Min Age",
                    numeric: "Please enter in digit"
                },
                max_age: {
                    required: "Please enter Max Age",
                    numeric: "Please enter in digit"
                },

                ghost_count: {
                    required: "Please enter Ghost Count",
                    numeric: "Please enter in digit"
                },

                ghost_day: {
                    required: "Please enter Ghost Day",
                    numeric: "Please enter in digit"
                },
                no_chat_day_duration: {
                    required: "Please enter No Chat Day Duration",
                    numeric: "Please enter in digit"

                }
            },
        });



    });
</script>