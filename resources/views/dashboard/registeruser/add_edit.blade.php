@extends('dashboard.layouts.app')

@section('title')
Advertisement
@endsection

@section('create_btn'){{route('dashboard_registereduser.index')}}@endsection
@section('create_btn_btn') Back @endsection

@section('content')

<div class="card mb-4 wow fadeIn">
    <div class="card-body">

        <h4 class="mb-2 mb-sm-0 pt-1">
            Register User Information
        </h4>
        <hr>
        <form class="ajaxForm users" enctype="multipart/form-data" data-name="users"
            action="{{route('dashboard_registereduser.post_data')}}" method="post">
            {{csrf_field()}}

            <div class="modal-body">
                <input id="id" name="id" value="" type="hidden">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="registername">Name</label>
                            <input type="text" class="cls form-control" name="registername" id="registername"
                                placeholder="Name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="cls form-control" name="email" id="email" placeholder="Email">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="mobile">Mobile</label>
                            <input type="text" class="cls form-control" name="mobile" id="mobile"
                                placeholder="ex:)+1-541-754-3010">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="text" class="cls form-control" name="password" id="password"
                                placeholder="Password">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <main class="container">
                            <div class="row" style="padding-top:20px">
                                <div class="col">
                                    <span class="dateofbirth">Date of birth:</span>
                                    <input name="datepicker" data-date-format="dd/mm/yyyy" id="datepicker">
                                </div>
                            </div>
                        </main>
                    </div>
                    <div class="col-md-6">
                        <div class="card-body" id="datepickercolor">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group form-elements m-0">
                                        <div class="form-label">Freze User</div>
                                    </div>
                                </div>
                                <div class="col-md-4 x-check-active">
                                    <div class="material-switch pull-left" style="transform: translateY(16px);">
                                        <input id="someSwitchOptionSuccess3" name="status" type="checkbox"
                                            onChange="statuschange()" />
                                        <label for="someSwitchOptionSuccess3" class="label-success"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12" style="margin-top:10px">
                    <div class="card shadow">
                        <div class="card-header">
                            <h3 class="mb-0 card-title">Logo Upload</h3>
                        </div>
                        <div class="card-body">
                            <input type="file" class="dropify" id="picture" name="file" data-height="300" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="button_action" id="button_action" value="insert">
                <a href="{{route('dashboard_registereduser.index')}}" class="btn btn-default">
                    Close
                </a>
                <button type="submit" class="btn btn-primary btn-load">
                    Save Changes
                </button>
            </div>
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

#datepickercolor {
    display: flex;
    align-items: center;
}

#progress_ {
    display: flex;
    justify-content: center;
    align-items: center;
}

.dateofbirth {
    font-size: 15px;
    color: #000;
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
    $("input[type=range]").mousemove(function(e) {
        var val = ($(this).val() - $(this).attr('min')) / ($(this).attr('max') - $(this).attr('min'));
        var percent = val * 100;
        $("#pregressval").text(parseInt(percent) + "%");
        $(this).css('background-image',
            '-webkit-gradient(linear, left top, right top, ' +
            'color-stop(' + percent + '%, #FF5500), ' +
            'color-stop(' + percent + '%, #e9e2e1)' +
            ')');

        $(this).css('background-image',
            '-moz-linear-gradient(left center, #FF5500 0%, #FF5500 ' + percent + '%, #e9e2e1 ' +
            percent + '%, #e9e2e1 100%)');
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
        url: "{{route('dashboard_registereduser.get_data_by_id')}}",
        method: "get",
        data: {
            "id": id,
        },
        dataType: "json",
        success: function(result) {
            if (result.success != null) {
                console.log(result.success);
                $('#id').val(result.success.id);
                $('#registername').val(result.success.name);
                $('#email').val(result.success.email);
                $('#mobile').val(result.success.mobile);
                $('#password').val(result.success.password);
                $('#datepicker').val(result.success.datepicker);

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
                window.location.href = "{{route('dashboard_registereduser.index')}}";
            }
        }
    });
};
</script>


@endsection