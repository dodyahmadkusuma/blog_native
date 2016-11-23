<<<<<<< HEAD
<?php
 session_start(); 
 ?>

<?php if(isset($_SESSION['userdata'])) : ?>
<h1>Selamat datang</h1>
<a href="logout.php">Logout</a>

<?php else : ?>
<h1>maaf</h1> <a href="login.php">Kembali</a>
<?php endif ;?>
=======
<?php
 session_start(); 
 ?>

<?php if(isset($_SESSION['userdata'])) : ?>
<h1>Selamat datang</h1>
<a href="logout.php">Logout</a>

<?php else : ?>
<h1>maaf</h1> <a href="login.php">Kembali</a>
<?php endif ;?>
>>>>>>> fac416ddeaafeb63a6c9be7da51eb0e509d06404
