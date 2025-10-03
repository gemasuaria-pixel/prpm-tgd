<?php

namespace App\Http\Controllers\ResearchController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ResearchProposal;

class UploadPenelitianController extends Controller
{

     public function index(){
        
        return view('user.penelitian.usulanProposal');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'year' => ['required', 'integer', 'between:1900,3000'],
            'discipline' => ['required', 'string', 'max:255'],
            'leader_name' => ['required', 'string', 'max:255'],
            'field_of_study' => ['nullable', 'string', 'max:255'],
            'keywords' => ['required', 'string', 'max:255'],
            'abstract' => ['required', 'string'],
        ]);

        ResearchProposal::create([
            'user_id' => $request->user()->id,
            'title' => $validated['title'],
            'year' => $validated['year'],
            'discipline' => $validated['discipline'],
            'leader_name' => $validated['leader_name'],
            'field_of_study' => $validated['field_of_study'] ?? null,
            'keywords' => $validated['keywords'],
            'abstract' => $validated['abstract'],
        ]);

        return redirect()->route('user.usulanProposal')->with('status', 'Usulan berhasil disimpan.');
    }
}
