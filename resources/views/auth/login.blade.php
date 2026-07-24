@extends('layouts.builder360-auth')

@section('title', 'Login — Builder360 ERP CRM')

@section('content')
<main style="min-height:100vh;display:grid;place-items:center;background:var(--bg);padding:24px">
        <section class="card" style="width:min(100%,440px);padding:28px">
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:22px">
                <div class="sb-logo" style="position:static">B</div>
                <div>
                    <h1 style="margin:0;font-size:24px">Builder360 Login</h1>
                    <p style="margin:4px 0 0;color:var(--muted)">Secure ERP–CRM workspace access</p>
                </div>
            </div>

            <form method="POST" action="{{ route('login.store') }}" novalidate>
                @csrf

                <label style="display:block;margin-bottom:14px">
                    <span style="display:block;font-weight:700;margin-bottom:6px">Email</span>
                    <input
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="username"
                        style="width:100%;padding:12px 14px;border:1px solid var(--line);border-radius:12px;background:var(--surface);color:var(--text)"
                    >
                    @error('email')
                        <span style="display:block;margin-top:6px;color:var(--red);font-size:13px">{{ $message }}</span>
                    @enderror
                </label>

                <label style="display:block;margin-bottom:14px">
                    <span style="display:block;font-weight:700;margin-bottom:6px">Password</span>
                    <input
                        name="password"
                        type="password"
                        required
                        autocomplete="current-password"
                        style="width:100%;padding:12px 14px;border:1px solid var(--line);border-radius:12px;background:var(--surface);color:var(--text)"
                    >
                    @error('password')
                        <span style="display:block;margin-top:6px;color:var(--red);font-size:13px">{{ $message }}</span>
                    @enderror
                </label>

                <label style="display:flex;align-items:center;gap:8px;margin-bottom:18px;color:var(--muted);font-size:14px">
                    <input name="remember" type="checkbox" value="1">
                    Remember this device
                </label>

                <button class="btn btn-primary" type="submit" style="width:100%;justify-content:center">
                    Login to Builder360
                </button>

                <div style="margin-top:14px;text-align:center">
                    <a href="{{ route('password.request') }}" style="color:var(--accent);font-weight:700;text-decoration:none">
                        Forgot password?
                    </a>
                </div>
            </form>

        </section>
    </main>
@endsection
