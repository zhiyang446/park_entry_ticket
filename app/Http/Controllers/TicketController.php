<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $currentUser = Auth::user();

            // 检查是否是管理员
            if (!$currentUser->is_admin) {
                return response()->json(['error' => 'User not authenticated.'], 403);
            }

            // 处理 DataTables 的 Ajax 请求
            if ($request->ajax()) {
                $tickets = Ticket::query();
                return DataTables::of($tickets)
                    ->addColumn('action', function ($ticket) {
                        $buttons = '';
                        if ($ticket->status === 'new') {
                            $buttons .= '<button class="btn btn-sm btn-success redeem-ticket" data-id="'.$ticket->id.'">
                                <i class="fas fa-check"></i> Use</button> ';
                        }
                        $buttons .= '<button class="btn btn-sm btn-danger delete-ticket" data-id="'.$ticket->id.'">
                            <i class="fas fa-trash"></i></button>';
                        return $buttons;
                    })
                    ->editColumn('status', function ($ticket) {
                        $statusClasses = [
                            'new' => 'bg-success',
                            'redeemed' => 'bg-secondary',
                            'expired' => 'bg-danger'
                        ];
                        return '<span class="badge '.$statusClasses[$ticket->status].'">'
                            .ucfirst($ticket->status).'</span>';
                    })
                    ->editColumn('creation_date', function ($ticket) {
                        return $ticket->creation_date ? Carbon::parse($ticket->creation_date)->format('Y-m-d H:i:s') : '';
                    })
                    ->editColumn('redemption_date', function ($ticket) {
                        return $ticket->redemption_date ? 
                            Carbon::parse($ticket->redemption_date)->format('Y-m-d H:i:s') : '';
                    })
                    ->rawColumns(['action', 'status'])
                    ->toJson();
            }

            return view('ticketList');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'error' => true,
                    'message' => $e->getMessage()
                ], 500);
            }
            throw $e;
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ticket_type' => 'required|string',
            'ticket_quantity' => 'required|integer|min:1'
        ]);

        $prices = [
            'adult' => '100',
            'child' => '50',
            'senior' => '75'
        ];

        $tickets = [];
        $today = Carbon::now()->format('Ymd');
        $baseCount = Ticket::whereDate('creation_date', today())->count();

        for ($i = 0; $i < $request->ticket_quantity; $i++) {
            $count = $baseCount + $i + 1;
            $ticket_id = 'TIC' . $today . '_' . str_pad($count, 3, '0', STR_PAD_LEFT);

            $ticket = Ticket::create([
                'ticket_id' => $ticket_id,
                'ticket_type' => $request->ticket_type,
                'ticket_price' => $prices[$request->ticket_type] ?? '100',
                'ticket_quantity' => 1,
                'creation_date' => now(),
                'status' => 'new'
            ]);

            // Generate QR code with direct redemption URL
            $redeemUrl = route('tickets.redeem', ['ticket' => $ticket->id, 'auto_redeem' => true]);
            $qrCode = QrCode::size(200)
                           ->margin(1)
                           ->generate($redeemUrl);

            // Save QR code to storage
            $qrPath = 'qrcodes/' . $ticket_id . '.svg';
            Storage::disk('public')->put($qrPath, $qrCode);

            // Update ticket with QR code path
            $ticket->qr_code = $qrPath;
            $ticket->save();

            $tickets[] = $ticket;
        }

        return response()->json([
            'success' => true,
            'message' => 'Tickets created successfully',
            'tickets' => $tickets
        ]);
    }

    /**
     * Display QR code for a ticket
     */
    public function showQrCode($id)
    {
        $ticket = Ticket::findOrFail($id);
        
        if (!$ticket->qr_code || !Storage::disk('public')->exists($ticket->qr_code)) {
            abort(404, 'QR code not found');
        }

        return response()->file(Storage::disk('public')->path($ticket->qr_code));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $ticket = Ticket::findOrFail($id);
        return response()->json(['ticket' => $ticket]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        $request->validate([
            'status' => 'required|in:new,redeemed,expired',
            'redemption_date' => 'nullable|date',
        ]);

        $ticket->status = $request->status;
        if ($ticket->status === 'redeemed') {
            $ticket->redemption_date = now();
        } else {
            $ticket->redemption_date = $request->redemption_date;
        }

        $ticket->save();

        return response()->json([
            'success' => true,
            'message' => 'Ticket updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();
        return response()->json([
            'success' => true,
            'message' => 'Ticket deleted successfully'
        ]);
    }

    /**
     * Redeem a ticket
     */
    public function redeem(Request $request, Ticket $ticket)
    {
        if($ticket->status !== 'new'){
            $message = 'Ticket has already been redeemed.';
            if ($request->query('auto_redeem')) {
                return view('tickets.mobile_redeemed', [
                    'message' => $message,
                    'ticket' => $ticket
                ]);
            }
            return response()->json([
                'success' => false,
                'message' => $message
            ], 400);
        }

        $ticket->status = 'redeemed';
        $ticket->redemption_date = now();
        $ticket->save();

        // 如果是自动兑换（通过扫描二维码），显示移动端视图
        if ($request->query('auto_redeem')) {
            return view('tickets.mobile_redeemed', ['ticket' => $ticket]);
        }

        // 如果是通过 AJAX 请求，返回 JSON
        return response()->json([
            'success' => true,
            'message' => 'Ticket redeemed successfully'
        ]);
    }
}
