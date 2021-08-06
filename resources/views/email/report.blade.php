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
                color: #f37934 !important;
            }
            .orange-background{
                background: #f37934 !important;
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
        </style>


    </head>
    <body>

        <div class="container">
            <div class="col-md-12">
                <div class="panel panel-default">
                  <div class="panel-heading orange-background text-center" style="border-radius: 10px 10px 0px 0px;"><h3>Download Report for {{$report_number}}</h3></div>
                  <div class="panel-body">
                    This message is automatically generated.<br><br>

                    Please click the link below to download the report.<br><br>

                    <a href="{{ env('APP_URL') . '/loadingreport/' . $report_number }}" class="orange-text">Download Report </a> || <a href="{{ env('APP_URL') . '/downloadzip/' . $report_number }}" class="orange-text">Download Images </a><br><br>
                  
                    Thanks and Best Regards,<br><br><br>


                    <span class="signature">{{$inspector_name}}</span><br>                    
                  </div>
                </div>
            </div>
        </div>
    </body>
</html>