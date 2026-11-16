<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProjectController extends Controller
{
    // PROSES TAMBAH DATA PROJECT
    public function store(Request $request) {
        $request->validate([
            'nama_project' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048'
        ]);

        if ($request->hasFile('gambar')) {
            $gambarFile = $request->file('gambar');
            $namaGambar = time() . '_' . uniqid() . '.' . $gambarFile->getClientOriginalExtension();
            $gambarFile->move(public_path('img'), $namaGambar);
        }

        Project::create([
            'nama_project' => $request->nama_project,
            'deskripsi' => $request->deskripsi,
            'gambar' => $namaGambar
        ]);

        return redirect('/')->with('success', 'Project baru berhasil ditambahkan!');
    }

    // PROSES EDIT / UPDATE DATA PROJECT
    public function update(Request $request, $id) {
        $project = Project::findOrFail($id);

        $request->validate([
            'nama_project' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048'
        ]);

        if ($request->hasFile('gambar')) {
            if (File::exists(public_path('img/' . $project->gambar))) {
                File::delete(public_path('img/' . $project->gambar));
            }

            $gambarFile = $request->file('gambar');
            $namaGambar = time() . '_' . uniqid() . '.' . $gambarFile->getClientOriginalExtension();
            $gambarFile->move(public_path('img'), $namaGambar);
            $project->gambar = $namaGambar;
        }

        $project->nama_project = $request->nama_project;
        $project->deskripsi = $request->deskripsi;
        $project->save();

        return redirect('/')->with('success', 'Project berhasil diperbarui!');
    }

    // PROSES HAPUS DATA PROJECT
    public function destroy($id) {
        $project = Project::findOrFail($id);
        if (File::exists(public_path('img/' . $project->gambar))) {
            File::delete(public_path('img/' . $project->gambar));
        }
        $project->delete();

        return redirect('/')->with('success', 'Project berhasil dihapus!');
    }
}