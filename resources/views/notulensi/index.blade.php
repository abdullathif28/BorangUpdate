@extends('layouts.admin')

@section('content')

@include('components.pelatihan-selector', ['allPelatihan' => $allPelatihan ?? collect(), 'pelatihan' => $pelatihan ?? null])



<div class="row">
        <div class="col-12">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Daftar Notulensi</h6>
                    <a href="{{ route('notulensi.create') }}" class="btn btn-sm btn-primary">+ Tambah Notulensi</a>
                </div>

                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-3">
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Pelatihan</th>
                                    <th>Materi</th>
                                    <th>Pengampu</th>
                                    <th>Tanggal</th>
                                    <th>Jumlah Peserta</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($notulensi as $n)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $n->pelatihan->nama_pelatihan }}</td>
                                        <td>{{ $n->materi->nama_materi }}</td>
                                        <td>{{ $n->pengampu }}</td>
                                        <td>{{ $n->tanggal }}</td>
                                        <td>{{ $n->jumlah_peserta }}</td>
                                        <td>
                                            <a href="{{ route('notulensi.show', $n->id) }}" class="btn btn-sm btn-info">Lihat</a>
                                            <form action="{{ route('notulensi.destroy', $n->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus notulensi ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">Belum ada notulensi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="mt-3">
                            {{ $notulensi->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

