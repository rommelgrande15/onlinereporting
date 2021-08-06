@extends('layouts.new')
@section('title','Project Management')
@section('page-title', 'Project Inspection')
@section('stylesheets')
  {{ Html::style('/css/admin/factory.css') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 padding-b-25">
            
            <div class="table-responsive">
                
              	<h4 class="heading">Inspection Details</h4>
              <div class="col-md-6 col-sm-6 col-xs-12">
  <div class="info-box">
    <span class="info-box-icon bg-red"><i class="ion ion-ios-paper"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Report Number :</span>
      <span class="info-box-number">{{$inspection->reference_number}}</span>
    </div>
    <!-- /.info-box-content -->
  </div>
  <!-- /.info-box -->
</div>
<!-- /.col -->
<div class="col-md-6 col-sm-6 col-xs-12">
  <div class="info-box">
    <span class="info-box-icon bg-red"><i class="fa fa-wrench"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Service Type :</span>
      <span class="info-box-number">{{$inspection->service}}</span>
    </div>
    <!-- /.info-box-content -->
  </div>
  <!-- /.info-box -->
</div>
                     <div class="col-md-6 col-sm-6 col-xs-12">
  <div class="info-box">
    <span class="info-box-icon bg-red"><i class="fa fa-calendar-check-o"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Inspection Date :</span>
      <span class="info-box-number">{{$inspection->inspection_date}}</span>
    </div>
    <!-- /.info-box-content -->
  </div>
  <!-- /.info-box -->
</div>
              <!-- /.col -->
<div class="col-md-6 col-sm-6 col-xs-12">
  <div class="info-box">
    <span class="info-box-icon bg-red"><i class="fa fa-user-secret"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Assigned Inspector :</span>
      <span class="info-box-number">{{$inspection->name}}</span>
    </div>
    <!-- /.info-box-content -->
  </div>
  <!-- /.info-box -->
</div>
<!-- /.col -->
   	<h4 class="heading">Client Details</h4>
                   
<!-- /.col -->
         
<!-- fix for small devices only -->
            

<div class="col-md-6 col-sm-6 col-xs-12">
  <div class="info-box">
    <span class="info-box-icon bg-green"><i class="fa fa-id-badge"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Client Name :</span>
      <span class="info-box-number">{{$inspection->client_name}}</span>
    </div>
    <!-- /.info-box-content -->
  </div>
  <!-- /.info-box -->
</div>
<!-- /.col -->
<div class="col-md-6 col-sm-6 col-xs-12">
  <div class="info-box">
    <span class="info-box-icon bg-green"><i class="fa fa-braille"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Client Code :</span>
      <span class="info-box-number">{{$inspection->client_id}}</span>
    </div>
    <!-- /.info-box-content -->
  </div>
  <!-- /.info-box -->
</div>
<!-- /.col -->
       <div class="col-md-4 col-sm-6 col-xs-12">
  <div class="info-box">
    <span class="info-box-icon bg-green"><i class="fa fa-vcard-o"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Client Contact Person :</span>
      <span class="info-box-number">{{$inspection->contact_person}}</span>
    </div>
    <!-- /.info-box-content -->
  </div>
  <!-- /.info-box -->
</div>       
    
              <div class="col-md-4 col-sm-6 col-xs-12">
  <div class="info-box">
    <span class="info-box-icon bg-green"><i class="fa fa-cc"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Client Contact Email :</span>
      <span class="info-box-number">{{$inspection->email_address}}</span>
    </div>
    <!-- /.info-box-content -->
  </div>
  <!-- /.info-box -->
</div> 
    
      <div class="col-md-4 col-sm-6 col-xs-12">
  <div class="info-box">
    <span class="info-box-icon bg-green"><i class="	fa fa-phone-square"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Client Contact Number :</span>
      <span class="info-box-number">{{$inspection->contact_number}}</span>
    </div>
    <!-- /.info-box-content -->
  </div>
  <!-- /.info-box -->
</div>             
           
                 	<h4 class="heading">Factory Details</h4>
              <div class="col-md-4 col-sm-6 col-xs-12">
  <div class="info-box">
    <span class="info-box-icon bg-yellow"><i class="fa fa-institution"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Factory Name:</span>
      <span class="info-box-number">{{$inspection->factory_name}}</span>
    </div>
    <!-- /.info-box-content -->
  </div>
  <!-- /.info-box -->
</div>
    <div class="col-md-4 col-sm-6 col-xs-12">
  <div class="info-box">
    <span class="info-box-icon bg-yellow"><i class="fa fa-map-marker"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Factory Address:</span>
      <span class="info-box-number">{{$inspection->factory_address}}</span>
    </div>
    <!-- /.info-box-content -->
  </div>
  <!-- /.info-box -->
</div>   
              <!-- <div class="col-md-3 col-sm-6 col-xs-12">
  <div class="info-box">
    <span class="info-box-icon bg-yellow"><i class="fa fa-flag-checkered"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Factory Country:</span>
      <span class="info-box-number">{{$inspection->factory_country}}</span>
    </div>
 
  </div>
 
</div> -->
              <div class="col-md-4 col-sm-6 col-xs-12">
  <div class="info-box">
    <span class="info-box-icon bg-yellow"><i class="fa fa-map-signs"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Factory City:</span>
      <span class="info-box-number">{{$inspection->factory_city}}</span>
    </div>
  
  </div>

</div> 
              <h4 class="heading">Factory Contact Details</h4>
    
               <div class="col-md-4 col-sm-6 col-xs-12">
  <div class="info-box">
    <span class="info-box-icon bg-teal"><i class="fa fa-vcard-o"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Factory Contact Person :</span>
      <span class="info-box-number">{{$inspection->factory_contact_person}}</span>
    </div>
    <!-- /.info-box-content -->
  </div>
  <!-- /.info-box -->
</div> 
               <div class="col-md-4 col-sm-6 col-xs-12">
  <div class="info-box">
    <span class="info-box-icon bg-teal"><i class="fa fa-cc"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Factory Email :</span>
      <span class="info-box-number">{{$inspection->factory_email}}</span>
    </div>
    <!-- /.info-box-content -->
  </div>
  <!-- /.info-box -->
</div> 
               <div class="col-md-4 col-sm-6 col-xs-12">
  <div class="info-box">
    <span class="info-box-icon bg-teal"><i class="	fa fa-phone-square"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Factory Contact Number :</span>
      <span class="info-box-number">{{$inspection->factory_contact_number}}</span>
    </div>
    <!-- /.info-box-content -->
  </div>
  <!-- /.info-box -->
</div> 
 <h4 class="heading">Product Details</h4>
   <div class="col-md-4 col-sm-6 col-xs-12">
  <div class="info-box">
    <span class="info-box-icon bg-maroon"><i class="fa fa-cube"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Product Name :</span>
      <span class="info-box-number">{{$inspection->product_name}}</span>
    </div>
    <!-- /.info-box-content -->
  </div>
  <!-- /.info-box -->
</div> 
               <div class="col-md-4 col-sm-6 col-xs-12">
  <div class="info-box">
    <span class="info-box-icon bg-maroon"><i class="fa fa-certificate"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Product Category :</span>
      <span class="info-box-number">{{$inspection->product_category}}</span>
    </div>
    <!-- /.info-box-content -->
  </div>
  <!-- /.info-box -->
</div> 
               <div class="col-md-4 col-sm-6 col-xs-12">
  <div class="info-box">
    <span class="info-box-icon bg-maroon"><i class="fa fa-cubes"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Quantity :</span>
      <span class="info-box-number">{{$inspection->aql_qty}}</span>
    </div>
    <!-- /.info-box-content -->
  </div>
  <!-- /.info-box -->
</div> 
              
               <h3 class="h3-link"><small><a href="{{route('panel', $user_info->user_id)}}"><i class="fa fa-arrow-left"></i> Go Back to Project List</a></small> </h3>   
              
            </div>
        </div>
    </div>
    
    @include('partials.admin.factory._updatecontact')
    @include('partials.admin.factory._deletecontact')
    
@endsection

@section('scripts')
	{{ Html::script('/js/admin/factory.js') }}
@endsection
