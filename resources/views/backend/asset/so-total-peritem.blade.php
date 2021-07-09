<!-- First you need to extend the CB layout -->
@extends('crudbooster::admin_template')
@section('content')
<!-- Your custom  HTML goes here -->

<?php 

$url_callback = url('admin/stock_opname_asset/total-peritem/'.$id);

?>
<p>
  <a title="Return" href="{{url('admin/stock_opname_asset')}}">
    <i class="fa fa-chevron-circle-left"></i>
    &nbsp; Back To List Data Stock Opname Asset
  </a>
</p>


<div class="box">
  <div class="box-body">
      <div class="row">
        <div class="col-md-6">
          <form action="{{action('AdminStockOpnameAssetController@postAddItem')}}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="id_stock_opname_asset" id="id_stock_opname_asset" value="{{$id}}">
            <input type="hidden" name="url_callback" value="{{$url_callback}}">
            <div class="form-group">
                <label class="control-label col-sm-12" style="font-size: 28px">
                    Scan Barcode Here :
                </label>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <input type="text" title="Barcode" required class="form-control" name="code" id="code" value="{{ old('code') }}" placeholder="Scan / Type & Enter">
                </div>
            </div>
            <input type="submit" name="submit" class="hidden">
          </form>
        </div>
        <div class="col-md-6">
          <table class="table table-striped">
            <tr>
              <th>Stock Opaname</th>
              <td>{{tv($id,'stock_opname_asset','name')}}</td>
            </tr>
            <tr>
              <th>Date</th>
              <td>{{tv($id,'stock_opname_asset','created_at')}}</td>
            </tr>
            <tr>
              <th>Lokasi</th>
              <td>{{tv($stock_opname_asset->id_warehouse,'warehouse','name')}}</td>
            </tr>
            <tr>
              <th>Status</th>
              <td>{{tv($id,'stock_opname_asset','status')}}</td>
            </tr>
          </table>
          <?php $status = tv($id,'stock_opname_asset','status') ?>
          @if($status != 'PUBLISH')
            <div style="margin-bottom: 10px"><a href="{{action('AdminStockOpnameAssetController@getUpdateStatus').'/'.$id.'?url_callback='.$url_callback}}" class="btn btn-sm btn-success">Publish Stock Opname <i class="fa fa-arrow-right"></i></a></div>
          @endif
        </div>
      </div>
  </div>
</div>

<ul class="nav nav-tabs">
    <li><a href="{{url('admin/stock_opname_asset/list-item/'.$id)}}"><i class="fa fa-th-list"></i> Scanned Item</a></li>
    <li class="active"><a href="{{url('admin/stock_opname_asset/total-peritem/'.$id)}}"><i class="fa fa-th-list"></i> Total PerItem</a></li>
</ul>

<div class="box">
  <div class="box-body">
    <div class="wrapHead">
      <p style="font-weight: bold">
        Total PerItem
      </p>
    </div>
    <table class="table table-hover table-striped table-bordered">
      <thead>
        <tr>
          <th>Item</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        @foreach($stock_opname_asset_item as $item)
        <tr>
          <td>{{tv($item->id_item,'item','name')}}</td>
          <td>{{totalSoAssetPerItem($id,$item->id_item)}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="box-footer">
    <div class="pull-right">
      {!! urldecode(str_replace("/?","?",$stock_opname_asset_item->appends(Request::all())->render())) !!}
    </div>
  </div>
</div>


@endsection()