@extends('layouts.app')
@section('content')

<div class="row container">
    @if ($documents->count())
    <h3>Documents</h3>
    <div>
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <td>Name</td>
                    <td></td>
                    <td></td>
                </tr>
            </thead>
            <tbody>

                @foreach ($documents as $document)
                <tr>
                    <td>{{$document->fileName}} {{ $document->noPage }}</td>
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

<form action="{{ route('document.update') }}" method="post" enctype="multipart/form-data">
    <div class="row">
        <div>
            <br />
            @csrf
            <div class="form-group">
                <input type="file" class="form-control" name="file" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</form>
@endsection