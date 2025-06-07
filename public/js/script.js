
document.addEventListener('DOMContentLoaded', function () {
    initializeNavigation();
    initializeChart();
});

// Sidebar Toggle for Mobile
function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    sidebar.classList.toggle('active');
}

// Logout Function
function logout() {
    window.location.href = 'admin-login.php';
}

// Navigation System
function initializeNavigation() {
    const menuItems = document.querySelectorAll('.sidebar-menu li[data-section]');

    menuItems.forEach(item => {
        item.addEventListener('click', function () {
            // Remove active class from all items
            menuItems.forEach(li => li.classList.remove('active'));

            // Add active class to clicked item
            this.classList.add('active');

            // Hide all sections
            document.querySelectorAll('.content-section').forEach(section => {
                section.classList.remove('active');
            });

            // Show selected section
            const sectionId = this.dataset.section;
            document.getElementById(sectionId).classList.add('active');
        });
    });
}

// Chart Initialization
function initializeChart() {
    // Main Chart
    const ctx = document.getElementById('myChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Monthly Sales',
                data: [65, 59, 80, 81, 56, 55],
                borderColor: '#667eea',
                tension: 0.4,
                fill: false
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                },
                title: {
                    display: true,
                    text: 'Sales Analytics'
                }
            }
        }
    });

    // Analytics Chart
    const ctx2 = document.getElementById('analyticsChart').getContext('2d');
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: ['Q1', 'Q2', 'Q3', 'Q4'],
            datasets: [{
                label: 'Quarterly Performance',
                data: [45, 78, 66, 94],
                backgroundColor: '#667eea'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                },
                title: {
                    display: true,
                    text: 'Performance Analytics'
                }
            }
        }
    });
}

function toggleStatus(button) {
    if (button.classList.contains("unblock")) {
        button.innerText = "Unblock";
        button.classList.remove("unblock");
        button.classList.add("block");
    } else {
        button.innerText = "Block";
        button.classList.remove("block");
        button.classList.add("unblock");
    }
}

async function adminLogout(){

    const response = await  fetch(
            "/admin-logout",
            {
                method: "GET",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }

    );

    if (response.ok) {
        window.location = "/";
    } else {
        console.log("Error");
    }
}

async function sensorStatus(id,status){

    const data = {
        id:id ,
        status:status 
    };

    console.log(data);

    const response = await  fetch(
            "sensor-status",
            {
                method: "POST",
                body: JSON.stringify(data),
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }

    );

    if (response.ok) {
        const json = await response.json();
        console.log(json);

        if(json.success){
            window.location.reload();
        }
        

    } else {
        console.log("error");
    }
}

async function loadChart(id){
    const data = {
        id:id 
    };

    console.log(data);

    const response = await  fetch(
            "/load-chart",
            {
                method: "POST",
                body: JSON.stringify(data),
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }

    );

    if (response.ok) {
        const json = await response.json();
        console.log(json);

        if(json.success){
            window.location.reload();
        }
        

    } else {
        console.log("error");
    }
}

async function userStatus(id,status){

    const data = {
        id:id ,
        status:status 
    };

    console.log(data);

    const response = await  fetch(
            "user-status",
            {
                method: "POST",
                body: JSON.stringify(data),
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }

    );

    if (response.ok) {
        const json = await response.json();
        console.log(json);

        if(json.success){
            window.location.reload();
        }
        

    } else {
        console.log("error");
    }
}