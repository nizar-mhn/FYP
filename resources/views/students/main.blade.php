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
                    <button class="nav-link subjectNav text-light active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">ABSC3211</button>
                    <button class="nav-link subjectNav text-light" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">BSCS412</button>
                    <button class="nav-link subjectNav text-light" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">PLKS423</button>
                    <button class="nav-link subjectNav text-light ms-auto text-light" id="nav-personalFiles-tab" data-bs-toggle="tab" data-bs-target="#nav-personalFiles" type="button" role="tab" aria-controls="nav-personalFiles" aria-selected="false">Personal</button>
                    
                </div>
            </nav>
            <!--<div class="d-flex p-1" style="background-color: #264653; height: 45px">
                <div class="me-auto subjectButtons nav nav-tabs">
                    <button type="button" class="btn text-light text-wrap nav-link active">A2BS</button>
                    <button type="button" class="btn text-light text-wrap nav-link">A3BS</button>
                    <a href="" id="result"></a>
                </div>
                <div class="ms-auto dropdown">
                    <button type="button" class="btn uploadButton text-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Upload</button>
                    <ul class="dropdown-menu">
                    

                        <li><a href="{{ url('/documents/uploadFile/') }}" class="btn dropdown-item">File Upload</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><button type="button" class="btn text-wrap dropdown-item disabled" onclick="createPicker()">Google Drive Upload</button></li>
                    </ul>
                </div>
            </div>-->
            <!--<div class="container-fluid" style="background-color:#264653; height: 10px">
            </div>-->
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
                <div>
                    @php
                      $id = session()->get('img');
                    @endphp
                    <img src="data:image/png;base64,{{ $id }}" style="height: 100px;width:100px">
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

                                @php
                                    /*$documentEncoded = base64_encode($document);

                                    
                                    var_dump($document);
                                    $pdf = new Spatie\PdfToImage\Pdf($document); 
                                    $pageNum = $pdf->getNumberOfPages();
                                    $pdf->saveImage('D:\Documents\FYP\FYP\public\image');

                                    
                                    
                                    $num = preg_match_all("/\/Page\W/", $document, $dummy);*/
                                @endphp

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
        <div class="col"></div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let tokenClient;
    let accessToken = null;
    let pickerInited = false;
    let gisInited = false;

    function onApiLoad() {
        gapi.load('picker', onPickerApiLoad);
    }

    function onPickerApiLoad() {
        pickerInited = true;
    }

    function gisLoaded() {
        // TODO(developer): Replace with your client ID and required scopes
        tokenClient = google.accounts.oauth2.initTokenClient({
            client_id: '984571528719-5klivvs955pte6vctv52us32pmtd4t90.apps.googleusercontent.com',
            scope: 'https://www.googleapis.com/auth/drive.file',
            callback: '', // defined later
        });
        gisInited = true;
    }

    function createPicker() {
        const showPicker = () => {
            const view = new google.picker.View(google.picker.ViewId.DOCS);
            // TODO(developer): Replace with your API key
            const picker = new google.picker.PickerBuilder()
                .enableFeature(google.picker.Feature.NAV_HIDDEN)
                .addView(view)
                .setOAuthToken(accessToken)
                .setDeveloperKey('AIzaSyCy_O5QlJzeQ-AjlDrOmkhAy9idRwDctx0')
                .setCallback(pickerCallback)
                .build();
            picker.setVisible(true);
        }

        // Use Google Identity Services to request an access token
        tokenClient.callback = async (response) => {
            if (response.error !== undefined) {
                throw (response);
            }
            accessToken = response.access_token;
            showPicker();
        };

        if (accessToken === null) {
            // Prompt the user to select a Google Account and ask for consent to share their data
            // when establishing a new session.
            tokenClient.requestAccessToken({
                prompt: 'consent'
            });
        } else {
            // Skip display of account chooser and consent dialog for an existing session.
            tokenClient.requestAccessToken({
                prompt: ''
            });
        }
    }

    // A simple callback implementation.
    function pickerCallback(data) {
        let url = 'nothing';
        if (data[google.picker.Response.ACTION] == google.picker.Action.PICKED) {
            let doc = data[google.picker.Response.DOCUMENTS][0];
            url = doc[google.picker.Document.ID];
        }
        let message = `You picked: ${url}`;
        document.getElementById('result').innerText = message;
    }
</script>
<script async defer src="https://apis.google.com/js/api.js" onload="onApiLoad()"></script>
<script async defer src="https://accounts.google.com/gsi/client" onload="gisLoaded()"></script>
@endpush