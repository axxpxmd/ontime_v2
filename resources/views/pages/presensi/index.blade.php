@extends('layouts.app')
@section('title', '| '.$title.'')
@section('content')
<div class="container-fluid mt-3" >
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6 mb-5-m">
                <div class="card shadow animate__animated animate__fadeInLeft">
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="row h-100">
                                <div class="col-md-4">
                                    <img class="img-fluid mx-auto d-block rounded-circle img-circular" width="90" src="{{ asset('images/default.png') }}" alt="Foto Profil">
                                    <div class="text-center mt-3">
                                        <p class="m-0 fs-13 text-uppercase font-weight-bolder text-black">Asip Hamdi </p>
                                    </div> 
                                </div>
                                <div class="col-md-8 my-auto">
                                    <span class="m-none" style="border-left: 3px solid #E7E8EA; min-height: 40% !important; position: absolute"></span>
                                    <div class="mx-auto">
                                        <div class="row mb-2">
                                            <div class="col-sm-3 text-right text-black fs-13 font-weight-bold">OPD </div>
                                            <div class="col-sm-9 fs-13 text-black-50 font-weight-bold">KOMINFO</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3 text-right text-black fs-13 font-weight-bold">Unit Kerja </div>
                                            <div class="col-sm-9 fs-13 text-black-50 font-weight-bold">Sub Koordinator Pengembangan Penyelenggaraan e-Government</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow animate__animated animate__fadeInRight">
                    <div class="card-body px-4 py-2">
                        <div class="row">
                            <div class="col-md-6 text-center-m">
                                <p class="m-0 fs-13 text-black-50 font-weight-bold">Jam Kerja</p>
                                <p class="m-0 fs-13 text-black font-weight-bold">07:30 - 15:00</p>
                                <p class="m-0 fs-13 text-black font-weight-bold">Masuk : -</p>
                            </div>
                            <div class="col-md-6 text-right text-center-m">
                                <img src="{{ asset('images/clock.png') }}" class="mt-2" width="50" alt="Jam">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card shadow bg-white mt-3 animate__animated animate__fadeInRight">
                    <div class="card-body px-4 py-2">
                        <div class="row">
                            <div class="col-md-6 text-center-m">
                                <p class="m-0 fs-13 text-black-50 font-weight-bold">Jam Kerja</p>
                                <p class="m-0 fs-13 text-black font-weight-bold">07:30 - 15:00</p>
                                <p class="m-0 fs-13 text-black font-weight-bold">Masuk : -</p>
                            </div>
                            <div class="col-md-6 text-right text-center-m">
                                <img src="{{ asset('images/calender.png') }}" class="mt-2" width="50" alt="Jam">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-4">
        <div class="card shadow">
            <div class="card-body">
                <div class="mb-3">
                    <p class="m-0 font-weight-bold fs-13 text-black">Total Kehadiran ( 900 )</p>
                </div>
                <div class="row">
                    <div class="col-md-2 mb-5-m px-1">
                        <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ request('tanggal', date('Y-m-d')) }}">
                    </div>
                    <div class="col-md-1 mb-5-m px-1">
                        <select class="form-control select2" name="ket" id="ket" onchange="">
                            <option value="">Semua</option>
                            @foreach ($keterangans as $ket)
                                <option value="{{ $ket }}">{{ $ket }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5 mb-5-m px-1">
                        <select class="form-control select2" name="opd_id" id="opd_id" onchange="">
                            <option value="">Semua</option>
                            @foreach ($opds as $i)
                                <option value="{{ $i->id }}">{{ $i->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mb-5-m px-1">
                        <input type="text" class="form-control" placeholder="Nama Pegawai " id="nama_pegawai" placeholder="" name="nama_pegawai" value="{{ request('nama_pegawai', '') }}">
                    </div>
                    <div class="col-md-2 mb-5-m px-1 text-center-m">
                        <button type="submit" class="btn btn-primary m-r-10 fs-13" onclick="pressOnChange()"><i class="fa fa-search m-r-8"></i>Cari</button>
                        <button type="submit" class="btn btn-success fs-13"><i class="fa fa-download"></i></button>
                    </div>
                </div>
                <hr class="m-0">
                <div class="table-responsive">
                    <table id="dataTable" class="table data-table display nowrap table-striped" style="width:100%">
                        <thead>
                            <th>No</th>
                            <th>Username</th>
                            <th>Nama</th>
                            <th>Keterangan</th>
                            <th>Jam Masuk</th>
                            <th>Jam Keluar</th>
                            <th>Jam Kerja</th>
                            <th>Aksi</th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
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
            previous: '&#8592;' // or '←' 
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
