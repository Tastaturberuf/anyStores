var stores;

function loadMap()
{
    var oReq = new XMLHttpRequest();

    oReq.addEventListener("progress", updateProgress);
    oReq.addEventListener("load", transferComplete);
    oReq.addEventListener("error", transferFailed);
    oReq.addEventListener("abort", transferCanceled);

    oReq.open("POST", anystores.stores.url);
    oReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    oReq.send(anystores.stores.params);

    // progress on transfers from the server to the client (downloads)
    function updateProgress (oEvent) {
        if (oEvent.lengthComputable) {
            var percentComplete = oEvent.loaded / oEvent.total;
            // ...
        } else {
            // Unable to compute progress information since the total size is unknown
        }
    }

    function transferComplete(evt) {
        console.log(evt);
        stores = JSON.parse(this.responseText);
        console.log(stores);
        initialize();
    }

    function transferFailed(evt) {
        console.log("An error occurred while transferring.");
    }

    function transferCanceled(evt) {
        console.log("The transfer has been canceled by the user.");
    }
}


function initialize()
{
    var map = new google.maps.Map(document.getElementById('map-canvas'), {
        zoom: anystores.map.zoom,
        center: new google.maps.LatLng(anystores.map.latitude, anystores.map.longitude),
        streetViewControl: anystores.map.streetview,
        mapTypeId: anystores.map.maptype
    });

    var markers = [];

    for (var i = 0; i < stores.length; i++) {

        var store = stores[i];

        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(store.latitude, store.longitude)
        });

        var infowindow = new google.maps.InfoWindow();

        google.maps.event.addListener(marker, 'click', (function(marker, i) {

            var html = "<b><a href=\"" + store.href + "\">" + store.name + "</a></b><br>";

            (store.street !="") ? html += store.street  + "<br>" : "";
            (store.city !="")   ? html += store.postal  + " " +  store.city  + "<br>" : "";
            (store.phone !="")  ? html += store.phone  + "<br>" : "";
            (store.url !="")    ? html += "<a href=\"" + store.url  + "\">" + store.url  + "</a><br>" : "";
            (store.email !="")  ? html += "<a href=\"mailto:" + store.email  + "\">" + store.email  + "</a><br>" : "";
            (store.href !="")   ? html += "<br><a href=\"" + anystores.stores.href + store.href + "\">Mehr Informationen</a>" : "";

            return function() {
                infowindow.setContent(html);
                infowindow.open(map, marker);
            }

        })(marker, i));

        markers.push(marker);
    }

    var markerCluster = new MarkerClusterer(map, markers);
}

google.maps.event.addDomListener(window, 'load', loadMap);
