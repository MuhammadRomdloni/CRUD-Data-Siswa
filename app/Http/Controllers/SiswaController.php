<?php

namespace App\Http\Controllers;

use App\Models\siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
     /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $siswas = Siswa::latest()->paginate(10);
        return view('siswa.index', compact('siswas'));
    }

/**
* create
*
* @return void
*/
public function create()
{
    return view('siswa.create');
}


/**
* store
*
* @param  mixed $request
* @return void
*/
public function store(Request $request)
{
    $this->validate($request, [
        'nis'     => 'required',
        'name'     => 'required',
        'born'     => 'required',
        'date'   => 'required',
        'alamat'   => 'required',
        'kelas'   => 'required'
    ]);

    $siswa = Siswa::create([
        'nis'     => $request->nis,
        'name'     => $request->name,
        'born'     => $request->born,
        'date'   => $request->date,
        'alamat'     => $request->alamat,
        'kelas'     => $request->kelas
    ]);

    if($siswa){
        //redirect dengan pesan sukses
        return redirect()->route('siswa.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }else{
        //redirect dengan pesan error
        return redirect()->route('siswa.index')->with(['error' => 'Data Gagal Disimpan!']);
    }
}

/**
* edit
*
* @param  mixed $siswa
* @return void
*/
public function edit(Siswa $siswa)
{
    return view('siswa.edit', compact('siswa'));
}


/**
* update
*
* @param  mixed $request
* @param  mixed $siswa
* @return void
*/
public function update(Request $request, Siswa $siswa)
{
    $this->validate($request, [
        'nis'     => 'required',
        'name'     => 'required',
        'born'     => 'required',
        'date'   => 'required',
        'alamat'   => 'required',
        'kelas'   => 'required'
    ]);

    //get data Siswa by ID
    $siswa = Siswa::findOrFail($siswa->id);

    if($request->name) {

        $siswa->update([
        'nis'     => $request->nis,
        'name'     => $request->name,
        'born'     => $request->born,
        'date'   => $request->date,
        'alamat'     => $request->alamat,
        'kelas'     => $request->kelas
        ]);

    } else {

        $siswa->update([
        'nis'     => $request->nis,
        'name'     => $request->name,
        'born'     => $request->born,
        'date'     => $request->date,
        'alamat'    => $request->alamat,
        'kelas'     => $request->kelas
        
        ]);

    }

    if($siswa){
        //redirect dengan pesan sukses
        return redirect()->route('siswa.index')->with(['success' => 'Data Berhasil Diupdate!']);
    }else{
        //redirect dengan pesan error
        return redirect()->route('siswa.index')->with(['error' => 'Data Gagal Diupdate!']);
    }
}

/**
* destroy
*
* @param  mixed $id
* @return void
*/
public function destroy($id)
{
  $siswa = Siswa::findOrFail($id);
  Storage::disk('local')->delete(' / /'.$siswa->name);
  $siswa->delete();

  if($siswa){
     //redirect dengan pesan sukses
     return redirect()->route('siswa.index')->with(['success' => 'Data Berhasil Dihapus!']);
  }else{
    //redirect dengan pesan error
    return redirect()->route('siswa.index')->with(['error' => 'Data Gagal Dihapus!']);
  }
}
}
