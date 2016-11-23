

<?php include_once"php/database.php" ?>

<!DOCTYPE html>
<html lang="en">
<?php include_once"php/head.php" ?>
<?php include_once"php/header.php"  ?>



<section id="content">
    <div class="container">
<section id="mainbar">
    
    <div class="blog-wrapper">
        
        <div class="blog-item">
<?php 
   
    $sql="select * from content";
    $result = mysql_query($sql);
    while ($data = mysql_fetch_array($result))
    {
?>
             
     
        </div>
        <div class="blog-item">
            <div class="blog-title"><?php echo $data['judul_content'];?></div>
            <div class="blog-meta"><?php echo $data['tgl_content'];?></div>
            <div class="blog-content">
            <?php echo $data['isi_content'];?>
            </div>
            <a href="" class="blog-readmore">Read More</a>
<?php } ?>
        </div>

    </div>

</section>
<?php include_once"php/sidebar.php"  ?>
<?php include_once"php/footer.php"  ?>

</body>
=======

<?php include_once"php/database.php" ?>

<!DOCTYPE html>
<html lang="en">
<?php include_once"php/head.php" ?>
<?php include_once"php/header.php"  ?>



<section id="content">
    <div class="container">
<section id="mainbar">
    
    <div class="blog-wrapper">
        
        <div class="blog-item">
<?php 
   
    $sql="select * from content";
    $result = mysql_query($sql);
    while ($data = mysql_fetch_array($result))
    {
?>
             
     
        </div>
        <div class="blog-item">
            <div class="blog-title"><?php echo $data['judul_content'];?></div>
            <div class="blog-meta"><?php echo $data['tgl_content'];?></div>
            <div class="blog-content">
            <?php echo $data['isi_content'];?>
            </div>
            <a href="" class="blog-readmore">Read More</a>
<?php } ?>
        </div>

    </div>

</section>
<?php include_once"php/sidebar.php"  ?>
<?php include_once"php/footer.php"  ?>

</body>

</html>