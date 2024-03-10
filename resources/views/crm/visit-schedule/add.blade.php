<x-app-layout>

    <div class="content">
        <h4><b>Add Visit</b></h4>
        @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
        <div class="block block-rounded">
            <div class="block-content block-content-full bg-pattern">
                <form action="{{ route('crm.visit-schedule.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>ID Visit</label>
                                <input type="text" class="form-control @error('id') is-invalid @enderror" name="id" value="" readonly>
                                @error('id')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label class="col-12">Company<span class="text-danger"> *<span></label>
                                <div class="col-md-12">
                                    <select class="form-control @error('company') is-invalid @enderror" name="company" required>
                                        <option value="0" disabled selected>Please select</option>
                                    </select>
                                    @error('company')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Company Telephone</label>
                                <input type="text" class="form-control" name="company_phone" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Customer Name</label>
                                <input type="text" class="form-control" name="customer" disabled>
                            </div>
                            <div class="form-group">
                                <label>Contact Number</label>
                                <input type="text" class="form-control" name="customer_phone" disabled>
                            </div>
                            <div class="form-group">
                                <label>Customer Email</label>
                                <input type="email" class="form-control" name="customer_email" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <div class="col-6">
                                    <label>Visit By<span class="text-danger"> *<span></label>
                                    <select class="form-control @error('visit_by') is-invalid @enderror" name="visit_by" required>
                                        <option value="0" disabled selected>Please select</option>
                                        <option>Phone</option>
                                        <option>Email</option>
                                        <option>Onsite</option>
                                    </select>
                                    @error('visit_by')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <label>Division<span class="text-danger"> *<span></label>
                                    <input type="text" class="form-control @error('devision') is-invalid @enderror" name="devision" value="{{ old('devision') }}">
                                    @error('devision')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-6">
                                    <label>Date <span class="text-danger"> *<span></label>
                                    <input type="date" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ old('date') }}" required>
                                    @error('date')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <label>Time<span class="text-danger"> *<span></label>
                                    <input type="time" class="form-control @error('time') is-invalid @enderror" name="time" value="{{ old('time') }}">
                                    @error('time')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Transportation<span class="text-danger"> *<span></label>
                                <select class="form-control @error('') is-invalid @enderror" name="" required>
                                    <option value="0" disabled selected>Please select</option>
                                    <option>Ford Eco Sport</option>
                                    <option>Chevrolet Colorado</option>
                                    <option>Suzuki Granmax</option>
                                    <option>Yamaha Mx</option>
                                    <option>Other</option>
                                </select>
                                @error('visit_by')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-12">Schedule<span class="text-danger"> *<span></label>
                                <div class="col-12">
                                    <textarea class="form-control" name="schedule" rows="6">{{ old('schedule') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <hr>
                        </div>
                        <div class="col-md-12 mt-3">
                            <h5>Invite Other :</h5>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-12">Staff Email</label>
                                <div class="col-md-12">
                                    <select class="form-control" name="engineer[]" id="engineer" multiple="multiple">
                                        <option value="0">Please select</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-hero btn-alt-primary"><i class="fa fa-check mr-2"></i>ADD VISIT</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-slot name="js">
        <script>
            $(document).ready(function() {
                generateId()
                listCompany()
                $('select[name=company]').select2()
                $('select[name=company]').change(function() {
                    getCompanyDetail($(this).val())
                })
            })

            function generateId() {
                var url = "{{ route('crm.visit-schedule.id') }}"
                $.get(url, function(response) {
                    $('input[name=id]').val(response)
                })
            }

            function listCompany() {
                var url = "{{ route('crm.visit-schedule.company') }}"
                $.get(url, function(response) {
                    var element = ``
                    $.each(response, function(index, value) {
                        element += `<option value="` + value.uuid + `">` + value.company + `</option>`
                    })
                    $('select[name=company]').append(element)
                })
            }

            function getCompanyDetail(id) {
                var url = "{{ route('crm.visit-schedule.company-detail', ['id' => ':id']) }}"
                url = url.replace(':id', id)
                $.get(url, function(response) {
                    $('input[name=company_phone]').val(response.company_phone)
                    $('input[name=customer]').val(response.customer)
                    $('input[name=customer_phone]').val(response.customer_phone)
                    $('input[name=customer_email]').val(response.customer_email)
                })
            }
            $("#engineer").select2({
                ajax: {
                    url: `{{ route('crm.visit-schedule.search_enginer') }}`
                    , dataType: 'json'
                    , delay: 250
                    , processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.email
                                    , id: item.email
                                , }
                            })
                        };
                    }
                    , cache: true
                }
            })

        </script>
    </x-slot>

</x-app-layout>
