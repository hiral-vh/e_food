@extends('admin.master')
@section('title','Food-Category')
@section('css')
<style>
  .tblLength {
    display: inline-block;
    width: 200px;
  }
  .dis-flex p{
    margin-bottom:0;
  }
  
</style>
@endsection

@section('content')
<div class="content-page">
  <!-- Start content -->
  <div class="content">

    <div class="">
      <div class="page-header-title">
        <h4 class="page-title">Subscription Details</h4>
      </div>
    </div>

    <div class="page-content-wrapper ">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-12">
            <div class="card">
              <div class="card-body" style="display: block;">
                <div class="row">
                  <div class="col-12 col-md-12 col-lg-12 order-2 order-md-1">
                    <div class="row">
                      <div class="col-12 col-sm-12">
                        <ul class="list-group list-group-unbordered">
                          <li class="list-group-item">
                            <b class="tblLength">Subscription Name</b><span class="category-section">{{isset($subscriptionData->plan_name) ? $subscriptionData->plan_name : 'Trial Package'}}</span>
                          </li>
                          <li class="list-group-item">
                            <b class="tblLength">Start Date</b><span class="category-section">{{(isset($subscriptionData->start_date))? date('d-m-Y', strtotime($subscriptionData->start_date)) : 'N/A'}}</span>
                          </li>
                          <li class="list-group-item">
                            <b class="tblLength">End Date</b><span class="category-section">{{(isset($subscriptionData->end_date))? date('d-m-Y', strtotime($subscriptionData->end_date)) : 'N/A'}}</span>
                          </li>
                          <li class="list-group-item">
                            <b class="tblLength">Price (&#163;)</b><span class="category-section">{{isset($subscriptionData->plan_price) ? '£' . $subscriptionData->plan_price : 'N/A'}}</span>
                          </li>
                          <li class="list-group-item dis-flex d-flex">
                            <b class="tblLength">Description</b><span class="category-section">{!! isset($subscriptionData->plan_description) ? $subscriptionData->plan_description : 'N/A' !!}</span>
                          </li>
                          <li class="list-group-item">
                            <b class="tblLength">Duration</b><span class="category-section">{{(isset($subscriptionData->plan_duration))? $subscriptionData->plan_duration : '1'}} Month</span>
                          </li>
                          <li class="list-group-item">
                            <b class="tblLength">Allowed Orders</b><span class="category-section">{{(isset($subscriptionData->allowed_order))? $subscriptionData->allowed_order : 'N/A'}}</span>
                          </li>
                          <li class="list-group-item">
                            <b class="tblLength">Remaining Orders</b><span class="category-section">{{(isset($subscriptionData->total_orders))? $subscriptionData->total_orders : 'N/A'}}</span>
                          </li>
                        </ul>
                        <!-- <div class="upgrade-btn-box">
                          <a href="{{route('upgrade-subscription')}}"><button class="btn btn-upgrade mr-10" title="Upgrade Subscription">Upgrade Subscription</button></a>


                          <a href="{{route('cancel-subscription')}}"><button class="btn btn-upgrade mr-2" title="Cancel Subscription">Cancel Subscription</button></a>
                        </div> -->
                        @if($subscriptionData->plan_id == null)
                        <div class="upgrade-btn-box">
                          <a href="{{route('upgrade-subscription')}}"><button class="btn btn-upgrade" title="Upgrade Subscription">Subscribe Plan</button></a>
                        </div>
                        @elseif($subscriptionData->plan_id != 1)

                        @if($subscriptionData->cancel_subscription == 'cancel')
                        <div class="upgrade-btn-box">
                          <a href="{{route('upgrade-subscription')}}"><button class="btn btn-upgrade mr-10" title="Upgrade Subscription">Subscribe Plan</button></a>
                        </div>

                        @else
                        <div class="upgrade-btn-box">
                          <a href="{{route('cancel-subscription')}}"><button class="btn btn-upgrade mr-4" title="Cancel Subscription">Cancel Subscription</button></a>

                          <a href="{{route('upgrade-subscription')}}"><button class="btn btn-upgrade" title="Upgrade Subscription">Upgrade Subscription</button></a>
                        </div>
                        @endif

                        @endif
                      </div>
                    </div>
                  </div>
                  <!-- <div style="height: 300px"></div> -->
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- end row -->

      </div><!-- container -->

    </div> <!-- Page content Wrapper -->
  </div> <!-- Page content Wrapper -->

</div> <!-- content -->
@endsection
<!-- <footer class="footer">
  © 2019 - 2020 Hexzy <span class="d-none d-md-inline-block"> - Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesdesign.</span>
</footer> -->




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