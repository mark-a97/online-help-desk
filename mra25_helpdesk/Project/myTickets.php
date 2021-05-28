<?php

    session_start();
    ob_start();
    $message = "";
    $currentPage = "My Tickets";
    // include('includes/dbConnect.php');
    include('includes/navbar.php');
    include_once($_SERVER['DOCUMENT_ROOT'].'/helpdesk/classes/admin.php');

    $tickets = new Ticket();
    $admin = new Admin();
    $functions->isLoggedIn();
    if(isset($_POST['activeTickets'])){
        $tickets->addReply();
    }
    if(isset($_POST['createTicket'])) {
        $tickets->createTicket();  
    }

    if(isset($_GET['createdTicket'])){
        if($_GET['createdTicket'] == "success"){
            $message = $user->returnedMessage = "Ticket successfully created";
        }
        else if($_GET['createdTicket'] == "failed"){
            $db->errors ++;
            $message = $user->returnedMessage = "Problems creating ticket";
        }
    }

    if(isset($_POST['ticketID'])){
        header("Location: viewTicket.php?ticketID=" . $_POST['ticketID']);
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
                <button class="tablinks active" type='button' id='activeTab'>Active</button>
                <button class="tablinks" type='button' id='closedTab' >Closed</button>
            </div>


            <div class='form-manage-tickets'>


                <div id="Active" class="tabcontent" style='display:block'>
                    <h3 class='form-header'> Active Tickets</h3>
                    <hr>
                    <div class='tooltip'><span id='btnCreateTicket'><i class="fas fa-2x fa-plus-circle"></i><p class='tooltip-view'>Create ticket</p></span></div><?php $tickets->getTickets();?>
                </div>

                <div id="Closed" class="tabcontent" style='display: none'>
                    <h3 class='form-header'> Closed Tickets</h3>
                    <hr>
                    <?php $tickets->getClosedTickets(NULL); ?>
                </div>    
                
            </div>
        </form>
        
        
        <div class='form-manage' id='create-ticket-popup'>
            <form class="popup-create-ticket" method='POST'>
                <span id='close-btn'><i class="fas fa-times-circle"></i></span>
                <h3 class='form-header'>Create Ticket</h3>
                <hr>
                <p class='settings-list'><label class='input-label' for="ticketSubject">Subject</label>
                <input class="input-type" type="text" name="ticketSubject"></p>
                <?php $admin->getSettings('ticket');?>

                <p class='settings-list'><label class='input-label' for="ticketPriority">Priority</label>
                    <select class='select-input-ticket' name='ticketPriority'>
                        <option value='none' selected disabled hidden> Select an Option </option>
                        <option value='Low'>Low</option>
                        <option value='Medium'>Medium</option>
                        <option value='High'>High</option>
                    </select>
                </p>
        
                <p class='settings-list'><label class='input-label' for="ticketDescription">Description</label>
                <textarea maxlength='250' id='create-ticket-description' class="ticket-description" name="ticketDescription"></textarea> </p>
                <span class='text-limit'>250 characters remaining</span>

                <input class="submit-btn" type="submit" id="submitTicket" name="createTicket" value="Create Ticket">
            </form>
        </div>
    </div>
    </main>


    <?php
    include_once('includes/footer.php');
?>
