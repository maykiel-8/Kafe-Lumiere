{{-- resources/views/admin/users/create.blade.php --}}
@extends('layouts.admin')
@section('title', isset($user) ? 'Edit User' : 'Add User')
@section('page-title', isset($user) ? 'Edit User' : 'Add User')
 
@section('content')
<div class="row justify-content-center">
<div class="col-lg-7">
 
<form action="{{ isset($user) ? route('admin.users.update', $user) : route('admin.users.store') }}"
      method="POST" enctype="multipart/form-data">
@csrf
@if(isset($user)) @method('PUT') @endif
 
<div class="kafe-card mb-3">
    <div class="kafe-card-header"><span style="font-weight:500;">{{ isset($user) ? 'Edit User Account' : 'New User Account' }}</span></div>
    <div class="kafe-card-body">
 
        {{-- Avatar upload --}}
        <div style="text-align:center;margin-bottom:1.5rem;">
            <div id="avatarPreview" style="width:90px;height:90px;border-radius:50%;background:var(--kafe-caramel);margin:0 auto 10px;display:flex;align-items:center;justify-content:center;font-size:2.2rem;color:#fff;font-family:var(--font-serif);overflow:hidden;cursor:pointer;" onclick="document.getElementById('photoInput').click()">
                @if(isset($user) && $user->photo)
                    <img src="{{ asset('storage/'.$user->photo) }}" style="width:100%;height:100%;object-fit:cover;">
                @else
                    <i class="bi bi-person" style="font-size:2rem;"></i>
                @endif
            </div>
            <button type="button" class="btn-kafe-outline" style="font-size:.78rem;padding:4px 14px;" onclick="document.getElementById('photoInput').click()">
                <i class="bi bi-camera"></i> Upload Photo
            </button>
            <input type="file" id="photoInput" name="photo" accept="image/*" style="display:none;" onchange="previewAvatar(event)">
            <div style="font-size:.72rem;color:#888;margin-top:4px;">JPG/PNG, max 2MB. Email verification will be sent on creation.</div>
        </div>
 
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label-kafe">First Name *</label>
                <input class="form-control-kafe @error('first_name') is-invalid @enderror"
                       name="first_name" value="{{ old('first_name', $user->first_name ?? '') }}" required>
                @error('first_name')<div style="font-size:.73rem;color:#c0392b;">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label-kafe">Last Name *</label>
                <input class="form-control-kafe @error('last_name') is-invalid @enderror"
                       name="last_name" value="{{ old('last_name', $user->last_name ?? '') }}" required>
                @error('last_name')<div style="font-size:.73rem;color:#c0392b;">{{ $message }}</div>@enderror
            </div>
            <div class="col-12">
                <label class="form-label-kafe">Email Address *</label>
                <input class="form-control-kafe @error('email') is-invalid @enderror"
                       name="email" type="email" value="{{ old('email', $user->email ?? '') }}" required>
                @error('email')<div style="font-size:.73rem;color:#c0392b;">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label-kafe">Role *</label>
                <select class="form-control-kafe" name="role" required>
                    <option value="cashier" {{ old('role', $user->role ?? '') === 'cashier' ? 'selected':'' }}>Cashier</option>
                    <option value="admin"   {{ old('role', $user->role ?? '') === 'admin'   ? 'selected':'' }}>Admin</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label-kafe">Status</label>
                <select class="form-control-kafe" name="status">
                    <option value="active"   {{ old('status', $user->status ?? 'active')   === 'active'   ? 'selected':'' }}>Active</option>
                    <option value="inactive" {{ old('status', $user->status ?? '') === 'inactive' ? 'selected':'' }}>Inactive</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label-kafe">Password {{ isset($user) ? '(leave blank to keep)' : '*' }}</label>
                <input class="form-control-kafe @error('password') is-invalid @enderror"
                       name="password" type="password"
                       placeholder="{{ isset($user) ? 'New password…' : 'Min 8 characters' }}"
                       {{ isset($user) ? '' : 'required' }}>
                @error('password')<div style="font-size:.73rem;color:#c0392b;">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label-kafe">Confirm Password</label>
                <input class="form-control-kafe" name="password_confirmation" type="password" placeholder="Repeat password">
            </div>
        </div>
    </div>
</div>
 
<div class="d-flex gap-2">
    <button type="submit" class="btn-kafe">
        <i class="bi bi-check2"></i> {{ isset($user) ? 'Update User' : 'Create User' }}
    </button>
    <a href="{{ route('admin.users.index') }}" class="btn-kafe-outline">Cancel</a>
</div>
</form>
 
</div>
</div>
@endsection
 
@push('scripts')
<script>
function previewAvatar(e) {
    const file = e.target.files[0];
    if (!file) return;
    const wrap = document.getElementById('avatarPreview');
    wrap.innerHTML = `<img src="${URL.createObjectURL(file)}" style="width:100%;height:100%;object-fit:cover;">`;
}
</script>
@endpush
 
