@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h4 class="mb-0">Ticket Error</h4>
                </div>
                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="fas fa-exclamation-circle text-danger" style="font-size: 64px;"></i>
                    </div>
                    <h5 class="card-title">Error</h5>
                    <div class="card-text">
                        <p class="text-danger">{{ $message }}</p>
                        <div class="mt-3">
                            <p><strong>Ticket ID:</strong> {{ $ticket->ticket_id }}</p>
                            <p><strong>Type:</strong> {{ ucfirst($ticket->ticket_type) }}</p>
                            <p><strong>Status:</strong> {{ ucfirst($ticket->status) }}</p>
                            @if($ticket->redemption_date)
                                <p><strong>Redeemed at:</strong> {{ $ticket->redemption_date->format('Y-m-d H:i:s') }}</p>
                            @endif
                        </div>
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