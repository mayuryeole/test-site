@extends('layouts.app')

@section('meta')
    <title>Mode Of Contact</title>
@endsection
@section('header')
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/media/front/css/twilio-chat/main.css">
@endsection
<section class="account-setting">
    <div class="container">

        {{--<div id="login" class="popup">--}}
        {{--<h3>Log In</h3>--}}
        {{--<input id="login-name" placeholder="Identity"></input>--}}
        {{--<button id="login-button" class="red-button">Log In As Guest</button>--}}
        {{--<p>-or-</p>--}}
        {{--<div class="g-signin2" data-onsuccess="googleLogIn" data-theme="light"></div>--}}
        {{--</div>--}}
        <input type="hidden" id="login-name" value="ramesh">
        {{--<input type="hidden" id="add-identity" value="swapnil" />--}}
        <div id="add-member" class="popup">
            <h3>Add User<div class="remove-button glyphicon glyphicon-remove"></div></h3>
            <input id="add-identity" placeholder="Identity"></input>
            <button id="add-button" class="red-button">Add</button>
        </div>
        {{--<div id="invite-member" class="popup">--}}
        {{--<h3>Invite User<div class="remove-button glyphicon glyphicon-remove"></div></h3>--}}
        {{--<input id="invite-identity" placeholder="Identity"></input>--}}
        {{--<button id="invite-button" class="red-button">Invite</button>--}}
        {{--</div>--}}
        {{--<div id="update-channel" class="popup">--}}
        {{--<h3>Edit Channel<div class="remove-button glyphicon glyphicon-remove"></div></h3>--}}
        {{--<input id="update-channel-display-name" placeholder="Display Name"/>--}}
        {{--<input id="update-channel-unique-name" placeholder="Unique Name (Optional)"/>--}}
        {{--<input id="update-channel-desc" placeholder="Description (Optional)"/>--}}
        {{--<input disabled="true" type="checkbox" id="update-channel-private"/><label>Private Channel</label>--}}
        {{--<button id="update-channel-submit" class="red-button">Update Channel</button>--}}
        {{--</div>--}}
        {{--<div id="create-channel" class="popup">--}}
        {{--<h3>Create Channel<div class="remove-button glyphicon glyphicon-remove"></div></h3>--}}
        {{--<input id="create-channel-display-name" placeholder="Display Name"/>--}}
        {{--<input id="create-channel-unique-name" placeholder="Unique Name (Optional)"/>--}}
        {{--<input id="create-channel-desc" placeholder="Description (Optional)"/>--}}
        {{--<input type="checkbox" id="create-channel-private"/><label>Private Channel</label>--}}
        {{--<button id="create-new-channel" class="red-button">Create Channel</button>--}}
        {{--</div>--}}

        <div id="overlay"></div>
        <div id="sidebar">
            <div id="profile">
                <img></img>
                <label></label>
                <div id="presence"></div>
            </div>
            <div id="channels">
                <div id="invited-channels">
                    <ul></ul>
                </div>
                <div id="my-channels">
                    <ul></ul>
                </div>
                <div id="known-channels">
                    <ul></ul>
                </div>
                <div id="public-channels">
                    <ul></ul>
                </div>
                <div id="sidebar-footer">
                    <button id="create-channel-button" class="red-button">Create Channel</button>
                </div>
            </div>
        </div>

        <div id="no-channel">
            <p>You are not currently viewing a Channel.</p>
        </div>

        <div id="channel">
            <div id="channel-info">
                <h1 id="channel-title"></h1>
                <h2 id="channel-desc"></h2>
                <button id="edit-channel" class="white-button">Edit Channel</button>
                <button id="delete-channel" class="red-button">Delete Channel</button>
            </div>
            <div id="channel-body">
                <div id="channel-chat">
                    <div id="channel-messages"><ul></ul></div>
                    <div id="channel-message-send">
                        <div id="typing-indicator"><span></span></div>
                        <input type="textbox" id="message-body-input"></input>
                        <button id="send-message" class="red-button">Send</div>
                </div>
                <div id="channel-join-panel">
                    <button id="join-channel" class="red-button">Join this Channel</div>
            </div>
            <div id="channel-members">
                <h3>Members</h3>
                <button id="add-user" class="red-button">Add</button>
                {{--<button id="invite-user" class="red-button">Invite</button>--}}
                <ul></ul>
            </div>
        </div>

    </div>
</section>
@section('footer')
    <script src="{{ url('/') }}/media/front/js/twilio-chat/vendor/fingerprint2.js"></script>
    <script src="{{ url('/') }}/media/front/js/twilio-chat/vendor/superagent.js"></script>

    <script src="https://media.twiliocdn.com/sdk/js/common/v0.1/twilio-common.min.js"></script>
    <script src="https://media.twiliocdn.com/sdk/js/chat/v1.0/twilio-chat.min.js"></script>

    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <script type="text/javascript" src="{{ url('/') }}/media/front/js/twilio-chat/md5.js"></script>
    <script type="text/javascript" src="{{ url('/') }}/media/front/js/twilio-chat/index.js"></script>
@endsection