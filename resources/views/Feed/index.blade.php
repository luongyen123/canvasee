@extends('layout')
@section('content')
<section class="content-header">
  <h1>
  Feed in gruop
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Feed</a></li>
    <li class="active">Index</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">List feed in gruop</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>

              <tr>
                <th>Title</th>
                <th>Content</th>
                <th>Likes</th>
                <th>Shares</th>
                <th>Comments</th>
                <th>Notifications</th>
                <th>Medias</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
               @foreach($feeds as $value)

              <tr>
                <td>{{$value->title}}</td>
                <td>{{$value->content}}</td>
                <td>{{$value->likes}}</td>
                <td>{{$value->shares}}</td>
                <td>{{$value->comments}}</td>
                <td>{{$value->notifications}}</td>
                <td>{{$value->medias}}</td>

                <td>
                  <a href="{{route('feeds.edit',[$value->group_id,$value->id])}}"><i class="fa fa-edit"></i></a>
                  <a href="{{route('feeds.destroy',[$value->group_id,$value->id])}}"><i class="fa fa-times"></i></a>
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