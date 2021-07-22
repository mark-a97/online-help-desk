
<?php
  include('../classes/notifications.php');


   if(isset($_COOKIE['session_cookie'])){
       $db = new Notifications();
   
    $username = $_COOKIE['session_cookie'];

   
        $servername = "XXXX";
        $susername = "XXXX";
        $password = "XXXX";
        $dbname = "XXXX";

        // $servername = "localhost";
        // $susername = "root";
        // $password = "";
        // $dbname = "helpdesk";
        
        $id;
        $msg;
        // Create connection
        $conn = new mysqli($servername, $susername, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        $sql = $conn->prepare("SELECT * FROM notifications WHERE noti_to = ? ORDER BY noti_time DESC");
        $sql->bind_param("s", $username);
        $sql->execute();
        $result = $sql->get_result(); 

        if ($result->num_rows > 0) {

            while($row = $result->fetch_assoc()) {
                $notifications = $row['noti_type'];
                
                switch($notifications) {
                    case 'Ticket':
                        $name = $row['noti_from'];
                        $id = $row['noti_entity'];
                        $notifID = $row['notificationID'];
                        $message = $row['noti_msg'];

                        echo "
                            <form method='post' action='viewTicket.php?ticketID=".$id."' class='inline'>
                            <input type='hidden' name='entity_id' value='".$notifID."'>
                            <button type='submit' name='submit_param' value='submit_value' class='link-button'>
                            <div class='notif-div'>".$db->notifImg($name)."<span class='notif-span'><strong>" . $name . "</strong>" . $message . "</span></div>
                            </button>
                            </form>
                        ";
                        break;
                    case 'Admin':
                        $name = $row['noti_from'];
                        $id = $row['noti_entity'];
                        $notifID = $row['notificationID'];
                        $message = $row['noti_msg'];
                        echo "
                            <form method='post' action='viewTicket.php?ticketID=".$id."' class='inline'>
                            <input type='hidden' name='entity_id' value='".$notifID."'>
                            <button type='submit' name='submit_param' value='submit_value' class='link-button'>
                            <div class='notif-div'>".$db->notifImg($name)."<span class='notif-span'><strong>" . $name . "</strong>" . $message . "</span></div>
                            </button>
                            </form>
                        ";
                        break;
                    case 'ticketReopen':
                        $name = $row['noti_from'];
                        $id = $row['noti_entity'];
                        $notifID = $row['notificationID'];
                        $message = $row['noti_msg'];
                        echo "
                            <form method='post' action='viewTicket.php?ticketID=".$id."' class='inline'>
                            <input type='hidden' name='entity_id' value='".$notifID."'>
                            <button type='submit' name='submit_param' value='submit_value' class='link-button'>
                            <div class='notif-div'>".$db->notifImg($name)."<span class='notif-span'><strong>" . $name . "</strong>" . $message . "</span></div>
                            </button>
                            </form>
                        ";
                        break;
                    case 'addDepartment':
                        $name = $row['noti_from'];
                        $id = $row['noti_entity'];
                        $notifID = $row['notificationID'];
                        $message = $row['noti_msg'];
                        echo "
                            <form method='post' action='index.php' class='inline'>
                            <input type='hidden' name='entity_id' value='".$notifID."'>
                            <button type='submit' name='submit_param' value='submit_value' class='link-button'>
                            <div class='notif-div'>".$db->notifImg($name)."<span class='notif-span'><strong>" . $name . "</strong>" . $message . "</span></div>
                            </button>
                            </form>
                        ";
                        break;
                    case 'addAdmin':
                        $name = $row['noti_from'];
                        $id = $row['noti_entity'];
                        $notifID = $row['notificationID'];
                        $message = $row['noti_msg'];
                        echo "
                            <form method='post' action='index.php' class='inline'>
                            <input type='hidden' name='entity_id' value='".$notifID."'>
                            <button type='submit' name='submit_param' value='submit_value' class='link-button'>
                            <div class='notif-div'>".$db->notifImg($name)."<span class='notif-span'><strong>" . $name . "</strong>" . $message . "</span></div>
                            </button>
                            </form>
                        ";
                        break;
                    case 'removeAdmin':
                        $name = $row['noti_from'];
                        $id = $row['noti_entity'];
                        $notifID = $row['notificationID'];
                        $message = $row['noti_msg'];
                        
                        echo "
                            <form method='post' action='index.php' class='inline'>
                            <input type='hidden' name='entity_id' value='".$notifID."'>
                            <button type='submit' name='submit_param' value='submit_value' class='link-button'>
                            <div class='notif-div'>".$db->notifImg($name)."<span class='notif-span'><strong>" . $name . "</strong>" . $message . "</span></div>
                            </button>
                            </form>
                        ";
                        break;
                    case 'assignedTo':
                        $name = $row['noti_from'];
                        $id = $row['noti_entity'];
                        $notifID = $row['notificationID'];
                        $message = $row['noti_msg'];
                        
                        echo "
                            <form method='post' action='viewTicket.php?ticketID=".$id."' class='inline'>
                            <input type='hidden' name='entity_id' value='".$notifID."'>
                            <button type='submit' name='submit_param' value='submit_value' class='link-button'>
                            <div class='notif-div'>".$db->notifImg($name)."<span class='notif-span'><strong>" . $name . "</strong>" . $message . "</span></div>
                            </button>
                            </form>
                        ";
                        break;
                    case 'assignedToUser':
                        $name = $row['noti_from'];
                        $id = $row['noti_entity'];
                        $notifID = $row['notificationID'];
                        $message = $row['noti_msg'];
                        
                        echo "
                            <form method='post' action='viewTicket.php?ticketID=".$id."' class='inline'>
                            <input type='hidden' name='entity_id' value='".$notifID."'>
                            <button type='submit' name='submit_param' value='submit_value' class='link-button'>
                            <div class='notif-div'>".$db->notifImg($name)."<span class='notif-span'><strong>" . $name . "</strong>" . $message . "</span></div>
                            </button>
                            </form>
                        ";
                        break;
                    case 'changePerms':
                        $name = $row['noti_from'];
                        $id = $row['noti_entity'];
                        $notifID = $row['notificationID'];
                        $message = $row['noti_msg'];
                        
                        echo "
                            <form method='post' action='index.php' class='inline'>
                            <input type='hidden' name='entity_id' value='".$notifID."'>
                            <button type='submit' name='submit_param' value='submit_value' class='link-button'>
                            <div class='notif-div'>".$db->notifImg($name)."<span class='notif-span'><strong>" . $name . "</strong>" . $message . "</span></div>
                            </button>
                            </form>
                        ";
                        break;
                    case 'deleteTicket':
                        $name = $row['noti_from'];
                        $id = $row['noti_entity'];
                        $notifID = $row['notificationID'];
                        $message = $row['noti_msg'];
                        
                        echo "
                        <form method='post' action='myTickets.php' class='inline'>
                        <input type='hidden' name='entity_id' value='".$notifID."'>
                        <button type='submit' name='submit_param' value='submit_value' class='link-button'>
                        <div class='notif-div'>".$db->notifImg($name)."<span class='notif-span'><strong>" . $name . "</strong>" . $message . "</span></div>
                        </button>
                        </form>
                    ";
                    break;
                
                    }
                }
            }
        else {
            echo "<h3 style='text-align:center'>You have no active notifications";
        }

    }
    else {
        header("Location: ".$_SERVER['DOCUMENT_ROOT']."/helpdesk/includes/logout.php");
    }
        
       //div class='notif-div'>".$db->notifImg($name)."<span class='notif-span'>" . $message . "</span></div>

$conn->close();
?>