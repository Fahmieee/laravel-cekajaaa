<!-- First you need to extend the CB layout -->
@extends('crudbooster::admin_template')
@section('content')
<!-- Your custom  HTML goes here -->

	<p> 
        <a title="Return" href="{{g('return_url')}}">
             <i class="fa fa-chevron-circle-left "></i>
            Back To List Data
        </a>
    </p>
<div class="box box-success">
	<div class="box-header">
		<h3 class="box-title">Detail</h3>
		<div class="box-tools pull-right">
			<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
			</button>
		</div>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-5">
				<table class="table table-striped">
					<tr>
						<th>SKU</th>
						<td>{{tv($item_asset_code->id_item,'item','sku')}}</td>
					</tr>
					<tr>
						<th>Name</th>
						<td>{{tv($item_asset_code->id_item,'item','name')}}</td>
					</tr>
					<tr>
						<th>Create by</th>
						<td>{{tv($item_asset_code->id_cms_users,'cms_users','name')}}</td>
					</tr>
					<tr>
						<th>Create at</th>
						<td>{{$item_asset_code->created_at}}</td>
					</tr>
				</table>
			</div>
			<div class="col-md-5">
				<div style="padding: 10px; text-align: center">
					<div><img src="{{url('admin/helpers/barcode?barcode='.$item_asset_code->code.'&orientation=horizontal&size=50&codetype=code128')}}" alt="we" style="margin-top: 2px;"/></div>
					<div><b>{{$item_asset_code->code}}</b></div>
				</div>
			</div>
		</div>
		

		
</div>
@endsection
