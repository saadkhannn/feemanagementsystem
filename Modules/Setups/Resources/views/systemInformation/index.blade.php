@extends('layouts.index')

@section('content')
<div class="card" style="margin-bottom: 25px;">
    <div class="card-header bg-info text-white" style="cursor: pointer;">
        <h4>
        	<strong>System Information</strong>
        </h4>
    </div>
    <div class="card-body">
        <form action="{{ route('system-information.store') }}" method="post" id="crud-form" enctype="multipart/form-data">
        @csrf
            <div class="row">
              <div class="col-md-8">
                  <div class="form-group row">
                    <div class="col-md-6">
                      <label for="name"><strong>Name :</strong></label>
                      <input type="text" class="form-control" name="name" value="{{$information->name}}" id="name">
                    </div>
                    <div class="col-md-6">
                      <label for="email"><strong>Email :</strong></label>
                      <input type="text" class="form-control" name="email" value="{{$information->email}}" id="email">
                    </div>
                  </div>
                  <div class="form-group row mb-1">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="description"><strong>Description :</strong></label>
                        <textarea rows="4" class="form-control" name="description" id="description" style="resize: none">{{$information->description}}</textarea>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="address"><strong>Address :</strong></label>
                        <textarea rows="4" class="form-control" name="address" id="address" style="resize: none">{{$information->address}}</textarea>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row mb-01">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="motto"><strong>Motto :</strong></label>
                        <input type="text" class="form-control" name="motto" value="{{$information->motto}}" id="motto">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="tagline"><strong>Tagline :</strong></label>
                        <input type="text" class="form-control" name="tagline" value="{{$information->tagline}}" id="tagline">
                      </div>
                    </div>
                  </div>
              </div>
              <div class="col-md-4">
                <div class="form-group row">
                  <div class="col-md-6 mb-3">
                    <label for="twitter"><strong>Twitter :</strong></label>
                    <input type="text" class="form-control" name="twitter" value="{{$information->twitter}}" id="twitter">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="facebook"><strong>Facebook :</strong></label>
                    <input type="text" class="form-control" name="facebook" value="{{$information->facebook}}" id="facebook">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="instagram"><strong>Instagram :</strong></label>
                    <input type="text" class="form-control" name="instagram" value="{{$information->instagram}}" id="instagram">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="skype"><strong>Skype :</strong></label>
                    <input type="text" class="form-control" name="skype" value="{{$information->skype}}" id="skype">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="linked_in"><strong>Linked In :</strong></label>
                    <input type="text" class="form-control" name="linked_in" value="{{$information->linked_in}}" id="linked_in">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="website"><strong>Website :</strong></label>
                    <input type="text" class="form-control" name="website" value="{{$information->website}}" id="linked_in">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="phone"><strong>Phone :</strong></label>
                    <input type="text" class="form-control" name="phone" value="{{$information->phone}}" id="phone">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="mobile"><strong>Mobile :</strong></label>
                    <input type="text" class="form-control" name="mobile" value="{{$information->mobile}}" id="mobile">
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                  <div class="form-group row">
                    <div class="col-md-12">
                      <div class="row">
                        <div class="col-md-5">
                          <label for="logo"><strong>Current Logo :</strong></label>
                          <br>
                          <img src="{{ url('system-images/logos/'.session()->get('system-information')->logo) }}" class="mt-4 pt-2 img img-fluid">
                        </div>
                        <div class="col-md-5">
                          <label for="secondary_logo"><strong>Current Secondary Logo :</strong></label>
                          <br>
                          <img src="{{ url('system-images/secondary-logos/'.session()->get('system-information')->secondary_logo) }}" class="mt-4 pt-2 img img-fluid">
                        </div>
                        <div class="col-md-2">
                          <label for="icon"><strong>Current Icon :</strong></label>
                          <br>
                          <img src="{{ url('system-images/icons/'.session()->get('system-information')->icon) }}" class="img img-fluid" style="width: 25%">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-md-12">
                      <div class="row">
                        <div class="col-md-5">
                          <label for="logo_file"><strong>New Logo :</strong></label>
                          <input type="file" class="form-control" name="logo_file" id="logo_file">
                        </div>
                        <div class="col-md-5">
                          <label for="secondary_logo_file"><strong>New Secondary Logo :</strong></label>
                          <input type="file" class="form-control" name="secondary_logo_file" id="secondary_logo_file">
                        </div>
                        <div class="col-md-2">
                          <label for="icon_file"><strong>New Icon :</strong></label>
                          <input type="file" class="form-control" name="icon_file" id="icon_file">
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save"></i>&nbsp; Update</button>
            </div>
        </form>
    </div>
</div>
@endsection