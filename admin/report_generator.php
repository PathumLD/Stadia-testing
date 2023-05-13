<?php
// Include the database connection file
include("../linkDB.php"); //database connection function 
?>
<!DOCTYPE html>

<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <title> Stadia </title>

  <!-- Fontawesome CDN Link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"> </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
  <!-- <link rel="stylesheet" href="../css/admin.css"> -->
  
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      margin: 20px;
    }

    .page-border {
      border: 1px solid black;
      padding: 20px;
    }

    .report-title {
      font-size: 24px;
      margin-bottom: 20px;
    }

    .report-table {
      border-collapse: collapse;
      width: 100%;
    }

    .report-table th,
    .report-table td {
      border: 1px solid black;
      padding: 8px;
    }

    .report-table th {
      text-align: left;
      background-color: #f2f2f2;
    }

    .btn-pdf {
  background-color: #0A2558;
  color: white;
  font-size: 1.0rem;
  padding: 6px 12px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
}

.btn-pdf:hover {
  background-color: darkblue;
  color: white;
  border-color: #0A2558;
  cursor: pointer;
}
  </style>

</head>

<body>
<div id="divID">

  <div class="page-border">
    
   
    <table class="report-table">


    <?php
  if(isset($_POST['generate_report'])) {
    $reportType = $_POST['report_type'];
    $reportTitle = "";

    switch ($reportType) {
      case 'listcoaches':
        $reportTitle = "List of Coaches Report";
        $query = "SELECT sport, GROUP_CONCAT(coach) as coaches FROM coach_classes GROUP BY sport";
        break;

      case 'listmembers':
        $reportTitle = "List of Members Report : Overview by Monthly";
        $query = "SELECT fname, lname, email,NIC, type
        FROM users
        WHERE MONTH(datetime) = MONTH(CURRENT_TIMESTAMP()) AND YEAR(datetime) = YEAR(CURRENT_TIMESTAMP())";
      
        break;

        case 'refreshmentorders':
          $reportTitle = "Refreshments Order Summary: Overview by Monthly";
          $query = "SELECT product_id, quantity, date
          FROM orders
          WHERE type = 'refreshment' AND MONTH(date) = MONTH(CURRENT_DATE()) AND YEAR(date) = YEAR(CURRENT_DATE())";
                
          break;
          case 'equipmentorders':
            $reportTitle = "Equipment Order Summary: Overview by Monthly";
            $query = "SELECT product_id, quantity, date
            FROM orders
            WHERE type = 'equipment' AND MONTH(date) = MONTH(CURRENT_DATE()) AND YEAR(date) = YEAR(CURRENT_DATE())";
                  
            break;

            case 'complainstatus':
              $reportTitle = "Complaint Status";
              $query = "SELECT subject, details, handled
              FROM complaints
              WHERE status = 1 AND handled IN (3,4)";      
              break;
            
              default:
                $reportTitle = "Unknown Report";
                $query = "";
                break;
    }

    // Generate report table
    if ($query != "") {
      $result = $linkDB->query($query);

      if ($result->num_rows > 0) {
        echo "<h2 class='report-title'>$reportTitle</h2>";
        echo "<table class='report-table'>";
        echo "<thead><tr>";
        switch ($reportType) {
          case 'listcoaches':
            echo "<th>Sport</th>";
            echo "<th>Coaches</th>";
            break;

          case 'listmembers':
            echo "<th>First Name</th>";
            echo "<th>Last Name</th>";
            echo "<th>NIC</th>";
            echo "<th>Email</th>";
            echo "<th>Type</th>";
            break;

            case 'refreshmentorders':
              echo "<th>Product Id</th>";
              echo "<th>Date</th>";
              echo "<th>Quantity</th>";
              break;

              case 'equipmentorders':
                echo "<th>Product Id</th>";
                echo "<th>Date</th>";
                echo "<th>Quantity</th>";
                break;
         
                case 'complainstatus':
                  echo "<th>Subject</th>";
                  echo "<th>Details</th>";
                  echo "<th>Handled Status</th>";
                  break;
           
          

          default:
            break;
        }
        echo "</tr></thead>";
        echo "<tbody>";
        while ($row = $result->fetch_assoc()) {
          echo "<tr>";
          switch ($reportType) {
            case 'listcoaches':
              echo "<td>" . $row["sport"] . "</td>";
              echo "<td>" . $row["coaches"] . "</td>";
              break;

            case 'listmembers':
              echo "<td>" . $row["fname"] . "</td>";
              echo "<td>" . $row["lname"] . "</td>";
              echo "<td>" . $row["NIC"] . "</td>";
              echo "<td>" . $row["email"] . "</td>";
              echo "<td>" . $row["type"] . "</td>";
              break;

              case 'refreshmentorders':
                echo "<td>" . $row["product_id"] . "</td>";
                echo "<td>" . $row["date"] . "</td>";
                echo "<td>" . $row["quantity"] . "</td>";
                break;
                
                case 'equipmentorders':
                  echo "<td>" . $row["product_id"] . "</td>";
                  echo "<td>" . $row["date"] . "</td>";
                  echo "<td>" . $row["quantity"] . "</td>";
                  break;
                
                  case 'complainstatus':
                    echo "<td>" . $row["subject"] . "</td>";
                    echo "<td>" . $row["details"] . "</td>";
                    if ($row["handled"] == 3) {
                      echo "<td>Not Handled</td>";
                    } else if ($row["handled"] == 4) {
                      echo "<td>Handled</td>";
                    }
                    break;

            default:
              break;
          }
          echo "</tr>";
        }
        echo "</tbody></table>";
      } else {
        echo "<p>No results found.</p>";
      }
    } else {
      echo "<p>Unknown report type.</p>";
    }
  }
?>
</div>
</div>
<script type="text/javascript">
        function convertHTMLtoPDF() {
            const { jsPDF } = window.jspdf;
 
            var doc = new jsPDF('l', 'mm', [1500, 1400]);
            var pdfjs = document.querySelector('#divID');
 
            doc.html(pdfjs, {
                callback: function(doc) {
                    doc.save("Report_summary.pdf");
                },
                x: 12,
                y: 12
            });               
        }           
    </script>      
    <button onclick="convertHTMLtoPDF()" class="btn-pdf" id="btnpdf" style="    margin-left: 1267px;    /* float: left; */    margin-top: 54px;    /* margin-right: 279px; */">Generate PDF</button>

</body>

</html>