@extends('layouts.admin')
@section('title', 'Tambah Notulensi')
@section('page-title', 'Tambah Notulensi')
@section('page-subtitle', 'Catat notulensi sesi materi')

@section('content')
<div class="row">
    <div class="col-12">
        <form action="{{ route('notulensi.store') }}" method="POST">
            @csrf
            <div class="card mb-4">
                <div class="card-header">
                    <h6>Form Tambah Notulensi</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Pelatihan <span style="color:red">*</span></label>
                        <select name="pelatihan_id" id="pelatihan_id" class="form-control" required>
                            <option value="">-- Pilih Pelatihan --</option>
                            @foreach($allPelatihan as $p)
                            <option value="{{ $p->id }}" {{ (old('pelatihan_id', $pelatihanAktif?->id) == $p->id) ? 'selected' : '' }}>
                                {{ $p->nama_pelatihan }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Materi <span style="color:red">*</span></label>
                        <select name="materi_id" id="materi_id" class="form-control" required>
                            <option value="">-- Pilih Materi --</option>
                            @foreach($materi as $m)
                            <option value="{{ $m->id }}" {{ old('materi_id') == $m->id ? 'selected' : '' }}>
                                {{ $m->nama_materi }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pengampu</label>
                        <input type="text" name="pengampu" class="form-control" value="{{ old('pengampu') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Moderator</label>
                        <input type="text" name="moderator" class="form-control" value="{{ old('moderator') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notulis</label>
                        <input type="text" name="notulis" class="form-control" value="{{ old('notulis') }}" required>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal') }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Waktu Mulai</label>
                            <input type="time" name="waktu_mulai" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Waktu Selesai</label>
                            <input type="time" name="waktu_selesai" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Peserta</label>
                        <input type="number" name="jumlah_peserta" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kondisi Peserta</label>
                        <textarea name="kondisi_peserta" class="form-control" rows="2" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pokok Materi</label>
                        <textarea name="pokok_materi" class="form-control" rows="2" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jalannya Materi</label>
                        <textarea name="jalannya_materi" class="form-control" rows="2" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pokok Pembahasan</label>
                        <textarea name="pokok_pembahasan" class="form-control" rows="2" required></textarea>
                    </div>

                    <hr>
                    <h6>Sesi Tanya Jawab</h6>
                    <div id="pertanyaan-container">
                        <div class="pertanyaan-item mb-3 border rounded p-3">
                            <div class="mb-2">
                                <label>Pertanyaan</label>
                                <textarea name="pertanyaan[]" class="form-control" rows="2" required></textarea>
                            </div>
                            <div class="mb-2">
                                <label>Jawaban</label>
                                <textarea name="jawaban[]" class="form-control" rows="2" required></textarea>
                            </div>
                            <button type="button" class="btn btn-danger btn-sm remove-pertanyaan">Hapus</button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-secondary mb-3" id="tambah-pertanyaan">+ Tambah Pertanyaan</button>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Simpan Notulensi</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// Dynamic materi filter by pelatihan
document.getElementById('pelatihan_id').addEventListener('change', function() {
    const pelatihanId = this.value;
    if (!pelatihanId) return;
    fetch(`/api/materi-by-pelatihan/${pelatihanId}`)
        .then(r => r.json())
        .then(data => {
            const sel = document.getElementById('materi_id');
            sel.innerHTML = '<option value="">-- Pilih Materi --</option>';
            data.forEach(m => sel.innerHTML += `<option value="${m.id}">${m.nama_materi}</option>`);
        });
});

document.getElementById('tambah-pertanyaan').addEventListener('click', function () {
    const container = document.getElementById('pertanyaan-container');
    const item = document.querySelector('.pertanyaan-item').cloneNode(true);
    item.querySelectorAll('textarea').forEach(t => t.value = '');
    container.appendChild(item);
});

document.addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-pertanyaan')) {
        const items = document.querySelectorAll('.pertanyaan-item');
        if (items.length > 1) {
            e.target.closest('.pertanyaan-item').remove();
        }
    }
});
</script>
@endpush
@endsection
