function handleAction(action, r_id) {
    fetch(`homePage.php?action=${action}&id=${r_id}`)
        .then(response => response.text())
        .then(data => {
            alert(data); // Show success/error message
            if (action === 'accept') {
                // Update the UI for accepted request (you can also refresh or update the status)
            } else if (action === 'delete') {
                // Remove the request from the UI
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

function handleDelete(action, r_id) {
    fetch(`homePage.php?action=delete&id=${r_id}`)
        .then(response => response.text())
        .then(data => {
            alert(data); // Success message
            // You can also update the UI here to reflect the deleted status
        })
        .catch(error => {
            console.error('Error:', error);
        });
}


    // Function to handle Accept and Delete actions
    function handleAction(action, r_id) {
        fetch(`homePage.php?action=${action}&id=${r_id}`)
            .then(response => response.text())
            .then(data => {
                alert(data); // Show success/error message
                if (action === 'accept') {
                    // Update the UI for accepted request (you can also refresh or update the status)
                } else if (action === 'delete') {
                    // Remove the request from the UI
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }


