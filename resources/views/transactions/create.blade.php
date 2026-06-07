@extends('layouts.app')
@section('content')

<div class="page-header">
    <div>
        <div class="page-title">💸 Tambah Transaksi</div>
        <div class="page-subtitle">Catat pemasukan atau pengeluaran baru</div>
    </div>
    <a href="{{ route('transactions.index') }}" class="btn btn-gray">← Kembali</a>
</div>

<div class="card" style="max-width:600px;">
    <form method="POST" action="{{ route('transactions.store') }}">
        @csrf

        <div class="form-group">
            <label class="form-label">Kategori</label>
            <select name="category_id" required class="form-control">
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}">
                    {{ $category->name }} ({{ $category->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }})
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">Tipe</label>
            <select name="type" required class="form-control">
                <option value="income">📈 Pemasukan</option>
                <option value="expense">📉 Pengeluaran</option>
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">Jumlah (Rp)</label>
            <input type="number" name="amount" required min="1" placeholder="Contoh: 500000" class="form-control">
        </div>

        <div class="form-group">
            <label class="form-label">Tanggal</label>
            <input type="date" name="date" required value="{{ date('Y-m-d') }}" class="form-control">
        </div>

        <div class="form-group">
            <label class="form-label">Catatan (opsional)</label>
            <input type="text" name="note" placeholder="Tambahkan catatan..." class="form-control">
        </div>

        <div style="display:flex; gap:12px; margin-top:8px;">
            <button class="btn btn-primary" style="flex:1">💾 Simpan Transaksi</button>
            <a href="{{ route('transactions.index') }}" class="btn btn-gray" style="flex:1; text-align:center;">Batal</a>
        </div>
    </form>
</div>
@endsection