<x-app-layout>

    <div class="content">
        <h4><b>Edit Report</b></h4>
        
        <div class="block block-rounded">
            <div class="block-content block-content-full bg-pattern">
                <form action="{{ route('crm.visit-report.store-edit') }}" method="POST">
                    @csrf
                    <input type="hidden" name="uuid" value="{{ $visit->uuid }}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-12">ID Visit</label>
                                <div class="col-md-12">
                                    <select class="form-control @error('visit') is-invalid @enderror" name="visit">
                                        <option value="0" selected disabled>Please select</option>
                                    </select>
                                    @error('visit')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-6">
                                    <label>Date</label>
                                    <input type="text" class="form-control" name="visit_date" value="{{ Carbon\Carbon::parse($visit->visit->date)->format('d M Y') }}" disabled>
                                </div>
                                <div class="col-6">
                                    <label>Time</label>
                                    <input type="text" class="form-control" name="visit_time" value="{{ isset($visit->visit->time) ? Carbon\Carbon::parse($visit->visit->time)->format('H:i') : '00:00' }}" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Customer - Company Name</label>
                                <input type="text" class="form-control" name="customer" value="{{ strtoupper($visit->visit->customer->name . " - " . $visit->visit->customer->company) }}" disabled>
                            </div>
                            <div class="form-group row">
                                <div class="col-6">
                                    <label>Phone</label>
                                    <input type="text" class="form-control" name="phone" value="{{ $visit->visit->customer->phone }}" disabled>
                                </div>
                                <div class="col-6">
                                    <label>Sales Email</label>
                                    <input type="email" class="form-control" name="email" value="{{ $visit->visit->customer->email }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-12">Status</label>
                                <div class="col-md-12">
                                    <select class="form-control @error('status') is-invalid @enderror" name="status">
                                        <option value="0" selected disabled>Please select</option>
                                        <option {{ $visit->status == 'Feed / Budgeting' ? 'selected' : '' }}>Feed / Budgeting</option>
                                        <option {{ $visit->status == 'Building' ? 'selected' : '' }}>Building</option>
                                        <option {{ $visit->status == 'Buying' ? 'selected' : '' }}>Buying</option>
                                    </select>
                                    @error('status')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12">Upload File (png,jpg,jpeg,pdf.xls.doc)</label>
                                <div class="col-12">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input js-custom-file-input-enabled" id="" name="" data-toggle="custom-file-input">
                                        <label class="custom-file-label" >Choose file</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <h5>Document List</h5>
                                    <div class="d-none align-items-center" id="loading-file">
                                        <div class="mr-2">
                                            <span>Uploading file</span>
                                        </div>
                                        <div class="spinner-border spinner-border-sm text-info" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                    <ul class="list-group">

                                    </ul>
                                </div>
                            </div>
                            <!-- <div class="form-group row">
                                <div class="col-md-6">
                                    <label>Next Visit Schedule</label>
                                    <input type="date" class="form-control @error('next_date_visit') is-invalid @enderror" name="next_date_visit" value="{{ $visit->next_date_visit }}">
                                    @error('next_date_visit')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label>Time</label>
                                    <input type="time" class="form-control @error('next_time_visit') is-invalid @enderror" name="next_time_visit" value="{{ $visit->next_time_visit }}">
                                    @error('next_time_visit')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12">Staff Email</label>
                                <div class="col-md-12">
                                    <select class="form-control" name="engineer[]" id="engineer" multiple="multiple">
                                        <option value="0">Please select</option>
                                    </select>
                                </div>
                            </div> -->
                        </div>
                        <div class="col-md-12">
                            <hr>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-12">Note / Description</label>
                                <div class="col-12">
                                    <textarea class="form-control @error('note') is-invalid @enderror" name="note" rows="6">{{ $visit->note }}</textarea>
                                    @error('note')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-12">Planning</label>
                                <div class="col-12">
                                    <textarea class="form-control @error('planing') is-invalid @enderror" name="planing" rows="6">{{ $visit->planing }}</textarea>
                                    @error('planing')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <a href="{{ route('crm.visit-report') }}" class="btn btn-hero btn-danger text-white mr-3 mb-2"><i class="fa fa-arrow-circle-left mr-2"></i>BACK</a>
                            <button type="submit" class="btn btn-hero btn-primary mb-2"><i class="fa fa-check mr-2"></i>SAVE REPORT</button><br>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-slot name="js">
        <script>
            $(document).ready(function() {
                listVisit()
                $('select[name=visit]').select2()
                $('select[name=visit]').val("{{ $visit->visit->uuid }}")
                $('select[name=visit]').change(function() {
                    getVisitDetail($(this).val())
                })
                
            })

            function listVisit()
            {
                var url = "{{ route('crm.visit-report.visit') }}"
                $.get(url, function(response) {
                    var element = ``
                    element += `<option value="{{ $visit->visit->uuid }}">{{ $visit->visit->id }}</option>`
                    $.each(response, function(index, value) {
                        element += `<option value="`+value.uuid+`">`+value.id+`</option>`
                    })
                    $('select[name=visit]').append(element)
                })
            }

            function getVisitDetail(id)
            {
                var url = "{{ route('crm.visit-report.visit-detail', ['id' => ':id']) }}"
                url = url.replace(':id', id)
                $.get(url, function(response) {
                    $('input[name=visit_date]').val(response.visit_date)
                    $('input[name=visit_time]').val(response.visit_time)
                    $('input[name=customer]').val(response.customer)
                    $('input[name=phone]').val(response.phone)
                    $('input[name=email]').val(response.email)
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
            let visitemail = `{{ $visit->visit->enginer_email }}`
            let dataenginerexisting = JSON.parse(visitemail.replace(/&quot;/g,'"'))

            dataenginerexisting.forEach(element => {
                $('#engineer').append(
                    `<option value="${element}" selected>${element}</option>`
                );
            });
        </script>
    </x-slot>

</x-app-layout>
