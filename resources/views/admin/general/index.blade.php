@extends('layouts.admin')

@section('title', 'Pengaturan Umum')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Pengaturan Umum</h3>
                    <a href="{{ route('admin.general.edit') }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit Pengaturan
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h5 class="text-primary">Persyaratan</h5>
                                <div class="border p-3 rounded bg-light">
                                    @if($general->persyaratan)
                                        {!! nl2br(e($general->persyaratan)) !!}
                                    @else
                                        <em class="text-muted">Belum diatur</em>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-4">
                                <h5 class="text-primary">Jam Operasional</h5>
                                <div class="border p-3 rounded bg-light">
                                    @if($general->jam_operasional)
                                        {{ $general->jam_operasional }}
                                    @else
                                        <em class="text-muted">Belum diatur</em>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-4">
                                <h5 class="text-primary">Lokasi</h5>
                                <div class="border p-3 rounded bg-light">
                                    @if($general->lokasi)
                                        {!! nl2br(e($general->lokasi)) !!}
                                    @else
                                        <em class="text-muted">Belum diatur</em>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-4">
                                <h5 class="text-primary">Syarat & Ketentuan</h5>
                                <div class="border p-3 rounded bg-light" style="max-height: 200px; overflow-y: auto;">
                                    @if($general->syarat_ketentuan)
                                        {!! nl2br(e($general->syarat_ketentuan)) !!}
                                    @else
                                        <em class="text-muted">Belum diatur</em>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(!$general->exists)
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            Pengaturan umum belum dikonfigurasi. Klik tombol "Edit Pengaturan" untuk mengatur informasi umum.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
