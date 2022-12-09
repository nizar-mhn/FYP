@extends('layouts.staff')
<style>
    .buyBtn {
        background-color: #E76F51 !important;
    }

    .buyBtn:hover {
        background-color: #F4A261 !important;
    }
</style>
@section('content')
@php
$currentFile = DB::table('files')->where('fileID', $fileID)->first();
@endphp
<div class="container">
    <h1>File Info</h1>
    <div class="row ">
        <div class="col-md-6">
            <img src="data:image/png;base64,{{ $currentFile->thumbnail }}" class="thumbnail border border-2" alt="File Picture" style="height: 500px; object-fit:cover;width:400px">
        </div>
        <div class="col-md-6">
            <h2>File: {{ $currentFile->fileName }}</h2>
            <h2 class="pt-4">No. Pages: {{ $currentFile->noPage }}</h2>
        </div>
    </div>
</div>
@endsection