<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TodoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Pastikan pengguna sudah login
    }

    // Menampilkan semua data Todo
    public function index(Request $request)
    {
        $todos = Todo::latest()->paginate(3); // Fetch semua data Todo

        if ($request->has('search')) {
            $todos = $this->search($request->get('search'));
        }
        return view('todo.index', compact('todos'));
    }
    public function pending(Request $request)
    {
        $todos = Todo::where('completed', 0)->paginate(3); // Fetch semua data Todo

        if ($request->has('search')) {
            $todos = $this->search($request->get('search'));
        }
        return view('todo.pending', compact('todos'));
    }
    public function history()
    {
        $todos = Todo::where('completed', 1)->paginate(5); // Fetch semua data Todo
        return view('todo.history', compact('todos'));
    }

    // Menampilkan form tambah Todo
    public function create()
    {
        return view('todo.tambah');
    }

    // Menyimpan data Todo baru
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'title' => 'required|unique:todos,title',
            'description' => 'required|string',
            'documentation' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('documentation')) {
            $path = $request->file('documentation')->store('todos', 'public');
            $validated['documentation'] = $path;
        }

        Todo::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'completed' => $request->has('completed') ? true : false,
            'documentation' => $validated['documentation'] ?? null,
        ]);


        return redirect()->route('todo.index')->with('success', 'To Do berhasil ditambahkan.');
    }

    // Menampilkan form edit Todo
    public function edit(Todo $todo)
    {
        return view('todo.edit', compact('todo'));
    }

    public function update(Request $request, Todo $todo)
    {
        // Validasi input
        $validated = $request->validate([
            'title' => 'required|string|unique:todos,title,' . $todo->id . '|max:255',
            'description' => 'required|string',
            'completed' => 'boolean',
            'documentation' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        // Periksa jika ada file baru diunggah
        if ($request->hasFile('documentation')) {
            // Hapus file lama jika ada
            if ($todo->documentation && \Storage::disk('public')->exists($todo->documentation)) {
                \Storage::disk('public')->delete($todo->documentation);
            }

            // Simpan file baru
            $validated['documentation'] = $request->file('documentation')->store('images', 'public');
        } else {
            // Pertahankan file dokumentasi lama jika tidak ada file baru
            $validated['documentation'] = $todo->documentation;
        }

        // Update data Todo
        $todo->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'completed' => $request->completed,
            'documentation' => $validated['documentation'],
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('todo.index')->with('success', 'Todo berhasil diperbarui.');
    }

    // Menghapus Todo
    public function destroy(Todo $todo)
    {
        // Hapus file dokumentasi jika ada
        if ($todo->documentation) {
            \Storage::disk('public')->delete($todo->documentation);
        }

        // Hapus data Todo
        $todo->delete();

        return redirect()->route('todo.index')->with('success', 'Todo berhasil dihapus.');
    }

    public function search($search)
    {
        // Filter berdasarkan title atau description
        return Todo::query()
            ->where('title', 'like', "%{$search}%")
            ->orWhere('description', 'like', "%{$search}%")
            ->latest()
            ->paginate(3); // Pagination hasil pencarian
    }
}
