@extends('layouts.app')
@section('title', '| '.$title.'')
@section('content')
<div class="container-fluid mt-3" >
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6 mb-5-m">
                <div class="card">
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <img class="img-fluid mx-auto d-block rounded-circle img-circular" width="100" src="{{ asset('images/default.png') }}" alt="Foto Profil">
                                    <div class="text-center mt-3">
                                        <p class="m-0 fs-14 text-uppercase font-weight-bolder text-black">Administrator</p>
                                    </div> 
                                </div>
                                <div class="col-md-8">
                                    <span class="m-none" style="border-left: 3px solid #E7E8EA; height: 140px; position: absolute"></span>
                                    <div class="row mb-2">
                                        <div class="col-sm-3 text-right text-black fs-14 font-weight-bold">OPD </div>
                                        <div class="col-sm-9 fs-14 text-black-50 font-weight-bold">KOMINFO</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3 text-right text-black fs-14 font-weight-bold">Unit Kerja </div>
                                        <div class="col-sm-9 fs-14 text-black-50 font-weight-bold">Sub Koordinator Pengembangan Penyelenggaraan e-Government</div>
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
                                <p class="m-0 fs-14 text-black-50 font-weight-bold">Jam Kerja</p>
                                <p class="m-0 fs-14 text-black font-weight-bold">07:30 - 15:00</p>
                                <p class="m-0 fs-14 text-black font-weight-bold">Masuk : -</p>
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
                                <p class="m-0 fs-14 text-black-50 font-weight-bold">Jam Kerja</p>
                                <p class="m-0 fs-14 text-black font-weight-bold">07:30 - 15:00</p>
                                <p class="m-0 fs-14 text-black font-weight-bold">Masuk : -</p>
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
                    <p class="m-0 font-weight-bold fs-14 text-black">Total Kehadiran ( 900 )</p>
                </div>
                <div class="row">
                    <div class="col-md-2 mb-5-m px-1">
                        <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ request('tanggal', date('Y-m-d')) }}">
                    </div>
                    <div class="col-md-1 mb-5-m px-1">
                        <select class="form-control select2" name="keterangan" id="keterangan" onchange="">
                            <option value="">Semua</option>
                            @foreach ($keterangans as $ket)
                                <option value="{{ $ket }}">{{ $ket }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5 mb-5-m px-1">
                        <select class="form-control select2 fs-19" name="opd_id" id="opd_id" onchange="">
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
                        <button type="submit" class="btn btn-primary m-r-10 fs-14"><i class="fa fa-search m-r-8"></i>Cari</button>
                        <button type="submit" class="btn btn-success fs-14"><i class="fa fa-download"></i></button>
                    </div>
                </div>
                <hr class="m-0">
                <div class="table-responsive">
                    <table class="table display nowrap table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th width="20%" class="fs-13 font-weight-bolder ps-2">Author</th>
                                <th width="20%" class="fs-13 font-weight-bolder ps-2">Function</th>
                                <th width="20%" class="fs-13 font-weight-bolder ps-2">Status</th>
                                <th width="10%" class="fs-13 font-weight-bolder ps-2">Employed</th>
                                <th width="10%" class="fs-13 font-weight-bolder ps-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 0; $i < 10; $i++) 
                            <tr class="fs-13 text-secondary">
                                <td>Asip Hamdi</td>
                                <td>Web Developer</td>
                                <td>Pegawai Tetap</td>
                                <td>DISKOMINFO Kota Tangerang</td>
                                <td></td>
                            </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
    // 
</script>
@endpush
