<!DOCTYPE HTML>
<html>

<head>
  <title>Browse customers with AJAX autocomplete</title>
  <script>

    function searchResult(searchstr) {
      if (searchstr.length == 0) {

        return;
      }
      xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          //take JSON text from the server and convert it to JavaScript objects
          //mbrs will become a two dimensional array of our customers much like
          //a PHP associative array
          var mbrs = JSON.parse(this.responseText);
          var tbl = document.getElementById("tblcustomers"); //find the table in the HTML

          //clear any existing rows from any previous searches
          //if this is not cleared rows will just keep being added
          var rowCount = tbl.rows.length;
          for (var i = 1; i < rowCount; i++) {
            //delete from the top - row 0 is the table header we keep
            tbl.deleteRow(1);
          }

          //populate the table
          //mbrs.length is the size of our array
          for (var i = 0; i < mbrs.length; i++) {
            var mbrid = mbrs[i]['customerID'];
            var fn = mbrs[i]['firstname'];
            var ln = mbrs[i]['lastname'];

            //concatenate our actions urls into a single string
            var urls = '<a href="viewcustomer.php?id=' + mbrid + '">[view]</a>';
            urls += '<a href="editcustomer.php?id=' + mbrid + '">[edit]</a>';
            urls += '<a href="deletecustomer.php?id=' + mbrid + '">[delete]</a>';

            //create a table row with three cells  
            tr = tbl.insertRow(-1);
            var tabCell = tr.insertCell(-1);
            tabCell.innerHTML = ln; //lastname
            var tabCell = tr.insertCell(-1);
            tabCell.innerHTML = fn; //firstname      
            var tabCell = tr.insertCell(-1);
            tabCell.innerHTML = urls; //action URLS            
          }
        }
      }
      //call our php file that will look for a customer or customers matchign the seachstring
      xmlhttp.open("GET", "customersearch.php?sq=" + searchstr, true);
      xmlhttp.send();
    }
  </script>
</head>
<style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
    }

    h1 {
      background-color: #007BFF;
      color: white;
      padding: 20px;
      text-align: center;
      margin-bottom: 20px;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    a {
      text-decoration: none;
      color: #007BFF;
    }

    a:hover {
      text-decoration: underline;
    }

    form {
      text-align: center;
      margin: 0 auto;
      padding: 20px;
      background-color: #fff;
      border: 1px solid #ddd;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      max-width: 400px;
    }

    label {
      font-weight: bold;
    }

    input[type="text"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      margin-bottom: 10px;
      font-size: 16px;
    }

    table {
      width: 100%;
      margin-top: 20px;
      border-collapse: collapse;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      background-color: #fff;
    }

    th,
    td {
      padding: 10px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #007BFF;
      color: white;
    }

    tr:hover {
      background-color: #f5f5f5;
    }
  </style>

<body>

  <h1>Customer List Search by Lastname</h1>
  <h2><a href='registercustomer.php'>[Create new Customer]</a><a href="index.php">[Return to main page]</a>
  </h2>
  <form>
    <label for="lastname">Lastname: </label>
    <input id="lastname" type="text" size="30" onkeyup="searchResult(this.value)" onclick="javascript: this.value = ''"
      placeholder="Start typing a last name">

  </form>
  <table id="tblcustomers" border="1">
    <thead>
      <tr>
        <th>Last name</th>
        <th>First name</th>
        <th>Actions</th>
      </tr>
    </thead>

  </table>
</body>

</html>