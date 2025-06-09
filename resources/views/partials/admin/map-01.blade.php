@push('foot')
<script src="/js/map-example/us-aea-en.js"></script>
<script>
    window.addEventListener('load', function () {
        const mapElement = document.getElementById('mapOne');
        if (!mapElement) return;

        const zipMarkers = @json($zipCoordinates);

        new jsVectorMap({
            selector: "#mapOne",
            map: "us_aea_en",
            zoomButtons: true,

            markers: zipMarkers.map(location => ({
                name: location.zip,
                coords: [location.lat, location.lng],
            })),

            markerStyle: {
                initial: {
                    fill: "#3056D3",
                    stroke: "#fff",
                    r: 5
                },
                hover: {
                    fill: "#FF5722",
                    stroke: "#fff",
                    cursor: "pointer"
                },
            },

            regionStyle: {
                initial: {
                    fill: "#C8D0D8",
                },
                hover: {
                    fillOpacity: 1,
                    fill: "#3056D3",
                },
            },
        });
    });
</script>
@endpush
<div
  class="col-span-12 rounded-sm border border-stroke bg-white px-7.5 py-6 shadow-default dark:border-strokedark dark:bg-boxdark xl:col-span-7"
>
  <h4 class="mb-2 text-xl font-bold text-black dark:text-white">
    Region labels
  </h4>
  <div id="mapOne" class="mapOne map-btn h-90"></div>
</div>