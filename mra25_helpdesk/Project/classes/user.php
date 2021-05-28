<?php
    // include_once($_SERVER['DOCUMENT_ROOT'].'/helpdesk/includes/dbConnect.php');
include('functions.php');


    class User{

        private $database = null;
        public $errors = 0;
        public $returnedMessage;

        public function __construct(){ 
            $this->database = new mysqli("localhost", "mra25_newUser", "JkI=4zvo36xz", "mra25_helpDesk");
            // $this->database = new mysqli("localhost", "root", "", "helpdesk");
            
        }
       
        function __destruct() {
            echo nl2br("");
            // echo "Database Closed";
            $this->database->close();
            //Closing the database.
        }


        public function isAdmin(){
            $username = $_SESSION['fUsername'];
            $sql = "SELECT adminLevel FROM users WHERE id = ?";
            if($stmt = $this->database->prepare($sql)){
                $stmt->bind_param("i", $_SESSION['id']);
                $stmt->execute();
                $stmt->bind_result($isAdmin);
                $stmt->fetch();
                $stmt->close();
                return $isAdmin;
            }
        }
    
        

        
        public function register(){
            $getFunction = new Functions();

            $username = htmlspecialchars($_POST['fUsername']);
            $forename = htmlspecialchars($_POST['forename']);
            $surname = htmlspecialchars($_POST['surname']);
            $mobile = htmlspecialchars($_POST['mobile']);
            $email = htmlspecialchars($_POST['fEmail']);
            $password = htmlspecialchars($_POST['fPassword']);
            $confirm = htmlspecialchars($_POST['confirm_password']);
            $adminLevel = 0;

           
            $getFunction->valueChecks($username, "Username", NULL, 255, 4);
            $getFunction->valueChecks($forename, "Forename", "TEXT_ONLY", 255, 1);
            $getFunction->valueChecks($surname, "Surname", "TEXT_ONLY", 255, 1);
            $getFunction->valueChecks($mobile, "Mobile", "NUMBERS_ONLY", 11, 11);
            $getFunction->valueChecks($email, "Email", NULL, 255, 10);
            $getFunction->valueChecks($password, "Password", NULL, 255, 8);
            $getFunction->valueChecks($confirm, "Confirm Password", NULL, 255, 8);

            $this->errors = $getFunction->getErrors();
            $this->returnedMessage = $getFunction->getMessage();

            if(empty($email) || empty($password) || empty($username) || empty($forename) || empty($surname) || empty($confirm)){
                $this->returnedMessage = "Please fill out all required fields";
            }
            else if($confirm != $password){
                $this->returnedMessage = "Please make sure both passwords are the same";
            }

            else if($this->errors === 0){

                $sql = $this->database->prepare("SELECT * FROM users WHERE fEmail = ?");
                $sql->bind_param("s", $email);
                $sql->execute();
                $sql->store_result();

                if($sql->num_rows >= 1) {
                    $this->returnedMessage = "This account already exists";
                }
                else{
                    $sql->fetch();
                    $username = preg_replace('/\s+/', '', $username);
                    $password = password_hash($password, PASSWORD_DEFAULT);       

                    $sql = "INSERT INTO users (first_name, last_name, mobile_number, fUsername, fEmail, fPassword, adminLevel)
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $this->database->prepare($sql);
                    $stmt->bind_param("ssssssi", $forename, $surname, $mobile, $username, $email, $password, $adminLevel);
                    $stmt->execute();

                    $sql = "INSERT INTO user_image (fUsername, picture_status)
                    VALUES (?, 1)";
                    $stmt = $this->database->prepare($sql);
                    $stmt->bind_param("s", $username);
                    $stmt->execute();
                    header("Location: login.php?account=created");
                }
            }    
        }

        
        public function login(){
            $email = trim(htmlspecialchars($_POST['fEmail']));
            $password = trim(htmlspecialchars($_POST['fPassword']));
            if(empty($email) || empty($password)){
                $this->$returnedMessage = "Please fill out all required fields";
            }


            if($this->errors === 0){
                
          
            $sessionName = '';
                $sql = $this->database->prepare("SELECT id, fUsername, fEmail, fPassword FROM users where fEmail=?");
                $sql->bind_param("s", $email);
                $sql->execute();
                $sql->store_result();
                
                if($sql->num_rows == 0){
                    $this->returnedMessage = "Incorrect details";
                    $this->errors ++;
                }
                else {
                    $sql->bind_result($id, $username, $email, $fPassword);
                    $sql->fetch();
                 
                    if(password_verify($password, $fPassword)){             
           
                        $_SESSION['id'] = $id;
                        $_SESSION['fEmail'] = $email;
                        $_SESSION['fUsername'] = $username;
                        $logged_in = $id;
                        header("Location: index.php?logged_in=success");
                        setcookie("session_cookie", $_SESSION['fUsername'], time()+86400); 
                    }
                    else {
                        $this->returnedMessage = "Incorrect details";
                        $this->errors ++;
                    }
                }
            }
        }


        public function updateAccount(){
            // $keys = ['name', 'email', 'current_password', 'new_password', 'new_password_confirm'];
             // $err = array();

             $file = $_FILES['file'];
             $fileTmpName = $file['tmp_name'];
             $fileName = $file['name'];
             $fileSize = $file['size'];
             $fileError = $file['error'];
             $fileType = $file['type'];
            
            $username = $_SESSION['fUsername'];
            $logged_in = $_SESSION['id'];

            $name = htmlspecialchars($_POST['name']);
            $forename = htmlspecialchars($_POST['forename']);
            $surname = htmlspecialchars($_POST['surname']);
            $mobile = htmlspecialchars($_POST['phone']);
            $email = htmlspecialchars($_POST['email']);
            $email_confirm = htmlspecialchars($_POST['email_confirm']);
            $password = htmlspecialchars($_POST['current_password']);
            $password_new = htmlspecialchars($_POST['new_password']);
            $password_new_confirm = htmlspecialchars($_POST['new_password_confirm']);

            $getFunction = new Functions();
            

            if(!empty($name)){
                if($name === $username){
                    $this->returnedMessage = "This is already your active username";
                }
                else {
                    $oldUsername;

                    $sql = "SELECT fUsername FROM users WHERE fUsername = ?";
                    $stmt = $this->database->prepare($sql);
                    $stmt->bind_param("s", $username);
                    $stmt->execute();
                    $result = $stmt->get_result(); 
                    while ($row = $result->fetch_assoc()) {
                        $oldUsername = $row['fUsername'];
                    }

                    $sql = "SELECT fUsername FROM users WHERE fUsername = ?";
                    $stmt = $this->database->prepare($sql);
                    $stmt->bind_param("s", $name);
                    $stmt->execute();
                    $stmt->store_result(); //stores the result to check the rows
                    if($stmt->num_rows > 0){
                        $this->returnedMessage = "Username must be unique";
                        $this->errors++;
                    }
                    else {

                        $getFunction->valueChecks($name, "Username", NULL, 255, 4);
                        $this->errors = $getFunction->getErrors();
                        $this->returnedMessage = $getFunction->getMessage();

                        if($this->errors === 0){
                            $stmt = $this->database->prepare("UPDATE users SET fUsername = ? WHERE id=?");
                            $stmt->bind_param("si", $name, $logged_in);
                            $stmt->execute(); 

                            $_SESSION['fUsername'] = $name;
                            $username = $_SESSION['fUsername'];

                            $stmt = $this->database->prepare("UPDATE tickets SET fUsername = ? WHERE fUsername = ?");
                            $stmt->bind_param("ss", $name, $oldUsername);
                            $stmt->execute(); 
                            
                            $stmt = $this->database->prepare("UPDATE technicians SET fUsername = ? WHERE fUsername = ?");
                            $stmt->bind_param("ss", $name, $oldUsername);
                            $stmt->execute(); 
                            
                            $stmt = $this->database->prepare("UPDATE replies SET fUsername = ? WHERE fUsername = ?");
                            $stmt->bind_param("ss", $name, $oldUsername);
                            $stmt->execute(); 

                            $stmt = $this->database->prepare("UPDATE user_image SET fUsername = ? WHERE fUsername = ?");
                            $stmt->bind_param("ss", $name, $oldUsername);
                            $stmt->execute(); 

                            $oldName = 'profile'.$oldUsername;
                            $exts = array('jpg', 'jpeg', 'png', 'pdf');
                            $newName = 'profile'.$name;
                            foreach($exts as $ext) {
                                if(file_exists("uploads/" . $oldName . "." . $ext)){
                                    $switch = "uploads/" . $oldName . "." . $ext;
                                    $newName = "uploads/" .$newName. "." . $ext;
                                    rename($switch, $newName);
                                }
                            }
                
                            
                            $stmt = $this->database->prepare("UPDATE notifications SET noti_to = ? WHERE noti_to = ?");
                            $stmt->bind_param("ss", $name, $oldUsername);
                            $stmt->execute();

                            $stmt = $this->database->prepare("UPDATE notifications SET noti_from = ? WHERE noti_from = ?");
                            $stmt->bind_param("ss", $name, $oldUsername);
                            $stmt->execute();

                            setcookie("session_cookie", $_SESSION['fUsername'], time()+3600); 

                            header("Location: index.php?updated=success");
                        }


                    }
                }
            }
            
            if(!empty($forename)){
                $getFunction->valueChecks($forename, "Forename", "TEXT_ONLY", 255, 1);
                $this->errors = $getFunction->getErrors();
                $this->returnedMessage = $getFunction->getMessage();

                if($this->errors === 0){
                    $stmt = $this->database->prepare("UPDATE users SET first_name = ? WHERE fUsername = ?");
                    $stmt->bind_param("ss", $forename, $username);
                    $stmt->execute(); 
                }
            }
            if(!empty($surname)){
                $getFunction->valueChecks($surname, "Surname", "TEXT_ONLY", 255, 1);
                $this->errors = $getFunction->getErrors();
                $this->returnedMessage = $getFunction->getMessage();

                if($this->errors === 0){
                    $stmt = $this->database->prepare("UPDATE users SET last_name = ? WHERE fUsername = ?");
                    $stmt->bind_param("ss", $surname, $username);
                    $stmt->execute(); 
                }
            }
            if(!empty($mobile)){
                $getFunction->valueChecks($mobile, "Mobile", "NUMBERS_ONLY", 11, 11);
                $this->errors = $getFunction->getErrors();
                $this->returnedMessage = $getFunction->getMessage();
                if($this->errors === 0){
                    $stmt = $this->database->prepare("UPDATE users SET mobile_number = ? WHERE fUsername = ?");
                    $stmt->bind_param("ss", $mobile, $username);
                    $stmt->execute(); 
                }
            }
            if(!empty($email)){
                if($email != $email_confirm){
                    $this->returnedMessage = "Emails must match";
                    $this->errors++;
                }
                else {
                    $getFunction->valueChecks($email, "Email", NULL, 255, 10);
                    $this->errors = $getFunction->getErrors();
                    $this->returnedMessage = $getFunction->getMessage();
                    if($this->errors === 0){
                        $sql = "SELECT fEmail FROM users WHERE fEmail = ?";
                        $stmt = $this->database->prepare($sql);
                        $stmt->bind_param("s", $email);
                        $stmt->execute();
                        $stmt->store_result(); 
                        if($stmt->num_rows > 0){
                            $this->returnedMessage = "Email must be unique";
                        }
                        else {
                            $stmt = $this->database->prepare("UPDATE users SET fEmail = ? WHERE id=?");
                            $stmt->bind_param("si", $email, $logged_in);
                            $stmt->execute(); 
                        }
                    }
                }
            }
            if(isset($_POST['usergroup'])){
                $department = $_POST['usergroup'];
                if(!empty($department)){
                    $stmt = $this->database->prepare("UPDATE technicians SET userSpeciality = ? WHERE fUsername = ?");
                    $stmt->bind_param("ss", $department, $username);
                    $stmt->execute(); 
                }
            }
            if(!empty($password)){
                if($password_new != $password_new_confirm){
                    $this->returnedMessage = "Emails must be match";
                }
                else if($password === $password_new) {
                    $this->returnedMessage = "Can't have the same previous password!";
                }
                $getFunction->valueChecks($password_new, "Password", NULL, 255, 8);
                $this->errors = $getFunction->getErrors();
                $this->returnedMessage = $getFunction->getMessage();
                if($this->errors === 0){               
                    $sql = $this->database->prepare("SELECT fPassword FROM users where fUsername=?");
                    $sql->bind_param("s", $username);
                    $sql->execute();
                    $sql->store_result();
                    
                    if($sql->num_rows == 0){
                        echo "invalid acc";
                    }
                    else {
                        $sql->bind_result($fPassword);
                        $sql->fetch();
                     
                        if(password_verify($password, $fPassword)){        
                            echo "Password updated";
                            $password_new = password_hash($password_new, PASSWORD_DEFAULT);
                            $stmt = $this->database->prepare("UPDATE users SET fPassword = ? WHERE fUsername=?");
                            $stmt->bind_param("ss", $password_new, $username);
                            $stmt->execute();  
                        }
                        else {
                            $this->returnedMessage = "Password error!";
                        }
                    }
                }
            }
            if(isset($file)){
                if(!empty($file)){
            
                    $fileExt = explode('.', $fileName);
                    $fileActualExt = strtolower(end($fileExt));
                    $allowed = array('jpg', 'jpeg', 'png', 'pdf');

                        if(in_array($fileActualExt, $allowed)){
                            if($fileError === 0){
                                if($fileSize < 1000000){
                                    $fileNameNew = "profile".$username.".".$fileActualExt;
                                    $fileDestination = 'uploads/'.$fileNameNew;
                                    move_uploaded_file($fileTmpName, $fileDestination);

                                    $stmt = $this->database->prepare("UPDATE user_image SET picture_status = 0 WHERE fUsername = ?");
                                    $stmt->bind_param("s", $username);
                                    $stmt->execute();
                                }
                                else {
                                    $this->returnedMessage = "File is too large!";
                                }
                            }
                            else {
                                $this->returnedMessage = "Problem with file";
                            }
                        }
                    }
                }
                if($this->errors === 0){
                    $this->returnedMessage = "Account successfully updated";
                }
                
            }


            
    public function getImg($place){
        $logged_in = $_SESSION['id'];
        $username = $_SESSION['fUsername'];

        $sql = "SELECT * FROM user_image WHERE fUsername = ?";
        $stmt = $this->database->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result(); 
        
        if($place == 'nav-bar'){
            while ($row = $result->fetch_assoc()) {
                if($row['picture_status'] == 0){
                echo "<img id='nav-profile-img' src='uploads/profile".$username.".jpg'>";
                }
                else {
                    echo "<img id='nav-profile-img'  src='uploads/profileDefault.png'>";
                    
                }
            }     
        }
        else if($place == 'user-settings'){
            while ($row = $result->fetch_assoc()) {
                if($row['picture_status'] == 0){
                    echo "<img src='uploads/profile".$username.".jpg'>";
                }
                else {
                    echo "<img src='uploads/profileDefault.png'>";
                    
                }
            }     
        }
    }


    public function showRoles(){
        $sql = "SELECT userSpeciality FROM admin_speciality";
        $stmt = $this->database->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
  
        while ($row = $result->fetch_assoc()) {


            echo "<option value='".$row['userSpeciality']."'>".$row['userSpeciality']."</option>";
        }             
    }


    public function getDashInfo($query){
        $username = $_SESSION['fUsername'];
        
        if($query === "completed"){
            $count = 0;
            $stmt = $this->database->prepare("SELECT * FROM tickets WHERE assignedTo = ? AND ticketStatus = 'Closed' ");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $count++;
            }
            echo $count;      
        }
        else if($query === "active"){
            $count = 0;
            $stmt = $this->database->prepare("SELECT * FROM tickets WHERE assignedTo = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $count++;
            }
            echo $count;  
        }
        else if($query === "admins"){
            $count = 0;
            $stmt = $this->database->prepare("SELECT * FROM technicians");
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $count++;
            }
            echo $count;  
        }
    }

    
    public function getDetails(){
        $username = $_SESSION['fUsername'];
        $sql = "SELECT fUsername, first_name, last_name, fEmail, mobile_number FROM users WHERE fUsername = ?";
        $stmt = $this->database->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $functions = new Functions();
  
        while ($row = $result->fetch_assoc()) {
                 
            echo "
                    <hr>
                    <h4 class='form-header'>Personal Information</h4>
                    <hr>
                    <p><strong>Forename:</strong> ".$row['first_name']."</p>
                    <p><strong>Surname:</strong> ".$row['last_name']."</p>
                    <p><strong>Username:</strong> ".$row['fUsername']."</p>
                    <p><strong>Mobile:</strong> ".$functions->hidePhone($row['mobile_number'])."</p>
                    <p><strong>Email:</strong> ".$functions->hideEmail($row['fEmail'])."</p>";
                    if($this->isAdmin() >= 1){
                        $sql = "SELECT userSpeciality FROM technicians WHERE fUsername = ?";
                        $stmt = $this->database->prepare($sql);
                        $stmt->bind_param("s", $username);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while ($row = $result->fetch_assoc()) {
                            echo "<p><strong>Admin Role:</strong> ".$row['userSpeciality']."</p>";
                        }
                    }
           
               
        }

    }

    public function displayFAQ(){
        $sql = "SELECT * FROM faq_table";
        $stmt = $this->database->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows == 0){
            echo "<h3 style='text-align:center'>There are no questions available. Please check back later</h2>";
        }

        while ($row = $result->fetch_assoc()) {
            echo "<li>
            <button type='button' class='accordion'>".$row['faq_topic']."</button>
                    <div class='faq-panel'>
                        <p class='faq-username'>Added by: ".$row['fUsername']."</p>
                        <p class='faq-p'><b>Q: ".$row['faq_question']."</b></p>
                        <p class='faq-p'>A: ".$row['faq_answer']."</p>
                    </div>
            
                </li>";
        }      
    }
    


    //ADMIN PERMS
    public function adminPermissions($target) {
        $username = $_SESSION['fUsername'];
        if($target === 'delete'){
            $sql = "SELECT can_delete FROM technicians WHERE fUsername = ?";
            $stmt = $this->database->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->bind_result($deletePerms);
            $stmt->fetch();
            $stmt->close();
            return $deletePerms;
        }
        else if($target === 'modify'){
            $sql = "SELECT can_modify FROM technicians WHERE fUsername = ?";
            $stmt = $this->database->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->bind_result($modifyPerms);
            $stmt->fetch();
            $stmt->close();
            return $modifyPerms;
        }

    }


    //ADMIN PERMS

        

        

    }// END CLASs


?>