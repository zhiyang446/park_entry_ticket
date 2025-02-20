<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --page-bg: #20222b;
                --page-text: #f8f9fa;
                --table-bg: #2a2e37;
                --table-header: #343a40;
                --table-text: #f8f9fa;
                --table-border: #474f58;
                --table-stripe: #31353d;
                --modal-bg: #2a2e37;
                --modal-header: #343a40;
                --badge-redeemed: #6c757d;
                --badge-new: #28a745;
                --btn-primary: #0d6efd;
                --btn-info: #17a2b8;
                --btn-danger: #dc3545;
                --btn-warning: #ffc107;
            }

            /* Override Bootstrap's background */
            body, .bg-white {
                background-color: var(--page-bg) !important;
            }

            /* Fix white background issue */
            .card, .container, .container-fluid {
                background-color: var(--page-bg) !important;
            }

            /* DataTables wrapper background fix */
            div.dataTables_wrapper {
                background-color: var(--table-bg) !important;
                padding: 0;
                border-radius: 0.5rem;
                margin: 1rem 0;
                border: 1px solid var(--table-border);
            }

            /* DataTables container background fix */
            .dataTables_wrapper .row {
                background-color: var(--table-bg) !important;
                margin: 0;
                padding: 0;
            }

            /* DataTables header (length and search) */
            .dataTables_wrapper .row:first-child {
                padding: 1rem 1rem 0.5rem 1rem;
            }

            /* DataTables footer (info and pagination) */
            .dataTables_wrapper .row:last-child {
                padding: 0.5rem 1rem 1rem 1rem;
            }

            /* Table container */
            .dataTables_wrapper .row:nth-child(2) {
                padding: 0;
            }

            /* Pagination container specific */
            .dataTables_paginate {
                padding: 0 !important;
            }

            /* Pagination buttons */
            .pagination {
                margin: 0;
                display: flex;
                gap: 2px;
            }

            .pagination .page-item .page-link {
                background-color: rgba(255, 255, 255, 0.1) !important;
                border: none !important;
                color: var(--page-text) !important;
                padding: 6px 12px;
                font-size: 0.875rem;
                border-radius: 4px;
                transition: all 0.2s ease;
                min-width: 32px;
                text-align: center;
            }

            .pagination .page-item.active .page-link {
                background-color: #0d6efd !important;
                color: #ffffff !important;
                font-weight: 500;
                z-index: 1;
            }

            .pagination .page-item .page-link:hover {
                background-color: rgba(255, 255, 255, 0.2) !important;
                color: var(--page-text) !important;
                z-index: 2;
            }

            .pagination .page-item.disabled .page-link {
                background-color: rgba(255, 255, 255, 0.05) !important;
                color: rgba(255, 255, 255, 0.5) !important;
                opacity: 1;
            }

            /* Previous/Next buttons */
            .pagination .page-item:first-child .page-link,
            .pagination .page-item:last-child .page-link {
                background-color: rgba(255, 255, 255, 0.1) !important;
                color: var(--page-text) !important;
            }

            .pagination .page-item:first-child .page-link:hover,
            .pagination .page-item:last-child .page-link:hover {
                background-color: rgba(255, 255, 255, 0.2) !important;
            }

            /* DataTables pagination container */
            .dataTables_wrapper .dataTables_paginate {
                padding: 0 !important;
                margin-top: 0.5rem;
            }

            /* Force dark background on all table elements */
            table.dataTable,
            table.dataTable thead,
            table.dataTable tbody,
            table.dataTable th,
            table.dataTable td,
            .table {
                background-color: var(--table-bg) !important;
                color: var(--page-text) !important;
            }

            /* Ensure header stays dark */
            table.dataTable thead th,
            table.dataTable thead td,
            .table thead th {
                background-color: var(--table-header) !important;
                color: var(--page-text) !important;
                border-color: var(--table-border) !important;
                border-bottom: 2px solid var(--table-border) !important;
            }

            /* Style table body */
            table.dataTable tbody tr,
            table.dataTable tbody td,
            .table tbody td {
                background-color: var(--table-bg) !important;
                color: var(--page-text) !important;
                border-color: var(--table-border) !important;
            }

            /* Style striped rows */
            table.dataTable.stripe tbody tr.odd,
            table.dataTable.stripe tbody tr.odd td,
            .table-striped tbody tr:nth-of-type(odd) td {
                background-color: var(--table-stripe) !important;
            }

            /* Hover effect */
            table.dataTable tbody tr:hover,
            table.dataTable tbody tr:hover td,
            .table tbody tr:hover td {
                background-color: rgba(255, 255, 255, 0.05) !important;
            }

            /* Rest of your existing styles... */
            
            /* Additional DataTables specific overrides */
            .dataTables_length label,
            .dataTables_filter label,
            .dataTables_info {
                color: var(--page-text) !important;
            }

            .dataTables_length select,
            .dataTables_filter input {
                background-color: var(--table-header) !important;
                color: var(--page-text) !important;
                border: 1px solid var(--table-border) !important;
            }

            /* Make sure sorting icons are visible */
            table.dataTable thead .sorting:after,
            table.dataTable thead .sorting_asc:after,
            table.dataTable thead .sorting_desc:after {
                opacity: 0.7;
            }

            /* Rest of your existing styles remain unchanged */
            body {
                background-color: var(--page-bg);
                color: var(--page-text);
            }

            /* DataTables Custom Dark Theme Styling */
            .dataTables_wrapper {
                background-color: var(--table-bg);
                padding: 1.5rem;
                border-radius: 0.5rem;
                margin: 1rem 0;
                border: 1px solid var(--table-border);
            }
            
            .dataTables_wrapper .dataTables_length,
            .dataTables_wrapper .dataTables_filter,
            .dataTables_wrapper .dataTables_info,
            .dataTables_wrapper .dataTables_processing,
            .dataTables_wrapper .dataTables_paginate {
                color: var(--page-text) !important;
            }

            .dataTables_wrapper .dataTables_paginate .paginate_button {
                color: var(--page-text) !important;
                background-color: var(--table-header) !important;
                border: 1px solid var(--table-border) !important;
                border-radius: 0.25rem;
                margin: 0 2px;
            }

            .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
                background-color: var(--table-bg) !important;
                color: var(--page-text) !important;
                border: 1px solid var(--table-border) !important;
            }

            .dataTables_wrapper .dataTables_paginate .paginate_button.current,
            .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
                background: var(--btn-primary) !important;
                color: var(--page-text) !important;
                border: 1px solid var(--btn-primary) !important;
            }

            /* Table Styling */
            .table {
                color: var(--page-text) !important;
                background-color: var(--table-bg) !important;
                border-color: var(--table-border) !important;
            }

            .table thead th {
                background-color: var(--table-header) !important;
                color: var(--page-text) !important;
                border-color: var(--table-border) !important;
                padding: 12px 8px;
            }

            .table tbody td {
                border-color: var(--table-border) !important;
                padding: 12px 8px;
                background-color: var(--table-bg) !important;
                color: var(--page-text) !important;
            }

            .table-striped tbody tr:nth-of-type(odd) td {
                background-color: rgba(255, 255, 255, 0.02) !important;
            }

            /* Badge Styling */
            .badge {
                padding: 6px 10px;
                font-weight: 500;
                border-radius: 4px;
            }

            .badge-redeemed {
                background-color: var(--badge-redeemed) !important;
                color: var(--page-text) !important;
            }

            .badge-new {
                background-color: var(--badge-new) !important;
                color: var(--page-text) !important;
            }

            /* Button Styling */
            .btn {
                padding: 6px 12px;
                border-radius: 4px;
                font-weight: 500;
                transition: all 0.2s;
            }

            .btn-primary {
                background-color: var(--btn-primary) !important;
                border-color: var(--btn-primary) !important;
                color: var(--page-text) !important;
            }

            .btn-info {
                background-color: var(--btn-info) !important;
                border-color: var(--btn-info) !important;
                color: var(--page-text) !important;
            }

            .btn-info:hover {
                opacity: 0.9;
                background-color: var(--btn-info) !important;
                color: var(--page-text) !important;
            }

            .btn-danger {
                background-color: var(--btn-danger) !important;
                border-color: var(--btn-danger) !important;
                color: var(--page-text) !important;
            }

            .btn-warning {
                background-color: var(--btn-warning) !important;
                border-color: var(--btn-warning) !important;
                color: #212529 !important;
            }

            .btn:hover {
                opacity: 0.9;
                transform: translateY(-1px);
            }

            /* Search and Length Menu Styling */
            .dataTables_filter input,
            .dataTables_length select,
            .dataTables_length select option {
                background-color: var(--table-header) !important;
                color: var(--page-text) !important;
                border: 1px solid var(--table-border) !important;
                border-radius: 4px;
                padding: 6px 10px;
            }

            /* Fix for white background in select dropdown */
            select option {
                background-color: var(--table-header) !important;
                color: var(--page-text) !important;
            }

            /* Navigation styling */
            .navbar {
                background-color: var(--table-header) !important;
                border-bottom: 1px solid var(--table-border);
            }

            .navbar-brand {
                color: var(--page-text) !important;
            }

            /* Add Ticket button styling */
            .btn-add-ticket {
                background-color: var(--btn-primary);
                color: var(--page-text);
                padding: 8px 16px;
                border-radius: 4px;
                font-weight: 500;
                display: inline-flex;
                align-items: center;
                gap: 8px;
            }

            .btn-add-ticket:hover {
                opacity: 0.9;
                transform: translateY(-1px);
            }

            /* Override Bootstrap table styles */
            .table > :not(caption) > * > * {
                background-color: var(--table-bg) !important;
                color: var(--page-text) !important;
            }

            .table > thead {
                background-color: var(--table-header) !important;
                color: var(--page-text) !important;
            }

            /* Modal Dark Theme */
            .modal-content {
                background-color: var(--modal-bg) !important;
                border: 1px solid var(--table-border) !important;
                color: var(--page-text) !important;
            }

            .modal-header {
                background-color: var(--modal-header) !important;
                border-bottom: 1px solid var(--table-border) !important;
                color: var(--page-text) !important;
            }

            .modal-body {
                background-color: var(--modal-bg) !important;
                color: var(--page-text) !important;
            }

            .modal-footer {
                background-color: var(--modal-bg) !important;
                border-top: 1px solid var(--table-border) !important;
            }

            /* Close button in modal */
            .modal .btn-close {
                color: var(--page-text) !important;
                background-color: transparent !important;
                opacity: 0.8;
                filter: invert(1) grayscale(100%) brightness(200%);
            }

            .modal .btn-close:hover {
                opacity: 1;
            }

            /* QR Code container */
            .qr-code-container {
                background-color: var(--modal-bg) !important;
                color: var(--page-text) !important;
                padding: 20px;
                text-align: center;
            }

            .qr-code-container img {
                background-color: #ffffff;
                padding: 10px;
                border-radius: 8px;
                margin-bottom: 15px;
            }

            /* Modal title and text */
            .modal-title {
                color: var(--page-text) !important;
            }

            .modal-body p {
                color: var(--page-text) !important;
                margin-bottom: 1rem;
            }

            /* Form Controls Dark Theme */
            .form-control,
            .form-select {
                background-color: var(--table-header) !important;
                border: 1px solid var(--table-border) !important;
                color: var(--page-text) !important;
            }

            .form-control:focus,
            .form-select:focus {
                background-color: var(--table-header) !important;
                border-color: var(--btn-primary) !important;
                color: var(--page-text) !important;
                box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
            }

            /* Form labels */
            .form-label {
                color: var(--page-text) !important;
                margin-bottom: 0.5rem;
            }

            /* Select dropdown options */
            .form-select option {
                background-color: var(--table-header) !important;
                color: var(--page-text) !important;
            }

            /* Number input arrows */
            .form-control[type="number"]::-webkit-inner-spin-button,
            .form-control[type="number"]::-webkit-outer-spin-button {
                filter: invert(1);
            }

            /* Placeholder text */
            .form-control::placeholder,
            .form-select::placeholder {
                color: rgba(248, 249, 250, 0.6) !important;
            }

            /* Modal footer buttons */
            .modal-footer .btn-secondary {
                background-color: var(--badge-redeemed) !important;
                border-color: var(--badge-redeemed) !important;
                color: var(--page-text) !important;
            }

            .modal-footer .btn-primary {
                background-color: var(--btn-primary) !important;
                border-color: var(--btn-primary) !important;
                color: var(--page-text) !important;
            }

            /* Input group addons if any */
            .input-group-text {
                background-color: var(--table-header) !important;
                border-color: var(--table-border) !important;
                color: var(--page-text) !important;
            }

            /* Disabled form controls */
            .form-control:disabled,
            .form-control[readonly],
            .form-select:disabled {
                background-color: rgba(52, 58, 64, 0.65) !important;
                color: rgba(248, 249, 250, 0.65) !important;
            }

            /* Invalid form feedback */
            .invalid-feedback {
                color: var(--btn-danger) !important;
            }

            /* Valid form feedback */
            .valid-feedback {
                color: var(--badge-new) !important;
            }

            /* New pagination styles with more specific selectors */
            .dataTables_wrapper .dataTables_paginate .pagination {
                margin: 0;
                display: flex;
                gap: 4px;
            }

            .dataTables_wrapper .dataTables_paginate .pagination .page-item .page-link {
                background-color: #2d3748 !important;
                border: none !important;
                color: #ffffff !important;
                padding: 8px 12px;
                font-size: 14px;
                border-radius: 6px;
                min-width: 38px;
                height: 38px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0;
                transition: background-color 0.2s ease;
            }

            .dataTables_wrapper .dataTables_paginate .pagination .page-item.active .page-link {
                background-color: #3182ce !important;
                color: #ffffff !important;
                font-weight: 500;
                box-shadow: 0 0 0 2px rgba(49, 130, 206, 0.4);
            }

            .dataTables_wrapper .dataTables_paginate .pagination .page-item .page-link:hover {
                background-color: #4a5568 !important;
            }

            .dataTables_wrapper .dataTables_paginate .pagination .page-item.disabled .page-link {
                background-color: #1a202c !important;
                color: #718096 !important;
                cursor: not-allowed;
            }

            /* First and Last page buttons */
            .dataTables_wrapper .dataTables_paginate .pagination .page-item:first-child .page-link,
            .dataTables_wrapper .dataTables_paginate .pagination .page-item:last-child .page-link {
                font-size: 18px;
                padding: 4px 12px;
            }

            /* Container spacing */
            .dataTables_wrapper .dataTables_paginate {
                padding: 1rem 0 0 0 !important;
                margin: 0;
            }

            /* Override any conflicting styles */
            .page-item.active .page-link {
                z-index: 3;
                color: #fff;
                background-color: #3182ce !important;
                border-color: transparent !important;
            }

            .page-link:focus {
                box-shadow: none !important;
                z-index: 3;
            }

            /* Remove any unwanted borders or backgrounds */
            .pagination {
                background: transparent !important;
                border: none !important;
            }

            .page-link {
                border: none !important;
                background: transparent !important;
            }

            /* New clean pagination styles */
            .dataTables_wrapper .dataTables_paginate {
                padding: 0 !important;
                margin: 0 !important;
            }

            .dataTables_wrapper .dataTables_paginate .pagination {
                margin: 0;
                padding: 4px;
                display: inline-flex;
                background: rgba(0, 0, 0, 0.2);
                border-radius: 6px;
                gap: 2px;
            }

            .dataTables_wrapper .dataTables_paginate .page-item .page-link {
                padding: 6px 12px !important;
                background: rgba(255, 255, 255, 0.05) !important;
                border: none !important;
                color: rgba(255, 255, 255, 0.7) !important;
                font-size: 13px;
                min-width: 32px;
                height: 32px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 4px;
                transition: all 0.2s ease;
                margin: 0;
            }

            .dataTables_wrapper .dataTables_paginate .page-item.active .page-link {
                background: #0d6efd !important;
                color: #ffffff !important;
                font-weight: 500;
            }

            .dataTables_wrapper .dataTables_paginate .page-item .page-link:hover:not(.active) {
                background: rgba(255, 255, 255, 0.1) !important;
                color: #ffffff !important;
            }

            .dataTables_wrapper .dataTables_paginate .page-item.disabled .page-link {
                background: transparent !important;
                color: rgba(255, 255, 255, 0.3) !important;
                cursor: not-allowed;
            }

            /* First/Last and Prev/Next buttons */
            .dataTables_wrapper .dataTables_paginate .page-item:first-child .page-link,
            .dataTables_wrapper .dataTables_paginate .page-item:last-child .page-link {
                font-size: 16px;
                padding: 6px 10px !important;
            }

            /* Remove unwanted effects */
            .page-link:focus {
                box-shadow: none !important;
            }

            .pagination {
                box-shadow: none !important;
            }

            .page-item:first-child .page-link,
            .page-item:last-child .page-link {
                border-radius: 4px !important;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-page-bg">
        <div class="min-h-screen bg-page-bg text-page-text">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-table-header shadow-lg border-b border-table-border">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="container py-4">
                @yield('content')
            </main>
        </div>

        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        
        @yield('scripts')

        <script>
            // Override DataTables default styling
            $.extend(true, $.fn.dataTable.defaults, {
                "dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                       "<'row'<'col-sm-12'tr>>" +
                       "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                "language": {
                    "lengthMenu": "_MENU_ records per page",
                    "zeroRecords": "No matching records found",
                    "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                    "infoEmpty": "No records available",
                    "infoFiltered": "(filtered from _MAX_ total records)"
                }
            });

            // Fix background colors after DataTable initialization
            $(document).ready(function() {
                $('.dataTables_wrapper .row').css('background-color', 'var(--table-bg)');
                $('.card, .container, .container-fluid').css('background-color', 'var(--page-bg)');
            });
        </script>
    </body>
</html>
