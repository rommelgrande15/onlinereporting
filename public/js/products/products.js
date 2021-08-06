$(document).ready(function(){
	$('#products_table').dataTable();

	$('.readonly').each(function(){
		$(this).prop('disabled', true);
	});

	$('body').on('click','.btn_product_details',function(){
		var id = $(this).data('id');
		$('#edit_product_id').val(id);
		$.ajax({
			url : selectproduct,
			type: 'POST',
			data:{
				_token : token,
				product_id : id
			},
			success: function(response){
				console.log(response);
				$('#edit_product_name').val(response.product.product_name);
				$('#edit_product_category').val(response.product.product_category);
				$('#edit_product_unit').val(response.product.product_unit);
				$('#edit_po_no').val(response.product.po_no);
				$('#edit_brand').val(response.product.brand);
				$('#edit_cmf').val(response.product.cmf);
				$('#edit_tech_specs').val(response.product.tech_specs);
				$('#edit_shipping_mark').val(response.product.shipping_mark);
				$('#edit_additional_product_info').val(response.product.additional_product_info);

				$('#updateProductModal').modal();
			}
		})
	});

	 $('#save_product_details').click(function(){
          var empty = $(".required-field-product").filter(function() {
              return this.value == "";
          });

          if(empty.length) {
              $(".required-field-product").each(function(){
                if ($(this).val() === '') {
                   $(this).css({
                    'background':'#ffcccc'
                    });
                }
              });
          }else{
              $.ajax({
                url : newproduct,
                type : 'POST',
                data: {
                  _token: token,
                  new_product_name: $('#new_product_name').val(),
                  new_product_category: $('#new_product_category').val(),
                  new_product_unit: $('#new_product_unit').val(),
                  new_po_no: $('#new_po_no').val(),
                  new_brand: $('#new_brand').val(),
                  new_cmf: $('#new_cmf').val(),
                  new_tech_specs: $('#new_tech_specs').val(),
                  new_shipping_mark: $('#new_shipping_mark').val(),
                  new_additional_product_info: $('#new_additional_product_info').val()
                },
                success : function(response){
                  location.reload();
                }
              });
          }
      });

	 $.getJSON("json/categories.json", function(obj) {
        $.each(obj,function (i,optgroups){
          $.each(optgroups, function(groupName, options) {
            var $optgroup = $("<optgroup>", {
                    label: groupName
            });

            

            $.each(options, function(j, option) {
                    var $option = $("<option>", {
                        text: option.text,
                        value: option.value
                    });
                    $option.appendTo($optgroup);
                });
            $optgroup.appendTo('.categories');
          });
        });
    });

	 /*$('#close_product_modal').click(function(){

	 	$('.readonly').each(function(){
			$(this).val('');
			$(this).prop('disabled',true);
			$(this).css('background-color', '#eee');
		});
		$('#update_product_details').hide();
		$('#edit_product_details').show();


	 });*/
  $("#updateProductModal").on("hidden.bs.modal", function () {
      $('.readonly').each(function(){
        $(this).val('');
        $(this).prop('disabled',true);
        $(this).css('background-color', '#eee');
      });
      $('#update_product_details').hide();
      $('#edit_product_details').show();
  });

	$('#edit_product_details').click(function(){
		$(this).hide();
		$('#update_product_details').show();
		$('.readonly').each(function(){
			$(this).prop('disabled',false);
			$(this).css('background-color', '#fff');
		});
	});

	$('#update_product_details').click(function(){
          	$.ajax({
          		url : updateproduct,
          		type : 'POST',
          		data : {
          			_token : token,
          			product_id : $('#edit_product_id').val(),
          			edit_product_name : $('#edit_product_name').val(),
      					edit_product_category: $('#edit_product_category').val(),
      					edit_product_unit: $('#edit_product_unit').val(),
      					edit_po_no: $('#edit_po_no').val(),
      					edit_brand: $('#edit_brand').val(),
      					edit_cmf: $('#edit_cmf').val(),
      					edit_tech_specs: $('#edit_tech_specs').val(),
      					edit_shipping_mark: $('#edit_shipping_mark').val(),
      					edit_additional_product_info: $('#edit_additional_product_info').val(),
          		},
          		success : function(){
          			location.reload();
          		}
          	});
	});

  $('body').on('click','.btn_delete_product',function(){
    var id = $(this).data('id');
    $('#delete_product_id').val(id);
    $('#deleteProductModal').modal();
  });

  $('#delete_product_details').click(function(){
    $.ajax({
              url : deleteproduct,
              type : 'POST',
              data : {
                _token : token,
                product_id : $('#delete_product_id').val(),
               
              },
              success : function(){
                location.reload();
              }
            });
  });
});