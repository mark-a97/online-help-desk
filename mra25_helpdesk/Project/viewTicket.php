<?php
    session_start();
    ob_start();

    $currentPage = "View Ticket";
    include('includes/navbar.php');
    
    $tickets = new Ticket();
    $functions->isLoggedIn();

    if(isset($_POST['submitReply'])){
        $tickets->submitReply();
    }

    if(isset($_POST['addReply'])){
         $tickets->addReply($ticketID);
    }

    if(isset($_POST['reopenTicket'])){
        $tickets->reopenTicket($ticketID);
   }

   if(isset($_GET['ticketID'])){
       $ticketID = $_GET['ticketID'];
   }

    $tickets->verifyTicketID($ticketID);


?>



    <main>
        <div class='inside-main'>
           
            <form class='form-style-view-ticket' action="viewTicket.php?ticketID=<?php echo $ticketID;?>" method='POST'>
                <div class='view-sidebar'>
                    <?php $tickets->getTicketInfo($ticketID); ?>  
                </div>
                <div class='view-main'>
                <h3 class='form-header' id=''> Ticket: #<?php echo $ticketID; ?></h3>
                <hr>
                    <?php $tickets->viewTicket($ticketID); ?>  

                    <?php if($user->isAdmin() >= 1){ ?>
                            <select class='select-input-ticket' name='ticketStatus'>
                            <option value='none' selected disabled hidden> <?php echo $tickets->checkStatus($ticketID);?> </option>
                                <option value='Active'>Active</option>
                                <option value='In progress'>In progress</option>
                                <option value='Closed'>Closed</option>
                            </select>
                    <?php } 

                        if($tickets->getClosedStatus($ticketID) === false){
                            echo "<input class='submit-btn-ticket' type='submit' id='updateDescription' name='addReply' value='Add Reply'>";
                        }

                        ?>
                        
                 
                </div>
            </form>
            
         </div>

    </main>
    <?php
    include_once('includes/footer.php');
?>