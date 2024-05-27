@extends('admin.master')
@section('title','Discount')
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
        <h4 class="page-title">Discount Details</h4>
      </div>
    </div>

    <div class="page-content-wrapper ">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-12">
            <div class="card">
              <div class="card-body">
                <div class="card-tools">
                  <div class="text-right mt-0 mb-3">
                    <a href="{{route('discount.edit',$discountData->id)}}" class="btn btn-sm btn-primary" title="Edit">Edit</a>
                    <a id="delete" href="javascript:void(0);" class="btn btn-sm btn-danger" title="Delete">Delete</a>
                    <form action="{{ route('discount.destroy', $discountData->id)}}" method="POST" id="deleteForm">
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
                            <b class="tblLength">Discount Name</b><span class="category-section">{{$discountData->discount_name !="" ? $discountData->discount_name : 'N/A'}}</span>
                          </li>
                          <li class="list-group-item">
                            <b class="tblLength">Discount Code</b><span class="category-section">{{$discountData->discount_code !="" ? $discountData->discount_code : 'N/A'}}</span>
                          </li>
                          <li class="list-group-item">
                            <b class="tblLength">Discount Type</b><span class="category-section">{{$discountData->discount_type !="" ? $discountData->discount_type : 'N/A'}}</span>
                          </li>
                          <li class="list-group-item">
                            <b class="tblLength">Discount Percentage</b><span class="category-section">{{$discountData->discount_percentage !="" ? $discountData->discount_percentage : 'N/A'}}</span>
                          </li>

                          <li class="list-group-item">
                            <b class="tblLength">Discount Start Date</b><span class="category-section">{{$discountData->discount_start_date !="" ? date("d-m-Y",strtotime($discountData->discount_start_date)) : 'N/A'}}</span>
                          </li>
                          <li class="list-group-item">
                            <b class="tblLength">Discount End Date</b><span class="category-section" >{{$discountData->discount_end_date !="" ? date("d-m-Y",strtotime($discountData->discount_end_date)) : 'N/A'}}</span>
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