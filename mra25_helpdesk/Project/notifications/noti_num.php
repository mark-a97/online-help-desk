
<?php



   if(isset($_COOKIE['session_cookie'])){
   
    $username = $_COOKIE['session_cookie'];
           
    $servername = "localhost";
    $susername = "mra25_newUser";
    $password = "JkI=4zvo36xz";
    $dbname = "mra25_helpDesk";

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