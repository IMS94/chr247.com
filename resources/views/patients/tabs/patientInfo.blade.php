<div class="container-fluid">
    <div class="row">

        <div class="col-md-6 panel">
            <div class="row">
                <label class="col-md-4">Name</label>
                <div class="col-md-8">{{$patient->first_name}} {{$patient->last_name}}</div>
            </div>
            <div class="row">
                <label class="col-md-4">Age</label>
                <div class="col-md-8">{{Utils::getAge($patient->dob)}}</div>
            </div>
            <div class="row">
                <label class="col-md-4">Address</label>
                <div class="col-md-8">{{$patient->address}}</div>
            </div>
            <div class="row">
                <label class="col-md-4">Gender</label>
                <div class="col-md-8">{{$patient->gender}}</div>
            </div>
            <div class="row">
                <label class="col-md-4">NIC</label>
                <div class="col-md-8">{{$patient->nic}}</div>
            </div>
            <div class="row">
                <label class="col-md-4">Contact No.</label>
                <div class="col-md-8">{{$patient->phone}}</div>
            </div>
            <div class="row">
                <label class="col-md-4">Registered on</label>
                <div class="col-md-8">{{Utils::getTimestamp($patient->created_at)}}</div>
            </div>

        </div>

        <div class="col-md-6 panel">
            <div class="row">
                <label class="col-md-4">Blood Group</label>
                <div class="col-md-8">{{$patient->blood_group}}</div>
            </div>
            <div class="row">
                <label class="col-md-4">Remarks</label>
                <div class="col-md-8">{{$patient->remarks?:'-'}}</div>
            </div>
            <div class="row">
                <label class="col-md-4">Allergies</label>
                <div class="col-md-8">{{$patient->allergies}}</div>
            </div>
            <div class="row">
                <label class="col-md-4">Family History</label>
                <div class="col-md-8">{{$patient->family_history}}</div>
            </div>
            <div class="row">
                <label class="col-md-4">Medical History</label>
                <div class="col-md-8">{{$patient->medical_history}}</div>
            </div>
            <div class="row">
                <label class="col-md-4">Surgical history</label>
                <div class="col-md-8">{{$patient->post_surgical_history}}</div>
            </div>
        </div>

    </div>
</div>