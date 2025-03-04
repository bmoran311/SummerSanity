@push('foot')
<script src="/js/map-example/us-aea-en.js"></script>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        const mapOne = new jsVectorMap({
            selector: "#mapOne",
            map: "us_aea_en",
            zoomButtons: true,

            regionStyle: {
                initial: {
                fill: "#C8D0D8",
                },
                hover: {
                fillOpacity: 1,
                fill: "#3056D3",
                },
            },
            regionLabelStyle: {
                initial: {
                //fontFamily: "Satoshi",
                fontWeight: "semibold",
                fill: "#fff",
                },
                hover: {
                cursor: "pointer",
                },
            },

            labels: {
                regions: {
                render(code) {
                    return code.split("-")[1];
                },
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
