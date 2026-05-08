@if(isset($allPelatihan) && $allPelatihan->count() > 0)
<div class="card mb-3" style="background:#fff;border-left:4px solid #0f4c81">
    <div class="card-body" style="padding:14px 20px">
        <form method="POST" action="{{ route('pelatihan.set-aktif') }}" class="d-flex align-items-center gap-3" style="flex-wrap:wrap">
            @csrf
            <label style="font-size:13px;font-weight:600;color:#0f4c81;white-space:nowrap;margin:0">
                <i class="fas fa-layer-group" style="margin-right:6px"></i>Pelatihan Aktif:
            </label>
            <select name="pelatihan_id" class="form-control form-select" style="max-width:360px;font-size:13px" onchange="this.form.submit()">
                @foreach($allPelatihan as $p)
                <option value="{{ $p->id }}" {{ (isset($pelatihan) && $pelatihan && $pelatihan->id == $p->id) ? 'selected' : '' }}>
                    {{ $p->nama_pelatihan }} — {{ $p->penyelenggara }} ({{ $p->status }})
                </option>
                @endforeach
            </select>
            @if(isset($pelatihan) && $pelatihan)
            <span class="badge" style="{{ $pelatihan->status === 'aktif' ? 'background:#d1fae5;color:#065f46' : 'background:#fef3c7;color:#92400e' }}">
                {{ strtoupper($pelatihan->status) }}
            </span>
            @endif
        </form>
    </div>
</div>
@endif
