<?php

    session_start();
    ob_start();
    
    $currentPage = "Admin Dashboard";

    include('includes/navbar.php');
    include_once($_SERVER['DOCUMENT_ROOT'].'/helpdesk/classes/admin.php');
    
    $tickets = new Ticket();
    $admin = new Admin();
    $message = "";

    if($level < 1) {
        header("Location: index.php");
    }

    $functions->isLoggedIn();
    
    if(isset($_POST['activeTickets'])){
        $tickets->addReply();
    }
    if(isset($_GET['btnUpdate'])){
        $status = $_GET['ticketSelect'];
        echo $status;
    }
    if(isset($_POST['panelUpdate'])){
        $admin->checkTicket();
    }
    if(isset($_POST['delete-ticket'])) {
        $admin->deleteTicket();
    }
    if(isset($_POST['ticketID'])){
        header("Location: viewTicket.php?ticketID=" . $_POST['ticketID']);
    }
    
    if(isset($_GET['deletedTicket'])){
        if($_GET['deletedTicket'] == "success"){
            $message = $user->returnedMessage = "Ticket " . $_GET['ticketID'] . " successfully deleted";
        }
        else if($_GET['deletedTicket'] == "failed"){
            $user->errors ++;
            $message = $user->returnedMessage = "Problems deleting " . $_GET['ticketID'];
        }
    }
    else if(isset($_GET['assignedAdmin'])){
        if($_GET['assignedAdmin']){
            $message = $user->returnedMessage = "Ticket(s) have been assigned";
        }
    }
 
  
?>

<main>

<?php if($user->errors > 0) {echo "<div class='error-div'><p class='error-message'>"; echo $message . "</p> </div>";
            }
        
        else if($user->errors === 0 && $user->returnedMessage == true) {
            echo "<div class='success-div'><p class='error-message'>"; echo $message . "</p> </div>";
        }
    ?>  
    
<div class='inside-main'>        


    
   <form class='form-style-tickets' method='POST''>

        <div class="tab">
            <button class="tablinks" type='button' id='activeTab'>Active</button>
            <button class="tablinks" type='button' id='assignedTab' >Assigned</button>
            <button class="tablinks" type='button' id='closedTab' >Closed</button>
            <input type='search' id='search-bar' name='search-bar' placeholder='Search ticket...'>
        </div>

        <div class='form-manage-tickets'>


            <!-- Tab content -->
            <div id="Active" class="tabcontent" style='display:block'>
            <h3 class='form-header'>Active Tickets</h3>
                <hr>
                <?php $admin->getActiveTickets($currentPage);?>
            </div>

            <div id="Assigned" class="tabcontent" style='display: none'>
                <h3 class='form-header'> Assigned Tickets</h3>
                <hr>
                <?php $admin->getAssignedTickets($currentPage);?>
            </div>

            <div id="Closed" class="tabcontent" style='display: none'>
            <h3 class='form-header'> Closed Tickets</h3>
                <hr>
                <?php $tickets->getClosedTickets($currentPage); ?>
            </div>

            <div>
                <p class='legend-text'><span class='ticket-okay'><i class='fas fa-2x fa-thumbs-up'></i></span> = under 7 days active</p>             
                <p id='exclamation' class='legend-text'><span class='ticket-warning'><i class='fas fa-2x fa-exclamation'></i></span> = over 7 days active</p>
            </div>
        </div>

    </form>

    <div class='form-manage' id='create-ticket-popup'>
        <form class="popup-create-ticket" method='POST'>
            <div class='icon-warning'><div id='triangle-warning'><i class="fas fa-4x fa-exclamation-triangle"></i></div> <!-- //ff6961 pastal red--></div>
            
                <h3>Are you sure?</h3>
                <p id='delete-p'></p>
                <div class='btn-div'>
                    <button id='form-btn-close' type='button'>Cancel</button>
                    <button id='form-btn-delete'>Delete</button>
                </div>
            </div>
        </form>
    </div>
    
</div>
</main>




    <?php include_once('includes/footer.php'); ?>