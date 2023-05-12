<?php session_start();?>
<?php include("../linkDB.php"); //database connection function ?> 

<!DOCTYPE html>

<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title> Stadia </title>
    
    <!-- Fontawesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 
     <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <?php include('../include/javascript.php'); ?>
     <?php include('../include/styles.php'); ?>

   </head>
<body onload="initClock()">

<div class="sidebar">

    <?php include('../include/clientsidebar.php'); ?>

</div>

<section class="home-section">

    <nav>

        <?php include('../include/navbar.php'); ?>

    </nav>

    <div class="home-content">

        <div class="main-content">

            <?php $var = $_SESSION['email']; ?>

            <h1>Upload CV</h1>

            <div class="content">

				<form method="post" enctype="multipart/form-data">
					<div class="form-input py-2">
						<div class="form-group">
						<input type="text" class="form-control" name="name"
								placeholder="Enter your name" required>
						</div>                                 
						<div class="form-group">
						<input type="file" name="pdf_file"
								class="form-control" accept=".pdf"
								title="Upload CV"/>
						</div>
						<div class="form-group">
						<input type="submit" class="btnRegister"
								name="submit" value="Submit">
						</div>
					</div>
				</form>

				<button id="view-cv-btn">View CV</button>

				<?php
					// Retrieve the pdf from the database
					$folder = "../pdf/";
					$result = mysqli_query($linkDB, "SELECT * FROM pdf_data WHERE email = '".$var."'");
					$row = mysqli_fetch_array($result);
					$filename = $row['filename'];
				?>
            
            </div>

        </div>

    </div>

    <footer>
        <div class="foot">
          <?php include("../include/footer.php"); ?>
        </div>
    </footer> 

</section>

</body>
</html>

<script>
        /* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
        var dropdown = document.getElementsByClassName("dropdown-btn");
        var i;
        
        for (i = 0; i < dropdown.length; i++) {
          dropdown[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var dropdownContent = this.nextElementSibling;
            if (dropdownContent.style.display === "block") {
              dropdownContent.style.display = "none";
            } else {
              dropdownContent.style.display = "block";
            }
          });
        }
</script>

<?php
	if (isset($_POST['submit'])) {

		$name = $_POST['name'];
		$email = $_SESSION['email'];

		if (isset($_FILES['pdf_file']['name']))
		{
		$file_name = $_FILES['pdf_file']['name'];
		$file_tmp = $_FILES['pdf_file']['tmp_name'];

		move_uploaded_file($file_tmp,"../pdf/".$file_name);

		$query ="INSERT INTO pdf_data(username,filename,email) VALUES('$name','$file_name', '$email')";
		$res = mysqli_query($linkDB, $query);
		}
		else
		{
		?>
			<div class=
			"alert alert-danger alert-dismissible
			fade show text-center">
			<a class="close" data-dismiss="alert"
				aria-label="close">×</a>
			<strong>Failed!</strong>
				File must be uploaded in PDF format!
			</div>
		<?php
		}
	}
?>

<script>
    const viewCvBtn = document.getElementById('view-cv-btn');
    
    viewCvBtn.addEventListener('click', () => {
        const url = "<?php echo $folder . $filename; ?>";
        window.open(url, '_blank');
    });
</script>