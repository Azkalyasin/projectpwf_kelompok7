@extends('admin.layouts.app')

@section('title', 'Kelola User')
@section('breadcrumb', 'Admin / Users')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Daftar User</h3>
        <form action="{{ route('admin.users.index') }}" method="GET" class="search-bar" style="margin:0;">
            <input type="text" name="search" class="form-control" style="max-width:220px; padding:0.5rem 0.75rem;"
                   placeholder="Cari nama / email..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-secondary btn-sm">Cari</button>
            @if(request('search'))
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">✕</a>
            @endif
        </form>
    </div>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Bergabung</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $i => $user)
                <tr>
                    <td style="color:var(--muted)">{{ $users->firstItem() + $i }}</td>
                    <td>
                        <div style="display:flex; align-items:center; gap:0.6rem;">
                            <div style="width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,#7c3aed,#ec4899);display:flex;align-items:center;justify-content:center;font-size:0.8rem;font-weight:700;color:white;flex-shrink:0;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <span>{{ $user->name }}</span>
                        </div>
                    </td>
                    <td style="color:var(--muted)">{{ $user->email }}</td>
                    <td>
                        <span class="badge {{ $user->role === 'admin' ? 'badge-admin' : 'badge-user' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td style="color:var(--muted)">{{ $user->created_at->format('d M Y') }}</td>
                    <td>
                        <div style="display:flex; gap:0.4rem;">
                            @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.toggle-role', $user) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-warning btn-sm"
                                            title="{{ $user->role === 'admin' ? 'Jadikan User' : 'Jadikan Admin' }}">
                                        {{ $user->role === 'admin' ? '👤' : '⭐' }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                      onsubmit="return confirm('Hapus user {{ $user->name }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">🗑️</button>
                                </form>
                            @else
                                <span style="font-size:0.75rem; color:var(--muted);">Akun ini</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center; color:var(--muted); padding:3rem;">
                        Tidak ada user ditemukan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
        <div style="padding:1rem 1.5rem;">{{ $users->appends(request()->query())->links() }}</div>
    @endif
</div>
@endsection
