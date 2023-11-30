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
                                        <option {{ $visit->status == 'Bidding' ? 'selected' : '' }}>Bidding</option>
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
                                        <input type="file" class="custom-file-input js-custom-file-input-enabled" id="" name="upload-pdf" data-toggle="custom-file-input">
                                        <label class="custom-file-label"  id="upload-pdf-label" >Choose file</label>
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
                getPdf("{{ $visit->visit->uuid }}")
                getVisitDetail("{{ $visit->visit->uuid }}")
                $('select[name=visit]').select2()
                $('select[name=visit]').val("{{ $visit->visit->uuid }}")
                $('select[name=visit]').change(function() {
                    getVisitDetail($(this).val())
                    $('input[type=file]').attr('disabled', false)
                })
                $('input[name=upload-pdf]').change(function() {
                 
                    uploadPdf($(this).prop('files')[0])
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

            function listItemPdf(status, data) {
                if (status == 200) {
                    var element = ``
                    var number = 1
                    var visit = $('select[name=visit]').val()
                    $.each(data, function(index, value) {
                        element += `<li class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <a href="/file/show/temp/${visit}/${value.filename}" target="_blank">` +
                            number + `. ` + value.aliases + `</a>
                                            <button type="button" onclick="deletePdf('` + value.filename + `')" class="btn btn-link text-danger" style="padding: 0; width: auto; height: auto;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                                                </svg>    
                                            </button>
                                        </div>
                                    </li>`
                        number++
                    })
                    $('.list-group').html(``)
                    $('.list-group').html(element)
                    $('input[name=pdf]').val(JSON.stringify(data))
                }
            }


            function getPdf(id) {
                $.ajax({
                    url: "{{ route('crm.visit-report.get-pdf') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        so: id
                    },
                    success: function(response) {
                        listItemPdf(response.status, response.data)
                    },
                    error: function(xhr, status, error) {
                        console.log(error)
                    }
                })
            }

            function uploadPdf(file) {
                const formData = new FormData()
                formData.append('_token', '{{ csrf_token() }}')
                formData.append('file', file)
                formData.append('so', $('select[name=visit]').val())
                $.ajax({
                    url: '{{ route('crm.visit-report.upload-pdf') }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#loading-file').removeClass('d-flex')
                        $('#loading-file').addClass('d-none')
                        listItemPdf(response.status, response.data)
                    },
                    error: function(xhr, status, error) {
                        console.log(error)
                    }
                })
                $('#upload-pdf-label').html('Choose file')
            }

            function deletePdf(file) {
                $.ajax({
                    url: "{{ route('crm.visit-report.delete-pdf') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        file: file,
                        so: $('select[name=visit]').val()
                    },
                    success: function(response) {
                        listItemPdf(response.status, response.data)
                    },
                    error: function(xhr, status, error) {
                        console.log(error)
                    }
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
