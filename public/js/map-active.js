function initMap() {
    // The location of Kiyv
    var kiyv = {lat: 50.4547, lng: 30.5238};
    // The map, centered at Kiyv
    var map = new google.maps.Map(
        document.getElementById('googleMap'), {zoom: 4, center: kiyv});
    // The marker, positioned at Kiyv
    var marker = new google.maps.Marker({position: kiyv, map: map});
}