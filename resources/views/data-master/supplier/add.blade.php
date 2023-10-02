<x-app-layout>

    <div class="content">
        <h4><b>Add Supplier</b></h4>

        <div class="block block-rounded">
            <div class="block-content block-content-full bg-pattern">
                <form action="{{ route('data-master.supplier.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Company Name *</label>
                                <input type="text" class="form-control @error('company_name') is-invalid @enderror"
                                    name="company_name" value="{{ old('company_name') }}" required>
                                @error('company_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Company Telephone *</label>
                                <input type="text" class="form-control @error('company_phone') is-invalid @enderror"
                                    name="company_phone" value="{{ old('company_phone') }}" required>
                                @error('company_phone')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Company Email *</label>
                                <input type="email" class="form-control @error('company_email') is-invalid @enderror"
                                    name="company_email" value="{{ old('company_email') }}" required>
                                @error('company_email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Item Spesialization</label>
                                <input type="text"
                                    class="form-control @error('item_spesialization') is-invalid @enderror"
                                    name="item_spesialization" value="{{ old('item_spesialization') }}">
                                @error('item_spesialization')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Sales Representative *</label>
                                <input type="text"
                                    class="form-control @error('sales_representative') is-invalid @enderror"
                                    name="sales_representative" value="{{ old('sales_representative') }}" required>
                                @error('sales_representative')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Contact Number *</label>
                                <input type="text" class="form-control @error('contact_number') is-invalid @enderror"
                                    name="contact_number" value="{{ old('contact_number') }}">
                                @error('contact_number')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Sales Email *</label>
                                <input type="email" class="form-control @error('sales_email') is-invalid @enderror"
                                    name="sales_email" value="{{ old('sales_email') }}">
                                @error('sales_email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label class="col-12">Location *</label>
                                <div class="col-md-12">
                                    <select class="form-control" name="location" required>
                                        <option value="0" selected disabled>Please select</option>
                                        <option value="1">Indonesia</option>
                                        <option value="2">Luar Negeri</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Bank Name</label>
                                <input type="text" class="form-control @error('bank_name') is-invalid @enderror"
                                    name="bank_name" value="{{ old('bank_name') }}">
                                @error('bank_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Bank Number</label>
                                <input type="text" class="form-control @error('bank_number') is-invalid @enderror"
                                    name="bank_number" value="{{ old('bank_number') }}">
                                @error('bank_number')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Bank Account</label>
                                <input type="text" class="form-control @error('bank_account') is-invalid @enderror"
                                    name="bank_account" value="{{ old('bank_account') }}">
                                @error('bank_account')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Bank Swift</label>
                                <input type="text" class="form-control @error('bank_swift') is-invalid @enderror"
                                    name="bank_swift" value="{{ old('bank_swift') }}">
                                @error('bank_swift')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-12">Address *</label>
                                <div class="col-12">
                                    <textarea class="form-control @error('address') is-invalid @enderror" name="address" rows="6" required>{{ old('address') }}</textarea>
                                    @error('address')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-hero btn-alt-primary"><i
                                    class="fa fa-check mr-2"></i>ADD SUPPLIER</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>
