@extends('layouts.app')
@section('content')

<div class="page-header">
    <div>
        <div class="page-title">📈 Laporan Bulanan</div>
        <div class="page-subtitle">Ringkasan keuangan per tahun</div>
    </div>
    <form method="GET" action="{{ route('reports.index') }}">
        <select name="year" class="form-control" onchange="this.form.submit()" style="width:120px">
            @foreach($years as $y)
            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
            @endforeach
        </select>
    </form>
</div>

<div class="mini-cards" style="grid-template-columns:repeat(3,1fr)">
    <div class="mini-card">
        <div class="mini-card-label">Total Pemasukan {{ $year }}</div>
        <div class="mini-card-value text-green">Rp {{ number_format($totalIncome, 0, ',', '.') }}</div>
    </div>
    <div class="mini-card">
        <div class="mini-card-label">Total Pengeluaran {{ $year }}</div>
        <div class="mini-card-value text-red">Rp {{ number_format($totalExpense, 0, ',', '.') }}</div>
    </div>
    <div class="mini-card">
        <div class="mini-card-label">Saldo Bersih {{ $year }}</div>
        <div class="mini-card-value {{ $totalBalance >= 0 ? 'text-blue' : 'text-red' }}">Rp {{ number_format($totalBalance, 0, ',', '.') }}</div>
    </div>
</div>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px;">
    <div class="card">
        <div class="card-title">📊 Tren Pemasukan & Pengeluaran</div>
        <canvas id="trendChart" height="220"></canvas>
    </div>
    <div class="card">
        <div class="card-title">📊 Saldo Bersih per Bulan</div>
        <canvas id="balanceChart" height="220"></canvas>
    </div>
</div>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
    <div class="card">
        <div class="card-title">📅 Detail per Bulan</div>
        <table>
            <thead>
                <tr>
                    <th>Bulan</th>
                    <th>Pemasukan</th>
                    <th>Pengeluaran</th>
                    <th>Saldo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($monthlyData as $data)
                <tr style="{{ $data['income'] == 0 && $data['expense'] == 0 ? 'opacity:0.3' : '' }}">
                    <td><strong>{{ $data['label'] }}</strong></td>
                    <td class="text-green">{{ $data['income'] > 0 ? 'Rp '.number_format($data['income'],0,',','.') : '-' }}</td>
                    <td class="text-red">{{ $data['expense'] > 0 ? 'Rp '.number_format($data['expense'],0,',','.') : '-' }}</td>
                    <td class="{{ $data['balance'] >= 0 ? 'text-blue' : 'text-red' }}">
                        <strong>{{ ($data['income']>0||$data['expense']>0) ? 'Rp '.number_format($data['balance'],0,',','.') : '-' }}</strong>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="card">
        <div class="card-title">🏆 Top 5 Pengeluaran Terbesar</div>
        @forelse($topCategories as $i => $cat)
        <div style="margin-bottom:16px;">
            <div style="display:flex; justify-content:space-between; font-size:13px; margin-bottom:6px;">
                <span><strong>{{ $i+1 }}. {{ $cat['name'] }}</strong></span>
                <span class="text-red"><strong>Rp {{ number_format($cat['total'],0,',','.') }}</strong></span>
            </div>
            <div class="progress">
                <div class="progress-bar progress-red" style="width:{{ $topCategories[0]['total'] > 0 ? ($cat['total']/$topCategories[0]['total'])*100 : 0 }}%"></div>
            </div>
        </div>
        @empty
        <div class="empty-state"><div class="icon">📊</div><p>Belum ada data pengeluaran</p></div>
        @endforelse
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = @json(collect($monthlyData)->pluck('label'));
    const incomes = @json(collect($monthlyData)->pluck('income'));
    const expenses = @json(collect($monthlyData)->pluck('expense'));
    const balances = @json(collect($monthlyData)->pluck('balance'));

    new Chart(document.getElementById('trendChart'), {
        type: 'line',
        data: { labels, datasets: [
            { label: 'Pemasukan', data: incomes, borderColor: '#10b981', backgroundColor: 'rgba(16,185,129,0.1)', fill: true, tension: 0.4, borderWidth: 2 },
            { label: 'Pengeluaran', data: expenses, borderColor: '#f43f5e', backgroundColor: 'rgba(244,63,94,0.1)', fill: true, tension: 0.4, borderWidth: 2 }
        ]},
        options: { responsive: true, plugins: { legend: { position: 'bottom' } }, scales: { y: { grid: { color: 'rgba(0,0,0,0.04)' } }, x: { grid: { display: false } } } }
    });

    new Chart(document.getElementById('balanceChart'), {
        type: 'bar',
        data: { labels, datasets: [{
            label: 'Saldo Bersih', data: balances,
            backgroundColor: balances.map(v => v >= 0 ? 'rgba(99,102,241,0.8)' : 'rgba(244,63,94,0.8)'),
            borderRadius: 6, borderSkipped: false
        }]},
        options: { responsive: true, plugins: { legend: { position: 'bottom' } }, scales: { y: { grid: { color: 'rgba(0,0,0,0.04)' } }, x: { grid: { display: false } } } }
    });
</script>
@endsection