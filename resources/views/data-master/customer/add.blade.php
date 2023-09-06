<x-app-layout>

    <div class="content">
        <h4><b>Add Customer</b></h4>
        
        <div class="block block-rounded">
            <div class="block-content block-content-full bg-pattern">
                <form action="{{ route('data-master.customer.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Customer Name *</label>
                                <input type="text" class="form-control @error('customer_name') is-invalid @enderror" name="customer_name" value="{{ old('customer_name') }}" required>
                                @error('customer_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Email *</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Phone / HP *</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required>
                                @error('phone')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Alternate Contact No</label>
                                <input type="text" class="form-control @error('alternate') is-invalid @enderror" name="alternate" value="{{ old('alternate') }}">
                                @error('alternate')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Company Name *</label>
                                <input type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name" value="{{ old('company_name') }}" required>
                                @error('company_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Telp. *</label>
                                <input type="text" class="form-control @error('company_phone') is-invalid @enderror" name="company_phone" value="{{ old('company_phone') }}" required>
                                @error('company_phone')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Fax</label>
                                <input type="text" class="form-control @error('company_fax') is-invalid @enderror" name="company_fax" value="{{ old('company_fax') }}">
                                @error('company_fax')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label class="col-12">Profile Picture</label>
                                <div class="col-12">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input js-custom-file-input-enabled" name="profile" data-toggle="custom-file-input" accept="image/*">
                                        <label id="label-profile" class="custom-file-label" for="profile">Choose file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}">
                                @error('username')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}">
                                @error('password')
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
                            <div class="form-group row">
                                <label class="col-12">Note</label>
                                <div class="col-12">
                                    <textarea class="js-summernote @error('address') is-invalid @enderror" name="note">{{ old('note') }}</textarea>
                                    @error('note')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-hero btn-alt-primary"><i class="fa fa-check mr-2"></i>ADD CUSTOMER</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-slot name="js">
        <script>
            $(document).ready(function() {
                $('input[name=profile]').change(function() {
                    var name = $(this).val().split("\\").pop()
                    $('#label-profile').html(name)
                })
                $('input[name=sign]').change(function() {
                    var name = $(this).val().split("\\").pop()
                    $('#label-sign').html(name)
                })
            })
        </script>
        @if (Session::has('error'))
        <script>
            toastr.error("{{ Session::get('error') }}", 'Error!')
        </script> 
        @endif
    </x-slot>

</x-app-layout>
