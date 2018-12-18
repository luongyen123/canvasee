@extends('layout')
@section('content')
@if (Session::has('flash_message'))
    <div class="alert alert-{!! Session::get('flash_level') !!} slideUp_msg">
        {!! Session::get('flash_message') !!}
    </div>
@endif
<section class="content-header">
  <h1>
  Member in gruop : {{$group[$idgroup]}}
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Member</a></li>
    <li class="active">Index</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">List member in gruop</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>

              <tr>
                <th>ID</th>
                <th>User</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
               @foreach($member as $value)
              <tr>
                <td>{{$value->id}}</td>
                <td>{{$user[$value->user_id]}}</td>
                <td>
                  <a  class="btn btn-success" href="{{route('member.destroy',$value->id)}}"><i class="fa fa-times"></i></a>
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