@extends('layouts.master')
@section('title','Products')
@section('stylesheets')
  {{ Html::style('/css/products/products.css') }}
@endsection

@section('content')
    <div class="row">
    	<div class="col-md-3">
    		@include('partials._sidebar')
    	</div>
    	<div class="col-md-9">
    		<div class="panel panel-default panel-primary main-content-panel">
				<div class="panel-heading heading-text">Products List</div>
				<div class="panel-body">
          <div class="col-md-12 btn-control-wrapper">
            <button class="btn btn-success" data-toggle="modal" data-target="#productModal"><i class="fa fa-plus"></i> Add a New Product</button>
          </div>
          <div class="col-md-12">
            <table class="table" id="products_table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Product Name</th>
                  <th>Category</th>
                  <th>Brand</th>
                  <th class="text-center">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($products as $i=>$product)
                  <tr>
                    <td>{{$i+1}}</td>
                    <td>{{$product->product_name}}</td>
                    <td>{{$product->product_category}}</td>
                    <td>{{$product->brand}}</td>
                    <td class="text-center">
                      <button class="btn btn-primary btn-xs btn_product_details" data-toggle="modal" data-id="{{$product->id}}">
                        <i class="fa fa-pencil"></i>
                      </button>
                      <button class="btn btn-danger btn-xs btn_delete_product" data-toggle="modal" data-id="{{$product->id}}">
                        <i class="fa fa-times"></i>
                      </button>
                    </td>

                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
				</div>
			</div>
    	</div>
    </div>
    @include('partials.inspection._addproduct')
    @include('partials._editproduct')
    @include('partials._deleteproduct')
@endsection

@section('scripts')
	{{ Html::script('/js/products/products.js') }}
  <script type="text/javascript">
    var token = "{{Session::token()}}";
    var newproduct = "{{route('newproduct')}}";
    var selectproduct = "{{route('selectproduct')}}";
    var deleteproduct = "{{route('deleteproduct')}}";
    var updateproduct = "{{route('updateproduct')}}";
  </script>
@endsection
