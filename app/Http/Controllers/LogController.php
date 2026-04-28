<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index()
    {
        // On récupère tous les logs avec les infos de l'utilisateur
        $logs = ActivityLog::with('user')->latest()->paginate(50);
        
        return view('admin.logs', compact('logs'));
    }
}