<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Redeemed</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .success-icon {
            color: #28a745;
            font-size: 80px;
            margin: 20px 0;
        }
        .ticket-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            margin-top: 20px;
        }
        .ticket-header {
            background: #28a745;
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 20px;
        }
        .ticket-body {
            padding: 20px;
        }
        .ticket-info {
            margin: 10px 0;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <div class="ticket-card">
                    <div class="ticket-header text-center">
                        <h4 class="mb-0">Ticket Successfully Redeemed</h4>
                    </div>
                    <div class="ticket-body text-center">
                        <i class="fas fa-check-circle success-icon"></i>
                        
                        <div class="ticket-info">
                            <h5>Ticket Details</h5>
                            <p class="mb-2"><strong>Ticket ID:</strong> {{ $ticket->ticket_id }}</p>
                            <p class="mb-2"><strong>Type:</strong> {{ ucfirst($ticket->ticket_type) }}</p>
                            <p class="mb-2"><strong>Price:</strong> RM{{ number_format($ticket->ticket_price, 2) }}</p>
                            <p class="mb-0"><strong>Redeemed at:</strong><br>{{ $ticket->redemption_date->format('Y-m-d H:i:s') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 