@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">Manajemen Pesanan Masuk (Admin)</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th>ID Invoice</th>
                            <th>Pelanggan</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td class="fw-bold">{{ $order->invoice_code }}</td>
                            <td>
                                {{ $order->user->name }}<br>
                                <small class="text-muted">{{ $order->user->email }}</small>
                            </td>
                            <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                            <td class="fw-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            <td>
                                {{-- Form Update Status --}}
                                <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST">
                                    @csrf 
                                    <select name="status" class="form-select form-select-sm" 
                                            onchange="this.form.submit()" 
                                            style="width: 130px; border-color: 
                                            {{ $order->status == 'completed' ? 'green' : ($order->status == 'pending' ? 'orange' : 'blue') }}">
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Paid</option>
                                        <option value="cooking" {{ $order->status == 'cooking' ? 'selected' : '' }}>Cooking</option>
                                        <option value="served" {{ $order->status == 'served' ? 'selected' : '' }}>Served</option>
                                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </form>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#detailModal{{ $order->id }}">
                                    Lihat Detail
                                </button>

                                {{-- MODAL DETAIL --}}
                                <div class="modal fade" id="detailModal{{ $order->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Detail Order: {{ $order->invoice_code }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <ul class="list-group list-group-flush">
                                                    @foreach($order->orderItems as $item)
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <span class="fw-bold">{{ $item->product->nama_produk }}</span>
                                                            <div class="text-muted small">Qty: {{ $item->quantity }} x Rp {{ number_format($item->price_at_purchase, 0, ',', '.') }}</div>
                                                        </div>
                                                        <span class="fw-bold">Rp {{ number_format($item->quantity * $item->price_at_purchase, 0, ',', '.') }}</span>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                                <div class="mt-3 text-end fw-bold fs-5">
                                                    Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination --}}
            <div class="mt-3">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>
@endsection