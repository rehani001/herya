<?php

namespace App\Http\Controllers;
use App\Models\Catalogue;
use Illuminate\Http\Request;

class CatalogueController extends Controller
{

    public function index()
    {
        $catalogues = Catalogue::paginate(10);
        return view('admin.catalogue-list',compact('catalogues'));
    }

    public function create()
    {
        return view('admin.add-catalogue');
    }

    public function store(Request $request)
    {
        $katalog = new Catalogue;
        $img = '';
        if ($request->hasFile('img')) {
            $gambar = $request->file('img');
            $nama = $gambar->getClientOriginalName();
            $gambar->move(public_path().'/img/',$nama);
            $img = '/img/'.$nama;
        }
        $katalog->img = $img;
        $katalog->nama_katalog = $request->nama_katalog;
        $katalog->harga = $request->harga;
        $katalog->desc = $request->desc;
        $katalog->save();

        return redirect('/catalogue-list')->with('sukses','Katalog berhasil ditambahkan');
    }
   
    public function show($id)
    {
        $cek = Catalogue::find($id);
        return view('detail', compact('cek'));
    }

    public function edit($id)
    {
        $catalogue = Catalogue::find($id);
        return view('admin.edit-catalogue',compact('catalogue'));
    }
  
    public function update(Request $request, $id)
    {
        $catalogue = Catalogue::find($id);
        $catalogue->update($request->all());

        return redirect('catalogue-list')->with('edit','Data berhasil diubah');
    }

     public function destroy($id)
    {
        $catalogues = Catalogue::find($id);
        $catalogues->delete();
        return redirect('/catalogue-list')->with('hapus','Data Berhasil Dihapus');
    }
}
