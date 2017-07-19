@php
    $locales = array_keys(LaravelLocalization::getSupportedLocales());
@endphp

{{-- title --}}
<div class="field">
    {{ Form::label('title', 'Title', ['class' => 'label']) }}
    <div class="control input-box">
        <div class="select toggle-locale">
            <select v-model="title">
                @foreach ($locales as $code)
                    <option value="{{ $code }}">{{ $code }}</option>
                @endforeach
            </select>
        </div>
        @foreach ($locales as $code)
            <input type="text" name="title[{{ $code }}]" class="input" v-show="showTitle('{{ $code }}')" placeholder="Some Title">
        @endforeach
    </div>
    @if($errors->has('title'))
        <p class="help is-danger">
            {{ $errors->first('title') }}
        </p>
    @endif
</div>

{{-- body --}}
<div class="field">
    {{ Form::label('body', 'Body', ['class' => 'label']) }}
    <div class="control input-box">
        <div class="select toggle-locale">
            <select v-model="body">
                @foreach ($locales as $code)
                    <option value="{{ $code }}">{{ $code }}</option>
                @endforeach
            </select>
        </div>
        @foreach ($locales as $code)
            <textarea name="body[{{ $code }}]" class="textarea" v-show="showBody('{{ $code }}')"></textarea>
        @endforeach
    </div>
    @if($errors->has('body'))
        <p class="help is-danger">
            {{ $errors->first('body') }}
        </p>
    @endif
</div>

{{-- desc --}}
<div class="field">
    {{ Form::label('desc', 'Description', ['class' => 'label']) }}
    <div class="control input-box">
        <div class="select toggle-locale">
            <select v-model="desc">
                @foreach ($locales as $code)
                    <option value="{{ $code }}">{{ $code }}</option>
                @endforeach
            </select>
        </div>
        @foreach ($locales as $code)
            <textarea name="desc[{{ $code }}]" class="textarea" v-show="showDesc('{{ $code }}')"></textarea>
        @endforeach
    </div>
    @if($errors->has('desc'))
        <p class="help is-danger">
            {{ $errors->first('desc') }}
        </p>
    @endif
</div>

{{-- prefix --}}
<div class="field">
    {{ Form::label('prefix', 'Url Prefix', ['class' => 'label']) }}
    <div class="control input-box">
        <div class="select toggle-locale">
            <select v-model="prefix">
                @foreach ($locales as $code)
                    <option value="{{ $code }}">{{ $code }}</option>
                @endforeach
            </select>
        </div>
        @foreach ($locales as $code)
            <input type="text" name="prefix[{{ $code }}]" class="input" v-show="showPrefix('{{ $code }}')" placeholder="abc">
        @endforeach
    </div>
    @if($errors->has('prefix'))
        <p class="help is-danger">
            {{ $errors->first('prefix') }}
        </p>
    @endif
</div>

{{-- url --}}
<div class="field">
    {{ Form::label('url', 'Url', ['class' => 'label']) }}
    <div class="control input-box">
        <div class="select toggle-locale">
            <select v-model="url">
                @foreach ($locales as $code)
                    <option value="{{ $code }}">{{ $code }}</option>
                @endforeach
            </select>
        </div>
        @foreach ($locales as $code)
            <input type="text" name="url[{{ $code }}]" class="input" v-show="showUrl('{{ $code }}')" placeholder="xyz/{someParam}">
        @endforeach
    </div>
    @if($errors->has('url'))
        <p class="help is-danger">
            {{ $errors->first('url') }}
        </p>
    @endif
</div>