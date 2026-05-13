<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function index(Request $request)
    {
        $query = Agenda::with('creator');

        if ($request->filled('search')) {
            $query->where('judul', 'like', "%{$request->search}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $agendas = $query->orderBy('tanggal_mulai', 'desc')->paginate(10)->withQueryString();
        $upcomingAgendas = Agenda::upcoming()->limit(3)->get();

        return view('agenda.index', compact('agendas', 'upcomingAgendas'));
    }

    public function create()
    {
        return view('agenda.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'           => 'required|string|max:255',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'lokasi'          => 'nullable|string|max:255',
            'penanggung_jawab'=> 'nullable|string|max:100',
            'deskripsi'       => 'nullable|string',
        ]);

        $agenda = Agenda::create(array_merge(
            $request->only(['judul', 'deskripsi', 'tanggal_mulai', 'tanggal_selesai', 'lokasi', 'penanggung_jawab']),
            ['created_by' => auth()->id(), 'status' => 'upcoming', 'warna' => $request->warna ?? '#002147']
        ));

        LogAktivitas::log('create_agenda', "Buat agenda: {$agenda->judul}", $agenda->id, 'Agenda');

        return redirect()->route('agenda.index')->with('success', 'Agenda berhasil ditambahkan!');
    }

    public function show($id)
    {
        $agenda = Agenda::with('creator')->findOrFail($id);
        return view('agenda.show', compact('agenda'));
    }

    public function edit($id)
    {
        $agenda = Agenda::findOrFail($id);
        return view('agenda.edit', compact('agenda'));
    }

    public function update(Request $request, $id)
    {
        $agenda = Agenda::findOrFail($id);

        $request->validate([
            'judul'         => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'status'        => 'required|in:upcoming,ongoing,completed,cancelled',
        ]);

        $agenda->update($request->only(['judul', 'deskripsi', 'tanggal_mulai', 'tanggal_selesai', 'lokasi', 'penanggung_jawab', 'status', 'warna']));

        LogAktivitas::log('update_agenda', "Edit agenda: {$agenda->judul}", $agenda->id, 'Agenda');

        return redirect()->route('agenda.index')->with('success', 'Agenda berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $agenda = Agenda::findOrFail($id);
        LogAktivitas::log('delete_agenda', "Hapus agenda: {$agenda->judul}", $agenda->id, 'Agenda');
        $agenda->delete();

        return back()->with('success', 'Agenda berhasil dihapus!');
    }
}
