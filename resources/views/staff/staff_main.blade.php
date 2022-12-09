@extends('layouts.staff')
<!-- Style -->
<Style>
    .uploadButton {
        background-color: #264653 !important;
    }

    .uploadButton:hover {
        background-color: #2A9D8F !important;
    }

    .subjectButtons button:hover {
        background-color: #F4A261 !important;
    }

    .subjectNavs>.active {
        background-color: #F4A261 !important;
    }

    .subjectNav {
        background-color: #E76F51 !important;
    }
</Style>
@section('content')
<div class="container-fluid">

    <div class="row">
        <div class="col"></div>
        <div class="col-8">
            <h1 class="fw-bold mb-5">Files</h1>
            <!--<div class="container-fluid" style="background-color:#264653; height: 10px">
            </div>-->

            <nav class="navbar-dark">
                <div class="nav nav-tabs d-flex subjectNavs" id="nav-tab" role="tablist">
                    @foreach ($courseList as $course)
                    @php
                    $currentCourseID = $course->courseID;
                    $currentCourse = DB::table('courses')->where('courseID', $currentCourseID)->first();
                    @endphp
                    <button class="nav-link subjectNav text-light <?php if ($loop->first) {
                                                                        echo 'active';
                                                                    } ?>" id="nav-{{ $currentCourse->courseCode }}-tab" data-bs-toggle="tab" data-bs-target="#nav-{{ $currentCourse->courseCode }}" type="button" role="tab" aria-controls="nav-{{ $currentCourse->courseCode }}" aria-selected="true">{{ $currentCourse->courseCode }}</button>
                    @endforeach
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                @php
                $count = 1;
                @endphp
                @foreach ($courseList as $course)
                @php
                $count++;
                $currentCourseID = $course->courseID;
                $currentCourse = DB::table('courses')->where('courseID', $currentCourseID)->first();
                @endphp
                <div class="container p-3 tab-pane fade <?php if ($loop->first) {
                                                            echo 'active show';
                                                        }  ?>" style="height: 450px; background-color:#E76F51" id="nav-{{ $currentCourse->courseCode }}" role="tabpanel" aria-labelledby="nav-{{ $currentCourse->courseCode }}-tab" tabindex="0">
                    <div class="container d-flex p-2">
                        <h1 class="text-light">{{ $currentCourse->courseName }}</h1>
                        <div class="ms-auto">
                            <button type="button" class="btn uploadButton text-light" data-bs-toggle="modal" data-bs-target="#uploadModal{{$count}}">Upload</button>
                            <div class="modal fade" id="uploadModal{{$count}}" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="uploadModalLabel">
                                                Upload File
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('document.staffupdate') }}" method="post" enctype="multipart/form-data">
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div>
                                                        <br />
                                                        @csrf
                                                        <div class="form-group">
                                                            <input type="file" class="form-control" name="file" accept="application/pdf" required>
                                                            <input type="hidden" value="{{ $currentCourse->courseID }}" name="courseID">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row row-cols-1 row-cols-md-4 g-4 overflow-auto mt-1" style="height: 370px;">
                        @php
                        $fileList = DB::table('course_files')->where('courseID',$currentCourseID)->get();
                        @endphp
                        @foreach ($fileList as $fileID)
                        @php
                        $currentFile = DB::table('files')->where('fileID', $fileID->fileID)->first();
                        @endphp
                        <div class="col">
                            <div class="card">
                                <a href="">
                                    <img src="data:image/png;base64,{{ $currentFile->thumbnail }}" class="card-img-top" alt="..." style="height: 100px">
                                </a>
                                <div class="card-footer" style="background-color:#2A9D8F">
                                    <small class=" text-light">{{ $currentFile->fileName }}</small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="col"></div>
    </div>
</div>
@endsection