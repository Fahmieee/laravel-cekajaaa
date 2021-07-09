<!DOCTYPE html>
<html>
<head>
	<title>Print Label</title>
</head>
<body onload="window.print()">
<!-- <body> -->

		<div class="main-wraper" style="width: 9.5cm;border: 1px solid #333;display: inline-block;text-align: center;">
			<table width="100%">
				<tr>
					<td><b>{{$name}}</b></td>
				</tr>
				<tr>
					<td><img src="{{url('admin/helpers/barcode?barcode='.$code.'&orientation=horizontal&size=50&codetype=code128')}}" alt="we" style="margin-top: 2px;"/></td>
				</tr>
				<tr>
					<td>
						<b>{{$code}}</b>
					</td>
				</tr>
			</table>
		</div>
</body>
</html>