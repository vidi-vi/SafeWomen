<?php
    $template=1;
    $email = '';
    $name = '';
    $passwd = '';
    $confirm_passwd = '';
    $question = '';
    $answer = '';
    $errors = array();
    if(isset($_POST['submit'])){
        $email = trim($_POST['email']);
        $passwd = trim($_POST['passwd']);
        $confirm_passwd = trim($_POST['confirm_passwd']);
        $name = trim($_POST['name']);
        $question = trim($_POST['question']);       
        $answer = trim($_POST['answer']);
        
        //Level 1 - All the required values are entered
        
        if($email==''){
            $errors['email'] = 'The email ID can not be empty';
        }
        if($passwd==''){
            $errors['passwd'] = 'The Password can not be empty';
        }
        if($confirm_passwd==''){
            $errors['confirm_passwd'] = 'The Confirm Password can not be empty';
        }
        if($name==''){
            $errors['name'] = 'The Name can not be empty';
        }
        if($question==''){
            $errors['question'] = 'The Question can not be empty';
        }
        if($answer==''){
            $errors['answer'] = 'The Answer can not be empty';
        }
        
        //Level 2 - All the values are valid
        
        if(count($errors)==0){
            if(!preg_match('/\w+@\w+[.]\w+/', $email)){
                $errors['email'] = 'The email ID is not Valid';
            }
            if(strlen($passwd)<7){
                $errors['passwd'] = 'The Password is too short';
            }
            if($passwd!=$confirm_passwd){
                $errors['confirm_passwd'] = 'The Passwords do not match';
            }
            if(!preg_match('/^[A-Za-z]+(\s[A-Za-z]+)*$/', $name)){
                $errors['name'] = 'The Name has some Invalid Characters';
            }
        }
        
        //Level 3 - Primary Key Match
        
        if(count($errors)==0){
            require_once 'db/db_settings.php';
            $db = @mysqli_connect($server,$user,$password,$database) or die('We are having some error with the Server.Please try later');
            $query = "select * from users where email='$email'";
            $result = mysqli_query($db, $query);
            if(mysqli_num_rows($result)==1){
                $errors['email'] = 'The email ID is already registered';
            }
        }
        
        //To start the registration process
        
        if(count($errors)==0){
            $passwd = sha1($passwd);
            require_once 'db/db_settings.php';
            $db = @mysqli_connect($server,$user,$password,$database) or die('We are having some error with the Server.Please try later');
            $query = "insert into users(email,password,role,name,question,answer,active) values('$email','$passwd','member','$name','$question','$answer',0)";
            if(mysqli_query($db, $query)){
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
                $mail->FromName = 'Safe Women';
                $mail->AddAddress($email);

                $mail->IsHTML(true);
                $mail->Subject    = "Registration Successful";
                $mail->Body    = 'Your registration is complete. Please click  <a href="http://localhost/Safewoman/login.php">here</a> to login to your account and begin your journey into a safe world! ';

                if(!$mail->Send())
                {
                  echo "Mailer Error: " . $mail->ErrorInfo;
                }
                $template = 2;
            }
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
       
		<title>Safe Women</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/css/main.css" />
	
    </head>
    <body >
         <?php require_once 'header.php'; ?>
        <?php require_once 'menu.php'; ?>
        <div id="content">
            <?php if($template==1) { ?>
            <br>
            <br>
            <br>
            <br>
       
            <h2 align="center">Regitration Page</h2>
            <form action="register.php" method="POST">
                <table class="center"  >
                    <tbody align="center">
                        <tr>
                            <td>Email Id : </td>
                            <td>
                                <input type="text" name="email" value="<?php echo $email;?>" />*
                                <?php if(isset($errors['email'])){ ?>
                                &nbsp;&nbsp;&nbsp;<span class="error"><?php echo $errors['email'];?></span>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Password : </td>
                            <td>
                                <input type="password" name="passwd" value="<?php echo $passwd;?>" />*
                                <?php if(isset($errors['passwd'])){ ?>
                                &nbsp;&nbsp;&nbsp;<span class="error"><?php echo $errors['passwd'];?></span>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Confirm Password : </td>
                            <td>
                                <input type="password" name="confirm_passwd" value="<?php echo $confirm_passwd;?>" />*
                                <?php if(isset($errors['confirm_passwd'])){ ?>
                                &nbsp;&nbsp;&nbsp;<span class="error"><?php echo $errors['confirm_passwd'];?></span>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Name : </td>
                            <td>
                                <input type="text" name="name" value="<?php echo $name;?>" />*
                                <?php if(isset($errors['name'])){ ?>
                                &nbsp;&nbsp;&nbsp;<span class="error"><?php echo $errors['name'];?></span>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Question : </td>
                            <td>
                                <input type="text" name="question" value="<?php echo $question;?>" />*
                                <?php if(isset($errors['question'])){ ?>
                                &nbsp;&nbsp;&nbsp;<span class="error"><?php echo $errors['question'];?></span>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Answer: </td>
                            <td>
                                <input type="text" name="answer" value="<?php echo $answer;?>" />*
                                <?php if(isset($errors['answer'])){ ?>
                                &nbsp;&nbsp;&nbsp;<span class="error"><?php echo $errors['answer'];?></span>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="center">
                                <input type="submit" value="Register" name="submit" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
            <?php } ?>
            <?php if($template==2) { ?>
            <h2>Registration Complete</h2>
            <h3>An email has been sent to your email id <?php echo $email;?></h3>
            <p>Please click the verification link in your email to activate your login.</p>
            <a href="login.php">Login</a>
            <?php } ?>
        </div>
        <?php require_once 'footer.php'; ?>
    </body>
</html>

