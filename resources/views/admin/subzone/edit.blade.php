@extends('admin.layout.base')

@section('title', 'Sub Zones')

@section('content')

    <div class="content-area py-1">
        <div class="container-fluid">
            
            <div class="box box-block bg-white">
                <h5 class="mb-1"><span class="s-icon"><i class="ti-zoom-in"></i></span> &nbsp;Edit SubZones </h5>
                <hr/>
                
                <form class="form-horizontal" method="POST" action="{{route('admin.subzone.update',$editZone[0]->main)}}">
                  {{csrf_field()}}
                  <input type="hidden" name="_method" value="PATCH">
                  <div class="form-group row">
                    <label for="main" class="col-xs-2 col-form-label">Main</label>
                    <div class="col-xs-10">
                      <select class="form-control" name="main">
                        @foreach ($allZones as $zone)
                          <option value="{{$zone->id}}" {{$editZone[0]->main==$zone->id?"selected":null}}>{{$zone->zone_name}}</option>
                        @endforeach
                      <select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="sub" class="col-xs-2 col-form-label">Subzone</label>
                    <div class="col-xs-10">						
                      <input class="form-control typeahead" type="text" placeholder="Type in and select zones" name="sub" required id="sub"
                      value="@foreach($editZone as $zone){{@$zone->subZone->zone_name}},@endforeach">
                    </div>
                  </div>
                  <button class="btn btn-primary">Add</button>
                </form>
            </div>
            
        </div>
    </div>
    <script>
      var zones = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.whitespace,
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        // url points to a json file that contains an array of country names, see
        // https://github.com/twitter/typeahead.js/blob/gh-pages/data/countries.json
        prefetch: {
          url: "{{url('/admin/allZones')}}",
          cache: false
        },
      });
      zones.initialize();
    
      $('.typeahead').tagsinput({
      typeaheadjs: {
        name: 'zones',
        source: zones.ttAdapter()
      }
      });
    </script>
@endsection