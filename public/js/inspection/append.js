
$(document).ready(function(){

  function serializeInputs(){
     $(".product_name").each(function() {
        var id = parseInt($(this).find('option:selected').val())
        product_id.push(id);
    });

    $('#product_ids').val(product_id);

    $(".qty").each(function() {
        qty.push($(this).val());
    });

    $(".gen_inspection_level").each(function() {
        gen_inspection_level.push($(this).val());
    });

    $(".gen_sample_size").each(function() {
        gen_sample_size.push($(this).val());
    });

    $(".special_inspection_level").each(function() {
        special_inspection_level.push($(this).val());
    });

    $(".special_sample_size").each(function() {
        special_sample_size.push($(this).val());
    });

    $(".minor").each(function() {
        minor.push($(this).val());
    });

    $(".major").each(function() {
        major.push($(this).val());
    });

    $(".crit").each(function() {
        crit.push($(this).val());
    });

    $(".functional").each(function() {
        fn.push($(this).val());
    });

  }

  $('body').on('change','.required', function(){
    if ($(this).val() != '') {
       $(this).css({
        'background':'#fff'
        });
    }
  });
  $('#first-next').click(function(){
    var empty = $('.step1').find(".required").filter(function() {
            return this.value == "";
    });
    if(empty.length){
      $('.step1').find(".required").each(function(){
        if ($(this).val() === '') {
           $(this).css({
            'background':'#ffcccc'
            });
        }else{
           $(this).css({
            'background':'#fff'
            });
        }
      });
    }else{
      $('.step1').hide(500);
      $('.step2').show(500);
      $('.f1-steps').find('.steps-active').removeClass('steps-active');
      $('.f1-step:nth-child(2)').addClass('steps-active');
    }
  });

  $('#second-next').click(function(){
    var empty = $('.step2').find(".required").filter(function() {
            return this.value == "";
    });
    if(empty.length){
      $('.step2').find(".required").each(function(){
        if ($(this).val() === '') {
                 $(this).css({
                  'background':'#ffcccc'
                  });
              }else{
           $(this).css({
            'background':'#fff'
            });
        }
        });
    }else{
      $('.step2').hide(500);
      $('.step3').show(500);
      $('.f1-steps').find('.steps-active').removeClass('steps-active');
      $('.f1-step:nth-child(3)').addClass('steps-active');
    }
  });

  $('#third-next').click(function(){
    var empty = $('.step3').find(".required").filter(function() {
            return this.value == "";
    });
    console.log(empty.length);  
    if(empty.length){
      $('.step3').find(".required").each(function(){
        if ($(this).val() === '') {
                 $(this).css({
                  'background':'#ffcccc'
                  });
              }else{
           $(this).css({
            'background':'#fff'
            });
        }
        });
    }else{
        if ($('#file_upload_container').children().length == 0) {
          $('#confirmationModal').modal();
        }else{
          productValidation();
          serializeInputs();
        }
    }
  });

  $('#fourth-next').click(function(){
    var empty = $('.step4').find(".required").filter(function() {
            return this.value == "";
    });
    console.log(empty.length);  
    if(empty.length){
      $('.step4').find(".required").each(function(){
        if ($(this).val() === '') {
                 $(this).css({
                  'background':'#ffcccc'
                  });
              }else{
           $(this).css({
            'background':'#fff'
            });
        }
        });
    }else{
      $('.step4').hide(500);
      $('.step5').show(500);
      $('.f1-steps').find('.steps-active').removeClass('steps-active');
      $('.f1-step:nth-child(5)').addClass('steps-active');
    }
  });

  $('#first-back').click(function(){
      $('.step1').show(500);
      $('.step2').hide(500);
      $('.f1-steps').find('.steps-active').removeClass('steps-active');
      $('.f1-step:nth-child(1)').addClass('steps-active');
  });

  $('#second-back').click(function(){
      $('.step2').show(500);
      $('.step3').hide(500);
      $('.f1-steps').find('.steps-active').removeClass('steps-active');
      $('.f1-step:nth-child(2)').addClass('steps-active');
  });

  $('#third-back').click(function(){
      products = [];
      po_quantity = [];
      visual = [];
      functional = [];
      product_id = [];
      qty = [];
      gen_inspection_level = [];
      gen_sample_size = [];
      special_inspection_level = [];
      special_sample_size = [];
      minor = [];
      major = [];
      crit = [];
      fn = [];

      $('.product-row').remove();
      $('.step3').show(500);
      $('.step4').hide(500);
      $('.f1-steps').find('.steps-active').removeClass('steps-active');
      $('.f1-step:nth-child(3)').addClass('steps-active');
  });

  $('#fourth-back').click(function(){
      $('.step4').show(500);
      $('.step5').hide(500);
      $('.f1-steps').find('.steps-active').removeClass('steps-active');
      $('.f1-step:nth-child(4)').addClass('steps-active');
  });
  $('#yes_confirm').click(function(){
    productValidation();
    $('#confirmationModal').modal('hide');
  })
  $('#no_confirm').click(function(){
    $('#confirmationModal').modal('hide');
  })
  function productValidation(){
          $(".product_name").each(function() {
              products.push($(this).find('option:selected').text());
          });
          $(".qty").each(function() {
              po_quantity.push($(this).val());
          });

          $(".gen_sample_size").each(function() {
              visual.push($(this).val());
          });

          $(".special_sample_size").each(function() {
              functional.push($(this).val());
          });
          var sample_size = Math.max(...visual);

          if(sample_size <=315){
            manday = 1;
          }else if(sample_size >= 316 && sample_size<=500){
            manday = 2;
          }else if(sample_size >=501 && sample_size<=799){
            manday = 3;
          }else if(sample_size >=800 && sample_size<=1249){
            manday = 4;
          }else if(sample_size >=1250 && sample_size<=1999){
            manday = 5;
          }else if(sample_size >= 2000){
            manday = 6;
          }

          for (var i = 0; i <= products.length-1; i++) {
            var table_row = '<tr class="product-row">'+
                  '<td>'+products[i]+'</td>'+
                  '<td>'+po_quantity[i]+'</td>'+
                  '<td>'+visual[i]+'</td>'+
                  '<td>'+functional[i]+'</td>'+
                  '<td>'+manday+'</td>'+
                '</tr>';
            $('#summary-table').append(table_row);   
            $('#manday').val(manday);            
          }
          $('.step3').hide(500);
          $('.step4').show(500);
          $('.f1-steps').find('.steps-active').removeClass('steps-active');
          $('.f1-step:nth-child(4)').addClass('steps-active');
  }
  
});