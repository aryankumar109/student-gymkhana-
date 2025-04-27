<?php

$to_email="5121aryan.5121@gmail.com";
$subject ="simple email test via php";
$body ="hi , 2nd attemp";
$headers= "From : 9176aryankumar@gmail.com" ;

if (mail($to_email ,$subject , $body , $headers)){
    echo "Email successfully sent to $to_email .." ;

}else {
    echo "Email sending failed ...";
}

?>

