<?php
    include_once($_SERVER['DOCUMENT_ROOT'].'/helpdesk/classes/user.php');
    include_once($_SERVER['DOCUMENT_ROOT'].'/helpdesk/classes/functions.php');
    include_once($_SERVER['DOCUMENT_ROOT'].'/helpdesk/classes/tickets.php');
    include_once($_SERVER['DOCUMENT_ROOT'].'/helpdesk/classes/notifications.php');

    $db;
    $user = new User();
    
    $functions = new Functions();
    $notif = new Notifications();

    $level = "";
    $delete;
    $modify = "";
    if(isset($_POST['ticketIDD'])){
        $set = $_POST['ticketIDD'];
    }
    if(isset($_SESSION['id'])){
        $logged_in = $_SESSION['id'];
        // $db = new Database;
        $level = $user->isAdmin();
        if($level > 0){
            $delete = $user->adminPermissions('delete');
            $modify = $user->adminPermissions('modify');
        }
    }
    else{
        $logged_in = null;
    }
    if(isset($_SESSION['ticketID'])){
        $ticketID = $_SESSION['ticketID'];
    }
    
    if(isset($_POST['entity_id'])){
        $value = $_POST['entity_id'];
        $notif->openedNotification($value);
    }
    $url = $_SERVER['REQUEST_URI'];  

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="javascript/main.js"></script>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/grid.css">

    <?php 
        include_once('checkPage.php');
    ?>

    <title>We Fix It</title>

</head>


<div id='wrapper'>

<nav class="navBar">
    <?php if($logged_in){ ?>
    <div class="burger-i" id='burger-i'>
        <i class="fas fa-bars burger"> </i>
    </div> <?php } ?>
    <div class="logo">
        <a id='site-name' href="index.php">We Fix It</a>
        <a id='site-name-mobile' href="index.php">WFX</a>
    </div>
   
    <?php if($logged_in){ ?>
        

    <ul class='nav-links'>        
        <div id='profile'>
        <li class="dropdown">
            <span><?php 
                if(isset($_SESSION['fUsername'])) {
                    echo $user->getImg('nav-bar');
                    echo "<span id='nav-username'>".$_SESSION['fUsername']."</span>";
                }
            ?> &nbsp;&nbsp;<i class="fa fa-caret-down"></i>
                      
            <div class="dropdown-content-name">
                <a href="includes/logout.php">Logout</a>
            </div>  
        </li>
            </div>
        
        <li class="dropdown"><span id='notif-menu' class='notif-icon'href="#"><i class="fas fa-bell" id='noti_number'> </i> </span>
           
                <form class="popup-notif-form" id='x' method='POST'>
        <!-- <span id='notif-close-btn'><i class="fas fa-times-circle"></i></span> -->
                    <h2>Notifications</h2>
                    <div id='notif_list'>

                    </div>
                </form>
           
        </li>
          
    </ul>
 
    
<div class='notification-box'>
            <ul id='notif_test' class='notif-list'>
                <?php     include_once($_SERVER['DOCUMENT_ROOT'].'/helpdesk/notifications/noti_list.php'); ?>
            </ul>

</div>

<?php } ?>



    <!-- <div class='dropdown'>
    <?php 
            if(isset($_SESSION['fUsername'])) {
                echo "<p class='drop-btn'>
                Hello " . $_SESSION['fUsername']
                ."<i class='fas fa-caret-down'></i></p>";
            }

            ?>
            <div class='dropdown-content'>
            <a href='#'>Logout</a>
            </div>
        </div>
     -->


<!--  <form class='notif-form' action='".$url.$row['ticketID']."' method='POST'> -->
    


    
</nav>

<?php 
if($logged_in) { ?>
<aside class='sideNavBar'>

<ul class="side-nav-active" id="side-nav">
<li class='nav-list'><a 
            <?php if($currentPage === "Dashboard") { echo "id='active-page'";}
            ?> href='index.php'><span class='font-icon'><i class="fas fa-user"></span></i>Dashboard</a>
        </li>

        <?php if($level > 1 || $modify === 1) { ?>
            <li class='nav-list'><a <?php if($currentPage === "Management") { echo "id='active-page'";}
                ?> href='manage.php'><span class='font-icon' ><i class="fas fa-user-cog"></span></i><span id='cog'>Management</span></a>
            </li>
        <?php } ?>

        <?php if($level >= 1){ ?>
            <li class='nav-list'><a <?php if($currentPage === "Admin Dashboard") { echo "id='active-page'";}
                ?> href='adminPanel.php'><span class='font-icon'><i class="fas fa-headset"></span></i>Ticket dash</a>
            </li>
        <?php } ?>

        <li class='nav-list'><a <?php if($currentPage === "My Tickets") { echo "id='active-page'";}
            ?> href='myTickets.php'><span class='font-icon'><i class="fas fa-clipboard-list"></span></i>My Tickets</a>
        </li>

        <li class='nav-list'><a <?php if($currentPage === "FAQ") { echo "id='active-page'";}
            ?> href='faq.php'><span class='font-icon'><i class="fas fa-question"></span></i>FAQ</a>
        </li>

        <li class='nav-list'><a <?php if($currentPage === "/") { echo "id='active-page'";}
            ?> href='includes/logout.php'><span class='font-icon'><i class="fas fa-sign-out-alt"></span></i>Logout</a>
        </li>
      
       
    </ul>

</aside>
<?php } ?>

<div class='user-location'>
    <?php echo "<p id='page-name'>".$currentPage."</p>"; ?>
</div>

