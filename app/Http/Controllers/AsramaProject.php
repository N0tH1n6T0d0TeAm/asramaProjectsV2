<?php

namespace App\Http\Controllers;

use App\Models\Angkatan;
use App\Models\isi_workspace;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use App\Models\LaporanPost;
use App\Models\ModelRole;
use App\Models\Roles;
use App\Models\Siswa;
use App\Models\Laporan_Perkembangan;
use App\Models\KategoriMasalah;
use App\Models\ModelHasRoles;
use App\Models\Workspace;
use App\Models\Password;
use App\Models\Confidensial;
use App\Models\User;
use Dompdf\Dompdf;
use Illuminate\Database\Eloquent\Model;
use Image;
use IsiWorkspace;
use Kategori;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Dompdf as PdfDompdf;

class AsramaProject extends Controller
{

    public function tambah_laporan(Request $req)
    {
        $foto = array();
        foreach ($req->file('gambar') as $file) {
            $nama = $file->getClientOriginalName();

            $image =  Image::make($file);
            $image->save(public_path('postingan/' . $file->getClientOriginalName()), 50);
            $foto[] = $nama;
        }

    // public function tambah_laporan(Request $req)
    // {
    //     $foto = array();
    //     foreach ($req->file('gambar') as $file) {
    //         $nama = $file->getClientOriginalName();

    //         $image =  Image::make($file);
    //         $image->save(base_path('../postingan/' . $file->getClientOriginalName()), 50);
    //         $foto[] = $nama;
    //     }

        $tabel = new LaporanPost();
        $tabel->gambar = implode('|', $foto);
        $tabel->id_roles = $req->id_roles;
        $tabel->id_pengguna = $req->id_pengguna;
        $tabel->deskripsi = NULL;
        $tabel->nama_siswass = NULL;
        $tabel->save();


        return redirect()->route("asrama.laporanharian", ["id_saja" => $tabel->id_laporan]);
    }


    public function lihat_post($id)
    {
        $tabel = LaporanPost::find($id);
        $murid = Siswa::where('jenis_kelamin','L')->get();
        return view('laporan_asrama.postingan', ["data" => $tabel, "murid" => $murid]);
    }

    public function kembali_home($id)
    {
        $tabel = LaporanPost::find($id);

        $gambar = $tabel->gambar;

        $gambarArray = explode("|", $gambar);

        $folder = public_path('/postingan/');

        foreach ($gambarArray as $files) {
            if (file_exists($folder . $files)) {
                unlink($folder . $files);
            };
        };

        $tabel->delete();

        return redirect('/laporan_harian');
    }

    public function tambah_siswa(Request $req)
    {
        $ids = $req->idnya;
        $tabel = LaporanPost::find($ids);
        $tabel->deskripsi = $req->deskripsi;
        $tabel->nama_siswass = $req->tags;
        $tabel->update();
        return redirect('laporan_harian');
    }

    public function tampil_laporan_harian()
    {
        $tabel = LaporanPost::orderBy('id_laporan','asc')->paginate(5);
        $tabel2 = ModelRole::where('model_id', auth()->user()->id)->get();
        $table3 = ModelHasRoles::with('user')->where('role_id', '6')->orWhere('role_id', '9')->get();
        $table5 = ModelHasRoles::with('user')->where('role_id', '6')->orWhere('role_id', '9')->get();
        $table6 = Siswa::where('jenis_kelamin','L')->get();
        return view('laporan_asrama.laporan_harian', ["datas" => $tabel, "datas2" => $tabel2,'data3'=>$table3,'data5'=>$table5]);
    }
 //
    public function edit_post($id)
    {
        $tabel = LaporanPost::find($id);
        return response()->json([
            'status' => 200,
            'tampil' => $tabel,
        ]);
    }

    public function detail_siswa()
    {
        $tabel = Siswa::where('jenis_kelamin','L')->Where('status','aktif')->paginate(3);
        $tabel2 = Jurusan::all();
        $tabel3 = Angkatan::all();
        $table5 = ModelHasRoles::with('user')->where('role_id', '6')->orWhere('role_id', '9')->get();
        return view('laporan_asrama.laporan_perkembangan', ['data' => $tabel, 'data2' => $tabel2,'data3' => $tabel3,'data5' => $table5]);
    }

    public function cari_siswa(Request $req)
    {


        $siswa = new Siswa();

        $tabel2 = Jurusan::all();

        $tabel3 = Angkatan::all();

        if ($req->filled("nama")) {
            $siswa = $siswa->where("nama_siswa", "LIKE", "%" . $req->nama . "%")->where('jenis_kelamin', 'L')->Where('status', 'aktif');
        }else{
            $siswa = $siswa->where("nama_siswa", "LIKE", "%" . $req->nama . "%")->where('jenis_kelamin', 'L')->Where('status', 'aktif');
        }

        if ($req->filled("angkatan")) {
            $siswa = $siswa->where("id_angkatan", $req->angkatan)->where('jenis_kelamin', 'L')->Where('status', 'aktif');
        }else{
            $siswa = $siswa->where("nama_siswa", "LIKE", "%" . $req->nama . "%")->where('jenis_kelamin', 'L')->Where('status', 'aktif');
        }

        if ($req->filled("jurusan")) {
            $siswa = $siswa->where("id_jurusan", $req->jurusan)->where('jenis_kelamin', 'L')->Where('status', 'aktif');
        }else{
            $siswa = $siswa->where("nama_siswa", "LIKE", "%" . $req->nama . "%")->where('jenis_kelamin', 'L')->Where('status', 'aktif');
        }
        $table5 = ModelHasRoles::with('user')->where('role_id', '6')->orWhere('role_id', '9')->get();

        // dd($siswa->get());
        return view("laporan_asrama.siswa_perkembangan", ["data" => $siswa->get(), 'data2' => $tabel2, 'data3' => $tabel3,'data5' => $table5]);
    }

    public function detail_perkembangan($nis){
        $tabel = Siswa::find($nis);
        $tabel2 = Laporan_Perkembangan::where("nis_siswas",$nis)->get();
        $tabel3 = Password::all();
        $table5 = ModelHasRoles::with('user')->where('role_id', '6')->orWhere('role_id', '9')->get();
        return view('laporan_asrama.detail_laporan',["data" => $tabel,"data2"=>$tabel2,"data3" => $tabel3,'data5' => $table5]);
    }

    public function rentang_tanggal(Request $req, $nis)
    {
        $dari = $req->dari;
        $sampai = $req->sampai;

        $tabel = Siswa::find($nis);
        if ($req->has('dari')) {
            $tabel2 = Laporan_Perkembangan::with('kategori')->where("nis_siswas", $nis)->WhereBetween('tanggal', [$dari, $sampai])
                ->orWhereBetween('tanggal', [$sampai, $dari])
                ->orWhere('tanggal', $dari)
                ->orWhere('tanggal', $sampai)
                ->get();
        } else {
            $tabel2 = Laporan_Perkembangan::where("nis_siswas", $nis)->get();
        }
        $html = view('laporan_asrama.laporan-pdf', ["data" => $tabel, "data2" => $tabel2])->render();

        $pdf = new Dompdf();
        $pdf->loadHtml($html);
        $pdf->render();

        return $pdf->stream('laporan.pdf');
    }

    public function tambah_perkembangan(Request $req){
        $tabel = new Laporan_Perkembangan();
        $tabel->judul_buku = $req->judul;
        $tabel->id_pengguna = $req->id_pengguna;
        $tabel->nis_siswas = $req->nis_siswa;
        $tabel->level_kategori = "Tidak Ada Kategori";
        $tabel->tanggal = $req->tanggal;
        $tabel->save();
        return back();
    }

    public function catatan_perkembangan($id){
        $tabel = Laporan_Perkembangan::find($id);
         $table5 = ModelHasRoles::with('user')->where('role_id', '6')->orWhere('role_id', '9')->get();
        return view('laporan_asrama.catatan_perkembangan', ["data" => $tabel,'data5' => $table5]);
    }
    

    public function tambah_kategori(Request $req){
        $tabel = new KategoriMasalah;
        $tabel->level_kategori = $req->level_kategori;
        $tabel->save();
        return back();
    }

    public function edit_catatan($id){
        $tabel = Laporan_Perkembangan::find($id);
        $tabel2 = KategoriMasalah::all();
        $tabel3 = ModelHasRoles::with('user')->where('role_id','6')->orWhere('role_id', '9')->get();
        $table5 = ModelHasRoles::with('user')->where('role_id', '6')->orWhere('role_id', '9')->get();
        return view('laporan_asrama.edit_catatan', ["data" => $tabel,"data2" => $tabel2,"data3" => $tabel3,'data5' => $table5]);
    }

    public function beranda(){
        $table5 = ModelHasRoles::with('user')->where('role_id', '6')->orWhere('role_id', '9')->get();
         return view('beranda.index', ['data5' => $table5]);
    }

    public function tambah_confidensial(Request $req){
        
        $id_perkembangan = $req->id_perkembangan;
        
        $tabel = Laporan_Perkembangan::find($id_perkembangan);
        $tabel->level_kategori = "Confidensial";
        $tabel->update();
        
        foreach ($req->nama_pamong as $key => $value) {
            $tabel2 = new Confidensial();
            $tabel2->id_perkembangan = $id_perkembangan;
            $tabel2->nama_pamong = $req->nama_pamong[$key];
            $tabel2->save();
        }
        return back();
    }

    public function beri_catatan(Request $req){
        if($req->level_kategori == "Umum"){
            $ids = $req->ids;
            $tabel = Laporan_Perkembangan::find($ids);
            $tabel->judul_buku = $req->judul_buku;
            $tabel->level_kategori = $req->level_kategori;
            $tabel->isi_buku = $req->isi_buku;
            $tabel->update();
        }else{
            $ids = $req->ids;
            $tabel = Laporan_Perkembangan::find($ids);
            $tabel->judul_buku = $req->judul_buku;
            $tabel->isi_buku = $req->isi_buku;
            $tabel->update();
        }
        
        return back();
    }

    // public function update_kategori($ids,$lol2){
    //     $tabel = KategoriMasalah::find($ids);
    //     $tabel->nama_kategori = $lol2;
    //     $tabel->update();
    //     return 'success';
    // }

    public function hapus_kategori($id_hapus)
    {
        $tabel = KategoriMasalah::find($id_hapus);
        $tabel->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Data Berhasil Di Hapus',
        ]);
    }

    public function hapus_info($id){
        $tabel = Laporan_Perkembangan::find($id);
        $tabel->delete();
        return back();
    }

    public function update_status($ids,$status_siswa){
        $tabel = Siswa::find($ids);
        $tabel->status = $status_siswa;
        $tabel->update();
        return back();   
    }

    public function update_alumni($id_alumni)
    {
        $tabel = Siswa::find($id_alumni);
        $tabel->status = "alumni";
        $tabel->update();
        return back();
    }

    public function status_siswa(){
        $tabel = Siswa::where('status','tidak aktif')->get();
        $tabel2 = Siswa::where('status','alumni')->get();
        $table5 = ModelHasRoles::with('user')->where('role_id', '6')->orWhere('role_id', '9')->get();
        return view('laporan_asrama.status_siswa', ["data" => $tabel,'data2' => $tabel2,'data5' => $table5]);
    }

    public function status_aktif($ids){
        $tabel = Siswa::find($ids);
        $tabel->status = "aktif";
        $tabel->update();
        return back();
    }

    public function profil_postingan($id){
        $tabel = User::find($id);
        $tabel2 = LaporanPost::where('id_pengguna',$id)->get();
        $tabel3 = LaporanPost::where('id_pengguna',$id)->count();
        $table5 = ModelHasRoles::with('user')->where('role_id', '6')->orWhere('role_id', '9')->get();
        return view('laporan_asrama.profil_postingan',['data' => $tabel,'data2' => $tabel2,'hitung'=>$tabel3,'data5' => $table5]);
    }

    public function workspace(){
        $tabel = ModelHasRoles::where('role_id','6')->get();
        $tabel2 = Workspace::all();
        $table5 = ModelHasRoles::with('user')->where('role_id', '6')->orWhere('role_id', '9')->get();
        return view('laporan_asrama.workspace',['data' => $tabel,'data2' => $tabel2,'data5' => $table5]);
    }

    public function tambah_tugas(Request $req){
        $tabel = new Workspace;
        $tabel->id_pamong = $req->id_pamong;
        $tabel->tugas = $req->judul_tugas;
        $tabel->tanggal = $req->tanggal;
        $tabel->save();
        
        foreach($req->isi_tugas as $key => $value){
            $tabel2 = new isi_workspace();
            $tabel2->id_workspace = $tabel->id_workspace;
            $tabel2->isi_tugas = $req->isi_tugas[$key];
            $tabel2->status = "Belum Dikerjakan";
            $tabel2->cek = "0";
            $tabel2->deskripsi = NULL;
            $tabel2->save();
        }
        
            
        return back();
    }


    public function lihat_tugas_pamong(){
        $tabel = Workspace::where("id_pamong", auth()->user()->id)->get();
        $tabel2 = isi_workspace::where('cek','0')->count();
        $table5 = ModelHasRoles::with('user')->where('role_id', '6')->orWhere('role_id', '9')->get();
        return view('laporan_asrama.dashboard_pamong',['data' => $tabel,'hitung'=>$tabel2,'data5'=>$table5]);
    }

    public function udah_selesai($id){
        $tabel = isi_workspace::find($id);
        $tabel->cek = 1;
        $tabel->update();
        return back();
    }

    public function kembalikan_tugas($id){
        $tabel = Workspace::find($id);
        $tabel->status = "belum dikerjakan";
        $tabel->update();
        return back();
    }

    public function hapus_tugas($id)
    {
        $tabel = isi_workspace::find($id);
        $tabel->workspace->delete();
        $tabel->delete();
        return back();
    }

    public function update_detail_tugas($id_asli,$ids,$inputs){
         isi_workspace::where('id_bagian', $ids)
            ->where('id_workspace', $id_asli)
            ->update(['status' => $inputs]);
            
        return back();
    }

    public function update_deskripsi($ids, $lol2){
        isi_workspace::where('id_bagian',$ids)->update(['deskripsi' => $lol2]);
        return 'success';
    }

    public function update_status_deskripsi($id_desk,$isi_desk){
        isi_workspace::where('id_bagian',$id_desk)->update(['status' => 'Pending','deskripsi' => $isi_desk]);
        return back();
    }

    public function update_status_dibatalkan($ids){
        isi_workspace::where('id_bagian',$ids)->update(['status' => 'Tugas Dibatalkan','cek' => '0']);
        return back();
    }

    public function update_status_belum_dikerjakan($ids,$inputs,$id_workspace)
    {
        isi_workspace::where('id_workspace', $id_workspace)->update(['cek' => '0']); 
        isi_workspace::where('id_bagian', $ids)->update(['status' => $inputs]);
        return back();
    }

    public function setting_profile($id){
        $tabel = User::find($id);
        $table5 = ModelHasRoles::with('user')->where('role_id', '6')->orWhere('role_id', '9')->get();
        return view('laporan_asrama.setting_profile',['data'=>$tabel,'data5' => $table5]);
    }

    public function update_profile(Request $req){
        $ids = $req->ids;
        $tabel = User::find($ids);
        $tabel->name = $req->nama;
        $tabel->active = $req->bio;
        $tabel->update();
        return back();
    }

    public function master(){
        $table5 = ModelHasRoles::with('user')->where('role_id', '6')->orWhere('role_id', '9')->get();
        return view('layouts.master',['data5' => $table5]);
    }

    public function update_post($ids,$inputs){
        $tabel = LaporanPost::find($ids);
        $tabel->deskripsi = $inputs;
        $tabel->update();
        return back();
    }


    public function ganti_posisi(){
        $table5 = ModelHasRoles::with('user')->where('role_id', '6')->orWhere('role_id', '9')->get();
        return view('laporan_asrama.ganti_posisi',['data5' => $table5]);
    } 

    public function ubah_posisi($ids){
        ModelHasRoles::where('model_id',$ids)->update(['role_id' => '9']);
        return back();    
    }

    public function turunkan($ids)
    {
        ModelHasRoles::where('model_id', $ids)->update(['role_id' => '6']);
        return back();
    }

    public function piket(){
        $table5 = ModelHasRoles::with('user')->where('role_id', '6')->orWhere('role_id', '9')->get();
        return view('laporan_asrama.piket', ['data5' => $table5]);
    }

    public function setting_akun($id){
        $tabels = User::find($id);
        $table5 = ModelHasRoles::with('user')->where('role_id', '6')->orWhere('role_id', '9')->get();
        return view('laporan_asrama.setting_akun', ['data'=>$tabels,'data5' => $table5]);
    }

    public function update_email($ids, $lol2){
        $tabels = User::find($ids);
        $tabels->email = $lol2;
        $tabels->update();
        return 'success';
    }

    public function update_password($id_pass, $pass)
    {
        $tabels = User::find($id_pass);
        $tabels->password = bcrypt($pass);
        $tabels->update();
        return 'success';
    }

   

    public function tambah_daftar_siswa(){
        $table5 = ModelHasRoles::with('user')->where('role_id', '6')->orWhere('role_id', '9')->get();
        $tabels = Jurusan::all();
        $tabels2 = Angkatan::all();
        return view('laporan_asrama.tambah_daftar_siswa',['data5'=>$table5,'jurusan' => $tabels,'angkatan' => $tabels2]);       
    }

    // public function tambah_profil_siswa($nis,$nisn,$nama_siswa,$tempat_lahir,$jurusan,$angkatan,$agama,$no_absen,$tanggal_lahir,$fileName){
    //     $tabel = new Siswa;
    //     $tabel->nis = $nis;
    //     $tabel->password = NULL;
    //     $tabel->nisn = $nisn;
    //     $tabel->nama_siswa = $nama_siswa;
    //     $tabel->tempat_lahir = $tempat_lahir;
    //     $tabel->id_jurusan = $jurusan;
    //     $tabel->id_angkatan = $angkatan;
    //     $tabel->agama = $agama;
    //     $tabel->no_absen = $no_absen;
    //     $tabel->tanggal_lahir = $tanggal_lahir;
    //     $tabel->jenis_kelamin = "L";
    //     $foto = $fileName;
    //     $tabel->status = "aktif";
    //     $tabel->save();
    //     return 'success';
    // }

    

    public function tambah_profil_siswa(Request $req){
        
       
        $files = [];
        if($req->hasfile('foto_profil')){
            foreach($req->file('foto_profil') as $file){
                $name = time().rand(1,100).'.'.$file->extension();
                $file->move(public_path('siswa'),$name);
                $files[] = $name;
            }
        }

        foreach($req->nis as $key => $val){
           
            $tabel = new Siswa;
            $tabel->nis = $req->nis[$key];
            $tabel->password = NULL;
            $tabel->nisn = $req->nisn[$key];
            $tabel->nama_siswa = $req->nama_siswa[$key];
            $tabel->id_jurusan = $req->jurusan[$key];
            $tabel->id_angkatan = $req->angkatan[$key];
            $tabel->agama = $req->agama[$key];
            $tabel->no_absen = $req->no_absen[$key];
            $tabel->foto_profil = $name;
            $tabel->tanggal_lahir = $req->tanggal_lahir[$key];
            $tabel->tempat_lahir = $req->tempat_lahir[$key];
            $tabel->jenis_kelamin = "L";
            $tabel->status = "aktif";
            $tabel->save();
        }
       
        return back();
    }

    public function hapus_siswa($nis){
        $siswa = Siswa::find($nis);
        $siswa->delete();
        return redirect()->route('laporan_perkembangan');        
    }
}