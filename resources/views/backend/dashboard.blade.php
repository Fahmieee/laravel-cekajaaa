<!-- First you need to extend the CB layout -->
@extends('crudbooster::admin_template')
@section('content')
<!-- Your custom  HTML goes here -->

<div class="box hidden">
  <div class="box-body">
    <form class="form-inline" method="get">
      <div class="row">
        <div class="col-md-3">
          <select class="form-control" style="width: 100%" name="item">
            <option value="0">- Select Item -</option>
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
  <div class="box-header with-border">
    <h3 class="box-title">Cari Asset</h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
      </button>
    </div>
  </div>
  <div class="box-body">
    <form class="form-inline" method="get" action="{{url('admin/laporan-riwayat-asset')}}">
      <div class="row">
        <div class="col-md-3">
          <input type="input" name="q" class="form-control" style="width: 100%">
        </div>
        <div class="col-md-3">
          <input type="submit" value="Track" class="btn btn-success">
        </div>
      </div>
    </form>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Armada di Lokasi</h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="box-body">
        <canvas id="chartAsset"></canvas>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Stock Pada Lokasi</h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="box-body">
        <canvas id="chartStock"></canvas>
      </div>
    </div>
  </div>
</div>

<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">Out In Item Flow</h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
      </button>
    </div>
  </div>
  <div class="box-body">
    <canvas id="outInFlow"></canvas>
  </div>
</div>



@push("bottom")

    
    <script src="http://www.chartjs.org/dist/2.7.1/Chart.bundle.js"></script>
    <script src="http://www.chartjs.org/samples/latest/utils.js"></script>
    <style>
    canvas {
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
    }
    </style>
    
    <!-- Inquiry -->
    <?php 

      $item_asset = DB::table('stock')->select(DB::raw('sum(qty) as qty, id_item'))->where('type',2)->groupby('id_item')->orderby('qty','DESC')->limit(10)->get();

      $color = array('#dd4b39','#00a65a','#3c8dbc','#f39c12','#00c0ef','#dac71e','#009688','#d01d0f','#3F51B5');
      $i = 0;
      $q = '[';
      $r = '[';
      foreach ($item_asset as $item_asset) {
        $q .= '"'.tv($item_asset->id_item,'item','name').'",';
        $r .= $item_asset->qty.',';
        $i++;
      }

      $q = substr($q, 0, -1);
      $q .= ']';

      $r = substr($r, 0, -1);
      $r .= ']';

    ?>


    <?php 

      $item_stock = DB::table('stock')->select(DB::raw('sum(qty) as qty, id_item'))->where('type',1)->groupby('id_item')->orderby('qty','DESC')->limit(5)->get();

      $color = array('#dd4b39','#00a65a','#3c8dbc','#f39c12','#00c0ef','#dac71e','#009688','#d01d0f','#3F51B5');
      $i = 0;
      $p = '[';
      $o = '[';
      foreach ($item_stock as $item_stock) {
        $p .= '"'.tv($item_stock->id_item,'item','name').'",';
        $o .= $item_stock->qty.',';
        $i++;
      }

      $p = substr($p, 0, -1);
      $p .= ']';

      $o = substr($o, 0, -1);
      $o .= ']';

    ?>
    <script>
        var labelAsset = {!!$p!!};
        var dataAsset= {
            labels: labelAsset,
            datasets: [{
                label: 'Asset',
                fill : false,
                backgroundColor: 'rgba(3, 169, 244, 0.7)',
                borderColor: 'rgba(3, 169, 244, 1)',
                borderWidth: 1,
                data: {{$o}}

            }]
        };


        var labelStock = {!!$q!!};
        var dataStock= {
            labels: labelStock,
            datasets: [{
                label: 'Stock',
                fill : false,
                backgroundColor: "rgba(255, 193, 7, 0.7)",
                borderColor: 'rgba(255, 193, 7, 1)',
                borderWidth: 1,
                data: {{$r}}

            }]
        };

        var labelStock = ['2018-11-01','2018-11-12','2018-11-13','2018-11-14','2018-11-15','2018-11-16','2018-11-17','2018-11-18','2018-11-19','2018-11-20','2018-11-21','2018-11-22','2018-11-23','2018-11-24','2018-11-25','2018-11-26','2018-11-27','2018-11-28',];
        var datainout = {
            labels: labelStock,
            datasets: [{
                label: 'In',
                fill : false,
                backgroundColor: "rgba(255, 193, 7, 0.7)",
                borderColor: 'rgba(255, 193, 7, 1)',
                borderWidth: 1,
                data: [11,31,14,25,34,47,38,21,27,24,37,38,32,24,19,20,33,26]

            },{
                label: 'Out',
                fill : false,
                backgroundColor: 'rgba(3, 169, 244, 0.7)',
                borderColor: 'rgba(3, 169, 244, 1)',
                borderWidth: 1,
                data: [21,27,24,37,38,32,24,19,20,33,26,11,31,14,25,34,47,38]

            }]
        };


        window.onload = function() {
            
            var ctx = document.getElementById("chartAsset").getContext("2d");
            window.myBar = new Chart(ctx, {
                type: 'bar',
                data: dataAsset,
                options: {
                    // Elements options apply to all of the options unless overridden in a dataset
                    // In this case, we are setting the border of each horizontal bar to be 2px wide
                    elements: {
                        rectangle: {
                            borderWidth: 2,
                        }
                    },
                    responsive: true,
                    legend: {
                        position: 'bottom',
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: true
                    },
                    scales :{
                        yAxes : [{
                            ticks : {
                                beginAtZero : true
                            }
                        }]
                    }
                }
            });


            
            var ctx = document.getElementById("chartStock").getContext("2d");
            window.myBar = new Chart(ctx, {
                type: 'bar',
                data: dataStock,
                options: {
                    // Elements options apply to all of the options unless overridden in a dataset
                    // In this case, we are setting the border of each horizontal bar to be 2px wide
                    elements: {
                        rectangle: {
                            borderWidth: 2,
                        }
                    },
                    responsive: true,
                    legend: {
                        position: 'bottom',
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: true
                    },
                    scales :{
                        yAxes : [{
                            ticks : {
                                beginAtZero : true
                            }
                        }]
                    }
                }
            });
            
            var ctx = document.getElementById("outInFlow").getContext("2d");
            window.myBar = new Chart(ctx, {
                type: 'line',
                data: datainout,
                options: {
                    // Elements options apply to all of the options unless overridden in a dataset
                    // In this case, we are setting the border of each horizontal bar to be 2px wide
                    elements: {
                        rectangle: {
                            borderWidth: 2,
                        }
                    },
                    responsive: true,
                    legend: {
                        position: 'bottom',
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: true
                    },
                    scales :{
                        yAxes : [{
                            ticks : {
                                beginAtZero : true
                            }
                        }]
                    }
                }
            });
        };

    </script>

@endpush

@endsection()