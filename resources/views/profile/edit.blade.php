@extends('layouts.user-app')

@section('title', 'Profil')
@section('breadcrumb', 'User / Pengaturan Profil')

@section('content')

    <div class="grid-2">
        <!-- Update Profile Information -->
        <div class="card">
            <div class="card-header">
                <div>
                    <h3>Informasi Profil</h3>
                    <p style="font-size: 0.8rem; color: var(--muted); margin-top: 0.2rem;">
                        Perbarui informasi profil dan alamat email akun Anda.
                    </p>
                </div>
            </div>
            <div class="card-body">
                <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                    @csrf
                </form>

                <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('patch')

                    <!-- Photo Upload -->
                    <div class="form-group">
                        <label class="form-label" for="photo">Foto Profil</label>
                        @if ($user->photo)
                            <div style="margin-bottom: 1rem;">
                                <img src="{{ Storage::url($user->photo) }}" alt="Profile Photo" style="width: 80px; height: 80px; object-fit: cover; border-radius: 50%; border: 2px solid var(--border);">
                            </div>
                        @endif
                        <input id="photo" name="photo" type="file" class="form-control" style="padding: 0.5rem;" accept="image/*">
                        @error('photo')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="name">Nama Lengkap</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required autocomplete="name">
                        @error('name')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required autocomplete="username">
                        @error('email')
                            <p class="form-error">{{ $message }}</p>
                        @enderror

                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div style="margin-top: 0.5rem;">
                                <p style="font-size: 0.85rem; color: var(--warning);">
                                    Email Anda belum diverifikasi.
                                    <button form="send-verification" style="background: none; border: none; color: var(--accent); cursor: pointer; text-decoration: underline; font-family: inherit;">
                                        Kirim ulang email verifikasi.
                                    </button>
                                </p>
                            </div>
                        @endif
                    </div>

                    <div style="margin-top: 1.5rem;">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Update Password -->
        <div class="card">
            <div class="card-header">
                <div>
                    <h3>Ubah Password</h3>
                    <p style="font-size: 0.8rem; color: var(--muted); margin-top: 0.2rem;">
                        Pastikan akun Anda menggunakan kata sandi panjang dan acak agar tetap aman.
                    </p>
                </div>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')

                    <div class="form-group">
                        <label class="form-label" for="current_password">Password Saat Ini</label>
                        <input type="password" id="current_password" name="current_password" class="form-control" autocomplete="current-password">
                        @error('current_password', 'updatePassword')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password">Password Baru</label>
                        <input type="password" id="password" name="password" class="form-control" autocomplete="new-password">
                        @error('password', 'updatePassword')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password_confirmation">Konfirmasi Password Baru</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" autocomplete="new-password">
                        @error('password_confirmation', 'updatePassword')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div style="margin-top: 1.5rem;">
                        <button type="submit" class="btn btn-primary">Ubah Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
