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
                  <div class="panel-heading orange-background text-center" style="border-radius: 10px 10px 0px 0px;"></div>
                  <div class="panel-body">
                    <table style="width: 60%; margin: auto; border-collapse: collapse; border: 0; font-family: arial;">
                        <tr style="background:#ffa500; height: 100px;">
                            <td width="30%" style="text-align: center; vertical-align: middle;"><img src="http://www.the-inspection-company.com/htm_files/tic.png" alt="tic" style="width: 80%"/></td>
                            <td style="text-align: left; vertical-align: middle; color: #fff; padding: 0">
                              <h1>The Inspection Company Ltd.</h1>
                            </td>
                        </tr>
                        <tr>
                             <td colspan="2" style="padding: 20px; background-color: #ededed;">
                                <p>This message is automatically generated.</p><br><br>                        
                                <p>Dear <b>{!!$account_name!!}</b>,</p>

                                <br/>
                                <p>
                                    Good Day! <b>{!!$client_name!!}</b> have been created an account for you to access our Dashboard. Here is the information of the supplier account that has been created earlier. Please keep it hidden and not to tell anyone to secure all the information that you have in this account. Thank you!
                                </p><br>
                                <p><a href='https://tic-service.company/'><b>Redirect me to Dashboard</b></a></p>

                                <p><b>Supplier Account Details</b> </p>
                                <table style="width: 100%; border-collapse: collapse;">
                                    <tr style="">
                                        <th style="border: 1px solid #848484; padding: 5px;" width="50%" align="left">Username : </th>
                                        <td style="border: 1px solid #848484">{!!$username!!}</td>
                                    </tr>
                                    <tr style="">
                                        <th style="border: 1px solid #848484; padding: 5px;" width="50%" align="left">Email Address : </th>
                                        <td style="border: 1px solid #848484">{!!$email!!}</td>
                                    </tr>
                                    <tr style="">
                                        <th style="border: 1px solid #848484; padding: 5px;" width="50%" align="left">Password : </th>
                                        <td style="border: 1px solid #848484">{!! $password !!}</td>
                                    </tr>
                                    <tr style="">
                                        <th style="border: 1px solid #848484; padding: 5px;" width="50%" align="left">Contact Number : </th>
                                        <td style="border: 1px solid #848484">{!!$contact_number!!}</td>
                                    </tr>
                                    <tr style="">
                                        <th style="border: 1px solid #848484;  padding: 5px;" width="50%" align="left">Account Name : </th>
                                        <td style="border: 1px solid #848484">{!!$account_name!!}</td>
                                    </tr> 
                                </table>
                                <br>


                                <br><p >
                                    Thanks and Best Regards,<br>
                                    The Inspection Company
                                </p><br><br>
                             </td>
                        </tr>
                    </table>
               
                  </div>
                </div>
            </div>
        </div>
    </body>
</html>