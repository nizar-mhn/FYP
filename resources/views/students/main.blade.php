
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

    .subjectNavs > .active{
        background-color: #2A9D8F !important;
    }

    .subjectNav{
        background-color: #264653 !important;
    }

</Style>

@section('content')
<div class="container-fluid">

    <div class="row">
        <div class="col"></div>
        <div class="col-8">
            <h1 class="fw-bold mb-5">My Files</h1>
            <!--<div class="container-fluid" style="background-color:#264653; height: 10px">
            </div>-->
            
            <nav class="navbar-dark">
                <div class="nav nav-tabs d-flex subjectNavs" id="nav-tab" role="tablist">
                    @foreach ($courseList as $course)
                    @php
                        $currentCourseID = $course->courseID;
                        $currentCourse = DB::table('courses')->where('courseID', $currentCourseID)->first();
                    @endphp
                    <button class="nav-link subjectNav text-light <?php if($loop->first){echo 'active';} ?>" id="nav-{{ $currentCourse->courseCode }}-tab" data-bs-toggle="tab" data-bs-target="#nav-{{ $currentCourse->courseCode }}" type="button" role="tab" aria-controls="nav-{{ $currentCourse->courseCode }}" aria-selected="true">{{ $currentCourse->courseCode }}</button>
                    @endforeach
                    <button class="nav-link subjectNav text-light ms-auto text-light" id="nav-personalFiles-tab" data-bs-toggle="tab" data-bs-target="#nav-personalFiles" type="button" role="tab" aria-controls="nav-personalFiles" aria-selected="false">Personal</button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                @foreach ($courseList as $course)
                    @php
                        $currentCourseID = $course->courseID;
                        $currentCourse = DB::table('courses')->where('courseID', $currentCourseID)->first();
                    @endphp
                    <div class="container p-3 tab-pane fade <?php if($loop->first){echo 'active show';}  ?>" style="height: 450px; background-color:#264653" id="nav-{{ $currentCourse->courseCode }}" role="tabpanel" aria-labelledby="nav-{{ $currentCourse->courseCode }}-tab" tabindex="0">
                        <h1 class="text-light">{{ $currentCourse->courseName }}</h1>

                        <div class="overflow-auto d-flex">
                           
                        </div>
                    </div>
                @endforeach
                
                <div class="tab-pane fade" id="nav-personalFiles" role="tabpanel" aria-labelledby="nav-personalFiles-tab" tabindex="0">

                    <div class="container " style="height: 450px; background-color:#264653">
                        <div class="container d-flex p-2">
                            <h1 class="text-light">Subject Name</h1>
                            <div class="ms-auto">
                                <button type="button" class="btn uploadButton text-light" data-bs-toggle="modal" data-bs-target="#uploadModal">Upload</button>
                                <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="uploadModalLabel">
                                                    Upload File
                                                </h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('document.update') }}" method="post" enctype="multipart/form-data">
                                            <div class="modal-body">
                                                    <div class="row">
                                                        <div>
                                                            <br />
                                                            @csrf
                                                            <div class="form-group">
                                                                <input type="file" class="form-control" name="file" required>
                                                                <input type="hidden" value="{{ Auth::user()->studentID }}" name="studentID">
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
                        <div class="row text-light">
                            @if ($documents->count())
                            <h3>Documents</h3>
                            <div>
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <td class="text-light">Name</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                    <tbody>
        
                                        @foreach ($documents as $document)
        
                                        <tr>
                                            <td class="text-light">{{$document->fileName}}  </td>
                                            <td> <img src="data:image/png;base64,{{ $document->thumbnail }}" style="height: 100px;width:100px"></td>
                                            <!-- <td><?php
                                                        // $im = new imagick(($document->fileName)[0]);
                                                        // $im->setImageFormat('jpg');
                                                        // header('Content-Type: image/jpeg');
                                                        // echo $im;
                                                        ?>
                            </td> -->
                                            <td><a href="{{ route('document.download', $document->fileID) }}">Download</a></td>
                                            <td><a href="{{ route('document.destroy', $document->fileID) }}">Delete</a></td>
                                        </tr>
                                    </tbody>
                                    @endforeach
                                </table>
                            </div>
                            @endif
                        </div> 
                    </div>
                </div>
            </div>
        </div>
        <div class="col"></div>
    </div>
</div>
@endsection