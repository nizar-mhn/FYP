@extends('layouts.app')
<style>
    .buyBtn{
        background-color: #E76F51 !important;
    }

    .buyBtn:hover{
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
                <img src="data:image/png;base64,{{ $currentFile->thumbnail }}" class="thumbnail border border-2" alt="File Picture" style="height: 500px;">
            </div>
            <div class="col-md-6">
                <h2>File: {{ $currentFile->fileName }}</h2>
                <h2 class="pt-4">No. Pages: {{ $currentFile->noPage }}</h2>
                <form class="pt-4" action="{{ route('payment') }}" method="POST">
                    @csrf
                    <h2>Binding Type:</h2>
                    <select class="form-select form-select-lg" name="binding-type" aria-label="" style="width: 300px">
                        <option value="No_binding" selected>No binding</option>
                        <option value="Saddle_Stitching">Saddle Stitching</option>
                        <option value="Case_Binding">Case Binding</option>
                        <option value="Wire-O_Binding">Wire-O Binding</option>
                    </select>
                    <h2 class="pt-2">Color:</h2>
                    <input type="checkbox" class="btn-check" name="checkColor" id="btn-check-outlined" autocomplete="off">
                    <label class="btn btn-outline-primary" for="btn-check-outlined">Color Page</label><br>

                    <h2 class="pt-3">Page Format:</h2>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="pageFormat" id="pageFormat1" value="one-side" checked>
                        <label class="form-check-label" for="pageFormat1">
                          One side Page
                        </label>
                      </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="pageFormat" id="pageFormat2" value="back-back">
                        <label class="form-check-label" for="pageFormat2">
                          Back-to-back Page
                        </label>
                    </div>

                    <h2 class="pt-3">Amount:</h2>
                    <input type="number"  name="amount" style="width:80px" min="1" max="10" required>
                    <div class="d-flex  pt-2" style="width: 400px">
                        <input type="hidden" name="fileID" value="{{ $currentFile->fileID }}">
                        <button class="btn buyBtn ms-auto text-light" type="submit" value="submit">Order</button>
                    </div>
                    
                </form>

            </div>
        </div>
    </div>
@endsection