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
    <p>We are pleased to inform you that your shipment has been confirmed by our freight forwarder.
    Here are the consignment details:</p>
   
    <p><b> Ticket No: </b> {{$details['ticket_no']}}</p>
    <p><b> Date & Time: </b> {{$details['date_time']}}</p>
    <p><b> Tracking No: </b> {{$details['tracking_no']}}</p>
    <p><b> Flight Service Name: </b> {{$details['flight_service_name']}}</p>

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