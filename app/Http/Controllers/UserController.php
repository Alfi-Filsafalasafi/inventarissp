<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use File;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $users = User::all();
        return view('user.index', ['users' => $users]);
    }
    public function create()
    {
        return view('user.tambah');
    }
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nama' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:3',
            'foto' => 'required|mimes:jpeg,jpg,png|max:1000',
        ]);
        
        $extFile = $request->nama;
        $extensi = $request->foto->getClientOriginalExtension();
        $namaFile = $extFile."-".time().".".$extensi;
        $path = $request->foto->move('image/user',$namaFile);

        $user = new User();
        $user->name = $validateData['nama'];
        $user->email = $validateData['email'];
        $user->password = Hash::make($validateData['password']);
        $user->foto = $namaFile;
        $user->level = $request->level;
        $user->save();

        return redirect()->route('user.index')
                ->with('tambah',"penambahan data {$validateData['nama']} berhasil");
    }

    public function destroy(User $user){
        //hapus file 
        $gambar = User::where('id',$user->id)->first();
        File::delete('image/user/'.$gambar->foto);
        $user->delete();
        return redirect()->route('user.index')->with('hapus',"hapus data $user->name berhasil");

    }

    public function edit(User $user){
        return view('user.edit',['user' => $user]);
    }

    public function update(Request $request, User $user)
    {

        if($request->password == "" && $request->foto == ""){
            $validateData = $request->validate([
                'nama' => 'required|min:3',
                'email' => 'required|email|unique:users,email,'.$user->id,
            ]);
            $user = User::find($user->id); 
            $user->name = $validateData['nama'];
            $user->email = $validateData['email'];
            $user->level = $request->level;
            $user->save();
        }else if($request->password == ""){
            
            $validateData = $request->validate([
                'nama' => 'required|min:3',
                'email' => 'required|email|unique:users,email,'.$user->id,
            'foto' => 'required|mimes:jpeg,jpg,png|max:1000',
            ]);

            $gambar = User::where('id',$user->id)->first();
        File::delete('image/user/'.$gambar->foto);

            $extFile = $request->nama;
            $extensi = $request->foto->getClientOriginalExtension();
            $namaFile = $extFile."-".time().".".$extensi;
            $path = $request->foto->move('image/user',$namaFile);

            $user = User::find($user->id); 
            $user->name = $validateData['nama'];
            $user->email = $validateData['email'];
            $user->level = $request->level;
            $user->foto = $namaFile;
            $user->save();
        } else if($request->foto == ""){
            $validateData = $request->validate([
                'nama' => 'required|min:3',
                'email' => 'required|email|unique:users,email,'.$user->id,
                'password' => 'min:3',
            ]);


            $user = User::find($user->id); 
            $user->name = $validateData['nama'];
            $user->email = $validateData['email'];
            $user->level = $request->level;
            $user->password = Hash::make($validateData['password']);
            $user->save();
        } else {
            $validateData = $request->validate([
                'nama' => 'required|min:3',
                'email' => 'required|email|unique:users,email,'.$user->id,
                'foto' => 'required|mimes:jpeg,jpg,png|max:1000',
                'password' => 'min:3',
            ]);

            $gambar = User::where('id',$user->id)->first();
            File::delete('image/user/'.$gambar->foto);

            $extFile = $request->nama;
            $extensi = $request->foto->getClientOriginalExtension();
            $namaFile = $extFile."-".time().".".$extensi;
            $path = $request->foto->move('image/user',$namaFile);

            $user = User::find($user->id); 
            $user->name = $validateData['nama'];
            $user->email = $validateData['email'];
            $user->level = $request->level;
            $user->foto = $namaFile;
            $user->password = Hash::make($validateData['password']);
            $user->save();
        }
        return redirect()->route('user.index')
                ->with('ubah',"perubahan data {$validateData['nama']} berhasil");
    }

    public function passedit(){
        return view ('gantipass.edit');
    }

    public function passupdate(Request $request)
    {
        $validateData = $request->validate([
            'password' => 'required|min:3',
        ]);
        $user = User::find($request->id); 
            $user->password = Hash::make($validateData['password']);
            $user->save();
    
        return redirect()->route('pass.edit')->with('tambah',"Ganti Password berhasil");
    }
    
}
