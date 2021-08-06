$(document).ready(function() {


    /**
     * Apply the same filter to all DataTable instances on a particular page. The
     * function call exactly matches that used by `fnFilter()` so regular expression
     * and individual column sorting can be used.
     *
     * DataTables 1.10+ provides this ability through its new API, which is able to
     * to control multiple tables at a time.
     * `$('.dataTable').DataTable().search( ... )` for example will apply the same
     * filter to all tables on the page. The new API should be used in preference
     * to this older method if at all possible.
     *
     *  @name fnFilterAll
     *  @summary Apply a common filter to all DataTables on a page
     *  @author [Kristoffer Karlström](http://www.kmmtiming.se/)
     *  @deprecated
     *
     *  @param {string} sInput Filtering input
     *  @param {integer} [iColumn=null] Column to apply the filter to
     *  @param {boolean} [bRegex] Regular expression flag
     *  @param {boolean} [bSmart] Smart filtering flag
     *
     *  @example
     *    $(document).ready(function() {
     *      var table = $(".dataTable").dataTable();
     *       
     *      $("#search").keyup( function () {
     *        // Filter on the column (the index) of this element
     *        table.fnFilterAll(this.value);
     *      } );
     *    });
     */

    jQuery.fn.dataTableExt.oApi.fnFilterAll = function(oSettings, sInput, iColumn, bRegex, bSmart) {
        var settings = $.fn.dataTableSettings;

        for (var i = 0; i < settings.length; i++) {
            settings[i].oInstance.fnFilter(sInput, iColumn, bRegex, bSmart);
        }
    };
    /*  $('#inspections_table').DataTable({
         "order": [
             [6, "desc"]
         ],
         "pageLength": 30
     }); */


    var oTable = $('#inspections_table').dataTable({
        "oLanguage": {
            "sSearch": "Search all columns:"
        },
        "order": [
            [4, "desc"]
        ],
        "pageLength": 30
    });

    $('select#engines').change(function() {
        oTable.fnFilter($(this).val());

    });

    var services = {
        'iqi': 'Incoming Quality Inspection',
        'dupro': 'During Production Inspection',
        'psi': 'Pre Shipment Inspection',
        'cli': 'Container Loading Inspection',
    };

    $('body')
        .on('click', '#btn-edit-contact', function() {
            var dis = this;
            var id = $(dis).data('id');


            $.ajax({
                url: '/update-contact-person',
                type: 'POST',
                data: {
                    _token: token,
                    id: id
                },
                success: function(response) {
                    //$('#hidden_cid').val(id);

                    $('#contact_id').val(response.client[0].id);
                    $('#contact_name').val(response.client[0].contact_person);
                    $('#contact_email').val(response.client[0].email_address);
                    $('#contact_tel').val(response.client[0].tel_number);
                    $('#contact_mobile').val(response.client[0].contact_number);
                    $('#contact_skype').val(response.client[0].client_skype);
                    $('#contact_wechat').val(response.client[0].client_wechat);
                    $('#contact_whatsapp').val(response.client[0].client_whatsapp);
                    $('#contact_qq').val(response.client[0].client_qqmail);
                    $('#edit_report_notify').first().val(response.client[0].report_notify);
                    $('#modalContactPerson').modal('show');

                },
                error: function(err) {
                    console.log(err);
                }
            })
        })

    .on('click', '.btn-edit-supplier', function() {
        var dis = this;

        var id = $(dis).data('id');
        $.ajax({
            url: '/update-supplier-contact',
            type: 'POST',
            data: {
                _token: token,
                id: id
            },
            success: function(response) {
                //$('#hidden_cid').val(id);

                $('#supplier_contact_id').val(response.supplier_contact[0].id);
                $('#supplier_contact_person').val(response.supplier_contact[0].supplier_contact_person);
                $('#supplier_contact_number').val(response.supplier_contact[0].supplier_contact_number);
                $('#supplier_tel_number').val(response.supplier_contact[0].supplier_tel_number);
                $('#supplier_contact_email').val(response.supplier_contact[0].supplier_email);
                $('#supplier_contact_skype').val(response.supplier_contact[0].supplier_contact_skype);
                $('#supplier_contact_wechat').val(response.supplier_contact[0].supplier_contact_wechat);
                $('#supplier_contact_whatsapp').val(response.supplier_contact[0].supplier_contact_whatsapp);
                $('#supplier_contact_qq').val(response.supplier_contact[0].supplier_contact_qq);
                // $('#contact_tel').val(response.client[0].tel_number);
                // $('#contact_mobile').val(response.client[0].contact_number);
                // $('#contact_skype').val(response.client[0].client_skype);
                // $('#contact_wechat').val(response.client[0].client_wechat);
                // $('#contact_whatsapp').val(response.client[0].client_whatsapp);
                // $('#contact_qq').val(response.client[0].client_qqmail);
                // $('#edit_report_notify').first().val(response.client[0].report_notify);
                $('#modalSupplierContactPerson').modal('show');

            },
            error: function(err) {
                console.log(err);
            }
        })
    })

    .on('click', '#btn-delete-supplier', function() {
        var dis = this;
        var id = $(dis).data('delete_id');


        $.ajax({
            url: '/delete-supplier-contact',
            type: 'POST',
            data: {
                _token: token,
                id: id
            },
            success: function(response) {
                //$('#hidden_cid').val(id);

                $('#delete_suppliercontact_id').val(response.supplier_contact[0].id);
                $('#delete_suppliercontact_name').html(response.supplier_contact[0].supplier_contact_person);
                $('#modalDeleteSupplierContactPerson').modal('show');

            },
            error: function(err) {
                console.log(err);
            }
        })
    })

    .on('click', '#btn-delete-contact', function() {
        var dis = this;
        var id = $(dis).data('delete_id');


        $.ajax({
            url: '/delete-contact-person',
            type: 'POST',
            data: {
                _token: token,
                id: id
            },
            success: function(response) {
                //$('#hidden_cid').val(id);

                $('#delete_contact_id').val(response.client[0].id);
                $('#delete_contact_name').html(response.client[0].contact_person);
                $('#modalDeleteSupplierContactPerson').modal('show');

            },
            error: function(err) {
                console.log(err);
            }
        })
    })


});