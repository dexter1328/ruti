

<div class="tab-pane fade" id="profile">
    @if ($errors->any())
    <div class="alert alert-danger container">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <div class="col">
        <div class="row">
          <div class="col mb-3">
            <div class="card">
              <div class="card-body">
                <div class="e-profile">
                  <div class="row">
                    <div class="col-12 col-sm-auto mb-3">
                      <div class="mx-auto" style="width: 140px;">
                        <div class="d-flex justify-content-center align-items-center rounded" style="height: 140px; background-color: rgb(233, 236, 239);">
                          <span style="color: rgb(166, 168, 170); font: bold 8pt Arial;">
                            @if (Auth::guard('w2bcustomer')->user()->image)
                            <img class="rounded-circle" src="{{asset('public/user_photo/'.Auth::guard('w2bcustomer')->user()->image)}}"  alt="">
                            @else
                            <i class="lnr lnr-user fa-3x d-flex"></i>
                            @endif
                         </span>
                        </div>
                      </div>
                    </div>
                    <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                      <div class="text-center text-sm-left mb-2 mb-sm-0">
                        <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap">{{Auth::guard('w2bcustomer')->user()->first_name}} {{Auth::guard('w2bcustomer')->user()->last_name}}</h4>
                        <p class="mb-0">{{Auth::guard('w2bcustomer')->user()->email}}</p>
                        {{-- <div class="text-muted"><small>Last seen 2 hours ago</small></div> --}}
                        {{-- <div class="mt-2">
                          <button class="btn btn-primary" type="button">
                            <i class="fa fa-fw fa-camera"></i>
                            <span>Change Photo</span>
                          </button>
                        </div> --}}
                      </div>
                      <div class="text-center text-sm-right">
                        {{-- <span class="badge badge-secondary">administrator</span> --}}
                        <div class="text-muted"><small>Joined {{  \Carbon\Carbon::parse(Auth::guard('w2bcustomer')->user()->created_at)->format('d M, Y')}}</small></div>
                      </div>
                    </div>
                  </div>
                  <ul class="nav nav-tabs">
                    <li class="nav-item"><a href class="active nav-link">Settings</a></li>
                  </ul>
                  <div class="tab-content pt-3">
                    <div class="tab-pane active">
                      <form class="form" action="{{ route('user-profile-update',$user->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                        <div class="row">
                          <div class="col">
                            <div class="row">
                              <div class="col">
                                <div class="form-group">
                                  <label>First Name</label>
                                  <input class="form-control" type="text" name="first_name" placeholder="Enter First Name" value="{{ $user->first_name }}">
                                </div>
                              </div>
                              <div class="col">
                                <div class="form-group">
                                  <label>Last Name</label>
                                  <input class="form-control" type="text" name="last_name" placeholder="Enter Last Name" value="{{ $user->last_name }}">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                  <div class="form-group">
                                    <label>Phone No</label>
                                    <input class="form-control" type="text" name="mobile" placeholder="Enter Phone No" value="{{ $user->mobile }}">

                                  </div>
                                </div>
                              </div>
                            <div class="row">
                              <div class="col mb-3">
                                <div class="form-group">
                                  <label>Address</label>
                                  <textarea class="form-control" rows="3" name="address" placeholder="Enter Your Address" value="">{{ $user->address }}</textarea>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                  <div class="form-group">
                                    <label>About</label>
                                    <textarea class="form-control" rows="5" name="about" value="" placeholder="Enter Your Bio">{{ $user->about }}</textarea>
                                  </div>
                                </div>
                            </div>
                            <div class="row" style="margin:0">
                                <div class="col mb-3">
                                  <div class="form-group">
                                    <input type="file" name="image" class="form-control custom-file-input" id="customFile" >
                                    <label class="custom-file-label" for="customFile">Change Profile Image</label>
                                   </div>
                                </div>
                              </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12 mb-3">
                            <div class="mb-2"><b>Change Password</b></div>

                            <div class="form-group">
                                <label for="input-13" class="col-form-label">Password</label>
                                <div>
                                    <input type="password" id="password" name="password" class="form-control"  placeholder="Enter New Password" >
                                    {{-- <span toggle="#password" class="fa fa-eye field-icon toggle-password"></span> --}}
                                </div>
                                <label for="input-13" class="col-form-label">Confirm Password</label>
                                <div>
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"   placeholder="Confirm New Password">
                                    {{-- <span class="confirm-check fa"></span> --}}

                                </div>
                            </div>
                          </div>

                        </div>
                        <div class="row">
                          <div class="col d-flex justify-content-end">
                            <button class="btn btn-primary" type="submit">Save Changes</button>
                          </div>
                        </div>
                      </form>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-12 col-md-3 mb-3">
            <div class="card mb-3">
              <div class="card-body">
                <div class="px-xl-3">
                  <button class="btn btn-block btn-secondary">
                    <i class="fa fa-sign-out"></i>
                    <span>Logout</span>
                  </button>
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-body">
                <h6 class="card-title font-weight-bold">Support</h6>
                <p class="card-text">Get fast, free help from our friendly assistants.</p>
                <button type="button" class="btn btn-primary">Contact Us</button>
              </div>
            </div>
          </div>
        </div>

      </div>
</div>
