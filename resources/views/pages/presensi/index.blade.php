@extends('layouts.app')
@section('title', '| '.$title.'')
@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
@endpush
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
                                <p class="m-0 fs-13 text-black font-weight-bold">{{ $jamKerja->mulai_kerja }} - {{ $jamKerja->selesai_kerja }}</p>
                                <p class="m-0 fs-13 text-black font-weight-bold">Masuk : {{ $absen->jam_masuk ? $absen->jam_masuk : '-' }}</p>
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
                                <p class="m-0 fs-13 text-black font-weight-bold">{{ Carbon\Carbon::now()->isoFormat('D MMMM Y') }}</p>
                                <p class="m-0 fs-13 text-black font-weight-bold">Keluar : {{ $absen->jam_keluar ? $absen->jam_keluar : '-' }}</p>
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
<div class="modal fade" id="modalMap" tabindex="-1" role="dialog" aria-labelledby="modalMap" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header px-3 py-3 ">
                <p class="fs-14 text-black m-0">Lokasi Absen <span class="font-weight-bolder" id="namaUserLokasi"></span></p>
            </div>
            <div class="row lok_datang" style="display: none">
                <div class="col-md-12 p-4">
                    <center>
                        <p class="fs-14 m-0 mb-3 textbl">Lokasi Datang</p>
                    </center>
                    <div id="map" style="width: 100%;height:300px"></div>
                </div>
            </div>
            <hr class="m-0">
            <div class="row lok_pulang" style="display: none">
                <div class="col-md-12 p-4">
                    <center>
                        <p class="fs-14 m-0 mb-3">Lokasi Pulang</p>
                    </center>
                    <div id="map2" style="width: 100%;height:300px"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.loading')
@endsection
@push('scripts')
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
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

    OpenStreetMap = L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png");
    OpenStreetMap2 = L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png");

    var pc = true;
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        pc = false;
    }
    var map, map2;

    function modalMap(id) {
        $('#loading').show();
        $('.lok_datang').hide();
        $('.lok_pulang').hide();
        const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
       
        $.ajax({
            url: "{{ route('kehadiran.getLokasi') }}",
            method: 'post',
            dataType: 'json',
            data: {
                _token: CSRF_TOKEN,
                id: id
            },
            success: function(data) {
                console.log(data);
                if (map != undefined) {
                    map.remove();
                }
                if (map2 != undefined) {
                    map2.remove();
                }
                if (data.lokasi_datang) {
                    $('.lok_datang').show();

                    map = L.map("map", {
                        center: [-6.291100, 106.715421],
                        zoom: 15,
                        dragging: pc,
                        tap: pc,
                        pixelRatio: window.devicePixelRatio || 1,
                        fullscreenControl: true,
                        fullscreenControlOptions: {
                            position: "topleft"
                        },
                        measureControl: false,
                        layers: [OpenStreetMap]
                    })

                    latlng = data.lokasi_datang.split(', ');
                    let marker = L.marker([latlng[0], latlng[1]]).addTo(map);
                    map.panTo(new L.LatLng(latlng[0], latlng[1]));
                }
                if (data.lokasi_pulang) {
                    $('.lok_pulang').show();

                    map2 = L.map("map2", {
                        center: [-6.291100, 106.715421],
                        zoom: 15,
                        dragging: pc,
                        tap: pc,
                        pixelRatio: window.devicePixelRatio || 1,
                        fullscreenControl: true,
                        fullscreenControlOptions: {
                            position: "topleft"
                        },
                        measureControl: false,
                        layers: [OpenStreetMap2]
                    })

                    latlng = data.lokasi_pulang.split(', ');
                    let marker = L.marker([latlng[0], latlng[1]]).addTo(map2);
                    map2.panTo(new L.LatLng(latlng[0], latlng[1]));
                }

                setTimeout(function() {
                    map.invalidateSize();
                    if (data.lokasi_pulang) {
                        map2.invalidateSize(); 
                        map.invalidateSize();  
                    }
                }, 1000);

                $('#loading').hide();
                $('#namaUserLokasi').html(data.nama)
                $('#modalMap').modal('show');
            }
        });
    };
</script>
@endpush
