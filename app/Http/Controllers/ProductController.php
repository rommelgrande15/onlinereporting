<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Product;
use App\Company;
use View;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getProductPage(){
        $company = Company::where('user_id',Auth::id())->first();
        $products = Product::where('user_id',Auth::id())->get();
        return view('pages.products.index',compact('company','products'));
    }

    public function postNewProduct(Request $request){
        $this->validate($request,array(
            'new_product_name' =>'required',
            'new_product_category'=>'required',
            'new_product_unit'=>'required',
            'new_po_no'=>'required',
            'new_brand'=>'required',
            'new_cmf'=>'required',
            'new_tech_specs'=>'required',
            'new_shipping_mark'=>'required',
            'new_additional_product_info'=>'required'
        ));
        $user = User::find(Auth::id());
        $product = new Product();
        $product->user_id = $user->client_code;
        $product->product_name = $request['new_product_name'];
        $product->product_category = $request['new_product_category'];
        $product->product_unit = $request['new_product_unit'];
        $product->po_no = $request['new_po_no'];
        $product->brand = $request['new_brand'];
        $product->cmf = $request['new_cmf'];
        $product->tech_specs = $request['new_tech_specs'];
        $product->shipping_mark = $request['new_shipping_mark'];
        $product->additional_product_info = $request['new_additional_product_info'];
        if ($product->save()) {

            $new = Product::where('id',$product->id)->first();
            return response()->json([
                'product' => $new
            ],200);
        }
    }
 
    public function postNewProductAJAX(Request $request){
        $this->validate($request,array(
            'client_code' =>'required',
            'product_name' =>'required',
            'product_category'=>'required',
            'product_unit'=>'required'
        ));
        $product = new Product();
        $product->client_code = $request['client_code'];
        $product->product_name = $request['product_name'];
        $product->product_category = $request['product_category'];
        $product->product_unit = $request['product_unit'];

        $po_no = $request['po_no'];
        $model_no = $request['model_no'];
        $brand = $request['brand'];
        $cmf = $request['cmf'];
        $tech_specs = $request['tech_specs'];
        $shipping_mark = $request['shipping_mark'];
        $additional_product_info = $request['additional_product_info'];

        if($po_no==""){$po_no="N/A";}
        if($model_no==""){$model_no="N/A";}
        if($brand==""){$brand="N/A";}
        if($cmf==""){$cmf="N/A";}
        if($tech_specs==""){$tech_specs="N/A";}
        if($shipping_mark==""){$shipping_mark="N/A";}
        if($additional_product_info==""){$additional_product_info="N/A";}

        $product->po_no = $po_no;
        $product->model_no = $model_no;
        $product->brand = $brand;
        $product->cmf = $cmf;
        $product->tech_specs = $tech_specs;
        $product->shipping_mark = $shipping_mark;
        $product->additional_product_info = $additional_product_info;

        if ($product->save()) {
            return response()->json([
                'product' => $product
            ],200);
        }
    }

    public function getProduct(Request $request){
        $product = Product::where('id',$request['product_id'])->first();
            return response()->json([ 
                'product' => $product
            ],200);
    }

    public function updateProduct(Request $request){
        $this->validate($request,array(
            'edit_product_name' =>'required',
            'edit_product_category'=>'required',
            'edit_product_unit'=>'required',
            'edit_po_no'=>'required',
            'edit_brand'=>'required',
            'edit_cmf'=>'required',
            'edit_tech_specs'=>'required',
            'edit_shipping_mark'=>'required',
            'edit_additional_product_info'=>'required'
        ));

        $product = Product::find($request['product_id']);
        $product->product_name = $request['edit_product_name'];
        $product->product_category = $request['edit_product_category'];
        $product->product_unit = $request['edit_product_unit'];
        $product->po_no = $request['edit_po_no'];
        $product->brand = $request['edit_brand'];
        $product->cmf = $request['edit_cmf'];
        $product->tech_specs = $request['edit_tech_specs'];
        $product->shipping_mark = $request['edit_shipping_mark'];
        $product->additional_product_info = $request['edit_additional_product_info'];
        if ($product->save()) {

            $new = Product::where('id',$product->id)->first();
            return response()->json([
                'product' => $new
            ],200);
        }

    }

    public function deleteProduct(Request $request){
        $product = Product::find($request['product_id']);
        $product->delete();
        return response()->json([
                'message' => 'Product has been deleted!'
            ],200);
    }
}
