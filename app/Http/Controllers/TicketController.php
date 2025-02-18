<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Auth;
class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentUser = Auth::user();
        if(!$currentUser->is_admin){
            return redirect()->back()->withErrors(['error' => 'User not authenticated.']);
        }
        $tickets = Ticket::all();
        return response()->json(['tickets' => $tickets]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        validator($request->all(),[
            'ticket_id' => 'required|string|max:255',
            'creation_date' => 'required|date',
            'redemption_date' => 'nullable|date',
            'status' => 'required|in:new,redeemed,expired',
        ]);

        $today = Carbon::now()->format('Ymd');
        $count = Ticket::whereDate('creation_date', $today)->count() + 1;
        $ticket_id = 'TIC' . $today . '_' . str_pad($count, 3, '0', STR_PAD_LEFT);

        $ticket = Ticket::create([
            'ticket_id' => $ticket_id,
            'creation_date' => $today,
            'redemption_date' => $request->redemption_date ?? null,
            'status' => 'new',
        ]);

        //generate qr code
        $qrCode = QrCode::size(200)->generate($ticket->ticket_id);

        return response()->json([
            'success' => true,
            'message' => 'Ticket created successfully',
            'ticket' => $ticket,
            'qr_code' => $qrCode
        ]);
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
        validator($request->all(),[
            'status' => 'required|in:new,redeemed,expired',
            'redemption_date' => 'nullable|date',
        ]);

        $ticket->status = $request->status;
        if ($ticket->status === 'redeemed') {
            $ticket->redemption_date = now()->toDateString();
        } else {
            $ticket->redemption_date = $request->redemption_date ?? null;
        }

        $ticket->save();

        return redirect()->route('tickets.edit', $ticket->id)->with('success', 'Ticket updated successfully');
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
            'message' => 'Ticket deleted successfully']);
    }
}
