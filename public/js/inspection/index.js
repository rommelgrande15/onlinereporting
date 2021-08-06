$(window).on('load',function() {
    // Animate loader off screen
    $(".se-pre-con").fadeOut("slow");
});
var products = new Array();
var po_quantity = new Array();
var visual = new Array();
var functional = new Array();
var manday = new Array();
var product_id = new Array();
var qty = new Array();
var gen_inspection_level = new Array();
var gen_sample_size = new Array();
var special_inspection_level = new Array();
var special_sample_size = new Array();
var minor = new Array();
var major = new Array();
var crit = new Array();
var fn = new Array();

var count = 0;
var form = $("#inspection-form");
var steps = 0;
console.log(products);

function addDays(date, days) {
  var dat = date;
  dat.setDate(dat.getDate() + days);
  return dat;
}

$(document).ready(function(){
var datetoday = new Date().toISOString().slice(0, 10);
console.log(datetoday);
$("#inspection_date").datepicker({
    changeMonth: true,
    changeYear: true,
    dateFormat: 'yy-mm-dd',
    minDate: 1,
    numberOfMonths: 2,
    showMonthAfterYear: true,
    onSelect: function(selectedDate) {
      $('#summary_inspection_date').text(convertDateToWords(selectedDate));
      $('#shipment_date').datepicker('option', 'minDate', addDays(new Date(selectedDate), 1));
      var today = moment(datetoday, 'YYYY/MM/DD');
      var date_select = moment($(this).val(), 'YYYY/MM/DD');
      $(this).css('background','#fff');
      var days = date_select.diff(today, 'days');
        if (days <= 1){
          $('#alert-me').fadeIn('slow');
        }else{
          $('#alert-me').fadeOut('slow');
        }
    }
  });
  $("#shipment_date").datepicker({
    changeMonth: true,
    changeYear: true,
    dateFormat: 'yy-mm-dd',
    numberOfMonths: 2,
    showMonthAfterYear: true,
    onSelect: function(selectedDate) {
      console.log(selectedDate)
      $('#inspection_date').datepicker('option', 'maxDate', $(this).val());
      $(this).css('background','#fff');
    }
  });

  $('#close-me').click(function(){
    $('#alert-me').fadeOut('slow');
  })
    $('#save_factory').click(function(){
        var empty = $(".required-field").filter(function() {
            return this.value == "";
        });
        if(empty.length) {
            $(".required-field").each(function(){
              if ($(this).val() === '') {
                 $(this).css({
                  'background':'#ffcccc'
                  });
              }
            });
            
        }else{
          if (isValidEmailAddress($('#new_email_address').val())) {
            $.ajax({
              url : url,
              type : 'POST',
              data: {
                _token: token,
                new_factory_name: $('#new_factory_name').val(),
                new_factory_address: $('#new_factory_address').val(),
                new_country: $('#new_country').val(),
                new_city: $('#new_city').val(),
                new_contact_person: $('#new_contact_person').val(),
                new_contact_number: $('#new_contact_number').val(),
                new_email_address: $('#new_email_address').val(),
              },
              success : function(response){
                $('#new_factory_name').val('');
                $('#new_factory_address').val('');
                $('#new_country').val('');
                $('#new_city').val('');
                $('#new_contact_person').val('');
                $('#new_contact_number').val('');
                $('#new_email_address').val('');

                $('#factory_name').append('<option value='+response.factory.id +' selected>'+response.factory.factory_name+'</option>');
                $('#factory_address').val(response.factory.factory_address);
                $('#country').val(response.factory.factory_country);
                $('#city').val(response.factory.factory_city);
                $('#contact_person').val(response.factory.factory_contact_person);
                $('#contact_number').val(response.factory.factory_contact_number);
                $('#email_address').val(response.factory.factory_email);

                $('#factoryModal').modal('hide');
              }
            });

          }else{
            $('#email-error').html('Invalid email address!');
          }
          
        }
    });

    $(".required-field").on('change',function(){
        if ($(this).val() != '') {
          $(this).css({
            'background':'#fff'
          })
        }
    });

    $('#factory_name').on('change',function(){
      $.ajax({
        url : getfactory,
        type: 'POST',
        data:{
          _token : token,
          id : $('#factory_name option:selected').val(),
        },
        beforeSend: function(){
          $('#factory-loading').show();
        },
        success: function(response){
          console.log(response)
          $('#factory-loading').hide();
          $('#factory_address').val(response.factory.factory_address);
          $('#country').val(response.factory.factory_country);
          $('#city').val(response.factory.factory_city);
          $('#contact_person').val(response.factory.factory_contact_person);
          $('#contact_number').val(response.factory.factory_contact_number);
          $('#email_address').val(response.factory.factory_email);
        }
      });
    }); 
    var loading = function() {
        var over = '<div id="overlay">' +
            '<img id="loading" src="/images/loader-64x/Preloader_9.gif">' +
            '</div>';
        $(over).appendTo('body');
    };

    var success = function() {
        $('#loading').remove();
        $('<img id="loading" src="/images/loader-64x/success.png">').appendTo('#overlay');
    };

    $('#test').click(function(){
     
       loading();

      setTimeout(function(){
       success();
      }, 3000);

      setTimeout(function(){
        $('#overlay').remove();
        window.location.href = '/dashboard';
      }, 6000);
    })
    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone("div.file_upload", {
        url: upload,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        autoProcessQueue: false,
        addRemoveLinks: true,
        uploadMultiple: true,
        parallelUploads: 100,
        maxFiles: 100,
        maxFilesize: 500,
        paramName: "file",
        init: function(){
            $("#confirm_booking_btn").click(function(e) {
              e.preventDefault();
              e.stopPropagation();
              myDropzone.processQueue();
              loading();
            });
            this.on("sendingmultiple", function(data, xhr, formData) {
                
                $(".product_name").each(function(){
                  formData.append("product_name[]", $(this).val());
                });
                $(".qty").each(function(){
                  formData.append("qty[]", $(this).val());
                });
                $(".gen_inspection_level").each(function(){
                  formData.append("gen_inspection_level[]", $(this).val());
                });
                $(".gen_sample_size").each(function(){
                  formData.append("gen_sample_size[]", $(this).val());
                });
                $(".special_inspection_level").each(function(){
                  formData.append("special_inspection_level[]", $(this).val());
                });
                $(".special_sample_size").each(function(){
                  formData.append("special_sample_size[]", $(this).val());
                });
                $(".minor").each(function(){
                  formData.append("minor[]", $(this).val());
                });
                $(".major").each(function(){
                  formData.append("major[]", $(this).val());
                });
                $(".crit").each(function(){
                  formData.append("crit[]", $(this).val());
                });
                $(".functional").each(function(){
                  formData.append("functional[]", $(this).val());
                });
                
                formData.append("service_type", $("#service_type").val());
                formData.append("reference_number", $("#reference_number").val());
                formData.append("factory_name", $("#factory_name").val());
                formData.append("inspection_date", $("#inspection_date").val());
                formData.append("change_date", $("#change_date").val());
                formData.append("shipment_date", $("#shipment_date").val());
                formData.append("reference_sample", $("#reference_sample").val());
                formData.append("courier", $("#courier").val());
                formData.append("tracking_number", $("#tracking_number").val());
                formData.append("change_inspection_schedule", $("#change_inspection_schedule").val());
                formData.append("more_info", $("#more_info").val());
                formData.append("manday", $("#manday").val());

            });
            this.on("successmultiple", function(files, response) {
              success();
              setTimeout(function(){
                $('#overlay').remove();
                window.location.href = '/dashboard';
              }, 3000);
            });
            this.on("errormultiple", function(files, response) {
              console.log('error sending')
            });
        }
    });

     

    $('#confirm_booking_btn').click(function(){
         $("div.file_upload").processQueue(); 
    });

    $.getJSON("json/categories.json", function(json) {
        $.each(json,function (i,optgroups){
          $.each(optgroups, function(groupName, options) {
            var $optgroup = $("<optgroup>", {
                    label: groupName
            });

            $.each(options, function(j, option) {
                    var $option = $("<option>", {
                        text: option.text,
                        value: option.val
                    });
                    $option.appendTo($optgroup);
                });
            $optgroup.appendTo('.categories');  
          });
        });
    });

    var aql_options =  {
      "" : "--",
      "0.065" : "0.065",
      "0.10" : "0.10",
      "0.15" : "0.15",
      "0.25" : "0.25",
      "0.4" : "0.4",
      "0.65" : "0.65",
      "1.0" : "1.0",
      "1.5" : "1.5",
      "2.5" : "2.5",
      "4.0" : "4.0",
      "6.5" : "6.5",
      "10.0" : "10"
    };

    $.each(aql_options,function(key, value) 
    {
        $('.aql_select').append('<option value=' + key + '>' + value + '</option>');
    });


    $('#add_product_btn').click(function(){
      var count = count + 1; 
      $( ".product-container" ).first().clone().find("input:text, select, textarea").val("").end().appendTo( ".product-pane" );
    });

    $('body').on('click','.delete-product', function(){
      $(this).closest('.product-container').remove();
    })

    $('#reference_sample').on('change',function(){
      if ($(this).val() != 'No Sample') {
        $('#courier').addClass("required");
        $('#tracking_number').addClass("required");

        $('.with-sample').show(500);
        $('#courier').val("");
        $('#tracking_number').val("");
        $('#change_inspection_schedule').val("");
        $('#more_info').val("");
      }else{
        $('#courier').removeClass("required");
        $('#tracking_number').removeClass("required");
        $('.with-sample').hide(500);
        
      }
    });

    select_service();
    $('#service_type').on('change',select_service);

    function select_service(){
      var type = $('#service_type option:selected').text();
       $('#summary_service_type').html(type);
    }



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
                  $('#new_product_name').val('');
                  $('#new_product_category').val('');
                  $('#new_product_unit').val('');
                  $('#new_po_no').val('');
                  $('#new_brand').val('');
                  $('#new_cmf').val('');
                  $('#new_tech_specs').val('');
                  $('#new_shipping_mark').val('');
                  $('#new_additional_product_info').val('');
                  $('.products-list').append('<option value="'+response.product.id+'">'+response.product.product_name+'</option>')
                  $('#productModal').modal('hide');
                }
              });
          }
      });

      $('body').on('change','.product_name', function(){
        var product_id = $(this).find('option:selected').val();
        var dis = $(this);
        if (dis.val() == '') {
          dis.closest('.product-container').find('.shipping_mark').val('');
          dis.closest('.product-container').find('.po_no').val('');
          dis.closest('.product-container').find('.product_category').val('');
          dis.closest('.product-container').find('.brand').val('');
          dis.closest('.product-container').find('.cmf').val('');
          dis.closest('.product-container').find('.unit').val('');
          dis.closest('.product-container').find('.tech_specs').val('');
          dis.closest('.product-container').find('.additional_info').val('');
        }else{
          $.ajax({
              url : selectproduct,
              type: 'POST',
              data:{
                _token : token,
                product_id : product_id
              },
              beforeSend: function(){
                console.log('loading');
              },
              success: function(response){
                  console.log(response);
                  dis.closest('.product-container').find('.shipping_mark').val(response.product.shipping_mark);
                  dis.closest('.product-container').find('.po_no').val(response.product.po_no);
                  dis.closest('.product-container').find('.product_category').val(response.product.product_category);
                  dis.closest('.product-container').find('.brand').val(response.product.brand);
                  dis.closest('.product-container').find('.cmf').val(response.product.cmf);
                  dis.closest('.product-container').find('.unit').val(response.product.product_unit);
                  dis.closest('.product-container').find('.tech_specs').val(response.product.tech_specs);
                  dis.closest('.product-container').find('.additional_info').val(response.product.additional_product_info);
                  var tt = dis.find('option:selected').text();
              }
          });
        }
        
      });

      $('body').on('click','.btn-aql-modal',function(){
        var this_btn = $(this);
        this_btn.closest('.product-container').find('.aqlModal').modal();
      });
    
      $('body').on('change','.gen_inspection_level',function(){
        var gen = $(this);
        var quantity = gen.closest('.aqlModal').find('.qty').val();
        var general_sample_size = gensample(quantity, gen.val());
         gen.closest('.aqlModal').find('.gen_sample_size').val(general_sample_size);
      });

      $('body').on('change','.special_inspection_level',function(){
        var special = $(this);
        var quantity = special.closest('.aqlModal').find('.qty').val();
        var special_sample_size = specialsample(quantity, special.val());
        special.closest('.aqlModal').find('.special_sample_size ').val(special_sample_size);
      });


      $('body').on('change','.qty',function(){
        var quantity = $(this);
        var gen = quantity.closest('.aqlModal').find('.gen_inspection_level').val();
        var general_sample_size = gensample(quantity.val(), gen);
        quantity.closest('.aqlModal').find('.gen_sample_size').val(general_sample_size);

        var special = quantity.closest('.aqlModal').find('.special_inspection_level').val();
        var special_sample_size = specialsample(quantity.val(), special);
        quantity.closest('.aqlModal').find('.special_sample_size ').val(special_sample_size);

      });

      $('body').on('click','.btn-aql-confirm',function(){
        var confirm = $(this);
        var aql_field = $('.aql_field')
        var this_modal = confirm.closest('.aqlModal');

        var aql_fields =  confirm.closest('.aqlModal').find('.aql_field').filter(function() {
              return this.value == "";  
        });

        if(aql_fields.length){
          aql_field.each(function(i,val){
            if ($(this).val() == '') {
              $(this).css('background','#ffcccc');
            }else{
              $(this).css('background','#ffffff');
            }
          });
        }else{
          var product_qty = confirm.closest('.aqlModal').find('.qty').val();
          var copy = this_modal.closest('.product-container').find('.product_qty').val(product_qty);
          confirm.closest('.aqlModal').modal('hide');

          
        }
      });


      $('.actions>ul>li:nth-child(2)>a').click(function(){
        steps = steps + 1;
        console.log(steps);
      });

      $('.actions>ul>li:nth-child(1)>a').click(function(){
          steps = steps - 1;
          console.log(steps);
      });
});