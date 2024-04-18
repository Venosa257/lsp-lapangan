@extends('layouts.main')
@section('content')
<style>
    @font-face {
        font-family: 'Plus Jakarta Sans';
        src: url('fonts/PlusJakartaSans-Medium.ttf');
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .back-image {
        position: absolute;
        z-index: -1;
        width: 100%;
        height: 100%;
        filter: blur(2px);
    }
</style>
    <main class="pt-3">
        @if (session('failed-booking')[0] ?? false)
            <div class="alert alert-danger" role="alert">
                Jadwal yang anda masukkan telah di pesan oleh seseorang, harap memasukkan jadwal booking yang lain
            </div>
        @endif
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb mt-2">
                <li class="breadcrumb-item"><a style="text-decoration: none" href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Booking</li>
            </ol>
        </nav>
        <div class="card border-primary">
            <div class="card-header bg-warning-subtle">
                <h4 style="padding-left: 10px; margin-top: 6px">Booking Lapangan</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('booking.post') }}" method="POST">
                    @csrf
            <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label" for="name">Nama</label>
                                <input type="text" name="name" class="form-control" value="{{old('name')}}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label" for="no_tlp">Nomor Telepon</label>
                                <input type="number" name="no_tlp" class="form-control" value="{{old('no_tlp')}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label" for="lokasi">Lokasi</label>
                                <select name="lokasi" class="form-select" id="lokasi" required value="{{old('lokasi')}}">
                                    <option value="" disabled selected>-- Pilih Lokasi Lapangan --</option>
                                    <option value="indoor">Indoor</option>
                                    <option value="outdoor">Outdoor</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label" for="jenis">Jenis</label>
                                <select required name="jenis" class="form-select" id="jenis">
                                    <option value="" disabled selected>-- Pilih Jenis Lapangan --</option>
                                    <option value="reguler"  @selected(old('jenis') == 'reguler')>Reguler</option>
                                    <option value="matras" @selected(old('jenis') == 'matras')>Matras</option>
                                    <option value="rumput" @selected(old('jenis') == 'rumput')>Rumput</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="datetime-local" class="form-control" name="date_start" value="{{old('date_start')}}">
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="datetime-local" class="form-control" name="date_end" value="{{old('date_end')}}">
                        </div>
                    </div>
                    <div class="card mt-4 mb-2 border-primary">
                        <div class="card-header bg-warning">
                            <h5><strong>* Tambahan Sewa</strong></h5>
                        </div>
                    <div class="container mt-3 mb-3">
                        <div class="form-check form-check-inline">
                            <input type="checkbox" name="sewa_sepatu" id="sewa_sepatu" class="form-check-input" @checked(old('sewa_sepatu'))>
                        <label class="form-check-label" for="sewa_sepatu">Sewa Sepatu Rp. 50.000 / jam</label>
                    </div>
                    <div class="form-check form-check-inline">
                            <input type="checkbox" name="sewa_kostum" id="sewa_kostum" class="form-check-input">
                        <label class="form-check-label" for="sewa_kostum">Sewa Kostum Rp. 45.000 / jam</label>
                    </div>
                    </div>
                </div>
                    {{-- </div> --}}
                    <button type="submit" class="btn btn-primary w-100 mt-4">Checkout</button>
                </form>
            </div>
        </div>
        </div>
        <div class="card mt-4">
            <div class="card-header bg-primary">
                <h4 style="margin-top: 6px; padding-left: 12px; color: white">Daftar Booking</h4>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Penyewa</th>
                            <th>No Tlp</th>
                            <th>Lokasi</th>
                            <th>Jenis</th>
                            <th>Harga Perjam</th>
                            <th>Tgl Mulai</th>
                            <th>Tgl Selesai</th>
                            <th>Total Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (session('failed-booking')[0] ?? false)
                            @foreach (session('failed-booking') as $b)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $b->name }}</td>
                                    <td>{{ $b->no_tlp }}</td>
                                    <td>{{ $b->lapangan->lokasi }}</td>
                                    <td>{{ $b->lapangan->jenis }}</td>
                                    <td>Rp. {{ number_format($b->lapangan->price) }}</td>
                                    <td>{{ $b->getDateStart() }}</td>
                                    <td>{{ $b->getDateEnd() }}</td>
                                    <td>Rp. {{ number_format($b->total_price) }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </main>


@endsection
