function findpst(clicked_id) {

    x = clicked_id;

    intStr1 = x.replace(/[A-Za-z$-]/g, "");
    //  alert(intStr1);
    var z = document.getElementById('pstcodee' + intStr1).value;

    $('#pst_report_data_id').val(z);
    $.ajax({
        url: '/onlinereport/getpstcodedata/' + z,
        type: 'GET',
        success: function(response) {
            $('#partnumberr' + intStr1 + ' option').remove();
            $('#partnumberr' + intStr1).append($('<option value="">Select Part Number</option>'));
            var count = response.main_part_qty.length;
            for (var i = 0; i <= count - 1; i++) {
                $('#partnumberr' + intStr1).append($("<option></option>").attr("value", response.main_part_qty[i].partnumberr).text(response.main_part_qty[i].part_number));
            }

        }
    });
}

function findpartno(clicked_id) {

    x = clicked_id;

    intStr1 = x.replace(/[A-Za-z$-]/g, "");
    //  alert(intStr1);
    var z = document.getElementById('partnumberr' + intStr1).value;
    $.ajax({
        url: '/onlinereport/getmainpartdata/' + z,
        type: 'GET',
        success: function(response) {
            $('#manufacture_code' + intStr1).val(response.pst_code_main_part_data_report_id.manufacture_code);
            $('#description' + intStr1).val(response.pst_code_main_part_data_report_id.description);
            $('#bom_qty' + intStr1).val(response.pst_code_main_part_data_report_id.bom_qty);
            $('#total_packaging' + intStr1).val(response.pst_code_main_part_data_report_id.total_packaging);
            $('#qty_pcs' + intStr1).val(response.pst_code_main_part_data_report_id.qty_pcs);
            $('#carton_size' + intStr1).val(response.pst_code_main_part_data_report_id.carton_size_weight);
        },
    });
}
$(document).ready(function() {

    $("#part_number").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });
    // $("#part_number").select2({ dropdownAutoWidth: true, width: 'auto' });


    $('#pst_code').on('change', function() {
        //	alert('hi');
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/onlinereport/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number option').remove();
                $('#part_number').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/onlinereport/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    // $('#main_part_qty').on('change', function() {
    //     $('#pst_main_part_data_id').val($(this).val());
    //     $.ajax({
    //         url: '/getpartnumber/' + $(this).val(),
    //         type: 'GET',
    //         success: function(response) {
    //             $('#part_number option').remove();
    //             $('#part_number').append($('<option value="">Select Part Number</option>'));
    //             var count = response.pst_code_data_report_filling.length;
    //             for (var i = 0; i <= count - 1; i++) {
    //                 $('#part_number').append($("<option></option>").attr("value", response.pst_code_data_report_filling[i].part_number).text(response.pst_code_data_report_filling[i].part_number));
    //             }
    //         }
    //     });
    // });

    $("#part_number2").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code2').on('change', function() {
        //alert($(this).val());
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/onlinereport/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number2 option').remove();
                $('#part_number2').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number2').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number2').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/onlinereport/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code2').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description2').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty2').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging2').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs2').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size2').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number3").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code3').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/onlinereport/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number3 option').remove();
                $('#part_number3').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number3').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number3').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/onlinereport/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code3').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description3').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty3').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging3').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs3').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size3').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number4").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code4').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/onlinereport/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number4 option').remove();
                $('#part_number4').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number4').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number4').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/onlinereport/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code4').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description4').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty4').val(response.pst_code_main_part_data_report_id.bom_qty);

                $('#total_packaging4').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs4').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size4').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number5").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code5').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/onlinereport/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number5 option').remove();
                $('#part_number5').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number5').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number5').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/onlinereport/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code5').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description5').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty5').val(response.pst_code_main_part_data_report_id.bom_qty);


                $('#total_packaging5').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs5').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size5').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number6").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code6').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/onlinereport/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number6 option').remove();
                $('#part_number6').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number6').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number6').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/onlinereport/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code6').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description6').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty6').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging6').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs6').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size6').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number7").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code7').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number7 option').remove();
                $('#part_number7').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number7').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number7').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code7').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description7').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty7').val(response.pst_code_main_part_data_report_id.bom_qty);


                $('#total_packaging7').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs7').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size7').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number8").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code8').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number8 option').remove();
                $('#part_number8').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number8').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number8').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code8').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description8').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty8').val(response.pst_code_main_part_data_report_id.bom_qty);

                $('#total_packaging8').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs8').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size8').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number9").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code9').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number9 option').remove();
                $('#part_number9').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number9').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number9').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code9').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description9').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty9').val(response.pst_code_main_part_data_report_id.bom_qty);

                $('#total_packaging9').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs9').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size9').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number10").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code10').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number10 option').remove();
                $('#part_number10').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number10').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number10').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code10').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description10').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty10').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging10').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs10').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size10').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number11").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code11').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number11 option').remove();
                $('#part_number11').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number11').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number11').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code11').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description11').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty11').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging11').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs11').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size11').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number12").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code12').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number12 option').remove();
                $('#part_number12').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number12').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number12').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code12').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description12').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty12').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging12').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs12').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size12').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number13").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code13').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number13 option').remove();
                $('#part_number13').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number13').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number13').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code13').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description13').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty13').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging13').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs13').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size13').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number14").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code14').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number14 option').remove();
                $('#part_number14').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number14').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number14').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code14').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description14').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty14').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging14').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs14').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size14').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number15").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code15').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number15 option').remove();
                $('#part_number15').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number15').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number15').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code15').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description15').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty15').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging15').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs15').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size15').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number16").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code16').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number16 option').remove();
                $('#part_number16').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number16').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number16').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code16').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description16').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty16').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging16').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs16').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size16').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number17").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code17').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number17 option').remove();
                $('#part_number17').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number17').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number17').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code17').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description17').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty17').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging17').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs17').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size17').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number18").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code18').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number18 option').remove();
                $('#part_number18').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number18').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number18').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code18').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description18').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty18').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging18').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs18').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size18').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number19").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code19').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number19 option').remove();
                $('#part_number19').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number19').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number19').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code19').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description19').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty19').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging19').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs19').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size19').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number20").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code20').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number20 option').remove();
                $('#part_number20').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number20').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number20').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code20').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description20').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty20').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging20').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs20').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size20').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number21").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code21').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number21 option').remove();
                $('#part_number21').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number21').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number21').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code21').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description21').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty21').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging21').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs21').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size21').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number22").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code22').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number22 option').remove();
                $('#part_number22').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number22').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number22').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code22').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description22').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty22').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging22').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs22').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size22').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number23").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code23').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number23 option').remove();
                $('#part_number23').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number23').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number23').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code23').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description23').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty23').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging23').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs23').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size23').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number24").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code24').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number24 option').remove();
                $('#part_number24').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number24').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number24').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code24').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description24').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty24').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging24').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs24').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size24').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number25").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code25').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number25 option').remove();
                $('#part_number25').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number25').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number25').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code25').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description25').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty25').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging25').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs25').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size25').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number26").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code26').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number26 option').remove();
                $('#part_number26').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number26').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number26').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code26').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description26').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty26').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging26').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs26').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size26').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number27").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code27').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number27 option').remove();
                $('#part_number27').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number27').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number27').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code27').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description27').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty27').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging27').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs27').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size27').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number28").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code28').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number28 option').remove();
                $('#part_number28').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number28').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number28').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code28').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description28').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty28').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging28').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs28').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size28').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number29").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code29').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number29 option').remove();
                $('#part_number29').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number29').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number29').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code29').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description29').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty29').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging29').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs29').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size29').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number30").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code30').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number30 option').remove();
                $('#part_number30').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number30').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number30').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code30').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description30').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty30').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging30').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs30').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size30').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number31").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code31').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number31 option').remove();
                $('#part_number31').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number31').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number31').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code31').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description31').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty31').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging31').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs31').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size31').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number32").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code32').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number32 option').remove();
                $('#part_number32').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number32').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number32').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code32').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description32').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty32').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging32').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs32').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size32').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number33").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code33').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number33 option').remove();
                $('#part_number33').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number33').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number33').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code33').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description33').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty33').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging33').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs33').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size33').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number34").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code34').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number34 option').remove();
                $('#part_number34').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number34').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number34').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code34').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description34').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty34').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging34').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs34').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size34').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number35").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code35').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number35 option').remove();
                $('#part_number35').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number35').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number35').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code35').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description35').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty35').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging35').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs35').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size35').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number36").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code36').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number36 option').remove();
                $('#part_number36').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number36').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number36').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code36').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description36').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty36').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging36').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs36').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size36').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number37").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code37').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number37 option').remove();
                $('#part_number37').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number37').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number37').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code37').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description37').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty37').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging37').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs37').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size37').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number38").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code38').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number38 option').remove();
                $('#part_number38').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number38').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number38').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code38').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description38').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty38').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging38').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs38').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size38').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number39").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code39').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number39 option').remove();
                $('#part_number39').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number39').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number39').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code39').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description39').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty39').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging39').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs39').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size39').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number40").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code40').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number40 option').remove();
                $('#part_number40').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number40').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number40').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code40').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description40').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty40').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging40').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs40').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size40').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number41").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code41').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number41 option').remove();
                $('#part_number41').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number41').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number41').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code41').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description41').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty41').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging41').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs41').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size41').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number42").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code42').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number42 option').remove();
                $('#part_number42').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number42').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number42').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code42').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description42').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty42').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging42').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs42').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size42').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number43").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code43').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number43 option').remove();
                $('#part_number43').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number43').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number43').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code43').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description43').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty43').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging43').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs43').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size43').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number44").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code44').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number44 option').remove();
                $('#part_number44').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number44').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number44').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code44').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description44').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty44').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging44').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs44').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size44').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number45").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code45').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number45 option').remove();
                $('#part_number45').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number45').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number45').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code45').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description45').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty45').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging45').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs45').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size45').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number46").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code46').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number46 option').remove();
                $('#part_number46').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number46').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number46').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code46').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description46').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty46').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging46').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs46').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size46').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number47").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code47').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number47 option').remove();
                $('#part_number47').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number47').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number47').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code47').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description47').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty47').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging47').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs47').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size47').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number48").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code48').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number48 option').remove();
                $('#part_number48').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number48').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number48').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code48').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description48').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty48').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging48').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs48').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size48').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number49").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code49').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number49 option').remove();
                $('#part_number49').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number49').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number49').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code49').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description49').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty49').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging49').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs49').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size49').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number50").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code50').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number50 option').remove();
                $('#part_number50').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number50').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number50').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code50').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description50').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty50').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging50').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs50').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size50').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number51").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code51').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number51 option').remove();
                $('#part_number51').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number51').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number51').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code51').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description51').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty51').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging51').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs51').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size51').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number52").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code52').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number52 option').remove();
                $('#part_number52').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number52').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number52').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code52').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description52').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty52').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging52').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs52').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size52').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number53").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code53').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number53 option').remove();
                $('#part_number53').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number53').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number53').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code53').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description53').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty53').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging53').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs53').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size53').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number54").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code54').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number54 option').remove();
                $('#part_number54').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number54').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number54').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code54').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description54').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty54').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging54').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs54').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size54').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number55").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code55').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number55 option').remove();
                $('#part_number55').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number55').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number55').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code55').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description55').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty55').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging55').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs55').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size55').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number56").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code56').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number56 option').remove();
                $('#part_number56').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number56').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number56').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code56').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description56').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty56').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging56').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs56').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size56').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number57").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code57').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number57 option').remove();
                $('#part_number57').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number57').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number57').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code57').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description57').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty57').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging57').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs57').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size57').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number58").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code58').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number58 option').remove();
                $('#part_number58').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number58').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number58').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code58').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description58').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty58').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging58').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs58').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size58').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number59").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code59').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number59 option').remove();
                $('#part_number59').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number59').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number59').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code59').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description59').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty59').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging59').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs59').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size59').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number60").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code60').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number60 option').remove();
                $('#part_number60').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number60').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number60').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code60').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description60').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty60').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging60').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs60').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size60').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number61").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code61').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number61 option').remove();
                $('#part_number61').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number61').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number61').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code61').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description61').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty61').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging61').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs61').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size61').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number62").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code62').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number62 option').remove();
                $('#part_number62').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number62').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number62').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code62').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description62').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty62').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging62').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs62').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size62').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number63").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code63').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number63 option').remove();
                $('#part_number63').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number63').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number63').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code63').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description63').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty63').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging63').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs63').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size63').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number64").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code64').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number64 option').remove();
                $('#part_number64').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number64').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number64').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code64').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description64').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty64').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging64').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs64').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size64').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number65").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code65').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number65 option').remove();
                $('#part_number65').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number65').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number65').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code65').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description65').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty65').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging65').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs65').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size65').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number66").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code66').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number66 option').remove();
                $('#part_number66').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number66').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number66').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code66').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description66').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty66').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging66').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs66').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size66').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number67").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code67').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number67 option').remove();
                $('#part_number67').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number67').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number67').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code67').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description67').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty67').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging67').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs67').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size67').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number68").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code68').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number68 option').remove();
                $('#part_number68').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number68').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number68').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code68').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description68').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty68').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging68').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs68').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size68').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number69").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code69').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number69 option').remove();
                $('#part_number69').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number69').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number69').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code69').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description69').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty69').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging69').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs69').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size69').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number70").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code70').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number70 option').remove();
                $('#part_number70').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number70').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number70').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code70').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description70').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty70').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging70').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs70').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size70').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number71").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code71').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number71 option').remove();
                $('#part_number71').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number71').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number71').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code71').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description71').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty71').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging71').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs71').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size71').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number72").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code72').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number72 option').remove();
                $('#part_number72').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number72').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number72').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code72').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description72').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty72').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging72').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs72').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size72').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number73").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code73').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number73 option').remove();
                $('#part_number73').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number73').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number73').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code73').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description73').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty73').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging73').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs73').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size73').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number74").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code74').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number74 option').remove();
                $('#part_number74').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number74').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number74').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code74').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description74').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty74').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging74').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs74').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size74').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number75").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code75').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number75 option').remove();
                $('#part_number75').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number75').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number75').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code75').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description75').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty75').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging75').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs75').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size75').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number76").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code76').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number76 option').remove();
                $('#part_number76').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number76').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number76').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code76').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description76').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty76').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging76').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs76').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size76').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number77").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code77').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number77 option').remove();
                $('#part_number77').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number77').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number77').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code77').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description77').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty77').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging77').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs77').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size77').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number78").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code78').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number78 option').remove();
                $('#part_number78').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number78').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number78').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code78').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description78').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty78').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging78').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs78').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size78').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number79").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code79').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number79 option').remove();
                $('#part_number79').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number79').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number79').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code79').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description79').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty79').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging79').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs79').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size79').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number80").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code80').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number80 option').remove();
                $('#part_number80').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number80').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number80').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code80').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description80').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty80').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging80').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs80').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size80').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number81").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code81').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number81 option').remove();
                $('#part_number81').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number81').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number81').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code81').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description81').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty81').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging81').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs81').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size81').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number82").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code82').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number82 option').remove();
                $('#part_number82').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number82').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number82').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code82').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description82').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty82').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging82').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs82').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size82').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number83").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code83').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number83 option').remove();
                $('#part_number83').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number83').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number83').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code83').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description83').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty83').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging83').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs83').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size83').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number84").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code84').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number84 option').remove();
                $('#part_number84').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number84').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number84').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code84').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description84').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty84').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging84').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs84').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size84').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number85").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code85').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number85 option').remove();
                $('#part_number85').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number85').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number85').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code85').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description85').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty85').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging85').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs85').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size85').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number86").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code86').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number86 option').remove();
                $('#part_number86').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number86').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number86').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code86').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description86').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty86').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging86').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs86').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size86').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number87").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code87').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number87 option').remove();
                $('#part_number87').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number87').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number87').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code87').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description87').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty87').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging87').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs87').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size87').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number88").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code88').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number88 option').remove();
                $('#part_number88').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number88').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number88').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code88').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description88').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty88').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging88').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs88').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size88').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number89").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code89').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number89 option').remove();
                $('#part_number89').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number89').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number89').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code89').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description89').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty89').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging89').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs89').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size89').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number90").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code90').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number90 option').remove();
                $('#part_number90').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number90').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number90').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code90').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description90').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty90').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging90').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs90').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size90').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number91").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code91').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number91 option').remove();
                $('#part_number91').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number91').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number91').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code91').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description91').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty91').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging91').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs91').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size91').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number92").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code92').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number92 option').remove();
                $('#part_number92').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number92').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number92').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code92').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description92').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty92').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging92').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs92').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size92').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number93").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code93').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number93 option').remove();
                $('#part_number93').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number93').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number93').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code93').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description93').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty93').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging93').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs93').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size93').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number94").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code94').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number94 option').remove();
                $('#part_number94').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number94').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number94').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code94').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description94').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty94').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging94').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs94').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size94').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number95").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code95').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number95 option').remove();
                $('#part_number95').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number95').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number95').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code95').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description95').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty95').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging95').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs95').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size95').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number96").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code96').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number96 option').remove();
                $('#part_number96').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number96').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number96').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code96').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description96').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty96').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging96').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs96').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size96').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number97").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code97').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number97 option').remove();
                $('#part_number97').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number97').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number97').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code97').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description97').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty97').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging97').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs97').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size97').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number98").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code98').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number98 option').remove();
                $('#part_number98').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number98').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number98').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code98').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description98').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty98').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging98').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs98').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size98').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number99").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code99').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number99 option').remove();
                $('#part_number99').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number99').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number99').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code99').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description99').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty99').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging99').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs99').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size99').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });

    $("#part_number100").select2({
        placeholder: "Select Part Number",
        width: 'element',
        allowClear: true
    });

    $('#pst_code100').on('change', function() {
        $('#pst_report_data_id').val($(this).val());
        $.ajax({
            url: '/getpstcodedata/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#part_number100 option').remove();
                $('#part_number100').append($('<option value="">Select Part Number</option>'));
                var count = response.main_part_qty.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#part_number100').append($("<option></option>").attr("value", response.main_part_qty[i].part_number).text(response.main_part_qty[i].part_number));
                }

            }
        });
    });

    $('#part_number100').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getmainpartdata/' + dis.val(),
            type: 'GET',
            success: function(response) {
                $('#manufacture_code100').val(response.pst_code_main_part_data_report_id.manufacture_code);
                $('#description100').val(response.pst_code_main_part_data_report_id.description);
                $('#bom_qty100').val(response.pst_code_main_part_data_report_id.bom_qty);
                $('#total_packaging100').val(response.pst_code_main_part_data_report_id.total_packaging);
                $('#qty_pcs100').val(response.pst_code_main_part_data_report_id.qty_pcs);
                $('#carton_size100').val(response.pst_code_main_part_data_report_id.carton_size_weight);
            },
        });
    });




    var add_inspector_id = $('#inspector_id').val();
    var add_report_id = $('#report_id').val();
    var add_inspection_id = $('#inspection_id').val();

    // var add_pst_code_arr = $('.pst_code');
    // var add_main_part_qty_arr = $('.main_part_qty');
    // var add_part_number_arr = $('.part_number');
    // var add_manufacture_code_arr = $('.manufacture_code');
    // var add_description_arr = $('.description');  
    // var add_bom_qty_arr = $('.bom_qty');       
    // var add_qty_pcs_arr = $('.qty_pcs');  
    // var add_total_packaging_arr = $('.total_packaging');  
    // var add_samples_unit_arr = $('.samples_unit');  
    // var add_carton_size_weight_arr = $('.carton_size_weight');  
    // var add_part_number_section_arr = $('.add_part_number_section');  

    // var add_pst_code = [];
    // var add_main_part_qty = [];
    // var add_part_number = []; 
    // var add_manufacture_code = []; 
    // var add_description = [];  
    // var add_bom_qty = [];        
    // var add_qty_pcs = [];  
    // var add_total_packaging = []; 
    // var add_samples_unit = [];        
    // var add_carton_size_weight = [];  
    // var add_part_number_section = [];  

    // for(var i = 0; i < add_pst_code_arr.length; i++){
    //     var g_data=$(add_pst_code_arr[i]).val();
    //     add_pst_code.push(g_data);
    //   }

    //   for(var i = 0; i < add_main_part_qty_arr.length; i++){
    //     var g_data=$(add_main_part_qty_arr[i]).val();
    //     add_main_part_qty.push(g_data);
    //   }

    //    for(var i = 0; i < add_part_number_arr.length; i++){
    //     var g_data=$(add_part_number_arr[i]).val();
    //     add_part_number.push(g_data);
    //   }

    //   for(var i = 0; i < add_manufacture_code_arr.length; i++){
    //     var g_data=$(add_manufacture_code_arr[i]).val();
    //     add_manufacture_code.push(g_data);
    //   }

    //    for(var i = 0; i < add_description_arr.length; i++){
    //     var g_data=$(add_description_arr[i]).val();
    //     add_description.push(g_data);
    //   }

    //   for(var i = 0; i < add_bom_qty_arr.length; i++){
    //     var g_data=$(add_bom_qty_arr[i]).val();
    //     add_bom_qty.push(g_data);
    //   }

    //    for(var i = 0; i < add_qty_pcs_arr.length; i++){
    //     var g_data=$(add_qty_pcs_arr[i]).val();
    //     add_qty_pcs.push(g_data);
    //   }

    //   for(var i = 0; i < add_total_packaging_arr.length; i++){
    //     var g_data=$(add_total_packaging_arr[i]).val();
    //     add_total_packaging.push(g_data);
    //   }

    //   for(var i = 0; i < add_samples_unit_arr.length; i++){
    //     var g_data=$(add_samples_unit_arr[i]).val();
    //     add_samples_unit.push(g_data);
    //   }

    //   for(var i = 0; i < add_carton_size_weight_arr.length; i++){
    //     var g_data=$(add_carton_size_weight_arr[i]).val();
    //     add_carton_size_weight.push(g_data);
    //   }

    //   for(var i = 0; i < add_part_number_section_arr.length; i++){
    //     var g_data=$(add_part_number_section_arr[i]).val();
    //     add_part_number_section.push(g_data);
    //   }

    //   console.log(add_pst_code);
    //   console.log(add_main_part_qty);
    //   console.log(add_part_number);
    //   console.log(add_manufacture_code);
    //   console.log(add_description);
    //   console.log(add_bom_qty);
    //   console.log(add_qty_pcs);
    //   console.log(add_total_packaging);
    //   console.log(add_samples_unit);
    //   console.log(add_carton_size_weight);
    //   console.log(add_part_number_section);

    // $('body').on('click', '.s-btn-rm-part', function() {
    //     $(this).closest('.part2').remove();
    // });

    $('.remove_function_part2').click(function() {
        $("#btn_add_more_function_part").show();
        $(".part2").attr("style", "display: none");
    });

    $('.remove_function_part3').click(function() {
        $("#btn_add_more_function_part2").show();
        $(".part3").attr("style", "display: none");
    });

    $('.remove_function_part4').click(function() {
        $("#btn_add_more_function_part3").show();
        $(".part4").attr("style", "display: none");
    });

    $('.remove_function_part5').click(function() {
        $("#btn_add_more_function_part4").show();
        $(".part5").attr("style", "display: none");
    });

    $('.remove_function_part6').click(function() {
        $("#btn_add_more_function_part5").show();
        $(".part6").attr("style", "display: none");
    });

    $('.remove_function_part7').click(function() {
        $("#btn_add_more_function_part6").show();
        $(".part7").attr("style", "display: none");
    });

    $('.remove_function_part8').click(function() {
        $("#btn_add_more_function_part7").show();
        $(".part8").attr("style", "display: none");
    });

    $('.remove_function_part9').click(function() {
        $("#btn_add_more_function_part8").show();
        $(".part9").attr("style", "display: none");
    });

    $('.remove_function_part10').click(function() {
        $("#btn_add_more_function_part9").show();
        $(".part10").attr("style", "display: none");
    });

    $('.remove_function_part11').click(function() {
        $("#btn_add_more_function_part10").show();
        $(".part11").attr("style", "display: none");
    });

    $('.remove_function_part12').click(function() {
        $("#btn_add_more_function_part11").show();
        $(".part12").attr("style", "display: none");
    });

    $('.remove_function_part13').click(function() {
        $("#btn_add_more_function_part12").show();
        $(".part13").attr("style", "display: none");
    });

    $('.remove_function_part14').click(function() {
        $("#btn_add_more_function_part13").show();
        $(".part14").attr("style", "display: none");
    });

    $('.remove_function_part15').click(function() {
        $("#btn_add_more_function_part14").show();
        $(".part15").attr("style", "display: none");
    });

    $('.remove_function_part16').click(function() {
        $("#btn_add_more_function_part15").show();
        $(".part16").attr("style", "display: none");
    });

    $('.remove_function_part17').click(function() {
        $("#btn_add_more_function_part16").show();
        $(".part17").attr("style", "display: none");
    });

    $('.remove_function_part18').click(function() {
        $("#btn_add_more_function_part17").show();
        $(".part18").attr("style", "display: none");
    });

    $('.remove_function_part19').click(function() {
        $("#btn_add_more_function_part18").show();
        $(".part19").attr("style", "display: none");
    });

    $('.remove_function_part20').click(function() {
        $("#btn_add_more_function_part19").show();
        $(".part20").attr("style", "display: none");
    });

    $('.remove_function_part21').click(function() {
        $("#btn_add_more_function_part20").show();
        $(".part21").attr("style", "display: none");
    });

    $('.remove_function_part22').click(function() {
        $("#btn_add_more_function_part21").show();
        $(".part22").attr("style", "display: none");
    });

    $('.remove_function_part23').click(function() {
        $("#btn_add_more_function_part22").show();
        $(".part23").attr("style", "display: none");
    });

    $('.remove_function_part24').click(function() {
        $("#btn_add_more_function_part23").show();
        $(".part24").attr("style", "display: none");
    });

    $('.remove_function_part25').click(function() {
        $("#btn_add_more_function_part24").show();
        $(".part25").attr("style", "display: none");
    });

    $('.remove_function_part26').click(function() {
        $("#btn_add_more_function_part25").show();
        $(".part26").attr("style", "display: none");
    });

    $('.remove_function_part27').click(function() {
        $("#btn_add_more_function_part26").show();
        $(".part27").attr("style", "display: none");
    });

    $('.remove_function_part28').click(function() {
        $("#btn_add_more_function_part27").show();
        $(".part28").attr("style", "display: none");
    });

    $('.remove_function_part29').click(function() {
        $("#btn_add_more_function_part28").show();
        $(".part29").attr("style", "display: none");
    });

    $('.remove_function_part30').click(function() {
        $("#btn_add_more_function_part29").show();
        $(".part30").attr("style", "display: none");
    });

    $('.remove_function_part31').click(function() {
        $("#btn_add_more_function_part30").show();
        $(".part31").attr("style", "display: none");
    });

    $('.remove_function_part32').click(function() {
        $("#btn_add_more_function_part31").show();
        $(".part32").attr("style", "display: none");
    });

    $('.remove_function_part33').click(function() {
        $("#btn_add_more_function_part32").show();
        $(".part33").attr("style", "display: none");
    });

    $('.remove_function_part34').click(function() {
        $("#btn_add_more_function_part33").show();
        $(".part34").attr("style", "display: none");
    });

    $('.remove_function_part35').click(function() {
        $("#btn_add_more_function_part34").show();
        $(".part35").attr("style", "display: none");
    });

    $('.remove_function_part36').click(function() {
        $("#btn_add_more_function_part35").show();
        $(".part36").attr("style", "display: none");
    });

    $('.remove_function_part37').click(function() {
        $("#btn_add_more_function_part36").show();
        $(".part37").attr("style", "display: none");
    });

    $('.remove_function_part38').click(function() {
        $("#btn_add_more_function_part37").show();
        $(".part38").attr("style", "display: none");
    });

    $('.remove_function_part39').click(function() {
        $("#btn_add_more_function_part38").show();
        $(".part39").attr("style", "display: none");
    });

    $('.remove_function_part40').click(function() {
        $("#btn_add_more_function_part39").show();
        $(".part40").attr("style", "display: none");
    });

    $('.remove_function_part41').click(function() {
        $("#btn_add_more_function_part40").show();
        $(".part41").attr("style", "display: none");
    });

    $('.remove_function_part42').click(function() {
        $("#btn_add_more_function_part41").show();
        $(".part42").attr("style", "display: none");
    });

    $('.remove_function_part43').click(function() {
        $("#btn_add_more_function_part42").show();
        $(".part43").attr("style", "display: none");
    });

    $('.remove_function_part44').click(function() {
        $("#btn_add_more_function_part43").show();
        $(".part44").attr("style", "display: none");
    });

    $('.remove_function_part45').click(function() {
        $("#btn_add_more_function_part44").show();
        $(".part45").attr("style", "display: none");
    });

    $('.remove_function_part46').click(function() {
        $("#btn_add_more_function_part45").show();
        $(".part46").attr("style", "display: none");
    });

    $('.remove_function_part47').click(function() {
        $("#btn_add_more_function_part46").show();
        $(".part47").attr("style", "display: none");
    });

    $('.remove_function_part48').click(function() {
        $("#btn_add_more_function_part47").show();
        $(".part48").attr("style", "display: none");
    });

    $('.remove_function_part49').click(function() {
        $("#btn_add_more_function_part48").show();
        $(".part49").attr("style", "display: none");
    });

    $('.remove_function_part50').click(function() {
        $("#btn_add_more_function_part49").show();
        $(".part50").attr("style", "display: none");
    });

    $('.remove_function_part51').click(function() {
        $("#btn_add_more_function_part50").show();
        $(".part51").attr("style", "display: none");
    });

    $('.remove_function_part52').click(function() {
        $("#btn_add_more_function_part51").show();
        $(".part52").attr("style", "display: none");
    });

    $('.remove_function_part53').click(function() {
        $("#btn_add_more_function_part52").show();
        $(".part53").attr("style", "display: none");
    });

    $('.remove_function_part54').click(function() {
        $("#btn_add_more_function_part53").show();
        $(".part54").attr("style", "display: none");
    });

    $('.remove_function_part55').click(function() {
        $("#btn_add_more_function_part54").show();
        $(".part55").attr("style", "display: none");
    });

    $('.remove_function_part56').click(function() {
        $("#btn_add_more_function_part55").show();
        $(".part56").attr("style", "display: none");
    });

    $('.remove_function_part57').click(function() {
        $("#btn_add_more_function_part56").show();
        $(".part57").attr("style", "display: none");
    });

    $('.remove_function_part58').click(function() {
        $("#btn_add_more_function_part57").show();
        $(".part58").attr("style", "display: none");
    });

    $('.remove_function_part59').click(function() {
        $("#btn_add_more_function_part58").show();
        $(".part59").attr("style", "display: none");
    });

    $('.remove_function_part60').click(function() {
        $("#btn_add_more_function_part59").show();
        $(".part60").attr("style", "display: none");
    });

    $('.remove_function_part61').click(function() {
        $("#btn_add_more_function_part60").show();
        $(".part61").attr("style", "display: none");
    });

    $('.remove_function_part62').click(function() {
        $("#btn_add_more_function_part61").show();
        $(".part62").attr("style", "display: none");
    });

    $('.remove_function_part63').click(function() {
        $("#btn_add_more_function_part62").show();
        $(".part63").attr("style", "display: none");
    });

    $('.remove_function_part64').click(function() {
        $("#btn_add_more_function_part63").show();
        $(".part64").attr("style", "display: none");
    });

    $('.remove_function_part65').click(function() {
        $("#btn_add_more_function_part64").show();
        $(".part65").attr("style", "display: none");
    });

    $('.remove_function_part66').click(function() {
        $("#btn_add_more_function_part65").show();
        $(".part66").attr("style", "display: none");
    });

    $('.remove_function_part67').click(function() {
        $("#btn_add_more_function_part66").show();
        $(".part67").attr("style", "display: none");
    });

    $('.remove_function_part68').click(function() {
        $("#btn_add_more_function_part67").show();
        $(".part68").attr("style", "display: none");
    });

    $('.remove_function_part69').click(function() {
        $("#btn_add_more_function_part68").show();
        $(".part69").attr("style", "display: none");
    });

    $('.remove_function_part70').click(function() {
        $("#btn_add_more_function_part69").show();
        $(".part70").attr("style", "display: none");
    });

    $('.remove_function_part71').click(function() {
        $("#btn_add_more_function_part70").show();
        $(".part71").attr("style", "display: none");
    });

    $('.remove_function_part72').click(function() {
        $("#btn_add_more_function_part71").show();
        $(".part72").attr("style", "display: none");
    });

    $('.remove_function_part73').click(function() {
        $("#btn_add_more_function_part72").show();
        $(".part73").attr("style", "display: none");
    });

    $('.remove_function_part74').click(function() {
        $("#btn_add_more_function_part73").show();
        $(".part74").attr("style", "display: none");
    });

    $('.remove_function_part75').click(function() {
        $("#btn_add_more_function_part74").show();
        $(".part75").attr("style", "display: none");
    });

    $('.remove_function_part76').click(function() {
        $("#btn_add_more_function_part75").show();
        $(".part76").attr("style", "display: none");
    });

    $('.remove_function_part77').click(function() {
        $("#btn_add_more_function_part76").show();
        $(".part77").attr("style", "display: none");
    });

    $('.remove_function_part78').click(function() {
        $("#btn_add_more_function_part77").show();
        $(".part78").attr("style", "display: none");
    });

    $('.remove_function_part79').click(function() {
        $("#btn_add_more_function_part78").show();
        $(".part79").attr("style", "display: none");
    });

    $('.remove_function_part80').click(function() {
        $("#btn_add_more_function_part79").show();
        $(".part80").attr("style", "display: none");
    });

    $('.remove_function_part81').click(function() {
        $("#btn_add_more_function_part80").show();
        $(".part81").attr("style", "display: none");
    });

    $('.remove_function_part82').click(function() {
        $("#btn_add_more_function_part81").show();
        $(".part82").attr("style", "display: none");
    });

    $('.remove_function_part83').click(function() {
        $("#btn_add_more_function_part82").show();
        $(".part83").attr("style", "display: none");
    });

    $('.remove_function_part84').click(function() {
        $("#btn_add_more_function_part83").show();
        $(".part84").attr("style", "display: none");
    });

    $('.remove_function_part85').click(function() {
        $("#btn_add_more_function_part84").show();
        $(".part85").attr("style", "display: none");
    });

    $('.remove_function_part86').click(function() {
        $("#btn_add_more_function_part85").show();
        $(".part86").attr("style", "display: none");
    });

    $('.remove_function_part87').click(function() {
        $("#btn_add_more_function_part86").show();
        $(".part87").attr("style", "display: none");
    });

    $('.remove_function_part88').click(function() {
        $("#btn_add_more_function_part87").show();
        $(".part88").attr("style", "display: none");
    });

    $('.remove_function_part89').click(function() {
        $("#btn_add_more_function_part88").show();
        $(".part89").attr("style", "display: none");
    });

    $('.remove_function_part90').click(function() {
        $("#btn_add_more_function_part89").show();
        $(".part90").attr("style", "display: none");
    });

    $('.remove_function_part91').click(function() {
        $("#btn_add_more_function_part90").show();
        $(".part91").attr("style", "display: none");
    });

    $('.remove_function_part92').click(function() {
        $("#btn_add_more_function_part91").show();
        $(".part92").attr("style", "display: none");
    });

    $('.remove_function_part93').click(function() {
        $("#btn_add_more_function_part92").show();
        $(".part93").attr("style", "display: none");
    });

    $('.remove_function_part94').click(function() {
        $("#btn_add_more_function_part93").show();
        $(".part94").attr("style", "display: none");
    });

    $('.remove_function_part95').click(function() {
        $("#btn_add_more_function_part94").show();
        $(".part95").attr("style", "display: none");
    });

    $('.remove_function_part96').click(function() {
        $("#btn_add_more_function_part95").show();
        $(".part96").attr("style", "display: none");
    });

    $('.remove_function_part97').click(function() {
        $("#btn_add_more_function_part96").show();
        $(".part97").attr("style", "display: none");
    });

    $('.remove_function_part98').click(function() {
        $("#btn_add_more_function_part97").show();
        $(".part98").attr("style", "display: none");
    });

    $('.remove_function_part99').click(function() {
        $("#btn_add_more_function_part98").show();
        $(".part99").attr("style", "display: none");
    });

    $('.remove_function_part100').click(function() {
        $("#btn_add_more_function_part99").show();
        $(".part100").attr("style", "display: none");
    });

    calculatePercentage = function() {
        var total_quantity = document.getElementById('total_available_qty').value;
        var product_aql_qty = document.getElementById('product_aql_qty').value;
        document.getElementById('total_finish_percentage').value = (parseInt(total_quantity) / parseInt(product_aql_qty)) * 100 + "%";

    }

    $('#btn_save_inspector_report').click(function() {
        //RADIOBUTTON VALUES TO BE CHECK

        var shipt_qty1 = $(".shipt_qty1:checked").val();
        var ce_report1 = $(".ce_report1:checked").val();
        var color_logo_style1 = $(".color_logo_style1:checked").val();
        var marking1 = $(".marking1:checked").val();
        var prouct_spect_function1 = $(".prouct_spect_function1:checked").val();
        var visual_checking1 = $(".visual_checking1:checked").val();
        var product_packing1 = $(".product_packing1:checked").val();
        var ship_mark1 = $(".ship_mark1:checked").val();
        var export_carton1 = $(".export_carton1:checked").val();
        var measurement_data1 = $(".measurement_data1:checked").val();
        var comparable_with_sample1 = $(".comparable_with_sample1:checked").val();
        var inspection_result = $(".inspection_result:checked").val();

        // saveInspectorReportDetails();


        //VALIDATION PART IF THERE IS AN EMPTY FIELDS
        var add = $('#form_online_report .validate_input');
        var add_count_null = 0;
        for (var i = 0; i < add.length; i++) {
            var data = $(add[i]).val();
            if (data == "") {
                $(add[i]).css("border", "1px solid red");
                add_count_null += 1;
            } else {
                $(add[i]).removeAttr("style");
            }
        }

        if (add_count_null == 0) {
            saveInspectorReportDetails();
        } else {
            swal({
                title: "Oops!",
                text: "Please check empty or invalid input fields!",
                type: "warning",
            });
            // Swal.fire({
            //     icon: 'warning',
            //     title: 'Please check empty or invalid input fields!',
            //     showConfirmButton: false,
            //     timer: 3000,
            //     width: '600px',
            // })
        }
    });
});
$('#form_online_report .validate_input').change(function() {
    var val = $(this).val();
    if (val == '' || val == null) {
        $(this).css("border", "1px solid red");
    } else {
        $(this).removeAttr("style");
    }
});



function saveInspectorReportDetails() {
    $('.send-loading ').show();

    //alert('hi');

    $.ajax({
        type: 'POST',
        url: '/onlinereport/inspector-reports-save',


        data: $("#form_online_report").serialize(),

        success: function(data) {
            swal({
                title: "Success",
                type: 'success',
                text: "Your Report Is Successfully Uploaded, Please wait and download your generated file from your report. Thankyou!",
            }, function() {
                var report_id_generate = document.getElementById('report_id').value;
                var unique_id_generate = document.getElementById('uniqueid').value;
                var url = '/onlinereport/generate-docx/' + report_id_generate + '/' + unique_id_generate;
                document.location.href = url;
                // swal({
                //     title: "Success",
                //     text: "Your file has been downloaded. You will be redirected to Report Login Details because this report is finished. Thankyou!",
                //     type: "success",
                //         }, function() {
                //             var url = '/login-again';
                //             document.location.href=url;
                //         });
                //     }
            });



        },
        error: function() {
            swal({
                title: "Error",
                text: "Error: Server encountered an error. Please try again or contact your system administrator.",
                type: "error",
            });
            // Swal.fire({
            //     icon: 'error',
            //     title: 'Error',
            //     text: "Error: Server encountered an error. Please try again or contact your system administrator.",
            //     width: '1000px',
            // })
            $('.send-loading ').hide();
        }
    });
}

Dropzone.options.dropzone = {
    maxFilesize: 12,
    renameFile: function(file) {
        var dt = new Date();
        var time = dt.getTime();
        return time + file.name;
    },
    acceptedFiles: ".jpeg,.jpg,.png,.gif",
    addRemoveLinks: true,
    timeout: 50000,
    removedfile: function(file) {
        var name = file.upload.filename;
        var report_id = $('#report_id').val();
        var photo_description = $('#photo_description').val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            type: 'POST',
            url: '{{ url("inspector-image-delete") }}',
            data: {
                filename: name,
                report_id: report_id,
                photo_description: photo_description,
            },
            success: function(data) {
                console.log("File has been successfully removed!!");
            },
            error: function(e) {
                console.log(e);
            }
        });
        var fileRef;
        return (fileRef = file.previewElement) != null ?
            fileRef.parentNode.removeChild(file.previewElement) : void 0;
    },

    success: function(file, response) {
        // Swal.fire({
        //     icon: 'success',
        //     title: 'Photos Successfully Uploaded!',
        //     showConfirmButton: false,
        //     timer: 1500,
        //     width: '1000px',
        // })
    },
    error: function(file, response) {
        return false;
    }
};