@extends('admin.master')
@section('title','Food-Category')
@section('css')
@endsection

@section('content')
<div class="content-page">
  <!-- Start content -->
  <div class="content">

    <div class="">
      <div class="page-header-title">
        <h4 class="page-title">Food Category Details</h4>
      </div>
    </div>


      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-12">
            <div class="card">
              <div class="card-body">
                <h4 class="m-t-0">Your Title</h4>

                <div class="card-tools">
                  <div class="text-center mt-0 mb-3">
                    <a href="{{route('food-category.edit',$category->id)}}" class="btn btn-sm btn-primary" title="Edit">Edit</a>
                    <a id="delete" href="javascript:void(0);" class="btn btn-sm btn-danger" title="Delete">Delete</a>
                    <form action="{{ route('food-category.destroy', $category->id)}}" method="POST" id="deleteForm">
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
                            <b>Title</b><span class="category-section ml-4">{{$category->food_category_name !="" ? $category->food_category_name : 'N/A'}}</span>
                          </li>
                          <li class="list-group-item">
                            <b>Image</b><span class="category-section"><img src="{{url($category->food_category_image)}}" height="100px" width="100px" class="img-fluid ml-3" width="30px"></span>
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