<x-app-layout>
    <div class="content">
        <h4><b>Add Forwarder</b></h4>

        <div class="block block-rounded">
            <div class="block-content block-content-full bg-pattern">
                <form action="{{ route('data-master.exim.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Forwarder Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="forwarder_name" required>
                            </div>
                            <div class="form-group">
                                <label>Forwarder Telephone <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="forwarder_telephone" required>
                            </div>
                            <div class="form-group">
                                <label>PIC Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control " name="pic_name" required>
                            </div>
                            <div class="form-group">
                                <label>PIC Phone <span class="text-danger">*</span></label>
                                <input type="text" class="form-control " name="pic_phone" required>
                            </div>
                            <div class="form-group">
                                <label>Forwarder Address <span class="text-danger">*</span></label>
                                <textarea class="form-control " name="forwarder_address" rows="6" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Bank Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control " name="bank_name" required>
                            </div>
                            <div class="form-group">
                                <label>Swift Code <span class="text-danger">*</span></label>
                                <input type="text" class="form-control " name="swift_code" required>
                            </div>
                            <div class="form-group">
                                <label>Bank Account <span class="text-danger">*</span></label>
                                <input type="text" class="form-control " name="bank_account" required>
                            </div>
                            <div class="form-group">
                                <label>Bank Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control " name="bank_number" required>
                            </div>
                            <div class="form-group">
                                <label>Bank Address <span class="text-danger">*</span></label>
                                <textarea class="form-control " name="bank_address" rows="6" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Bank Name</label>
                                <input type="text" class="form-control " name="bank_name_1" required>
                            </div>
                            <div class="form-group">
                                <label>Swift Code</label>
                                <input type="text" class="form-control " name="swift_code_1" required>
                            </div>
                            <div class="form-group">
                                <label>Bank Account</label>
                                <input type="text" class="form-control " name="bank_account_1" required>
                            </div>
                            <div class="form-group">
                                <label>Bank Number</label>
                                <input type="text" class="form-control " name="bank_number_1" required>
                            </div>
                            <div class="form-group">
                                <label>Bank Address</label>
                                <textarea class="form-control " name="bank_address_1" rows="6" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-hero btn-alt-primary"><i class="fa fa-check mr-2"></i>ADD FORWADER</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <x-slot name="js">
        <script>

        </script>
    </x-slot>
</x-app-layout>