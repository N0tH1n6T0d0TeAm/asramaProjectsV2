@extends('layouts.master')
@section('title', 'Profil '.ucwords($siswa->nama_siswa))
@section('branch1', 'Data Siswa')
@section('branch2', 'Profil Siswa')

@section('content')
<div class="row">
    <div class="col-sm-4">
        <img src="{{asset('siswa/' . $siswa->foto_profil)}}" alt="" class="img-fluid">
    </div>
    <div class="col-sm-8">
        <div class="container">
            <h3>{{$siswa->nama_siswa}} <button class="btn btn-danger hapus_siswa" siswas="{{$siswa->nis}}"><i class="fa fa-trash"></i></button> <a class="btn btn-primary" href="/detail_perkembangan/{{$siswa->nis}}">Kembali</a></h3>
            <table class="table">
                <tr>
                    <th>Angkatan {{$siswa->id_angkatan}}</th>
                </tr>
            </table>
            <nav>
                
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" style="overflow-y: scroll;">
                    <div class="card mt-3">
                        <div class="card-body px-0 py-0">
                            <div class="responsive-table px-0 py-0">
                                <table class="table">
                                    <tr>
                                        <th class="text-center" colspan="2">Data Pribadi</th>
                                    </tr>
                                    <tr>
                                        <th>NIS</th>
                                        <td>{{$siswa->nis}}</td>
                                    </tr>
                                    <tr>
                                        <th>NISN</th>
                                        <td>{{$siswa->nisn}}</td>
                                    </tr>
                                    <tr>
                                        <th>TTL</th>
                                        <td>{{$siswa->tempat_lahir}}, {{$siswa->tanggal_lahir}}</td>
                                    </tr>
                                    <tr>
                                        <th>Agama</th>
                                        <td>{{$siswa->agama}}</td>
                                    </tr>
                                    <tr>
                                        <th>Jurusan</th>
                                        <td>{{$siswa->jurusan->jurusan}}</td>
                                    </tr>
                                    <tr>
                                        <th>Angkatan</th>
                                        <td>{{$siswa->id_angkatan}}</td>
                                    </tr>
                                    <tr>
                                        <th>No Absen</th>
                                        <td>{{$siswa->no_absen}}</td>
                                    </tr>
                                    <tr></tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <div class="card mt-3" style="">
                        <div class="card-header pb-0">
                            <h6 class="mb-0">Catatan Raport Karakter</h6>
                        </div>
                        <div class="card-body ">
                            <ul class="list-group">

                                    @foreach($catataneraport as $ce)
                                    <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                                        <div class="d-flex flex-column">
                                          <h6 class="mb-3 text-sm">{{$ce->keterangan}}</h6>
                                          <span class="mb-2 text-xs">Tanggal Penilaian: <span class="text-dark font-weight-bold ms-sm-2">Viking Burrito</span></span>
                                          <span class="mb-2 text-xs">Email Address: <span class="text-dark ms-sm-2 font-weight-bold">oliver@burrito.com</span></span>
                                          <span class="text-xs">VAT Number: <span class="text-dark ms-sm-2 font-weight-bold">FRB1235476</span></span>
                                        </div>
                                      </li>
                                    

                                    @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-catatanpositif" role="tabpanel" aria-labelledby="nav-contact-tab">
                    @foreach($catatanPositif as $i => $cs)
                    @include('components.superApp.cardcatatanlist')
                    @endforeach
                </div>
                <div class="tab-pane fade" id="nav-rk" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6 class="mb-0">Riwayat Konseling</h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                @foreach($riwayatkonseling as $i => $rwt)
                                <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-3 text-sm">{{$rwt->keterangan_siswa}}</h6>
                                        <span class="mb-2 text-xs">Hari/Tanggal: <span class="text-dark font-weight-bold ms-sm-2">{{getDates($rwt->detailjk->hari,$rwt->detailjk->jadwal->minggu,$rwt->detailjk->jadwal->bulan,$rwt->detailjk->jadwal->tahun,"hari")}} , {{getDates($rwt->detailjk->hari,$rwt->detailjk->jadwal->minggu,$rwt->detailjk->jadwal->bulan,$rwt->detailjk->jadwal->tahun)}}</span></span>
                                        <span class="mb-2 text-xs">Jam: <span class="text-dark ms-sm-2 font-weight-bold">{{$rwt->detailjk->dari}} - {{$rwt->detailjk->sampai}}</span></span>
                                        <span class="mb-2 text-xs">Konselor: <span class="text-dark ms-sm-2 font-weight-bold">{{$rwt->detailjk->jadwal->konselor->name}}</span></span>
                                        <span class="mb-2 text-xs">Catatan Konselor: <span class="text-dark ms-sm-2 font-weight-bold">{{$rwt->catatan_konselor}}</span></span>
                                        <span class="text-xs">Status: <span class="badge {{renderStatusReservasi($rwt->status)}}">{{$rwt->status}}</span></span>
                                    </div>
                                    <div class="ms-auto text-end">
                                    </div>

                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<script>
    $('.hapus_siswa').on('click',function(){
        var tombol = $(this).attr('siswas');
        
        swal({
        title: "Apakah Anda Yakin?",
        text: "Data Siswa Ini Tidak Dapat Dikembalikan Selamanya!",
        icon: "warning",
        dangerMode: true,
        buttons: true,
    }).then((hapus) => {
        if(hapus){
            window.location = '/hapus_siswa/' + tombol + '/';
            swal('Data Berhasil Dihapus!',{icon: "success"});
        }else{
            swal("Data Disimpan!",{icon: "info"});
        }
    })
    })
</script>
@endsection
