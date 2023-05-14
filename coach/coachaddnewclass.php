<?php session_start(); ?>
<?php include("../linkDB.php"); //database connection function ?>

<?php 

    if(isset($_POST['submit'])){

        $level = $_POST['level'];
        $sport = $_POST['sport'];
        $day = $_POST['day'];
        $stime = $_POST['stime'];
        $etime = $_POST['etime'];
        $age_group = $_POST['age_group'];
        $months = $_POST['months'];
        $no_of_students = $_POST['no_of_students'];
        $email = $_SESSION['email'];


        $query = "SELECT CONCAT(fname, ' ', lname) AS coach_name FROM users WHERE email = '$email'";
        $result = mysqli_query($linkDB, $query);
        $row = mysqli_fetch_assoc($result);
        $coach = $row['coach_name'];

        $time = $stime . ' - ' . $etime;


        // Validate the input for months
        if($months >= 1 && $months <= 3) {
            $sql = "INSERT INTO coach_classes (level, sport, day, time, age_group, months, no_of_students, email, coach) VALUES ('$level', '$sport', '$day', '$time', '$age_group', '$months', '$no_of_students', '$email', '$coach')";
            if(mysqli_query($linkDB, $sql)){
                echo "<script>window.location.href='coachclasses.php'; </script>";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($linkDB);
            }
        } else {
            echo "Months count should be between 1 and 3";
        }
    }

?>
