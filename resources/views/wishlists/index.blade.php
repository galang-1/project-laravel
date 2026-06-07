@extends('layouts.app')
@section('content')

<div class="page-header">
    <div>
        <div class="page-title">🛍️ Wishlist</div>
        <div class="page-subtitle">Daftar barang impianmu</div>
    </div>
</div>

<div class="card">
    <div class="card-title">Tambah Item Wishlist</div>
    <form method="POST" action="{{ route('wishlists.store') }}" class="form-row">
        @csrf
        <div class="form-group">
            <label class="form-label">Icon</label>
            <input type="text" name="icon" value="🛍️" maxlength="4" class="form-control" style="width:70px; text-align:center; font-size:20px;">
        </div>
        <div class="form-group">
            <label class="form-label">Nama Barang</label>
            <input type="text" name="name" required placeholder="Contoh: MacBook Pro" class="form-control" style="width:180px">
        </div>
        <div class="form-group">
            <label class="form-label">Estimasi Harga</label>
            <input type="number" name="estimated_price" min="0" placeholder="Opsional" class="form-control" style="width:160px">
        </div>
        <div class="form-group">
            <label class="form-label">Link</label>
            <input type="url" name="link" placeholder="https://..." class="form-control" style="width:180px">
        </div>
        <div class="form-group">
            <label class="form-label">Prioritas</label>
            <select name="priority" class="form-control" style="width:130px">
                <option value="high">🔴 Tinggi</option>
                <option value="medium" selected>🟡 Sedang</option>
                <option value="low">🟢 Rendah</option>
            </select>
        </div>
        <div class="form-group">
            <button class="btn btn-primary">+ Tambah</button>
        </div>
    </form>
</div>

@if($totalEstimated > 0)
<div style="background:linear-gradient(135deg,#6366f1,#8b5cf6); border-radius:16px; padding:16px 22px; margin-bottom:20px; color:#fff; font-size:14px; font-weight:600;">
    💰 Total estimasi belanja: Rp {{ number_format($totalEstimated, 0, ',', '.') }}
</div>
@endif

<div class="card">
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Harga</th>
                    <th>Prioritas</th>
                    <th>Link</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($wishlists as $item)
                <tr style="{{ $item->is_bought ? 'opacity:0.5' : '' }}">
                    <td>
                        <span style="font-size:18px;">{{ $item->icon }}</span>
                        <strong style="{{ $item->is_bought ? 'text-decoration:line-through' : '' }}">{{ $item->name }}</strong>
                    </td>
                    <td>{{ $item->estimated_price ? 'Rp ' . number_format($item->estimated_price, 0, ',', '.') : '-' }}</td>
                    <td>{{ $item->priorityLabel() }}</td>
                    <td>
                        @if($item->link)
                        <a href="{{ $item->link }}" target="_blank" class="btn-link-blue">Lihat →</a>
                        @else -
                        @endif
                    </td>
                    <td>
                        @if($item->is_bought)
                        <span class="badge badge-green">✅ Sudah dibeli</span>
                        @else
                        <span class="badge badge-yellow">⏳ Belum dibeli</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-group">
                            <form method="POST" action="{{ route('wishlists.toggle', $item) }}" style="margin:0">
                                @csrf
                                <button class="btn btn-sm {{ $item->is_bought ? 'btn-gray' : 'btn-success' }}">
                                    {{ $item->is_bought ? 'Batal' : '✅ Beli' }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('wishlists.destroy', $item) }}" style="margin:0">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6"><div class="empty-state"><div class="icon">🛍️</div><p>Belum ada wishlist</p></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection