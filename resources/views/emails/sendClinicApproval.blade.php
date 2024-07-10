<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="description">
  <meta content="" name="keywords">
</head>
<body>

  <div style="width: 600px; background: #f2f2f2; margin: 0 auto; font-family: Arial, Helvetica, sans-serif; ">
    <div style="background-color: #edbfac; text-transform: uppercase; border-top: 10px solid #61301f; padding: 0px 0; text-align: center; color: white; font-size: 40px; font-weight: bold;">
     <img src="{{asset('assets/images/logo.png')}}" alt="">
     <br> <span style="font-size: 50px;"></span>
   </div>  
   <div style="font-size: 15px; padding: 15px;">
    <h4 style="color: #61301f;">Dear {{ $details['name'] }},</h4>
    <p>We are pleased to inform you that your registration application has been approved. You can now
    log in to the Petto app using your credentials and start managing your clinic's activities.</p>
    <p>Login here: [Login Link] app’s link will be attached here </p>
    <p>If you have any questions or need assistance, feel free to reach out to our support team. Client’s
    support link will be attached here</p>
    <p>Happy pet parenting!</p>
    <p><b> Best regards,</b></p>
    <p>The Petto Team</p>
    <p><b>Powered by </b></p>
    <p> CodeCore Labs</p>
  </div>
  <div style="background-color: #edbfac; text-transform: uppercase; border-bottom: 3px solid #61301f; padding: 7px 0; text-align: center; color: white; font-size: 40px; font-weight: bold;">
  </div>
</div>
</body>
</html>