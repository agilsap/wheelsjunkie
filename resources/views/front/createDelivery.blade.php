@include('layouts.front-navbar')
<div class="container-fluid mt-5">
    <div class="row justify-content-center pt-3">
        <div class="col-sm-9">
            @if (session()->has('sukses'))
            <div class="alert alert-success alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <i class="icon fas fa-check"></i>
                <strong> {{ session()->get('sukses') }} </strong>
            </div>
            @endif
            @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <i class="icon fas fa-exclamation-triangle"></i>
                <strong> {{ session()->get('error') }} </strong>
            </div>
            @endif
            <div class="row page-title">
                Delivery Information
            </div>
            <div class="row my-5 p-3 card">
                <div class="col-sm-12">
                    <div class="row d-flex flex-column">
                        Transaction ID : {{$transaction->transaction_id}}
                        <h4 class="pt-2"><strong>TOTAL : Rp{{$transaction->transaction_total_cost}}</strong></h4>
                    </div>
                    <div class="row">
                        <h5>Product:</h5>
                    </div>
                    <div class="row">
                        <h5><strong>{{$product->product_name}}</strong></h5>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-sm-12">
                    <div class="card">
                        <form action="{{route('delivery.store',$transaction->transaction_id)}}" class="form-horizontal" enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="card-header purple-brand text-white">
                              <h3 class="card-title cardTitle">Details</h3>
                            </div>
                            <div class="card-body px-5 mx-5">
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                        <h5 class="control-label">Transaction ID<strong class="required_red">*</strong></h5>
                                    </div>
                                    <div class="col-md-7">
                                      <input type="text" value=""  name="transaction_id" class="form-control" id="transaction_id" placeholder="Transaction ID" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                        <h5 class="control-label">Courier Name<strong class="required_red">*</strong></h5>
                                    </div>
                                    <div class="col-md-7">
                                      <input type="text" value=""  name="courier_name" class="form-control" id="courier_name" placeholder="Courier Name" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                        <h5 class="control-label">Receipt Number<strong class="required_red">*</strong></h5>
                                    </div>
                                    <div class="col-md-7">
                                      <input type="text" value=""  name="receipt_number" class="form-control" id="receipt_number" placeholder="Receipt Number" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                        <h5 class="control-label">Delivery Date <strong class="required_red">*</strong></h5>
                                    </div>
                                    <div class="col-md-7">
                                      <input type="date" value=""  name="delivery_date" class="form-control" id="delivery_date" placeholder="Delivery Date" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                        <h5 class="control-label">Status<strong class="required_red">*</strong></h5>
                                    </div>
                                    <div class="col-md-7">
                                      <input type="text" value=""  name="status" class="form-control" id="status" placeholder="Status" required>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row justify-content-center">
                                    <button type="submit" class="btn btn-brand">
                                        <h3>Confirm</h3>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>