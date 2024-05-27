@extends('admin.master')
@section('title','Menu Category')
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css" class="href">
@endsection

@section('content')
<div class="content-page">
  <!-- Start content -->
  <div class="content">

    <div class="">
      <div class="page-header-title">
        <h4 class="page-title">Menu Category Details</h4>
      </div>
    </div>


    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <div class="card-body">
              <h4 class="m-t-0">Menu Category</h4>
              <div class="card-tools">
                <div class="text-center mt-0 mb-3">
                  <a href="{{route('menu-category.edit',$menuCategory->id)}}" class="btn btn-sm btn-primary" title="Edit">Edit</a>
                  <a id="delete" href="javascript:void(0);" class="btn btn-sm btn-danger" title="Delete">Delete</a>
                  <form action="{{ route('menu-category.destroy', $menuCategory->id)}}" method="POST" id="deleteForm">
                    @csrf
                    <input name="_method" type="hidden" value="DELETE">
                  </form>
                </div>
              </div>
            </div>
            <div class="card-body" style="display: block;">
              <div class="row">
                <div class="col-12 col-md-12 col-lg-12 order-2 order-md-1">
                  <div class="row">

                    <div class="col-12 col-sm-6">
                      <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                          <b>Title</b><span class="category-section ml-3">{{$menuCategory->title !="" ? $menuCategory->title : 'N/A'}}</span>
                        </li>
                    </div>
                  </div>
                </div>
                <div style="height: 300px"></div>
              </div>
            </div>
          </div>
        </div>
        <!-- end row -->

      </div><!-- container -->

    </div> <!-- Page content Wrapper -->

  </div> <!-- content -->

  <footer class="footer">
    © 2019 - 2020 Hexzy <span class="d-none d-md-inline-block"> - Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesdesign.</span>
  </footer>

</div>

@endsection
@section('js')

<script type="text/javascript">
  $('#delete').click(function(event) {

    var form = $("#deleteForm").closest("form");

    event.preventDefault();
    swal({
        title: 'Are you sure you want to delete this record?',
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          form.submit();
        }
      });
  });
</script>
@endsection
