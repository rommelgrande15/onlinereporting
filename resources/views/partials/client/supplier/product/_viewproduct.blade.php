<div id="viewProduct" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">View Product Details</h4>
			</div>
			<div class="modal-body">
				<div class="panel panel-primary main-content-panel">
					<div class="panel-heading">
						<h3 class="panel-title">View product</h3>
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-hover table-bordered" id="table_view_product">
								<tbody>
									<tr style="background-color:lightgrey">
										<th colspan="4">
											<h4>1. Product Details</h4>
										</th>
									</tr>
									<tr colspan="4">
										<th>Product Name :</th>
										<td id="view_prod_name">data</td>
									</tr>
									<tr>
										<th>Model / Part no. :</th>
										<td id="view_model_number">data</td>
										<th>Supplier Item No. :</th>
										<td id="view_supplier_item_no">data</td>
									</tr>

									<tr>
										<th>Category :</th>
										<td id="view_cat">data</td>
										<th>Sub-category :</th>
										<td id="view_sub_cat">data</td>
									</tr>
									<tr>
										<th>Unit :</th>
										<td id="view_prod_unit">data</td>
										<th>Brand :</th>
										<td id="view_prod_brand">
											<div></div>
										</td>
									</tr>
									<tr>
										<th>Product :</th>
										<td colspan="3" >
											<button class="btn btn-primary btn-sm" id="btn_view_log_prod">View <i class="fa fa-arrow-right"></i></button>
											<p id="view_logistic_prod" class="hidden">
												Length (cm): <span id="view_prod_length"></span><br/>
												Width (cm): <span id="view_prod_width"></span><br/>
												Height (cm): <span id="view_prod_height"></span><br/>
												Diameter (cm): <span id="view_prod_diameter"></span><br/>
												Weight (kg): <span id="view_prod_weight"></span><br/>
											</p>
										</td>
									</tr>
									<tr>
										<th>Retail Pack :</th>
										<td colspan="3" >
											<button class="btn btn-primary btn-sm" id="btn_view_log_retail">View <i class="fa fa-arrow-right"></i></button>
											<p id="view_logistic_retail" class="hidden">
												Length (cm): <span id="view_retail_length"></span><br/>
												Width (cm): <span id="view_retail_width"></span><br/>
												Height (cm): <span id="view_retail_height"></span><br/>
												Diameter (cm): <span id="view_retail_diameter"></span><br/>
												Weight (kg): <span id="view_retail_weight"></span><br/>
												Retail Box Quantity: <span id="view_retail_qty"></span><br/>
											</p>
										</td>
									</tr>
									<tr>
										<th>Inner Carton :</th>
										<td colspan="3" >
											<button class="btn btn-primary btn-sm" id="btn_view_log_inner">View <i class="fa fa-arrow-right"></i></button>
											<p id="view_logistic_inner" class="hidden">
												Length (cm): <span id="view_inner_length"></span><br/>
												Width (cm): <span id="view_inner_width"></span><br/>
												Height (cm): <span id="view_inner_height"></span><br/>
												Diameter (cm): <span id="view_inner_diameter"></span><br/>
												Weight (kg): <span id="view_inner_weight"></span><br/>
												Inner Box Quantity: <span id="view_inner_qty"></span><br/>
											</p>
										</td>
									</tr>
									<tr>
										<th>Export Carton :</th>
										<td colspan="3">
											<button class="btn btn-primary btn-sm" id="btn_view_log_export">View <i class="fa fa-arrow-right"></i></button>
											<p id="view_logistic_export" class="hidden">
												Length (cm): <span id="view_export_length"></span><br/>
												Width (cm): <span id="view_export_width"></span><br/>
												Height (cm): <span id="view_export_height"></span><br/>
												Diameter (cm): <span id="view_export_diameter"></span><br/>
												Weight (kg): <span id="view_export_weight"></span><br/>
												Export Box Quantity: <span id="view_export_qty"></span><br/>
												Max. weight of export carton (kg): <span id="view_export_max_weight"></span><br/>
												Export Carton CBM: <span id="view_export_cbm"></span><br/>
											</p>
										</td>
									</tr>
									{{-- <tr>
										<th>Goods Ready Date :</th>
										<td colspan="3" id="view_grd">data</td>
									</tr> --}}
									<tr>
										<th>Item Description :</th>
										<td colspan="3" id="view_item_desc">
										</td>
									</tr>
									<tr>
										<th>Additional Info :</th>
										<td colspan="3" id="view_add_info">
											<div></div>
										</td>
									</tr>

									<tr>
										<th>Product Photos : </th>
										<td colspan="3">
											<div id="view_prod_photos"></div>
										</td>
									</tr>
									<tr>
										<th>Product Spec / Technical Details :</th>
										<td colspan="3">
											<div id="view_prod_spec"></div>
										</td>
									</tr>
									<tr>
										<th>Art Work :</th>
										<td colspan="3">
											<div id="view_artwork"></div>
										</td>
									</tr>
									<tr>
										<th>Shipping Mark :</th>
										<td colspan="3">
											<div id="view_ship_mark"></div>
										</td>
									</tr>
									<tr>
										<th>Packing Details :</th>
										<td colspan="3">
											<div id="view_prod_details"></div>
										</td>
									</tr>
									<tr>
										<th>Other Photos :</th>
										<td colspan="3">
											<div id="view_other_photos"></div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						{{-- <div id="view_prod_photos">
              <label>Product Photos: </label><br/>
              <label>Product Spec / Technical Details :</label><br/>
              <label>Art Work :</label><br/>
              <label>Shipping Mark :</label><br/>
              <label>Packing Details :</label><br/>
              <label>Other Photos :</label><br/>
            </div> --}}
					</div>
				</div>
			</div>
			<div class="modal-footer">

				<button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-ban"></i> Close</button>
			</div>
		</div>

	</div>
</div>
