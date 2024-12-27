<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VideoController extends Controller
{
    public function analyze(Request $request)
    {

        $video = $request->file('video');

        // Kirim file ke API Python
        $response = Http::attach(
            'file', file_get_contents($video->getRealPath()), $video->getClientOriginalName()
        )->post('http://127.0.0.1:5000/detect');
        if ($response->failed()) {
            return back()->withErrors(['error' => 'Failed to analyze video.']);
        }

        $violations = $response->json()['violations'];
        return view('results', ['violations' => $violations]);
    }
}
