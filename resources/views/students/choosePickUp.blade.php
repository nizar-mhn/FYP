@extends('layouts.app')
<style>
    .imageMapSchool{
        width: 500px;
        height: 600px;
        object-fit: contain;
    }

    .submitBtn{
        background-color: #E76F51 !important;
    }

    .submitBtn:hover{
        background-color: #F4A261 !important;
    }
</style>
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-6 pb-2">
                <img class="imageMapSchool thumbnail border border-3" src="../image/MapBlocks/schoolMapSelfPickup.png" id="locationMap">
            </div>
            <div class="col-lg-6">
                <h1 class="fw-bold">Choose delivery location</h1>
                <hr>
                <form action="" method="POST">
                    <select class="form-select form-select-lg" name="deliveryLocation" aria-label="" style="width: 300px" id="mapLocationSelect">
                        <option value="SelfPickUp" selected>Self Pickup (Red Bricks)</option>
                        <option value="Block_K">Block K</option>
                        <option value="Block_H">Block H</option>
                        <option value="Block_M">Block M</option>
                        <option value="Block_C">Block C</option>
                        <option value="Block_R">Block R</option>
                    </select>
                    <div class="row">
                        <div class="col-lg-4 mt-5">
                            <button class="btn submitBtn text-light" type="submit">
                                Continue to Payment >>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        const locationSelect = document.getElementById("mapLocationSelect");

        locationSelect.addEventListener("change",function(){
            document.getElementById("locationMap").src = "../image/MapBlocks/schoolMap"+ locationSelect.value + ".png";
        })
    </script>
@endsection
