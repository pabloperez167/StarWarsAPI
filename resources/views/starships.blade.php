@extends('layouts.app')

@section('content')

    <div id="app">
        <ul>
            <li v-for="starship in starships" :key="starship.id">
                <h3>@{{ starship.name }}</h3>
                <ul>
                    <li v-for="pilot in starship.pilots" :key="pilot.id">
                        @{{ pilot.name }}
                    </li>
                </ul>
            </li>
        </ul>
    </div>

    <script>
        
            data: {
                starships: @json($starships)
            };
    </script>
@endsection
