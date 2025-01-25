console.log("script.js loaded"); // Add this line at the top of your script.js
document.addEventListener('DOMContentLoaded', () => {
    const contactForm = document.getElementById('contact-form');

    if (contactForm) {
        contactForm.addEventListener('submit', (e) => {
            e.preventDefault(); // Prevent the default form submission
            console.log("Form submitted");

            // Collect form data
            const contactData = {
                name: contactForm.name.value,
                email: contactForm.email.value,
                message: contactForm.message.value
            };

            // Log the data being sent
            console.log("Data being sent:", contactData); 

            // Send data to the server
            $.ajax({
                url: 'http://localhost/Waste%20management%20platform/submit_contact.php', // Adjust the path to your PHP script
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(contactData),
                success: (response) => {
                    // Log the response for debugging
                    console.log("Response from server:", response);
                    const result = JSON.parse(response);
                    if (result.success) {
                        alert('Message sent successfully!');
                        contactForm.reset(); // Reset the form fields
                    } else {
                        alert('Error sending message: ' + result.error);
                    }
                },
                error: (xhr, status, error) => {
                    console.error('Error details:', xhr.responseText); // Log the error response
                    alert('An error occurred: ' + error);
                }
            });
        });
    }
});