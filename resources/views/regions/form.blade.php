<div class="form-group">

    <label for="name">Name</label>
    {!! Form::text('name',null,[
    'class' => 'form-control'
 ]) !!}
<br>


@inject('city', 'App\Models\City')
<label for="city">City</label>
{!! Form::select('city_id', $city->pluck('name','id')->toArray(), null , ['class' => 'form-control']) !!}
<br>


</div>
<div class="form-group">
    <button class="btn btn-primary" type="submit">Submit</button>
</div>





