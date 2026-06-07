<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KeuanganKu</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { background: #f0f2f5; min-height: 100vh; display: flex; }

        /* Sidebar */
        .sidebar { width: 260px; background: #1e1e2e; min-height: 100vh; position: fixed; top: 0; left: 0; display: flex; flex-direction: column; z-index: 100; }
        .sidebar-brand { padding: 24px 20px; border-bottom: 1px solid #2a2a3e; display: flex; align-items: center; gap: 12px; }
        .brand-icon { width: 42px; height: 42px; background: linear-gradient(135deg, #6366f1, #8b5cf6); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; }
        .brand-text p { color: #fff; font-weight: 700; font-size: 16px; }
        .brand-text span { color: #6366f1; font-size: 11px; font-weight: 500; }

        .nav-section { padding: 16px 12px 8px; color: #4a4a6a; font-size: 10px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; }
        .nav-item { display: flex; align-items: center; gap: 12px; padding: 11px 16px; margin: 2px 8px; border-radius: 10px; color: #8888aa; font-size: 13px; font-weight: 500; text-decoration: none; transition: all 0.2s; cursor: pointer; }
        .nav-item:hover { background: #2a2a3e; color: #fff; }
        .nav-item.active { background: linear-gradient(135deg, #6366f1, #8b5cf6); color: #fff; box-shadow: 0 4px 12px rgba(99,102,241,0.4); }
        .nav-icon { font-size: 16px; width: 20px; text-align: center; }

        .sidebar-footer { margin-top: auto; padding: 16px 12px; border-top: 1px solid #2a2a3e; }
        .user-info { display: flex; align-items: center; gap: 10px; padding: 10px; border-radius: 10px; margin-bottom: 8px; background: #2a2a3e; }
        .user-avatar { width: 36px; height: 36px; background: linear-gradient(135deg, #6366f1, #8b5cf6); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: 14px; }
        .user-name { color: #fff; font-size: 13px; font-weight: 600; }
        .user-email { color: #6666aa; font-size: 11px; }
        .logout-btn { display: flex; align-items: center; gap: 10px; padding: 10px 16px; border-radius: 10px; color: #f87171; font-size: 13px; font-weight: 500; background: none; border: none; cursor: pointer; width: 100%; transition: all 0.2s; }
        .logout-btn:hover { background: rgba(248,113,113,0.1); }

        /* Main */
        .main { margin-left: 260px; flex: 1; padding: 32px; }

        /* Alert */
        .alert-success { background: #d1fae5; border: 1px solid #6ee7b7; color: #065f46; padding: 14px 18px; border-radius: 12px; margin-bottom: 24px; display: flex; align-items: center; gap: 8px; font-size: 14px; }
        /* Global Form & Card Styles */
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px; }
        .page-title { font-size: 24px; font-weight: 700; color: #1e1e2e; display: flex; align-items: center; gap: 8px; }
        .page-subtitle { color: #888; font-size: 14px; margin-top: 4px; }

        .card { background: #fff; border-radius: 20px; padding: 24px; box-shadow: 0 1px 4px rgba(0,0,0,0.06); border: 1px solid #f0f0f0; margin-bottom: 20px; }
        .card-title { font-size: 15px; font-weight: 700; color: #1e1e2e; margin-bottom: 20px; }

        /* Buttons */
        .btn { padding: 10px 20px; border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer; border: none; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s; }
        .btn-primary { background: linear-gradient(135deg, #6366f1, #8b5cf6); color: #fff; box-shadow: 0 4px 12px rgba(99,102,241,0.3); }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(99,102,241,0.4); }
        .btn-success { background: linear-gradient(135deg, #10b981, #059669); color: #fff; box-shadow: 0 4px 12px rgba(16,185,129,0.3); }
        .btn-danger { background: linear-gradient(135deg, #f43f5e, #e11d48); color: #fff; }
        .btn-gray { background: #f3f4f6; color: #374151; }
        .btn-sm { padding: 6px 14px; font-size: 12px; border-radius: 8px; }
        .btn-link-blue { color: #6366f1; font-size: 12px; font-weight: 600; text-decoration: none; background: none; border: none; cursor: pointer; padding: 0; }
        .btn-link-red { color: #f43f5e; font-size: 12px; font-weight: 600; text-decoration: none; background: none; border: none; cursor: pointer; padding: 0; }

        /* Forms */
        .form-group { margin-bottom: 16px; }
        .form-label { display: block; font-size: 12px; font-weight: 600; color: #6b7280; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px; }
        .form-control { width: 100%; padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 10px; font-size: 13px; color: #1e1e2e; background: #fafafa; transition: all 0.2s; outline: none; }
        .form-control:focus { border-color: #6366f1; background: #fff; box-shadow: 0 0 0 3px rgba(99,102,241,0.1); }
        .form-row { display: flex; gap: 16px; flex-wrap: wrap; align-items: flex-end; }
        .form-row .form-group { margin-bottom: 0; }

        /* Tables */
        .table-wrapper { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        thead tr { background: #f8f9ff; }
        th { padding: 12px 16px; text-align: left; font-weight: 700; color: #6b7280; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; }
        td { padding: 14px 16px; border-bottom: 1px solid #f5f5f5; color: #374151; vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #fafafe; }

        /* Badges */
        .badge { padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 600; }
        .badge-green { background: #d1fae5; color: #065f46; }
        .badge-red { background: #fee2e2; color: #991b1b; }
        .badge-blue { background: #dbeafe; color: #1e40af; }
        .badge-yellow { background: #fef3c7; color: #92400e; }

        /* Progress Bar */
        .progress { background: #f3f4f6; border-radius: 999px; height: 8px; overflow: hidden; margin: 6px 0; }
        .progress-bar { height: 100%; border-radius: 999px; transition: width 0.5s; }
        .progress-green { background: linear-gradient(90deg, #10b981, #059669); }
        .progress-red { background: linear-gradient(90deg, #f43f5e, #e11d48); }
        .progress-blue { background: linear-gradient(90deg, #6366f1, #8b5cf6); }
        .progress-yellow { background: linear-gradient(90deg, #f59e0b, #d97706); }

        /* Stat mini cards */
        .mini-cards { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 20px; }
        .mini-card { background: #fff; border-radius: 16px; padding: 18px; border: 1px solid #f0f0f0; }
        .mini-card-label { font-size: 11px; color: #9ca3af; font-weight: 600; text-transform: uppercase; margin-bottom: 6px; }
        .mini-card-value { font-size: 20px; font-weight: 800; }
        .text-green { color: #10b981; }
        .text-red { color: #f43f5e; }
        .text-blue { color: #6366f1; }
        .text-gray { color: #9ca3af; }

        /* Empty state */
        .empty-state { text-align: center; padding: 48px 20px; color: #9ca3af; }
        .empty-state .icon { font-size: 48px; margin-bottom: 12px; }
        .empty-state p { font-size: 14px; }

        /* Action buttons in table */
        .action-group { display: flex; align-items: center; gap: 8px; }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon">💰</div>
            <div class="brand-text">
                <p>KeuanganKu</p>
                <span>Personal Finance</span>
            </div>
        </div>

        <div class="nav-section">Menu Utama</div>
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <span class="nav-icon">📊</span> Dashboard
        </a>
        <a href="{{ route('transactions.index') }}" class="nav-item {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
            <span class="nav-icon">💸</span> Transaksi
        </a>
        <a href="{{ route('categories.index') }}" class="nav-item {{ request()->routeIs('categories.*') ? 'active' : '' }}">
            <span class="nav-icon">🏷️</span> Kategori
        </a>

        <div class="nav-section">Perencanaan</div>
        <a href="{{ route('budgets.index') }}" class="nav-item {{ request()->routeIs('budgets.*') ? 'active' : '' }}">
            <span class="nav-icon">🔔</span> Budget
        </a>
        <a href="{{ route('goals.index') }}" class="nav-item {{ request()->routeIs('goals.*') ? 'active' : '' }}">
            <span class="nav-icon">🎯</span> Goals
        </a>
        <a href="{{ route('wishlists.index') }}" class="nav-item {{ request()->routeIs('wishlists.*') ? 'active' : '' }}">
            <span class="nav-icon">🛍️</span> Wishlist
        </a>
        <a href="{{ route('reports.index') }}" class="nav-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
            <span class="nav-icon">📈</span> Laporan
        </a>

        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div>
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <div class="user-email">{{ auth()->user()->email }}</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="logout-btn">🚪 Logout</button>
            </form>
        </div>
    </aside>

    <main class="main">
        @if(session('success'))
        <div class="alert-success">✅ {{ session('success') }}</div>
        @endif
        @yield('content')
    </main>
</body>
</html>