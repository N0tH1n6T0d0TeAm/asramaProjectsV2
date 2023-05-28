<?php

use App\Events\BuatPesan;
use App\Http\Controllers\Admin\KonfigurasiPenggunaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAppController;
use App\Http\Controllers\Konseling\JadwalKonselingController;
use App\Http\Controllers\AsramaProject;
use App\Http\Controllers\General\GeneralController;
use App\Http\Controllers\RaportKarakter\RaportKarakterController;
use App\Http\Controllers\redirectRole;
use Spatie\Permission\Middlewares\RoleMiddleware;

/*
                                        ,   ,                                
                                        $,  $,     ,                         
                                        "ss.$ss. .s'                         
                                ,     .ss$$$$$$$$$$s,                        
                                $. s$$$$$$$$$$$$$$`$$Ss                      
                                "$$$$$$$$$$$$$$$$$$o$$$       ,              
                               s$$$$$$$$$$$$$$$$$$$$$$$$s,  ,s               
                              s$$$$$$$$$"$$$$$$""""$$$$$$"$$$$$,             
                              s$$$$$$$$$$s""$$$$ssssss"$$$$$$$$"             
                             s$$$$$$$$$$'         `"""ss"$"$s""              
                             s$$$$$$$$$$,              `"""""$  .s$$s        
                             s$$$$$$$$$$$$s,...               `s$$'  `       
                         `ssss$$$$$$$$$$$$$$$$$$$$####s.     .$$"$.   , s-   
                           `""""$$$$$$$$$$$$$$$$$$$$#####$$$$$$"     $.$'    
 Posable artist:                 "$$$$$$$$$$$$$$$$$$$$$####s""     .$$$|     
   -Michael Patrick Effendy       "$$$$$$$$$$$$$$$$$$$$$$$$##s    .$$" $    
                                   $$""$$$$$$$$$$$$$$$$$$$$$$$$$$$$$"   `    
                                  $$"  "$"$$$$$$$$$$$$$$$$$$$$S""""'         
                             ,   ,"     '  $$$$$$$$$$$$$$$$####s             
                             $.          .s$$$$$$$$$$$$$$$$$####"            
                 ,           "$s.   ..ssS$$$$$$$$$$$$$$$$$$$####"            
                 $           .$$$S$$$$$$$$$$$$$$$$$$$$$$$$#####"             
                 Ss     ..sS$$$$$$$$$$$$$$$$$$$$$$$$$$$######""              
                  "$$sS$$$$$$$$$$$$$$$$$$$$$$$$$$$########"                  
           ,      s$$$$$$$$$$$$$$$$$$$$$$$$#########""'                      
           $    s$$$$$$$$$$$$$$$$$$$$$#######""'      s'         ,           
           $$..$$$$$$$$$$$$$$$$$$######"'       ....,$$....    ,$            
            "$$$$$$$$$$$$$$$######"' ,     .sS$$$$$$$$$$$$$$$$s$$            
              $$$$$$$$$$$$#####"     $, .s$$$$$$$$$$$$$$$$$$$$$$$$s.         
   )          $$$$$$$$$$$#####'      `$$$$$$$$$###########$$$$$$$$$$$.       
  ((          $$$$$$$$$$$#####       $$$$$$$$###"       "####$$$$$$$$$$      
  ) \         $$$$$$$$$$$$####.     $$$$$$###"             "###$$$$$$$$$   s'
 (   )        $$$$$$$$$$$$$####.   $$$$$###"                ####$$$$$$$$s$$' 
 )  ( (       $$"$$$$$$$$$$$#####.$$$$$###'                .###$$$$$$$$$$"   
 (  )  )   _,$"   $$$$$$$$$$$$######.$$##'                .###$$$$$$$$$$     
 ) (  ( \.         "$$$$$$$$$$$$$#######,,,.          ..####$$$$$$$$$$$"     
(   )$ )  )        ,$$$$$$$$$$$$$$$$$$####################$$$$$$$$$$$"       
(   ($$  ( \     _sS"  `"$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$S$$,       
 )  )$$$s ) )  .      .   `$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$"'  `$$      
  (   $$$Ss/  .$,    .$,,s$$$$$$##S$$$$$$$$$$$$$$$$$$$$$$$$S""        '      
    \)_$$$$$$$$$$$$$$$$$$$$$$$##"  $$        `$$.        `$$.                
        `"S$$$$$$$$$$$$$$$$$#"      $          `$          `$                
            `"""""""""""""'         '           '           '

*/

Route::get('/', function () {
    return redirect('login');
})->name("welcome");

Route::controller(RaportKarakterController::class)->middleware('auth')->group(function () {
    Route::get('/raportkarakter', 'index')->name('eraport.raportkarakter');
    Route::get('/generateraportkarakter', 'generateeraportkarakter')->name("eraport.generateraportkarakter");
    Route::get('/downloadraportkarakter', 'downloadraportkarakter')->name("eraport.downloadraportkarakter");

    Route::get('/getpenilailist', [RaportKarakterController::class, 'getpenilailist'])->name('eraport.getpenilailist');
});


Route::group(["middleware" => "auth"], function () {

    Route::get('redirect',[redirectRole::class,'index']);
    
    Route::view('laporan_harian', 'laporan_asrama.laporan_harian');


    Route::get('getnotif', [GeneralController::class, 'getnotif'])->name('general.getnotif');

    Route::get('laporan_harian', [AsramaProject::class, 'tampil_laporan_harian'])->name('laporan_harian');

    Route::get('edit_post/{id}', [AsramaProject::class, 'edit_post']);


    Route::get('kembali/{id}', [AsramaProject::class, 'kembali_home']);

    Route::get('postingan/{id_saja}', [AsramaProject::class, 'lihat_post'])->name("asrama.laporanharian");

    Route::post('tambah_laporan', [AsramaProject::class, 'tambah_laporan'])->name('tambah_laporan');

    Route::put('tambah_siswa', [AsramaProject::class, 'tambah_siswa']);

    Route::view('postingan', 'laporan_asrama.postingan');

    


    Route::view('laporan_perkembangan', 'laporan_asrama.laporan_perkembangan');

    Route::get('laporan_perkembangan', [AsramaProject::class, 'detail_siswa'])->name('laporan_perkembangan');

    Route::get('siswa_perkembangan', [AsramaProject::class, 'cari_siswa'])->name('siswa_perkembangan');

    Route::view('detail_perkembangan', 'laporan_asrama.detail_laporan');

    Route::get('detail_perkembangan/{nis}', [AsramaProject::class, 'detail_perkembangan']);
    
    Route::get('rentang_tanggal/{nis}', [AsramaProject::class, 'rentang_tanggal']);

    Route::post('tambah_perkembangan', [AsramaProject::class, 'tambah_perkembangan']);

    Route::view('catatan_perkembangan', 'laporan_asrama.catatan_perkembangan');

    Route::get('catatan_perkembangan/{id}', [AsramaProject::class, 'catatan_perkembangan']);

    Route::view('edit_catatan', 'laporan_asrama.edit_catatan');

    Route::get('edit_catatan/{id}', [AsramaProject::class, 'edit_catatan']);

    Route::get('/update_kategori/{ids}/{lol2}', [AsramaProject::class, 'update_kategori']);

    Route::delete('hapus_kategori/{id_hapus}', [AsramaProject::class, 'hapus_kategori']);

    Route::get('hapus_info/{id}', [AsramaProject::class, 'hapus_info']);

    Route::get('update_status/{ids}/{status_siswa}/', [AsramaProject::class, 'update_status']);

    Route::get('update_status_alumni/{id_alumni}', [AsramaProject::class, 'update_alumni']);

    Route::put('beri_catatan', [AsramaProject::class, 'beri_catatan']);

    Route::post('tambah_kategori', [AsramaProject::class, 'tambah_kategori']);


    Route::view('status_siswa', 'laporan_asrama.status_siswa');

    Route::get('status_siswa', [AsramaProject::class, 'status_siswa'])->name('status_siswa');

    Route::get('status_aktif/{ids}', [AsramaProject::class, 'status_aktif']);

    Route::view('profil_postingan', 'laporan_asrama.profil_postingan');

    Route::get('profil_postingan/{id}',[AsramaProject::class,'profil_postingan']);

    Route::view('workspace', 'laporan_asrama.workspace');

    Route::get('workspace', [AsramaProject::class, 'workspace'])->name('workspace');

    Route::post('tambah_tugas', [AsramaProject::class, 'tambah_tugas']);

    Route::view('dashboard_pamong', 'laporan_asrama.dashboard_pamong');

    Route::get('dashboard_pamong', [AsramaProject::class, 'lihat_tugas_pamong'])->name('dashboard_pamong');


    Route::get('udah_selesai/{id}', [AsramaProject::class, 'udah_selesai']);

    Route::get('kembalikan_tugas/{id}', [AsramaProject::class, 'kembalikan_tugas']);

    Route::get('hapus_tugas/{id}', [AsramaProject::class, 'hapus_tugas']);

    Route::get('update_detail/{id_asli}/{ids}/{inputs}/', [AsramaProject::class, 'update_detail_tugas']);

    Route::get('update_deskripsi/{ids}/{lol2}', [AsramaProject::class, 'update_deskripsi']);

    Route::get('update_status_deskripsi/{id_desk}/{isi_desk}', [AsramaProject::class, 'update_status_deskripsi']);

    Route::get('update_status_dibatalkan/{ids}', [AsramaProject::class, 'update_status_dibatalkan']);

    Route::get('update_status_belum_dikerjakan/{ids}/{inputs}/{id_workspace}', [AsramaProject::class, 'update_status_belum_dikerjakan']);


    Route::view('laporan-pdf','laporan_asrama.laporan-pdf');

    Route::post('tambah_confidensial',[AsramaProject::class,'tambah_confidensial']);


    Route::view('setting_profile','laporan_asrama.setting_profile');
    
    Route::get('setting_profile/{id}',[AsramaProject::class,'setting_profile']);
    
    Route::put('update_profile',[AsramaProject::class,'update_profile']);

    Route::view('master','layouts.master');
    
    Route::get('master',[AsramaProject::class,'master']);

    Route::get('/beranda', [AsramaProject::class, "beranda"])->name("beranda");

    Route::get('update_posts/{ids}/{inputs}',[AsramaProject::class,'update_post']);


    Route::view('ganti_posisi','laporan_asrama.ganti_posisi');

    Route::get('ganti_posisi',[AsramaProject::class,'ganti_posisi'])->name('ganti_posisi');
    
    Route::get('ubah_posisi/{ids}',[AsramaProject::class,'ubah_posisi']);

    Route::get('turunkan/{ids}', [AsramaProject::class, 'turunkan']);

    Route::view('piket','laporan_asrama.ganti_posisi');

    Route::get('piket',[AsramaProject::class,'piket']);

    Route::view('setting_akun','laporan_asrama.setting_akun');

    Route::get('setting_akun/{id}',[AsramaProject::class,'setting_akun']);

    Route::get('update_email/{ids}/{lol2}',[AsramaProject::class,'update_email']);

    Route::get('update_password/{id_pass}/{pass}',[AsramaProject::class,'update_password']);

    Route::view('tambah_daftar_siswa','laporan_asrama.tambah_daftar_siswa');

    Route::get('tambah_daftar_siswa',[AsramaProject::class,'tambah_daftar_siswa'])->name('tambah_daftar_siswa');
    
    //Route::get('/tambah_profil_siswa/{nis}/{nisn}/{nama_siswa}/{tempat_lahir}/{jurusan}/{angkatan}/{agama}/{no_absen}/{tanggal_lahir}/{fileName}/',[AsramaProject::class,'tambah_profil_siswa']);
    
    Route::post('tambah_profil_siswa',[AsramaProject::class,'tambah_profil_siswa']);

    Route::get('hapus_siswa/{nis}',[AsramaProject::class,'hapus_siswa']);

    #-------------------------------------------------------------------------------------------------------------#

    Route::view('test_saja', 'testing.mytest');




    Route::get('/dashboard', [SuperAppController::class, "dashboard"])->name("dashboard");

    Route::get('/datasiswa', [SuperAppController::class, "datasiswa"])->name('datasiswa');

    Route::get('/datajurusan/{angkatan}', [SuperAppController::class, "datajurusan"])->name('datajurusan');
    Route::post('/datajurusan/tambahsiswa', [SuperAppController::class, "tambahsiswa"])->name('datajurusan.tambahsiswa');
    Route::post('/datajurusan/tambahsiswaexcel', [SuperAppController::class, "tambahsiswaexcel"])->name('datajurusan.tambahsiswa.excel');

    Route::get('/siswakelas/{angkatan}/{jurusan}', [SuperAppController::class, "siswakelas"])->name('siswakelas');

    Route::get('/profilsiswa/{nis}', [SuperAppController::class, "profilsiswa"])->name('profilsiswa');
    Route::get('/eraportkelas/{angkatan}/{jurusan}', [SuperAppController::class, "eraportkelas"])->name("eraport.kelas");
    Route::get('/eraport/rekaperaportdetail/{params}', [SuperAppController::class, "rekaperaportdetail"])->name("eraport.rekaperaportdetail");

    Route::get('/eraportkelas/tambahmanual/add/{params}', [SuperAppController::class, "tambaheraportmanual"])->name("eraport.tambah.manual");
    Route::post('/eraportkelas/tambahmanual/store', [SuperAppController::class, "tambaheraportmanualstore"])->name("eraport.tambahmanual.store");

    Route::post('/validasieraport', [SuperAppController::class, "validasieraport"])->name("eraport.validasi");
    Route::get('/lihateraport/{id}', [SuperAppController::class, "lihateraport"])->name("eraport.lihat");
    Route::put('/updateraport', [SuperAppController::class, "updateeraport"])->name("eraport.update");
    Route::get('/rekapraport/{angkatan}/{jurusan}', [SuperAppController::class, "rekaperaport"])->name("eraport.rekap");

    Route::post('/senderaport', [SuperAppController::class, "senderaport"])->name("eraport.send");

    Route::post('/tambahcatatan', [SuperAppController::class, "tambahcatatan"])->name("tambahcatatan");

    //
    Route::get('/eraport', [SuperAppController::class, "eraport"])->name("eraport");

    Auth::routes();

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/konfigurasiumum', [SuperAppController::class, "konfigurasiumum"])->name("admin.konfigurasiumum");

    Route::get('/datasiswa', [SuperAppController::class, "datasiswa"])->name('datasiswa');

    Route::get('/carisiswa', [SuperAppController::class, "carisiswa"])->name('carisiswa');

    Route::get('/konfigurasiumum/jurusan', [SuperAppController::class, "konfigurasijurusan"])->name("admin.konfigurasiumum.jurusan");
    Route::post('/konfigurasiumum/jurusan/tambah', [SuperAppController::class, "tambahjurusan"])->name("admin.konfigurasiumum.jurusan.tambah");

    Route::get('/konfigurasiumum/angkatan', [SuperAppController::class, "konfigurasiangkatan"])->name("admin.konfigurasiumum.angkatan");
    Route::post('/konfigurasiumum/angkatan/tambah', [SuperAppController::class, "tambahangkatan"])->name("admin.konfigurasiumum.angkatan.tambah");

    Route::get('/konfigurasiumum/pengguna', [SuperAppController::class, "konfigurasipengguna"])->name("admin.konfigurasiumum.pengguna");

    Route::resource("konfigurasipengguna", KonfigurasiPenggunaController::class);



    Route::post('/konfigurasiumum/kategori/tambah', [SuperAppController::class, "tambahkategori"])->name('admin.konfigurasiumum.kategori.tambah');

    Route::get('kategori', [SuperAppController::class, "konfigurasikategori"])->name('admin.konfigurasiumum.kategori');

    Route::view("/testing", "testing.customtooltips");

    Route::get('hakakseskelas/{id}', [SuperAppController::class, "hakakseskelas"])->name("admin.konfigurasiumum.pengguna.hak");
    Route::post('hakakseskelas/tambah', [SuperAppController::class, "tambahhakakseskelas"])->name("admin.konfigurasiumum.pengguna.hak.tambah");

    //Route Home
   
    Route::get('/listsiswa', [SuperAppController::class, "listsiswa"])->name("listsiswa");

    //Konseling
    Route::get('/reservasikonseling', [SuperAppController::class, "reservasikonseling"])->name("bk.reservasikonseling");
    Route::put('/tolakreservasi', [SuperAppController::class, "tolakreservasi"])->name("bk.tolakreservasi");
    Route::put('/tanggapireservasi', [SuperAppController::class, "tanggapireservasi"])->name("bk.tanggapireservasi");
    Route::put('/ubahjadwalreservasi', [SuperAppController::class, "ubahreservasi"])->name("bk.ubahjadwalreservasi");


    Route::get("/bk/jadwalsaya", [SuperAppController::class, "profil"])->name("bk.jadwalsaya");
    Route::post("/bk/hapusjadwal", [JadwalKonselingController::class, "hapus"])->name("bk.hapusjadwal");
    Route::post("/profil/storejadwal", [SuperAppController::class, "storejadwal"])->name("profil.storejadwal");
    Route::get("/profil/lihatjadwal/{id}", [SuperAppController::class, "lihatjadwal"])->name("profil.lihatjadwal");
    Route::get("/bk/lihatdetailjadwal", [SuperAppController::class, "lihatdetailjadwal"])->name('bk.getdetailjadwal');
    Route::put("/bk/editdetailjadwal", [SuperAppController::class, "editdetailjadwal"])->name('bk.editdetailjadwal');
    Route::put("/bk/selesaireservasi", [SuperAppController::class, "selesaireservasi"])->name('bk.selesaireservasi');
    Route::put("/bk/updatejadwal", [SuperAppController::class, "updatejadwal"])->name('bk.updatejadwal');
    Route::get("/bk/getinfosesi", [SuperAppController::class, "getinfosesi"])->name('bk.getinfosesi');
    Route::get("/profil", [SuperAppController::class, "profil"])->name("profil");
    Route::post("/profil/storejadwal", [SuperAppController::class, "storejadwal"])->name("profil.storejadwal");

    Route::get("/profil/lihatjadwal/{id}", [SuperAppController::class, "lihatjadwal"])->name("profil.lihatjadwal");
});

Route::get('/injectsiswa', [SuperAppController::class, "injectsiswa"]);

//Siswa 
Route::middleware("auth:siswa")->group(function () {
    Route::get('/pengajuankonseling', [SuperAppController::class, "pengajuankonseling"])->name("siswa.pengajuankonseling");
    Route::get('/pengajuankonseling/carikonselor', [SuperAppController::class, "carikonselor"])->name("siswa.carikonselor");
    Route::post('/pengajuankonseling/store', [SuperAppController::class, "pengajuankonselingstore"])->name("siswa.pengajuankonseling.store");


    Route::get('/riwayatkonseling', [SuperAppController::class, "riwayatkonseling"])->name("siswa.riwayatkonseling");
    Route::get('/ajukansesi/{id}', [SuperAppController::class, "ajukansesi"])->name("siswa.ajukansesi");
    Route::get('/batalkankonseling', [SuperAppController::class, "batalkonseling"])->name("siswa.batalkonseling");
});
Route::get('/siswa/register', [SuperAppController::class, "registersiswa"])->name("siswa.register");
Route::post('/siswa/register', [SuperAppController::class, "registersiswastore"])->name("siswa.register.store");

Route::get('/siswa/login', [SuperAppController::class, "loginsiswa"])->name("siswa.login");
Route::post('/siswa/login', [SuperAppController::class, "loginsiswaattempt"])->name("siswa.login.attempt");

Route::post('/injectraport/store', [SuperAppController::class, "injectsiswastore"])->name('injectsiswa.store');
Route::get('/injectphotoprofile', [SuperAppController::class, "injectphotoprofile"]);

Route::view("/tester", "workbench.test");
require __DIR__ . '/auth.php';