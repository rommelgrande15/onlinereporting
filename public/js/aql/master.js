$(document).ready(function() {

    $('body').on('keyup', '.edit_aql_qty', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.EditAQLModal').find('.edit_aql_minor').val();
        var major = dis.closest('.EditAQLModal').find('.edit_aql_major').val();
        var lvl = dis.closest('.EditAQLModal').find('.edit_aql_normal_level').val();
        var special_lvl = dis.closest('.EditAQLModal').find('.edit_aql_special_level').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.EditAQLModal').find('.edit_max_major').val(majorMax);
        dis.closest('.EditAQLModal').find('.edit_max_minor').val(minorMax);
        dis.closest('.EditAQLModal').find('.edit_aql_normal_letter').val(letter);
        dis.closest('.EditAQLModal').find('.edit_aql_special_letter').val(special_letter);
        dis.closest('.EditAQLModal').find('.edit_aql_normal_sampsize').val(sampsize);
        dis.closest('.EditAQLModal').find('.edit_aql_special_sampsize').val(special_sampsize);
    });

    $('body').on('change', '.edit_aql_normal_level', function() {

        var dis = $(this);
        var batchSize = dis.closest('.EditAQLModal').find('.edit_aql_qty').val();
        var minor = dis.closest('.EditAQLModal').find('.edit_aql_minor').val();
        var major = dis.closest('.EditAQLModal').find('.edit_aql_major').val();
        var lvl = dis.val();




        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.EditAQLModal').find('.edit_max_major').val(majorMax);
        dis.closest('.EditAQLModal').find('.edit_max_minor').val(minorMax);
        dis.closest('.EditAQLModal').find('.edit_aql_normal_letter').val(letter);
        dis.closest('.EditAQLModal').find('.edit_aql_normal_sampsize').val(sampsize);
    });

    $('body').on('change', '.edit_aql_special_level', function() {
        var dis = $(this);
        var batchSize = dis.closest('.EditAQLModal').find('.edit_aql_qty').val();
        var minor = dis.closest('.EditAQLModal').find('.edit_aql_minor').val();
        var major = dis.closest('.EditAQLModal').find('.edit_aql_major').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.EditAQLModal').find('.edit_aql_special_letter').val(letter);
        dis.closest('.EditAQLModal').find('.edit_aql_special_sampsize').val(sampsize);
    });

    $('body').on('change', '.edit_aql_major', function() {
        var dis = $(this);
        var batchSize = dis.closest('.EditAQLModal').find('.edit_aql_qty').val();
        var minor = dis.closest('.EditAQLModal').find('.edit_aql_minor').val();
        var major = dis.val();
        var lvl = dis.closest('.EditAQLModal').find('.edit_aql_normal_level').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.EditAQLModal').find('.edit_max_major').val(majorMax);
        dis.closest('.EditAQLModal').find('.edit_max_minor').val(minorMax);
        dis.closest('.EditAQLModal').find('.edit_aql_normal_letter').val(letter);
        dis.closest('.EditAQLModal').find('.edit_aql_normal_sampsize').val(sampsize);
    });

    $('body').on('change', '.edit_aql_minor', function() {
        var dis = $(this);
        var batchSize = dis.closest('.EditAQLModal').find('.edit_aql_qty').val();
        var major = dis.closest('.EditAQLModal').find('.edit_aql_major').val();
        var minor = dis.val();
        var lvl = dis.closest('.EditAQLModal').find('.edit_aql_normal_level').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.EditAQLModal').find('.edit_max_major').val(majorMax);
        dis.closest('.EditAQLModal').find('.edit_max_minor').val(minorMax);
        dis.closest('.EditAQLModal').find('.edit_aql_normal_letter').val(letter);
        dis.closest('.EditAQLModal').find('.edit_aql_normal_sampsize').val(sampsize);
    });


    $('body').on('keyup', '.new_edit_aql_qty', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.EditAQLModal').find('.new_edit_aql_minor').val();
        var major = dis.closest('.EditAQLModal').find('.new_edit_aql_major').val();
        var lvl = dis.closest('.EditAQLModal').find('.new_edit_aql_normal_level').val();
        var special_lvl = dis.closest('.EditAQLModal').find('.new_edit_aql_special_level').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.EditAQLModal').find('.new_edit_max_major').val(majorMax);
        dis.closest('.EditAQLModal').find('.new_edit_max_minor').val(minorMax);
        dis.closest('.EditAQLModal').find('.new_edit_aql_normal_letter').val(letter);
        dis.closest('.EditAQLModal').find('.new_edit_aql_special_letter').val(special_letter);
        dis.closest('.EditAQLModal').find('.new_edit_aql_normal_sampsize').val(sampsize);
        dis.closest('.EditAQLModal').find('.new_edit_aql_special_sampsize').val(special_sampsize);
    });

    $('body').on('change', '.new_edit_aql_normal_level', function() {

        var dis = $(this);
        var batchSize = dis.closest('.EditAQLModal').find('.new_edit_aql_qty').val();
        var minor = dis.closest('.EditAQLModal').find('.new_edit_aql_minor').val();
        var major = dis.closest('.EditAQLModal').find('.new_edit_aql_major').val();
        var lvl = dis.val();




        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.EditAQLModal').find('.new_edit_max_major').val(majorMax);
        dis.closest('.EditAQLModal').find('.new_edit_max_minor').val(minorMax);
        dis.closest('.EditAQLModal').find('.new_edit_aql_normal_letter').val(letter);
        dis.closest('.EditAQLModal').find('.new_edit_aql_normal_sampsize').val(sampsize);
    });

    $('body').on('change', '.new_edit_aql_special_level', function() {
        var dis = $(this);
        var batchSize = dis.closest('.EditAQLModal').find('.new_edit_aql_qty').val();
        var minor = dis.closest('.EditAQLModal').find('.new_edit_aql_minor').val();
        var major = dis.closest('.EditAQLModal').find('.new_edit_aql_major').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.EditAQLModal').find('.new_edit_aql_special_letter').val(letter);
        dis.closest('.EditAQLModal').find('.new_edit_aql_special_sampsize').val(sampsize);
    });

    $('body').on('change', '.new_edit_aql_major', function() {
        var dis = $(this);
        var batchSize = dis.closest('.EditAQLModal').find('.new_edit_aql_qty').val();
        var minor = dis.closest('.EditAQLModal').find('.new_edit_aql_minor').val();
        var major = dis.val();
        var lvl = dis.closest('.EditAQLModal').find('.new_edit_aql_normal_level').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.EditAQLModal').find('.new_edit_max_major').val(majorMax);
        dis.closest('.EditAQLModal').find('.new_edit_max_minor').val(minorMax);
        dis.closest('.EditAQLModal').find('.new_edit_aql_normal_letter').val(letter);
        dis.closest('.EditAQLModal').find('.new_edit_aql_normal_sampsize').val(sampsize);
    });

    $('body').on('change', '.new_edit_aql_minor', function() {
        var dis = $(this);
        var batchSize = dis.closest('.EditAQLModal').find('.new_edit_aql_qty').val();
        var major = dis.closest('.EditAQLModal').find('.new_edit_aql_major').val();
        var minor = dis.val();
        var lvl = dis.closest('.EditAQLModal').find('.new_edit_aql_normal_level').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.EditAQLModal').find('.new_edit_max_major').val(majorMax);
        dis.closest('.EditAQLModal').find('.new_edit_max_minor').val(minorMax);
        dis.closest('.EditAQLModal').find('.new_edit_aql_normal_letter').val(letter);
        dis.closest('.EditAQLModal').find('.new_edit_aql_normal_sampsize').val(sampsize);
    });
});