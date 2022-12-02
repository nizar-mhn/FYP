@extends('layouts.app')
<!-- Style -->
<Style>
    .uploadButton{
        background-color: #E76F51 !important; 
    }
    .uploadButton:hover{
        background-color: #F4A261 !important; 
    }
    .subjectButtons button:hover{
        background-color: #2A9D8F !important;
    }
</Style>

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col"></div>
            <div class="col-8">
                <h1 class="fw-bold mb-5">My Files</h1>
                <div class="d-flex p-1" style="background-color: #264653; height: 45px">
                    <div class="me-auto subjectButtons">
                        <button type="button" class="btn text-light text-wrap ">A2BS-something</button>
                        <button type="button" class="btn text-light text-wrap ">A3BS-something</button>
                        <a href="" id="result"></a>
                    </div>
                    <div class="ms-auto dropdown">
                        <button type="button" class="btn uploadButton text-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Upload</button>
                        <ul class="dropdown-menu">
                            <li><button type="button" class="btn text-wrap dropdown-item">File Upload</button></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><button type="button" class="btn text-wrap dropdown-item" onclick="createPicker()">Google Drive Upload</button></li>
                        </ul>
                    </div>
                </div>
                <div class="container-fluid" style="background-color: #2A9D8F; height: 10px">
                </div>
                <div class="container mt-3" style="height: 450px; background-color:#264653">
                    
                </div>
            </div>
            <div class="col"></div>
        </div>
    </div>

    /* var clientID = '984571528719-5klivvs955pte6vctv52us32pmtd4t90.apps.googleusercontent.com'
    var apiKey = 'AIzaSyCy_O5QlJzeQ-AjlDrOmkhAy9idRwDctx0'
    var projectID = '984571528719'
    var oauthtoken
    var pickerApiLoaded = false

    //scope for google drive
    var scope = 'https://www.googleapis.com/auth/drive.file'; */
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
                    tokenClient.requestAccessToken({prompt: 'consent'});
                } else {
                    // Skip display of account chooser and consent dialog for an existing session.
                    tokenClient.requestAccessToken({prompt: ''});
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