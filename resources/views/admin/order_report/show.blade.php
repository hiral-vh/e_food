@extends('admin.master')
@section('title','Order Report')
@section('css')
<style>
    .menuTble,
    th,
    td {
        border: 1px solid #e5e5e5;
        padding: 5px;
        margin: 10px;
    }

    .select2 {
        width: 100% !important;
    }

    .select2-container--default .select2-selection--single {
        background-color: #fafafa;
        border: 1px solid #f4f7Fa;
        border-radius: 4px;
        height: 36px;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #6c757d;
        line-height: 37px;
    }

    /* modal css */
    .cur-order-inner {
        color: #fff;
        background: #2c2c2c;
        padding: 20px;
    }

    .cur-between {
        display: flex;
        justify-content: space-between;
    }

    .cur-between p {
        margin-bottom: 0px;
    }

    .arrival-tit {
        font-size: 13px;
        line-height: 21px;
    }

    .curtime {
        font-size: 17px;
        margin-bottom: 0 !important;
        font-weight: 600;
    }

    .curid {
        font-size: 20px;
        margin-bottom: 0 !important;
        font-weight: 800;
    }

    .cur-content {
        padding: 0 !important;
    }

    .cur-header {
        padding: 15px !important;
    }

    .cur-body {
        padding: 0 !important;
    }

    .stepdesign-main {
        padding: 20px 15px;
    }

    ul.step-ul {
        list-style: none;
        padding-left: 20px;
        position: relative;
    }

    ul.step-ul li .step-ul-inner {
        display: flex;
        align-items: center;
        margin-bottom: 40px;
    }

    ul.step-ul li .step-ul-inner p {
        margin-bottom: 0;
        line-height: 23px;
        font-size: 15px;
        margin-left: 30px;
    }

    ul.step-ul li {
        position: relative;
    }

    .step-ul-inner {
        position: relative;
    }

    .line {
        border-left: 1.5px dotted #2c2c2c;
        height: 30px;
        border-radius: 0;
        position: absolute;
        left: 19px;
        display: block;
        top: 46px;
    }

    .step-ul-inner img {
        height: 40px;
        width: 40px;
    }

    ul.step-ul li:last-child .step-ul-inner .line {
        display: none;
    }

    ul.step-ul li:last-child .step-ul-inner {
        margin-bottom: 0px;
    }

    /* modal css end */
</style>
@endsection
@section('content')



<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="">
            <div class="page-header-title">
                @if($orderData[0]->order_status != 'Rejected Order')
                <a onclick="opentrackStatus({{$orderData[0]->id}})" href="javascript:void(0)" class="btn btn-normal btn-primary btn-sm float-right m-l-10">Track Order</a>
                @endif
                <h4 class="page-title">Order Report</h4>

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
                                    <div>


                                        @if($orderData[0]->order_status == 'Order Confirmed')
                                        <a onclick="rejectOrders({{$orderData[0]->id}},{{$orderData[0]->user_id}})" href="javascript:void(0)" class="btn btn-normal btn-primary btn-sm float-right m-l-10">Reject Order</a>

                                        <a onclick="acceptOrders({{$orderData[0]->id}},{{$orderData[0]->user_id}})" href="javascript:void(0)" class="btn btn-normal btn-danger btn-sm float-right m-l-10">Accept Order</a>

                                        @endif
                                        <!--
                                        @php
                                        if($orderData[0]->order_type == '3'){
                                        if(empty($orderData[0]->delivery_person_id)){
                                        if($orderData[0]->order_status == 'Your orders are on its way'){
                                        @endphp
                                        <a onclick="opentDeliveryPerson({{$orderData[0]->id}})" href="javascript:void(0)" class="btn btn-normal btn-info btn-sm float-right  m-l-10">Add Delivery Person</a>
                                        @php } } } @endphp
                                        -->

                                        @php
                                        if($orderData[0]->order_type == '1'){
                                        if($orderData[0]->order_status == 'Accepted Order'){
                                        $nextStatus = "Preparing your Order";
                                        $orderstatusText = "'". $nextStatus. "'";
                                        echo '<button onclick="submitStatus('.$orderstatusText.','.$orderData[0]->id.','.$orderData[0]->user_id.')" class="btn btn-normal btn-warning btn-sm float-right m-l-10">Preparing your Order</button>';
                                        }else if($orderData[0]->order_status == 'Preparing your Order'){
                                        $nextStatus = "Your orders is ready";
                                        $orderstatusText = "'". $nextStatus. "'";
                                        echo '<button onclick="submitStatus('.$orderstatusText.','.$orderData[0]->id.','.$orderData[0]->user_id.')" class="btn btn-normal btn-info btn-sm float-right m-l-10">Your orders is ready</button>';
                                        }else if($orderData[0]->order_status == 'Your orders is ready'){
                                        $nextStatus = "Order Collected";
                                        $orderstatusText = "'". $nextStatus. "'";
                                        echo '<button onclick="submitStatus('.$orderstatusText.','.$orderData[0]->id.','.$orderData[0]->user_id.')" class="btn btn-normal btn-success btn-sm float-right m-l-10">Order Collected</button>';
                                        }

                                        }

                                        if($orderData[0]->order_type == '3'){
                                        if($orderData[0]->order_status == 'Accepted Order'){
                                        $nextStatus = "Preparing your Order";
                                        $orderstatusText = "'". $nextStatus. "'";
                                        echo '<button onclick="submitStatus('.$orderstatusText.','.$orderData[0]->id.','.$orderData[0]->user_id.')" class="btn btn-normal btn-warning btn-sm float-right m-l-10">Preparing your Order</button>';
                                        }else if($orderData[0]->order_status == 'Preparing your Order'){
                                        $nextStatus = "Your Order is ready";
                                        $orderstatusText = "'". $nextStatus. "'";
                                        echo '<button onclick="submitStatus('.$orderstatusText.','.$orderData[0]->id.','.$orderData[0]->user_id.')" class="btn btn-normal btn-info btn-sm float-right m-l-10">Your Order is ready</button>';
                                        }else if($orderData[0]->order_status == 'Your Order is ready'){
                                        $nextStatus = "Your orders are on its way";
                                        $orderstatusText = "'". $nextStatus. "'";
                                        echo '<button onclick="submitStatus('.$orderstatusText.','.$orderData[0]->id.','.$orderData[0]->user_id.')" class="btn btn-normal btn-secondary btn-sm float-right m-l-10">Your orders are on its way</button>';
                                        }else if($orderData[0]->order_status == 'Your orders are on its way'){
                                        $nextStatus = "Delivered";
                                        $orderstatusText = "'". $nextStatus. "'";
                                        echo '<button onclick="submitStatus('.$orderstatusText.','.$orderData[0]->id.','.$orderData[0]->user_id.')" class="btn btn-normal btn-success btn-sm float-right m-l-10">Delivered</button>';
                                        }
                                        }
                                        @endphp

                                    </div>
                                    <h4>Customer Detail</h4>

                                    <hr />
                                    <div class="row">
                                        <div class="col-md-4">
                                            <dl class="dl-horizontal mb-0">
                                                <dt><strong>Customer Name</strong> :</dt>
                                                <dd>{{$orderData[0]->first_name}} {{$orderData[0]->last_name}}</dd>
                                                <dt><strong>Delivery Address</strong> :</dt>
                                                <dd>{{$orderData[0]->address_line}} {{$orderData[0]->address_street}} {{$orderData[0]->address_city}} {{$orderData[0]->address_postcode}}</dd>
                                            </dl>
                                        </div>
                                        <div class="col-md-4">
                                            <dl class="dl-horizontal mb-0">
                                                <dt><strong>Customer Email</strong> :</dt>
                                                <dd>{{$orderData[0]->email}}</dd>
                                                <dt><strong>Delivery Contact Number</strong> :</dt>
                                                <dd>+{{$orderData[0]->address_country_code}} {{$orderData[0]->address_contact_no}}</dd>
                                            </dl>
                                        </div>
                                        <div class="col-md-4">
                                            <dl class="dl-horizontal mb-0">
                                                <dt><strong>Customer Mobile</strong> :</dt>
                                                <dd>+{{$orderData[0]->country_code}} {{$orderData[0]->mobile_no}}</dd>
                                            </dl>
                                        </div>
                                    </div>
                                    <h4>Order Detail</h4>
                                    <hr />
                                    @php
                                    $orderstatus = '';
                                    if($orderData[0]->order_status == 'Order Confirmed'){
                                    $orderstatus = '<span class="badge badge-primary">'.$orderData[0]->order_status.'</span>';
                                    }else if($orderData[0]->order_status == 'Preparing your Order'){
                                    $orderstatus = '<span class="badge badge-warning">'.$orderData[0]->order_status.'</span>';
                                    }else if($orderData[0]->order_status == 'Your orders are on its way'){
                                    $orderstatus = '<span class="badge badge-info">'.$orderData[0]->order_status.'</span>';
                                    }else if($orderData[0]->order_status == 'Your orders is ready'){
                                    $orderstatus = '<span class="badge badge-info">'.$orderData[0]->order_status.'</span>';
                                    }else if($orderData[0]->order_status == 'Order Collected'){
                                    $orderstatus = '<span class="badge badge-success">'.$orderData[0]->order_status.'</span>';
                                    }else if($orderData[0]->order_status == 'Delivered'){
                                    $orderstatus = '<span class="badge badge-success">'.$orderData[0]->order_status.'</span>';
                                    }else if($orderData[0]->order_status == 'Accepted Order'){
                                    $orderstatus = '<span class="badge badge-dark">'.$orderData[0]->order_status.'</span>';
                                    }else if($orderData[0]->order_status == 'Rejected Order'){
                                    $orderstatus = '<span class="badge badge-primary">'.$orderData[0]->order_status.'</span>';
                                    }
                                    $orderstatusText = "'". $orderData[0]->order_status. "'";
                                    @endphp
                                    <div class="row">
                                        <div class="col-md-4">
                                            <dl class="dl-horizontal mb-0">
                                                <dt><strong>Order Number</strong> :</dt>
                                                <dd>#{{$orderData[0]->order_number}}</dd>
                                                <dt><strong>Delivery Charge</strong> :</dt>
                                                <dd>{{$orderData[0]->delivery_charge}}</dd>
                                                <dt><strong>Order Status</strong> :</dt>
                                                <dd>{!! $orderstatus !!}
                                                    @if($orderData[0]->order_status != 'Delivered' && $orderData[0]->order_status == 'Accepted Order' || $orderData[0]->order_status == 'Preparing your Order' || $orderData[0]->order_status == 'Your orders are on its way')

                                                    <?php /*<a onclick="openDropDownforstatus({{$orderData[0]->id}},{{$orderData[0]->user_id}},{{$orderstatusText}});" href="javascript:void(0)"><i style="font-size: 20px;" class="ti-pencil"></i></a>*/ ?>
                                                    @endif


                                                </dd>
                                                @if($orderData[0]->order_status == 'Rejected Order')
                                                <dt><strong>Reason</strong> :</dt>
                                                <dd>
                                                    <p>{{$orderData[0]->reject_order_reason}}</p>
                                                </dd>
                                                @endif
                                            </dl>
                                        </div>
                                        @php
                                        $orderType = '';
                                        if($orderData[0]->order_type == '1'){
                                        $orderType= 'Collection';
                                        }else if($orderData[0]->order_type == '2'){
                                        $orderType= 'Dine-in';
                                        }else if($orderData[0]->order_type == '3'){
                                        $orderType= 'Delivery';
                                        } @endphp
                                        <div class="col-md-4">
                                            <dl class="dl-horizontal mb-0">
                                                <dt><strong>Order Type</strong> :</dt>
                                                <dd>{{$orderType}}</dd>
                                                <dt><strong>Sub Total</strong> :</dt>
                                                <dd>&#163; {{number_format($orderData[0]->sub_total,2)}}</dd>
                                                <!--
                                                @if(!empty($orderData[0]->delivery_person_id))
                                                <dt><strong>Delivery Person</strong> :</dt>
                                                <dd>{{$orderData[0]->delivery_person_name}}</dd>
                                                @endif
                                                -->
                                            </dl>
                                        </div>
                                        <div class="col-md-4">
                                            <dl class="dl-horizontal mb-0">
                                                <dt><strong>Order Date Time</strong> :</dt>
                                                <dd>{{date("d/m/Y h:i A",strtotime($orderData[0]->order_date_time))}}</dd>
                                                <dt><strong>Total Amount (&#163;)</strong> :</dt>
                                                <dd>&#163; {{$orderData[0]->total_amount}}</dd>
                                                <dt><strong>Discount Amount</strong> :</dt>
                                                <dd>{{($orderData[0]->discount_amount) ? $orderData[0]->discount_amount: '-'}}</dd>
                                            </dl>
                                        </div>
                                    </div>

                                    @if(!empty($orderData[0]->booktableuser))
                                    <hr />

                                    <h4>User Book Table Detail</h4>
                                    <hr />
                                    <div class="row">
                                        <div class="col-md-4">
                                            <dl class="dl-horizontal mb-0">
                                                <dt><strong>Booking Ref. Id</strong> :</dt>
                                                <dd>{{$orderData[0]->booktableuser['booking_ref_id']}}</dd>
                                                <dt><strong>Booking Note</strong> :</dt>
                                                <dd>{{$orderData[0]->booking_notes}}</dd>
                                            </dl>
                                        </div>
                                        <div class="col-md-4">
                                            <dl class="dl-horizontal mb-0">
                                                <dt><strong>Booking Date</strong> :</dt>
                                                <dd>{{date("d/m/Y",strtotime($orderData[0]->booktableuser['book_date']))}}</dd>
                                                <dt><strong>Booking From - To Time</strong> :</dt>
                                                <dd>@if(!empty($orderData[0]->booktableuser->booktabletime)) {{($orderData[0]->booktableuser->booktabletime['time_from'])? date("h:i A",strtotime($orderData[0]->booktableuser->booktabletime['time_from'])) : ''}} - {{($orderData[0]->booktableuser->booktabletime['time_to']) ? date("h:i A",strtotime($orderData[0]->booktableuser->booktabletime['time_to'])):''}}
                                                    @endif
                                                </dd>
                                            </dl>
                                        </div>
                                        <div class="col-md-4">
                                            <dl class="dl-horizontal mb-0">
                                                <dt><strong>Number of People</strong> :</dt>
                                                <dd>{{$orderData[0]->booktableuser['number_of_people']}}</dd>
                                                <dt><strong>Table Name</strong> :</dt>
                                                <dd>{{$orderData[0]->booktableuser->booktablename['table_name']}}</dd>
                                            </dl>
                                        </div>
                                    </div>

                                    @endif

                                    @if(!empty($orderData[0]->orderItemData))
                                    <hr />
                                    <h4>Menu Detail</h4>
                                    <hr />
                                    <div class="row">
                                        <table class="menuTble" style="border-collapse: collapse;" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Image</th>
                                                    <th>Name</th>
                                                    <th>Description</th>
                                                    <th>Quantity</th>
                                                    <th>Price (&#163;)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $total = 0; $i=0; @endphp
                                                @foreach($orderData[$i]->orderItemData as $menuValue)
                                                @php $menuName = substr($menuValue->menudata->name,0,10);
                                                $otherChr = '';
                                                if(strlen($menuValue->menudata->name) > 10){
                                                $otherChr= '...';
                                                }
                                                @endphp
                                                @php $total = $total + $menuValue->item_price; @endphp
                                                <tr>
                                                    <td style="width:15%"><img src="{{asset($menuValue->menudata->image)}}" height="60px" width="60px" /></td>
                                                    <td>{{$menuName}}{{$otherChr}}</td>
                                                    <td>{{$menuValue->menudata->description}}</td>
                                                    <td>{{$menuValue->item_qty}}</td>
                                                    <td>&#163; {{number_format($menuValue->item_price,2)}}</td>
                                                </tr>

                                                <tr>
                                                    <th>Removable ingredients</th>
                                                    @if($menuValue->getRemoveing)
                                                    @forelse($menuValue->getRemoveing as $rwData)
                                                    <td colspan="">{{$rwData->ingredients_name}}</td>
                                                    @empty
                                                    <td>Data not available</td>
                                                    @endforelse
                                                    @else
                                                    <td>
                                                        <center>-</center>
                                                    </td>
                                                    @endif
                                                </tr>

                                                @endforeach
                                                <tr>
                                                    <td colspan="4" style="text-align: right"><b>Total</b></td>
                                                    <td>&#163; {{number_format($total,2)}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    @endif

                                </div>








                            </div>
                        </div>
                    </div>

                </div> <!-- End Row -->
            </div>
        </div>
    </div>
    <!-- sample modal content -->
    <div id="custom-width-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title m-0" id="custom-width-modalLabel">Change Order Status</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="hidden" id="orderid" />
                                <input type="hidden" id="userid" />
                                <select class="select2 form-control" id="order_status">
                                    <option value="">Select Order Status</option>
                                </select>
                                <span id="order_statuserror" class=" name-error text-primary"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="return submitStatus();" class="btn btn-primary waves-effect waves-light">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- sample modal content -->
    <div id="custom-width-modal-deliverperson" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title m-0" id="custom-width-modalLabel">Add Delivery Person</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="hidden" id="orderidd" />
                                <select class="select2 form-control" id="delivery_person">
                                    <option value="">Select Delivery Person</option>
                                </select>
                                <span id="order_deliveryperson" class=" name-error text-primary"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="return assignDeliveryPerson();" class="btn btn-primary waves-effect waves-light">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- sample modal content -->
    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content cur-content">
                <div class="modal-header cur-header">
                    <h4 class="modal-title m-0" id="custom-width-modalLabel">Track Order</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body cur-body">

                    <div class="cur-order-main">
                        <div class="cur-order-inner">
                            <div class="cur-between">
                                <p class="arrival-tit">Estimated Arrival</p>
                                <p class="arrival-tit">Order Number</p>
                            </div>
                            @php
                            $time = date('H:i:s',strtotime($orderData[0]->order_date_time));
                            $estimatedHour = date('H:i:s', strtotime($time . ' +'.$orderData[0]->estimated_min.' minutes'));
                            $estimated_arrival = date('h:i A', strtotime($orderData[0]->order_date_time)) .' - '. date("h:i A",strtotime($estimatedHour));
                            @endphp
                            <div class="cur-between">
                                <p class="curtime">{{$estimated_arrival}}</p>
                                <p class="curid">#{{$orderData[0]->order_number}}</p>
                            </div>
                        </div>
                        @php
                        if($orderData[0]->order_type == '1'){
                        if($orderData[0]->order_status == 'Order Confirmed'){
                        $orderconfrimData = 'block';
                        $preparingorderData = 'none';
                        $orderonthewayData = 'none';
                        $deleiveredData = 'none';
                        $orderacceptData = 'none';
                        $orderrejectData = 'none';
                        $ordertisway = 'none';
                        $showUrl = 'block';
                        }else if($orderData[0]->order_status == 'Accepted Order'){
                        $orderacceptData = 'block';
                        $orderconfrimData = 'none';
                        $preparingorderData = 'none';
                        $orderonthewayData = 'none';
                        $deleiveredData = 'none';
                        $orderrejectData = 'none';
                        $ordertisway = 'none';
                        $showUrl = 'block';
                        }else if($orderData[0]->order_status == 'Rejected Order'){
                        $orderrejectData = 'block';
                        $orderacceptData = 'none';
                        $orderconfrimData = 'none';
                        $preparingorderData = 'none';
                        $orderonthewayData = 'none';
                        $ordertisway = 'none';
                        $deleiveredData = 'none';
                        $showUrl = 'block';
                        }else if($orderData[0]->order_status == 'Preparing your Order'){
                        $orderconfrimData = 'block';
                        $preparingorderData = 'block';
                        $orderacceptData = 'block';
                        $orderonthewayData = 'none';
                        $deleiveredData = 'none';
                        $orderrejectData = 'none';
                        $ordertisway = 'none';
                        $showUrl = 'block';
                        }else if($orderData[0]->order_status == 'Your orders are on its way'){
                        $orderconfrimData = 'block';
                        $preparingorderData = 'block';
                        $orderonthewayData = 'block';
                        $orderacceptData = 'block';
                        $deleiveredData = 'none';
                        $orderrejectData = 'none';
                        $ordertisway = 'none';
                        $showUrl = 'block';
                        }else if($orderData[0]->order_status == 'Delivered'){
                        $orderconfrimData = 'block';
                        $preparingorderData = 'block';
                        $orderonthewayData = 'block';
                        $orderacceptData = 'block';
                        $deleiveredData = 'block';
                        $orderrejectData = 'none';
                        $ordertisway = 'none';
                        $showUrl = 'block';
                        }else{
                        $orderconfrimData = 'block';
                        $preparingorderData = 'none';
                        $orderonthewayData = 'none';
                        $deleiveredData = 'none';
                        $orderacceptData = 'none';
                        $orderrejectData = 'none';
                        $ordertisway = 'none';
                        $showUrl = 'block';
                        }
                        }
                        if($orderData[0]->order_type == '2'){
                        if($orderData[0]->order_status == 'Order Confirmed'){
                        $orderconfrimData = 'block';
                        $preparingorderData = 'none';
                        $orderonthewayData = 'none';
                        $deleiveredData = 'none';
                        $orderacceptData = 'none';
                        $orderrejectData = 'none';
                        $ordertisway = 'none';
                        $showUrl = 'block';
                        }else if($orderData[0]->order_status == 'Accepted Order'){
                        $orderacceptData = 'block';
                        $orderconfrimData = 'block';
                        $preparingorderData = 'none';
                        $orderonthewayData = 'none';
                        $deleiveredData = 'none';
                        $orderrejectData = 'none';
                        $showUrl = 'none';
                        $ordertisway = 'none';
                        }else if($orderData[0]->order_status == 'Rejected Order'){
                        $orderrejectData = 'block';
                        $orderacceptData = 'none';
                        $orderconfrimData = 'block';
                        $preparingorderData = 'none';
                        $orderonthewayData = 'none';
                        $ordertisway = 'none';
                        $deleiveredData = 'none';
                        $showUrl = 'none';
                        }else{
                        $orderconfrimData = 'block';
                        $preparingorderData = 'none';
                        $orderonthewayData = 'none';
                        $deleiveredData = 'none';
                        $orderacceptData = 'none';
                        $orderrejectData = 'none';
                        $ordertisway = 'none';
                        $showUrl = 'block';
                        }
                        }
                        if($orderData[0]->order_type == '3'){
                        if($orderData[0]->order_status == 'Order Confirmed'){
                        $orderconfrimData = 'block';
                        $preparingorderData = 'none';
                        $orderonthewayData = 'none';
                        $deleiveredData = 'none';
                        $ordertisway = 'none';
                        $orderacceptData = 'none';
                        $orderrejectData = 'none';
                        $showUrl = 'block';
                        }else if($orderData[0]->order_status == 'Accepted Order'){
                        $orderacceptData = 'block';
                        $orderconfrimData = 'none';
                        $preparingorderData = 'none';
                        $orderonthewayData = 'none';
                        $deleiveredData = 'none';
                        $ordertisway = 'none';
                        $orderrejectData = 'none';
                        $showUrl = 'block';
                        }else if($orderData[0]->order_status == 'Rejected Order'){
                        $orderrejectData = 'block';
                        $orderacceptData = 'none';
                        $orderconfrimData = 'none';
                        $preparingorderData = 'none';
                        $orderonthewayData = 'none';
                        $deleiveredData = 'none';
                        $ordertisway = 'none';
                        $showUrl = 'block';
                        }else if($orderData[0]->order_status == 'Preparing your Order'){
                        $orderconfrimData = 'block';
                        $preparingorderData = 'block';
                        $orderacceptData = 'block';
                        $orderonthewayData = 'none';
                        $deleiveredData = 'none';
                        $orderrejectData = 'none';
                        $ordertisway = 'none';
                        $showUrl = 'block';
                        }else if($orderData[0]->order_status == 'Your Order is ready'){
                        $orderconfrimData = 'block';
                        $preparingorderData = 'block';
                        $orderacceptData = 'block';
                        $orderonthewayData = 'none';
                        $deleiveredData = 'none';
                        $orderrejectData = 'none';
                        $ordertisway = 'none';
                        $showUrl = 'block';
                        }else if($orderData[0]->order_status == 'Your orders are on its way'){
                        $ordertisway = 'block';
                        $orderconfrimData = 'block';
                        $preparingorderData = 'block';
                        $orderonthewayData = 'block';
                        $orderacceptData = 'block';
                        $deleiveredData = 'none';
                        $orderrejectData = 'none';
                        $showUrl = 'block';
                        }else if($orderData[0]->order_status == 'Delivered'){
                        $orderconfrimData = 'block';
                        $preparingorderData = 'block';
                        $orderonthewayData = 'block';
                        $orderacceptData = 'block';
                        $deleiveredData = 'block';
                        $ordertisway = 'block';
                        $orderrejectData = 'none';
                        $showUrl = 'block';
                        }else{
                        $orderconfrimData = 'block';
                        $preparingorderData = 'none';
                        $orderonthewayData = 'none';
                        $deleiveredData = 'none';
                        $orderacceptData = 'none';
                        $orderrejectData = 'none';
                        $ordertisway = 'none';
                        $showUrl = 'block';
                        }
                        }

                        @endphp
                        <div class="stepdesign-main">
                            <div class="">
                                <ul class="step-ul">

                                    <li id="orderconfrimData" style="display:{{$orderconfrimData}}">
                                        <div class="step-ul-inner">
                                            <div class="line"></div>
                                            <img src="{{asset('/OrderConfirmed.png')}}" alt="">
                                            <p class="step-text">Order Confirmed</p>
                                        </div>
                                    </li>
                                    <li id="orderacceptData" style="display:{{$orderacceptData}}">
                                        <div class="step-ul-inner">
                                            <div class="line" style="display:{{$showUrl}}"></div>
                                            <img src="{{asset('/OrderConfirmed.png')}}" alt="">
                                            <p class="step-text">Accepted Order</p>
                                        </div>
                                    </li>
                                    <li id="orderrejectData" style="display:{{$orderrejectData}}">
                                        <div class="step-ul-inner">
                                            <div class="line" style="display:{{$showUrl}}"></div>
                                            <img src="{{asset('/Orderreject.png')}}" alt="">
                                            <p class="step-text">Rejected Order</p>
                                        </div>
                                    </li>
                                    <li id="preparingorderData" style="display:{{$preparingorderData}}">
                                        <div class="step-ul-inner">
                                            <div class="line"></div>
                                            <img src="{{asset('/PreparingyourOrder.png')}}" alt="">
                                            <p class="step-text">Preparing your Order</p>
                                        </div>
                                    </li>
                                    <li id="ordertisway" style="display:{{$ordertisway}}">
                                        <div class="step-ul-inner">
                                            <div class="line"></div>
                                            <img src="{{asset('/OrderConfirmed.png')}}" alt="">
                                            <p class="step-text">Your Order is ready</p>
                                        </div>
                                    </li>
                                    <li id="orderonthewayData" style="display:{{$orderonthewayData}}">
                                        <div class="step-ul-inner">
                                            <div class="line"></div>
                                            <img src="{{asset('/Yourordersareonitsway.png')}}" alt="">
                                            <p class="step-text">Your orders are on its way</p>
                                        </div>
                                    </li>

                                    <li id="deleiveredData" style="display:{{$deleiveredData}}">
                                        <div class="step-ul-inner">
                                            <div class="line"></div>
                                            <img src="{{asset('/Delivered.png')}}" alt="">
                                            <p class="step-text">Delivered</p>
                                        </div>
                                    </li>
                                </ul>




                            </div>

                        </div>
                    </div>

                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- sample modal content -->
    <div id="myrejectModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content cur-content">
                <div class="modal-header cur-header">
                    <h4 class="modal-title m-0" id="custom-width-modalLabel">Reject Order</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body cur-body">

                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="hidden" id="o_id" />
                            <input type="hidden" id="user_order_id" />
                            <label>Reason<span style="color:red">*</span></label>
                            <textarea id="reject_reason" placeholder="Reason" class="form-control"></textarea>
                            <span id="reject_reasonerror" class=" name-error text-primary"></span>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" onclick="return rejectOrdersdata();" class="btn btn-primary waves-effect waves-light">Save changes</button>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
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

        function openDropDownforstatus(id, userid, orderstatus) {
            $("#orderid").val(id);
            $("#userid").val(userid);
            $("#custom-width-modal").modal('show');
            var statusVal = '';

            if (orderstatus == 'Accepted Order') {
                statusVal += '<option value="Preparing your Order">Preparing your Order</option><option value="Your orders are on its way">Your orders are on its way</option><option value="Delivered">Delivered</option>';
            } else if (orderstatus == 'Preparing your Order') {
                statusVal += '<option value="Your orders are on its way">Your orders are on its way</option><option value="Delivered">Delivered</option>';
            } else if (orderstatus == 'Your orders are on its way') {
                statusVal += '<option value="Delivered">Delivered</option>';
            }
            $("#order_status").append(statusVal);
            $("#order_status").select2().trigger("change");
        }

        function rejectOrdersdata() {
            var reject_reason = $("#reject_reason").val();
            var orderid = $("#o_id").val();
            var userid = $("#user_order_id").val();
            if (reject_reason.trim() == '') {
                $("#reject_reasonerror").html("Please enter Reason");
                return false;
            } else {
                $("#reject_reasonerror").html("");
                $.ajax({
                    async: false,
                    global: false,
                    url: "<?php echo URL::to('/'); ?>/rejectOrderstatus",
                    type: "POST",
                    data: {
                        orderid: orderid,
                        userid: userid,
                        reject_reason: reject_reason,
                        _token: "<?php echo csrf_token(); ?>"
                    },
                    success: function(response) {
                        if (response == 1) {
                            toastr.success("Order rejected successfully");
                            location.reload();
                        } else {
                            toastr.error("Something went wrong");
                        }
                    }
                });
            }

        }

        function submitStatus(order_status, orderid, userid) {
            var orderType = '{{$orderData[0]->order_type}}';
            var deliveryPerson = '{{$orderData[0]->delivery_person_id}}';
            /*if (order_status == 'Delivered') {
                if (orderType == '3') {
                    if (deliveryPerson == '') {
                        alert('Please add delivery person to this order.');
                        return false;
                    }
                }
            }*/


            $.ajax({
                async: false,
                global: false,
                url: "<?php echo URL::to('/'); ?>/changeOrderstatus",
                type: "POST",
                data: {
                    orderid: orderid,
                    userid: userid,
                    order_status: order_status,
                    _token: "<?php echo csrf_token(); ?>"
                },
                success: function(response) {
                    if (response == 1) {
                        toastr.success("Order Status changed successfully");
                        location.reload();
                    } else {
                        toastr.error("Something went wrong");
                    }
                }
            });
        }


        function opentrackStatus(id) {
            $("#myModal").modal('show');
        }

        function rejectOrders(id, userid) {
            $("#o_id").val(id);
            $("#user_order_id").val(userid);
            $("#reject_reason").val('');
            $("#reject_reasonerror").html("");
            $("#myrejectModal").modal('show');
        }

        function acceptOrders(id, userid) {
            if (confirm("Are you sure you want to Accept this Order") == true) {
                $.ajax({
                    async: false,
                    global: false,
                    url: "<?php echo URL::to('/'); ?>/acceptOrders",
                    type: "POST",
                    data: {
                        orderid: id,
                        userid: userid,
                        order_status: 'Accepted Order',
                        _token: "<?php echo csrf_token(); ?>"
                    },
                    success: function(response) {
                        if (response == 1) {
                            toastr.success("Order accepted successfully");
                            location.reload();
                        } else {
                            toastr.error("Something went wrong");
                        }
                    }
                });
            } else {
                return false;
            }
        }

        function assignDeliveryPerson() {
            var orderidd = $("#orderidd").val();
            var delivery_person = $("#delivery_person").val();
            if (delivery_person == '') {
                $("#order_deliveryperson").html("Please select Delivery Person");
                return false;
            }
            $("#order_deliveryperson").html("");
            $.ajax({
                async: false,
                global: false,
                url: "<?php echo URL::to('/'); ?>/addDeliverypersons",
                type: "POST",
                data: {
                    orderidd: orderidd,
                    delivery_person: delivery_person,
                    _token: "<?php echo csrf_token(); ?>"
                },
                success: function(response) {
                    if (response == 1) {
                        toastr.success("Delivery person addedd successfully");
                        location.reload();
                    } else {
                        toastr.error("Something went wrong");
                    }
                }
            });

        }
        /*
        function opentDeliveryPerson(id) {
            $("#orderidd").val(id);
            $.ajax({
                async: false,
                global: false,
                url: "<?php echo URL::to('/'); ?>/getDeliveryperson",
                type: "POST",
                data: {
                    orderid: id,
                    _token: "<?php echo csrf_token(); ?>"
                },
                success: function(response) {
                    if (response != '') {
                        var temp = '';
                        var json = $.parseJSON(response);

                        $.each(json, function(index, value) {
                            temp += '<option value=' + value.id + '>' + value.delivery_person_name + '</option>';
                        });



                        $("#delivery_person").append(temp);
                        $("#delivery_person").select2().trigger("change");
                        $("#custom-width-modal-deliverperson").modal('show');
                    } else {
                        toastr.error("Not available any delivery person right now");
                    }
                }
            });

        }
        */
        $(document).ready(function() {
            $("#orderReportmenu_a").addClass('waves-effect active subdrop');
            $("#orderReportmenu_ul").css('display', 'block');
        });
    </script>
    @endsection