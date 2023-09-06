<x-app-layout>

    <div class="content">
        <h4><b>Edit Report</b></h4>
        
        <div class="block block-rounded">
            <div class="block-content block-content-full bg-pattern">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>ID Report</label>
                            <input type="text" class="form-control" name="id" value="{{ $visit->id }}" disabled>
                        </div>
                        <div class="form-group row">
                            <label class="col-12">ID Visit</label>
                            <div class="col-md-12">
                                <select class="form-control @error('visit') is-invalid @enderror" name="visit" disabled>
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
                                <input type="text" class="form-control" name="visit_time" value="{{ Carbon\Carbon::parse($visit->visit->time)->format('H:i') }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Customer - Company Name</label>
                            <input type="text" class="form-control" name="customer" value="{{ $visit->visit->customer->name . " - " . $visit->visit->customer->company }}" disabled>
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" class="form-control" name="phone" value="{{ $visit->visit->customer->phone }}" disabled>
                        </div>
                        <div class="form-group">
                            <label>Sales Email</label>
                            <input type="email" class="form-control" name="email" value="{{ $visit->visit->customer->email }}" disabled>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label class="col-12">Status</label>
                            <div class="col-md-12">
                                <select class="form-control @error('status') is-invalid @enderror" name="status" disabled>
                                    <option value="0" selected disabled>Please select</option>
                                    <option {{ $visit->status == 'Budgeting' ? 'selected' : '' }}>Budgeting</option>
                                    <option {{ $visit->status == 'Feed' ? 'selected' : '' }}>Feed</option>
                                    <option {{ $visit->status == 'Bidding' ? 'selected' : '' }}>Bidding</option>
                                    <option {{ $visit->status == 'Buying' ? 'selected' : '' }}>Buying</option>
                                    <option {{ $visit->status == 'Win' ? 'selected' : '' }}>Win</option>
                                    <option {{ $visit->status == 'Lost' ? 'selected' : '' }}>Lost</option>
                                </select>
                                @error('status')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Next Visit Schedule</label>
                            <input type="date" class="form-control @error('next_date_visit') is-invalid @enderror" name="next_date_visit" value="{{ $visit->next_date_visit }}" readonly>
                            @error('next_date_visit')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Time</label>
                            <input type="time" class="form-control @error('next_time_visit') is-invalid @enderror" name="next_time_visit" value="{{ $visit->next_time_visit }}" readonly>
                            @error('next_time_visit')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-12">Note / Description</label>
                            <div class="col-12">
                                <textarea class="form-control @error('note') is-invalid @enderror" name="note" rows="6" readonly>{{ $visit->note }}</textarea>
                                @error('note')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-12">Planing</label>
                            <div class="col-12">
                                <textarea class="form-control @error('planing') is-invalid @enderror" name="planing" rows="6" readonly>{{ $visit->planing }}</textarea>
                                @error('planing')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 text-center">
                        <a href="{{ route('crm.visit-report') }}" readonly class="btn btn-hero btn-danger text-white mr-3 mb-2"><i class="fa fa-arrow-circle-left mr-2"></i>BACK</a>
                    </div>
                </div>
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
        </script>
    </x-slot>

</x-app-layout>
