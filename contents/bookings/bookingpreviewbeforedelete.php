<!DOCTYPE html>
<html>
<head>
    <title>Booking Preview before deletion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .booking-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .booking-item {
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 10px;
            margin-bottom: 10px;
        }

        .delete-btn {
            background-color: #FF3333;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 10px;
        }
    </style>
</head>
<body>
<div style="text-align: center;">
    <h1>Booking Preview before deletion</h1>
    <h2><a href='listrooms.php'>[Return to the Bookings listings]</a><a href="index.php">[Return to main page]</a>

</h2>
</div>
    <div class="booking-container" id="bookingContainer">
        <!-- Bookings will be dynamically added here using JavaScript -->
    </div>

    <script>
        // Sample data for bookings (replace this with actual data from the server)
        const bookings = [
            {
                id: 1,
                roomname: "Luxury Suite",
                roomtype: "Suite",
                beds: 1,
                checkin: "2023-08-15",
                checkout: "2023-08-20",
                contactnumber: "1234567890",
                bookingextras: "Breakfast included",
            },
            {
                id: 2,
                roomname: "Standard Room",
                roomtype: "Double",
                beds: 2,
                checkin: "2023-09-05",
                checkout: "2023-09-10",
                contactnumber: "9876543210",
                bookingextras: "Late checkout",
            },
        ];

        // Function to render the bookings on the page
        function renderBookings() {
            const bookingContainer = document.getElementById("bookingContainer");
            bookingContainer.innerHTML = "";

            bookings.forEach((booking) => {
                const bookingItem = document.createElement("div");
                bookingItem.classList.add("booking-item");

                const bookingDetails = `
                    <p><strong>Room Name:</strong> ${booking.roomname}</p>
                    <p><strong>Room Type:</strong> ${booking.roomtype}</p>
                    <p><strong>Beds:</strong> ${booking.beds}</p>
                    <p><strong>Check-in Date:</strong> ${booking.checkin}</p>
                    <p><strong>Check-out Date:</strong> ${booking.checkout}</p>
                    <p><strong>Contact Number:</strong> ${booking.contactnumber}</p>
                    <p><strong>Booking Extras:</strong> ${booking.bookingextras}</p>
                    <button class="delete-btn" onclick="confirmDelete(${booking.id})">Delete</button>
                `;

                bookingItem.innerHTML = bookingDetails;
                bookingContainer.appendChild(bookingItem);
            });
        }

        // Function to confirm booking deletion
        function confirmDelete(bookingId) {
            const confirmed = confirm("Are you sure you want to delete this booking?");
            if (confirmed) {
                // Simulate booking deletion (you would send this to the server in a real application)
                const index = bookings.findIndex((booking) => booking.id === bookingId);
                if (index !== -1) {
                    bookings.splice(index, 1);
                    renderBookings();
                }
            }
        }

        // Initial render when the page loads
        renderBookings();
    </script>
</body>
</html>
