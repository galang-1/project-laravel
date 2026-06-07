@extends('layouts.app')
@section('content')

<div class="page-header">
    <div>
        <div class="page-title">🔔 Budget & Notifikasi</div>
        <div class="page-subtitle">Set batas pengeluaran per kategori</div>
    </div>
</div>

@if(count($warnings) > 0)
<div style="margin-bottom:20px; display:flex; flex-direction:column; gap:12px;">
    @foreach($warnings as $w)
    <div style="background:{{ $w['over'] ? '#fff5f5' : '#f0fdf4' }}; border:1.5px solid {{ $w['over'] ? '#fca5a5' : '#86efac' }}; border-radius:16px; padding:18px 22px;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
            <span style="font-weight:700; color:{{ $w['over'] ? '#dc2626' : '#16a34a' }}; font-size:14px;">
                {{ $w['over'] ? '⚠️' : '✅' }} {{ $w['category'] }}
            </span>
            <span style="font-size:13px; font-weight:600; color:{{ $w['over'] ? '#dc2626' : '#16a34a' }};">
                Rp {{ number_format($w['spent'], 0, ',', '.') }} / Rp {{ number_format($w['limit'], 0, ',', '.') }}
            </span>
        </div>
        <div class="progress">
            <div class="progress-bar {{ $w['over'] ? 'progress-red' : 'progress-green' }}" style="width:{{ min($w['percent'], 100) }}%"></div>
        </div>
        <p style="font-size:12px; margin-top:6px; color:{{ $w['over'] ? '#dc2626' : '#16a34a' }};">
            {{ $w['percent'] }}% dari batas {{ $w['over'] ? '— Pengeluaran melebihi batas! 🚨' : '' }}
        </p>
    </div>
    @endforeach
</div>
@endif

<div class="card">
    <div class="card-title">Set Budget Baru</div>
    <form method="POST" action="{{ route('budgets.store') }}" class="form-row">
        @csrf
        <div class="form-group">
            <label class="form-label">Kategori Pengeluaran</label>
            <select name="category_id" required class="form-control" style="width:220px">
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Batas Budget (Rp)</label>
            <input type="number" name="limit_amount" required min="1" placeholder="Contoh: 500000" class="form-control" style="width:200px">
        </div>
        <div class="form-group">
            <button class="btn btn-primary">💾 Simpan Budget</button>
        </div>
    </form>
</div>

<div class="card">
    <div class="card-title">Daftar Budget</div>
    <table>
        <thead>
            <tr>
                <th>Kategori</th>
                <th>Batas Budget</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($budgets as $budget)
            <tr>
                <td><strong>{{ $budget->category->name }}</strong></td>
                <td class="text-blue"><strong>Rp {{ number_format($budget->limit_amount, 0, ',', '.') }}</strong></td>
                <td>
                    <form method="POST" action="{{ route('budgets.destroy', $budget) }}" style="margin:0">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="3"><div class="empty-state"><div class="icon">🔔</div><p>Belum ada budget</p></div></td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection