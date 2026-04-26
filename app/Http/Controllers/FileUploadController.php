<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function tmpUpload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf,webp',
        ]);
        $file = $request->file('file');
        $filename = uniqid('tmp_', true) . '.' . $file->getClientOriginalExtension();
        $file->storeAs('livewire-tmp', $filename);
        return response()->json(['success' => true, 'filename' => $filename]);
    }
}
