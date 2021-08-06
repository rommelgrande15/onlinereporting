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
                  <div class="panel-heading orange-background text-center" style="border-radius: 10px 10px 0px 0px;"><h3>Download Blank Report for {{$report_number}}</h3></div>
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
                                <p>Dear <b>{{$insp_name}}</b>,</p>

                                <br/>
                                <p>
                                    Please see attached files for your inspection reference on <b>{{$inspection_date}}</b>. Kindly also use the details below to download the report from the app.
                                </p><br>

                                <p><b>Factory Details</b> </p>
                                <table style="width: 100%; border-collapse: collapse;">
                                    <tr style="">
                                        <th style="border: 1px solid #848484; padding: 5px;" width="50%" align="left">Factory Name : </th>
                                        <td style="border: 1px solid #848484">{!!$factory_name!!}</td>
                                    </tr>
                                    <tr style="">
                                        <th style="border: 1px solid #848484; padding: 5px;" width="50%" align="left">Factory Address : </th>
                                        <td style="border: 1px solid #848484">{{$factory_address}}</td>
                                    </tr>
                                    <tr style="">
                                        <th style="border: 1px solid #848484; padding: 5px;" width="50%" align="left">Factory Address (Local) : </th>
                                        <td style="border: 1px solid #848484">{!! $factory_address_local !!}</td>
                                    </tr>
                                    <tr style="">
                                        <th style="border: 1px solid #848484; padding: 5px;" width="50%" align="left">Factory Contact	: </th>
                                        <td style="border: 1px solid #848484">{!!$fac_contact!!}</td>
                                    </tr>
                                    <tr style="">
                                        <th style="border: 1px solid #848484;  padding: 5px;" width="50%" align="left">Factory Contact Person # : </th>
                                        <td style="border: 1px solid #848484">{{$fac_num}}</td>
                                    </tr> 
                                    <tr style="">
                                        <th style="border: 1px solid #848484; padding: 5px;" width="50%" align="left">Factory Contact Person Email : </th>
                                        <td style="border: 1px solid #848484">{{$fac_email}}</td>
                                    </tr> 
                                </table>
                                <br>

                                <p><b>App Login Details</b> </p>
                                <table style="width: 100%; border-collapse: collapse;">
                                    <tr style="">
                                        <th style="border: 1px solid #848484; padding: 5px;" width="50%" align="left">Inspector Username : </th>
                                        <td style="border: 1px solid #848484">{{$insp_un}}</td>
                                    </tr>
                                    <tr style="">
                                        <th style="border: 1px solid #848484; padding: 5px;" width="50%" align="left">Inspector Password : </th>
                                        <td style="border: 1px solid #848484">{{$insp_pw}}</td>
                                    </tr>
                                    <tr style="">
                                        <th style="border: 1px solid #848484; padding: 5px;" width="50%" align="left">Report Number :</th>
                                        <td style="border: 1px solid #848484">{{$report_number}}</td>
                                    </tr>
                                    <tr style="">
                                        <th style="border: 1px solid #848484; padding: 5px;" width="50%" align="left">Report Password :</th>
                                        <td style="border: 1px solid #848484">{{$password}}</td>
                                    </tr>
                                </table>
                                <br>

                                <p><b>Note :</b></p>
                                <p>{!! nl2br(e($memo)) !!} </p><br/>
                                <p><b>Requirements :</b></p>
                                <p>{!! nl2br(e($requirement)) !!} </p><br/><br/>

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