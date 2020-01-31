<template>
    <MglMap
        :accessToken="accessToken"
        :mapStyle="mapStyle"
        @load="onMapLoad"
    >
        <MglNavigationControl position="top-right" />
        <MglGeolocateControl position="top-right" />
        <MglPopup :coordinates="popupCoordinates">
            <span>Hello world!</span>
        </MglPopup>
    </MglMap>
</template>

<script>
    import Mapbox from "mapbox-gl";
    import {
        MglMap,
        MglNavigationControl,
        MglGeolocateControl,
        MglPopup
    } from "vue-mapbox";
    import '../../assets/css/map.css'
    export default {
        components: {
            MglMap,
            MglNavigationControl,
            MglGeolocateControl,
            MglPopup
        },
        data() {
            return {
                accessToken: 'pk.eyJ1IjoiY3ZhcmFuZGFzIiwiYSI6ImNrMWF5cXdvcTAxZ2MzaG82a2J3Mmc3d2wifQ.K8J4LKPzudGlXEWGtYV6nw', // your access token. Needed if you using Mapbox maps
                mapStyle: 'mapbox://styles/mapbox/streets-v11', // your map style
                popupCoordinates: [10, 10]
            };
        },

        created() {
            // We need to set mapbox-gl library here in order to use it in template
            this.mapbox = Mapbox;
        },
        methods: {
            async onMapLoad(event) {
                // Here we cathing 'load' map event
                const asyncActions = event.component.actions

                const newParams = await asyncActions.flyTo({
                    center: [-7.8536599, 39.557191],
                    zoom: 6,
                    speed: 1
                })
            }
        }

        // map.addControl(new MapboxGeocoder({
        //     accessToken: mapboxgl.accessToken,
        //     language: 'pt-PT',
        //     mapboxgl: mapboxgl,
        //     marker: false,
        //     filter: function (item) {
        //         // returns true if item contains New South Wales region
        //         return item.context.map(function (i) {
        //             return (i.id.split('.').shift() === 'country' && i.text === 'Portugal');
        //         }).reduce(function (acc, cur) {
        //             return acc || cur;
        //         });
        //     },
        // }));
    };
</script>


