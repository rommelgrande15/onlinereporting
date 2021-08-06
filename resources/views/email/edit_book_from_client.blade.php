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
                    @php
                    $logo_link='http://www.the-inspection-company.com/htm_files/tic.png';
                    $company_header='The Inspection Company Ltd.';
                    $ch_align='left';
                    $db_link='https://tic-service.company/';
                    $bg_color='#ffa500';
                    @endphp
                    @if($user_type)
                    @if($user_type=='tic_sera')
                    @php
                    $logo_link='http://tic-service.company/images/ticsera-logo.png';
                    $company_header='TIC-SERA';
                    $ch_align='center';
                    $bg_color='#dd4b39';
                    $db_link='https://tic-service.company/tic-sera-login';
                    @endphp
                    @endif
                    @endif
                    <table style="width: 60%; margin: auto; border-collapse: collapse; border: 0; font-family: arial;">
                        <tr style="background:{{$bg_color}}; height: 100px;">
                            <td width="30%" style="text-align: center; vertical-align: middle;"><img src="{{$logo_link}}" alt="tic" style="width: 80%" /></td>
                            <td style="text-align: {{$ch_align}}; vertical-align: middle; color: #fff; padding: 0">
                                <h1>{{$company_header}}</h1>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding: 20px; background-color: #ededed;">
                                <p>Dear {{$dear_client}},</p><br />
                                <p>Your inspection details has been successfully updated. Our booking team is now reviewing your inspection details below and you will get a response shortly.<br />
                                    <p><a href='{{$db_link}}'>Redirect me to Dashboard</a></p>

                                    <p><b>Inspection Details</b> </p>
                                    <table style="width: 100%; border-collapse: collapse;">
                                        <tr style="">
                                            <th style="border: 1px solid #848484; font-weight: bold; padding: 5px;" width="50%" align="left">Client</th>
                                            <td style="border: 1px solid #848484">{{$c_name}}</td>
                                        </tr>
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
                                    </table>

                                    <p><b>Factory Details</b> </p>
                                    <table style="width: 100%; border-collapse: collapse;">
                                        <tr style="">
                                            <th style="border: 1px solid #848484; padding: 5px;" width="50%" align="left">Factory Name : </th>
                                            <td style="border: 1px solid #848484">{!!$factory->factory_name!!}</td>
                                        </tr>
                                        <tr style="">
                                            <th style="border: 1px solid #848484; padding: 5px;" width="50%" align="left">Factory Address : </th>
                                            <td style="border: 1px solid #848484">{!!$factory->factory_address!!}</td>
                                        </tr>
                                        <tr style="">
                                            <th style="border: 1px solid #848484; padding: 5px;" width="50%" align="left">Factory Address (Local) : </th>
                                            <td style="border: 1px solid #848484">{!! $factory->factory_address_local !!}</td>
                                        </tr>
                                        <tr style="">
                                            <th style="border: 1px solid #848484; padding: 5px;" width="50%" align="left">Factory Contact : </th>
                                            <td style="border: 1px solid #848484">{!!$factory_cont->factory_contact_person!!}</td>
                                        </tr>
                                        <tr style="">
                                            <th style="border: 1px solid #848484;  padding: 5px;" width="50%" align="left">Factory Contact Person # : </th>
                                            <td style="border: 1px solid #848484">{!!$factory_cont->factory_contact_number!!}</td>
                                        </tr>
                                        <tr style="">
                                            <th style="border: 1px solid #848484;  padding: 5px;" width="50%" align="left">Factory Contact Email : </th>
                                            <td style="border: 1px solid #848484">{!!$factory_cont->factory_email!!}</td>
                                        </tr>
                                    </table>
                                    <br>
                                    @if($psi_product_list)
                                    <p><b>Product Details</b> </p>
                                    <table style="width: 100%; border-collapse: collapse;">
                                        @foreach($psi_product_list as $key=>$psi_prod)
                                        <tr style="">
                                            <th style="border: 1px solid #848484; font-weight: bold; padding: 5px;" width="50%" align="left">Product</th>
                                            <td style="border: 1px solid #848484">{!!$psi_prod->product_name!!}</td>
                                        </tr>
                                        <tr style="">
                                            <th style="border: 1px solid #848484; font-weight: bold; padding: 5px;" width="50%" align="left">Category</th>
                                            <td style="border: 1px solid #848484">{!!$psi_prod->product_category!!}</td>
                                        </tr>
                                        <tr style="">
                                            <th style="border: 1px solid #848484; font-weight: bold; padding: 5px;" width="50%" align="left">Brand</th>
                                            <td style="border: 1px solid #848484">{!!$psi_prod->brand!!}</td>
                                        </tr>

                                        <tr style="">
                                            <th style="border: 1px solid #848484; font-weight: bold; padding: 5px;" width="50%" align="left">Model #</th>
                                            <td style="border: 1px solid #848484">{!!$psi_prod->model_no!!}</td>
                                        </tr>

                                        <tr style="">
                                            <th style="border: 1px solid #848484; font-weight: bold; padding: 5px;" width="50%" align="left">PO #</th>
                                            <td style="border: 1px solid #848484">{!!$psi_prod->po_no!!}</td>
                                        </tr>

                                        <tr style="">
                                            <th style="border: 1px solid #848484; font-weight: bold; padding: 5px;" width="50%" align="left">PO Quantity </th>
                                            <td style="border: 1px solid #848484">{!!$psi_prod->aql_qty!!} {!!$psi_prod->aql_qty_unit!!}</td>
                                        </tr>

                                        <tr style="">
                                            <th style="border: 1px solid #848484; font-weight: bold; padding: 5px;" width="50%" align="left">Sample Level</th>
                                            <td style="border: 1px solid #848484">{!!$psi_prod->aql_normal_level!!} / {!!$psi_prod->aql_special_level!!}</td>
                                        </tr>

                                        <tr style="">
                                            <th style="border: 1px solid #848484; font-weight: bold; padding: 5px;" width="50%" align="left">Sampling Size </th>
                                            <td style="border: 1px solid #848484">{!!$psi_prod->aql_normal_sampsize!!} / {!!$psi_prod->aql_special_sampsize!!}</td>
                                        </tr>

                                        <tr style="">
                                            <th style="border: 1px solid #848484; font-weight: bold; padding: 5px;" width="50%" align="left">AQL Major </th>
                                            <td style="border: 1px solid #848484">{!!$psi_prod->aql_major!!}</td>
                                        </tr>

                                        <tr style="">
                                            <th style="border: 1px solid #848484; font-weight: bold; padding: 5px;" width="50%" align="left">Max Allowed Major </th>
                                            <td style="border: 1px solid #848484">{!!$psi_prod->max_allowed_major!!}</td>
                                        </tr>

                                        <tr style="">
                                            <th style="border: 1px solid #848484; font-weight: bold; padding: 5px;" width="50%" align="left">AQL Minor </th>
                                            <td style="border: 1px solid #848484">{!!$psi_prod->aql_minor!!}</td>
                                        </tr>

                                        <tr style="">
                                            <th style="border: 1px solid #848484; font-weight: bold; padding: 5px;" width="50%" align="left">Max Allowed Minor </th>
                                            <td style="border: 1px solid #848484">{!!$psi_prod->max_allowed_minor!!}</td>
                                        </tr>
                                        <tr style="">
                                            <th style="border: 1px solid #848484; font-weight: bold; padding: 5px;" width="50%" align="left">Item Description </th>
                                            <td style="border: 1px solid #848484">{!!$psi_prod->item_description!!}</td>
                                        </tr>
                                        <tr style="">
                                            <th style="border: 1px solid #848484; font-weight: bold; padding: 5px;" width="50%" align="left">Additional Product Info </th>
                                            <td style="border: 1px solid #848484">{!!$psi_prod->additional_product_info!!}</td>
                                        </tr>
                                        @endforeach
                                    </table>
                                    @endif

                                    @if($requirement)
                                    <p><b>Other Details</b> </p>
                                    <table style="width: 100%; border-collapse: collapse;">
                                        <tr style="">
                                            <th style="border: 1px solid #848484; padding: 5px;" width="50%" align="left">Requirements : </th>
                                            <td style="border: 1px solid #848484">{!!$requirement!!}</td>
                                        </tr>
                                        <tr style="">
                                            <th style="border: 1px solid #848484; padding: 5px;" width="50%" align="left">Memo / Notes : </th>
                                            <td style="border: 1px solid #848484">{!!$memo!!}</td>
                                        </tr>
                                    </table>
                                    @endif

                                    <br>
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
