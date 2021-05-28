<?php 
// <h1>INDEX</h1>";
    switch($currentPage) {
        case 'Dashboard':
            echo "
            <link rel='stylesheet' href='css/form.css'>
            <script src='javascript/main.js'></script>";
            
            break;
        case 'profilePage':
            echo "<h1>Profile</h1>";
            break;
        case 'accountSettings':
            echo "
            <link rel='stylesheet' href='css/form.css'>
            
            ";
            
            break;
        case 'createTicket':
            echo "
            <link rel='stylesheet' href='css/myTickets.css'>
            <link rel='stylesheet' href='css/form.css'>";
            break;
        case 'Management':
            echo "
            <link rel='stylesheet' href='css/myTickets.css'>
            <link rel='stylesheet' href='css/form.css'>
            <link rel='stylesheet' href='css/manage.css'>";
            break;
        case 'Admin Dashboard':
                echo "
                <link rel='stylesheet' href='css/myTickets.css'>
                <link rel='stylesheet' href='css/form.css'>
                <script src='javascript/adminPanel.js'></script>";
                break;
        case 'My Tickets':
            echo "<link rel='stylesheet' href='css/myTickets.css'>
            <script src='javascript/myTickets.js'></script>
            <link rel='stylesheet' href='css/form.css'>";
            break;
        case 'View Ticket':
            echo "<link rel='stylesheet' href='css/myTickets.css'>
            <script src='javascript/viewTicket.js'></script>
            <link rel='stylesheet' href='css/form.css'>";
            break;
        case 'FAQ':
                echo "
                <link rel='stylesheet' href='css/form.css'>
                <script src='javascript/faq.js'></script>";
                break;
        case 'Login':
            echo "<link rel='stylesheet' href='css/form.css'>
            <script src='javascript/login.js'></script>";
            break;
        case 'Register':
            echo "<link rel='stylesheet' href='css/form.css'>
            <script src='javascript/register.js'></script>";
            break;
    }
?>