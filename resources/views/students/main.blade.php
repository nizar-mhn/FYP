@extends('layouts.app')
<!-- Style -->
<Style>
    .uploadButton {
        background-color: #E76F51 !important;
    }

    .uploadButton:hover {
        background-color: #F4A261 !important;
    }

    .subjectNavs button:hover {
        background-color: #2A9D8F !important;
    }

    .subjectNavs>.active {
        background-color: #2A9D8F !important;
    }

    .subjectNav {
        background-color: #264653 !important;
    }
</Style>

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col"></div>
            <div class="col-8">
                <div class="d-flex">
                    <h1 class="fw-bold mb-5">Files</h1>
                    @php
                        $paymentAlert = Session::get('paymentAlert');
                    @endphp
                    @isset($paymentAlert)
                        <div class="alert alert-success ms-auto" id="paymentSuccess" role="alert">
                            {{ $paymentAlert }}
                        </div>
                    @endisset
                </div>


                <nav class="navbar-dark">
                    <div class="nav nav-tabs d-flex subjectNavs" id="nav-tab" role="tablist">
                        @foreach ($courseList as $course)
                            @php
                                $currentCourseID = $course->courseID;
                                $currentCourse = DB::table('courses')
                                    ->where('courseID', $currentCourseID)
                                    ->first();
                            @endphp
                            <button class="nav-link subjectNav text-light <?php if ($loop->first) {
                                echo 'active';
                            } ?>"
                                id="nav-{{ $currentCourse->courseCode }}-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-{{ $currentCourse->courseCode }}" type="button" role="tab"
                                aria-controls="nav-{{ $currentCourse->courseCode }}"
                                aria-selected="true">{{ $currentCourse->courseCode }}</button>
                        @endforeach
                        <button class="nav-link subjectNav text-light ms-auto text-light" id="nav-personalFiles-tab"
                            data-bs-toggle="tab" data-bs-target="#nav-personalFiles" type="button" role="tab"
                            aria-controls="nav-personalFiles" aria-selected="false">Personal</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">

                    @foreach ($courseList as $course)
                        @php
                            $currentCourseID = $course->courseID;
                            $currentCourse = DB::table('courses')
                                ->where('courseID', $currentCourseID)
                                ->first();
                        @endphp
                        <div class="container p-3 tab-pane fade <?php if ($loop->first) {
                            echo 'active show';
                        } ?>"
                            style="height: 450px; background-color:#264653" id="nav-{{ $currentCourse->courseCode }}"
                            role="tabpanel" aria-labelledby="nav-{{ $currentCourse->courseCode }}-tab" tabindex="0">
                            <h1 class="text-light">{{ $currentCourse->courseName }}</h1>
                            <div class="row row-cols-1 row-cols-md-4 g-4 overflow-auto mt-1" style="height: 370px;">
                                @php
                                    $fileList = DB::table('course_files')
                                        ->where('courseID', $currentCourseID)
                                        ->orderbyDesc('fileID')
                                        ->get();
                                @endphp
                                @if (count($fileList))
                                    @foreach ($fileList as $fileID)
                                        @php
                                            $currentFile = DB::table('files')
                                                ->where('fileID', $fileID->fileID)
                                                ->first();
                                        @endphp
                                        <div class="col">
                                            <div class="card">
                                                <div class="card-header text-light text-break" style="background-color: #2A9D8F">
                                                    <small class=" text-light">{{ $currentFile->fileName }}</small>
                                                </div>
                                                <a href="/students/{{ $currentFile->fileID }}">
                                                    <img src="data:image/png;base64,{{ $currentFile->thumbnail }}"
                                                        class="card-img-top" alt="..."
                                                        style="height: 100px; object-fit: cover;">
                                                </a>
                                                <div class="card-footer text-light" style="background-color:#2A9D8F">
                                                    @php
                                                        $dateTime = explode(' ', $currentFile->dateUpload) 
                                                    @endphp
                                                    Date: {{ $dateTime[0] }} <br>
                                                    Time: {{ $dateTime[1] }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="text-light"><i class="bi bi-file-earmark-excel-fill text-light"></i>
                                                No Files Available </h5>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    <div class="tab-pane fade" id="nav-personalFiles" role="tabpanel"
                        aria-labelledby="nav-personalFiles-tab" tabindex="0">
                        <div class="container " style="height: 450px; background-color:#264653">
                            <div class="container d-flex p-2">
                                <h1 class="text-light">My Files</h1>
                                <div class="ms-auto">
                                    <button type="button" class="btn uploadButton text-light" data-bs-toggle="modal"
                                       id="uploadButton" onclick="showModalUpload()" data-bs-target="#uploadModal">Upload</button>
                                    <div class="modal fade" id="uploadModal" tabindex="-1"
                                        aria-labelledby="uploadModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="uploadModalLabel">
                                                        Upload File
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('document.update') }}" method="post"
                                                    enctype="multipart/form-data">
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div>
                                                                <br />
                                                                @csrf
                                                                <div class="form-group">
                                                                    <input type="file" class="form-control"
                                                                        accept="application/pdf" name="file" required>
                                                                    <input type="hidden"
                                                                        value="{{ Auth::user()->studentID }}"
                                                                        name="studentID">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary" id="uploadBtnModal" onclick="hideAfterUpload()">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row text-light">
                                <div class="row row-cols-1 row-cols-md-4 g-4 overflow-auto mt-1" style="height: 370px;">
                                    @php
                                        $studentfileList = DB::table('student_files')
                                            ->where('studentID', Auth::user()->studentID)
                                            ->orderbyDesc('fileID')
                                            ->get();
                                    @endphp
                                    @if (count($studentfileList))
                                        @foreach ($studentfileList as $fileID)
                                            @php
                                                $currentStudentFile = DB::table('files')
                                                    ->where('fileID', $fileID->fileID)
                                                    ->first();
                                            @endphp
                                            <div class="col">
                                                <div class="card">
                                                    <div class="card-header text-light text-break" style="background-color: #2A9D8F">
                                                        <small class=" text-light">{{ $currentStudentFile->fileName }}</small>
                                                    </div>
                                                    <a href="/students/{{ $currentStudentFile->fileID }}">
                                                        <img src="data:image/png;base64,{{ $currentStudentFile->thumbnail }}"
                                                            class="card-img-top" alt="..."
                                                            style="height: 100px; object-fit: cover;">
                                                    </a>
                                                    <div class="card-footer text-light" style="background-color:#2A9D8F">
                                                        @php
                                                            $dateTime = explode(' ', $currentStudentFile->dateUpload) 
                                                        @endphp
                                                        Date: {{ $dateTime[0] }} <br>
                                                        Time: {{ $dateTime[1] }}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="row">
                                            <div class="col">
                                                <h5 class="text-light"><i
                                                        class="bi bi-file-earmark-excel-fill text-light"></i>
                                                    No Files Available </h5>
                                            </div>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">

            </div>
        </div>
    </div>
    <script>
        setTimeout(() => {
            const alert = document.getElementById('paymentSuccess');
            alert.style.display = 'none';
        }, 3000);

        function hideAfterUpload(){
            document.getElementById('uploadBtnModal').style.display = 'none';
        }
        function showModalUpload(){
            document.getElementById('uploadBtnModal').style.display = 'block';
        }
    </script>
@endsection
