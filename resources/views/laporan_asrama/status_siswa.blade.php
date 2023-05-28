@extends('layouts.master')
@section('content')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> 
    <style>
    a:hover{
        color: black;
        }
    a .dropdown{
        float: right;
        margin: 7px;
        transition: 10s ease;
    }
    table {
  border: 1px solid #ccc;
  border-collapse: collapse;
  margin: 0;
  padding: 0;
  width: 100%;
  table-layout: fixed;
}
table caption {
  font-size: 1.5em;
  margin: .5em 0 .75em;
}
table tr {
  background-color: #f8f8f8;
  border: 1px solid #ddd;
  padding: .35em;
}
table th,
table td {
  padding: .625em;
  text-align: center;
}
table th {
  font-size: .85em;
  letter-spacing: .1em;
  text-transform: uppercase;
}
@media screen and (max-width: 600px) {
    .kosong{
        display: none;
    }
  table {
    border: 0;
  }
  table caption {
    font-size: 1.3em;
  }
  
  table thead {
    border: none;
    clip: rect(0 0 0 0);
    height: 1px;
    margin: -1px;
    overflow: hidden;
    padding: 0;
    position: absolute;
    width: 1px;
  }
  
  table tr {
    border-bottom: 3px solid #ddd;
    display: block;
    margin-bottom: .625em;
  }
  
  table td {
    border-bottom: 1px solid #ddd;
    display: block;
    font-size: .8em;
    text-align: right;
  }
  
  table td::before {
    content: attr(data-label);
    float: left;
    font-weight: bold;
    text-transform: uppercase;
  }
}
    .sub-angkatan{
        display: none;
    }
    .sub-siswa{
        display: none;
    }
</style>

<a href="#" class="form-control angkatan" style="text-decoration: none;">Alumni<i class="fas fa-angle-right dropdown"></i></a>

<table class="sub-angkatan">
    <thead>
         <tr>
        <th>No</th>
        <th>Nama Anak<th>
        <th>Kembalikan</th>
    </tr> 
    </thead>

 <tbody>
    @php $no = 1; @endphp
    @foreach ($data2 as $d)
    <tr>
            <td data-label="no">{{$no++}}</td>
            <td data-label="nama anak"><a href="/detail_perkembangan/{{$d->nis}}" style="text-decoration: none">{{$d->nama_siswa}}</a></td>
            <td class="kosong"></td>
            <td data-label="kembalikan">
                <button class="btn btn-info ulangs" nis_siswa="{{$d->nis}}"><i class="fa fa-refresh"></i></button>
            </td>
        </tr>
    @endforeach
 </tbody>
</table>
<br>

<a href="#" class="form-control nama_siswa" style="text-decoration: none;">Dikeluarkan<i class="fas fa-angle-right dropdown"></i></a>

<table class="sub-siswa">
    <thead>
        <th>No</th>
        <th>Nama Siswa</th>
        <th>Jurusan</th>
        <th>Angkatan</th>
        <th>Kembalikan</th>
</thead>

<tbody>
    @php $no2=1; @endphp
    @foreach($data as $d)
    <tr>
            <td data-label="No">{{$no2++}}</td>
            <td data-label="nama siswa"><a href="/detail_perkembangan/{{$d->nis}}" style="text-decoration: none">{{$d->nama_siswa}}</a></td>
            <td data-label="Jurusan">{{$d->jurusan->jurusan}}</td>
            <td data-label="Angkatan">A-{{$d->angkatan->id_angkatan}}</td>
            <td data-label = "kembalikan">
                <button class="btn btn-info ulangs" nis_siswa="{{$d->nis}}"><i class="fa fa-refresh"></i></button>
            </td>
        </tr>
    @endforeach
</tbody>
</table>

<script type="text/javascript">
$('.ulangs').click(function(){
        var ids = $(this).attr('nis_siswa');
        
        swal({
            title: "Apakah Anda Ingin Mengembalikan Nama Ini?",
            text: "Jika Anda Mencoba Menekan Tombol Ini Maka Anda Mengembalikan Angkatan Tersebut Kembali Ke Datanya Yang Semula,Apakah Anda Yakin Dengan Ini?",
            icon: "warning",
            buttons: true,
        }).then((kalauKembali) => {
            if(kalauKembali){
                window.location = '/status_aktif/' +ids+ '/',
                swal('Berhasil Seperti Semula',{icon: "success"})
            }else{
                swal('Data Anda Tetap Aman',{icon: "info"});
            }
        })
    })
    
    $(document).ready(function(){
        $('.angkatan').click(function(){
            $(this).next('.sub-angkatan').slideToggle();
        });
        $('.nama_siswa').click(function(){
            $(this).next('.sub-siswa').slideToggle();
        })
    })
</script>
@endsection