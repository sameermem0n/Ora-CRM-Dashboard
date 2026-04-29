<div class="row">
    <div class="col-md-12">
        <div class="card-box">
            <form action="{{Route('paymint.store')}}" method="post" class="parsley-examples" novalidate="">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Client <span class="text-danger">*</span></label>
                            <select wire:model="clientid" name="clientid" class="form-control" required>
                                <option value="">Select Client</option>
                                @foreach($clients as $val)
                                <option value="{{$val->id}}">{{$val->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Invoice ID<span class="text-danger">*</span></label>
                            <select name="invoice_id" class="form-control" required>
                                <option value="">Select Invoice</option>
                                @foreach($invoices as $val)
                                <option value="{{$val->id}}">{{$val->id}}</option>
                                @endforeach
                            </select>
                        </div> 
                    </div>
                </div>
                <div class="form-group text-left mb-0">
                    <button class="btn btn-primary waves-effect waves-light mr-1" type="submit">
                        View
                    </button>
                    <button type="reset" class="btn btn-secondary waves-effect waves-light">
                        Cancel
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>