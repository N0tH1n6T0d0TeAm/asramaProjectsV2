@extends('layouts.master')
@section('content')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> 

<style>
 .overlay h2{
    font-size: 20px;
    margin-left: 5px;
}
.overlay{
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0,0,0,0.8);
        transition: opacity 500ms;
        visibility: hidden;
        opacity: 0;
        z-index: 2148;
}
.overlay:target{
    visibility: visible;
    opacity: 1;
    transition: 0.3s ease-in-out;
}
.overlay .info input{
    margin: 5px 10px auto;
    width: 90%;
}

.overlay .info select{
    margin: 5px 10px auto;
    width: 90%;
}
.overlay .info label{
    margin-left: 5px;
}
.info .lol{
    margin: 5% 30% auto;
    background: #fff;
    width: 40%;
    border-radius: 3px;
    padding: 70px 0;
}
.overlay .info button{
    float: right;
    margin: 10px;
}
a.keluar{
    float: right;
    color: black;
    text-decoration: none;
}
.overlay .info .textarea{
    width: 90%;
    margin: 0 10px;
}

@media(max-width: 376px){
    tbody{
        font-size: 10px;
    }
}

@media(max-width: 420px){
    tbody{
        font-size: 10px;
    }
}
@media(max-width: 282px){
    table{
        position: relative;
        left: -1em;
    }
    tbody{
        font-size: 7px;
    }
}
</style>

<a href="#tambahTugas" style="float: right">Tambah Tugas</a><br><br>

<div id="tambahTugas" class="overlay" style="overflow-y: scroll;">
    <div class="info">
        <div class="lol">
            <div class="isinya" style="position: relative;top: -3em;">
    <form action="/tambah_tugas" method="POST">
    @csrf
    <h2>Tambah Tugas <a href="#" class="keluar">&times</a></h2>
    <hr style="border: 1px solid black;margin-top: -3px;">

    <input type="hidden" name="tanggal" value="{{\Carbon\Carbon::now()->toDateString()}}">
    
    <label>Nama Pamong</label>
    <select class="form-control" name="id_pamong" required>
        <option value="">Nama Pamong</option>
        @foreach($data as $d)
        <option value="{{$d->model_id}}">{{$d->user->name}}</option>
        @endforeach
    </select>
    <table>
        <thead>
        <tr>
            <td><label>Tugas</label></td>
        </tr>
    </thead>
    
    <tbody class="isi">
        <tr>
            <td><input type="text" style="width: 100%" name="judul_tugas" class="form-control" placeholder="Judul" required></td>
            <td><a href="#tambahTugas" style="margin: 5px;" class="btn btn-success tambahs"><i class="fas fa-plus"></i></a></td>
        </tr>
        <tr>
            <td><input type="text" style="width: 100%" name="isi_tugas[]" class="form-control" placeholder="Isi Tugas" required></td>
            <td><a href="#tambahTugas" style="margin: 5px;" class="btn btn-danger"><i class="fas fa-minus"></i></a></td>
        </tr>
    </tbody>
    </table>
    <button class="btn btn-primary">Tambah</button>
    </form>
        </div>
    </div>
    </div>
</div>




@foreach($data2 as $d)

 @php
        $sudah_dikerjakan = $d->isi->where('id_workspace',$d->isi->id_workspace)->where('status','Sudah Dikerjakan')->count();
        $total_data =  $sudah_dikerjakan + $d->isi->where('id_workspace',$d->isi->id_workspace)->where('status','Belum Dikerjakan')->count(); 


        $dibatalkan = $d->isi->where('id_workspace',$d->isi->id_workspace)->where('status','Pending')->count();

        $detail_tugas = $d->isi->where('id_workspace',$d->isi->id_workspace)->get();
        
   @endphp


    <div class="card">
  <div class="card-header">

    {{tgl_indo($d->tanggal)}} <a href="#" class="btn btn-danger hapus_tugas" id_tugasnya="{{$d->id_workspace}}" style="float: right"><i class="fas fa-trash"></i></a><br>
    <p style="font-size: 10px; color: red">* Anda Hanya Dapat Mengatur Status Yang Belum Dikerjakan & Pekerjaan Dibatalkan *</p>
  
</div>

  <div class="card-body">
    <h5 class="card-title">{{$d->user->name}}</h5>
    <p class="card-text">{{$d->tugas}}</p>
   
   
    @if(round($sudah_dikerjakan / $total_data * 100) == 0)
    <p style="color: red">Belum Dikerjakan</p>
    @elseif(round($sudah_dikerjakan / $total_data * 100) <= 99 || $dibatalkan)
    <p style="color: orange">On Going</p>
    @else
    <p style="color: green">Pekerjaan Selesai</p>
    @endif
    <div class="progress">
        <div class="progress-bar" role="progressbar" style="width: {{round($sudah_dikerjakan / $total_data * 100)}}%; height: 500%;">{{round($sudah_dikerjakan / $total_data * 100)}}%

        </div>
    </div><br>

    <table style="width: 100%; text-align: center">
                    <thead>
                        <th></th>
                        <th><label>Detail Tugas</label></th>
                        <th><label>Status</label></th>
                        <th><label>Deskripsi</label></th>
                    </thead>
                    @foreach ($detail_tugas as $d)
                    @if($d->status == "Sudah Dikerjakan")
                    <tbody>
                        <td><input type="checkbox" class="form-checkbox" style="pointer-events: none" checked></td>
                        <td>{{$d->isi_tugas}}</td>
                        <td>{{$d->status}}</td>
                        <td>{{$d->deskripsi}}</td>
                    </tbody>
                    @elseif($d->status == "Pending")
                    <tbody style="color: orange;">
                        <td><input type="checkbox" class="form-checkbox" disabled></td>
                        <td>{{$d->isi_tugas}}</td>
                        <td>{{$d->status}}</td>
                        <td>{{$d->deskripsi}}</td>
                    </tbody>
                    @elseif($d->status == "Belum Dikerjakan")
                    <tbody>
                        <td><input type="checkbox"  id_bagian="{{$d->id_bagian}}" class="form-checkbox check"></td>
                        <td>{{$d->isi_tugas}}</td>
                        <td>{{$d->status}}</td>
                        <td>{{$d->deskripsi}}</td>
                    </tbody>
                    @else
                    <tbody style="color: red">
                        <td><input type="checkbox" id_bagian="{{$d->id_bagian}}" id_workspace="{{$d->id_workspace}}" value="Belum Dikerjakan" class="form-checkbox check2" checked></td>
                        <td>{{$d->isi_tugas}}</td>
                        <td>{{$d->status}}</td>
                        <td>{{$d->deskripsi}}</td>
                    </tbody>
                    @endif
                    @endforeach
                </table>
          
  </div>
</div><br>


@endforeach


<script>

    $('.check').on('click',function(){
        var ids = $(this).attr('id_bagian');
        
        
        window.location = "/update_status_dibatalkan/"+ids+'/';
    })

    $('.check2').on('click',function(){
        var ids = $(this).attr('id_bagian');
        var inputs = $(this).val();
        var id_workspace = $(this).attr('id_workspace');
        
        window.location = "/update_status_belum_dikerjakan/"+ids+'/'+inputs+'/'+id_workspace;
    })


    $('.tambahs').on('click',function(){
        var isi = `<tr>
            <td><input type="text" style="width: 100%" name="isi_tugas[]" class="form-control" placeholder="Isi Tugas" required></td>
            <td><a href="#tambahTugas" style="margin: 5px;" class="btn btn-danger hapus"><i class="fas fa-minus"></i></a></td>
        </tr>` ;

        $('.isi').append(isi);
    })


    $('.isi').delegate('.hapus', 'click', function(){
    $(this).parent().parent().remove();
});

    $('.hapus_tugas').on('click',function(){
        var ids = $(this).attr('id_tugasnya');
        
        swal({
            icon: "warning",
            title: "Apakah Anda Yakin?",
            text: "Ingin Menghapus Tugas Ini?",
            buttons: true,
            dangerMode: true,
        }).then((kembalikanTugas) => {
            if(kembalikanTugas){
                swal("Tugas Dihapus",{icon: "success"});
                window.location = "/hapus_tugas/" + ids;
            }else{
                swal("Tugas Diamankan",{icon: "info"});
            }
        })
    })
</script>

@endsection