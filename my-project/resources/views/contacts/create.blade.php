@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 text-center ">
            @if(Session::has('message'))
            <div class="row mb-3">
                <p class="alert {{ Session::get('alert-class', 'alert-info') }}"> <strong>{{ Session::get('message') }}</strong></p>
            </div>
            @endif
            @if(Session::has('error'))
            <div class="row mb-3">
                <p class="alert {{ Session::get('alert-class', 'alert-warning') }}"> <strong>{{ Session::get('error') }}</strong></p>
            </div>
            @endif
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ ($form_action ==='new') ? __('Contacts') : __('Edit contact') . ' #'. $edit_contact->id }}</div>


                <div class="card-body">
                    <form method="POST" action="{{  ($form_action ==='new') ? route('contact') : route('contact.edit', [ $edit_contact->id]) }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('* Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ isset($edit_contact) ? $edit_contact->name : old('name')  }}" required autocomplete="false" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('* Email') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ isset($edit_contact) ? $edit_contact->email : old('email') }}" required autocomplete="false">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class=" row mb-3">
                            <label for="phone_number" class="col-md-4 col-form-label text-md-end">{{ __('* Phone') }}</label>

                            <div class="col-md-6">
                                <input id="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ isset($edit_contact) ? $edit_contact->phone_number : old('phone_number')}}" required autocomplete="false">

                                @error('phone_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <input type="hidden" name="form_action" value="{{ ('edit'===$form_action) ? 'save_changes' : 'new'  }}" />
                                <button type="submit" class="btn {{ ($form_action ==='new') ? 'btn-primary' : 'btn-danger' }}">
                                    {{ ($form_action ==='new') ? __('New Contact') : __('Save Contact') }}
                                </button>
                                @if ($form_action ==='edit')
                                <input type="hidden" value="{{ $edit_contact->id }}" name="id" />
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @if(is_array($contact_list) && count($contact_list) > 0)
        <div class=" row mb-3">
            <div class="col-md-12"> &nbsp;
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Contact Listing') }}</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th width="5%">Edit</th>
                                <th width="5%">Delete</th>
                            </tr>
                            @for ($i = 0; $i < count($contact_list); $i++) <tr>
                                <td>{{ $contact_list[$i]['id']}}</td>
                                <td>{{ $contact_list[$i]['name']}}</td>
                                <td>{{ $contact_list[$i]['email']}}</td>
                                <td>{{ $contact_list[$i]['phone_number']}}</td>
                                <td>
                                    <form method="POST" action="{{ route('contact.edit', [$contact_list[$i]['id']]) }}">
                                        @csrf
                                        <input type="hidden" name="form_action" value="edit" />
                                        <button type="submit" class="btn btn-primary btn-sm">Edit</button>
                                    </form>
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('contact.delete') }}" onsubmit="return confirm('Do you really want to delete #{{ $contact_list[$i]["id"]}}?');">
                                        @csrf
                                        <input type="hidden" name="delete_id" value="{{ $contact_list[$i]['id']}}" />
                                        <input type="hidden" name="form_action" value="delete" />
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                                </tr>
                                @endfor
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
