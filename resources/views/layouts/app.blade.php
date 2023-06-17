<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

     
        
    </div>


    {{-- this script to make marker when clicked on  --}}
    {{-- <script>
        let map;

        function initMap() {
            myLatlng = {
                lat: 31.233334,
                lng: 30.033333
            };

            map = new google.maps.Map(document.getElementById("map"), {
                center: {
                    lat: 31.233334,
                    lng: 30.033333
                },
                zoom: 8,
                mapTypeId: 'roadmap',
            });

            marker = new google.maps.Marker({
                position: myLatlng,
                map,
                title: "Click to zoom",
            });

           
            map.addListener("click", (mapsMouseEvent) => {
                marker.setMap(null);
                myLatlng = JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2)
                latLngObj = JSON.parse(myLatlng);
                console.log(latLngObj);

                marker = new google.maps.Marker({
                    position: {
                        lat: parseFloat(latLngObj.lat),
                        lng: parseFloat(latLngObj.lng)
                    },
                    map,
                    title: "Click to zoom",
                });
                
            });
        }

        window.initMap = initMap;
    </script> --}}

    <script>
        let map;
        let marker;
        let markers = [];

        function initMap() {
            const myLatlng = {
                lat: 31.233334,
                lng: 30.033333
            };

            map = new google.maps.Map(document.getElementById("map"), {
                center: myLatlng,
                zoom: 6,
                mapTypeId: "roadmap"
            });

            marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                title: "Click to zoom"
            });

            // this for when click remove the old marker and add new marker
            map.addListener("click", (mapsMouseEvent) => {
                marker.setMap(null);
                const latLngObj = mapsMouseEvent.latLng.toJSON();
                console.log(latLngObj);

                marker = new google.maps.Marker({
                    position: latLngObj,
                    map: map,
                    title: "Click to zoom"
                });
            });

            const searchInput = document.getElementById("searchInput");
            const searchBox = new google.maps.places.SearchBox(searchInput);

            searchBox.addListener("places_changed", () => {
                const places = searchBox.getPlaces();

                if (places.length === 0) {
                    return;
                }

                // clearMarkers();

                const bounds = new google.maps.LatLngBounds();
                places.forEach((place) => {
                    if (!place.geometry || !place.geometry.location) {
                        console.log("Returned place contains no geometry");
                        return;
                    }

                    const marker = new google.maps.Marker({
                        map: map,
                        position: place.geometry.location,
                        title: place.name
                    });

                    markers.push(marker);
                    bounds.extend(place.geometry.location);
                });

                map.fitBounds(bounds);
            });
        }

        function clearMarkers() {
            markers.forEach((marker) => {
                marker.setMap(null);
            });
            markers = [];
        }
    </script>

    <script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyARSOni7zR2Ai_O8geP1MkVno5S5SlP5mU&libraries=places&callback=initMap">
    </script>




</body>

</html>
