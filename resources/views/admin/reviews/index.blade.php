{{-- resources/views/admin/reviews/index.blade.php --}}
@extends('layouts.admin')
@section('title','Reviews')
@section('page-title','Product Reviews')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-label">Average Rating</div>
            <div class="stat-value">{{ $avgRating }} <span style="font-size:1.2rem;color:var(--kafe-gold);">★</span></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-label">Total Reviews</div>
            <div class="stat-value">{{ $totalReviews }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-label">5-Star Reviews</div>
            <div class="stat-value">{{ \App\Models\Review::where('rating',5)->count() }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-label">1-Star Reviews</div>
            <div class="stat-value">{{ \App\Models\Review::where('rating',1)->count() }}</div>
        </div>
    </div>
</div>

<div class="kafe-card">
    <div class="kafe-card-body" style="padding:0;">
        <table class="table table-kafe mb-0" id="reviewsTable">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Product</th>
                    <th>Rating</th>
                    <th>Review</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($reviews as $r)
            <tr id="review-row-{{ $r->id }}">
                <td>
                    <div style="display:flex;align-items:center;gap:8px;">
                        <div style="width:30px;height:30px;border-radius:50%;background:var(--kafe-blush);display:flex;align-items:center;justify-content:center;font-size:.75rem;font-weight:600;color:var(--kafe-brown);flex-shrink:0;">
                            {{ strtoupper(substr($r->user->first_name ?? '?', 0, 1)) }}
                        </div>
                        <div>
                            {{-- Null-safe: user could be deleted --}}
                            <div style="font-size:.85rem;font-weight:500;">{{ $r->user->full_name ?? '(Deleted User)' }}</div>
                            <div style="font-size:.72rem;color:#888;">{{ $r->user->email ?? '' }}</div>
                        </div>
                    </div>
                </td>
                <td style="font-size:.82rem;font-weight:500;">
                    {{-- Null-safe: product could be soft-deleted --}}
                    {{ $r->product->name ?? '(Deleted Product)' }}
                    @if($r->product && $r->product->trashed())
                        <span class="badge-kafe badge-inactive" style="font-size:.65rem;margin-left:4px;">archived</span>
                    @endif
                </td>
                <td>
                    <div style="color:var(--kafe-gold);font-size:.9rem;letter-spacing:1px;">
                        {{ str_repeat('★', $r->rating) }}{{ str_repeat('☆', 5 - $r->rating) }}
                    </div>
                    <div style="font-size:.7rem;color:#888;">{{ $r->rating }}/5</div>
                </td>
                <td style="font-size:.82rem;max-width:280px;">{{ $r->comment }}</td>
                <td style="font-size:.8rem;">{{ $r->created_at->format('M d, Y') }}</td>
                <td>
                    <form action="{{ route('admin.reviews.destroy', $r) }}" method="POST"
                          onsubmit="return confirm('Delete this review permanently?')">
                        @csrf @method('DELETE')
                        <button class="btn-icon danger" title="Delete Review">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $reviews->links() }}</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $('#reviewsTable').DataTable({
        pageLength: 15,
        language: {
            emptyTable: 'No reviews yet.',
            search: '<i class="bi bi-search"></i>',
            searchPlaceholder: 'Search...',
            paginate: { previous: '‹', next: '›' }
        },
        columnDefs: [{ targets: [2, 5], orderable: false }]
    });
});
</script>
@endpush