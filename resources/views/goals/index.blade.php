@extends('layouts.app')
@section('content')

<div class="page-header">
    <div>
        <div class="page-title">🎯 Tabungan Goals</div>
        <div class="page-subtitle">Target nabung untuk impianmu</div>
    </div>
</div>

<div class="card">
    <div class="card-title">Tambah Goal Baru</div>
    <form method="POST" action="{{ route('goals.store') }}" class="form-row">
        @csrf
        <div class="form-group">
            <label class="form-label">Icon</label>
            <input type="text" name="icon" value="🎯" maxlength="4" class="form-control" style="width:70px; text-align:center; font-size:20px;">
        </div>
        <div class="form-group">
            <label class="form-label">Nama Goal</label>
            <input type="text" name="name" required placeholder="Contoh: Beli Laptop" class="form-control" style="width:200px">
        </div>
        <div class="form-group">
            <label class="form-label">Target (Rp)</label>
            <input type="number" name="target_amount" required min="1" placeholder="10000000" class="form-control" style="width:180px">
        </div>
        <div class="form-group">
            <label class="form-label">Deadline (opsional)</label>
            <input type="date" name="deadline" class="form-control" style="width:160px">
        </div>
        <div class="form-group">
            <button class="btn btn-primary">+ Tambah Goal</button>
        </div>
    </form>
</div>

@forelse($goals as $goal)
<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:16px;">
        <div>
            <div style="font-size:20px; font-weight:800; color:#1e1e2e; display:flex; align-items:center; gap:8px;">
                {{ $goal->icon }} {{ $goal->name }}
            </div>
            @if($goal->deadline)
            <div style="font-size:12px; color:#9ca3af; margin-top:4px;">
                🗓️ Deadline: {{ \Carbon\Carbon::parse($goal->deadline)->format('d F Y') }}
            </div>
            @endif
        </div>
        <form method="POST" action="{{ route('goals.destroy', $goal) }}" style="margin:0">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-danger">Hapus</button>
        </form>
    </div>

    <div style="display:flex; justify-content:space-between; font-size:13px; margin-bottom:8px;">
        <span>Terkumpul: <strong class="text-green">Rp {{ number_format($goal->saved_amount, 0, ',', '.') }}</strong></span>
        <span>Target: <strong>Rp {{ number_format($goal->target_amount, 0, ',', '.') }}</strong></span>
    </div>
    <div class="progress">
        <div class="progress-bar {{ $goal->percentage() >= 100 ? 'progress-green' : ($goal->percentage() >= 50 ? 'progress-blue' : 'progress-yellow') }}"
            style="width:{{ $goal->percentage() }}%"></div>
    </div>
    <div style="display:flex; justify-content:space-between; font-size:12px; margin-top:6px; color:#9ca3af;">
        <span class="{{ $goal->percentage() >= 100 ? 'text-green' : '' }}" style="font-weight:600;">
            {{ $goal->percentage() >= 100 ? '🎉 Goal tercapai!' : $goal->percentage() . '% tercapai' }}
        </span>
        @if($goal->percentage() < 100)
        <span>Sisa: Rp {{ number_format($goal->remaining(), 0, ',', '.') }}</span>
        @endif
    </div>

    @if($goal->percentage() < 100)
    <form method="POST" action="{{ route('goals.addSaving', $goal) }}" class="form-row" style="margin-top:16px;">
        @csrf
        <div class="form-group" style="flex:1">
            <input type="number" name="amount" required min="1" placeholder="Tambah nominal tabungan (Rp)" class="form-control">
        </div>
        <div class="form-group">
            <button class="btn btn-success">+ Tabung</button>
        </div>
    </form>
    @endif
</div>
@empty
<div class="card">
    <div class="empty-state">
        <div class="icon">🎯</div>
        <p>Belum ada goal. Yuk buat target tabungan pertamamu!</p>
    </div>
</div>
@endforelse
@endsection