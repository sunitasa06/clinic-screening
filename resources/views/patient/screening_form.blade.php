<html>
<head>
    <title>Patient Screen Form - Puresoft</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <meta name="_token" content="{{csrf_token()}}"/>
</head>
<style>
    .daily_frequency
    {
        display: none;
    }
    .success_message{
        display: none;
    }
</style>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Screening Form</a>
        </div>
        <ul class="nav navbar-nav">
            <li class="active"><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{ url('patient/list-screening') }}">Screening List</a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <h2>Patient Screening form</h2>
    <form class="btn-submit" id="ajax">
        <div class="form-group">
            <label for="email">First Name :</label>
            <input type="text" class="form-control" id="f_name" placeholder="Enter Patient First Name" name="f_name" required>
        </div>
        <div class="form-group">
            <label for="pwd">Date Of Birth:</label>
            <input type="date" class="form-control" id="dob" name="dob" required>
        </div>
        <div class="form-group">
            <label>Frequency</label>
            <br>
            <label class="radio-inline">
                <input type="radio" name="frequency" value="Monthly">Monthly
            </label>
            <label class="radio-inline">
                <input type="radio" name="frequency" value="Weekly">Weekly
            </label>
            <label class="radio-inline">
                <input type="radio" name="frequency" value="Daily">Daily
            </label>
        </div>
        <div class="form-group daily_frequency">
            <label>Daily Frequency</label>
            <br>
            <label class="radio-inline">
                <input type="radio" name="daily_freq" value="1-2">1-2
            </label>
            <label class="radio-inline">
                <input type="radio" name="daily_freq" value="3-4">3-4
            </label>
            <label class="radio-inline">
                <input type="radio" name="daily_freq" value="5+">5+
            </label>
        </div>
        <button type="button" class="btn btn-default" onclick="checkEligibility()">Submit</button>
        <button type="reset" class="btn btn-default">Reset Form</button>

    </form>
    <div class="alert alert-success alert-dismissible fade in success_message" >
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <span id="success_message"></span>
    </div>
</div>
<script>
    function checkEligibility() {

        var f_name = $('#f_name').val();
        var dob = $('#dob').val();
        var frequency = $('input[name=frequency]:checked').val();

        if(f_name == '')
        {
            alert('Enter patient first name');
            return false;
        }

        if(dob == '')
        {
            alert('Enter patient date of birth');
            return false;
        }
        if(frequency == '')
        {
            alert('Enter patient migration frequency');
            return false;
        }

        // var age = calculateAge();


        // if (age < 18) {
        //     alert('Participants must be over 18 years of age');
        // } else {
        //     var cohort = determineCohort(age, frequency);
        //     alert('Participant ' + f_name + ' is assigned to ' + cohort);
        // }

        $.ajax({
            type: "post",
            url: "{{route('patient-store')}}",
            dataType: "json",
            data: $('#ajax').serialize(),
            success: function(data){
                $(".success_message").show();
                $("#success_message").html("<strong>Success!</strong> "+data.message);
            },
            error: function(data){
                alert(data);
            }
        });
    }

    function calculateAge() {
        var dob = new Date($('#dob').val());
        var today = new Date();
        var age = today.getFullYear() - dob.getFullYear();
        var monthDiff = today.getMonth() - dob.getMonth();

        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
            age--;
        }

        return age;
    }

    function determineCohort(age, frequency) {
        if (frequency === 'Monthly' || frequency === 'Weekly') {
            return 'Cohort A';
        } else if (frequency === 'Daily') {
            $('.daily_frequency').show();
            var dailyFreq = $('input[name=daily_freq]:checked').val();
            return 'Cohort B (' + dailyFreq + ')';
        }
    }

    $('input[name=frequency]').change(function () {
        $('input[name=daily_freq]').prop('checked', false);
        if ($(this).val() !== 'Daily') {
            $('.daily_frequency').hide();
        } else {
            $('.daily_frequency').show();
        }
    });

    $('button[type=reset]').click(function () {
        $('.daily_frequency').hide(); // Hide daily frequency on reset
        $('.success_message').hide();
    });
</script>
</body>
</html>
