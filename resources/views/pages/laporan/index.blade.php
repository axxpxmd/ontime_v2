@extends('layouts.app')
@section('title', '| '.$title.'')
@section('content')
<div class="container-fluid mt-3" >
    <div class="py-4">
        <div class="card shadow mb-3">
            <div class="card-body">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row m-0">
                                <div class="col-sm-3">
                                    <label for="periode_mulai" class="float-right col-form-label fs-13">Periode Mulai</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="date" name="periode_mulai" id="periode_mulai" class="form-control fs-13 mb-3" value="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="form-group row m-0">
                                <div class="col-sm-3">
                                    <label for="periode_selesai" class="float-right col-form-label fs-13">Periode Selesai</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="date" name="periode_selesai" id="periode_selesai" class="form-control fs-13 mb-3" value="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="form-group row m-0">
                                <div class="col-sm-3">
                                    <label for="opd_id" class="float-right col-form-label fs-13">OPD</label>
                                </div>
                                <div class="col-sm-9">
                                    <select class="form-control select2" name="opd_id" id="opd_id" onchange="">
                                        <option value="">Semua</option>
                                        @foreach ($opds as $i)
                                            <option value="{{ $i->id }}" {{ $opd_id_user == $i->id ? 'selected' : '' }}>{{ $i->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label for="unit_kerja_id" class="float-right col-form-label fs-13">Unit Kerja</label>
                                </div>
                                <div class="col-sm-9">
                                    <select class="form-control select2" name="unit_kerja_id" id="unit_kerja_id" onchange="">
                                        <option value="">Semua</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label for="sub_unit_kerja_id" class="float-right col-form-label fs-13">Sub Unit Kerja</label>
                                </div>
                                <div class="col-sm-9">
                                    <select class="form-control select2" name="sub_unit_kerja_id" id="sub_unit_kerja_id" onchange="">
                                        <option value="">Semua</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9">
                                    <button class="btn btn-success btn-sm m-r-10" onclick="pressOnChange()"><i class="fa fa-search m-r-8"></i>Filter</button>
                                    <a target="_blank" href="#" class="btn btn-sm btn-primary ml-2" id="exportpdf"><i class="fas fa-print m-r-8"></i>Print</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow">
            <div class="card-body">
                <hr class="m-0">
                <div class="table-responsive">
                    {{-- <table id="dataTable" class="table data-table display nowrap table-striped" style="width:100%">
                        <thead>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Unit Kerja</th>
                            <th>Jam Kerja</th>
                            <th>Gaji</th>
                            <th>Total Sanksi</th>
                            <th>Gaji Final</th>
                            <th>Detail</th>
                        </thead>
                        <tbody></tbody>
                    </table> --}}
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.loading')
@endsection
@push('scripts')
<script type="text/javascript">
    var table = $('#dataTable').dataTable({
        scrollX: true,
        processing: true,
        serverSide: true,
        order: [ 0, 'asc' ],
        pageLength: 10,
        searching: false,
        language: {
            paginate: {
            next: '&#8594;', // or '→'
            previous: '&#85x92;' // or '←' 
            }
        },
        ajax: {
            url: "{{ route('kehadiran') }}",
            method: 'GET',
            data: function (data) {
                data.tanggal = $('#tanggal').val();
                data.ket = $('#ket').val();
                data.opd_id = $('#opd_id').val();
                data.nama_pegawai = $('#nama_pegawai').val();
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, align: 'center', className: 'text-center align-middle'},
            {data: 'username', name: 'username', className: 'align-middle'},
            {data: 'nama', name: 'nama', className: 'align-middle'},
            {data: 'ket', name: 'ket', className: 'align-middle'},
            {data: 'jam_masuk', name: 'jam_masuk', className: 'align-middle'},
            {data: 'jam_keluar', name: 'jam_keluar', className: 'align-middle'},
            {data: 'jam_kerja', name: 'jam_kerja', className: 'align-middle'},
            {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center align-middle'},
        ]
    });

    pressOnChange();
    function pressOnChange(){
        table.api().ajax.reload();
    }
</script>
@endpush
