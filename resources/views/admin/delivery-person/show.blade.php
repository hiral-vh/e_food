@extends('admin.master')
@section('title','Delivery-Person')
@section('css')
<style>
  .tblLength {
    display: inline-block;
    width: 200px;
  }
</style>
@endsection

@section('content')
<div class="content-page">
  <!-- Start content -->
  <div class="content">

    <div class="">
      <div class="page-header-title">
        <h4 class="page-title">Delivery Person Details</h4>
      </div>
    </div>


    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <div class="card-body">


              <div class="card-tools">
                <div class="text-right mt-0 mb-3">
                  <a href="{{route('delivery-person.edit',$category->id)}}" class="btn btn-sm btn-primary" title="Edit">Edit</a>
                  <a id="delete" href="javascript:void(0);" class="btn btn-sm btn-danger" title="Delete">Delete</a>
                  <form action="{{ route('delivery-person.destroy', $category->id)}}" method="POST" id="deleteForm">
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
                          <b class="tblLength">Delivery Person Name</b><span class="category-section">{{$category->delivery_person_name !="" ? $category->delivery_person_name : 'N/A'}}</span>
                        </li>
                        <li class="list-group-item">
                          <b class="tblLength">Delivery Person Email</b><span class="category-section">{{$category->delivery_person_email !="" ? $category->delivery_person_email : 'N/A'}}</span>
                        </li>
                        <li class="list-group-item">
                          <b class="tblLength">Delivery Person Mobile</b><span class="category-section">+{{$category->delivery_person_country_code}} {{$category->delivery_person_mobile !="" ? $category->delivery_person_mobile : 'N/A'}}</span>
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