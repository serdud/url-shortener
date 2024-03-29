@extends('layout.app')

@section('content')
    <div class="url_block">
        <div class="url_form">
            <form class="pure-form" id="url_form">
                <input type="text" class="pure-input-rounded" id="url_input" name="url" placeholder="Shorten your link" autocomplete="off" maxlength="2000" required />
                <button type="submit" class="pure-button" id="shorten_button">Shorten</button>
            </form>
        </div>
    </div>
@stop
