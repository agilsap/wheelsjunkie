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
                PAYMENT CONFIRMATION
            </div>
            <div class="row my-5 p-3 card">
                <div class="col-sm-12">
                    <div class="row d-flex flex-column">
                        Transaction ID : {{$transaction->transaction_id}}
                        <h4 class="pt-2"><strong>TOTAL : Rp{{$transaction->transaction_total_cost}}</strong></h4>
                    </div>
                    <div class="row">
                        <h5>Please pay the specified ammount to this Bank Account Number:</h5>
                    </div>
                    <div class="row">
                        <h5><strong>BCA 12345667 (Ivan)</strong></h5>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-sm-12">
                    <div class="card">
                        <form action="{{route('transaction.store',$transaction->transaction_id)}}"
                            class="form-horizontal" enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="card-header purple-brand text-white">
                                <h3 class="card-title cardTitle">Upload Payment Receipt</h3>
                            </div>
                            <div class="card-body px-5 mx-5">
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                        <h5 class="control-label">Transaction ID<strong class="required_red">*</strong>
                                        </h5>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" value="" name="transaction_id" class="form-control"
                                            id="transaction_id" placeholder="Transaction ID" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                        <h5 class="control-label">Account Holder Name<strong
                                                class="required_red">*</strong></h5>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" value="" name="bank_account_owner" class="form-control"
                                            id="bank_account_owner" placeholder="Account Holder Name" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                        <h5 class="control-label">Payment Date <strong class="required_red">*</strong>
                                        </h5>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="date" value="" name="payment_date" class="form-control"
                                            id="payment_date" placeholder="Payment Date" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                        <h5 class="control-label">Fund Transfer Receipt <strong
                                                class="required_red">*</strong></h5>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="custom-file ">
                                            <input type="file" name="proof_of_payment" id="proof_of_payment"
                                                class="custom-file-input form-control" required />
                                            {{-- <label class="custom-file-label" for="property_picture" class="custom-file-label">Choose File</label> --}}
                                            <label class="custom-file-label" for="custom-file"
                                                class="custom-file-label">Choose File</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                        <h5 class="control-label">Additional Information</h5>
                                    </div>
                                    <div class="col-md-7">
                                        <textarea name="additional_info" class="form-control" id="additional_info"
                                            placeholder="Additional Information"></textarea>
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
<script src="{{asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
<script>
    $(function () {
        bsCustomFileInput.init();
    });
</script>