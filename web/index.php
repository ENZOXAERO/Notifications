<?php

$str = '';
$color = "#98bf40";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $token = $_POST["token"];
    $title = $_POST["title"];
    $message = $_POST["message"];

    $token = htmlspecialchars($token,ENT_COMPAT);
    $title = htmlspecialchars($title,ENT_COMPAT);
    $message = htmlspecialchars($message,ENT_COMPAT);

    $data = array(
        "to" => "$token",
        "notification" => array(
            "title" => $title,
            "body" => $message,
            "icon" => "https://example.com/icon.png",
            )
    );

    $data_string = json_encode($data);
    $headers = array(
        'Authorization: key=AAAA_19C80A:APA91bGzYr9CboI9Jl6zJLWS4N8vYC1D5Ujg2EZS4AjRMLGYsJu9nsesosFgLzhwY0r8gI8Yevz_oXwS-fr-CW0OJYZ5W2Udl1_pCvB89w8oxymkr_04inbZ45nml3hj6_72fMPoTvqz',
        'Content-Type: application/json'
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/fcm/send");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch,CURLOPT_HTTPHEADER, $headers );
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true );
    curl_setopt($ch,CURLOPT_POSTFIELDS, $data_string);

    $result = curl_exec($ch);
    $response = json_decode($result, true);

    if($response['success'] == 1){
        $str = "Message has sent successfully";
    }else{
        $str = "An error has been occurred to send message";
        $color = "red";
    }
    curl_close ($ch);

}
?>

<h3 style="color:#8c8c8c; padding-top: 100px;" align="center"> Sent Message Notification</h3>
<hr>


<div style="padding-left: 150px; padding-right: 150px">
    <form method="post">
        <label for="token">Insert token to sent notification</label><br>
        <input type="text" name="token" id="token" style="width: 50%" required/>
        <br>
        <label for="title">Title of message</label><br>
        <input type="text" name="title" id="title" style="width: 50%" required/>
        <br>
        <label for="message">Message</label><br>
        <textarea rows="2" name="message" id="message" style="width: 50%" required></textarea>

        <br><br>
        <button type="submit" name="btnSent">Sent Message</button>

        <br><br>
        <label style="color:<?php echo $color; ?>"><?php echo $str; ?></label>
    </form>
</div>




