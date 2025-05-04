<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use Illuminate\Http\Request;


class InvitationController extends Controller
{
    public function index()
    {
        $invitations = \App\Models\Invitation::with(['inviter', 'invitee'])->get()->map(function ($invite) {
            return [
                'guardian1_name' => isset($invite->inviter) ? $invite->inviter->first_name . ' ' . $invite->inviter->last_name : 'Unknown',
                'email' => $invite->email,
                'status' => $invite->status,
                'guardian2_name' => isset($invite->invitee) ? $invite->invitee->first_name . ' ' . $invite->invitee->last_name : null,
                'created_at' => $invite->created_at,
            ];
        });      

        return view('admin.invitations.list', compact('invitations'));
    }    
}
