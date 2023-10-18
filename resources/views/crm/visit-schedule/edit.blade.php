<x-app-layout>

    <div class="content">
        <h4><b>Edit Visit</b></h4>
        
        <div class="block block-rounded">
            <div class="block-content block-content-full bg-pattern">
                <form action="{{ route('crm.visit-schedule.store-edit') }}" method="POST">
                    @csrf
                    <input type="hidden" name="uuid" value="{{ $visit->uuid }}">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>ID Visit</label>
                                <input type="text" class="form-control @error('id') is-invalid @enderror" name="id" value="{{ $visit->id }}" readonly>
                                @error('id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label class="col-12">Company</label>
                                <div class="col-md-12">
                                    <select class="form-control @error('company') is-invalid @enderror" name="company">
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
                                    <label>Visit By</label>
                                    <select class="form-control @error('visit_by') is-invalid @enderror" name="visit_by" required>
                                        <option value="0" disabled selected>Please select</option>
                                        <option {{ $visit->visit_by == 'Phone' ? 'selected' : '' }}>Phone</option>
                                        <option {{ $visit->visit_by == 'Email' ? 'selected' : '' }}>Email</option>
                                        <option {{ $visit->visit_by == 'Onsite' ? 'selected' : '' }}>Onsite</option>
                                    </select>
                                    @error('visit_by')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <label>Devision</label>
                                    <input type="text" class="form-control @error('devision') is-invalid @enderror" name="devision" value="{{ $visit->devision }}">
                                    @error('devision')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Date *</label>
                                <input type="date" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ $visit->date }}" required>
                                @error('date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Time</label>
                                <input type="time" class="form-control @error('time') is-invalid @enderror" name="time" value="{{ $visit->time }}">
                                @error('time')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-12">Schedule</label>
                                <div class="col-12">
                                    <textarea class="form-control" name="schedule" rows="6">{{ $visit->schedule }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <hr>
                        </div>
                        <div class="col-md-12 mt-3">
                            <h5>Invite Engineer :</h5>
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
                            <a href="{{ route('crm.visit-schedule') }}" class="btn btn-hero btn-danger text-white mr-3"><i class="fa fa-arrow-circle-left mr-2"></i>BACK</a>
                            <button type="submit" class="btn btn-hero btn-alt-primary"><i class="fa fa-check mr-2"></i>SAVE VISIT</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-slot name="js">
        <script>
            $(document).ready(function() {
                listCompany()
                $('select[name=company]').select2()
                $('select[name=company]').val("{{ $visit->customer->uuid }}")
                $('input[name=company_phone]').val("{{ $visit->customer->company_phone }}")
                $('input[name=customer]').val("{{ $visit->customer->name }}")
                $('input[name=customer_phone]').val("{{ $visit->customer->phone }}")
                $('input[name=customer_email]').val("{{ $visit->customer->email }}")
                $('select[name=company]').change(function() {
                    getCompanyDetail($(this).val())
                })
            })

            function listCompany()
            {
                var url = "{{ route('crm.visit-schedule.company') }}"
                $.get(url, function(response) {
                    var element = ``
                    $.each(response, function(index, value) {
                        element += `<option value="`+value.uuid+`">`+value.company+`</option>`
                    })
                    $('select[name=company]').append(element)
                })
            }

            function getCompanyDetail(id)
            {
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
                    url: `{{ route('crm.visit-schedule.search_enginer') }}`,
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.email,
                                    id: item.email,
                                }
                            })
                        };
                    },
                    cache: true
                }
            })
            let visitemail = `{{ $visit->enginer_email }}`
            let dataenginerexisting = JSON.parse(visitemail.replace(/&quot;/g,'"'))
            
            dataenginerexisting.forEach(element => {
                $('#engineer').append(
                    `<option value="${element}" selected>${element}</option>`
                );
            });
            

        </script>
    </x-slot>

</x-app-layout>
