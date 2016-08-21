@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Connect</div>
                <div class="panel-body">                    
                    <div class="row">
                        @foreach(RMF\Models\SocialSite::active()->get() as $site)
                            <div class="col-md-6 col-lg-4" style="margin-bottom:10px;">
                                <a 
                                    class="btn btn-block btn-social btn-{{ $site->class }}"
                                    href="{{ route('auth.social.redirect', ['provider' => $site->class ]) }}"
                                >
                                    <span class="fa fa-{{ $site->button }}"></span>
                                    Connect with {{ $site->name }}
                                </a>    
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
