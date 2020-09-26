@extends('layouts.app')

@section('title','SMS verification form')
@section('content')
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-inset  border-0">
                        <div class="card-header bg-white">
                            <h3 class="title  text-center">@lang($page_title) </h3>
                        </div>
                        <div class="card-body">

                            <form method="POST" action="{{route('user.verify_email')}}" class="contact-form mb-4">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input class="form-control" type="email" name="email"  readonly value="{{auth()->user()->email}}">
                                        </div>

                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input class="form-control"  name="email_verified_code" placeholder="Code">
                                            @if ($errors->has('email_verified_code'))
                                                <small class="text-danger">{{ $errors->first('email_verified_code') }}</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-12 pt-4">
                                        <button class="cmn-btn btn-block btn-info" type="submit">@lang('Submit')</button>
                                    </div>
                                </div>

                            </form>

                            @lang('When don\'t sent any code your email') <a class="btn-link" href="{{route('user.send_verify_code')}}?type=email"> @lang('Resend code')</a>
                            @if ($errors->has('resend'))
                                <br/>
                                <small class="text-danger">{{ $errors->first('resend') }}</small>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
        
@endsection
