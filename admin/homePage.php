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
        <p>&copy; 2025 Waste Management Platform</p>
    </footer>
    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const requestContainer = document.getElementById('requests-container');
            const messagesContainer = document.getElementById('messages-container');
    
            // Fetch and display waste collection requests from the database
            async function fetchRequests() {
                try {
                    const response = await fetch('fetch_requests.php');
                    const requests = await response.json();
                    displayRequests(requests);
                } catch (error) {
                    console.error('Error fetching requests:', error);
                }
            }
            // Fetch and display suggestions
            async function fetchSuggestions() {
                try {
                    const response = await fetch('fetch_suggestions.php');
                    const suggestions = await response.json();
                    displaySuggestions(suggestions);
                } catch (error) {
                    console.error('Error fetching suggestions:', error);
                }
            }
    
            async function renderRequest(request, index) {
                const { name, email, phone, wasteType, location, status } = request; // Include status
                console.log(`Rendering request for ${name} with status: ${status}`); // Debug log

    
                return `<div class="request-container">
                            <div class="request-details">
                                <p><strong>Name:</strong> ${name}</p>
                                <p><strong>Email:</strong> ${email}</p>
                                <p><strong>Phone:</strong> ${phone}</p>
                                <p><strong>Waste Type:</strong> ${wasteType}</p>
                                <p><strong>Location:</strong> ${location}</p>
                            </div>
                            <div class="actions">
                                ${status === 'pending' ? `
                                    <button class="btn btn-accept" onclick="handleAccept('${email}')">Accept</button>
                                    <button class="btn btn-delete" onclick="handleDelete('${email}')">Delete</button>
                                ` : `
                                    <span class="accepted-message">Accepted</span>
                                `}
                            </div>
                        </div>`;
            }
    
            async function displayRequests(requests) {
                if (requests.length === 0) {
        requestContainer.innerHTML = '<p>No waste collection requests available.</p>';
        return;
    }
                const requestPromises = requests.map((request, index) => renderRequest(request, index));
                const requestsHtml = await Promise.all(requestPromises);
                requestContainer.innerHTML = requestsHtml.join('');
            }
            async function renderSuggestion(suggestion) {
                const { name, email, message } = suggestion;
                return `<div class="message-container">
                            <p><strong>Name:</strong> ${name}</p>
                            <p><strong>Email:</strong> ${email}</p>
                            <p><strong>Message:</strong> ${message}</p>
                        </div>`;
            }

            async function displaySuggestions(suggestions) {
                if (suggestions.length === 0) {
        messagesContainer.innerHTML = '<p>No suggestions available.</p>';
        return;
    }
                const suggestionPromises = suggestions.map(suggestion => renderSuggestion(suggestion));
                const suggestionsHtml = await Promise.all(suggestionPromises);
                messagesContainer.innerHTML = suggestionsHtml.join('');
            }
    
            window.handleAccept = function(email) {
                if (confirm('Are you sure you want to accept this request?')) {
                    // Call a PHP script to update the request status in the database
                    fetch('accept_request.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `email=${encodeURIComponent(email)}`
                    })
                    .then(response => response.text())
                    .then(data => {
                        alert(data); // Show success or error message
                        location.reload(); // Reload the page to reflect changes
                    })
                    .catch(error => {
                        console.error('Error accepting request:', error);
                    });
                }
            };
    
            window.handleDelete = function(email) {
                if (confirm('Are you sure you want to delete this request?')) {
                    // Call a PHP script to delete the request from the database
                    fetch('delete_request.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `email=${encodeURIComponent(email)}`
                    })
                    .then(response => response.text())
                    .then(data => {
                        alert(data); // Show success or error message
                        location.reload(); // Reload the page to reflect changes
                    })
                    .catch(error => {
                        console.error('Error deleting request:', error);
                    });
                }
            };
    
            fetchRequests(); // Fetch requests when the page loads
            fetchSuggestions();
        });
    </script>
    </body>
    </html>