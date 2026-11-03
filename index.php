<?php

// Include the database connection file
include "db.php";

// SQL query to get all employee records from the database
$sql = "SELECT * FROM emp";

// Execute the SQL query
$result = mysqli_query($conn, $sql);

// Create an empty array to store employee records
$employees = [];

// Fetch employee records one by one
while ($row = mysqli_fetch_assoc($result)) {

    // Add each employee record to the array
    $employees[] = $row;

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Set character encoding -->
    <meta charset="UTF-8">

    <!-- Make the website responsive on different screen sizes -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Website title shown in the browser tab -->
    <title>Sourcecube Technologies | Employee Utility</title>

    <!-- Connect the external CSS file -->
    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="main">

    <!-- HEADER: Displays company name and administrator information -->

    <header class="topbar">

        <!-- Company logo and name -->
        <div class="brand">
            <h2>SOURCECUBE<span>.</span></h2>
            <p>TECHNOLOGIES</p>
        </div>

        <!-- Administrator information -->
        <div class="admin">
            <div class="admin-dot"></div>
            Administrator
        </div>

    </header>


    <!-- OVERVIEW: Main dashboard section -->

    <section id="overview">

        <!-- Hero section with project introduction -->

        <div class="hero">

            <div class="hero-content">

                <!-- Dashboard heading -->
                <span class="hero-label">
                    EMPLOYEE MANAGEMENT SYSTEM
                </span>

                <h1>
                    Manage your people.<br>
                    Understand your workforce.
                </h1>

                <!-- Short project description -->
                <p>
                    Search, organize and analyze employee information
                    with one simple dashboard.
                </p>

                <!-- Button to open the employee section -->
                <a href="#employees" class="hero-button">
                    Explore Employees →
                </a>

            </div>

            <!-- Decorative design elements -->
            <div class="hero-decoration">
                <div class="circle circle-one"></div>
                <div class="circle circle-two"></div>
                <div class="hero-number">ST.</div>
            </div>

        </div>


        <!-- SUMMARY CARDS: Display employee statistics -->

        <div class="stats-grid">

            <!-- Display total number of employees -->
            <div class="stat-card">
                <div class="stat-icon orange">♙</div>
                <p>Total Employees</p>
                <h2 id="totalEmployees">0</h2>
                <span>Employee records</span>
            </div>

            <!-- Display total number of departments -->
            <div class="stat-card">
                <div class="stat-icon purple">▥</div>
                <p>Total Departments</p>
                <h2 id="totalDepartments">0</h2>
                <span>Active departments</span>
            </div>

            <!-- Display the number of currently visible records -->
            <div class="stat-card">
                <div class="stat-icon green">▤</div>
                <p>Showing Records</p>
                <h2 id="showingRecords">0</h2>
                <span>Filtered employees</span>
            </div>

        </div>

    </section>


    <!-- EMPLOYEE DIRECTORY: Displays employee records -->

    <section class="content-section" id="employees">

        <div class="section-heading">

            <div>
                <span class="section-label">EMPLOYEE DATABASE</span>
                <h2>Employee Directory</h2>
                <p>Search and organize employee records.</p>
            </div>

            <!-- Button to reset search, filter and sorting -->
            <button class="reset-button" onclick="resetData()">
                ↻ Reset All
            </button>

        </div>


        <!-- SEARCH, FILTER AND SORT OPTIONS -->

        <div class="filter-panel">

            <!-- Search employees by name -->
            <div>
                <label>SEARCH EMPLOYEE</label>

                <input
                    type="text"
                    id="search"
                    placeholder="Enter employee name..."
                >
            </div>


            <!-- Filter employees by department -->
            <div>
                <label>DEPARTMENT FILTER</label>

                <select id="department">

                    <option value="">All Departments</option>
                    <option value="IT">IT</option>
                    <option value="HR">HR</option>
                    <option value="Sales">Sales</option>

                </select>
            </div>


            <!-- Sort employees according to salary -->
            <div>
                <label>SORT BY SALARY</label>

                <select id="sort">

                    <option value="">Default Order</option>
                    <option value="low">Lowest Salary</option>
                    <option value="high">Highest Salary</option>

                </select>
            </div>

        </div>


        <!-- EMPLOYEE TABLE: Displays employee details -->

        <div class="table-container">

            <table>

                <!-- Table column headings -->
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>EMPLOYEE NAME</th>
                        <th>DEPARTMENT</th>
                        <th>SALARY</th>
                    </tr>
                </thead>

                <!-- JavaScript displays employee records here -->
                <tbody id="employeeData"></tbody>

            </table>

        </div>

        <!-- Displays the number of matching employee records -->
        <p id="resultText" class="result-text"></p>

    </section>


    <!-- SALARY DETAILS: Calculates salary information -->

    <section class="content-section" id="salary">

        <div class="section-heading">

            <div>
                <span class="section-label">SALARY INFORMATION</span>
                <h2>Employee Salary Details</h2>
                <p>Calculate average salary and find the highest paid employee.</p>
            </div>

        </div>


        <div class="analytics-grid">

            <!-- AVERAGE SALARY: Calculates the average employee salary -->

            <div class="analysis-card average-card">

                <div class="analysis-top">
                    <span>AVERAGE SALARY</span>
                    <div class="analysis-icon">₹</div>
                </div>

                <!-- Displays the calculated average salary -->
                <h2 id="average">Not calculated</h2>

                <p>Average salary of current employees.</p>

                <!-- Calls the calculateAverage function -->
                <button onclick="calculateAverage()">
                    Calculate Average →
                </button>

            </div>


            <!-- HIGHEST PAID EMPLOYEE: Finds the employee with the highest salary -->

            <div class="analysis-card highest-card">

                <div class="analysis-top">
                    <span>HIGHEST PAID EMPLOYEE</span>
                    <div class="analysis-icon">↗</div>
                </div>

                <!-- Displays the highest paid employee -->
                <h2 id="highest">Not calculated</h2>

                <p>Employee receiving the highest salary.</p>

                <!-- Calls the findHighest function -->
                <button onclick="findHighest()">
                    Find Highest Paid →
                </button>

            </div>

        </div>

    </section>


    <!-- DEPARTMENT GROUPING: Groups employees by department -->

    <section class="content-section" id="departments">

        <div class="section-heading">

            <div>
                <span class="section-label">DEPARTMENT INFORMATION</span>
                <h2>Department Overview</h2>
                <p>Group employees according to department.</p>
            </div>

            <!-- Calls the groupEmployees function -->
            <button class="group-button" onclick="groupEmployees()">
                Group Employees →
            </button>

        </div>

        <!-- JavaScript displays department-wise employee groups here -->
        <div id="group" class="group-grid"></div>

    </section>


    <!-- FOOTER: Displays company and project information -->

    <footer>
        © 2026 Sourcecube Technologies.
        Employee Data Utility.
    </footer>

</div>


<!-- PHP DATA TO JAVASCRIPT: Sends employee records to JavaScript -->

<script>

// Store employee records received from PHP in a JavaScript array
const employees = <?php

// Convert the PHP employee array into JSON format
echo json_encode(
    $employees,

    // Protect special characters while converting PHP data to JSON
    JSON_HEX_TAG |
    JSON_HEX_APOS |
    JSON_HEX_QUOT |
    JSON_HEX_AMP
);

?>;

</script>

<!-- Connect the external JavaScript file -->
<script src="script.js"></script>

</body>
</html>