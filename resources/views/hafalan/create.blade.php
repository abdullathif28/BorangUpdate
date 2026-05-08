{{-- <!-- resources/views/hafalan/create.blade.php -->

@extends('layouts.admin')

@section('content')
    

    <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0">Tambah Hafalan</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('hafalan.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="peserta_id">Nama Peserta</label>
                                <select name="peserta_id" id="peserta_id" class="form-control" required>
                                    <option value="">Pilih Peserta</option>
                                    @foreach ($peserta as $peserta)
                                        <option value="{{ $peserta->id }}">{{ $peserta->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="surat_1">Surat 1</label>
                                <input type="text" class="form-control" id="surat_1" name="surat_1" value="{{ old('surat_1') }}">
                            </div>
                            <div class="form-group">
                                <label for="surat_2">Surat 2</label>
                                <input type="text" class="form-control" id="surat_2" name="surat_2" value="{{ old('surat_2') }}">
                            </div>
                            <div class="form-group">
                                <label for="surat_3">Surat 3</label>
                                <input type="text" class="form-control" id="surat_3" name="surat_3" value="{{ old('surat_3') }}">
                            </div>
                            <div class="form-group">
                                <label for="surat_4">Surat 4</label>
                                <input type="text" class="form-control" id="surat_4" name="surat_4" value="{{ old('surat_4') }}">
                            </div>
                            <div class="form-group">
                                <label for="surat_5">Surat 5</label>
                                <input type="text" class="form-control" id="surat_5" name="surat_5" value="{{ old('surat_5') }}">
                            </div>
                            <div class="form-group">
                                <label for="surat_6">Surat 6</label>
                                <input type="text" class="form-control" id="surat_6" name="surat_6" value="{{ old('surat_6') }}">
                            </div>
                            <div class="form-group">
                                <label for="surat_7">Surat 7</label>
                                <input type="text" class="form-control" id="surat_7" name="surat_7" value="{{ old('surat_7') }}">
                            </div>
                            <!-- Repeat for Surat 2 to Surat 7 -->
                            <div class="form-group">
                                <label for="nilai">Nilai</label>
                                <input type="number" class="form-control" id="nilai" name="nilai" value="{{ old('nilai') }}">
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection --}}
<!-- resources/views/hafalan/create.blade.php -->

@extends('layouts.admin')

@section('content')
    

    <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0">Tambah Hafalan</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('hafalan.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="peserta_id">Nama Peserta</label>
                                <select name="peserta_id" id="peserta_id" class="form-control" required>
                                    <option value="">Pilih Peserta</option>
                                    @foreach ($peserta as $peserta)
                                        <option value="{{ $peserta->id }}">{{ $peserta->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mt-4">
                                <label>Checklist Hafalan</label>
                                @for ($i = 1; $i <= 7; $i++)
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="surat_{{ $i }}" name="surat_{{ $i }}" value="1" {{ old('surat_'.$i) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="surat_{{ $i }}">Hafal Surat {{ $i }}</label>
                                    </div>
                                @endfor
                            </div>

                            <div class="form-group mt-4">
                                <label for="nilai">Nilai</label>
                                <input type="number" class="form-control" id="nilai" name="nilai" value="{{ old('nilai') }}">
                            </div>

                            <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection

