<?php

    class Ticket{

        public $errors = 0;
        public $returnedMessage;

        public function __construct(){ 
            // $this->database = new mysqli("localhost", "root", "", "helpdesk");
            $this->database = new mysqli("XXXX", "XXXX", "XXXX", "XXXX");
            include_once('notifications.php');
            $this->notif = new Notifications();
            
        }
   
        function __destruct() {
            $this->database->close();
        }

        public function createTicket(){
            $username = $_SESSION['fUsername'];
            $tSubject = htmlspecialchars($_POST['ticketSubject']);
            $speciality = $_POST['activeUserSpeciality'];
            $tDescription = htmlspecialchars($_POST['ticketDescription']);
            $priority = $_POST['ticketPriority'];
            $date = gmdate("Y:m:d H:i:s");
            $status = 'Active';

            if(empty($username) || empty($tSubject) || empty($tDescription)){
                echo "Missing parameter";
            }
            else{ 
                $success = "";  
                $sql = "INSERT INTO tickets (fUsername, ticketSubject, speciality, priority, ticketDescription, ticketDate, ticketStatus, ticketLastMessage)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $this->database->prepare($sql);
                $stmt->bind_param("ssssssss", $username, $tSubject, $speciality, $priority, $tDescription, $date, $status, $date);
                $stmt->execute();
                if($stmt){
                    header("Location:myTickets.php?createdTicket=success");
                }
                else {
                    header("Location:myTickets.php?createdTicket=failed");
                }
            }
            
        }

        public function verifyTicketID($ticketID){
            if(is_numeric($ticketID)){
                $stmt = $this->database->prepare("SELECT * FROM tickets WHERE ticketID = ?");
                $stmt->bind_param("i", $ticketID);
                $stmt->execute();
                $result = $stmt->get_result();
                if($result->num_rows === 0){
                    $stmt = $this->database->prepare("SELECT * FROM tickets WHERE ticketID = ? AND ticketStatus = 'Closed' ");
                    $stmt->bind_param("i", $ticketID);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if($result->num_rows === 0){
                        header("Location: 404.php");
                    }
                }
            }
            else {
                header("Location: 404.php");
            }
           
        }

        
        public function checkStatus($ticketID){
            $sql = "SELECT ticketStatus FROM tickets WHERE ticketID = ?";
            $stmt = $this->database->prepare($sql);
            $stmt->bind_param("i", $ticketID);
            $stmt->execute();

            
            $stmt->store_result();
            if($stmt->num_rows == 0){
                $sql = "SELECT ticketStatus FROM tickets WHERE ticketID = ? AND ticketStatus = 'Closed'";
                $stmt = $this->database->prepare($sql);
                $stmt->bind_param("i", $ticketID);
                $stmt->execute();
            }
            $stmt->bind_result($checkStatus);
            $stmt->fetch();
            $stmt->close();
            return $checkStatus;       
        }

        
        
        public function getClosedStatus($ticketID){
            $sql =  "SELECT * FROM tickets WHERE ticketID = ? AND ticketStatus = 'Closed' ";
            $stmt = $this->database->prepare($sql);
            $stmt->bind_param("i", $ticketID);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows === 1){
                echo "<input type='submit' id='reopen-ticket' name='reopenTicket' value='Re-open Ticket'>";
            }
            else {
                return false;
            }
        }

        public function ticketReplyImg($targetName){
            $sql = "SELECT * FROM user_image WHERE fUsername = ?";
            $stmt = $this->database->prepare($sql);
            $stmt->bind_param("s", $targetName);
            $stmt->execute();
            $result = $stmt->get_result(); 

                while ($row = $result->fetch_assoc()) {
                    if($row['picture_status'] == 0){
                        echo "<img class='reply-img' src='uploads/profile".$targetName.".jpg'>";
                    }
                    else {
                        echo "<img class='reply-img' src='uploads/profileDefault.png'>";
                        
                    }
            }     
        }
    


        public function getTicketInfo($ticketID){
            $username = $_SESSION['fUsername'];
            $functions = new Functions();
            $user = new User();

            $foundTicket = false;
            $sql = "SELECT * FROM tickets WHERE ticketID = ?";
            $stmt = $this->database->prepare($sql);
            $stmt->bind_param("i", $ticketID);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows === 0 ){
                $sql = "SELECT * FROM tickets WHERE ticketID = ? AND ticketStatus = 'Closed' ";
                $stmt = $this->database->prepare($sql);
                $stmt->bind_param("i", $ticketID);
                $stmt->execute();
                $result = $stmt->get_result();
            }
           
            // $days = 
            echo "<ul class='ticket-info'>";
            while ($row = $result->fetch_assoc()) {
                if($row['fUsername'] != $username && $user->isAdmin() === 0 ){
                    header("Location: 404.php");
                }
                else {

                    
                    $ticketDate = new DateTime($row['ticketLastMessage']);
                    $ticketDay = new DateTime($row['ticketDate']);
                    echo "
                            <li>Created At  <p> ".$functions->convertDate($ticketDay, 'date')."        </p></li>
                            <li>Created By  <p> ".$row['fUsername']."         </p></li>
                            <li>Assigned To <p>" .$row['assignedTo']."        </p></li>
                            <li>Priority    <p>" .$row['priority']."          </p></li>
                            <li>Department  <p>" .$row['speciality']."        </p></li>
                            <li>Last Active   <p>" .$functions->convertDate($ticketDate, 'date')." </p></li>
                            <li>Status      <p> ".$row['ticketStatus']."      </p></li>
                        ";
                }
                echo "</ul>";      
            }
        }


        public function getTickets(){
            $user = new User();
            $functions = new Functions();

            $username = $_SESSION['fUsername'];

            $sql = $this->database->prepare(
                "SELECT ticketID, fUsername, ticketSubject, ticketDescription,
                ticketDate, ticketStatus, ticketLastMessage 
                FROM tickets WHERE fUsername = ? AND ticketStatus = 'Active' OR ticketStatus = 'In progress' ORDER BY ticketDate DESC");
                                             
            $sql->bind_param("s", $username);
            $sql->execute();
            $result = $sql->get_result();

            if($result->num_rows == 0){
                echo "<h3 style='text-align:center'>You have no active tickets</h2>";
            }
            
            while ($row = $result->fetch_assoc()) {
                if($row['fUsername'] === $username){
                
                    $ticketDate = new DateTime($row['ticketDate']);
                    $ticketMsg = new DateTime($row['ticketLastMessage']);

                    echo "
                    <table class='closedTable' role='table'>
                        <thead role='rowgroup'
                            <tr role='row'>
                                <th role='columnheader' class='ticket-c'>Ticket ID</th>
                                <th role='columnheader' class='subject-c'>Subject</th>
                                <th role='columnheader' class='date-c'>Date</th>
                                <th role='columnheader' class='status-c'>Status</th>
                                <th role='columnheader' class='last-m-c'>Last Message</th>
                                <th role='columnheader' class='btn-c'></th>
                            </tr>
                        </thead>
                        <tbody role='rowgroup'>
                            <tr role='row'>
                                <td role='cell'>".$row['ticketID']."</td>
                                <td role='cell'>".$row['ticketSubject']."</td>
                                <td role='cell'>".$functions->convertDate($ticketDate, 'date')."</td>
                                <td role='cell' class='status-c'>".$row['ticketStatus']."</td>
                                <td role='cell' class='last-m-c'>".$functions->convertDate($ticketMsg, 'date')."</td>
                                <td role='cell'><div class='tooltip'><button class='btnView' type='submit' value='".$row['ticketID']."' name='ticketID'><i class='fas fa-eye'><p class='tooltip-view'>View</p></i></button></div></td>        
                            </tr>
                        </tbody>
                    </table><br>";
                }
            }
        }


        
        public function getClosedTickets($currentPage){
            $user = new User();
            $functions = new Functions();

            $username = $_SESSION['fUsername'];
            $url = $_SERVER['REQUEST_URI']; 
            $url = substr($url, strpos($url, "a"));
            
            if($url == "adminPanel.php"){
                $sql = $this->database->prepare(
                    "SELECT ticketID, fUsername, ticketSubject, ticketDescription,
                    ticketDate, ticketStatus, ticketLastMessage 
                    FROM tickets WHERE ticketStatus = 'Closed' ORDER BY ticketDate DESC");
            }
            else {
                $sql = $this->database->prepare(
                    "SELECT ticketID, fUsername, ticketSubject, ticketDescription,
                    ticketDate, ticketStatus, ticketLastMessage 
                    FROM tickets WHERE fUsername = ? AND ticketStatus = 'Closed' ORDER BY ticketDate DESC");
                                    
                $sql->bind_param("s", $username);
            }

            $sql->execute();
            $result = $sql->get_result();

            if($result->num_rows == 0){
                echo "<h3 style='text-align:center'>You have no closed tickets</h2>";
            }

            while ($row = $result->fetch_assoc()) {

                $ticketDate = new DateTime($row['ticketDate']);
                $ticketMsg = new DateTime($row['ticketLastMessage']);
                  
                echo "
                <table class='closedTable' role='table'>
                    <thead role='rowgroup'
                        <tr role='row'>
                            <th role='columnheader' class='ticket-c'>Ticket ID</th>
                            <th role='columnheader' class='ticket-c'>Subject</th>
                            <th role='columnheader' class='date-c'>Date</th>
                            <th role='columnheader' class='status-c'>Status</th>
                            <th role='columnheader' class='last-m-c'>Last Message</th>
                            <th role='columnheader' class='btn-c'></th>
                        </tr>
                    </thead>
                    <tbody role='rowgroup'>
                        <tr role='row'>
                            <td role='cell'>".$row['ticketID']."</td>
                            <td role='cell' class='subject-c'>".$row['ticketSubject']."</td>
                            <td role='cell'>".$functions->convertDate($ticketDate, 'date')."</td>
                            <td role='cell' class='status-c'>".$row['ticketStatus']."</td>
                            <td role='cell' class='last-m-c'>".$functions->convertDate($ticketMsg, 'date')."</td>
                            <td role='cell'>
                            <div class='tooltip'><button class='btnView' type='submit'  value='".$row['ticketID']."' name='ticketID'><i class='fas fa-eye'><p class='tooltip-view'>View</p></i></button></div>
                            </td>
                        </tr>
                    </tbody>
                </table><br>";
            } 
        }


        public function viewTicket($ticketID){
            $functions = new Functions();
            
            $foundTicket = false;
            $closedTicket = false;

            $sql = $this->database->prepare("SELECT * FROM tickets WHERE ticketID = ? AND NOT ticketStatus = 'Closed'");
            $sql->bind_param("i", $ticketID);
            $sql->execute();
            $result = $sql->get_result();   
            
            if($result->num_rows == 0){
                $foundTicket = false;
            }
            else {
                $foundTicket = true;
                
            }
            
            if($foundTicket == false){
                $stmt = $this->database->prepare("SELECT * FROM tickets WHERE ticketID = ? AND ticketStatus = 'Closed' ");
                $stmt->bind_param("i", $ticketID);
                $stmt->execute();
                $result = $stmt->get_result();  

                if($result->num_rows == 0){
                    $foundTicket = false;
                }
                else {
                    $foundTicket = true;
                    $closedTicket = true;
                }
            }
            if($foundTicket == true){

                while ($row = $result->fetch_assoc()) {
                    // $call = new Database;
         
                    $_SESSION['ticketID'] = $ticketID;
                    
                    echo "    
                        <h4>".$row['ticketSubject']."</h4>
                        <p class='header-description'>".$row['ticketDescription']."</p>
                        <hr>
                        ";    
                       
                }
            }
            else {
                header("Location: 404.php");
            }
            
            if($foundTicket == true){
                $sql = $this->database->prepare("SELECT * FROM replies WHERE ticketID = ?");
                $sql->bind_param("i", $ticketID);
                $sql->execute();
                
                $result = $sql->get_result();   

                while ($row = $result->fetch_assoc()) {
                    $replyTime = new DateTime($row['replyTime']);
                   

                    echo "<div class='div-reply-data'>";
                    $this->ticketReplyImg($row['fUsername']);
                    echo "
  
                        <p class='reply-username'><strong>".$row['fUsername']."</strong></p>
                        <p class='reply-time'>".$functions->convertDate($replyTime, 'date')."</p>
                        
                        </div>
                        <p class='reply-info'>".$row['ticketReply']."</p>
                        <hr>
                    ";
                }
                if(!$closedTicket)
                    echo "<textarea maxlength='250' rows='10' class='ticket-textarea' name='ticketReply'></textarea> 
                        <span id='view-ticket-text' class='text-limit'>250 characters remaining</span>
                    ";
            }
        
        }

        public function addReply($ticketID){
            $user = new User();

            $username = $_SESSION['fUsername'];
            $ticketReply = htmlspecialchars($_POST['ticketReply']);
            $subject;
            $replyFrom;
            
            $date = gmdate("Y:m:d H:i:s");

            $sql = $this->database->prepare("SELECT fUsername, ticketSubject, ticketStatus FROM tickets WHERE ticketID = ?");
            $sql->bind_param("i", $ticketID);
            $sql->execute();
            $result = $sql->get_result(); 
            while ($row = $result->fetch_assoc()) {
                
                $subject = $row['ticketSubject'];
                $originalStatus = $row['ticketStatus'];
                if(!isset($_POST['ticketStatus'])){
                    $status = $originalStatus;
                }
                else {
                    $status = $_POST['ticketStatus'];
                }
            }

            if(!empty($ticketReply) && $user->isAdmin() == 0){
                $sql = "INSERT INTO replies (ticketID, fUsername, replyTime, ticketReply)
                VALUES (?, ?, ?, ?)";
                $stmt = $this->database->prepare($sql);
                $stmt->bind_param("ssss", $ticketID, $username, $date, $ticketReply);
                $stmt->execute();
                $replyFrom = "User";
               
                    $this->notif->addReplyNotification($username, $subject, $replyFrom, NULL);
                header('Location: viewTicket.php?ticketID='.$ticketID);
            }
            else if(!empty($ticketReply) && $user->isAdmin() >= 1){
                $sql = "INSERT INTO replies (ticketID, fUsername, replyTime, ticketReply)
                VALUES (?, ?, ?, ?)";
                $stmt = $this->database->prepare($sql);
                $stmt->bind_param("ssss", $ticketID, $username, $date, $ticketReply);
                $stmt->execute();

                $stmt = $this->database->prepare("UPDATE tickets SET ticketLastMessage = ?, ticketStatus = ? WHERE ticketID=?");
                $stmt->bind_param("ssi", $date, $status, $ticketID);
                $stmt->execute();
                $replyFrom = "Admin";
               
                    $this->notif->addReplyNotification($username, $subject, $replyFrom, NULL);
                

                if($status == "Closed"){
                    $stmt = $this->database->prepare("UPDATE tickets SET ticketStatus = 'Closed' WHERE ticketID = ?");
                    $stmt->bind_param("i", $ticketID);
                    $stmt->execute();
                }
                header('Location: viewTicket.php?ticketID='.$ticketID);
            }
        }

        public function reopenTicket($ticketID){
            $username = $_SESSION['fUsername'];

            $status = "Active";
            $subject = "";

            $stmt = $this->database->prepare("SELECT ticketSubject FROM tickets WHERE ticketID = ? AND ticketStatus = 'Closed' ");
            $stmt->bind_param("i", $ticketID);
            $stmt->execute();
            $result = $stmt->get_result(); 
            while ($row = $result->fetch_assoc()) {
                $subject = $row['ticketSubject'];
            }         

            $stmt = $this->database->prepare("UPDATE tickets SET ticketStatus = ? WHERE ticketID = ?");
            $stmt->bind_param("si", $status, $ticketID);
            $stmt->execute();

            
            $replyFrom = "userReopen";
             
            $this->notif->addReplyNotification($username, $subject, $replyFrom, NULL);

            
            // header('Location: viewTicket.php?ticketID='.$ticketID);
        }

        
            

        public function updateTicket(){
            $url = $_SERVER['REQUEST_URI']; 
            $description = $_POST['ticketDescription'];
            $ticketID = substr($url, strpos($url, "=") +1 );
            $date = gmdate("Y:m:d H:i:s");
            $status = 'Active';
    
            $stmt = $this->database->prepare("UPDATE tickets SET ticketDescription = ?, ticketLastMessage = ?, ticketStatus = ? WHERE ticketID=?");
            $stmt->bind_param("sssi", $description, $date, $status, $ticketID);
            $stmt->execute();
        }

       

    }// END CLASS