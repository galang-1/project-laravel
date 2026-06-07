@extends('layouts.app')
@section('content')

<div class="page-header">
    <div>
        <div class="page-title">💸 Transaksi</div>
        <div class="page-subtitle">Kelola semua transaksi keuanganmu</div>
    </div>
    <a href="{{ route('transactions.create') }}" class="btn btn-primary">+ Tambah Transaksi</a>
</div>

<!-- Filter -->
<div class="card">
    <form method="GET" action="{{ route('transactions.index') }}" class="form-row">
        <div class="form-group">
            <label class="form-label">Bulan</label>
            <select name="month" class="form-control" style="width:160px">
                <option value="">Semua Bulan</option>
                @foreach(range(1,12) as $m)
                <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                    {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Tahun</label>
            <select name="year" class="form-control" style="width:120px">
                <option value="">Semua Tahun</option>
                @foreach(range(date('Y'), date('Y')-3) as $y)
                <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <button class="btn btn-primary">🔍 Filter</button>
            <a href="{{ route('transactions.index') }}" class="btn btn-gray" style="margin-left:8px">↺ Reset</a>
        </div>
    </form>
</div>

<!-- Ringkasan -->
<div class="mini-cards">
    <div class="mini-card">
        <div class="mini-card-label">Pemasukan</div>
        <div class="mini-card-value text-green">Rp {{ number_format($totalIncome, 0, ',', '.') }}</div>
    </div>
    <div class="mini-card">
        <div class="mini-card-label">Pengeluaran</div>
        <div class="mini-card-value text-red">Rp {{ number_format($totalExpense, 0, ',', '.') }}</div>
    </div>
    <div class="mini-card">
        <div class="mini-card-label">Saldo</div>
        <div class="mini-card-value {{ ($totalIncome-$totalExpense) >= 0 ? 'text-blue' : 'text-red' }}">
            Rp {{ number_format($totalIncome - $totalExpense, 0, ',', '.') }}
        </div>
    </div>
</div>

<!-- Tabel -->
<div class="card">
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Kategori</th>
                    <th>Catatan</th>
                    <th>Tipe</th>
                    <th>Jumlah</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $t)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($t->date)->format('d M Y') }}</td>
                    <td><strong>{{ $t->category->name }}</strong></td>
                    <td>{{ $t->note ?? '-' }}</td>
                    <td>
                        <span class="badge {{ $t->type === 'income' ? 'badge-green' : 'badge-red' }}">
                            {{ $t->type === 'income' ? '📈 Pemasukan' : '📉 Pengeluaran' }}
                        </span>
                    </td>
                    <td><strong class="{{ $t->type === 'income' ? 'text-green' : 'text-red' }}">Rp {{ number_format($t->amount, 0, ',', '.') }}</strong></td>
                    <td>
                        <div class="action-group">
                            <a href="{{ route('transactions.edit', $t) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form method="POST" action="{{ route('transactions.destroy', $t) }}" style="margin:0">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6"><div class="empty-state"><div class="icon">📭</div><p>Belum ada transaksi</p></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top:16px">{{ $transactions->links() }}</div>
</div>
@endsection