<!-- First you need to extend the CB layout -->
@extends('crudbooster::admin_template')
@section('content')
<!-- Your custom  HTML goes here -->

<?php 

$url_callback = url('admin/stock_opname/list-item/'.$id);
$status       = tv($id,'stock_opname','status');
?>


    <p> 
        <a title="Return" href="{{url('admin/stock_opname')}}">
             <i class="fa fa-chevron-circle-left "></i>
            Back To List Data Stock Opname
        </a>
    </p>

<div class="box">
  <div class="box-body">
      <div class="row">
        @if($status != 'PUBLISH')
        <div class="col-md-6">
          <form action="{{action('AdminStockOpnameController@postAddItem')}}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="id_stock_opname" id="id_stock_opname" value="{{$id}}">
            <input type="hidden" name="url_callback" value="{{$url_callback}}">
            <div class="form-group">
                <label class="control-label col-sm-12" style="font-size: 28px">
                    Scan Barcode Here :
                </label>
            </div>
            <div class="form-group">
                <div class="col-sm-10">
                    <input type="text" title="Barcode" required class="form-control" name="sku" id="sku" value="{{ old('sku') }}" placeholder="Scan / Type & Enter">
                </div>
                <div class="col-sm-2">
                    <input type="number" title="QTY" required class="form-control" name="qty" id="qty" value="{{ old('qty') }}" placeholder="Qty">
                </div>
            </div>
            <input type="submit" name="submit" class="hidden">
          </form>
        </div>
        @endif
        <div class="col-md-6">
          <table class="table table-striped">
            <tr>
              <th>Stock Opaname</th>
              <td>{{tv($id,'stock_opname','name')}}</td>
            </tr>
            <tr>
              <?php $id_warehouse = tv($id,'stock_opname','id_warehouse') ?>
              <th>Lokasi</th>
              <td>{{tv($id_warehouse,'warehouse','name')}}</td>
            </tr>
            <tr>
              <th>Date</th>
              <td>{{tv($id,'stock_opname','created_at')}}</td>
            </tr>
            <tr>
              <th>Status</th>
              <td>{{tv($id,'stock_opname','status')}}</td>
            </tr>
          </table>
          @if($status != 'PUBLISH')
            <div style="margin-bottom: 10px"><a href="{{action('AdminStockOpnameController@getUpdateStatus').'/'.$id.'?url_callback='.$url_callback}}" class="btn btn-sm btn-success">Publish Stock Opname <i class="fa fa-arrow-right"></i></a></div>
          @endif
        </div>
      </div>
  </div>
</div>


<div class="box">
  <div class="box-body">
    <div class="wrapHead">
      <p style="font-weight: bold">
        Scanned Item
      </p>
    </div>
    <table class="table table-hover table-striped table-bordered">
      <thead>
        <tr>
          <th>Item</th>
          <th>Barcode</th>
          <th>QTY</th>
        </tr>
      </thead>
      <tbody>
        @foreach($stock_opname_item as $item)
        <tr>
          <td>{{tv($item->id_item,'item','name')}}</td>
          <td>{{tv($item->id_item,'item','sku')}}</td>
          <td>{{$item->qty}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="box-footer">
    <div class="pull-right">
      {!! urldecode(str_replace("/?","?",$stock_opname_item->appends(Request::all())->render())) !!}
    </div>
  </div>
</div>


@endsection()