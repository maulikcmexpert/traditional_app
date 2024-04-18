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
                    number: true
                },
                max_age: {
                    required: true,
                    minMaxAgeComparison: true,
                    number: true
                },

                ghost_count: {

                    required: true,
                    number: true
                },

                ghost_day: {
                    required: true,
                    number: true
                },
                no_chat_day_duration: {
                    required: true,
                    number: true
                },
            },
            messages: {
                min_age: {
                    required: "Please enter Min Age",
                    number: "Please enter in digit"
                },
                max_age: {
                    required: "Please enter Max Age",
                    number: "Please enter in digit"
                },

                ghost_count: {
                    required: "Please enter Ghost Count",
                    number: "Please enter in digit"
                },

                ghost_day: {
                    required: "Please enter Ghost Day",
                    number: "Please enter in digit"
                },
                no_chat_day_duration: {
                    required: "Please enter No Chat Day Duration",
                    number: "Please enter in digit"

                }
            },
        });



    });
</script>