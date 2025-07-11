$(document).ready(function () {

    var schoolIcon = L.icon({
        iconUrl: 'https://cdn-icons-png.flaticon.com/512/1344/1344093.png',
        iconSize: [20, 20], // size of the icon
    });
    var schoolCongTy = L.icon({
        iconUrl: 'https://icons-for-free.com/iconfiles/png/512/business+company+estate+office+work+icon-1320086520504455343.png',
        iconSize: [25, 25], // size of the icon
    });
    var CSDL = L.layerGroup();
    L.marker([21.02653771837346, 105.7990890471644], {
        draggable: true,
        icon: schoolCongTy
    }).bindPopup('Trụ sở DTS Groups').addTo(CSDL);
    var mbAttr = '<a href="https://dongbo.csdl.edu.vn/dashboard">Hệ thống CSDL Ngành Giáo dục',
        mbUrl = 'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoieHVhbm5nb2NwdDl4IiwiYSI6ImNrdjkwYjRpaDl5dWcydm1ubGZnNDFtbjYifQ.hcZFPmMheRi1-1LuHisHBA';
    var grayscale = L.tileLayer(mbUrl, {
            id: 'mapbox/light-v9',
            tileSize: 512,
            zoomOffset: -1,
            attribution: mbAttr
        }),
        streets = L.tileLayer(mbUrl, {
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1,
            attribution: mbAttr
        }),
        outdoors = L.tileLayer(mbUrl, {
            id: 'mapbox/outdoors-v11',
            tileSize: 512,
            zoomOffset: -1,
            attribution: mbAttr
        }),
        satellite = L.tileLayer(mbUrl, {
            id: 'mapbox/satellite-streets-v11',
            tileSize: 512,
            zoomOffset: -1,
            attribution: mbAttr
        }),
        dark = L.tileLayer(mbUrl, {
            id: 'mapbox/dark-v10',
            tileSize: 512,
            zoomOffset: -1,
            attribution: mbAttr
        });
    var map = L.map('map', {
        center: [21.026140203903815, 105.82419741343087],
        zoom: 8,
        layers: [satellite]
    });
    var baseLayers = {
        "Dark mode": dark,
        "Đơn sắc": grayscale,
        "Ngoài trời": outdoors,
        "Giao thông": streets,
        "Địa hình": satellite
    };
    var overlays = {
        "Trung tâm hỗ trợ": CSDL
    };
    L.control.layers(baseLayers, overlays).addTo(map);
    var info = L.control();
    info.onAdd = function (map) {
        this._div = L.DomUtil.create('div', 'info');
        this.update();
        return this._div;
    };
    info.update = function (props) {
        this._div.innerHTML = '<h6 style="color:red"><b>Thông tin chi tiết</b></h6>' + (props ?
            '<b>' + props.name + '</b><br />' +
            props.soLuongTruong + ' trường. <br/>' +
            props.soLuongGiaoVien + ' giáo viên. <br/>' +
            props.soLuongLopHoc + ' lớp học. <br/>' +
            props.soLuongHocSinh + ' học sinh. <br/>' :
            'Chọn vùng để xem chi tiết');
    };
    info.addTo(map);
    var mang = [];
    var geojson;
    var theMarker = [];
    $("#thongKeDuLieuBieuDo").click(function (e) {
        e.preventDefault();
        let donVi = $('.donViThongKe :selected').val();
        let capHoc = $('.capHocThongKe :selected').val();
        let namHoc = $('.namHocThongKe :selected').val();
        if (donVi == 'Chọn đơn vị') {
            thongBao('error', 'Thiếu đơn vị.')
            return;
        }
        if (capHoc == 'Chọn cấp học') {
            thongBao('error', 'Thiếu cấp học.')
            return;
        }
        if (namHoc == 'Chọn năm học') {
            thongBao('error', 'Thiếu năm học.')
            return;
        }
        console.log("Lấy vị trí địa lý của:")
        console.log(donVi)
        $.ajax({
            url: '/lay-du-du-lieu-ioc-theo-khu-vuc',
            type: 'GET',
            dataType: 'json',
            data: {
                capHocs: [capHoc],
                // maDonVis: ['164','165','166','167','168','169','170','171','172','173'],
                maDonVis: [donVi],
                idSo: '19',
                namHoc: namHoc,
            }
        }).done(function (ketqua) {
            console.log("kết quả trả về IOC:");
            console.log(ketqua);
            if (ketqua.rc == 0) {
                let responseApi = {
                    "type": "FeatureCollection",
                    "features": []
                };
                let quanHuyens = ketqua.quanHuyens;
                let danhSachTruong = ketqua.truongHocs;
                let tongQuanHuyen = ketqua.tongQuanHuyen;
                ganDuLieuTongQuan(tongQuanHuyen)
                let locationFlyTo = [];
                console.log(quanHuyens.length)
                // ganDiemTruong(danhSachTruong[i])
                theMarker = [];
                for (let i = 0; i < quanHuyens.length; i++) {
                    locationFlyTo = quanHuyens[i].centralPoint
                    let obj = {
                        "type": "Feature",
                        "id": "0" + i,
                        "properties": {
                            "name": quanHuyens[i].tenQuanHuyen,
                            "density": quanHuyens[i].soLuongTruongHoc,
                            "soLuongTruong": quanHuyens[i].soLuongTruongHoc,
                            "soLuongGiaoVien": quanHuyens[i].soLuongCanBoGiaoVien,
                            "soLuongCanBoGiaoVienNam": quanHuyens[i].soLuongCanBoGiaoVienNam,
                            "soLuongCanBoGiaoVienNu": quanHuyens[i].soLuongCanBoGiaoVienNu,
                            "soLuongHocSinh": quanHuyens[i].soLuongHocSinh,
                            "soLuongHocSinhNam": quanHuyens[i].soLuongHocSinhNam,
                            "soLuongHocSinhNu": quanHuyens[i].soLuongHocSinhNu,
                            "soLuongLopHoc": quanHuyens[i].soLuongLopHoc,
                        },
                        "geometry": {
                            "type": "Polygon",
                            "coordinates": [quanHuyens[i].border]
                        }
                    };
                    responseApi.features.push(obj);
                }
                loadingMap();
                setTimeout(removeLoader, 100)
                setTimeout(function () {
                    // var linesFeatureLayer = L.geoJson(myLines);
                    // linesFeatureLayer.addTo(map);
                    geojson = L.geoJson(responseApi, {
                        style: style,
                        onEachFeature: onEachFeature
                    });
                    geojson.addTo(map);
                    map.flyTo(locationFlyTo, 7)
                    setTimeout(function () {
                        map.flyTo(locationFlyTo, 10)
                    }, 1500)
                }, 500);
                for (let i = 0; i < danhSachTruong.length; i++) {
                    if(danhSachTruong[i].location&&danhSachTruong[i].location.length>0){
                        let mk = L.marker(danhSachTruong[i].location, {
                            icon: schoolIcon
                        }).addTo(map).bindPopup(danhSachTruong[i].tenTruongHoc);
                        theMarker.push(mk)
                    }
                }

            } else {}
            return;
        });
    });
    function ganDuLieuTongQuan(e){
        console.log("Gán dữ liệu tổng quan:")
        console.log(e)
        $('#soLuongTruongHoc').text(e.truongHoc)
        $('#soLuongCanBo').text(e.giaoVien)
        $('#soLuongHocSinh').text(e.hocSinh)
        $('#soLuongHocSinhNghiHoc').text(e.diemTruong)
    }
    function getColor(d) {
        return d > 1000 ? '#800026' :
            d > 500 ? '#BD0026' :
            d > 200 ? '#E31A1C' :
            d > 100 ? '#FC4E2A' :
            d > 50 ? '#FD8D3C' :
            d > 20 ? '#FE024C' :
            d > 10 ? '#FED976' :
            '#FF0DA0';
    }
    function style(feature) {
        return {
            weight: 2,
            opacity: 0.4,
            color: 'red',
            dashArray: '3',
            fillOpacity: 0.4,
            fillColor: getColor(feature.properties.density)
        };
    }
    function highlightFeature(e) {
        var layer = e.target;
        layer.setStyle({
            weight: 2,
            color: '#0F0',
            dashArray: '',
            fillOpacity: 0.3
        });
        if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
            layer.bringToFront();
        }
        info.update(layer.feature.properties);
    }
    function resetHighlight(e) {
        geojson.resetStyle(e.target);
        // info.update();
    }
    function zoomToFeature(e) {
        let data = e.target;
        console.log("ấn vào từng khu vực")
        console.log(e)
        info.update(data.feature.properties);
        // map.fitBounds(e.target.getBounds());
    }
    function onEachFeature(feature, layer) {
        console.log("layer")
        console.log(layer)
        layer.on({
            mouseover: highlightFeature,
            mouseout: resetHighlight,
            click: zoomToFeature
        });
    }
    function ganDiemTruong(e) {
        if (e && e.location && e.location.length > 0) {
            var marker = new L.Marker(e.location, {
                draggable: true,
                icon: schoolIcon
            });
            map.addLayer(marker);
            marker.bindPopup(e.name);
        }
    };
    function onMapClick(e) {
        let arr = [e.latlng.lng, e.latlng.lat];
        mang.push(arr);
        let m = JSON.stringify(mang)
        // navigator.clipboard.writeText(m);
        console.log(arr)
    };
    function thongBao(t, e) {
        let type = 'success';
        if (t) {
            type = t;
        }
        if (t == 'success') {
            NotiSuccess(e)
        }
        if (t == 'error') {
            NotiError(e)
        }
        if (t == 'info') {
            NotiInfo(e)
        }
    }

    function NotiSuccess(e) {
        notif({
            position: 'left',
            msg: e,
            type: "success",
            timeout: 1500,
        });
    }

    function NotiError(e) {
        notif({
            position: 'left',
            msg: e,
            type: "error",
            timeout: 1500,
        });
    }

    function NotiInfo(e) {
        notif({
            position: 'left',
            msg: e,
            type: "info",
            timeout: 1500,
        });
    }

});
