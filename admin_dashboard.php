<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <!-- Include Bootstrap 5 CSS and JavaScript from CDNs -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Admin Dashboard</h1>

        <div class="mb-3">
            <label for="subjectSelect" class="form-label">Select a Subject:</label>
            <select class="form-select" id="subjectSelect">
            <option value="computer_ethics">Select a course</option>
                <option value="computer_ethics">Computer Ethics</option>
                <option value="computer_security">Computer Security</option>
                <option value="programming">Programming</option>
                <!-- Add more subjects as needed -->
            </select>
        </div>

        <div id="subjectTables">
            <!-- The subject tables will be loaded dynamically here -->
        </div>
    </div>

    <script>
    // JavaScript to load subject-specific grades dynamically
    document.getElementById("subjectSelect").addEventListener("change", function () {
        // Get the selected subject
        var selectedSubject = this.value;

        // Make an AJAX request to retrieve subject-specific grades in JSON format
        $.ajax({
            url: "get_subject_grades.php",
            type: "POST",
            data: { subject: selectedSubject },
            dataType: "json", // Specify the data type as JSON
            success: function (data) {
                // Clear any existing data
                document.getElementById("subjectTables").innerHTML = "";

                if (data.length > 0) {
                    var table = '<table class="table table-bordered">' +
                        '<thead class="thead-dark"><tr>' +
                        '<th>Student Name</th><th>Index Number</th><th>Grade</th>' +
                        '</tr></thead><tbody>';

                    data.forEach(function (item) {
                        table += '<tr>';
                        table += '<td>' + item.FirstName + '</td>';
                        table += '<td>' + item.IndexNumber + '</td>';
                        table += '<td>' + item.Grade + '</td>';
                        table += '</tr>';
                    });

                    table += '</tbody></table>';

                    document.getElementById("subjectTables").innerHTML = table;
                } else {
                    document.getElementById("subjectTables").innerHTML = "No records found for " + selectedSubject;
                }
            },
            error: function (error) {
                console.error(error);
            }
        });
    });
</script>


</body>
</html>
