@extends('layouts.admin')

@section('content')


<div class="row">
        <div class="col-12">
            <form action="{{ route('notulensi.update', $notulensi->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6>Detail Notulensi - {{ $notulensi->pelatihan->nama_pelatihan }}</h6>
                        <a href="{{ route('notulensi.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Nama Pelatihan</label>
                                <input type="text" class="form-control" value="{{ $notulensi->pelatihan->nama_pelatihan }}" disabled>
                            </div>
                            <div class="col-md-6">
                                <label>Materi</label>
                                <input type="text" class="form-control" value="{{ $notulensi->materi->nama_materi }}" disabled>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Pengampu</label>
                                <input type="text" name="pengampu" class="form-control" value="{{ $notulensi->pengampu }}">
                            </div>
                            <div class="col-md-4">
                                <label>Moderator</label>
                                <input type="text" name="moderator" class="form-control" value="{{ $notulensi->moderator }}">
                            </div>
                            <div class="col-md-4">
                                <label>Notulis</label>
                                <input type="text" name="notulis" class="form-control" value="{{ $notulensi->notulis }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Tanggal</label>
                                <input type="date" name="tanggal" class="form-control" value="{{ $notulensi->tanggal }}">
                            </div>
                            <div class="col-md-4">
                                <label>Waktu Mulai</label>
                                <input type="time" name="waktu_mulai" class="form-control" value="{{ $notulensi->waktu_mulai }}">
                            </div>
                            <div class="col-md-4">
                                <label>Waktu Selesai</label>
                                <input type="time" name="waktu_selesai" class="form-control" value="{{ $notulensi->waktu_selesai }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Jumlah Peserta</label>
                                <input type="number" name="jumlah_peserta" class="form-control" value="{{ $notulensi->jumlah_peserta }}">
                            </div>
                            <div class="col-md-6">
                                <label>Kondisi Peserta</label>
                                <textarea name="kondisi_peserta" class="form-control" rows="2">{{ $notulensi->kondisi_peserta }}</textarea>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Pokok Materi</label>
                            <textarea name="pokok_materi" class="form-control" rows="2">{{ $notulensi->pokok_materi }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label>Jalannya Materi</label>
                            <textarea name="jalannya_materi" class="form-control" rows="2">{{ $notulensi->jalannya_materi }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label>Pokok Pembahasan</label>
                            <textarea name="pokok_pembahasan" class="form-control" rows="2">{{ $notulensi->pokok_pembahasan }}</textarea>
                        </div>

                        <hr class="my-4">
                        <h6>Sesi Tanya Jawab</h6>
                        @foreach($notulensi->notulensi_pertanyaan ?? [] as $index => $item)
                        {{-- tampilkan item --}}
                        
                    
                            <div class="border p-3 mb-3 rounded">
                                <label>Pertanyaan {{ $index + 1 }}</label>
                                <textarea name="pertanyaan[{{ $item->id }}]" class="form-control" rows="2">{{ $item->pertanyaan }}</textarea>

                                <label class="mt-2">Jawaban</label>
                                <textarea name="jawaban[{{ $item->id }}]" class="form-control" rows="2">{{ $item->jawaban }}</textarea>
                            </div>
                        @endforeach

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('notulensi.exportPdf', $notulensi->id) }}" class="btn btn-danger me-2">Ekspor PDF</a>
                            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                        </div>
                        
                       

                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

