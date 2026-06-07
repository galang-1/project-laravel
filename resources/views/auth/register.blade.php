<x-guest-layout>
<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&family=DM+Sans:wght@300;400;500&display=swap');

:root {
    --cream: #FAF7F2;
    --dark: #1A1A2E;
    --accent: #C8A97E;
    --muted: #8A8A9A;
    --border: #E8E4DC;
    --error: #C0392B;
}

* { box-sizing: border-box; }

body {
    background: var(--cream) !important;
    font-family: 'DM Sans', sans-serif !important;
}

.min-h-screen { background: var(--cream) !important; }

.auth-wrapper {
    display: flex;
    width: 900px;
    max-width: 95vw;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 32px 80px rgba(0,0,0,0.12);
    animation: slideUp 0.6s cubic-bezier(0.16,1,0.3,1) forwards;
    opacity: 0;
    transform: translateY(20px);
    margin: 0 auto;
}

@keyframes slideUp { to { opacity:1; transform:translateY(0); } }

.auth-panel {
    width: 300px;
    flex-shrink: 0;
    background: var(--dark);
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 40px;
    overflow: hidden;
}

.auth-panel::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: linear-gradient(135deg, rgba(200,169,126,0.2) 0%, transparent 60%);
}

.panel-dots {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background-image: radial-gradient(circle at 2px 2px, rgba(200,169,126,0.12) 1px, transparent 0);
    background-size: 28px 28px;
}

.panel-logo {
    position: relative;
    z-index: 2;
    width: 44px;
    height: 44px;
    background: var(--accent);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.panel-body {
    position: relative;
    z-index: 2;
}

.panel-body h2 {
    font-family: 'Playfair Display', serif;
    font-size: 24px;
    color: #fff;
    line-height: 1.3;
    margin: 0 0 12px;
    font-weight: 600;
}

.panel-body h2 em { color: var(--accent); font-style: normal; }

.panel-features {
    list-style: none;
    padding: 0; margin: 0;
    display: flex;
    flex-direction: column;
    gap: 10px;
    position: relative;
    z-index: 2;
}

.panel-features li {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    color: rgba(255,255,255,0.55);
    font-family: 'DM Sans', sans-serif;
}

.panel-features li::before {
    content: '';
    width: 5px; height: 5px;
    background: var(--accent);
    border-radius: 50%;
    flex-shrink: 0;
}

.auth-form-side {
    flex: 1;
    background: #fff;
    padding: 40px 44px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.form-head { margin-bottom: 22px; }

.form-head h1 {
    font-family: 'Playfair Display', serif;
    font-size: 24px;
    color: var(--dark);
    font-weight: 600;
    margin: 0 0 4px;
}

.form-head p { font-size: 13px; color: var(--muted); margin: 0; }
.form-head p a { color: var(--accent); text-decoration: none; font-weight: 500; }

.alert-err {
    background: #FDF2F2;
    border: 1px solid #F5C6C6;
    border-radius: 10px;
    padding: 10px 14px;
    margin-bottom: 16px;
    font-size: 12px;
    color: var(--error);
    display: flex;
    align-items: center;
    gap: 7px;
}

.field { margin-bottom: 14px; }

.field label {
    display: block;
    font-size: 11px;
    font-weight: 500;
    color: var(--dark);
    letter-spacing: .08em;
    text-transform: uppercase;
    margin-bottom: 6px;
    font-family: 'DM Sans', sans-serif;
}

.field input[type="text"],
.field input[type="email"],
.field input[type="password"] {
    width: 100% !important;
    height: 44px !important;
    border: 1.5px solid var(--border) !important;
    border-radius: 10px !important;
    padding: 0 14px !important;
    font-family: 'DM Sans', sans-serif !important;
    font-size: 14px !important;
    color: var(--dark) !important;
    background: #FAFAFA !important;
    outline: none !important;
    box-shadow: none !important;
    transition: all .2s ease;
    display: block;
}

.field input:focus {
    border-color: var(--accent) !important;
    background: #fff !important;
    box-shadow: 0 0 0 4px rgba(200,169,126,0.12) !important;
}

.field-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
}

.strength-bars {
    display: flex;
    gap: 4px;
    margin-top: 6px;
}

.s-bar {
    height: 3px;
    flex: 1;
    background: var(--border);
    border-radius: 2px;
    transition: background .3s;
}

.btn-register {
    width: 100%;
    height: 48px;
    background: var(--dark) !important;
    color: #fff !important;
    border: none !important;
    border-radius: 10px !important;
    font-family: 'DM Sans', sans-serif !important;
    font-size: 14px !important;
    font-weight: 500 !important;
    cursor: pointer;
    margin-top: 6px;
    transition: all .3s ease;
    box-shadow: none !important;
}

.btn-register:hover {
    background: #2D2D4A !important;
    transform: translateY(-1px);
    box-shadow: 0 8px 24px rgba(26,26,46,0.25) !important;
}

@media (max-width: 680px) {
    .auth-panel { display: none; }
    .auth-form-side { padding: 32px 22px; }
    .auth-wrapper { border-radius: 0; }
    .field-row { grid-template-columns: 1fr; }
}
</style>

<div class="auth-wrapper">

    {{-- Left panel --}}
    <div class="auth-panel">
        <div class="panel-dots"></div>

        <div class="panel-logo">
            <svg viewBox="0 0 32 32" width="22" height="22" xmlns="http://www.w3.org/2000/svg">
                <polygon points="16,3 29,10 29,22 16,29 3,22 3,10" fill="none" stroke="white" stroke-width="2"/>
                <polygon points="16,9 23,13 23,19 16,23 9,19 9,13" fill="white" opacity="0.35"/>
                <circle cx="16" cy="16" r="3" fill="white"/>
            </svg>
        </div>

        <div class="panel-body">
            <h2>Mulai perjalanan <em>finansial</em> Anda</h2>
        </div>

        <ul class="panel-features">
            <li>Lacak pengeluaran harian</li>
            <li>Buat anggaran bulanan</li>
            <li>Pantau tujuan tabungan</li>
            <li>Laporan keuangan visual</li>
        </ul>
    </div>

    {{-- Right form --}}
    <div class="auth-form-side">

        <div class="form-head">
            <h1>Buat akun baru</h1>
            <p>Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a></p>
        </div>

        @if ($errors->any())
        <div class="alert-err">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="field">
                <label for="name">Nama Lengkap</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}"
                    required autofocus autocomplete="name" placeholder="Nama lengkap Anda">
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="field">
                <label for="email">Alamat Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                    required autocomplete="username" placeholder="nama@email.com">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="field-row">
                <div class="field">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password"
                        required autocomplete="new-password" placeholder="Min. 8 karakter"
                        oninput="strengthCheck(this.value)">
                    <div class="strength-bars">
                        <div class="s-bar" id="sb1"></div>
                        <div class="s-bar" id="sb2"></div>
                        <div class="s-bar" id="sb3"></div>
                        <div class="s-bar" id="sb4"></div>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="field">
                    <label for="password_confirmation">Konfirmasi</label>
                    <input id="password_confirmation" type="password"
                        name="password_confirmation"
                        required autocomplete="new-password" placeholder="Ulangi password">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
            </div>

            <button type="submit" class="btn-register">Buat Akun</button>
        </form>

    </div>
</div>

<script>
function strengthCheck(v) {
    let s = 0;
    if (v.length >= 8) s++;
    if (/[A-Z]/.test(v)) s++;
    if (/[0-9]/.test(v)) s++;
    if (/[^A-Za-z0-9]/.test(v)) s++;
    const c = ['#E74C3C','#E67E22','#F1C40F','#27AE60'];
    [1,2,3,4].forEach(i => {
        document.getElementById('sb'+i).style.background = i <= s ? c[s-1] : 'var(--border)';
    });
}
</script>

</x-guest-layout>