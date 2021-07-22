
<?php



   if(isset($_COOKIE['session_cookie'])){
   
    $username = $_COOKIE['session_cookie'];
           
    $servername = "XXXX";
    $susername = "XXXX";
    $password = "XXXX";
    $dbname = "XXXX";

    // $servername = "localhost";
    // $susername = "root";
    // $password = "";
    // $dbname = "helpdesk";
    // Create connection
    $conn = new mysqli($servername, $susername, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 


    $sql = $conn->prepare("SELECT * FROM notifications WHERE noti_to = ? AND readNotification = 'False'");
    $sql->bind_param("s", $username);
    $sql->execute();
    $result = $sql->get_result(); 



    echo $result->num_rows;

$conn->close();
}
?>