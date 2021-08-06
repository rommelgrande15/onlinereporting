<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="utf-8">
    <style type="text/css">
        body {
            font-family: Arial;
        }

        a {
            text-decoration: none;
        }

        .orange-text {
            color: #f37934 !important;
        }

        .orange-background {
            background: #f37934 !important;
            color: #fff !important;
            padding: 1px 25px;
            border: 1px solid #d5d5d5;

        }

        .tic-logo {
            margin-bottom: 25px;
        }

        .img-logo {
            max-width: 400px;
            margin: auto;
        }

        .signature {
            font-weight: bold;
        }

        .signature-logo {
            max-width: 250px;
        }

        .text-center {
            text-align: center;
        }

        .link-btn {
            padding: 10px;
            background: #3cb5d0;
            color: #fff !important;
            text-decoration: none;
            border-radius: 5px;
            border: 1px solid #3cb5d0;
        }

        .panel-body {
            border: 1px solid #d5d5d5;
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
                            <td width="30%" style="text-align: center; vertical-align: middle;"><img src="http://www.the-inspection-company.com/htm_files/tic.png" alt="tic" style="width: 80%" /></td>
                            <td style="text-align: left; vertical-align: middle; color: #fff; padding: 0">
                                <h1>The Inspection Company Ltd.</h1>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding: 20px; background-color: #ededed;">
                                <p>Dear Inspector,</p><br />
                                <p>Please see attached files for your inspection reference on {{$inspection_date}} and other info below.,</p><br />
                                <p>Note :</p>
                                <p>{!! nl2br(e($memo)) !!} </p><br />

                                <p>Requirements :</p>
                                <p>{!! nl2br(e($requirement)) !!} </p><br /><br />
                                <table style="width: 100%; border-collapse: collapse;">
                                    <tr style="">
                                        <th style="border: 1px solid #848484; font-weight: bold; padding: 5px;" width="50%" align="left">Project Client Number</th>
                                        <td style="border: 1px solid #848484">{!!$client_number!!}</td>
                                    </tr>
                                    <tr style="">
                                        <th style="border: 1px solid #848484; font-weight: bold; padding: 5px;" width="50%" align="left">Inspection Service</th>
                                        <td style="border: 1px solid #848484">{{$service}}</td>
                                    </tr>
                                    <tr style="">
                                        <th style="border: 1px solid #848484; font-weight: bold; padding: 5px;" width="50%" align="left">Inspection Date</th>
                                        <td style="border: 1px solid #848484">{{$inspection_date}}</td>
                                    </tr>
                                    <tr style="">
                                        <th style="border: 1px solid #848484; font-weight: bold; padding: 5px;" width="50%" align="left">Factory Name</th>
                                        <td style="border: 1px solid #848484">{!!$factory_name!!}</td>
                                    </tr>
                                    <tr style="">
                                        <th style="border: 1px solid #848484; font-weight: bold; padding: 5px;" width="50%" align="left">Factory Address</th>
                                        <td style="border: 1px solid #848484">{{$factory_address}}</td>
                                    </tr>
                                    <tr style="">
                                        <th style="border: 1px solid #848484; font-weight: bold; padding: 5px;" width="50%" align="left">Factory Address (Local)</th>
                                        <td style="border: 1px solid #848484">{!!$factory_address_local!!}</td>
                                    </tr>
                                    <tr style="">
                                        <th style="border: 1px solid #848484; font-weight: bold; padding: 5px;" width="50%" align="left">Factory Contact</th>
                                        <td style="border: 1px solid #848484">{!!$fac_contact!!}</td>
                                    </tr>
                                    <tr style="">
                                        <th style="border: 1px solid #848484; font-weight: bold; padding: 5px;" width="50%" align="left">Factory Contact Person #</th>
                                        <td style="border: 1px solid #848484">{{$fac_num}}</td>
                                    </tr>
                                    @foreach($psi_product_list as $key=>$psi_prod)
                                    <tr style="">
                                        <th style="border: 1px solid #848484; font-weight: bold; padding: 5px;" width="50%" align="left">Product {{$key + 1}}</th>
                                        @foreach($product_list as $prod)
                                        @if($prod->id==$psi_prod->product_name)
                                        <td style="border: 1px solid #848484">{!!$prod->product_name!!}</td>
                                        @endif
                                        @endforeach
                                    </tr>

                                    <tr style="">
                                        <th style="border: 1px solid #848484; font-weight: bold; padding: 5px;" width="50%" align="left">Brand</th>
                                        <td style="border: 1px solid #848484">{{$psi_prod->brand}}</td>
                                    </tr>

                                    <tr style="">
                                        <th style="border: 1px solid #848484; font-weight: bold; padding: 5px;" width="50%" align="left">Model #</th>
                                        <td style="border: 1px solid #848484">{{$psi_prod->model_no}}</td>
                                    </tr>

                                    <tr style="">
                                        <th style="border: 1px solid #848484; font-weight: bold; padding: 5px;" width="50%" align="left">PO #</th>
                                        <td style="border: 1px solid #848484">{{$psi_prod->po_no}}</td>
                                    </tr>

                                    <tr style="">
                                        <th style="border: 1px solid #848484; font-weight: bold; padding: 5px;" width="50%" align="left">PO Quantity </th>
                                        <td style="border: 1px solid #848484">{{$psi_prod->aql_qty}}</td>
                                    </tr>

                                    <tr style="">
                                        <th style="border: 1px solid #848484; font-weight: bold; padding: 5px;" width="50%" align="left">Sample Level</th>
                                        <td style="border: 1px solid #848484">{{$psi_prod->aql_normal_level}} / {{$psi_prod->aql_special_level}}</td>
                                    </tr>

                                    <tr style="">
                                        <th style="border: 1px solid #848484; font-weight: bold; padding: 5px;" width="50%" align="left">Sampling Size </th>
                                        <td style="border: 1px solid #848484">{{$psi_prod->aql_normal_sampsize}} / {{$psi_prod->aql_special_sampsize}}</td>
                                    </tr>

                                    <tr style="">
                                        <th style="border: 1px solid #848484; font-weight: bold; padding: 5px;" width="50%" align="left">AQL Major </th>
                                        <td style="border: 1px solid #848484">{{$psi_prod->aql_major}}</td>
                                    </tr>

                                    <tr style="">
                                        <th style="border: 1px solid #848484; font-weight: bold; padding: 5px;" width="50%" align="left">Max Allowed Major </th>
                                        <td style="border: 1px solid #848484">{{$psi_prod->max_allowed_major}}</td>
                                    </tr>

                                    <tr style="">
                                        <th style="border: 1px solid #848484; font-weight: bold; padding: 5px;" width="50%" align="left">AQL Minor </th>
                                        <td style="border: 1px solid #848484">{{$psi_prod->aql_minor}}</td>
                                    </tr>

                                    <tr style="">
                                        <th style="border: 1px solid #848484; font-weight: bold; padding: 5px;" width="50%" align="left">Max Allowed Minor </th>
                                        <td style="border: 1px solid #848484">{{$psi_prod->max_allowed_minor}}</td>
                                    </tr>
                                    <tr style="">
                                        <td style="border: 1px solid #848484" colspan="2"><span style="font-weight: bold;">Description: </span> {!!$psi_prod->item_description!!}</td>
                                    </tr>
                                    @endforeach
                                </table>
                                <br>
                                <p>
                                    Thanks and Best Regards
                                </p><br><br>
                            </td>
                        </tr>
                    </table>

                    {{-- Please use the details below to download the report from the app.<br><br>

                    <strong>Report Number: </strong> <span>{{$report_number}}</span><br>
                    <strong>Password: </strong> <span>{{$password}}</span><br><br> --}}

                </div>
            </div>
        </div>
    </div>
</body>

</html>
