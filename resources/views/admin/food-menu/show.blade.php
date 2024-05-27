@extends('admin.master')
@section('title','Food-Category')
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
        <h4 class="page-title">Food Menu Details</h4>
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
                    <a href="{{route('food-menu.edit',$menuData->id)}}" class="btn btn-sm btn-primary" title="Edit">Edit</a>
                    <a id="delete" href="javascript:void(0);" class="btn btn-sm btn-danger" title="Delete">Delete</a>
                    <form action="{{ route('food-menu.destroy', $menuData->id)}}" method="POST" id="deleteForm">
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

                      <div class="col-12 col-sm-12">
                        <ul class="list-group list-group-unbordered">
                          <li class="list-group-item">
                            <b class="tblLength">Item Name</b><span class="category-section">{{isset($menuData->name) ? $menuData->name : 'N/A'}}</span>
                          </li>
                          <li class="list-group-item">
                            <b class="tblLength">Item Image</b><span class="category-section"><img src="{{url($menuData->image)}}" height="50px" width="50px" class="img-fluid" width="30px"></span>
                          </li>
                          <li class="list-group-item">
                            <b class="tblLength">Item Price (&#163;)</b><span class="category-section">{{isset($menuData->price) ? '£ ' .$menuData->price : 'N/A'}}</span>
                          </li>
                          <li class="list-group-item">
                            <b class="tblLength">Description</b><span class="category-section">{{isset($menuData->description) ? $menuData->description : 'N/A'}}</span>
                          </li>
                          <li class="list-group-item">
                            <b class="tblLength">Attribute</b><span class="category-section">{{(isset($menuData->menuAttribute) && (count($menuData->menuAttribute) > 0))? 'Yes' : 'No'}}</span>
                          </li>
                      </div>

                      <div class="col-12 col-sm-12">
                        <br />
                        <table class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; width: 100%;">
                          <thead>
                            <tr>
                              <td><b>Attibute Name</b></td>
                              <td><b>Attibute Price (&#163;)</b></td>
                            </tr>
                          </thead>
                          <tbody>
                            @if(count($menuDataAttibute) > 0)
                            @foreach($menuDataAttibute as $mkey)
                            <tr>
                              <td>{{isset($mkey->attribute_name) ? $mkey->attribute_name : 'N/A'}}</td>
                              <td>{{isset($mkey->attribute_price) ? '£ ' .$mkey->attribute_price : 'N/A'}}</td>
                            </tr>
                            @endforeach
                            @endif
                          </tbody>
                        </table>

                      </div>

                      <div class="col-12 col-sm-12">
                        <br />
                        <table class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; width: 100%;">
                          <thead>
                            <tr>
                              <td><b>Extra Item Name</b></td>
                              <td><b>Extra Item Price (&#163;)</b></td>
                            </tr>
                          </thead>
                          <tbody>
                            @if(count($menuDataExtraItem) > 0)
                            @foreach($menuDataExtraItem as $mkey)
                            <tr>
                              <td>{{isset($mkey->item_name) ? $mkey->item_name : 'N/A'}}</td>
                              <td>{{isset($mkey->item_price) ? '£ ' .$mkey->item_price : 'N/A'}}</td>
                            </tr>
                            @endforeach
                            @endif
                          </tbody>
                        </table>

                      </div>

                      <div class="col-12 col-sm-12">
                        <br />
                        <table class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; width: 100%;">
                          <thead>
                            <tr>
                              <td><b>Remove Ingredients Name</b></td>
                            </tr>
                          </thead>
                          <tbody>
                            @if(count($removeIngredients) > 0)
                            @foreach($removeIngredients as $mkey)
                            <tr>
                              <td>{{isset($mkey->ingredients_name) ? $mkey->ingredients_name : 'N/A'}}</td>
                            </tr>
                            @endforeach
                            @endif
                          </tbody>
                        </table>

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