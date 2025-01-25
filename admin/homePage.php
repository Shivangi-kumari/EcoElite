<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Provider Dashboard</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <nav>
        <a href="homePage.php">Home</a>
        <a href="../index.php">Logout</a>
    </nav>
    <header>
        <h1>Service Provider Dashboard</h1>
    </header>
    <main>
        <h2>Waste Collection Requests</h2>
        <div id="requests-container"></div>

        <h2>Suggestions</h2>
        <div id="messages-container" class="message-container"></div>
    </main>
    <footer>
        <p>&copy; 2024 Waste Management Platform</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
    const requestContainer = document.getElementById('requests-container');
    const messagesContainer = document.getElementById('messages-container');

    // Fetch and display waste collection requests
    const requests = JSON.parse(localStorage.getItem('scheduleRequests')) || [];

    async function fetchLocationName(lat, lng) {
        try {
            const response = await fetch('https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1');
            const data = await response.json();
            return data.display_name;
        } catch (error) {
            console.error('Error fetching address:', error);
            return 'Location details unavailable';
        }
    }

    async function renderRequest(request, index) {
        const { name, email, phone, wasteType, location } = request;
        const [lat, lng] = location ? location.split(',').map(Number) : [undefined, undefined];

        let locationName = 'Location details unavailable';
        let longitudeText = 'Longitude not available';
        let latitudeText = 'Latitude not available';

        if (lat && lng && !isNaN(lat) && !isNaN(lng)) {
            locationName = await fetchLocationName(lat, lng);
            longitudeText = lng;
            latitudeText = lat;
        } else {
            longitudeText = lng !== undefined ? lng : 'Longitude not available';
            latitudeText = lat !== undefined ? lat : 'Latitude not available';
        }

        return `<div class="request-container">
                    <div class="request-details">
                        <p><strong>Name:</strong> ${name}</p>
                        <p><strong>Email:</strong> ${email}</p>
                        <p><strong>Phone:</strong> ${phone}</p>
                        <p><strong>Waste Type:</strong> ${wasteType}</p>
                        <p><strong>Location Name:</strong> ${locationName}</p>
                       
                    </div>
                    <div class="actions">
                        <button class="btn btn-accept" onclick="handleAccept(${index})">Accept</button>
                        <button class="btn btn-delete" onclick="handleDelete(${index})">Delete</button>
                    </div>
                </div>`;
    }

    async function displayRequests() {
        const requestPromises = requests.map((request, index) => renderRequest(request, index));
        const requestsHtml = await Promise.all(requestPromises);
        requestContainer.innerHTML = requestsHtml.join('');
    }

    displayRequests();

    window.handleAccept = function(index) {
        if (confirm('Are you sure you want to accept this request?')) {
            const requests = JSON.parse(localStorage.getItem('scheduleRequests')) || [];
            requests.splice(index, 1); // Remove the request from the list
            localStorage.setItem('scheduleRequests', JSON.stringify(requests)); // Update local storage
            location.reload(); // Reload the page to reflect changes
        }
    };

    window.handleDelete = function(index) {
        if (confirm('Are you sure you want to delete this request?')) {
            const requests = JSON.parse(localStorage.getItem('scheduleRequests')) || [];
            requests.splice(index, 1); // Remove the request from the list
            localStorage.setItem('scheduleRequests', JSON.stringify(requests)); // Update local storage
            location.reload(); // Reload the page to reflect changes
        }
    };

    // Fetch and display contact messages
    const messages = JSON.parse(localStorage.getItem('contactMessages')) || [];

    messages.forEach(message => {
        const messageElem = document.createElement('div');
        messageElem.innerHTML = `<p><strong>Name:</strong> ${message.name}</p>
                                 <p><strong>Email:</strong> ${message.email}</p>
                                 <p><strong>Message:</strong> ${message.message}</p>`;
        messagesContainer.appendChild(messageElem);
    });
});

    </script>
    </body>
    </html>