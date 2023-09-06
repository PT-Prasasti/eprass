<x-app-layout>

    <div class="content">
        <h4><b>Edit Sales</b></h4>
        
        <div class="block block-rounded">
            <div class="block-content block-content-full bg-pattern">
                <form action="{{ route('data-master.sales.store-edit') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="uuid" value="{{ $sales->uuid }}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Sales Name *</label>
                                <input type="text" class="form-control @error('sales_name') is-invalid @enderror" name="sales_name" value="{{ $sales->name }}" required>
                                @error('sales_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Email *</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $sales->email }}" required>
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Phone / HP *</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $sales->phone }}" required>
                                @error('phone')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Alternate Contact No</label>
                                <input type="text" class="form-control @error('alternate') is-invalid @enderror" name="alternate" value="{{ $sales->alternate }}">
                                @error('alternate')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-12">Profile Picture</label>
                                @if ($sales->profile_picture != NULL)
                                <img src="{{ Storage::url($sales->profile_picture) }}" alt="File Image" style="width: 70px;" class="mb-2 ml-3">
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
                                <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ $sales->username }}">
                                @error('username')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ $sales->password }}">
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label class="col-12">Tanda Tangan</label>
                                <div class="col-12">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input js-custom-file-input-enabled" name="sign" data-toggle="custom-file-input" accept="image/*">
                                        <label id="label-sign" class="custom-file-label" for="sign">Choose file</label>
                                    </div>
                                    @if (isset($sales->sign))
                                    <img src="{{ $sales->sign }}" alt="tanda-tangan" class="mt-2" style="width: 200px; height: 80px;">
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <a href="{{ route('data-master.sales') }}" class="btn btn-hero btn-danger text-white mr-3"><i class="fa fa-arrow-circle-left mr-2"></i>BACK</a>
                            <button type="submit" class="btn btn-hero btn-alt-primary"><i class="fa fa-check mr-2"></i>EDIT SALES</button>
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
        @if (Session::has('erorr'))
        <script>
            toastr.erorr("{{ Session::get('erorr') }}", 'Error!')
        </script> 
        @endif
    </x-slot>

</x-app-layout>
