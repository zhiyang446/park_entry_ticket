@extends('layouts.app')

@section('styles')
<link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
<style>
    .dataTables_wrapper {
        padding: 0;
        width: 100%;
    }
    
    /* Title styling */
    h2 {
        font-size: 90px !important;
        line-height: 1.2 !important;
        margin: 20px 0 !important;
    }
    
    /* Status badge styling */
    table .badge {
        font-size: 1rem;
        padding: 0.5em 1em;
    }

    /* Table styling */
    #ticketTable thead th,
    #ticketTable tbody td {
        text-align: center !important;
        vertical-align: middle !important;
    }

    #ticketTable .actions-column {
        display: flex;
        justify-content: center;
        gap: 8px;
    }
    
    @media screen and (max-width: 767px) {
        .container {
            padding: 0 15px;
        }
        .card-body {
            padding: 15px;
        }
        
        /* Mobile specific styles */
        .dtr-details {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }
        
        .dtr-details li {
            display: flex !important;
            justify-content: space-between !important;
            align-items: flex-start !important;
            padding: 15px 0 !important;
            border-bottom: 1px solid #dee2e6 !important;
        }
        
        .dtr-details li:last-child {
            border-bottom: none !important;
        }
        
        .dtr-title {
            font-weight: 600 !important;
            color: #495057 !important;
            min-width: 120px !important;
            padding-right: 15px !important;
        }
        
        .dtr-data {
            text-align: right !important;
        }
        
        /* Button styles */
        .dtr-data .btn {
            padding: 8px 16px !important;
            font-size: 14px !important;
            display: inline-block !important;
        }
        
        .dtr-data .btn-success {
            margin-right: 8px !important;
        }
        
        /* Spacing utilities */
        .mb-2 {
            margin-bottom: 0.75rem !important;
        }
        
        .mt-2 {
            margin-top: 0.75rem !important;
        }
    }
</style>
@endsection

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
    <div class="row">
        <div class="col-md-12">
            <h2 style="font-size: 35px;">Ticket Management</h2>
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addTicketModal">
                <i class="fas fa-plus"></i> Add Ticket
            </button>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="ticketTable" class="table table-bordered table-striped w-100">
                    <thead>
                        <tr>
                            <th>Ticket ID</th>
                            <th>Type</th>
                            <th>Price (RM)</th>
                            <th>Status</th>
                            <th>Creation Date</th>
                            <th>Redemption Date</th>
                            <th>QR Code</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Ticket Modal -->
    <div class="modal fade" id="addTicketModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Ticket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="addTicketForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Ticket Type</label>
                            <select class="form-select" name="ticket_type" required>
                                <option value="">Select Ticket Type</option>
                                <option value="adult">Adult</option>
                                <option value="child">Child</option>
                                <option value="senior">Senior</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Quantity</label>
                            <input type="number" class="form-control" name="ticket_quantity" min="1" value="1" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Generate Ticket</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View QR Code Modal -->
    <div class="modal fade" id="viewQrModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ticket QR Code</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="qrCodeImage" src="" alt="QR Code" style="width: 200px; height: 200px; display: unset;">
                    <div class="mt-3">
                        <p id="ticketDetails"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Use Ticket Modal -->
    <div class="modal fade" id="redeemTicketModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Use Ticket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="redeemTicketForm">
                    @csrf
                    <input type="hidden" name="ticket_id" id="redeem_ticket_id">
                    <div class="modal-body">
                        <p>Confirm to use this ticket? The status will be changed to redeemed after confirmation.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Ticket Modal -->
    <div class="modal fade" id="deleteTicketModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Delete Ticket
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="fas fa-trash text-danger mb-3" style="font-size: 48px;"></i>
                    <h5 class="mb-3">Are you sure you want to delete this ticket?</h5>
                    <p class="text-muted mb-0">This action cannot be undone.</p>
                </div>
                <div class="modal-footer justify-content-center border-0">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger px-4" id="confirmDelete">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.33/moment-timezone-with-data.min.js"></script>
<script>
    // Set moment.js default timezone to Malaysia
    moment.tz.setDefault("Asia/Kuala_Lumpur");
</script>
<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var table = $('#ticketTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: {
            details: {
                renderer: function(api, rowIdx, columns) {
                    var data = $.map(columns, function(col, i) {
                        return col.hidden ?
                            '<li class="d-flex justify-content-between align-items-center">' +
                            '<div class="dtr-title">' + col.title + '</div> ' +
                            '<div class="dtr-data">' + col.data + '</div>' +
                            '</li>' : '';
                    }).join('');
                    
                    return data ?
                        $('<ul class="dtr-details list-unstyled"/>').append(data) :
                        false;
                }
            }
        },
        ajax: {
            url: "{{ route('tickets.index') }}",
            type: 'GET',
            error: function(xhr, error, thrown) {
                console.error('DataTables error:', error);
                console.error('Server response:', xhr.responseText);
                toastr.error('Error loading ticket data. Please try refreshing the page.');
            }
        },
        columns: [
            {
                data: 'ticket_id',
                name: 'ticket_id',
                responsivePriority: 1,
                className: 'text-center'
            },
            {
                data: 'ticket_type',
                name: 'ticket_type',
                responsivePriority: 2,
                className: 'text-center',
                render: function(data) {
                    return data ? data.charAt(0).toUpperCase() + data.slice(1) : '';
                }
            },
            {
                data: 'ticket_price',
                name: 'ticket_price',
                responsivePriority: 3,
                className: 'text-center',
                render: function(data) {
                    return 'RM ' + data;
                }
            },
            {
                data: 'status',
                name: 'status',
                className: 'text-center',
                render: function(data) {
                    const statusClasses = {
                        'new': 'bg-success',
                        'redeemed': 'bg-secondary',
                        'expired': 'bg-danger'
                    };
                    return '<span class="badge ' + statusClasses[data] + '" style="font-size: 1rem; padding: 0.5em 1em;">' + 
                           data.charAt(0).toUpperCase() + data.slice(1) + '</span>';
                }
            },
            {
                data: 'creation_date',
                name: 'creation_date',
                className: 'text-center',
                render: function(data) {
                    return data ? moment.utc(data).tz('Asia/Kuala_Lumpur').format('YYYY-MM-DD HH:mm:ss') : '';
                }
            },
            {
                data: 'redemption_date',
                name: 'redemption_date',
                className: 'text-center',
                render: function(data) {
                    return data ? moment.utc(data).tz('Asia/Kuala_Lumpur').format('YYYY-MM-DD HH:mm:ss') : '';
                }
            },
            {
                data: 'qr_code',
                name: 'qr_code',
                className: 'text-center',
                render: function(data, type, row) {
                    if (data) {
                        return '<button class="btn btn-sm btn-info view-qr mb-2" data-ticket=\'' + JSON.stringify(row) + '\'>' +
                            '<i class="fas fa-qrcode"></i> View QR</button>';
                    }
                    return '-';
                }
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function(data, type, row) {
                    return '<div class="d-flex justify-content-center gap-2">' +
                           '<button class="btn btn-sm btn-success redeem-ticket" data-id="' + row.id + '">' +
                           '<i class="fas fa-check"></i> Use</button>' +
                           '<button class="btn btn-sm btn-danger delete-ticket" data-id="' + row.id + '">' +
                           '<i class="fas fa-trash"></i></button>' +
                           '</div>';
                }
            }
        ],
        order: [[3, 'desc']], // Sort by creation date by default
        language: {
            processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
        },
        drawCallback: function() {
            $('.dataTables_paginate > .pagination').addClass('pagination-sm');
        }
    });

    // View QR Code
    $('#ticketTable').on('click', '.view-qr', function() {
        var ticket = $(this).data('ticket');
        $('#qrCodeImage').attr('src', '/storage/' + ticket.qr_code);
        
        $('#ticketDetails').html(
            '<strong>Ticket ID:</strong> ' + ticket.ticket_id + '<br>' +
            '<strong>Type:</strong> ' + ticket.ticket_type + '<br>' +
            '<strong>Price:</strong> RM ' + ticket.ticket_price
        );

        $('#viewQrModal').modal('show');
    });

    // Handle add form submission
    $('#addTicketForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('tickets.store') }}",
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#addTicketModal').modal('hide');
                table.ajax.reload();
                toastr.success('Tickets created successfully!');
            },
            error: function(xhr) {
                console.error('Error:', xhr.responseText);
                toastr.error(xhr.responseJSON?.message || 'An error occurred, please try again!');
            }
        });
    });

    // Use ticket
    $('#ticketTable').on('click', '.redeem-ticket', function() {
        var id = $(this).data('id');
        $('#redeem_ticket_id').val(id);
        $('#redeemTicketModal').modal('show');
    });

    // Handle ticket usage
    $('#redeemTicketForm').on('submit', function(e) {
        e.preventDefault();
        var ticketId = $('#redeem_ticket_id').val();
        $.ajax({
            url: `/tickets/${ticketId}/redeem`,
            method: 'GET',
            success: function(response) {
                $('#redeemTicketModal').modal('hide');
                table.ajax.reload();
                toastr.success('Ticket redeemed successfully!');
            },
            error: function(xhr) {
                console.error('Error:', xhr.responseText);
                toastr.error(xhr.responseJSON?.message || 'Operation failed, please try again!');
            }
        });
    });

    // Delete ticket
    let ticketToDelete = null;
    
    $('#ticketTable').on('click', '.delete-ticket', function() {
        ticketToDelete = $(this).data('id');
        $('#deleteTicketModal').modal('show');
    });

    $('#confirmDelete').on('click', function() {
        if (ticketToDelete) {
            $.ajax({
                url: `/tickets/${ticketToDelete}`,
                method: 'DELETE',
                success: function() {
                    $('#deleteTicketModal').modal('hide');
                    table.ajax.reload();
                    toastr.success('Ticket deleted successfully!');
                    ticketToDelete = null;
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                    toastr.error(xhr.responseJSON?.message || 'Delete failed, please try again!');
                }
            });
        }
    });
});
</script>
@endsection