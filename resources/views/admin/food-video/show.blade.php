@extends('admin.master')
@section('title','Food-Video')



@section('content')

<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">Details</h4>
            </div>
        </div>
        <!-- End row -->




        <div class="page-content-wrapper ">

            <div class="page-content-wrapper ">

                <div class="container-fluid">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <h4 class="m-t-0 m-b-15 text-center">{{(!empty($details->title))?$details->title:'N/A'}}</h4>
                                            <div class="new-video text-center">
                                                <video class="video-player" controls>
                                                    <source src="{{ asset($details->video) }}" type="video/mp4">
                                                </video>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <p class="m-t-0 m-b-15">{!! wordwrap("$details->description",500,"<br>\n",true); !!}</p>
                                        </div>

                                    </div>
                                </div>

                            </div> <!-- card-body -->
                        </div> <!-- card -->
                    </div> <!-- col -->

                </div>

            </div>
        </div>
    </div>
</div>
</div>


@endsection

@section('js')

<script>

</script>

@endsection