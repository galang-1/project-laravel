@extends('layouts.app')
@section('content')

<div class="page-header">
    <div>
        <div class="page-title">🏷️ Kategori</div>
        <div class="page-subtitle">Kelola kategori pemasukan & pengeluaran</div>
    </div>
</div>

<!-- Form Tambah -->
<div class="card">
    <div class="card-title">Tambah Kategori Baru</div>
    <form method="POST" action="{{ route('categories.store') }}" class="form-row">
        @csrf
        <div class="form-group">
            <label class="form-label">Nama Kategori</label>
            <input type="text" name="name" required placeholder="Contoh: Makan, Gaji..." class="form-control" style="width:220px">
        </div>
        <div class="form-group">
            <label class="form-label">Tipe</label>
            <select name="type" class="form-control" style="width:160px">
                <option value="income">📈 Pemasukan</option>
                <option value="expense">📉 Pengeluaran</option>
            </select>
        </div>
        <div class="form-group">
            <button class="btn btn-primary">+ Tambah</button>
        </div>
    </form>
</div>

<!-- Daftar Kategori -->
<div class="card">
    <div class="card-title">Daftar Kategori</div>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Tipe</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td><strong>{{ $category->name }}</strong></td>
                    <td>
                        <span class="badge {{ $category->type === 'income' ? 'badge-green' : 'badge-red' }}">
                            {{ $category->type === 'income' ? '📈 Pemasukan' : '📉 Pengeluaran' }}
                        </span>
                    </td>
                    <td>
                        <form method="POST" action="{{ route('categories.destroy', $category) }}" style="margin:0">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3"><div class="empty-state"><div class="icon">🏷️</div><p>Belum ada kategori</p></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection