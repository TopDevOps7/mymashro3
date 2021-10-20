@extends('dashboard.layouts.app')

@section('title')
Draws
@endsection
@section('create_btn'){{route('dashboard_draws.add_edit')}}@endsection
@section('create_btn_btn') Create new @endsection
@section('content')

<div class="row">
    <div class="col-md-12">

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <div class="filter-custom">
                        <div class="row">
                            <div class="col-lg-4">
                                <button type="button" class="btn btn-sm btn-dark ajax_delete_all">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <table class="table table-striped table-bordered text-nowrap w-100 dataTable no-footer data_Table"
                        id="data_Table">
                        <thead>
                            <th>
                                <label>
                                    <input type="checkbox" class="btn_select_all">
                                </label>
                            </th>
                            <th>Video</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Priority</th>
                            <th>Option</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection


@section('js')

<script type="text/javascript">
var alert_w = "Modal_Lock_Title}}";
var alert_war = "Warning}}";
var array = [];
$(document).ready(function() {

    var datatable = $('#data_Table').DataTable({
        "columnDefs": [{
            "targets": [0],
            "orderable": false
        }],
        "processing": true,
        "serverSide": true,
        "bStateSave": true,
        "fnCreatedRow": function(nRow, aData, iDataIndex) {
            $(nRow).attr('id', 'item_' + aData['id']);
        },
        "ajax": {
            "url": "{{ route('dashboard_draws.get_data') }}",
            "dataType": "json",
            "type": "POST",
            "data": {
                _token: "{{csrf_token()}}"
            }
        },
        "columns": [{
                "data": "id"
            },
            {
                "data": "file"
            },
            {
                "data": "name"
            },
            {
                "data": "status"
            },
            {
                "data": "priority"
            },
            {
                "data": "options"
            }
        ]
    });;

    "use strict";
    $(document).on('change', '#priority', function() {
        var priorityvalue = this.value;
        var priorityid = $(this).attr("data-id");
        $.ajax({
            url: "{{route('dashboard_draws.get_data_by_iddata')}}",
            method: "get",
            data: {
                "id": priorityid,
                "value": priorityvalue
            },
            dataType: "json",
            success: function(result) {
                if (result.success != null) {
                    datatable.ajax.reload();
                }

            }
        });
    });
    //Code here.

    /*$('#data_Table tbody').sortable({
        axis: 'y',
        update: function (event, ui) {
            var data = $(this).sortable('serialize');
            console.log(data);
        }
    });*/

    $(document).on('click', '.btn_confirm_email_current', function() {
        var id = $(this).data("id");
        console.log(id);
        if (id) {
            $('#data_Table tbody #item_' + id).css('background', 'hsla(64, 100%, 50%, 0.36)');
        }

        $.ajax({
            url: "{{ route('dashboard_draws.confirm_email') }}",
            method: "get",
            data: {
                "id": id,
            },
            dataType: "json",
            success: function(result) {
                if (result.error != null) {
                    toastr.error(result.error, "@lang('table.confirm_email')");
                } else {
                    toastr.success(result.success, "@lang('table.confirm_email')");
                }
                $('#data_Table').DataTable().ajax.reload();
            }
        });
    });
    $(document).on('click', '.ajax_delete_all', function() {
        $.ajax({
            url: "{{ route('dashboard_draws.deleted_all') }}",
            method: "get",
            data: {
                "array": array,
            },
            dataType: "json",
            success: function(result) {
                if (result.error != null) {
                    toastr.error(result.error);
                    $("input:checkbox").prop('checked', false);
                    datatable.ajax.reload();
                } else {
                    toastr.success(result.success);
                    array = [];
                    $("input:checkbox").prop('checked', false);
                    datatable.ajax.reload();
                }
            }
        });
    });

    $(document).on('click', '.btn_select_all', function() {
        array = [];
        $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
        $('.btn_select_btn_deleted').each(function(index, value) {
            var id = $(value).data("id");
            var status = $(value).prop("checked");
            if (status == true) {
                array.push(id);
            } else {
                var index2 = array.indexOf(id);
                if (index2 > -1) {
                    array.splice(index2, 1);
                }
            }
        });
    });

    $(document).on('click', '.btn_select_btn_deleted', function() {
        var id = $(this).data("id");
        var status = $(this).prop("checked");
        var numberOfChecked = $('input:checkbox:checked').length;
        var numberOftext = $('.btn_select_btn_deleted').length;
        if (status == true) {
            array.push(id);
        } else {
            var index = array.indexOf(id);
            if (index > -1) {
                array.splice(index, 1);
            }
        }
        if (numberOftext != array.length) {
            $(".btn_select_all").prop('checked', false);
        }
        if (numberOftext == array.length) {
            $(".btn_select_all").prop('checked', $(this).prop('checked'));
        }
    });

    $(document).on("click", ".PopUp", function() {
        $('#PopUp .modal-title').html($(this).attr("title"));
        $('.modal .title').html('انشاء مستخدم جديد');
        $("#PopUp").modal({
            show: true,
            backdrop: "static"
        });
    });

    $(document).on("click", ".btn_edit_current", function() {
        $('#PopUp .modal-title').html($(this).attr("title"));
        $("#PopUp").modal({
            show: true,
            backdrop: "static"
        });
    });

    $(document).on('click', '.btn_delete_current', function() {
        var id = $(this).data("id");
        $('#ModDelete').modal('show');
        $('#iddel').val(id);
        if (id) {
            $('#data_Table tbody tr').css('background', 'transparent');
            $('#data_Table tbody #item_' + id).css('background', 'hsla(64, 100%, 50%, 0.36)');
        }
    });

    $('.btn_deleted').on("click", function() {
        var id = $('#iddel').val();
        console.log(id);
        $.ajax({
            url: "{{ route('dashboard_draws.deleted') }}",
            method: "get",
            data: {
                "id": id,
            },
            dataType: "json",
            success: function(result) {
                toastr.error(result.error);
                $('.modal').modal('hide');
                datatable.ajax.reload();
            }
        });
    });

});
</script>


@endsection