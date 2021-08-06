$(document).ready(function() {

    $('body').on('click', '.btn-main_part_qty-modal', function() {
        jQuery.noConflict();
        $('.AQLModal').modal('show');
    });

    $('body').on('keyup', '.aql_qty', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal').find('.aql_minor').val();
        var major = dis.closest('.AQLModal').find('.aql_major').val();
        var lvl = dis.closest('.AQLModal').find('.aql_normal_level').val();
        var special_lvl = dis.closest('.AQLModal').find('.aql_special_level').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal').find('.max_major').val(majorMax);
        dis.closest('.AQLModal').find('.max_minor').val(minorMax);
        dis.closest('.AQLModal').find('.aql_normal_letter').val(letter);
        dis.closest('.AQLModal').find('.aql_special_letter').val(special_letter);
        dis.closest('.AQLModal').find('.aql_normal_sampsize').val(sampsize);
        dis.closest('.AQLModal').find('.aql_special_sampsize').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal').find('.aql_qty').val();
        var minor = dis.closest('.AQLModal').find('.aql_minor').val();
        var major = dis.closest('.AQLModal').find('.aql_major').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal').find('.max_major').val(majorMax);
        dis.closest('.AQLModal').find('.max_minor').val(minorMax);
        dis.closest('.AQLModal').find('.aql_normal_letter').val(letter);
        dis.closest('.AQLModal').find('.aql_normal_sampsize').val(sampsize);
    })

    $('body').on('change', '.aql_special_level', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal').find('.aql_qty').val();
        var minor = dis.closest('.AQLModal').find('.aql_minor').val();
        var major = dis.closest('.AQLModal').find('.aql_major').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal').find('.aql_special_letter').val(letter);
        dis.closest('.AQLModal').find('.aql_special_sampsize').val(sampsize);
    })

    $('body').on('change', '.aql_major', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal').find('.aql_qty').val();
        var minor = dis.closest('.AQLModal').find('.aql_minor').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal').find('.aql_normal_level').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal').find('.max_major').val(majorMax);
        dis.closest('.AQLModal').find('.max_minor').val(minorMax);
        dis.closest('.AQLModal').find('.aql_normal_letter').val(letter);
        dis.closest('.AQLModal').find('.aql_normal_sampsize').val(sampsize);
    })

    $('body').on('change', '.aql_minor', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal').find('.aql_qty').val();
        var major = dis.closest('.AQLModal').find('.aql_major').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal').find('.aql_normal_level').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal').find('.max_major').val(majorMax);
        dis.closest('.AQLModal').find('.max_minor').val(minorMax);
        dis.closest('.AQLModal').find('.aql_normal_letter').val(letter);
        dis.closest('.AQLModal').find('.aql_normal_sampsize').val(sampsize);
    })

    $('body').on('click', '.confirmAQL', function() {
        var dis = $(this);
        dis.closest('.prod-details').find('.main_part_qty').val(dis.closest('.prod-details').find('.aql_qty').val());
        dis.closest('.prod-details').find('.samples_unit').val(dis.closest('.prod-details').find('.aql_normal_sampsize').val());
        dis.closest('.prod-details').find('.AQLModal').modal('hide');

    });

    $('.aql_select').append('<option value="">--</option>');
    $('.aql_select').append('<option value="0.065">0.065</option>');
    $('.aql_select').append('<option value="0.10">0.10</option>');
    $('.aql_select').append('<option value="0.15">0.15</option>');
    $('.aql_select').append('<option value="0.25">0.25</option>');
    $('.aql_select').append('<option value="0.4">0.4</option>');
    $('.aql_select').append('<option value="0.65">0.65</option>');
    $('.aql_select').append('<option value="1">1.0</option>');
    $('.aql_select').append('<option value="1.5">1.5</option>');
    $('.aql_select').append('<option value="2.5">2.5</option>');
    $('.aql_select').append('<option value="4">4.0</option>');
    $('.aql_select').append('<option value="6.5">6.5</option>');
    $('.aql_select').append('<option value="10">10.0</option>');
    $('.aql_select').append('<option value="N/A">N/A</option>');

    ////2//////////
    $('body').on('click', '.btn-main_part_qty-modal2', function() {
        jQuery.noConflict();
        $('.AQLModal2').modal('show');
    });

    $('body').on('keyup', '.aql_qty2', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal2').find('.aql_minor2').val();
        var major = dis.closest('.AQLModal2').find('.aql_major2').val();
        var lvl = dis.closest('.AQLModal2').find('.aql_normal_level2').val();
        var special_lvl = dis.closest('.AQLModal2').find('.aql_special_level2').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal2').find('.max_major2').val(majorMax);
        dis.closest('.AQLModal2').find('.max_minor2').val(minorMax);
        dis.closest('.AQLModal2').find('.aql_normal_letter2').val(letter);
        dis.closest('.AQLModal2').find('.aql_special_letter2').val(special_letter);
        dis.closest('.AQLModal2').find('.aql_normal_sampsize2').val(sampsize);
        dis.closest('.AQLModal2').find('.aql_special_sampsize2').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level2', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal2').find('.aql_qty2').val();
        var minor = dis.closest('.AQLModal2').find('.aql_minor2').val();
        var major = dis.closest('.AQLModal2').find('.aql_major2').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal2').find('.max_major2').val(majorMax);
        dis.closest('.AQLModal2').find('.max_minor2').val(minorMax);
        dis.closest('.AQLModal2').find('.aql_normal_letter2').val(letter);
        dis.closest('.AQLModal2').find('.aql_normal_sampsize2').val(sampsize);
    })

    $('body').on('change', '.aql_special_level2', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal2').find('.aql_qty2').val();
        var minor = dis.closest('.AQLModal2').find('.aql_minor2').val();
        var major = dis.closest('.AQLModal2').find('.aql_major2').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal2').find('.aql_special_letter2').val(letter);
        dis.closest('.AQLModal2').find('.aql_special_sampsize2').val(sampsize);
    })

    $('body').on('change', '.aql_major2', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal2').find('.aql_qty2').val();
        var minor = dis.closest('.AQLModal2').find('.aql_minor2').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal2').find('.aql_normal_level2').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal2').find('.max_major2').val(majorMax);
        dis.closest('.AQLModal2').find('.max_minor2').val(minorMax);
        dis.closest('.AQLModal2').find('.aql_normal_letter2').val(letter);
        dis.closest('.AQLModal2').find('.aql_normal_sampsize2').val(sampsize);
    })

    $('body').on('change', '.aql_minor2', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal2').find('.aql_qty2').val();
        var major = dis.closest('.AQLModal2').find('.aql_major2').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal2').find('.aql_normal_level2').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal2').find('.max_major2').val(majorMax);
        dis.closest('.AQLModal2').find('.max_minor2').val(minorMax);
        dis.closest('.AQLModal2').find('.aql_normal_letter2').val(letter);
        dis.closest('.AQLModal2').find('.aql_normal_sampsize2').val(sampsize);
    })

    $('body').on('click', '.confirmAQL2', function() {
        var dis = $(this);
        dis.closest('.part2').find('.main_part_qty2').val(dis.closest('.part2').find('.aql_qty2').val());
        dis.closest('.part2').find('#samples_unit2').val(dis.closest('.part2').find('.aql_normal_sampsize2').val());
        dis.closest('.part2').find('.AQLModal2').modal('hide');

    });

    $('.aql_select2').append('<option value="">--</option>');
    $('.aql_select2').append('<option value="0.065">0.065</option>');
    $('.aql_select2').append('<option value="0.10">0.10</option>');
    $('.aql_select2').append('<option value="0.15">0.15</option>');
    $('.aql_select2').append('<option value="0.25">0.25</option>');
    $('.aql_select2').append('<option value="0.4">0.4</option>');
    $('.aql_select2').append('<option value="0.65">0.65</option>');
    $('.aql_select2').append('<option value="1">1.0</option>');
    $('.aql_select2').append('<option value="1.5">1.5</option>');
    $('.aql_select2').append('<option value="2.5">2.5</option>');
    $('.aql_select2').append('<option value="4">4.0</option>');
    $('.aql_select2').append('<option value="6.5">6.5</option>');
    $('.aql_select2').append('<option value="10">10.0</option>');
    $('.aql_select2').append('<option value="N/A">N/A</option>');

    //#3
    $('body').on('click', '.btn-main_part_qty-modal3', function() {
        jQuery.noConflict();
        $('.AQLModal3').modal('show');
    });

    $('body').on('keyup', '.aql_qty3', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal3').find('.aql_minor3').val();
        var major = dis.closest('.AQLModal3').find('.aql_major3').val();
        var lvl = dis.closest('.AQLModal3').find('.aql_normal_level3').val();
        var special_lvl = dis.closest('.AQLModal3').find('.aql_special_level3').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal3').find('.max_major3').val(majorMax);
        dis.closest('.AQLModal3').find('.max_minor3').val(minorMax);
        dis.closest('.AQLModal3').find('.aql_normal_letter3').val(letter);
        dis.closest('.AQLModal3').find('.aql_special_letter3').val(special_letter);
        dis.closest('.AQLModal3').find('.aql_normal_sampsize3').val(sampsize);
        dis.closest('.AQLModal3').find('.aql_special_sampsize3').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level3', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal3').find('.aql_qty3').val();
        var minor = dis.closest('.AQLModal3').find('.aql_minor3').val();
        var major = dis.closest('.AQLModal3').find('.aql_major3').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal3').find('.max_major3').val(majorMax);
        dis.closest('.AQLModal3').find('.max_minor3').val(minorMax);
        dis.closest('.AQLModal3').find('.aql_normal_letter3').val(letter);
        dis.closest('.AQLModal3').find('.aql_normal_sampsize3').val(sampsize);
    })

    $('body').on('change', '.aql_special_level3', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal3').find('.aql_qty3').val();
        var minor = dis.closest('.AQLModal3').find('.aql_minor3').val();
        var major = dis.closest('.AQLModal3').find('.aql_major3').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal3').find('.aql_special_letter3').val(letter);
        dis.closest('.AQLModal3').find('.aql_special_sampsize3').val(sampsize);
    })

    $('body').on('change', '.aql_major3', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal3').find('.aql_qty3').val();
        var minor = dis.closest('.AQLModal3').find('.aql_minor3').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal3').find('.aql_normal_level3').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal3').find('.max_major3').val(majorMax);
        dis.closest('.AQLModal3').find('.max_minor3').val(minorMax);
        dis.closest('.AQLModal3').find('.aql_normal_letter3').val(letter);
        dis.closest('.AQLModal3').find('.aql_normal_sampsize3').val(sampsize);
    })

    $('body').on('change', '.aql_minor3', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal3').find('.aql_qty3').val();
        var major = dis.closest('.AQLModal3').find('.aql_major3').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal3').find('.aql_normal_level3').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal3').find('.max_major3').val(majorMax);
        dis.closest('.AQLModal3').find('.max_minor3').val(minorMax);
        dis.closest('.AQLModal3').find('.aql_normal_letter3').val(letter);
        dis.closest('.AQLModal3').find('.aql_normal_sampsize3').val(sampsize);
    })

    $('body').on('click', '.confirmAQL3', function() {
        var dis = $(this);
        dis.closest('.part3').find('.main_part_qty3').val(dis.closest('.part3').find('.aql_qty3').val());
        dis.closest('.part3').find('#samples_unit3').val(dis.closest('.part3').find('.aql_normal_sampsize3').val());
        dis.closest('.part3').find('.AQLModal3').modal('hide');

    });

    $('.aql_select3').append('<option value="">--</option>');
    $('.aql_select3').append('<option value="0.065">0.065</option>');
    $('.aql_select3').append('<option value="0.10">0.10</option>');
    $('.aql_select3').append('<option value="0.15">0.15</option>');
    $('.aql_select3').append('<option value="0.25">0.25</option>');
    $('.aql_select3').append('<option value="0.4">0.4</option>');
    $('.aql_select3').append('<option value="0.65">0.65</option>');
    $('.aql_select3').append('<option value="1">1.0</option>');
    $('.aql_select3').append('<option value="1.5">1.5</option>');
    $('.aql_select3').append('<option value="2.5">2.5</option>');
    $('.aql_select3').append('<option value="4">4.0</option>');
    $('.aql_select3').append('<option value="6.5">6.5</option>');
    $('.aql_select3').append('<option value="10">10.0</option>');
    $('.aql_select3').append('<option value="N/A">N/A</option>');

    //4
    $('body').on('click', '.btn-main_part_qty-modal4', function() {
        jQuery.noConflict();
        $('.AQLModal4').modal('show');
    });

    $('body').on('keyup', '.aql_qty4', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal4').find('.aql_minor4').val();
        var major = dis.closest('.AQLModal4').find('.aql_major4').val();
        var lvl = dis.closest('.AQLModal4').find('.aql_normal_level4').val();
        var special_lvl = dis.closest('.AQLModal4').find('.aql_special_level4').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal4').find('.max_major4').val(majorMax);
        dis.closest('.AQLModal4').find('.max_minor4').val(minorMax);
        dis.closest('.AQLModal4').find('.aql_normal_letter4').val(letter);
        dis.closest('.AQLModal4').find('.aql_special_letter4').val(special_letter);
        dis.closest('.AQLModal4').find('.aql_normal_sampsize4').val(sampsize);
        dis.closest('.AQLModal4').find('.aql_special_sampsize4').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level4', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal4').find('.aql_qty4').val();
        var minor = dis.closest('.AQLModal4').find('.aql_minor4').val();
        var major = dis.closest('.AQLModal4').find('.aql_major4').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal4').find('.max_major4').val(majorMax);
        dis.closest('.AQLModal4').find('.max_minor4').val(minorMax);
        dis.closest('.AQLModal4').find('.aql_normal_letter4').val(letter);
        dis.closest('.AQLModal4').find('.aql_normal_sampsize4').val(sampsize);
    })

    $('body').on('change', '.aql_special_level4', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal4').find('.aql_qty4').val();
        var minor = dis.closest('.AQLModal4').find('.aql_minor4').val();
        var major = dis.closest('.AQLModal4').find('.aql_major4').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal4').find('.aql_special_letter4').val(letter);
        dis.closest('.AQLModal4').find('.aql_special_sampsize4').val(sampsize);
    })

    $('body').on('change', '.aql_major4', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal4').find('.aql_qty4').val();
        var minor = dis.closest('.AQLModal4').find('.aql_minor4').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal4').find('.aql_normal_level4').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal4').find('.max_major4').val(majorMax);
        dis.closest('.AQLModal4').find('.max_minor4').val(minorMax);
        dis.closest('.AQLModal4').find('.aql_normal_letter4').val(letter);
        dis.closest('.AQLModal4').find('.aql_normal_sampsize4').val(sampsize);
    })

    $('body').on('change', '.aql_minor4', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal4').find('.aql_qty4').val();
        var major = dis.closest('.AQLModal4').find('.aql_major4').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal4').find('.aql_normal_level4').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal4').find('.max_major4').val(majorMax);
        dis.closest('.AQLModal4').find('.max_minor4').val(minorMax);
        dis.closest('.AQLModal4').find('.aql_normal_letter4').val(letter);
        dis.closest('.AQLModal4').find('.aql_normal_sampsize4').val(sampsize);
    })

    $('body').on('click', '.confirmAQL4', function() {
        var dis = $(this);
        dis.closest('.part4').find('.main_part_qty4').val(dis.closest('.part4').find('.aql_qty4').val());
        dis.closest('.part4').find('#samples_unit4').val(dis.closest('.part4').find('.aql_normal_sampsize4').val());
        dis.closest('.part4').find('.AQLModal4').modal('hide');

    });

    $('.aql_select4').append('<option value="">--</option>');
    $('.aql_select4').append('<option value="0.065">0.065</option>');
    $('.aql_select4').append('<option value="0.10">0.10</option>');
    $('.aql_select4').append('<option value="0.15">0.15</option>');
    $('.aql_select4').append('<option value="0.25">0.25</option>');
    $('.aql_select4').append('<option value="0.4">0.4</option>');
    $('.aql_select4').append('<option value="0.65">0.65</option>');
    $('.aql_select4').append('<option value="1">1.0</option>');
    $('.aql_select4').append('<option value="1.5">1.5</option>');
    $('.aql_select4').append('<option value="2.5">2.5</option>');
    $('.aql_select4').append('<option value="4">4.0</option>');
    $('.aql_select4').append('<option value="6.5">6.5</option>');
    $('.aql_select4').append('<option value="10">10.0</option>');
    $('.aql_select4').append('<option value="N/A">N/A</option>');

    //5
    $('body').on('click', '.btn-main_part_qty-modal5', function() {
        jQuery.noConflict();
        $('.AQLModal5').modal('show');
    });

    $('body').on('keyup', '.aql_qty5', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal5').find('.aql_minor5').val();
        var major = dis.closest('.AQLModal5').find('.aql_major5').val();
        var lvl = dis.closest('.AQLModal5').find('.aql_normal_level5').val();
        var special_lvl = dis.closest('.AQLModal5').find('.aql_special_level5').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal5').find('.max_major5').val(majorMax);
        dis.closest('.AQLModal5').find('.max_minor5').val(minorMax);
        dis.closest('.AQLModal5').find('.aql_normal_letter5').val(letter);
        dis.closest('.AQLModal5').find('.aql_special_letter5').val(special_letter);
        dis.closest('.AQLModal5').find('.aql_normal_sampsize5').val(sampsize);
        dis.closest('.AQLModal5').find('.aql_special_sampsize5').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level5', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal5').find('.aql_qty5').val();
        var minor = dis.closest('.AQLModal5').find('.aql_minor5').val();
        var major = dis.closest('.AQLModal5').find('.aql_major5').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal5').find('.max_major5').val(majorMax);
        dis.closest('.AQLModal5').find('.max_minor5').val(minorMax);
        dis.closest('.AQLModal5').find('.aql_normal_letter5').val(letter);
        dis.closest('.AQLModal5').find('.aql_normal_sampsize5').val(sampsize);
    })

    $('body').on('change', '.aql_special_level5', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal5').find('.aql_qty5').val();
        var minor = dis.closest('.AQLModal5').find('.aql_minor5').val();
        var major = dis.closest('.AQLModal5').find('.aql_major5').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal5').find('.aql_special_letter5').val(letter);
        dis.closest('.AQLModal5').find('.aql_special_sampsize5').val(sampsize);
    })

    $('body').on('change', '.aql_major5', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal5').find('.aql_qty5').val();
        var minor = dis.closest('.AQLModal5').find('.aql_minor5').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal5').find('.aql_normal_level5').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal5').find('.max_major5').val(majorMax);
        dis.closest('.AQLModal5').find('.max_minor5').val(minorMax);
        dis.closest('.AQLModal5').find('.aql_normal_letter5').val(letter);
        dis.closest('.AQLModal5').find('.aql_normal_sampsize5').val(sampsize);
    })

    $('body').on('change', '.aql_minor5', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal5').find('.aql_qty5').val();
        var major = dis.closest('.AQLModal5').find('.aql_major5').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal5').find('.aql_normal_level5').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal5').find('.max_major5').val(majorMax);
        dis.closest('.AQLModal5').find('.max_minor5').val(minorMax);
        dis.closest('.AQLModal5').find('.aql_normal_letter5').val(letter);
        dis.closest('.AQLModal5').find('.aql_normal_sampsize5').val(sampsize);
    })

    $('body').on('click', '.confirmAQL5', function() {
        var dis = $(this);
        dis.closest('.part5').find('.main_part_qty5').val(dis.closest('.part5').find('.aql_qty5').val());
        dis.closest('.part5').find('#samples_unit5').val(dis.closest('.part5').find('.aql_normal_sampsize5').val());
        dis.closest('.part5').find('.AQLModal5').modal('hide');

    });

    $('.aql_select5').append('<option value="">--</option>');
    $('.aql_select5').append('<option value="0.065">0.065</option>');
    $('.aql_select5').append('<option value="0.10">0.10</option>');
    $('.aql_select5').append('<option value="0.15">0.15</option>');
    $('.aql_select5').append('<option value="0.25">0.25</option>');
    $('.aql_select5').append('<option value="0.4">0.4</option>');
    $('.aql_select5').append('<option value="0.65">0.65</option>');
    $('.aql_select5').append('<option value="1">1.0</option>');
    $('.aql_select5').append('<option value="1.5">1.5</option>');
    $('.aql_select5').append('<option value="2.5">2.5</option>');
    $('.aql_select5').append('<option value="4">4.0</option>');
    $('.aql_select5').append('<option value="6.5">6.5</option>');
    $('.aql_select5').append('<option value="10">10.0</option>');
    $('.aql_select5').append('<option value="N/A">N/A</option>');

    //6
    $('body').on('click', '.btn-main_part_qty-modal6', function() {
        jQuery.noConflict();
        $('.AQLModal6').modal('show');
    });

    $('body').on('keyup', '.aql_qty6', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal6').find('.aql_minor6').val();
        var major = dis.closest('.AQLModal6').find('.aql_major6').val();
        var lvl = dis.closest('.AQLModal6').find('.aql_normal_level6').val();
        var special_lvl = dis.closest('.AQLModal6').find('.aql_special_level6').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal6').find('.max_major6').val(majorMax);
        dis.closest('.AQLModal6').find('.max_minor6').val(minorMax);
        dis.closest('.AQLModal6').find('.aql_normal_letter6').val(letter);
        dis.closest('.AQLModal6').find('.aql_special_letter6').val(special_letter);
        dis.closest('.AQLModal6').find('.aql_normal_sampsize6').val(sampsize);
        dis.closest('.AQLModal6').find('.aql_special_sampsize6').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level6', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal6').find('.aql_qty6').val();
        var minor = dis.closest('.AQLModal6').find('.aql_minor6').val();
        var major = dis.closest('.AQLModal6').find('.aql_major6').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal6').find('.max_major6').val(majorMax);
        dis.closest('.AQLModal6').find('.max_minor6').val(minorMax);
        dis.closest('.AQLModal6').find('.aql_normal_letter6').val(letter);
        dis.closest('.AQLModal6').find('.aql_normal_sampsize6').val(sampsize);
    })

    $('body').on('change', '.aql_special_level6', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal6').find('.aql_qty6').val();
        var minor = dis.closest('.AQLModal6').find('.aql_minor6').val();
        var major = dis.closest('.AQLModal6').find('.aql_major6').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal6').find('.aql_special_letter6').val(letter);
        dis.closest('.AQLModal6').find('.aql_special_sampsize6').val(sampsize);
    })

    $('body').on('change', '.aql_major6', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal6').find('.aql_qty6').val();
        var minor = dis.closest('.AQLModal6').find('.aql_minor6').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal6').find('.aql_normal_level6').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal6').find('.max_major6').val(majorMax);
        dis.closest('.AQLModal6').find('.max_minor6').val(minorMax);
        dis.closest('.AQLModal6').find('.aql_normal_letter6').val(letter);
        dis.closest('.AQLModal6').find('.aql_normal_sampsize6').val(sampsize);
    })

    $('body').on('change', '.aql_minor6', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal6').find('.aql_qty6').val();
        var major = dis.closest('.AQLModal6').find('.aql_major6').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal6').find('.aql_normal_level6').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal6').find('.max_major6').val(majorMax);
        dis.closest('.AQLModal6').find('.max_minor6').val(minorMax);
        dis.closest('.AQLModal6').find('.aql_normal_letter6').val(letter);
        dis.closest('.AQLModal6').find('.aql_normal_sampsize6').val(sampsize);
    })

    $('body').on('click', '.confirmAQL6', function() {
        var dis = $(this);
        dis.closest('.part6').find('.main_part_qty6').val(dis.closest('.part6').find('.aql_qty6').val());
        dis.closest('.part6').find('#samples_unit6').val(dis.closest('.part6').find('.aql_normal_sampsize6').val());
        dis.closest('.part6').find('.AQLModal6').modal('hide');

    });

    $('.aql_select6').append('<option value="">--</option>');
    $('.aql_select6').append('<option value="0.065">0.065</option>');
    $('.aql_select6').append('<option value="0.10">0.10</option>');
    $('.aql_select6').append('<option value="0.15">0.15</option>');
    $('.aql_select6').append('<option value="0.25">0.25</option>');
    $('.aql_select6').append('<option value="0.4">0.4</option>');
    $('.aql_select6').append('<option value="0.65">0.65</option>');
    $('.aql_select6').append('<option value="1">1.0</option>');
    $('.aql_select6').append('<option value="1.5">1.5</option>');
    $('.aql_select6').append('<option value="2.5">2.5</option>');
    $('.aql_select6').append('<option value="4">4.0</option>');
    $('.aql_select6').append('<option value="6.5">6.5</option>');
    $('.aql_select6').append('<option value="10">10.0</option>');
    $('.aql_select6').append('<option value="N/A">N/A</option>');

    //7
    $('body').on('click', '.btn-main_part_qty-modal7', function() {
        jQuery.noConflict();
        $('.AQLModal7').modal('show');
    });

    $('body').on('keyup', '.aql_qty7', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal7').find('.aql_minor7').val();
        var major = dis.closest('.AQLModal7').find('.aql_major7').val();
        var lvl = dis.closest('.AQLModal7').find('.aql_normal_level7').val();
        var special_lvl = dis.closest('.AQLModal7').find('.aql_special_level7').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal7').find('.max_major7').val(majorMax);
        dis.closest('.AQLModal7').find('.max_minor7').val(minorMax);
        dis.closest('.AQLModal7').find('.aql_normal_letter7').val(letter);
        dis.closest('.AQLModal7').find('.aql_special_letter7').val(special_letter);
        dis.closest('.AQLModal7').find('.aql_normal_sampsize7').val(sampsize);
        dis.closest('.AQLModal7').find('.aql_special_sampsize7').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level7', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal7').find('.aql_qty7').val();
        var minor = dis.closest('.AQLModal7').find('.aql_minor7').val();
        var major = dis.closest('.AQLModal7').find('.aql_major7').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal7').find('.max_major7').val(majorMax);
        dis.closest('.AQLModal7').find('.max_minor7').val(minorMax);
        dis.closest('.AQLModal7').find('.aql_normal_letter7').val(letter);
        dis.closest('.AQLModal7').find('.aql_normal_sampsize7').val(sampsize);
    })

    $('body').on('change', '.aql_special_level7', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal7').find('.aql_qty7').val();
        var minor = dis.closest('.AQLModal7').find('.aql_minor7').val();
        var major = dis.closest('.AQLModal7').find('.aql_major7').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal7').find('.aql_special_letter7').val(letter);
        dis.closest('.AQLModal7').find('.aql_special_sampsize7').val(sampsize);
    })

    $('body').on('change', '.aql_major7', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal7').find('.aql_qty7').val();
        var minor = dis.closest('.AQLModal7').find('.aql_minor7').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal7').find('.aql_normal_level7').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal7').find('.max_major7').val(majorMax);
        dis.closest('.AQLModal7').find('.max_minor7').val(minorMax);
        dis.closest('.AQLModal7').find('.aql_normal_letter7').val(letter);
        dis.closest('.AQLModal7').find('.aql_normal_sampsize7').val(sampsize);
    })

    $('body').on('change', '.aql_minor7', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal7').find('.aql_qty7').val();
        var major = dis.closest('.AQLModal7').find('.aql_major7').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal7').find('.aql_normal_level7').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal7').find('.max_major7').val(majorMax);
        dis.closest('.AQLModal7').find('.max_minor7').val(minorMax);
        dis.closest('.AQLModal7').find('.aql_normal_letter7').val(letter);
        dis.closest('.AQLModal7').find('.aql_normal_sampsize7').val(sampsize);
    })

    $('body').on('click', '.confirmAQL7', function() {
        var dis = $(this);
        dis.closest('.part7').find('.main_part_qty7').val(dis.closest('.part7').find('.aql_qty7').val());
        dis.closest('.part7').find('#samples_unit7').val(dis.closest('.part7').find('.aql_normal_sampsize7').val());
        dis.closest('.part7').find('.AQLModal7').modal('hide');

    });

    $('.aql_select7').append('<option value="">--</option>');
    $('.aql_select7').append('<option value="0.065">0.065</option>');
    $('.aql_select7').append('<option value="0.10">0.10</option>');
    $('.aql_select7').append('<option value="0.15">0.15</option>');
    $('.aql_select7').append('<option value="0.25">0.25</option>');
    $('.aql_select7').append('<option value="0.4">0.4</option>');
    $('.aql_select7').append('<option value="0.65">0.65</option>');
    $('.aql_select7').append('<option value="1">1.0</option>');
    $('.aql_select7').append('<option value="1.5">1.5</option>');
    $('.aql_select7').append('<option value="2.5">2.5</option>');
    $('.aql_select7').append('<option value="4">4.0</option>');
    $('.aql_select7').append('<option value="6.5">6.5</option>');
    $('.aql_select7').append('<option value="10">10.0</option>');
    $('.aql_select7').append('<option value="N/A">N/A</option>');

    //8
    $('body').on('click', '.btn-main_part_qty-modal8', function() {
        jQuery.noConflict();
        $('.AQLModal8').modal('show');
    });

    $('body').on('keyup', '.aql_qty8', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal8').find('.aql_minor8').val();
        var major = dis.closest('.AQLModal8').find('.aql_major8').val();
        var lvl = dis.closest('.AQLModal8').find('.aql_normal_level8').val();
        var special_lvl = dis.closest('.AQLModal8').find('.aql_special_level8').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal8').find('.max_major8').val(majorMax);
        dis.closest('.AQLModal8').find('.max_minor8').val(minorMax);
        dis.closest('.AQLModal8').find('.aql_normal_letter8').val(letter);
        dis.closest('.AQLModal8').find('.aql_special_letter8').val(special_letter);
        dis.closest('.AQLModal8').find('.aql_normal_sampsize8').val(sampsize);
        dis.closest('.AQLModal8').find('.aql_special_sampsize8').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level8', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal8').find('.aql_qty8').val();
        var minor = dis.closest('.AQLModal8').find('.aql_minor8').val();
        var major = dis.closest('.AQLModal8').find('.aql_major8').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal8').find('.max_major8').val(majorMax);
        dis.closest('.AQLModal8').find('.max_minor8').val(minorMax);
        dis.closest('.AQLModal8').find('.aql_normal_letter8').val(letter);
        dis.closest('.AQLModal8').find('.aql_normal_sampsize8').val(sampsize);
    })

    $('body').on('change', '.aql_special_level8', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal8').find('.aql_qty8').val();
        var minor = dis.closest('.AQLModal8').find('.aql_minor8').val();
        var major = dis.closest('.AQLModal8').find('.aql_major8').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal8').find('.aql_special_letter8').val(letter);
        dis.closest('.AQLModal8').find('.aql_special_sampsize8').val(sampsize);
    })

    $('body').on('change', '.aql_major8', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal8').find('.aql_qty8').val();
        var minor = dis.closest('.AQLModal8').find('.aql_minor8').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal8').find('.aql_normal_level8').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal8').find('.max_major8').val(majorMax);
        dis.closest('.AQLModal8').find('.max_minor8').val(minorMax);
        dis.closest('.AQLModal8').find('.aql_normal_letter8').val(letter);
        dis.closest('.AQLModal8').find('.aql_normal_sampsize8').val(sampsize);
    })

    $('body').on('change', '.aql_minor8', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal8').find('.aql_qty8').val();
        var major = dis.closest('.AQLModal8').find('.aql_major8').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal8').find('.aql_normal_level8').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal8').find('.max_major8').val(majorMax);
        dis.closest('.AQLModal8').find('.max_minor8').val(minorMax);
        dis.closest('.AQLModal8').find('.aql_normal_letter8').val(letter);
        dis.closest('.AQLModal8').find('.aql_normal_sampsize8').val(sampsize);
    })

    $('body').on('click', '.confirmAQL8', function() {
        var dis = $(this);
        dis.closest('.part8').find('.main_part_qty8').val(dis.closest('.part8').find('.aql_qty8').val());
        dis.closest('.part8').find('#samples_unit8').val(dis.closest('.part8').find('.aql_normal_sampsize8').val());
        dis.closest('.part8').find('.AQLModal8').modal('hide');

    });

    $('.aql_select8').append('<option value="">--</option>');
    $('.aql_select8').append('<option value="0.065">0.065</option>');
    $('.aql_select8').append('<option value="0.10">0.10</option>');
    $('.aql_select8').append('<option value="0.15">0.15</option>');
    $('.aql_select8').append('<option value="0.25">0.25</option>');
    $('.aql_select8').append('<option value="0.4">0.4</option>');
    $('.aql_select8').append('<option value="0.65">0.65</option>');
    $('.aql_select8').append('<option value="1">1.0</option>');
    $('.aql_select8').append('<option value="1.5">1.5</option>');
    $('.aql_select8').append('<option value="2.5">2.5</option>');
    $('.aql_select8').append('<option value="4">4.0</option>');
    $('.aql_select8').append('<option value="6.5">6.5</option>');
    $('.aql_select8').append('<option value="10">10.0</option>');
    $('.aql_select8').append('<option value="N/A">N/A</option>');

    //9
    $('body').on('click', '.btn-main_part_qty-modal9', function() {
        jQuery.noConflict();
        $('.AQLModal9').modal('show');
    });

    $('body').on('keyup', '.aql_qty9', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal9').find('.aql_minor9').val();
        var major = dis.closest('.AQLModal9').find('.aql_major9').val();
        var lvl = dis.closest('.AQLModal9').find('.aql_normal_level9').val();
        var special_lvl = dis.closest('.AQLModal9').find('.aql_special_level9').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal9').find('.max_major9').val(majorMax);
        dis.closest('.AQLModal9').find('.max_minor9').val(minorMax);
        dis.closest('.AQLModal9').find('.aql_normal_letter9').val(letter);
        dis.closest('.AQLModal9').find('.aql_special_letter9').val(special_letter);
        dis.closest('.AQLModal9').find('.aql_normal_sampsize9').val(sampsize);
        dis.closest('.AQLModal9').find('.aql_special_sampsize9').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level9', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal9').find('.aql_qty9').val();
        var minor = dis.closest('.AQLModal9').find('.aql_minor9').val();
        var major = dis.closest('.AQLModal9').find('.aql_major9').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal9').find('.max_major9').val(majorMax);
        dis.closest('.AQLModal9').find('.max_minor9').val(minorMax);
        dis.closest('.AQLModal9').find('.aql_normal_letter9').val(letter);
        dis.closest('.AQLModal9').find('.aql_normal_sampsize9').val(sampsize);
    })

    $('body').on('change', '.aql_special_level9', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal9').find('.aql_qty9').val();
        var minor = dis.closest('.AQLModal9').find('.aql_minor9').val();
        var major = dis.closest('.AQLModal9').find('.aql_major9').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal9').find('.aql_special_letter9').val(letter);
        dis.closest('.AQLModal9').find('.aql_special_sampsize9').val(sampsize);
    })

    $('body').on('change', '.aql_major9', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal9').find('.aql_qty9').val();
        var minor = dis.closest('.AQLModal9').find('.aql_minor9').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal9').find('.aql_normal_level9').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal9').find('.max_major9').val(majorMax);
        dis.closest('.AQLModal9').find('.max_minor9').val(minorMax);
        dis.closest('.AQLModal9').find('.aql_normal_letter9').val(letter);
        dis.closest('.AQLModal9').find('.aql_normal_sampsize9').val(sampsize);
    })

    $('body').on('change', '.aql_minor9', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal9').find('.aql_qty9').val();
        var major = dis.closest('.AQLModal9').find('.aql_major9').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal9').find('.aql_normal_level9').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal9').find('.max_major9').val(majorMax);
        dis.closest('.AQLModal9').find('.max_minor9').val(minorMax);
        dis.closest('.AQLModal9').find('.aql_normal_letter9').val(letter);
        dis.closest('.AQLModal9').find('.aql_normal_sampsize9').val(sampsize);
    })

    $('body').on('click', '.confirmAQL9', function() {
        var dis = $(this);
        dis.closest('.part9').find('.main_part_qty9').val(dis.closest('.part9').find('.aql_qty9').val());
        dis.closest('.part9').find('#samples_unit9').val(dis.closest('.part9').find('.aql_normal_sampsize9').val());
        dis.closest('.part9').find('.AQLModal9').modal('hide');

    });

    $('.aql_select9').append('<option value="">--</option>');
    $('.aql_select9').append('<option value="0.065">0.065</option>');
    $('.aql_select9').append('<option value="0.10">0.10</option>');
    $('.aql_select9').append('<option value="0.15">0.15</option>');
    $('.aql_select9').append('<option value="0.25">0.25</option>');
    $('.aql_select9').append('<option value="0.4">0.4</option>');
    $('.aql_select9').append('<option value="0.65">0.65</option>');
    $('.aql_select9').append('<option value="1">1.0</option>');
    $('.aql_select9').append('<option value="1.5">1.5</option>');
    $('.aql_select9').append('<option value="2.5">2.5</option>');
    $('.aql_select9').append('<option value="4">4.0</option>');
    $('.aql_select9').append('<option value="6.5">6.5</option>');
    $('.aql_select9').append('<option value="10">10.0</option>');
    $('.aql_select9').append('<option value="N/A">N/A</option>');

    //10
    $('body').on('click', '.btn-main_part_qty-modal10', function() {
        jQuery.noConflict();
        $('.AQLModal10').modal('show');
    });

    $('body').on('keyup', '.aql_qty10', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal10').find('.aql_minor10').val();
        var major = dis.closest('.AQLModal10').find('.aql_major10').val();
        var lvl = dis.closest('.AQLModal10').find('.aql_normal_level10').val();
        var special_lvl = dis.closest('.AQLModal10').find('.aql_special_level10').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal10').find('.max_major10').val(majorMax);
        dis.closest('.AQLModal10').find('.max_minor10').val(minorMax);
        dis.closest('.AQLModal10').find('.aql_normal_letter10').val(letter);
        dis.closest('.AQLModal10').find('.aql_special_letter10').val(special_letter);
        dis.closest('.AQLModal10').find('.aql_normal_sampsize10').val(sampsize);
        dis.closest('.AQLModal10').find('.aql_special_sampsize10').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level10', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal10').find('.aql_qty10').val();
        var minor = dis.closest('.AQLModal10').find('.aql_minor10').val();
        var major = dis.closest('.AQLModal10').find('.aql_major10').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal10').find('.max_major10').val(majorMax);
        dis.closest('.AQLModal10').find('.max_minor10').val(minorMax);
        dis.closest('.AQLModal10').find('.aql_normal_letter10').val(letter);
        dis.closest('.AQLModal10').find('.aql_normal_sampsize10').val(sampsize);
    })

    $('body').on('change', '.aql_special_level10', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal10').find('.aql_qty10').val();
        var minor = dis.closest('.AQLModal10').find('.aql_minor10').val();
        var major = dis.closest('.AQLModal10').find('.aql_major10').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal10').find('.aql_special_letter10').val(letter);
        dis.closest('.AQLModal10').find('.aql_special_sampsize10').val(sampsize);
    })

    $('body').on('change', '.aql_major10', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal10').find('.aql_qty10').val();
        var minor = dis.closest('.AQLModal10').find('.aql_minor10').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal10').find('.aql_normal_level10').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal10').find('.max_major10').val(majorMax);
        dis.closest('.AQLModal10').find('.max_minor10').val(minorMax);
        dis.closest('.AQLModal10').find('.aql_normal_letter10').val(letter);
        dis.closest('.AQLModal10').find('.aql_normal_sampsize10').val(sampsize);
    })

    $('body').on('change', '.aql_minor10', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal10').find('.aql_qty10').val();
        var major = dis.closest('.AQLModal10').find('.aql_major10').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal10').find('.aql_normal_level10').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal10').find('.max_major10').val(majorMax);
        dis.closest('.AQLModal10').find('.max_minor10').val(minorMax);
        dis.closest('.AQLModal10').find('.aql_normal_letter10').val(letter);
        dis.closest('.AQLModal10').find('.aql_normal_sampsize10').val(sampsize);
    })

    $('body').on('click', '.confirmAQL10', function() {
        var dis = $(this);
        dis.closest('.part10').find('.main_part_qty10').val(dis.closest('.part10').find('.aql_qty10').val());
        dis.closest('.part10').find('#samples_unit10').val(dis.closest('.part10').find('.aql_normal_sampsize10').val());
        dis.closest('.part10').find('.AQLModal10').modal('hide');

    });

    $('.aql_select10').append('<option value="">--</option>');
    $('.aql_select10').append('<option value="0.065">0.065</option>');
    $('.aql_select10').append('<option value="0.10">0.10</option>');
    $('.aql_select10').append('<option value="0.15">0.15</option>');
    $('.aql_select10').append('<option value="0.25">0.25</option>');
    $('.aql_select10').append('<option value="0.4">0.4</option>');
    $('.aql_select10').append('<option value="0.65">0.65</option>');
    $('.aql_select10').append('<option value="1">1.0</option>');
    $('.aql_select10').append('<option value="1.5">1.5</option>');
    $('.aql_select10').append('<option value="2.5">2.5</option>');
    $('.aql_select10').append('<option value="4">4.0</option>');
    $('.aql_select10').append('<option value="6.5">6.5</option>');
    $('.aql_select10').append('<option value="10">10.0</option>');
    $('.aql_select10').append('<option value="N/A">N/A</option>');

    //11
    $('body').on('click', '.btn-main_part_qty-modal11', function() {
        jQuery.noConflict();
        $('.AQLModal11').modal('show');
    });

    $('body').on('keyup', '.aql_qty11', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal11').find('.aql_minor11').val();
        var major = dis.closest('.AQLModal11').find('.aql_major11').val();
        var lvl = dis.closest('.AQLModal11').find('.aql_normal_level11').val();
        var special_lvl = dis.closest('.AQLModal11').find('.aql_special_level11').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal11').find('.max_major11').val(majorMax);
        dis.closest('.AQLModal11').find('.max_minor11').val(minorMax);
        dis.closest('.AQLModal11').find('.aql_normal_letter11').val(letter);
        dis.closest('.AQLModal11').find('.aql_special_letter11').val(special_letter);
        dis.closest('.AQLModal11').find('.aql_normal_sampsize11').val(sampsize);
        dis.closest('.AQLModal11').find('.aql_special_sampsize11').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level11', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal11').find('.aql_qty11').val();
        var minor = dis.closest('.AQLModal11').find('.aql_minor11').val();
        var major = dis.closest('.AQLModal11').find('.aql_major11').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal11').find('.max_major11').val(majorMax);
        dis.closest('.AQLModal11').find('.max_minor11').val(minorMax);
        dis.closest('.AQLModal11').find('.aql_normal_letter11').val(letter);
        dis.closest('.AQLModal11').find('.aql_normal_sampsize11').val(sampsize);
    })

    $('body').on('change', '.aql_special_level11', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal11').find('.aql_qty11').val();
        var minor = dis.closest('.AQLModal11').find('.aql_minor11').val();
        var major = dis.closest('.AQLModal11').find('.aql_major11').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal11').find('.aql_special_letter11').val(letter);
        dis.closest('.AQLModal11').find('.aql_special_sampsize11').val(sampsize);
    })

    $('body').on('change', '.aql_major11', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal11').find('.aql_qty11').val();
        var minor = dis.closest('.AQLModal11').find('.aql_minor11').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal11').find('.aql_normal_level11').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal11').find('.max_major11').val(majorMax);
        dis.closest('.AQLModal11').find('.max_minor11').val(minorMax);
        dis.closest('.AQLModal11').find('.aql_normal_letter11').val(letter);
        dis.closest('.AQLModal11').find('.aql_normal_sampsize11').val(sampsize);
    })

    $('body').on('change', '.aql_minor11', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal11').find('.aql_qty11').val();
        var major = dis.closest('.AQLModal11').find('.aql_major11').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal11').find('.aql_normal_level11').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal11').find('.max_major11').val(majorMax);
        dis.closest('.AQLModal11').find('.max_minor11').val(minorMax);
        dis.closest('.AQLModal11').find('.aql_normal_letter11').val(letter);
        dis.closest('.AQLModal11').find('.aql_normal_sampsize11').val(sampsize);
    })

    $('body').on('click', '.confirmAQL11', function() {
        var dis = $(this);
        dis.closest('.part11').find('.main_part_qty11').val(dis.closest('.part11').find('.aql_qty11').val());
        dis.closest('.part11').find('#samples_unit11').val(dis.closest('.part11').find('.aql_normal_sampsize11').val());
        dis.closest('.part11').find('.AQLModal11').modal('hide');

    });

    $('.aql_select11').append('<option value="">--</option>');
    $('.aql_select11').append('<option value="0.065">0.065</option>');
    $('.aql_select11').append('<option value="0.10">0.10</option>');
    $('.aql_select11').append('<option value="0.15">0.15</option>');
    $('.aql_select11').append('<option value="0.25">0.25</option>');
    $('.aql_select11').append('<option value="0.4">0.4</option>');
    $('.aql_select11').append('<option value="0.65">0.65</option>');
    $('.aql_select11').append('<option value="1">1.0</option>');
    $('.aql_select11').append('<option value="1.5">1.5</option>');
    $('.aql_select11').append('<option value="2.5">2.5</option>');
    $('.aql_select11').append('<option value="4">4.0</option>');
    $('.aql_select11').append('<option value="6.5">6.5</option>');
    $('.aql_select11').append('<option value="10">10.0</option>');
    $('.aql_select11').append('<option value="N/A">N/A</option>');

    //12
    $('body').on('click', '.btn-main_part_qty-modal12', function() {
        jQuery.noConflict();
        $('.AQLModal12').modal('show');
    });

    $('body').on('keyup', '.aql_qty12', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal12').find('.aql_minor12').val();
        var major = dis.closest('.AQLModal12').find('.aql_major12').val();
        var lvl = dis.closest('.AQLModal12').find('.aql_normal_level12').val();
        var special_lvl = dis.closest('.AQLModal12').find('.aql_special_level12').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal12').find('.max_major12').val(majorMax);
        dis.closest('.AQLModal12').find('.max_minor12').val(minorMax);
        dis.closest('.AQLModal12').find('.aql_normal_letter12').val(letter);
        dis.closest('.AQLModal12').find('.aql_special_letter12').val(special_letter);
        dis.closest('.AQLModal12').find('.aql_normal_sampsize12').val(sampsize);
        dis.closest('.AQLModal12').find('.aql_special_sampsize12').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level12', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal12').find('.aql_qty12').val();
        var minor = dis.closest('.AQLModal12').find('.aql_minor12').val();
        var major = dis.closest('.AQLModal12').find('.aql_major12').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal12').find('.max_major12').val(majorMax);
        dis.closest('.AQLModal12').find('.max_minor12').val(minorMax);
        dis.closest('.AQLModal12').find('.aql_normal_letter12').val(letter);
        dis.closest('.AQLModal12').find('.aql_normal_sampsize12').val(sampsize);
    })

    $('body').on('change', '.aql_special_level12', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal12').find('.aql_qty12').val();
        var minor = dis.closest('.AQLModal12').find('.aql_minor12').val();
        var major = dis.closest('.AQLModal12').find('.aql_major12').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal12').find('.aql_special_letter12').val(letter);
        dis.closest('.AQLModal12').find('.aql_special_sampsize12').val(sampsize);
    })

    $('body').on('change', '.aql_major12', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal12').find('.aql_qty12').val();
        var minor = dis.closest('.AQLModal12').find('.aql_minor12').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal12').find('.aql_normal_level12').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal12').find('.max_major12').val(majorMax);
        dis.closest('.AQLModal12').find('.max_minor12').val(minorMax);
        dis.closest('.AQLModal12').find('.aql_normal_letter12').val(letter);
        dis.closest('.AQLModal12').find('.aql_normal_sampsize12').val(sampsize);
    })

    $('body').on('change', '.aql_minor12', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal12').find('.aql_qty12').val();
        var major = dis.closest('.AQLModal12').find('.aql_major12').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal12').find('.aql_normal_level12').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal12').find('.max_major12').val(majorMax);
        dis.closest('.AQLModal12').find('.max_minor12').val(minorMax);
        dis.closest('.AQLModal12').find('.aql_normal_letter12').val(letter);
        dis.closest('.AQLModal12').find('.aql_normal_sampsize12').val(sampsize);
    })

    $('body').on('click', '.confirmAQL12', function() {
        var dis = $(this);
        dis.closest('.part12').find('.main_part_qty12').val(dis.closest('.part12').find('.aql_qty12').val());
        dis.closest('.part12').find('#samples_unit12').val(dis.closest('.part12').find('.aql_normal_sampsize12').val());
        dis.closest('.part12').find('.AQLModal12').modal('hide');

    });

    $('.aql_select12').append('<option value="">--</option>');
    $('.aql_select12').append('<option value="0.065">0.065</option>');
    $('.aql_select12').append('<option value="0.10">0.10</option>');
    $('.aql_select12').append('<option value="0.15">0.15</option>');
    $('.aql_select12').append('<option value="0.25">0.25</option>');
    $('.aql_select12').append('<option value="0.4">0.4</option>');
    $('.aql_select12').append('<option value="0.65">0.65</option>');
    $('.aql_select12').append('<option value="1">1.0</option>');
    $('.aql_select12').append('<option value="1.5">1.5</option>');
    $('.aql_select12').append('<option value="2.5">2.5</option>');
    $('.aql_select12').append('<option value="4">4.0</option>');
    $('.aql_select12').append('<option value="6.5">6.5</option>');
    $('.aql_select12').append('<option value="10">10.0</option>');
    $('.aql_select12').append('<option value="N/A">N/A</option>');

    //13
    $('body').on('click', '.btn-main_part_qty-modal13', function() {
        jQuery.noConflict();
        $('.AQLModal13').modal('show');
    });

    $('body').on('keyup', '.aql_qty13', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal13').find('.aql_minor13').val();
        var major = dis.closest('.AQLModal13').find('.aql_major13').val();
        var lvl = dis.closest('.AQLModal13').find('.aql_normal_level13').val();
        var special_lvl = dis.closest('.AQLModal13').find('.aql_special_level13').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal13').find('.max_major13').val(majorMax);
        dis.closest('.AQLModal13').find('.max_minor13').val(minorMax);
        dis.closest('.AQLModal13').find('.aql_normal_letter13').val(letter);
        dis.closest('.AQLModal13').find('.aql_special_letter13').val(special_letter);
        dis.closest('.AQLModal13').find('.aql_normal_sampsize13').val(sampsize);
        dis.closest('.AQLModal13').find('.aql_special_sampsize13').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level13', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal13').find('.aql_qty13').val();
        var minor = dis.closest('.AQLModal13').find('.aql_minor13').val();
        var major = dis.closest('.AQLModal13').find('.aql_major13').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal13').find('.max_major13').val(majorMax);
        dis.closest('.AQLModal13').find('.max_minor13').val(minorMax);
        dis.closest('.AQLModal13').find('.aql_normal_letter13').val(letter);
        dis.closest('.AQLModal13').find('.aql_normal_sampsize13').val(sampsize);
    })

    $('body').on('change', '.aql_special_level13', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal13').find('.aql_qty13').val();
        var minor = dis.closest('.AQLModal13').find('.aql_minor13').val();
        var major = dis.closest('.AQLModal13').find('.aql_major13').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal13').find('.aql_special_letter13').val(letter);
        dis.closest('.AQLModal13').find('.aql_special_sampsize13').val(sampsize);
    })

    $('body').on('change', '.aql_major13', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal13').find('.aql_qty13').val();
        var minor = dis.closest('.AQLModal13').find('.aql_minor13').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal13').find('.aql_normal_level13').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal13').find('.max_major13').val(majorMax);
        dis.closest('.AQLModal13').find('.max_minor13').val(minorMax);
        dis.closest('.AQLModal13').find('.aql_normal_letter13').val(letter);
        dis.closest('.AQLModal13').find('.aql_normal_sampsize13').val(sampsize);
    })

    $('body').on('change', '.aql_minor13', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal13').find('.aql_qty13').val();
        var major = dis.closest('.AQLModal13').find('.aql_major13').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal13').find('.aql_normal_level13').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal13').find('.max_major13').val(majorMax);
        dis.closest('.AQLModal13').find('.max_minor13').val(minorMax);
        dis.closest('.AQLModal13').find('.aql_normal_letter13').val(letter);
        dis.closest('.AQLModal13').find('.aql_normal_sampsize13').val(sampsize);
    })

    $('body').on('click', '.confirmAQL13', function() {
        var dis = $(this);
        dis.closest('.part13').find('.main_part_qty13').val(dis.closest('.part13').find('.aql_qty13').val());
        dis.closest('.part13').find('#samples_unit13').val(dis.closest('.part13').find('.aql_normal_sampsize13').val());
        dis.closest('.part13').find('.AQLModal13').modal('hide');

    });

    $('.aql_select13').append('<option value="">--</option>');
    $('.aql_select13').append('<option value="0.065">0.065</option>');
    $('.aql_select13').append('<option value="0.10">0.10</option>');
    $('.aql_select13').append('<option value="0.15">0.15</option>');
    $('.aql_select13').append('<option value="0.25">0.25</option>');
    $('.aql_select13').append('<option value="0.4">0.4</option>');
    $('.aql_select13').append('<option value="0.65">0.65</option>');
    $('.aql_select13').append('<option value="1">1.0</option>');
    $('.aql_select13').append('<option value="1.5">1.5</option>');
    $('.aql_select13').append('<option value="2.5">2.5</option>');
    $('.aql_select13').append('<option value="4">4.0</option>');
    $('.aql_select13').append('<option value="6.5">6.5</option>');
    $('.aql_select13').append('<option value="10">10.0</option>');
    $('.aql_select13').append('<option value="N/A">N/A</option>');

    //14
    $('body').on('click', '.btn-main_part_qty-modal14', function() {
        jQuery.noConflict();
        $('.AQLModal14').modal('show');
    });

    $('body').on('keyup', '.aql_qty14', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal14').find('.aql_minor14').val();
        var major = dis.closest('.AQLModal14').find('.aql_major14').val();
        var lvl = dis.closest('.AQLModal14').find('.aql_normal_level14').val();
        var special_lvl = dis.closest('.AQLModal14').find('.aql_special_level14').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal14').find('.max_major14').val(majorMax);
        dis.closest('.AQLModal14').find('.max_minor14').val(minorMax);
        dis.closest('.AQLModal14').find('.aql_normal_letter14').val(letter);
        dis.closest('.AQLModal14').find('.aql_special_letter14').val(special_letter);
        dis.closest('.AQLModal14').find('.aql_normal_sampsize14').val(sampsize);
        dis.closest('.AQLModal14').find('.aql_special_sampsize14').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level14', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal14').find('.aql_qty14').val();
        var minor = dis.closest('.AQLModal14').find('.aql_minor14').val();
        var major = dis.closest('.AQLModal14').find('.aql_major14').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal14').find('.max_major14').val(majorMax);
        dis.closest('.AQLModal14').find('.max_minor14').val(minorMax);
        dis.closest('.AQLModal14').find('.aql_normal_letter14').val(letter);
        dis.closest('.AQLModal14').find('.aql_normal_sampsize14').val(sampsize);
    })

    $('body').on('change', '.aql_special_level14', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal14').find('.aql_qty14').val();
        var minor = dis.closest('.AQLModal14').find('.aql_minor14').val();
        var major = dis.closest('.AQLModal14').find('.aql_major14').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal14').find('.aql_special_letter14').val(letter);
        dis.closest('.AQLModal14').find('.aql_special_sampsize14').val(sampsize);
    })

    $('body').on('change', '.aql_major14', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal14').find('.aql_qty14').val();
        var minor = dis.closest('.AQLModal14').find('.aql_minor14').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal14').find('.aql_normal_level14').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal14').find('.max_major14').val(majorMax);
        dis.closest('.AQLModal14').find('.max_minor14').val(minorMax);
        dis.closest('.AQLModal14').find('.aql_normal_letter14').val(letter);
        dis.closest('.AQLModal14').find('.aql_normal_sampsize14').val(sampsize);
    })

    $('body').on('change', '.aql_minor14', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal14').find('.aql_qty14').val();
        var major = dis.closest('.AQLModal14').find('.aql_major14').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal14').find('.aql_normal_level14').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal14').find('.max_major14').val(majorMax);
        dis.closest('.AQLModal14').find('.max_minor14').val(minorMax);
        dis.closest('.AQLModal14').find('.aql_normal_letter14').val(letter);
        dis.closest('.AQLModal14').find('.aql_normal_sampsize14').val(sampsize);
    })

    $('body').on('click', '.confirmAQL14', function() {
        var dis = $(this);
        dis.closest('.part14').find('.main_part_qty14').val(dis.closest('.part14').find('.aql_qty14').val());
        dis.closest('.part14').find('#samples_unit14').val(dis.closest('.part14').find('.aql_normal_sampsize14').val());
        dis.closest('.part14').find('.AQLModal14').modal('hide');

    });

    $('.aql_select14').append('<option value="">--</option>');
    $('.aql_select14').append('<option value="0.065">0.065</option>');
    $('.aql_select14').append('<option value="0.10">0.10</option>');
    $('.aql_select14').append('<option value="0.15">0.15</option>');
    $('.aql_select14').append('<option value="0.25">0.25</option>');
    $('.aql_select14').append('<option value="0.4">0.4</option>');
    $('.aql_select14').append('<option value="0.65">0.65</option>');
    $('.aql_select14').append('<option value="1">1.0</option>');
    $('.aql_select14').append('<option value="1.5">1.5</option>');
    $('.aql_select14').append('<option value="2.5">2.5</option>');
    $('.aql_select14').append('<option value="4">4.0</option>');
    $('.aql_select14').append('<option value="6.5">6.5</option>');
    $('.aql_select14').append('<option value="10">10.0</option>');
    $('.aql_select14').append('<option value="N/A">N/A</option>');

    //15
    $('body').on('click', '.btn-main_part_qty-modal15', function() {
        jQuery.noConflict();
        $('.AQLModal15').modal('show');
    });

    $('body').on('keyup', '.aql_qty15', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal15').find('.aql_minor15').val();
        var major = dis.closest('.AQLModal15').find('.aql_major15').val();
        var lvl = dis.closest('.AQLModal15').find('.aql_normal_level15').val();
        var special_lvl = dis.closest('.AQLModal15').find('.aql_special_level15').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal15').find('.max_major15').val(majorMax);
        dis.closest('.AQLModal15').find('.max_minor15').val(minorMax);
        dis.closest('.AQLModal15').find('.aql_normal_letter15').val(letter);
        dis.closest('.AQLModal15').find('.aql_special_letter15').val(special_letter);
        dis.closest('.AQLModal15').find('.aql_normal_sampsize15').val(sampsize);
        dis.closest('.AQLModal15').find('.aql_special_sampsize15').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level15', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal15').find('.aql_qty15').val();
        var minor = dis.closest('.AQLModal15').find('.aql_minor15').val();
        var major = dis.closest('.AQLModal15').find('.aql_major15').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal15').find('.max_major15').val(majorMax);
        dis.closest('.AQLModal15').find('.max_minor15').val(minorMax);
        dis.closest('.AQLModal15').find('.aql_normal_letter15').val(letter);
        dis.closest('.AQLModal15').find('.aql_normal_sampsize15').val(sampsize);
    })

    $('body').on('change', '.aql_special_level15', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal15').find('.aql_qty15').val();
        var minor = dis.closest('.AQLModal15').find('.aql_minor15').val();
        var major = dis.closest('.AQLModal15').find('.aql_major15').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal15').find('.aql_special_letter15').val(letter);
        dis.closest('.AQLModal15').find('.aql_special_sampsize15').val(sampsize);
    })

    $('body').on('change', '.aql_major15', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal15').find('.aql_qty15').val();
        var minor = dis.closest('.AQLModal15').find('.aql_minor15').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal15').find('.aql_normal_level15').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal15').find('.max_major15').val(majorMax);
        dis.closest('.AQLModal15').find('.max_minor15').val(minorMax);
        dis.closest('.AQLModal15').find('.aql_normal_letter15').val(letter);
        dis.closest('.AQLModal15').find('.aql_normal_sampsize15').val(sampsize);
    })

    $('body').on('change', '.aql_minor15', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal15').find('.aql_qty15').val();
        var major = dis.closest('.AQLModal15').find('.aql_major15').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal15').find('.aql_normal_level15').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal15').find('.max_major15').val(majorMax);
        dis.closest('.AQLModal15').find('.max_minor15').val(minorMax);
        dis.closest('.AQLModal15').find('.aql_normal_letter15').val(letter);
        dis.closest('.AQLModal15').find('.aql_normal_sampsize15').val(sampsize);
    })

    $('body').on('click', '.confirmAQL15', function() {
        var dis = $(this);
        dis.closest('.part15').find('.main_part_qty15').val(dis.closest('.part15').find('.aql_qty15').val());
        dis.closest('.part15').find('#samples_unit15').val(dis.closest('.part15').find('.aql_normal_sampsize15').val());
        dis.closest('.part15').find('.AQLModal15').modal('hide');

    });

    $('.aql_select15').append('<option value="">--</option>');
    $('.aql_select15').append('<option value="0.065">0.065</option>');
    $('.aql_select15').append('<option value="0.10">0.10</option>');
    $('.aql_select15').append('<option value="0.15">0.15</option>');
    $('.aql_select15').append('<option value="0.25">0.25</option>');
    $('.aql_select15').append('<option value="0.4">0.4</option>');
    $('.aql_select15').append('<option value="0.65">0.65</option>');
    $('.aql_select15').append('<option value="1">1.0</option>');
    $('.aql_select15').append('<option value="1.5">1.5</option>');
    $('.aql_select15').append('<option value="2.5">2.5</option>');
    $('.aql_select15').append('<option value="4">4.0</option>');
    $('.aql_select15').append('<option value="6.5">6.5</option>');
    $('.aql_select15').append('<option value="10">10.0</option>');
    $('.aql_select15').append('<option value="N/A">N/A</option>');

    //16
    $('body').on('click', '.btn-main_part_qty-modal16', function() {
        jQuery.noConflict();
        $('.AQLModal16').modal('show');
    });

    $('body').on('keyup', '.aql_qty16', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal16').find('.aql_minor16').val();
        var major = dis.closest('.AQLModal16').find('.aql_major16').val();
        var lvl = dis.closest('.AQLModal16').find('.aql_normal_level16').val();
        var special_lvl = dis.closest('.AQLModal16').find('.aql_special_level16').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal16').find('.max_major16').val(majorMax);
        dis.closest('.AQLModal16').find('.max_minor16').val(minorMax);
        dis.closest('.AQLModal16').find('.aql_normal_letter16').val(letter);
        dis.closest('.AQLModal16').find('.aql_special_letter16').val(special_letter);
        dis.closest('.AQLModal16').find('.aql_normal_sampsize16').val(sampsize);
        dis.closest('.AQLModal16').find('.aql_special_sampsize16').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level16', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal16').find('.aql_qty16').val();
        var minor = dis.closest('.AQLModal16').find('.aql_minor16').val();
        var major = dis.closest('.AQLModal16').find('.aql_major16').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal16').find('.max_major16').val(majorMax);
        dis.closest('.AQLModal16').find('.max_minor16').val(minorMax);
        dis.closest('.AQLModal16').find('.aql_normal_letter16').val(letter);
        dis.closest('.AQLModal16').find('.aql_normal_sampsize16').val(sampsize);
    })

    $('body').on('change', '.aql_special_level16', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal16').find('.aql_qty16').val();
        var minor = dis.closest('.AQLModal16').find('.aql_minor16').val();
        var major = dis.closest('.AQLModal16').find('.aql_major16').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal16').find('.aql_special_letter16').val(letter);
        dis.closest('.AQLModal16').find('.aql_special_sampsize16').val(sampsize);
    })

    $('body').on('change', '.aql_major16', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal16').find('.aql_qty16').val();
        var minor = dis.closest('.AQLModal16').find('.aql_minor16').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal16').find('.aql_normal_level16').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal16').find('.max_major16').val(majorMax);
        dis.closest('.AQLModal16').find('.max_minor16').val(minorMax);
        dis.closest('.AQLModal16').find('.aql_normal_letter16').val(letter);
        dis.closest('.AQLModal16').find('.aql_normal_sampsize16').val(sampsize);
    })

    $('body').on('change', '.aql_minor16', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal16').find('.aql_qty16').val();
        var major = dis.closest('.AQLModal16').find('.aql_major16').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal16').find('.aql_normal_level16').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal16').find('.max_major16').val(majorMax);
        dis.closest('.AQLModal16').find('.max_minor16').val(minorMax);
        dis.closest('.AQLModal16').find('.aql_normal_letter16').val(letter);
        dis.closest('.AQLModal16').find('.aql_normal_sampsize16').val(sampsize);
    })

    $('body').on('click', '.confirmAQL16', function() {
        var dis = $(this);
        dis.closest('.part16').find('.main_part_qty16').val(dis.closest('.part16').find('.aql_qty16').val());
        dis.closest('.part16').find('#samples_unit16').val(dis.closest('.part16').find('.aql_normal_sampsize16').val());
        dis.closest('.part16').find('.AQLModal16').modal('hide');

    });

    $('.aql_select16').append('<option value="">--</option>');
    $('.aql_select16').append('<option value="0.065">0.065</option>');
    $('.aql_select16').append('<option value="0.10">0.10</option>');
    $('.aql_select16').append('<option value="0.15">0.15</option>');
    $('.aql_select16').append('<option value="0.25">0.25</option>');
    $('.aql_select16').append('<option value="0.4">0.4</option>');
    $('.aql_select16').append('<option value="0.65">0.65</option>');
    $('.aql_select16').append('<option value="1">1.0</option>');
    $('.aql_select16').append('<option value="1.5">1.5</option>');
    $('.aql_select16').append('<option value="2.5">2.5</option>');
    $('.aql_select16').append('<option value="4">4.0</option>');
    $('.aql_select16').append('<option value="6.5">6.5</option>');
    $('.aql_select16').append('<option value="10">10.0</option>');
    $('.aql_select16').append('<option value="N/A">N/A</option>');

    //17
    $('body').on('click', '.btn-main_part_qty-modal17', function() {
        jQuery.noConflict();
        $('.AQLModal17').modal('show');
    });

    $('body').on('keyup', '.aql_qty17', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal17').find('.aql_minor17').val();
        var major = dis.closest('.AQLModal17').find('.aql_major17').val();
        var lvl = dis.closest('.AQLModal17').find('.aql_normal_level17').val();
        var special_lvl = dis.closest('.AQLModal17').find('.aql_special_level17').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal17').find('.max_major17').val(majorMax);
        dis.closest('.AQLModal17').find('.max_minor17').val(minorMax);
        dis.closest('.AQLModal17').find('.aql_normal_letter17').val(letter);
        dis.closest('.AQLModal17').find('.aql_special_letter17').val(special_letter);
        dis.closest('.AQLModal17').find('.aql_normal_sampsize17').val(sampsize);
        dis.closest('.AQLModal17').find('.aql_special_sampsize17').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level17', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal17').find('.aql_qty17').val();
        var minor = dis.closest('.AQLModal17').find('.aql_minor17').val();
        var major = dis.closest('.AQLModal17').find('.aql_major17').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal17').find('.max_major17').val(majorMax);
        dis.closest('.AQLModal17').find('.max_minor17').val(minorMax);
        dis.closest('.AQLModal17').find('.aql_normal_letter17').val(letter);
        dis.closest('.AQLModal17').find('.aql_normal_sampsize17').val(sampsize);
    })

    $('body').on('change', '.aql_special_level17', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal17').find('.aql_qty17').val();
        var minor = dis.closest('.AQLModal17').find('.aql_minor17').val();
        var major = dis.closest('.AQLModal17').find('.aql_major17').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal17').find('.aql_special_letter17').val(letter);
        dis.closest('.AQLModal17').find('.aql_special_sampsize17').val(sampsize);
    })

    $('body').on('change', '.aql_major17', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal17').find('.aql_qty17').val();
        var minor = dis.closest('.AQLModal17').find('.aql_minor17').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal17').find('.aql_normal_level17').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal17').find('.max_major17').val(majorMax);
        dis.closest('.AQLModal17').find('.max_minor17').val(minorMax);
        dis.closest('.AQLModal17').find('.aql_normal_letter17').val(letter);
        dis.closest('.AQLModal17').find('.aql_normal_sampsize17').val(sampsize);
    })

    $('body').on('change', '.aql_minor17', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal17').find('.aql_qty17').val();
        var major = dis.closest('.AQLModal17').find('.aql_major17').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal17').find('.aql_normal_level17').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal17').find('.max_major17').val(majorMax);
        dis.closest('.AQLModal17').find('.max_minor17').val(minorMax);
        dis.closest('.AQLModal17').find('.aql_normal_letter17').val(letter);
        dis.closest('.AQLModal17').find('.aql_normal_sampsize17').val(sampsize);
    })

    $('body').on('click', '.confirmAQL17', function() {
        var dis = $(this);
        dis.closest('.part17').find('.main_part_qty17').val(dis.closest('.part17').find('.aql_qty17').val());
        dis.closest('.part17').find('#samples_unit17').val(dis.closest('.part17').find('.aql_normal_sampsize17').val());
        dis.closest('.part17').find('.AQLModal17').modal('hide');

    });

    $('.aql_select17').append('<option value="">--</option>');
    $('.aql_select17').append('<option value="0.065">0.065</option>');
    $('.aql_select17').append('<option value="0.10">0.10</option>');
    $('.aql_select17').append('<option value="0.15">0.15</option>');
    $('.aql_select17').append('<option value="0.25">0.25</option>');
    $('.aql_select17').append('<option value="0.4">0.4</option>');
    $('.aql_select17').append('<option value="0.65">0.65</option>');
    $('.aql_select17').append('<option value="1">1.0</option>');
    $('.aql_select17').append('<option value="1.5">1.5</option>');
    $('.aql_select17').append('<option value="2.5">2.5</option>');
    $('.aql_select17').append('<option value="4">4.0</option>');
    $('.aql_select17').append('<option value="6.5">6.5</option>');
    $('.aql_select17').append('<option value="10">10.0</option>');
    $('.aql_select17').append('<option value="N/A">N/A</option>');

    //18
    $('body').on('click', '.btn-main_part_qty-modal18', function() {
        jQuery.noConflict();
        $('.AQLModal18').modal('show');
    });

    $('body').on('keyup', '.aql_qty18', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal18').find('.aql_minor18').val();
        var major = dis.closest('.AQLModal18').find('.aql_major18').val();
        var lvl = dis.closest('.AQLModal18').find('.aql_normal_level18').val();
        var special_lvl = dis.closest('.AQLModal18').find('.aql_special_level18').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal18').find('.max_major18').val(majorMax);
        dis.closest('.AQLModal18').find('.max_minor18').val(minorMax);
        dis.closest('.AQLModal18').find('.aql_normal_letter18').val(letter);
        dis.closest('.AQLModal18').find('.aql_special_letter18').val(special_letter);
        dis.closest('.AQLModal18').find('.aql_normal_sampsize18').val(sampsize);
        dis.closest('.AQLModal18').find('.aql_special_sampsize18').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level18', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal18').find('.aql_qty18').val();
        var minor = dis.closest('.AQLModal18').find('.aql_minor18').val();
        var major = dis.closest('.AQLModal18').find('.aql_major18').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal18').find('.max_major18').val(majorMax);
        dis.closest('.AQLModal18').find('.max_minor18').val(minorMax);
        dis.closest('.AQLModal18').find('.aql_normal_letter18').val(letter);
        dis.closest('.AQLModal18').find('.aql_normal_sampsize18').val(sampsize);
    })

    $('body').on('change', '.aql_special_level18', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal18').find('.aql_qty18').val();
        var minor = dis.closest('.AQLModal18').find('.aql_minor18').val();
        var major = dis.closest('.AQLModal18').find('.aql_major18').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal18').find('.aql_special_letter18').val(letter);
        dis.closest('.AQLModal18').find('.aql_special_sampsize18').val(sampsize);
    })

    $('body').on('change', '.aql_major18', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal18').find('.aql_qty18').val();
        var minor = dis.closest('.AQLModal18').find('.aql_minor18').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal18').find('.aql_normal_level18').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal18').find('.max_major18').val(majorMax);
        dis.closest('.AQLModal18').find('.max_minor18').val(minorMax);
        dis.closest('.AQLModal18').find('.aql_normal_letter18').val(letter);
        dis.closest('.AQLModal18').find('.aql_normal_sampsize18').val(sampsize);
    })

    $('body').on('change', '.aql_minor18', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal18').find('.aql_qty18').val();
        var major = dis.closest('.AQLModal18').find('.aql_major18').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal18').find('.aql_normal_level18').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal18').find('.max_major18').val(majorMax);
        dis.closest('.AQLModal18').find('.max_minor18').val(minorMax);
        dis.closest('.AQLModal18').find('.aql_normal_letter18').val(letter);
        dis.closest('.AQLModal18').find('.aql_normal_sampsize18').val(sampsize);
    })

    $('body').on('click', '.confirmAQL18', function() {
        var dis = $(this);
        dis.closest('.part18').find('.main_part_qty18').val(dis.closest('.part18').find('.aql_qty18').val());
        dis.closest('.part18').find('#samples_unit18').val(dis.closest('.part18').find('.aql_normal_sampsize18').val());
        dis.closest('.part18').find('.AQLModal18').modal('hide');

    });

    $('.aql_select18').append('<option value="">--</option>');
    $('.aql_select18').append('<option value="0.065">0.065</option>');
    $('.aql_select18').append('<option value="0.10">0.10</option>');
    $('.aql_select18').append('<option value="0.15">0.15</option>');
    $('.aql_select18').append('<option value="0.25">0.25</option>');
    $('.aql_select18').append('<option value="0.4">0.4</option>');
    $('.aql_select18').append('<option value="0.65">0.65</option>');
    $('.aql_select18').append('<option value="1">1.0</option>');
    $('.aql_select18').append('<option value="1.5">1.5</option>');
    $('.aql_select18').append('<option value="2.5">2.5</option>');
    $('.aql_select18').append('<option value="4">4.0</option>');
    $('.aql_select18').append('<option value="6.5">6.5</option>');
    $('.aql_select18').append('<option value="10">10.0</option>');
    $('.aql_select18').append('<option value="N/A">N/A</option>');

    //19
    $('body').on('click', '.btn-main_part_qty-modal19', function() {
        jQuery.noConflict();
        $('.AQLModal19').modal('show');
    });

    $('body').on('keyup', '.aql_qty19', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal19').find('.aql_minor19').val();
        var major = dis.closest('.AQLModal19').find('.aql_major19').val();
        var lvl = dis.closest('.AQLModal19').find('.aql_normal_level19').val();
        var special_lvl = dis.closest('.AQLModal19').find('.aql_special_level19').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal19').find('.max_major19').val(majorMax);
        dis.closest('.AQLModal19').find('.max_minor19').val(minorMax);
        dis.closest('.AQLModal19').find('.aql_normal_letter19').val(letter);
        dis.closest('.AQLModal19').find('.aql_special_letter19').val(special_letter);
        dis.closest('.AQLModal19').find('.aql_normal_sampsize19').val(sampsize);
        dis.closest('.AQLModal19').find('.aql_special_sampsize19').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level19', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal19').find('.aql_qty19').val();
        var minor = dis.closest('.AQLModal19').find('.aql_minor19').val();
        var major = dis.closest('.AQLModal19').find('.aql_major19').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal19').find('.max_major19').val(majorMax);
        dis.closest('.AQLModal19').find('.max_minor19').val(minorMax);
        dis.closest('.AQLModal19').find('.aql_normal_letter19').val(letter);
        dis.closest('.AQLModal19').find('.aql_normal_sampsize19').val(sampsize);
    })

    $('body').on('change', '.aql_special_level19', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal19').find('.aql_qty19').val();
        var minor = dis.closest('.AQLModal19').find('.aql_minor19').val();
        var major = dis.closest('.AQLModal19').find('.aql_major19').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal19').find('.aql_special_letter19').val(letter);
        dis.closest('.AQLModal19').find('.aql_special_sampsize19').val(sampsize);
    })

    $('body').on('change', '.aql_major19', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal19').find('.aql_qty19').val();
        var minor = dis.closest('.AQLModal19').find('.aql_minor19').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal19').find('.aql_normal_level19').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal19').find('.max_major19').val(majorMax);
        dis.closest('.AQLModal19').find('.max_minor19').val(minorMax);
        dis.closest('.AQLModal19').find('.aql_normal_letter19').val(letter);
        dis.closest('.AQLModal19').find('.aql_normal_sampsize19').val(sampsize);
    })

    $('body').on('change', '.aql_minor19', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal19').find('.aql_qty19').val();
        var major = dis.closest('.AQLModal19').find('.aql_major19').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal19').find('.aql_normal_level19').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal19').find('.max_major19').val(majorMax);
        dis.closest('.AQLModal19').find('.max_minor19').val(minorMax);
        dis.closest('.AQLModal19').find('.aql_normal_letter19').val(letter);
        dis.closest('.AQLModal19').find('.aql_normal_sampsize19').val(sampsize);
    })

    $('body').on('click', '.confirmAQL19', function() {
        var dis = $(this);
        dis.closest('.part19').find('.main_part_qty19').val(dis.closest('.part19').find('.aql_qty19').val());
        dis.closest('.part19').find('#samples_unit19').val(dis.closest('.part19').find('.aql_normal_sampsize19').val());
        dis.closest('.part19').find('.AQLModal19').modal('hide');

    });

    $('.aql_select19').append('<option value="">--</option>');
    $('.aql_select19').append('<option value="0.065">0.065</option>');
    $('.aql_select19').append('<option value="0.10">0.10</option>');
    $('.aql_select19').append('<option value="0.15">0.15</option>');
    $('.aql_select19').append('<option value="0.25">0.25</option>');
    $('.aql_select19').append('<option value="0.4">0.4</option>');
    $('.aql_select19').append('<option value="0.65">0.65</option>');
    $('.aql_select19').append('<option value="1">1.0</option>');
    $('.aql_select19').append('<option value="1.5">1.5</option>');
    $('.aql_select19').append('<option value="2.5">2.5</option>');
    $('.aql_select19').append('<option value="4">4.0</option>');
    $('.aql_select19').append('<option value="6.5">6.5</option>');
    $('.aql_select19').append('<option value="10">10.0</option>');
    $('.aql_select19').append('<option value="N/A">N/A</option>');

    //20
    $('body').on('click', '.btn-main_part_qty-modal20', function() {
        jQuery.noConflict();
        $('.AQLModal20').modal('show');
    });

    $('body').on('keyup', '.aql_qty20', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal20').find('.aql_minor20').val();
        var major = dis.closest('.AQLModal20').find('.aql_major20').val();
        var lvl = dis.closest('.AQLModal20').find('.aql_normal_level20').val();
        var special_lvl = dis.closest('.AQLModal20').find('.aql_special_level20').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal20').find('.max_major20').val(majorMax);
        dis.closest('.AQLModal20').find('.max_minor20').val(minorMax);
        dis.closest('.AQLModal20').find('.aql_normal_letter20').val(letter);
        dis.closest('.AQLModal20').find('.aql_special_letter20').val(special_letter);
        dis.closest('.AQLModal20').find('.aql_normal_sampsize20').val(sampsize);
        dis.closest('.AQLModal20').find('.aql_special_sampsize20').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level20', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal20').find('.aql_qty20').val();
        var minor = dis.closest('.AQLModal20').find('.aql_minor20').val();
        var major = dis.closest('.AQLModal20').find('.aql_major20').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal20').find('.max_major20').val(majorMax);
        dis.closest('.AQLModal20').find('.max_minor20').val(minorMax);
        dis.closest('.AQLModal20').find('.aql_normal_letter20').val(letter);
        dis.closest('.AQLModal20').find('.aql_normal_sampsize20').val(sampsize);
    })

    $('body').on('change', '.aql_special_level20', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal20').find('.aql_qty20').val();
        var minor = dis.closest('.AQLModal20').find('.aql_minor20').val();
        var major = dis.closest('.AQLModal20').find('.aql_major20').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal20').find('.aql_special_letter20').val(letter);
        dis.closest('.AQLModal20').find('.aql_special_sampsize20').val(sampsize);
    })

    $('body').on('change', '.aql_major20', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal20').find('.aql_qty20').val();
        var minor = dis.closest('.AQLModal20').find('.aql_minor20').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal20').find('.aql_normal_level20').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal20').find('.max_major20').val(majorMax);
        dis.closest('.AQLModal20').find('.max_minor20').val(minorMax);
        dis.closest('.AQLModal20').find('.aql_normal_letter20').val(letter);
        dis.closest('.AQLModal20').find('.aql_normal_sampsize20').val(sampsize);
    })

    $('body').on('change', '.aql_minor20', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal20').find('.aql_qty20').val();
        var major = dis.closest('.AQLModal20').find('.aql_major20').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal20').find('.aql_normal_level20').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal20').find('.max_major20').val(majorMax);
        dis.closest('.AQLModal20').find('.max_minor20').val(minorMax);
        dis.closest('.AQLModal20').find('.aql_normal_letter20').val(letter);
        dis.closest('.AQLModal20').find('.aql_normal_sampsize20').val(sampsize);
    })

    $('body').on('click', '.confirmAQL20', function() {
        var dis = $(this);
        dis.closest('.part20').find('.main_part_qty20').val(dis.closest('.part20').find('.aql_qty20').val());
        dis.closest('.part20').find('#samples_unit20').val(dis.closest('.part20').find('.aql_normal_sampsize20').val());
        dis.closest('.part20').find('.AQLModal20').modal('hide');

    });

    $('.aql_select20').append('<option value="">--</option>');
    $('.aql_select20').append('<option value="0.065">0.065</option>');
    $('.aql_select20').append('<option value="0.10">0.10</option>');
    $('.aql_select20').append('<option value="0.15">0.15</option>');
    $('.aql_select20').append('<option value="0.25">0.25</option>');
    $('.aql_select20').append('<option value="0.4">0.4</option>');
    $('.aql_select20').append('<option value="0.65">0.65</option>');
    $('.aql_select20').append('<option value="1">1.0</option>');
    $('.aql_select20').append('<option value="1.5">1.5</option>');
    $('.aql_select20').append('<option value="2.5">2.5</option>');
    $('.aql_select20').append('<option value="4">4.0</option>');
    $('.aql_select20').append('<option value="6.5">6.5</option>');
    $('.aql_select20').append('<option value="10">10.0</option>');
    $('.aql_select20').append('<option value="N/A">N/A</option>');

    //21
    $('body').on('click', '.btn-main_part_qty-modal21', function() {
        jQuery.noConflict();
        $('.AQLModal21').modal('show');
    });

    $('body').on('keyup', '.aql_qty21', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal21').find('.aql_minor21').val();
        var major = dis.closest('.AQLModal21').find('.aql_major21').val();
        var lvl = dis.closest('.AQLModal21').find('.aql_normal_level21').val();
        var special_lvl = dis.closest('.AQLModal21').find('.aql_special_level21').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal21').find('.max_major21').val(majorMax);
        dis.closest('.AQLModal21').find('.max_minor21').val(minorMax);
        dis.closest('.AQLModal21').find('.aql_normal_letter21').val(letter);
        dis.closest('.AQLModal21').find('.aql_special_letter21').val(special_letter);
        dis.closest('.AQLModal21').find('.aql_normal_sampsize21').val(sampsize);
        dis.closest('.AQLModal21').find('.aql_special_sampsize21').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level21', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal21').find('.aql_qty21').val();
        var minor = dis.closest('.AQLModal21').find('.aql_minor21').val();
        var major = dis.closest('.AQLModal21').find('.aql_major21').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal21').find('.max_major21').val(majorMax);
        dis.closest('.AQLModal21').find('.max_minor21').val(minorMax);
        dis.closest('.AQLModal21').find('.aql_normal_letter21').val(letter);
        dis.closest('.AQLModal21').find('.aql_normal_sampsize21').val(sampsize);
    })

    $('body').on('change', '.aql_special_level21', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal21').find('.aql_qty21').val();
        var minor = dis.closest('.AQLModal21').find('.aql_minor21').val();
        var major = dis.closest('.AQLModal21').find('.aql_major21').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal21').find('.aql_special_letter21').val(letter);
        dis.closest('.AQLModal21').find('.aql_special_sampsize21').val(sampsize);
    })

    $('body').on('change', '.aql_major21', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal21').find('.aql_qty21').val();
        var minor = dis.closest('.AQLModal21').find('.aql_minor21').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal21').find('.aql_normal_level21').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal21').find('.max_major21').val(majorMax);
        dis.closest('.AQLModal21').find('.max_minor21').val(minorMax);
        dis.closest('.AQLModal21').find('.aql_normal_letter21').val(letter);
        dis.closest('.AQLModal21').find('.aql_normal_sampsize21').val(sampsize);
    })

    $('body').on('change', '.aql_minor21', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal21').find('.aql_qty21').val();
        var major = dis.closest('.AQLModal21').find('.aql_major21').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal21').find('.aql_normal_level21').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal21').find('.max_major21').val(majorMax);
        dis.closest('.AQLModal21').find('.max_minor21').val(minorMax);
        dis.closest('.AQLModal21').find('.aql_normal_letter21').val(letter);
        dis.closest('.AQLModal21').find('.aql_normal_sampsize21').val(sampsize);
    })

    $('body').on('click', '.confirmAQL21', function() {
        var dis = $(this);
        dis.closest('.part21').find('.main_part_qty21').val(dis.closest('.part21').find('.aql_qty21').val());
        dis.closest('.part21').find('#samples_unit21').val(dis.closest('.part21').find('.aql_normal_sampsize21').val());
        dis.closest('.part21').find('.AQLModal21').modal('hide');

    });

    $('.aql_select21').append('<option value="">--</option>');
    $('.aql_select21').append('<option value="0.065">0.065</option>');
    $('.aql_select21').append('<option value="0.10">0.10</option>');
    $('.aql_select21').append('<option value="0.15">0.15</option>');
    $('.aql_select21').append('<option value="0.25">0.25</option>');
    $('.aql_select21').append('<option value="0.4">0.4</option>');
    $('.aql_select21').append('<option value="0.65">0.65</option>');
    $('.aql_select21').append('<option value="1">1.0</option>');
    $('.aql_select21').append('<option value="1.5">1.5</option>');
    $('.aql_select21').append('<option value="2.5">2.5</option>');
    $('.aql_select21').append('<option value="4">4.0</option>');
    $('.aql_select21').append('<option value="6.5">6.5</option>');
    $('.aql_select21').append('<option value="10">10.0</option>');
    $('.aql_select21').append('<option value="N/A">N/A</option>');

    //22
    $('body').on('click', '.btn-main_part_qty-modal22', function() {
        jQuery.noConflict();
        $('.AQLModal22').modal('show');
    });

    $('body').on('keyup', '.aql_qty22', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal22').find('.aql_minor22').val();
        var major = dis.closest('.AQLModal22').find('.aql_major22').val();
        var lvl = dis.closest('.AQLModal22').find('.aql_normal_level22').val();
        var special_lvl = dis.closest('.AQLModal22').find('.aql_special_level22').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal22').find('.max_major22').val(majorMax);
        dis.closest('.AQLModal22').find('.max_minor22').val(minorMax);
        dis.closest('.AQLModal22').find('.aql_normal_letter22').val(letter);
        dis.closest('.AQLModal22').find('.aql_special_letter22').val(special_letter);
        dis.closest('.AQLModal22').find('.aql_normal_sampsize22').val(sampsize);
        dis.closest('.AQLModal22').find('.aql_special_sampsize22').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level22', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal22').find('.aql_qty22').val();
        var minor = dis.closest('.AQLModal22').find('.aql_minor22').val();
        var major = dis.closest('.AQLModal22').find('.aql_major22').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal22').find('.max_major22').val(majorMax);
        dis.closest('.AQLModal22').find('.max_minor22').val(minorMax);
        dis.closest('.AQLModal22').find('.aql_normal_letter22').val(letter);
        dis.closest('.AQLModal22').find('.aql_normal_sampsize22').val(sampsize);
    })

    $('body').on('change', '.aql_special_level22', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal22').find('.aql_qty22').val();
        var minor = dis.closest('.AQLModal22').find('.aql_minor22').val();
        var major = dis.closest('.AQLModal22').find('.aql_major22').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal22').find('.aql_special_letter22').val(letter);
        dis.closest('.AQLModal22').find('.aql_special_sampsize22').val(sampsize);
    })

    $('body').on('change', '.aql_major22', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal22').find('.aql_qty22').val();
        var minor = dis.closest('.AQLModal22').find('.aql_minor22').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal22').find('.aql_normal_level22').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal22').find('.max_major22').val(majorMax);
        dis.closest('.AQLModal22').find('.max_minor22').val(minorMax);
        dis.closest('.AQLModal22').find('.aql_normal_letter22').val(letter);
        dis.closest('.AQLModal22').find('.aql_normal_sampsize22').val(sampsize);
    })

    $('body').on('change', '.aql_minor22', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal22').find('.aql_qty22').val();
        var major = dis.closest('.AQLModal22').find('.aql_major22').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal22').find('.aql_normal_level22').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal22').find('.max_major22').val(majorMax);
        dis.closest('.AQLModal22').find('.max_minor22').val(minorMax);
        dis.closest('.AQLModal22').find('.aql_normal_letter22').val(letter);
        dis.closest('.AQLModal22').find('.aql_normal_sampsize22').val(sampsize);
    })

    $('body').on('click', '.confirmAQL22', function() {
        var dis = $(this);
        dis.closest('.part22').find('.main_part_qty22').val(dis.closest('.part22').find('.aql_qty22').val());
        dis.closest('.part22').find('#samples_unit22').val(dis.closest('.part22').find('.aql_normal_sampsize22').val());
        dis.closest('.part22').find('.AQLModal22').modal('hide');

    });

    $('.aql_select22').append('<option value="">--</option>');
    $('.aql_select22').append('<option value="0.065">0.065</option>');
    $('.aql_select22').append('<option value="0.10">0.10</option>');
    $('.aql_select22').append('<option value="0.15">0.15</option>');
    $('.aql_select22').append('<option value="0.25">0.25</option>');
    $('.aql_select22').append('<option value="0.4">0.4</option>');
    $('.aql_select22').append('<option value="0.65">0.65</option>');
    $('.aql_select22').append('<option value="1">1.0</option>');
    $('.aql_select22').append('<option value="1.5">1.5</option>');
    $('.aql_select22').append('<option value="2.5">2.5</option>');
    $('.aql_select22').append('<option value="4">4.0</option>');
    $('.aql_select22').append('<option value="6.5">6.5</option>');
    $('.aql_select22').append('<option value="10">10.0</option>');
    $('.aql_select22').append('<option value="N/A">N/A</option>');

    //23
    $('body').on('click', '.btn-main_part_qty-modal23', function() {
        jQuery.noConflict();
        $('.AQLModal23').modal('show');
    });

    $('body').on('keyup', '.aql_qty23', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal23').find('.aql_minor23').val();
        var major = dis.closest('.AQLModal23').find('.aql_major23').val();
        var lvl = dis.closest('.AQLModal23').find('.aql_normal_level23').val();
        var special_lvl = dis.closest('.AQLModal23').find('.aql_special_level23').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal23').find('.max_major23').val(majorMax);
        dis.closest('.AQLModal23').find('.max_minor23').val(minorMax);
        dis.closest('.AQLModal23').find('.aql_normal_letter23').val(letter);
        dis.closest('.AQLModal23').find('.aql_special_letter23').val(special_letter);
        dis.closest('.AQLModal23').find('.aql_normal_sampsize23').val(sampsize);
        dis.closest('.AQLModal23').find('.aql_special_sampsize23').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level23', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal23').find('.aql_qty23').val();
        var minor = dis.closest('.AQLModal23').find('.aql_minor23').val();
        var major = dis.closest('.AQLModal23').find('.aql_major23').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal23').find('.max_major23').val(majorMax);
        dis.closest('.AQLModal23').find('.max_minor23').val(minorMax);
        dis.closest('.AQLModal23').find('.aql_normal_letter23').val(letter);
        dis.closest('.AQLModal23').find('.aql_normal_sampsize23').val(sampsize);
    })

    $('body').on('change', '.aql_special_level23', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal23').find('.aql_qty23').val();
        var minor = dis.closest('.AQLModal23').find('.aql_minor23').val();
        var major = dis.closest('.AQLModal23').find('.aql_major23').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal23').find('.aql_special_letter23').val(letter);
        dis.closest('.AQLModal23').find('.aql_special_sampsize23').val(sampsize);
    })

    $('body').on('change', '.aql_major23', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal23').find('.aql_qty23').val();
        var minor = dis.closest('.AQLModal23').find('.aql_minor23').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal23').find('.aql_normal_level23').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal23').find('.max_major23').val(majorMax);
        dis.closest('.AQLModal23').find('.max_minor23').val(minorMax);
        dis.closest('.AQLModal23').find('.aql_normal_letter23').val(letter);
        dis.closest('.AQLModal23').find('.aql_normal_sampsize23').val(sampsize);
    })

    $('body').on('change', '.aql_minor23', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal23').find('.aql_qty23').val();
        var major = dis.closest('.AQLModal23').find('.aql_major23').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal23').find('.aql_normal_level23').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal23').find('.max_major23').val(majorMax);
        dis.closest('.AQLModal23').find('.max_minor23').val(minorMax);
        dis.closest('.AQLModal23').find('.aql_normal_letter23').val(letter);
        dis.closest('.AQLModal23').find('.aql_normal_sampsize23').val(sampsize);
    })

    $('body').on('click', '.confirmAQL23', function() {
        var dis = $(this);
        dis.closest('.part23').find('.main_part_qty23').val(dis.closest('.part23').find('.aql_qty23').val());
        dis.closest('.part23').find('#samples_unit23').val(dis.closest('.part23').find('.aql_normal_sampsize23').val());
        dis.closest('.part23').find('.AQLModal23').modal('hide');

    });

    $('.aql_select23').append('<option value="">--</option>');
    $('.aql_select23').append('<option value="0.065">0.065</option>');
    $('.aql_select23').append('<option value="0.10">0.10</option>');
    $('.aql_select23').append('<option value="0.15">0.15</option>');
    $('.aql_select23').append('<option value="0.25">0.25</option>');
    $('.aql_select23').append('<option value="0.4">0.4</option>');
    $('.aql_select23').append('<option value="0.65">0.65</option>');
    $('.aql_select23').append('<option value="1">1.0</option>');
    $('.aql_select23').append('<option value="1.5">1.5</option>');
    $('.aql_select23').append('<option value="2.5">2.5</option>');
    $('.aql_select23').append('<option value="4">4.0</option>');
    $('.aql_select23').append('<option value="6.5">6.5</option>');
    $('.aql_select23').append('<option value="10">10.0</option>');
    $('.aql_select23').append('<option value="N/A">N/A</option>');

    //24
    $('body').on('click', '.btn-main_part_qty-modal24', function() {
        jQuery.noConflict();
        $('.AQLModal24').modal('show');
    });

    $('body').on('keyup', '.aql_qty24', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal24').find('.aql_minor24').val();
        var major = dis.closest('.AQLModal24').find('.aql_major24').val();
        var lvl = dis.closest('.AQLModal24').find('.aql_normal_level24').val();
        var special_lvl = dis.closest('.AQLModal24').find('.aql_special_level24').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal24').find('.max_major24').val(majorMax);
        dis.closest('.AQLModal24').find('.max_minor24').val(minorMax);
        dis.closest('.AQLModal24').find('.aql_normal_letter24').val(letter);
        dis.closest('.AQLModal24').find('.aql_special_letter24').val(special_letter);
        dis.closest('.AQLModal24').find('.aql_normal_sampsize24').val(sampsize);
        dis.closest('.AQLModal24').find('.aql_special_sampsize24').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level24', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal24').find('.aql_qty24').val();
        var minor = dis.closest('.AQLModal24').find('.aql_minor24').val();
        var major = dis.closest('.AQLModal24').find('.aql_major24').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal24').find('.max_major24').val(majorMax);
        dis.closest('.AQLModal24').find('.max_minor24').val(minorMax);
        dis.closest('.AQLModal24').find('.aql_normal_letter24').val(letter);
        dis.closest('.AQLModal24').find('.aql_normal_sampsize24').val(sampsize);
    })

    $('body').on('change', '.aql_special_level24', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal24').find('.aql_qty24').val();
        var minor = dis.closest('.AQLModal24').find('.aql_minor24').val();
        var major = dis.closest('.AQLModal24').find('.aql_major24').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal24').find('.aql_special_letter24').val(letter);
        dis.closest('.AQLModal24').find('.aql_special_sampsize24').val(sampsize);
    })

    $('body').on('change', '.aql_major24', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal24').find('.aql_qty24').val();
        var minor = dis.closest('.AQLModal24').find('.aql_minor24').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal24').find('.aql_normal_level24').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal24').find('.max_major24').val(majorMax);
        dis.closest('.AQLModal24').find('.max_minor24').val(minorMax);
        dis.closest('.AQLModal24').find('.aql_normal_letter24').val(letter);
        dis.closest('.AQLModal24').find('.aql_normal_sampsize24').val(sampsize);
    })

    $('body').on('change', '.aql_minor24', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal24').find('.aql_qty24').val();
        var major = dis.closest('.AQLModal24').find('.aql_major24').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal24').find('.aql_normal_level24').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal24').find('.max_major24').val(majorMax);
        dis.closest('.AQLModal24').find('.max_minor24').val(minorMax);
        dis.closest('.AQLModal24').find('.aql_normal_letter24').val(letter);
        dis.closest('.AQLModal24').find('.aql_normal_sampsize24').val(sampsize);
    })

    $('body').on('click', '.confirmAQL24', function() {
        var dis = $(this);
        dis.closest('.part24').find('.main_part_qty24').val(dis.closest('.part24').find('.aql_qty24').val());
        dis.closest('.part24').find('#samples_unit24').val(dis.closest('.part24').find('.aql_normal_sampsize24').val());
        dis.closest('.part24').find('.AQLModal24').modal('hide');

    });

    $('.aql_select24').append('<option value="">--</option>');
    $('.aql_select24').append('<option value="0.065">0.065</option>');
    $('.aql_select24').append('<option value="0.10">0.10</option>');
    $('.aql_select24').append('<option value="0.15">0.15</option>');
    $('.aql_select24').append('<option value="0.25">0.25</option>');
    $('.aql_select24').append('<option value="0.4">0.4</option>');
    $('.aql_select24').append('<option value="0.65">0.65</option>');
    $('.aql_select24').append('<option value="1">1.0</option>');
    $('.aql_select24').append('<option value="1.5">1.5</option>');
    $('.aql_select24').append('<option value="2.5">2.5</option>');
    $('.aql_select24').append('<option value="4">4.0</option>');
    $('.aql_select24').append('<option value="6.5">6.5</option>');
    $('.aql_select24').append('<option value="10">10.0</option>');
    $('.aql_select24').append('<option value="N/A">N/A</option>');

    //25
    $('body').on('click', '.btn-main_part_qty-modal25', function() {
        jQuery.noConflict();
        $('.AQLModal25').modal('show');
    });

    $('body').on('keyup', '.aql_qty25', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal25').find('.aql_minor25').val();
        var major = dis.closest('.AQLModal25').find('.aql_major25').val();
        var lvl = dis.closest('.AQLModal25').find('.aql_normal_level25').val();
        var special_lvl = dis.closest('.AQLModal25').find('.aql_special_level25').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal25').find('.max_major25').val(majorMax);
        dis.closest('.AQLModal25').find('.max_minor25').val(minorMax);
        dis.closest('.AQLModal25').find('.aql_normal_letter25').val(letter);
        dis.closest('.AQLModal25').find('.aql_special_letter25').val(special_letter);
        dis.closest('.AQLModal25').find('.aql_normal_sampsize25').val(sampsize);
        dis.closest('.AQLModal25').find('.aql_special_sampsize25').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level25', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal25').find('.aql_qty25').val();
        var minor = dis.closest('.AQLModal25').find('.aql_minor25').val();
        var major = dis.closest('.AQLModal25').find('.aql_major25').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal25').find('.max_major25').val(majorMax);
        dis.closest('.AQLModal25').find('.max_minor25').val(minorMax);
        dis.closest('.AQLModal25').find('.aql_normal_letter25').val(letter);
        dis.closest('.AQLModal25').find('.aql_normal_sampsize25').val(sampsize);
    })

    $('body').on('change', '.aql_special_level25', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal25').find('.aql_qty25').val();
        var minor = dis.closest('.AQLModal25').find('.aql_minor25').val();
        var major = dis.closest('.AQLModal25').find('.aql_major25').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal25').find('.aql_special_letter25').val(letter);
        dis.closest('.AQLModal25').find('.aql_special_sampsize25').val(sampsize);
    })

    $('body').on('change', '.aql_major25', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal25').find('.aql_qty25').val();
        var minor = dis.closest('.AQLModal25').find('.aql_minor25').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal25').find('.aql_normal_level25').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal25').find('.max_major25').val(majorMax);
        dis.closest('.AQLModal25').find('.max_minor25').val(minorMax);
        dis.closest('.AQLModal25').find('.aql_normal_letter25').val(letter);
        dis.closest('.AQLModal25').find('.aql_normal_sampsize25').val(sampsize);
    })

    $('body').on('change', '.aql_minor25', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal25').find('.aql_qty25').val();
        var major = dis.closest('.AQLModal25').find('.aql_major25').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal25').find('.aql_normal_level25').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal25').find('.max_major25').val(majorMax);
        dis.closest('.AQLModal25').find('.max_minor25').val(minorMax);
        dis.closest('.AQLModal25').find('.aql_normal_letter25').val(letter);
        dis.closest('.AQLModal25').find('.aql_normal_sampsize25').val(sampsize);
    })

    $('body').on('click', '.confirmAQL25', function() {
        var dis = $(this);
        dis.closest('.part25').find('.main_part_qty25').val(dis.closest('.part25').find('.aql_qty25').val());
        dis.closest('.part25').find('#samples_unit25').val(dis.closest('.part25').find('.aql_normal_sampsize25').val());
        dis.closest('.part25').find('.AQLModal25').modal('hide');

    });

    $('.aql_select25').append('<option value="">--</option>');
    $('.aql_select25').append('<option value="0.065">0.065</option>');
    $('.aql_select25').append('<option value="0.10">0.10</option>');
    $('.aql_select25').append('<option value="0.15">0.15</option>');
    $('.aql_select25').append('<option value="0.25">0.25</option>');
    $('.aql_select25').append('<option value="0.4">0.4</option>');
    $('.aql_select25').append('<option value="0.65">0.65</option>');
    $('.aql_select25').append('<option value="1">1.0</option>');
    $('.aql_select25').append('<option value="1.5">1.5</option>');
    $('.aql_select25').append('<option value="2.5">2.5</option>');
    $('.aql_select25').append('<option value="4">4.0</option>');
    $('.aql_select25').append('<option value="6.5">6.5</option>');
    $('.aql_select25').append('<option value="10">10.0</option>');
    $('.aql_select25').append('<option value="N/A">N/A</option>');

    //26
    $('body').on('click', '.btn-main_part_qty-modal26', function() {
        jQuery.noConflict();
        $('.AQLModal26').modal('show');
    });

    $('body').on('keyup', '.aql_qty26', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal26').find('.aql_minor26').val();
        var major = dis.closest('.AQLModal26').find('.aql_major26').val();
        var lvl = dis.closest('.AQLModal26').find('.aql_normal_level26').val();
        var special_lvl = dis.closest('.AQLModal26').find('.aql_special_level26').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal26').find('.max_major26').val(majorMax);
        dis.closest('.AQLModal26').find('.max_minor26').val(minorMax);
        dis.closest('.AQLModal26').find('.aql_normal_letter26').val(letter);
        dis.closest('.AQLModal26').find('.aql_special_letter26').val(special_letter);
        dis.closest('.AQLModal26').find('.aql_normal_sampsize26').val(sampsize);
        dis.closest('.AQLModal26').find('.aql_special_sampsize26').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level26', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal26').find('.aql_qty26').val();
        var minor = dis.closest('.AQLModal26').find('.aql_minor26').val();
        var major = dis.closest('.AQLModal26').find('.aql_major26').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal26').find('.max_major26').val(majorMax);
        dis.closest('.AQLModal26').find('.max_minor26').val(minorMax);
        dis.closest('.AQLModal26').find('.aql_normal_letter26').val(letter);
        dis.closest('.AQLModal26').find('.aql_normal_sampsize26').val(sampsize);
    })

    $('body').on('change', '.aql_special_level26', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal26').find('.aql_qty26').val();
        var minor = dis.closest('.AQLModal26').find('.aql_minor26').val();
        var major = dis.closest('.AQLModal26').find('.aql_major26').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal26').find('.aql_special_letter26').val(letter);
        dis.closest('.AQLModal26').find('.aql_special_sampsize26').val(sampsize);
    })

    $('body').on('change', '.aql_major26', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal26').find('.aql_qty26').val();
        var minor = dis.closest('.AQLModal26').find('.aql_minor26').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal26').find('.aql_normal_level26').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal26').find('.max_major26').val(majorMax);
        dis.closest('.AQLModal26').find('.max_minor26').val(minorMax);
        dis.closest('.AQLModal26').find('.aql_normal_letter26').val(letter);
        dis.closest('.AQLModal26').find('.aql_normal_sampsize26').val(sampsize);
    })

    $('body').on('change', '.aql_minor26', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal26').find('.aql_qty26').val();
        var major = dis.closest('.AQLModal26').find('.aql_major26').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal26').find('.aql_normal_level26').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal26').find('.max_major26').val(majorMax);
        dis.closest('.AQLModal26').find('.max_minor26').val(minorMax);
        dis.closest('.AQLModal26').find('.aql_normal_letter26').val(letter);
        dis.closest('.AQLModal26').find('.aql_normal_sampsize26').val(sampsize);
    })

    $('body').on('click', '.confirmAQL26', function() {
        var dis = $(this);
        dis.closest('.part26').find('.main_part_qty26').val(dis.closest('.part26').find('.aql_qty26').val());
        dis.closest('.part26').find('#samples_unit26').val(dis.closest('.part26').find('.aql_normal_sampsize26').val());
        dis.closest('.part26').find('.AQLModal26').modal('hide');

    });

    $('.aql_select26').append('<option value="">--</option>');
    $('.aql_select26').append('<option value="0.065">0.065</option>');
    $('.aql_select26').append('<option value="0.10">0.10</option>');
    $('.aql_select26').append('<option value="0.15">0.15</option>');
    $('.aql_select26').append('<option value="0.25">0.25</option>');
    $('.aql_select26').append('<option value="0.4">0.4</option>');
    $('.aql_select26').append('<option value="0.65">0.65</option>');
    $('.aql_select26').append('<option value="1">1.0</option>');
    $('.aql_select26').append('<option value="1.5">1.5</option>');
    $('.aql_select26').append('<option value="2.5">2.5</option>');
    $('.aql_select26').append('<option value="4">4.0</option>');
    $('.aql_select26').append('<option value="6.5">6.5</option>');
    $('.aql_select26').append('<option value="10">10.0</option>');
    $('.aql_select26').append('<option value="N/A">N/A</option>');

    //27
    $('body').on('click', '.btn-main_part_qty-modal27', function() {
        jQuery.noConflict();
        $('.AQLModal27').modal('show');
    });

    $('body').on('keyup', '.aql_qty27', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal27').find('.aql_minor27').val();
        var major = dis.closest('.AQLModal27').find('.aql_major27').val();
        var lvl = dis.closest('.AQLModal27').find('.aql_normal_level27').val();
        var special_lvl = dis.closest('.AQLModal27').find('.aql_special_level27').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal27').find('.max_major27').val(majorMax);
        dis.closest('.AQLModal27').find('.max_minor27').val(minorMax);
        dis.closest('.AQLModal27').find('.aql_normal_letter27').val(letter);
        dis.closest('.AQLModal27').find('.aql_special_letter27').val(special_letter);
        dis.closest('.AQLModal27').find('.aql_normal_sampsize27').val(sampsize);
        dis.closest('.AQLModal27').find('.aql_special_sampsize27').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level27', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal27').find('.aql_qty27').val();
        var minor = dis.closest('.AQLModal27').find('.aql_minor27').val();
        var major = dis.closest('.AQLModal27').find('.aql_major27').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal27').find('.max_major27').val(majorMax);
        dis.closest('.AQLModal27').find('.max_minor27').val(minorMax);
        dis.closest('.AQLModal27').find('.aql_normal_letter27').val(letter);
        dis.closest('.AQLModal27').find('.aql_normal_sampsize27').val(sampsize);
    })

    $('body').on('change', '.aql_special_level27', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal27').find('.aql_qty27').val();
        var minor = dis.closest('.AQLModal27').find('.aql_minor27').val();
        var major = dis.closest('.AQLModal27').find('.aql_major27').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal27').find('.aql_special_letter27').val(letter);
        dis.closest('.AQLModal27').find('.aql_special_sampsize27').val(sampsize);
    })

    $('body').on('change', '.aql_major27', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal27').find('.aql_qty27').val();
        var minor = dis.closest('.AQLModal27').find('.aql_minor27').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal27').find('.aql_normal_level27').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal27').find('.max_major27').val(majorMax);
        dis.closest('.AQLModal27').find('.max_minor27').val(minorMax);
        dis.closest('.AQLModal27').find('.aql_normal_letter27').val(letter);
        dis.closest('.AQLModal27').find('.aql_normal_sampsize27').val(sampsize);
    })

    $('body').on('change', '.aql_minor27', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal27').find('.aql_qty27').val();
        var major = dis.closest('.AQLModal27').find('.aql_major27').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal27').find('.aql_normal_level27').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal27').find('.max_major27').val(majorMax);
        dis.closest('.AQLModal27').find('.max_minor27').val(minorMax);
        dis.closest('.AQLModal27').find('.aql_normal_letter27').val(letter);
        dis.closest('.AQLModal27').find('.aql_normal_sampsize27').val(sampsize);
    })

    $('body').on('click', '.confirmAQL27', function() {
        var dis = $(this);
        dis.closest('.part27').find('.main_part_qty27').val(dis.closest('.part27').find('.aql_qty27').val());
        dis.closest('.part27').find('#samples_unit27').val(dis.closest('.part27').find('.aql_normal_sampsize27').val());
        dis.closest('.part27').find('.AQLModal27').modal('hide');

    });

    $('.aql_select27').append('<option value="">--</option>');
    $('.aql_select27').append('<option value="0.065">0.065</option>');
    $('.aql_select27').append('<option value="0.10">0.10</option>');
    $('.aql_select27').append('<option value="0.15">0.15</option>');
    $('.aql_select27').append('<option value="0.25">0.25</option>');
    $('.aql_select27').append('<option value="0.4">0.4</option>');
    $('.aql_select27').append('<option value="0.65">0.65</option>');
    $('.aql_select27').append('<option value="1">1.0</option>');
    $('.aql_select27').append('<option value="1.5">1.5</option>');
    $('.aql_select27').append('<option value="2.5">2.5</option>');
    $('.aql_select27').append('<option value="4">4.0</option>');
    $('.aql_select27').append('<option value="6.5">6.5</option>');
    $('.aql_select27').append('<option value="10">10.0</option>');
    $('.aql_select27').append('<option value="N/A">N/A</option>');

    //28
    $('body').on('click', '.btn-main_part_qty-modal28', function() {
        jQuery.noConflict();
        $('.AQLModal28').modal('show');
    });

    $('body').on('keyup', '.aql_qty28', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal28').find('.aql_minor28').val();
        var major = dis.closest('.AQLModal28').find('.aql_major28').val();
        var lvl = dis.closest('.AQLModal28').find('.aql_normal_level28').val();
        var special_lvl = dis.closest('.AQLModal28').find('.aql_special_level28').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal28').find('.max_major28').val(majorMax);
        dis.closest('.AQLModal28').find('.max_minor28').val(minorMax);
        dis.closest('.AQLModal28').find('.aql_normal_letter28').val(letter);
        dis.closest('.AQLModal28').find('.aql_special_letter28').val(special_letter);
        dis.closest('.AQLModal28').find('.aql_normal_sampsize28').val(sampsize);
        dis.closest('.AQLModal28').find('.aql_special_sampsize28').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level28', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal28').find('.aql_qty28').val();
        var minor = dis.closest('.AQLModal28').find('.aql_minor28').val();
        var major = dis.closest('.AQLModal28').find('.aql_major28').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal28').find('.max_major28').val(majorMax);
        dis.closest('.AQLModal28').find('.max_minor28').val(minorMax);
        dis.closest('.AQLModal28').find('.aql_normal_letter28').val(letter);
        dis.closest('.AQLModal28').find('.aql_normal_sampsize28').val(sampsize);
    })

    $('body').on('change', '.aql_special_level28', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal28').find('.aql_qty28').val();
        var minor = dis.closest('.AQLModal28').find('.aql_minor28').val();
        var major = dis.closest('.AQLModal28').find('.aql_major28').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal28').find('.aql_special_letter28').val(letter);
        dis.closest('.AQLModal28').find('.aql_special_sampsize28').val(sampsize);
    })

    $('body').on('change', '.aql_major28', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal28').find('.aql_qty28').val();
        var minor = dis.closest('.AQLModal28').find('.aql_minor28').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal28').find('.aql_normal_level28').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal28').find('.max_major28').val(majorMax);
        dis.closest('.AQLModal28').find('.max_minor28').val(minorMax);
        dis.closest('.AQLModal28').find('.aql_normal_letter28').val(letter);
        dis.closest('.AQLModal28').find('.aql_normal_sampsize28').val(sampsize);
    })

    $('body').on('change', '.aql_minor28', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal28').find('.aql_qty28').val();
        var major = dis.closest('.AQLModal28').find('.aql_major28').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal28').find('.aql_normal_level28').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal28').find('.max_major28').val(majorMax);
        dis.closest('.AQLModal28').find('.max_minor28').val(minorMax);
        dis.closest('.AQLModal28').find('.aql_normal_letter28').val(letter);
        dis.closest('.AQLModal28').find('.aql_normal_sampsize28').val(sampsize);
    })

    $('body').on('click', '.confirmAQL28', function() {
        var dis = $(this);
        dis.closest('.part28').find('.main_part_qty28').val(dis.closest('.part28').find('.aql_qty28').val());
        dis.closest('.part28').find('#samples_unit28').val(dis.closest('.part28').find('.aql_normal_sampsize28').val());
        dis.closest('.part28').find('.AQLModal28').modal('hide');

    });

    $('.aql_select28').append('<option value="">--</option>');
    $('.aql_select28').append('<option value="0.065">0.065</option>');
    $('.aql_select28').append('<option value="0.10">0.10</option>');
    $('.aql_select28').append('<option value="0.15">0.15</option>');
    $('.aql_select28').append('<option value="0.25">0.25</option>');
    $('.aql_select28').append('<option value="0.4">0.4</option>');
    $('.aql_select28').append('<option value="0.65">0.65</option>');
    $('.aql_select28').append('<option value="1">1.0</option>');
    $('.aql_select28').append('<option value="1.5">1.5</option>');
    $('.aql_select28').append('<option value="2.5">2.5</option>');
    $('.aql_select28').append('<option value="4">4.0</option>');
    $('.aql_select28').append('<option value="6.5">6.5</option>');
    $('.aql_select28').append('<option value="10">10.0</option>');
    $('.aql_select28').append('<option value="N/A">N/A</option>');

    //29
    $('body').on('click', '.btn-main_part_qty-modal29', function() {
        jQuery.noConflict();
        $('.AQLModal29').modal('show');
    });

    $('body').on('keyup', '.aql_qty29', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal29').find('.aql_minor29').val();
        var major = dis.closest('.AQLModal29').find('.aql_major29').val();
        var lvl = dis.closest('.AQLModal29').find('.aql_normal_level29').val();
        var special_lvl = dis.closest('.AQLModal29').find('.aql_special_level29').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal29').find('.max_major29').val(majorMax);
        dis.closest('.AQLModal29').find('.max_minor29').val(minorMax);
        dis.closest('.AQLModal29').find('.aql_normal_letter29').val(letter);
        dis.closest('.AQLModal29').find('.aql_special_letter29').val(special_letter);
        dis.closest('.AQLModal29').find('.aql_normal_sampsize29').val(sampsize);
        dis.closest('.AQLModal29').find('.aql_special_sampsize29').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level29', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal29').find('.aql_qty29').val();
        var minor = dis.closest('.AQLModal29').find('.aql_minor29').val();
        var major = dis.closest('.AQLModal29').find('.aql_major29').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal29').find('.max_major29').val(majorMax);
        dis.closest('.AQLModal29').find('.max_minor29').val(minorMax);
        dis.closest('.AQLModal29').find('.aql_normal_letter29').val(letter);
        dis.closest('.AQLModal29').find('.aql_normal_sampsize29').val(sampsize);
    })

    $('body').on('change', '.aql_special_level29', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal29').find('.aql_qty29').val();
        var minor = dis.closest('.AQLModal29').find('.aql_minor29').val();
        var major = dis.closest('.AQLModal29').find('.aql_major29').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal29').find('.aql_special_letter29').val(letter);
        dis.closest('.AQLModal29').find('.aql_special_sampsize29').val(sampsize);
    })

    $('body').on('change', '.aql_major29', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal29').find('.aql_qty29').val();
        var minor = dis.closest('.AQLModal29').find('.aql_minor29').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal29').find('.aql_normal_level29').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal29').find('.max_major29').val(majorMax);
        dis.closest('.AQLModal29').find('.max_minor29').val(minorMax);
        dis.closest('.AQLModal29').find('.aql_normal_letter29').val(letter);
        dis.closest('.AQLModal29').find('.aql_normal_sampsize29').val(sampsize);
    })

    $('body').on('change', '.aql_minor29', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal29').find('.aql_qty29').val();
        var major = dis.closest('.AQLModal29').find('.aql_major29').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal29').find('.aql_normal_level29').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal29').find('.max_major29').val(majorMax);
        dis.closest('.AQLModal29').find('.max_minor29').val(minorMax);
        dis.closest('.AQLModal29').find('.aql_normal_letter29').val(letter);
        dis.closest('.AQLModal29').find('.aql_normal_sampsize29').val(sampsize);
    })

    $('body').on('click', '.confirmAQL29', function() {
        var dis = $(this);
        dis.closest('.part29').find('.main_part_qty29').val(dis.closest('.part29').find('.aql_qty29').val());
        dis.closest('.part29').find('#samples_unit29').val(dis.closest('.part29').find('.aql_normal_sampsize29').val());
        dis.closest('.part29').find('.AQLModal29').modal('hide');

    });

    $('.aql_select29').append('<option value="">--</option>');
    $('.aql_select29').append('<option value="0.065">0.065</option>');
    $('.aql_select29').append('<option value="0.10">0.10</option>');
    $('.aql_select29').append('<option value="0.15">0.15</option>');
    $('.aql_select29').append('<option value="0.25">0.25</option>');
    $('.aql_select29').append('<option value="0.4">0.4</option>');
    $('.aql_select29').append('<option value="0.65">0.65</option>');
    $('.aql_select29').append('<option value="1">1.0</option>');
    $('.aql_select29').append('<option value="1.5">1.5</option>');
    $('.aql_select29').append('<option value="2.5">2.5</option>');
    $('.aql_select29').append('<option value="4">4.0</option>');
    $('.aql_select29').append('<option value="6.5">6.5</option>');
    $('.aql_select29').append('<option value="10">10.0</option>');
    $('.aql_select29').append('<option value="N/A">N/A</option>');

    //30
    $('body').on('click', '.btn-main_part_qty-modal30', function() {
        jQuery.noConflict();
        $('.AQLModal30').modal('show');
    });

    $('body').on('keyup', '.aql_qty30', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal30').find('.aql_minor30').val();
        var major = dis.closest('.AQLModal30').find('.aql_major30').val();
        var lvl = dis.closest('.AQLModal30').find('.aql_normal_level30').val();
        var special_lvl = dis.closest('.AQLModal30').find('.aql_special_level30').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal30').find('.max_major30').val(majorMax);
        dis.closest('.AQLModal30').find('.max_minor30').val(minorMax);
        dis.closest('.AQLModal30').find('.aql_normal_letter30').val(letter);
        dis.closest('.AQLModal30').find('.aql_special_letter30').val(special_letter);
        dis.closest('.AQLModal30').find('.aql_normal_sampsize30').val(sampsize);
        dis.closest('.AQLModal30').find('.aql_special_sampsize30').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level30', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal30').find('.aql_qty30').val();
        var minor = dis.closest('.AQLModal30').find('.aql_minor30').val();
        var major = dis.closest('.AQLModal30').find('.aql_major30').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal30').find('.max_major30').val(majorMax);
        dis.closest('.AQLModal30').find('.max_minor30').val(minorMax);
        dis.closest('.AQLModal30').find('.aql_normal_letter30').val(letter);
        dis.closest('.AQLModal30').find('.aql_normal_sampsize30').val(sampsize);
    })

    $('body').on('change', '.aql_special_level30', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal30').find('.aql_qty30').val();
        var minor = dis.closest('.AQLModal30').find('.aql_minor30').val();
        var major = dis.closest('.AQLModal30').find('.aql_major30').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal30').find('.aql_special_letter30').val(letter);
        dis.closest('.AQLModal30').find('.aql_special_sampsize30').val(sampsize);
    })

    $('body').on('change', '.aql_major30', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal30').find('.aql_qty30').val();
        var minor = dis.closest('.AQLModal30').find('.aql_minor30').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal30').find('.aql_normal_level30').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal30').find('.max_major30').val(majorMax);
        dis.closest('.AQLModal30').find('.max_minor30').val(minorMax);
        dis.closest('.AQLModal30').find('.aql_normal_letter30').val(letter);
        dis.closest('.AQLModal30').find('.aql_normal_sampsize30').val(sampsize);
    })

    $('body').on('change', '.aql_minor30', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal30').find('.aql_qty30').val();
        var major = dis.closest('.AQLModal30').find('.aql_major30').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal30').find('.aql_normal_level30').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal30').find('.max_major30').val(majorMax);
        dis.closest('.AQLModal30').find('.max_minor30').val(minorMax);
        dis.closest('.AQLModal30').find('.aql_normal_letter30').val(letter);
        dis.closest('.AQLModal30').find('.aql_normal_sampsize30').val(sampsize);
    })

    $('body').on('click', '.confirmAQL30', function() {
        var dis = $(this);
        dis.closest('.part30').find('.main_part_qty30').val(dis.closest('.part30').find('.aql_qty30').val());
        dis.closest('.part30').find('#samples_unit30').val(dis.closest('.part30').find('.aql_normal_sampsize30').val());
        dis.closest('.part30').find('.AQLModal30').modal('hide');

    });

    $('.aql_select30').append('<option value="">--</option>');
    $('.aql_select30').append('<option value="0.065">0.065</option>');
    $('.aql_select30').append('<option value="0.10">0.10</option>');
    $('.aql_select30').append('<option value="0.15">0.15</option>');
    $('.aql_select30').append('<option value="0.25">0.25</option>');
    $('.aql_select30').append('<option value="0.4">0.4</option>');
    $('.aql_select30').append('<option value="0.65">0.65</option>');
    $('.aql_select30').append('<option value="1">1.0</option>');
    $('.aql_select30').append('<option value="1.5">1.5</option>');
    $('.aql_select30').append('<option value="2.5">2.5</option>');
    $('.aql_select30').append('<option value="4">4.0</option>');
    $('.aql_select30').append('<option value="6.5">6.5</option>');
    $('.aql_select30').append('<option value="10">10.0</option>');
    $('.aql_select30').append('<option value="N/A">N/A</option>');

    //31
    $('body').on('click', '.btn-main_part_qty-modal31', function() {
        jQuery.noConflict();
        $('.AQLModal31').modal('show');
    });

    $('body').on('keyup', '.aql_qty31', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal31').find('.aql_minor31').val();
        var major = dis.closest('.AQLModal31').find('.aql_major31').val();
        var lvl = dis.closest('.AQLModal31').find('.aql_normal_level31').val();
        var special_lvl = dis.closest('.AQLModal31').find('.aql_special_level31').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal31').find('.max_major31').val(majorMax);
        dis.closest('.AQLModal31').find('.max_minor31').val(minorMax);
        dis.closest('.AQLModal31').find('.aql_normal_letter31').val(letter);
        dis.closest('.AQLModal31').find('.aql_special_letter31').val(special_letter);
        dis.closest('.AQLModal31').find('.aql_normal_sampsize31').val(sampsize);
        dis.closest('.AQLModal31').find('.aql_special_sampsize31').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level31', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal31').find('.aql_qty31').val();
        var minor = dis.closest('.AQLModal31').find('.aql_minor31').val();
        var major = dis.closest('.AQLModal31').find('.aql_major31').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal31').find('.max_major31').val(majorMax);
        dis.closest('.AQLModal31').find('.max_minor31').val(minorMax);
        dis.closest('.AQLModal31').find('.aql_normal_letter31').val(letter);
        dis.closest('.AQLModal31').find('.aql_normal_sampsize31').val(sampsize);
    })

    $('body').on('change', '.aql_special_level31', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal31').find('.aql_qty31').val();
        var minor = dis.closest('.AQLModal31').find('.aql_minor31').val();
        var major = dis.closest('.AQLModal31').find('.aql_major31').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal31').find('.aql_special_letter31').val(letter);
        dis.closest('.AQLModal31').find('.aql_special_sampsize31').val(sampsize);
    })

    $('body').on('change', '.aql_major31', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal31').find('.aql_qty31').val();
        var minor = dis.closest('.AQLModal31').find('.aql_minor31').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal31').find('.aql_normal_level31').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal31').find('.max_major31').val(majorMax);
        dis.closest('.AQLModal31').find('.max_minor31').val(minorMax);
        dis.closest('.AQLModal31').find('.aql_normal_letter31').val(letter);
        dis.closest('.AQLModal31').find('.aql_normal_sampsize31').val(sampsize);
    })

    $('body').on('change', '.aql_minor31', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal31').find('.aql_qty31').val();
        var major = dis.closest('.AQLModal31').find('.aql_major31').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal31').find('.aql_normal_level31').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal31').find('.max_major31').val(majorMax);
        dis.closest('.AQLModal31').find('.max_minor31').val(minorMax);
        dis.closest('.AQLModal31').find('.aql_normal_letter31').val(letter);
        dis.closest('.AQLModal31').find('.aql_normal_sampsize31').val(sampsize);
    })

    $('body').on('click', '.confirmAQL31', function() {
        var dis = $(this);
        dis.closest('.part31').find('.main_part_qty31').val(dis.closest('.part31').find('.aql_qty31').val());
        dis.closest('.part31').find('#samples_unit31').val(dis.closest('.part31').find('.aql_normal_sampsize31').val());
        dis.closest('.part31').find('.AQLModal31').modal('hide');

    });

    $('.aql_select31').append('<option value="">--</option>');
    $('.aql_select31').append('<option value="0.065">0.065</option>');
    $('.aql_select31').append('<option value="0.10">0.10</option>');
    $('.aql_select31').append('<option value="0.15">0.15</option>');
    $('.aql_select31').append('<option value="0.25">0.25</option>');
    $('.aql_select31').append('<option value="0.4">0.4</option>');
    $('.aql_select31').append('<option value="0.65">0.65</option>');
    $('.aql_select31').append('<option value="1">1.0</option>');
    $('.aql_select31').append('<option value="1.5">1.5</option>');
    $('.aql_select31').append('<option value="2.5">2.5</option>');
    $('.aql_select31').append('<option value="4">4.0</option>');
    $('.aql_select31').append('<option value="6.5">6.5</option>');
    $('.aql_select31').append('<option value="10">10.0</option>');
    $('.aql_select31').append('<option value="N/A">N/A</option>');

    //32
    $('body').on('click', '.btn-main_part_qty-modal32', function() {
        jQuery.noConflict();
        $('.AQLModal32').modal('show');
    });

    $('body').on('keyup', '.aql_qty32', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal32').find('.aql_minor32').val();
        var major = dis.closest('.AQLModal32').find('.aql_major32').val();
        var lvl = dis.closest('.AQLModal32').find('.aql_normal_level32').val();
        var special_lvl = dis.closest('.AQLModal32').find('.aql_special_level32').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal32').find('.max_major32').val(majorMax);
        dis.closest('.AQLModal32').find('.max_minor32').val(minorMax);
        dis.closest('.AQLModal32').find('.aql_normal_letter32').val(letter);
        dis.closest('.AQLModal32').find('.aql_special_letter32').val(special_letter);
        dis.closest('.AQLModal32').find('.aql_normal_sampsize32').val(sampsize);
        dis.closest('.AQLModal32').find('.aql_special_sampsize32').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level32', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal32').find('.aql_qty32').val();
        var minor = dis.closest('.AQLModal32').find('.aql_minor32').val();
        var major = dis.closest('.AQLModal32').find('.aql_major32').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal32').find('.max_major32').val(majorMax);
        dis.closest('.AQLModal32').find('.max_minor32').val(minorMax);
        dis.closest('.AQLModal32').find('.aql_normal_letter32').val(letter);
        dis.closest('.AQLModal32').find('.aql_normal_sampsize32').val(sampsize);
    })

    $('body').on('change', '.aql_special_level32', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal32').find('.aql_qty32').val();
        var minor = dis.closest('.AQLModal32').find('.aql_minor32').val();
        var major = dis.closest('.AQLModal32').find('.aql_major32').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal32').find('.aql_special_letter32').val(letter);
        dis.closest('.AQLModal32').find('.aql_special_sampsize32').val(sampsize);
    })

    $('body').on('change', '.aql_major32', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal32').find('.aql_qty32').val();
        var minor = dis.closest('.AQLModal32').find('.aql_minor32').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal32').find('.aql_normal_level32').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal32').find('.max_major32').val(majorMax);
        dis.closest('.AQLModal32').find('.max_minor32').val(minorMax);
        dis.closest('.AQLModal32').find('.aql_normal_letter32').val(letter);
        dis.closest('.AQLModal32').find('.aql_normal_sampsize32').val(sampsize);
    })

    $('body').on('change', '.aql_minor32', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal32').find('.aql_qty32').val();
        var major = dis.closest('.AQLModal32').find('.aql_major32').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal32').find('.aql_normal_level32').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal32').find('.max_major32').val(majorMax);
        dis.closest('.AQLModal32').find('.max_minor32').val(minorMax);
        dis.closest('.AQLModal32').find('.aql_normal_letter32').val(letter);
        dis.closest('.AQLModal32').find('.aql_normal_sampsize32').val(sampsize);
    })

    $('body').on('click', '.confirmAQL32', function() {
        var dis = $(this);
        dis.closest('.part32').find('.main_part_qty32').val(dis.closest('.part32').find('.aql_qty32').val());
        dis.closest('.part32').find('#samples_unit32').val(dis.closest('.part32').find('.aql_normal_sampsize32').val());
        dis.closest('.part32').find('.AQLModal32').modal('hide');

    });

    $('.aql_select32').append('<option value="">--</option>');
    $('.aql_select32').append('<option value="0.065">0.065</option>');
    $('.aql_select32').append('<option value="0.10">0.10</option>');
    $('.aql_select32').append('<option value="0.15">0.15</option>');
    $('.aql_select32').append('<option value="0.25">0.25</option>');
    $('.aql_select32').append('<option value="0.4">0.4</option>');
    $('.aql_select32').append('<option value="0.65">0.65</option>');
    $('.aql_select32').append('<option value="1">1.0</option>');
    $('.aql_select32').append('<option value="1.5">1.5</option>');
    $('.aql_select32').append('<option value="2.5">2.5</option>');
    $('.aql_select32').append('<option value="4">4.0</option>');
    $('.aql_select32').append('<option value="6.5">6.5</option>');
    $('.aql_select32').append('<option value="10">10.0</option>');
    $('.aql_select32').append('<option value="N/A">N/A</option>');

    //33
    $('body').on('click', '.btn-main_part_qty-modal33', function() {
        jQuery.noConflict();
        $('.AQLModal33').modal('show');
    });

    $('body').on('keyup', '.aql_qty33', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal33').find('.aql_minor33').val();
        var major = dis.closest('.AQLModal33').find('.aql_major33').val();
        var lvl = dis.closest('.AQLModal33').find('.aql_normal_level33').val();
        var special_lvl = dis.closest('.AQLModal33').find('.aql_special_level33').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal33').find('.max_major33').val(majorMax);
        dis.closest('.AQLModal33').find('.max_minor33').val(minorMax);
        dis.closest('.AQLModal33').find('.aql_normal_letter33').val(letter);
        dis.closest('.AQLModal33').find('.aql_special_letter33').val(special_letter);
        dis.closest('.AQLModal33').find('.aql_normal_sampsize33').val(sampsize);
        dis.closest('.AQLModal33').find('.aql_special_sampsize33').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level33', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal33').find('.aql_qty33').val();
        var minor = dis.closest('.AQLModal33').find('.aql_minor33').val();
        var major = dis.closest('.AQLModal33').find('.aql_major33').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal33').find('.max_major33').val(majorMax);
        dis.closest('.AQLModal33').find('.max_minor33').val(minorMax);
        dis.closest('.AQLModal33').find('.aql_normal_letter33').val(letter);
        dis.closest('.AQLModal33').find('.aql_normal_sampsize33').val(sampsize);
    })

    $('body').on('change', '.aql_special_level33', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal33').find('.aql_qty33').val();
        var minor = dis.closest('.AQLModal33').find('.aql_minor33').val();
        var major = dis.closest('.AQLModal33').find('.aql_major33').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal33').find('.aql_special_letter33').val(letter);
        dis.closest('.AQLModal33').find('.aql_special_sampsize33').val(sampsize);
    })

    $('body').on('change', '.aql_major33', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal33').find('.aql_qty33').val();
        var minor = dis.closest('.AQLModal33').find('.aql_minor33').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal33').find('.aql_normal_level33').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal33').find('.max_major33').val(majorMax);
        dis.closest('.AQLModal33').find('.max_minor33').val(minorMax);
        dis.closest('.AQLModal33').find('.aql_normal_letter33').val(letter);
        dis.closest('.AQLModal33').find('.aql_normal_sampsize33').val(sampsize);
    })

    $('body').on('change', '.aql_minor33', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal33').find('.aql_qty33').val();
        var major = dis.closest('.AQLModal33').find('.aql_major33').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal33').find('.aql_normal_level33').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal33').find('.max_major33').val(majorMax);
        dis.closest('.AQLModal33').find('.max_minor33').val(minorMax);
        dis.closest('.AQLModal33').find('.aql_normal_letter33').val(letter);
        dis.closest('.AQLModal33').find('.aql_normal_sampsize33').val(sampsize);
    })

    $('body').on('click', '.confirmAQL33', function() {
        var dis = $(this);
        dis.closest('.part33').find('.main_part_qty33').val(dis.closest('.part33').find('.aql_qty33').val());
        dis.closest('.part33').find('#samples_unit33').val(dis.closest('.part33').find('.aql_normal_sampsize33').val());
        dis.closest('.part33').find('.AQLModal33').modal('hide');

    });

    $('.aql_select33').append('<option value="">--</option>');
    $('.aql_select33').append('<option value="0.065">0.065</option>');
    $('.aql_select33').append('<option value="0.10">0.10</option>');
    $('.aql_select33').append('<option value="0.15">0.15</option>');
    $('.aql_select33').append('<option value="0.25">0.25</option>');
    $('.aql_select33').append('<option value="0.4">0.4</option>');
    $('.aql_select33').append('<option value="0.65">0.65</option>');
    $('.aql_select33').append('<option value="1">1.0</option>');
    $('.aql_select33').append('<option value="1.5">1.5</option>');
    $('.aql_select33').append('<option value="2.5">2.5</option>');
    $('.aql_select33').append('<option value="4">4.0</option>');
    $('.aql_select33').append('<option value="6.5">6.5</option>');
    $('.aql_select33').append('<option value="10">10.0</option>');
    $('.aql_select33').append('<option value="N/A">N/A</option>');

    //34
    $('body').on('click', '.btn-main_part_qty-modal34', function() {
        jQuery.noConflict();
        $('.AQLModal34').modal('show');
    });

    $('body').on('keyup', '.aql_qty34', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal34').find('.aql_minor34').val();
        var major = dis.closest('.AQLModal34').find('.aql_major34').val();
        var lvl = dis.closest('.AQLModal34').find('.aql_normal_level34').val();
        var special_lvl = dis.closest('.AQLModal34').find('.aql_special_level34').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal34').find('.max_major34').val(majorMax);
        dis.closest('.AQLModal34').find('.max_minor34').val(minorMax);
        dis.closest('.AQLModal34').find('.aql_normal_letter34').val(letter);
        dis.closest('.AQLModal34').find('.aql_special_letter34').val(special_letter);
        dis.closest('.AQLModal34').find('.aql_normal_sampsize34').val(sampsize);
        dis.closest('.AQLModal34').find('.aql_special_sampsize34').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level34', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal34').find('.aql_qty34').val();
        var minor = dis.closest('.AQLModal34').find('.aql_minor34').val();
        var major = dis.closest('.AQLModal34').find('.aql_major34').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal34').find('.max_major34').val(majorMax);
        dis.closest('.AQLModal34').find('.max_minor34').val(minorMax);
        dis.closest('.AQLModal34').find('.aql_normal_letter34').val(letter);
        dis.closest('.AQLModal34').find('.aql_normal_sampsize34').val(sampsize);
    })

    $('body').on('change', '.aql_special_level34', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal34').find('.aql_qty34').val();
        var minor = dis.closest('.AQLModal34').find('.aql_minor34').val();
        var major = dis.closest('.AQLModal34').find('.aql_major34').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal34').find('.aql_special_letter34').val(letter);
        dis.closest('.AQLModal34').find('.aql_special_sampsize34').val(sampsize);
    })

    $('body').on('change', '.aql_major34', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal34').find('.aql_qty34').val();
        var minor = dis.closest('.AQLModal34').find('.aql_minor34').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal34').find('.aql_normal_level34').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal34').find('.max_major34').val(majorMax);
        dis.closest('.AQLModal34').find('.max_minor34').val(minorMax);
        dis.closest('.AQLModal34').find('.aql_normal_letter34').val(letter);
        dis.closest('.AQLModal34').find('.aql_normal_sampsize34').val(sampsize);
    })

    $('body').on('change', '.aql_minor34', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal34').find('.aql_qty34').val();
        var major = dis.closest('.AQLModal34').find('.aql_major34').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal34').find('.aql_normal_level34').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal34').find('.max_major34').val(majorMax);
        dis.closest('.AQLModal34').find('.max_minor34').val(minorMax);
        dis.closest('.AQLModal34').find('.aql_normal_letter34').val(letter);
        dis.closest('.AQLModal34').find('.aql_normal_sampsize34').val(sampsize);
    })

    $('body').on('click', '.confirmAQL34', function() {
        var dis = $(this);
        dis.closest('.part34').find('.main_part_qty34').val(dis.closest('.part34').find('.aql_qty34').val());
        dis.closest('.part34').find('#samples_unit34').val(dis.closest('.part34').find('.aql_normal_sampsize34').val());
        dis.closest('.part34').find('.AQLModal34').modal('hide');

    });

    $('.aql_select34').append('<option value="">--</option>');
    $('.aql_select34').append('<option value="0.065">0.065</option>');
    $('.aql_select34').append('<option value="0.10">0.10</option>');
    $('.aql_select34').append('<option value="0.15">0.15</option>');
    $('.aql_select34').append('<option value="0.25">0.25</option>');
    $('.aql_select34').append('<option value="0.4">0.4</option>');
    $('.aql_select34').append('<option value="0.65">0.65</option>');
    $('.aql_select34').append('<option value="1">1.0</option>');
    $('.aql_select34').append('<option value="1.5">1.5</option>');
    $('.aql_select34').append('<option value="2.5">2.5</option>');
    $('.aql_select34').append('<option value="4">4.0</option>');
    $('.aql_select34').append('<option value="6.5">6.5</option>');
    $('.aql_select34').append('<option value="10">10.0</option>');
    $('.aql_select34').append('<option value="N/A">N/A</option>');

    //35
    $('body').on('click', '.btn-main_part_qty-modal35', function() {
        jQuery.noConflict();
        $('.AQLModal35').modal('show');
    });

    $('body').on('keyup', '.aql_qty35', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal35').find('.aql_minor35').val();
        var major = dis.closest('.AQLModal35').find('.aql_major35').val();
        var lvl = dis.closest('.AQLModal35').find('.aql_normal_level35').val();
        var special_lvl = dis.closest('.AQLModal35').find('.aql_special_level35').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal35').find('.max_major35').val(majorMax);
        dis.closest('.AQLModal35').find('.max_minor35').val(minorMax);
        dis.closest('.AQLModal35').find('.aql_normal_letter35').val(letter);
        dis.closest('.AQLModal35').find('.aql_special_letter35').val(special_letter);
        dis.closest('.AQLModal35').find('.aql_normal_sampsize35').val(sampsize);
        dis.closest('.AQLModal35').find('.aql_special_sampsize35').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level35', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal35').find('.aql_qty35').val();
        var minor = dis.closest('.AQLModal35').find('.aql_minor35').val();
        var major = dis.closest('.AQLModal35').find('.aql_major35').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal35').find('.max_major35').val(majorMax);
        dis.closest('.AQLModal35').find('.max_minor35').val(minorMax);
        dis.closest('.AQLModal35').find('.aql_normal_letter35').val(letter);
        dis.closest('.AQLModal35').find('.aql_normal_sampsize35').val(sampsize);
    })

    $('body').on('change', '.aql_special_level35', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal35').find('.aql_qty35').val();
        var minor = dis.closest('.AQLModal35').find('.aql_minor35').val();
        var major = dis.closest('.AQLModal35').find('.aql_major35').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal35').find('.aql_special_letter35').val(letter);
        dis.closest('.AQLModal35').find('.aql_special_sampsize35').val(sampsize);
    })

    $('body').on('change', '.aql_major35', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal35').find('.aql_qty35').val();
        var minor = dis.closest('.AQLModal35').find('.aql_minor35').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal35').find('.aql_normal_level35').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal35').find('.max_major35').val(majorMax);
        dis.closest('.AQLModal35').find('.max_minor35').val(minorMax);
        dis.closest('.AQLModal35').find('.aql_normal_letter35').val(letter);
        dis.closest('.AQLModal35').find('.aql_normal_sampsize35').val(sampsize);
    })

    $('body').on('change', '.aql_minor35', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal35').find('.aql_qty35').val();
        var major = dis.closest('.AQLModal35').find('.aql_major35').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal35').find('.aql_normal_level35').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal35').find('.max_major35').val(majorMax);
        dis.closest('.AQLModal35').find('.max_minor35').val(minorMax);
        dis.closest('.AQLModal35').find('.aql_normal_letter35').val(letter);
        dis.closest('.AQLModal35').find('.aql_normal_sampsize35').val(sampsize);
    })

    $('body').on('click', '.confirmAQL35', function() {
        var dis = $(this);
        dis.closest('.part35').find('.main_part_qty35').val(dis.closest('.part35').find('.aql_qty35').val());
        dis.closest('.part35').find('#samples_unit35').val(dis.closest('.part35').find('.aql_normal_sampsize35').val());
        dis.closest('.part35').find('.AQLModal35').modal('hide');

    });

    $('.aql_select35').append('<option value="">--</option>');
    $('.aql_select35').append('<option value="0.065">0.065</option>');
    $('.aql_select35').append('<option value="0.10">0.10</option>');
    $('.aql_select35').append('<option value="0.15">0.15</option>');
    $('.aql_select35').append('<option value="0.25">0.25</option>');
    $('.aql_select35').append('<option value="0.4">0.4</option>');
    $('.aql_select35').append('<option value="0.65">0.65</option>');
    $('.aql_select35').append('<option value="1">1.0</option>');
    $('.aql_select35').append('<option value="1.5">1.5</option>');
    $('.aql_select35').append('<option value="2.5">2.5</option>');
    $('.aql_select35').append('<option value="4">4.0</option>');
    $('.aql_select35').append('<option value="6.5">6.5</option>');
    $('.aql_select35').append('<option value="10">10.0</option>');
    $('.aql_select35').append('<option value="N/A">N/A</option>');

    //36
    $('body').on('click', '.btn-main_part_qty-modal36', function() {
        jQuery.noConflict();
        $('.AQLModal36').modal('show');
    });

    $('body').on('keyup', '.aql_qty36', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal36').find('.aql_minor36').val();
        var major = dis.closest('.AQLModal36').find('.aql_major36').val();
        var lvl = dis.closest('.AQLModal36').find('.aql_normal_level36').val();
        var special_lvl = dis.closest('.AQLModal36').find('.aql_special_level36').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal36').find('.max_major36').val(majorMax);
        dis.closest('.AQLModal36').find('.max_minor36').val(minorMax);
        dis.closest('.AQLModal36').find('.aql_normal_letter36').val(letter);
        dis.closest('.AQLModal36').find('.aql_special_letter36').val(special_letter);
        dis.closest('.AQLModal36').find('.aql_normal_sampsize36').val(sampsize);
        dis.closest('.AQLModal36').find('.aql_special_sampsize36').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level36', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal36').find('.aql_qty36').val();
        var minor = dis.closest('.AQLModal36').find('.aql_minor36').val();
        var major = dis.closest('.AQLModal36').find('.aql_major36').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal36').find('.max_major36').val(majorMax);
        dis.closest('.AQLModal36').find('.max_minor36').val(minorMax);
        dis.closest('.AQLModal36').find('.aql_normal_letter36').val(letter);
        dis.closest('.AQLModal36').find('.aql_normal_sampsize36').val(sampsize);
    })

    $('body').on('change', '.aql_special_level36', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal36').find('.aql_qty36').val();
        var minor = dis.closest('.AQLModal36').find('.aql_minor36').val();
        var major = dis.closest('.AQLModal36').find('.aql_major36').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal36').find('.aql_special_letter36').val(letter);
        dis.closest('.AQLModal36').find('.aql_special_sampsize36').val(sampsize);
    })

    $('body').on('change', '.aql_major36', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal36').find('.aql_qty36').val();
        var minor = dis.closest('.AQLModal36').find('.aql_minor36').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal36').find('.aql_normal_level36').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal36').find('.max_major36').val(majorMax);
        dis.closest('.AQLModal36').find('.max_minor36').val(minorMax);
        dis.closest('.AQLModal36').find('.aql_normal_letter36').val(letter);
        dis.closest('.AQLModal36').find('.aql_normal_sampsize36').val(sampsize);
    })

    $('body').on('change', '.aql_minor36', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal36').find('.aql_qty36').val();
        var major = dis.closest('.AQLModal36').find('.aql_major36').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal36').find('.aql_normal_level36').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal36').find('.max_major36').val(majorMax);
        dis.closest('.AQLModal36').find('.max_minor36').val(minorMax);
        dis.closest('.AQLModal36').find('.aql_normal_letter36').val(letter);
        dis.closest('.AQLModal36').find('.aql_normal_sampsize36').val(sampsize);
    })

    $('body').on('click', '.confirmAQL36', function() {
        var dis = $(this);
        dis.closest('.part36').find('.main_part_qty36').val(dis.closest('.part36').find('.aql_qty36').val());
        dis.closest('.part36').find('#samples_unit36').val(dis.closest('.part36').find('.aql_normal_sampsize36').val());
        dis.closest('.part36').find('.AQLModal36').modal('hide');

    });

    $('.aql_select36').append('<option value="">--</option>');
    $('.aql_select36').append('<option value="0.065">0.065</option>');
    $('.aql_select36').append('<option value="0.10">0.10</option>');
    $('.aql_select36').append('<option value="0.15">0.15</option>');
    $('.aql_select36').append('<option value="0.25">0.25</option>');
    $('.aql_select36').append('<option value="0.4">0.4</option>');
    $('.aql_select36').append('<option value="0.65">0.65</option>');
    $('.aql_select36').append('<option value="1">1.0</option>');
    $('.aql_select36').append('<option value="1.5">1.5</option>');
    $('.aql_select36').append('<option value="2.5">2.5</option>');
    $('.aql_select36').append('<option value="4">4.0</option>');
    $('.aql_select36').append('<option value="6.5">6.5</option>');
    $('.aql_select36').append('<option value="10">10.0</option>');
    $('.aql_select36').append('<option value="N/A">N/A</option>');

    //37
    $('body').on('click', '.btn-main_part_qty-modal37', function() {
        jQuery.noConflict();
        $('.AQLModal37').modal('show');
    });

    $('body').on('keyup', '.aql_qty37', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal37').find('.aql_minor37').val();
        var major = dis.closest('.AQLModal37').find('.aql_major37').val();
        var lvl = dis.closest('.AQLModal37').find('.aql_normal_level37').val();
        var special_lvl = dis.closest('.AQLModal37').find('.aql_special_level37').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal37').find('.max_major37').val(majorMax);
        dis.closest('.AQLModal37').find('.max_minor37').val(minorMax);
        dis.closest('.AQLModal37').find('.aql_normal_letter37').val(letter);
        dis.closest('.AQLModal37').find('.aql_special_letter37').val(special_letter);
        dis.closest('.AQLModal37').find('.aql_normal_sampsize37').val(sampsize);
        dis.closest('.AQLModal37').find('.aql_special_sampsize37').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level37', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal37').find('.aql_qty37').val();
        var minor = dis.closest('.AQLModal37').find('.aql_minor37').val();
        var major = dis.closest('.AQLModal37').find('.aql_major37').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal37').find('.max_major37').val(majorMax);
        dis.closest('.AQLModal37').find('.max_minor37').val(minorMax);
        dis.closest('.AQLModal37').find('.aql_normal_letter37').val(letter);
        dis.closest('.AQLModal37').find('.aql_normal_sampsize37').val(sampsize);
    })

    $('body').on('change', '.aql_special_level37', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal37').find('.aql_qty37').val();
        var minor = dis.closest('.AQLModal37').find('.aql_minor37').val();
        var major = dis.closest('.AQLModal37').find('.aql_major37').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal37').find('.aql_special_letter37').val(letter);
        dis.closest('.AQLModal37').find('.aql_special_sampsize37').val(sampsize);
    })

    $('body').on('change', '.aql_major37', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal37').find('.aql_qty37').val();
        var minor = dis.closest('.AQLModal37').find('.aql_minor37').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal37').find('.aql_normal_level37').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal37').find('.max_major37').val(majorMax);
        dis.closest('.AQLModal37').find('.max_minor37').val(minorMax);
        dis.closest('.AQLModal37').find('.aql_normal_letter37').val(letter);
        dis.closest('.AQLModal37').find('.aql_normal_sampsize37').val(sampsize);
    })

    $('body').on('change', '.aql_minor37', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal37').find('.aql_qty37').val();
        var major = dis.closest('.AQLModal37').find('.aql_major37').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal37').find('.aql_normal_level37').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal37').find('.max_major37').val(majorMax);
        dis.closest('.AQLModal37').find('.max_minor37').val(minorMax);
        dis.closest('.AQLModal37').find('.aql_normal_letter37').val(letter);
        dis.closest('.AQLModal37').find('.aql_normal_sampsize37').val(sampsize);
    })

    $('body').on('click', '.confirmAQL37', function() {
        var dis = $(this);
        dis.closest('.part37').find('.main_part_qty37').val(dis.closest('.part37').find('.aql_qty37').val());
        dis.closest('.part37').find('#samples_unit37').val(dis.closest('.part37').find('.aql_normal_sampsize37').val());
        dis.closest('.part37').find('.AQLModal37').modal('hide');

    });

    $('.aql_select37').append('<option value="">--</option>');
    $('.aql_select37').append('<option value="0.065">0.065</option>');
    $('.aql_select37').append('<option value="0.10">0.10</option>');
    $('.aql_select37').append('<option value="0.15">0.15</option>');
    $('.aql_select37').append('<option value="0.25">0.25</option>');
    $('.aql_select37').append('<option value="0.4">0.4</option>');
    $('.aql_select37').append('<option value="0.65">0.65</option>');
    $('.aql_select37').append('<option value="1">1.0</option>');
    $('.aql_select37').append('<option value="1.5">1.5</option>');
    $('.aql_select37').append('<option value="2.5">2.5</option>');
    $('.aql_select37').append('<option value="4">4.0</option>');
    $('.aql_select37').append('<option value="6.5">6.5</option>');
    $('.aql_select37').append('<option value="10">10.0</option>');
    $('.aql_select37').append('<option value="N/A">N/A</option>');

    //38
    $('body').on('click', '.btn-main_part_qty-modal38', function() {
        jQuery.noConflict();
        $('.AQLModal38').modal('show');
    });

    $('body').on('keyup', '.aql_qty38', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal38').find('.aql_minor38').val();
        var major = dis.closest('.AQLModal38').find('.aql_major38').val();
        var lvl = dis.closest('.AQLModal38').find('.aql_normal_level38').val();
        var special_lvl = dis.closest('.AQLModal38').find('.aql_special_level38').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal38').find('.max_major38').val(majorMax);
        dis.closest('.AQLModal38').find('.max_minor38').val(minorMax);
        dis.closest('.AQLModal38').find('.aql_normal_letter38').val(letter);
        dis.closest('.AQLModal38').find('.aql_special_letter38').val(special_letter);
        dis.closest('.AQLModal38').find('.aql_normal_sampsize38').val(sampsize);
        dis.closest('.AQLModal38').find('.aql_special_sampsize38').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level38', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal38').find('.aql_qty38').val();
        var minor = dis.closest('.AQLModal38').find('.aql_minor38').val();
        var major = dis.closest('.AQLModal38').find('.aql_major38').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal38').find('.max_major38').val(majorMax);
        dis.closest('.AQLModal38').find('.max_minor38').val(minorMax);
        dis.closest('.AQLModal38').find('.aql_normal_letter38').val(letter);
        dis.closest('.AQLModal38').find('.aql_normal_sampsize38').val(sampsize);
    })

    $('body').on('change', '.aql_special_level38', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal38').find('.aql_qty38').val();
        var minor = dis.closest('.AQLModal38').find('.aql_minor38').val();
        var major = dis.closest('.AQLModal38').find('.aql_major38').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal38').find('.aql_special_letter38').val(letter);
        dis.closest('.AQLModal38').find('.aql_special_sampsize38').val(sampsize);
    })

    $('body').on('change', '.aql_major38', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal38').find('.aql_qty38').val();
        var minor = dis.closest('.AQLModal38').find('.aql_minor38').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal38').find('.aql_normal_level38').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal38').find('.max_major38').val(majorMax);
        dis.closest('.AQLModal38').find('.max_minor38').val(minorMax);
        dis.closest('.AQLModal38').find('.aql_normal_letter38').val(letter);
        dis.closest('.AQLModal38').find('.aql_normal_sampsize38').val(sampsize);
    })

    $('body').on('change', '.aql_minor38', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal38').find('.aql_qty38').val();
        var major = dis.closest('.AQLModal38').find('.aql_major38').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal38').find('.aql_normal_level38').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal38').find('.max_major38').val(majorMax);
        dis.closest('.AQLModal38').find('.max_minor38').val(minorMax);
        dis.closest('.AQLModal38').find('.aql_normal_letter38').val(letter);
        dis.closest('.AQLModal38').find('.aql_normal_sampsize38').val(sampsize);
    })

    $('body').on('click', '.confirmAQL38', function() {
        var dis = $(this);
        dis.closest('.part38').find('.main_part_qty38').val(dis.closest('.part38').find('.aql_qty38').val());
        dis.closest('.part38').find('#samples_unit38').val(dis.closest('.part38').find('.aql_normal_sampsize38').val());
        dis.closest('.part38').find('.AQLModal38').modal('hide');

    });

    $('.aql_select38').append('<option value="">--</option>');
    $('.aql_select38').append('<option value="0.065">0.065</option>');
    $('.aql_select38').append('<option value="0.10">0.10</option>');
    $('.aql_select38').append('<option value="0.15">0.15</option>');
    $('.aql_select38').append('<option value="0.25">0.25</option>');
    $('.aql_select38').append('<option value="0.4">0.4</option>');
    $('.aql_select38').append('<option value="0.65">0.65</option>');
    $('.aql_select38').append('<option value="1">1.0</option>');
    $('.aql_select38').append('<option value="1.5">1.5</option>');
    $('.aql_select38').append('<option value="2.5">2.5</option>');
    $('.aql_select38').append('<option value="4">4.0</option>');
    $('.aql_select38').append('<option value="6.5">6.5</option>');
    $('.aql_select38').append('<option value="10">10.0</option>');
    $('.aql_select38').append('<option value="N/A">N/A</option>');

    //39
    $('body').on('click', '.btn-main_part_qty-modal39', function() {
        jQuery.noConflict();
        $('.AQLModal39').modal('show');
    });

    $('body').on('keyup', '.aql_qty39', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal39').find('.aql_minor39').val();
        var major = dis.closest('.AQLModal39').find('.aql_major39').val();
        var lvl = dis.closest('.AQLModal39').find('.aql_normal_level39').val();
        var special_lvl = dis.closest('.AQLModal39').find('.aql_special_level39').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal39').find('.max_major39').val(majorMax);
        dis.closest('.AQLModal39').find('.max_minor39').val(minorMax);
        dis.closest('.AQLModal39').find('.aql_normal_letter39').val(letter);
        dis.closest('.AQLModal39').find('.aql_special_letter39').val(special_letter);
        dis.closest('.AQLModal39').find('.aql_normal_sampsize39').val(sampsize);
        dis.closest('.AQLModal39').find('.aql_special_sampsize39').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level39', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal39').find('.aql_qty39').val();
        var minor = dis.closest('.AQLModal39').find('.aql_minor39').val();
        var major = dis.closest('.AQLModal39').find('.aql_major39').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal39').find('.max_major39').val(majorMax);
        dis.closest('.AQLModal39').find('.max_minor39').val(minorMax);
        dis.closest('.AQLModal39').find('.aql_normal_letter39').val(letter);
        dis.closest('.AQLModal39').find('.aql_normal_sampsize39').val(sampsize);
    })

    $('body').on('change', '.aql_special_level39', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal39').find('.aql_qty39').val();
        var minor = dis.closest('.AQLModal39').find('.aql_minor39').val();
        var major = dis.closest('.AQLModal39').find('.aql_major39').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal39').find('.aql_special_letter39').val(letter);
        dis.closest('.AQLModal39').find('.aql_special_sampsize39').val(sampsize);
    })

    $('body').on('change', '.aql_major39', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal39').find('.aql_qty39').val();
        var minor = dis.closest('.AQLModal39').find('.aql_minor39').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal39').find('.aql_normal_level39').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal39').find('.max_major39').val(majorMax);
        dis.closest('.AQLModal39').find('.max_minor39').val(minorMax);
        dis.closest('.AQLModal39').find('.aql_normal_letter39').val(letter);
        dis.closest('.AQLModal39').find('.aql_normal_sampsize39').val(sampsize);
    })

    $('body').on('change', '.aql_minor39', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal39').find('.aql_qty39').val();
        var major = dis.closest('.AQLModal39').find('.aql_major39').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal39').find('.aql_normal_level39').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal39').find('.max_major39').val(majorMax);
        dis.closest('.AQLModal39').find('.max_minor39').val(minorMax);
        dis.closest('.AQLModal39').find('.aql_normal_letter39').val(letter);
        dis.closest('.AQLModal39').find('.aql_normal_sampsize39').val(sampsize);
    })

    $('body').on('click', '.confirmAQL39', function() {
        var dis = $(this);
        dis.closest('.part39').find('.main_part_qty39').val(dis.closest('.part39').find('.aql_qty39').val());
        dis.closest('.part39').find('#samples_unit39').val(dis.closest('.part39').find('.aql_normal_sampsize39').val());
        dis.closest('.part39').find('.AQLModal39').modal('hide');

    });

    $('.aql_select39').append('<option value="">--</option>');
    $('.aql_select39').append('<option value="0.065">0.065</option>');
    $('.aql_select39').append('<option value="0.10">0.10</option>');
    $('.aql_select39').append('<option value="0.15">0.15</option>');
    $('.aql_select39').append('<option value="0.25">0.25</option>');
    $('.aql_select39').append('<option value="0.4">0.4</option>');
    $('.aql_select39').append('<option value="0.65">0.65</option>');
    $('.aql_select39').append('<option value="1">1.0</option>');
    $('.aql_select39').append('<option value="1.5">1.5</option>');
    $('.aql_select39').append('<option value="2.5">2.5</option>');
    $('.aql_select39').append('<option value="4">4.0</option>');
    $('.aql_select39').append('<option value="6.5">6.5</option>');
    $('.aql_select39').append('<option value="10">10.0</option>');
    $('.aql_select39').append('<option value="N/A">N/A</option>');

    //40
    $('body').on('click', '.btn-main_part_qty-modal40', function() {
        jQuery.noConflict();
        $('.AQLModal40').modal('show');
    });

    $('body').on('keyup', '.aql_qty40', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal40').find('.aql_minor40').val();
        var major = dis.closest('.AQLModal40').find('.aql_major40').val();
        var lvl = dis.closest('.AQLModal40').find('.aql_normal_level40').val();
        var special_lvl = dis.closest('.AQLModal40').find('.aql_special_level40').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal40').find('.max_major40').val(majorMax);
        dis.closest('.AQLModal40').find('.max_minor40').val(minorMax);
        dis.closest('.AQLModal40').find('.aql_normal_letter40').val(letter);
        dis.closest('.AQLModal40').find('.aql_special_letter40').val(special_letter);
        dis.closest('.AQLModal40').find('.aql_normal_sampsize40').val(sampsize);
        dis.closest('.AQLModal40').find('.aql_special_sampsize40').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level40', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal40').find('.aql_qty40').val();
        var minor = dis.closest('.AQLModal40').find('.aql_minor40').val();
        var major = dis.closest('.AQLModal40').find('.aql_major40').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal40').find('.max_major40').val(majorMax);
        dis.closest('.AQLModal40').find('.max_minor40').val(minorMax);
        dis.closest('.AQLModal40').find('.aql_normal_letter40').val(letter);
        dis.closest('.AQLModal40').find('.aql_normal_sampsize40').val(sampsize);
    })

    $('body').on('change', '.aql_special_level40', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal40').find('.aql_qty40').val();
        var minor = dis.closest('.AQLModal40').find('.aql_minor40').val();
        var major = dis.closest('.AQLModal40').find('.aql_major40').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal40').find('.aql_special_letter40').val(letter);
        dis.closest('.AQLModal40').find('.aql_special_sampsize40').val(sampsize);
    })

    $('body').on('change', '.aql_major40', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal40').find('.aql_qty40').val();
        var minor = dis.closest('.AQLModal40').find('.aql_minor40').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal40').find('.aql_normal_level40').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal40').find('.max_major40').val(majorMax);
        dis.closest('.AQLModal40').find('.max_minor40').val(minorMax);
        dis.closest('.AQLModal40').find('.aql_normal_letter40').val(letter);
        dis.closest('.AQLModal40').find('.aql_normal_sampsize40').val(sampsize);
    })

    $('body').on('change', '.aql_minor40', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal40').find('.aql_qty40').val();
        var major = dis.closest('.AQLModal40').find('.aql_major40').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal40').find('.aql_normal_level40').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal40').find('.max_major40').val(majorMax);
        dis.closest('.AQLModal40').find('.max_minor40').val(minorMax);
        dis.closest('.AQLModal40').find('.aql_normal_letter40').val(letter);
        dis.closest('.AQLModal40').find('.aql_normal_sampsize40').val(sampsize);
    })

    $('body').on('click', '.confirmAQL40', function() {
        var dis = $(this);
        dis.closest('.part40').find('.main_part_qty40').val(dis.closest('.part40').find('.aql_qty40').val());
        dis.closest('.part40').find('#samples_unit40').val(dis.closest('.part40').find('.aql_normal_sampsize40').val());
        dis.closest('.part40').find('.AQLModal40').modal('hide');

    });

    $('.aql_select40').append('<option value="">--</option>');
    $('.aql_select40').append('<option value="0.065">0.065</option>');
    $('.aql_select40').append('<option value="0.10">0.10</option>');
    $('.aql_select40').append('<option value="0.15">0.15</option>');
    $('.aql_select40').append('<option value="0.25">0.25</option>');
    $('.aql_select40').append('<option value="0.4">0.4</option>');
    $('.aql_select40').append('<option value="0.65">0.65</option>');
    $('.aql_select40').append('<option value="1">1.0</option>');
    $('.aql_select40').append('<option value="1.5">1.5</option>');
    $('.aql_select40').append('<option value="2.5">2.5</option>');
    $('.aql_select40').append('<option value="4">4.0</option>');
    $('.aql_select40').append('<option value="6.5">6.5</option>');
    $('.aql_select40').append('<option value="10">10.0</option>');
    $('.aql_select40').append('<option value="N/A">N/A</option>');

    //41
    $('body').on('click', '.btn-main_part_qty-modal41', function() {
        jQuery.noConflict();
        $('.AQLModal41').modal('show');
    });

    $('body').on('keyup', '.aql_qty41', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal41').find('.aql_minor41').val();
        var major = dis.closest('.AQLModal41').find('.aql_major41').val();
        var lvl = dis.closest('.AQLModal41').find('.aql_normal_level41').val();
        var special_lvl = dis.closest('.AQLModal41').find('.aql_special_level41').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal41').find('.max_major41').val(majorMax);
        dis.closest('.AQLModal41').find('.max_minor41').val(minorMax);
        dis.closest('.AQLModal41').find('.aql_normal_letter41').val(letter);
        dis.closest('.AQLModal41').find('.aql_special_letter41').val(special_letter);
        dis.closest('.AQLModal41').find('.aql_normal_sampsize41').val(sampsize);
        dis.closest('.AQLModal41').find('.aql_special_sampsize41').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level41', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal41').find('.aql_qty41').val();
        var minor = dis.closest('.AQLModal41').find('.aql_minor41').val();
        var major = dis.closest('.AQLModal41').find('.aql_major41').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal41').find('.max_major41').val(majorMax);
        dis.closest('.AQLModal41').find('.max_minor41').val(minorMax);
        dis.closest('.AQLModal41').find('.aql_normal_letter41').val(letter);
        dis.closest('.AQLModal41').find('.aql_normal_sampsize41').val(sampsize);
    })

    $('body').on('change', '.aql_special_level41', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal41').find('.aql_qty41').val();
        var minor = dis.closest('.AQLModal41').find('.aql_minor41').val();
        var major = dis.closest('.AQLModal41').find('.aql_major41').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal41').find('.aql_special_letter41').val(letter);
        dis.closest('.AQLModal41').find('.aql_special_sampsize41').val(sampsize);
    })

    $('body').on('change', '.aql_major41', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal41').find('.aql_qty41').val();
        var minor = dis.closest('.AQLModal41').find('.aql_minor41').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal41').find('.aql_normal_level41').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal41').find('.max_major41').val(majorMax);
        dis.closest('.AQLModal41').find('.max_minor41').val(minorMax);
        dis.closest('.AQLModal41').find('.aql_normal_letter41').val(letter);
        dis.closest('.AQLModal41').find('.aql_normal_sampsize41').val(sampsize);
    })

    $('body').on('change', '.aql_minor41', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal41').find('.aql_qty41').val();
        var major = dis.closest('.AQLModal41').find('.aql_major41').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal41').find('.aql_normal_level41').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal41').find('.max_major41').val(majorMax);
        dis.closest('.AQLModal41').find('.max_minor41').val(minorMax);
        dis.closest('.AQLModal41').find('.aql_normal_letter41').val(letter);
        dis.closest('.AQLModal41').find('.aql_normal_sampsize41').val(sampsize);
    })

    $('body').on('click', '.confirmAQL41', function() {
        var dis = $(this);
        dis.closest('.part41').find('.main_part_qty41').val(dis.closest('.part41').find('.aql_qty41').val());
        dis.closest('.part41').find('#samples_unit41').val(dis.closest('.part41').find('.aql_normal_sampsize41').val());
        dis.closest('.part41').find('.AQLModal41').modal('hide');

    });

    $('.aql_select41').append('<option value="">--</option>');
    $('.aql_select41').append('<option value="0.065">0.065</option>');
    $('.aql_select41').append('<option value="0.10">0.10</option>');
    $('.aql_select41').append('<option value="0.15">0.15</option>');
    $('.aql_select41').append('<option value="0.25">0.25</option>');
    $('.aql_select41').append('<option value="0.4">0.4</option>');
    $('.aql_select41').append('<option value="0.65">0.65</option>');
    $('.aql_select41').append('<option value="1">1.0</option>');
    $('.aql_select41').append('<option value="1.5">1.5</option>');
    $('.aql_select41').append('<option value="2.5">2.5</option>');
    $('.aql_select41').append('<option value="4">4.0</option>');
    $('.aql_select41').append('<option value="6.5">6.5</option>');
    $('.aql_select41').append('<option value="10">10.0</option>');
    $('.aql_select41').append('<option value="N/A">N/A</option>');

    //42
    $('body').on('click', '.btn-main_part_qty-modal42', function() {
        jQuery.noConflict();
        $('.AQLModal42').modal('show');
    });

    $('body').on('keyup', '.aql_qty42', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal42').find('.aql_minor42').val();
        var major = dis.closest('.AQLModal42').find('.aql_major42').val();
        var lvl = dis.closest('.AQLModal42').find('.aql_normal_level42').val();
        var special_lvl = dis.closest('.AQLModal42').find('.aql_special_level42').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal42').find('.max_major42').val(majorMax);
        dis.closest('.AQLModal42').find('.max_minor42').val(minorMax);
        dis.closest('.AQLModal42').find('.aql_normal_letter42').val(letter);
        dis.closest('.AQLModal42').find('.aql_special_letter42').val(special_letter);
        dis.closest('.AQLModal42').find('.aql_normal_sampsize42').val(sampsize);
        dis.closest('.AQLModal42').find('.aql_special_sampsize42').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level42', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal42').find('.aql_qty42').val();
        var minor = dis.closest('.AQLModal42').find('.aql_minor42').val();
        var major = dis.closest('.AQLModal42').find('.aql_major42').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal42').find('.max_major42').val(majorMax);
        dis.closest('.AQLModal42').find('.max_minor42').val(minorMax);
        dis.closest('.AQLModal42').find('.aql_normal_letter42').val(letter);
        dis.closest('.AQLModal42').find('.aql_normal_sampsize42').val(sampsize);
    })

    $('body').on('change', '.aql_special_level42', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal42').find('.aql_qty42').val();
        var minor = dis.closest('.AQLModal42').find('.aql_minor42').val();
        var major = dis.closest('.AQLModal42').find('.aql_major42').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal42').find('.aql_special_letter42').val(letter);
        dis.closest('.AQLModal42').find('.aql_special_sampsize42').val(sampsize);
    })

    $('body').on('change', '.aql_major42', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal42').find('.aql_qty42').val();
        var minor = dis.closest('.AQLModal42').find('.aql_minor42').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal42').find('.aql_normal_level42').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal42').find('.max_major42').val(majorMax);
        dis.closest('.AQLModal42').find('.max_minor42').val(minorMax);
        dis.closest('.AQLModal42').find('.aql_normal_letter42').val(letter);
        dis.closest('.AQLModal42').find('.aql_normal_sampsize42').val(sampsize);
    })

    $('body').on('change', '.aql_minor42', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal42').find('.aql_qty42').val();
        var major = dis.closest('.AQLModal42').find('.aql_major42').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal42').find('.aql_normal_level42').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal42').find('.max_major42').val(majorMax);
        dis.closest('.AQLModal42').find('.max_minor42').val(minorMax);
        dis.closest('.AQLModal42').find('.aql_normal_letter42').val(letter);
        dis.closest('.AQLModal42').find('.aql_normal_sampsize42').val(sampsize);
    })

    $('body').on('click', '.confirmAQL42', function() {
        var dis = $(this);
        dis.closest('.part42').find('.main_part_qty42').val(dis.closest('.part42').find('.aql_qty42').val());
        dis.closest('.part42').find('#samples_unit42').val(dis.closest('.part42').find('.aql_normal_sampsize42').val());
        dis.closest('.part42').find('.AQLModal42').modal('hide');

    });

    $('.aql_select42').append('<option value="">--</option>');
    $('.aql_select42').append('<option value="0.065">0.065</option>');
    $('.aql_select42').append('<option value="0.10">0.10</option>');
    $('.aql_select42').append('<option value="0.15">0.15</option>');
    $('.aql_select42').append('<option value="0.25">0.25</option>');
    $('.aql_select42').append('<option value="0.4">0.4</option>');
    $('.aql_select42').append('<option value="0.65">0.65</option>');
    $('.aql_select42').append('<option value="1">1.0</option>');
    $('.aql_select42').append('<option value="1.5">1.5</option>');
    $('.aql_select42').append('<option value="2.5">2.5</option>');
    $('.aql_select42').append('<option value="4">4.0</option>');
    $('.aql_select42').append('<option value="6.5">6.5</option>');
    $('.aql_select42').append('<option value="10">10.0</option>');
    $('.aql_select42').append('<option value="N/A">N/A</option>');

    //43
    $('body').on('click', '.btn-main_part_qty-modal43', function() {
        jQuery.noConflict();
        $('.AQLModal43').modal('show');
    });

    $('body').on('keyup', '.aql_qty43', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal43').find('.aql_minor43').val();
        var major = dis.closest('.AQLModal43').find('.aql_major43').val();
        var lvl = dis.closest('.AQLModal43').find('.aql_normal_level43').val();
        var special_lvl = dis.closest('.AQLModal43').find('.aql_special_level43').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal43').find('.max_major43').val(majorMax);
        dis.closest('.AQLModal43').find('.max_minor43').val(minorMax);
        dis.closest('.AQLModal43').find('.aql_normal_letter43').val(letter);
        dis.closest('.AQLModal43').find('.aql_special_letter43').val(special_letter);
        dis.closest('.AQLModal43').find('.aql_normal_sampsize43').val(sampsize);
        dis.closest('.AQLModal43').find('.aql_special_sampsize43').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level43', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal43').find('.aql_qty43').val();
        var minor = dis.closest('.AQLModal43').find('.aql_minor43').val();
        var major = dis.closest('.AQLModal43').find('.aql_major43').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal43').find('.max_major43').val(majorMax);
        dis.closest('.AQLModal43').find('.max_minor43').val(minorMax);
        dis.closest('.AQLModal43').find('.aql_normal_letter43').val(letter);
        dis.closest('.AQLModal43').find('.aql_normal_sampsize43').val(sampsize);
    })

    $('body').on('change', '.aql_special_level43', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal43').find('.aql_qty43').val();
        var minor = dis.closest('.AQLModal43').find('.aql_minor43').val();
        var major = dis.closest('.AQLModal43').find('.aql_major43').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal43').find('.aql_special_letter43').val(letter);
        dis.closest('.AQLModal43').find('.aql_special_sampsize43').val(sampsize);
    })

    $('body').on('change', '.aql_major43', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal43').find('.aql_qty43').val();
        var minor = dis.closest('.AQLModal43').find('.aql_minor43').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal43').find('.aql_normal_level43').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal43').find('.max_major43').val(majorMax);
        dis.closest('.AQLModal43').find('.max_minor43').val(minorMax);
        dis.closest('.AQLModal43').find('.aql_normal_letter43').val(letter);
        dis.closest('.AQLModal43').find('.aql_normal_sampsize43').val(sampsize);
    })

    $('body').on('change', '.aql_minor43', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal43').find('.aql_qty43').val();
        var major = dis.closest('.AQLModal43').find('.aql_major43').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal43').find('.aql_normal_level43').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal43').find('.max_major43').val(majorMax);
        dis.closest('.AQLModal43').find('.max_minor43').val(minorMax);
        dis.closest('.AQLModal43').find('.aql_normal_letter43').val(letter);
        dis.closest('.AQLModal43').find('.aql_normal_sampsize43').val(sampsize);
    })

    $('body').on('click', '.confirmAQL43', function() {
        var dis = $(this);
        dis.closest('.part43').find('.main_part_qty43').val(dis.closest('.part43').find('.aql_qty43').val());
        dis.closest('.part43').find('#samples_unit43').val(dis.closest('.part43').find('.aql_normal_sampsize43').val());
        dis.closest('.part43').find('.AQLModal43').modal('hide');

    });

    $('.aql_select43').append('<option value="">--</option>');
    $('.aql_select43').append('<option value="0.065">0.065</option>');
    $('.aql_select43').append('<option value="0.10">0.10</option>');
    $('.aql_select43').append('<option value="0.15">0.15</option>');
    $('.aql_select43').append('<option value="0.25">0.25</option>');
    $('.aql_select43').append('<option value="0.4">0.4</option>');
    $('.aql_select43').append('<option value="0.65">0.65</option>');
    $('.aql_select43').append('<option value="1">1.0</option>');
    $('.aql_select43').append('<option value="1.5">1.5</option>');
    $('.aql_select43').append('<option value="2.5">2.5</option>');
    $('.aql_select43').append('<option value="4">4.0</option>');
    $('.aql_select43').append('<option value="6.5">6.5</option>');
    $('.aql_select43').append('<option value="10">10.0</option>');
    $('.aql_select43').append('<option value="N/A">N/A</option>');

    //44
    $('body').on('click', '.btn-main_part_qty-modal44', function() {
        jQuery.noConflict();
        $('.AQLModal44').modal('show');
    });

    $('body').on('keyup', '.aql_qty44', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal44').find('.aql_minor44').val();
        var major = dis.closest('.AQLModal44').find('.aql_major44').val();
        var lvl = dis.closest('.AQLModal44').find('.aql_normal_level44').val();
        var special_lvl = dis.closest('.AQLModal44').find('.aql_special_level44').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal44').find('.max_major44').val(majorMax);
        dis.closest('.AQLModal44').find('.max_minor44').val(minorMax);
        dis.closest('.AQLModal44').find('.aql_normal_letter44').val(letter);
        dis.closest('.AQLModal44').find('.aql_special_letter44').val(special_letter);
        dis.closest('.AQLModal44').find('.aql_normal_sampsize44').val(sampsize);
        dis.closest('.AQLModal44').find('.aql_special_sampsize44').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level44', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal44').find('.aql_qty44').val();
        var minor = dis.closest('.AQLModal44').find('.aql_minor44').val();
        var major = dis.closest('.AQLModal44').find('.aql_major44').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal44').find('.max_major44').val(majorMax);
        dis.closest('.AQLModal44').find('.max_minor44').val(minorMax);
        dis.closest('.AQLModal44').find('.aql_normal_letter44').val(letter);
        dis.closest('.AQLModal44').find('.aql_normal_sampsize44').val(sampsize);
    })

    $('body').on('change', '.aql_special_level44', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal44').find('.aql_qty44').val();
        var minor = dis.closest('.AQLModal44').find('.aql_minor44').val();
        var major = dis.closest('.AQLModal44').find('.aql_major44').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal44').find('.aql_special_letter44').val(letter);
        dis.closest('.AQLModal44').find('.aql_special_sampsize44').val(sampsize);
    })

    $('body').on('change', '.aql_major44', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal44').find('.aql_qty44').val();
        var minor = dis.closest('.AQLModal44').find('.aql_minor44').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal44').find('.aql_normal_level44').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal44').find('.max_major44').val(majorMax);
        dis.closest('.AQLModal44').find('.max_minor44').val(minorMax);
        dis.closest('.AQLModal44').find('.aql_normal_letter44').val(letter);
        dis.closest('.AQLModal44').find('.aql_normal_sampsize44').val(sampsize);
    })

    $('body').on('change', '.aql_minor44', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal44').find('.aql_qty44').val();
        var major = dis.closest('.AQLModal44').find('.aql_major44').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal44').find('.aql_normal_level44').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal44').find('.max_major44').val(majorMax);
        dis.closest('.AQLModal44').find('.max_minor44').val(minorMax);
        dis.closest('.AQLModal44').find('.aql_normal_letter44').val(letter);
        dis.closest('.AQLModal44').find('.aql_normal_sampsize44').val(sampsize);
    })

    $('body').on('click', '.confirmAQL44', function() {
        var dis = $(this);
        dis.closest('.part44').find('.main_part_qty44').val(dis.closest('.part44').find('.aql_qty44').val());
        dis.closest('.part44').find('#samples_unit44').val(dis.closest('.part44').find('.aql_normal_sampsize44').val());
        dis.closest('.part44').find('.AQLModal44').modal('hide');

    });

    $('.aql_select44').append('<option value="">--</option>');
    $('.aql_select44').append('<option value="0.065">0.065</option>');
    $('.aql_select44').append('<option value="0.10">0.10</option>');
    $('.aql_select44').append('<option value="0.15">0.15</option>');
    $('.aql_select44').append('<option value="0.25">0.25</option>');
    $('.aql_select44').append('<option value="0.4">0.4</option>');
    $('.aql_select44').append('<option value="0.65">0.65</option>');
    $('.aql_select44').append('<option value="1">1.0</option>');
    $('.aql_select44').append('<option value="1.5">1.5</option>');
    $('.aql_select44').append('<option value="2.5">2.5</option>');
    $('.aql_select44').append('<option value="4">4.0</option>');
    $('.aql_select44').append('<option value="6.5">6.5</option>');
    $('.aql_select44').append('<option value="10">10.0</option>');
    $('.aql_select44').append('<option value="N/A">N/A</option>');

    //45
    $('body').on('click', '.btn-main_part_qty-modal45', function() {
        jQuery.noConflict();
        $('.AQLModal45').modal('show');
    });

    $('body').on('keyup', '.aql_qty45', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal45').find('.aql_minor45').val();
        var major = dis.closest('.AQLModal45').find('.aql_major45').val();
        var lvl = dis.closest('.AQLModal45').find('.aql_normal_level45').val();
        var special_lvl = dis.closest('.AQLModal45').find('.aql_special_level45').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal45').find('.max_major45').val(majorMax);
        dis.closest('.AQLModal45').find('.max_minor45').val(minorMax);
        dis.closest('.AQLModal45').find('.aql_normal_letter45').val(letter);
        dis.closest('.AQLModal45').find('.aql_special_letter45').val(special_letter);
        dis.closest('.AQLModal45').find('.aql_normal_sampsize45').val(sampsize);
        dis.closest('.AQLModal45').find('.aql_special_sampsize45').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level45', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal45').find('.aql_qty45').val();
        var minor = dis.closest('.AQLModal45').find('.aql_minor45').val();
        var major = dis.closest('.AQLModal45').find('.aql_major45').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal45').find('.max_major45').val(majorMax);
        dis.closest('.AQLModal45').find('.max_minor45').val(minorMax);
        dis.closest('.AQLModal45').find('.aql_normal_letter45').val(letter);
        dis.closest('.AQLModal45').find('.aql_normal_sampsize45').val(sampsize);
    })

    $('body').on('change', '.aql_special_level45', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal45').find('.aql_qty45').val();
        var minor = dis.closest('.AQLModal45').find('.aql_minor45').val();
        var major = dis.closest('.AQLModal45').find('.aql_major45').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal45').find('.aql_special_letter45').val(letter);
        dis.closest('.AQLModal45').find('.aql_special_sampsize45').val(sampsize);
    })

    $('body').on('change', '.aql_major45', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal45').find('.aql_qty45').val();
        var minor = dis.closest('.AQLModal45').find('.aql_minor45').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal45').find('.aql_normal_level45').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal45').find('.max_major45').val(majorMax);
        dis.closest('.AQLModal45').find('.max_minor45').val(minorMax);
        dis.closest('.AQLModal45').find('.aql_normal_letter45').val(letter);
        dis.closest('.AQLModal45').find('.aql_normal_sampsize45').val(sampsize);
    })

    $('body').on('change', '.aql_minor45', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal45').find('.aql_qty45').val();
        var major = dis.closest('.AQLModal45').find('.aql_major45').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal45').find('.aql_normal_level45').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal45').find('.max_major45').val(majorMax);
        dis.closest('.AQLModal45').find('.max_minor45').val(minorMax);
        dis.closest('.AQLModal45').find('.aql_normal_letter45').val(letter);
        dis.closest('.AQLModal45').find('.aql_normal_sampsize45').val(sampsize);
    })

    $('body').on('click', '.confirmAQL45', function() {
        var dis = $(this);
        dis.closest('.part45').find('.main_part_qty45').val(dis.closest('.part45').find('.aql_qty45').val());
        dis.closest('.part45').find('#samples_unit45').val(dis.closest('.part45').find('.aql_normal_sampsize45').val());
        dis.closest('.part45').find('.AQLModal45').modal('hide');

    });

    $('.aql_select45').append('<option value="">--</option>');
    $('.aql_select45').append('<option value="0.065">0.065</option>');
    $('.aql_select45').append('<option value="0.10">0.10</option>');
    $('.aql_select45').append('<option value="0.15">0.15</option>');
    $('.aql_select45').append('<option value="0.25">0.25</option>');
    $('.aql_select45').append('<option value="0.4">0.4</option>');
    $('.aql_select45').append('<option value="0.65">0.65</option>');
    $('.aql_select45').append('<option value="1">1.0</option>');
    $('.aql_select45').append('<option value="1.5">1.5</option>');
    $('.aql_select45').append('<option value="2.5">2.5</option>');
    $('.aql_select45').append('<option value="4">4.0</option>');
    $('.aql_select45').append('<option value="6.5">6.5</option>');
    $('.aql_select45').append('<option value="10">10.0</option>');
    $('.aql_select45').append('<option value="N/A">N/A</option>');

    //46
    $('body').on('click', '.btn-main_part_qty-modal46', function() {
        jQuery.noConflict();
        $('.AQLModal46').modal('show');
    });

    $('body').on('keyup', '.aql_qty46', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal46').find('.aql_minor46').val();
        var major = dis.closest('.AQLModal46').find('.aql_major46').val();
        var lvl = dis.closest('.AQLModal46').find('.aql_normal_level46').val();
        var special_lvl = dis.closest('.AQLModal46').find('.aql_special_level46').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal46').find('.max_major46').val(majorMax);
        dis.closest('.AQLModal46').find('.max_minor46').val(minorMax);
        dis.closest('.AQLModal46').find('.aql_normal_letter46').val(letter);
        dis.closest('.AQLModal46').find('.aql_special_letter46').val(special_letter);
        dis.closest('.AQLModal46').find('.aql_normal_sampsize46').val(sampsize);
        dis.closest('.AQLModal46').find('.aql_special_sampsize46').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level46', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal46').find('.aql_qty46').val();
        var minor = dis.closest('.AQLModal46').find('.aql_minor46').val();
        var major = dis.closest('.AQLModal46').find('.aql_major46').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal46').find('.max_major46').val(majorMax);
        dis.closest('.AQLModal46').find('.max_minor46').val(minorMax);
        dis.closest('.AQLModal46').find('.aql_normal_letter46').val(letter);
        dis.closest('.AQLModal46').find('.aql_normal_sampsize46').val(sampsize);
    })

    $('body').on('change', '.aql_special_level46', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal46').find('.aql_qty46').val();
        var minor = dis.closest('.AQLModal46').find('.aql_minor46').val();
        var major = dis.closest('.AQLModal46').find('.aql_major46').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal46').find('.aql_special_letter46').val(letter);
        dis.closest('.AQLModal46').find('.aql_special_sampsize46').val(sampsize);
    })

    $('body').on('change', '.aql_major46', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal46').find('.aql_qty46').val();
        var minor = dis.closest('.AQLModal46').find('.aql_minor46').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal46').find('.aql_normal_level46').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal46').find('.max_major46').val(majorMax);
        dis.closest('.AQLModal46').find('.max_minor46').val(minorMax);
        dis.closest('.AQLModal46').find('.aql_normal_letter46').val(letter);
        dis.closest('.AQLModal46').find('.aql_normal_sampsize46').val(sampsize);
    })

    $('body').on('change', '.aql_minor46', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal46').find('.aql_qty46').val();
        var major = dis.closest('.AQLModal46').find('.aql_major46').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal46').find('.aql_normal_level46').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal46').find('.max_major46').val(majorMax);
        dis.closest('.AQLModal46').find('.max_minor46').val(minorMax);
        dis.closest('.AQLModal46').find('.aql_normal_letter46').val(letter);
        dis.closest('.AQLModal46').find('.aql_normal_sampsize46').val(sampsize);
    })

    $('body').on('click', '.confirmAQL46', function() {
        var dis = $(this);
        dis.closest('.part46').find('.main_part_qty46').val(dis.closest('.part46').find('.aql_qty46').val());
        dis.closest('.part46').find('#samples_unit46').val(dis.closest('.part46').find('.aql_normal_sampsize46').val());
        dis.closest('.part46').find('.AQLModal46').modal('hide');

    });

    $('.aql_select46').append('<option value="">--</option>');
    $('.aql_select46').append('<option value="0.065">0.065</option>');
    $('.aql_select46').append('<option value="0.10">0.10</option>');
    $('.aql_select46').append('<option value="0.15">0.15</option>');
    $('.aql_select46').append('<option value="0.25">0.25</option>');
    $('.aql_select46').append('<option value="0.4">0.4</option>');
    $('.aql_select46').append('<option value="0.65">0.65</option>');
    $('.aql_select46').append('<option value="1">1.0</option>');
    $('.aql_select46').append('<option value="1.5">1.5</option>');
    $('.aql_select46').append('<option value="2.5">2.5</option>');
    $('.aql_select46').append('<option value="4">4.0</option>');
    $('.aql_select46').append('<option value="6.5">6.5</option>');
    $('.aql_select46').append('<option value="10">10.0</option>');
    $('.aql_select46').append('<option value="N/A">N/A</option>');

    //47
    $('body').on('click', '.btn-main_part_qty-modal47', function() {
        jQuery.noConflict();
        $('.AQLModal47').modal('show');
    });

    $('body').on('keyup', '.aql_qty47', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal47').find('.aql_minor47').val();
        var major = dis.closest('.AQLModal47').find('.aql_major47').val();
        var lvl = dis.closest('.AQLModal47').find('.aql_normal_level47').val();
        var special_lvl = dis.closest('.AQLModal47').find('.aql_special_level47').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal47').find('.max_major47').val(majorMax);
        dis.closest('.AQLModal47').find('.max_minor47').val(minorMax);
        dis.closest('.AQLModal47').find('.aql_normal_letter47').val(letter);
        dis.closest('.AQLModal47').find('.aql_special_letter47').val(special_letter);
        dis.closest('.AQLModal47').find('.aql_normal_sampsize47').val(sampsize);
        dis.closest('.AQLModal47').find('.aql_special_sampsize47').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level47', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal47').find('.aql_qty47').val();
        var minor = dis.closest('.AQLModal47').find('.aql_minor47').val();
        var major = dis.closest('.AQLModal47').find('.aql_major47').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal47').find('.max_major47').val(majorMax);
        dis.closest('.AQLModal47').find('.max_minor47').val(minorMax);
        dis.closest('.AQLModal47').find('.aql_normal_letter47').val(letter);
        dis.closest('.AQLModal47').find('.aql_normal_sampsize47').val(sampsize);
    })

    $('body').on('change', '.aql_special_level47', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal47').find('.aql_qty47').val();
        var minor = dis.closest('.AQLModal47').find('.aql_minor47').val();
        var major = dis.closest('.AQLModal47').find('.aql_major47').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal47').find('.aql_special_letter47').val(letter);
        dis.closest('.AQLModal47').find('.aql_special_sampsize47').val(sampsize);
    })

    $('body').on('change', '.aql_major47', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal47').find('.aql_qty47').val();
        var minor = dis.closest('.AQLModal47').find('.aql_minor47').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal47').find('.aql_normal_level47').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal47').find('.max_major47').val(majorMax);
        dis.closest('.AQLModal47').find('.max_minor47').val(minorMax);
        dis.closest('.AQLModal47').find('.aql_normal_letter47').val(letter);
        dis.closest('.AQLModal47').find('.aql_normal_sampsize47').val(sampsize);
    })

    $('body').on('change', '.aql_minor47', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal47').find('.aql_qty47').val();
        var major = dis.closest('.AQLModal47').find('.aql_major47').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal47').find('.aql_normal_level47').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal47').find('.max_major47').val(majorMax);
        dis.closest('.AQLModal47').find('.max_minor47').val(minorMax);
        dis.closest('.AQLModal47').find('.aql_normal_letter47').val(letter);
        dis.closest('.AQLModal47').find('.aql_normal_sampsize47').val(sampsize);
    })

    $('body').on('click', '.confirmAQL47', function() {
        var dis = $(this);
        dis.closest('.part47').find('.main_part_qty47').val(dis.closest('.part47').find('.aql_qty47').val());
        dis.closest('.part47').find('#samples_unit47').val(dis.closest('.part47').find('.aql_normal_sampsize47').val());
        dis.closest('.part47').find('.AQLModal47').modal('hide');

    });

    $('.aql_select47').append('<option value="">--</option>');
    $('.aql_select47').append('<option value="0.065">0.065</option>');
    $('.aql_select47').append('<option value="0.10">0.10</option>');
    $('.aql_select47').append('<option value="0.15">0.15</option>');
    $('.aql_select47').append('<option value="0.25">0.25</option>');
    $('.aql_select47').append('<option value="0.4">0.4</option>');
    $('.aql_select47').append('<option value="0.65">0.65</option>');
    $('.aql_select47').append('<option value="1">1.0</option>');
    $('.aql_select47').append('<option value="1.5">1.5</option>');
    $('.aql_select47').append('<option value="2.5">2.5</option>');
    $('.aql_select47').append('<option value="4">4.0</option>');
    $('.aql_select47').append('<option value="6.5">6.5</option>');
    $('.aql_select47').append('<option value="10">10.0</option>');
    $('.aql_select47').append('<option value="N/A">N/A</option>');

    //48
    $('body').on('click', '.btn-main_part_qty-modal48', function() {
        jQuery.noConflict();
        $('.AQLModal48').modal('show');
    });

    $('body').on('keyup', '.aql_qty48', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal48').find('.aql_minor48').val();
        var major = dis.closest('.AQLModal48').find('.aql_major48').val();
        var lvl = dis.closest('.AQLModal48').find('.aql_normal_level48').val();
        var special_lvl = dis.closest('.AQLModal48').find('.aql_special_level48').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal48').find('.max_major48').val(majorMax);
        dis.closest('.AQLModal48').find('.max_minor48').val(minorMax);
        dis.closest('.AQLModal48').find('.aql_normal_letter48').val(letter);
        dis.closest('.AQLModal48').find('.aql_special_letter48').val(special_letter);
        dis.closest('.AQLModal48').find('.aql_normal_sampsize48').val(sampsize);
        dis.closest('.AQLModal48').find('.aql_special_sampsize48').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level48', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal48').find('.aql_qty48').val();
        var minor = dis.closest('.AQLModal48').find('.aql_minor48').val();
        var major = dis.closest('.AQLModal48').find('.aql_major48').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal48').find('.max_major48').val(majorMax);
        dis.closest('.AQLModal48').find('.max_minor48').val(minorMax);
        dis.closest('.AQLModal48').find('.aql_normal_letter48').val(letter);
        dis.closest('.AQLModal48').find('.aql_normal_sampsize48').val(sampsize);
    })

    $('body').on('change', '.aql_special_level48', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal48').find('.aql_qty48').val();
        var minor = dis.closest('.AQLModal48').find('.aql_minor48').val();
        var major = dis.closest('.AQLModal48').find('.aql_major48').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal48').find('.aql_special_letter48').val(letter);
        dis.closest('.AQLModal48').find('.aql_special_sampsize48').val(sampsize);
    })

    $('body').on('change', '.aql_major48', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal48').find('.aql_qty48').val();
        var minor = dis.closest('.AQLModal48').find('.aql_minor48').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal48').find('.aql_normal_level48').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal48').find('.max_major48').val(majorMax);
        dis.closest('.AQLModal48').find('.max_minor48').val(minorMax);
        dis.closest('.AQLModal48').find('.aql_normal_letter48').val(letter);
        dis.closest('.AQLModal48').find('.aql_normal_sampsize48').val(sampsize);
    })

    $('body').on('change', '.aql_minor48', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal48').find('.aql_qty48').val();
        var major = dis.closest('.AQLModal48').find('.aql_major48').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal48').find('.aql_normal_level48').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal48').find('.max_major48').val(majorMax);
        dis.closest('.AQLModal48').find('.max_minor48').val(minorMax);
        dis.closest('.AQLModal48').find('.aql_normal_letter48').val(letter);
        dis.closest('.AQLModal48').find('.aql_normal_sampsize48').val(sampsize);
    })

    $('body').on('click', '.confirmAQL48', function() {
        var dis = $(this);
        dis.closest('.part48').find('.main_part_qty48').val(dis.closest('.part48').find('.aql_qty48').val());
        dis.closest('.part48').find('#samples_unit48').val(dis.closest('.part48').find('.aql_normal_sampsize48').val());
        dis.closest('.part48').find('.AQLModal48').modal('hide');

    });

    $('.aql_select48').append('<option value="">--</option>');
    $('.aql_select48').append('<option value="0.065">0.065</option>');
    $('.aql_select48').append('<option value="0.10">0.10</option>');
    $('.aql_select48').append('<option value="0.15">0.15</option>');
    $('.aql_select48').append('<option value="0.25">0.25</option>');
    $('.aql_select48').append('<option value="0.4">0.4</option>');
    $('.aql_select48').append('<option value="0.65">0.65</option>');
    $('.aql_select48').append('<option value="1">1.0</option>');
    $('.aql_select48').append('<option value="1.5">1.5</option>');
    $('.aql_select48').append('<option value="2.5">2.5</option>');
    $('.aql_select48').append('<option value="4">4.0</option>');
    $('.aql_select48').append('<option value="6.5">6.5</option>');
    $('.aql_select48').append('<option value="10">10.0</option>');
    $('.aql_select48').append('<option value="N/A">N/A</option>');

    //49
    $('body').on('click', '.btn-main_part_qty-modal49', function() {
        jQuery.noConflict();
        $('.AQLModal49').modal('show');
    });

    $('body').on('keyup', '.aql_qty49', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal49').find('.aql_minor49').val();
        var major = dis.closest('.AQLModal49').find('.aql_major49').val();
        var lvl = dis.closest('.AQLModal49').find('.aql_normal_level49').val();
        var special_lvl = dis.closest('.AQLModal49').find('.aql_special_level49').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal49').find('.max_major49').val(majorMax);
        dis.closest('.AQLModal49').find('.max_minor49').val(minorMax);
        dis.closest('.AQLModal49').find('.aql_normal_letter49').val(letter);
        dis.closest('.AQLModal49').find('.aql_special_letter49').val(special_letter);
        dis.closest('.AQLModal49').find('.aql_normal_sampsize49').val(sampsize);
        dis.closest('.AQLModal49').find('.aql_special_sampsize49').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level49', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal49').find('.aql_qty49').val();
        var minor = dis.closest('.AQLModal49').find('.aql_minor49').val();
        var major = dis.closest('.AQLModal49').find('.aql_major49').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal49').find('.max_major49').val(majorMax);
        dis.closest('.AQLModal49').find('.max_minor49').val(minorMax);
        dis.closest('.AQLModal49').find('.aql_normal_letter49').val(letter);
        dis.closest('.AQLModal49').find('.aql_normal_sampsize49').val(sampsize);
    })

    $('body').on('change', '.aql_special_level49', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal49').find('.aql_qty49').val();
        var minor = dis.closest('.AQLModal49').find('.aql_minor49').val();
        var major = dis.closest('.AQLModal49').find('.aql_major49').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal49').find('.aql_special_letter49').val(letter);
        dis.closest('.AQLModal49').find('.aql_special_sampsize49').val(sampsize);
    })

    $('body').on('change', '.aql_major49', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal49').find('.aql_qty49').val();
        var minor = dis.closest('.AQLModal49').find('.aql_minor49').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal49').find('.aql_normal_level49').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal49').find('.max_major49').val(majorMax);
        dis.closest('.AQLModal49').find('.max_minor49').val(minorMax);
        dis.closest('.AQLModal49').find('.aql_normal_letter49').val(letter);
        dis.closest('.AQLModal49').find('.aql_normal_sampsize49').val(sampsize);
    })

    $('body').on('change', '.aql_minor49', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal49').find('.aql_qty49').val();
        var major = dis.closest('.AQLModal49').find('.aql_major49').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal49').find('.aql_normal_level49').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal49').find('.max_major49').val(majorMax);
        dis.closest('.AQLModal49').find('.max_minor49').val(minorMax);
        dis.closest('.AQLModal49').find('.aql_normal_letter49').val(letter);
        dis.closest('.AQLModal49').find('.aql_normal_sampsize49').val(sampsize);
    })

    $('body').on('click', '.confirmAQL49', function() {
        var dis = $(this);
        dis.closest('.part49').find('.main_part_qty49').val(dis.closest('.part49').find('.aql_qty49').val());
        dis.closest('.part49').find('#samples_unit49').val(dis.closest('.part49').find('.aql_normal_sampsize49').val());
        dis.closest('.part49').find('.AQLModal49').modal('hide');

    });

    $('.aql_select49').append('<option value="">--</option>');
    $('.aql_select49').append('<option value="0.065">0.065</option>');
    $('.aql_select49').append('<option value="0.10">0.10</option>');
    $('.aql_select49').append('<option value="0.15">0.15</option>');
    $('.aql_select49').append('<option value="0.25">0.25</option>');
    $('.aql_select49').append('<option value="0.4">0.4</option>');
    $('.aql_select49').append('<option value="0.65">0.65</option>');
    $('.aql_select49').append('<option value="1">1.0</option>');
    $('.aql_select49').append('<option value="1.5">1.5</option>');
    $('.aql_select49').append('<option value="2.5">2.5</option>');
    $('.aql_select49').append('<option value="4">4.0</option>');
    $('.aql_select49').append('<option value="6.5">6.5</option>');
    $('.aql_select49').append('<option value="10">10.0</option>');
    $('.aql_select49').append('<option value="N/A">N/A</option>');

    //50
    $('body').on('click', '.btn-main_part_qty-modal50', function() {
        jQuery.noConflict();
        $('.AQLModal50').modal('show');
    });

    $('body').on('keyup', '.aql_qty50', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal50').find('.aql_minor50').val();
        var major = dis.closest('.AQLModal50').find('.aql_major50').val();
        var lvl = dis.closest('.AQLModal50').find('.aql_normal_level50').val();
        var special_lvl = dis.closest('.AQLModal50').find('.aql_special_level50').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal50').find('.max_major50').val(majorMax);
        dis.closest('.AQLModal50').find('.max_minor50').val(minorMax);
        dis.closest('.AQLModal50').find('.aql_normal_letter50').val(letter);
        dis.closest('.AQLModal50').find('.aql_special_letter50').val(special_letter);
        dis.closest('.AQLModal50').find('.aql_normal_sampsize50').val(sampsize);
        dis.closest('.AQLModal50').find('.aql_special_sampsize50').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level50', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal50').find('.aql_qty50').val();
        var minor = dis.closest('.AQLModal50').find('.aql_minor50').val();
        var major = dis.closest('.AQLModal50').find('.aql_major50').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal50').find('.max_major50').val(majorMax);
        dis.closest('.AQLModal50').find('.max_minor50').val(minorMax);
        dis.closest('.AQLModal50').find('.aql_normal_letter50').val(letter);
        dis.closest('.AQLModal50').find('.aql_normal_sampsize50').val(sampsize);
    })

    $('body').on('change', '.aql_special_level50', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal50').find('.aql_qty50').val();
        var minor = dis.closest('.AQLModal50').find('.aql_minor50').val();
        var major = dis.closest('.AQLModal50').find('.aql_major50').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal50').find('.aql_special_letter50').val(letter);
        dis.closest('.AQLModal50').find('.aql_special_sampsize50').val(sampsize);
    })

    $('body').on('change', '.aql_major50', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal50').find('.aql_qty50').val();
        var minor = dis.closest('.AQLModal50').find('.aql_minor50').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal50').find('.aql_normal_level50').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal50').find('.max_major50').val(majorMax);
        dis.closest('.AQLModal50').find('.max_minor50').val(minorMax);
        dis.closest('.AQLModal50').find('.aql_normal_letter50').val(letter);
        dis.closest('.AQLModal50').find('.aql_normal_sampsize50').val(sampsize);
    })

    $('body').on('change', '.aql_minor50', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal50').find('.aql_qty50').val();
        var major = dis.closest('.AQLModal50').find('.aql_major50').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal50').find('.aql_normal_level50').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal50').find('.max_major50').val(majorMax);
        dis.closest('.AQLModal50').find('.max_minor50').val(minorMax);
        dis.closest('.AQLModal50').find('.aql_normal_letter50').val(letter);
        dis.closest('.AQLModal50').find('.aql_normal_sampsize50').val(sampsize);
    })

    $('body').on('click', '.confirmAQL50', function() {
        var dis = $(this);
        dis.closest('.part50').find('.main_part_qty50').val(dis.closest('.part50').find('.aql_qty50').val());
        dis.closest('.part50').find('#samples_unit50').val(dis.closest('.part50').find('.aql_normal_sampsize50').val());
        dis.closest('.part50').find('.AQLModal50').modal('hide');

    });

    $('.aql_select50').append('<option value="">--</option>');
    $('.aql_select50').append('<option value="0.065">0.065</option>');
    $('.aql_select50').append('<option value="0.10">0.10</option>');
    $('.aql_select50').append('<option value="0.15">0.15</option>');
    $('.aql_select50').append('<option value="0.25">0.25</option>');
    $('.aql_select50').append('<option value="0.4">0.4</option>');
    $('.aql_select50').append('<option value="0.65">0.65</option>');
    $('.aql_select50').append('<option value="1">1.0</option>');
    $('.aql_select50').append('<option value="1.5">1.5</option>');
    $('.aql_select50').append('<option value="2.5">2.5</option>');
    $('.aql_select50').append('<option value="4">4.0</option>');
    $('.aql_select50').append('<option value="6.5">6.5</option>');
    $('.aql_select50').append('<option value="10">10.0</option>');
    $('.aql_select50').append('<option value="N/A">N/A</option>');

    //51
    $('body').on('click', '.btn-main_part_qty-modal51', function() {
        jQuery.noConflict();
        $('.AQLModal51').modal('show');
    });

    $('body').on('keyup', '.aql_qty51', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal51').find('.aql_minor51').val();
        var major = dis.closest('.AQLModal51').find('.aql_major51').val();
        var lvl = dis.closest('.AQLModal51').find('.aql_normal_level51').val();
        var special_lvl = dis.closest('.AQLModal51').find('.aql_special_level51').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal51').find('.max_major51').val(majorMax);
        dis.closest('.AQLModal51').find('.max_minor51').val(minorMax);
        dis.closest('.AQLModal51').find('.aql_normal_letter51').val(letter);
        dis.closest('.AQLModal51').find('.aql_special_letter51').val(special_letter);
        dis.closest('.AQLModal51').find('.aql_normal_sampsize51').val(sampsize);
        dis.closest('.AQLModal51').find('.aql_special_sampsize51').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level51', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal51').find('.aql_qty51').val();
        var minor = dis.closest('.AQLModal51').find('.aql_minor51').val();
        var major = dis.closest('.AQLModal51').find('.aql_major51').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal51').find('.max_major51').val(majorMax);
        dis.closest('.AQLModal51').find('.max_minor51').val(minorMax);
        dis.closest('.AQLModal51').find('.aql_normal_letter51').val(letter);
        dis.closest('.AQLModal51').find('.aql_normal_sampsize51').val(sampsize);
    })

    $('body').on('change', '.aql_special_level51', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal51').find('.aql_qty51').val();
        var minor = dis.closest('.AQLModal51').find('.aql_minor51').val();
        var major = dis.closest('.AQLModal51').find('.aql_major51').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal51').find('.aql_special_letter51').val(letter);
        dis.closest('.AQLModal51').find('.aql_special_sampsize51').val(sampsize);
    })

    $('body').on('change', '.aql_major51', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal51').find('.aql_qty51').val();
        var minor = dis.closest('.AQLModal51').find('.aql_minor51').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal51').find('.aql_normal_level51').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal51').find('.max_major51').val(majorMax);
        dis.closest('.AQLModal51').find('.max_minor51').val(minorMax);
        dis.closest('.AQLModal51').find('.aql_normal_letter51').val(letter);
        dis.closest('.AQLModal51').find('.aql_normal_sampsize51').val(sampsize);
    })

    $('body').on('change', '.aql_minor51', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal51').find('.aql_qty51').val();
        var major = dis.closest('.AQLModal51').find('.aql_major51').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal51').find('.aql_normal_level51').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal51').find('.max_major51').val(majorMax);
        dis.closest('.AQLModal51').find('.max_minor51').val(minorMax);
        dis.closest('.AQLModal51').find('.aql_normal_letter51').val(letter);
        dis.closest('.AQLModal51').find('.aql_normal_sampsize51').val(sampsize);
    })

    $('body').on('click', '.confirmAQL51', function() {
        var dis = $(this);
        dis.closest('.part51').find('.main_part_qty51').val(dis.closest('.part51').find('.aql_qty51').val());
        dis.closest('.part51').find('#samples_unit51').val(dis.closest('.part51').find('.aql_normal_sampsize51').val());
        dis.closest('.part51').find('.AQLModal51').modal('hide');

    });

    $('.aql_select51').append('<option value="">--</option>');
    $('.aql_select51').append('<option value="0.065">0.065</option>');
    $('.aql_select51').append('<option value="0.10">0.10</option>');
    $('.aql_select51').append('<option value="0.15">0.15</option>');
    $('.aql_select51').append('<option value="0.25">0.25</option>');
    $('.aql_select51').append('<option value="0.4">0.4</option>');
    $('.aql_select51').append('<option value="0.65">0.65</option>');
    $('.aql_select51').append('<option value="1">1.0</option>');
    $('.aql_select51').append('<option value="1.5">1.5</option>');
    $('.aql_select51').append('<option value="2.5">2.5</option>');
    $('.aql_select51').append('<option value="4">4.0</option>');
    $('.aql_select51').append('<option value="6.5">6.5</option>');
    $('.aql_select51').append('<option value="10">10.0</option>');
    $('.aql_select51').append('<option value="N/A">N/A</option>');

    //52
    $('body').on('click', '.btn-main_part_qty-modal52', function() {
        jQuery.noConflict();
        $('.AQLModal52').modal('show');
    });

    $('body').on('keyup', '.aql_qty52', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal52').find('.aql_minor52').val();
        var major = dis.closest('.AQLModal52').find('.aql_major52').val();
        var lvl = dis.closest('.AQLModal52').find('.aql_normal_level52').val();
        var special_lvl = dis.closest('.AQLModal52').find('.aql_special_level52').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal52').find('.max_major52').val(majorMax);
        dis.closest('.AQLModal52').find('.max_minor52').val(minorMax);
        dis.closest('.AQLModal52').find('.aql_normal_letter52').val(letter);
        dis.closest('.AQLModal52').find('.aql_special_letter52').val(special_letter);
        dis.closest('.AQLModal52').find('.aql_normal_sampsize52').val(sampsize);
        dis.closest('.AQLModal52').find('.aql_special_sampsize52').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level52', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal52').find('.aql_qty52').val();
        var minor = dis.closest('.AQLModal52').find('.aql_minor52').val();
        var major = dis.closest('.AQLModal52').find('.aql_major52').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal52').find('.max_major52').val(majorMax);
        dis.closest('.AQLModal52').find('.max_minor52').val(minorMax);
        dis.closest('.AQLModal52').find('.aql_normal_letter52').val(letter);
        dis.closest('.AQLModal52').find('.aql_normal_sampsize52').val(sampsize);
    })

    $('body').on('change', '.aql_special_level52', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal52').find('.aql_qty52').val();
        var minor = dis.closest('.AQLModal52').find('.aql_minor52').val();
        var major = dis.closest('.AQLModal52').find('.aql_major52').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal52').find('.aql_special_letter52').val(letter);
        dis.closest('.AQLModal52').find('.aql_special_sampsize52').val(sampsize);
    })

    $('body').on('change', '.aql_major52', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal52').find('.aql_qty52').val();
        var minor = dis.closest('.AQLModal52').find('.aql_minor52').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal52').find('.aql_normal_level52').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal52').find('.max_major52').val(majorMax);
        dis.closest('.AQLModal52').find('.max_minor52').val(minorMax);
        dis.closest('.AQLModal52').find('.aql_normal_letter52').val(letter);
        dis.closest('.AQLModal52').find('.aql_normal_sampsize52').val(sampsize);
    })

    $('body').on('change', '.aql_minor52', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal52').find('.aql_qty52').val();
        var major = dis.closest('.AQLModal52').find('.aql_major52').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal52').find('.aql_normal_level52').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal52').find('.max_major52').val(majorMax);
        dis.closest('.AQLModal52').find('.max_minor52').val(minorMax);
        dis.closest('.AQLModal52').find('.aql_normal_letter52').val(letter);
        dis.closest('.AQLModal52').find('.aql_normal_sampsize52').val(sampsize);
    })

    $('body').on('click', '.confirmAQL52', function() {
        var dis = $(this);
        dis.closest('.part52').find('.main_part_qty52').val(dis.closest('.part52').find('.aql_qty52').val());
        dis.closest('.part52').find('#samples_unit52').val(dis.closest('.part52').find('.aql_normal_sampsize52').val());
        dis.closest('.part52').find('.AQLModal52').modal('hide');

    });

    $('.aql_select52').append('<option value="">--</option>');
    $('.aql_select52').append('<option value="0.065">0.065</option>');
    $('.aql_select52').append('<option value="0.10">0.10</option>');
    $('.aql_select52').append('<option value="0.15">0.15</option>');
    $('.aql_select52').append('<option value="0.25">0.25</option>');
    $('.aql_select52').append('<option value="0.4">0.4</option>');
    $('.aql_select52').append('<option value="0.65">0.65</option>');
    $('.aql_select52').append('<option value="1">1.0</option>');
    $('.aql_select52').append('<option value="1.5">1.5</option>');
    $('.aql_select52').append('<option value="2.5">2.5</option>');
    $('.aql_select52').append('<option value="4">4.0</option>');
    $('.aql_select52').append('<option value="6.5">6.5</option>');
    $('.aql_select52').append('<option value="10">10.0</option>');
    $('.aql_select52').append('<option value="N/A">N/A</option>');

    //53
    $('body').on('click', '.btn-main_part_qty-modal53', function() {
        jQuery.noConflict();
        $('.AQLModal53').modal('show');
    });

    $('body').on('keyup', '.aql_qty53', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal53').find('.aql_minor53').val();
        var major = dis.closest('.AQLModal53').find('.aql_major53').val();
        var lvl = dis.closest('.AQLModal53').find('.aql_normal_level53').val();
        var special_lvl = dis.closest('.AQLModal53').find('.aql_special_level53').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal53').find('.max_major53').val(majorMax);
        dis.closest('.AQLModal53').find('.max_minor53').val(minorMax);
        dis.closest('.AQLModal53').find('.aql_normal_letter53').val(letter);
        dis.closest('.AQLModal53').find('.aql_special_letter53').val(special_letter);
        dis.closest('.AQLModal53').find('.aql_normal_sampsize53').val(sampsize);
        dis.closest('.AQLModal53').find('.aql_special_sampsize53').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level53', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal53').find('.aql_qty53').val();
        var minor = dis.closest('.AQLModal53').find('.aql_minor53').val();
        var major = dis.closest('.AQLModal53').find('.aql_major53').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal53').find('.max_major53').val(majorMax);
        dis.closest('.AQLModal53').find('.max_minor53').val(minorMax);
        dis.closest('.AQLModal53').find('.aql_normal_letter53').val(letter);
        dis.closest('.AQLModal53').find('.aql_normal_sampsize53').val(sampsize);
    })

    $('body').on('change', '.aql_special_level53', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal53').find('.aql_qty53').val();
        var minor = dis.closest('.AQLModal53').find('.aql_minor53').val();
        var major = dis.closest('.AQLModal53').find('.aql_major53').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal53').find('.aql_special_letter53').val(letter);
        dis.closest('.AQLModal53').find('.aql_special_sampsize53').val(sampsize);
    })

    $('body').on('change', '.aql_major53', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal53').find('.aql_qty53').val();
        var minor = dis.closest('.AQLModal53').find('.aql_minor53').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal53').find('.aql_normal_level53').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal53').find('.max_major53').val(majorMax);
        dis.closest('.AQLModal53').find('.max_minor53').val(minorMax);
        dis.closest('.AQLModal53').find('.aql_normal_letter53').val(letter);
        dis.closest('.AQLModal53').find('.aql_normal_sampsize53').val(sampsize);
    })

    $('body').on('change', '.aql_minor53', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal53').find('.aql_qty53').val();
        var major = dis.closest('.AQLModal53').find('.aql_major53').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal53').find('.aql_normal_level53').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal53').find('.max_major53').val(majorMax);
        dis.closest('.AQLModal53').find('.max_minor53').val(minorMax);
        dis.closest('.AQLModal53').find('.aql_normal_letter53').val(letter);
        dis.closest('.AQLModal53').find('.aql_normal_sampsize53').val(sampsize);
    })

    $('body').on('click', '.confirmAQL53', function() {
        var dis = $(this);
        dis.closest('.part53').find('.main_part_qty53').val(dis.closest('.part53').find('.aql_qty53').val());
        dis.closest('.part53').find('#samples_unit53').val(dis.closest('.part53').find('.aql_normal_sampsize53').val());
        dis.closest('.part53').find('.AQLModal53').modal('hide');

    });

    $('.aql_select53').append('<option value="">--</option>');
    $('.aql_select53').append('<option value="0.065">0.065</option>');
    $('.aql_select53').append('<option value="0.10">0.10</option>');
    $('.aql_select53').append('<option value="0.15">0.15</option>');
    $('.aql_select53').append('<option value="0.25">0.25</option>');
    $('.aql_select53').append('<option value="0.4">0.4</option>');
    $('.aql_select53').append('<option value="0.65">0.65</option>');
    $('.aql_select53').append('<option value="1">1.0</option>');
    $('.aql_select53').append('<option value="1.5">1.5</option>');
    $('.aql_select53').append('<option value="2.5">2.5</option>');
    $('.aql_select53').append('<option value="4">4.0</option>');
    $('.aql_select53').append('<option value="6.5">6.5</option>');
    $('.aql_select53').append('<option value="10">10.0</option>');
    $('.aql_select53').append('<option value="N/A">N/A</option>');

    //54
    $('body').on('click', '.btn-main_part_qty-modal54', function() {
        jQuery.noConflict();
        $('.AQLModal54').modal('show');
    });

    $('body').on('keyup', '.aql_qty54', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal54').find('.aql_minor54').val();
        var major = dis.closest('.AQLModal54').find('.aql_major54').val();
        var lvl = dis.closest('.AQLModal54').find('.aql_normal_level54').val();
        var special_lvl = dis.closest('.AQLModal54').find('.aql_special_level54').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal54').find('.max_major54').val(majorMax);
        dis.closest('.AQLModal54').find('.max_minor54').val(minorMax);
        dis.closest('.AQLModal54').find('.aql_normal_letter54').val(letter);
        dis.closest('.AQLModal54').find('.aql_special_letter54').val(special_letter);
        dis.closest('.AQLModal54').find('.aql_normal_sampsize54').val(sampsize);
        dis.closest('.AQLModal54').find('.aql_special_sampsize54').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level54', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal54').find('.aql_qty54').val();
        var minor = dis.closest('.AQLModal54').find('.aql_minor54').val();
        var major = dis.closest('.AQLModal54').find('.aql_major54').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal54').find('.max_major54').val(majorMax);
        dis.closest('.AQLModal54').find('.max_minor54').val(minorMax);
        dis.closest('.AQLModal54').find('.aql_normal_letter54').val(letter);
        dis.closest('.AQLModal54').find('.aql_normal_sampsize54').val(sampsize);
    })

    $('body').on('change', '.aql_special_level54', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal54').find('.aql_qty54').val();
        var minor = dis.closest('.AQLModal54').find('.aql_minor54').val();
        var major = dis.closest('.AQLModal54').find('.aql_major54').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal54').find('.aql_special_letter54').val(letter);
        dis.closest('.AQLModal54').find('.aql_special_sampsize54').val(sampsize);
    })

    $('body').on('change', '.aql_major54', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal54').find('.aql_qty54').val();
        var minor = dis.closest('.AQLModal54').find('.aql_minor54').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal54').find('.aql_normal_level54').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal54').find('.max_major54').val(majorMax);
        dis.closest('.AQLModal54').find('.max_minor54').val(minorMax);
        dis.closest('.AQLModal54').find('.aql_normal_letter54').val(letter);
        dis.closest('.AQLModal54').find('.aql_normal_sampsize54').val(sampsize);
    })

    $('body').on('change', '.aql_minor54', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal54').find('.aql_qty54').val();
        var major = dis.closest('.AQLModal54').find('.aql_major54').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal54').find('.aql_normal_level54').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal54').find('.max_major54').val(majorMax);
        dis.closest('.AQLModal54').find('.max_minor54').val(minorMax);
        dis.closest('.AQLModal54').find('.aql_normal_letter54').val(letter);
        dis.closest('.AQLModal54').find('.aql_normal_sampsize54').val(sampsize);
    })

    $('body').on('click', '.confirmAQL54', function() {
        var dis = $(this);
        dis.closest('.part54').find('.main_part_qty54').val(dis.closest('.part54').find('.aql_qty54').val());
        dis.closest('.part54').find('#samples_unit54').val(dis.closest('.part54').find('.aql_normal_sampsize54').val());
        dis.closest('.part54').find('.AQLModal54').modal('hide');

    });

    $('.aql_select54').append('<option value="">--</option>');
    $('.aql_select54').append('<option value="0.065">0.065</option>');
    $('.aql_select54').append('<option value="0.10">0.10</option>');
    $('.aql_select54').append('<option value="0.15">0.15</option>');
    $('.aql_select54').append('<option value="0.25">0.25</option>');
    $('.aql_select54').append('<option value="0.4">0.4</option>');
    $('.aql_select54').append('<option value="0.65">0.65</option>');
    $('.aql_select54').append('<option value="1">1.0</option>');
    $('.aql_select54').append('<option value="1.5">1.5</option>');
    $('.aql_select54').append('<option value="2.5">2.5</option>');
    $('.aql_select54').append('<option value="4">4.0</option>');
    $('.aql_select54').append('<option value="6.5">6.5</option>');
    $('.aql_select54').append('<option value="10">10.0</option>');
    $('.aql_select54').append('<option value="N/A">N/A</option>');

    //55
    $('body').on('click', '.btn-main_part_qty-modal55', function() {
        jQuery.noConflict();
        $('.AQLModal55').modal('show');
    });

    $('body').on('keyup', '.aql_qty55', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal55').find('.aql_minor55').val();
        var major = dis.closest('.AQLModal55').find('.aql_major55').val();
        var lvl = dis.closest('.AQLModal55').find('.aql_normal_level55').val();
        var special_lvl = dis.closest('.AQLModal55').find('.aql_special_level55').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal55').find('.max_major55').val(majorMax);
        dis.closest('.AQLModal55').find('.max_minor55').val(minorMax);
        dis.closest('.AQLModal55').find('.aql_normal_letter55').val(letter);
        dis.closest('.AQLModal55').find('.aql_special_letter55').val(special_letter);
        dis.closest('.AQLModal55').find('.aql_normal_sampsize55').val(sampsize);
        dis.closest('.AQLModal55').find('.aql_special_sampsize55').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level55', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal55').find('.aql_qty55').val();
        var minor = dis.closest('.AQLModal55').find('.aql_minor55').val();
        var major = dis.closest('.AQLModal55').find('.aql_major55').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal55').find('.max_major55').val(majorMax);
        dis.closest('.AQLModal55').find('.max_minor55').val(minorMax);
        dis.closest('.AQLModal55').find('.aql_normal_letter55').val(letter);
        dis.closest('.AQLModal55').find('.aql_normal_sampsize55').val(sampsize);
    })

    $('body').on('change', '.aql_special_level55', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal55').find('.aql_qty55').val();
        var minor = dis.closest('.AQLModal55').find('.aql_minor55').val();
        var major = dis.closest('.AQLModal55').find('.aql_major55').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal55').find('.aql_special_letter55').val(letter);
        dis.closest('.AQLModal55').find('.aql_special_sampsize55').val(sampsize);
    })

    $('body').on('change', '.aql_major55', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal55').find('.aql_qty55').val();
        var minor = dis.closest('.AQLModal55').find('.aql_minor55').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal55').find('.aql_normal_level55').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal55').find('.max_major55').val(majorMax);
        dis.closest('.AQLModal55').find('.max_minor55').val(minorMax);
        dis.closest('.AQLModal55').find('.aql_normal_letter55').val(letter);
        dis.closest('.AQLModal55').find('.aql_normal_sampsize55').val(sampsize);
    })

    $('body').on('change', '.aql_minor55', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal55').find('.aql_qty55').val();
        var major = dis.closest('.AQLModal55').find('.aql_major55').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal55').find('.aql_normal_level55').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal55').find('.max_major55').val(majorMax);
        dis.closest('.AQLModal55').find('.max_minor55').val(minorMax);
        dis.closest('.AQLModal55').find('.aql_normal_letter55').val(letter);
        dis.closest('.AQLModal55').find('.aql_normal_sampsize55').val(sampsize);
    })

    $('body').on('click', '.confirmAQL55', function() {
        var dis = $(this);
        dis.closest('.part55').find('.main_part_qty55').val(dis.closest('.part55').find('.aql_qty55').val());
        dis.closest('.part55').find('#samples_unit55').val(dis.closest('.part55').find('.aql_normal_sampsize55').val());
        dis.closest('.part55').find('.AQLModal55').modal('hide');

    });

    $('.aql_select55').append('<option value="">--</option>');
    $('.aql_select55').append('<option value="0.065">0.065</option>');
    $('.aql_select55').append('<option value="0.10">0.10</option>');
    $('.aql_select55').append('<option value="0.15">0.15</option>');
    $('.aql_select55').append('<option value="0.25">0.25</option>');
    $('.aql_select55').append('<option value="0.4">0.4</option>');
    $('.aql_select55').append('<option value="0.65">0.65</option>');
    $('.aql_select55').append('<option value="1">1.0</option>');
    $('.aql_select55').append('<option value="1.5">1.5</option>');
    $('.aql_select55').append('<option value="2.5">2.5</option>');
    $('.aql_select55').append('<option value="4">4.0</option>');
    $('.aql_select55').append('<option value="6.5">6.5</option>');
    $('.aql_select55').append('<option value="10">10.0</option>');
    $('.aql_select55').append('<option value="N/A">N/A</option>');

    //56
    $('body').on('click', '.btn-main_part_qty-modal56', function() {
        jQuery.noConflict();
        $('.AQLModal56').modal('show');
    });

    $('body').on('keyup', '.aql_qty56', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal56').find('.aql_minor56').val();
        var major = dis.closest('.AQLModal56').find('.aql_major56').val();
        var lvl = dis.closest('.AQLModal56').find('.aql_normal_level56').val();
        var special_lvl = dis.closest('.AQLModal56').find('.aql_special_level56').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal56').find('.max_major56').val(majorMax);
        dis.closest('.AQLModal56').find('.max_minor56').val(minorMax);
        dis.closest('.AQLModal56').find('.aql_normal_letter56').val(letter);
        dis.closest('.AQLModal56').find('.aql_special_letter56').val(special_letter);
        dis.closest('.AQLModal56').find('.aql_normal_sampsize56').val(sampsize);
        dis.closest('.AQLModal56').find('.aql_special_sampsize56').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level56', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal56').find('.aql_qty56').val();
        var minor = dis.closest('.AQLModal56').find('.aql_minor56').val();
        var major = dis.closest('.AQLModal56').find('.aql_major56').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal56').find('.max_major56').val(majorMax);
        dis.closest('.AQLModal56').find('.max_minor56').val(minorMax);
        dis.closest('.AQLModal56').find('.aql_normal_letter56').val(letter);
        dis.closest('.AQLModal56').find('.aql_normal_sampsize56').val(sampsize);
    })

    $('body').on('change', '.aql_special_level56', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal56').find('.aql_qty56').val();
        var minor = dis.closest('.AQLModal56').find('.aql_minor56').val();
        var major = dis.closest('.AQLModal56').find('.aql_major56').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal56').find('.aql_special_letter56').val(letter);
        dis.closest('.AQLModal56').find('.aql_special_sampsize56').val(sampsize);
    })

    $('body').on('change', '.aql_major56', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal56').find('.aql_qty56').val();
        var minor = dis.closest('.AQLModal56').find('.aql_minor56').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal56').find('.aql_normal_level56').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal56').find('.max_major56').val(majorMax);
        dis.closest('.AQLModal56').find('.max_minor56').val(minorMax);
        dis.closest('.AQLModal56').find('.aql_normal_letter56').val(letter);
        dis.closest('.AQLModal56').find('.aql_normal_sampsize56').val(sampsize);
    })

    $('body').on('change', '.aql_minor56', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal56').find('.aql_qty56').val();
        var major = dis.closest('.AQLModal56').find('.aql_major56').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal56').find('.aql_normal_level56').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal56').find('.max_major56').val(majorMax);
        dis.closest('.AQLModal56').find('.max_minor56').val(minorMax);
        dis.closest('.AQLModal56').find('.aql_normal_letter56').val(letter);
        dis.closest('.AQLModal56').find('.aql_normal_sampsize56').val(sampsize);
    })

    $('body').on('click', '.confirmAQL56', function() {
        var dis = $(this);
        dis.closest('.part56').find('.main_part_qty56').val(dis.closest('.part56').find('.aql_qty56').val());
        dis.closest('.part56').find('#samples_unit56').val(dis.closest('.part56').find('.aql_normal_sampsize56').val());
        dis.closest('.part56').find('.AQLModal56').modal('hide');

    });

    $('.aql_select56').append('<option value="">--</option>');
    $('.aql_select56').append('<option value="0.065">0.065</option>');
    $('.aql_select56').append('<option value="0.10">0.10</option>');
    $('.aql_select56').append('<option value="0.15">0.15</option>');
    $('.aql_select56').append('<option value="0.25">0.25</option>');
    $('.aql_select56').append('<option value="0.4">0.4</option>');
    $('.aql_select56').append('<option value="0.65">0.65</option>');
    $('.aql_select56').append('<option value="1">1.0</option>');
    $('.aql_select56').append('<option value="1.5">1.5</option>');
    $('.aql_select56').append('<option value="2.5">2.5</option>');
    $('.aql_select56').append('<option value="4">4.0</option>');
    $('.aql_select56').append('<option value="6.5">6.5</option>');
    $('.aql_select56').append('<option value="10">10.0</option>');
    $('.aql_select56').append('<option value="N/A">N/A</option>');

    //57
    $('body').on('click', '.btn-main_part_qty-modal57', function() {
        jQuery.noConflict();
        $('.AQLModal57').modal('show');
    });

    $('body').on('keyup', '.aql_qty57', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal57').find('.aql_minor57').val();
        var major = dis.closest('.AQLModal57').find('.aql_major57').val();
        var lvl = dis.closest('.AQLModal57').find('.aql_normal_level57').val();
        var special_lvl = dis.closest('.AQLModal57').find('.aql_special_level57').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal57').find('.max_major57').val(majorMax);
        dis.closest('.AQLModal57').find('.max_minor57').val(minorMax);
        dis.closest('.AQLModal57').find('.aql_normal_letter57').val(letter);
        dis.closest('.AQLModal57').find('.aql_special_letter57').val(special_letter);
        dis.closest('.AQLModal57').find('.aql_normal_sampsize57').val(sampsize);
        dis.closest('.AQLModal57').find('.aql_special_sampsize57').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level57', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal57').find('.aql_qty57').val();
        var minor = dis.closest('.AQLModal57').find('.aql_minor57').val();
        var major = dis.closest('.AQLModal57').find('.aql_major57').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal57').find('.max_major57').val(majorMax);
        dis.closest('.AQLModal57').find('.max_minor57').val(minorMax);
        dis.closest('.AQLModal57').find('.aql_normal_letter57').val(letter);
        dis.closest('.AQLModal57').find('.aql_normal_sampsize57').val(sampsize);
    })

    $('body').on('change', '.aql_special_level57', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal57').find('.aql_qty57').val();
        var minor = dis.closest('.AQLModal57').find('.aql_minor57').val();
        var major = dis.closest('.AQLModal57').find('.aql_major57').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal57').find('.aql_special_letter57').val(letter);
        dis.closest('.AQLModal57').find('.aql_special_sampsize57').val(sampsize);
    })

    $('body').on('change', '.aql_major57', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal57').find('.aql_qty57').val();
        var minor = dis.closest('.AQLModal57').find('.aql_minor57').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal57').find('.aql_normal_level57').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal57').find('.max_major57').val(majorMax);
        dis.closest('.AQLModal57').find('.max_minor57').val(minorMax);
        dis.closest('.AQLModal57').find('.aql_normal_letter57').val(letter);
        dis.closest('.AQLModal57').find('.aql_normal_sampsize57').val(sampsize);
    })

    $('body').on('change', '.aql_minor57', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal57').find('.aql_qty57').val();
        var major = dis.closest('.AQLModal57').find('.aql_major57').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal57').find('.aql_normal_level57').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal57').find('.max_major57').val(majorMax);
        dis.closest('.AQLModal57').find('.max_minor57').val(minorMax);
        dis.closest('.AQLModal57').find('.aql_normal_letter57').val(letter);
        dis.closest('.AQLModal57').find('.aql_normal_sampsize57').val(sampsize);
    })

    $('body').on('click', '.confirmAQL57', function() {
        var dis = $(this);
        dis.closest('.part57').find('.main_part_qty57').val(dis.closest('.part57').find('.aql_qty57').val());
        dis.closest('.part57').find('#samples_unit57').val(dis.closest('.part57').find('.aql_normal_sampsize57').val());
        dis.closest('.part57').find('.AQLModal57').modal('hide');

    });

    $('.aql_select57').append('<option value="">--</option>');
    $('.aql_select57').append('<option value="0.065">0.065</option>');
    $('.aql_select57').append('<option value="0.10">0.10</option>');
    $('.aql_select57').append('<option value="0.15">0.15</option>');
    $('.aql_select57').append('<option value="0.25">0.25</option>');
    $('.aql_select57').append('<option value="0.4">0.4</option>');
    $('.aql_select57').append('<option value="0.65">0.65</option>');
    $('.aql_select57').append('<option value="1">1.0</option>');
    $('.aql_select57').append('<option value="1.5">1.5</option>');
    $('.aql_select57').append('<option value="2.5">2.5</option>');
    $('.aql_select57').append('<option value="4">4.0</option>');
    $('.aql_select57').append('<option value="6.5">6.5</option>');
    $('.aql_select57').append('<option value="10">10.0</option>');
    $('.aql_select57').append('<option value="N/A">N/A</option>');

    //58
    $('body').on('click', '.btn-main_part_qty-modal58', function() {
        jQuery.noConflict();
        $('.AQLModal58').modal('show');
    });

    $('body').on('keyup', '.aql_qty58', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal58').find('.aql_minor58').val();
        var major = dis.closest('.AQLModal58').find('.aql_major58').val();
        var lvl = dis.closest('.AQLModal58').find('.aql_normal_level58').val();
        var special_lvl = dis.closest('.AQLModal58').find('.aql_special_level58').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal58').find('.max_major58').val(majorMax);
        dis.closest('.AQLModal58').find('.max_minor58').val(minorMax);
        dis.closest('.AQLModal58').find('.aql_normal_letter58').val(letter);
        dis.closest('.AQLModal58').find('.aql_special_letter58').val(special_letter);
        dis.closest('.AQLModal58').find('.aql_normal_sampsize58').val(sampsize);
        dis.closest('.AQLModal58').find('.aql_special_sampsize58').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level58', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal58').find('.aql_qty58').val();
        var minor = dis.closest('.AQLModal58').find('.aql_minor58').val();
        var major = dis.closest('.AQLModal58').find('.aql_major58').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal58').find('.max_major58').val(majorMax);
        dis.closest('.AQLModal58').find('.max_minor58').val(minorMax);
        dis.closest('.AQLModal58').find('.aql_normal_letter58').val(letter);
        dis.closest('.AQLModal58').find('.aql_normal_sampsize58').val(sampsize);
    })

    $('body').on('change', '.aql_special_level58', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal58').find('.aql_qty58').val();
        var minor = dis.closest('.AQLModal58').find('.aql_minor58').val();
        var major = dis.closest('.AQLModal58').find('.aql_major58').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal58').find('.aql_special_letter58').val(letter);
        dis.closest('.AQLModal58').find('.aql_special_sampsize58').val(sampsize);
    })

    $('body').on('change', '.aql_major58', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal58').find('.aql_qty58').val();
        var minor = dis.closest('.AQLModal58').find('.aql_minor58').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal58').find('.aql_normal_level58').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal58').find('.max_major58').val(majorMax);
        dis.closest('.AQLModal58').find('.max_minor58').val(minorMax);
        dis.closest('.AQLModal58').find('.aql_normal_letter58').val(letter);
        dis.closest('.AQLModal58').find('.aql_normal_sampsize58').val(sampsize);
    })

    $('body').on('change', '.aql_minor58', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal58').find('.aql_qty58').val();
        var major = dis.closest('.AQLModal58').find('.aql_major58').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal58').find('.aql_normal_level58').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal58').find('.max_major58').val(majorMax);
        dis.closest('.AQLModal58').find('.max_minor58').val(minorMax);
        dis.closest('.AQLModal58').find('.aql_normal_letter58').val(letter);
        dis.closest('.AQLModal58').find('.aql_normal_sampsize58').val(sampsize);
    })

    $('body').on('click', '.confirmAQL58', function() {
        var dis = $(this);
        dis.closest('.part58').find('.main_part_qty58').val(dis.closest('.part58').find('.aql_qty58').val());
        dis.closest('.part58').find('#samples_unit58').val(dis.closest('.part58').find('.aql_normal_sampsize58').val());
        dis.closest('.part58').find('.AQLModal58').modal('hide');

    });

    $('.aql_select58').append('<option value="">--</option>');
    $('.aql_select58').append('<option value="0.065">0.065</option>');
    $('.aql_select58').append('<option value="0.10">0.10</option>');
    $('.aql_select58').append('<option value="0.15">0.15</option>');
    $('.aql_select58').append('<option value="0.25">0.25</option>');
    $('.aql_select58').append('<option value="0.4">0.4</option>');
    $('.aql_select58').append('<option value="0.65">0.65</option>');
    $('.aql_select58').append('<option value="1">1.0</option>');
    $('.aql_select58').append('<option value="1.5">1.5</option>');
    $('.aql_select58').append('<option value="2.5">2.5</option>');
    $('.aql_select58').append('<option value="4">4.0</option>');
    $('.aql_select58').append('<option value="6.5">6.5</option>');
    $('.aql_select58').append('<option value="10">10.0</option>');
    $('.aql_select58').append('<option value="N/A">N/A</option>');

    //59
    $('body').on('click', '.btn-main_part_qty-modal59', function() {
        jQuery.noConflict();
        $('.AQLModal59').modal('show');
    });

    $('body').on('keyup', '.aql_qty59', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal59').find('.aql_minor59').val();
        var major = dis.closest('.AQLModal59').find('.aql_major59').val();
        var lvl = dis.closest('.AQLModal59').find('.aql_normal_level59').val();
        var special_lvl = dis.closest('.AQLModal59').find('.aql_special_level59').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal59').find('.max_major59').val(majorMax);
        dis.closest('.AQLModal59').find('.max_minor59').val(minorMax);
        dis.closest('.AQLModal59').find('.aql_normal_letter59').val(letter);
        dis.closest('.AQLModal59').find('.aql_special_letter59').val(special_letter);
        dis.closest('.AQLModal59').find('.aql_normal_sampsize59').val(sampsize);
        dis.closest('.AQLModal59').find('.aql_special_sampsize59').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level59', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal59').find('.aql_qty59').val();
        var minor = dis.closest('.AQLModal59').find('.aql_minor59').val();
        var major = dis.closest('.AQLModal59').find('.aql_major59').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal59').find('.max_major59').val(majorMax);
        dis.closest('.AQLModal59').find('.max_minor59').val(minorMax);
        dis.closest('.AQLModal59').find('.aql_normal_letter59').val(letter);
        dis.closest('.AQLModal59').find('.aql_normal_sampsize59').val(sampsize);
    })

    $('body').on('change', '.aql_special_level59', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal59').find('.aql_qty59').val();
        var minor = dis.closest('.AQLModal59').find('.aql_minor59').val();
        var major = dis.closest('.AQLModal59').find('.aql_major59').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal59').find('.aql_special_letter59').val(letter);
        dis.closest('.AQLModal59').find('.aql_special_sampsize59').val(sampsize);
    })

    $('body').on('change', '.aql_major59', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal59').find('.aql_qty59').val();
        var minor = dis.closest('.AQLModal59').find('.aql_minor59').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal59').find('.aql_normal_level59').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal59').find('.max_major59').val(majorMax);
        dis.closest('.AQLModal59').find('.max_minor59').val(minorMax);
        dis.closest('.AQLModal59').find('.aql_normal_letter59').val(letter);
        dis.closest('.AQLModal59').find('.aql_normal_sampsize59').val(sampsize);
    })

    $('body').on('change', '.aql_minor59', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal59').find('.aql_qty59').val();
        var major = dis.closest('.AQLModal59').find('.aql_major59').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal59').find('.aql_normal_level59').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal59').find('.max_major59').val(majorMax);
        dis.closest('.AQLModal59').find('.max_minor59').val(minorMax);
        dis.closest('.AQLModal59').find('.aql_normal_letter59').val(letter);
        dis.closest('.AQLModal59').find('.aql_normal_sampsize59').val(sampsize);
    })

    $('body').on('click', '.confirmAQL59', function() {
        var dis = $(this);
        dis.closest('.part59').find('.main_part_qty59').val(dis.closest('.part59').find('.aql_qty59').val());
        dis.closest('.part59').find('#samples_unit59').val(dis.closest('.part59').find('.aql_normal_sampsize59').val());
        dis.closest('.part59').find('.AQLModal59').modal('hide');

    });

    $('.aql_select59').append('<option value="">--</option>');
    $('.aql_select59').append('<option value="0.065">0.065</option>');
    $('.aql_select59').append('<option value="0.10">0.10</option>');
    $('.aql_select59').append('<option value="0.15">0.15</option>');
    $('.aql_select59').append('<option value="0.25">0.25</option>');
    $('.aql_select59').append('<option value="0.4">0.4</option>');
    $('.aql_select59').append('<option value="0.65">0.65</option>');
    $('.aql_select59').append('<option value="1">1.0</option>');
    $('.aql_select59').append('<option value="1.5">1.5</option>');
    $('.aql_select59').append('<option value="2.5">2.5</option>');
    $('.aql_select59').append('<option value="4">4.0</option>');
    $('.aql_select59').append('<option value="6.5">6.5</option>');
    $('.aql_select59').append('<option value="10">10.0</option>');
    $('.aql_select59').append('<option value="N/A">N/A</option>');

    //60
    $('body').on('click', '.btn-main_part_qty-modal60', function() {
        jQuery.noConflict();
        $('.AQLModal60').modal('show');
    });

    $('body').on('keyup', '.aql_qty60', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal60').find('.aql_minor60').val();
        var major = dis.closest('.AQLModal60').find('.aql_major60').val();
        var lvl = dis.closest('.AQLModal60').find('.aql_normal_level60').val();
        var special_lvl = dis.closest('.AQLModal60').find('.aql_special_level60').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal60').find('.max_major60').val(majorMax);
        dis.closest('.AQLModal60').find('.max_minor60').val(minorMax);
        dis.closest('.AQLModal60').find('.aql_normal_letter60').val(letter);
        dis.closest('.AQLModal60').find('.aql_special_letter60').val(special_letter);
        dis.closest('.AQLModal60').find('.aql_normal_sampsize60').val(sampsize);
        dis.closest('.AQLModal60').find('.aql_special_sampsize60').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level60', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal60').find('.aql_qty60').val();
        var minor = dis.closest('.AQLModal60').find('.aql_minor60').val();
        var major = dis.closest('.AQLModal60').find('.aql_major60').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal60').find('.max_major60').val(majorMax);
        dis.closest('.AQLModal60').find('.max_minor60').val(minorMax);
        dis.closest('.AQLModal60').find('.aql_normal_letter60').val(letter);
        dis.closest('.AQLModal60').find('.aql_normal_sampsize60').val(sampsize);
    })

    $('body').on('change', '.aql_special_level60', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal60').find('.aql_qty60').val();
        var minor = dis.closest('.AQLModal60').find('.aql_minor60').val();
        var major = dis.closest('.AQLModal60').find('.aql_major60').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal60').find('.aql_special_letter60').val(letter);
        dis.closest('.AQLModal60').find('.aql_special_sampsize60').val(sampsize);
    })

    $('body').on('change', '.aql_major60', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal60').find('.aql_qty60').val();
        var minor = dis.closest('.AQLModal60').find('.aql_minor60').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal60').find('.aql_normal_level60').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal60').find('.max_major60').val(majorMax);
        dis.closest('.AQLModal60').find('.max_minor60').val(minorMax);
        dis.closest('.AQLModal60').find('.aql_normal_letter60').val(letter);
        dis.closest('.AQLModal60').find('.aql_normal_sampsize60').val(sampsize);
    })

    $('body').on('change', '.aql_minor60', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal60').find('.aql_qty60').val();
        var major = dis.closest('.AQLModal60').find('.aql_major60').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal60').find('.aql_normal_level60').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal60').find('.max_major60').val(majorMax);
        dis.closest('.AQLModal60').find('.max_minor60').val(minorMax);
        dis.closest('.AQLModal60').find('.aql_normal_letter60').val(letter);
        dis.closest('.AQLModal60').find('.aql_normal_sampsize60').val(sampsize);
    })

    $('body').on('click', '.confirmAQL60', function() {
        var dis = $(this);
        dis.closest('.part60').find('.main_part_qty60').val(dis.closest('.part60').find('.aql_qty60').val());
        dis.closest('.part60').find('#samples_unit60').val(dis.closest('.part60').find('.aql_normal_sampsize60').val());
        dis.closest('.part60').find('.AQLModal60').modal('hide');

    });

    $('.aql_select60').append('<option value="">--</option>');
    $('.aql_select60').append('<option value="0.065">0.065</option>');
    $('.aql_select60').append('<option value="0.10">0.10</option>');
    $('.aql_select60').append('<option value="0.15">0.15</option>');
    $('.aql_select60').append('<option value="0.25">0.25</option>');
    $('.aql_select60').append('<option value="0.4">0.4</option>');
    $('.aql_select60').append('<option value="0.65">0.65</option>');
    $('.aql_select60').append('<option value="1">1.0</option>');
    $('.aql_select60').append('<option value="1.5">1.5</option>');
    $('.aql_select60').append('<option value="2.5">2.5</option>');
    $('.aql_select60').append('<option value="4">4.0</option>');
    $('.aql_select60').append('<option value="6.5">6.5</option>');
    $('.aql_select60').append('<option value="10">10.0</option>');
    $('.aql_select60').append('<option value="N/A">N/A</option>');

    //61
    $('body').on('click', '.btn-main_part_qty-modal61', function() {
        jQuery.noConflict();
        $('.AQLModal61').modal('show');
    });

    $('body').on('keyup', '.aql_qty61', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal61').find('.aql_minor61').val();
        var major = dis.closest('.AQLModal61').find('.aql_major61').val();
        var lvl = dis.closest('.AQLModal61').find('.aql_normal_level61').val();
        var special_lvl = dis.closest('.AQLModal61').find('.aql_special_level61').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal61').find('.max_major61').val(majorMax);
        dis.closest('.AQLModal61').find('.max_minor61').val(minorMax);
        dis.closest('.AQLModal61').find('.aql_normal_letter61').val(letter);
        dis.closest('.AQLModal61').find('.aql_special_letter61').val(special_letter);
        dis.closest('.AQLModal61').find('.aql_normal_sampsize61').val(sampsize);
        dis.closest('.AQLModal61').find('.aql_special_sampsize61').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level61', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal61').find('.aql_qty61').val();
        var minor = dis.closest('.AQLModal61').find('.aql_minor61').val();
        var major = dis.closest('.AQLModal61').find('.aql_major61').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal61').find('.max_major61').val(majorMax);
        dis.closest('.AQLModal61').find('.max_minor61').val(minorMax);
        dis.closest('.AQLModal61').find('.aql_normal_letter61').val(letter);
        dis.closest('.AQLModal61').find('.aql_normal_sampsize61').val(sampsize);
    })

    $('body').on('change', '.aql_special_level61', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal61').find('.aql_qty61').val();
        var minor = dis.closest('.AQLModal61').find('.aql_minor61').val();
        var major = dis.closest('.AQLModal61').find('.aql_major61').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal61').find('.aql_special_letter61').val(letter);
        dis.closest('.AQLModal61').find('.aql_special_sampsize61').val(sampsize);
    })

    $('body').on('change', '.aql_major61', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal61').find('.aql_qty61').val();
        var minor = dis.closest('.AQLModal61').find('.aql_minor61').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal61').find('.aql_normal_level61').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal61').find('.max_major61').val(majorMax);
        dis.closest('.AQLModal61').find('.max_minor61').val(minorMax);
        dis.closest('.AQLModal61').find('.aql_normal_letter61').val(letter);
        dis.closest('.AQLModal61').find('.aql_normal_sampsize61').val(sampsize);
    })

    $('body').on('change', '.aql_minor61', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal61').find('.aql_qty61').val();
        var major = dis.closest('.AQLModal61').find('.aql_major61').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal61').find('.aql_normal_level61').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal61').find('.max_major61').val(majorMax);
        dis.closest('.AQLModal61').find('.max_minor61').val(minorMax);
        dis.closest('.AQLModal61').find('.aql_normal_letter61').val(letter);
        dis.closest('.AQLModal61').find('.aql_normal_sampsize61').val(sampsize);
    })

    $('body').on('click', '.confirmAQL61', function() {
        var dis = $(this);
        dis.closest('.part61').find('.main_part_qty61').val(dis.closest('.part61').find('.aql_qty61').val());
        dis.closest('.part61').find('#samples_unit61').val(dis.closest('.part61').find('.aql_normal_sampsize61').val());
        dis.closest('.part61').find('.AQLModal61').modal('hide');

    });

    $('.aql_select61').append('<option value="">--</option>');
    $('.aql_select61').append('<option value="0.065">0.065</option>');
    $('.aql_select61').append('<option value="0.10">0.10</option>');
    $('.aql_select61').append('<option value="0.15">0.15</option>');
    $('.aql_select61').append('<option value="0.25">0.25</option>');
    $('.aql_select61').append('<option value="0.4">0.4</option>');
    $('.aql_select61').append('<option value="0.65">0.65</option>');
    $('.aql_select61').append('<option value="1">1.0</option>');
    $('.aql_select61').append('<option value="1.5">1.5</option>');
    $('.aql_select61').append('<option value="2.5">2.5</option>');
    $('.aql_select61').append('<option value="4">4.0</option>');
    $('.aql_select61').append('<option value="6.5">6.5</option>');
    $('.aql_select61').append('<option value="10">10.0</option>');
    $('.aql_select61').append('<option value="N/A">N/A</option>');

    //62
    $('body').on('click', '.btn-main_part_qty-modal62', function() {
        jQuery.noConflict();
        $('.AQLModal62').modal('show');
    });

    $('body').on('keyup', '.aql_qty62', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal62').find('.aql_minor62').val();
        var major = dis.closest('.AQLModal62').find('.aql_major62').val();
        var lvl = dis.closest('.AQLModal62').find('.aql_normal_level62').val();
        var special_lvl = dis.closest('.AQLModal62').find('.aql_special_level62').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal62').find('.max_major62').val(majorMax);
        dis.closest('.AQLModal62').find('.max_minor62').val(minorMax);
        dis.closest('.AQLModal62').find('.aql_normal_letter62').val(letter);
        dis.closest('.AQLModal62').find('.aql_special_letter62').val(special_letter);
        dis.closest('.AQLModal62').find('.aql_normal_sampsize62').val(sampsize);
        dis.closest('.AQLModal62').find('.aql_special_sampsize62').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level62', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal62').find('.aql_qty62').val();
        var minor = dis.closest('.AQLModal62').find('.aql_minor62').val();
        var major = dis.closest('.AQLModal62').find('.aql_major62').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal62').find('.max_major62').val(majorMax);
        dis.closest('.AQLModal62').find('.max_minor62').val(minorMax);
        dis.closest('.AQLModal62').find('.aql_normal_letter62').val(letter);
        dis.closest('.AQLModal62').find('.aql_normal_sampsize62').val(sampsize);
    })

    $('body').on('change', '.aql_special_level62', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal62').find('.aql_qty62').val();
        var minor = dis.closest('.AQLModal62').find('.aql_minor62').val();
        var major = dis.closest('.AQLModal62').find('.aql_major62').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal62').find('.aql_special_letter62').val(letter);
        dis.closest('.AQLModal62').find('.aql_special_sampsize62').val(sampsize);
    })

    $('body').on('change', '.aql_major62', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal62').find('.aql_qty62').val();
        var minor = dis.closest('.AQLModal62').find('.aql_minor62').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal62').find('.aql_normal_level62').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal62').find('.max_major62').val(majorMax);
        dis.closest('.AQLModal62').find('.max_minor62').val(minorMax);
        dis.closest('.AQLModal62').find('.aql_normal_letter62').val(letter);
        dis.closest('.AQLModal62').find('.aql_normal_sampsize62').val(sampsize);
    })

    $('body').on('change', '.aql_minor62', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal62').find('.aql_qty62').val();
        var major = dis.closest('.AQLModal62').find('.aql_major62').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal62').find('.aql_normal_level62').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal62').find('.max_major62').val(majorMax);
        dis.closest('.AQLModal62').find('.max_minor62').val(minorMax);
        dis.closest('.AQLModal62').find('.aql_normal_letter62').val(letter);
        dis.closest('.AQLModal62').find('.aql_normal_sampsize62').val(sampsize);
    })

    $('body').on('click', '.confirmAQL62', function() {
        var dis = $(this);
        dis.closest('.part62').find('.main_part_qty62').val(dis.closest('.part62').find('.aql_qty62').val());
        dis.closest('.part62').find('#samples_unit62').val(dis.closest('.part62').find('.aql_normal_sampsize62').val());
        dis.closest('.part62').find('.AQLModal62').modal('hide');

    });

    $('.aql_select62').append('<option value="">--</option>');
    $('.aql_select62').append('<option value="0.065">0.065</option>');
    $('.aql_select62').append('<option value="0.10">0.10</option>');
    $('.aql_select62').append('<option value="0.15">0.15</option>');
    $('.aql_select62').append('<option value="0.25">0.25</option>');
    $('.aql_select62').append('<option value="0.4">0.4</option>');
    $('.aql_select62').append('<option value="0.65">0.65</option>');
    $('.aql_select62').append('<option value="1">1.0</option>');
    $('.aql_select62').append('<option value="1.5">1.5</option>');
    $('.aql_select62').append('<option value="2.5">2.5</option>');
    $('.aql_select62').append('<option value="4">4.0</option>');
    $('.aql_select62').append('<option value="6.5">6.5</option>');
    $('.aql_select62').append('<option value="10">10.0</option>');
    $('.aql_select62').append('<option value="N/A">N/A</option>');

    //63
    $('body').on('click', '.btn-main_part_qty-modal63', function() {
        jQuery.noConflict();
        $('.AQLModal63').modal('show');
    });

    $('body').on('keyup', '.aql_qty63', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal63').find('.aql_minor63').val();
        var major = dis.closest('.AQLModal63').find('.aql_major63').val();
        var lvl = dis.closest('.AQLModal63').find('.aql_normal_level63').val();
        var special_lvl = dis.closest('.AQLModal63').find('.aql_special_level63').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal63').find('.max_major63').val(majorMax);
        dis.closest('.AQLModal63').find('.max_minor63').val(minorMax);
        dis.closest('.AQLModal63').find('.aql_normal_letter63').val(letter);
        dis.closest('.AQLModal63').find('.aql_special_letter63').val(special_letter);
        dis.closest('.AQLModal63').find('.aql_normal_sampsize63').val(sampsize);
        dis.closest('.AQLModal63').find('.aql_special_sampsize63').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level63', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal63').find('.aql_qty63').val();
        var minor = dis.closest('.AQLModal63').find('.aql_minor63').val();
        var major = dis.closest('.AQLModal63').find('.aql_major63').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal63').find('.max_major63').val(majorMax);
        dis.closest('.AQLModal63').find('.max_minor63').val(minorMax);
        dis.closest('.AQLModal63').find('.aql_normal_letter63').val(letter);
        dis.closest('.AQLModal63').find('.aql_normal_sampsize63').val(sampsize);
    })

    $('body').on('change', '.aql_special_level63', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal63').find('.aql_qty63').val();
        var minor = dis.closest('.AQLModal63').find('.aql_minor63').val();
        var major = dis.closest('.AQLModal63').find('.aql_major63').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal63').find('.aql_special_letter63').val(letter);
        dis.closest('.AQLModal63').find('.aql_special_sampsize63').val(sampsize);
    })

    $('body').on('change', '.aql_major63', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal63').find('.aql_qty63').val();
        var minor = dis.closest('.AQLModal63').find('.aql_minor63').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal63').find('.aql_normal_level63').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal63').find('.max_major63').val(majorMax);
        dis.closest('.AQLModal63').find('.max_minor63').val(minorMax);
        dis.closest('.AQLModal63').find('.aql_normal_letter63').val(letter);
        dis.closest('.AQLModal63').find('.aql_normal_sampsize63').val(sampsize);
    })

    $('body').on('change', '.aql_minor63', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal63').find('.aql_qty63').val();
        var major = dis.closest('.AQLModal63').find('.aql_major63').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal63').find('.aql_normal_level63').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal63').find('.max_major63').val(majorMax);
        dis.closest('.AQLModal63').find('.max_minor63').val(minorMax);
        dis.closest('.AQLModal63').find('.aql_normal_letter63').val(letter);
        dis.closest('.AQLModal63').find('.aql_normal_sampsize63').val(sampsize);
    })

    $('body').on('click', '.confirmAQL63', function() {
        var dis = $(this);
        dis.closest('.part63').find('.main_part_qty63').val(dis.closest('.part63').find('.aql_qty63').val());
        dis.closest('.part63').find('#samples_unit63').val(dis.closest('.part63').find('.aql_normal_sampsize63').val());
        dis.closest('.part63').find('.AQLModal63').modal('hide');

    });

    $('.aql_select63').append('<option value="">--</option>');
    $('.aql_select63').append('<option value="0.065">0.065</option>');
    $('.aql_select63').append('<option value="0.10">0.10</option>');
    $('.aql_select63').append('<option value="0.15">0.15</option>');
    $('.aql_select63').append('<option value="0.25">0.25</option>');
    $('.aql_select63').append('<option value="0.4">0.4</option>');
    $('.aql_select63').append('<option value="0.65">0.65</option>');
    $('.aql_select63').append('<option value="1">1.0</option>');
    $('.aql_select63').append('<option value="1.5">1.5</option>');
    $('.aql_select63').append('<option value="2.5">2.5</option>');
    $('.aql_select63').append('<option value="4">4.0</option>');
    $('.aql_select63').append('<option value="6.5">6.5</option>');
    $('.aql_select63').append('<option value="10">10.0</option>');
    $('.aql_select63').append('<option value="N/A">N/A</option>');

    //64
    $('body').on('click', '.btn-main_part_qty-modal64', function() {
        jQuery.noConflict();
        $('.AQLModal64').modal('show');
    });

    $('body').on('keyup', '.aql_qty64', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal64').find('.aql_minor64').val();
        var major = dis.closest('.AQLModal64').find('.aql_major64').val();
        var lvl = dis.closest('.AQLModal64').find('.aql_normal_level64').val();
        var special_lvl = dis.closest('.AQLModal64').find('.aql_special_level64').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal64').find('.max_major64').val(majorMax);
        dis.closest('.AQLModal64').find('.max_minor64').val(minorMax);
        dis.closest('.AQLModal64').find('.aql_normal_letter64').val(letter);
        dis.closest('.AQLModal64').find('.aql_special_letter64').val(special_letter);
        dis.closest('.AQLModal64').find('.aql_normal_sampsize64').val(sampsize);
        dis.closest('.AQLModal64').find('.aql_special_sampsize64').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level64', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal64').find('.aql_qty64').val();
        var minor = dis.closest('.AQLModal64').find('.aql_minor64').val();
        var major = dis.closest('.AQLModal64').find('.aql_major64').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal64').find('.max_major64').val(majorMax);
        dis.closest('.AQLModal64').find('.max_minor64').val(minorMax);
        dis.closest('.AQLModal64').find('.aql_normal_letter64').val(letter);
        dis.closest('.AQLModal64').find('.aql_normal_sampsize64').val(sampsize);
    })

    $('body').on('change', '.aql_special_level64', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal64').find('.aql_qty64').val();
        var minor = dis.closest('.AQLModal64').find('.aql_minor64').val();
        var major = dis.closest('.AQLModal64').find('.aql_major64').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal64').find('.aql_special_letter64').val(letter);
        dis.closest('.AQLModal64').find('.aql_special_sampsize64').val(sampsize);
    })

    $('body').on('change', '.aql_major64', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal64').find('.aql_qty64').val();
        var minor = dis.closest('.AQLModal64').find('.aql_minor64').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal64').find('.aql_normal_level64').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal64').find('.max_major64').val(majorMax);
        dis.closest('.AQLModal64').find('.max_minor64').val(minorMax);
        dis.closest('.AQLModal64').find('.aql_normal_letter64').val(letter);
        dis.closest('.AQLModal64').find('.aql_normal_sampsize64').val(sampsize);
    })

    $('body').on('change', '.aql_minor64', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal64').find('.aql_qty64').val();
        var major = dis.closest('.AQLModal64').find('.aql_major64').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal64').find('.aql_normal_level64').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal64').find('.max_major64').val(majorMax);
        dis.closest('.AQLModal64').find('.max_minor64').val(minorMax);
        dis.closest('.AQLModal64').find('.aql_normal_letter64').val(letter);
        dis.closest('.AQLModal64').find('.aql_normal_sampsize64').val(sampsize);
    })

    $('body').on('click', '.confirmAQL64', function() {
        var dis = $(this);
        dis.closest('.part64').find('.main_part_qty64').val(dis.closest('.part64').find('.aql_qty64').val());
        dis.closest('.part64').find('#samples_unit64').val(dis.closest('.part64').find('.aql_normal_sampsize64').val());
        dis.closest('.part64').find('.AQLModal64').modal('hide');

    });

    $('.aql_select64').append('<option value="">--</option>');
    $('.aql_select64').append('<option value="0.065">0.065</option>');
    $('.aql_select64').append('<option value="0.10">0.10</option>');
    $('.aql_select64').append('<option value="0.15">0.15</option>');
    $('.aql_select64').append('<option value="0.25">0.25</option>');
    $('.aql_select64').append('<option value="0.4">0.4</option>');
    $('.aql_select64').append('<option value="0.65">0.65</option>');
    $('.aql_select64').append('<option value="1">1.0</option>');
    $('.aql_select64').append('<option value="1.5">1.5</option>');
    $('.aql_select64').append('<option value="2.5">2.5</option>');
    $('.aql_select64').append('<option value="4">4.0</option>');
    $('.aql_select64').append('<option value="6.5">6.5</option>');
    $('.aql_select64').append('<option value="10">10.0</option>');
    $('.aql_select64').append('<option value="N/A">N/A</option>');

    //65
    $('body').on('click', '.btn-main_part_qty-modal65', function() {
        jQuery.noConflict();
        $('.AQLModal65').modal('show');
    });

    $('body').on('keyup', '.aql_qty65', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal65').find('.aql_minor65').val();
        var major = dis.closest('.AQLModal65').find('.aql_major65').val();
        var lvl = dis.closest('.AQLModal65').find('.aql_normal_level65').val();
        var special_lvl = dis.closest('.AQLModal65').find('.aql_special_level65').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal65').find('.max_major65').val(majorMax);
        dis.closest('.AQLModal65').find('.max_minor65').val(minorMax);
        dis.closest('.AQLModal65').find('.aql_normal_letter65').val(letter);
        dis.closest('.AQLModal65').find('.aql_special_letter65').val(special_letter);
        dis.closest('.AQLModal65').find('.aql_normal_sampsize65').val(sampsize);
        dis.closest('.AQLModal65').find('.aql_special_sampsize65').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level65', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal65').find('.aql_qty65').val();
        var minor = dis.closest('.AQLModal65').find('.aql_minor65').val();
        var major = dis.closest('.AQLModal65').find('.aql_major65').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal65').find('.max_major65').val(majorMax);
        dis.closest('.AQLModal65').find('.max_minor65').val(minorMax);
        dis.closest('.AQLModal65').find('.aql_normal_letter65').val(letter);
        dis.closest('.AQLModal65').find('.aql_normal_sampsize65').val(sampsize);
    })

    $('body').on('change', '.aql_special_level65', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal65').find('.aql_qty65').val();
        var minor = dis.closest('.AQLModal65').find('.aql_minor65').val();
        var major = dis.closest('.AQLModal65').find('.aql_major65').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal65').find('.aql_special_letter65').val(letter);
        dis.closest('.AQLModal65').find('.aql_special_sampsize65').val(sampsize);
    })

    $('body').on('change', '.aql_major65', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal65').find('.aql_qty65').val();
        var minor = dis.closest('.AQLModal65').find('.aql_minor65').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal65').find('.aql_normal_level65').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal65').find('.max_major65').val(majorMax);
        dis.closest('.AQLModal65').find('.max_minor65').val(minorMax);
        dis.closest('.AQLModal65').find('.aql_normal_letter65').val(letter);
        dis.closest('.AQLModal65').find('.aql_normal_sampsize65').val(sampsize);
    })

    $('body').on('change', '.aql_minor65', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal65').find('.aql_qty65').val();
        var major = dis.closest('.AQLModal65').find('.aql_major65').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal65').find('.aql_normal_level65').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal65').find('.max_major65').val(majorMax);
        dis.closest('.AQLModal65').find('.max_minor65').val(minorMax);
        dis.closest('.AQLModal65').find('.aql_normal_letter65').val(letter);
        dis.closest('.AQLModal65').find('.aql_normal_sampsize65').val(sampsize);
    })

    $('body').on('click', '.confirmAQL65', function() {
        var dis = $(this);
        dis.closest('.part65').find('.main_part_qty65').val(dis.closest('.part65').find('.aql_qty65').val());
        dis.closest('.part65').find('#samples_unit65').val(dis.closest('.part65').find('.aql_normal_sampsize65').val());
        dis.closest('.part65').find('.AQLModal65').modal('hide');

    });

    $('.aql_select65').append('<option value="">--</option>');
    $('.aql_select65').append('<option value="0.065">0.065</option>');
    $('.aql_select65').append('<option value="0.10">0.10</option>');
    $('.aql_select65').append('<option value="0.15">0.15</option>');
    $('.aql_select65').append('<option value="0.25">0.25</option>');
    $('.aql_select65').append('<option value="0.4">0.4</option>');
    $('.aql_select65').append('<option value="0.65">0.65</option>');
    $('.aql_select65').append('<option value="1">1.0</option>');
    $('.aql_select65').append('<option value="1.5">1.5</option>');
    $('.aql_select65').append('<option value="2.5">2.5</option>');
    $('.aql_select65').append('<option value="4">4.0</option>');
    $('.aql_select65').append('<option value="6.5">6.5</option>');
    $('.aql_select65').append('<option value="10">10.0</option>');
    $('.aql_select65').append('<option value="N/A">N/A</option>');

    //66
    $('body').on('click', '.btn-main_part_qty-modal66', function() {
        jQuery.noConflict();
        $('.AQLModal66').modal('show');
    });

    $('body').on('keyup', '.aql_qty66', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal66').find('.aql_minor66').val();
        var major = dis.closest('.AQLModal66').find('.aql_major66').val();
        var lvl = dis.closest('.AQLModal66').find('.aql_normal_level66').val();
        var special_lvl = dis.closest('.AQLModal66').find('.aql_special_level66').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal66').find('.max_major66').val(majorMax);
        dis.closest('.AQLModal66').find('.max_minor66').val(minorMax);
        dis.closest('.AQLModal66').find('.aql_normal_letter66').val(letter);
        dis.closest('.AQLModal66').find('.aql_special_letter66').val(special_letter);
        dis.closest('.AQLModal66').find('.aql_normal_sampsize66').val(sampsize);
        dis.closest('.AQLModal66').find('.aql_special_sampsize66').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level66', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal66').find('.aql_qty66').val();
        var minor = dis.closest('.AQLModal66').find('.aql_minor66').val();
        var major = dis.closest('.AQLModal66').find('.aql_major66').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal66').find('.max_major66').val(majorMax);
        dis.closest('.AQLModal66').find('.max_minor66').val(minorMax);
        dis.closest('.AQLModal66').find('.aql_normal_letter66').val(letter);
        dis.closest('.AQLModal66').find('.aql_normal_sampsize66').val(sampsize);
    })

    $('body').on('change', '.aql_special_level66', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal66').find('.aql_qty66').val();
        var minor = dis.closest('.AQLModal66').find('.aql_minor66').val();
        var major = dis.closest('.AQLModal66').find('.aql_major66').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal66').find('.aql_special_letter66').val(letter);
        dis.closest('.AQLModal66').find('.aql_special_sampsize66').val(sampsize);
    })

    $('body').on('change', '.aql_major66', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal66').find('.aql_qty66').val();
        var minor = dis.closest('.AQLModal66').find('.aql_minor66').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal66').find('.aql_normal_level66').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal66').find('.max_major66').val(majorMax);
        dis.closest('.AQLModal66').find('.max_minor66').val(minorMax);
        dis.closest('.AQLModal66').find('.aql_normal_letter66').val(letter);
        dis.closest('.AQLModal66').find('.aql_normal_sampsize66').val(sampsize);
    })

    $('body').on('change', '.aql_minor66', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal66').find('.aql_qty66').val();
        var major = dis.closest('.AQLModal66').find('.aql_major66').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal66').find('.aql_normal_level66').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal66').find('.max_major66').val(majorMax);
        dis.closest('.AQLModal66').find('.max_minor66').val(minorMax);
        dis.closest('.AQLModal66').find('.aql_normal_letter66').val(letter);
        dis.closest('.AQLModal66').find('.aql_normal_sampsize66').val(sampsize);
    })

    $('body').on('click', '.confirmAQL66', function() {
        var dis = $(this);
        dis.closest('.part66').find('.main_part_qty66').val(dis.closest('.part66').find('.aql_qty66').val());
        dis.closest('.part66').find('#samples_unit66').val(dis.closest('.part66').find('.aql_normal_sampsize66').val());
        dis.closest('.part66').find('.AQLModal66').modal('hide');

    });

    $('.aql_select66').append('<option value="">--</option>');
    $('.aql_select66').append('<option value="0.065">0.065</option>');
    $('.aql_select66').append('<option value="0.10">0.10</option>');
    $('.aql_select66').append('<option value="0.15">0.15</option>');
    $('.aql_select66').append('<option value="0.25">0.25</option>');
    $('.aql_select66').append('<option value="0.4">0.4</option>');
    $('.aql_select66').append('<option value="0.65">0.65</option>');
    $('.aql_select66').append('<option value="1">1.0</option>');
    $('.aql_select66').append('<option value="1.5">1.5</option>');
    $('.aql_select66').append('<option value="2.5">2.5</option>');
    $('.aql_select66').append('<option value="4">4.0</option>');
    $('.aql_select66').append('<option value="6.5">6.5</option>');
    $('.aql_select66').append('<option value="10">10.0</option>');
    $('.aql_select66').append('<option value="N/A">N/A</option>');

    //67
    $('body').on('click', '.btn-main_part_qty-modal67', function() {
        jQuery.noConflict();
        $('.AQLModal67').modal('show');
    });

    $('body').on('keyup', '.aql_qty67', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal67').find('.aql_minor67').val();
        var major = dis.closest('.AQLModal67').find('.aql_major67').val();
        var lvl = dis.closest('.AQLModal67').find('.aql_normal_level67').val();
        var special_lvl = dis.closest('.AQLModal67').find('.aql_special_level67').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal67').find('.max_major67').val(majorMax);
        dis.closest('.AQLModal67').find('.max_minor67').val(minorMax);
        dis.closest('.AQLModal67').find('.aql_normal_letter67').val(letter);
        dis.closest('.AQLModal67').find('.aql_special_letter67').val(special_letter);
        dis.closest('.AQLModal67').find('.aql_normal_sampsize67').val(sampsize);
        dis.closest('.AQLModal67').find('.aql_special_sampsize67').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level67', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal67').find('.aql_qty67').val();
        var minor = dis.closest('.AQLModal67').find('.aql_minor67').val();
        var major = dis.closest('.AQLModal67').find('.aql_major67').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal67').find('.max_major67').val(majorMax);
        dis.closest('.AQLModal67').find('.max_minor67').val(minorMax);
        dis.closest('.AQLModal67').find('.aql_normal_letter67').val(letter);
        dis.closest('.AQLModal67').find('.aql_normal_sampsize67').val(sampsize);
    })

    $('body').on('change', '.aql_special_level67', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal67').find('.aql_qty67').val();
        var minor = dis.closest('.AQLModal67').find('.aql_minor67').val();
        var major = dis.closest('.AQLModal67').find('.aql_major67').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal67').find('.aql_special_letter67').val(letter);
        dis.closest('.AQLModal67').find('.aql_special_sampsize67').val(sampsize);
    })

    $('body').on('change', '.aql_major67', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal67').find('.aql_qty67').val();
        var minor = dis.closest('.AQLModal67').find('.aql_minor67').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal67').find('.aql_normal_level67').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal67').find('.max_major67').val(majorMax);
        dis.closest('.AQLModal67').find('.max_minor67').val(minorMax);
        dis.closest('.AQLModal67').find('.aql_normal_letter67').val(letter);
        dis.closest('.AQLModal67').find('.aql_normal_sampsize67').val(sampsize);
    })

    $('body').on('change', '.aql_minor67', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal67').find('.aql_qty67').val();
        var major = dis.closest('.AQLModal67').find('.aql_major67').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal67').find('.aql_normal_level67').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal67').find('.max_major67').val(majorMax);
        dis.closest('.AQLModal67').find('.max_minor67').val(minorMax);
        dis.closest('.AQLModal67').find('.aql_normal_letter67').val(letter);
        dis.closest('.AQLModal67').find('.aql_normal_sampsize67').val(sampsize);
    })

    $('body').on('click', '.confirmAQL67', function() {
        var dis = $(this);
        dis.closest('.part67').find('.main_part_qty67').val(dis.closest('.part67').find('.aql_qty67').val());
        dis.closest('.part67').find('#samples_unit67').val(dis.closest('.part67').find('.aql_normal_sampsize67').val());
        dis.closest('.part67').find('.AQLModal67').modal('hide');

    });

    $('.aql_select67').append('<option value="">--</option>');
    $('.aql_select67').append('<option value="0.065">0.065</option>');
    $('.aql_select67').append('<option value="0.10">0.10</option>');
    $('.aql_select67').append('<option value="0.15">0.15</option>');
    $('.aql_select67').append('<option value="0.25">0.25</option>');
    $('.aql_select67').append('<option value="0.4">0.4</option>');
    $('.aql_select67').append('<option value="0.65">0.65</option>');
    $('.aql_select67').append('<option value="1">1.0</option>');
    $('.aql_select67').append('<option value="1.5">1.5</option>');
    $('.aql_select67').append('<option value="2.5">2.5</option>');
    $('.aql_select67').append('<option value="4">4.0</option>');
    $('.aql_select67').append('<option value="6.5">6.5</option>');
    $('.aql_select67').append('<option value="10">10.0</option>');
    $('.aql_select67').append('<option value="N/A">N/A</option>');

    //68
    $('body').on('click', '.btn-main_part_qty-modal68', function() {
        jQuery.noConflict();
        $('.AQLModal68').modal('show');
    });

    $('body').on('keyup', '.aql_qty68', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal68').find('.aql_minor68').val();
        var major = dis.closest('.AQLModal68').find('.aql_major68').val();
        var lvl = dis.closest('.AQLModal68').find('.aql_normal_level68').val();
        var special_lvl = dis.closest('.AQLModal68').find('.aql_special_level68').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal68').find('.max_major68').val(majorMax);
        dis.closest('.AQLModal68').find('.max_minor68').val(minorMax);
        dis.closest('.AQLModal68').find('.aql_normal_letter68').val(letter);
        dis.closest('.AQLModal68').find('.aql_special_letter68').val(special_letter);
        dis.closest('.AQLModal68').find('.aql_normal_sampsize68').val(sampsize);
        dis.closest('.AQLModal68').find('.aql_special_sampsize68').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level68', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal68').find('.aql_qty68').val();
        var minor = dis.closest('.AQLModal68').find('.aql_minor68').val();
        var major = dis.closest('.AQLModal68').find('.aql_major68').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal68').find('.max_major68').val(majorMax);
        dis.closest('.AQLModal68').find('.max_minor68').val(minorMax);
        dis.closest('.AQLModal68').find('.aql_normal_letter68').val(letter);
        dis.closest('.AQLModal68').find('.aql_normal_sampsize68').val(sampsize);
    })

    $('body').on('change', '.aql_special_level68', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal68').find('.aql_qty68').val();
        var minor = dis.closest('.AQLModal68').find('.aql_minor68').val();
        var major = dis.closest('.AQLModal68').find('.aql_major68').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal68').find('.aql_special_letter68').val(letter);
        dis.closest('.AQLModal68').find('.aql_special_sampsize68').val(sampsize);
    })

    $('body').on('change', '.aql_major68', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal68').find('.aql_qty68').val();
        var minor = dis.closest('.AQLModal68').find('.aql_minor68').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal68').find('.aql_normal_level68').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal68').find('.max_major68').val(majorMax);
        dis.closest('.AQLModal68').find('.max_minor68').val(minorMax);
        dis.closest('.AQLModal68').find('.aql_normal_letter68').val(letter);
        dis.closest('.AQLModal68').find('.aql_normal_sampsize68').val(sampsize);
    })

    $('body').on('change', '.aql_minor68', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal68').find('.aql_qty68').val();
        var major = dis.closest('.AQLModal68').find('.aql_major68').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal68').find('.aql_normal_level68').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal68').find('.max_major68').val(majorMax);
        dis.closest('.AQLModal68').find('.max_minor68').val(minorMax);
        dis.closest('.AQLModal68').find('.aql_normal_letter68').val(letter);
        dis.closest('.AQLModal68').find('.aql_normal_sampsize68').val(sampsize);
    })

    $('body').on('click', '.confirmAQL68', function() {
        var dis = $(this);
        dis.closest('.part68').find('.main_part_qty68').val(dis.closest('.part68').find('.aql_qty68').val());
        dis.closest('.part68').find('#samples_unit68').val(dis.closest('.part68').find('.aql_normal_sampsize68').val());
        dis.closest('.part68').find('.AQLModal68').modal('hide');

    });

    $('.aql_select68').append('<option value="">--</option>');
    $('.aql_select68').append('<option value="0.065">0.065</option>');
    $('.aql_select68').append('<option value="0.10">0.10</option>');
    $('.aql_select68').append('<option value="0.15">0.15</option>');
    $('.aql_select68').append('<option value="0.25">0.25</option>');
    $('.aql_select68').append('<option value="0.4">0.4</option>');
    $('.aql_select68').append('<option value="0.65">0.65</option>');
    $('.aql_select68').append('<option value="1">1.0</option>');
    $('.aql_select68').append('<option value="1.5">1.5</option>');
    $('.aql_select68').append('<option value="2.5">2.5</option>');
    $('.aql_select68').append('<option value="4">4.0</option>');
    $('.aql_select68').append('<option value="6.5">6.5</option>');
    $('.aql_select68').append('<option value="10">10.0</option>');
    $('.aql_select68').append('<option value="N/A">N/A</option>');

    //69
    $('body').on('click', '.btn-main_part_qty-modal69', function() {
        jQuery.noConflict();
        $('.AQLModal69').modal('show');
    });

    $('body').on('keyup', '.aql_qty69', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal69').find('.aql_minor69').val();
        var major = dis.closest('.AQLModal69').find('.aql_major69').val();
        var lvl = dis.closest('.AQLModal69').find('.aql_normal_level69').val();
        var special_lvl = dis.closest('.AQLModal69').find('.aql_special_level69').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal69').find('.max_major69').val(majorMax);
        dis.closest('.AQLModal69').find('.max_minor69').val(minorMax);
        dis.closest('.AQLModal69').find('.aql_normal_letter69').val(letter);
        dis.closest('.AQLModal69').find('.aql_special_letter69').val(special_letter);
        dis.closest('.AQLModal69').find('.aql_normal_sampsize69').val(sampsize);
        dis.closest('.AQLModal69').find('.aql_special_sampsize69').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level69', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal69').find('.aql_qty69').val();
        var minor = dis.closest('.AQLModal69').find('.aql_minor69').val();
        var major = dis.closest('.AQLModal69').find('.aql_major69').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal69').find('.max_major69').val(majorMax);
        dis.closest('.AQLModal69').find('.max_minor69').val(minorMax);
        dis.closest('.AQLModal69').find('.aql_normal_letter69').val(letter);
        dis.closest('.AQLModal69').find('.aql_normal_sampsize69').val(sampsize);
    })

    $('body').on('change', '.aql_special_level69', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal69').find('.aql_qty69').val();
        var minor = dis.closest('.AQLModal69').find('.aql_minor69').val();
        var major = dis.closest('.AQLModal69').find('.aql_major69').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal69').find('.aql_special_letter69').val(letter);
        dis.closest('.AQLModal69').find('.aql_special_sampsize69').val(sampsize);
    })

    $('body').on('change', '.aql_major69', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal69').find('.aql_qty69').val();
        var minor = dis.closest('.AQLModal69').find('.aql_minor69').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal69').find('.aql_normal_level69').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal69').find('.max_major69').val(majorMax);
        dis.closest('.AQLModal69').find('.max_minor69').val(minorMax);
        dis.closest('.AQLModal69').find('.aql_normal_letter69').val(letter);
        dis.closest('.AQLModal69').find('.aql_normal_sampsize69').val(sampsize);
    })

    $('body').on('change', '.aql_minor69', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal69').find('.aql_qty69').val();
        var major = dis.closest('.AQLModal69').find('.aql_major69').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal69').find('.aql_normal_level69').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal69').find('.max_major69').val(majorMax);
        dis.closest('.AQLModal69').find('.max_minor69').val(minorMax);
        dis.closest('.AQLModal69').find('.aql_normal_letter69').val(letter);
        dis.closest('.AQLModal69').find('.aql_normal_sampsize69').val(sampsize);
    })

    $('body').on('click', '.confirmAQL69', function() {
        var dis = $(this);
        dis.closest('.part69').find('.main_part_qty69').val(dis.closest('.part69').find('.aql_qty69').val());
        dis.closest('.part69').find('#samples_unit69').val(dis.closest('.part69').find('.aql_normal_sampsize69').val());
        dis.closest('.part69').find('.AQLModal69').modal('hide');

    });

    $('.aql_select69').append('<option value="">--</option>');
    $('.aql_select69').append('<option value="0.065">0.065</option>');
    $('.aql_select69').append('<option value="0.10">0.10</option>');
    $('.aql_select69').append('<option value="0.15">0.15</option>');
    $('.aql_select69').append('<option value="0.25">0.25</option>');
    $('.aql_select69').append('<option value="0.4">0.4</option>');
    $('.aql_select69').append('<option value="0.65">0.65</option>');
    $('.aql_select69').append('<option value="1">1.0</option>');
    $('.aql_select69').append('<option value="1.5">1.5</option>');
    $('.aql_select69').append('<option value="2.5">2.5</option>');
    $('.aql_select69').append('<option value="4">4.0</option>');
    $('.aql_select69').append('<option value="6.5">6.5</option>');
    $('.aql_select69').append('<option value="10">10.0</option>');
    $('.aql_select69').append('<option value="N/A">N/A</option>');

    //70
    $('body').on('click', '.btn-main_part_qty-modal70', function() {
        jQuery.noConflict();
        $('.AQLModal70').modal('show');
    });

    $('body').on('keyup', '.aql_qty70', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal70').find('.aql_minor70').val();
        var major = dis.closest('.AQLModal70').find('.aql_major70').val();
        var lvl = dis.closest('.AQLModal70').find('.aql_normal_level70').val();
        var special_lvl = dis.closest('.AQLModal70').find('.aql_special_level70').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal70').find('.max_major70').val(majorMax);
        dis.closest('.AQLModal70').find('.max_minor70').val(minorMax);
        dis.closest('.AQLModal70').find('.aql_normal_letter70').val(letter);
        dis.closest('.AQLModal70').find('.aql_special_letter70').val(special_letter);
        dis.closest('.AQLModal70').find('.aql_normal_sampsize70').val(sampsize);
        dis.closest('.AQLModal70').find('.aql_special_sampsize70').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level70', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal70').find('.aql_qty70').val();
        var minor = dis.closest('.AQLModal70').find('.aql_minor70').val();
        var major = dis.closest('.AQLModal70').find('.aql_major70').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal70').find('.max_major70').val(majorMax);
        dis.closest('.AQLModal70').find('.max_minor70').val(minorMax);
        dis.closest('.AQLModal70').find('.aql_normal_letter70').val(letter);
        dis.closest('.AQLModal70').find('.aql_normal_sampsize70').val(sampsize);
    })

    $('body').on('change', '.aql_special_level70', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal70').find('.aql_qty70').val();
        var minor = dis.closest('.AQLModal70').find('.aql_minor70').val();
        var major = dis.closest('.AQLModal70').find('.aql_major70').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal70').find('.aql_special_letter70').val(letter);
        dis.closest('.AQLModal70').find('.aql_special_sampsize70').val(sampsize);
    })

    $('body').on('change', '.aql_major70', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal70').find('.aql_qty70').val();
        var minor = dis.closest('.AQLModal70').find('.aql_minor70').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal70').find('.aql_normal_level70').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal70').find('.max_major70').val(majorMax);
        dis.closest('.AQLModal70').find('.max_minor70').val(minorMax);
        dis.closest('.AQLModal70').find('.aql_normal_letter70').val(letter);
        dis.closest('.AQLModal70').find('.aql_normal_sampsize70').val(sampsize);
    })

    $('body').on('change', '.aql_minor70', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal70').find('.aql_qty70').val();
        var major = dis.closest('.AQLModal70').find('.aql_major70').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal70').find('.aql_normal_level70').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal70').find('.max_major70').val(majorMax);
        dis.closest('.AQLModal70').find('.max_minor70').val(minorMax);
        dis.closest('.AQLModal70').find('.aql_normal_letter70').val(letter);
        dis.closest('.AQLModal70').find('.aql_normal_sampsize70').val(sampsize);
    })

    $('body').on('click', '.confirmAQL70', function() {
        var dis = $(this);
        dis.closest('.part70').find('.main_part_qty70').val(dis.closest('.part70').find('.aql_qty70').val());
        dis.closest('.part70').find('#samples_unit70').val(dis.closest('.part70').find('.aql_normal_sampsize70').val());
        dis.closest('.part70').find('.AQLModal70').modal('hide');

    });

    $('.aql_select70').append('<option value="">--</option>');
    $('.aql_select70').append('<option value="0.065">0.065</option>');
    $('.aql_select70').append('<option value="0.10">0.10</option>');
    $('.aql_select70').append('<option value="0.15">0.15</option>');
    $('.aql_select70').append('<option value="0.25">0.25</option>');
    $('.aql_select70').append('<option value="0.4">0.4</option>');
    $('.aql_select70').append('<option value="0.65">0.65</option>');
    $('.aql_select70').append('<option value="1">1.0</option>');
    $('.aql_select70').append('<option value="1.5">1.5</option>');
    $('.aql_select70').append('<option value="2.5">2.5</option>');
    $('.aql_select70').append('<option value="4">4.0</option>');
    $('.aql_select70').append('<option value="6.5">6.5</option>');
    $('.aql_select70').append('<option value="10">10.0</option>');
    $('.aql_select70').append('<option value="N/A">N/A</option>');

    //71
    $('body').on('click', '.btn-main_part_qty-modal71', function() {
        jQuery.noConflict();
        $('.AQLModal71').modal('show');
    });

    $('body').on('keyup', '.aql_qty71', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal71').find('.aql_minor71').val();
        var major = dis.closest('.AQLModal71').find('.aql_major71').val();
        var lvl = dis.closest('.AQLModal71').find('.aql_normal_level71').val();
        var special_lvl = dis.closest('.AQLModal71').find('.aql_special_level71').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal71').find('.max_major71').val(majorMax);
        dis.closest('.AQLModal71').find('.max_minor71').val(minorMax);
        dis.closest('.AQLModal71').find('.aql_normal_letter71').val(letter);
        dis.closest('.AQLModal71').find('.aql_special_letter71').val(special_letter);
        dis.closest('.AQLModal71').find('.aql_normal_sampsize71').val(sampsize);
        dis.closest('.AQLModal71').find('.aql_special_sampsize71').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level71', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal71').find('.aql_qty71').val();
        var minor = dis.closest('.AQLModal71').find('.aql_minor71').val();
        var major = dis.closest('.AQLModal71').find('.aql_major71').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal71').find('.max_major71').val(majorMax);
        dis.closest('.AQLModal71').find('.max_minor71').val(minorMax);
        dis.closest('.AQLModal71').find('.aql_normal_letter71').val(letter);
        dis.closest('.AQLModal71').find('.aql_normal_sampsize71').val(sampsize);
    })

    $('body').on('change', '.aql_special_level71', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal71').find('.aql_qty71').val();
        var minor = dis.closest('.AQLModal71').find('.aql_minor71').val();
        var major = dis.closest('.AQLModal71').find('.aql_major71').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal71').find('.aql_special_letter71').val(letter);
        dis.closest('.AQLModal71').find('.aql_special_sampsize71').val(sampsize);
    })

    $('body').on('change', '.aql_major71', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal71').find('.aql_qty71').val();
        var minor = dis.closest('.AQLModal71').find('.aql_minor71').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal71').find('.aql_normal_level71').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal71').find('.max_major71').val(majorMax);
        dis.closest('.AQLModal71').find('.max_minor71').val(minorMax);
        dis.closest('.AQLModal71').find('.aql_normal_letter71').val(letter);
        dis.closest('.AQLModal71').find('.aql_normal_sampsize71').val(sampsize);
    })

    $('body').on('change', '.aql_minor71', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal71').find('.aql_qty71').val();
        var major = dis.closest('.AQLModal71').find('.aql_major71').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal71').find('.aql_normal_level71').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal71').find('.max_major71').val(majorMax);
        dis.closest('.AQLModal71').find('.max_minor71').val(minorMax);
        dis.closest('.AQLModal71').find('.aql_normal_letter71').val(letter);
        dis.closest('.AQLModal71').find('.aql_normal_sampsize71').val(sampsize);
    })

    $('body').on('click', '.confirmAQL71', function() {
        var dis = $(this);
        dis.closest('.part71').find('.main_part_qty71').val(dis.closest('.part71').find('.aql_qty71').val());
        dis.closest('.part71').find('#samples_unit71').val(dis.closest('.part71').find('.aql_normal_sampsize71').val());
        dis.closest('.part71').find('.AQLModal71').modal('hide');

    });

    $('.aql_select71').append('<option value="">--</option>');
    $('.aql_select71').append('<option value="0.065">0.065</option>');
    $('.aql_select71').append('<option value="0.10">0.10</option>');
    $('.aql_select71').append('<option value="0.15">0.15</option>');
    $('.aql_select71').append('<option value="0.25">0.25</option>');
    $('.aql_select71').append('<option value="0.4">0.4</option>');
    $('.aql_select71').append('<option value="0.65">0.65</option>');
    $('.aql_select71').append('<option value="1">1.0</option>');
    $('.aql_select71').append('<option value="1.5">1.5</option>');
    $('.aql_select71').append('<option value="2.5">2.5</option>');
    $('.aql_select71').append('<option value="4">4.0</option>');
    $('.aql_select71').append('<option value="6.5">6.5</option>');
    $('.aql_select71').append('<option value="10">10.0</option>');
    $('.aql_select71').append('<option value="N/A">N/A</option>');

    //72
    $('body').on('click', '.btn-main_part_qty-modal72', function() {
        jQuery.noConflict();
        $('.AQLModal72').modal('show');
    });

    $('body').on('keyup', '.aql_qty72', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal72').find('.aql_minor72').val();
        var major = dis.closest('.AQLModal72').find('.aql_major72').val();
        var lvl = dis.closest('.AQLModal72').find('.aql_normal_level72').val();
        var special_lvl = dis.closest('.AQLModal72').find('.aql_special_level72').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal72').find('.max_major72').val(majorMax);
        dis.closest('.AQLModal72').find('.max_minor72').val(minorMax);
        dis.closest('.AQLModal72').find('.aql_normal_letter72').val(letter);
        dis.closest('.AQLModal72').find('.aql_special_letter72').val(special_letter);
        dis.closest('.AQLModal72').find('.aql_normal_sampsize72').val(sampsize);
        dis.closest('.AQLModal72').find('.aql_special_sampsize72').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level72', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal72').find('.aql_qty72').val();
        var minor = dis.closest('.AQLModal72').find('.aql_minor72').val();
        var major = dis.closest('.AQLModal72').find('.aql_major72').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal72').find('.max_major72').val(majorMax);
        dis.closest('.AQLModal72').find('.max_minor72').val(minorMax);
        dis.closest('.AQLModal72').find('.aql_normal_letter72').val(letter);
        dis.closest('.AQLModal72').find('.aql_normal_sampsize72').val(sampsize);
    })

    $('body').on('change', '.aql_special_level72', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal72').find('.aql_qty72').val();
        var minor = dis.closest('.AQLModal72').find('.aql_minor72').val();
        var major = dis.closest('.AQLModal72').find('.aql_major72').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal72').find('.aql_special_letter72').val(letter);
        dis.closest('.AQLModal72').find('.aql_special_sampsize72').val(sampsize);
    })

    $('body').on('change', '.aql_major72', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal72').find('.aql_qty72').val();
        var minor = dis.closest('.AQLModal72').find('.aql_minor72').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal72').find('.aql_normal_level72').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal72').find('.max_major72').val(majorMax);
        dis.closest('.AQLModal72').find('.max_minor72').val(minorMax);
        dis.closest('.AQLModal72').find('.aql_normal_letter72').val(letter);
        dis.closest('.AQLModal72').find('.aql_normal_sampsize72').val(sampsize);
    })

    $('body').on('change', '.aql_minor72', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal72').find('.aql_qty72').val();
        var major = dis.closest('.AQLModal72').find('.aql_major72').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal72').find('.aql_normal_level72').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal72').find('.max_major72').val(majorMax);
        dis.closest('.AQLModal72').find('.max_minor72').val(minorMax);
        dis.closest('.AQLModal72').find('.aql_normal_letter72').val(letter);
        dis.closest('.AQLModal72').find('.aql_normal_sampsize72').val(sampsize);
    })

    $('body').on('click', '.confirmAQL72', function() {
        var dis = $(this);
        dis.closest('.part72').find('.main_part_qty72').val(dis.closest('.part72').find('.aql_qty72').val());
        dis.closest('.part72').find('#samples_unit72').val(dis.closest('.part72').find('.aql_normal_sampsize72').val());
        dis.closest('.part72').find('.AQLModal72').modal('hide');

    });

    $('.aql_select72').append('<option value="">--</option>');
    $('.aql_select72').append('<option value="0.065">0.065</option>');
    $('.aql_select72').append('<option value="0.10">0.10</option>');
    $('.aql_select72').append('<option value="0.15">0.15</option>');
    $('.aql_select72').append('<option value="0.25">0.25</option>');
    $('.aql_select72').append('<option value="0.4">0.4</option>');
    $('.aql_select72').append('<option value="0.65">0.65</option>');
    $('.aql_select72').append('<option value="1">1.0</option>');
    $('.aql_select72').append('<option value="1.5">1.5</option>');
    $('.aql_select72').append('<option value="2.5">2.5</option>');
    $('.aql_select72').append('<option value="4">4.0</option>');
    $('.aql_select72').append('<option value="6.5">6.5</option>');
    $('.aql_select72').append('<option value="10">10.0</option>');
    $('.aql_select72').append('<option value="N/A">N/A</option>');

    //73
    $('body').on('click', '.btn-main_part_qty-modal73', function() {
        jQuery.noConflict();
        $('.AQLModal73').modal('show');
    });

    $('body').on('keyup', '.aql_qty73', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal73').find('.aql_minor73').val();
        var major = dis.closest('.AQLModal73').find('.aql_major73').val();
        var lvl = dis.closest('.AQLModal73').find('.aql_normal_level73').val();
        var special_lvl = dis.closest('.AQLModal73').find('.aql_special_level73').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal73').find('.max_major73').val(majorMax);
        dis.closest('.AQLModal73').find('.max_minor73').val(minorMax);
        dis.closest('.AQLModal73').find('.aql_normal_letter73').val(letter);
        dis.closest('.AQLModal73').find('.aql_special_letter73').val(special_letter);
        dis.closest('.AQLModal73').find('.aql_normal_sampsize73').val(sampsize);
        dis.closest('.AQLModal73').find('.aql_special_sampsize73').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level73', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal73').find('.aql_qty73').val();
        var minor = dis.closest('.AQLModal73').find('.aql_minor73').val();
        var major = dis.closest('.AQLModal73').find('.aql_major73').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal73').find('.max_major73').val(majorMax);
        dis.closest('.AQLModal73').find('.max_minor73').val(minorMax);
        dis.closest('.AQLModal73').find('.aql_normal_letter73').val(letter);
        dis.closest('.AQLModal73').find('.aql_normal_sampsize73').val(sampsize);
    })

    $('body').on('change', '.aql_special_level73', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal73').find('.aql_qty73').val();
        var minor = dis.closest('.AQLModal73').find('.aql_minor73').val();
        var major = dis.closest('.AQLModal73').find('.aql_major73').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal73').find('.aql_special_letter73').val(letter);
        dis.closest('.AQLModal73').find('.aql_special_sampsize73').val(sampsize);
    })

    $('body').on('change', '.aql_major73', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal73').find('.aql_qty73').val();
        var minor = dis.closest('.AQLModal73').find('.aql_minor73').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal73').find('.aql_normal_level73').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal73').find('.max_major73').val(majorMax);
        dis.closest('.AQLModal73').find('.max_minor73').val(minorMax);
        dis.closest('.AQLModal73').find('.aql_normal_letter73').val(letter);
        dis.closest('.AQLModal73').find('.aql_normal_sampsize73').val(sampsize);
    })

    $('body').on('change', '.aql_minor73', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal73').find('.aql_qty73').val();
        var major = dis.closest('.AQLModal73').find('.aql_major73').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal73').find('.aql_normal_level73').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal73').find('.max_major73').val(majorMax);
        dis.closest('.AQLModal73').find('.max_minor73').val(minorMax);
        dis.closest('.AQLModal73').find('.aql_normal_letter73').val(letter);
        dis.closest('.AQLModal73').find('.aql_normal_sampsize73').val(sampsize);
    })

    $('body').on('click', '.confirmAQL73', function() {
        var dis = $(this);
        dis.closest('.part73').find('.main_part_qty73').val(dis.closest('.part73').find('.aql_qty73').val());
        dis.closest('.part73').find('#samples_unit73').val(dis.closest('.part73').find('.aql_normal_sampsize73').val());
        dis.closest('.part73').find('.AQLModal73').modal('hide');

    });

    $('.aql_select73').append('<option value="">--</option>');
    $('.aql_select73').append('<option value="0.065">0.065</option>');
    $('.aql_select73').append('<option value="0.10">0.10</option>');
    $('.aql_select73').append('<option value="0.15">0.15</option>');
    $('.aql_select73').append('<option value="0.25">0.25</option>');
    $('.aql_select73').append('<option value="0.4">0.4</option>');
    $('.aql_select73').append('<option value="0.65">0.65</option>');
    $('.aql_select73').append('<option value="1">1.0</option>');
    $('.aql_select73').append('<option value="1.5">1.5</option>');
    $('.aql_select73').append('<option value="2.5">2.5</option>');
    $('.aql_select73').append('<option value="4">4.0</option>');
    $('.aql_select73').append('<option value="6.5">6.5</option>');
    $('.aql_select73').append('<option value="10">10.0</option>');
    $('.aql_select73').append('<option value="N/A">N/A</option>');

    //74
    $('body').on('click', '.btn-main_part_qty-modal74', function() {
        jQuery.noConflict();
        $('.AQLModal74').modal('show');
    });

    $('body').on('keyup', '.aql_qty74', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal74').find('.aql_minor74').val();
        var major = dis.closest('.AQLModal74').find('.aql_major74').val();
        var lvl = dis.closest('.AQLModal74').find('.aql_normal_level74').val();
        var special_lvl = dis.closest('.AQLModal74').find('.aql_special_level74').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal74').find('.max_major74').val(majorMax);
        dis.closest('.AQLModal74').find('.max_minor74').val(minorMax);
        dis.closest('.AQLModal74').find('.aql_normal_letter74').val(letter);
        dis.closest('.AQLModal74').find('.aql_special_letter74').val(special_letter);
        dis.closest('.AQLModal74').find('.aql_normal_sampsize74').val(sampsize);
        dis.closest('.AQLModal74').find('.aql_special_sampsize74').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level74', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal74').find('.aql_qty74').val();
        var minor = dis.closest('.AQLModal74').find('.aql_minor74').val();
        var major = dis.closest('.AQLModal74').find('.aql_major74').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal74').find('.max_major74').val(majorMax);
        dis.closest('.AQLModal74').find('.max_minor74').val(minorMax);
        dis.closest('.AQLModal74').find('.aql_normal_letter74').val(letter);
        dis.closest('.AQLModal74').find('.aql_normal_sampsize74').val(sampsize);
    })

    $('body').on('change', '.aql_special_level74', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal74').find('.aql_qty74').val();
        var minor = dis.closest('.AQLModal74').find('.aql_minor74').val();
        var major = dis.closest('.AQLModal74').find('.aql_major74').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal74').find('.aql_special_letter74').val(letter);
        dis.closest('.AQLModal74').find('.aql_special_sampsize74').val(sampsize);
    })

    $('body').on('change', '.aql_major74', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal74').find('.aql_qty74').val();
        var minor = dis.closest('.AQLModal74').find('.aql_minor74').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal74').find('.aql_normal_level74').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal74').find('.max_major74').val(majorMax);
        dis.closest('.AQLModal74').find('.max_minor74').val(minorMax);
        dis.closest('.AQLModal74').find('.aql_normal_letter74').val(letter);
        dis.closest('.AQLModal74').find('.aql_normal_sampsize74').val(sampsize);
    })

    $('body').on('change', '.aql_minor74', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal74').find('.aql_qty74').val();
        var major = dis.closest('.AQLModal74').find('.aql_major74').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal74').find('.aql_normal_level74').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal74').find('.max_major74').val(majorMax);
        dis.closest('.AQLModal74').find('.max_minor74').val(minorMax);
        dis.closest('.AQLModal74').find('.aql_normal_letter74').val(letter);
        dis.closest('.AQLModal74').find('.aql_normal_sampsize74').val(sampsize);
    })

    $('body').on('click', '.confirmAQL74', function() {
        var dis = $(this);
        dis.closest('.part74').find('.main_part_qty74').val(dis.closest('.part74').find('.aql_qty74').val());
        dis.closest('.part74').find('#samples_unit74').val(dis.closest('.part74').find('.aql_normal_sampsize74').val());
        dis.closest('.part74').find('.AQLModal74').modal('hide');

    });

    $('.aql_select74').append('<option value="">--</option>');
    $('.aql_select74').append('<option value="0.065">0.065</option>');
    $('.aql_select74').append('<option value="0.10">0.10</option>');
    $('.aql_select74').append('<option value="0.15">0.15</option>');
    $('.aql_select74').append('<option value="0.25">0.25</option>');
    $('.aql_select74').append('<option value="0.4">0.4</option>');
    $('.aql_select74').append('<option value="0.65">0.65</option>');
    $('.aql_select74').append('<option value="1">1.0</option>');
    $('.aql_select74').append('<option value="1.5">1.5</option>');
    $('.aql_select74').append('<option value="2.5">2.5</option>');
    $('.aql_select74').append('<option value="4">4.0</option>');
    $('.aql_select74').append('<option value="6.5">6.5</option>');
    $('.aql_select74').append('<option value="10">10.0</option>');
    $('.aql_select74').append('<option value="N/A">N/A</option>');

    //75
    $('body').on('click', '.btn-main_part_qty-modal75', function() {
        jQuery.noConflict();
        $('.AQLModal75').modal('show');
    });

    $('body').on('keyup', '.aql_qty75', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal75').find('.aql_minor75').val();
        var major = dis.closest('.AQLModal75').find('.aql_major75').val();
        var lvl = dis.closest('.AQLModal75').find('.aql_normal_level75').val();
        var special_lvl = dis.closest('.AQLModal75').find('.aql_special_level75').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal75').find('.max_major75').val(majorMax);
        dis.closest('.AQLModal75').find('.max_minor75').val(minorMax);
        dis.closest('.AQLModal75').find('.aql_normal_letter75').val(letter);
        dis.closest('.AQLModal75').find('.aql_special_letter75').val(special_letter);
        dis.closest('.AQLModal75').find('.aql_normal_sampsize75').val(sampsize);
        dis.closest('.AQLModal75').find('.aql_special_sampsize75').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level75', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal75').find('.aql_qty75').val();
        var minor = dis.closest('.AQLModal75').find('.aql_minor75').val();
        var major = dis.closest('.AQLModal75').find('.aql_major75').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal75').find('.max_major75').val(majorMax);
        dis.closest('.AQLModal75').find('.max_minor75').val(minorMax);
        dis.closest('.AQLModal75').find('.aql_normal_letter75').val(letter);
        dis.closest('.AQLModal75').find('.aql_normal_sampsize75').val(sampsize);
    })

    $('body').on('change', '.aql_special_level75', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal75').find('.aql_qty75').val();
        var minor = dis.closest('.AQLModal75').find('.aql_minor75').val();
        var major = dis.closest('.AQLModal75').find('.aql_major75').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal75').find('.aql_special_letter75').val(letter);
        dis.closest('.AQLModal75').find('.aql_special_sampsize75').val(sampsize);
    })

    $('body').on('change', '.aql_major75', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal75').find('.aql_qty75').val();
        var minor = dis.closest('.AQLModal75').find('.aql_minor75').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal75').find('.aql_normal_level75').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal75').find('.max_major75').val(majorMax);
        dis.closest('.AQLModal75').find('.max_minor75').val(minorMax);
        dis.closest('.AQLModal75').find('.aql_normal_letter75').val(letter);
        dis.closest('.AQLModal75').find('.aql_normal_sampsize75').val(sampsize);
    })

    $('body').on('change', '.aql_minor75', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal75').find('.aql_qty75').val();
        var major = dis.closest('.AQLModal75').find('.aql_major75').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal75').find('.aql_normal_level75').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal75').find('.max_major75').val(majorMax);
        dis.closest('.AQLModal75').find('.max_minor75').val(minorMax);
        dis.closest('.AQLModal75').find('.aql_normal_letter75').val(letter);
        dis.closest('.AQLModal75').find('.aql_normal_sampsize75').val(sampsize);
    })

    $('body').on('click', '.confirmAQL75', function() {
        var dis = $(this);
        dis.closest('.part75').find('.main_part_qty75').val(dis.closest('.part75').find('.aql_qty75').val());
        dis.closest('.part75').find('#samples_unit75').val(dis.closest('.part75').find('.aql_normal_sampsize75').val());
        dis.closest('.part75').find('.AQLModal75').modal('hide');

    });

    $('.aql_select75').append('<option value="">--</option>');
    $('.aql_select75').append('<option value="0.065">0.065</option>');
    $('.aql_select75').append('<option value="0.10">0.10</option>');
    $('.aql_select75').append('<option value="0.15">0.15</option>');
    $('.aql_select75').append('<option value="0.25">0.25</option>');
    $('.aql_select75').append('<option value="0.4">0.4</option>');
    $('.aql_select75').append('<option value="0.65">0.65</option>');
    $('.aql_select75').append('<option value="1">1.0</option>');
    $('.aql_select75').append('<option value="1.5">1.5</option>');
    $('.aql_select75').append('<option value="2.5">2.5</option>');
    $('.aql_select75').append('<option value="4">4.0</option>');
    $('.aql_select75').append('<option value="6.5">6.5</option>');
    $('.aql_select75').append('<option value="10">10.0</option>');
    $('.aql_select75').append('<option value="N/A">N/A</option>');

    //76
    $('body').on('click', '.btn-main_part_qty-modal76', function() {
        jQuery.noConflict();
        $('.AQLModal76').modal('show');
    });

    $('body').on('keyup', '.aql_qty76', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal76').find('.aql_minor76').val();
        var major = dis.closest('.AQLModal76').find('.aql_major76').val();
        var lvl = dis.closest('.AQLModal76').find('.aql_normal_level76').val();
        var special_lvl = dis.closest('.AQLModal76').find('.aql_special_level76').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal76').find('.max_major76').val(majorMax);
        dis.closest('.AQLModal76').find('.max_minor76').val(minorMax);
        dis.closest('.AQLModal76').find('.aql_normal_letter76').val(letter);
        dis.closest('.AQLModal76').find('.aql_special_letter76').val(special_letter);
        dis.closest('.AQLModal76').find('.aql_normal_sampsize76').val(sampsize);
        dis.closest('.AQLModal76').find('.aql_special_sampsize76').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level76', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal76').find('.aql_qty76').val();
        var minor = dis.closest('.AQLModal76').find('.aql_minor76').val();
        var major = dis.closest('.AQLModal76').find('.aql_major76').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal76').find('.max_major76').val(majorMax);
        dis.closest('.AQLModal76').find('.max_minor76').val(minorMax);
        dis.closest('.AQLModal76').find('.aql_normal_letter76').val(letter);
        dis.closest('.AQLModal76').find('.aql_normal_sampsize76').val(sampsize);
    })

    $('body').on('change', '.aql_special_level76', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal76').find('.aql_qty76').val();
        var minor = dis.closest('.AQLModal76').find('.aql_minor76').val();
        var major = dis.closest('.AQLModal76').find('.aql_major76').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal76').find('.aql_special_letter76').val(letter);
        dis.closest('.AQLModal76').find('.aql_special_sampsize76').val(sampsize);
    })

    $('body').on('change', '.aql_major76', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal76').find('.aql_qty76').val();
        var minor = dis.closest('.AQLModal76').find('.aql_minor76').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal76').find('.aql_normal_level76').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal76').find('.max_major76').val(majorMax);
        dis.closest('.AQLModal76').find('.max_minor76').val(minorMax);
        dis.closest('.AQLModal76').find('.aql_normal_letter76').val(letter);
        dis.closest('.AQLModal76').find('.aql_normal_sampsize76').val(sampsize);
    })

    $('body').on('change', '.aql_minor76', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal76').find('.aql_qty76').val();
        var major = dis.closest('.AQLModal76').find('.aql_major76').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal76').find('.aql_normal_level76').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal76').find('.max_major76').val(majorMax);
        dis.closest('.AQLModal76').find('.max_minor76').val(minorMax);
        dis.closest('.AQLModal76').find('.aql_normal_letter76').val(letter);
        dis.closest('.AQLModal76').find('.aql_normal_sampsize76').val(sampsize);
    })

    $('body').on('click', '.confirmAQL76', function() {
        var dis = $(this);
        dis.closest('.part76').find('.main_part_qty76').val(dis.closest('.part76').find('.aql_qty76').val());
        dis.closest('.part76').find('#samples_unit76').val(dis.closest('.part76').find('.aql_normal_sampsize76').val());
        dis.closest('.part76').find('.AQLModal76').modal('hide');

    });

    $('.aql_select76').append('<option value="">--</option>');
    $('.aql_select76').append('<option value="0.065">0.065</option>');
    $('.aql_select76').append('<option value="0.10">0.10</option>');
    $('.aql_select76').append('<option value="0.15">0.15</option>');
    $('.aql_select76').append('<option value="0.25">0.25</option>');
    $('.aql_select76').append('<option value="0.4">0.4</option>');
    $('.aql_select76').append('<option value="0.65">0.65</option>');
    $('.aql_select76').append('<option value="1">1.0</option>');
    $('.aql_select76').append('<option value="1.5">1.5</option>');
    $('.aql_select76').append('<option value="2.5">2.5</option>');
    $('.aql_select76').append('<option value="4">4.0</option>');
    $('.aql_select76').append('<option value="6.5">6.5</option>');
    $('.aql_select76').append('<option value="10">10.0</option>');
    $('.aql_select76').append('<option value="N/A">N/A</option>');

    //77
    $('body').on('click', '.btn-main_part_qty-modal77', function() {
        jQuery.noConflict();
        $('.AQLModal77').modal('show');
    });

    $('body').on('keyup', '.aql_qty77', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal77').find('.aql_minor77').val();
        var major = dis.closest('.AQLModal77').find('.aql_major77').val();
        var lvl = dis.closest('.AQLModal77').find('.aql_normal_level77').val();
        var special_lvl = dis.closest('.AQLModal77').find('.aql_special_level77').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal77').find('.max_major77').val(majorMax);
        dis.closest('.AQLModal77').find('.max_minor77').val(minorMax);
        dis.closest('.AQLModal77').find('.aql_normal_letter77').val(letter);
        dis.closest('.AQLModal77').find('.aql_special_letter77').val(special_letter);
        dis.closest('.AQLModal77').find('.aql_normal_sampsize77').val(sampsize);
        dis.closest('.AQLModal77').find('.aql_special_sampsize77').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level77', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal77').find('.aql_qty77').val();
        var minor = dis.closest('.AQLModal77').find('.aql_minor77').val();
        var major = dis.closest('.AQLModal77').find('.aql_major77').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal77').find('.max_major77').val(majorMax);
        dis.closest('.AQLModal77').find('.max_minor77').val(minorMax);
        dis.closest('.AQLModal77').find('.aql_normal_letter77').val(letter);
        dis.closest('.AQLModal77').find('.aql_normal_sampsize77').val(sampsize);
    })

    $('body').on('change', '.aql_special_level77', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal77').find('.aql_qty77').val();
        var minor = dis.closest('.AQLModal77').find('.aql_minor77').val();
        var major = dis.closest('.AQLModal77').find('.aql_major77').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal77').find('.aql_special_letter77').val(letter);
        dis.closest('.AQLModal77').find('.aql_special_sampsize77').val(sampsize);
    })

    $('body').on('change', '.aql_major77', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal77').find('.aql_qty77').val();
        var minor = dis.closest('.AQLModal77').find('.aql_minor77').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal77').find('.aql_normal_level77').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal77').find('.max_major77').val(majorMax);
        dis.closest('.AQLModal77').find('.max_minor77').val(minorMax);
        dis.closest('.AQLModal77').find('.aql_normal_letter77').val(letter);
        dis.closest('.AQLModal77').find('.aql_normal_sampsize77').val(sampsize);
    })

    $('body').on('change', '.aql_minor77', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal77').find('.aql_qty77').val();
        var major = dis.closest('.AQLModal77').find('.aql_major77').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal77').find('.aql_normal_level77').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal77').find('.max_major77').val(majorMax);
        dis.closest('.AQLModal77').find('.max_minor77').val(minorMax);
        dis.closest('.AQLModal77').find('.aql_normal_letter77').val(letter);
        dis.closest('.AQLModal77').find('.aql_normal_sampsize77').val(sampsize);
    })

    $('body').on('click', '.confirmAQL77', function() {
        var dis = $(this);
        dis.closest('.part77').find('.main_part_qty77').val(dis.closest('.part77').find('.aql_qty77').val());
        dis.closest('.part77').find('#samples_unit77').val(dis.closest('.part77').find('.aql_normal_sampsize77').val());
        dis.closest('.part77').find('.AQLModal77').modal('hide');

    });

    $('.aql_select77').append('<option value="">--</option>');
    $('.aql_select77').append('<option value="0.065">0.065</option>');
    $('.aql_select77').append('<option value="0.10">0.10</option>');
    $('.aql_select77').append('<option value="0.15">0.15</option>');
    $('.aql_select77').append('<option value="0.25">0.25</option>');
    $('.aql_select77').append('<option value="0.4">0.4</option>');
    $('.aql_select77').append('<option value="0.65">0.65</option>');
    $('.aql_select77').append('<option value="1">1.0</option>');
    $('.aql_select77').append('<option value="1.5">1.5</option>');
    $('.aql_select77').append('<option value="2.5">2.5</option>');
    $('.aql_select77').append('<option value="4">4.0</option>');
    $('.aql_select77').append('<option value="6.5">6.5</option>');
    $('.aql_select77').append('<option value="10">10.0</option>');
    $('.aql_select77').append('<option value="N/A">N/A</option>');

    //
    $('body').on('click', '.btn-main_part_qty-modal78', function() {
        jQuery.noConflict();
        $('.AQLModal78').modal('show');
    });

    $('body').on('keyup', '.aql_qty78', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal78').find('.aql_minor78').val();
        var major = dis.closest('.AQLModal78').find('.aql_major78').val();
        var lvl = dis.closest('.AQLModal78').find('.aql_normal_level78').val();
        var special_lvl = dis.closest('.AQLModal78').find('.aql_special_level78').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal78').find('.max_major78').val(majorMax);
        dis.closest('.AQLModal78').find('.max_minor78').val(minorMax);
        dis.closest('.AQLModal78').find('.aql_normal_letter78').val(letter);
        dis.closest('.AQLModal78').find('.aql_special_letter78').val(special_letter);
        dis.closest('.AQLModal78').find('.aql_normal_sampsize78').val(sampsize);
        dis.closest('.AQLModal78').find('.aql_special_sampsize78').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level78', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal78').find('.aql_qty78').val();
        var minor = dis.closest('.AQLModal78').find('.aql_minor78').val();
        var major = dis.closest('.AQLModal78').find('.aql_major78').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal78').find('.max_major78').val(majorMax);
        dis.closest('.AQLModal78').find('.max_minor78').val(minorMax);
        dis.closest('.AQLModal78').find('.aql_normal_letter78').val(letter);
        dis.closest('.AQLModal78').find('.aql_normal_sampsize78').val(sampsize);
    })

    $('body').on('change', '.aql_special_level78', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal78').find('.aql_qty78').val();
        var minor = dis.closest('.AQLModal78').find('.aql_minor78').val();
        var major = dis.closest('.AQLModal78').find('.aql_major78').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal78').find('.aql_special_letter78').val(letter);
        dis.closest('.AQLModal78').find('.aql_special_sampsize78').val(sampsize);
    })

    $('body').on('change', '.aql_major78', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal78').find('.aql_qty78').val();
        var minor = dis.closest('.AQLModal78').find('.aql_minor78').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal78').find('.aql_normal_level78').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal78').find('.max_major78').val(majorMax);
        dis.closest('.AQLModal78').find('.max_minor78').val(minorMax);
        dis.closest('.AQLModal78').find('.aql_normal_letter78').val(letter);
        dis.closest('.AQLModal78').find('.aql_normal_sampsize78').val(sampsize);
    })

    $('body').on('change', '.aql_minor78', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal78').find('.aql_qty78').val();
        var major = dis.closest('.AQLModal78').find('.aql_major78').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal78').find('.aql_normal_level78').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal78').find('.max_major78').val(majorMax);
        dis.closest('.AQLModal78').find('.max_minor78').val(minorMax);
        dis.closest('.AQLModal78').find('.aql_normal_letter78').val(letter);
        dis.closest('.AQLModal78').find('.aql_normal_sampsize78').val(sampsize);
    })

    $('body').on('click', '.confirmAQL78', function() {
        var dis = $(this);
        dis.closest('.part78').find('.main_part_qty78').val(dis.closest('.part78').find('.aql_qty78').val());
        dis.closest('.part78').find('#samples_unit78').val(dis.closest('.part78').find('.aql_normal_sampsize78').val());
        dis.closest('.part78').find('.AQLModal78').modal('hide');

    });

    $('.aql_select78').append('<option value="">--</option>');
    $('.aql_select78').append('<option value="0.065">0.065</option>');
    $('.aql_select78').append('<option value="0.10">0.10</option>');
    $('.aql_select78').append('<option value="0.15">0.15</option>');
    $('.aql_select78').append('<option value="0.25">0.25</option>');
    $('.aql_select78').append('<option value="0.4">0.4</option>');
    $('.aql_select78').append('<option value="0.65">0.65</option>');
    $('.aql_select78').append('<option value="1">1.0</option>');
    $('.aql_select78').append('<option value="1.5">1.5</option>');
    $('.aql_select78').append('<option value="2.5">2.5</option>');
    $('.aql_select78').append('<option value="4">4.0</option>');
    $('.aql_select78').append('<option value="6.5">6.5</option>');
    $('.aql_select78').append('<option value="10">10.0</option>');
    $('.aql_select78').append('<option value="N/A">N/A</option>');

    //79
    $('body').on('click', '.btn-main_part_qty-modal79', function() {
        jQuery.noConflict();
        $('.AQLModal79').modal('show');
    });

    $('body').on('keyup', '.aql_qty79', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal79').find('.aql_minor79').val();
        var major = dis.closest('.AQLModal79').find('.aql_major79').val();
        var lvl = dis.closest('.AQLModal79').find('.aql_normal_level79').val();
        var special_lvl = dis.closest('.AQLModal79').find('.aql_special_level79').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal79').find('.max_major79').val(majorMax);
        dis.closest('.AQLModal79').find('.max_minor79').val(minorMax);
        dis.closest('.AQLModal79').find('.aql_normal_letter79').val(letter);
        dis.closest('.AQLModal79').find('.aql_special_letter79').val(special_letter);
        dis.closest('.AQLModal79').find('.aql_normal_sampsize79').val(sampsize);
        dis.closest('.AQLModal79').find('.aql_special_sampsize79').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level79', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal79').find('.aql_qty79').val();
        var minor = dis.closest('.AQLModal79').find('.aql_minor79').val();
        var major = dis.closest('.AQLModal79').find('.aql_major79').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal79').find('.max_major79').val(majorMax);
        dis.closest('.AQLModal79').find('.max_minor79').val(minorMax);
        dis.closest('.AQLModal79').find('.aql_normal_letter79').val(letter);
        dis.closest('.AQLModal79').find('.aql_normal_sampsize79').val(sampsize);
    })

    $('body').on('change', '.aql_special_level79', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal79').find('.aql_qty79').val();
        var minor = dis.closest('.AQLModal79').find('.aql_minor79').val();
        var major = dis.closest('.AQLModal79').find('.aql_major79').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal79').find('.aql_special_letter79').val(letter);
        dis.closest('.AQLModal79').find('.aql_special_sampsize79').val(sampsize);
    })

    $('body').on('change', '.aql_major79', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal79').find('.aql_qty79').val();
        var minor = dis.closest('.AQLModal79').find('.aql_minor79').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal79').find('.aql_normal_level79').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal79').find('.max_major79').val(majorMax);
        dis.closest('.AQLModal79').find('.max_minor79').val(minorMax);
        dis.closest('.AQLModal79').find('.aql_normal_letter79').val(letter);
        dis.closest('.AQLModal79').find('.aql_normal_sampsize79').val(sampsize);
    })

    $('body').on('change', '.aql_minor79', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal79').find('.aql_qty79').val();
        var major = dis.closest('.AQLModal79').find('.aql_major79').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal79').find('.aql_normal_level79').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal79').find('.max_major79').val(majorMax);
        dis.closest('.AQLModal79').find('.max_minor79').val(minorMax);
        dis.closest('.AQLModal79').find('.aql_normal_letter79').val(letter);
        dis.closest('.AQLModal79').find('.aql_normal_sampsize79').val(sampsize);
    })

    $('body').on('click', '.confirmAQL79', function() {
        var dis = $(this);
        dis.closest('.part79').find('.main_part_qty79').val(dis.closest('.part79').find('.aql_qty79').val());
        dis.closest('.part79').find('#samples_unit79').val(dis.closest('.part79').find('.aql_normal_sampsize79').val());
        dis.closest('.part79').find('.AQLModal79').modal('hide');

    });

    $('.aql_select79').append('<option value="">--</option>');
    $('.aql_select79').append('<option value="0.065">0.065</option>');
    $('.aql_select79').append('<option value="0.10">0.10</option>');
    $('.aql_select79').append('<option value="0.15">0.15</option>');
    $('.aql_select79').append('<option value="0.25">0.25</option>');
    $('.aql_select79').append('<option value="0.4">0.4</option>');
    $('.aql_select79').append('<option value="0.65">0.65</option>');
    $('.aql_select79').append('<option value="1">1.0</option>');
    $('.aql_select79').append('<option value="1.5">1.5</option>');
    $('.aql_select79').append('<option value="2.5">2.5</option>');
    $('.aql_select79').append('<option value="4">4.0</option>');
    $('.aql_select79').append('<option value="6.5">6.5</option>');
    $('.aql_select79').append('<option value="10">10.0</option>');
    $('.aql_select79').append('<option value="N/A">N/A</option>');

    //80
    $('body').on('click', '.btn-main_part_qty-modal80', function() {
        jQuery.noConflict();
        $('.AQLModal80').modal('show');
    });

    $('body').on('keyup', '.aql_qty80', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal80').find('.aql_minor80').val();
        var major = dis.closest('.AQLModal80').find('.aql_major80').val();
        var lvl = dis.closest('.AQLModal80').find('.aql_normal_level80').val();
        var special_lvl = dis.closest('.AQLModal80').find('.aql_special_level80').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal80').find('.max_major80').val(majorMax);
        dis.closest('.AQLModal80').find('.max_minor80').val(minorMax);
        dis.closest('.AQLModal80').find('.aql_normal_letter80').val(letter);
        dis.closest('.AQLModal80').find('.aql_special_letter80').val(special_letter);
        dis.closest('.AQLModal80').find('.aql_normal_sampsize80').val(sampsize);
        dis.closest('.AQLModal80').find('.aql_special_sampsize80').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level80', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal80').find('.aql_qty80').val();
        var minor = dis.closest('.AQLModal80').find('.aql_minor80').val();
        var major = dis.closest('.AQLModal80').find('.aql_major80').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal80').find('.max_major80').val(majorMax);
        dis.closest('.AQLModal80').find('.max_minor80').val(minorMax);
        dis.closest('.AQLModal80').find('.aql_normal_letter80').val(letter);
        dis.closest('.AQLModal80').find('.aql_normal_sampsize80').val(sampsize);
    })

    $('body').on('change', '.aql_special_level80', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal80').find('.aql_qty80').val();
        var minor = dis.closest('.AQLModal80').find('.aql_minor80').val();
        var major = dis.closest('.AQLModal80').find('.aql_major80').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal80').find('.aql_special_letter80').val(letter);
        dis.closest('.AQLModal80').find('.aql_special_sampsize80').val(sampsize);
    })

    $('body').on('change', '.aql_major80', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal80').find('.aql_qty80').val();
        var minor = dis.closest('.AQLModal80').find('.aql_minor80').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal80').find('.aql_normal_level80').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal80').find('.max_major80').val(majorMax);
        dis.closest('.AQLModal80').find('.max_minor80').val(minorMax);
        dis.closest('.AQLModal80').find('.aql_normal_letter80').val(letter);
        dis.closest('.AQLModal80').find('.aql_normal_sampsize80').val(sampsize);
    })

    $('body').on('change', '.aql_minor80', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal80').find('.aql_qty80').val();
        var major = dis.closest('.AQLModal80').find('.aql_major80').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal80').find('.aql_normal_level80').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal80').find('.max_major80').val(majorMax);
        dis.closest('.AQLModal80').find('.max_minor80').val(minorMax);
        dis.closest('.AQLModal80').find('.aql_normal_letter80').val(letter);
        dis.closest('.AQLModal80').find('.aql_normal_sampsize80').val(sampsize);
    })

    $('body').on('click', '.confirmAQL80', function() {
        var dis = $(this);
        dis.closest('.part80').find('.main_part_qty80').val(dis.closest('.part80').find('.aql_qty80').val());
        dis.closest('.part80').find('#samples_unit80').val(dis.closest('.part80').find('.aql_normal_sampsize80').val());
        dis.closest('.part80').find('.AQLModal80').modal('hide');

    });

    $('.aql_select80').append('<option value="">--</option>');
    $('.aql_select80').append('<option value="0.065">0.065</option>');
    $('.aql_select80').append('<option value="0.10">0.10</option>');
    $('.aql_select80').append('<option value="0.15">0.15</option>');
    $('.aql_select80').append('<option value="0.25">0.25</option>');
    $('.aql_select80').append('<option value="0.4">0.4</option>');
    $('.aql_select80').append('<option value="0.65">0.65</option>');
    $('.aql_select80').append('<option value="1">1.0</option>');
    $('.aql_select80').append('<option value="1.5">1.5</option>');
    $('.aql_select80').append('<option value="2.5">2.5</option>');
    $('.aql_select80').append('<option value="4">4.0</option>');
    $('.aql_select80').append('<option value="6.5">6.5</option>');
    $('.aql_select80').append('<option value="10">10.0</option>');
    $('.aql_select80').append('<option value="N/A">N/A</option>');

    //81
    $('body').on('click', '.btn-main_part_qty-modal81', function() {
        jQuery.noConflict();
        $('.AQLModal81').modal('show');
    });

    $('body').on('keyup', '.aql_qty81', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal81').find('.aql_minor81').val();
        var major = dis.closest('.AQLModal81').find('.aql_major81').val();
        var lvl = dis.closest('.AQLModal81').find('.aql_normal_level81').val();
        var special_lvl = dis.closest('.AQLModal81').find('.aql_special_level81').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal81').find('.max_major81').val(majorMax);
        dis.closest('.AQLModal81').find('.max_minor81').val(minorMax);
        dis.closest('.AQLModal81').find('.aql_normal_letter81').val(letter);
        dis.closest('.AQLModal81').find('.aql_special_letter81').val(special_letter);
        dis.closest('.AQLModal81').find('.aql_normal_sampsize81').val(sampsize);
        dis.closest('.AQLModal81').find('.aql_special_sampsize81').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level81', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal81').find('.aql_qty81').val();
        var minor = dis.closest('.AQLModal81').find('.aql_minor81').val();
        var major = dis.closest('.AQLModal81').find('.aql_major81').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal81').find('.max_major81').val(majorMax);
        dis.closest('.AQLModal81').find('.max_minor81').val(minorMax);
        dis.closest('.AQLModal81').find('.aql_normal_letter81').val(letter);
        dis.closest('.AQLModal81').find('.aql_normal_sampsize81').val(sampsize);
    })

    $('body').on('change', '.aql_special_level81', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal81').find('.aql_qty81').val();
        var minor = dis.closest('.AQLModal81').find('.aql_minor81').val();
        var major = dis.closest('.AQLModal81').find('.aql_major81').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal81').find('.aql_special_letter81').val(letter);
        dis.closest('.AQLModal81').find('.aql_special_sampsize81').val(sampsize);
    })

    $('body').on('change', '.aql_major81', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal81').find('.aql_qty81').val();
        var minor = dis.closest('.AQLModal81').find('.aql_minor81').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal81').find('.aql_normal_level81').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal81').find('.max_major81').val(majorMax);
        dis.closest('.AQLModal81').find('.max_minor81').val(minorMax);
        dis.closest('.AQLModal81').find('.aql_normal_letter81').val(letter);
        dis.closest('.AQLModal81').find('.aql_normal_sampsize81').val(sampsize);
    })

    $('body').on('change', '.aql_minor81', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal81').find('.aql_qty81').val();
        var major = dis.closest('.AQLModal81').find('.aql_major81').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal81').find('.aql_normal_level81').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal81').find('.max_major81').val(majorMax);
        dis.closest('.AQLModal81').find('.max_minor81').val(minorMax);
        dis.closest('.AQLModal81').find('.aql_normal_letter81').val(letter);
        dis.closest('.AQLModal81').find('.aql_normal_sampsize81').val(sampsize);
    })

    $('body').on('click', '.confirmAQL81', function() {
        var dis = $(this);
        dis.closest('.part81').find('.main_part_qty81').val(dis.closest('.part81').find('.aql_qty81').val());
        dis.closest('.part81').find('#samples_unit81').val(dis.closest('.part81').find('.aql_normal_sampsize81').val());
        dis.closest('.part81').find('.AQLModal81').modal('hide');

    });

    $('.aql_select81').append('<option value="">--</option>');
    $('.aql_select81').append('<option value="0.065">0.065</option>');
    $('.aql_select81').append('<option value="0.10">0.10</option>');
    $('.aql_select81').append('<option value="0.15">0.15</option>');
    $('.aql_select81').append('<option value="0.25">0.25</option>');
    $('.aql_select81').append('<option value="0.4">0.4</option>');
    $('.aql_select81').append('<option value="0.65">0.65</option>');
    $('.aql_select81').append('<option value="1">1.0</option>');
    $('.aql_select81').append('<option value="1.5">1.5</option>');
    $('.aql_select81').append('<option value="2.5">2.5</option>');
    $('.aql_select81').append('<option value="4">4.0</option>');
    $('.aql_select81').append('<option value="6.5">6.5</option>');
    $('.aql_select81').append('<option value="10">10.0</option>');
    $('.aql_select81').append('<option value="N/A">N/A</option>');

    //82
    $('body').on('click', '.btn-main_part_qty-modal82', function() {
        jQuery.noConflict();
        $('.AQLModal82').modal('show');
    });

    $('body').on('keyup', '.aql_qty82', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal82').find('.aql_minor82').val();
        var major = dis.closest('.AQLModal82').find('.aql_major82').val();
        var lvl = dis.closest('.AQLModal82').find('.aql_normal_level82').val();
        var special_lvl = dis.closest('.AQLModal82').find('.aql_special_level82').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal82').find('.max_major82').val(majorMax);
        dis.closest('.AQLModal82').find('.max_minor82').val(minorMax);
        dis.closest('.AQLModal82').find('.aql_normal_letter82').val(letter);
        dis.closest('.AQLModal82').find('.aql_special_letter82').val(special_letter);
        dis.closest('.AQLModal82').find('.aql_normal_sampsize82').val(sampsize);
        dis.closest('.AQLModal82').find('.aql_special_sampsize82').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level82', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal82').find('.aql_qty82').val();
        var minor = dis.closest('.AQLModal82').find('.aql_minor82').val();
        var major = dis.closest('.AQLModal82').find('.aql_major82').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal82').find('.max_major82').val(majorMax);
        dis.closest('.AQLModal82').find('.max_minor82').val(minorMax);
        dis.closest('.AQLModal82').find('.aql_normal_letter82').val(letter);
        dis.closest('.AQLModal82').find('.aql_normal_sampsize82').val(sampsize);
    })

    $('body').on('change', '.aql_special_level82', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal82').find('.aql_qty82').val();
        var minor = dis.closest('.AQLModal82').find('.aql_minor82').val();
        var major = dis.closest('.AQLModal82').find('.aql_major82').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal82').find('.aql_special_letter82').val(letter);
        dis.closest('.AQLModal82').find('.aql_special_sampsize82').val(sampsize);
    })

    $('body').on('change', '.aql_major82', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal82').find('.aql_qty82').val();
        var minor = dis.closest('.AQLModal82').find('.aql_minor82').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal82').find('.aql_normal_level82').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal82').find('.max_major82').val(majorMax);
        dis.closest('.AQLModal82').find('.max_minor82').val(minorMax);
        dis.closest('.AQLModal82').find('.aql_normal_letter82').val(letter);
        dis.closest('.AQLModal82').find('.aql_normal_sampsize82').val(sampsize);
    })

    $('body').on('change', '.aql_minor82', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal82').find('.aql_qty82').val();
        var major = dis.closest('.AQLModal82').find('.aql_major82').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal82').find('.aql_normal_level82').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal82').find('.max_major82').val(majorMax);
        dis.closest('.AQLModal82').find('.max_minor82').val(minorMax);
        dis.closest('.AQLModal82').find('.aql_normal_letter82').val(letter);
        dis.closest('.AQLModal82').find('.aql_normal_sampsize82').val(sampsize);
    })

    $('body').on('click', '.confirmAQL82', function() {
        var dis = $(this);
        dis.closest('.part82').find('.main_part_qty82').val(dis.closest('.part82').find('.aql_qty82').val());
        dis.closest('.part82').find('#samples_unit82').val(dis.closest('.part82').find('.aql_normal_sampsize82').val());
        dis.closest('.part82').find('.AQLModal82').modal('hide');

    });

    $('.aql_select82').append('<option value="">--</option>');
    $('.aql_select82').append('<option value="0.065">0.065</option>');
    $('.aql_select82').append('<option value="0.10">0.10</option>');
    $('.aql_select82').append('<option value="0.15">0.15</option>');
    $('.aql_select82').append('<option value="0.25">0.25</option>');
    $('.aql_select82').append('<option value="0.4">0.4</option>');
    $('.aql_select82').append('<option value="0.65">0.65</option>');
    $('.aql_select82').append('<option value="1">1.0</option>');
    $('.aql_select82').append('<option value="1.5">1.5</option>');
    $('.aql_select82').append('<option value="2.5">2.5</option>');
    $('.aql_select82').append('<option value="4">4.0</option>');
    $('.aql_select82').append('<option value="6.5">6.5</option>');
    $('.aql_select82').append('<option value="10">10.0</option>');
    $('.aql_select82').append('<option value="N/A">N/A</option>');

    //83
    $('body').on('click', '.btn-main_part_qty-modal83', function() {
        jQuery.noConflict();
        $('.AQLModal83').modal('show');
    });

    $('body').on('keyup', '.aql_qty83', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal83').find('.aql_minor83').val();
        var major = dis.closest('.AQLModal83').find('.aql_major83').val();
        var lvl = dis.closest('.AQLModal83').find('.aql_normal_level83').val();
        var special_lvl = dis.closest('.AQLModal83').find('.aql_special_level83').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal83').find('.max_major83').val(majorMax);
        dis.closest('.AQLModal83').find('.max_minor83').val(minorMax);
        dis.closest('.AQLModal83').find('.aql_normal_letter83').val(letter);
        dis.closest('.AQLModal83').find('.aql_special_letter83').val(special_letter);
        dis.closest('.AQLModal83').find('.aql_normal_sampsize83').val(sampsize);
        dis.closest('.AQLModal83').find('.aql_special_sampsize83').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level83', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal83').find('.aql_qty83').val();
        var minor = dis.closest('.AQLModal83').find('.aql_minor83').val();
        var major = dis.closest('.AQLModal83').find('.aql_major83').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal83').find('.max_major83').val(majorMax);
        dis.closest('.AQLModal83').find('.max_minor83').val(minorMax);
        dis.closest('.AQLModal83').find('.aql_normal_letter83').val(letter);
        dis.closest('.AQLModal83').find('.aql_normal_sampsize83').val(sampsize);
    })

    $('body').on('change', '.aql_special_level83', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal83').find('.aql_qty83').val();
        var minor = dis.closest('.AQLModal83').find('.aql_minor83').val();
        var major = dis.closest('.AQLModal83').find('.aql_major83').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal83').find('.aql_special_letter83').val(letter);
        dis.closest('.AQLModal83').find('.aql_special_sampsize83').val(sampsize);
    })

    $('body').on('change', '.aql_major83', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal83').find('.aql_qty83').val();
        var minor = dis.closest('.AQLModal83').find('.aql_minor83').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal83').find('.aql_normal_level83').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal83').find('.max_major83').val(majorMax);
        dis.closest('.AQLModal83').find('.max_minor83').val(minorMax);
        dis.closest('.AQLModal83').find('.aql_normal_letter83').val(letter);
        dis.closest('.AQLModal83').find('.aql_normal_sampsize83').val(sampsize);
    })

    $('body').on('change', '.aql_minor83', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal83').find('.aql_qty83').val();
        var major = dis.closest('.AQLModal83').find('.aql_major83').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal83').find('.aql_normal_level83').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal83').find('.max_major83').val(majorMax);
        dis.closest('.AQLModal83').find('.max_minor83').val(minorMax);
        dis.closest('.AQLModal83').find('.aql_normal_letter83').val(letter);
        dis.closest('.AQLModal83').find('.aql_normal_sampsize83').val(sampsize);
    })

    $('body').on('click', '.confirmAQL83', function() {
        var dis = $(this);
        dis.closest('.part83').find('.main_part_qty83').val(dis.closest('.part83').find('.aql_qty83').val());
        dis.closest('.part83').find('#samples_unit83').val(dis.closest('.part83').find('.aql_normal_sampsize83').val());
        dis.closest('.part83').find('.AQLModal83').modal('hide');

    });

    $('.aql_select83').append('<option value="">--</option>');
    $('.aql_select83').append('<option value="0.065">0.065</option>');
    $('.aql_select83').append('<option value="0.10">0.10</option>');
    $('.aql_select83').append('<option value="0.15">0.15</option>');
    $('.aql_select83').append('<option value="0.25">0.25</option>');
    $('.aql_select83').append('<option value="0.4">0.4</option>');
    $('.aql_select83').append('<option value="0.65">0.65</option>');
    $('.aql_select83').append('<option value="1">1.0</option>');
    $('.aql_select83').append('<option value="1.5">1.5</option>');
    $('.aql_select83').append('<option value="2.5">2.5</option>');
    $('.aql_select83').append('<option value="4">4.0</option>');
    $('.aql_select83').append('<option value="6.5">6.5</option>');
    $('.aql_select83').append('<option value="10">10.0</option>');
    $('.aql_select83').append('<option value="N/A">N/A</option>');

    //84
    $('body').on('click', '.btn-main_part_qty-modal84', function() {
        jQuery.noConflict();
        $('.AQLModal84').modal('show');
    });

    $('body').on('keyup', '.aql_qty84', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal84').find('.aql_minor84').val();
        var major = dis.closest('.AQLModal84').find('.aql_major84').val();
        var lvl = dis.closest('.AQLModal84').find('.aql_normal_level84').val();
        var special_lvl = dis.closest('.AQLModal84').find('.aql_special_level84').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal84').find('.max_major84').val(majorMax);
        dis.closest('.AQLModal84').find('.max_minor84').val(minorMax);
        dis.closest('.AQLModal84').find('.aql_normal_letter84').val(letter);
        dis.closest('.AQLModal84').find('.aql_special_letter84').val(special_letter);
        dis.closest('.AQLModal84').find('.aql_normal_sampsize84').val(sampsize);
        dis.closest('.AQLModal84').find('.aql_special_sampsize84').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level84', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal84').find('.aql_qty84').val();
        var minor = dis.closest('.AQLModal84').find('.aql_minor84').val();
        var major = dis.closest('.AQLModal84').find('.aql_major84').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal84').find('.max_major84').val(majorMax);
        dis.closest('.AQLModal84').find('.max_minor84').val(minorMax);
        dis.closest('.AQLModal84').find('.aql_normal_letter84').val(letter);
        dis.closest('.AQLModal84').find('.aql_normal_sampsize84').val(sampsize);
    })

    $('body').on('change', '.aql_special_level84', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal84').find('.aql_qty84').val();
        var minor = dis.closest('.AQLModal84').find('.aql_minor84').val();
        var major = dis.closest('.AQLModal84').find('.aql_major84').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal84').find('.aql_special_letter84').val(letter);
        dis.closest('.AQLModal84').find('.aql_special_sampsize84').val(sampsize);
    })

    $('body').on('change', '.aql_major84', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal84').find('.aql_qty84').val();
        var minor = dis.closest('.AQLModal84').find('.aql_minor84').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal84').find('.aql_normal_level84').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal84').find('.max_major84').val(majorMax);
        dis.closest('.AQLModal84').find('.max_minor84').val(minorMax);
        dis.closest('.AQLModal84').find('.aql_normal_letter84').val(letter);
        dis.closest('.AQLModal84').find('.aql_normal_sampsize84').val(sampsize);
    })

    $('body').on('change', '.aql_minor84', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal84').find('.aql_qty84').val();
        var major = dis.closest('.AQLModal84').find('.aql_major84').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal84').find('.aql_normal_level84').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal84').find('.max_major84').val(majorMax);
        dis.closest('.AQLModal84').find('.max_minor84').val(minorMax);
        dis.closest('.AQLModal84').find('.aql_normal_letter84').val(letter);
        dis.closest('.AQLModal84').find('.aql_normal_sampsize84').val(sampsize);
    })

    $('body').on('click', '.confirmAQL84', function() {
        var dis = $(this);
        dis.closest('.part84').find('.main_part_qty84').val(dis.closest('.part84').find('.aql_qty84').val());
        dis.closest('.part84').find('#samples_unit84').val(dis.closest('.part84').find('.aql_normal_sampsize84').val());
        dis.closest('.part84').find('.AQLModal84').modal('hide');

    });

    $('.aql_select84').append('<option value="">--</option>');
    $('.aql_select84').append('<option value="0.065">0.065</option>');
    $('.aql_select84').append('<option value="0.10">0.10</option>');
    $('.aql_select84').append('<option value="0.15">0.15</option>');
    $('.aql_select84').append('<option value="0.25">0.25</option>');
    $('.aql_select84').append('<option value="0.4">0.4</option>');
    $('.aql_select84').append('<option value="0.65">0.65</option>');
    $('.aql_select84').append('<option value="1">1.0</option>');
    $('.aql_select84').append('<option value="1.5">1.5</option>');
    $('.aql_select84').append('<option value="2.5">2.5</option>');
    $('.aql_select84').append('<option value="4">4.0</option>');
    $('.aql_select84').append('<option value="6.5">6.5</option>');
    $('.aql_select84').append('<option value="10">10.0</option>');
    $('.aql_select84').append('<option value="N/A">N/A</option>');

    //85
    $('body').on('click', '.btn-main_part_qty-modal85', function() {
        jQuery.noConflict();
        $('.AQLModal85').modal('show');
    });

    $('body').on('keyup', '.aql_qty85', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal85').find('.aql_minor85').val();
        var major = dis.closest('.AQLModal85').find('.aql_major85').val();
        var lvl = dis.closest('.AQLModal85').find('.aql_normal_level85').val();
        var special_lvl = dis.closest('.AQLModal85').find('.aql_special_level85').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal85').find('.max_major85').val(majorMax);
        dis.closest('.AQLModal85').find('.max_minor85').val(minorMax);
        dis.closest('.AQLModal85').find('.aql_normal_letter85').val(letter);
        dis.closest('.AQLModal85').find('.aql_special_letter85').val(special_letter);
        dis.closest('.AQLModal85').find('.aql_normal_sampsize85').val(sampsize);
        dis.closest('.AQLModal85').find('.aql_special_sampsize85').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level85', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal85').find('.aql_qty85').val();
        var minor = dis.closest('.AQLModal85').find('.aql_minor85').val();
        var major = dis.closest('.AQLModal85').find('.aql_major85').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal85').find('.max_major85').val(majorMax);
        dis.closest('.AQLModal85').find('.max_minor85').val(minorMax);
        dis.closest('.AQLModal85').find('.aql_normal_letter85').val(letter);
        dis.closest('.AQLModal85').find('.aql_normal_sampsize85').val(sampsize);
    })

    $('body').on('change', '.aql_special_level85', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal85').find('.aql_qty85').val();
        var minor = dis.closest('.AQLModal85').find('.aql_minor85').val();
        var major = dis.closest('.AQLModal85').find('.aql_major85').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal85').find('.aql_special_letter85').val(letter);
        dis.closest('.AQLModal85').find('.aql_special_sampsize85').val(sampsize);
    })

    $('body').on('change', '.aql_major85', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal85').find('.aql_qty85').val();
        var minor = dis.closest('.AQLModal85').find('.aql_minor85').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal85').find('.aql_normal_level85').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal85').find('.max_major85').val(majorMax);
        dis.closest('.AQLModal85').find('.max_minor85').val(minorMax);
        dis.closest('.AQLModal85').find('.aql_normal_letter85').val(letter);
        dis.closest('.AQLModal85').find('.aql_normal_sampsize85').val(sampsize);
    })

    $('body').on('change', '.aql_minor85', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal85').find('.aql_qty85').val();
        var major = dis.closest('.AQLModal85').find('.aql_major85').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal85').find('.aql_normal_level85').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal85').find('.max_major85').val(majorMax);
        dis.closest('.AQLModal85').find('.max_minor85').val(minorMax);
        dis.closest('.AQLModal85').find('.aql_normal_letter85').val(letter);
        dis.closest('.AQLModal85').find('.aql_normal_sampsize85').val(sampsize);
    })

    $('body').on('click', '.confirmAQL85', function() {
        var dis = $(this);
        dis.closest('.part85').find('.main_part_qty85').val(dis.closest('.part85').find('.aql_qty85').val());
        dis.closest('.part85').find('#samples_unit85').val(dis.closest('.part85').find('.aql_normal_sampsize85').val());
        dis.closest('.part85').find('.AQLModal85').modal('hide');

    });

    $('.aql_select85').append('<option value="">--</option>');
    $('.aql_select85').append('<option value="0.065">0.065</option>');
    $('.aql_select85').append('<option value="0.10">0.10</option>');
    $('.aql_select85').append('<option value="0.15">0.15</option>');
    $('.aql_select85').append('<option value="0.25">0.25</option>');
    $('.aql_select85').append('<option value="0.4">0.4</option>');
    $('.aql_select85').append('<option value="0.65">0.65</option>');
    $('.aql_select85').append('<option value="1">1.0</option>');
    $('.aql_select85').append('<option value="1.5">1.5</option>');
    $('.aql_select85').append('<option value="2.5">2.5</option>');
    $('.aql_select85').append('<option value="4">4.0</option>');
    $('.aql_select85').append('<option value="6.5">6.5</option>');
    $('.aql_select85').append('<option value="10">10.0</option>');
    $('.aql_select85').append('<option value="N/A">N/A</option>');

    //86
    $('body').on('click', '.btn-main_part_qty-modal86', function() {
        jQuery.noConflict();
        $('.AQLModal86').modal('show');
    });

    $('body').on('keyup', '.aql_qty86', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal86').find('.aql_minor86').val();
        var major = dis.closest('.AQLModal86').find('.aql_major86').val();
        var lvl = dis.closest('.AQLModal86').find('.aql_normal_level86').val();
        var special_lvl = dis.closest('.AQLModal86').find('.aql_special_level86').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal86').find('.max_major86').val(majorMax);
        dis.closest('.AQLModal86').find('.max_minor86').val(minorMax);
        dis.closest('.AQLModal86').find('.aql_normal_letter86').val(letter);
        dis.closest('.AQLModal86').find('.aql_special_letter86').val(special_letter);
        dis.closest('.AQLModal86').find('.aql_normal_sampsize86').val(sampsize);
        dis.closest('.AQLModal86').find('.aql_special_sampsize86').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level86', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal86').find('.aql_qty86').val();
        var minor = dis.closest('.AQLModal86').find('.aql_minor86').val();
        var major = dis.closest('.AQLModal86').find('.aql_major86').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal86').find('.max_major86').val(majorMax);
        dis.closest('.AQLModal86').find('.max_minor86').val(minorMax);
        dis.closest('.AQLModal86').find('.aql_normal_letter86').val(letter);
        dis.closest('.AQLModal86').find('.aql_normal_sampsize86').val(sampsize);
    })

    $('body').on('change', '.aql_special_level86', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal86').find('.aql_qty86').val();
        var minor = dis.closest('.AQLModal86').find('.aql_minor86').val();
        var major = dis.closest('.AQLModal86').find('.aql_major86').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal86').find('.aql_special_letter86').val(letter);
        dis.closest('.AQLModal86').find('.aql_special_sampsize86').val(sampsize);
    })

    $('body').on('change', '.aql_major86', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal86').find('.aql_qty86').val();
        var minor = dis.closest('.AQLModal86').find('.aql_minor86').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal86').find('.aql_normal_level86').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal86').find('.max_major86').val(majorMax);
        dis.closest('.AQLModal86').find('.max_minor86').val(minorMax);
        dis.closest('.AQLModal86').find('.aql_normal_letter86').val(letter);
        dis.closest('.AQLModal86').find('.aql_normal_sampsize86').val(sampsize);
    })

    $('body').on('change', '.aql_minor86', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal86').find('.aql_qty86').val();
        var major = dis.closest('.AQLModal86').find('.aql_major86').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal86').find('.aql_normal_level86').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal86').find('.max_major86').val(majorMax);
        dis.closest('.AQLModal86').find('.max_minor86').val(minorMax);
        dis.closest('.AQLModal86').find('.aql_normal_letter86').val(letter);
        dis.closest('.AQLModal86').find('.aql_normal_sampsize86').val(sampsize);
    })

    $('body').on('click', '.confirmAQL86', function() {
        var dis = $(this);
        dis.closest('.part86').find('.main_part_qty86').val(dis.closest('.part86').find('.aql_qty86').val());
        dis.closest('.part86').find('#samples_unit86').val(dis.closest('.part86').find('.aql_normal_sampsize86').val());
        dis.closest('.part86').find('.AQLModal86').modal('hide');

    });

    $('.aql_select86').append('<option value="">--</option>');
    $('.aql_select86').append('<option value="0.065">0.065</option>');
    $('.aql_select86').append('<option value="0.10">0.10</option>');
    $('.aql_select86').append('<option value="0.15">0.15</option>');
    $('.aql_select86').append('<option value="0.25">0.25</option>');
    $('.aql_select86').append('<option value="0.4">0.4</option>');
    $('.aql_select86').append('<option value="0.65">0.65</option>');
    $('.aql_select86').append('<option value="1">1.0</option>');
    $('.aql_select86').append('<option value="1.5">1.5</option>');
    $('.aql_select86').append('<option value="2.5">2.5</option>');
    $('.aql_select86').append('<option value="4">4.0</option>');
    $('.aql_select86').append('<option value="6.5">6.5</option>');
    $('.aql_select86').append('<option value="10">10.0</option>');
    $('.aql_select86').append('<option value="N/A">N/A</option>');

    //87
    $('body').on('click', '.btn-main_part_qty-modal87', function() {
        jQuery.noConflict();
        $('.AQLModal87').modal('show');
    });

    $('body').on('keyup', '.aql_qty87', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal87').find('.aql_minor87').val();
        var major = dis.closest('.AQLModal87').find('.aql_major87').val();
        var lvl = dis.closest('.AQLModal87').find('.aql_normal_level87').val();
        var special_lvl = dis.closest('.AQLModal87').find('.aql_special_level87').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal87').find('.max_major87').val(majorMax);
        dis.closest('.AQLModal87').find('.max_minor87').val(minorMax);
        dis.closest('.AQLModal87').find('.aql_normal_letter87').val(letter);
        dis.closest('.AQLModal87').find('.aql_special_letter87').val(special_letter);
        dis.closest('.AQLModal87').find('.aql_normal_sampsize87').val(sampsize);
        dis.closest('.AQLModal87').find('.aql_special_sampsize87').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level87', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal87').find('.aql_qty87').val();
        var minor = dis.closest('.AQLModal87').find('.aql_minor87').val();
        var major = dis.closest('.AQLModal87').find('.aql_major87').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal87').find('.max_major87').val(majorMax);
        dis.closest('.AQLModal87').find('.max_minor87').val(minorMax);
        dis.closest('.AQLModal87').find('.aql_normal_letter87').val(letter);
        dis.closest('.AQLModal87').find('.aql_normal_sampsize87').val(sampsize);
    })

    $('body').on('change', '.aql_special_level87', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal87').find('.aql_qty87').val();
        var minor = dis.closest('.AQLModal87').find('.aql_minor87').val();
        var major = dis.closest('.AQLModal87').find('.aql_major87').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal87').find('.aql_special_letter87').val(letter);
        dis.closest('.AQLModal87').find('.aql_special_sampsize87').val(sampsize);
    })

    $('body').on('change', '.aql_major87', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal87').find('.aql_qty87').val();
        var minor = dis.closest('.AQLModal87').find('.aql_minor87').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal87').find('.aql_normal_level87').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal87').find('.max_major87').val(majorMax);
        dis.closest('.AQLModal87').find('.max_minor87').val(minorMax);
        dis.closest('.AQLModal87').find('.aql_normal_letter87').val(letter);
        dis.closest('.AQLModal87').find('.aql_normal_sampsize87').val(sampsize);
    })

    $('body').on('change', '.aql_minor87', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal87').find('.aql_qty87').val();
        var major = dis.closest('.AQLModal87').find('.aql_major87').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal87').find('.aql_normal_level87').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal87').find('.max_major87').val(majorMax);
        dis.closest('.AQLModal87').find('.max_minor87').val(minorMax);
        dis.closest('.AQLModal87').find('.aql_normal_letter87').val(letter);
        dis.closest('.AQLModal87').find('.aql_normal_sampsize87').val(sampsize);
    })

    $('body').on('click', '.confirmAQL87', function() {
        var dis = $(this);
        dis.closest('.part87').find('.main_part_qty87').val(dis.closest('.part87').find('.aql_qty87').val());
        dis.closest('.part87').find('#samples_unit87').val(dis.closest('.part87').find('.aql_normal_sampsize87').val());
        dis.closest('.part87').find('.AQLModal87').modal('hide');

    });

    $('.aql_select87').append('<option value="">--</option>');
    $('.aql_select87').append('<option value="0.065">0.065</option>');
    $('.aql_select87').append('<option value="0.10">0.10</option>');
    $('.aql_select87').append('<option value="0.15">0.15</option>');
    $('.aql_select87').append('<option value="0.25">0.25</option>');
    $('.aql_select87').append('<option value="0.4">0.4</option>');
    $('.aql_select87').append('<option value="0.65">0.65</option>');
    $('.aql_select87').append('<option value="1">1.0</option>');
    $('.aql_select87').append('<option value="1.5">1.5</option>');
    $('.aql_select87').append('<option value="2.5">2.5</option>');
    $('.aql_select87').append('<option value="4">4.0</option>');
    $('.aql_select87').append('<option value="6.5">6.5</option>');
    $('.aql_select87').append('<option value="10">10.0</option>');
    $('.aql_select87').append('<option value="N/A">N/A</option>');

    //88
    $('body').on('click', '.btn-main_part_qty-modal88', function() {
        jQuery.noConflict();
        $('.AQLModal88').modal('show');
    });

    $('body').on('keyup', '.aql_qty88', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal88').find('.aql_minor88').val();
        var major = dis.closest('.AQLModal88').find('.aql_major88').val();
        var lvl = dis.closest('.AQLModal88').find('.aql_normal_level88').val();
        var special_lvl = dis.closest('.AQLModal88').find('.aql_special_level88').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal88').find('.max_major88').val(majorMax);
        dis.closest('.AQLModal88').find('.max_minor88').val(minorMax);
        dis.closest('.AQLModal88').find('.aql_normal_letter88').val(letter);
        dis.closest('.AQLModal88').find('.aql_special_letter88').val(special_letter);
        dis.closest('.AQLModal88').find('.aql_normal_sampsize88').val(sampsize);
        dis.closest('.AQLModal88').find('.aql_special_sampsize88').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level88', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal88').find('.aql_qty88').val();
        var minor = dis.closest('.AQLModal88').find('.aql_minor88').val();
        var major = dis.closest('.AQLModal88').find('.aql_major88').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal88').find('.max_major88').val(majorMax);
        dis.closest('.AQLModal88').find('.max_minor88').val(minorMax);
        dis.closest('.AQLModal88').find('.aql_normal_letter88').val(letter);
        dis.closest('.AQLModal88').find('.aql_normal_sampsize88').val(sampsize);
    })

    $('body').on('change', '.aql_special_level88', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal88').find('.aql_qty88').val();
        var minor = dis.closest('.AQLModal88').find('.aql_minor88').val();
        var major = dis.closest('.AQLModal88').find('.aql_major88').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal88').find('.aql_special_letter88').val(letter);
        dis.closest('.AQLModal88').find('.aql_special_sampsize88').val(sampsize);
    })

    $('body').on('change', '.aql_major88', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal88').find('.aql_qty88').val();
        var minor = dis.closest('.AQLModal88').find('.aql_minor88').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal88').find('.aql_normal_level88').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal88').find('.max_major88').val(majorMax);
        dis.closest('.AQLModal88').find('.max_minor88').val(minorMax);
        dis.closest('.AQLModal88').find('.aql_normal_letter88').val(letter);
        dis.closest('.AQLModal88').find('.aql_normal_sampsize88').val(sampsize);
    })

    $('body').on('change', '.aql_minor88', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal88').find('.aql_qty88').val();
        var major = dis.closest('.AQLModal88').find('.aql_major88').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal88').find('.aql_normal_level88').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal88').find('.max_major88').val(majorMax);
        dis.closest('.AQLModal88').find('.max_minor88').val(minorMax);
        dis.closest('.AQLModal88').find('.aql_normal_letter88').val(letter);
        dis.closest('.AQLModal88').find('.aql_normal_sampsize88').val(sampsize);
    })

    $('body').on('click', '.confirmAQL88', function() {
        var dis = $(this);
        dis.closest('.part88').find('.main_part_qty88').val(dis.closest('.part88').find('.aql_qty88').val());
        dis.closest('.part88').find('#samples_unit88').val(dis.closest('.part88').find('.aql_normal_sampsize88').val());
        dis.closest('.part88').find('.AQLModal88').modal('hide');

    });

    $('.aql_select88').append('<option value="">--</option>');
    $('.aql_select88').append('<option value="0.065">0.065</option>');
    $('.aql_select88').append('<option value="0.10">0.10</option>');
    $('.aql_select88').append('<option value="0.15">0.15</option>');
    $('.aql_select88').append('<option value="0.25">0.25</option>');
    $('.aql_select88').append('<option value="0.4">0.4</option>');
    $('.aql_select88').append('<option value="0.65">0.65</option>');
    $('.aql_select88').append('<option value="1">1.0</option>');
    $('.aql_select88').append('<option value="1.5">1.5</option>');
    $('.aql_select88').append('<option value="2.5">2.5</option>');
    $('.aql_select88').append('<option value="4">4.0</option>');
    $('.aql_select88').append('<option value="6.5">6.5</option>');
    $('.aql_select88').append('<option value="10">10.0</option>');
    $('.aql_select88').append('<option value="N/A">N/A</option>');

    //89
    $('body').on('click', '.btn-main_part_qty-modal89', function() {
        jQuery.noConflict();
        $('.AQLModal89').modal('show');
    });

    $('body').on('keyup', '.aql_qty89', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal89').find('.aql_minor89').val();
        var major = dis.closest('.AQLModal89').find('.aql_major89').val();
        var lvl = dis.closest('.AQLModal89').find('.aql_normal_level89').val();
        var special_lvl = dis.closest('.AQLModal89').find('.aql_special_level89').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal89').find('.max_major89').val(majorMax);
        dis.closest('.AQLModal89').find('.max_minor89').val(minorMax);
        dis.closest('.AQLModal89').find('.aql_normal_letter89').val(letter);
        dis.closest('.AQLModal89').find('.aql_special_letter89').val(special_letter);
        dis.closest('.AQLModal89').find('.aql_normal_sampsize89').val(sampsize);
        dis.closest('.AQLModal89').find('.aql_special_sampsize89').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level89', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal89').find('.aql_qty89').val();
        var minor = dis.closest('.AQLModal89').find('.aql_minor89').val();
        var major = dis.closest('.AQLModal89').find('.aql_major89').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal89').find('.max_major89').val(majorMax);
        dis.closest('.AQLModal89').find('.max_minor89').val(minorMax);
        dis.closest('.AQLModal89').find('.aql_normal_letter89').val(letter);
        dis.closest('.AQLModal89').find('.aql_normal_sampsize89').val(sampsize);
    })

    $('body').on('change', '.aql_special_level89', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal89').find('.aql_qty89').val();
        var minor = dis.closest('.AQLModal89').find('.aql_minor89').val();
        var major = dis.closest('.AQLModal89').find('.aql_major89').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal89').find('.aql_special_letter89').val(letter);
        dis.closest('.AQLModal89').find('.aql_special_sampsize89').val(sampsize);
    })

    $('body').on('change', '.aql_major89', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal89').find('.aql_qty89').val();
        var minor = dis.closest('.AQLModal89').find('.aql_minor89').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal89').find('.aql_normal_level89').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal89').find('.max_major89').val(majorMax);
        dis.closest('.AQLModal89').find('.max_minor89').val(minorMax);
        dis.closest('.AQLModal89').find('.aql_normal_letter89').val(letter);
        dis.closest('.AQLModal89').find('.aql_normal_sampsize89').val(sampsize);
    })

    $('body').on('change', '.aql_minor89', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal89').find('.aql_qty89').val();
        var major = dis.closest('.AQLModal89').find('.aql_major89').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal89').find('.aql_normal_level89').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal89').find('.max_major89').val(majorMax);
        dis.closest('.AQLModal89').find('.max_minor89').val(minorMax);
        dis.closest('.AQLModal89').find('.aql_normal_letter89').val(letter);
        dis.closest('.AQLModal89').find('.aql_normal_sampsize89').val(sampsize);
    })

    $('body').on('click', '.confirmAQL89', function() {
        var dis = $(this);
        dis.closest('.part89').find('.main_part_qty89').val(dis.closest('.part89').find('.aql_qty89').val());
        dis.closest('.part89').find('#samples_unit89').val(dis.closest('.part89').find('.aql_normal_sampsize89').val());
        dis.closest('.part89').find('.AQLModal89').modal('hide');

    });

    $('.aql_select89').append('<option value="">--</option>');
    $('.aql_select89').append('<option value="0.065">0.065</option>');
    $('.aql_select89').append('<option value="0.10">0.10</option>');
    $('.aql_select89').append('<option value="0.15">0.15</option>');
    $('.aql_select89').append('<option value="0.25">0.25</option>');
    $('.aql_select89').append('<option value="0.4">0.4</option>');
    $('.aql_select89').append('<option value="0.65">0.65</option>');
    $('.aql_select89').append('<option value="1">1.0</option>');
    $('.aql_select89').append('<option value="1.5">1.5</option>');
    $('.aql_select89').append('<option value="2.5">2.5</option>');
    $('.aql_select89').append('<option value="4">4.0</option>');
    $('.aql_select89').append('<option value="6.5">6.5</option>');
    $('.aql_select89').append('<option value="10">10.0</option>');
    $('.aql_select89').append('<option value="N/A">N/A</option>');

    //90
    $('body').on('click', '.btn-main_part_qty-modal90', function() {
        jQuery.noConflict();
        $('.AQLModal90').modal('show');
    });

    $('body').on('keyup', '.aql_qty90', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal90').find('.aql_minor90').val();
        var major = dis.closest('.AQLModal90').find('.aql_major90').val();
        var lvl = dis.closest('.AQLModal90').find('.aql_normal_level90').val();
        var special_lvl = dis.closest('.AQLModal90').find('.aql_special_level90').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal90').find('.max_major90').val(majorMax);
        dis.closest('.AQLModal90').find('.max_minor90').val(minorMax);
        dis.closest('.AQLModal90').find('.aql_normal_letter90').val(letter);
        dis.closest('.AQLModal90').find('.aql_special_letter90').val(special_letter);
        dis.closest('.AQLModal90').find('.aql_normal_sampsize90').val(sampsize);
        dis.closest('.AQLModal90').find('.aql_special_sampsize90').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level90', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal90').find('.aql_qty90').val();
        var minor = dis.closest('.AQLModal90').find('.aql_minor90').val();
        var major = dis.closest('.AQLModal90').find('.aql_major90').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal90').find('.max_major90').val(majorMax);
        dis.closest('.AQLModal90').find('.max_minor90').val(minorMax);
        dis.closest('.AQLModal90').find('.aql_normal_letter90').val(letter);
        dis.closest('.AQLModal90').find('.aql_normal_sampsize90').val(sampsize);
    })

    $('body').on('change', '.aql_special_level90', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal90').find('.aql_qty90').val();
        var minor = dis.closest('.AQLModal90').find('.aql_minor90').val();
        var major = dis.closest('.AQLModal90').find('.aql_major90').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal90').find('.aql_special_letter90').val(letter);
        dis.closest('.AQLModal90').find('.aql_special_sampsize90').val(sampsize);
    })

    $('body').on('change', '.aql_major90', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal90').find('.aql_qty90').val();
        var minor = dis.closest('.AQLModal90').find('.aql_minor90').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal90').find('.aql_normal_level90').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal90').find('.max_major90').val(majorMax);
        dis.closest('.AQLModal90').find('.max_minor90').val(minorMax);
        dis.closest('.AQLModal90').find('.aql_normal_letter90').val(letter);
        dis.closest('.AQLModal90').find('.aql_normal_sampsize90').val(sampsize);
    })

    $('body').on('change', '.aql_minor90', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal90').find('.aql_qty90').val();
        var major = dis.closest('.AQLModal90').find('.aql_major90').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal90').find('.aql_normal_level90').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal90').find('.max_major90').val(majorMax);
        dis.closest('.AQLModal90').find('.max_minor90').val(minorMax);
        dis.closest('.AQLModal90').find('.aql_normal_letter90').val(letter);
        dis.closest('.AQLModal90').find('.aql_normal_sampsize90').val(sampsize);
    })

    $('body').on('click', '.confirmAQL90', function() {
        var dis = $(this);
        dis.closest('.part90').find('.main_part_qty90').val(dis.closest('.part90').find('.aql_qty90').val());
        dis.closest('.part90').find('#samples_unit90').val(dis.closest('.part90').find('.aql_normal_sampsize90').val());
        dis.closest('.part90').find('.AQLModal90').modal('hide');

    });

    $('.aql_select90').append('<option value="">--</option>');
    $('.aql_select90').append('<option value="0.065">0.065</option>');
    $('.aql_select90').append('<option value="0.10">0.10</option>');
    $('.aql_select90').append('<option value="0.15">0.15</option>');
    $('.aql_select90').append('<option value="0.25">0.25</option>');
    $('.aql_select90').append('<option value="0.4">0.4</option>');
    $('.aql_select90').append('<option value="0.65">0.65</option>');
    $('.aql_select90').append('<option value="1">1.0</option>');
    $('.aql_select90').append('<option value="1.5">1.5</option>');
    $('.aql_select90').append('<option value="2.5">2.5</option>');
    $('.aql_select90').append('<option value="4">4.0</option>');
    $('.aql_select90').append('<option value="6.5">6.5</option>');
    $('.aql_select90').append('<option value="10">10.0</option>');
    $('.aql_select90').append('<option value="N/A">N/A</option>');

    //91
    $('body').on('click', '.btn-main_part_qty-modal91', function() {
        jQuery.noConflict();
        $('.AQLModal91').modal('show');
    });

    $('body').on('keyup', '.aql_qty91', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal91').find('.aql_minor91').val();
        var major = dis.closest('.AQLModal91').find('.aql_major91').val();
        var lvl = dis.closest('.AQLModal91').find('.aql_normal_level91').val();
        var special_lvl = dis.closest('.AQLModal91').find('.aql_special_level91').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal91').find('.max_major91').val(majorMax);
        dis.closest('.AQLModal91').find('.max_minor91').val(minorMax);
        dis.closest('.AQLModal91').find('.aql_normal_letter91').val(letter);
        dis.closest('.AQLModal91').find('.aql_special_letter91').val(special_letter);
        dis.closest('.AQLModal91').find('.aql_normal_sampsize91').val(sampsize);
        dis.closest('.AQLModal91').find('.aql_special_sampsize91').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level91', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal91').find('.aql_qty91').val();
        var minor = dis.closest('.AQLModal91').find('.aql_minor91').val();
        var major = dis.closest('.AQLModal91').find('.aql_major91').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal91').find('.max_major91').val(majorMax);
        dis.closest('.AQLModal91').find('.max_minor91').val(minorMax);
        dis.closest('.AQLModal91').find('.aql_normal_letter91').val(letter);
        dis.closest('.AQLModal91').find('.aql_normal_sampsize91').val(sampsize);
    })

    $('body').on('change', '.aql_special_level91', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal91').find('.aql_qty91').val();
        var minor = dis.closest('.AQLModal91').find('.aql_minor91').val();
        var major = dis.closest('.AQLModal91').find('.aql_major91').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal91').find('.aql_special_letter91').val(letter);
        dis.closest('.AQLModal91').find('.aql_special_sampsize91').val(sampsize);
    })

    $('body').on('change', '.aql_major91', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal91').find('.aql_qty91').val();
        var minor = dis.closest('.AQLModal91').find('.aql_minor91').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal91').find('.aql_normal_level91').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal91').find('.max_major91').val(majorMax);
        dis.closest('.AQLModal91').find('.max_minor91').val(minorMax);
        dis.closest('.AQLModal91').find('.aql_normal_letter91').val(letter);
        dis.closest('.AQLModal91').find('.aql_normal_sampsize91').val(sampsize);
    })

    $('body').on('change', '.aql_minor91', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal91').find('.aql_qty91').val();
        var major = dis.closest('.AQLModal91').find('.aql_major91').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal91').find('.aql_normal_level91').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal91').find('.max_major91').val(majorMax);
        dis.closest('.AQLModal91').find('.max_minor91').val(minorMax);
        dis.closest('.AQLModal91').find('.aql_normal_letter91').val(letter);
        dis.closest('.AQLModal91').find('.aql_normal_sampsize91').val(sampsize);
    })

    $('body').on('click', '.confirmAQL91', function() {
        var dis = $(this);
        dis.closest('.part91').find('.main_part_qty91').val(dis.closest('.part91').find('.aql_qty91').val());
        dis.closest('.part91').find('#samples_unit91').val(dis.closest('.part91').find('.aql_normal_sampsize91').val());
        dis.closest('.part91').find('.AQLModal91').modal('hide');

    });

    $('.aql_select91').append('<option value="">--</option>');
    $('.aql_select91').append('<option value="0.065">0.065</option>');
    $('.aql_select91').append('<option value="0.10">0.10</option>');
    $('.aql_select91').append('<option value="0.15">0.15</option>');
    $('.aql_select91').append('<option value="0.25">0.25</option>');
    $('.aql_select91').append('<option value="0.4">0.4</option>');
    $('.aql_select91').append('<option value="0.65">0.65</option>');
    $('.aql_select91').append('<option value="1">1.0</option>');
    $('.aql_select91').append('<option value="1.5">1.5</option>');
    $('.aql_select91').append('<option value="2.5">2.5</option>');
    $('.aql_select91').append('<option value="4">4.0</option>');
    $('.aql_select91').append('<option value="6.5">6.5</option>');
    $('.aql_select91').append('<option value="10">10.0</option>');
    $('.aql_select91').append('<option value="N/A">N/A</option>');

    //92
    $('body').on('click', '.btn-main_part_qty-modal92', function() {
        jQuery.noConflict();
        $('.AQLModal92').modal('show');
    });

    $('body').on('keyup', '.aql_qty92', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal92').find('.aql_minor92').val();
        var major = dis.closest('.AQLModal92').find('.aql_major92').val();
        var lvl = dis.closest('.AQLModal92').find('.aql_normal_level92').val();
        var special_lvl = dis.closest('.AQLModal92').find('.aql_special_level92').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal92').find('.max_major92').val(majorMax);
        dis.closest('.AQLModal92').find('.max_minor92').val(minorMax);
        dis.closest('.AQLModal92').find('.aql_normal_letter92').val(letter);
        dis.closest('.AQLModal92').find('.aql_special_letter92').val(special_letter);
        dis.closest('.AQLModal92').find('.aql_normal_sampsize92').val(sampsize);
        dis.closest('.AQLModal92').find('.aql_special_sampsize92').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level92', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal92').find('.aql_qty92').val();
        var minor = dis.closest('.AQLModal92').find('.aql_minor92').val();
        var major = dis.closest('.AQLModal92').find('.aql_major92').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal92').find('.max_major92').val(majorMax);
        dis.closest('.AQLModal92').find('.max_minor92').val(minorMax);
        dis.closest('.AQLModal92').find('.aql_normal_letter92').val(letter);
        dis.closest('.AQLModal92').find('.aql_normal_sampsize92').val(sampsize);
    })

    $('body').on('change', '.aql_special_level92', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal92').find('.aql_qty92').val();
        var minor = dis.closest('.AQLModal92').find('.aql_minor92').val();
        var major = dis.closest('.AQLModal92').find('.aql_major92').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal92').find('.aql_special_letter92').val(letter);
        dis.closest('.AQLModal92').find('.aql_special_sampsize92').val(sampsize);
    })

    $('body').on('change', '.aql_major92', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal92').find('.aql_qty92').val();
        var minor = dis.closest('.AQLModal92').find('.aql_minor92').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal92').find('.aql_normal_level92').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal92').find('.max_major92').val(majorMax);
        dis.closest('.AQLModal92').find('.max_minor92').val(minorMax);
        dis.closest('.AQLModal92').find('.aql_normal_letter92').val(letter);
        dis.closest('.AQLModal92').find('.aql_normal_sampsize92').val(sampsize);
    })

    $('body').on('change', '.aql_minor92', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal92').find('.aql_qty92').val();
        var major = dis.closest('.AQLModal92').find('.aql_major92').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal92').find('.aql_normal_level92').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal92').find('.max_major92').val(majorMax);
        dis.closest('.AQLModal92').find('.max_minor92').val(minorMax);
        dis.closest('.AQLModal92').find('.aql_normal_letter92').val(letter);
        dis.closest('.AQLModal92').find('.aql_normal_sampsize92').val(sampsize);
    })

    $('body').on('click', '.confirmAQL92', function() {
        var dis = $(this);
        dis.closest('.part92').find('.main_part_qty92').val(dis.closest('.part92').find('.aql_qty92').val());
        dis.closest('.part92').find('#samples_unit92').val(dis.closest('.part92').find('.aql_normal_sampsize92').val());
        dis.closest('.part92').find('.AQLModal92').modal('hide');

    });

    $('.aql_select92').append('<option value="">--</option>');
    $('.aql_select92').append('<option value="0.065">0.065</option>');
    $('.aql_select92').append('<option value="0.10">0.10</option>');
    $('.aql_select92').append('<option value="0.15">0.15</option>');
    $('.aql_select92').append('<option value="0.25">0.25</option>');
    $('.aql_select92').append('<option value="0.4">0.4</option>');
    $('.aql_select92').append('<option value="0.65">0.65</option>');
    $('.aql_select92').append('<option value="1">1.0</option>');
    $('.aql_select92').append('<option value="1.5">1.5</option>');
    $('.aql_select92').append('<option value="2.5">2.5</option>');
    $('.aql_select92').append('<option value="4">4.0</option>');
    $('.aql_select92').append('<option value="6.5">6.5</option>');
    $('.aql_select92').append('<option value="10">10.0</option>');
    $('.aql_select92').append('<option value="N/A">N/A</option>');

    //93
    $('body').on('click', '.btn-main_part_qty-modal93', function() {
        jQuery.noConflict();
        $('.AQLModal93').modal('show');
    });

    $('body').on('keyup', '.aql_qty93', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal93').find('.aql_minor93').val();
        var major = dis.closest('.AQLModal93').find('.aql_major93').val();
        var lvl = dis.closest('.AQLModal93').find('.aql_normal_level93').val();
        var special_lvl = dis.closest('.AQLModal93').find('.aql_special_level93').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal93').find('.max_major93').val(majorMax);
        dis.closest('.AQLModal93').find('.max_minor93').val(minorMax);
        dis.closest('.AQLModal93').find('.aql_normal_letter93').val(letter);
        dis.closest('.AQLModal93').find('.aql_special_letter93').val(special_letter);
        dis.closest('.AQLModal93').find('.aql_normal_sampsize93').val(sampsize);
        dis.closest('.AQLModal93').find('.aql_special_sampsize93').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level93', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal93').find('.aql_qty93').val();
        var minor = dis.closest('.AQLModal93').find('.aql_minor93').val();
        var major = dis.closest('.AQLModal93').find('.aql_major93').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal93').find('.max_major93').val(majorMax);
        dis.closest('.AQLModal93').find('.max_minor93').val(minorMax);
        dis.closest('.AQLModal93').find('.aql_normal_letter93').val(letter);
        dis.closest('.AQLModal93').find('.aql_normal_sampsize93').val(sampsize);
    })

    $('body').on('change', '.aql_special_level93', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal93').find('.aql_qty93').val();
        var minor = dis.closest('.AQLModal93').find('.aql_minor93').val();
        var major = dis.closest('.AQLModal93').find('.aql_major93').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal93').find('.aql_special_letter93').val(letter);
        dis.closest('.AQLModal93').find('.aql_special_sampsize93').val(sampsize);
    })

    $('body').on('change', '.aql_major93', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal93').find('.aql_qty93').val();
        var minor = dis.closest('.AQLModal93').find('.aql_minor93').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal93').find('.aql_normal_level93').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal93').find('.max_major93').val(majorMax);
        dis.closest('.AQLModal93').find('.max_minor93').val(minorMax);
        dis.closest('.AQLModal93').find('.aql_normal_letter93').val(letter);
        dis.closest('.AQLModal93').find('.aql_normal_sampsize93').val(sampsize);
    })

    $('body').on('change', '.aql_minor93', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal93').find('.aql_qty93').val();
        var major = dis.closest('.AQLModal93').find('.aql_major93').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal93').find('.aql_normal_level93').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal93').find('.max_major93').val(majorMax);
        dis.closest('.AQLModal93').find('.max_minor93').val(minorMax);
        dis.closest('.AQLModal93').find('.aql_normal_letter93').val(letter);
        dis.closest('.AQLModal93').find('.aql_normal_sampsize93').val(sampsize);
    })

    $('body').on('click', '.confirmAQL93', function() {
        var dis = $(this);
        dis.closest('.part93').find('.main_part_qty93').val(dis.closest('.part93').find('.aql_qty93').val());
        dis.closest('.part93').find('#samples_unit93').val(dis.closest('.part93').find('.aql_normal_sampsize93').val());
        dis.closest('.part93').find('.AQLModal93').modal('hide');

    });

    $('.aql_select93').append('<option value="">--</option>');
    $('.aql_select93').append('<option value="0.065">0.065</option>');
    $('.aql_select93').append('<option value="0.10">0.10</option>');
    $('.aql_select93').append('<option value="0.15">0.15</option>');
    $('.aql_select93').append('<option value="0.25">0.25</option>');
    $('.aql_select93').append('<option value="0.4">0.4</option>');
    $('.aql_select93').append('<option value="0.65">0.65</option>');
    $('.aql_select93').append('<option value="1">1.0</option>');
    $('.aql_select93').append('<option value="1.5">1.5</option>');
    $('.aql_select93').append('<option value="2.5">2.5</option>');
    $('.aql_select93').append('<option value="4">4.0</option>');
    $('.aql_select93').append('<option value="6.5">6.5</option>');
    $('.aql_select93').append('<option value="10">10.0</option>');
    $('.aql_select93').append('<option value="N/A">N/A</option>');

    //94
    $('body').on('click', '.btn-main_part_qty-modal94', function() {
        jQuery.noConflict();
        $('.AQLModal94').modal('show');
    });

    $('body').on('keyup', '.aql_qty94', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal94').find('.aql_minor94').val();
        var major = dis.closest('.AQLModal94').find('.aql_major94').val();
        var lvl = dis.closest('.AQLModal94').find('.aql_normal_level94').val();
        var special_lvl = dis.closest('.AQLModal94').find('.aql_special_level94').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal94').find('.max_major94').val(majorMax);
        dis.closest('.AQLModal94').find('.max_minor94').val(minorMax);
        dis.closest('.AQLModal94').find('.aql_normal_letter94').val(letter);
        dis.closest('.AQLModal94').find('.aql_special_letter94').val(special_letter);
        dis.closest('.AQLModal94').find('.aql_normal_sampsize94').val(sampsize);
        dis.closest('.AQLModal94').find('.aql_special_sampsize94').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level94', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal94').find('.aql_qty94').val();
        var minor = dis.closest('.AQLModal94').find('.aql_minor94').val();
        var major = dis.closest('.AQLModal94').find('.aql_major94').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal94').find('.max_major94').val(majorMax);
        dis.closest('.AQLModal94').find('.max_minor94').val(minorMax);
        dis.closest('.AQLModal94').find('.aql_normal_letter94').val(letter);
        dis.closest('.AQLModal94').find('.aql_normal_sampsize94').val(sampsize);
    })

    $('body').on('change', '.aql_special_level94', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal94').find('.aql_qty94').val();
        var minor = dis.closest('.AQLModal94').find('.aql_minor94').val();
        var major = dis.closest('.AQLModal94').find('.aql_major94').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal94').find('.aql_special_letter94').val(letter);
        dis.closest('.AQLModal94').find('.aql_special_sampsize94').val(sampsize);
    })

    $('body').on('change', '.aql_major94', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal94').find('.aql_qty94').val();
        var minor = dis.closest('.AQLModal94').find('.aql_minor94').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal94').find('.aql_normal_level94').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal94').find('.max_major94').val(majorMax);
        dis.closest('.AQLModal94').find('.max_minor94').val(minorMax);
        dis.closest('.AQLModal94').find('.aql_normal_letter94').val(letter);
        dis.closest('.AQLModal94').find('.aql_normal_sampsize94').val(sampsize);
    })

    $('body').on('change', '.aql_minor94', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal94').find('.aql_qty94').val();
        var major = dis.closest('.AQLModal94').find('.aql_major94').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal94').find('.aql_normal_level94').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal94').find('.max_major94').val(majorMax);
        dis.closest('.AQLModal94').find('.max_minor94').val(minorMax);
        dis.closest('.AQLModal94').find('.aql_normal_letter94').val(letter);
        dis.closest('.AQLModal94').find('.aql_normal_sampsize94').val(sampsize);
    })

    $('body').on('click', '.confirmAQL94', function() {
        var dis = $(this);
        dis.closest('.part94').find('.main_part_qty94').val(dis.closest('.part94').find('.aql_qty94').val());
        dis.closest('.part94').find('#samples_unit94').val(dis.closest('.part94').find('.aql_normal_sampsize94').val());
        dis.closest('.part94').find('.AQLModal94').modal('hide');

    });

    $('.aql_select94').append('<option value="">--</option>');
    $('.aql_select94').append('<option value="0.065">0.065</option>');
    $('.aql_select94').append('<option value="0.10">0.10</option>');
    $('.aql_select94').append('<option value="0.15">0.15</option>');
    $('.aql_select94').append('<option value="0.25">0.25</option>');
    $('.aql_select94').append('<option value="0.4">0.4</option>');
    $('.aql_select94').append('<option value="0.65">0.65</option>');
    $('.aql_select94').append('<option value="1">1.0</option>');
    $('.aql_select94').append('<option value="1.5">1.5</option>');
    $('.aql_select94').append('<option value="2.5">2.5</option>');
    $('.aql_select94').append('<option value="4">4.0</option>');
    $('.aql_select94').append('<option value="6.5">6.5</option>');
    $('.aql_select94').append('<option value="10">10.0</option>');
    $('.aql_select94').append('<option value="N/A">N/A</option>');

    //95
    $('body').on('click', '.btn-main_part_qty-modal95', function() {
        jQuery.noConflict();
        $('.AQLModal95').modal('show');
    });

    $('body').on('keyup', '.aql_qty95', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal95').find('.aql_minor95').val();
        var major = dis.closest('.AQLModal95').find('.aql_major95').val();
        var lvl = dis.closest('.AQLModal95').find('.aql_normal_level95').val();
        var special_lvl = dis.closest('.AQLModal95').find('.aql_special_level95').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal95').find('.max_major95').val(majorMax);
        dis.closest('.AQLModal95').find('.max_minor95').val(minorMax);
        dis.closest('.AQLModal95').find('.aql_normal_letter95').val(letter);
        dis.closest('.AQLModal95').find('.aql_special_letter95').val(special_letter);
        dis.closest('.AQLModal95').find('.aql_normal_sampsize95').val(sampsize);
        dis.closest('.AQLModal95').find('.aql_special_sampsize95').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level95', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal95').find('.aql_qty95').val();
        var minor = dis.closest('.AQLModal95').find('.aql_minor95').val();
        var major = dis.closest('.AQLModal95').find('.aql_major95').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal95').find('.max_major95').val(majorMax);
        dis.closest('.AQLModal95').find('.max_minor95').val(minorMax);
        dis.closest('.AQLModal95').find('.aql_normal_letter95').val(letter);
        dis.closest('.AQLModal95').find('.aql_normal_sampsize95').val(sampsize);
    })

    $('body').on('change', '.aql_special_level95', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal95').find('.aql_qty95').val();
        var minor = dis.closest('.AQLModal95').find('.aql_minor95').val();
        var major = dis.closest('.AQLModal95').find('.aql_major95').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal95').find('.aql_special_letter95').val(letter);
        dis.closest('.AQLModal95').find('.aql_special_sampsize95').val(sampsize);
    })

    $('body').on('change', '.aql_major95', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal95').find('.aql_qty95').val();
        var minor = dis.closest('.AQLModal95').find('.aql_minor95').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal95').find('.aql_normal_level95').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal95').find('.max_major95').val(majorMax);
        dis.closest('.AQLModal95').find('.max_minor95').val(minorMax);
        dis.closest('.AQLModal95').find('.aql_normal_letter95').val(letter);
        dis.closest('.AQLModal95').find('.aql_normal_sampsize95').val(sampsize);
    })

    $('body').on('change', '.aql_minor95', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal95').find('.aql_qty95').val();
        var major = dis.closest('.AQLModal95').find('.aql_major95').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal95').find('.aql_normal_level95').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal95').find('.max_major95').val(majorMax);
        dis.closest('.AQLModal95').find('.max_minor95').val(minorMax);
        dis.closest('.AQLModal95').find('.aql_normal_letter95').val(letter);
        dis.closest('.AQLModal95').find('.aql_normal_sampsize95').val(sampsize);
    })

    $('body').on('click', '.confirmAQL95', function() {
        var dis = $(this);
        dis.closest('.part95').find('.main_part_qty95').val(dis.closest('.part95').find('.aql_qty95').val());
        dis.closest('.part95').find('#samples_unit95').val(dis.closest('.part95').find('.aql_normal_sampsize95').val());
        dis.closest('.part95').find('.AQLModal95').modal('hide');

    });

    $('.aql_select95').append('<option value="">--</option>');
    $('.aql_select95').append('<option value="0.065">0.065</option>');
    $('.aql_select95').append('<option value="0.10">0.10</option>');
    $('.aql_select95').append('<option value="0.15">0.15</option>');
    $('.aql_select95').append('<option value="0.25">0.25</option>');
    $('.aql_select95').append('<option value="0.4">0.4</option>');
    $('.aql_select95').append('<option value="0.65">0.65</option>');
    $('.aql_select95').append('<option value="1">1.0</option>');
    $('.aql_select95').append('<option value="1.5">1.5</option>');
    $('.aql_select95').append('<option value="2.5">2.5</option>');
    $('.aql_select95').append('<option value="4">4.0</option>');
    $('.aql_select95').append('<option value="6.5">6.5</option>');
    $('.aql_select95').append('<option value="10">10.0</option>');
    $('.aql_select95').append('<option value="N/A">N/A</option>');

    //96
    $('body').on('click', '.btn-main_part_qty-modal96', function() {
        jQuery.noConflict();
        $('.AQLModal96').modal('show');
    });

    $('body').on('keyup', '.aql_qty96', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal96').find('.aql_minor96').val();
        var major = dis.closest('.AQLModal96').find('.aql_major96').val();
        var lvl = dis.closest('.AQLModal96').find('.aql_normal_level96').val();
        var special_lvl = dis.closest('.AQLModal96').find('.aql_special_level96').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal96').find('.max_major96').val(majorMax);
        dis.closest('.AQLModal96').find('.max_minor96').val(minorMax);
        dis.closest('.AQLModal96').find('.aql_normal_letter96').val(letter);
        dis.closest('.AQLModal96').find('.aql_special_letter96').val(special_letter);
        dis.closest('.AQLModal96').find('.aql_normal_sampsize96').val(sampsize);
        dis.closest('.AQLModal96').find('.aql_special_sampsize96').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level96', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal96').find('.aql_qty96').val();
        var minor = dis.closest('.AQLModal96').find('.aql_minor96').val();
        var major = dis.closest('.AQLModal96').find('.aql_major96').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal96').find('.max_major96').val(majorMax);
        dis.closest('.AQLModal96').find('.max_minor96').val(minorMax);
        dis.closest('.AQLModal96').find('.aql_normal_letter96').val(letter);
        dis.closest('.AQLModal96').find('.aql_normal_sampsize96').val(sampsize);
    })

    $('body').on('change', '.aql_special_level96', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal96').find('.aql_qty96').val();
        var minor = dis.closest('.AQLModal96').find('.aql_minor96').val();
        var major = dis.closest('.AQLModal96').find('.aql_major96').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal96').find('.aql_special_letter96').val(letter);
        dis.closest('.AQLModal96').find('.aql_special_sampsize96').val(sampsize);
    })

    $('body').on('change', '.aql_major96', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal96').find('.aql_qty96').val();
        var minor = dis.closest('.AQLModal96').find('.aql_minor96').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal96').find('.aql_normal_level96').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal96').find('.max_major96').val(majorMax);
        dis.closest('.AQLModal96').find('.max_minor96').val(minorMax);
        dis.closest('.AQLModal96').find('.aql_normal_letter96').val(letter);
        dis.closest('.AQLModal96').find('.aql_normal_sampsize96').val(sampsize);
    })

    $('body').on('change', '.aql_minor96', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal96').find('.aql_qty96').val();
        var major = dis.closest('.AQLModal96').find('.aql_major96').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal96').find('.aql_normal_level96').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal96').find('.max_major96').val(majorMax);
        dis.closest('.AQLModal96').find('.max_minor96').val(minorMax);
        dis.closest('.AQLModal96').find('.aql_normal_letter96').val(letter);
        dis.closest('.AQLModal96').find('.aql_normal_sampsize96').val(sampsize);
    })

    $('body').on('click', '.confirmAQL96', function() {
        var dis = $(this);
        dis.closest('.part96').find('.main_part_qty96').val(dis.closest('.part96').find('.aql_qty96').val());
        dis.closest('.part96').find('#samples_unit96').val(dis.closest('.part96').find('.aql_normal_sampsize96').val());
        dis.closest('.part96').find('.AQLModal96').modal('hide');

    });

    $('.aql_select96').append('<option value="">--</option>');
    $('.aql_select96').append('<option value="0.065">0.065</option>');
    $('.aql_select96').append('<option value="0.10">0.10</option>');
    $('.aql_select96').append('<option value="0.15">0.15</option>');
    $('.aql_select96').append('<option value="0.25">0.25</option>');
    $('.aql_select96').append('<option value="0.4">0.4</option>');
    $('.aql_select96').append('<option value="0.65">0.65</option>');
    $('.aql_select96').append('<option value="1">1.0</option>');
    $('.aql_select96').append('<option value="1.5">1.5</option>');
    $('.aql_select96').append('<option value="2.5">2.5</option>');
    $('.aql_select96').append('<option value="4">4.0</option>');
    $('.aql_select96').append('<option value="6.5">6.5</option>');
    $('.aql_select96').append('<option value="10">10.0</option>');
    $('.aql_select96').append('<option value="N/A">N/A</option>');

    //97
    $('body').on('click', '.btn-main_part_qty-modal97', function() {
        jQuery.noConflict();
        $('.AQLModal97').modal('show');
    });

    $('body').on('keyup', '.aql_qty97', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal97').find('.aql_minor97').val();
        var major = dis.closest('.AQLModal97').find('.aql_major97').val();
        var lvl = dis.closest('.AQLModal97').find('.aql_normal_level97').val();
        var special_lvl = dis.closest('.AQLModal97').find('.aql_special_level97').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal97').find('.max_major97').val(majorMax);
        dis.closest('.AQLModal97').find('.max_minor97').val(minorMax);
        dis.closest('.AQLModal97').find('.aql_normal_letter97').val(letter);
        dis.closest('.AQLModal97').find('.aql_special_letter97').val(special_letter);
        dis.closest('.AQLModal97').find('.aql_normal_sampsize97').val(sampsize);
        dis.closest('.AQLModal97').find('.aql_special_sampsize97').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level97', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal97').find('.aql_qty97').val();
        var minor = dis.closest('.AQLModal97').find('.aql_minor97').val();
        var major = dis.closest('.AQLModal97').find('.aql_major97').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal97').find('.max_major97').val(majorMax);
        dis.closest('.AQLModal97').find('.max_minor97').val(minorMax);
        dis.closest('.AQLModal97').find('.aql_normal_letter97').val(letter);
        dis.closest('.AQLModal97').find('.aql_normal_sampsize97').val(sampsize);
    })

    $('body').on('change', '.aql_special_level97', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal97').find('.aql_qty97').val();
        var minor = dis.closest('.AQLModal97').find('.aql_minor97').val();
        var major = dis.closest('.AQLModal97').find('.aql_major97').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal97').find('.aql_special_letter97').val(letter);
        dis.closest('.AQLModal97').find('.aql_special_sampsize97').val(sampsize);
    })

    $('body').on('change', '.aql_major97', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal97').find('.aql_qty97').val();
        var minor = dis.closest('.AQLModal97').find('.aql_minor97').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal97').find('.aql_normal_level97').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal97').find('.max_major97').val(majorMax);
        dis.closest('.AQLModal97').find('.max_minor97').val(minorMax);
        dis.closest('.AQLModal97').find('.aql_normal_letter97').val(letter);
        dis.closest('.AQLModal97').find('.aql_normal_sampsize97').val(sampsize);
    })

    $('body').on('change', '.aql_minor97', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal97').find('.aql_qty97').val();
        var major = dis.closest('.AQLModal97').find('.aql_major97').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal97').find('.aql_normal_level97').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal97').find('.max_major97').val(majorMax);
        dis.closest('.AQLModal97').find('.max_minor97').val(minorMax);
        dis.closest('.AQLModal97').find('.aql_normal_letter97').val(letter);
        dis.closest('.AQLModal97').find('.aql_normal_sampsize97').val(sampsize);
    })

    $('body').on('click', '.confirmAQL97', function() {
        var dis = $(this);
        dis.closest('.part97').find('.main_part_qty97').val(dis.closest('.part97').find('.aql_qty97').val());
        dis.closest('.part97').find('#samples_unit97').val(dis.closest('.part97').find('.aql_normal_sampsize97').val());
        dis.closest('.part97').find('.AQLModal97').modal('hide');

    });

    $('.aql_select97').append('<option value="">--</option>');
    $('.aql_select97').append('<option value="0.065">0.065</option>');
    $('.aql_select97').append('<option value="0.10">0.10</option>');
    $('.aql_select97').append('<option value="0.15">0.15</option>');
    $('.aql_select97').append('<option value="0.25">0.25</option>');
    $('.aql_select97').append('<option value="0.4">0.4</option>');
    $('.aql_select97').append('<option value="0.65">0.65</option>');
    $('.aql_select97').append('<option value="1">1.0</option>');
    $('.aql_select97').append('<option value="1.5">1.5</option>');
    $('.aql_select97').append('<option value="2.5">2.5</option>');
    $('.aql_select97').append('<option value="4">4.0</option>');
    $('.aql_select97').append('<option value="6.5">6.5</option>');
    $('.aql_select97').append('<option value="10">10.0</option>');
    $('.aql_select97').append('<option value="N/A">N/A</option>');

    //98
    $('body').on('click', '.btn-main_part_qty-modal98', function() {
        jQuery.noConflict();
        $('.AQLModal98').modal('show');
    });

    $('body').on('keyup', '.aql_qty98', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal98').find('.aql_minor98').val();
        var major = dis.closest('.AQLModal98').find('.aql_major98').val();
        var lvl = dis.closest('.AQLModal98').find('.aql_normal_level98').val();
        var special_lvl = dis.closest('.AQLModal98').find('.aql_special_level98').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal98').find('.max_major98').val(majorMax);
        dis.closest('.AQLModal98').find('.max_minor98').val(minorMax);
        dis.closest('.AQLModal98').find('.aql_normal_letter98').val(letter);
        dis.closest('.AQLModal98').find('.aql_special_letter98').val(special_letter);
        dis.closest('.AQLModal98').find('.aql_normal_sampsize98').val(sampsize);
        dis.closest('.AQLModal98').find('.aql_special_sampsize98').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level98', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal98').find('.aql_qty98').val();
        var minor = dis.closest('.AQLModal98').find('.aql_minor98').val();
        var major = dis.closest('.AQLModal98').find('.aql_major98').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal98').find('.max_major98').val(majorMax);
        dis.closest('.AQLModal98').find('.max_minor98').val(minorMax);
        dis.closest('.AQLModal98').find('.aql_normal_letter98').val(letter);
        dis.closest('.AQLModal98').find('.aql_normal_sampsize98').val(sampsize);
    })

    $('body').on('change', '.aql_special_level98', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal98').find('.aql_qty98').val();
        var minor = dis.closest('.AQLModal98').find('.aql_minor98').val();
        var major = dis.closest('.AQLModal98').find('.aql_major98').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal98').find('.aql_special_letter98').val(letter);
        dis.closest('.AQLModal98').find('.aql_special_sampsize98').val(sampsize);
    })

    $('body').on('change', '.aql_major98', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal98').find('.aql_qty98').val();
        var minor = dis.closest('.AQLModal98').find('.aql_minor98').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal98').find('.aql_normal_level98').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal98').find('.max_major98').val(majorMax);
        dis.closest('.AQLModal98').find('.max_minor98').val(minorMax);
        dis.closest('.AQLModal98').find('.aql_normal_letter98').val(letter);
        dis.closest('.AQLModal98').find('.aql_normal_sampsize98').val(sampsize);
    })

    $('body').on('change', '.aql_minor98', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal98').find('.aql_qty98').val();
        var major = dis.closest('.AQLModal98').find('.aql_major98').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal98').find('.aql_normal_level98').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal98').find('.max_major98').val(majorMax);
        dis.closest('.AQLModal98').find('.max_minor98').val(minorMax);
        dis.closest('.AQLModal98').find('.aql_normal_letter98').val(letter);
        dis.closest('.AQLModal98').find('.aql_normal_sampsize98').val(sampsize);
    })

    $('body').on('click', '.confirmAQL98', function() {
        var dis = $(this);
        dis.closest('.part98').find('.main_part_qty98').val(dis.closest('.part98').find('.aql_qty98').val());
        dis.closest('.part98').find('#samples_unit98').val(dis.closest('.part98').find('.aql_normal_sampsize98').val());
        dis.closest('.part98').find('.AQLModal98').modal('hide');

    });

    $('.aql_select98').append('<option value="">--</option>');
    $('.aql_select98').append('<option value="0.065">0.065</option>');
    $('.aql_select98').append('<option value="0.10">0.10</option>');
    $('.aql_select98').append('<option value="0.15">0.15</option>');
    $('.aql_select98').append('<option value="0.25">0.25</option>');
    $('.aql_select98').append('<option value="0.4">0.4</option>');
    $('.aql_select98').append('<option value="0.65">0.65</option>');
    $('.aql_select98').append('<option value="1">1.0</option>');
    $('.aql_select98').append('<option value="1.5">1.5</option>');
    $('.aql_select98').append('<option value="2.5">2.5</option>');
    $('.aql_select98').append('<option value="4">4.0</option>');
    $('.aql_select98').append('<option value="6.5">6.5</option>');
    $('.aql_select98').append('<option value="10">10.0</option>');
    $('.aql_select98').append('<option value="N/A">N/A</option>');

    //99
    $('body').on('click', '.btn-main_part_qty-modal99', function() {
        jQuery.noConflict();
        $('.AQLModal99').modal('show');
    });

    $('body').on('keyup', '.aql_qty99', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal99').find('.aql_minor99').val();
        var major = dis.closest('.AQLModal99').find('.aql_major99').val();
        var lvl = dis.closest('.AQLModal99').find('.aql_normal_level99').val();
        var special_lvl = dis.closest('.AQLModal99').find('.aql_special_level99').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal99').find('.max_major99').val(majorMax);
        dis.closest('.AQLModal99').find('.max_minor99').val(minorMax);
        dis.closest('.AQLModal99').find('.aql_normal_letter99').val(letter);
        dis.closest('.AQLModal99').find('.aql_special_letter99').val(special_letter);
        dis.closest('.AQLModal99').find('.aql_normal_sampsize99').val(sampsize);
        dis.closest('.AQLModal99').find('.aql_special_sampsize99').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level99', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal99').find('.aql_qty99').val();
        var minor = dis.closest('.AQLModal99').find('.aql_minor99').val();
        var major = dis.closest('.AQLModal99').find('.aql_major99').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal99').find('.max_major99').val(majorMax);
        dis.closest('.AQLModal99').find('.max_minor99').val(minorMax);
        dis.closest('.AQLModal99').find('.aql_normal_letter99').val(letter);
        dis.closest('.AQLModal99').find('.aql_normal_sampsize99').val(sampsize);
    })

    $('body').on('change', '.aql_special_level99', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal99').find('.aql_qty99').val();
        var minor = dis.closest('.AQLModal99').find('.aql_minor99').val();
        var major = dis.closest('.AQLModal99').find('.aql_major99').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal99').find('.aql_special_letter99').val(letter);
        dis.closest('.AQLModal99').find('.aql_special_sampsize99').val(sampsize);
    })

    $('body').on('change', '.aql_major99', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal99').find('.aql_qty99').val();
        var minor = dis.closest('.AQLModal99').find('.aql_minor99').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal99').find('.aql_normal_level99').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal99').find('.max_major99').val(majorMax);
        dis.closest('.AQLModal99').find('.max_minor99').val(minorMax);
        dis.closest('.AQLModal99').find('.aql_normal_letter99').val(letter);
        dis.closest('.AQLModal99').find('.aql_normal_sampsize99').val(sampsize);
    })

    $('body').on('change', '.aql_minor99', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal99').find('.aql_qty99').val();
        var major = dis.closest('.AQLModal99').find('.aql_major99').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal99').find('.aql_normal_level99').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal99').find('.max_major99').val(majorMax);
        dis.closest('.AQLModal99').find('.max_minor99').val(minorMax);
        dis.closest('.AQLModal99').find('.aql_normal_letter99').val(letter);
        dis.closest('.AQLModal99').find('.aql_normal_sampsize99').val(sampsize);
    })

    $('body').on('click', '.confirmAQL99', function() {
        var dis = $(this);
        dis.closest('.part99').find('.main_part_qty99').val(dis.closest('.part99').find('.aql_qty99').val());
        dis.closest('.part99').find('#samples_unit99').val(dis.closest('.part99').find('.aql_normal_sampsize99').val());
        dis.closest('.part99').find('.AQLModal99').modal('hide');

    });

    $('.aql_select99').append('<option value="">--</option>');
    $('.aql_select99').append('<option value="0.065">0.065</option>');
    $('.aql_select99').append('<option value="0.10">0.10</option>');
    $('.aql_select99').append('<option value="0.15">0.15</option>');
    $('.aql_select99').append('<option value="0.25">0.25</option>');
    $('.aql_select99').append('<option value="0.4">0.4</option>');
    $('.aql_select99').append('<option value="0.65">0.65</option>');
    $('.aql_select99').append('<option value="1">1.0</option>');
    $('.aql_select99').append('<option value="1.5">1.5</option>');
    $('.aql_select99').append('<option value="2.5">2.5</option>');
    $('.aql_select99').append('<option value="4">4.0</option>');
    $('.aql_select99').append('<option value="6.5">6.5</option>');
    $('.aql_select99').append('<option value="10">10.0</option>');
    $('.aql_select99').append('<option value="N/A">N/A</option>');

    //100
    $('body').on('click', '.btn-main_part_qty-modal100', function() {
        jQuery.noConflict();
        $('.AQLModal100').modal('show');
    });

    $('body').on('keyup', '.aql_qty100', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal100').find('.aql_minor100').val();
        var major = dis.closest('.AQLModal100').find('.aql_major100').val();
        var lvl = dis.closest('.AQLModal100').find('.aql_normal_level100').val();
        var special_lvl = dis.closest('.AQLModal100').find('.aql_special_level100').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal100').find('.max_major100').val(majorMax);
        dis.closest('.AQLModal100').find('.max_minor100').val(minorMax);
        dis.closest('.AQLModal100').find('.aql_normal_letter100').val(letter);
        dis.closest('.AQLModal100').find('.aql_special_letter100').val(special_letter);
        dis.closest('.AQLModal100').find('.aql_normal_sampsize100').val(sampsize);
        dis.closest('.AQLModal100').find('.aql_special_sampsize100').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level100', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal100').find('.aql_qty100').val();
        var minor = dis.closest('.AQLModal100').find('.aql_minor100').val();
        var major = dis.closest('.AQLModal100').find('.aql_major100').val();
        var lvl = dis.val();

        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal100').find('.max_major100').val(majorMax);
        dis.closest('.AQLModal100').find('.max_minor100').val(minorMax);
        dis.closest('.AQLModal100').find('.aql_normal_letter100').val(letter);
        dis.closest('.AQLModal100').find('.aql_normal_sampsize100').val(sampsize);
    })

    $('body').on('change', '.aql_special_level100', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal100').find('.aql_qty100').val();
        var minor = dis.closest('.AQLModal100').find('.aql_minor100').val();
        var major = dis.closest('.AQLModal100').find('.aql_major100').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal100').find('.aql_special_letter100').val(letter);
        dis.closest('.AQLModal100').find('.aql_special_sampsize100').val(sampsize);
    })

    $('body').on('change', '.aql_major100', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal100').find('.aql_qty100').val();
        var minor = dis.closest('.AQLModal100').find('.aql_minor100').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal100').find('.aql_normal_level100').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal100').find('.max_major100').val(majorMax);
        dis.closest('.AQLModal100').find('.max_minor100').val(minorMax);
        dis.closest('.AQLModal100').find('.aql_normal_letter100').val(letter);
        dis.closest('.AQLModal100').find('.aql_normal_sampsize100').val(sampsize);
    })

    $('body').on('change', '.aql_minor100', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal100').find('.aql_qty100').val();
        var major = dis.closest('.AQLModal100').find('.aql_major100').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal100').find('.aql_normal_level100').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal100').find('.max_major100').val(majorMax);
        dis.closest('.AQLModal100').find('.max_minor100').val(minorMax);
        dis.closest('.AQLModal100').find('.aql_normal_letter100').val(letter);
        dis.closest('.AQLModal100').find('.aql_normal_sampsize100').val(sampsize);
    })

    $('body').on('click', '.confirmAQL100', function() {
        var dis = $(this);
        dis.closest('.part100').find('.main_part_qty100').val(dis.closest('.part100').find('.aql_qty100').val());
        dis.closest('.part100').find('#samples_unit100').val(dis.closest('.part100').find('.aql_normal_sampsize100').val());
        dis.closest('.part100').find('.AQLModal100').modal('hide');

    });

    $('.aql_select100').append('<option value="">--</option>');
    $('.aql_select100').append('<option value="0.065">0.065</option>');
    $('.aql_select100').append('<option value="0.10">0.10</option>');
    $('.aql_select100').append('<option value="0.15">0.15</option>');
    $('.aql_select100').append('<option value="0.25">0.25</option>');
    $('.aql_select100').append('<option value="0.4">0.4</option>');
    $('.aql_select100').append('<option value="0.65">0.65</option>');
    $('.aql_select100').append('<option value="1">1.0</option>');
    $('.aql_select100').append('<option value="1.5">1.5</option>');
    $('.aql_select100').append('<option value="2.5">2.5</option>');
    $('.aql_select100').append('<option value="4">4.0</option>');
    $('.aql_select100').append('<option value="6.5">6.5</option>');
    $('.aql_select100').append('<option value="10">10.0</option>');
    $('.aql_select100').append('<option value="N/A">N/A</option>');

    //ADD BUTTON
    $('#btn_add_more_function_part').click(function() {
        $("#btn_add_more_function_part").hide();
        $(".part2").attr("style", "");
    });

    $('#btn_add_more_function_part2').click(function() {
        $("#btn_add_more_function_part2").hide();
        $(".part3").attr("style", "");
    });

    $('#btn_add_more_function_part3').click(function() {
        $("#btn_add_more_function_part3").hide();
        $(".part4").attr("style", "");
    });

    $('#btn_add_more_function_part4').click(function() {
        $("#btn_add_more_function_part4").hide();
        $(".part5").attr("style", "");
    });

    $('#btn_add_more_function_part5').click(function() {
        $("#btn_add_more_function_part5").hide();
        $(".part6").attr("style", "");
    });

    $('#btn_add_more_function_part6').click(function() {
        $("#btn_add_more_function_part6").hide();
        $(".part7").attr("style", "");
    });

    $('#btn_add_more_function_part7').click(function() {
        $("#btn_add_more_function_part7").hide();
        $(".part8").attr("style", "");
    });

    $('#btn_add_more_function_part8').click(function() {
        $("#btn_add_more_function_part8").hide();
        $(".part9").attr("style", "");
    });

    $('#btn_add_more_function_part9').click(function() {
        $("#btn_add_more_function_part9").hide();
        $(".part10").attr("style", "");
    });

    $('#btn_add_more_function_part10').click(function() {
        $("#btn_add_more_function_part10").hide();
        $(".part11").attr("style", "");
    });

    $('#btn_add_more_function_part11').click(function() {
        $("#btn_add_more_function_part11").hide();
        $(".part12").attr("style", "");
    });

    $('#btn_add_more_function_part12').click(function() {
        $("#btn_add_more_function_part12").hide();
        $(".part13").attr("style", "");
    });

    $('#btn_add_more_function_part13').click(function() {
        $("#btn_add_more_function_part13").hide();
        $(".part14").attr("style", "");
    });

    $('#btn_add_more_function_part14').click(function() {
        $("#btn_add_more_function_part14").hide();
        $(".part15").attr("style", "");
    });

    $('#btn_add_more_function_part15').click(function() {
        $("#btn_add_more_function_part15").hide();
        $(".part16").attr("style", "");
    });

    $('#btn_add_more_function_part16').click(function() {
        $("#btn_add_more_function_part16").hide();
        $(".part17").attr("style", "");
    });

    $('#btn_add_more_function_part17').click(function() {
        $("#btn_add_more_function_part17").hide();
        $(".part18").attr("style", "");
    });

    $('#btn_add_more_function_part18').click(function() {
        $("#btn_add_more_function_part18").hide();
        $(".part19").attr("style", "");
    });

    $('#btn_add_more_function_part19').click(function() {
        $("#btn_add_more_function_part19").hide();
        $(".part20").attr("style", "");
    });

    $('#btn_add_more_function_part20').click(function() {
        $("#btn_add_more_function_part20").hide();
        $(".part21").attr("style", "");
    });

    $('#btn_add_more_function_part21').click(function() {
        $("#btn_add_more_function_part21").hide();
        $(".part22").attr("style", "");
    });

    $('#btn_add_more_function_part22').click(function() {
        $("#btn_add_more_function_part22").hide();
        $(".part23").attr("style", "");
    });

    $('#btn_add_more_function_part23').click(function() {
        $("#btn_add_more_function_part23").hide();
        $(".part24").attr("style", "");
    });

    $('#btn_add_more_function_part24').click(function() {
        $("#btn_add_more_function_part24").hide();
        $(".part25").attr("style", "");
    });

    $('#btn_add_more_function_part25').click(function() {
        $("#btn_add_more_function_part25").hide();
        $(".part26").attr("style", "");
    });

    $('#btn_add_more_function_part26').click(function() {
        $("#btn_add_more_function_part26").hide();
        $(".part27").attr("style", "");
    });

    $('#btn_add_more_function_part27').click(function() {
        $("#btn_add_more_function_part27").hide();
        $(".part28").attr("style", "");
    });

    $('#btn_add_more_function_part28').click(function() {
        $("#btn_add_more_function_part28").hide();
        $(".part29").attr("style", "");
    });

    $('#btn_add_more_function_part29').click(function() {
        $("#btn_add_more_function_part29").hide();
        $(".part30").attr("style", "");
    });

    $('#btn_add_more_function_part30').click(function() {
        $("#btn_add_more_function_part30").hide();
        $(".part31").attr("style", "");
    });

    $('#btn_add_more_function_part31').click(function() {
        $("#btn_add_more_function_part31").hide();
        $(".part32").attr("style", "");
    });

    $('#btn_add_more_function_part32').click(function() {
        $("#btn_add_more_function_part32").hide();
        $(".part33").attr("style", "");
    });

    $('#btn_add_more_function_part33').click(function() {
        $("#btn_add_more_function_part33").hide();
        $(".part34").attr("style", "");
    });

    $('#btn_add_more_function_part34').click(function() {
        $("#btn_add_more_function_part34").hide();
        $(".part35").attr("style", "");
    });

    $('#btn_add_more_function_part35').click(function() {
        $("#btn_add_more_function_part35").hide();
        $(".part36").attr("style", "");
    });

    $('#btn_add_more_function_part36').click(function() {
        $("#btn_add_more_function_part36").hide();
        $(".part37").attr("style", "");
    });

    $('#btn_add_more_function_part37').click(function() {
        $("#btn_add_more_function_part37").hide();
        $(".part38").attr("style", "");
    });

    $('#btn_add_more_function_part38').click(function() {
        $("#btn_add_more_function_part38").hide();
        $(".part39").attr("style", "");
    });

    $('#btn_add_more_function_part39').click(function() {
        $("#btn_add_more_function_part39").hide();
        $(".part40").attr("style", "");
    });

    $('#btn_add_more_function_part40').click(function() {
        $("#btn_add_more_function_part40").hide();
        $(".part41").attr("style", "");
    });

    $('#btn_add_more_function_part41').click(function() {
        $("#btn_add_more_function_part41").hide();
        $(".part42").attr("style", "");
    });

    $('#btn_add_more_function_part42').click(function() {
        $("#btn_add_more_function_part42").hide();
        $(".part43").attr("style", "");
    });

    $('#btn_add_more_function_part43').click(function() {
        $("#btn_add_more_function_part43").hide();
        $(".part44").attr("style", "");
    });

    $('#btn_add_more_function_part44').click(function() {
        $("#btn_add_more_function_part44").hide();
        $(".part45").attr("style", "");
    });

    $('#btn_add_more_function_part45').click(function() {
        $("#btn_add_more_function_part45").hide();
        $(".part46").attr("style", "");
    });

    $('#btn_add_more_function_part46').click(function() {
        $("#btn_add_more_function_part46").hide();
        $(".part47").attr("style", "");
    });

    $('#btn_add_more_function_part47').click(function() {
        $("#btn_add_more_function_part47").hide();
        $(".part48").attr("style", "");
    });

    $('#btn_add_more_function_part48').click(function() {
        $("#btn_add_more_function_part48").hide();
        $(".part49").attr("style", "");
    });

    $('#btn_add_more_function_part49').click(function() {
        $("#btn_add_more_function_part49").hide();
        $(".part50").attr("style", "");
    });

    $('#btn_add_more_function_part50').click(function() {
        $("#btn_add_more_function_part50").hide();
        $(".part51").attr("style", "");
    });

    $('#btn_add_more_function_part51').click(function() {
        $("#btn_add_more_function_part51").hide();
        $(".part52").attr("style", "");
    });

    $('#btn_add_more_function_part52').click(function() {
        $("#btn_add_more_function_part52").hide();
        $(".part53").attr("style", "");
    });

    $('#btn_add_more_function_part53').click(function() {
        $("#btn_add_more_function_part53").hide();
        $(".part54").attr("style", "");
    });

    $('#btn_add_more_function_part54').click(function() {
        $("#btn_add_more_function_part54").hide();
        $(".part55").attr("style", "");
    });

    $('#btn_add_more_function_part55').click(function() {
        $("#btn_add_more_function_part55").hide();
        $(".part56").attr("style", "");
    });

    $('#btn_add_more_function_part56').click(function() {
        $("#btn_add_more_function_part56").hide();
        $(".part57").attr("style", "");
    });

    $('#btn_add_more_function_part57').click(function() {
        $("#btn_add_more_function_part57").hide();
        $(".part58").attr("style", "");
    });

    $('#btn_add_more_function_part58').click(function() {
        $("#btn_add_more_function_part58").hide();
        $(".part59").attr("style", "");
    });

    $('#btn_add_more_function_part59').click(function() {
        $("#btn_add_more_function_part59").hide();
        $(".part60").attr("style", "");
    });

    $('#btn_add_more_function_part60').click(function() {
        $("#btn_add_more_function_part60").hide();
        $(".part61").attr("style", "");
    });

    $('#btn_add_more_function_part61').click(function() {
        $("#btn_add_more_function_part61").hide();
        $(".part62").attr("style", "");
    });

    $('#btn_add_more_function_part62').click(function() {
        $("#btn_add_more_function_part62").hide();
        $(".part63").attr("style", "");
    });

    $('#btn_add_more_function_part63').click(function() {
        $("#btn_add_more_function_part63").hide();
        $(".part64").attr("style", "");
    });

    $('#btn_add_more_function_part64').click(function() {
        $("#btn_add_more_function_part64").hide();
        $(".part65").attr("style", "");
    });

    $('#btn_add_more_function_part65').click(function() {
        $("#btn_add_more_function_part65").hide();
        $(".part66").attr("style", "");
    });

    $('#btn_add_more_function_part66').click(function() {
        $("#btn_add_more_function_part66").hide();
        $(".part67").attr("style", "");
    });

    $('#btn_add_more_function_part67').click(function() {
        $("#btn_add_more_function_part67").hide();
        $(".part68").attr("style", "");
    });

    $('#btn_add_more_function_part68').click(function() {
        $("#btn_add_more_function_part68").hide();
        $(".part69").attr("style", "");
    });

    $('#btn_add_more_function_part69').click(function() {
        $("#btn_add_more_function_part69").hide();
        $(".part70").attr("style", "");
    });

    $('#btn_add_more_function_part70').click(function() {
        $("#btn_add_more_function_part70").hide();
        $(".part71").attr("style", "");
    });

    $('#btn_add_more_function_part71').click(function() {
        $("#btn_add_more_function_part71").hide();
        $(".part72").attr("style", "");
    });

    $('#btn_add_more_function_part72').click(function() {
        $("#btn_add_more_function_part72").hide();
        $(".part73").attr("style", "");
    });

    $('#btn_add_more_function_part73').click(function() {
        $("#btn_add_more_function_part73").hide();
        $(".part74").attr("style", "");
    });

    $('#btn_add_more_function_part74').click(function() {
        $("#btn_add_more_function_part74").hide();
        $(".part75").attr("style", "");
    });

    $('#btn_add_more_function_part75').click(function() {
        $("#btn_add_more_function_part75").hide();
        $(".part76").attr("style", "");
    });

    $('#btn_add_more_function_part76').click(function() {
        $("#btn_add_more_function_part76").hide();
        $(".part77").attr("style", "");
    });

    $('#btn_add_more_function_part77').click(function() {
        $("#btn_add_more_function_part77").hide();
        $(".part78").attr("style", "");
    });

    $('#btn_add_more_function_part78').click(function() {
        $("#btn_add_more_function_part78").hide();
        $(".part79").attr("style", "");
    });

    $('#btn_add_more_function_part79').click(function() {
        $("#btn_add_more_function_part79").hide();
        $(".part80").attr("style", "");
    });

    $('#btn_add_more_function_part80').click(function() {
        $("#btn_add_more_function_part80").hide();
        $(".part81").attr("style", "");
    });

    $('#btn_add_more_function_part81').click(function() {
        $("#btn_add_more_function_part81").hide();
        $(".part82").attr("style", "");
    });

    $('#btn_add_more_function_part82').click(function() {
        $("#btn_add_more_function_part82").hide();
        $(".part83").attr("style", "");
    });

    $('#btn_add_more_function_part83').click(function() {
        $("#btn_add_more_function_part83").hide();
        $(".part84").attr("style", "");
    });

    $('#btn_add_more_function_part84').click(function() {
        $("#btn_add_more_function_part84").hide();
        $(".part85").attr("style", "");
    });

    $('#btn_add_more_function_part85').click(function() {
        $("#btn_add_more_function_part85").hide();
        $(".part86").attr("style", "");
    });

    $('#btn_add_more_function_part86').click(function() {
        $("#btn_add_more_function_part86").hide();
        $(".part87").attr("style", "");
    });

    $('#btn_add_more_function_part87').click(function() {
        $("#btn_add_more_function_part87").hide();
        $(".part88").attr("style", "");
    });

    $('#btn_add_more_function_part88').click(function() {
        $("#btn_add_more_function_part88").hide();
        $(".part89").attr("style", "");
    });

    $('#btn_add_more_function_part89').click(function() {
        $("#btn_add_more_function_part89").hide();
        $(".part90").attr("style", "");
    });

    $('#btn_add_more_function_part89').click(function() {
        $("#btn_add_more_function_part89").hide();
        $(".part90").attr("style", "");
    });

    $('#btn_add_more_function_part90').click(function() {
        $("#btn_add_more_function_part90").hide();
        $(".part91").attr("style", "");
    });

    $('#btn_add_more_function_part91').click(function() {
        $("#btn_add_more_function_part91").hide();
        $(".part92").attr("style", "");
    });

    $('#btn_add_more_function_part92').click(function() {
        $("#btn_add_more_function_part92").hide();
        $(".part93").attr("style", "");
    });

    $('#btn_add_more_function_part93').click(function() {
        $("#btn_add_more_function_part93").hide();
        $(".part94").attr("style", "");
    });

    $('#btn_add_more_function_part94').click(function() {
        $("#btn_add_more_function_part94").hide();
        $(".part95").attr("style", "");
    });

    $('#btn_add_more_function_part95').click(function() {
        $("#btn_add_more_function_part95").hide();
        $(".part96").attr("style", "");
    });

    $('#btn_add_more_function_part96').click(function() {
        $("#btn_add_more_function_part96").hide();
        $(".part97").attr("style", "");
    });

    $('#btn_add_more_function_part97').click(function() {
        $("#btn_add_more_function_part97").hide();
        $(".part98").attr("style", "");
    });

    $('#btn_add_more_function_part98').click(function() {
        $("#btn_add_more_function_part98").hide();
        $(".part99").attr("style", "");
    });

    $('#btn_add_more_function_part99').click(function() {
        $("#btn_add_more_function_part99").hide();
        $(".part100").attr("style", "");
    });

    $('#btn_nav_addproduct1').click(function() {
        $(".nav_product1").attr("style", "");
    });


    //BUTTON FOR FUNCTION TEST
    //#1 FUNCTION TEST
    $('#btn_add_more_function_test1').click(function() {
        $("#btn_add_more_function_test1").hide();
        $(".functions1_part2").attr("style", "");
    });

    $('#btn_add_more_functions1_part2').click(function() {
        $("#btn_add_more_functions1_part2").hide();
        $(".functions1_part3").attr("style", "");
    });

    $('#btn_add_more_functions1_part3').click(function() {
        $("#btn_add_more_functions1_part3").hide();
        $(".functions1_part4").attr("style", "");
    });

    $('#btn_add_more_functions1_part4').click(function() {
        $("#btn_add_more_functions1_part4").hide();
        $(".functions1_part5").attr("style", "");
    });

    $('.remove_more_functions1_part2').click(function() {
        $("#btn_add_more_function_test1").show();
        $(".functions1_part2").attr("style", "display: none");
    });

    $('.remove_more_functions1_part3').click(function() {
        $("#btn_add_more_functions1_part2").show();
        $(".functions1_part3").attr("style", "display: none");
    });

    $('.remove_more_functions1_part4').click(function() {
        $("#btn_add_more_functions1_part3").show();
        $(".functions1_part4").attr("style", "display: none");
    });

    $('.remove_more_functions1_part5').click(function() {
        $("#btn_add_more_functions1_part4").show();
        $(".functions1_part5").attr("style", "display: none");
    });
    //#2 FUNCTION TEST
    $('#btn_add_more_function_test2').click(function() {
        $("#btn_add_more_function_test2").hide();
        $(".functions2_part2").attr("style", "");
    });

    $('#btn_add_more_functions2_part2').click(function() {
        $("#btn_add_more_functions2_part2").hide();
        $(".functions2_part3").attr("style", "");
    });

    $('#btn_add_more_functions2_part3').click(function() {
        $("#btn_add_more_functions2_part3").hide();
        $(".functions2_part4").attr("style", "");
    });

    $('#btn_add_more_functions2_part4').click(function() {
        $("#btn_add_more_functions2_part4").hide();
        $(".functions2_part5").attr("style", "");
    });

    $('.remove_more_functions2_part2').click(function() {
        $("#btn_add_more_function_test2").show();
        $(".functions2_part2").attr("style", "display: none");
    });

    $('.remove_more_functions2_part3').click(function() {
        $("#btn_add_more_functions2_part2").show();
        $(".functions2_part3").attr("style", "display: none");
    });

    $('.remove_more_functions2_part4').click(function() {
        $("#btn_add_more_functions2_part3").show();
        $(".functions2_part4").attr("style", "display: none");
    });

    $('.remove_more_functions2_part5').click(function() {
        $("#btn_add_more_functions2_part4").show();
        $(".functions2_part5").attr("style", "display: none");
    });

    //#3 FUNCTION TEST
    $('#btn_add_more_function_test3').click(function() {
        $("#btn_add_more_function_test3").hide();
        $(".functions3_part2").attr("style", "");
    });

    $('#btn_add_more_functions3_part2').click(function() {
        $("#btn_add_more_functions3_part2").hide();
        $(".functions3_part3").attr("style", "");
    });

    $('#btn_add_more_functions3_part3').click(function() {
        $("#btn_add_more_functions3_part3").hide();
        $(".functions3_part4").attr("style", "");
    });

    $('#btn_add_more_functions3_part4').click(function() {
        $("#btn_add_more_functions3_part4").hide();
        $(".functions3_part5").attr("style", "");
    });

    $('.remove_more_functions3_part2').click(function() {
        $("#btn_add_more_function_test3").show();
        $(".functions3_part2").attr("style", "display: none");
    });

    $('.remove_more_functions3_part3').click(function() {
        $("#btn_add_more_functions3_part2").show();
        $(".functions3_part3").attr("style", "display: none");
    });

    $('.remove_more_functions3_part4').click(function() {
        $("#btn_add_more_functions3_part3").show();
        $(".functions3_part4").attr("style", "display: none");
    });

    $('.remove_more_functions3_part5').click(function() {
        $("#btn_add_more_functions3_part4").show();
        $(".functions3_part5").attr("style", "display: none");
    });

    //BUTTON FOR ADD DEFECT FAILURES
    //#1
    $('#btn_add_more_defect_failures_1_part1').click(function() {
        $("#btn_add_more_defect_failures_1_part1").hide();
        $(".defects1_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_1_part2').click(function() {
        $("#btn_add_more_defect_failures_1_part2").hide();
        $(".defects1_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_1_part3').click(function() {
        $("#btn_add_more_defect_failures_1_part3").hide();
        $(".defects1_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_1_part4').click(function() {
        $("#btn_add_more_defect_failures_1_part4").hide();
        $(".defects1_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_1_part2').click(function() {
        $("#btn_add_more_defect_failures_1_part1").show();
        $(".defects1_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_1_part3').click(function() {
        $("#btn_add_more_defect_failures_1_part2").show();
        $(".defects1_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_1_part4').click(function() {
        $("#btn_add_more_defect_failures_1_part3").show();
        $(".defects1_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_1_part5').click(function() {
        $("#btn_add_more_defect_failures_1_part4").show();
        $(".defects1_part5").attr("style", "display: none");
    });


    //#2
    $('#btn_add_more_defect_failures_2_part1').click(function() {
        $("#btn_add_more_defect_failures_2_part1").hide();
        $(".defects2_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_2_part2').click(function() {
        $("#btn_add_more_defect_failures_2_part2").hide();
        $(".defects2_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_2_part3').click(function() {
        $("#btn_add_more_defect_failures_2_part3").hide();
        $(".defects2_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_2_part4').click(function() {
        $("#btn_add_more_defect_failures_2_part4").hide();
        $(".defects2_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_2_part2').click(function() {
        $("#btn_add_more_defect_failures_2_part1").show();
        $(".defects2_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_2_part3').click(function() {
        $("#btn_add_more_defect_failures_2_part2").show();
        $(".defects2_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_2_part4').click(function() {
        $("#btn_add_more_defect_failures_2_part3").show();
        $(".defects2_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_2_part5').click(function() {
        $("#btn_add_more_defect_failures_2_part4").show();
        $(".defects2_part5").attr("style", "display: none");
    });

    //#3
    $('#btn_add_more_defect_failures_3_part1').click(function() {
        $("#btn_add_more_defect_failures_3_part1").hide();
        $(".defects3_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_3_part2').click(function() {
        $("#btn_add_more_defect_failures_3_part2").hide();
        $(".defects3_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_3_part3').click(function() {
        $("#btn_add_more_defect_failures_3_part3").hide();
        $(".defects3_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_3_part4').click(function() {
        $("#btn_add_more_defect_failures_3_part4").hide();
        $(".defects3_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_3_part2').click(function() {
        $("#btn_add_more_defect_failures_3_part1").show();
        $(".defects3_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_3_part3').click(function() {
        $("#btn_add_more_defect_failures_3_part2").show();
        $(".defects3_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_3_part4').click(function() {
        $("#btn_add_more_defect_failures_3_part3").show();
        $(".defects3_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_3_part5').click(function() {
        $("#btn_add_more_defect_failures_3_part4").show();
        $(".defects3_part5").attr("style", "display: none");
    });

    //#4
    $('#btn_add_more_defect_failures_4_part1').click(function() {
        $("#btn_add_more_defect_failures_4_part1").hide();
        $(".defects4_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_4_part2').click(function() {
        $("#btn_add_more_defect_failures_4_part2").hide();
        $(".defects4_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_4_part3').click(function() {
        $("#btn_add_more_defect_failures_4_part3").hide();
        $(".defects4_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_4_part4').click(function() {
        $("#btn_add_more_defect_failures_4_part4").hide();
        $(".defects4_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_4_part2').click(function() {
        $("#btn_add_more_defect_failures_4_part1").show();
        $(".defects4_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_4_part3').click(function() {
        $("#btn_add_more_defect_failures_4_part2").show();
        $(".defects4_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_4_part4').click(function() {
        $("#btn_add_more_defect_failures_4_part3").show();
        $(".defects4_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_4_part5').click(function() {
        $("#btn_add_more_defect_failures_4_part4").show();
        $(".defects4_part5").attr("style", "display: none");
    });

    //#5
    $('#btn_add_more_defect_failures_5_part1').click(function() {
        $("#btn_add_more_defect_failures_5_part1").hide();
        $(".defects5_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_5_part2').click(function() {
        $("#btn_add_more_defect_failures_5_part2").hide();
        $(".defects5_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_5_part3').click(function() {
        $("#btn_add_more_defect_failures_5_part3").hide();
        $(".defects5_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_5_part4').click(function() {
        $("#btn_add_more_defect_failures_5_part4").hide();
        $(".defects5_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_5_part2').click(function() {
        $("#btn_add_more_defect_failures_5_part1").show();
        $(".defects5_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_5_part3').click(function() {
        $("#btn_add_more_defect_failures_5_part2").show();
        $(".defects5_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_5_part4').click(function() {
        $("#btn_add_more_defect_failures_5_part3").show();
        $(".defects5_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_5_part5').click(function() {
        $("#btn_add_more_defect_failures_5_part4").show();
        $(".defects5_part5").attr("style", "display: none");
    });

    //#6
    $('#btn_add_more_defect_failures_6_part1').click(function() {
        $("#btn_add_more_defect_failures_6_part1").hide();
        $(".defects6_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_6_part2').click(function() {
        $("#btn_add_more_defect_failures_6_part2").hide();
        $(".defects6_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_6_part3').click(function() {
        $("#btn_add_more_defect_failures_6_part3").hide();
        $(".defects6_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_6_part4').click(function() {
        $("#btn_add_more_defect_failures_6_part4").hide();
        $(".defects6_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_6_part2').click(function() {
        $("#btn_add_more_defect_failures_6_part1").show();
        $(".defects6_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_6_part3').click(function() {
        $("#btn_add_more_defect_failures_6_part2").show();
        $(".defects6_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_6_part4').click(function() {
        $("#btn_add_more_defect_failures_6_part3").show();
        $(".defects6_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_6_part5').click(function() {
        $("#btn_add_more_defect_failures_6_part4").show();
        $(".defects6_part5").attr("style", "display: none");
    });

    //#7
    $('#btn_add_more_defect_failures_7_part1').click(function() {
        $("#btn_add_more_defect_failures_7_part1").hide();
        $(".defects7_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_7_part2').click(function() {
        $("#btn_add_more_defect_failures_7_part2").hide();
        $(".defects7_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_7_part3').click(function() {
        $("#btn_add_more_defect_failures_7_part3").hide();
        $(".defects7_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_7_part4').click(function() {
        $("#btn_add_more_defect_failures_7_part4").hide();
        $(".defects7_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_7_part2').click(function() {
        $("#btn_add_more_defect_failures_7_part1").show();
        $(".defects7_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_7_part3').click(function() {
        $("#btn_add_more_defect_failures_7_part2").show();
        $(".defects7_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_7_part4').click(function() {
        $("#btn_add_more_defect_failures_7_part3").show();
        $(".defects7_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_7_part5').click(function() {
        $("#btn_add_more_defect_failures_7_part4").show();
        $(".defects7_part5").attr("style", "display: none");
    });

    //#8
    $('#btn_add_more_defect_failures_8_part1').click(function() {
        $("#btn_add_more_defect_failures_8_part1").hide();
        $(".defects8_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_8_part2').click(function() {
        $("#btn_add_more_defect_failures_8_part2").hide();
        $(".defects8_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_8_part3').click(function() {
        $("#btn_add_more_defect_failures_8_part3").hide();
        $(".defects8_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_8_part4').click(function() {
        $("#btn_add_more_defect_failures_8_part4").hide();
        $(".defects8_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_8_part2').click(function() {
        $("#btn_add_more_defect_failures_8_part1").show();
        $(".defects8_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_8_part3').click(function() {
        $("#btn_add_more_defect_failures_8_part2").show();
        $(".defects8_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_8_part4').click(function() {
        $("#btn_add_more_defect_failures_8_part3").show();
        $(".defects8_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_8_part5').click(function() {
        $("#btn_add_more_defect_failures_8_part4").show();
        $(".defects8_part5").attr("style", "display: none");
    });

    //#9
    $('#btn_add_more_defect_failures_9_part1').click(function() {
        $("#btn_add_more_defect_failures_9_part1").hide();
        $(".defects9_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_9_part2').click(function() {
        $("#btn_add_more_defect_failures_9_part2").hide();
        $(".defects9_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_9_part3').click(function() {
        $("#btn_add_more_defect_failures_9_part3").hide();
        $(".defects9_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_9_part4').click(function() {
        $("#btn_add_more_defect_failures_9_part4").hide();
        $(".defects9_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_9_part2').click(function() {
        $("#btn_add_more_defect_failures_9_part1").show();
        $(".defects9_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_9_part3').click(function() {
        $("#btn_add_more_defect_failures_9_part2").show();
        $(".defects9_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_9_part4').click(function() {
        $("#btn_add_more_defect_failures_9_part3").show();
        $(".defects9_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_9_part5').click(function() {
        $("#btn_add_more_defect_failures_9_part4").show();
        $(".defects9_part5").attr("style", "display: none");
    });

    //#10
    $('#btn_add_more_defect_failures_10_part1').click(function() {
        $("#btn_add_more_defect_failures_10_part1").hide();
        $(".defects10_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_10_part2').click(function() {
        $("#btn_add_more_defect_failures_10_part2").hide();
        $(".defects10_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_10_part3').click(function() {
        $("#btn_add_more_defect_failures_10_part3").hide();
        $(".defects10_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_10_part4').click(function() {
        $("#btn_add_more_defect_failures_10_part4").hide();
        $(".defects10_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_10_part2').click(function() {
        $("#btn_add_more_defect_failures_10_part1").show();
        $(".defects10_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_10_part3').click(function() {
        $("#btn_add_more_defect_failures_10_part2").show();
        $(".defects10_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_10_part4').click(function() {
        $("#btn_add_more_defect_failures_10_part3").show();
        $(".defects10_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_10_part5').click(function() {
        $("#btn_add_more_defect_failures_10_part4").show();
        $(".defects10_part5").attr("style", "display: none");
    });

    //#11
    $('#btn_add_more_defect_failures_11_part1').click(function() {
        $("#btn_add_more_defect_failures_11_part1").hide();
        $(".defects11_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_11_part2').click(function() {
        $("#btn_add_more_defect_failures_11_part2").hide();
        $(".defects11_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_11_part3').click(function() {
        $("#btn_add_more_defect_failures_11_part3").hide();
        $(".defects11_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_11_part4').click(function() {
        $("#btn_add_more_defect_failures_11_part4").hide();
        $(".defects11_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_11_part2').click(function() {
        $("#btn_add_more_defect_failures_11_part1").show();
        $(".defects11_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_11_part3').click(function() {
        $("#btn_add_more_defect_failures_11_part2").show();
        $(".defects11_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_11_part4').click(function() {
        $("#btn_add_more_defect_failures_11_part3").show();
        $(".defects11_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_11_part5').click(function() {
        $("#btn_add_more_defect_failures_11_part4").show();
        $(".defects11_part5").attr("style", "display: none");
    });

    //#12
    $('#btn_add_more_defect_failures_12_part1').click(function() {
        $("#btn_add_more_defect_failures_12_part1").hide();
        $(".defects12_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_12_part2').click(function() {
        $("#btn_add_more_defect_failures_12_part2").hide();
        $(".defects12_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_12_part3').click(function() {
        $("#btn_add_more_defect_failures_12_part3").hide();
        $(".defects12_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_12_part4').click(function() {
        $("#btn_add_more_defect_failures_12_part4").hide();
        $(".defects12_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_12_part2').click(function() {
        $("#btn_add_more_defect_failures_12_part1").show();
        $(".defects12_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_12_part3').click(function() {
        $("#btn_add_more_defect_failures_12_part2").show();
        $(".defects12_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_12_part4').click(function() {
        $("#btn_add_more_defect_failures_12_part3").show();
        $(".defects12_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_12_part5').click(function() {
        $("#btn_add_more_defect_failures_12_part4").show();
        $(".defects12_part5").attr("style", "display: none");
    });

    //#13
    $('#btn_add_more_defect_failures_13_part1').click(function() {
        $("#btn_add_more_defect_failures_13_part1").hide();
        $(".defects13_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_13_part2').click(function() {
        $("#btn_add_more_defect_failures_13_part2").hide();
        $(".defects13_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_13_part3').click(function() {
        $("#btn_add_more_defect_failures_13_part3").hide();
        $(".defects13_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_13_part4').click(function() {
        $("#btn_add_more_defect_failures_13_part4").hide();
        $(".defects13_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_13_part2').click(function() {
        $("#btn_add_more_defect_failures_13_part1").show();
        $(".defects13_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_13_part3').click(function() {
        $("#btn_add_more_defect_failures_13_part2").show();
        $(".defects13_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_13_part4').click(function() {
        $("#btn_add_more_defect_failures_13_part3").show();
        $(".defects13_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_13_part5').click(function() {
        $("#btn_add_more_defect_failures_13_part4").show();
        $(".defects13_part5").attr("style", "display: none");
    });

    //#14
    $('#btn_add_more_defect_failures_14_part1').click(function() {
        $("#btn_add_more_defect_failures_14_part1").hide();
        $(".defects14_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_14_part2').click(function() {
        $("#btn_add_more_defect_failures_14_part2").hide();
        $(".defects14_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_14_part3').click(function() {
        $("#btn_add_more_defect_failures_14_part3").hide();
        $(".defects14_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_14_part4').click(function() {
        $("#btn_add_more_defect_failures_14_part4").hide();
        $(".defects14_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_14_part2').click(function() {
        $("#btn_add_more_defect_failures_14_part1").show();
        $(".defects14_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_14_part3').click(function() {
        $("#btn_add_more_defect_failures_14_part2").show();
        $(".defects14_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_14_part4').click(function() {
        $("#btn_add_more_defect_failures_14_part3").show();
        $(".defects14_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_14_part5').click(function() {
        $("#btn_add_more_defect_failures_14_part4").show();
        $(".defects14_part5").attr("style", "display: none");
    });

    //#15
    $('#btn_add_more_defect_failures_15_part1').click(function() {
        $("#btn_add_more_defect_failures_15_part1").hide();
        $(".defects15_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_15_part2').click(function() {
        $("#btn_add_more_defect_failures_15_part2").hide();
        $(".defects15_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_15_part3').click(function() {
        $("#btn_add_more_defect_failures_15_part3").hide();
        $(".defects15_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_15_part4').click(function() {
        $("#btn_add_more_defect_failures_15_part4").hide();
        $(".defects15_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_15_part2').click(function() {
        $("#btn_add_more_defect_failures_15_part1").show();
        $(".defects15_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_15_part3').click(function() {
        $("#btn_add_more_defect_failures_15_part2").show();
        $(".defects15_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_15_part4').click(function() {
        $("#btn_add_more_defect_failures_15_part3").show();
        $(".defects15_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_15_part5').click(function() {
        $("#btn_add_more_defect_failures_15_part4").show();
        $(".defects15_part5").attr("style", "display: none");
    });

    //#16
    $('#btn_add_more_defect_failures_16_part1').click(function() {
        $("#btn_add_more_defect_failures_16_part1").hide();
        $(".defects16_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_16_part2').click(function() {
        $("#btn_add_more_defect_failures_16_part2").hide();
        $(".defects16_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_16_part3').click(function() {
        $("#btn_add_more_defect_failures_16_part3").hide();
        $(".defects16_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_16_part4').click(function() {
        $("#btn_add_more_defect_failures_16_part4").hide();
        $(".defects16_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_16_part2').click(function() {
        $("#btn_add_more_defect_failures_16_part1").show();
        $(".defects16_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_16_part3').click(function() {
        $("#btn_add_more_defect_failures_16_part2").show();
        $(".defects16_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_16_part4').click(function() {
        $("#btn_add_more_defect_failures_16_part3").show();
        $(".defects16_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_16_part5').click(function() {
        $("#btn_add_more_defect_failures_16_part4").show();
        $(".defects16_part5").attr("style", "display: none");
    });

    //#17
    $('#btn_add_more_defect_failures_17_part1').click(function() {
        $("#btn_add_more_defect_failures_17_part1").hide();
        $(".defects17_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_17_part2').click(function() {
        $("#btn_add_more_defect_failures_17_part2").hide();
        $(".defects17_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_17_part3').click(function() {
        $("#btn_add_more_defect_failures_17_part3").hide();
        $(".defects17_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_17_part4').click(function() {
        $("#btn_add_more_defect_failures_17_part4").hide();
        $(".defects17_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_17_part2').click(function() {
        $("#btn_add_more_defect_failures_17_part1").show();
        $(".defects17_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_17_part3').click(function() {
        $("#btn_add_more_defect_failures_17_part2").show();
        $(".defects17_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_17_part4').click(function() {
        $("#btn_add_more_defect_failures_17_part3").show();
        $(".defects17_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_17_part5').click(function() {
        $("#btn_add_more_defect_failures_17_part4").show();
        $(".defects17_part5").attr("style", "display: none");
    });

    //#18
    $('#btn_add_more_defect_failures_18_part1').click(function() {
        $("#btn_add_more_defect_failures_18_part1").hide();
        $(".defects18_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_18_part2').click(function() {
        $("#btn_add_more_defect_failures_18_part2").hide();
        $(".defects18_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_18_part3').click(function() {
        $("#btn_add_more_defect_failures_18_part3").hide();
        $(".defects18_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_18_part4').click(function() {
        $("#btn_add_more_defect_failures_18_part4").hide();
        $(".defects18_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_18_part2').click(function() {
        $("#btn_add_more_defect_failures_18_part1").show();
        $(".defects18_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_18_part3').click(function() {
        $("#btn_add_more_defect_failures_18_part2").show();
        $(".defects18_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_18_part4').click(function() {
        $("#btn_add_more_defect_failures_18_part3").show();
        $(".defects18_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_18_part5').click(function() {
        $("#btn_add_more_defect_failures_18_part4").show();
        $(".defects18_part5").attr("style", "display: none");
    });

    //#19
    $('#btn_add_more_defect_failures_19_part1').click(function() {
        $("#btn_add_more_defect_failures_19_part1").hide();
        $(".defects19_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_19_part2').click(function() {
        $("#btn_add_more_defect_failures_19_part2").hide();
        $(".defects19_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_19_part3').click(function() {
        $("#btn_add_more_defect_failures_19_part3").hide();
        $(".defects19_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_19_part4').click(function() {
        $("#btn_add_more_defect_failures_19_part4").hide();
        $(".defects19_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_19_part2').click(function() {
        $("#btn_add_more_defect_failures_19_part1").show();
        $(".defects19_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_19_part3').click(function() {
        $("#btn_add_more_defect_failures_19_part2").show();
        $(".defects19_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_19_part4').click(function() {
        $("#btn_add_more_defect_failures_19_part3").show();
        $(".defects19_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_19_part5').click(function() {
        $("#btn_add_more_defect_failures_19_part4").show();
        $(".defects19_part5").attr("style", "display: none");
    });

    //#20
    $('#btn_add_more_defect_failures_20_part1').click(function() {
        $("#btn_add_more_defect_failures_20_part1").hide();
        $(".defects20_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_20_part2').click(function() {
        $("#btn_add_more_defect_failures_20_part2").hide();
        $(".defects20_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_20_part3').click(function() {
        $("#btn_add_more_defect_failures_20_part3").hide();
        $(".defects20_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_20_part4').click(function() {
        $("#btn_add_more_defect_failures_20_part4").hide();
        $(".defects20_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_20_part2').click(function() {
        $("#btn_add_more_defect_failures_20_part1").show();
        $(".defects20_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_20_part3').click(function() {
        $("#btn_add_more_defect_failures_20_part2").show();
        $(".defects20_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_20_part4').click(function() {
        $("#btn_add_more_defect_failures_20_part3").show();
        $(".defects20_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_20_part5').click(function() {
        $("#btn_add_more_defect_failures_20_part4").show();
        $(".defects20_part5").attr("style", "display: none");
    });
    //#21
    $('#btn_add_more_defect_failures_21_part1').click(function() {
        $("#btn_add_more_defect_failures_21_part1").hide();
        $(".defects21_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_21_part2').click(function() {
        $("#btn_add_more_defect_failures_21_part2").hide();
        $(".defects21_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_21_part3').click(function() {
        $("#btn_add_more_defect_failures_21_part3").hide();
        $(".defects21_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_21_part4').click(function() {
        $("#btn_add_more_defect_failures_21_part4").hide();
        $(".defects21_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_21_part2').click(function() {
        $("#btn_add_more_defect_failures_21_part1").show();
        $(".defects21_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_21_part3').click(function() {
        $("#btn_add_more_defect_failures_21_part2").show();
        $(".defects21_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_21_part4').click(function() {
        $("#btn_add_more_defect_failures_21_part3").show();
        $(".defects21_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_21_part5').click(function() {
        $("#btn_add_more_defect_failures_21_part4").show();
        $(".defects21_part5").attr("style", "display: none");
    });
    //#22
    $('#btn_add_more_defect_failures_22_part1').click(function() {
        $("#btn_add_more_defect_failures_22_part1").hide();
        $(".defects22_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_22_part2').click(function() {
        $("#btn_add_more_defect_failures_22_part2").hide();
        $(".defects22_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_22_part3').click(function() {
        $("#btn_add_more_defect_failures_22_part3").hide();
        $(".defects22_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_22_part4').click(function() {
        $("#btn_add_more_defect_failures_22_part4").hide();
        $(".defects22_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_22_part2').click(function() {
        $("#btn_add_more_defect_failures_22_part1").show();
        $(".defects22_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_22_part3').click(function() {
        $("#btn_add_more_defect_failures_22_part2").show();
        $(".defects22_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_22_part4').click(function() {
        $("#btn_add_more_defect_failures_22_part3").show();
        $(".defects22_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_22_part5').click(function() {
        $("#btn_add_more_defect_failures_22_part4").show();
        $(".defects22_part5").attr("style", "display: none");
    });
    //23
    $('#btn_add_more_defect_failures_23_part1').click(function() {
        $("#btn_add_more_defect_failures_23_part1").hide();
        $(".defects23_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_23_part2').click(function() {
        $("#btn_add_more_defect_failures_23_part2").hide();
        $(".defects23_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_23_part3').click(function() {
        $("#btn_add_more_defect_failures_23_part3").hide();
        $(".defects23_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_23_part4').click(function() {
        $("#btn_add_more_defect_failures_23_part4").hide();
        $(".defects23_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_23_part2').click(function() {
        $("#btn_add_more_defect_failures_23_part1").show();
        $(".defects23_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_23_part3').click(function() {
        $("#btn_add_more_defect_failures_23_part2").show();
        $(".defects23_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_23_part4').click(function() {
        $("#btn_add_more_defect_failures_23_part3").show();
        $(".defects23_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_23_part5').click(function() {
        $("#btn_add_more_defect_failures_23_part4").show();
        $(".defects23_part5").attr("style", "display: none");
    });
    //24
    $('#btn_add_more_defect_failures_24_part1').click(function() {
        $("#btn_add_more_defect_failures_24_part1").hide();
        $(".defects24_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_24_part2').click(function() {
        $("#btn_add_more_defect_failures_24_part2").hide();
        $(".defects24_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_24_part3').click(function() {
        $("#btn_add_more_defect_failures_24_part3").hide();
        $(".defects24_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_24_part4').click(function() {
        $("#btn_add_more_defect_failures_24_part4").hide();
        $(".defects24_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_24_part2').click(function() {
        $("#btn_add_more_defect_failures_24_part1").show();
        $(".defects24_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_24_part3').click(function() {
        $("#btn_add_more_defect_failures_24_part2").show();
        $(".defects24_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_24_part4').click(function() {
        $("#btn_add_more_defect_failures_24_part3").show();
        $(".defects24_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_24_part5').click(function() {
        $("#btn_add_more_defect_failures_24_part4").show();
        $(".defects24_part5").attr("style", "display: none");
    });
    //25
    $('#btn_add_more_defect_failures_25_part1').click(function() {
        $("#btn_add_more_defect_failures_25_part1").hide();
        $(".defects25_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_25_part2').click(function() {
        $("#btn_add_more_defect_failures_25_part2").hide();
        $(".defects25_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_25_part3').click(function() {
        $("#btn_add_more_defect_failures_25_part3").hide();
        $(".defects25_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_25_part4').click(function() {
        $("#btn_add_more_defect_failures_25_part4").hide();
        $(".defects25_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_25_part2').click(function() {
        $("#btn_add_more_defect_failures_25_part1").show();
        $(".defects25_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_25_part3').click(function() {
        $("#btn_add_more_defect_failures_25_part2").show();
        $(".defects25_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_25_part4').click(function() {
        $("#btn_add_more_defect_failures_25_part3").show();
        $(".defects25_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_25_part5').click(function() {
        $("#btn_add_more_defect_failures_25_part4").show();
        $(".defects25_part5").attr("style", "display: none");
    });
    //26
    $('#btn_add_more_defect_failures_26_part1').click(function() {
        $("#btn_add_more_defect_failures_26_part1").hide();
        $(".defects26_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_26_part2').click(function() {
        $("#btn_add_more_defect_failures_26_part2").hide();
        $(".defects26_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_26_part3').click(function() {
        $("#btn_add_more_defect_failures_26_part3").hide();
        $(".defects26_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_26_part4').click(function() {
        $("#btn_add_more_defect_failures_26_part4").hide();
        $(".defects26_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_26_part2').click(function() {
        $("#btn_add_more_defect_failures_26_part1").show();
        $(".defects26_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_26_part3').click(function() {
        $("#btn_add_more_defect_failures_26_part2").show();
        $(".defects26_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_26_part4').click(function() {
        $("#btn_add_more_defect_failures_26_part3").show();
        $(".defects26_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_26_part5').click(function() {
        $("#btn_add_more_defect_failures_26_part4").show();
        $(".defects26_part5").attr("style", "display: none");
    });
    //27
    $('#btn_add_more_defect_failures_27_part1').click(function() {
        $("#btn_add_more_defect_failures_27_part1").hide();
        $(".defects27_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_27_part2').click(function() {
        $("#btn_add_more_defect_failures_27_part2").hide();
        $(".defects27_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_27_part3').click(function() {
        $("#btn_add_more_defect_failures_27_part3").hide();
        $(".defects27_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_27_part4').click(function() {
        $("#btn_add_more_defect_failures_27_part4").hide();
        $(".defects27_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_27_part2').click(function() {
        $("#btn_add_more_defect_failures_27_part1").show();
        $(".defects27_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_27_part3').click(function() {
        $("#btn_add_more_defect_failures_27_part2").show();
        $(".defects27_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_27_part4').click(function() {
        $("#btn_add_more_defect_failures_27_part3").show();
        $(".defects27_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_27_part5').click(function() {
        $("#btn_add_more_defect_failures_27_part4").show();
        $(".defects27_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_28_part1').click(function() {
        $("#btn_add_more_defect_failures_28_part1").hide();
        $(".defects28_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_28_part2').click(function() {
        $("#btn_add_more_defect_failures_28_part2").hide();
        $(".defects28_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_28_part3').click(function() {
        $("#btn_add_more_defect_failures_28_part3").hide();
        $(".defects28_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_28_part4').click(function() {
        $("#btn_add_more_defect_failures_28_part4").hide();
        $(".defects28_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_28_part2').click(function() {
        $("#btn_add_more_defect_failures_28_part1").show();
        $(".defects28_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_28_part3').click(function() {
        $("#btn_add_more_defect_failures_28_part2").show();
        $(".defects28_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_28_part4').click(function() {
        $("#btn_add_more_defect_failures_28_part3").show();
        $(".defects28_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_28_part5').click(function() {
        $("#btn_add_more_defect_failures_28_part4").show();
        $(".defects28_part5").attr("style", "display: none");
    });
    $('#btn_add_more_defect_failures_29_part1').click(function() {
        $("#btn_add_more_defect_failures_29_part1").hide();
        $(".defects29_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_29_part2').click(function() {
        $("#btn_add_more_defect_failures_29_part2").hide();
        $(".defects29_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_29_part3').click(function() {
        $("#btn_add_more_defect_failures_29_part3").hide();
        $(".defects29_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_29_part4').click(function() {
        $("#btn_add_more_defect_failures_29_part4").hide();
        $(".defects29_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_29_part2').click(function() {
        $("#btn_add_more_defect_failures_29_part1").show();
        $(".defects29_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_29_part3').click(function() {
        $("#btn_add_more_defect_failures_29_part2").show();
        $(".defects29_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_29_part4').click(function() {
        $("#btn_add_more_defect_failures_29_part3").show();
        $(".defects29_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_29_part5').click(function() {
        $("#btn_add_more_defect_failures_29_part4").show();
        $(".defects29_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_30_part1').click(function() {
        $("#btn_add_more_defect_failures_30_part1").hide();
        $(".defects30_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_30_part2').click(function() {
        $("#btn_add_more_defect_failures_30_part2").hide();
        $(".defects30_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_30_part3').click(function() {
        $("#btn_add_more_defect_failures_30_part3").hide();
        $(".defects30_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_30_part4').click(function() {
        $("#btn_add_more_defect_failures_30_part4").hide();
        $(".defects30_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_30_part2').click(function() {
        $("#btn_add_more_defect_failures_30_part1").show();
        $(".defects30_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_30_part3').click(function() {
        $("#btn_add_more_defect_failures_30_part2").show();
        $(".defects30_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_30_part4').click(function() {
        $("#btn_add_more_defect_failures_30_part3").show();
        $(".defects30_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_30_part5').click(function() {
        $("#btn_add_more_defect_failures_30_part4").show();
        $(".defects30_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_31_part1').click(function() {
        $("#btn_add_more_defect_failures_31_part1").hide();
        $(".defects31_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_31_part2').click(function() {
        $("#btn_add_more_defect_failures_31_part2").hide();
        $(".defects31_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_31_part3').click(function() {
        $("#btn_add_more_defect_failures_31_part3").hide();
        $(".defects31_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_31_part4').click(function() {
        $("#btn_add_more_defect_failures_31_part4").hide();
        $(".defects31_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_31_part2').click(function() {
        $("#btn_add_more_defect_failures_31_part1").show();
        $(".defects31_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_31_part3').click(function() {
        $("#btn_add_more_defect_failures_31_part2").show();
        $(".defects31_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_31_part4').click(function() {
        $("#btn_add_more_defect_failures_31_part3").show();
        $(".defects31_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_31_part5').click(function() {
        $("#btn_add_more_defect_failures_31_part4").show();
        $(".defects31_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_32_part1').click(function() {
        $("#btn_add_more_defect_failures_32_part1").hide();
        $(".defects32_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_32_part2').click(function() {
        $("#btn_add_more_defect_failures_32_part2").hide();
        $(".defects32_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_32_part3').click(function() {
        $("#btn_add_more_defect_failures_32_part3").hide();
        $(".defects32_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_32_part4').click(function() {
        $("#btn_add_more_defect_failures_32_part4").hide();
        $(".defects32_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_32_part2').click(function() {
        $("#btn_add_more_defect_failures_32_part1").show();
        $(".defects32_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_32_part3').click(function() {
        $("#btn_add_more_defect_failures_32_part2").show();
        $(".defects32_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_32_part4').click(function() {
        $("#btn_add_more_defect_failures_32_part3").show();
        $(".defects32_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_32_part5').click(function() {
        $("#btn_add_more_defect_failures_32_part4").show();
        $(".defects32_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_33_part1').click(function() {
        $("#btn_add_more_defect_failures_33_part1").hide();
        $(".defects33_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_33_part2').click(function() {
        $("#btn_add_more_defect_failures_33_part2").hide();
        $(".defects33_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_33_part3').click(function() {
        $("#btn_add_more_defect_failures_33_part3").hide();
        $(".defects33_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_33_part4').click(function() {
        $("#btn_add_more_defect_failures_33_part4").hide();
        $(".defects33_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_33_part2').click(function() {
        $("#btn_add_more_defect_failures_33_part1").show();
        $(".defects33_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_33_part3').click(function() {
        $("#btn_add_more_defect_failures_33_part2").show();
        $(".defects33_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_33_part4').click(function() {
        $("#btn_add_more_defect_failures_33_part3").show();
        $(".defects33_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_33_part5').click(function() {
        $("#btn_add_more_defect_failures_33_part4").show();
        $(".defects33_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_34_part1').click(function() {
        $("#btn_add_more_defect_failures_34_part1").hide();
        $(".defects34_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_34_part2').click(function() {
        $("#btn_add_more_defect_failures_34_part2").hide();
        $(".defects34_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_34_part3').click(function() {
        $("#btn_add_more_defect_failures_34_part3").hide();
        $(".defects34_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_34_part4').click(function() {
        $("#btn_add_more_defect_failures_34_part4").hide();
        $(".defects34_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_34_part2').click(function() {
        $("#btn_add_more_defect_failures_34_part1").show();
        $(".defects34_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_34_part3').click(function() {
        $("#btn_add_more_defect_failures_34_part2").show();
        $(".defects34_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_34_part4').click(function() {
        $("#btn_add_more_defect_failures_34_part3").show();
        $(".defects34_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_34_part5').click(function() {
        $("#btn_add_more_defect_failures_34_part4").show();
        $(".defects34_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_35_part1').click(function() {
        $("#btn_add_more_defect_failures_35_part1").hide();
        $(".defects35_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_35_part2').click(function() {
        $("#btn_add_more_defect_failures_35_part2").hide();
        $(".defects35_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_35_part3').click(function() {
        $("#btn_add_more_defect_failures_35_part3").hide();
        $(".defects35_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_35_part4').click(function() {
        $("#btn_add_more_defect_failures_35_part4").hide();
        $(".defects35_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_35_part2').click(function() {
        $("#btn_add_more_defect_failures_35_part1").show();
        $(".defects35_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_35_part3').click(function() {
        $("#btn_add_more_defect_failures_35_part2").show();
        $(".defects35_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_35_part4').click(function() {
        $("#btn_add_more_defect_failures_35_part3").show();
        $(".defects35_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_35_part5').click(function() {
        $("#btn_add_more_defect_failures_35_part4").show();
        $(".defects35_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_36_part1').click(function() {
        $("#btn_add_more_defect_failures_36_part1").hide();
        $(".defects36_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_36_part2').click(function() {
        $("#btn_add_more_defect_failures_36_part2").hide();
        $(".defects36_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_36_part3').click(function() {
        $("#btn_add_more_defect_failures_36_part3").hide();
        $(".defects36_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_36_part4').click(function() {
        $("#btn_add_more_defect_failures_36_part4").hide();
        $(".defects36_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_36_part2').click(function() {
        $("#btn_add_more_defect_failures_36_part1").show();
        $(".defects36_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_36_part3').click(function() {
        $("#btn_add_more_defect_failures_36_part2").show();
        $(".defects36_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_36_part4').click(function() {
        $("#btn_add_more_defect_failures_36_part3").show();
        $(".defects36_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_36_part5').click(function() {
        $("#btn_add_more_defect_failures_36_part4").show();
        $(".defects36_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_37_part1').click(function() {
        $("#btn_add_more_defect_failures_37_part1").hide();
        $(".defects37_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_37_part2').click(function() {
        $("#btn_add_more_defect_failures_37_part2").hide();
        $(".defects37_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_37_part3').click(function() {
        $("#btn_add_more_defect_failures_37_part3").hide();
        $(".defects37_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_37_part4').click(function() {
        $("#btn_add_more_defect_failures_37_part4").hide();
        $(".defects37_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_37_part2').click(function() {
        $("#btn_add_more_defect_failures_37_part1").show();
        $(".defects37_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_37_part3').click(function() {
        $("#btn_add_more_defect_failures_37_part2").show();
        $(".defects37_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_37_part4').click(function() {
        $("#btn_add_more_defect_failures_37_part3").show();
        $(".defects37_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_37_part5').click(function() {
        $("#btn_add_more_defect_failures_37_part4").show();
        $(".defects37_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_38_part1').click(function() {
        $("#btn_add_more_defect_failures_38_part1").hide();
        $(".defects38_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_38_part2').click(function() {
        $("#btn_add_more_defect_failures_38_part2").hide();
        $(".defects38_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_38_part3').click(function() {
        $("#btn_add_more_defect_failures_38_part3").hide();
        $(".defects38_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_38_part4').click(function() {
        $("#btn_add_more_defect_failures_38_part4").hide();
        $(".defects38_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_38_part2').click(function() {
        $("#btn_add_more_defect_failures_38_part1").show();
        $(".defects38_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_38_part3').click(function() {
        $("#btn_add_more_defect_failures_38_part2").show();
        $(".defects38_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_38_part4').click(function() {
        $("#btn_add_more_defect_failures_38_part3").show();
        $(".defects38_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_38_part5').click(function() {
        $("#btn_add_more_defect_failures_38_part4").show();
        $(".defects38_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_39_part1').click(function() {
        $("#btn_add_more_defect_failures_39_part1").hide();
        $(".defects39_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_39_part2').click(function() {
        $("#btn_add_more_defect_failures_39_part2").hide();
        $(".defects39_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_39_part3').click(function() {
        $("#btn_add_more_defect_failures_39_part3").hide();
        $(".defects39_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_39_part4').click(function() {
        $("#btn_add_more_defect_failures_39_part4").hide();
        $(".defects39_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_39_part2').click(function() {
        $("#btn_add_more_defect_failures_39_part1").show();
        $(".defects39_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_39_part3').click(function() {
        $("#btn_add_more_defect_failures_39_part2").show();
        $(".defects39_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_39_part4').click(function() {
        $("#btn_add_more_defect_failures_39_part3").show();
        $(".defects39_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_39_part5').click(function() {
        $("#btn_add_more_defect_failures_39_part4").show();
        $(".defects39_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_40_part1').click(function() {
        $("#btn_add_more_defect_failures_40_part1").hide();
        $(".defects40_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_40_part2').click(function() {
        $("#btn_add_more_defect_failures_40_part2").hide();
        $(".defects40_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_40_part3').click(function() {
        $("#btn_add_more_defect_failures_40_part3").hide();
        $(".defects40_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_40_part4').click(function() {
        $("#btn_add_more_defect_failures_40_part4").hide();
        $(".defects40_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_40_part2').click(function() {
        $("#btn_add_more_defect_failures_40_part1").show();
        $(".defects40_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_40_part3').click(function() {
        $("#btn_add_more_defect_failures_40_part2").show();
        $(".defects40_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_40_part4').click(function() {
        $("#btn_add_more_defect_failures_40_part3").show();
        $(".defects40_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_40_part5').click(function() {
        $("#btn_add_more_defect_failures_40_part4").show();
        $(".defects40_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_41_part1').click(function() {
        $("#btn_add_more_defect_failures_41_part1").hide();
        $(".defects41_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_41_part2').click(function() {
        $("#btn_add_more_defect_failures_41_part2").hide();
        $(".defects41_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_41_part3').click(function() {
        $("#btn_add_more_defect_failures_41_part3").hide();
        $(".defects41_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_41_part4').click(function() {
        $("#btn_add_more_defect_failures_41_part4").hide();
        $(".defects41_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_41_part2').click(function() {
        $("#btn_add_more_defect_failures_41_part1").show();
        $(".defects41_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_41_part3').click(function() {
        $("#btn_add_more_defect_failures_41_part2").show();
        $(".defects41_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_41_part4').click(function() {
        $("#btn_add_more_defect_failures_41_part3").show();
        $(".defects41_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_41_part5').click(function() {
        $("#btn_add_more_defect_failures_41_part4").show();
        $(".defects41_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_42_part1').click(function() {
        $("#btn_add_more_defect_failures_42_part1").hide();
        $(".defects42_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_42_part2').click(function() {
        $("#btn_add_more_defect_failures_42_part2").hide();
        $(".defects42_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_42_part3').click(function() {
        $("#btn_add_more_defect_failures_42_part3").hide();
        $(".defects42_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_42_part4').click(function() {
        $("#btn_add_more_defect_failures_42_part4").hide();
        $(".defects42_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_42_part2').click(function() {
        $("#btn_add_more_defect_failures_42_part1").show();
        $(".defects42_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_42_part3').click(function() {
        $("#btn_add_more_defect_failures_42_part2").show();
        $(".defects42_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_42_part4').click(function() {
        $("#btn_add_more_defect_failures_42_part3").show();
        $(".defects42_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_42_part5').click(function() {
        $("#btn_add_more_defect_failures_42_part4").show();
        $(".defects42_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_43_part1').click(function() {
        $("#btn_add_more_defect_failures_43_part1").hide();
        $(".defects43_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_43_part2').click(function() {
        $("#btn_add_more_defect_failures_43_part2").hide();
        $(".defects43_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_43_part3').click(function() {
        $("#btn_add_more_defect_failures_43_part3").hide();
        $(".defects43_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_43_part4').click(function() {
        $("#btn_add_more_defect_failures_43_part4").hide();
        $(".defects43_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_43_part2').click(function() {
        $("#btn_add_more_defect_failures_43_part1").show();
        $(".defects43_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_43_part3').click(function() {
        $("#btn_add_more_defect_failures_43_part2").show();
        $(".defects43_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_43_part4').click(function() {
        $("#btn_add_more_defect_failures_43_part3").show();
        $(".defects43_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_43_part5').click(function() {
        $("#btn_add_more_defect_failures_43_part4").show();
        $(".defects43_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_44_part1').click(function() {
        $("#btn_add_more_defect_failures_44_part1").hide();
        $(".defects44_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_44_part2').click(function() {
        $("#btn_add_more_defect_failures_44_part2").hide();
        $(".defects44_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_44_part3').click(function() {
        $("#btn_add_more_defect_failures_44_part3").hide();
        $(".defects44_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_44_part4').click(function() {
        $("#btn_add_more_defect_failures_44_part4").hide();
        $(".defects44_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_44_part2').click(function() {
        $("#btn_add_more_defect_failures_44_part1").show();
        $(".defects44_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_44_part3').click(function() {
        $("#btn_add_more_defect_failures_44_part2").show();
        $(".defects44_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_44_part4').click(function() {
        $("#btn_add_more_defect_failures_44_part3").show();
        $(".defects44_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_44_part5').click(function() {
        $("#btn_add_more_defect_failures_44_part4").show();
        $(".defects44_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_45_part1').click(function() {
        $("#btn_add_more_defect_failures_45_part1").hide();
        $(".defects45_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_45_part2').click(function() {
        $("#btn_add_more_defect_failures_45_part2").hide();
        $(".defects45_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_45_part3').click(function() {
        $("#btn_add_more_defect_failures_45_part3").hide();
        $(".defects45_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_45_part4').click(function() {
        $("#btn_add_more_defect_failures_45_part4").hide();
        $(".defects45_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_45_part2').click(function() {
        $("#btn_add_more_defect_failures_45_part1").show();
        $(".defects45_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_45_part3').click(function() {
        $("#btn_add_more_defect_failures_45_part2").show();
        $(".defects45_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_45_part4').click(function() {
        $("#btn_add_more_defect_failures_45_part3").show();
        $(".defects45_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_45_part5').click(function() {
        $("#btn_add_more_defect_failures_45_part4").show();
        $(".defects45_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_46_part1').click(function() {
        $("#btn_add_more_defect_failures_46_part1").hide();
        $(".defects46_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_46_part2').click(function() {
        $("#btn_add_more_defect_failures_46_part2").hide();
        $(".defects46_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_46_part3').click(function() {
        $("#btn_add_more_defect_failures_46_part3").hide();
        $(".defects46_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_46_part4').click(function() {
        $("#btn_add_more_defect_failures_46_part4").hide();
        $(".defects46_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_46_part2').click(function() {
        $("#btn_add_more_defect_failures_46_part1").show();
        $(".defects46_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_46_part3').click(function() {
        $("#btn_add_more_defect_failures_46_part2").show();
        $(".defects46_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_46_part4').click(function() {
        $("#btn_add_more_defect_failures_46_part3").show();
        $(".defects46_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_46_part5').click(function() {
        $("#btn_add_more_defect_failures_46_part4").show();
        $(".defects46_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_47_part1').click(function() {
        $("#btn_add_more_defect_failures_47_part1").hide();
        $(".defects47_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_47_part2').click(function() {
        $("#btn_add_more_defect_failures_47_part2").hide();
        $(".defects47_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_47_part3').click(function() {
        $("#btn_add_more_defect_failures_47_part3").hide();
        $(".defects47_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_47_part4').click(function() {
        $("#btn_add_more_defect_failures_47_part4").hide();
        $(".defects47_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_47_part2').click(function() {
        $("#btn_add_more_defect_failures_47_part1").show();
        $(".defects47_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_47_part3').click(function() {
        $("#btn_add_more_defect_failures_47_part2").show();
        $(".defects47_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_47_part4').click(function() {
        $("#btn_add_more_defect_failures_47_part3").show();
        $(".defects47_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_47_part5').click(function() {
        $("#btn_add_more_defect_failures_47_part4").show();
        $(".defects47_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_48_part1').click(function() {
        $("#btn_add_more_defect_failures_48_part1").hide();
        $(".defects48_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_48_part2').click(function() {
        $("#btn_add_more_defect_failures_48_part2").hide();
        $(".defects48_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_48_part3').click(function() {
        $("#btn_add_more_defect_failures_48_part3").hide();
        $(".defects48_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_48_part4').click(function() {
        $("#btn_add_more_defect_failures_48_part4").hide();
        $(".defects48_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_48_part2').click(function() {
        $("#btn_add_more_defect_failures_48_part1").show();
        $(".defects48_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_48_part3').click(function() {
        $("#btn_add_more_defect_failures_48_part2").show();
        $(".defects48_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_48_part4').click(function() {
        $("#btn_add_more_defect_failures_48_part3").show();
        $(".defects48_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_48_part5').click(function() {
        $("#btn_add_more_defect_failures_48_part4").show();
        $(".defects48_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_49_part1').click(function() {
        $("#btn_add_more_defect_failures_49_part1").hide();
        $(".defects49_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_49_part2').click(function() {
        $("#btn_add_more_defect_failures_49_part2").hide();
        $(".defects49_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_49_part3').click(function() {
        $("#btn_add_more_defect_failures_49_part3").hide();
        $(".defects49_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_49_part4').click(function() {
        $("#btn_add_more_defect_failures_49_part4").hide();
        $(".defects49_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_49_part2').click(function() {
        $("#btn_add_more_defect_failures_49_part1").show();
        $(".defects49_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_49_part3').click(function() {
        $("#btn_add_more_defect_failures_49_part2").show();
        $(".defects49_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_49_part4').click(function() {
        $("#btn_add_more_defect_failures_49_part3").show();
        $(".defects49_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_49_part5').click(function() {
        $("#btn_add_more_defect_failures_49_part4").show();
        $(".defects49_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_50_part1').click(function() {
        $("#btn_add_more_defect_failures_50_part1").hide();
        $(".defects50_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_50_part2').click(function() {
        $("#btn_add_more_defect_failures_50_part2").hide();
        $(".defects50_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_50_part3').click(function() {
        $("#btn_add_more_defect_failures_50_part3").hide();
        $(".defects50_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_50_part4').click(function() {
        $("#btn_add_more_defect_failures_50_part4").hide();
        $(".defects50_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_50_part2').click(function() {
        $("#btn_add_more_defect_failures_50_part1").show();
        $(".defects50_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_50_part3').click(function() {
        $("#btn_add_more_defect_failures_50_part2").show();
        $(".defects50_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_50_part4').click(function() {
        $("#btn_add_more_defect_failures_50_part3").show();
        $(".defects50_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_50_part5').click(function() {
        $("#btn_add_more_defect_failures_50_part4").show();
        $(".defects50_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_51_part1').click(function() {
        $("#btn_add_more_defect_failures_51_part1").hide();
        $(".defects51_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_51_part2').click(function() {
        $("#btn_add_more_defect_failures_51_part2").hide();
        $(".defects51_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_51_part3').click(function() {
        $("#btn_add_more_defect_failures_51_part3").hide();
        $(".defects51_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_51_part4').click(function() {
        $("#btn_add_more_defect_failures_51_part4").hide();
        $(".defects51_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_51_part2').click(function() {
        $("#btn_add_more_defect_failures_51_part1").show();
        $(".defects51_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_51_part3').click(function() {
        $("#btn_add_more_defect_failures_51_part2").show();
        $(".defects51_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_51_part4').click(function() {
        $("#btn_add_more_defect_failures_51_part3").show();
        $(".defects51_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_51_part5').click(function() {
        $("#btn_add_more_defect_failures_51_part4").show();
        $(".defects51_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_52_part1').click(function() {
        $("#btn_add_more_defect_failures_52_part1").hide();
        $(".defects52_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_52_part2').click(function() {
        $("#btn_add_more_defect_failures_52_part2").hide();
        $(".defects52_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_52_part3').click(function() {
        $("#btn_add_more_defect_failures_52_part3").hide();
        $(".defects52_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_52_part4').click(function() {
        $("#btn_add_more_defect_failures_52_part4").hide();
        $(".defects52_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_52_part2').click(function() {
        $("#btn_add_more_defect_failures_52_part1").show();
        $(".defects52_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_52_part3').click(function() {
        $("#btn_add_more_defect_failures_52_part2").show();
        $(".defects52_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_52_part4').click(function() {
        $("#btn_add_more_defect_failures_52_part3").show();
        $(".defects52_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_52_part5').click(function() {
        $("#btn_add_more_defect_failures_52_part4").show();
        $(".defects52_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_53_part1').click(function() {
        $("#btn_add_more_defect_failures_53_part1").hide();
        $(".defects53_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_53_part2').click(function() {
        $("#btn_add_more_defect_failures_53_part2").hide();
        $(".defects53_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_53_part3').click(function() {
        $("#btn_add_more_defect_failures_53_part3").hide();
        $(".defects53_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_53_part4').click(function() {
        $("#btn_add_more_defect_failures_53_part4").hide();
        $(".defects53_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_53_part2').click(function() {
        $("#btn_add_more_defect_failures_53_part1").show();
        $(".defects53_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_53_part3').click(function() {
        $("#btn_add_more_defect_failures_53_part2").show();
        $(".defects53_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_53_part4').click(function() {
        $("#btn_add_more_defect_failures_53_part3").show();
        $(".defects53_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_53_part5').click(function() {
        $("#btn_add_more_defect_failures_53_part4").show();
        $(".defects53_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_54_part1').click(function() {
        $("#btn_add_more_defect_failures_54_part1").hide();
        $(".defects54_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_54_part2').click(function() {
        $("#btn_add_more_defect_failures_54_part2").hide();
        $(".defects54_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_54_part3').click(function() {
        $("#btn_add_more_defect_failures_54_part3").hide();
        $(".defects54_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_54_part4').click(function() {
        $("#btn_add_more_defect_failures_54_part4").hide();
        $(".defects54_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_54_part2').click(function() {
        $("#btn_add_more_defect_failures_54_part1").show();
        $(".defects54_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_54_part3').click(function() {
        $("#btn_add_more_defect_failures_54_part2").show();
        $(".defects54_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_54_part4').click(function() {
        $("#btn_add_more_defect_failures_54_part3").show();
        $(".defects54_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_54_part5').click(function() {
        $("#btn_add_more_defect_failures_54_part4").show();
        $(".defects54_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_55_part1').click(function() {
        $("#btn_add_more_defect_failures_55_part1").hide();
        $(".defects55_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_55_part2').click(function() {
        $("#btn_add_more_defect_failures_55_part2").hide();
        $(".defects55_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_55_part3').click(function() {
        $("#btn_add_more_defect_failures_55_part3").hide();
        $(".defects55_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_55_part4').click(function() {
        $("#btn_add_more_defect_failures_55_part4").hide();
        $(".defects55_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_55_part2').click(function() {
        $("#btn_add_more_defect_failures_55_part1").show();
        $(".defects55_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_55_part3').click(function() {
        $("#btn_add_more_defect_failures_55_part2").show();
        $(".defects55_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_55_part4').click(function() {
        $("#btn_add_more_defect_failures_55_part3").show();
        $(".defects55_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_55_part5').click(function() {
        $("#btn_add_more_defect_failures_55_part4").show();
        $(".defects55_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_56_part1').click(function() {
        $("#btn_add_more_defect_failures_56_part1").hide();
        $(".defects56_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_56_part2').click(function() {
        $("#btn_add_more_defect_failures_56_part2").hide();
        $(".defects56_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_56_part3').click(function() {
        $("#btn_add_more_defect_failures_56_part3").hide();
        $(".defects56_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_56_part4').click(function() {
        $("#btn_add_more_defect_failures_56_part4").hide();
        $(".defects56_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_56_part2').click(function() {
        $("#btn_add_more_defect_failures_56_part1").show();
        $(".defects56_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_56_part3').click(function() {
        $("#btn_add_more_defect_failures_56_part2").show();
        $(".defects56_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_56_part4').click(function() {
        $("#btn_add_more_defect_failures_56_part3").show();
        $(".defects56_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_56_part5').click(function() {
        $("#btn_add_more_defect_failures_56_part4").show();
        $(".defects56_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_57_part1').click(function() {
        $("#btn_add_more_defect_failures_57_part1").hide();
        $(".defects57_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_57_part2').click(function() {
        $("#btn_add_more_defect_failures_57_part2").hide();
        $(".defects57_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_57_part3').click(function() {
        $("#btn_add_more_defect_failures_57_part3").hide();
        $(".defects57_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_57_part4').click(function() {
        $("#btn_add_more_defect_failures_57_part4").hide();
        $(".defects57_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_57_part2').click(function() {
        $("#btn_add_more_defect_failures_57_part1").show();
        $(".defects57_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_57_part3').click(function() {
        $("#btn_add_more_defect_failures_57_part2").show();
        $(".defects57_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_57_part4').click(function() {
        $("#btn_add_more_defect_failures_57_part3").show();
        $(".defects57_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_57_part5').click(function() {
        $("#btn_add_more_defect_failures_57_part4").show();
        $(".defects57_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_58_part1').click(function() {
        $("#btn_add_more_defect_failures_58_part1").hide();
        $(".defects58_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_58_part2').click(function() {
        $("#btn_add_more_defect_failures_58_part2").hide();
        $(".defects58_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_58_part3').click(function() {
        $("#btn_add_more_defect_failures_58_part3").hide();
        $(".defects58_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_58_part4').click(function() {
        $("#btn_add_more_defect_failures_58_part4").hide();
        $(".defects58_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_58_part2').click(function() {
        $("#btn_add_more_defect_failures_58_part1").show();
        $(".defects58_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_58_part3').click(function() {
        $("#btn_add_more_defect_failures_58_part2").show();
        $(".defects58_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_58_part4').click(function() {
        $("#btn_add_more_defect_failures_58_part3").show();
        $(".defects58_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_58_part5').click(function() {
        $("#btn_add_more_defect_failures_58_part4").show();
        $(".defects58_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_59_part1').click(function() {
        $("#btn_add_more_defect_failures_59_part1").hide();
        $(".defects59_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_59_part2').click(function() {
        $("#btn_add_more_defect_failures_59_part2").hide();
        $(".defects59_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_59_part3').click(function() {
        $("#btn_add_more_defect_failures_59_part3").hide();
        $(".defects59_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_59_part4').click(function() {
        $("#btn_add_more_defect_failures_59_part4").hide();
        $(".defects59_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_59_part2').click(function() {
        $("#btn_add_more_defect_failures_59_part1").show();
        $(".defects59_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_59_part3').click(function() {
        $("#btn_add_more_defect_failures_59_part2").show();
        $(".defects59_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_59_part4').click(function() {
        $("#btn_add_more_defect_failures_59_part3").show();
        $(".defects59_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_59_part5').click(function() {
        $("#btn_add_more_defect_failures_59_part4").show();
        $(".defects59_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_60_part1').click(function() {
        $("#btn_add_more_defect_failures_60_part1").hide();
        $(".defects60_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_60_part2').click(function() {
        $("#btn_add_more_defect_failures_60_part2").hide();
        $(".defects60_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_60_part3').click(function() {
        $("#btn_add_more_defect_failures_60_part3").hide();
        $(".defects60_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_60_part4').click(function() {
        $("#btn_add_more_defect_failures_60_part4").hide();
        $(".defects60_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_60_part2').click(function() {
        $("#btn_add_more_defect_failures_60_part1").show();
        $(".defects60_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_60_part3').click(function() {
        $("#btn_add_more_defect_failures_60_part2").show();
        $(".defects60_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_60_part4').click(function() {
        $("#btn_add_more_defect_failures_60_part3").show();
        $(".defects60_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_60_part5').click(function() {
        $("#btn_add_more_defect_failures_60_part4").show();
        $(".defects60_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_61_part1').click(function() {
        $("#btn_add_more_defect_failures_61_part1").hide();
        $(".defects61_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_61_part2').click(function() {
        $("#btn_add_more_defect_failures_61_part2").hide();
        $(".defects61_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_61_part3').click(function() {
        $("#btn_add_more_defect_failures_61_part3").hide();
        $(".defects61_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_61_part4').click(function() {
        $("#btn_add_more_defect_failures_61_part4").hide();
        $(".defects61_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_61_part2').click(function() {
        $("#btn_add_more_defect_failures_61_part1").show();
        $(".defects61_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_61_part3').click(function() {
        $("#btn_add_more_defect_failures_61_part2").show();
        $(".defects61_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_61_part4').click(function() {
        $("#btn_add_more_defect_failures_61_part3").show();
        $(".defects61_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_61_part5').click(function() {
        $("#btn_add_more_defect_failures_61_part4").show();
        $(".defects61_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_62_part1').click(function() {
        $("#btn_add_more_defect_failures_62_part1").hide();
        $(".defects62_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_62_part2').click(function() {
        $("#btn_add_more_defect_failures_62_part2").hide();
        $(".defects62_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_62_part3').click(function() {
        $("#btn_add_more_defect_failures_62_part3").hide();
        $(".defects62_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_62_part4').click(function() {
        $("#btn_add_more_defect_failures_62_part4").hide();
        $(".defects62_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_62_part2').click(function() {
        $("#btn_add_more_defect_failures_62_part1").show();
        $(".defects62_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_62_part3').click(function() {
        $("#btn_add_more_defect_failures_62_part2").show();
        $(".defects62_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_62_part4').click(function() {
        $("#btn_add_more_defect_failures_62_part3").show();
        $(".defects62_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_62_part5').click(function() {
        $("#btn_add_more_defect_failures_62_part4").show();
        $(".defects62_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_63_part1').click(function() {
        $("#btn_add_more_defect_failures_63_part1").hide();
        $(".defects63_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_63_part2').click(function() {
        $("#btn_add_more_defect_failures_63_part2").hide();
        $(".defects63_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_63_part3').click(function() {
        $("#btn_add_more_defect_failures_63_part3").hide();
        $(".defects63_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_63_part4').click(function() {
        $("#btn_add_more_defect_failures_63_part4").hide();
        $(".defects63_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_63_part2').click(function() {
        $("#btn_add_more_defect_failures_63_part1").show();
        $(".defects63_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_63_part3').click(function() {
        $("#btn_add_more_defect_failures_63_part2").show();
        $(".defects63_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_63_part4').click(function() {
        $("#btn_add_more_defect_failures_63_part3").show();
        $(".defects63_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_63_part5').click(function() {
        $("#btn_add_more_defect_failures_63_part4").show();
        $(".defects63_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_64_part1').click(function() {
        $("#btn_add_more_defect_failures_64_part1").hide();
        $(".defects64_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_64_part2').click(function() {
        $("#btn_add_more_defect_failures_64_part2").hide();
        $(".defects64_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_64_part3').click(function() {
        $("#btn_add_more_defect_failures_64_part3").hide();
        $(".defects64_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_64_part4').click(function() {
        $("#btn_add_more_defect_failures_64_part4").hide();
        $(".defects64_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_64_part2').click(function() {
        $("#btn_add_more_defect_failures_64_part1").show();
        $(".defects64_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_64_part3').click(function() {
        $("#btn_add_more_defect_failures_64_part2").show();
        $(".defects64_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_64_part4').click(function() {
        $("#btn_add_more_defect_failures_64_part3").show();
        $(".defects64_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_64_part5').click(function() {
        $("#btn_add_more_defect_failures_64_part4").show();
        $(".defects64_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_65_part1').click(function() {
        $("#btn_add_more_defect_failures_65_part1").hide();
        $(".defects65_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_65_part2').click(function() {
        $("#btn_add_more_defect_failures_65_part2").hide();
        $(".defects65_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_65_part3').click(function() {
        $("#btn_add_more_defect_failures_65_part3").hide();
        $(".defects65_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_65_part4').click(function() {
        $("#btn_add_more_defect_failures_65_part4").hide();
        $(".defects65_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_65_part2').click(function() {
        $("#btn_add_more_defect_failures_65_part1").show();
        $(".defects65_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_65_part3').click(function() {
        $("#btn_add_more_defect_failures_65_part2").show();
        $(".defects65_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_65_part4').click(function() {
        $("#btn_add_more_defect_failures_65_part3").show();
        $(".defects65_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_65_part5').click(function() {
        $("#btn_add_more_defect_failures_65_part4").show();
        $(".defects65_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_66_part1').click(function() {
        $("#btn_add_more_defect_failures_66_part1").hide();
        $(".defects66_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_66_part2').click(function() {
        $("#btn_add_more_defect_failures_66_part2").hide();
        $(".defects66_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_66_part3').click(function() {
        $("#btn_add_more_defect_failures_66_part3").hide();
        $(".defects66_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_66_part4').click(function() {
        $("#btn_add_more_defect_failures_66_part4").hide();
        $(".defects66_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_66_part2').click(function() {
        $("#btn_add_more_defect_failures_66_part1").show();
        $(".defects66_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_66_part3').click(function() {
        $("#btn_add_more_defect_failures_66_part2").show();
        $(".defects66_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_66_part4').click(function() {
        $("#btn_add_more_defect_failures_66_part3").show();
        $(".defects66_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_66_part5').click(function() {
        $("#btn_add_more_defect_failures_66_part4").show();
        $(".defects66_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_67_part1').click(function() {
        $("#btn_add_more_defect_failures_67_part1").hide();
        $(".defects67_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_67_part2').click(function() {
        $("#btn_add_more_defect_failures_67_part2").hide();
        $(".defects67_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_67_part3').click(function() {
        $("#btn_add_more_defect_failures_67_part3").hide();
        $(".defects67_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_67_part4').click(function() {
        $("#btn_add_more_defect_failures_67_part4").hide();
        $(".defects67_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_67_part2').click(function() {
        $("#btn_add_more_defect_failures_67_part1").show();
        $(".defects67_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_67_part3').click(function() {
        $("#btn_add_more_defect_failures_67_part2").show();
        $(".defects67_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_67_part4').click(function() {
        $("#btn_add_more_defect_failures_67_part3").show();
        $(".defects67_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_67_part5').click(function() {
        $("#btn_add_more_defect_failures_67_part4").show();
        $(".defects67_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_68_part1').click(function() {
        $("#btn_add_more_defect_failures_68_part1").hide();
        $(".defects68_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_68_part2').click(function() {
        $("#btn_add_more_defect_failures_68_part2").hide();
        $(".defects68_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_68_part3').click(function() {
        $("#btn_add_more_defect_failures_68_part3").hide();
        $(".defects68_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_68_part4').click(function() {
        $("#btn_add_more_defect_failures_68_part4").hide();
        $(".defects68_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_68_part2').click(function() {
        $("#btn_add_more_defect_failures_68_part1").show();
        $(".defects68_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_68_part3').click(function() {
        $("#btn_add_more_defect_failures_68_part2").show();
        $(".defects68_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_68_part4').click(function() {
        $("#btn_add_more_defect_failures_68_part3").show();
        $(".defects68_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_68_part5').click(function() {
        $("#btn_add_more_defect_failures_68_part4").show();
        $(".defects68_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_69_part1').click(function() {
        $("#btn_add_more_defect_failures_69_part1").hide();
        $(".defects69_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_69_part2').click(function() {
        $("#btn_add_more_defect_failures_69_part2").hide();
        $(".defects69_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_69_part3').click(function() {
        $("#btn_add_more_defect_failures_69_part3").hide();
        $(".defects69_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_69_part4').click(function() {
        $("#btn_add_more_defect_failures_69_part4").hide();
        $(".defects69_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_69_part2').click(function() {
        $("#btn_add_more_defect_failures_69_part1").show();
        $(".defects69_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_69_part3').click(function() {
        $("#btn_add_more_defect_failures_69_part2").show();
        $(".defects69_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_69_part4').click(function() {
        $("#btn_add_more_defect_failures_69_part3").show();
        $(".defects69_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_69_part5').click(function() {
        $("#btn_add_more_defect_failures_69_part4").show();
        $(".defects69_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_70_part1').click(function() {
        $("#btn_add_more_defect_failures_70_part1").hide();
        $(".defects70_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_70_part2').click(function() {
        $("#btn_add_more_defect_failures_70_part2").hide();
        $(".defects70_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_70_part3').click(function() {
        $("#btn_add_more_defect_failures_70_part3").hide();
        $(".defects70_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_70_part4').click(function() {
        $("#btn_add_more_defect_failures_70_part4").hide();
        $(".defects70_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_70_part2').click(function() {
        $("#btn_add_more_defect_failures_70_part1").show();
        $(".defects70_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_70_part3').click(function() {
        $("#btn_add_more_defect_failures_70_part2").show();
        $(".defects70_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_70_part4').click(function() {
        $("#btn_add_more_defect_failures_70_part3").show();
        $(".defects70_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_70_part5').click(function() {
        $("#btn_add_more_defect_failures_70_part4").show();
        $(".defects70_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_71_part1').click(function() {
        $("#btn_add_more_defect_failures_71_part1").hide();
        $(".defects71_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_71_part2').click(function() {
        $("#btn_add_more_defect_failures_71_part2").hide();
        $(".defects71_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_71_part3').click(function() {
        $("#btn_add_more_defect_failures_71_part3").hide();
        $(".defects71_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_71_part4').click(function() {
        $("#btn_add_more_defect_failures_71_part4").hide();
        $(".defects71_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_71_part2').click(function() {
        $("#btn_add_more_defect_failures_71_part1").show();
        $(".defects71_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_71_part3').click(function() {
        $("#btn_add_more_defect_failures_71_part2").show();
        $(".defects71_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_71_part4').click(function() {
        $("#btn_add_more_defect_failures_71_part3").show();
        $(".defects71_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_71_part5').click(function() {
        $("#btn_add_more_defect_failures_71_part4").show();
        $(".defects71_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_72_part1').click(function() {
        $("#btn_add_more_defect_failures_72_part1").hide();
        $(".defects72_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_72_part2').click(function() {
        $("#btn_add_more_defect_failures_72_part2").hide();
        $(".defects72_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_72_part3').click(function() {
        $("#btn_add_more_defect_failures_72_part3").hide();
        $(".defects72_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_72_part4').click(function() {
        $("#btn_add_more_defect_failures_72_part4").hide();
        $(".defects72_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_72_part2').click(function() {
        $("#btn_add_more_defect_failures_72_part1").show();
        $(".defects72_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_72_part3').click(function() {
        $("#btn_add_more_defect_failures_72_part2").show();
        $(".defects72_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_72_part4').click(function() {
        $("#btn_add_more_defect_failures_72_part3").show();
        $(".defects72_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_72_part5').click(function() {
        $("#btn_add_more_defect_failures_72_part4").show();
        $(".defects72_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_73_part1').click(function() {
        $("#btn_add_more_defect_failures_73_part1").hide();
        $(".defects73_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_73_part2').click(function() {
        $("#btn_add_more_defect_failures_73_part2").hide();
        $(".defects73_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_73_part3').click(function() {
        $("#btn_add_more_defect_failures_73_part3").hide();
        $(".defects73_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_73_part4').click(function() {
        $("#btn_add_more_defect_failures_73_part4").hide();
        $(".defects73_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_73_part2').click(function() {
        $("#btn_add_more_defect_failures_73_part1").show();
        $(".defects73_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_73_part3').click(function() {
        $("#btn_add_more_defect_failures_73_part2").show();
        $(".defects73_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_73_part4').click(function() {
        $("#btn_add_more_defect_failures_73_part3").show();
        $(".defects73_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_73_part5').click(function() {
        $("#btn_add_more_defect_failures_73_part4").show();
        $(".defects73_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_74_part1').click(function() {
        $("#btn_add_more_defect_failures_74_part1").hide();
        $(".defects74_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_74_part2').click(function() {
        $("#btn_add_more_defect_failures_74_part2").hide();
        $(".defects74_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_74_part3').click(function() {
        $("#btn_add_more_defect_failures_74_part3").hide();
        $(".defects74_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_74_part4').click(function() {
        $("#btn_add_more_defect_failures_74_part4").hide();
        $(".defects74_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_74_part2').click(function() {
        $("#btn_add_more_defect_failures_74_part1").show();
        $(".defects74_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_74_part3').click(function() {
        $("#btn_add_more_defect_failures_74_part2").show();
        $(".defects74_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_74_part4').click(function() {
        $("#btn_add_more_defect_failures_74_part3").show();
        $(".defects74_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_74_part5').click(function() {
        $("#btn_add_more_defect_failures_74_part4").show();
        $(".defects74_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_75_part1').click(function() {
        $("#btn_add_more_defect_failures_75_part1").hide();
        $(".defects75_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_75_part2').click(function() {
        $("#btn_add_more_defect_failures_75_part2").hide();
        $(".defects75_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_75_part3').click(function() {
        $("#btn_add_more_defect_failures_75_part3").hide();
        $(".defects75_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_75_part4').click(function() {
        $("#btn_add_more_defect_failures_75_part4").hide();
        $(".defects75_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_75_part2').click(function() {
        $("#btn_add_more_defect_failures_75_part1").show();
        $(".defects75_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_75_part3').click(function() {
        $("#btn_add_more_defect_failures_75_part2").show();
        $(".defects75_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_75_part4').click(function() {
        $("#btn_add_more_defect_failures_75_part3").show();
        $(".defects75_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_75_part5').click(function() {
        $("#btn_add_more_defect_failures_75_part4").show();
        $(".defects75_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_76_part1').click(function() {
        $("#btn_add_more_defect_failures_76_part1").hide();
        $(".defects76_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_76_part2').click(function() {
        $("#btn_add_more_defect_failures_76_part2").hide();
        $(".defects76_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_76_part3').click(function() {
        $("#btn_add_more_defect_failures_76_part3").hide();
        $(".defects76_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_76_part4').click(function() {
        $("#btn_add_more_defect_failures_76_part4").hide();
        $(".defects76_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_76_part2').click(function() {
        $("#btn_add_more_defect_failures_76_part1").show();
        $(".defects76_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_76_part3').click(function() {
        $("#btn_add_more_defect_failures_76_part2").show();
        $(".defects76_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_76_part4').click(function() {
        $("#btn_add_more_defect_failures_76_part3").show();
        $(".defects76_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_76_part5').click(function() {
        $("#btn_add_more_defect_failures_76_part4").show();
        $(".defects76_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_77_part1').click(function() {
        $("#btn_add_more_defect_failures_77_part1").hide();
        $(".defects77_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_77_part2').click(function() {
        $("#btn_add_more_defect_failures_77_part2").hide();
        $(".defects77_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_77_part3').click(function() {
        $("#btn_add_more_defect_failures_77_part3").hide();
        $(".defects77_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_77_part4').click(function() {
        $("#btn_add_more_defect_failures_77_part4").hide();
        $(".defects77_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_77_part2').click(function() {
        $("#btn_add_more_defect_failures_77_part1").show();
        $(".defects77_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_77_part3').click(function() {
        $("#btn_add_more_defect_failures_77_part2").show();
        $(".defects77_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_77_part4').click(function() {
        $("#btn_add_more_defect_failures_77_part3").show();
        $(".defects77_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_77_part5').click(function() {
        $("#btn_add_more_defect_failures_77_part4").show();
        $(".defects77_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_78_part1').click(function() {
        $("#btn_add_more_defect_failures_78_part1").hide();
        $(".defects78_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_78_part2').click(function() {
        $("#btn_add_more_defect_failures_78_part2").hide();
        $(".defects78_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_78_part3').click(function() {
        $("#btn_add_more_defect_failures_78_part3").hide();
        $(".defects78_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_78_part4').click(function() {
        $("#btn_add_more_defect_failures_78_part4").hide();
        $(".defects78_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_78_part2').click(function() {
        $("#btn_add_more_defect_failures_78_part1").show();
        $(".defects78_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_78_part3').click(function() {
        $("#btn_add_more_defect_failures_78_part2").show();
        $(".defects78_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_78_part4').click(function() {
        $("#btn_add_more_defect_failures_78_part3").show();
        $(".defects78_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_78_part5').click(function() {
        $("#btn_add_more_defect_failures_78_part4").show();
        $(".defects78_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_79_part1').click(function() {
        $("#btn_add_more_defect_failures_79_part1").hide();
        $(".defects79_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_79_part2').click(function() {
        $("#btn_add_more_defect_failures_79_part2").hide();
        $(".defects79_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_79_part3').click(function() {
        $("#btn_add_more_defect_failures_79_part3").hide();
        $(".defects79_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_79_part4').click(function() {
        $("#btn_add_more_defect_failures_79_part4").hide();
        $(".defects79_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_79_part2').click(function() {
        $("#btn_add_more_defect_failures_79_part1").show();
        $(".defects79_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_79_part3').click(function() {
        $("#btn_add_more_defect_failures_79_part2").show();
        $(".defects79_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_79_part4').click(function() {
        $("#btn_add_more_defect_failures_79_part3").show();
        $(".defects79_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_79_part5').click(function() {
        $("#btn_add_more_defect_failures_79_part4").show();
        $(".defects79_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_80_part1').click(function() {
        $("#btn_add_more_defect_failures_80_part1").hide();
        $(".defects80_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_80_part2').click(function() {
        $("#btn_add_more_defect_failures_80_part2").hide();
        $(".defects80_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_80_part3').click(function() {
        $("#btn_add_more_defect_failures_80_part3").hide();
        $(".defects80_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_80_part4').click(function() {
        $("#btn_add_more_defect_failures_80_part4").hide();
        $(".defects80_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_80_part2').click(function() {
        $("#btn_add_more_defect_failures_80_part1").show();
        $(".defects80_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_80_part3').click(function() {
        $("#btn_add_more_defect_failures_80_part2").show();
        $(".defects80_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_80_part4').click(function() {
        $("#btn_add_more_defect_failures_80_part3").show();
        $(".defects80_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_80_part5').click(function() {
        $("#btn_add_more_defect_failures_80_part4").show();
        $(".defects80_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_81_part1').click(function() {
        $("#btn_add_more_defect_failures_81_part1").hide();
        $(".defects81_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_81_part2').click(function() {
        $("#btn_add_more_defect_failures_81_part2").hide();
        $(".defects81_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_81_part3').click(function() {
        $("#btn_add_more_defect_failures_81_part3").hide();
        $(".defects81_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_81_part4').click(function() {
        $("#btn_add_more_defect_failures_81_part4").hide();
        $(".defects81_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_81_part2').click(function() {
        $("#btn_add_more_defect_failures_81_part1").show();
        $(".defects81_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_81_part3').click(function() {
        $("#btn_add_more_defect_failures_81_part2").show();
        $(".defects81_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_81_part4').click(function() {
        $("#btn_add_more_defect_failures_81_part3").show();
        $(".defects81_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_81_part5').click(function() {
        $("#btn_add_more_defect_failures_81_part4").show();
        $(".defects81_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_82_part1').click(function() {
        $("#btn_add_more_defect_failures_82_part1").hide();
        $(".defects82_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_82_part2').click(function() {
        $("#btn_add_more_defect_failures_82_part2").hide();
        $(".defects82_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_82_part3').click(function() {
        $("#btn_add_more_defect_failures_82_part3").hide();
        $(".defects82_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_82_part4').click(function() {
        $("#btn_add_more_defect_failures_82_part4").hide();
        $(".defects82_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_82_part2').click(function() {
        $("#btn_add_more_defect_failures_82_part1").show();
        $(".defects82_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_82_part3').click(function() {
        $("#btn_add_more_defect_failures_82_part2").show();
        $(".defects82_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_82_part4').click(function() {
        $("#btn_add_more_defect_failures_82_part3").show();
        $(".defects82_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_82_part5').click(function() {
        $("#btn_add_more_defect_failures_82_part4").show();
        $(".defects82_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_83_part1').click(function() {
        $("#btn_add_more_defect_failures_83_part1").hide();
        $(".defects83_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_83_part2').click(function() {
        $("#btn_add_more_defect_failures_83_part2").hide();
        $(".defects83_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_83_part3').click(function() {
        $("#btn_add_more_defect_failures_83_part3").hide();
        $(".defects83_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_83_part4').click(function() {
        $("#btn_add_more_defect_failures_83_part4").hide();
        $(".defects83_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_83_part2').click(function() {
        $("#btn_add_more_defect_failures_83_part1").show();
        $(".defects83_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_83_part3').click(function() {
        $("#btn_add_more_defect_failures_83_part2").show();
        $(".defects83_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_83_part4').click(function() {
        $("#btn_add_more_defect_failures_83_part3").show();
        $(".defects83_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_83_part5').click(function() {
        $("#btn_add_more_defect_failures_83_part4").show();
        $(".defects83_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_84_part1').click(function() {
        $("#btn_add_more_defect_failures_84_part1").hide();
        $(".defects84_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_84_part2').click(function() {
        $("#btn_add_more_defect_failures_84_part2").hide();
        $(".defects84_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_84_part3').click(function() {
        $("#btn_add_more_defect_failures_84_part3").hide();
        $(".defects84_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_84_part4').click(function() {
        $("#btn_add_more_defect_failures_84_part4").hide();
        $(".defects84_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_84_part2').click(function() {
        $("#btn_add_more_defect_failures_84_part1").show();
        $(".defects84_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_84_part3').click(function() {
        $("#btn_add_more_defect_failures_84_part2").show();
        $(".defects84_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_84_part4').click(function() {
        $("#btn_add_more_defect_failures_84_part3").show();
        $(".defects84_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_84_part5').click(function() {
        $("#btn_add_more_defect_failures_84_part4").show();
        $(".defects84_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_85_part1').click(function() {
        $("#btn_add_more_defect_failures_85_part1").hide();
        $(".defects85_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_85_part2').click(function() {
        $("#btn_add_more_defect_failures_85_part2").hide();
        $(".defects85_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_85_part3').click(function() {
        $("#btn_add_more_defect_failures_85_part3").hide();
        $(".defects85_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_85_part4').click(function() {
        $("#btn_add_more_defect_failures_85_part4").hide();
        $(".defects85_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_85_part2').click(function() {
        $("#btn_add_more_defect_failures_85_part1").show();
        $(".defects85_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_85_part3').click(function() {
        $("#btn_add_more_defect_failures_85_part2").show();
        $(".defects85_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_85_part4').click(function() {
        $("#btn_add_more_defect_failures_85_part3").show();
        $(".defects85_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_85_part5').click(function() {
        $("#btn_add_more_defect_failures_85_part4").show();
        $(".defects85_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_86_part1').click(function() {
        $("#btn_add_more_defect_failures_86_part1").hide();
        $(".defects86_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_86_part2').click(function() {
        $("#btn_add_more_defect_failures_86_part2").hide();
        $(".defects86_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_86_part3').click(function() {
        $("#btn_add_more_defect_failures_86_part3").hide();
        $(".defects86_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_86_part4').click(function() {
        $("#btn_add_more_defect_failures_86_part4").hide();
        $(".defects86_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_86_part2').click(function() {
        $("#btn_add_more_defect_failures_86_part1").show();
        $(".defects86_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_86_part3').click(function() {
        $("#btn_add_more_defect_failures_86_part2").show();
        $(".defects86_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_86_part4').click(function() {
        $("#btn_add_more_defect_failures_86_part3").show();
        $(".defects86_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_86_part5').click(function() {
        $("#btn_add_more_defect_failures_86_part4").show();
        $(".defects86_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_87_part1').click(function() {
        $("#btn_add_more_defect_failures_87_part1").hide();
        $(".defects87_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_87_part2').click(function() {
        $("#btn_add_more_defect_failures_87_part2").hide();
        $(".defects87_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_87_part3').click(function() {
        $("#btn_add_more_defect_failures_87_part3").hide();
        $(".defects87_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_87_part4').click(function() {
        $("#btn_add_more_defect_failures_87_part4").hide();
        $(".defects87_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_87_part2').click(function() {
        $("#btn_add_more_defect_failures_87_part1").show();
        $(".defects87_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_87_part3').click(function() {
        $("#btn_add_more_defect_failures_87_part2").show();
        $(".defects87_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_87_part4').click(function() {
        $("#btn_add_more_defect_failures_87_part3").show();
        $(".defects87_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_87_part5').click(function() {
        $("#btn_add_more_defect_failures_87_part4").show();
        $(".defects87_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_88_part1').click(function() {
        $("#btn_add_more_defect_failures_88_part1").hide();
        $(".defects88_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_88_part2').click(function() {
        $("#btn_add_more_defect_failures_88_part2").hide();
        $(".defects88_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_88_part3').click(function() {
        $("#btn_add_more_defect_failures_88_part3").hide();
        $(".defects88_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_88_part4').click(function() {
        $("#btn_add_more_defect_failures_88_part4").hide();
        $(".defects88_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_88_part2').click(function() {
        $("#btn_add_more_defect_failures_88_part1").show();
        $(".defects88_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_88_part3').click(function() {
        $("#btn_add_more_defect_failures_88_part2").show();
        $(".defects88_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_88_part4').click(function() {
        $("#btn_add_more_defect_failures_88_part3").show();
        $(".defects88_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_88_part5').click(function() {
        $("#btn_add_more_defect_failures_88_part4").show();
        $(".defects88_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_89_part1').click(function() {
        $("#btn_add_more_defect_failures_89_part1").hide();
        $(".defects89_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_89_part2').click(function() {
        $("#btn_add_more_defect_failures_89_part2").hide();
        $(".defects89_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_89_part3').click(function() {
        $("#btn_add_more_defect_failures_89_part3").hide();
        $(".defects89_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_89_part4').click(function() {
        $("#btn_add_more_defect_failures_89_part4").hide();
        $(".defects89_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_89_part2').click(function() {
        $("#btn_add_more_defect_failures_89_part1").show();
        $(".defects89_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_89_part3').click(function() {
        $("#btn_add_more_defect_failures_89_part2").show();
        $(".defects89_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_89_part4').click(function() {
        $("#btn_add_more_defect_failures_89_part3").show();
        $(".defects89_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_89_part5').click(function() {
        $("#btn_add_more_defect_failures_89_part4").show();
        $(".defects89_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_90_part1').click(function() {
        $("#btn_add_more_defect_failures_90_part1").hide();
        $(".defects90_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_90_part2').click(function() {
        $("#btn_add_more_defect_failures_90_part2").hide();
        $(".defects90_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_90_part3').click(function() {
        $("#btn_add_more_defect_failures_90_part3").hide();
        $(".defects90_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_90_part4').click(function() {
        $("#btn_add_more_defect_failures_90_part4").hide();
        $(".defects90_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_90_part2').click(function() {
        $("#btn_add_more_defect_failures_90_part1").show();
        $(".defects90_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_90_part3').click(function() {
        $("#btn_add_more_defect_failures_90_part2").show();
        $(".defects90_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_90_part4').click(function() {
        $("#btn_add_more_defect_failures_90_part3").show();
        $(".defects90_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_90_part5').click(function() {
        $("#btn_add_more_defect_failures_90_part4").show();
        $(".defects90_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_91_part1').click(function() {
        $("#btn_add_more_defect_failures_91_part1").hide();
        $(".defects91_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_91_part2').click(function() {
        $("#btn_add_more_defect_failures_91_part2").hide();
        $(".defects91_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_91_part3').click(function() {
        $("#btn_add_more_defect_failures_91_part3").hide();
        $(".defects91_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_91_part4').click(function() {
        $("#btn_add_more_defect_failures_91_part4").hide();
        $(".defects91_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_91_part2').click(function() {
        $("#btn_add_more_defect_failures_91_part1").show();
        $(".defects91_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_91_part3').click(function() {
        $("#btn_add_more_defect_failures_91_part2").show();
        $(".defects91_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_91_part4').click(function() {
        $("#btn_add_more_defect_failures_91_part3").show();
        $(".defects91_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_91_part5').click(function() {
        $("#btn_add_more_defect_failures_91_part4").show();
        $(".defects91_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_92_part1').click(function() {
        $("#btn_add_more_defect_failures_92_part1").hide();
        $(".defects92_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_92_part2').click(function() {
        $("#btn_add_more_defect_failures_92_part2").hide();
        $(".defects92_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_92_part3').click(function() {
        $("#btn_add_more_defect_failures_92_part3").hide();
        $(".defects92_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_92_part4').click(function() {
        $("#btn_add_more_defect_failures_92_part4").hide();
        $(".defects92_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_92_part2').click(function() {
        $("#btn_add_more_defect_failures_92_part1").show();
        $(".defects92_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_92_part3').click(function() {
        $("#btn_add_more_defect_failures_92_part2").show();
        $(".defects92_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_92_part4').click(function() {
        $("#btn_add_more_defect_failures_92_part3").show();
        $(".defects92_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_92_part5').click(function() {
        $("#btn_add_more_defect_failures_92_part4").show();
        $(".defects92_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_93_part1').click(function() {
        $("#btn_add_more_defect_failures_93_part1").hide();
        $(".defects93_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_93_part2').click(function() {
        $("#btn_add_more_defect_failures_93_part2").hide();
        $(".defects93_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_93_part3').click(function() {
        $("#btn_add_more_defect_failures_93_part3").hide();
        $(".defects93_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_93_part4').click(function() {
        $("#btn_add_more_defect_failures_93_part4").hide();
        $(".defects93_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_93_part2').click(function() {
        $("#btn_add_more_defect_failures_93_part1").show();
        $(".defects93_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_93_part3').click(function() {
        $("#btn_add_more_defect_failures_93_part2").show();
        $(".defects93_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_93_part4').click(function() {
        $("#btn_add_more_defect_failures_93_part3").show();
        $(".defects93_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_93_part5').click(function() {
        $("#btn_add_more_defect_failures_93_part4").show();
        $(".defects93_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_94_part1').click(function() {
        $("#btn_add_more_defect_failures_94_part1").hide();
        $(".defects94_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_94_part2').click(function() {
        $("#btn_add_more_defect_failures_94_part2").hide();
        $(".defects94_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_94_part3').click(function() {
        $("#btn_add_more_defect_failures_94_part3").hide();
        $(".defects94_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_94_part4').click(function() {
        $("#btn_add_more_defect_failures_94_part4").hide();
        $(".defects94_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_94_part2').click(function() {
        $("#btn_add_more_defect_failures_94_part1").show();
        $(".defects94_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_94_part3').click(function() {
        $("#btn_add_more_defect_failures_94_part2").show();
        $(".defects94_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_94_part4').click(function() {
        $("#btn_add_more_defect_failures_94_part3").show();
        $(".defects94_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_94_part5').click(function() {
        $("#btn_add_more_defect_failures_94_part4").show();
        $(".defects94_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_95_part1').click(function() {
        $("#btn_add_more_defect_failures_95_part1").hide();
        $(".defects95_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_95_part2').click(function() {
        $("#btn_add_more_defect_failures_95_part2").hide();
        $(".defects95_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_95_part3').click(function() {
        $("#btn_add_more_defect_failures_95_part3").hide();
        $(".defects95_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_95_part4').click(function() {
        $("#btn_add_more_defect_failures_95_part4").hide();
        $(".defects95_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_95_part2').click(function() {
        $("#btn_add_more_defect_failures_95_part1").show();
        $(".defects95_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_95_part3').click(function() {
        $("#btn_add_more_defect_failures_95_part2").show();
        $(".defects95_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_95_part4').click(function() {
        $("#btn_add_more_defect_failures_95_part3").show();
        $(".defects95_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_95_part5').click(function() {
        $("#btn_add_more_defect_failures_95_part4").show();
        $(".defects95_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_96_part1').click(function() {
        $("#btn_add_more_defect_failures_96_part1").hide();
        $(".defects96_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_96_part2').click(function() {
        $("#btn_add_more_defect_failures_96_part2").hide();
        $(".defects96_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_96_part3').click(function() {
        $("#btn_add_more_defect_failures_96_part3").hide();
        $(".defects96_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_96_part4').click(function() {
        $("#btn_add_more_defect_failures_96_part4").hide();
        $(".defects96_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_96_part2').click(function() {
        $("#btn_add_more_defect_failures_96_part1").show();
        $(".defects96_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_96_part3').click(function() {
        $("#btn_add_more_defect_failures_96_part2").show();
        $(".defects96_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_96_part4').click(function() {
        $("#btn_add_more_defect_failures_96_part3").show();
        $(".defects96_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_96_part5').click(function() {
        $("#btn_add_more_defect_failures_96_part4").show();
        $(".defects96_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_97_part1').click(function() {
        $("#btn_add_more_defect_failures_97_part1").hide();
        $(".defects97_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_97_part2').click(function() {
        $("#btn_add_more_defect_failures_97_part2").hide();
        $(".defects97_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_97_part3').click(function() {
        $("#btn_add_more_defect_failures_97_part3").hide();
        $(".defects97_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_97_part4').click(function() {
        $("#btn_add_more_defect_failures_97_part4").hide();
        $(".defects97_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_97_part2').click(function() {
        $("#btn_add_more_defect_failures_97_part1").show();
        $(".defects97_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_97_part3').click(function() {
        $("#btn_add_more_defect_failures_97_part2").show();
        $(".defects97_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_97_part4').click(function() {
        $("#btn_add_more_defect_failures_97_part3").show();
        $(".defects97_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_97_part5').click(function() {
        $("#btn_add_more_defect_failures_97_part4").show();
        $(".defects97_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_98_part1').click(function() {
        $("#btn_add_more_defect_failures_98_part1").hide();
        $(".defects98_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_98_part2').click(function() {
        $("#btn_add_more_defect_failures_98_part2").hide();
        $(".defects98_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_98_part3').click(function() {
        $("#btn_add_more_defect_failures_98_part3").hide();
        $(".defects98_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_98_part4').click(function() {
        $("#btn_add_more_defect_failures_98_part4").hide();
        $(".defects98_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_98_part2').click(function() {
        $("#btn_add_more_defect_failures_98_part1").show();
        $(".defects98_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_98_part3').click(function() {
        $("#btn_add_more_defect_failures_98_part2").show();
        $(".defects98_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_98_part4').click(function() {
        $("#btn_add_more_defect_failures_98_part3").show();
        $(".defects98_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_98_part5').click(function() {
        $("#btn_add_more_defect_failures_98_part4").show();
        $(".defects98_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_99_part1').click(function() {
        $("#btn_add_more_defect_failures_99_part1").hide();
        $(".defects99_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_99_part2').click(function() {
        $("#btn_add_more_defect_failures_99_part2").hide();
        $(".defects99_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_99_part3').click(function() {
        $("#btn_add_more_defect_failures_99_part3").hide();
        $(".defects99_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_99_part4').click(function() {
        $("#btn_add_more_defect_failures_99_part4").hide();
        $(".defects99_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_99_part2').click(function() {
        $("#btn_add_more_defect_failures_99_part1").show();
        $(".defects99_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_99_part3').click(function() {
        $("#btn_add_more_defect_failures_99_part2").show();
        $(".defects99_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_99_part4').click(function() {
        $("#btn_add_more_defect_failures_99_part3").show();
        $(".defects99_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_99_part5').click(function() {
        $("#btn_add_more_defect_failures_99_part4").show();
        $(".defects99_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_100_part1').click(function() {
        $("#btn_add_more_defect_failures_100_part1").hide();
        $(".defects100_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_100_part2').click(function() {
        $("#btn_add_more_defect_failures_100_part2").hide();
        $(".defects100_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_100_part3').click(function() {
        $("#btn_add_more_defect_failures_100_part3").hide();
        $(".defects100_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_100_part4').click(function() {
        $("#btn_add_more_defect_failures_100_part4").hide();
        $(".defects100_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_100_part2').click(function() {
        $("#btn_add_more_defect_failures_100_part1").show();
        $(".defects100_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_100_part3').click(function() {
        $("#btn_add_more_defect_failures_100_part2").show();
        $(".defects100_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_100_part4').click(function() {
        $("#btn_add_more_defect_failures_100_part3").show();
        $(".defects100_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_100_part5').click(function() {
        $("#btn_add_more_defect_failures_100_part4").show();
        $(".defects100_part5").attr("style", "display: none");
    });



    $('#btn_add_more_defect_failures_2_part1').click(function() {
        $("#btn_add_more_defect_failures_2_part1").hide();
        $(".defects2_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_2_part2').click(function() {
        $("#btn_add_more_defect_failures_2_part2").hide();
        $(".defects2_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_2_part3').click(function() {
        $("#btn_add_more_defect_failures_2_part3").hide();
        $(".defects2_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_2_part4').click(function() {
        $("#btn_add_more_defect_failures_2_part4").hide();
        $(".defects2_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_2_part2').click(function() {
        $("#btn_add_more_defect_failures_2_part1").show();
        $(".defects2_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_2_part3').click(function() {
        $("#btn_add_more_defect_failures_2_part2").show();
        $(".defects2_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_2_part4').click(function() {
        $("#btn_add_more_defect_failures_2_part3").show();
        $(".defects2_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_2_part5').click(function() {
        $("#btn_add_more_defect_failures_2_part4").show();
        $(".defects2_part5").attr("style", "display: none");
    });

    //#3
    $('#btn_add_more_defect_failures_3_part1').click(function() {
        $("#btn_add_more_defect_failures_3_part1").hide();
        $(".defects3_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_3_part2').click(function() {
        $("#btn_add_more_defect_failures_3_part2").hide();
        $(".defects3_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_3_part3').click(function() {
        $("#btn_add_more_defect_failures_3_part3").hide();
        $(".defects3_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_3_part4').click(function() {
        $("#btn_add_more_defect_failures_3_part4").hide();
        $(".defects3_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_3_part2').click(function() {
        $("#btn_add_more_defect_failures_3_part1").show();
        $(".defects3_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_3_part3').click(function() {
        $("#btn_add_more_defect_failures_3_part2").show();
        $(".defects3_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_3_part4').click(function() {
        $("#btn_add_more_defect_failures_3_part3").show();
        $(".defects3_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_3_part5').click(function() {
        $("#btn_add_more_defect_failures_3_part4").show();
        $(".defects3_part5").attr("style", "display: none");
    });

    //#4
    $('#btn_add_more_defect_failures_4_part1').click(function() {
        $("#btn_add_more_defect_failures_4_part1").hide();
        $(".defects4_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_4_part2').click(function() {
        $("#btn_add_more_defect_failures_4_part2").hide();
        $(".defects4_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_4_part3').click(function() {
        $("#btn_add_more_defect_failures_4_part3").hide();
        $(".defects4_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_4_part4').click(function() {
        $("#btn_add_more_defect_failures_4_part4").hide();
        $(".defects4_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_4_part2').click(function() {
        $("#btn_add_more_defect_failures_4_part1").show();
        $(".defects4_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_4_part3').click(function() {
        $("#btn_add_more_defect_failures_4_part2").show();
        $(".defects4_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_4_part4').click(function() {
        $("#btn_add_more_defect_failures_4_part3").show();
        $(".defects4_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_4_part5').click(function() {
        $("#btn_add_more_defect_failures_4_part4").show();
        $(".defects4_part5").attr("style", "display: none");
    });

    //#5
    $('#btn_add_more_defect_failures_5_part1').click(function() {
        $("#btn_add_more_defect_failures_5_part1").hide();
        $(".defects5_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_5_part2').click(function() {
        $("#btn_add_more_defect_failures_5_part2").hide();
        $(".defects5_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_5_part3').click(function() {
        $("#btn_add_more_defect_failures_5_part3").hide();
        $(".defects5_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_5_part4').click(function() {
        $("#btn_add_more_defect_failures_5_part4").hide();
        $(".defects5_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_5_part2').click(function() {
        $("#btn_add_more_defect_failures_5_part1").show();
        $(".defects5_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_5_part3').click(function() {
        $("#btn_add_more_defect_failures_5_part2").show();
        $(".defects5_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_5_part4').click(function() {
        $("#btn_add_more_defect_failures_5_part3").show();
        $(".defects5_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_5_part5').click(function() {
        $("#btn_add_more_defect_failures_5_part4").show();
        $(".defects5_part5").attr("style", "display: none");
    });

    //#6
    $('#btn_add_more_defect_failures_6_part1').click(function() {
        $("#btn_add_more_defect_failures_6_part1").hide();
        $(".defects6_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_6_part2').click(function() {
        $("#btn_add_more_defect_failures_6_part2").hide();
        $(".defects6_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_6_part3').click(function() {
        $("#btn_add_more_defect_failures_6_part3").hide();
        $(".defects6_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_6_part4').click(function() {
        $("#btn_add_more_defect_failures_6_part4").hide();
        $(".defects6_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_6_part2').click(function() {
        $("#btn_add_more_defect_failures_6_part1").show();
        $(".defects6_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_6_part3').click(function() {
        $("#btn_add_more_defect_failures_6_part2").show();
        $(".defects6_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_6_part4').click(function() {
        $("#btn_add_more_defect_failures_6_part3").show();
        $(".defects6_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_6_part5').click(function() {
        $("#btn_add_more_defect_failures_6_part4").show();
        $(".defects6_part5").attr("style", "display: none");
    });

    //#7
    $('#btn_add_more_defect_failures_7_part1').click(function() {
        $("#btn_add_more_defect_failures_7_part1").hide();
        $(".defects7_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_7_part2').click(function() {
        $("#btn_add_more_defect_failures_7_part2").hide();
        $(".defects7_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_7_part3').click(function() {
        $("#btn_add_more_defect_failures_7_part3").hide();
        $(".defects7_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_7_part4').click(function() {
        $("#btn_add_more_defect_failures_7_part4").hide();
        $(".defects7_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_7_part2').click(function() {
        $("#btn_add_more_defect_failures_7_part1").show();
        $(".defects7_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_7_part3').click(function() {
        $("#btn_add_more_defect_failures_7_part2").show();
        $(".defects7_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_7_part4').click(function() {
        $("#btn_add_more_defect_failures_7_part3").show();
        $(".defects7_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_7_part5').click(function() {
        $("#btn_add_more_defect_failures_7_part4").show();
        $(".defects7_part5").attr("style", "display: none");
    });

    //#8
    $('#btn_add_more_defect_failures_8_part1').click(function() {
        $("#btn_add_more_defect_failures_8_part1").hide();
        $(".defects8_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_8_part2').click(function() {
        $("#btn_add_more_defect_failures_8_part2").hide();
        $(".defects8_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_8_part3').click(function() {
        $("#btn_add_more_defect_failures_8_part3").hide();
        $(".defects8_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_8_part4').click(function() {
        $("#btn_add_more_defect_failures_8_part4").hide();
        $(".defects8_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_8_part2').click(function() {
        $("#btn_add_more_defect_failures_8_part1").show();
        $(".defects8_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_8_part3').click(function() {
        $("#btn_add_more_defect_failures_8_part2").show();
        $(".defects8_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_8_part4').click(function() {
        $("#btn_add_more_defect_failures_8_part3").show();
        $(".defects8_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_8_part5').click(function() {
        $("#btn_add_more_defect_failures_8_part4").show();
        $(".defects8_part5").attr("style", "display: none");
    });

    //#9
    $('#btn_add_more_defect_failures_9_part1').click(function() {
        $("#btn_add_more_defect_failures_9_part1").hide();
        $(".defects9_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_9_part2').click(function() {
        $("#btn_add_more_defect_failures_9_part2").hide();
        $(".defects9_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_9_part3').click(function() {
        $("#btn_add_more_defect_failures_9_part3").hide();
        $(".defects9_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_9_part4').click(function() {
        $("#btn_add_more_defect_failures_9_part4").hide();
        $(".defects9_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_9_part2').click(function() {
        $("#btn_add_more_defect_failures_9_part1").show();
        $(".defects9_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_9_part3').click(function() {
        $("#btn_add_more_defect_failures_9_part2").show();
        $(".defects9_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_9_part4').click(function() {
        $("#btn_add_more_defect_failures_9_part3").show();
        $(".defects9_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_9_part5').click(function() {
        $("#btn_add_more_defect_failures_9_part4").show();
        $(".defects9_part5").attr("style", "display: none");
    });

    //#10
    $('#btn_add_more_defect_failures_10_part1').click(function() {
        $("#btn_add_more_defect_failures_10_part1").hide();
        $(".defects10_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_10_part2').click(function() {
        $("#btn_add_more_defect_failures_10_part2").hide();
        $(".defects10_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_10_part3').click(function() {
        $("#btn_add_more_defect_failures_10_part3").hide();
        $(".defects10_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_10_part4').click(function() {
        $("#btn_add_more_defect_failures_10_part4").hide();
        $(".defects10_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_10_part2').click(function() {
        $("#btn_add_more_defect_failures_10_part1").show();
        $(".defects10_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_10_part3').click(function() {
        $("#btn_add_more_defect_failures_10_part2").show();
        $(".defects10_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_10_part4').click(function() {
        $("#btn_add_more_defect_failures_10_part3").show();
        $(".defects10_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_10_part5').click(function() {
        $("#btn_add_more_defect_failures_10_part4").show();
        $(".defects10_part5").attr("style", "display: none");
    });

    //#11
    $('#btn_add_more_defect_failures_11_part1').click(function() {
        $("#btn_add_more_defect_failures_11_part1").hide();
        $(".defects11_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_11_part2').click(function() {
        $("#btn_add_more_defect_failures_11_part2").hide();
        $(".defects11_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_11_part3').click(function() {
        $("#btn_add_more_defect_failures_11_part3").hide();
        $(".defects11_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_11_part4').click(function() {
        $("#btn_add_more_defect_failures_11_part4").hide();
        $(".defects11_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_11_part2').click(function() {
        $("#btn_add_more_defect_failures_11_part1").show();
        $(".defects11_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_11_part3').click(function() {
        $("#btn_add_more_defect_failures_11_part2").show();
        $(".defects11_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_11_part4').click(function() {
        $("#btn_add_more_defect_failures_11_part3").show();
        $(".defects11_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_11_part5').click(function() {
        $("#btn_add_more_defect_failures_11_part4").show();
        $(".defects11_part5").attr("style", "display: none");
    });

    //#12
    $('#btn_add_more_defect_failures_12_part1').click(function() {
        $("#btn_add_more_defect_failures_12_part1").hide();
        $(".defects12_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_12_part2').click(function() {
        $("#btn_add_more_defect_failures_12_part2").hide();
        $(".defects12_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_12_part3').click(function() {
        $("#btn_add_more_defect_failures_12_part3").hide();
        $(".defects12_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_12_part4').click(function() {
        $("#btn_add_more_defect_failures_12_part4").hide();
        $(".defects12_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_12_part2').click(function() {
        $("#btn_add_more_defect_failures_12_part1").show();
        $(".defects12_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_12_part3').click(function() {
        $("#btn_add_more_defect_failures_12_part2").show();
        $(".defects12_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_12_part4').click(function() {
        $("#btn_add_more_defect_failures_12_part3").show();
        $(".defects12_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_12_part5').click(function() {
        $("#btn_add_more_defect_failures_12_part4").show();
        $(".defects12_part5").attr("style", "display: none");
    });

    //#13
    $('#btn_add_more_defect_failures_13_part1').click(function() {
        $("#btn_add_more_defect_failures_13_part1").hide();
        $(".defects13_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_13_part2').click(function() {
        $("#btn_add_more_defect_failures_13_part2").hide();
        $(".defects13_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_13_part3').click(function() {
        $("#btn_add_more_defect_failures_13_part3").hide();
        $(".defects13_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_13_part4').click(function() {
        $("#btn_add_more_defect_failures_13_part4").hide();
        $(".defects13_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_13_part2').click(function() {
        $("#btn_add_more_defect_failures_13_part1").show();
        $(".defects13_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_13_part3').click(function() {
        $("#btn_add_more_defect_failures_13_part2").show();
        $(".defects13_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_13_part4').click(function() {
        $("#btn_add_more_defect_failures_13_part3").show();
        $(".defects13_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_13_part5').click(function() {
        $("#btn_add_more_defect_failures_13_part4").show();
        $(".defects13_part5").attr("style", "display: none");
    });

    //#14
    $('#btn_add_more_defect_failures_14_part1').click(function() {
        $("#btn_add_more_defect_failures_14_part1").hide();
        $(".defects14_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_14_part2').click(function() {
        $("#btn_add_more_defect_failures_14_part2").hide();
        $(".defects14_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_14_part3').click(function() {
        $("#btn_add_more_defect_failures_14_part3").hide();
        $(".defects14_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_14_part4').click(function() {
        $("#btn_add_more_defect_failures_14_part4").hide();
        $(".defects14_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_14_part2').click(function() {
        $("#btn_add_more_defect_failures_14_part1").show();
        $(".defects14_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_14_part3').click(function() {
        $("#btn_add_more_defect_failures_14_part2").show();
        $(".defects14_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_14_part4').click(function() {
        $("#btn_add_more_defect_failures_14_part3").show();
        $(".defects14_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_14_part5').click(function() {
        $("#btn_add_more_defect_failures_14_part4").show();
        $(".defects14_part5").attr("style", "display: none");
    });

    //#15
    $('#btn_add_more_defect_failures_15_part1').click(function() {
        $("#btn_add_more_defect_failures_15_part1").hide();
        $(".defects15_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_15_part2').click(function() {
        $("#btn_add_more_defect_failures_15_part2").hide();
        $(".defects15_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_15_part3').click(function() {
        $("#btn_add_more_defect_failures_15_part3").hide();
        $(".defects15_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_15_part4').click(function() {
        $("#btn_add_more_defect_failures_15_part4").hide();
        $(".defects15_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_15_part2').click(function() {
        $("#btn_add_more_defect_failures_15_part1").show();
        $(".defects15_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_15_part3').click(function() {
        $("#btn_add_more_defect_failures_15_part2").show();
        $(".defects15_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_15_part4').click(function() {
        $("#btn_add_more_defect_failures_15_part3").show();
        $(".defects15_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_15_part5').click(function() {
        $("#btn_add_more_defect_failures_15_part4").show();
        $(".defects15_part5").attr("style", "display: none");
    });

    //#16
    $('#btn_add_more_defect_failures_16_part1').click(function() {
        $("#btn_add_more_defect_failures_16_part1").hide();
        $(".defects16_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_16_part2').click(function() {
        $("#btn_add_more_defect_failures_16_part2").hide();
        $(".defects16_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_16_part3').click(function() {
        $("#btn_add_more_defect_failures_16_part3").hide();
        $(".defects16_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_16_part4').click(function() {
        $("#btn_add_more_defect_failures_16_part4").hide();
        $(".defects16_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_16_part2').click(function() {
        $("#btn_add_more_defect_failures_16_part1").show();
        $(".defects16_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_16_part3').click(function() {
        $("#btn_add_more_defect_failures_16_part2").show();
        $(".defects16_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_16_part4').click(function() {
        $("#btn_add_more_defect_failures_16_part3").show();
        $(".defects16_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_16_part5').click(function() {
        $("#btn_add_more_defect_failures_16_part4").show();
        $(".defects16_part5").attr("style", "display: none");
    });

    //#17
    $('#btn_add_more_defect_failures_17_part1').click(function() {
        $("#btn_add_more_defect_failures_17_part1").hide();
        $(".defects17_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_17_part2').click(function() {
        $("#btn_add_more_defect_failures_17_part2").hide();
        $(".defects17_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_17_part3').click(function() {
        $("#btn_add_more_defect_failures_17_part3").hide();
        $(".defects17_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_17_part4').click(function() {
        $("#btn_add_more_defect_failures_17_part4").hide();
        $(".defects17_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_17_part2').click(function() {
        $("#btn_add_more_defect_failures_17_part1").show();
        $(".defects17_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_17_part3').click(function() {
        $("#btn_add_more_defect_failures_17_part2").show();
        $(".defects17_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_17_part4').click(function() {
        $("#btn_add_more_defect_failures_17_part3").show();
        $(".defects17_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_17_part5').click(function() {
        $("#btn_add_more_defect_failures_17_part4").show();
        $(".defects17_part5").attr("style", "display: none");
    });

    //#18
    $('#btn_add_more_defect_failures_18_part1').click(function() {
        $("#btn_add_more_defect_failures_18_part1").hide();
        $(".defects18_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_18_part2').click(function() {
        $("#btn_add_more_defect_failures_18_part2").hide();
        $(".defects18_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_18_part3').click(function() {
        $("#btn_add_more_defect_failures_18_part3").hide();
        $(".defects18_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_18_part4').click(function() {
        $("#btn_add_more_defect_failures_18_part4").hide();
        $(".defects18_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_18_part2').click(function() {
        $("#btn_add_more_defect_failures_18_part1").show();
        $(".defects18_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_18_part3').click(function() {
        $("#btn_add_more_defect_failures_18_part2").show();
        $(".defects18_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_18_part4').click(function() {
        $("#btn_add_more_defect_failures_18_part3").show();
        $(".defects18_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_18_part5').click(function() {
        $("#btn_add_more_defect_failures_18_part4").show();
        $(".defects18_part5").attr("style", "display: none");
    });

    //#19
    $('#btn_add_more_defect_failures_19_part1').click(function() {
        $("#btn_add_more_defect_failures_19_part1").hide();
        $(".defects19_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_19_part2').click(function() {
        $("#btn_add_more_defect_failures_19_part2").hide();
        $(".defects19_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_19_part3').click(function() {
        $("#btn_add_more_defect_failures_19_part3").hide();
        $(".defects19_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_19_part4').click(function() {
        $("#btn_add_more_defect_failures_19_part4").hide();
        $(".defects19_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_19_part2').click(function() {
        $("#btn_add_more_defect_failures_19_part1").show();
        $(".defects19_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_19_part3').click(function() {
        $("#btn_add_more_defect_failures_19_part2").show();
        $(".defects19_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_19_part4').click(function() {
        $("#btn_add_more_defect_failures_19_part3").show();
        $(".defects19_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_19_part5').click(function() {
        $("#btn_add_more_defect_failures_19_part4").show();
        $(".defects19_part5").attr("style", "display: none");
    });

    //#20
    $('#btn_add_more_defect_failures_20_part1').click(function() {
        $("#btn_add_more_defect_failures_20_part1").hide();
        $(".defects20_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_20_part2').click(function() {
        $("#btn_add_more_defect_failures_20_part2").hide();
        $(".defects20_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_20_part3').click(function() {
        $("#btn_add_more_defect_failures_20_part3").hide();
        $(".defects20_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_20_part4').click(function() {
        $("#btn_add_more_defect_failures_20_part4").hide();
        $(".defects20_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_20_part2').click(function() {
        $("#btn_add_more_defect_failures_20_part1").show();
        $(".defects20_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_20_part3').click(function() {
        $("#btn_add_more_defect_failures_20_part2").show();
        $(".defects20_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_20_part4').click(function() {
        $("#btn_add_more_defect_failures_20_part3").show();
        $(".defects20_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_20_part5').click(function() {
        $("#btn_add_more_defect_failures_20_part4").show();
        $(".defects20_part5").attr("style", "display: none");
    });
    //#21
    $('#btn_add_more_defect_failures_21_part1').click(function() {
        $("#btn_add_more_defect_failures_21_part1").hide();
        $(".defects21_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_21_part2').click(function() {
        $("#btn_add_more_defect_failures_21_part2").hide();
        $(".defects21_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_21_part3').click(function() {
        $("#btn_add_more_defect_failures_21_part3").hide();
        $(".defects21_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_21_part4').click(function() {
        $("#btn_add_more_defect_failures_21_part4").hide();
        $(".defects21_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_21_part2').click(function() {
        $("#btn_add_more_defect_failures_21_part1").show();
        $(".defects21_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_21_part3').click(function() {
        $("#btn_add_more_defect_failures_21_part2").show();
        $(".defects21_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_21_part4').click(function() {
        $("#btn_add_more_defect_failures_21_part3").show();
        $(".defects21_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_21_part5').click(function() {
        $("#btn_add_more_defect_failures_21_part4").show();
        $(".defects21_part5").attr("style", "display: none");
    });
    //#22
    $('#btn_add_more_defect_failures_22_part1').click(function() {
        $("#btn_add_more_defect_failures_22_part1").hide();
        $(".defects22_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_22_part2').click(function() {
        $("#btn_add_more_defect_failures_22_part2").hide();
        $(".defects22_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_22_part3').click(function() {
        $("#btn_add_more_defect_failures_22_part3").hide();
        $(".defects22_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_22_part4').click(function() {
        $("#btn_add_more_defect_failures_22_part4").hide();
        $(".defects22_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_22_part2').click(function() {
        $("#btn_add_more_defect_failures_22_part1").show();
        $(".defects22_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_22_part3').click(function() {
        $("#btn_add_more_defect_failures_22_part2").show();
        $(".defects22_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_22_part4').click(function() {
        $("#btn_add_more_defect_failures_22_part3").show();
        $(".defects22_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_22_part5').click(function() {
        $("#btn_add_more_defect_failures_22_part4").show();
        $(".defects22_part5").attr("style", "display: none");
    });
    //23
    $('#btn_add_more_defect_failures_23_part1').click(function() {
        $("#btn_add_more_defect_failures_23_part1").hide();
        $(".defects23_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_23_part2').click(function() {
        $("#btn_add_more_defect_failures_23_part2").hide();
        $(".defects23_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_23_part3').click(function() {
        $("#btn_add_more_defect_failures_23_part3").hide();
        $(".defects23_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_23_part4').click(function() {
        $("#btn_add_more_defect_failures_23_part4").hide();
        $(".defects23_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_23_part2').click(function() {
        $("#btn_add_more_defect_failures_23_part1").show();
        $(".defects23_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_23_part3').click(function() {
        $("#btn_add_more_defect_failures_23_part2").show();
        $(".defects23_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_23_part4').click(function() {
        $("#btn_add_more_defect_failures_23_part3").show();
        $(".defects23_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_23_part5').click(function() {
        $("#btn_add_more_defect_failures_23_part4").show();
        $(".defects23_part5").attr("style", "display: none");
    });
    //24
    $('#btn_add_more_defect_failures_24_part1').click(function() {
        $("#btn_add_more_defect_failures_24_part1").hide();
        $(".defects24_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_24_part2').click(function() {
        $("#btn_add_more_defect_failures_24_part2").hide();
        $(".defects24_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_24_part3').click(function() {
        $("#btn_add_more_defect_failures_24_part3").hide();
        $(".defects24_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_24_part4').click(function() {
        $("#btn_add_more_defect_failures_24_part4").hide();
        $(".defects24_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_24_part2').click(function() {
        $("#btn_add_more_defect_failures_24_part1").show();
        $(".defects24_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_24_part3').click(function() {
        $("#btn_add_more_defect_failures_24_part2").show();
        $(".defects24_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_24_part4').click(function() {
        $("#btn_add_more_defect_failures_24_part3").show();
        $(".defects24_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_24_part5').click(function() {
        $("#btn_add_more_defect_failures_24_part4").show();
        $(".defects24_part5").attr("style", "display: none");
    });
    //25
    $('#btn_add_more_defect_failures_25_part1').click(function() {
        $("#btn_add_more_defect_failures_25_part1").hide();
        $(".defects25_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_25_part2').click(function() {
        $("#btn_add_more_defect_failures_25_part2").hide();
        $(".defects25_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_25_part3').click(function() {
        $("#btn_add_more_defect_failures_25_part3").hide();
        $(".defects25_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_25_part4').click(function() {
        $("#btn_add_more_defect_failures_25_part4").hide();
        $(".defects25_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_25_part2').click(function() {
        $("#btn_add_more_defect_failures_25_part1").show();
        $(".defects25_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_25_part3').click(function() {
        $("#btn_add_more_defect_failures_25_part2").show();
        $(".defects25_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_25_part4').click(function() {
        $("#btn_add_more_defect_failures_25_part3").show();
        $(".defects25_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_25_part5').click(function() {
        $("#btn_add_more_defect_failures_25_part4").show();
        $(".defects25_part5").attr("style", "display: none");
    });
    //26
    $('#btn_add_more_defect_failures_26_part1').click(function() {
        $("#btn_add_more_defect_failures_26_part1").hide();
        $(".defects26_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_26_part2').click(function() {
        $("#btn_add_more_defect_failures_26_part2").hide();
        $(".defects26_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_26_part3').click(function() {
        $("#btn_add_more_defect_failures_26_part3").hide();
        $(".defects26_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_26_part4').click(function() {
        $("#btn_add_more_defect_failures_26_part4").hide();
        $(".defects26_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_26_part2').click(function() {
        $("#btn_add_more_defect_failures_26_part1").show();
        $(".defects26_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_26_part3').click(function() {
        $("#btn_add_more_defect_failures_26_part2").show();
        $(".defects26_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_26_part4').click(function() {
        $("#btn_add_more_defect_failures_26_part3").show();
        $(".defects26_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_26_part5').click(function() {
        $("#btn_add_more_defect_failures_26_part4").show();
        $(".defects26_part5").attr("style", "display: none");
    });
    //27
    $('#btn_add_more_defect_failures_27_part1').click(function() {
        $("#btn_add_more_defect_failures_27_part1").hide();
        $(".defects27_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_27_part2').click(function() {
        $("#btn_add_more_defect_failures_27_part2").hide();
        $(".defects27_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_27_part3').click(function() {
        $("#btn_add_more_defect_failures_27_part3").hide();
        $(".defects27_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_27_part4').click(function() {
        $("#btn_add_more_defect_failures_27_part4").hide();
        $(".defects27_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_27_part2').click(function() {
        $("#btn_add_more_defect_failures_27_part1").show();
        $(".defects27_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_27_part3').click(function() {
        $("#btn_add_more_defect_failures_27_part2").show();
        $(".defects27_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_27_part4').click(function() {
        $("#btn_add_more_defect_failures_27_part3").show();
        $(".defects27_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_27_part5').click(function() {
        $("#btn_add_more_defect_failures_27_part4").show();
        $(".defects27_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_28_part1').click(function() {
        $("#btn_add_more_defect_failures_28_part1").hide();
        $(".defects28_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_28_part2').click(function() {
        $("#btn_add_more_defect_failures_28_part2").hide();
        $(".defects28_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_28_part3').click(function() {
        $("#btn_add_more_defect_failures_28_part3").hide();
        $(".defects28_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_28_part4').click(function() {
        $("#btn_add_more_defect_failures_28_part4").hide();
        $(".defects28_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_28_part2').click(function() {
        $("#btn_add_more_defect_failures_28_part1").show();
        $(".defects28_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_28_part3').click(function() {
        $("#btn_add_more_defect_failures_28_part2").show();
        $(".defects28_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_28_part4').click(function() {
        $("#btn_add_more_defect_failures_28_part3").show();
        $(".defects28_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_28_part5').click(function() {
        $("#btn_add_more_defect_failures_28_part4").show();
        $(".defects28_part5").attr("style", "display: none");
    });
    $('#btn_add_more_defect_failures_29_part1').click(function() {
        $("#btn_add_more_defect_failures_29_part1").hide();
        $(".defects29_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_29_part2').click(function() {
        $("#btn_add_more_defect_failures_29_part2").hide();
        $(".defects29_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_29_part3').click(function() {
        $("#btn_add_more_defect_failures_29_part3").hide();
        $(".defects29_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_29_part4').click(function() {
        $("#btn_add_more_defect_failures_29_part4").hide();
        $(".defects29_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_29_part2').click(function() {
        $("#btn_add_more_defect_failures_29_part1").show();
        $(".defects29_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_29_part3').click(function() {
        $("#btn_add_more_defect_failures_29_part2").show();
        $(".defects29_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_29_part4').click(function() {
        $("#btn_add_more_defect_failures_29_part3").show();
        $(".defects29_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_29_part5').click(function() {
        $("#btn_add_more_defect_failures_29_part4").show();
        $(".defects29_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_30_part1').click(function() {
        $("#btn_add_more_defect_failures_30_part1").hide();
        $(".defects30_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_30_part2').click(function() {
        $("#btn_add_more_defect_failures_30_part2").hide();
        $(".defects30_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_30_part3').click(function() {
        $("#btn_add_more_defect_failures_30_part3").hide();
        $(".defects30_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_30_part4').click(function() {
        $("#btn_add_more_defect_failures_30_part4").hide();
        $(".defects30_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_30_part2').click(function() {
        $("#btn_add_more_defect_failures_30_part1").show();
        $(".defects30_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_30_part3').click(function() {
        $("#btn_add_more_defect_failures_30_part2").show();
        $(".defects30_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_30_part4').click(function() {
        $("#btn_add_more_defect_failures_30_part3").show();
        $(".defects30_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_30_part5').click(function() {
        $("#btn_add_more_defect_failures_30_part4").show();
        $(".defects30_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_31_part1').click(function() {
        $("#btn_add_more_defect_failures_31_part1").hide();
        $(".defects31_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_31_part2').click(function() {
        $("#btn_add_more_defect_failures_31_part2").hide();
        $(".defects31_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_31_part3').click(function() {
        $("#btn_add_more_defect_failures_31_part3").hide();
        $(".defects31_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_31_part4').click(function() {
        $("#btn_add_more_defect_failures_31_part4").hide();
        $(".defects31_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_31_part2').click(function() {
        $("#btn_add_more_defect_failures_31_part1").show();
        $(".defects31_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_31_part3').click(function() {
        $("#btn_add_more_defect_failures_31_part2").show();
        $(".defects31_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_31_part4').click(function() {
        $("#btn_add_more_defect_failures_31_part3").show();
        $(".defects31_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_31_part5').click(function() {
        $("#btn_add_more_defect_failures_31_part4").show();
        $(".defects31_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_32_part1').click(function() {
        $("#btn_add_more_defect_failures_32_part1").hide();
        $(".defects32_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_32_part2').click(function() {
        $("#btn_add_more_defect_failures_32_part2").hide();
        $(".defects32_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_32_part3').click(function() {
        $("#btn_add_more_defect_failures_32_part3").hide();
        $(".defects32_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_32_part4').click(function() {
        $("#btn_add_more_defect_failures_32_part4").hide();
        $(".defects32_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_32_part2').click(function() {
        $("#btn_add_more_defect_failures_32_part1").show();
        $(".defects32_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_32_part3').click(function() {
        $("#btn_add_more_defect_failures_32_part2").show();
        $(".defects32_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_32_part4').click(function() {
        $("#btn_add_more_defect_failures_32_part3").show();
        $(".defects32_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_32_part5').click(function() {
        $("#btn_add_more_defect_failures_32_part4").show();
        $(".defects32_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_33_part1').click(function() {
        $("#btn_add_more_defect_failures_33_part1").hide();
        $(".defects33_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_33_part2').click(function() {
        $("#btn_add_more_defect_failures_33_part2").hide();
        $(".defects33_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_33_part3').click(function() {
        $("#btn_add_more_defect_failures_33_part3").hide();
        $(".defects33_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_33_part4').click(function() {
        $("#btn_add_more_defect_failures_33_part4").hide();
        $(".defects33_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_33_part2').click(function() {
        $("#btn_add_more_defect_failures_33_part1").show();
        $(".defects33_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_33_part3').click(function() {
        $("#btn_add_more_defect_failures_33_part2").show();
        $(".defects33_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_33_part4').click(function() {
        $("#btn_add_more_defect_failures_33_part3").show();
        $(".defects33_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_33_part5').click(function() {
        $("#btn_add_more_defect_failures_33_part4").show();
        $(".defects33_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_34_part1').click(function() {
        $("#btn_add_more_defect_failures_34_part1").hide();
        $(".defects34_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_34_part2').click(function() {
        $("#btn_add_more_defect_failures_34_part2").hide();
        $(".defects34_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_34_part3').click(function() {
        $("#btn_add_more_defect_failures_34_part3").hide();
        $(".defects34_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_34_part4').click(function() {
        $("#btn_add_more_defect_failures_34_part4").hide();
        $(".defects34_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_34_part2').click(function() {
        $("#btn_add_more_defect_failures_34_part1").show();
        $(".defects34_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_34_part3').click(function() {
        $("#btn_add_more_defect_failures_34_part2").show();
        $(".defects34_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_34_part4').click(function() {
        $("#btn_add_more_defect_failures_34_part3").show();
        $(".defects34_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_34_part5').click(function() {
        $("#btn_add_more_defect_failures_34_part4").show();
        $(".defects34_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_35_part1').click(function() {
        $("#btn_add_more_defect_failures_35_part1").hide();
        $(".defects35_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_35_part2').click(function() {
        $("#btn_add_more_defect_failures_35_part2").hide();
        $(".defects35_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_35_part3').click(function() {
        $("#btn_add_more_defect_failures_35_part3").hide();
        $(".defects35_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_35_part4').click(function() {
        $("#btn_add_more_defect_failures_35_part4").hide();
        $(".defects35_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_35_part2').click(function() {
        $("#btn_add_more_defect_failures_35_part1").show();
        $(".defects35_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_35_part3').click(function() {
        $("#btn_add_more_defect_failures_35_part2").show();
        $(".defects35_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_35_part4').click(function() {
        $("#btn_add_more_defect_failures_35_part3").show();
        $(".defects35_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_35_part5').click(function() {
        $("#btn_add_more_defect_failures_35_part4").show();
        $(".defects35_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_36_part1').click(function() {
        $("#btn_add_more_defect_failures_36_part1").hide();
        $(".defects36_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_36_part2').click(function() {
        $("#btn_add_more_defect_failures_36_part2").hide();
        $(".defects36_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_36_part3').click(function() {
        $("#btn_add_more_defect_failures_36_part3").hide();
        $(".defects36_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_36_part4').click(function() {
        $("#btn_add_more_defect_failures_36_part4").hide();
        $(".defects36_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_36_part2').click(function() {
        $("#btn_add_more_defect_failures_36_part1").show();
        $(".defects36_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_36_part3').click(function() {
        $("#btn_add_more_defect_failures_36_part2").show();
        $(".defects36_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_36_part4').click(function() {
        $("#btn_add_more_defect_failures_36_part3").show();
        $(".defects36_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_36_part5').click(function() {
        $("#btn_add_more_defect_failures_36_part4").show();
        $(".defects36_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_37_part1').click(function() {
        $("#btn_add_more_defect_failures_37_part1").hide();
        $(".defects37_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_37_part2').click(function() {
        $("#btn_add_more_defect_failures_37_part2").hide();
        $(".defects37_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_37_part3').click(function() {
        $("#btn_add_more_defect_failures_37_part3").hide();
        $(".defects37_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_37_part4').click(function() {
        $("#btn_add_more_defect_failures_37_part4").hide();
        $(".defects37_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_37_part2').click(function() {
        $("#btn_add_more_defect_failures_37_part1").show();
        $(".defects37_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_37_part3').click(function() {
        $("#btn_add_more_defect_failures_37_part2").show();
        $(".defects37_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_37_part4').click(function() {
        $("#btn_add_more_defect_failures_37_part3").show();
        $(".defects37_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_37_part5').click(function() {
        $("#btn_add_more_defect_failures_37_part4").show();
        $(".defects37_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_38_part1').click(function() {
        $("#btn_add_more_defect_failures_38_part1").hide();
        $(".defects38_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_38_part2').click(function() {
        $("#btn_add_more_defect_failures_38_part2").hide();
        $(".defects38_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_38_part3').click(function() {
        $("#btn_add_more_defect_failures_38_part3").hide();
        $(".defects38_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_38_part4').click(function() {
        $("#btn_add_more_defect_failures_38_part4").hide();
        $(".defects38_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_38_part2').click(function() {
        $("#btn_add_more_defect_failures_38_part1").show();
        $(".defects38_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_38_part3').click(function() {
        $("#btn_add_more_defect_failures_38_part2").show();
        $(".defects38_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_38_part4').click(function() {
        $("#btn_add_more_defect_failures_38_part3").show();
        $(".defects38_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_38_part5').click(function() {
        $("#btn_add_more_defect_failures_38_part4").show();
        $(".defects38_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_39_part1').click(function() {
        $("#btn_add_more_defect_failures_39_part1").hide();
        $(".defects39_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_39_part2').click(function() {
        $("#btn_add_more_defect_failures_39_part2").hide();
        $(".defects39_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_39_part3').click(function() {
        $("#btn_add_more_defect_failures_39_part3").hide();
        $(".defects39_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_39_part4').click(function() {
        $("#btn_add_more_defect_failures_39_part4").hide();
        $(".defects39_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_39_part2').click(function() {
        $("#btn_add_more_defect_failures_39_part1").show();
        $(".defects39_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_39_part3').click(function() {
        $("#btn_add_more_defect_failures_39_part2").show();
        $(".defects39_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_39_part4').click(function() {
        $("#btn_add_more_defect_failures_39_part3").show();
        $(".defects39_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_39_part5').click(function() {
        $("#btn_add_more_defect_failures_39_part4").show();
        $(".defects39_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_40_part1').click(function() {
        $("#btn_add_more_defect_failures_40_part1").hide();
        $(".defects40_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_40_part2').click(function() {
        $("#btn_add_more_defect_failures_40_part2").hide();
        $(".defects40_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_40_part3').click(function() {
        $("#btn_add_more_defect_failures_40_part3").hide();
        $(".defects40_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_40_part4').click(function() {
        $("#btn_add_more_defect_failures_40_part4").hide();
        $(".defects40_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_40_part2').click(function() {
        $("#btn_add_more_defect_failures_40_part1").show();
        $(".defects40_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_40_part3').click(function() {
        $("#btn_add_more_defect_failures_40_part2").show();
        $(".defects40_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_40_part4').click(function() {
        $("#btn_add_more_defect_failures_40_part3").show();
        $(".defects40_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_40_part5').click(function() {
        $("#btn_add_more_defect_failures_40_part4").show();
        $(".defects40_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_41_part1').click(function() {
        $("#btn_add_more_defect_failures_41_part1").hide();
        $(".defects41_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_41_part2').click(function() {
        $("#btn_add_more_defect_failures_41_part2").hide();
        $(".defects41_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_41_part3').click(function() {
        $("#btn_add_more_defect_failures_41_part3").hide();
        $(".defects41_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_41_part4').click(function() {
        $("#btn_add_more_defect_failures_41_part4").hide();
        $(".defects41_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_41_part2').click(function() {
        $("#btn_add_more_defect_failures_41_part1").show();
        $(".defects41_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_41_part3').click(function() {
        $("#btn_add_more_defect_failures_41_part2").show();
        $(".defects41_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_41_part4').click(function() {
        $("#btn_add_more_defect_failures_41_part3").show();
        $(".defects41_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_41_part5').click(function() {
        $("#btn_add_more_defect_failures_41_part4").show();
        $(".defects41_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_42_part1').click(function() {
        $("#btn_add_more_defect_failures_42_part1").hide();
        $(".defects42_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_42_part2').click(function() {
        $("#btn_add_more_defect_failures_42_part2").hide();
        $(".defects42_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_42_part3').click(function() {
        $("#btn_add_more_defect_failures_42_part3").hide();
        $(".defects42_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_42_part4').click(function() {
        $("#btn_add_more_defect_failures_42_part4").hide();
        $(".defects42_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_42_part2').click(function() {
        $("#btn_add_more_defect_failures_42_part1").show();
        $(".defects42_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_42_part3').click(function() {
        $("#btn_add_more_defect_failures_42_part2").show();
        $(".defects42_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_42_part4').click(function() {
        $("#btn_add_more_defect_failures_42_part3").show();
        $(".defects42_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_42_part5').click(function() {
        $("#btn_add_more_defect_failures_42_part4").show();
        $(".defects42_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_43_part1').click(function() {
        $("#btn_add_more_defect_failures_43_part1").hide();
        $(".defects43_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_43_part2').click(function() {
        $("#btn_add_more_defect_failures_43_part2").hide();
        $(".defects43_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_43_part3').click(function() {
        $("#btn_add_more_defect_failures_43_part3").hide();
        $(".defects43_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_43_part4').click(function() {
        $("#btn_add_more_defect_failures_43_part4").hide();
        $(".defects43_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_43_part2').click(function() {
        $("#btn_add_more_defect_failures_43_part1").show();
        $(".defects43_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_43_part3').click(function() {
        $("#btn_add_more_defect_failures_43_part2").show();
        $(".defects43_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_43_part4').click(function() {
        $("#btn_add_more_defect_failures_43_part3").show();
        $(".defects43_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_43_part5').click(function() {
        $("#btn_add_more_defect_failures_43_part4").show();
        $(".defects43_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_44_part1').click(function() {
        $("#btn_add_more_defect_failures_44_part1").hide();
        $(".defects44_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_44_part2').click(function() {
        $("#btn_add_more_defect_failures_44_part2").hide();
        $(".defects44_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_44_part3').click(function() {
        $("#btn_add_more_defect_failures_44_part3").hide();
        $(".defects44_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_44_part4').click(function() {
        $("#btn_add_more_defect_failures_44_part4").hide();
        $(".defects44_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_44_part2').click(function() {
        $("#btn_add_more_defect_failures_44_part1").show();
        $(".defects44_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_44_part3').click(function() {
        $("#btn_add_more_defect_failures_44_part2").show();
        $(".defects44_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_44_part4').click(function() {
        $("#btn_add_more_defect_failures_44_part3").show();
        $(".defects44_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_44_part5').click(function() {
        $("#btn_add_more_defect_failures_44_part4").show();
        $(".defects44_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_45_part1').click(function() {
        $("#btn_add_more_defect_failures_45_part1").hide();
        $(".defects45_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_45_part2').click(function() {
        $("#btn_add_more_defect_failures_45_part2").hide();
        $(".defects45_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_45_part3').click(function() {
        $("#btn_add_more_defect_failures_45_part3").hide();
        $(".defects45_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_45_part4').click(function() {
        $("#btn_add_more_defect_failures_45_part4").hide();
        $(".defects45_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_45_part2').click(function() {
        $("#btn_add_more_defect_failures_45_part1").show();
        $(".defects45_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_45_part3').click(function() {
        $("#btn_add_more_defect_failures_45_part2").show();
        $(".defects45_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_45_part4').click(function() {
        $("#btn_add_more_defect_failures_45_part3").show();
        $(".defects45_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_45_part5').click(function() {
        $("#btn_add_more_defect_failures_45_part4").show();
        $(".defects45_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_46_part1').click(function() {
        $("#btn_add_more_defect_failures_46_part1").hide();
        $(".defects46_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_46_part2').click(function() {
        $("#btn_add_more_defect_failures_46_part2").hide();
        $(".defects46_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_46_part3').click(function() {
        $("#btn_add_more_defect_failures_46_part3").hide();
        $(".defects46_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_46_part4').click(function() {
        $("#btn_add_more_defect_failures_46_part4").hide();
        $(".defects46_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_46_part2').click(function() {
        $("#btn_add_more_defect_failures_46_part1").show();
        $(".defects46_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_46_part3').click(function() {
        $("#btn_add_more_defect_failures_46_part2").show();
        $(".defects46_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_46_part4').click(function() {
        $("#btn_add_more_defect_failures_46_part3").show();
        $(".defects46_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_46_part5').click(function() {
        $("#btn_add_more_defect_failures_46_part4").show();
        $(".defects46_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_47_part1').click(function() {
        $("#btn_add_more_defect_failures_47_part1").hide();
        $(".defects47_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_47_part2').click(function() {
        $("#btn_add_more_defect_failures_47_part2").hide();
        $(".defects47_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_47_part3').click(function() {
        $("#btn_add_more_defect_failures_47_part3").hide();
        $(".defects47_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_47_part4').click(function() {
        $("#btn_add_more_defect_failures_47_part4").hide();
        $(".defects47_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_47_part2').click(function() {
        $("#btn_add_more_defect_failures_47_part1").show();
        $(".defects47_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_47_part3').click(function() {
        $("#btn_add_more_defect_failures_47_part2").show();
        $(".defects47_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_47_part4').click(function() {
        $("#btn_add_more_defect_failures_47_part3").show();
        $(".defects47_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_47_part5').click(function() {
        $("#btn_add_more_defect_failures_47_part4").show();
        $(".defects47_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_48_part1').click(function() {
        $("#btn_add_more_defect_failures_48_part1").hide();
        $(".defects48_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_48_part2').click(function() {
        $("#btn_add_more_defect_failures_48_part2").hide();
        $(".defects48_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_48_part3').click(function() {
        $("#btn_add_more_defect_failures_48_part3").hide();
        $(".defects48_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_48_part4').click(function() {
        $("#btn_add_more_defect_failures_48_part4").hide();
        $(".defects48_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_48_part2').click(function() {
        $("#btn_add_more_defect_failures_48_part1").show();
        $(".defects48_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_48_part3').click(function() {
        $("#btn_add_more_defect_failures_48_part2").show();
        $(".defects48_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_48_part4').click(function() {
        $("#btn_add_more_defect_failures_48_part3").show();
        $(".defects48_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_48_part5').click(function() {
        $("#btn_add_more_defect_failures_48_part4").show();
        $(".defects48_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_49_part1').click(function() {
        $("#btn_add_more_defect_failures_49_part1").hide();
        $(".defects49_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_49_part2').click(function() {
        $("#btn_add_more_defect_failures_49_part2").hide();
        $(".defects49_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_49_part3').click(function() {
        $("#btn_add_more_defect_failures_49_part3").hide();
        $(".defects49_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_49_part4').click(function() {
        $("#btn_add_more_defect_failures_49_part4").hide();
        $(".defects49_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_49_part2').click(function() {
        $("#btn_add_more_defect_failures_49_part1").show();
        $(".defects49_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_49_part3').click(function() {
        $("#btn_add_more_defect_failures_49_part2").show();
        $(".defects49_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_49_part4').click(function() {
        $("#btn_add_more_defect_failures_49_part3").show();
        $(".defects49_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_49_part5').click(function() {
        $("#btn_add_more_defect_failures_49_part4").show();
        $(".defects49_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_50_part1').click(function() {
        $("#btn_add_more_defect_failures_50_part1").hide();
        $(".defects50_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_50_part2').click(function() {
        $("#btn_add_more_defect_failures_50_part2").hide();
        $(".defects50_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_50_part3').click(function() {
        $("#btn_add_more_defect_failures_50_part3").hide();
        $(".defects50_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_50_part4').click(function() {
        $("#btn_add_more_defect_failures_50_part4").hide();
        $(".defects50_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_50_part2').click(function() {
        $("#btn_add_more_defect_failures_50_part1").show();
        $(".defects50_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_50_part3').click(function() {
        $("#btn_add_more_defect_failures_50_part2").show();
        $(".defects50_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_50_part4').click(function() {
        $("#btn_add_more_defect_failures_50_part3").show();
        $(".defects50_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_50_part5').click(function() {
        $("#btn_add_more_defect_failures_50_part4").show();
        $(".defects50_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_51_part1').click(function() {
        $("#btn_add_more_defect_failures_51_part1").hide();
        $(".defects51_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_51_part2').click(function() {
        $("#btn_add_more_defect_failures_51_part2").hide();
        $(".defects51_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_51_part3').click(function() {
        $("#btn_add_more_defect_failures_51_part3").hide();
        $(".defects51_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_51_part4').click(function() {
        $("#btn_add_more_defect_failures_51_part4").hide();
        $(".defects51_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_51_part2').click(function() {
        $("#btn_add_more_defect_failures_51_part1").show();
        $(".defects51_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_51_part3').click(function() {
        $("#btn_add_more_defect_failures_51_part2").show();
        $(".defects51_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_51_part4').click(function() {
        $("#btn_add_more_defect_failures_51_part3").show();
        $(".defects51_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_51_part5').click(function() {
        $("#btn_add_more_defect_failures_51_part4").show();
        $(".defects51_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_52_part1').click(function() {
        $("#btn_add_more_defect_failures_52_part1").hide();
        $(".defects52_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_52_part2').click(function() {
        $("#btn_add_more_defect_failures_52_part2").hide();
        $(".defects52_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_52_part3').click(function() {
        $("#btn_add_more_defect_failures_52_part3").hide();
        $(".defects52_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_52_part4').click(function() {
        $("#btn_add_more_defect_failures_52_part4").hide();
        $(".defects52_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_52_part2').click(function() {
        $("#btn_add_more_defect_failures_52_part1").show();
        $(".defects52_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_52_part3').click(function() {
        $("#btn_add_more_defect_failures_52_part2").show();
        $(".defects52_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_52_part4').click(function() {
        $("#btn_add_more_defect_failures_52_part3").show();
        $(".defects52_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_52_part5').click(function() {
        $("#btn_add_more_defect_failures_52_part4").show();
        $(".defects52_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_53_part1').click(function() {
        $("#btn_add_more_defect_failures_53_part1").hide();
        $(".defects53_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_53_part2').click(function() {
        $("#btn_add_more_defect_failures_53_part2").hide();
        $(".defects53_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_53_part3').click(function() {
        $("#btn_add_more_defect_failures_53_part3").hide();
        $(".defects53_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_53_part4').click(function() {
        $("#btn_add_more_defect_failures_53_part4").hide();
        $(".defects53_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_53_part2').click(function() {
        $("#btn_add_more_defect_failures_53_part1").show();
        $(".defects53_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_53_part3').click(function() {
        $("#btn_add_more_defect_failures_53_part2").show();
        $(".defects53_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_53_part4').click(function() {
        $("#btn_add_more_defect_failures_53_part3").show();
        $(".defects53_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_53_part5').click(function() {
        $("#btn_add_more_defect_failures_53_part4").show();
        $(".defects53_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_54_part1').click(function() {
        $("#btn_add_more_defect_failures_54_part1").hide();
        $(".defects54_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_54_part2').click(function() {
        $("#btn_add_more_defect_failures_54_part2").hide();
        $(".defects54_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_54_part3').click(function() {
        $("#btn_add_more_defect_failures_54_part3").hide();
        $(".defects54_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_54_part4').click(function() {
        $("#btn_add_more_defect_failures_54_part4").hide();
        $(".defects54_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_54_part2').click(function() {
        $("#btn_add_more_defect_failures_54_part1").show();
        $(".defects54_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_54_part3').click(function() {
        $("#btn_add_more_defect_failures_54_part2").show();
        $(".defects54_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_54_part4').click(function() {
        $("#btn_add_more_defect_failures_54_part3").show();
        $(".defects54_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_54_part5').click(function() {
        $("#btn_add_more_defect_failures_54_part4").show();
        $(".defects54_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_55_part1').click(function() {
        $("#btn_add_more_defect_failures_55_part1").hide();
        $(".defects55_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_55_part2').click(function() {
        $("#btn_add_more_defect_failures_55_part2").hide();
        $(".defects55_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_55_part3').click(function() {
        $("#btn_add_more_defect_failures_55_part3").hide();
        $(".defects55_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_55_part4').click(function() {
        $("#btn_add_more_defect_failures_55_part4").hide();
        $(".defects55_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_55_part2').click(function() {
        $("#btn_add_more_defect_failures_55_part1").show();
        $(".defects55_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_55_part3').click(function() {
        $("#btn_add_more_defect_failures_55_part2").show();
        $(".defects55_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_55_part4').click(function() {
        $("#btn_add_more_defect_failures_55_part3").show();
        $(".defects55_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_55_part5').click(function() {
        $("#btn_add_more_defect_failures_55_part4").show();
        $(".defects55_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_56_part1').click(function() {
        $("#btn_add_more_defect_failures_56_part1").hide();
        $(".defects56_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_56_part2').click(function() {
        $("#btn_add_more_defect_failures_56_part2").hide();
        $(".defects56_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_56_part3').click(function() {
        $("#btn_add_more_defect_failures_56_part3").hide();
        $(".defects56_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_56_part4').click(function() {
        $("#btn_add_more_defect_failures_56_part4").hide();
        $(".defects56_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_56_part2').click(function() {
        $("#btn_add_more_defect_failures_56_part1").show();
        $(".defects56_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_56_part3').click(function() {
        $("#btn_add_more_defect_failures_56_part2").show();
        $(".defects56_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_56_part4').click(function() {
        $("#btn_add_more_defect_failures_56_part3").show();
        $(".defects56_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_56_part5').click(function() {
        $("#btn_add_more_defect_failures_56_part4").show();
        $(".defects56_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_57_part1').click(function() {
        $("#btn_add_more_defect_failures_57_part1").hide();
        $(".defects57_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_57_part2').click(function() {
        $("#btn_add_more_defect_failures_57_part2").hide();
        $(".defects57_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_57_part3').click(function() {
        $("#btn_add_more_defect_failures_57_part3").hide();
        $(".defects57_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_57_part4').click(function() {
        $("#btn_add_more_defect_failures_57_part4").hide();
        $(".defects57_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_57_part2').click(function() {
        $("#btn_add_more_defect_failures_57_part1").show();
        $(".defects57_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_57_part3').click(function() {
        $("#btn_add_more_defect_failures_57_part2").show();
        $(".defects57_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_57_part4').click(function() {
        $("#btn_add_more_defect_failures_57_part3").show();
        $(".defects57_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_57_part5').click(function() {
        $("#btn_add_more_defect_failures_57_part4").show();
        $(".defects57_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_58_part1').click(function() {
        $("#btn_add_more_defect_failures_58_part1").hide();
        $(".defects58_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_58_part2').click(function() {
        $("#btn_add_more_defect_failures_58_part2").hide();
        $(".defects58_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_58_part3').click(function() {
        $("#btn_add_more_defect_failures_58_part3").hide();
        $(".defects58_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_58_part4').click(function() {
        $("#btn_add_more_defect_failures_58_part4").hide();
        $(".defects58_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_58_part2').click(function() {
        $("#btn_add_more_defect_failures_58_part1").show();
        $(".defects58_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_58_part3').click(function() {
        $("#btn_add_more_defect_failures_58_part2").show();
        $(".defects58_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_58_part4').click(function() {
        $("#btn_add_more_defect_failures_58_part3").show();
        $(".defects58_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_58_part5').click(function() {
        $("#btn_add_more_defect_failures_58_part4").show();
        $(".defects58_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_59_part1').click(function() {
        $("#btn_add_more_defect_failures_59_part1").hide();
        $(".defects59_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_59_part2').click(function() {
        $("#btn_add_more_defect_failures_59_part2").hide();
        $(".defects59_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_59_part3').click(function() {
        $("#btn_add_more_defect_failures_59_part3").hide();
        $(".defects59_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_59_part4').click(function() {
        $("#btn_add_more_defect_failures_59_part4").hide();
        $(".defects59_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_59_part2').click(function() {
        $("#btn_add_more_defect_failures_59_part1").show();
        $(".defects59_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_59_part3').click(function() {
        $("#btn_add_more_defect_failures_59_part2").show();
        $(".defects59_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_59_part4').click(function() {
        $("#btn_add_more_defect_failures_59_part3").show();
        $(".defects59_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_59_part5').click(function() {
        $("#btn_add_more_defect_failures_59_part4").show();
        $(".defects59_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_60_part1').click(function() {
        $("#btn_add_more_defect_failures_60_part1").hide();
        $(".defects60_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_60_part2').click(function() {
        $("#btn_add_more_defect_failures_60_part2").hide();
        $(".defects60_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_60_part3').click(function() {
        $("#btn_add_more_defect_failures_60_part3").hide();
        $(".defects60_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_60_part4').click(function() {
        $("#btn_add_more_defect_failures_60_part4").hide();
        $(".defects60_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_60_part2').click(function() {
        $("#btn_add_more_defect_failures_60_part1").show();
        $(".defects60_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_60_part3').click(function() {
        $("#btn_add_more_defect_failures_60_part2").show();
        $(".defects60_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_60_part4').click(function() {
        $("#btn_add_more_defect_failures_60_part3").show();
        $(".defects60_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_60_part5').click(function() {
        $("#btn_add_more_defect_failures_60_part4").show();
        $(".defects60_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_61_part1').click(function() {
        $("#btn_add_more_defect_failures_61_part1").hide();
        $(".defects61_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_61_part2').click(function() {
        $("#btn_add_more_defect_failures_61_part2").hide();
        $(".defects61_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_61_part3').click(function() {
        $("#btn_add_more_defect_failures_61_part3").hide();
        $(".defects61_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_61_part4').click(function() {
        $("#btn_add_more_defect_failures_61_part4").hide();
        $(".defects61_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_61_part2').click(function() {
        $("#btn_add_more_defect_failures_61_part1").show();
        $(".defects61_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_61_part3').click(function() {
        $("#btn_add_more_defect_failures_61_part2").show();
        $(".defects61_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_61_part4').click(function() {
        $("#btn_add_more_defect_failures_61_part3").show();
        $(".defects61_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_61_part5').click(function() {
        $("#btn_add_more_defect_failures_61_part4").show();
        $(".defects61_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_62_part1').click(function() {
        $("#btn_add_more_defect_failures_62_part1").hide();
        $(".defects62_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_62_part2').click(function() {
        $("#btn_add_more_defect_failures_62_part2").hide();
        $(".defects62_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_62_part3').click(function() {
        $("#btn_add_more_defect_failures_62_part3").hide();
        $(".defects62_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_62_part4').click(function() {
        $("#btn_add_more_defect_failures_62_part4").hide();
        $(".defects62_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_62_part2').click(function() {
        $("#btn_add_more_defect_failures_62_part1").show();
        $(".defects62_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_62_part3').click(function() {
        $("#btn_add_more_defect_failures_62_part2").show();
        $(".defects62_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_62_part4').click(function() {
        $("#btn_add_more_defect_failures_62_part3").show();
        $(".defects62_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_62_part5').click(function() {
        $("#btn_add_more_defect_failures_62_part4").show();
        $(".defects62_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_63_part1').click(function() {
        $("#btn_add_more_defect_failures_63_part1").hide();
        $(".defects63_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_63_part2').click(function() {
        $("#btn_add_more_defect_failures_63_part2").hide();
        $(".defects63_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_63_part3').click(function() {
        $("#btn_add_more_defect_failures_63_part3").hide();
        $(".defects63_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_63_part4').click(function() {
        $("#btn_add_more_defect_failures_63_part4").hide();
        $(".defects63_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_63_part2').click(function() {
        $("#btn_add_more_defect_failures_63_part1").show();
        $(".defects63_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_63_part3').click(function() {
        $("#btn_add_more_defect_failures_63_part2").show();
        $(".defects63_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_63_part4').click(function() {
        $("#btn_add_more_defect_failures_63_part3").show();
        $(".defects63_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_63_part5').click(function() {
        $("#btn_add_more_defect_failures_63_part4").show();
        $(".defects63_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_64_part1').click(function() {
        $("#btn_add_more_defect_failures_64_part1").hide();
        $(".defects64_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_64_part2').click(function() {
        $("#btn_add_more_defect_failures_64_part2").hide();
        $(".defects64_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_64_part3').click(function() {
        $("#btn_add_more_defect_failures_64_part3").hide();
        $(".defects64_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_64_part4').click(function() {
        $("#btn_add_more_defect_failures_64_part4").hide();
        $(".defects64_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_64_part2').click(function() {
        $("#btn_add_more_defect_failures_64_part1").show();
        $(".defects64_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_64_part3').click(function() {
        $("#btn_add_more_defect_failures_64_part2").show();
        $(".defects64_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_64_part4').click(function() {
        $("#btn_add_more_defect_failures_64_part3").show();
        $(".defects64_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_64_part5').click(function() {
        $("#btn_add_more_defect_failures_64_part4").show();
        $(".defects64_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_65_part1').click(function() {
        $("#btn_add_more_defect_failures_65_part1").hide();
        $(".defects65_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_65_part2').click(function() {
        $("#btn_add_more_defect_failures_65_part2").hide();
        $(".defects65_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_65_part3').click(function() {
        $("#btn_add_more_defect_failures_65_part3").hide();
        $(".defects65_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_65_part4').click(function() {
        $("#btn_add_more_defect_failures_65_part4").hide();
        $(".defects65_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_65_part2').click(function() {
        $("#btn_add_more_defect_failures_65_part1").show();
        $(".defects65_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_65_part3').click(function() {
        $("#btn_add_more_defect_failures_65_part2").show();
        $(".defects65_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_65_part4').click(function() {
        $("#btn_add_more_defect_failures_65_part3").show();
        $(".defects65_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_65_part5').click(function() {
        $("#btn_add_more_defect_failures_65_part4").show();
        $(".defects65_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_66_part1').click(function() {
        $("#btn_add_more_defect_failures_66_part1").hide();
        $(".defects66_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_66_part2').click(function() {
        $("#btn_add_more_defect_failures_66_part2").hide();
        $(".defects66_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_66_part3').click(function() {
        $("#btn_add_more_defect_failures_66_part3").hide();
        $(".defects66_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_66_part4').click(function() {
        $("#btn_add_more_defect_failures_66_part4").hide();
        $(".defects66_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_66_part2').click(function() {
        $("#btn_add_more_defect_failures_66_part1").show();
        $(".defects66_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_66_part3').click(function() {
        $("#btn_add_more_defect_failures_66_part2").show();
        $(".defects66_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_66_part4').click(function() {
        $("#btn_add_more_defect_failures_66_part3").show();
        $(".defects66_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_66_part5').click(function() {
        $("#btn_add_more_defect_failures_66_part4").show();
        $(".defects66_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_67_part1').click(function() {
        $("#btn_add_more_defect_failures_67_part1").hide();
        $(".defects67_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_67_part2').click(function() {
        $("#btn_add_more_defect_failures_67_part2").hide();
        $(".defects67_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_67_part3').click(function() {
        $("#btn_add_more_defect_failures_67_part3").hide();
        $(".defects67_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_67_part4').click(function() {
        $("#btn_add_more_defect_failures_67_part4").hide();
        $(".defects67_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_67_part2').click(function() {
        $("#btn_add_more_defect_failures_67_part1").show();
        $(".defects67_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_67_part3').click(function() {
        $("#btn_add_more_defect_failures_67_part2").show();
        $(".defects67_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_67_part4').click(function() {
        $("#btn_add_more_defect_failures_67_part3").show();
        $(".defects67_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_67_part5').click(function() {
        $("#btn_add_more_defect_failures_67_part4").show();
        $(".defects67_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_68_part1').click(function() {
        $("#btn_add_more_defect_failures_68_part1").hide();
        $(".defects68_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_68_part2').click(function() {
        $("#btn_add_more_defect_failures_68_part2").hide();
        $(".defects68_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_68_part3').click(function() {
        $("#btn_add_more_defect_failures_68_part3").hide();
        $(".defects68_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_68_part4').click(function() {
        $("#btn_add_more_defect_failures_68_part4").hide();
        $(".defects68_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_68_part2').click(function() {
        $("#btn_add_more_defect_failures_68_part1").show();
        $(".defects68_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_68_part3').click(function() {
        $("#btn_add_more_defect_failures_68_part2").show();
        $(".defects68_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_68_part4').click(function() {
        $("#btn_add_more_defect_failures_68_part3").show();
        $(".defects68_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_68_part5').click(function() {
        $("#btn_add_more_defect_failures_68_part4").show();
        $(".defects68_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_69_part1').click(function() {
        $("#btn_add_more_defect_failures_69_part1").hide();
        $(".defects69_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_69_part2').click(function() {
        $("#btn_add_more_defect_failures_69_part2").hide();
        $(".defects69_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_69_part3').click(function() {
        $("#btn_add_more_defect_failures_69_part3").hide();
        $(".defects69_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_69_part4').click(function() {
        $("#btn_add_more_defect_failures_69_part4").hide();
        $(".defects69_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_69_part2').click(function() {
        $("#btn_add_more_defect_failures_69_part1").show();
        $(".defects69_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_69_part3').click(function() {
        $("#btn_add_more_defect_failures_69_part2").show();
        $(".defects69_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_69_part4').click(function() {
        $("#btn_add_more_defect_failures_69_part3").show();
        $(".defects69_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_69_part5').click(function() {
        $("#btn_add_more_defect_failures_69_part4").show();
        $(".defects69_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_70_part1').click(function() {
        $("#btn_add_more_defect_failures_70_part1").hide();
        $(".defects70_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_70_part2').click(function() {
        $("#btn_add_more_defect_failures_70_part2").hide();
        $(".defects70_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_70_part3').click(function() {
        $("#btn_add_more_defect_failures_70_part3").hide();
        $(".defects70_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_70_part4').click(function() {
        $("#btn_add_more_defect_failures_70_part4").hide();
        $(".defects70_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_70_part2').click(function() {
        $("#btn_add_more_defect_failures_70_part1").show();
        $(".defects70_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_70_part3').click(function() {
        $("#btn_add_more_defect_failures_70_part2").show();
        $(".defects70_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_70_part4').click(function() {
        $("#btn_add_more_defect_failures_70_part3").show();
        $(".defects70_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_70_part5').click(function() {
        $("#btn_add_more_defect_failures_70_part4").show();
        $(".defects70_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_71_part1').click(function() {
        $("#btn_add_more_defect_failures_71_part1").hide();
        $(".defects71_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_71_part2').click(function() {
        $("#btn_add_more_defect_failures_71_part2").hide();
        $(".defects71_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_71_part3').click(function() {
        $("#btn_add_more_defect_failures_71_part3").hide();
        $(".defects71_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_71_part4').click(function() {
        $("#btn_add_more_defect_failures_71_part4").hide();
        $(".defects71_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_71_part2').click(function() {
        $("#btn_add_more_defect_failures_71_part1").show();
        $(".defects71_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_71_part3').click(function() {
        $("#btn_add_more_defect_failures_71_part2").show();
        $(".defects71_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_71_part4').click(function() {
        $("#btn_add_more_defect_failures_71_part3").show();
        $(".defects71_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_71_part5').click(function() {
        $("#btn_add_more_defect_failures_71_part4").show();
        $(".defects71_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_72_part1').click(function() {
        $("#btn_add_more_defect_failures_72_part1").hide();
        $(".defects72_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_72_part2').click(function() {
        $("#btn_add_more_defect_failures_72_part2").hide();
        $(".defects72_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_72_part3').click(function() {
        $("#btn_add_more_defect_failures_72_part3").hide();
        $(".defects72_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_72_part4').click(function() {
        $("#btn_add_more_defect_failures_72_part4").hide();
        $(".defects72_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_72_part2').click(function() {
        $("#btn_add_more_defect_failures_72_part1").show();
        $(".defects72_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_72_part3').click(function() {
        $("#btn_add_more_defect_failures_72_part2").show();
        $(".defects72_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_72_part4').click(function() {
        $("#btn_add_more_defect_failures_72_part3").show();
        $(".defects72_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_72_part5').click(function() {
        $("#btn_add_more_defect_failures_72_part4").show();
        $(".defects72_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_73_part1').click(function() {
        $("#btn_add_more_defect_failures_73_part1").hide();
        $(".defects73_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_73_part2').click(function() {
        $("#btn_add_more_defect_failures_73_part2").hide();
        $(".defects73_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_73_part3').click(function() {
        $("#btn_add_more_defect_failures_73_part3").hide();
        $(".defects73_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_73_part4').click(function() {
        $("#btn_add_more_defect_failures_73_part4").hide();
        $(".defects73_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_73_part2').click(function() {
        $("#btn_add_more_defect_failures_73_part1").show();
        $(".defects73_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_73_part3').click(function() {
        $("#btn_add_more_defect_failures_73_part2").show();
        $(".defects73_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_73_part4').click(function() {
        $("#btn_add_more_defect_failures_73_part3").show();
        $(".defects73_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_73_part5').click(function() {
        $("#btn_add_more_defect_failures_73_part4").show();
        $(".defects73_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_74_part1').click(function() {
        $("#btn_add_more_defect_failures_74_part1").hide();
        $(".defects74_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_74_part2').click(function() {
        $("#btn_add_more_defect_failures_74_part2").hide();
        $(".defects74_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_74_part3').click(function() {
        $("#btn_add_more_defect_failures_74_part3").hide();
        $(".defects74_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_74_part4').click(function() {
        $("#btn_add_more_defect_failures_74_part4").hide();
        $(".defects74_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_74_part2').click(function() {
        $("#btn_add_more_defect_failures_74_part1").show();
        $(".defects74_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_74_part3').click(function() {
        $("#btn_add_more_defect_failures_74_part2").show();
        $(".defects74_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_74_part4').click(function() {
        $("#btn_add_more_defect_failures_74_part3").show();
        $(".defects74_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_74_part5').click(function() {
        $("#btn_add_more_defect_failures_74_part4").show();
        $(".defects74_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_75_part1').click(function() {
        $("#btn_add_more_defect_failures_75_part1").hide();
        $(".defects75_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_75_part2').click(function() {
        $("#btn_add_more_defect_failures_75_part2").hide();
        $(".defects75_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_75_part3').click(function() {
        $("#btn_add_more_defect_failures_75_part3").hide();
        $(".defects75_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_75_part4').click(function() {
        $("#btn_add_more_defect_failures_75_part4").hide();
        $(".defects75_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_75_part2').click(function() {
        $("#btn_add_more_defect_failures_75_part1").show();
        $(".defects75_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_75_part3').click(function() {
        $("#btn_add_more_defect_failures_75_part2").show();
        $(".defects75_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_75_part4').click(function() {
        $("#btn_add_more_defect_failures_75_part3").show();
        $(".defects75_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_75_part5').click(function() {
        $("#btn_add_more_defect_failures_75_part4").show();
        $(".defects75_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_76_part1').click(function() {
        $("#btn_add_more_defect_failures_76_part1").hide();
        $(".defects76_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_76_part2').click(function() {
        $("#btn_add_more_defect_failures_76_part2").hide();
        $(".defects76_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_76_part3').click(function() {
        $("#btn_add_more_defect_failures_76_part3").hide();
        $(".defects76_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_76_part4').click(function() {
        $("#btn_add_more_defect_failures_76_part4").hide();
        $(".defects76_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_76_part2').click(function() {
        $("#btn_add_more_defect_failures_76_part1").show();
        $(".defects76_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_76_part3').click(function() {
        $("#btn_add_more_defect_failures_76_part2").show();
        $(".defects76_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_76_part4').click(function() {
        $("#btn_add_more_defect_failures_76_part3").show();
        $(".defects76_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_76_part5').click(function() {
        $("#btn_add_more_defect_failures_76_part4").show();
        $(".defects76_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_77_part1').click(function() {
        $("#btn_add_more_defect_failures_77_part1").hide();
        $(".defects77_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_77_part2').click(function() {
        $("#btn_add_more_defect_failures_77_part2").hide();
        $(".defects77_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_77_part3').click(function() {
        $("#btn_add_more_defect_failures_77_part3").hide();
        $(".defects77_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_77_part4').click(function() {
        $("#btn_add_more_defect_failures_77_part4").hide();
        $(".defects77_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_77_part2').click(function() {
        $("#btn_add_more_defect_failures_77_part1").show();
        $(".defects77_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_77_part3').click(function() {
        $("#btn_add_more_defect_failures_77_part2").show();
        $(".defects77_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_77_part4').click(function() {
        $("#btn_add_more_defect_failures_77_part3").show();
        $(".defects77_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_77_part5').click(function() {
        $("#btn_add_more_defect_failures_77_part4").show();
        $(".defects77_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_78_part1').click(function() {
        $("#btn_add_more_defect_failures_78_part1").hide();
        $(".defects78_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_78_part2').click(function() {
        $("#btn_add_more_defect_failures_78_part2").hide();
        $(".defects78_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_78_part3').click(function() {
        $("#btn_add_more_defect_failures_78_part3").hide();
        $(".defects78_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_78_part4').click(function() {
        $("#btn_add_more_defect_failures_78_part4").hide();
        $(".defects78_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_78_part2').click(function() {
        $("#btn_add_more_defect_failures_78_part1").show();
        $(".defects78_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_78_part3').click(function() {
        $("#btn_add_more_defect_failures_78_part2").show();
        $(".defects78_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_78_part4').click(function() {
        $("#btn_add_more_defect_failures_78_part3").show();
        $(".defects78_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_78_part5').click(function() {
        $("#btn_add_more_defect_failures_78_part4").show();
        $(".defects78_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_79_part1').click(function() {
        $("#btn_add_more_defect_failures_79_part1").hide();
        $(".defects79_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_79_part2').click(function() {
        $("#btn_add_more_defect_failures_79_part2").hide();
        $(".defects79_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_79_part3').click(function() {
        $("#btn_add_more_defect_failures_79_part3").hide();
        $(".defects79_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_79_part4').click(function() {
        $("#btn_add_more_defect_failures_79_part4").hide();
        $(".defects79_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_79_part2').click(function() {
        $("#btn_add_more_defect_failures_79_part1").show();
        $(".defects79_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_79_part3').click(function() {
        $("#btn_add_more_defect_failures_79_part2").show();
        $(".defects79_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_79_part4').click(function() {
        $("#btn_add_more_defect_failures_79_part3").show();
        $(".defects79_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_79_part5').click(function() {
        $("#btn_add_more_defect_failures_79_part4").show();
        $(".defects79_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_80_part1').click(function() {
        $("#btn_add_more_defect_failures_80_part1").hide();
        $(".defects80_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_80_part2').click(function() {
        $("#btn_add_more_defect_failures_80_part2").hide();
        $(".defects80_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_80_part3').click(function() {
        $("#btn_add_more_defect_failures_80_part3").hide();
        $(".defects80_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_80_part4').click(function() {
        $("#btn_add_more_defect_failures_80_part4").hide();
        $(".defects80_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_80_part2').click(function() {
        $("#btn_add_more_defect_failures_80_part1").show();
        $(".defects80_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_80_part3').click(function() {
        $("#btn_add_more_defect_failures_80_part2").show();
        $(".defects80_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_80_part4').click(function() {
        $("#btn_add_more_defect_failures_80_part3").show();
        $(".defects80_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_80_part5').click(function() {
        $("#btn_add_more_defect_failures_80_part4").show();
        $(".defects80_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_81_part1').click(function() {
        $("#btn_add_more_defect_failures_81_part1").hide();
        $(".defects81_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_81_part2').click(function() {
        $("#btn_add_more_defect_failures_81_part2").hide();
        $(".defects81_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_81_part3').click(function() {
        $("#btn_add_more_defect_failures_81_part3").hide();
        $(".defects81_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_81_part4').click(function() {
        $("#btn_add_more_defect_failures_81_part4").hide();
        $(".defects81_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_81_part2').click(function() {
        $("#btn_add_more_defect_failures_81_part1").show();
        $(".defects81_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_81_part3').click(function() {
        $("#btn_add_more_defect_failures_81_part2").show();
        $(".defects81_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_81_part4').click(function() {
        $("#btn_add_more_defect_failures_81_part3").show();
        $(".defects81_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_81_part5').click(function() {
        $("#btn_add_more_defect_failures_81_part4").show();
        $(".defects81_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_82_part1').click(function() {
        $("#btn_add_more_defect_failures_82_part1").hide();
        $(".defects82_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_82_part2').click(function() {
        $("#btn_add_more_defect_failures_82_part2").hide();
        $(".defects82_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_82_part3').click(function() {
        $("#btn_add_more_defect_failures_82_part3").hide();
        $(".defects82_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_82_part4').click(function() {
        $("#btn_add_more_defect_failures_82_part4").hide();
        $(".defects82_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_82_part2').click(function() {
        $("#btn_add_more_defect_failures_82_part1").show();
        $(".defects82_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_82_part3').click(function() {
        $("#btn_add_more_defect_failures_82_part2").show();
        $(".defects82_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_82_part4').click(function() {
        $("#btn_add_more_defect_failures_82_part3").show();
        $(".defects82_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_82_part5').click(function() {
        $("#btn_add_more_defect_failures_82_part4").show();
        $(".defects82_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_83_part1').click(function() {
        $("#btn_add_more_defect_failures_83_part1").hide();
        $(".defects83_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_83_part2').click(function() {
        $("#btn_add_more_defect_failures_83_part2").hide();
        $(".defects83_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_83_part3').click(function() {
        $("#btn_add_more_defect_failures_83_part3").hide();
        $(".defects83_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_83_part4').click(function() {
        $("#btn_add_more_defect_failures_83_part4").hide();
        $(".defects83_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_83_part2').click(function() {
        $("#btn_add_more_defect_failures_83_part1").show();
        $(".defects83_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_83_part3').click(function() {
        $("#btn_add_more_defect_failures_83_part2").show();
        $(".defects83_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_83_part4').click(function() {
        $("#btn_add_more_defect_failures_83_part3").show();
        $(".defects83_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_83_part5').click(function() {
        $("#btn_add_more_defect_failures_83_part4").show();
        $(".defects83_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_84_part1').click(function() {
        $("#btn_add_more_defect_failures_84_part1").hide();
        $(".defects84_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_84_part2').click(function() {
        $("#btn_add_more_defect_failures_84_part2").hide();
        $(".defects84_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_84_part3').click(function() {
        $("#btn_add_more_defect_failures_84_part3").hide();
        $(".defects84_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_84_part4').click(function() {
        $("#btn_add_more_defect_failures_84_part4").hide();
        $(".defects84_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_84_part2').click(function() {
        $("#btn_add_more_defect_failures_84_part1").show();
        $(".defects84_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_84_part3').click(function() {
        $("#btn_add_more_defect_failures_84_part2").show();
        $(".defects84_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_84_part4').click(function() {
        $("#btn_add_more_defect_failures_84_part3").show();
        $(".defects84_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_84_part5').click(function() {
        $("#btn_add_more_defect_failures_84_part4").show();
        $(".defects84_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_85_part1').click(function() {
        $("#btn_add_more_defect_failures_85_part1").hide();
        $(".defects85_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_85_part2').click(function() {
        $("#btn_add_more_defect_failures_85_part2").hide();
        $(".defects85_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_85_part3').click(function() {
        $("#btn_add_more_defect_failures_85_part3").hide();
        $(".defects85_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_85_part4').click(function() {
        $("#btn_add_more_defect_failures_85_part4").hide();
        $(".defects85_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_85_part2').click(function() {
        $("#btn_add_more_defect_failures_85_part1").show();
        $(".defects85_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_85_part3').click(function() {
        $("#btn_add_more_defect_failures_85_part2").show();
        $(".defects85_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_85_part4').click(function() {
        $("#btn_add_more_defect_failures_85_part3").show();
        $(".defects85_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_85_part5').click(function() {
        $("#btn_add_more_defect_failures_85_part4").show();
        $(".defects85_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_86_part1').click(function() {
        $("#btn_add_more_defect_failures_86_part1").hide();
        $(".defects86_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_86_part2').click(function() {
        $("#btn_add_more_defect_failures_86_part2").hide();
        $(".defects86_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_86_part3').click(function() {
        $("#btn_add_more_defect_failures_86_part3").hide();
        $(".defects86_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_86_part4').click(function() {
        $("#btn_add_more_defect_failures_86_part4").hide();
        $(".defects86_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_86_part2').click(function() {
        $("#btn_add_more_defect_failures_86_part1").show();
        $(".defects86_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_86_part3').click(function() {
        $("#btn_add_more_defect_failures_86_part2").show();
        $(".defects86_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_86_part4').click(function() {
        $("#btn_add_more_defect_failures_86_part3").show();
        $(".defects86_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_86_part5').click(function() {
        $("#btn_add_more_defect_failures_86_part4").show();
        $(".defects86_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_87_part1').click(function() {
        $("#btn_add_more_defect_failures_87_part1").hide();
        $(".defects87_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_87_part2').click(function() {
        $("#btn_add_more_defect_failures_87_part2").hide();
        $(".defects87_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_87_part3').click(function() {
        $("#btn_add_more_defect_failures_87_part3").hide();
        $(".defects87_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_87_part4').click(function() {
        $("#btn_add_more_defect_failures_87_part4").hide();
        $(".defects87_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_87_part2').click(function() {
        $("#btn_add_more_defect_failures_87_part1").show();
        $(".defects87_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_87_part3').click(function() {
        $("#btn_add_more_defect_failures_87_part2").show();
        $(".defects87_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_87_part4').click(function() {
        $("#btn_add_more_defect_failures_87_part3").show();
        $(".defects87_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_87_part5').click(function() {
        $("#btn_add_more_defect_failures_87_part4").show();
        $(".defects87_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_88_part1').click(function() {
        $("#btn_add_more_defect_failures_88_part1").hide();
        $(".defects88_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_88_part2').click(function() {
        $("#btn_add_more_defect_failures_88_part2").hide();
        $(".defects88_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_88_part3').click(function() {
        $("#btn_add_more_defect_failures_88_part3").hide();
        $(".defects88_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_88_part4').click(function() {
        $("#btn_add_more_defect_failures_88_part4").hide();
        $(".defects88_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_88_part2').click(function() {
        $("#btn_add_more_defect_failures_88_part1").show();
        $(".defects88_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_88_part3').click(function() {
        $("#btn_add_more_defect_failures_88_part2").show();
        $(".defects88_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_88_part4').click(function() {
        $("#btn_add_more_defect_failures_88_part3").show();
        $(".defects88_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_88_part5').click(function() {
        $("#btn_add_more_defect_failures_88_part4").show();
        $(".defects88_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_89_part1').click(function() {
        $("#btn_add_more_defect_failures_89_part1").hide();
        $(".defects89_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_89_part2').click(function() {
        $("#btn_add_more_defect_failures_89_part2").hide();
        $(".defects89_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_89_part3').click(function() {
        $("#btn_add_more_defect_failures_89_part3").hide();
        $(".defects89_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_89_part4').click(function() {
        $("#btn_add_more_defect_failures_89_part4").hide();
        $(".defects89_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_89_part2').click(function() {
        $("#btn_add_more_defect_failures_89_part1").show();
        $(".defects89_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_89_part3').click(function() {
        $("#btn_add_more_defect_failures_89_part2").show();
        $(".defects89_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_89_part4').click(function() {
        $("#btn_add_more_defect_failures_89_part3").show();
        $(".defects89_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_89_part5').click(function() {
        $("#btn_add_more_defect_failures_89_part4").show();
        $(".defects89_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_90_part1').click(function() {
        $("#btn_add_more_defect_failures_90_part1").hide();
        $(".defects90_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_90_part2').click(function() {
        $("#btn_add_more_defect_failures_90_part2").hide();
        $(".defects90_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_90_part3').click(function() {
        $("#btn_add_more_defect_failures_90_part3").hide();
        $(".defects90_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_90_part4').click(function() {
        $("#btn_add_more_defect_failures_90_part4").hide();
        $(".defects90_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_90_part2').click(function() {
        $("#btn_add_more_defect_failures_90_part1").show();
        $(".defects90_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_90_part3').click(function() {
        $("#btn_add_more_defect_failures_90_part2").show();
        $(".defects90_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_90_part4').click(function() {
        $("#btn_add_more_defect_failures_90_part3").show();
        $(".defects90_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_90_part5').click(function() {
        $("#btn_add_more_defect_failures_90_part4").show();
        $(".defects90_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_91_part1').click(function() {
        $("#btn_add_more_defect_failures_91_part1").hide();
        $(".defects91_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_91_part2').click(function() {
        $("#btn_add_more_defect_failures_91_part2").hide();
        $(".defects91_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_91_part3').click(function() {
        $("#btn_add_more_defect_failures_91_part3").hide();
        $(".defects91_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_91_part4').click(function() {
        $("#btn_add_more_defect_failures_91_part4").hide();
        $(".defects91_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_91_part2').click(function() {
        $("#btn_add_more_defect_failures_91_part1").show();
        $(".defects91_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_91_part3').click(function() {
        $("#btn_add_more_defect_failures_91_part2").show();
        $(".defects91_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_91_part4').click(function() {
        $("#btn_add_more_defect_failures_91_part3").show();
        $(".defects91_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_91_part5').click(function() {
        $("#btn_add_more_defect_failures_91_part4").show();
        $(".defects91_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_92_part1').click(function() {
        $("#btn_add_more_defect_failures_92_part1").hide();
        $(".defects92_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_92_part2').click(function() {
        $("#btn_add_more_defect_failures_92_part2").hide();
        $(".defects92_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_92_part3').click(function() {
        $("#btn_add_more_defect_failures_92_part3").hide();
        $(".defects92_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_92_part4').click(function() {
        $("#btn_add_more_defect_failures_92_part4").hide();
        $(".defects92_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_92_part2').click(function() {
        $("#btn_add_more_defect_failures_92_part1").show();
        $(".defects92_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_92_part3').click(function() {
        $("#btn_add_more_defect_failures_92_part2").show();
        $(".defects92_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_92_part4').click(function() {
        $("#btn_add_more_defect_failures_92_part3").show();
        $(".defects92_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_92_part5').click(function() {
        $("#btn_add_more_defect_failures_92_part4").show();
        $(".defects92_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_93_part1').click(function() {
        $("#btn_add_more_defect_failures_93_part1").hide();
        $(".defects93_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_93_part2').click(function() {
        $("#btn_add_more_defect_failures_93_part2").hide();
        $(".defects93_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_93_part3').click(function() {
        $("#btn_add_more_defect_failures_93_part3").hide();
        $(".defects93_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_93_part4').click(function() {
        $("#btn_add_more_defect_failures_93_part4").hide();
        $(".defects93_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_93_part2').click(function() {
        $("#btn_add_more_defect_failures_93_part1").show();
        $(".defects93_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_93_part3').click(function() {
        $("#btn_add_more_defect_failures_93_part2").show();
        $(".defects93_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_93_part4').click(function() {
        $("#btn_add_more_defect_failures_93_part3").show();
        $(".defects93_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_93_part5').click(function() {
        $("#btn_add_more_defect_failures_93_part4").show();
        $(".defects93_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_94_part1').click(function() {
        $("#btn_add_more_defect_failures_94_part1").hide();
        $(".defects94_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_94_part2').click(function() {
        $("#btn_add_more_defect_failures_94_part2").hide();
        $(".defects94_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_94_part3').click(function() {
        $("#btn_add_more_defect_failures_94_part3").hide();
        $(".defects94_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_94_part4').click(function() {
        $("#btn_add_more_defect_failures_94_part4").hide();
        $(".defects94_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_94_part2').click(function() {
        $("#btn_add_more_defect_failures_94_part1").show();
        $(".defects94_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_94_part3').click(function() {
        $("#btn_add_more_defect_failures_94_part2").show();
        $(".defects94_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_94_part4').click(function() {
        $("#btn_add_more_defect_failures_94_part3").show();
        $(".defects94_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_94_part5').click(function() {
        $("#btn_add_more_defect_failures_94_part4").show();
        $(".defects94_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_95_part1').click(function() {
        $("#btn_add_more_defect_failures_95_part1").hide();
        $(".defects95_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_95_part2').click(function() {
        $("#btn_add_more_defect_failures_95_part2").hide();
        $(".defects95_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_95_part3').click(function() {
        $("#btn_add_more_defect_failures_95_part3").hide();
        $(".defects95_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_95_part4').click(function() {
        $("#btn_add_more_defect_failures_95_part4").hide();
        $(".defects95_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_95_part2').click(function() {
        $("#btn_add_more_defect_failures_95_part1").show();
        $(".defects95_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_95_part3').click(function() {
        $("#btn_add_more_defect_failures_95_part2").show();
        $(".defects95_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_95_part4').click(function() {
        $("#btn_add_more_defect_failures_95_part3").show();
        $(".defects95_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_95_part5').click(function() {
        $("#btn_add_more_defect_failures_95_part4").show();
        $(".defects95_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_96_part1').click(function() {
        $("#btn_add_more_defect_failures_96_part1").hide();
        $(".defects96_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_96_part2').click(function() {
        $("#btn_add_more_defect_failures_96_part2").hide();
        $(".defects96_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_96_part3').click(function() {
        $("#btn_add_more_defect_failures_96_part3").hide();
        $(".defects96_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_96_part4').click(function() {
        $("#btn_add_more_defect_failures_96_part4").hide();
        $(".defects96_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_96_part2').click(function() {
        $("#btn_add_more_defect_failures_96_part1").show();
        $(".defects96_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_96_part3').click(function() {
        $("#btn_add_more_defect_failures_96_part2").show();
        $(".defects96_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_96_part4').click(function() {
        $("#btn_add_more_defect_failures_96_part3").show();
        $(".defects96_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_96_part5').click(function() {
        $("#btn_add_more_defect_failures_96_part4").show();
        $(".defects96_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_97_part1').click(function() {
        $("#btn_add_more_defect_failures_97_part1").hide();
        $(".defects97_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_97_part2').click(function() {
        $("#btn_add_more_defect_failures_97_part2").hide();
        $(".defects97_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_97_part3').click(function() {
        $("#btn_add_more_defect_failures_97_part3").hide();
        $(".defects97_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_97_part4').click(function() {
        $("#btn_add_more_defect_failures_97_part4").hide();
        $(".defects97_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_97_part2').click(function() {
        $("#btn_add_more_defect_failures_97_part1").show();
        $(".defects97_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_97_part3').click(function() {
        $("#btn_add_more_defect_failures_97_part2").show();
        $(".defects97_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_97_part4').click(function() {
        $("#btn_add_more_defect_failures_97_part3").show();
        $(".defects97_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_97_part5').click(function() {
        $("#btn_add_more_defect_failures_97_part4").show();
        $(".defects97_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_98_part1').click(function() {
        $("#btn_add_more_defect_failures_98_part1").hide();
        $(".defects98_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_98_part2').click(function() {
        $("#btn_add_more_defect_failures_98_part2").hide();
        $(".defects98_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_98_part3').click(function() {
        $("#btn_add_more_defect_failures_98_part3").hide();
        $(".defects98_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_98_part4').click(function() {
        $("#btn_add_more_defect_failures_98_part4").hide();
        $(".defects98_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_98_part2').click(function() {
        $("#btn_add_more_defect_failures_98_part1").show();
        $(".defects98_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_98_part3').click(function() {
        $("#btn_add_more_defect_failures_98_part2").show();
        $(".defects98_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_98_part4').click(function() {
        $("#btn_add_more_defect_failures_98_part3").show();
        $(".defects98_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_98_part5').click(function() {
        $("#btn_add_more_defect_failures_98_part4").show();
        $(".defects98_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_99_part1').click(function() {
        $("#btn_add_more_defect_failures_99_part1").hide();
        $(".defects99_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_99_part2').click(function() {
        $("#btn_add_more_defect_failures_99_part2").hide();
        $(".defects99_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_99_part3').click(function() {
        $("#btn_add_more_defect_failures_99_part3").hide();
        $(".defects99_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_99_part4').click(function() {
        $("#btn_add_more_defect_failures_99_part4").hide();
        $(".defects99_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_99_part2').click(function() {
        $("#btn_add_more_defect_failures_99_part1").show();
        $(".defects99_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_99_part3').click(function() {
        $("#btn_add_more_defect_failures_99_part2").show();
        $(".defects99_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_99_part4').click(function() {
        $("#btn_add_more_defect_failures_99_part3").show();
        $(".defects99_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_99_part5').click(function() {
        $("#btn_add_more_defect_failures_99_part4").show();
        $(".defects99_part5").attr("style", "display: none");
    });

    $('#btn_add_more_defect_failures_100_part1').click(function() {
        $("#btn_add_more_defect_failures_100_part1").hide();
        $(".defects100_part2").attr("style", "");
    });

    $('#btn_add_more_defect_failures_100_part2').click(function() {
        $("#btn_add_more_defect_failures_100_part2").hide();
        $(".defects100_part3").attr("style", "");
    });

    $('#btn_add_more_defect_failures_100_part3').click(function() {
        $("#btn_add_more_defect_failures_100_part3").hide();
        $(".defects100_part4").attr("style", "");
    });

    $('#btn_add_more_defect_failures_100_part4').click(function() {
        $("#btn_add_more_defect_failures_100_part4").hide();
        $(".defects100_part5").attr("style", "");
    });

    $('.remove_more_defect_failures_100_part2').click(function() {
        $("#btn_add_more_defect_failures_100_part1").show();
        $(".defects100_part2").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_100_part3').click(function() {
        $("#btn_add_more_defect_failures_100_part2").show();
        $(".defects100_part3").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_100_part4').click(function() {
        $("#btn_add_more_defect_failures_100_part3").show();
        $(".defects100_part4").attr("style", "display: none");
    });

    $('.remove_more_defect_failures_100_part5').click(function() {
        $("#btn_add_more_defect_failures_100_part4").show();
        $(".defects100_part5").attr("style", "display: none");
    });



});