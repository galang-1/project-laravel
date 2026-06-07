@extends('layouts.app')

@section('content')
<style>
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px; }
    .page-title { font-size: 24px; font-weight: 700; color: #1e1e2e; }
    .page-subtitle { color: #888; font-size: 14px; margin-top: 4px; }
    .btn-primary { background: linear-gradient(135deg, #6366f1, #8b5cf6); color: #fff; padding: 11px 22px; border-radius: 12px; text-decoration: none; font-size: 13px; font-weight: 600; box-shadow: 0 4px 12px rgba(99,102,241,0.3); transition: all 0.2s; }
    .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(99,102,241,0.4); }

    .stat-cards { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 24px; }
    .stat-card { border-radius: 20px; padding: 24px; color: #fff; position: relative; overflow: hidden; }
    .stat-card::before { content: ''; position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: rgba(255,255,255,0.1); border-radius: 50%; }
    .stat-card.green { background: linear-gradient(135deg, #10b981, #059669); }
    .stat-card.red { background: linear-gradient(135deg, #f43f5e, #e11d48); }
    .stat-card.blue { background: linear-gradient(135deg, #6366f1, #4f46e5); }
    .stat-label { font-size: 13px; opacity: 0.85; margin-bottom: 8px; font-weight: 500; }
    .stat-icon { position: absolute; top: 20px; right: 20px; font-size: 28px; opacity: 0.3; }
    .stat-value { font-size: 26px; font-weight: 800; margin-bottom: 6px; }
    .stat-note { font-size: 12px; opacity: 0.75; }

    .charts-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px; }
    .card { background: #fff; border-radius: 20px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); border: 1px solid #f0f0f0; }
    .card-title { font-size: 15px; font-weight: 700; color: #1e1e2e; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; }

    .tx-item { display: flex; align-items: center; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #f5f5f5; }
    .tx-item:last-child { border-bottom: none; }
    .tx-left { display: flex; align-items: center; gap: 12px; }
    .tx-icon { width: 42px; height: 42px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 18px; }
    .tx-icon.income { background: #d1fae5; }
    .tx-icon.expense { background: #fee2e2; }
    .tx-name { font-size: 14px; font-weight: 600; color: #1e1e2e; }
    .tx-date { font-size: 12px; color: #aaa; margin-top: 2px; }
    .tx-amount { font-size: 15px; font-weight: 700; }
    .tx-amount.income { color: #10b981; }
    .tx-amount.expense { color: #f43f5e; }
    .empty-state { text-align: center; padding: 40px; color: #aaa; }
    .empty-state .icon { font-size: 48px; margin-bottom: 8px; }
</style>

<div class="page-header">
    <div>
        <div class="page-title">Dashboard</div>
        <div class="page-subtitle">Selamat datang, {{ auth()->user()->name }}! 👋</div>
    </div>
    <a href="{{ route('transactions.create') }}" class="btn-primary">+ Tambah Transaksi</a>
</div>

<div class="stat-cards">
    <div class="stat-card green">
        <div class="stat-label">Total Pemasukan</div>
        <div class="stat-icon">💰</div>
        <div class="stat-value">Rp {{ number_format($totalIncome, 0, ',', '.') }}</div>
        <div class="stat-note">Semua waktu</div>
    </div>
    <div class="stat-card red">
        <div class="stat-label">Total Pengeluaran</div>
        <div class="stat-icon">💸</div>
        <div class="stat-value">Rp {{ number_format($totalExpense, 0, ',', '.') }}</div>
        <div class="stat-note">Semua waktu</div>
    </div>
    <div class="stat-card blue">
        <div class="stat-label">Saldo Bersih</div>
        <div class="stat-icon">🏦</div>
        <div class="stat-value">Rp {{ number_format($balance, 0, ',', '.') }}</div>
        <div class="stat-note">{{ $balance >= 0 ? 'Keuangan sehat ✅' : 'Perlu perhatian ⚠️' }}</div>
    </div>
</div>

<div class="charts-grid">
    <div class="card">
        <div class="card-title">📊 Pemasukan vs Pengeluaran</div>
        <canvas id="barChart" height="220"></canvas>
    </div>
    <div class="card">
        <div class="card-title">🍩 Ringkasan Keuangan</div>
        <canvas id="pieChart" height="220"></canvas>
    </div>
</div>

<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <div class="card-title" style="margin-bottom:0">🕐 Transaksi Terbaru</div>
        <a href="{{ route('transactions.index') }}" style="color:#6366f1; font-size:13px; font-weight:600; text-decoration:none;">Lihat semua →</a>
    </div>

    @forelse($recentTransactions as $transaction)
    <div class="tx-item">
        <div class="tx-left">
            <div class="tx-icon {{ $transaction->type === 'income' ? 'income' : 'expense' }}">
                {{ $transaction->type === 'income' ? '📈' : '📉' }}
            </div>
            <div>
                <div class="tx-name">{{ $transaction->category->name }}</div>
                <div class="tx-date">{{ \Carbon\Carbon::parse($transaction->date)->format('d M Y') }}</div>
            </div>
        </div>
        <div class="tx-amount {{ $transaction->type === 'income' ? 'income' : 'expense' }}">
            {{ $transaction->type === 'income' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
        </div>
    </div>
    @empty
    <div class="empty-state">
        <div class="icon">📭</div>
        <p>Belum ada transaksi</p>
    </div>
    @endforelse
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: ['Total'],
            datasets: [
                { label: 'Pemasukan', data: [{{ $totalIncome }}], backgroundColor: '#10b981', borderRadius: 8, borderSkipped: false },
                { label: 'Pengeluaran', data: [{{ $totalExpense }}], backgroundColor: '#f43f5e', borderRadius: 8, borderSkipped: false }
            ]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 16, font: { size: 12 } } } },
            scales: { y: { grid: { color: 'rgba(0,0,0,0.04)' }, ticks: { font: { size: 11 } } }, x: { grid: { display: false } } }
        }
    });

    new Chart(document.getElementById('pieChart'), {
        type: 'doughnut',
        data: {
            labels: ['Pemasukan', 'Pengeluaran', 'Saldo'],
            datasets: [{ data: [{{ $totalIncome }}, {{ $totalExpense }}, {{ max($balance, 0) }}], backgroundColor: ['#10b981', '#f43f5e', '#6366f1'], borderWidth: 0 }]
        },
        options: {
            responsive: true, cutout: '72%',
            plugins: {
                legend: { position: 'bottom', labels: { usePointStyle: true, padding: 16, font: { size: 12 } } },
                tooltip: { callbacks: { label: function(c) { const t = c.dataset.data.reduce((a,b)=>a+b,0); return ` ${c.label}: Rp ${c.parsed.toLocaleString('id-ID')} (${((c.parsed/t)*100).toFixed(1)}%)`; } } }
            }
        }
    });
</script>
@endsection