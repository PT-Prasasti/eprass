<x-app-layout>

    <div class="content">
        <h4><b>Add Report</b></h4>
        
        <div class="block block-rounded">
            <div class="block-content block-content-full bg-pattern">
                <form action="{{ route('crm.visit-report.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-12">ID Visit</label>
                                <div class="col-md-12">
                                    @if (isset($data))         
                                    <input type="hidden" name="visit" value="{{ $data['uuid'] }}">                               
                                    <select class="form-control @error('visit') is-invalid @enderror" name="" disabled>
                                        <option value="0" selected>{{ $data['id'] }}</option>
                                    </select>
                                    @else
                                    <select class="form-control @error('visit') is-invalid @enderror" name="visit">
                                        <option value="0" selected disabled>Please select</option>
                                    </select>
                                    @endif
                                    @error('visit')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-6">
                                    <label>Date</label>
                                    @if (isset($data))
                                    <input type="text" class="form-control" name="visit_date" value="{{ $data['visit_date'] }}" disabled>
                                    @else
                                    <input type="text" class="form-control" name="visit_date" disabled>
                                    @endif
                                </div>
                                <div class="col-6">
                                    <label>Time</label>
                                    @if (isset($data))
                                    <input type="text" class="form-control" name="visit_time" value="{{ $data['visit_time'] }}" disabled>
                                    @else
                                    <input type="text" class="form-control" name="visit_time" disabled>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Customer - Company Name</label>
                                @if (isset($data))
                                <input type="text" class="form-control" name="customer" value="{{ $data['customer'] }}" disabled>
                                @else
                                <input type="text" class="form-control" name="customer" disabled>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Phone</label>
                                @if (isset($data))
                                <input type="text" class="form-control" name="phone" value="{{ $data['phone'] }}" disabled>
                                @else
                                <input type="text" class="form-control" name="phone" disabled>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                @if (isset($data))
                                <input type="email" class="form-control" name="email" value="{{ $data['email'] }}" disabled>
                                @else
                                <input type="email" class="form-control" name="email" disabled>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-12">Status *</label>
                                <div class="col-md-12">
                                    <select class="form-control @error('status') is-invalid @enderror" name="status" required>
                                        <option value="0" selected disabled>Please select</option>
                                        <option>Budgeting</option>
                                        <option>Feed</option>
                                    </select>
                                    @error('status')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-6">
                                    <label>Next Visit Schedule</label>
                                    <input type="date" class="form-control @error('next_date_visit') is-invalid @enderror" name="next_date_visit" value="{{ old('next_date_visit') }}">
                                    @error('next_date_visit')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <label>Time</label>
                                    <input type="time" class="form-control @error('next_time_visit') is-invalid @enderror" name="next_time_visit" value="{{ old('next_time_visit') }}">
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
                            </div>
                        </div>
                        <div class="col-md-12">
                            <hr>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-12">Note / Description</label>
                                <div class="col-12">
                                    <textarea class="form-control @error('note') is-invalid @enderror" name="note" rows="6">{{ old('note') }}</textarea>
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
                                    <textarea class="form-control @error('planing') is-invalid @enderror" name="planing" rows="6">{{ old('planing') }}</textarea>
                                    @error('planing')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-hero btn-primary mb-2"><i class="fa fa-check mr-2"></i>ADD REPORT</button><br>
                            <button type="submit" class="btn btn-hero btn-success"><i class="fa fa-save mr-2"></i>SAVE REPORT & CREATED INQUIRY</button>
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
                listVisit()
                $('select[name=visit]').select2()
                $('select[name=visit]').change(function() {
                    getVisitDetail($(this).val())
                })
            })

            function generateId()
            {
                var url = "{{ route('crm.visit-report.id') }}"
                $.get(url, function(response) {
                    $('input[name=id]').val(response)
                })
            }

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
        </script>
    </x-slot>

</x-app-layout>
