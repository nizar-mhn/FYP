@extends('layouts.admin')
<style>
    .sideBar {
        background-color: #56CBF9;
        height: 100vh;
    }

    .header {
        background-color: #12355B;
    }
</style>
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-2">
                <div class="sidebar pb-2">
                    <h2 class="text-light header text-center">
                        Menu
                    </h2>
                </div>
            </div>
            @php
                $programList = 1;
                $selectedProgram = 1;
                $courseList = 1;
            @endphp
            @if (!empty($programList))
                <div class="col-3 p-2 mt-4">
                    <div class="container">

                        <h1 class="">Program Edit</h1>
                        <form action="">
                            <h3>Program</h3>
                            <select class="form-select form-select-lg" name="programYear" aria-label="" style="width: 300px"
                                id="bindingTypeSelect">
                                <option value="1" selected>1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                            <h3>Year</h3>
                            <select class="form-select form-select-lg" name="programYear" aria-label=""
                                style="width: 300px" id="bindingTypeSelect">
                                <option value="1" selected>1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>

                            <h3 class="mt-3">Semester</h3>
                            <select class="form-select form-select-lg" name="programSem" aria-label="" style="width: 300px"
                                id="bindingTypeSelect">
                                <option value="1" selected>1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>

                            <button class="btn text-light mt-3" type="submit" style="background-color:#E76F51"><i
                                    class="bi bi-search me-2"></i>Search</button>
                            <a href="" class="btn text-light mt-3 ms-4" style="background-color:#E76F51"><i
                                    class="bi bi-plus-circle me-2"></i>Add Program</a>
                        </form>
                    </div>
                </div>
                <div class="col-5 offset-1 p-2 mt-4">
                    @if (!empty($selectedProgram))
                        @if (!empty($courseList))
                            <div class="container">
                                <h3 class="mt-5">Course List</h3>
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
                                <hr>
                                <form action="">
                                    <select class="form-select form-select-lg" name="programSem" aria-label=""
                                        style="width: 300px" id="bindingTypeSelect">
                                        <option value="1" selected>1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                    <button href="" class="btn text-light mt-3" style="background-color:#E76F51"><i
                                            class="bi bi-send-plus-fill me-2"></i>Add Course</button>
                                    <button type="button" class="btn uploadButton text-light mt-3" data-bs-toggle="modal"
                                        id="uploadButton" onclick="showModalUpload()" data-bs-target="#uploadModal"
                                        style="background-color:#E76F51"><i class="bi bi-plus-square me-2"></i>Add new
                                        course</button>
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
                                                        <button type="submit" class="btn btn-primary" id="uploadBtnModal"
                                                            onclick="hideAfterUpload()">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        @else
                        <div class="container">
                            <h3 class="mt-5">Course List</h3>
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
                            <h4 class="text-center mt-4 fw-bold mb-5">No courses found</h4>
                            <hr>
                                <form action="">
                                    <select class="form-select form-select-lg" name="programSem" aria-label=""
                                        style="width: 300px" id="bindingTypeSelect">
                                        <option value="1" selected>1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                    <button href="" class="btn text-light mt-3" style="background-color:#E76F51"><i
                                            class="bi bi-send-plus-fill me-2"></i>Add Course</button>
                                    <button type="button" class="btn uploadButton text-light mt-3" data-bs-toggle="modal"
                                        id="uploadButton" onclick="showModalUpload()" data-bs-target="#uploadModal"
                                        style="background-color:#E76F51"><i class="bi bi-plus-square me-2"></i>Add new
                                        course</button>
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
                                                        <button type="submit" class="btn btn-primary" id="uploadBtnModal"
                                                            onclick="hideAfterUpload()">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                        </div>
                        @endif
                    @else
                        <div class="container">
                            <h3 class="mt-5">Course List</h3>
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
                <div class="col-3 p-2 mt-4">
                    <h1>No Programs</h1>
                    <a href="" class="btn text-light mt-3" style="background-color:#E76F51"><i
                            class="bi bi-plus-circle me-2"></i>Add Program</a>
                </div>
            @endif
        </div>
    </div>
@endsection
