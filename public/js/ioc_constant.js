
function loadingMap(){
    $('.hienThiBanDo').append('<div style="" id="loadingDiv"><div class="loader">Loading...</div></div>');
}

function removeLoader(){
    $( "#loadingDiv" ).fadeOut(500, function() {
    $( "#loadingDiv" ).remove(); //makes page more lightweight 
  });  
}

function RenderMap(item) {
  let arr_location = item
    item.features.map((element, index) => {
        let result = applyCountryBorder( element.properties.name).then(data => {
            let arr = [];
            if (data[0].geojson.coordinates) {
                arr = data[0].geojson.coordinates;
            }
            arr_location.features[index].geometry.coordinates = arr;
        })
        return element;
    });
    return arr_location
}
async function applyCountryBorder( countryname) {
    // let latLngs = [];
    let latLngs = await jQuery.ajax({
        type: "GET",
        dataType: "json",
        url: "https://nominatim.openstreetmap.org/search?q=" +
            countryname.trim() +
            "&polygon_geojson=1&format=json",

        success: function (data) {
        },
    })
    return latLngs
}
var listDiemTruong = [{
        name: 'Trường Cao Đẳng Thương Mại và Du Lịch',
        location: [21.573437070508298, 105.82872412000835]
    },
    {
        name: 'Trường THPT Lương Ngọc Quyến',
        location: [21.591125169306803, 105.82729751173234]
    },
]
