@extends('website.app')

@section('content')
<?php
$locale = session()->get('locale');
   if($locale){

      $locale;

   }else{

      $locale = 'en';

   }
   
   $title = $locale.'_title';
   $des = $locale.'_description';
 ?>
<div class="container">
	<h3 style="font-size: 32px;margin: 21px 0 0 21px;color:black;">{!!ucwords(@$data->$title)!!}</h3><br>
	<div class="container">
		<div class="row">
			<div class="col-md-12 mb-4"style="margin-bottom: 20px;">
				<div>
				{!!@$data->$des!!}
				</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection