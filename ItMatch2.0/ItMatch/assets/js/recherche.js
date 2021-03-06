
$(document).ready(function() {
    $('#btnPosition').click(function(){
        $('#search').replaceWith();
    });
});

mapboxgl.accessToken = 'pk.eyJ1IjoieHdpenoiLCJhIjoiY2swbmpybTF4MDBrYTNtbXg3eTkyeWFleiJ9.LJrZc-HtZqUtNB63_66cbQ';
var map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/light-v10',
    center: [2.5, 46.5],
    zoom: 5.60,
});

map.addControl(new mapboxgl.NavigationControl());

var listTrajet = document.querySelector('#listTrajet .list');
var listResult = [
    {
        text: "Trajet 1",
        latitude_depart: "49.477297",
        longitude_depart: "1.087807",
        latitude_arrivee: "49.475784",
        longitude_arrivee: "1.085822"
    },
    {
        text: "Trajet 2",
        latitude_depart: "49.459763",
        longitude_depart: "1.064371",
        latitude_arrivee: "49.475784",
        longitude_arrivee: "1.085822"
    },
    { text: "Trajet 3"},
    { text: "Trajet 4"}
]

function displayListTrajet(list){
    while(listTrajet.firstChild){
        listTrajet.removeChild(listTrajet.firstChild);
    }

    list.map(function(trajet){
        let btn = document.createElement('button');
        btn.className = "asideSearchResult";
        btn.innerHTML = trajet.text;

        btn.setAttribute('latitude_depart', trajet.latitude_depart);
        btn.setAttribute('longitude_depart', trajet.longitude_depart);
        btn.setAttribute('latitude_arrivee', trajet.latitude_arrivee);
        btn.setAttribute('longitude_arrivee', trajet.longitude_arrivee);

        btn.addEventListener("click", trajetClick);

        listTrajet.appendChild(btn);
    })
}

displayListTrajet(listResult);

function trajetClick(event){

    let url = "https://api.mapbox.com/directions/v5/mapbox/driving/" +
        event.target.getAttribute("longitude_depart") + "," + event.target.getAttribute("latitude_depart")+ ";" +
        event.target.getAttribute("longitude_arrivee") + "," + event.target.getAttribute("latitude_arrivee") +
        "?geometries=geojson&access_token=" + mapboxgl.accessToken;

    fetch(url).then(function(response){
        return response.json();
    }).then(function(data){

        if(map.getSource("trajet")){
            map.getSource("trajet").setData({
                "type": "Feature",
                "properties": {},
                "geometry": data.routes[0].geometry
            })
        } else {
            map.addSource("trajet", {
                "type": "geojson",
                "data": {
                    "type": "Feature",
                    "properties": {},
                    "geometry": data.routes[0].geometry
                }
            });
        }

        if(!map.getLayer('route')){
            map.addLayer({
                "id": "route",
                "type": "line",
                "source": "trajet"
            })
        }


        //setLngLat([longitude, latitude])
        //parseFloat(string)


        let coordinates = data.routes[0].geometry.coordinates;
        let bounds = coordinates.reduce(function(bounds, coord) {
            return bounds.extend(coord);
        }, new mapboxgl.LngLatBounds(coordinates[0], coordinates[0]));

        map.fitBounds(bounds, {
            padding: 200
        });
    })
}

// Recherche départ
var inputdepart = document.getElementById("inputdepart");
var resultdepart = document.getElementById("resultdepart");

function razDepartSearch() {
    while(resultdepart.firstChild){
        resultdepart.removeChild(resultdepart.firstChild);
    }
}

function clickResultDepart(event) {
    console.log(event);
    inputdepart.value = event.target.innerText;

    razDepartSearch();

    resultdepart.style.display = "none";
}


inputdepart.addEventListener('keyup', function() {
    console.log(inputdepart.value)

    if(inputdepart.value === ""){
        razDepartSearch();
        resultdepart.style.display = "none";
        return;
    }

    resultdepart.style.display = "block";

    fetch("https://api.mapbox.com/geocoding/v5/mapbox.places/" + inputdepart.value +
        ".json?types=place,locality&access_token=" + mapboxgl.accessToken)
        .then(function(response){
            return response.json();
        })
        .then(function(data){

            let list = data.features.map(function(el){
                return {
                    name: el.place_name,
                    center: el.center
                }
            })
            console.log("result", list)

            razDepartSearch();

            for(let i=0; i<list.length; i++){
                let li = document.createElement('li');

                li.innerHTML = list[i].name;

                li.addEventListener('click', clickResultDepart);

                resultdepart.appendChild(li);
            }
        })
})
// fin recherche départ

var inputarrive = document.getElementById("inputarrive");
var resultarrive = document.getElementById("resultarrive");

function razArriveSearch() {
    while(resultarrive.firstChild){
        resultarrive.removeChild(resultarrive.firstChild);
    }
}

function clickResultArrive(event) {
    console.log(event);
    inputarrive.value = event.target.innerText;

    razArriveSearch();

    resultarrive.style.display = "none";
}

inputarrive.addEventListener('keyup', function() {
    console.log(inputarrive.value)

    if(inputarrive.value === ""){
        razArriveSearch();
        resultarrive.style.display = "none";
        return;
    }

    resultarrive.style.display = "block";

    fetch("https://api.mapbox.com/geocoding/v5/mapbox.places/" + inputarrive.value + ".json?types=place,locality&access_token=" + mapboxgl.accessToken)
        .then(function(response){
            return response.json();
        })
        .then(function(data){
            let list = data.features.map(function(el){
                return {
                    name: el.place_name,
                    center: el.center
                }
            })
            console.log("result", list)

            razArriveSearch();

            for(let i=0; i<list.length; i++){
                let li = document.createElement('li');

                li.innerHTML = list[i].name;

                li.addEventListener('click', clickResultArrive);

                resultarrive.appendChild(li);
            }
        })
})