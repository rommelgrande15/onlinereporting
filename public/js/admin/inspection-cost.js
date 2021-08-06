$(document).ready(function() {
    $('body').on('click', '.btn-view-cost-client', function() {
        $('.send-loading').show();
        $.ajax({
            url: '/get-cost/' + $(this).data('id'),
            type: 'GET',
            success: function(response) {
                console.log(response);
                $('.proj_added_row').remove();
                //inspection details
                $('#table_view_project > tbody:last-child').append(
                    '<tr style="background-color:lightgrey" class="proj_added_row">' +
                    '<th colspan="4"><h4>1. Inspection Details</h4></th>' +
                    '</tr>' +
                    '<tr class="proj_added_row">' +
                    '<th>Reference Number :</th>' +
                    '<td>' + response.inspections.reference_number + '</td>' +
                    '<th>Project Number :</th>' +
                    '<td >' + response.inspections.client_project_number + '</td>' +
                    '</tr>' +
                    '<tr class="proj_added_row">' +
                    '<th>Service Type:</th>' +
                    '<td >' + response.inspections.service + '</td>' +
                    '<th>Inspection Date :</th>' +
                    '<td >' + response.inspections.inspection_date + '</td>' +
                    '</tr>');
                response.inspectors.forEach(element => {
                    $('#table_view_project > tbody:last-child').append(
                        '<tr class="proj_added_row">' +
                        '<th>Assigned Inspector :</th>' +
                        '<td  colspan="3">' + element.name + '</td>' +
                        '</tr>');
                });
                $('#table_view_project > tbody:last-child').append(
                    '<tr class="proj_added_row">' +
                    '<th>Manday :</th>' +
                    '<td  colspan="3">' + response.inspections.manday + '</td>' +
                    '</tr>');

                //client details
                $('#table_view_project > tbody:last-child').append(
                    '<tr style="background-color:lightgrey" class="proj_added_row">' +
                    '<th colspan="4"><h4>2. Client Details</h4></th>' +
                    '</tr>' +
                    '<tr class="proj_added_row">' +
                    '<th>Client Name :</th>' +
                    '<td >' + response.client.Company_Name + '</td>' +
                    '<th>Client Code :</th>' +
                    '<td >' + response.client.client_code + '</td>' +
                    '</tr>' +
                    '<tr class="proj_added_row">' +
                    '<th>Client Email :</th>' +
                    '<td >' + response.client.Company_Email + '</td>' +
                    '<th>Client Number :</th>' +
                    '<td >' + response.client.Phone_number + '</td>' +
                    '</tr>' +
                    '<tr class="proj_added_row">' +
                    '<th>Client Address :</th>' +
                    '<td  colspan="3">' + response.client.Company_Address + '</td>' +
                    '</tr>');

                //client cost
                var md = response.cost_details.md_charges;
                var travel = response.cost_details.travel_cost;
                var hotel = response.cost_details.hotel_cost;
                var ot = response.cost_details.ot_cost;
                var curr = response.cost_details.currency;

                $('#table_view_project > tbody:last-child').append(
                    '<tr style="background-color:lightgrey" class="proj_added_row">' +
                    '<th colspan="4"><h4>3. Cost Details</h4></th>' +
                    '</tr>' +
                    '<tr class="proj_added_row">' +
                    '<th>Currency :</th>' +
                    '<td colspan="3">' + curr.toUpperCase() + '</td>' +
                    '</tr>' +
                    '<tr class="proj_added_row">' +
                    '<th>Md Charges :</th>' +
                    '<td >' + md + '</td>' +
                    '<th>Travel Cost :</th>' +
                    '<td >' + travel + '</td>' +
                    '</tr>' +
                    '<tr class="proj_added_row">' +
                    '<th>Hotel Cost :</th>' +
                    '<td >' + hotel + '</td>' +
                    '<th>OT Cost :</th>' +
                    '<td >' + ot + '</td>' +
                    '</tr>');
                //other cost
                if (response.cost_details.other_cost_text) {
                    $('#table_view_project > tbody:last-child').append(
                        '<tr class="proj_added_row">' +
                        '<th colspan="4">Other Cost:</th>' +
                        '</tr>');
                    console.log('test');
                    var o_cost_text = response.cost_details.other_cost_text.split(",");
                    var o_cost_val = response.cost_details.other_cost_value.split(",");
                    console.log(o_cost_text);
                    var other_count = o_cost_text.length;
                    console.log(other_count);
                    for (var i = 0; i < other_count; i++) {
                        $('#table_view_project > tbody:last-child').append(
                            '<tr class="proj_added_row">' +
                            '<th colspan="2">' + o_cost_text[i] + '</th>' +
                            '<td colspan="2">' + o_cost_val[i] + '</td>' +
                            '</tr>');
                    }
                }

                //total cost
                $('#table_view_project > tbody:last-child').append(
                    '<tr class="proj_added_row">' +
                    '<th colspan="2">Total Cost :</th>' +
                    '<td colspan="2">' + response.total_cost + '</td>' +
                    '</tr>');

                $('.send-loading').hide();
                $('#viewClientCost').modal('show');
            }
        });

    });
})