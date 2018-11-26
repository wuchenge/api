<div class="form-group {!! !$errors->has($label) ?: 'has-error' !!}">

    <label for="{{$id}}" class="col-sm-2 control-label">{{$label}}</label>

    <div class="{{$viewClass['field']}}">

        @include('admin::form.error')

        @if($value)
            @foreach($value as $val)
            <a href="{{$val}}" class="grid-popup-link">
                <img src='{{$val}}' style='max-width:50px;max-height:50px' class='img img-thumbnail' />
            </a>
            @endforeach
        @endif


    </div>
</div>
