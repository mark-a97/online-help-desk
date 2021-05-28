<?php
    session_start();
    ob_start();

    $currentPage = "404 PAGE NOT FOUND";
    // include('includes/dbConnect.php');
    include('includes/navbar.php');
    
   
  
?>

    <main>
        <div>
    <?php
if(isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])){

}
else{
echo "Please to not enter random inputs into the search bar!";
}
?>
  </div>
    </main>
    <?php
    include_once('includes/footer.php');
?>