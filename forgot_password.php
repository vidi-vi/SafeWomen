<?php
    $template=1;
    $status = 0;
    $email = '';
    $question='';
    $answer = '';
    if(isset($_POST['submit'])){
        $email = $_POST['email'];
        require_once 'db/db_settings.php';
        $db = @mysqli_connect($server,$user,$password,$database) or die('We are having some error with the Server.Please try later');
        $query = "select * from users where email='$email'";
        $result = mysqli_query($db, $query);
        if(mysqli_num_rows($result)==1){
            $row = mysqli_fetch_array($result);
            $question = $row['question'];
            $template = 2;
        }else{
            $status = 1;
        }
    }
    if(isset($_POST['ans'])){
        $email = $_POST['email'];
        $question = $_POST['question'];
        $answer = $_POST['answer'];
        require_once 'db/db_settings.php';
        $db = @mysqli_connect($server,$user,$password,$database) or die('We are having some error with the Server.Please try later');
        $query = "select answer from users where email='$email'";
        $result = mysqli_query($db, $query);
        $row = mysqli_fetch_array($result);
        echo $answer.' '.$row['answer'];
        if($answer == $row['answer']){ 
                $str = str_shuffle("Dat34%$");
                $passwd = sha1($str);
                $query = "update users set password='$passwd' where email='$email'";
                mysqli_query($db, $query);
                require_once('includes/class.phpmailer.php');
                $mail = new PHPMailer();
                $mail->IsSMTP();
                $mail->CharSet="UTF-8";
                $mail->SMTPSecure = 'tls';
                $mail->Host = 'smtp.gmail.com';
                $mail->Port = 587;
                $mail->Username = 'vidishasethi55@gmail.com';
                $mail->Password = '24061999';
                $mail->SMTPAuth = true;

                $mail->From = 'vidishasethi55@gmail.com';
                $mail->FromName = 'Women Safe';
                $mail->AddAddress($email);

                $mail->IsHTML(true);
                $mail->Subject    = "Password Reset";
                $mail->Body    = 'Your new password is '.$str;

                if(!$mail->Send())
                {
                  echo "Mailer Error: " . $mail->ErrorInfo;
                }            
            $template = 3;
        }else{
            $status = 2;
            $template = 2;
        }
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
       
        <title>Safe Women</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/css/main.css" />

    </head>
    <body>
        <?php require_once 'header.php'; ?>
        <?php require_once 'menu.php'; ?>
        <div id="content">
            <br>
            <br>
             <br>
            <br>
            <h2>Forgot Password</h2>
            <?php if($template==1) { ?>
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                    Email ID :
                    <input type="text" name="email" value="" />
                    <input type="submit" value="Submit" name="submit" />
                </form>
                <?php if($status==1) { ?>
                <h3 style="color:red">This Email ID is not registered</h3>
                <?php } ?>    
            <?php } ?>    
            <?php if($template==2) { ?>
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                    <table>
                            <tbody>
                                <tr>
                                    <td>Email ID : </td>
                                    <td><input type="text" name="email" readonly value="<?php echo $email;?>" /></td>
                                </tr>
                                <tr>
                                    <td>Question : </td>
                                    <td><input type="text" name="question" readonly value="<?php echo $question;?>" /></td>
                                </tr>
                                <tr>
                                    <td>Answer</td>
                                    <td><input type="text" name="answer" /></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="center">
                                        <input type="submit" value="Submit Answer" name="ans" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                </form>
                <?php if($status==2) { ?>
                <h3 style="color:red">The answer is Incorrect</h3>
                <?php } ?>    
            <?php } ?>  
            <?php if($template==3) { ?>
                Please check your email.
            <?php } ?> 
        </div>
        <?php require_once 'footer.php'; ?>
    </body>
</html>
