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
            <h3 class="pt-4">No. Pages: {{ $currentFile->noPage }}</h3>
            @php
            $dateTime = explode(' ', $currentFile->dateUpload)
            @endphp
            <h3 class="pt-4">Upload Date: {{ $dateTime[0] }} </h3>
            <h3 class="pt-4">Upload Time: {{ $dateTime[1] }} </h3>
            <h3 class="pt-4 pb-4">Availability: {{ $currentFile->availability }} </h3>
            <form method="GET" action="{{route('updateAvailability')}}">
                @if($currentFile->availability=="Available")
                <button type="submit" class="btn text-light" style="background-color: #264653;" value="1" name="availability">Set Unavailable</button>
                @else
                <button type="submit" class="btn text-light" style="background-color: #264653;" value="0" name="availability">Set Available</button>
                @endif
                <input type="hidden" name="fileID" value="{{$fileID}}">
            </form>
        </div>
    </div>
</div>
@endsection