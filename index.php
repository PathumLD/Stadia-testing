<!DOCTYPE html>

<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title> Stadia </title>
    <link rel="stylesheet" href="css/index.css">
    <!-- Fontawesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>

  <!-- Move to up button -->
  <div class="scroll-button">
    <a href="#home"><i class="fas fa-arrow-up"></i></a>
  </div>

  <!-- navgaition menu -->
  <nav>
    <div class="navbar">
      <div class="logo"><a href="#"><img src="images/logo2.png" alt="logo"></a></div>
      <ul class="menu">
          <li><a href="#home">Home</a></li>
          <li><a href="#about">About</a></li>
          <li><a href="#gallery">Gallery</a></li>
          <li><a href="#services">Services</a></li>
          <li><a href="#contact">Contact</a></li>
          <li><a href="login.php">Login</a></li>
      </ul>
      <div class="media-icons">
        <a href="https://www.facebook.com/"><i class="fab fa-facebook-f"></i></a>
        <a href="https://twitter.com/"><i class="fab fa-twitter"></i></a>
        <a href="https://www.instagram.com/"><i class="fab fa-instagram"></i></a>
      </div>
    </div>
  </nav>

<!-- Home Section Start -->
 <section class="home" id="home">
   <div class="home-content">
     <div class="text">
       <div class="text-one">STADIA</div>
       <div class="text-two">PLAY LIKE A CHAMPION</div>
     </div>
     <div class="button">
       <button onclick="location.href='login.php'"> Login Here!</button>
     </div>
   </div>
 </section>

<!-- About Section Start -->
<section class="about" id="about">
  <div class="content">
    <div class="title"><span>About US</span></div>
  <div class="about-details">
    <div class="left">
      <img src="images/about.jpeg" alt="about image">
    </div>
    <div class="right">
      
      <p><p>
            <?php
            include("linkDB.php");
            $query = "SELECT details FROM adminabout LIMIT 1"; // assuming you only have one row in the table
            $result = mysqli_query($linkDB, $query);
            $row = mysqli_fetch_assoc($result);
            $details = $row['details'];
            echo $details;
            ?>
          </p>
          <div class="button">
        <button onclick="location.href='login.php'">Register With Us!</button>
      </div>
    </div>
  </div>
  </div>
</section>


<!-- Gallery section start -->
<section class="gallery" id="gallery">
  <div class="content">
    <div class="title"><span>Gallery</span></div>
    <div class="boxes">

      <table>
        <tr>
          <td><img src="images/1.jpg" alt="about image"></td>
          <td><img src="images/2.jpeg" alt="about image"></td>
          <td><img src="images/3.jpg" alt="about image"></td>
        </tr>
        <tr>
          <td><img src="images/4.jpg" alt="about image"></td>
          <td><img src="images/5.jpg" alt="about image"></td>
        </tr>
      </table>

    </div>
  </div>
</section>


<!-- My Services Section Start -->
 <section class="services" id="services">
   <div class="content">
     <div class="title"><span>Our Services</span></div>
     <div class="boxes">

      <div class="box">
        <div class="icon">
          <i class="fas fa-swimming-pool"></i>
        </div>
        <div class="topic">Court / Pool Booking</div>
        <p>We provide an efficient system for booking courts and swimming pools in accordance with your needs.</p>
      </div>

      <div class="box">
         <div class="icon">
           <i class="fas fa-boxes"></i>
       </div>
       <div class="topic">Enroll in classes</div>
       <p>Clients can register for classes based on their age and level of experience.</p>
     </div>

       <div class="box">
         <div class="icon">
           <i class="fas fa-shopping-cart"></i>
       </div>
       <div class="topic">Rent Equipment</div>
       <p>Clients can borrow and rent out equipment they need for an affordable rate on a daily basis.</p>
     </div>

       <div class="box">
         <div class="icon">
          <i class="fas fa-coffee"></i>
       </div>
       <div class="topic">Order Refreshments</div>
       <p>Clients can place retail or bulk orders for refreshments such as snacks and drinks.</p>
     </div>

       <div class="box">
         <div class="icon">
           <i class="fas fa-users"></i>
       </div>
       <div class="topic">Find Students</div>
       <p>Consists of a student information management system where records of students are kept and student information can be viewed.</p>
     </div>

     <div class="box">
        <div class="icon">
          <i class="fas fa-user-secret"></i>
        </div>
        <div class="topic">Find Coaches</div>
        <p>Clients can find coaches if they prefer to do practices in a professional manner</p>
      </div>       

   </div>
   </div>
 </section>

<!-- Contact Me section Start -->
<section class="contact" id="contact">
  <div class="content">
    <div class="title"><span>Contact Us</span></div>
    <div class="text">
      <ul>
        <li> <i class="fas fa-map-marker"></i> 35/A , Stadia , Park Street , Col-07</li>
        <li> <i class="fas fa-phone"></i> 011 - 2606888</li>
        <li> <i class="fas fa-mobile"></i> 071 123 4567</li>
        <li> <i class="fas fa-building"></i> 7.00AM - 10.00PM  Monday - Sunday</li>
      </ul>
    </div>
    <div class="map">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.810008881926!2d79.85639471441087!3d6.915620195004827!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae2486c725a7145%3A0xd5ba5d279874b56c!2sPark%20St%2C%20Colombo%200007!5e0!3m2!1sen!2slk!4v1654478615658!5m2!1sen!2slk" width="300" height="225" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </div>
  </div>
</section>

<!-- Footer Section Start -->
<footer>
  <div class="text">
    <span>Created By <a href="#">Stadia.</a> | &#169; 2023 All Rights Reserved</span>
  </div>
</footer>

  <script src="js/script.js"></script>
</body>
</html>