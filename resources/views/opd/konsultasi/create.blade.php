@extends('layouts.app')

@section('title', 'Buat Konsultasi Baru')


@push('styles')
<style>

.konsul-header{
    display:flex;
    align-items:center;
    gap:14px;
    margin-bottom:25px;
}

.back-btn{
    width:42px;
    height:42px;
    border-radius:10px;
    border:1px solid #dbe5f5;
    background:white;
    color:#165DFF;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:20px;
}


.konsul-title{
    font-size:26px;
    font-weight:800;
    color:#102a56;
}



.form-card{

    background:white;
    border-radius:16px;
    border:1px solid #e5edf8;
    padding:35px;

    box-shadow:
    0 10px 30px rgba(15,23,42,.06);

}



.form-group-icon{

    display:flex;
    gap:18px;
    margin-bottom:25px;

}



.field-icon{

    width:42px;
    height:42px;

    background:#eef4ff;
    color:#165DFF;

    border-radius:12px;

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:20px;

    flex-shrink:0;

}



.field-content{

    flex:1;

}



.field-label{

    font-weight:700;
    color:#102a56;
    margin-bottom:8px;

}



.form-control,
.form-select{

    border-radius:10px;
    border:1px solid #d8e2f0;

    padding:12px 15px;

}



.form-control:focus,
.form-select:focus{

    border-color:#165DFF;
    box-shadow:0 0 0 .2rem rgba(22,93,255,.12);

}



textarea.form-control{

    height:110px;
    resize:none;

}



.form-text{

    color:#718096;
    font-size:13px;

}



.btn-submit{

    background:#165DFF;
    border:none;

    padding:12px 25px;

    border-radius:10px;

    font-weight:700;

}



.btn-submit:hover{

    background:#0f4bd8;

}



.btn-cancel{

    padding:12px 25px;
    border-radius:10px;

}



</style>
@endpush



@section('content')


<div class="konsul-header">

<a href="{{ route('opd.dashboard') }}" class="back-btn">

<i class="bi bi-arrow-left"></i>

</a>


<div class="konsul-title">

Buat Konsultasi Baru

</div>


</div>





<div class="form-card">


<form method="POST"
action="{{ route('opd.konsultasi.store') }}"
enctype="multipart/form-data">

@csrf





<!-- JUDUL -->

<div class="form-group-icon">


<div class="field-icon">

<i class="bi bi-file-earmark-text"></i>

</div>



<div class="field-content">


<label class="field-label">

Judul Konsultasi

</label>


<input

type="text"

name="judul"

id="judul"

class="form-control @error('judul') is-invalid @enderror"

value="{{ old('judul') }}"

placeholder="Contoh: Konsultasi Pertanggungjawaban Perjalanan Dinas"

required

>


@error('judul')
<div class="invalid-feedback">
{{ $message }}
</div>
@enderror


</div>


</div>






<!-- KATEGORI -->

<div class="form-group-icon">


<div class="field-icon">

<i class="bi bi-grid"></i>

</div>



<div class="field-content">


<label class="field-label">

Kategori

</label>



<select

name="category_id"

id="category_id"

class="form-select @error('category_id') is-invalid @enderror"

required>


<option value="">

— Pilih Kategori —

</option>



@foreach ($kategori as $item)

<option

value="{{ $item->id }}"

@selected(old('category_id') == $item->id)

>

{{ $item->nama_kategori }}

</option>


@endforeach


</select>



<div class="form-text mt-2">

Pilih yang paling mendekati topik pertanyaan Anda. Kurang yakin? Pilih "Lain-lain".

</div>



@error('category_id')

<div class="invalid-feedback">

{{ $message }}

</div>

@enderror



</div>


</div>






<!-- PERTANYAAN -->


<div class="form-group-icon">


<div class="field-icon">

<i class="bi bi-chat"></i>

</div>



<div class="field-content">


<label class="field-label">

Uraian Pertanyaan

</label>



<textarea

name="pertanyaan"

id="pertanyaan"

class="form-control @error('pertanyaan') is-invalid @enderror"

placeholder="Jelaskan konteks dan pertanyaan Anda secara ringkas dan jelas."

required>{{ old('pertanyaan') }}</textarea>



<div class="form-text mt-2">

Minimal 20 karakter. Semakin jelas uraian, semakin cepat direspons.

</div>



@error('pertanyaan')

<div class="invalid-feedback">

{{ $message }}

</div>

@enderror



</div>


</div>






<!-- LAMPIRAN -->


<div class="form-group-icon">


<div class="field-icon">

<i class="bi bi-paperclip"></i>

</div>



<div class="field-content">


<label class="field-label">

Lampiran <span class="text-muted fw-normal">(opsional)</span>

</label>



<input

type="file"

name="lampiran[]"

id="lampiran"

multiple

class="form-control @error('lampiran') is-invalid @enderror"

accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png"

>



<div class="form-text mt-2">

Masing-masing berkas maksimal {{ round(config('ekonsul.lampiran.maks_ukuran_kb') / 1024, 1) }} MB.
Format: PDF, Word, Excel, atau gambar.

</div>


</div>


</div>





<div class="d-flex gap-3">


<button type="submit" class="btn btn-submit text-white">

<i class="bi bi-send"></i>

Ajukan Konsultasi

</button>



<a href="{{ route('opd.dashboard') }}"

class="btn btn-outline-secondary btn-cancel">

Batal

</a>


</div>





</form>


</div>


@endsection