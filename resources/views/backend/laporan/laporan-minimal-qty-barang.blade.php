<!-- First you need to extend the CB layout -->
@extends('crudbooster::admin_template')
@section('content')
<!-- Your custom  HTML goes here -->

<div class="box">
  <div class="box-body">
    <form class="form-inline" method="get">
      <div class="row">
        <div class="col-md-3">
          <select class="form-control" style="width: 100%" name="item">
            <option value="0">- Pilih Item -</option>
            @foreach($items as $items)
              <option {{(g('item') == $items->id)?'selected':''}} value="{{$items->id}}">{{$items->name}}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3">
          <select class="form-control" style="width: 100%" name="warehouse">
            <option value="0">- Pilih Lokasi -</option>
            @foreach($warehouse as $wrs)
              <option {{(g('warehouse') == $wrs->id)?'selected':''}} value="{{$wrs->id}}">{{$wrs->name}}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3">
          <input type="submit" value="Filter" class="btn btn-success">
        </div>
      </div>
    </form>
  </div>
</div>

<div class="box">
  <div class="box-header">
    <p style="font-weight: bold;margin-bottom: 0px">Assets are less than Minimum Warehouse Qty</p>
  </div>
  <div class="box-body">
    <table class="table table-hover table-striped table-bordered">
      <thead>
        <tr>
          <th>Item</th>
          <th>Lokasi</th>
          <th>Qty</th>
          <th>Min. Stock</th>
        </tr>
      </thead>
      <tbody>
        @foreach($item_minimal_stock as $item)
        @if(stockItem($item->id_item,$item->id_warehouse) < $item->minimal_stock)
        <tr>
          <td>{{tv($item->id_item,'item','name')}}</td>
          <td>{{tv($item->id_warehouse,'warehouse','name')}}</td>
          <td>{{number_format(stockItem($item->id_item,$item->id_warehouse),0)}}</td>
          <td>{{number_format($item->minimal_stock,0)}}</td>
        </tr>
        @endif
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<div class="box">
  <div class="box-header">
    <p style="font-weight: bold;margin-bottom: 0px">Stock Item is less than Minimum Warehouse Qty</p>
  </div>
  <div class="box-body">
    <table class="table table-hover table-striped table-bordered">
      <thead>
        <tr>
          <th>Item</th>
          <th>Lokasi</th>
          <th>Qty</th>
          <th>Min. Stock</th>
        </tr>
      </thead>
      <tbody>
        @foreach($item_minimal_asset as $item)
        @if(stockItem($item->id_item,$item->id_warehouse) < $item->minimal_stock)
        <tr>
          <td>{{tv($item->id_item,'item','name')}}</td>
          <td>{{tv($item->id_warehouse,'warehouse','name')}}</td>
          <td>{{number_format(stockItem($item->id_item,$item->id_warehouse),0)}}</td>
          <td>{{number_format($item->minimal_stock,0)}}</td>
        </tr>
        @endif
        @endforeach
      </tbody>
    </table>
  </div>
</div>


@endsection()