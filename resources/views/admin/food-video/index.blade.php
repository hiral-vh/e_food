@extends('admin.master')
@section('title','Food-Video')

@section('content')

<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">Video Details</h4>
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
                                        <div class="col-lg-12">
                                            <div class="card">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        @foreach($list as $data)
                                        <div class="col-md-6">
                                            <div class="card video-inner-card">
                                                <div class="card-body">
                                                    <div class="title-videos">
                                                        <h5>{{$data->title}}</h5>
                                                        <p>{!! substr($data->description, 0, 50) !!}...</p>
                                                        <video class="video-player" controls>
                                                            <source src="{{ asset($data->video) }}" type="video/mp4">
                                                        </video>
                                                        <div class="button-video">
                                                            <a href="{{route('details-video',$data->id)}}"><button type="button" class="btn btn-primary waves-effect waves-light m-l-10">View</button></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
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