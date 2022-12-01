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
                    </div>
                    <div class="ms-auto dropdown">
                        <button type="button" class="btn uploadButton text-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Upload</button>
                        <ul class="dropdown-menu">
                            <li><button type="button" class="btn text-wrap dropdown-item">File Upload</button></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><button type="button" class="btn text-wrap dropdown-item" onclick="pickerDialog()">Google Drive Upload</button></li>
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

@endsection
@push('scripts')
    <script>
        var clientID = '984571528719-5klivvs955pte6vctv52us32pmtd4t90.apps.googleusercontent.com'
        var apiKey = 'AIzaSyCy_O5QlJzeQ-AjlDrOmkhAy9idRwDctx0'
        var projectID = '984571528719'
        var oauthtoken
        var pickerApiLoaded = false
    
        //scope for google drive
        var scope = 'https://www.googleapis.com/auth/drive.file';
    
        //client library google
        function pickerDialog(){
            loadPicker()
        }
    
        function loadPicker(){
            gapi.load('auth',{'callback':onAuthApiLoad})
            gapi.load('picker',{'callback':onPickerApiLoad})
        }
    
        function onAuthApiLoad(){
            window.gapi.auth.authorize({
                'client_id': clientID,
                'scope':scope,
                'immediate':false
            },
            handleAuthResult
            )
        }
    
        function handleAuthResult(authResult){
            //Access token
            if(authResult && !authResult.error){
                oauthToken = authResult.access_token
                createPicker()
            }
        }
    
        function onPickerApiLoad(){
            pickerApiLoaded = true
            createPicker()
        }
    
        function createPicker(){
            if(pickerApiLoaded && oauthtoken){
                var view = new google.picker.View(google.picker.ViewId.DOCS)
                view.setMimeTypes('image/png,image/jpeg,image/jpg');
                var picker = new google.picker.PickerBuilder()
                .enableFeature(google.picker.Feature.NAV_HIDDEN)
                .setAppId(project_id)
                .setOAuthToken(oauthtoken)
                .addView(view)
                .addView(new google.picker.DocsUploadView())
                .setDeveloperKey(apiKey)
                .setCallback(pickerCallback)
                .build()
                
                picker.setVisible(true)
    
            }
        }
        
    </script>

@endpush