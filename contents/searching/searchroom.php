<!DOCTYPE html>
<html>
<head>
  <title>Make a Booking</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 20px;
      background-color: #f5f5f5;
    }
    
    .container {
      max-width: 600px;
      margin: 0 auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    
    h1 {
      text-align: center;
      margin-top: 0;
    }
    
    label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }
    
    input[type="text"],
    input[type="date"],
    input[type="submit"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    
    input[type="submit"] {
      background-color: #4caf50;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    
    input[type="submit"]:hover {
      background-color: #45a049;
    }
    
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    
    th, td {
      padding: 10px;
      text-align: left;
      border-bottom: 1px solid #ccc;
    }
    
    th {
      background-color: #f2f2f2;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Search for a room availability</h1>
    
    <form>
      <label for="Start_Date">Start Date:</label>
      <input type="date" id="Start_Date" name="Start_Date" required>
      
      <label for="End_Date">End Date:</label>
      <input type="date" id="End_Date" name="End_Date" required>
      
      <input type="submit" value="Search Availability">
    </form>
    
    <table>
      <thead>
        <tr>
          <th>Room #</th>
          <th>Roomname</th>
          <th>Room Type</th>
          <th>Beds</th>
        </tr>
      </thead>
      <tbody>
        <!-- Room availability results will be dynamically added here -->
      </tbody>
    </table>
  </div>
</body>
</html>