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
                                        <p>Dear <b>{!!$insp_name!!}</b>,</p><br/>
                                        @if($inspection_date==$inspection_date_to || $inspection_date_to=='')
                                            <p>Please see attached files for your inspection reference on {!!$inspection_date!!} and other info below.,</p><br/>
                                        @else
                                            <p>Please see attached files for your inspection reference on {!!$inspection_date!!} to {!!$inspection_date_to!!} and other info below.,</p><br/>
                                        @endif
                                        <p>Note :</p>
                                        <p>{!! nl2br(e($memo)) !!} </p><br/>

                                        <p>Requirements :</p>
                                        <p>{!! nl2br(e($requirement)) !!} </p><br/><br/>

                                        <table style="width: 100%; border-collapse: collapse;">
                                            <tr style="">
                                                <th style="border: 1px solid #848484; font-weight: bold; padding: 5px;" width="50%" align="left">Project Client Number</th>
                                                <td style="border: 1px solid #848484">{!!$client_number!!}</td>
                                            </tr>
                                            <tr style="">
                                                <th style="border: 1px solid #848484; font-weight: bold; padding: 5px;" width="50%" align="left">Inspection Service</th>
                                                <td style="border: 1px solid #848484">{!!$service!!}</td>
                                            </tr>
                                            <tr style="">
                                                <th style="border: 1px solid #848484; font-weight: bold; padding: 5px;" width="50%" align="left">Inspection Date</th>
                                                @if($inspection_date==$inspection_date_to || $inspection_date_to=='')
                                                    <td style="border: 1px solid #848484">{!!$inspection_date!!}</td>
                                                @else
                                                    <td style="border: 1px solid #848484">{!!$inspection_date!!} to {!!$inspection_date_to!!}</td>
                                                @endif
                                            </tr>
                                            <tr style="">
                                                <th style="border: 1px solid #848484; font-weight: bold; padding: 5px;" width="50%" align="left">Manday</th>
                                                <td style="border: 1px solid #848484">{!!$manday!!}</td>
                                            </tr>
                                            <tr style="">
                                                <th style="border: 1px solid #848484; font-weight: bold; padding: 5px;" width="50%" align="left">Factory Name</th>
                                                <td style="border: 1px solid #848484">{!!$factory_name!!}</td>
                                            </tr> 
                                            <tr style="">
                                                <th style="border: 1px solid #848484; font-weight: bold; padding: 5px;" width="50%" align="left">Factory Address</th>
                                                <td style="border: 1px solid #848484">{!!$factory_address!!}</td>
                                            </tr> 
                                            <tr style="">
                                                <th style="border: 1px solid #848484; font-weight: bold; padding: 5px;" width="50%" align="left">Factory Contact</th>
                                                <td style="border: 1px solid #848484">{!!$fac_contact!!}</td>
                                            </tr> 
                                            <tr style="">
                                                <th style="border: 1px solid #848484; font-weight: bold; padding: 5px;" width="50%" align="left">Factory Contact Person #</th>
                                                <td style="border: 1px solid #848484">{!!$fac_num!!}</td>
                                            </tr> 
                                                
                                            <tr style="">
                                                    <th style="border: 1px solid #848484; font-weight: bold; padding: 5px;" width="50%" align="left">Supplier</th>
                                                    <td style="border: 1px solid #848484">{!!$supplier!!}</td>
                                                </tr>                 
                                        </table>
                                        <br>

                                        <p><b>App Login Details for Geo Tracking</b> </p>
                                        <table style="width: 100%; border-collapse: collapse;">
                                            <tr style="">
                                                <th style="border: 1px solid #848484; padding: 5px;" width="50%" align="left">Inspector Username : </th>
                                                <td style="border: 1px solid #848484">{!!$insp_un!!}</td>
                                            </tr>
                                            <tr style="">
                                                <th style="border: 1px solid #848484; padding: 5px;" width="50%" align="left">Inspector Password : </th>
                                                <td style="border: 1px solid #848484">{!!$insp_pw!!}</td>
                                            </tr>
                                            <tr style="">
                                                <th style="border: 1px solid #848484; padding: 5px;" width="50%" align="left">Report Number :</th>
                                                <td style="border: 1px solid #848484">{!!$report_number!!}</td>
                                            </tr>
                                            <tr style="">
                                                <th style="border: 1px solid #848484; padding: 5px;" width="50%" align="left">Report Password :</th>
                                                <td style="border: 1px solid #848484">{!!$password!!}</td>
                                            </tr>
                                        </table>

                                        <p><b>Login Details for File Manager</b> </p>
                                        <table style="width: 100%; border-collapse: collapse;">
                                            <tr style="">
                                                <th style="border: 1px solid #848484; padding: 5px;" width="50%" align="left">Inspector Username : </th>
                                                <td style="border: 1px solid #848484">{!!$fm_un!!}</td>
                                            </tr>
                                            <tr style="">
                                                <th style="border: 1px solid #848484; padding: 5px;" width="50%" align="left">Inspector Password : </th>
                                                <td style="border: 1px solid #848484">{!!$fm_pw!!}</td>
                                            </tr>
                                        </table>
                                        <p><a href='https://t-i-c.services/login'>Redirect me to File Manager</a></p>
                                        <br>

                                        @if($file_passed)
                                            <p><b>Attachments:</b> </p>
                                            <p style="color:red">Please click the link below one by one to download each attachment.</p>
                                                <table style="width: 100%; border-collapse: collapse;">
                                                    @foreach ($file_passed as $file_name)      
                                                        @php
                                                            $name = explode("/", $file_name);
                                                            $temp;
                                                            if(count($name)>=4){
                                                                $temp=$name[0].'_'.$name[1].'_'.$name[2].'_'.$name[3];
                                                            }
                                                        @endphp                                                      
                                                        @if(count($name)>=4)                                                                  
                                                            <tr style="">
                                                                <th colspan="2" style="border: 1px solid #848484; padding: 5px;" width="100%" align="left"><a href="https://tic-service.company/download-file/{!! $temp!!}" target="_blank" download>@php echo $name[3]; @endphp</a></th>
                                                            </tr>
                                                        @endif
                                                    @endforeach    
                                                </table>  
                                            <br>                                         
                                        @endif

                                        
                                        <p>
                                        Thanks and Best Regards
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