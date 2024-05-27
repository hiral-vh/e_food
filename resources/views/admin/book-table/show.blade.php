@extends('admin.master')
@section('title','Food-Category')
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css" class="href">
<style>
  span.time-from {
    border-right: 1px solid #ef5c6adb;
    padding: 14px 0px;
  }

  span.category-section.ml-3.from-time {
    margin-right: 15px;
  }

  .card-tools {
    padding-top: 15px;
  }

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
        <h4 class="page-title">Book Table Detail</h4>
      </div>
    </div>
    <div class="page-content-wrapper ">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-12">
            <div class="card">
              <div class="card-tools">
                <div class="mb-3 ml-3 mt-0 pr-md-5 text-right">
                  <a href="{{route('table-number.edit',$booktable->id)}}" class="btn btn-sm btn-primary" title="Edit">Edit</a>
                  <a id="delete" href="javascript:void(0);" class="btn btn-sm btn-danger" title="Delete">Delete</a>
                  <form action="{{ route('table-number.destroy', $booktable->id)}}" method="POST" id="deleteForm">
                    @csrf
                    <input name="_method" type="hidden" value="DELETE">
                  </form>
                </div>
              </div>
              <div class="card-body" style="display: block;">
                <div class="row">
                  <div class="col-12 col-md-12 col-lg-12 order-2 order-md-1">
                    <div class="row">

                      <div class="col-12 col-sm-6">
                        <ul class="list-group list-group-unbordered">
                          <li class="list-group-item">
                            <b class="tblLength">Table Number</b><span class="category-section">{{$booktable->table_name !="" ? $booktable->table_name : 'N/A'}}</span>
                          </li>
                          <li class="list-group-item">
                            <b class="tblLength">Number of People</b><span class="category-section">{{$booktable->number_of_people !="" ? $booktable->number_of_people : 'N/A'}}</span>
                          </li>
                          <li class="list-group-item">
                            <b class="tblLength">Duration</b><span class="category-section">{{$booktable->duration !="" ? $booktable->duration : 'N/A'}}</span>
                          </li>
                        </ul>
                      </div>

                      <div class="col-12 col-sm-6">
                        <ul class="list-group list-group-unbordered">
                          @foreach($bookTableDuration as $duration)
                          <li class="list-group-item">
                            <span class="time-from">
                              <b>Time From</b><span class="category-section from-time">{{$duration->time_from !="" ? $duration->time_from : 'N/A'}}</span>
                            </span>
                            <span class="time-to">
                              <b class="ml-3">Time to</b><span class="category-section">{{$duration->time_to !="" ? $duration->time_to : 'N/A'}}</span>
                          </li>
                          </span>
                          @endforeach
                        </ul>
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