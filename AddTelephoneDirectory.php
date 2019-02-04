<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <meta charset="utf-8">
        <title>Database Entry</title>
    </head>
    <body>

        <?php
        // if statement to enforce valid data entry
        if (empty($_POST['first_name']) || empty($_POST['last_name']) ||
                empty($_POST['address']) || empty($_POST['city']) ||
                empty($_POST['state']) || empty($_POST['zip']) ||
                empty($_POST['phone']) || !is_numeric($_POST['zip'])||
                !is_numeric($_POST['phone']))
            echo "<p>All entry must be filled out and numeric values for zip field and phone field.</p>";


        else {
            $DBConnect = mysqli_connect("localhost", "root", "root");
            if ($DBConnect === FALSE)
                echo "<p>Unable to connect to the database server.</p>"
                . "<p>Error code " . mysqli_errno()
                . ": " . mysqli_error() . "</p>";

            else {
                $DBName = "phone_directory";
                if (!mysqli_select_db($DBConnect, $DBName)) {
                    $SQLstring = "CREATE DATABASE $DBName";
                    $QueryResult = mysqli_query($DBConnect, $SQLstring);
                    if ($QueryResult === FALSE)
                        echo "<p>Unable to execute the query.</p>"
                        . "<p>Error code " . mysqli_errno($DBConnect)
                        . ": " . mysqli_error($DBConnect) . "</p>";
                } // if statement for creating the database if the database don't already exist

                mysqli_select_db($DBConnect, $DBName);

                $TableName = "phone_entries";
                $SQLstring = "SHOW TABLES LIKE '$TableName'";
                $QueryResult = mysqli_query($DBConnect, $SQLstring);
                if (mysqli_num_rows($QueryResult) == 0) {
                    $SQLstring = "CREATE TABLE $TableName (countID SMALLINT
                            NOT NULL AUTO_INCREMENT PRIMARY KEY, last_name VARCHAR(40), first_name VARCHAR(40), 
                            address VARCHAR(40), city VARCHAR(15), state VARCHAR(10), zip VARCHAR(20), phone_number BIGINT)";
                    $QueryResult = mysqli_query($DBConnect, $SQLstring);
                    if ($QueryResult === FALSE)
                        echo "<p>Unable to create the table.</p>"
                        . "<p>Error code " . mysqli_errno($DBConnect)
                        . ": " . mysqli_error($DBConnect) .
                        "</p>";
                } // if statement for creating the database table

                $LastName = stripslashes($_POST['last_name']);
                $FirstName = stripslashes($_POST['first_name']);
                $Address = stripslashes($_POST['address']);
                $City = stripslashes($_POST['city']);
                $State = stripslashes($_POST['state']);
                $Zip = stripslashes($_POST['zip']);
                $Phone = stripslashes($_POST['phone']);
                
                $SQLstring = "INSERT INTO $TableName VALUES(NULL, '$LastName', '$FirstName', '$Address', '$City', '$State', '$Zip', '$Phone')";
                $QueryResult = mysqli_query($DBConnect, $SQLstring);
                if ($QueryResult === FALSE)
                    echo "<p>Unable to execute the query.</p>"
                    . "<p>Error code " . mysqli_errno($DBConnect)
                    . ": " . mysqli_error($DBConnect) . "</p>";
                else
                    echo "<h1>Your entry has been added to the database.</h1>";
            } // end of  else statement for database creation only if the the database connection is successful
            
            mysqli_close($DBConnect);
        } // end of else statement for database connection only if the data entry is valid
        ?>

    </body>
</html>