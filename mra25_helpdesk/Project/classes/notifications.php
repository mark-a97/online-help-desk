<?php

class Notifications{


    public function __construct(){ 
        // $this->database = new mysqli("localhost", "root", "", "helpdesk");
        $this->database = new mysqli("XXXX", "XXXX", "XXXX", "XXXX");
        
    }

    function __destruct() {
        $this->database->close();
    }

    public function notifImg($targetName){
        $sql = "SELECT * FROM user_image WHERE fUsername = ?";
        $stmt = $this->database->prepare($sql);
        $stmt->bind_param("s", $targetName);
        $stmt->execute();
        $result = $stmt->get_result(); 

            while ($row = $result->fetch_assoc()) {
                if($row['picture_status'] == 0){
                    echo "<img class='notif-img' src='uploads/profile".$targetName.".jpg'>";
                }
                else {
                    echo "<img class='notif-img' src='uploads/profileDefault.png'>";
                    
                }
        }     
    }

    public function openedNotification($value){
        $stmt = $this->database->prepare("UPDATE notifications SET readNotification = 'True' WHERE notificationID = ?");
        $stmt->bind_param("s", $value);
        $stmt->execute(); 
    }

 
    
    public function addReplyNotification($username, $subject, $replyFrom, $id){
        $url = $_SERVER['REQUEST_URI']; 
        $ticketID = substr($url, strpos($url, "=") +1 );
        $id;
        $notiTo;
        $message;
        $type = "";
        $entity = "";
        $status = 'False';
        $date = gmdate("Y:m:d H:i:s");

        if($replyFrom == "User"){
            $sql = $this->database->prepare("SELECT assignedTo FROM tickets WHERE ticketID = ?");
            $sql->bind_param("i", $ticketID);
            $sql->execute();
            $result = $sql->get_result(); 

            while ($row = $result->fetch_assoc()) {
                $notiTo = $row['assignedTo'];
            }
            $type = "Ticket";
            $entity = $ticketID;
            
            if($username !== $notiTo){
                $message = ' has replied to the ticket: ' . $subject . ' that you are watching. Click here to view.';
                $sql = "INSERT INTO notifications (noti_from, noti_to, noti_type, noti_time, noti_entity, noti_msg, readNotification)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
    
                $stmt = $this->database->prepare($sql);
                $stmt->bind_param("ssssiss", $username, $notiTo, $type, $date, $entity, $message, $status);
                $stmt->execute();  
            }

        }
        else if($replyFrom == "Admin"){
            $sql = $this->database->prepare("SELECT fUsername FROM tickets WHERE ticketID = ?");
            $sql->bind_param("i", $ticketID);
            $sql->execute();
            $result = $sql->get_result(); 

            while ($row = $result->fetch_assoc()) {
                $notiTo = $row['fUsername'];
              
            }
            $type = "Ticket";
            $entity = $ticketID;
            
            
            if($username !== $notiTo){
                $message = ' has replied to your ticket ('. $subject .'). Click here to view.';
                $sql = "INSERT INTO notifications (noti_from, noti_to, noti_type, noti_time, noti_entity, noti_msg, readNotification)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
    
                $stmt = $this->database->prepare($sql);
                $stmt->bind_param("ssssiss", $username, $notiTo, $type, $date, $entity, $message, $status);
                $stmt->execute();  
            }

        }
        else if($replyFrom == "userReopen"){
            $sql = $this->database->prepare("SELECT assignedTo FROM tickets WHERE ticketID = ? AND ticketStatus = 'Closed' ");
            $sql->bind_param("i", $ticketID);
            $sql->execute();
            $result = $sql->get_result(); 

            while ($row = $result->fetch_assoc()) {
                $notiTo = $row['assignedTo'];
              
            }
            $type = "ticketReopen";
            $entity = $ticketID;

            if($username !== $notiTo){
                $message = ' has reopened the ticket: '. $subject .'. Click here to view.';
                $sql = "INSERT INTO notifications (noti_from, noti_to, noti_type, noti_time, noti_entity, noti_msg, readNotification)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $this->database->prepare($sql);
                $stmt->bind_param("ssssiss", $username, $notiTo, $type, $date, $entity, $message, $status);
                $stmt->execute();  
            }

        }
        else if($replyFrom == "addDepartment"){
            $sql = $this->database->prepare("SELECT fUsername FROM technicians");
            $sql->execute();
            $result = $sql->get_result(); 

            while ($row = $result->fetch_assoc()) {
                $type = "addDepartment";
                $entity = $ticketID;
                $notiTo = $row['fUsername'];

                if($username !== $notiTo){
                    $message = ' has added a new department ('. $subject .'). Click here to view.';
                    $sql = "INSERT INTO notifications (noti_from, noti_to, noti_type, noti_time, noti_entity, noti_msg, readNotification)
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $this->database->prepare($sql);
                    $stmt->bind_param("ssssiss", $username, $notiTo, $type, $date, $entity, $message, $status);
                    $stmt->execute();  
                }
            }
        }
        else if($replyFrom == "addAdmin"){
            $sql = $this->database->prepare("SELECT id, fUsername FROM users WHERE fUsername = ? ");
            $sql->bind_param("s", $id);
            $sql->execute();
            $result = $sql->get_result(); 

            while ($row = $result->fetch_assoc()) {
                $notiTo = $row['fUsername'];
                $entity = $row['id'];
            }
            $type = "addAdmin";

            if($username !== $notiTo){
                $message = ' has set your admin level to: '. $subject .'. Click here to view your profile.';
                $sql = "INSERT INTO notifications (noti_from, noti_to, noti_type, noti_time, noti_entity, noti_msg, readNotification)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $this->database->prepare($sql);
                $stmt->bind_param("ssssiss", $username, $notiTo, $type, $date, $entity, $message, $status);
                $stmt->execute();  
                // echo $username;
            }
        }
        else if($replyFrom == "removeAdmin"){
            $sql = $this->database->prepare("SELECT id, fUsername FROM users WHERE fUsername = ? ");
            $sql->bind_param("s", $id);
            $sql->execute();
            $result = $sql->get_result(); 

            while ($row = $result->fetch_assoc()) {
                $notiTo = $row['fUsername'];
                $entity = $row['id'];
            }
            $type = "removeAdmin";

            if($username !== $notiTo){
                $message = ' has removed you as an Admin. Click here to view your profile.';
                $sql = "INSERT INTO notifications (noti_from, noti_to, noti_type, noti_time, noti_entity, noti_msg, readNotification)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $this->database->prepare($sql);
                $stmt->bind_param("ssssiss", $username, $notiTo, $type, $date, $entity, $message, $status);
                $stmt->execute();  
            }
        }
        else if($replyFrom == "assignedTo"){
            $sql = $this->database->prepare("SELECT assignedTo, ticketSubject FROM tickets WHERE ticketID = ? ");
            $sql->bind_param("i", $id);
            $sql->execute();
            $result = $sql->get_result(); 
            $assignedTo = "";

            while ($row = $result->fetch_assoc()) {
                $subject = $row['ticketSubject'];
                $notiTo = $row['assignedTo'];
                $entity = $id;
            }
            $type = "assignedTo";

            if($username !== $notiTo){
                $message = ' has assigned you to the ticket: '.$subject.'. Click here to view.';
                $sql = "INSERT INTO notifications (noti_from, noti_to, noti_type, noti_time, noti_entity, noti_msg, readNotification)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $this->database->prepare($sql);
                $stmt->bind_param("ssssiss", $username, $notiTo, $type, $date, $entity, $message, $status);
                $stmt->execute();  
            }
        }
        else if($replyFrom == "assignedToUser"){
            $assignee;
            $sql = $this->database->prepare("SELECT fUsername, assignedTo, ticketSubject FROM tickets WHERE ticketID = ? ");
            $sql->bind_param("i", $id);
            $sql->execute();
            $result = $sql->get_result(); 

            while ($row = $result->fetch_assoc()) {
                $subject = $row['ticketSubject'];
                $notiTo = $row['fUsername'];
                $assignee = $row['assignedTo'];
                $entity = $id;
            }
            $type = "assignedToUser";

            if($username !== $notiTo){
                $message = ' has assigned '.$assignee. ' to your ticket: '. $subject .'. You should get a response soon.';
                $sql = "INSERT INTO notifications (noti_from, noti_to, noti_type, noti_time, noti_entity, noti_msg, readNotification)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $this->database->prepare($sql);
                $stmt->bind_param("ssssiss", $username, $notiTo, $type, $date, $entity, $message, $status);
                $stmt->execute();  
            }
        }
        else if($replyFrom == "changePerms"){
            $notiTo = $subject;
            $sql = $this->database->prepare("SELECT can_delete, can_modify FROM technicians WHERE fUsername = ? ");
            $sql->bind_param("i", $notiTo);
            $sql->execute();
            $result = $sql->get_result(); 
            $modify = "";
            $delete = "";
            while ($row = $result->fetch_assoc()) {

                $modify = $row['can_modify'];
                $delete = $row['can_delete'];
                $entity = $notiTo;
            }
            $type = "changePerms";

            if($username !== $notiTo){
                $message = ' has changed your permissions delete: '.$delete.', modify: '.$modify.'. Click here to view your profile.';
                $sql = "INSERT INTO notifications (noti_from, noti_to, noti_type, noti_time, noti_entity, noti_msg, readNotification)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $this->database->prepare($sql);
                $stmt->bind_param("ssssiss", $username, $notiTo, $type, $date, $entity, $message, $status);
                $stmt->execute();  
            }
        }
        else if($replyFrom == "deleteTicket"){
            $notiTo = "";
            $entity = "";
            $sql = $this->database->prepare("SELECT fUsername from tickets WHERE ticketID = ? ");
            $sql->bind_param("i", $id);
            $sql->execute();
            $result = $sql->get_result(); 

            while ($row = $result->fetch_assoc()) {
                $notiTo = $row['fUsername'];
                $entity = $id;
            }
            $type = "deleteTicket";
    
            if($username !== $notiTo){
                $message = ' has deleted your ticket: '. $subject . '. Click here to view your tickets';
                $sql = "INSERT INTO notifications (noti_from, noti_to, noti_type, noti_time, noti_entity, noti_msg, readNotification)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $this->database->prepare($sql);
                $stmt->bind_param("ssssiss", $username, $notiTo, $type, $date, $entity, $message, $status);
                $stmt->execute();  
    
                
                $sql = "DELETE FROM tickets WHERE ticketID = ?";
                $stmt = $this->database->prepare($sql);
                $stmt->bind_param("i", $id);
                $stmt->execute(); 
            }
        }
    }


    }


?>