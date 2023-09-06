<x-app-layout>

    <div class="content">
        <h4><b>Edit Customer</b></h4>
        
        <div class="block block-rounded">
            <div class="block-content block-content-full bg-pattern">
                <form action="{{ route('data-master.customer.store-edit') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="uuid" value="{{ $customer->uuid }}">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Customer Name *</label>
                                <input type="text" class="form-control @error('customer_name') is-invalid @enderror" name="customer_name" value="{{ $customer->name }}" required>
                                @error('customer_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Email *</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $customer->email }}" required>
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Phone / HP *</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $customer->phone }}" required>
                                @error('phone')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Alternate Contact No</label>
                                <input type="text" class="form-control @error('alternate') is-invalid @enderror" name="alternate" value="{{ $customer->alternate }}">
                                @error('alternate')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Company Name *</label>
                                <input type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name" value="{{ $customer->company }}" required>
                                @error('company_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Telp. *</label>
                                <input type="text" class="form-control @error('company_phone') is-invalid @enderror" name="company_phone" value="{{ $customer->company_phone }}" required>
                                @error('company_phone')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Fax</label>
                                <input type="text" class="form-control @error('company_fax') is-invalid @enderror" name="company_fax" value="{{ $customer->company_fax }}">
                                @error('company_fax')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label class="col-12">Profile Picture</label>
                                @if ($customer->profile_picture != NULL)
                                <img src="{{ Storage::url($customer->profile_picture) }}" alt="File Image" style="width: 70px;" class="mb-2 ml-3">
                                @endif
                                <div class="col-12">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input js-custom-file-input-enabled" name="profile" data-toggle="custom-file-input" accept="image/*">
                                        <label class="custom-file-label" for="profile">Choose file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ $customer->username }}">
                                @error('username')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ $customer->password }}">
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-12">Address *</label>
                                <div class="col-12">
                                    <textarea class="form-control @error('address') is-invalid @enderror" name="address" rows="6" required>{{ $customer->address }}</textarea>
                                    @error('address')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12">Note</label>
                                <div class="col-12">
                                    <textarea class="js-summernote @error('address') is-invalid @enderror" name="note">{{ $customer->note }}</textarea>
                                    @error('note')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <a href="{{ route('data-master.customer') }}" class="btn btn-hero btn-danger text-white mr-3"><i class="fa fa-arrow-circle-left mr-2"></i>BACK</a>
                            <button type="submit" class="btn btn-hero btn-alt-primary"><i class="fa fa-check mr-2"></i>EDIT CUSTOMER</button>
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
