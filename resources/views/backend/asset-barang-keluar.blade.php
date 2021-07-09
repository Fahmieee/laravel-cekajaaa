<!-- First you need to extend the CB layout -->
@extends('crudbooster::admin_template')
@section('content')
<!-- Your custom  HTML goes here -->

    
<div>
    <p> 
        <a title="Return" href="{{url('admin/barang-keluar-asset')}}">
             <i class="fa fa-chevron-circle-left "></i>
            Back To List Data Barang Keluar
        </a>
    </p>
                    
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong><i class="fa fa-th-list"></i> Add Barang Keluar</strong>
        </div>
        <form id="formAddSave" class="form-horizontal" method="POST" action="{{url('admin/barang-keluar-asset/add-save')}}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="id_item" id="id_item">
            <div class="panel-body" style="padding:20px 0px 0px 0px">       
                <div class="box-body" id="parent-form-area">      
                    <div class="form-group">
                        <label class="control-label col-sm-2">
                            Barcode <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-10">
                            <input type="text" title="Barcode" required class="form-control" name="code" id="code" placeholder="Scan / Type & Enter" value="{{ old('code') }}">
                            <div id="statusBarcode"></div>
                        </div>
                    </div>
                    <div id="wrapDesc">
                        <div class="form-group">
                            <label class="control-label col-sm-2">
                                SKU
                            </label>
                            <div class="col-sm-10">
                                <input type="text" title="SKU" required class="form-control" name="sku" id="sku" readonly value="{{ old('sku') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">
                                Name
                            </label>
                            <div class="col-sm-10">
                                <input type="text" title="Name" required class="form-control" name="name" id="name" readonly value="{{ old('name') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">
                                Lokasi
                            </label>
                            <div class="col-sm-10">
                                <input type="text" title="Gudang" required class="form-control" name="gudang" id="gudang" readonly value="{{ old('gudang') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">
                                Description
                            </label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="description" placeholder="Description" rows="4">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer" style="background: #F5F5F5">
                    <div class="form-group">
                        <label class="control-label col-sm-2"></label>
                        <div class="col-sm-10">
                            <a href="{{g("return_url")}}" class="btn btn-default"><i class="fa fa-chevron-circle-left"></i> Back</a>

                            <input type="button" name="submitx[]" value="Save &amp; Add More" class="btn btn-success hidden" onclick="submitForm()">
                            <input type="button" name="submitx[]" value="Save" class="btn btn-success" id="submitButton" onclick="submitForm()">
                        </div>
                    </div>
                </div><!-- /.box-footer-->
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    var input = document.getElementById("code");
    input.addEventListener("keyup", function(event) {
      event.preventDefault();
      if (event.keyCode === 13) {
        barcode(input.value);
        return false;
      }
    });
    function barcode(code) {
        var url = '{{url("admin/helpers/asset-detail-from-barcode-out?barcode=")}}'+code;
        $.get(url,function(response){
           document.getElementById("statusBarcode").innerHTML = response['api_message'];
           if (response['api_status'] == 1) {
            document.getElementById("sku").value     = response['data']['sku'];
            document.getElementById("name").value    = response['data']['name'];
            document.getElementById("id_item").value = response['data']['id_item'];
            document.getElementById("gudang").value  = response['data']['gudang'];
            $("#submitButton").removeClass('hidden');
           }else{
            document.getElementById("sku").value     = '';
            document.getElementById("name").value    = '';
            document.getElementById("id_item").value = '';
            document.getElementById("gudang").value  = '';
            $("#submitButton").addClass('hidden');
           }
        });
    }

    function submitForm(){
        document.getElementById("formAddSave").submit();
    }
</script>
@endsection()