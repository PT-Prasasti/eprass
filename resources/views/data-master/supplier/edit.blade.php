<x-app-layout>

    <div class="content">
        <h4><b>Edit Supplier</b></h4>
        
        <div class="block block-rounded">
            <div class="block-content block-content-full bg-pattern">
                <form action="{{ route('data-master.supplier.store-edit') }}" method="POST">
                    @csrf
                    <input type="hidden" name="uuid" value="{{ $supplier->uuid }}">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Company Name *</label>
                                <input type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name" value="{{ $supplier->company }}" required>
                                @error('company_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Company Telephone *</label>
                                <input type="text" class="form-control @error('company_phone') is-invalid @enderror" name="company_phone" value="{{ $supplier->company_phone }}" required>
                                @error('company_phone')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Company Email *</label>
                                <input type="text" class="form-control @error('company_email') is-invalid @enderror" name="company_email" value="{{ $supplier->company_email }}" required>
                                @error('company_email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Item Spesialization</label>
                                <input type="text" class="form-control @error('item_spesialization') is-invalid @enderror" name="item_spesialization" value="{{ $supplier->item_spesialization }}">
                                @error('item_spesialization')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Sales Representative</label>
                                <input type="text" class="form-control @error('sales_representative') is-invalid @enderror" name="sales_representative" value="{{ $supplier->sales_rep }}">
                                @error('sales_representative')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Contact Number</label>
                                <input type="text" class="form-control @error('contact_number') is-invalid @enderror" name="contact_number" value="{{ $supplier->contact_number }}">
                                @error('contact_number')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Sales Email</label>
                                <input type="text" class="form-control @error('sales_email') is-invalid @enderror" name="sales_email" value="{{ $supplier->sales_email }}">
                                @error('sales_email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label class="col-12">Location</label>
                                <div class="col-md-12">
                                    <select class="form-control" name="location">
                                        <option value="0" selected disabled>Please select</option>
                                        <option value="1" {{ $supplier->location == '1' ? 'selected' : '' }}>Indonesia</option>
                                        <option value="2" {{ $supplier->location == '2' ? 'selected' : '' }}>Luar Negeri</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Bank Name</label>
                                <input type="text" class="form-control @error('bank_name') is-invalid @enderror" name="bank_name" value="{{ $supplier->bank_name }}">
                                @error('bank_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Bank Number</label>
                                <input type="text" class="form-control @error('bank_number') is-invalid @enderror" name="bank_number" value="{{ $supplier->bank_number }}">
                                @error('bank_number')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Bank Account</label>
                                <input type="text" class="form-control @error('bank_account') is-invalid @enderror" name="bank_account" value="{{ $supplier->bank_account }}">
                                @error('bank_account')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Bank Swift</label>
                                <input type="text" class="form-control @error('bank_swift') is-invalid @enderror" name="bank_swift" value="{{ $supplier->bank_swift }}">
                                @error('bank_swift')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-12">Address</label>
                                <div class="col-12">
                                    <textarea class="form-control @error('address') is-invalid @enderror" name="address" rows="6">{{ $supplier->address }}</textarea>
                                    @error('address')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <a href="{{ route('data-master.supplier') }}" class="btn btn-hero btn-danger text-white mr-3"><i class="fa fa-arrow-circle-left mr-2"></i>BACK</a>
                            <button type="submit" class="btn btn-hero btn-alt-primary"><i class="fa fa-check mr-2"></i>EDIT SUPPLIER</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-slot name="js">
        @if (Session::has('success'))
        <script>
            toastr.success("{{ Session::get('success') }}", 'Success')
        </script> 
        @endif
    </x-slot>

</x-app-layout>
