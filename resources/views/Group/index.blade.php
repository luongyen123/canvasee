@extends('layout')
@section('content')
<section class="content-header">
  <h1>
  Group Admin
  <small> Hashtag</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Group</a></li>
    <li class="active">Index</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">List Hashtag canvasee</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
           
              <tr>
                <th>Name</th>
                <th>Feeds nummber</th>
                <th>Following Number</th>
                <th>Feed list</th>
                <th>Follwing list</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
               @foreach($data as $value)
              <tr>
                <td>{{$value->name}}</td>
                <td>{{$value->feeds->count()}}</td>
                <td>{{$value->members->count()}}</td>
                <td><a href="{{route('feeds.index',$value->id)}}">Members</a></td>
                <td><a href="{{route('members.index',$value->id)}}">Follwing</a></td>
                <td>
                  
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>
@endsection
@section('js')
<script src="{{asset('/theme/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/theme/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<!-- SlimScroll -->
<script src="{{asset('/theme/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('/theme/bower_components/fastclick/lib/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('/theme/dist/js/demo.js')}}"></script>
<script>
$(function () {
$('#example1').DataTable()
$('#example2').DataTable({
'paging'      : true,
'lengthChange': false,
'searching'   : false,
'ordering'    : true,
'info'        : true,
'autoWidth'   : false
})
})
</script>
@endsection