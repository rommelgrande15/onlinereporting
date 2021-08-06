<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="" >
	<title></title>
    <style type="text/css">
    body{
        font-family: 'Verdana, Geneva, sans-serif';
        padding: 1em;
    }
    .header{
    	width: 100%;
        top: -60px;
        position: fixed;
        height: 50px;
        padding: .5em;
    }
    .footer {
        width: 100%;
        text-align: center;
        position: fixed;
    }
    .col-md-6{
        width: 50%;
    }
    .footer {
        bottom: 0px;
    }
    .pagenum:before {
        content: counter(page);
    }
    .content{
        margin-top:50px;
        word-wrap: break-word;
        height: auto;
    }
    .text-right{
        text-align: right;
    }
    .text-center{
        text-align: center;
    }
    .company-title{
        margin-top: -35px;
        margin-left: 305px;
        color: #3cb5d0;
        font-size: 22px;
        font-weight: bold;
    }
    .label{
        font-weight: bold;
    }
    .tr-head{
        background: #e5e5e5;
    }
    .page-break {
        page-break-after: always;
    }
    table {
    border-collapse: collapse;
    width: 100%
    }

    table, th, td {
        border: 1px solid black;
        font-size: 13px;
    }
    @page {
        margin:80px 50px 120px 50px;
    }
    .footer-text{
        font-size: 12px;
        font-style: italic;
    }
    </style>


</head>
<body>
<div class="header">
    <img src="images/tic.png" width="250" class="logo">
    <div class="company-title">InspectOne | Asia E-Commerce Ltd.</div>    
</div>
<div class="footer footer-text">
<hr>
    Page <span class=" pagenum"></span><br>
        InspectOne | Asia E-Commerce Ltd.<br>
        The Innovation Centre, EXETER | EX4 4RN United Kingdom<br>
        Tel: +44(0)1392 580015<br>
        Website: http://inspect.one<br>
        Email: sales@inspect.one

</div>
<div class="content">
<table class="table">
    <tr>
        <td class="label">Date Booked</td>
        <td>{{date_format($booking->created_at, "M-d-Y h:i:s A")}}</td>
        <td class="label">Project Reference Number:</td>
        <td>{{$booking->reference_number}}</td>
    </tr>
    <tr>
        <td class="label">Company Name:</td>
        <td>{{$company->company_name}}</td>
        <td class="label">Tel No:</td>
        <td>{{$company->phone_number}}</td>
    </tr>
    <tr>
        <td class="label">Contact Person:</td>
        <td>{{$company->full_name}}</td>
        <td class="label">Email:</td>
        <td>{{$company->company_email}}</td>
    </tr>
    <tr>
        <td class="label">Address:</td>
        <td colspan="3">{{$company->company_address}}</td>
    </tr>
    <tr>
        <td class="label">Factory Name:</td>
        <td>{{$factory->factory_name}}</td>
        <td class="label">Tel No:</td>
        <td>{{$factory->factory_contact_number}}</td>
    </tr>
    <tr>
        <td class="label">Contact Person:</td>
        <td>{{$factory->factory_contact_person}}</td>
        <td class="label">Email:</td>
        <td>{{$factory->factory_email}}</td>
    </tr>
    <tr>
        <td class="label">Factory Address:</td>
        <td colspan="3">{{$factory->factory_address}}</td>
    </tr>
    <tr>
        <td class="label">Inspection Date:</td>
        <td>{{$booking->inspection_date}}</td>
        <td class="label">Shipment Date:</td>
        <td>{{$booking->shipment_date}}</td>
    </tr>
    <tr>
        <td class="label">Date Remarks:</td>
        <td colspan="3">{{ $factory->factory_address === 0 ? "Do not allow factory to change inspection date" : "Allow factory to change inspection date" }}</td>
    </tr>
    <tr>
        <td class="label">Service Requested:</td>
        <td colspan="3">{{ $service_type }}</td>
    </tr>
</table>
<br>

<table class="table">
    @foreach($productInfo as $i => $product)
        <tr>
            <td colspan="4" class="text-center label tr-head">Product {{$i +1}}</td>
        </tr>
        <tr>
            <td class="label">Product:</td>
            <td>{{$product->product_name}}</td>
            <td class="label">Brand:</td>
            <td>{{$product->brand}}</td>
        </tr>

        <tr>
            <td class="label">Unit:</td>
            <td>{{$product->product_unit}}</td>
            <td class="label">PO Number:</td>
            <td>{{$product->po_no}}</td>
        </tr>
        <tr>
            <td class="label">Quantity:</td>
            <td colspan="3">{{$products[$i]->qty}}</td>
        </tr>
        <tr>
            <td class="label">Shipping Mark:</td>
            <td colspan="3">{{$product->shipping_mark}}</td>
        </tr>
        <tr>
            <td class="label">Technical Specifications:</td>
            <td colspan="3">{{$product->tech_specs}}</td>
        </tr>
        <tr>
            <td class="label">Product Info:</td>
            <td colspan="3">{{$product->additional_product_info}}</td>
        </tr>
        <tr>
            <td class="label text-center tr-head" colspan="2">AQL Acceptable Level:</td>
            <td class="label text-center tr-head" colspan="2">AQL Sampling Level:</td>
        </tr>
        <tr>
            <td class="label">Visual:</td>
            <td>{{$products[$i]->gen_sample_size}}</td>
            <td class="label">Minor:</td>
            <td>{{$products[$i]->minor}}</td>
        </tr>
        <tr>
            <td class="label">Functional:</td>
            <td>{{$products[$i]->special_sample_size}}</td>
            <td class="label">Major:</td>
            <td>{{$products[$i]->major}}</td>
        </tr>
        <tr>
            <td class="label"></td>
            <td></td>
            <td class="label">Critical:</td>
            <td>{{$products[$i]->crit}}</td>
        </tr>
        <tr>
            <td class="label">Manday</td>
            <td>{{$booking->manday}}</td>
            <td class="label">Function:</td>
            <td>{{$products[$i]->functional}}</td>
        </tr>
        
    @endforeach
    <tr>
        <td colspan="4" class="tr-head text-center label">Samples</td>
    </tr>
    <tr>
        <td class="label">Reference Samples</td>
        <td>{{$booking->reference_sample}}</td>
        <td class="label">Courier:</td>
        <td>{{$booking->courier}}</td>
    </tr>
    <tr>
        <td class="label">Tracking Number</td>
        <td colspan="3">{{$booking->tracking_number}}</td>
    </tr>
    <tr>
        <td colspan="4" class="tr-head text-center label">Additional Remarks</td>
    </tr>
    <tr>
        <td colspan="4">{{!empty($booking->more_info) ? $booking->more_info : 'No additional information'}}</td>
    </tr>
    <tr>
        <td colspan="4" class="tr-head label">Notes:</td>
    </tr>
    <tr>
        <td colspan="4" class="tr-head ">
            <ul>
                <li>General AQL Sampling Level: Visual (Level II) and Functional Level (Level S2), if no specific requirements.</li>
                <li>General AQL Acceptable Level: Level II, Critical (0/0), Najor(2.5), Minor(4.0), Functional (1.0), if no specific requirements.</li>
                <li>Please Provide any information that would facilitate in the inspection (e.g photos, rating label, gift box, shipping mark, etc.).</li>
                <li>Please provide details for requirement of products, if any special is requested.</li>
                <li>in case factory fails to pay any re-inspection or other charges, the applicant automatically take over these charges.</li>
                <li>Jurisdiction is Hong Kong.</li>
            </ul>
        </td>
    </tr>
</table>

</div>
<div class="page-break"></div>
<div class="content">
    <table class="table">
        <tr>
            <td class="tr-head text-center label" colspan="4">Customer Requirement Sheet</td>
        </tr>
        <tr>
           <td colspan="4" class="label tr-head">1. Do you want us to continue if we face the following conditions in the factory?</td> 
        </tr>
        <tr>
            <td class="label">No key component list available</td>
            <td>{{$crs->no_key_component === 1 ? 'Yes' : 'No'}}</td>
            <td class="label">No removable sticker on carton</td>
            <td>{{$crs->no_removable_sticker_carton === 1 ? 'Yes' : 'No'}}</td>
        </tr>
        <tr>
            <td class="label">No serial number on the product</td>
            <td>{{$crs->no_serial_number === 1 ? 'Yes' : 'No'}}</td>
            <td class="label">Packaging label does not contain imp/exp info</td>
            <td>{{$crs->no_imp_exp_info === 1 ? 'Yes' : 'No'}}</td>
        </tr>
        <tr>
            <td class="label">No rating label</td>
            <td>{{$crs->no_rating_label === 1 ? 'Yes' : 'No'}}</td>
            <td class="label">Packaging is not finished by 80%</td>
            <td>{{$crs->packing_not_finished === 1 ? 'Yes' : 'No'}}</td>
        </tr>
        <tr>
            <td class="label">No removable sticker on product</td>
            <td>{{$crs->no_removable_sticker_product === 1 ? 'Yes' : 'No'}}</td>
            <td class="label">Production is not finished by 100%</td>
            <td>{{$crs->production_not_finished === 1 ? 'Yes' : 'No'}}</td>
        </tr>
        <tr>
            <td class="label">Missing logo on product</td>
            <td>{{$crs->missing_logo_product === 1 ? 'Yes' : 'No'}}</td>
            <td class="label">Report Requirement</td>
            <td>{{$crs->report_requirement_1}} / {{$crs->report_requirement_2}} / {{$crs->report_requirement_3}}</td>
        </tr>
        <tr>
            <td colspan="4" class="tr-head label">2. Special Requirements?</td>
        </tr>
        <tr>
            <td class="label">Double Sampling</td>
            <td>{{$crs->double_sampling === 1 ? 'Yes' : 'No'}}</td>
            <td class="label">Seal on whole quantity</td>
            <td>{{$crs->seal_on_whole_quantity === 1 ? 'Yes' : 'No'}}</td>
        </tr>
        <tr>
            <td class="label">Seal on every product</td>
            <td>{{$crs->seal_every_product === 1 ? 'Yes' : 'No'}}</td>
            <td class="label">TIC report or own report</td>
            <td>{{$crs->tic_own_report === "TIC" ? 'TIC' : 'Own'}}</td>
        </tr>
        <tr>
            <td class="label">Seal on every opened carton</td>
            <td>{{$crs->seal_opened_carton === 1 ? 'Yes' : 'No'}}</td>
            <td class="label">TIC Chop on Export Carton</td>
            <td>{{$crs->tic_chop === "TIC" ? 'TIC' : 'Own'}}</td>
        </tr>

        <tr>
            <td colspan="4" class="label tr-head">3. Product Specific Requirements?</td>
        </tr>
        <tr>
            <td class="label">Temperature Test</td>
            <td>{{$crs->temperature_test === 1 ? 'Yes' : 'No'}}</td>
            <td class="label">Temperature rise measure test</td>
            <td>{{$crs->temp_rise_test === 1 ? 'Yes' : 'No'}}</td>
        </tr>
        <tr>
            <td class="label">Humidity Test</td>
            <td>{{$crs->humidity_test === 1 ? 'Yes' : 'No'}}</td>
            <td class="label">Noise Test</td>
            <td>{{$crs->noise_test === 1 ? 'Yes' : 'No'}}</td>
        </tr>
        <tr>
            <td class="label">Special Requirement for this?</td>
            <td colspan="3">{{$crs->special_requirements}}</td>
        </tr>
        <tr>
            <td colspan="4" class="label tr-head">4. Special Packing Instructions</td>
        </tr>
        <tr>
            <td colspan="4">{{$crs->instructions}}</td>
        </tr>
        <tr>
            <td class="label">Blister Packing</td>
            <td>{{$crs->blister_packing === 1 ? 'Yes' : 'No'}}</td>
            <td class="label">Carton Packing</td>
            <td>{{$crs->carton_packing === 1 ? 'Yes' : 'No'}}</td>
        </tr>
        <tr>
            <td class="label">Tape</td>
            <td colspan="3">{{$crs->tape}}</td>
        </tr>
         <tr>
            <td colspan="4" class="label tr-head">5. Additional Special Requirements</td>
        </tr>
        <tr>
            <td colspan="4">{{$crs->additional_requirements}}</td>
        </tr>

    </table>
</div>


</body>
</html>