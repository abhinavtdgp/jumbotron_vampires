<?php include 'dbconfig.php';?>
<?php
 
  require './PHPMailer_5.2.4/PHPMailer_5.2.4/class.phpmailer.php';
  ob_start();
  $p_name=$_GET['name'];
  $p_company=$_GET['company'];
  $p_price=$_GET['marketprice'];
  $p_status="Originated";
  $timestamp=date('Y-m-d h:i:sa');
  $p_seller=$_GET['seller'];
  $p_deliveryperson = $_GET['deliveryperson'];
  $p_customer=$_GET['username'];
  $p_customeremail=$_GET['customer_email'];
  
   
   
echo $p_customer;

  try {
    $conn = new PDO("mysql:host={$dbHost};dbname={$dbname}",$dbUser,$dbPass);
    $sql="INSERT INTO new_order (name,company,status,price,customer,customer_email,seller,delivery_person,timestamp) VALUES(:name,:company,:status,:price,:customer,:customer_email,:seller,:delivery_person,:timestamp);";
    $query= $conn->prepare($sql);
    $result=$query->execute(array(
                                ":name"=>$p_name,
                                ":company"=>$p_company,
                                ":status"=>$p_status,
                                ":price"=>$p_price,
                                ":customer"=>$p_customer,
                                ":customer_email"=>$p_customeremail,
                                ":seller"=>$p_seller,
                                ":delivery_person"=>$p_deliveryperson,
                                ":timestamp"=>$timestamp
                              ));
   if($result){
     echo "Successfully added the data";
     $mail = new PHPMailer;
     $mail->IsSMTP();
      $mail->SMTPDebug = 1;
      $mail->SMTPAuth = true;                                   // Set mailer to use SMTP
      $mail->SMTPSecure = 'tsl';                            // Enable encryption, 'ssl' also accepted
      $mail->Host = 'localhost';  // Specify main and backup server
      //$mail->Port=465;
      $mail->IsHTML(true);                              // Enable SMTP authentication
      $mail->Username = 'esamaadhaan@manojpusa.club';                            // SMTP username
      $mail->Password = 'Lmurugan@123';                           // SMTP password
      $mail->SetFrom = 'esamaadhaan@manojpusa.club';
      $mail->Subject = 'New User has been created';
      $mail->Body    =     '<p>
                                  Hi ' .$p_customer. ',</p>
                              <p>
                                  The request for a product with name '. $p_name .' has been created
                              </p>
                              <p>
                                  Thanks for ordering
                              </p>
                              <p>
                                  Regards,<br>
                                  A_Kart Team<br>
                                  Bangalore India<br>
                              </p>';
        $mail->AddAddress($customer_email );               // Name is optional

      if(!$mail->Send()) {
         echo 'Message could not be sent.';
         echo 'Mailer Error: ' . $mail->ErrorInfo;
         exit;
      }
   }
  else{
     echo "Data not added successfully";
   }
  } catch (Exception $e) {
     echo $e->getMessage();
    //header("Location:./login.php?message=DbNotConnected");
    echo "DBNotConnected";
  }
?>