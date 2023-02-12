  <div class="form-group">



<label for="who_are_we">who are we</label>
{!! Form::text('who_are_we',null,[
'class' => 'form-control'
]) !!}


        <label for="about_app">about app</label>
        {!! Form::textarea('about_app',null,[
        'class' => 'form-control'
     ]) !!}


<label for="commission_text">commission text</label>
{!! Form::textarea('commission_text',null,[
'class' => 'form-control'
]) !!}

<label for="commission">commission</label>
{!! Form::numeric('commission',null,[
'class' => 'form-control'
]) !!}


        <label for="fb_link">fb link</label>
        {!! Form::text('fb_link',null,[
        'class' => 'form-control'
     ]) !!}




        <label for="insta_link">insta link</label>
        {!! Form::text('insta_link',null,[
        'class' => 'form-control'
     ]) !!}

    </div>

    <div class="form-group">
        <button class="btn btn-primary" type="submit">Submit</button>
    </div>





