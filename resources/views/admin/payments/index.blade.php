@extends('layouts.admin')

@section('title', 'Financial Ledger & Payments')

@section('content')

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Financial Ledger & Transactions</h3>
        <p class="text-secondary small mb-0">Audit online checkout transactions, receipts, and payment method reconciliations.</p>
    </div>
</div>

<!-- Financial Summary KPI Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card h-100">
            <span class="text-secondary small fw-bold text-uppercase d-block mb-1">Total Revenue</span>
            <h2 class="fw-bold text-success mb-1">${{ number_format($totalRevenue, 2) }}</h2>
            <small class="text-muted">Verified successful payments</small>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card h-100">
            <span class="text-secondary small fw-bold text-uppercase d-block mb-1">Card Gateway</span>
            <h2 class="fw-bold text-dark mb-1">${{ number_format($cardRevenue, 2) }}</h2>
            <small class="text-muted">Visa / Mastercard / Amex</small>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card h-100">
            <span class="text-secondary small fw-bold text-uppercase d-block mb-1">UPI & NetBanking</span>
            <h2 class="fw-bold text-dark mb-1">${{ number_format($upiRevenue, 2) }}</h2>
            <small class="text-muted">Instant QR & VPA transfers</small>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card h-100">
            <span class="text-secondary small fw-bold text-uppercase d-block mb-1">Counter / Cash</span>
            <h2 class="fw-bold text-dark mb-1">${{ number_format($cashRevenue, 2) }}</h2>
            <small class="text-muted">Physical front desk terminal</small>
        </div>
    </div>
</div>

<!-- Search & Filters -->
<div class="card border rounded-4 shadow-sm mb-4 bg-white p-3">
    <form action="{{ route('admin.payments.index') }}" method="GET" class="row g-2 align-items-center">
        <div class="col-md-5">
            <div class="input-group">
                <span class="input-group-text bg-light"><i class="bi bi-search text-muted"></i></span>
                <input type="text" name="search" class="form-control" placeholder="Search by Transaction ID, Receipt #, Guest name, Ref..." value="{{ request('search') }}">
            </div>
        </div>
        <div class="col-md-3">
            <select name="method" class="form-select">
                <option value="">All Payment Methods</option>
                <option value="card" {{ request('method') == 'card' ? 'selected' : '' }}>Credit / Debit Card</option>
                <option value="upi" {{ request('method') == 'upi' ? 'selected' : '' }}>UPI / QR Code</option>
                <option value="cash" {{ request('method') == 'cash' ? 'selected' : '' }}>Counter / Cash</option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="status" class="form-select">
                <option value="">All Statuses</option>
                <option value="successful" {{ request('status') == 'successful' ? 'selected' : '' }}>Successful</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
            </select>
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-dark w-100 fw-semibold">Filter</button>
            <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-secondary" title="Reset"><i class="bi bi-arrow-counterclockwise"></i></a>
        </div>
    </form>
</div>

<!-- Payments Table -->
<div class="card border rounded-4 shadow-sm bg-white overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 small">
                <thead class="table-light">
                    <tr>
                        <th>Transaction ID</th>
                        <th>Receipt Number</th>
                        <th>Guest & Reference</th>
                        <th>Method</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Payment Date</th>
                        <th class="text-end">Receipt</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $p)
                        <tr>
                            <td>
                                <span class="fw-bold font-monospace text-dark">{{ $p->transaction_id }}</span>
                                @if($p->gateway_reference)
                                    <small class="d-block text-muted font-monospace" style="font-size: 0.7rem;">{{ $p->gateway_reference }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border font-monospace">{{ $p->receipt_number }}</span>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $p->reservation->guest->full_name ?? 'Guest' }}</div>
                                @if($p->reservation)
                                    <a href="{{ route('admin.reservations.show', $p->reservation->id) }}" class="text-muted text-decoration-none font-monospace">
                                        {{ $p->reservation->booking_reference }}
                                    </a>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-dark-subtle text-dark border">{{ ucfirst($p->payment_method) }}</span>
                                @if($p->card_last_four)
                                    <small class="text-muted">(&bull;&bull;&bull;&bull; {{ $p->card_last_four }})</small>
                                @endif
                            </td>
                            <td>
                                <span class="fw-bold text-success fs-6">${{ number_format($p->amount, 2) }}</span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $p->payment_status === 'successful' ? 'success' : 'warning' }} text-uppercase">
                                    {{ $p->payment_status }}
                                </span>
                            </td>
                            <td>
                                {{ $p->paid_at ? $p->paid_at->format('M d, Y') : 'N/A' }}
                                <small class="text-muted d-block">{{ $p->paid_at ? $p->paid_at->format('h:i A') : '' }}</small>
                            </td>
                            <td class="text-end">
                                @if($p->reservation)
                                    <a href="{{ route('booking.receipt', $p->reservation->booking_reference) }}" target="_blank" class="btn btn-sm btn-outline-dark" title="Print Official Receipt">
                                        <i class="bi bi-printer-fill me-1"></i> Receipt
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">No financial transaction records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($payments->hasPages())
        <div class="card-footer bg-white border-top p-3">
            {{ $payments->links() }}
        </div>
    @endif
</div>

@endsection
