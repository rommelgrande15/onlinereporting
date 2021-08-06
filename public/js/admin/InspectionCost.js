$(document).ready(function() {

    $('#InspectionCost_table').DataTable(

        {

            "order": [
                [4, "desc"]
            ]
        }


    );



    $('#InspectionCost_table2').DataTable(

        {

            "order": [
                [4, "desc"]
            ]
        }


    );

    $('body')
        .on('click', '.btn-view-cost-cli', function() {
            $('#viewClientCost').modal();
        })
})