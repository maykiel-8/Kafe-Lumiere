{{-- resources/views/admin/products/trashed.blade.php --}}
@extends('layouts.admin')
@section('title','Archived Products')
@section('page-title','Product Archive')

@section('content')
<div class="section-header">
    <div>
        <div class="section-title">Archived Products</div>
        <div style="font-size:.8rem;color:#888;">Soft-deleted products — restore to bring them back</div>
    </div>
    <a href="{{ route('admin.products.index') }}" class="btn-kafe-outline">
        <i class="bi bi-arrow-left"></i> Back to Products
    </a>
</div>

<div class="kafe-card">
    <div class="kafe-card-body" style="padding:0;">
        <table class="table table-kafe mb-0" id="trashedTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Deleted On</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            {{-- DO NOT use @empty with a colspan row when using DataTables --}}
            {{-- DataTables sees 1 column (colspan) vs 5 headers = "Incorrect column count" --}}
            {{-- Let DataTables render its own "No data available" message instead --}}
            @foreach($products as $p)
            <tr>
                <td><strong>{{ $p->name }}</strong></td>
                <td>{{ $p->category->name ?? '—' }}</td>
                <td>₱{{ number_format($p->price_tall, 2) }}</td>
                <td style="font-size:.82rem;">{{ $p->deleted_at->format('M d, Y') }}</td>
                <td>
                    <form action="{{ route('admin.products.restore', $p->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn-kafe" style="font-size:.78rem;padding:4px 14px;">
                            <i class="bi bi-arrow-counterclockwise"></i> Restore
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $('#trashedTable').DataTable({
        pageLength: 15,
        language: {
            emptyTable: 'No archived products.',
            search: '<i class="bi bi-search"></i>',
            searchPlaceholder: 'Search...',
            paginate: { previous: '‹', next: '›' }
        },
        columnDefs: [
            { targets: [4], orderable: false }
        ]
    });
});
</script>
@endpush