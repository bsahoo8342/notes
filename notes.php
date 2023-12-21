<?php

session_start();
if (!isset($_SESSION["login"]) && $_SESSION["login"] != true) {
    header("location: index.php");
    exit();
}
include("dbcon.php");
$email = $_SESSION['username'];

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if ($_GET['id'] != NULL) {
        $id = $_GET['id'];
        $qu = "SELECT * FROM `list` WHERE `slno` = '$id'";
        $res = mysqli_query($con, $qu);

        if ($row = mysqli_fetch_assoc($res)) {
            $title = $row['title'];
            $fnm = $row['filenm'];
        }

        require_once 'Swiftmailer/vendor/autoload.php';

        // Create the Transport
         $transport = (new Swift_SmtpTransport('<YOUR_SMTP_SERVER_ADD>', <PORT_NO>, '<TYPE>'))
         ->setUsername('<USER_MAIL_ADD>')
         ->setPassword('<PASSWORD>')
        ;

        // Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);


        // Create a message
        $message = (new Swift_Message('<SUBJECT>'))
        ->setFrom(['<USER_MAIL_ADD>' => '<USER_NAME>'])
        ->setTo(['<RECEIVER_MAIL_ADD>'])
        ->setBody('<MESSAGE_BODY>')
            // Optionally add any attachments
            ->attach(Swift_Attachment::fromPath(<PATH>, '<FILE_TYPE>'))
        ;

        // Send the message
        $result = $mailer->send($message);
        if($result){
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Mail sent Successfully!</strong> Notes sent to your mail address.
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div><br>
            ";

        }else{
             echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
             <strong>Mail not sent!</strong> Contact with Admin.
             <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
           </div><br>";
        }
    }
}
if(isset($_SESSION["username"]))
{
	if(time()-$_SESSION["login_time_stamp"] > 600) //session will active for 10 minutes
	{
		session_unset();
		session_destroy();
		header("Location:index.php");
        exit;
	}
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <!-- Style CSS -->
   <link rel="stylesheet" href="./css/style.css">
   <!-- Demo CSS (No need to include it into your project) -->
   <link rel="stylesheet" href="./css/demo.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
        <!-- SCRIPT FOR DATE & TIME -->
        <script src="./js/script.js"></script>

</head>

<style>
    .anchor{
        text-decoration: none;
    }
    .warn{
        color:red;
    }
</style>

 <main class="cd__main">

      <body onload="startTime()">
         <div id="clockdate">
            <div class="clockdate-wrapper">
               <div id="clock"></div>
               <div id="date"></div>
            </div>
         </div>
      </body>
      </main>

<body>
    
    <div class="container text-center">
        <h1><u>Files </u></h1>
        <h2 class="warn"><p id="demo"></p></h2>
        <table class="table table-borderless">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Titile</th>
                    <th scope="col">Size</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <?php
            //Get Data From Database
            $get = "SELECT * FROM `list`";
            $res = $con->query($get);

            foreach ($res as $row) {
                ?>
                <tbody>
                    <tr>
                        <th scope="row">
                            <?php echo $row['slno']; ?>
                        </th>
                        <td>
                            <?php echo $row['title']; ?>
                        </td>
                        <td>
                            <?php echo $row['size']. "MB"; ?>
                        </td>
                        <form action="" method="post">
                            <td>
                                <button type="submit" name="send" id="send" onclick="show()" class="btn btn-outline-info"><a
                                      class="anchor"  href="?id=<?php echo $row['slno']; ?>">Send me</a></button>
                                      
                            </td>
                        </form>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    
    <script>
function show() {
  document.getElementById("demo").innerHTML = "Wait for few minutes sending....";
}
</script>

</body>

</html>