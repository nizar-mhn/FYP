@extends('layouts.admin')
<style>
    .sideBar {
        background-color: #56CBF9;
        height: 100vh;
    }

    .header {
        background-color: #12355B;
    }

    button {
        background-color: #12355B !important;
    }

    .btnDelete {
        background-color: red !important;
    }
</style>
@section('content')
<div class="container-fluid">
    <div class="container mt-3">
        <h1 class="">Program Edit</h1>
        <hr>
    </div>
    <div class="row">
        @if (count($programList))
        <div class="col-3 offset-2 p-2 mt-4">
            <div class="container">
                <form action="{{ route('getCourseList') }}" method="post">
                    @csrf
                    <h3>Program</h3>
                    <select class="form-select form-select-lg" name="programID" aria-label="" style="width: 300px" id="bindingTypeSelect">
                        @if (isset($programID))
                        @foreach ($programList as $program)
                        @if ($programID == $program->programID)
                        <option value="{{ $program->programID }}" selected>{{ $program->programName }}
                        </option>
                        @else
                        <option value="{{ $program->programID }}">{{ $program->programName }}</option>
                        @endif
                        @endforeach
                        @else
                        @foreach ($programList as $program)
                        <option value="{{ $program->programID }}">{{ $program->programName }}</option>
                        @endforeach
                        @endif

                    </select>
                    <h3>Year</h3>
                    <select class="form-select form-select-lg" name="programYear" aria-label="" style="width: 300px" id="bindingTypeSelect">
                        @if (isset($programYear))
                        @for ($i = 1; $i < 4; $i++) @if ($programYear==$i) <option value="{{ $i }}" selected>{{ $i }}</option>
                            @else
                            <option value="{{ $i }}">{{ $i }}</option>
                            @endif
                            @endfor
                            @else
                            <option value="1" selected>1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            @endif

                    </select>

                    <h3 class="mt-3">Semester</h3>
                    <select class="form-select form-select-lg" name="programSem" aria-label="" style="width: 300px" id="bindingTypeSelect">
                        @if (isset($programSem))
                        @for ($i = 1; $i < 4; $i++) @if ($programSem==$i) <option value="{{ $i }}" selected>{{ $i }}</option>
                            @else
                            <option value="{{ $i }}">{{ $i }}</option>
                            @endif
                            @endfor
                            @else
                            <option value="1" selected>1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            @endif

                    </select>

                    <button class="btn text-light mt-3" type="submit" style="background-color:#E76F51"><i class="bi bi-search me-2"></i>Search</button>

                    {{-- Add new program modal --}}
                    <button type="button" class="btn text-light mt-3" data-bs-toggle="modal" id="newProgramButton" data-bs-target="#programModal" style="background-color:#E76F51"><i class="bi bi-plus-square me-2"></i>Add new
                        program</button>
                    @if (isset($errorProgram))
                    <div class="alert-danger alert mt-2" style="width: 300px">
                        {{ $errorProgram }}
                    </div>
                    @endif
                </form>
                <div class="modal fade" id="programModal" tabindex="-1" aria-labelledby="programModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="programModalLabel">
                                    Add Program
                                </h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('addProgram') }}" method="post">
                                <div class="modal-body">
                                    <div class="row">
                                        <div>
                                            <br />
                                            @csrf
                                            <label for="programName" class="">{{ __('Program Name') }}</label>
                                            <input type="text" name="programName" id="programName" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" id="newProgramButtonModal">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-5 offset-1 p-2 mt-4">
            @if (!empty($programID))
            @php
            $courseID = DB::table('course_lists')
            ->where('courseListID', $courseListID)
            ->get();

            @endphp
            @if (count($courseID))
            <div class="container">
                <h3 class="mt-2">Course List</h3>
                <div class="row border shadow rounded p-1" style="background-color: #12355B">
                    <div class="col-md-12 fw-bold text-light">
                        @php
                        $programInfo = DB::table('programs')->where('programID',$programID)->first();
                        @endphp
                        {{ $programInfo->programName }}
                    </div>
                </div>
                <div class="row border p-1 rounded shadow mb-2 text-light" style="background-color:#12355B">
                    <div class="col-md-4">
                        Year: {{ $programYear }}
                    </div>
                    <div class="col-md-4">
                        Semester: {{ $programSem }}
                    </div>
                </div>
                <div class="row border p-1">
                    <div class="col-md-4">
                        Course Name
                    </div>
                    <div class="col-md-4">
                        Course Code
                    </div>
                    <div class="col-md-4 text-center">
                        Delete
                    </div>
                </div>
                @foreach ($courseID as $id)
                @php
                $courseInfo = DB::table('courses')
                ->where('courseID', $id->courseID)
                ->first();
                @endphp
                <div class="row border p-2">
                    <div class="col-md-4">
                        {{ $courseInfo->courseName }}
                    </div>
                    <div class="col-md-4">
                        {{ $courseInfo->courseCode }}
                    </div>
                    <div class="col-md-4 pt-2 text-center">
                        <form action="{{route('deleteCourseList')}}" method="post">
                            @csrf
                            <input type="hidden" name="courseListID" value="{{ $courseListID }}">
                            <input type="hidden" name="programID" value="{{ $programID }}">
                            <input type="hidden" name="programYear" value="{{ $programYear }}">
                            <input type="hidden" name="programSem" value="{{ $programSem }}">
                            <input type="hidden" name="courseID" value="{{ $courseInfo->courseID }}">
                            <button class="btn btn-danger btnDelete text-light" type="submit"><i class="bi bi-x-octagon-fill"></i></button>
                        </form>
                    </div>
                </div>
                @endforeach

                <hr>
                <form action="{{ route('addCourseList') }}" method="POST">
                    @csrf
                    @php
                    $courseListOption = DB::table('courses')->get();
                    @endphp
                    <select class="form-select form-select-lg" name="courseID" aria-label="" style="width: 300px" id="bindingTypeSelect">
                        @foreach ($courseListOption as $course)
                        <option value="{{ $course->courseID }}">{{ $course->courseName }}</option>
                        @endforeach

                    </select>
                    @if (isset($errorMsg))
                    <div class="alert-danger alert mt-1" style="width: 300px">
                        {{ $errorMsg }}
                    </div>
                    @endif
                    <input type="hidden" name="courseListID" value="{{ $courseListID }}">
                    <input type="hidden" name="programID" value="{{ $programID }}">
                    <input type="hidden" name="programYear" value="{{ $programYear }}">
                    <input type="hidden" name="programSem" value="{{ $programSem }}">
                    <button type="submit" class="btn text-light mt-3" style="background-color:#E76F51"><i class="bi bi-send-plus-fill me-2"></i>Add
                        Course</button>
                </form>

            </div>
            @else
            <div class="container">
                <h3 class="mt-2">Course List</h3>
                <div class="row border shadow rounded p-1" style="background-color: #12355B">
                    <div class="col-md-12 fw-bold text-light">
                        @php
                        $programInfo = DB::table('programs')->where('programID',$programID)->first();
                        @endphp
                        {{ $programInfo->programName }}
                    </div>
                </div>
                <div class="row border p-1 rounded shadow mb-2 text-light" style="background-color:#12355B">
                    <div class="col-md-4">
                        Year: {{ $programYear }}
                    </div>
                    <div class="col-md-4">
                        Semester: {{ $programSem }}
                    </div>
                </div>
                <div class="row border p-1">
                    <div class="col-md-4">
                        Course Name
                    </div>
                    <div class="col-md-4">
                        Course Code
                    </div>
                    <div class="col-md-4">
                        Edit
                    </div>
                </div>
                <h4 class="text-center mt-4 fw-bold mb-5">No courses found</h4>
                <hr>
                <form action="{{ route('addCourseList') }}" method="POST">
                    @csrf
                    @php
                    $courseListOption = DB::table('courses')->get();
                    @endphp
                    <select class="form-select form-select-lg" name="courseID" aria-label="" style="width: 300px" id="bindingTypeSelect">
                        @foreach ($courseListOption as $course)
                        <option value="{{ $course->courseID }}">{{ $course->courseName }}</option>
                        @endforeach

                    </select>
                    @if (isset($errorMsg))
                    <div class="alert-danger alert mt-1" style="width: 300px">
                        {{ $errorMsg }}
                    </div>
                    @endif
                    <input type="hidden" name="programID" value="{{ $programID }}">
                    <input type="hidden" name="programYear" value="{{ $programYear }}">
                    <input type="hidden" name="programSem" value="{{ $programSem }}">
                    <button type="submit" class="btn text-light mt-3" style="background-color:#E76F51"><i class="bi bi-send-plus-fill me-2"></i>Add
                        Course</button>
                </form>
            </div>
            @endif
            @else
            <div class="container">
                <h3 class="mt-2">Course List</h3>
                <div class="row border">
                    <div class="col-md-4">
                        Course Name
                    </div>
                    <div class="col-md-4">
                        Course Code
                    </div>
                    <div class="col-md-4">
                        Edit
                    </div>
                </div>
                <h4 class="text-center mt-4 fw-bold mb-5">Select program</h4>
            </div>
            @endif
        </div>
        @else
        <div class="row">

            <div class="col-3 offset-2 p-2 mt-4">
                <h3>No Programs</h3>
                {{-- Add new program modal --}}
                <button type="button" class="btn text-light mt-3" data-bs-toggle="modal" id="newProgramButton" data-bs-target="#programModal" style="background-color:#E76F51"><i class="bi bi-plus-square me-2"></i>Add new
                    program</button>
            </div>
            <div class="modal fade" id="programModal" tabindex="-1" aria-labelledby="programModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="programModalLabel">
                                Add Program
                            </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('addProgram') }}" method="post">
                            <div class="modal-body">
                                <div class="row">
                                    <div>
                                        <br />
                                        @csrf
                                        <label for="programName" class="">{{ __('Program Name') }}</label>
                                        <input type="text" name="programName" id="programName" required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" id="newProgramButtonModal">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection