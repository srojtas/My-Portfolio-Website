<?php
session_start();
if($_SESSION){
    if($_SESSION["username"] == ""){
    header( "Location: http://sascha.rojtas.com/classProjects/hw7/login.php"); // Checks for login. If not, redirects to login.
        exit();
    }
} else {
    header( "Location: http://sascha.rojtas.com/classProjects/hw7/login.php"); // Same as above.
    exit();
}
    if($_POST) {
        if($_GET) {
            include "dbconn.php";
            $threadTitle = mysqli_real_escape_string($dbconnect,$_POST['threadTitle']); // Sanitize
            $threadDescription = mysqli_real_escape_string($dbconnect,$_POST['threadDescription']); // Sanitize
            $catID = mysqli_real_escape_string($dbconnect,$_GET['catID']); // Sanitize
            $todayDate = date('Y-m-d');
            $newThread = "INSERT INTO `hw7Threads` (`threadTitle`, `desc`, `date`, `userID_FK`, `catID_FK`) VALUES ('";
            $newThread .= $threadTitle;
            $newThread .= "', '";
            $newThread .= $threadDescription;
            $newThread .= "', '";
            $newThread .= $todayDate;
            $newThread .= "', '{$_SESSION["userID"]}', '";
            $newThread .= $catID;
            $newThread .= "');";
            mysqli_query($dbconnect,$newThread);
            $getThreadID = "SELECT threadID FROM hw7Threads WHERE `desc` = '{$_POST['threadDescription']}';";
            $getThreadIDStep2 = mysqli_query($dbconnect,$getThreadID); // SQL Query to create a new thread
            $result = mysqli_fetch_assoc($getThreadIDStep2);
            $firstReply = "INSERT INTO `hw7Replies` (`comment`, `date`, `userID_FK`, `threadID_FK`) VALUES ('";
            $userPost = mysqli_real_escape_string($dbconnect,$_POST['userPost']); // Sanitize
            $firstReply .= $userPost;
            $firstReply .= "', '";
            $firstReply .= $todayDate;
            $firstReply .= "', '{$_SESSION["userID"]}', '";
            $firstReply .= $result["threadID"];
            $firstReply .= "');";
            mysqli_query($dbconnect,$firstReply); // SQL Query to insert the first reply
            header( "Location: http://sascha.rojtas.com/classProjects/hw7/viewThread.php?id={$result["threadID"]}");
            exit();
        } else {
            header( "Location: http://sascha.rojtas.com/classProjects/hw7/categories.php");
            exit();
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forum -- New Thread</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
    
<body>

    <header>
        <h1>New Thread<?php if($_SESSION) echo " -- Logged in as ".$_SESSION["username"]; // Shows user that is logged in if any?></h1>
    </header>
    
    <div class="mainContent">
        <form method="post" action ="newThread.php?catID=<?php echo $_GET["catID"];?>" class="newThread">
        <p>
            <label for="threadTitle">Thread Title</label>
            <input name="threadTitle" type="text" required>
        </p>
        <p>
            <label for="threadDescription">Thread Description</label> <!-- HTML Table to create a new thread -->
            <input name="threadDescription" type="text" required>
        </p>
        <p>
            <label for="userPost">Enter Text to Post</label>
            <textarea name="userPost" cols="100" rows="6" required></textarea>
        </p>
        <p>
            <input type="submit" name="submit" value="Create Thread">
        </p>
        </form>
        <p><a href="categories.php">Back to Categories</a></p>
        <p><?php if($_SESSION) echo "<p><a href='logout.php'>Log out</a></p>"; else echo "<p><a href='login.php'>Log in</a></p>";?>  <!-- Checks for login. If so, offers option to log out. If not, offers option to log in. --></p>
    </div>
</body>
</html>