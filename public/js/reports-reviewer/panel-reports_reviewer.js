//Dropzone.autoDiscover = false;
$(document).ready(function () {
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

    //.on('click', '#btn_view', function () {
    //			var dis = this;
    //			var id = $(dis).data('id');
    //			var service = $(dis).data('service');
    //			var factory = $(dis).data('fac');
    //			var date = $(dis).data('date');
    //			$('#cancel_service').text(service);
    //			$('#cancel_fac_name').text(factory);
    //			$('#cancel_ins_date').text(date);
    //			$('#cancel_ins_id').val(id);
    //$('#modalViewReport').modal('show');


    $('body').on('click', '#btn_select', function () {
        var dis = this;
        var inspection_id = $(dis).data('id');
        var client_code = $(dis).data('code');
        var ref_no = $(dis).data('ref_no');
        var project_no = $(dis).data('project_no');
        $("#report_status").prop('selectedIndex', 0)
        $.ajax({
            url: '/get-client-report/' + $(this).data('id'),
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                $('#inspection_id').val(inspection_id);
                $('#client_id').val(client_code);
                $('#ref_no').val(ref_no);
                $('#cc_email').val();
                $('.ref_no').text(ref_no + '-');
                $('#company_email').val(response.clients.Company_Email);
                $('#client_name').val(response.clients.client_name);
                var cc_emails = '';
                var count_email = response.client_contacts.length;
                $.each(response.client_contacts, function (i, item) {
                    if(item.email_address != 'N/A'){
                        if(count_email > 1){
                            cc_emails =  item.email_address + '; ' + cc_emails;
                        } else {
                            cc_emails =  item.email_address;
                        }
                        
                    }
                });
                
                var count_supplier_email = response.supplier_contacts.length;
                $.each(response.supplier_contacts, function (i, item) {
                    if (item.supplier_email != 'N/A') {
                        if (count_supplier_email > 1) {
                            cc_emails += item.supplier_email + '; ' + cc_emails;
                        } else {
                            cc_emails += item.supplier_email;
                        }
                    }
                });
                
                $('#cc_email').val(cc_emails);
                $('#modalSendReport').modal('show');
            },
            error: function (err) {
                console.log(err);
            }
        })
    })

    //Assign Reporter
    $('body').on('click', '.btn_assign', function () {
        var dis = this;
        var inspection_id = $(dis).data('id');
        var client_code = $(dis).data('code');
        var ref_no = $(dis).data('ref_no');
        var project_no = $(dis).data('project_no');
        $.ajax({
            url: '/get-client-report/' + $(this).data('id'),
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                $('#ins_id').val(inspection_id);
                //$('#client_id').val(client_code);
                $('#ref_n').val(ref_no);
                //$('#company_email').val(response.clients.Company_Email);
                $('#modalAssignReport').modal('show');
            },
            error: function (err) {
                console.log(err);
            }
        })
    })

    $('body').on('click', '#change-profile-pic', function () {
        $('#profile_pic_modal').modal('show');
    })

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    //$('.btn_view').click(function () {
    $('body').on('click', '.btn_view', function () {
        console.log('Button View Clicked');
        var table = $("#table_report_content");
        var tableString = "";
        table.empty();
        var dis = this;
        var id = $(dis).data('id');
        var ref_no = $(dis).data('ref_no');
        $.ajax({
            url: "/view-uploaded-report",
            method: "POST",
            data: {
                id: id
            },
            success: function (data) {
                if (data == "") {
                    swal({
                        position: 'top-end',
                        type: 'error',
                        title: 'No file/s found.',
                        showConfirmButton: true,
                        timer: 1000
                    });
                } else {
                    $('#ref_number').html(ref_no);
                    //$('#download_button').html("<a href='/download-report-file/" + id + "' class='btn btn-sm btn-primary pull-right' download><i class='fa fa-download'></i> Download</a>");
                    /*tableString += "<table id='reports_table' class='table table-condensed cell-border small dataTable no-footer'><thead><tr><th class='text-left'>Reference #</th><th class='text-left'>Client Code</th><th class='text-left'>Report File</th><th class='text-left'>Date</th><th class='text-left'>Actions</th></tr></thead><tbody>";*/
                    $.each(data, function (a, b) {
                        function humanFileSize(size) {
                            var i = size == 0 ? 0 : Math.floor(Math.log(size) / Math.log(1024));
                            return (size / Math.pow(1024, i)).toFixed(2) * 1 + ' ' + ['B', 'KB', 'MB', 'GB', 'TB'][i];
                        };
                        tableString += "<tr>" +
                            "<td>" + b.report_file + "</td>" +
                            "<td>" + humanFileSize(b.report_file_size) + "</td>" +
                            "<td>" + b.name + "</td>" +
                            "<td>" + b.report_status + "</td>" +
                            "<td>" + b.created_at + "</td>" +
                            "<td class='text-center'><a href='/download-report-file/" + b.inspection_id + "/" + b.report_file + "' class='btn btn-block btn-xs btn-primary' download><i class='fa fa-download'></i></a></td></tr>";
                        /*tableString += "<tr>" +
                        		"<td>" + b.report_file + "</td>" +
                        		"<td>" + humanFileSize(b.report_file_size) + "</td>" +
                        		"<td>" + b.name + "</td>" +
                        		"<td>" + b.created_at + "</td>";*/
                    });
                    //tableString += "</tbody></table>";
                    table.append(tableString);
                    $('#modalViewReport').modal("show");
                }
            },
        });
    });

});
