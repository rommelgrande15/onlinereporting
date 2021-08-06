<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
        <style type="text/css">
            body{
                font-family: Arial;
            }
            a{
                text-decoration: none;
            }
            .orange-text{
                color: #3cb5d0 !important;
            }
            .orange-background{
                background: #3cb5d0 !important;
                color: #fff !important;
                padding: 1px 25px;
                border:1px solid #d5d5d5;

            }
            .tic-logo{
                margin-bottom: 25px;
            }
            .img-logo{
                max-width: 400px;
                margin:auto;
            }
            .signature{
                font-weight: bold;
            }
            .signature-logo{
                max-width: 250px;
            }
            .text-center{
                text-align:center;
            }
            .link-btn{
                padding: 10px;
                background: #3cb5d0;
                color: #fff !important;
                text-decoration: none;
                border-radius: 5px;
                border:1px solid #3cb5d0;
            }
            .panel-body{
                border:1px solid #d5d5d5;
                padding: 25px;
            }
            .label{
                font-weight: bold;
            }
            table {
                border-collapse: collapse;
                width: 800px;
            }
        </style>


    </head>
    <body>

        <div class="container">
            <div class="col-md-12">
                <div class="panel panel-default">
                  <div class="panel-heading orange-background text-center" style="border-radius: 10px 10px 0px 0px;"><h3>Inspection Booking Details</h3></div>
                  <div class="panel-body">
                    <div class="text-center tic-logo">
                        <img src="https://s17.postimg.org/ptievyh1b/tic.png" class="img-logo">
                    </div>
                    <h3>Hello {{$full_name}},</h3>

                    Thank you for using our booking system. Please check the summary of booking below<br><br>

                    <table border>
                        <tr>
                            <td class="label">Project Reference Number</td>
                            <td>{{$booking->reference_number}}</td>
                        </tr>
                        <tr>
                            <td class="label">Inspection Service</td>
                            <td>{{$service}}</td>
                        </tr>
                        <tr>
                            <td class="label">Desired Inspection Date</td>
                            <td>{{$booking->inspection_date}}</td>
                        </tr>
                        <tr>
                            <td class="label">Expected Shipment Date</td>
                            <td>{{$booking->shipment_date}}</td>
                        </tr>
                        <tr>
                            <td class="label">Factory Name</td>
                            <td>{{$factory->factory_name}}</td>
                        </tr>
                        <tr>
                            <td class="label">Factory Address</td>
                            <td>{{$factory->factory_name}}</td>
                        </tr>
                        <tr>
                            <td class="label">Contact Person</td>
                            <td>{{$factory->factory_contact_person}}</td>
                        </tr>
                        <tr>
                            <td class="label">Contact Number</td>
                            <td>{{$factory->factory_contact_number}}</td>
                        </tr>
                        <tr>
                            <td class="label">Man/Day</td>
                            <td>{{$booking->manday}}</td>
                        </tr>
                    </table>
                    <br>
                    You can click the button below to view/download your booking sheet.<br><br>

                    <a href="{{ URL::to('pdf/' . $booking->id) }}" class="link-btn">Click Here to Download Your Booking Sheet </a> <br><br>

                    Should you have any questions, you can reach us at booking@inspect.one<br><br>

                    We look forward to give you the best services we could provide.<br><br><br>
                  
                    Thanks and Best Regards,<br><br><br>


                    <span class="signature">InspectOne | Asia E-Commerce Ltd.</span><br>
                    <img src="https://s17.postimg.org/ptievyh1b/tic.png" class="signature-logo"><br>
                    <span class="signature">The Innovation Centre</span><br>
                    <span class="signature">EXETER|EX4 4RN</span><br>
                    <span class="signature">United Kingdom</span><br>
                    <span class="signature"><i class="fa fa-mobile"></i> Tel No.:</span> +44(0)1392 580015<br>
                    <span class="signature"><i class="fa fa-mobile"></i> Website:</span> http://inspect.one<br>
                    <span class="signature"><i class="fa fa-phone"></i> Email:</span> sales@inspect.one<br>
                    
                  </div>
                </div>
            </div>
        </div>
    </body>
</html>