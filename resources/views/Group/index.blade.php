@extends('layout')
@section('content')
@if (Session::has('flash_message'))
    <div class="alert alert-{!! Session::get('flash_level') !!} slideUp_msg">
        {!! Session::get('flash_message') !!}
    </div>
@endif
<section class="content-header">
<p id="toado"></p>
  <h1>
  Group Admin
  <small> Hashtag</small>
  </h1>
  <button data-toggle="modal" data-target="#addModal" id="" class="btn btn-success"><i class="fa fa-plus-circle" aria-hidden="true"> add group</i></button>

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
{{--                <td>{{$value->members->count()}}</td>--}}
                <td><a href="{{route('feeds.index',$value->id)}}">Feeds</a></td>
                <td><a href="{{route('members.index',$value->id)}}">Follwing</a></td>
                <td>
                  <a class="btn btn-primary edit_group" idgroup='{{$value->id}}' name="{{$value->name}}" data-toggle="modal" data-target="#editModal" href=""><i class="fa fa-edit"></i></a>
                  <a class="btn btn-primary" href="{{route('groups.destroy',$value->id)}}"><i class="fa fa-times"></i></a>
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

  {{-- them group --}}

  <div class="modal fade" id="addModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h3>Add group</h3>
          <form class="form-group" action="{{ route('groups.store') }}" method="post">
            <input type="hidden" id="_token" value="{{ csrf_token() }}">
            <label>Name group :</label>
            <input class="form-control" type="text" id="name_group" placeholder="nhap ten group" name="name">
          </form>
        </div>
        <div class="modal-footer">
          <button type="" id="add_group" class="btn btn-success">Save</button>
        </div>
      </div>

    </div>
  </div>

  {{-- sửa group --}}
  <div class="modal fade" id="editModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h3>Edit group</h3>
          <form class="form-group" action="" method="post">
            <input type="hidden" id="_token" value="{{ csrf_token() }}">
            <label>Name group :</label>
            <input class="form-control" type="text" id="editname" placeholder="nhap ten group" name="name">
          </form>
        </div>
        <div class="modal-footer">
          <button type="" id="editgroup" class="btn btn-success">Save</button>
        </div>
      </div>

    </div>
  </div>
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
<script src='https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js'></script>

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
  });

  //ajax create group
  $('#addModal').on('shown.bs.modal', function () {
     $('#add_group').on('click',function(event){
        // $('#add_group').hide();

        var name_group = $('#name_group').val();
        var _token = $('input#_token').val();

        $.ajax({
          url:'groups/store',
          type:'post',
          data:{
            name:name_group,
            '_token': _token
          },
          success:function(data){
            console.log(data);
            if (data.trim() == 'true') {
              window.location.href = 'groups';
              $.notify("Thêm group thành công", "success");
            }
          },
          error: function(err){
            console.log(err);
          }
        });
      })
  });

  // ajax edit group
  $(document).on('click', '.edit_group', function (event) {
      var idgroup = $(this).attr('idgroup');
      var name_group = $(this).attr('name');
      var editname = $('#editname').val(name_group);

      $('#editname').on('change',function(){
        editname = $('#editname').val();
      });


      var _token = $('input#_token').val();
      console.log(idgroup);
      console.log(editname);
      $('#editgroup').on('click',function(){
        console.log(editname);
        $.ajax({
          url:'groups/update',
          type:'post',
          data:{
            idgroup:idgroup,
            editname:editname,
            '_token': _token
          },
          success:function(data){
            console.log(data);
            if (data.trim() == 'true') {
              window.location.href = 'groups';
              $.notify("sửa group thành công", "success");
            }
          },
          error: function(err){
            console.log(err);
          }
        })
      });
    });

});



</script>
@endsection
