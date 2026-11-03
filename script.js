// EMPLOYEE DATA

// Get employee data received from PHP and MySQL
let data = [...employees];

// Store the currently displayed employee records
let currentData = [...data];


// DISPLAY EMPLOYEES

function displayEmployees(list) {

    // Create an empty string to store table rows
    let output = "";

    // Check if no employee records are available
    if (list.length === 0) {

        // Display a message when no employee is found
        output = `
            <tr>
                <td colspan="4" style="text-align:center;">
                    No Employee Found
                </td>
            </tr>
        `;

    }

    // Display each employee record in the table
    list.forEach(emp => {

        // Convert department name to lowercase for CSS styling
        let departmentClass = emp.department.toLowerCase();

        // Create an HTML row for each employee
        output += `
            <tr>

                <td>${escapeHTML(emp.id)}</td>

                <td>${escapeHTML(emp.name)}</td>

                <td>
                    <span class="dept-badge dept-${escapeHTML(departmentClass)}">
                        ${escapeHTML(emp.department)}
                    </span>
                </td>

                <td>
                    ₹${Number(emp.salary).toLocaleString("en-IN")}
                </td>

            </tr>
        `;

    });

    // Display employee rows inside the HTML table
    document.getElementById("employeeData").innerHTML = output;

    // Update the number of currently displayed records
    document.getElementById("showingRecords").innerText = list.length;

    // Display the current record count and total employee count
    document.getElementById("resultText").innerText =
        "Showing " + list.length + " of " + data.length + " employees";

}


// BASIC HTML ESCAPING

// Convert special characters into safe HTML text
function escapeHTML(value) {

    // Replace special HTML characters with safe character codes
    return String(value).replace(/[&<>"']/g, function(char) {

        // Store the replacement values
        const characters = {
            "&": "&amp;",
            "<": "&lt;",
            ">": "&gt;",
            '"': "&quot;",
            "'": "&#039;"
        };

        // Return the safe replacement character
        return characters[char];

    });

}


// SEARCH + FILTER + SORT

function applyOperations() {

    // Get the employee name entered in the search box
    let searchValue = document
        .getElementById("search")
        .value
        .toLowerCase();

    // Get the selected department
    let department = document.getElementById("department").value;

    // Get the selected salary sorting option
    let sortValue = document.getElementById("sort").value;


    // SEARCH AND FILTER

    // Filter employees according to name and department
    let result = data.filter(emp => {

        // Check whether the employee name matches the search text
        let searchMatch = emp.name
            .toLowerCase()
            .includes(searchValue);

        // Check whether the employee belongs to the selected department
        let departmentMatch =
            department === "" || emp.department === department;

        // Return employees matching both conditions
        return searchMatch && departmentMatch;

    });


    // SORT EMPLOYEES BY SALARY

    // Sort salaries from lowest to highest
    if (sortValue === "low") {

        result.sort((a, b) =>
            Number(a.salary) - Number(b.salary)
        );

    }

    // Sort salaries from highest to lowest
    if (sortValue === "high") {

        result.sort((a, b) =>
            Number(b.salary) - Number(a.salary)
        );

    }

    // Store the filtered and sorted employee records
    currentData = result;

    // Display the updated employee records
    displayEmployees(currentData);

}


// SEARCH EVENT

// Run the search function whenever the user types something
document.getElementById("search")
    .addEventListener("input", applyOperations);


// FILTER EVENT

// Run the filter function whenever the department is changed
document.getElementById("department")
    .addEventListener("change", applyOperations);


// SORT EVENT

// Run the sorting function whenever the salary option is changed
document.getElementById("sort")
    .addEventListener("change", applyOperations);


// RESET ALL

function resetData() {

    // Clear the search box
    document.getElementById("search").value = "";

    // Reset the department dropdown
    document.getElementById("department").value = "";

    // Reset the salary sorting dropdown
    document.getElementById("sort").value = "";

    // Reset the average salary result
    document.getElementById("average").innerText = "Not calculated";

    // Reset the highest paid employee result
    document.getElementById("highest").innerText = "Not calculated";

    // Clear the department grouping results
    document.getElementById("group").innerHTML = "";

    // Display all employee records again
    applyOperations();

}


// AVERAGE SALARY

function calculateAverage() {

    // Check whether any employee records are available
    if (currentData.length === 0) {

        // Display a message if no employees are found
        document.getElementById("average").innerText =
            "No employees found";

        return;

    }

    // Calculate the total salary of all current employees
    let total = currentData.reduce((sum, emp) => {

        return sum + Number(emp.salary);

    }, 0);


    // Calculate average salary
    let average = total / currentData.length;

    // Display the average salary with the rupee symbol
    document.getElementById("average").innerText =
        "₹" + average.toLocaleString("en-IN", {
            maximumFractionDigits: 2
        });

}


// HIGHEST PAID EMPLOYEE

function findHighest() {

    // Check whether any employee records are available
    if (currentData.length === 0) {

        // Display a message if no employees are found
        document.getElementById("highest").innerText =
            "No employees found";

        return;

    }

    // Find the employee with the highest salary
    let highest = currentData.reduce((a, b) => {

        return Number(a.salary) > Number(b.salary) ? a : b;

    });

    // Display the employee name and highest salary
    document.getElementById("highest").innerText =
        highest.name + " - ₹" +
        Number(highest.salary).toLocaleString("en-IN");

}


// GROUP BY DEPARTMENT

function groupEmployees() {

    // Create an empty object to store department groups
    let groups = {};

    // Check each employee and group them by department
    currentData.forEach(emp => {

        // Create a new department group if it does not exist
        if (!groups[emp.department]) {

            groups[emp.department] = [];

        }

        // Add the employee name to the correct department
        groups[emp.department].push(emp.name);

    });


    // Create an empty string to store department information
    let output = "";

    // Display each department and its employees
    for (let dept in groups) {

        output += `

            <div class="group-box">

                <h3>${escapeHTML(dept)} Department</h3>

                <p>${groups[dept].map(escapeHTML).join(", ")}</p>

                <p class="group-count">
                    Total Employees: ${groups[dept].length}
                </p>

            </div>

        `;

    }


    // Check whether there are employees to group
    if (currentData.length === 0) {

        // Display a message if no employees are available
        output = "<p>No employees to group.</p>";

    }

    // Display department groups on the webpage
    document.getElementById("group").innerHTML = output;

}


// DASHBOARD SUMMARY

// Display the total number of employees
document.getElementById("totalEmployees").innerText = data.length;

// Get all unique department names
let departments = [...new Set(
    data.map(emp => emp.department)
)];

// Display the total number of departments
document.getElementById("totalDepartments").innerText =
    departments.length;


// INITIAL DISPLAY

// Display all employee records when the page loads
    displayEmployees(data);