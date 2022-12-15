@extends('layouts.admin')
<style>
</style>
@section('content')
    <div class="container">
        @php
            
        @endphp
        @if (!empty($courseList))
            <h1 class="mt-3">Course Edit</h1>
            <hr>
            <div class="row mt-3">
                <div class="col-md-8 offset-2 mt-4">
                    <div class="row p-3">
                        <div class="col-md-4 offset-5">
                        @if (isset($errorMsg))
                    <p class="alert-danger alert" id="errorMessage">
                        {{ $errorMsg }}
                    </p>
                    @endif
                        </div>
                        <div class="col-md-3 text-center">
                            <a href="" class="btn text-light" style="background-color: #12355B" data-bs-toggle="modal"
                                id="newCourseButton" data-bs-target="#courseModal">Add Course</a>
                            <div class="modal fade" id="courseModal" tabindex="-1" aria-labelledby="courseModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="courseModalLabel">
                                                Add Course
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('addCourse') }}" method="post">
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div>
                                                        <br />
                                                        @csrf
                                                        <label for="courseName"
                                                            class="">{{ __('Course Name') }}</label>
                                                        <input type="text" name="courseName" id="courseName" required>
                                                        
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div>
                                                        <br />
                                                        @csrf
                                                        <label for="courseCode"
                                                            class="">{{ __('Course Code') }}</label>
                                                        <input type="text" name="courseCode" id="courseCode" required>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary"
                                                    id="newProgramButtonModal">Add</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row border p-3 mb-3 text-light shadow rounded" style="background-color: #12355B">
                        <div class="col-md-3 text-center">
                            Course ID
                        </div>
                        <div class="col-md-3 ">
                            Course Name
                        </div>
                        <div class="col-md-3 ">
                            Course Code
                        </div>
                        <div class="col-md-3 text-center">
                            Edit
                        </div>
                    </div>
                    @foreach ($courseList as $course)
                        <div class="row border p-2">
                            <div class="col-md-3 text-center">
                                {{ $course->courseID }}
                            </div>
                            <div class="col-md-3 ">
                                {{ $course->courseName }}
                            </div>
                            <div class="col-md-3">
                                {{ $course->courseCode }}
                            </div>
                            <div class="col-md-3 text-center">
                                <a href="" class="btn text-light" style="background-color: #12355B"
                                    data-bs-toggle="modal" id="newCourseButton" data-bs-target="#courseEdit{{ $course->courseID }}">Edit</a>
                                <div class="modal fade" id="courseEdit{{ $course->courseID }}" tabindex="-1" aria-labelledby="courseEditLabel{{ $course->courseID }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="courseEditLabel{{ $course->courseID }}">
                                                    Edit course
                                                </h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('editCourse') }}" method="post">
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div>
                                                        <br />
                                                        @csrf
                                                        <label for="courseName"
                                                            class="">{{ __('Course Name') }}</label>
                                                        <input type="text" name="courseName" id="courseName" value="{{$course->courseName}}" required>
                                                        
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div>
                                                        <br />
                                                        @csrf
                                                        <label for="courseCode"
                                                            class="">{{ __('Course Code') }}</label>
                                                        <input type="text" name="courseCode" id="courseCode" value="{{$course->courseCode}}" required>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                                <div class="modal-footer">
                                                    <input type="hidden" name="courseID" value="{{$course->courseID}}">
                                                    <button type="submit" class="btn btn-primary"
                                                        id="newProgramButtonModal">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="row">
                <div class="container">
                    <div class="justify-content-md-center d-flex p-2 mt-1">
                        {!! $courseList->links() !!}
                    </div>
                </div>
            </div>
        @else
            <h1 class="mt-3">Course Edit</h1>
            <hr>
            <div class="row mt-3">
                <div class="col-md-8 offset-2 p-2 mt-4">
                    <div class="row border text-center">
                        <div class="col-md-4 ">
                            Course Name
                        </div>
                        <div class="col-md-4 ">
                            Course Code
                        </div>
                        <div class="col-md-4 ">
                            Edit
                        </div>
                    </div>

                </div>
                <div class="col-md-8 offset-2 p-2 mt-5 text-center">
                    <h1>No course</h1>
                    <form action="">
                        <button class="btn">Add course</button>
                    </form>
                </div>
            </div>
        @endif

    </div>
    <script>
        setTimeout(() => {
            const alert = document.getElementById('errorMessage');
            alert.style.display = 'none';
        }, 5000);
    </script>
@endsection
