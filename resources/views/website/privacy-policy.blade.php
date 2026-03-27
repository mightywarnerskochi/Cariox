@extends('website.layouts.app')

@section('content')
<div class="inner-vector">
    <picture><img src="{{ asset('assets/images/inner/inner-vector.png') }}" alt="Privacy & Policy"></picture>
</div>
<section class="inner-banner legal-banner">
    <div class="container-ctn w-100">
        <div class="content">
            <h1 class="title">Privacy Policy</h1>
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ url('/') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                        <path d="M12 12.75H6M2.25 8.9925V10.875C2.25 13.35 2.25 14.5875 3.01875 15.3563C3.7875 16.125 5.025 16.125 7.5 16.125H10.5C12.975 16.125 14.2125 16.125 14.9813 15.3563C15.75 14.5875 15.75 13.35 15.75 10.875V8.9925C15.75 7.731 15.75 7.101 15.483 6.555C15.216 6.009 14.718 5.622 13.7235 4.848L12.2235 3.68175C10.6748 2.47725 9.9 1.875 9 1.875C8.1 1.875 7.32525 2.47725 5.7765 3.68175L4.2765 4.848C3.28125 5.622 2.784 6.009 2.517 6.555C2.25 7.101 2.25 7.731 2.25 8.9925Z" stroke="black" stroke-width="1.125" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Home
                </a>
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                        <path d="M4.5 10.125H7.875V11.25H4.5V10.125ZM4.5 12.375H10.125V13.5H4.5V12.375Z" fill="#F04149"/>
                        <path d="M14.625 2.25H3.375C3.07677 2.25045 2.79088 2.36912 2.58 2.58C2.36912 2.79088 2.25045 3.07677 2.25 3.375V14.625C2.25045 14.9232 2.36912 15.2091 2.58 15.42C2.79088 15.6309 3.07677 15.7496 3.375 15.75H14.625C14.9232 15.7496 15.2091 15.6309 15.42 15.42C15.6309 15.2091 15.7496 14.9232 15.75 14.625V3.375C15.7496 3.07677 15.6309 2.79088 15.42 2.58C15.2091 2.36912 14.9232 2.25045 14.625 2.25ZM10.125 3.375V5.625H7.875V3.375H10.125ZM3.375 14.625V3.375H6.75V6.75H11.25V3.375H14.625L14.6256 14.625H3.375Z" fill="#F04149"/>
                    </svg>
                    Privacy Policy
                </span>
            </nav>
        </div>
    </div>
</section>

<section class="policy">
    <div  class="container-content features-list">
        <div class="container-ctn">
            {!! $siteSetting->privacy_policy ?? '<p>Please contact our support for our full Privacy and Policy document.</p>' !!}
        </div>
    </div>
</section>
@endsection