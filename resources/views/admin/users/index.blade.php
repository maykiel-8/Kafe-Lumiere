{{-- resources/views/admin/users/index.blade.php --}}
@extends('layouts.admin')
@section('title','Users')
@section('page-title','User Management')

@section('content')
<div class="section-header">
    <div>
        <div class="section-title">Users</div>
        <div style="font-size:.8rem;color:#888;">Manage staff accounts and roles</div>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn-kafe"><i class="bi bi-person-plus"></i> Add User</a>
</div>

<div class="kafe-card">
    <div class="kafe-card-body" style="padding:0;">
        <table class="table table-kafe mb-0" id="usersTable">
            <thead>
                <tr><th>Photo</th><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th>Verified</th><th>Joined</th><th>Actions</th></tr>
            </thead>
            <tbody>
            @foreach($users as $user)
            <tr id="user-row-{{ $user->id }}">
                <td>
                    <div style="width:36px;height:36px;border-radius:50%;overflow:hidden;background:var(--kafe-caramel);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:600;font-size:.8rem;">
                        @if($user->photo)
                            <img src="{{ asset('storage/'.$user->photo) }}" style="width:100%;height:100%;object-fit:cover;">
                        @else
                            {{ strtoupper(substr($user->first_name,0,1)) }}
                        @endif
                    </div>
                </td>
                <td><strong>{{ $user->full_name }}</strong></td>
                <td style="font-size:.82rem;">{{ $user->email }}</td>
                <td>
                    {{-- FIX: Pure Blade syntax for selected — no JS template literals --}}
                    <select class="form-control-kafe" style="width:115px;padding:4px 8px;font-size:.78rem;"
                            onchange="updateRole({{ $user->id }}, this.value)"
                            {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                        <option value="admin"    {{ $user->role === 'admin'    ? 'selected' : '' }}>Admin</option>
                        <option value="cashier"  {{ $user->role === 'cashier'  ? 'selected' : '' }}>Cashier</option>
                        <option value="customer" {{ $user->role === 'customer' ? 'selected' : '' }}>Customer</option>
                    </select>
                </td>
                <td>
                    <button class="badge-kafe {{ $user->status === 'active' ? 'badge-active' : 'badge-inactive' }}"
                            style="border:none;cursor:pointer;background:none;"
                            onclick="toggleStatus({{ $user->id }}, this)"
                            {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                        {{ ucfirst($user->status) }}
                    </button>
                </td>
                <td>
                    @if($user->email_verified_at)
                        <span style="color:var(--kafe-sage);font-size:.82rem;"><i class="bi bi-check-circle-fill"></i> Verified</span>
                    @else
                        <span style="color:#888;font-size:.82rem;"><i class="bi bi-clock"></i> Pending</span>
                    @endif
                </td>
                <td style="font-size:.8rem;">{{ $user->created_at->format('M d, Y') }}</td>
                <td>
                    <div class="d-flex gap-1">
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn-icon" title="Edit"><i class="bi bi-pencil"></i></a>
                        @if($user->id !== auth()->id())
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                              onsubmit="return confirm('Delete this user?')">
                            @csrf @method('DELETE')
                            <button class="btn-icon danger" title="Delete"><i class="bi bi-trash"></i></button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $users->links() }}</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $('#usersTable').DataTable({
        pageLength: 15,
        columnDefs: [{ orderable: false, targets: [0, 3, 4, 7] }],
        language: {
            search: '<i class="bi bi-search"></i>',
            searchPlaceholder: 'Search...',
            paginate: { previous: '‹', next: '›' }
        }
    });
});

function toggleStatus(id, btn) {
    const current   = btn.textContent.trim().toLowerCase();
    const newStatus = current === 'active' ? 'inactive' : 'active';
    $.ajax({
        url: '/admin/users/' + id + '/status',
        method: 'PATCH',
        data: { status: newStatus },
        success(res) {
            btn.textContent = res.status.charAt(0).toUpperCase() + res.status.slice(1);
            btn.className   = 'badge-kafe ' + (res.status === 'active' ? 'badge-active' : 'badge-inactive');
            btn.style.cssText = 'border:none;cursor:pointer;background:none;';
        }
    });
}

function updateRole(id, role) {
    $.ajax({
        url: '/admin/users/' + id + '/role',
        method: 'PATCH',
        data: { role },
        success() { showToast('Role updated to ' + role); }
    });
}

function showToast(msg) {
    const t = document.createElement('div');
    t.style.cssText = 'position:fixed;bottom:24px;right:24px;background:var(--kafe-brown);color:#fff;padding:12px 20px;border-radius:10px;font-size:.85rem;z-index:9999;';
    t.textContent = '✓ ' + msg;
    document.body.appendChild(t);
    setTimeout(() => t.remove(), 2800);
}
</script>
@endpush