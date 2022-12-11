@extends('layouts.app')
<style>
    .buyBtn {
        background-color: #E76F51 !important;
    }

    .buyBtn:hover {
        background-color: #F4A261 !important;
    }

    .filePicture{
        height: 500px; 
        object-fit:cover;
        width:400px;
        filter: grayscale(100%);
    }

    .zoom:hover {
        transform: scale(3);
    }
    .zoom:hover ~ .bindBadge{
        display: none;
    }

</style>
@section('content')
    @php
        $currentFile = DB::table('files')
            ->where('fileID', $fileID)
            ->first();
    @endphp
    <div class="container">
        <h1>File Info</h1>
        <div class="row">
            <div class="col-lg-6 pb-5">
                <img src="data:image/png;base64,{{ $currentFile->thumbnail }}" class="thumbnail border border-2 filePicture"
                    alt="File Picture" id="filePicture">
            </div>
            <div class="col-lg-6">
                <h2 class="fw-bold">{{ $currentFile->fileName }}</h2><hr>
                <h2 class="pt-3">No. Pages: {{ $currentFile->noPage }}</h2>
                <form class="pt-4" action="{{ route('chooseLocation') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <h2>Binding Type:</h2>
                            <select class="form-select form-select-lg" name="binding-type" aria-label="" style="width: 300px" id="bindingTypeSelect">
                                <option value="No_binding" selected>No binding</option>
                                <option value="Saddle_Stitching">Saddle Stitching</option>
                                <option value="Case_Binding">Case Binding</option>
                                <option value="Wire-O_Binding">Wire-O Binding</option>
                            </select>
                        </div>
                        <div class="col ms-3" id="bindingImageColumn" style="display: none">
                            <div class="position-relative">
                                <img src="" alt="" class="zoom" style="height: 85px; width:85px;" id="bindingImage">
                                <span class="bindBadge position-absolute top-70 start-55 translate-middle badge bg-secondary rounded-pill">
                                    <i class="bi bi-info-circle"></i>
                                    <span class="visually-hidden">Clickable</span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row pt-5">
                        <div class="col-md-3">

                            <h2 class="">Color:</h2>
                            <input type="checkbox" class="btn-check" name="checkColor" id="checkColorBtn" autocomplete="off">
                            <label class="btn btn-outline-primary" for="checkColorBtn">Color Page</label><br>
                        </div>
                        <div class="col-md pt-3">

                            <h2 class="">Page Format:</h2>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pageFormat" id="pageFormat1" value="one-side"
                                    checked>
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
                        </div>
                    </div>


                    <h2 class="pt-3">Amount:</h2>
                    <input type="number" name="amount" style="width:80px" min="1" max="100" value="1" required>
                    <div class="d-flex  pt-2" style="width: 400px">
                        <input type="hidden" name="fileID" value="{{ $currentFile->fileID }}">
                        <button class="btn buyBtn ms-auto text-light" type="submit" value="submit">Order</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
    <script>
        const dropdown = document.getElementById("bindingTypeSelect");
        const checkColorBtn = document.getElementById("checkColorBtn");
        dropdown.addEventListener("change", function() {
            var image = document.getElementById("bindingImage");
            if (dropdown.value == "No_binding") {
                document.getElementById("bindingImageColumn").style.display = "none";
                console.log("test");
            } else {
                document.getElementById("bindingImageColumn").style.display = "block";
                image.src = "../image/bindingTypeIMG/" + dropdown.value + ".png"
            }
        })

        checkColorBtn.addEventListener("change", function(){
            if(checkColorBtn.checked){
                document.getElementById("filePicture").style.filter = "grayscale(0%)";
            }else{
                document.getElementById("filePicture").style.filter = "grayscale(100%)";
            }
        })
    </script>
@endsection
