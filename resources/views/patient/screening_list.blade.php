<html>
<head>
    <title>Patient Screen List - Puresoft</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
</head>
<style>
    .daily_frequency
    {
        display: none;
    }
</style>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Screening Form</a>
        </div>
        <ul class="nav navbar-nav">
            <li ><a href="{{ url('/') }}">Home</a></li>
            <li class="active"><a href="{{ url('patient/list-screening') }}">Screening List</a></li>
        </ul>
    </div>
</nav>
<body>
<div class="container">
    <h2>Patient Screening List</h2>
    <table id="example" class="display" style="width:100%">
        <thead>
        <tr>
            <th>Name</th>
            <th>Date of Birth</th>
            <th>Age</th>
            <th>Migration Frequency</th>
            <th>Daily Frequency</th>
            <th>Cohort Type</th>
        </tr>
        </thead>
        <tbody>
        @foreach($patientData as $patient)
            <tr>
                <td>{{ $patient->patient_name }}</td>
                <td>{{ $patient->patient_dob }}</td>
                <td>{{ $patient->patient_age }}</td>
                <td>{{ $patient->mig_frequency }}</td>
                <td>{{ $patient->mig_frequency_daily }}</td>
                <td>{{ $patient->patient_cohort_type }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('#example').DataTable({
            pagingType: 'simple_numbers'
        });
    });
</script>
</body>
</html>
