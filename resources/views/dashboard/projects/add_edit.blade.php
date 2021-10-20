@extends('dashboard.layouts.app')

@section('title')
Top Project
@endsection

@section('create_btn'){{route('dashboard_topprojects.index')}}@endsection
@section('create_btn_btn') Back @endsection

@section('content')

<div class="card mb-4 wow fadeIn">
    <div class="card-body">

        <h4 class="mb-2 mb-sm-0 pt-1">
            Top Project Information
        </h4>
        <hr>
        <form class="ajaxForm orders" enctype="multipart/form-data" data-name="orders" action="" method="post">
            {{csrf_field()}}
            <div class="modal-body">
                <input id="id" name="id" value="" type="hidden">
                <!-- <div class="form-group">
                    <label for="topprojectname">Top Project Name</label>
                    <input type="text" class="cls form-control" name="topprojectname" id="topprojectname"
                        placeholder="Top Project Name">
                </div> -->
                <div class="row" style="margin-top:10px">
                    <div class="col-md-12">

                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div class="filter-custom">
                                    </div>

                                    <table
                                        class="table table-striped table-bordered text-nowrap w-100 dataTable no-footer data_Table"
                                        id="data_Table">
                                        <thead>
                                            <th>
                                                <label>
                                                    <input type="checkbox" class="btn_select_all">
                                                </label>
                                            </th>
                                            <th>Picture</th>
                                            <th>Name</th>
                                            <th>Ticket Price</th>
                                            <th>Started Tickets</th>
                                            <th>Available</th>
                                            <th>Sold</th>
                                            <th>Status</th>
                                            <th>Setting</th>
                                            <th>Option</th>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="modal-footer">
                <input type="hidden" name="button_action" id="button_action" value="insert">
                <a href="{{route('dashboard_topprojects.index')}}" class="btn btn-default">
                    Close
                </a>
                <button type="submit" class="btn btn-primary btn-load">
                    Update Changes
                </button>
            </div> -->


        </form>
    </div>

</div>


@endsection

<style>
input[type=range] {
    -webkit-appearance: none;
    -moz-apperance: none;
    border-radius: 6px;
    height: 6px;

    background-image: -webkit-gradient(linear,
            left top,
            right top,
            color-stop(15%, #FF5500),
            color-stop(15%, #e9e2e1));

    background-image: -moz-linear-gradient(left center,
            #e9e2e1 0%, #e9e2e1 15%,
            #FF5500 15%, #FF5500 100%);
}

#pregressval {
    font-size: 17px;
    font-weight: 700;
    font-style: unset;
    font-family: 'themify';
    position: relative;
    top: -16px;
    left: -79px;
    width: 50px;
}

#progress_ {
    display: flex;
    justify-content: center;
    align-items: center;
}

input[type="range"]::-moz-range-track {
    border: none;
    background: none;
    outline: none;
}

input[type=range]:focus {
    outline: none;
    border: none;
}

input[type=range]::-webkit-slider-thumb {
    -webkit-appearance: none !important;
    background-color: #FF5500;
    height: 13px;
    width: 13px;
    border-radius: 50%;
}

input[type=range]::-moz-range-thumb {
    -moz-appearance: none !important;
    background-color: #FF5500;
    border: none;
    height: 13px;
    width: 13px;
    border-radius: 50%;
}
</style>

@section('js')

<script type="text/javascript">
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
            "url": "{{ route('dashboard_topprojects.topget_data') }}",
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
                "data": "picture"
            },
            {
                "data": "name"
            },
            {
                "data": "priceofticker"
            },
            {
                "data": "numberofticket"
            },
            {
                "data": "available"
            },
            {
                "data": "sold"
            },
            {
                "data": "status"
            },
            {
                "data": "progressval"
            },
            {
                "data": "options"
            }
        ]
    });;

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
    $(document).on('click', '.btn_confirm_email_current', function() {
        var id = $(this).data("id");
        console.log(id);
        if (id) {
            $('#data_Table tbody #item_' + id).css('background', 'hsla(64, 100%, 50%, 0.36)');
        }

        $.ajax({
            url: "{{ route('dashboard_topprojects.confirm_email') }}",
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
    $(document).on('click', '#btn_select_current', function(e) {
        e.preventDefault();
        // var id = $("#id").attr("value");
        var id = $(this).data("id");
        // var name = $('#topprojectname').val();
        if (id == "") toastr.error('Please select project');
        if (id != null || id != undefined) {
            $.ajax({
                url: "{{ route('dashboard_topprojects.post_data') }}",
                method: "POST",
                data: {
                    "id": id,
                    _token: "{{csrf_token()}}"
                },
                dataType: "json",
                success: function(result) {
                    console.log(result);
                    if (result.success) {
                        window.location = "/dashboard/topprojects";

                    }
                }
            });
        }

    });




    "use strict";
    //Code here.

    var url = $(location).attr('href'),
        parts = url.split("/"),
        last_part = parts[parts.length - 1];

    var name_form = $('.ajaxForm').data('name');

    if (isNaN(last_part) == false) {
        if (last_part != null) {
            $('.title_info').html("Edit");
            Render_Data(last_part);
        }
    } else {
        $('.title_info').html("Close");
    }


});

function statuschange() {
    var checkedValue = $('#someSwitchOptionSuccess3:checked').val();
    let checkid = "";
    if (checkedValue == undefined) {
        checkedValue = "off";
    } else {
        checkedValue = "on";
    }
    console.log(checkedValue);
}
var Render_Data = function(id) {
    $.ajax({
        url: "{{route('dashboard_topprojects.get_data_by_id')}}",
        method: "get",
        data: {
            "id": id,
        },
        dataType: "json",
        success: function(result) {
            if (result.success != null) {
                console.log(result.success);
                $('#id').val(result.success.id);
                $('#projectname').val(result.success.name);
                $('#numberofticket').val(result.success.numberofticket);
                $('#priceofticker').val(result.success.priceofticker);
                $('#progressval').attr("value", `${result.success.progressval}`);
                $('#available').val(result.success.available);
                $('#sold').val(result.success.sold);
                if (result.success.status == "off") $('#someSwitchOptionSuccess3').attr("checked",
                    false);
                if (result.success.status == "on") $('#someSwitchOptionSuccess3').attr("checked", true);
                var image = geturlphoto() + result.success.picture;

                if (image != "") {
                    var editdrEvent_Img1 = $('#picture').dropify({
                        defaultFile: 'data:image/jpeg;base64,' + image
                    });
                    editdrEvent_Img1 = editdrEvent_Img1.data('dropify');
                    editdrEvent_Img1.resetPreview();
                    editdrEvent_Img1.clearElement();
                    editdrEvent_Img1.settings.defaultFile = 'data:image/jpeg;base64,' + image;
                    editdrEvent_Img1.destroy();
                    editdrEvent_Img1.init();

                    $('.dropify-render').attr("src", image);
                    $('.dropify-render img').attr("src", image);
                }
            } else {
                toastr.error('لا يوحد بيانات', 'العمليات');
                window.location.href = "{{route('dashboard_topprojects.index')}}";
            }
        }
    });
};
</script>


@endsection