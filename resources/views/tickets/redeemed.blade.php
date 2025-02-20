@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Ticket Redeemed Successfully</h4>
                </div>
                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 64px;"></i>
                    </div>
                    <h5 class="card-title">Ticket Details</h5>
                    <div class="card-text">
                        <p><strong>Ticket ID:</strong> {{ $ticket->ticket_id }}</p>
                        <p><strong>Type:</strong> {{ ucfirst($ticket->ticket_type) }}</p>
                        <p><strong>Price:</strong> {{ $ticket->ticket_price }}</p>
                        <p><strong>Redeemed at:</strong> {{ $ticket->redemption_date->format('Y-m-d H:i:s') }}</p>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('tickets.index') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left"></i> Back to Tickets
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 