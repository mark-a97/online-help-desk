<?php


class Admin{

    public $errors = 0;
    public $returnedMessage;
    private $notif;

    public function __construct(){ 
        // $this->database = new mysqli("localhost", "root", "", "helpdesk");
        $this->database = new mysqli("localhost", "mra25_newUser", "JkI=4zvo36xz", "mra25_helpDesk");
        include_once('notifications.php');
        $this->notif = new Notifications();
        
    }

    function __destruct() {
        $this->database->close();
    }


    public function adminTask(){
        $subject = "";
        if(isset($_POST['addAdmin'])){
            $notiTo = $_POST['addAdmin'];
            if(!empty($notiTo)){
                $username = $_SESSION['fUsername'];
                $level;
                $id;
                $sql = "SELECT adminLevel, fUsername FROM users WHERE fUsername = ?";
                $stmt = $this->database->prepare($sql);
                $stmt->bind_param("s", $notiTo);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $level = $row['adminLevel'];
                    $id = $row['fUsername'];
                    
                }
                if(!$level > 0){
                    $deletePerms = 0;
                    $settingsPerms = 0;
                    $stmt = $this->database->prepare("UPDATE users SET adminLevel = 1 WHERE fUsername=?");
                    $stmt->bind_param("s", $notiTo);
                    $stmt->execute();  

                    if(isset($_POST['del-perms'])){
                        $deletePerms = 1;
                    }
                    if(isset($_POST['settings-perms'])){
                        $settingsPerms = 1;
                    }
                    $sql = "INSERT INTO technicians (fUsername, can_delete, can_modify)
                    VALUES (?, ?, ?)";
                    $stmt = $this->database->prepare($sql);
                    $stmt->bind_param("sii", $notiTo, $deletePerms, $settingsPerms);
                    $stmt->execute();

                    $subject = "1";
                    $replyFrom = "addAdmin";
                    $this->notif->addReplyNotification($username, $subject, $replyFrom, $id);

                }
                else {
                    echo "admin already";
                } 
            }
        }

        if(isset($_POST['changePerms'])){
            $target = $_POST['changePerms'];
            $username = $_SESSION['fUsername'];
            if($username != $target){
                if(!empty($target)){    

                    $modify = 0;
                    $delete = 0;

                    if(isset($_POST['update-del-perms'])) {
                        $delete = 1;
                    }
                    else {
                        $delete = 0;
                    }
                    if(isset($_POST['update-settings-perms'])) {
                        $modify = 1;
                    }
                    else {
                        $modify = 0;
                    }

                    $stmt = $this->database->prepare("UPDATE technicians SET can_delete = ?, can_modify = ? WHERE fUsername=?");
                    $stmt->bind_param("iis", $delete, $modify, $target);
                    $stmt->execute();
                    $subject = $target;
                    $replyFrom = "changePerms";

                    $this->notif->addReplyNotification($username, $subject, $replyFrom, NULL);
                }
            }
        }

        if(isset($_POST['removeAdmin'])){
            $removeUsername = $_POST['removeAdmin'];
            $username = $_SESSION['fUsername'];
            if(!empty($removeUsername)){
                $sql = "SELECT * FROM technicians WHERE fUsername = ?";
                $stmt = $this->database->prepare($sql);
                $stmt->bind_param("s", $removeUsername);
                $stmt->execute();
                $stmt->store_result(); //stores the result to check the rows
                if($stmt->num_rows === 1){
                    $sql = "DELETE FROM technicians WHERE fUsername = ?";
                    $stmt = $this->database->prepare($sql);
                    $stmt->bind_param("s", $removeUsername);
                    $stmt->execute(); 

                    $stmt = $this->database->prepare("UPDATE users SET adminLevel = 0 WHERE fUsername = ?");
                    $stmt->bind_param("s", $removeUsername);
                    $stmt->execute(); 
                    $id = $removeUsername;
                    $replyFrom = "removeAdmin";
                    $this->notif->addReplyNotification($username, NULL, $replyFrom, $id);
                }
            }
        }
    }

    public function removeDepartment(){
        $getFunction = new Functions();

        $username = $_SESSION['fUsername'];
        if(isset($_POST['addDepartment'])){
            $department = htmlspecialchars($_POST['addDepartment']);
            if(!empty($department)){

                $getFunction->valueChecks($department, "Department", NULL, 255, 8);
                $this->errors = $getFunction->getErrors();
                $this->returnedMessage = $getFunction->getMessage();

                if($this->errors === 0){     
                    $sql = "SELECT userSpeciality FROM admin_speciality WHERE userSpeciality = ?";
                    $stmt = $this->database->prepare($sql);
                    $stmt->bind_param("s", $department);
                    $stmt->execute();
                    $stmt->store_result(); //stores the result to check the rows
                    if($stmt->num_rows === 0){
                        $subject = "";
                        $sql = "INSERT INTO admin_speciality (userSpeciality) VALUES (?)";
                        $stmt = $this->database->prepare($sql);
                        $stmt->bind_param("s", $department);
                        $stmt->execute();
                        $subject = $department;
                        $replyFrom = "addDepartment";
                        $this->notif->addReplyNotification($username, $subject, $replyFrom, NULL);
                    }

                }
            }
        }

        if(isset($_POST['removeDepartment'])){
            $department = $_POST['removeDepartment'];
            if(!empty($department)){
                $sql = "SELECT userSpeciality FROM admin_speciality WHERE userSpeciality = ?";
                $stmt = $this->database->prepare($sql);
                $stmt->bind_param("s", $department);
                $stmt->execute();
                $stmt->store_result(); //stores the result to check the rows
                if($stmt->num_rows === 1){
                    $sql = "DELETE FROM admin_speciality WHERE userSpeciality = ?";
                    $stmt = $this->database->prepare($sql);
                    $stmt->bind_param("s", $department);
                    $stmt->execute(); 

                }
            }
        }
    }

    public function addRole(){
        if(isset($_POST['userSpeciality'])){
            $speciality = htmlspecialchars($_POST['userSpeciality']);
            $sql = "SELECT * FROM admin_speciality WHERE userSpeciality = ?";
            $stmt = $this->database->prepare($sql);
            $stmt->bind_param("s", $speciality);
            $stmt->execute();
            $stmt->store_result(); //stores the result to check the rows
            if($stmt->num_rows == 0){
                if(!empty($speciality)){
                    $sql = "INSERT INTO admin_speciality (userSpeciality) VALUES (?)";
                    $stmt = $this->database->prepare($sql);
                    $stmt->bind_param("s", $speciality);
                    $stmt->execute();
                }
                // header("Location: manage.php?updated=success");
            }
            else {
                echo "ERER";
            }
        }

            $this->adminTask();
            $this->removeDepartment();
    
    }

    
    public function getSettings($task){ // Set to user possibly
        // $newRole = $_POST['userRole'];
        // $speciality = $_POST['activeUserSpeciality'];
        if($task == 'speciality'){
            $sql = "SELECT * FROM admin_speciality";
            $stmt = $this->database->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
    
            echo "
            <select class='select-input-manage' name='removeDepartment'>
                <option value='none' selected disabled hidden> Select an Option 
            </option>";

            while ($row = $result->fetch_assoc()) {
                echo "<option value='".$row['userSpeciality']."'>".$row['userSpeciality'];
            }
            echo "</select>";
        }
        if($task == 'ticket'){
            $sql = "SELECT * FROM admin_speciality";
            $stmt = $this->database->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
    
            echo "
            <p class='settings-list'><label class='input-label' for='activeUserSpeciality'>Department</label>
            <select class='select-input-ticket' name='activeUserSpeciality'>
                <option value='none' selected disabled hidden> Select an Option 
            </option>";

            while ($row = $result->fetch_assoc()) {
                echo "<option value='".$row['userSpeciality']."'>".$row['userSpeciality'];
            }
            echo "</select>";
        }
        else if($task == 'faq'){
            $sql = "SELECT faqID, faq_topic, faq_question FROM faq_table";
            $stmt = $this->database->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
    
            echo "
            <p class='settings-list'><label class='input-label' for='faq_list'>Delete Question</label>
            <select class='select-input' id='select-question' name='faq_list'>
                <option value='none' selected disabled hidden> Select an Option 
            </option>";

            while ($row = $result->fetch_assoc()) {
                echo "<option value='".$row['faqID']."'>#".$row['faqID']." " .$row['faq_topic']. " - ".$row['faq_question'];
            }
            echo "</select>";
        }
        else if($task == 'getSpeciality'){
        
            $sql = "SELECT * FROM admin_speciality";
            $stmt = $this->database->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();

            echo "
            <select class='select-input' name='currentUserSpeciality'>";
                

            while ($row = $result->fetch_assoc()) {
                echo "<option value='".$row['userSpeciality']."'>".$row['userSpeciality'];
            }
            echo "</select>";


        }
        else if($task == 'admin'){
        
            $sql = "SELECT fUsername FROM users WHERE adminLevel < 1";
            $stmt = $this->database->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();

            echo "
            <select class='select-input' name='addAdmin'>";
                

            while ($row = $result->fetch_assoc()) {
                echo "<option value='none' selected='' disabled='' hidden=''> Select an Option 
                </option>
                <option value='".$row['fUsername']."'>".$row['fUsername'];
            }
            echo "</select>";
        }
        else if($task == 'perms'){
        
            $sql = "SELECT fUsername FROM users WHERE adminLevel > 0";
            $stmt = $this->database->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();

            echo "
            <select class='select-input' name='changePerms'>";
                
            while ($row = $result->fetch_assoc()) {
                echo "<option value='none' selected='' disabled='' hidden=''> Select an Option 
                </option>
                <option value='".$row['fUsername']."'>".$row['fUsername'];
            }
            echo "</select>";
        }
        else if($task == 'admin-remove'){
        
            $sql = "SELECT fUsername FROM technicians";
            $stmt = $this->database->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();

            echo "
            <select class='select-input' name='removeAdmin'>
            <option value='none' selected='' disabled='' hidden=''> Select an Option 
            </option>";
                

            while ($row = $result->fetch_assoc()) {
                echo "<option value='".$row['fUsername']."'>".$row['fUsername'];
            }
            echo "</select>";
        }
            
    }



    //CREATE ANOTHER ACTIVETICKET ONCE TICKET IS ASSINGED TO AN ADMIN //

    public function getAssignedTickets($currentPage){
        $functions = new Functions();
        $user = new User();

        $url = $_SERVER['REQUEST_URI']; 
        $url = substr($url, strpos($url, "a"));
        $username = "%".$_SESSION['fUsername']."%";
      
        $sql = $this->database->prepare(
            "SELECT ticketID, fUsername, ticketSubject, ticketDescription,
            ticketDate, ticketStatus, priority, ticketLastMessage 
            FROM tickets WHERE assignedTo LIKE ? AND NOT ticketStatus = 'Closed' ORDER BY ticketDate DESC");
        $sql->bind_param("s", $username);
        // $sql->bind_param("s", $username);
        $sql->execute();
        // $sql->store_result();

        include_once($_SERVER['DOCUMENT_ROOT'].'/helpdesk/includes/navBar.php');
        
        $result = $sql->get_result();

        if($result->num_rows == 0){
            echo "<h3 style='text-align:center'>You have no assigned tickets</h2>";
        }


        while ($row = $result->fetch_assoc()) {
           
            $ticketDate = new DateTime($row['ticketDate']);
            $ticketMsg = new DateTime($row['ticketLastMessage']);
            $days = $functions->convertDate($ticketDate, 'days');
            
            echo "
            <table class='assignedTable' role='table'>
                <thead role='rowgroup'
                    <tr role='row'>
                        <th role='columnheader' class='icon-c'></th>
                        <th role='columnheader'>Ticket ID</th>
                        <th role='columnheader'>Subject</th>
                        <th role='columnheader'>Date</th>
                        <th role='columnheader' class='status-c'>Status</th>
                        <th role='columnheader' class='priority-c'>Priority</th>
                        <th role='columnheader' class='last-m-c'>Last Message</th>
                        <th role='columnheader' class='btn-c'></th>
                    </tr>
                </thead>
                <tbody role='rowgroup'>
                    <tr role='rowgroup'>";
                        if(strtotime($functions->convertDate($ticketDate, 'days')) >= strtotime('+7 days')){
                            echo "<td role='cell'><div class='ticket-warning'><i class='fas fa-2x fa-exclamation'></i></div></td>";
                        }
                        else {
                            echo "<td role='cell'><div class='ticket-okay'><i class='fas fa-2x fa-thumbs-up'></i></div></td>";
                        }
                        echo "
                        <td role='cell'>".$row['ticketID']."</td> 
                        <td role='cell' class='subject-c'>".$row['ticketSubject']."</td>
                        <td role='cell'>".$functions->convertDate($ticketDate, 'date')."</td>
                        <td role='cell' id='subject-c-overflow'class='status-c'>".$row['ticketStatus']."</td>";
                        $functions->checkPriority($row['priority']);
                        echo "<td role='cell' class='last-m-c'>".$functions->convertDate($ticketMsg, 'date')."</td>
                        <td role='cell' id='assigned-btn-c'><div class='tooltip'><button class='btnView' type='submit'  value='".$row['ticketID']."' name='ticketID'><i class='fas fa-eye'><p class='tooltip-view'>View</p></i></button></div>";
                        if($user->adminPermissions('delete') == 1 || $user->isAdmin() == 2 && $currentPage == "Admin Dashboard"){
                            echo "<div class='tooltip'><button type='button' class='btnDelete' value='".$row['ticketID']."''><i class='fas fa-minus-circle'><p class='tooltip-delete'>Delete</p></i></button></div>"; 
                        }
                        echo "
                    </tr>
                </tbody>
            </table><br>";
            //<button class='btnView' value='".$row['ticketID']."' name='editTicket'>Reply</button></td>
        } 
    }


    public function getActiveTickets($currentPage){
        $functions = new Functions();
        $user = new User();
        $returnedResults = false;
        $url = $_SERVER['REQUEST_URI']; 
        $url = substr($url, strpos($url, "a"));
        // $username = $_SESSION['fUsername'];
        $sql = $this->database->prepare(
            "SELECT ticketID, fUsername, ticketSubject, ticketDescription,
            ticketDate, ticketStatus, priority, ticketLastMessage 
            FROM tickets WHERE assignedTo IS NULL ORDER BY ticketDate DESC");
                                         
        // $sql->bind_param("s", $username);
        $sql->execute();
        // $sql->store_result();
        
        $result = $sql->get_result();

        if($result->num_rows == 0){
            echo "<h3 style='text-align:center'>There are no active tickets</h2>";
        }
        else {
            $returnedResults = true;
        }



        while ($row = $result->fetch_assoc()) {

            $ticketDate = new DateTime($row['ticketDate']);
            $ticketMsg = new DateTime($row['ticketLastMessage']);
            $days = $functions->convertDate($ticketDate, 'days');        

            echo "
            <table id='myTable' class='activeTable' role='table'>
                <thead role='rowgroup'
                    <tr role='row'>
                        <th role='columnheader' class='checkbox-c'></th>
                        <th role='columnheader' class='ticket-c'>Ticket ID</th>
                        <th role='columnheader' class='assigned-c'>Assign to</th>
                        <th role='columnheader' class='subject-c'>Subject</th>
                        <th role='columnheader' class='date-c'>Date</th>
                        <th role='columnheader' class='status-c'>Status</th>
                        <th role='columnheader' class='priority-c'>Priority</th>
                        <th role='columnheader' class='last-m-c'>Last Message</th>
                        <th role='columnheader' class='btn-c'></th>
                    </tr>
                </thread>
                <tbody role='rowgroup'>
                    <tr role='row'>
                    <td role='cell'>";
                        if(strtotime($functions->convertDate($ticketDate, 'days')) >= strtotime('+7 days')){
                            echo "<div class='ticket-warning'><i class='fas fa-2x fa-exclamation'></i>";
                        }
                        else {
                            echo "<div class='ticket-okay'><i class='fas fa-2x fa-thumbs-up'></i>";
                        }
                        if($user->isAdmin() == 2){
                            echo "
                            <input type='checkbox' name='selectedTicket[]' value='".$row['ticketID']."'\>";
                        }
                        echo "</div>
                    
                    </td>
                    <td role='cell' class='ticket-c'><input readonly name='ticketName[]' class='ticket-number' value='".$row['ticketID']."'\></td>
                
            

            ";
       
            if($user->isAdmin() == 2){
                    $this->getSoftware($row['ticketID']);
            }
            else {
                echo "<td role='cell'>Empty</td>";
            }
            echo "

            <td role='cell' class='subject-c'>".$row['ticketSubject']."</td>
            <td role='cell' class='date-c'>".$functions->convertDate($ticketDate, 'date')."</td>
            <td role='cell' class='status-c'>".$row['ticketStatus']."</td>";
            $functions->checkPriority($row['priority']);
            echo "<td role='cell' class='last-m-c'>".$functions->convertDate($ticketMsg, 'date')."</td>
            <td role='cell' class='btn-c'>
            <div class='tooltip'><button class='btnView' type='submit' value='".$row['ticketID']."' name='ticketID'><i class='fas fa-eye'><p class='tooltip-view'>View</p></i></button></div>";
            if($user->adminPermissions('delete') == 1 || $user->isAdmin() == 2 && $currentPage == "Admin Dashboard"){
                echo "<div class='tooltip'><button type='button' class='btnDelete' value='".$row['ticketID']."''><i class='fas fa-minus-circle'><p class='tooltip-delete'>Delete</p></i></button></div>"; 
            }
            echo "
            </td>        
            </tr>
            </tbody>
            </table><br>     
            ";
            

            //<button class='btnView' value='".$row['ticketID']."' name='editTicket'>Reply</button></td>
        } 
        if($returnedResults === true){
            echo " <input class='submit-btn' type='submit' value='Update' name='panelUpdate'>";
        }
    }//    <td>".$row['priority']."</td>


    
    public function getSoftware($ticketID){     
        $speciality;
        $stmt = $this->database->prepare("SELECT speciality FROM tickets WHERE ticketID = ?");
        $stmt->bind_param("i", $ticketID);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $speciality = $row['speciality'];
        }         

        $stmt = $this->database->prepare("SELECT fUsername,  userSpeciality FROM technicians WHERE userSpeciality = ? ");
        $stmt->bind_param("s", $speciality);
        $stmt->execute();
        $result = $stmt->get_result();

        echo "<td role='cell'><select name='assigned[]' class='select-assign'>";
        if($result->num_rows === 0){
            $stmt = $this->database->prepare("SELECT fUsername FROM users WHERE adminLevel > 1");
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                
                echo "
                <option value='".$row['fUsername']."'>".$row['fUsername'];
            }
        }

        while ($row = $result->fetch_assoc()) {
           echo "
            <option value='".$row['fUsername']."'>".$row['fUsername'];
        }
        
        echo "</select></td>";
    }

    public function deleteTicket(){
        $deletedTicket;
        $username = $_SESSION['fUsername'];
        $ticketID = $_POST['delete-ticket'];
        $sql = "SELECT ticketSubject FROM tickets WHERE ticketID = ?";
        $stmt = $this->database->prepare($sql);
        $stmt->bind_param("i", $ticketID);
        $stmt->execute(); 
        $result = $stmt->get_result();
        
        while($row = $result->fetch_assoc()){
            $subject = $row['ticketSubject'];
        }

        $replyFrom = "deleteTicket";
        $id = $ticketID;
        $this->notif->addReplyNotification($username, $subject, $replyFrom, $id);
        if($stmt){
            header("Location:adminPanel.php?deletedTicket=success&ticketID=".$ticketID);
        }
        else {
            header("Location:adminPanel.php?deletedTicket=failed&ticketID=".$ticketID);
        }
        
    }

    public function checkTicket(){
        $username = $_SESSION['fUsername'];
        $checkboxes = array();
        $last;
        if(isset($_POST['selectedTicket'])){
            foreach($_POST['selectedTicket'] as $ticketName){
                $checkboxes[] = $ticketName;
                $last = $ticketName;
                
            }
    
            // print_r($checkboxes);
            // echo "<br>";
            // echo "Last ticket was: " .$last;
            $names = array();
            $ids = array();
           
            foreach($_POST['ticketName'] as $ticketName){
                $ids[] = $ticketName;
            }
        
            foreach($_POST['assigned'] as $assigned){
                $names[] = $assigned;
            }
            
            // print_r($names);
            // print_r($ids);
            // print_r($names);
            $res = array_combine($ids, $names);
            
            foreach($checkboxes as $id) 
            {
          
                foreach($res as $key => $value)
                { 
                    if($key == $id){
                  
                        // echo "<br> ID " . $id." checkbox is checked assignedTo = ".$value;
                        $stmt = $this->database->prepare("UPDATE tickets SET assignedTo = ?, ticketStatus = 'In progress' WHERE ticketID=?");
                        $stmt->bind_param("si", $value, $id);
                        $stmt->execute(); 

                        $subject = "";
                        $sql = $this->database->prepare("SELECT ticketSubject, ticketID FROM tickets WHERE ticketID = ?");
                        $sql->bind_param("i", $id);
                        $sql->execute();
                        $result = $sql->get_result();   

                        while ($row = $result->fetch_assoc()) {
                            $subject = $row['ticketSubject'];
                            $id = $row['ticketID'];
                        }
                        
                        $replyFrom = "assignedTo";
                        $this->notif->addReplyNotification($username, $subject, $replyFrom, $id);
                        
                        $replyFrom = "assignedToUser";
                        $this->notif->addReplyNotification($username, $subject, $replyFrom, $id);
                    }  
                }
            }        
        }
    }
    
    // public function checkTicket(){
    //     $username = $_SESSION['fUsername'];
    //     $checkboxes = array();
    //     $last;
    //     if(isset($_POST['selectedTicket'])){
    //         foreach($_POST['selectedTicket'] as $ticketName){
    //             if(isset($_POST['selectedTicket'])){
    //             $checkboxes[] = $ticketName;
    //             $last = $ticketName;
    //             }
                
    //         }
    //         echo "<br>";
    
    //         // print_r($checkboxes);
    //         // echo "<br>";
    //         // echo "Last ticket was: " .$last;
    //         $names = array();
    //         $ids = array();
           
    //         foreach($_POST['ticketName'] as $ticketName){
    //             if(isset($_POST['ticketName'])){
    //                 $ids[] = $ticketName;
    //             }
    //         }
        
    //         foreach($_POST['assigned'] as $assigned){
    //             if(isset($_POST['assigned'])){
    //                 $names[] = $assigned;
    //             }
    //         }
            
    //         // print_r($names);
    //         // print_r($ids);
    //         print_r($names);
    //         print_R($checkboxes);
    //         $res = array_combine($checkboxes, $names); // checkboxes was $id;
    //         print_r($res);
            
    //         // foreach($checkboxes as $id) 
    //         // {
                
          
    //             foreach($res as $key => $value)
    //             { 
    //                 // if($key == $id){

    //                     $stmt = $this->database->prepare("UPDATE tickets SET assignedTo = ?, ticketStatus = 'In progress' WHERE ticketID=?");
    //                     $stmt->bind_param("si", $value, $id);
    //                     $stmt->execute(); 

    //                     $subject = "";
    //                     $sql = $this->database->prepare("SELECT ticketSubject, ticketID FROM tickets WHERE ticketID = ?");
    //                     $sql->bind_param("i", $ticketID);
    //                     $sql->execute();
    //                     $result = $sql->get_result();   

    //                     while ($row = $result->fetch_assoc()) {
    //                         $subject = $row['ticketSubject'];
    //                         $id = $row['ticketID'];
    //                     }
                        
    //                     $replyFrom = "assignedTo";
    //                     $this->notif->addReplyNotification($username, $subject, $replyFrom, $id);
                        
    //                     $replyFrom = "assignedToUser";
    //                     $this->notif->addReplyNotification($username, $subject, $replyFrom, $id);

    //                     // header("Location: adminPanel.php?assignedAdmin=True");

    //                 // }  
    //             }
    //         // }        
    //     }
    // }
  
    public function faq($task){
        $username = $_SESSION['fUsername'];
        if($task === 'add'){
            $topic = htmlspecialchars($_POST['faq-topic']);
            $question = htmlspecialchars($_POST['faq-question']);
            $answer = htmlspecialchars($_POST['faq-answer']);

            $sql = "INSERT INTO faq_table (fUsername, faq_topic, faq_question, faq_answer) VALUES (?, ?, ?, ?)";
            $stmt = $this->database->prepare($sql);
            $stmt->bind_param("ssss", $username, $topic, $question, $answer);
            $stmt->execute();
            if($stmt){
                header("Location: faq.php?updatedFAQ=True");
            }
            else {
                header("Location: faq.php?updatedFAQ=False");
            }
        }
        else if($task === 'del'){
            $ID = $_POST['faq_list'];
            $sql = "DELETE FROM faq_table WHERE faqID = ?";
            $stmt = $this->database->prepare($sql);
            $stmt->bind_param("s", $ID);
            $stmt->execute(); 
            if($stmt){
                header("Location: faq.php?deletedFAQ=True");   
            }
            else {
                header("Location: faq.php?deletedFAQ=False");   
            }
        }
    }

} // END CLASS

?>