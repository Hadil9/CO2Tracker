    // Initialize the platform object:
    var platform = new H.service.Platform({
    'apikey': '5Vo4_ugJNocjhsDV4W3-6fRp_BtoQdOxVmOI0TBeleY'
    });

    // Obtain the default map types from the platform object
    var maptypes = platform.createDefaultLayers();

    // Instantiate (and display) a map object:
    var map = new H.Map(
    document.getElementById('mapContainer'),
    maptypes.vector.normal.map,
    {
      zoom: 10,
      center: { lng: -73.48, lat: 45.48}
    });