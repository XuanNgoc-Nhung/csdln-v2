<template>
    <div>
        <el-row :span="24" class="banDoIOC">
            <el-col :span="24">
                <l-map style="height: 100%" :zoom.sync="zoom" :center.sync="center" ref="myMapRef"
                    :options="leafletMapOptions">

                    <l-control position="topright">
                        <input v-model="hienThiHocSinhNghiHoc" type="checkbox"> <span style="color:blue">Cảnh báo HS
                            nghỉ học</span>
                    </l-control>
                    <l-control-layers position="topright"></l-control-layers>
                    <l-tile-layer v-for="tileProvider in tileProviders" :key="tileProvider.name"
                        :name="tileProvider.name" :visible="tileProvider.visible" :url="tileProvider.url"
                        layer-type="base" />
                    <l-control-scale position="bottomleft" :imperial="true" :metric="false"></l-control-scale>
                    <l-geo-json :geojson="geojson" :options="options">
                    </l-geo-json>
                    <l-marker v-for="marker, index in danh_sach_cac_truong" :key="index" :icon="getIcon(marker)"
                        :lat-lng="marker.location">
                        <l-tooltip>
                            {{marker.tenTruongHoc}} - [{{marker.maTruongHoc}}]<br>
                            Giáo viên: {{marker.soLuongCanBoGiaoVien}}<br>
                            Lớp học: {{marker.soLuongLopHoc}}<br>
                            Học sinh: {{marker.soLuongHocSinh}}<br>
                            Học sinh bỏ học: {{marker.soLuongHocSinhNghiHoc}}
                        </l-tooltip>
                    </l-marker>
                    <l-marker v-for="marker in danh_sach_trung_tam_huyen" :key="marker.name" :icon="iconCenterCity"
                        :lat-lng="marker.location">
                        <l-tooltip>{{marker.name}}</l-tooltip>
                    </l-marker>

                </l-map>
            </el-col>
            <div v-show="thongTinBanDo.tenQuanHuyen!=''" ref="thongTinVungChon" class="thongTinVungChon">
                <el-row :gutter="20">
                    <el-col :span="24">
                        <h5><b>{{thongTinBanDo.tenQuanHuyen}}</b></h5>
                        <p>Số lượng Trường học: <span>{{thongTinBanDo.soLuongTruongHoc.toLocaleString()}}</span></p>
                        <p>Số lượng CBGV: <span>{{thongTinBanDo.soLuongCanBoGiaoVien.toLocaleString()}}</span></p>
                        <p>Số lượng CBGV nam: <span>{{thongTinBanDo.soLuongCanBoGiaoVienNam.toLocaleString()}}</span>
                        </p>
                        <p>Số lượng CBGV nữ: <span>{{thongTinBanDo.soLuongCanBoGiaoVienNu.toLocaleString()}}</span></p>
                        <p>Số lượng Học sinh: <span>{{thongTinBanDo.soLuongHocSinh.toLocaleString()}}</span></p>
                        <p>Số lượng Học sinh nam: <span>{{thongTinBanDo.soLuongHocSinhNam.toLocaleString()}}</span></p>
                        <p>Số lượng Học sinh nữ: <span>{{thongTinBanDo.soLuongHocSinhNu.toLocaleString()}}</span></p>
                        <p>Số lượng Học sinh nghỉ học:
                            <span>{{thongTinBanDo.soLuongHocSinhNghiHoc.toLocaleString()}}</span></p>
                    </el-col>
                </el-row>
            </div>
        </el-row>
    </div>
</template>

<script>
    import 'leaflet/dist/leaflet.css';
    import {
        LMap,
        LTileLayer,
        LPopup,
        LControlLayers,
        LMarker,
        LGeoJson,
        LControl,
        LTooltip,
        LControlScale
    } from 'vue2-leaflet';

    export default {
        props: ['item', 'darkMode'],
        components: {
            LMap,
            LPopup,
            LTileLayer,
            LControlLayers,
            LControlScale,
            LMarker,
            LTooltip,
            LControl,
            LGeoJson
        },
        watch: {
            item(newVal) {
                console.log(newVal);
                if (newVal) {
                    this.ganDuLieuBanDo(newVal);
                }
            },
            darkMode(newVal) {
                if (newVal) {
                    this.thayDoiGiaoDien('darkMode');
                } else {
                    this.thayDoiGiaoDien('donGian');
                }
            }
        },
        data() {
            return {
                thongtin: JSON.parse(window.userInfo),
                hienThiHocSinhNghiHoc: false,
                fillColor: "#e4ce7f",
                thongTinBanDo: {
                    soLuongCanBoGiaoVien: '',
                    soLuongCanBoGiaoVienNam: '',
                    soLuongCanBoGiaoVienNu: '',
                    soLuongDiemTruong: '',
                    soLuongHocSinh: '',
                    soLuongHocSinhNam: '',
                    soLuongHocSinhNghiHoc: '',
                    soLuongHocSinhNu: '',
                    soLuongTruongHoc: '',
                    tenQuanHuyen: '',
                },
                zoom: 8,
                leafletMapOptions: {
                    closePopupOnClick: false,
                    doubleClickZoom: 'center',
                },
                center: [21.0272475286914, 105.80010304310957],
                tileProviders: [{
                        name: 'Mặc định',
                        nameEn: 'macDinh',
                        visible: true,
                        attribution: 'Hệ thống CSDL Ngành Giáo dục',
                        url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                    },
                    {
                        name: 'Đơn giản',
                        nameEn: 'donGian',
                        visible: false,
                        attribution: 'Hệ thống CSDL Ngành Giáo dục',
                        url: 'https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png',
                    },
                    {
                        name: 'Vệ tinh',
                        nameEn: 'veTinh',
                        visible: false,
                        url: 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
                        attribution: 'Hệ thống CSDL Ngành Giáo dục',
                    },
                    {
                        name: 'Dark mode',
                        nameEn: 'darkMode',
                        visible: false,
                        url: 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png',
                        attribution: 'Hệ thống CSDL Ngành Giáo dục',
                    },
                    {
                        name: 'Địa hình',
                        nameEn: 'diaHinh',
                        visible: false,
                        url: 'https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png',
                        attribution: 'Hệ thống CSDL Ngành Giáo dục',
                    },
                ],
                geojson: {
                    "type": "FeatureCollection",
                    "features": []
                },
                danh_sach_cac_truong: [],
                danh_sach_trung_tam_huyen: [],
                iconTruongCap1: L.icon({
                    iconUrl: 'images/iconStudent.png',
                    iconSize: [20, 30],
                    iconAnchor: [20, 16]
                }),
                iconTruongCap2: L.icon({
                    iconUrl: 'images/iconSchool.png',
                    iconSize: [20, 30],
                    iconAnchor: [20, 16]
                }),
                iconTruongCap3: L.icon({
                    iconUrl: 'images/iconTruongCap3.png',
                    iconSize: [30, 20],
                    iconAnchor: [20, 16]
                }),
                iconTruongMamNon: L.icon({
                    iconUrl: 'images/iconTruongMamNon2.png',
                    iconSize: [25, 35],
                    iconAnchor: [20, 16]
                }),
                iconUser: L.icon({
                    iconUrl: 'images/iconUser.png',
                    iconSize: [20, 30],
                    iconAnchor: [20, 16]
                }),
                iconWarning: L.icon({
                    iconUrl: 'images/iconWarning.png',
                    iconSize: [20, 30],
                    iconAnchor: [20, 16]
                }),
                iconCenterCity: L.icon({
                    iconUrl: 'images/trungTamThanhPho4.png',
                    iconSize: [30, 20],
                    iconAnchor: [20, 20]
                }),

            };
        },
        mounted() {
            if (this.thongtin.ma_so == 83) {
                this.center = [10.24178469155829, 106.37486395059356]
            }
            if (this.thongtin.ma_so == 19) {
                this.center = [21.565549741699897, 105.81790618520046]
            }
        },
        computed: {
            options() {
                var defaultStyle = {
                    weight: 2,
                    opacity: 0.8,
                    color: '#0033FF',
                    fillOpacity: 0.2
                }
                return {
                    style: function style(feature) {
                        return defaultStyle
                    },
                    onEachFeature: (feature, layer) => {
                        var self = this;
                        layer.on('mouseover', () => {
                            layer.setStyle({
                                color: this.getColor(feature),
                                weight: 2
                            });
                        });
                        layer.on('mouseout', () => {
                            layer.setStyle(defaultStyle);
                            let thongTinBanDo = {
                                soLuongCanBoGiaoVien: '',
                                soLuongCanBoGiaoVienNam: '',
                                soLuongCanBoGiaoVienNu: '',
                                soLuongDiemTruong: '',
                                soLuongHocSinh: '',
                                soLuongHocSinhNam: '',
                                soLuongHocSinhNghiHoc: '',
                                soLuongHocSinhNu: '',
                                soLuongTruongHoc: '',
                                tenQuanHuyen: '',
                            };
                            this.ganDuLieuThongTin(thongTinBanDo)
                        });
                        layer.on('mouseover', (e) => {
                            this.ganDuLieuThongTin(feature.properties)

                            //open popup;
                        });
                        layer.on('mouseout', function (e) {
                            // L.popup().openOn(self.$refs.myMapRef.mapObject);
                        });
                        layer.on('click', (e) => {
                            console.log(feature.properties);
                            var popup = L.popup()
                                .setLatLng(e.latlng)
                                .setContent(
                                    '<p style="color: #878575; font-size: 12px; margin-bottom: 0;">' +
                                    feature.properties.tenQuanHuyen + '</>')
                                .openOn(self.$refs.myMapRef.mapObject);
                        });
                    }
                }

            }
        },
        methods: {
            thayDoiGiaoDien(e) {
                for (let i = 0; i < this.tileProviders.length; i++) {
                    if (this.tileProviders[i].nameEn == e) {
                        this.tileProviders[i].visible = true;
                    } else {
                        this.tileProviders[i].visible = false;
                    }

                }
            },
            getIcon(e) {
                // console.log('getIcon')
                // console.log(e)
                let data = e;
                if (data.capHoc == 1) {
                    if (this.hienThiHocSinhNghiHoc && data.soLuongHocSinhNghiHoc > 0) {
                        return this.iconWarning;
                    }
                    return this.iconTruongCap1
                } else if (data.capHoc == 2 || data.capHoc == 12) {
                    if (this.hienThiHocSinhNghiHoc && data.soLuongHocSinhNghiHoc > 0) {
                        return this.iconWarning;
                    }
                    return this.iconTruongCap2
                } else if (data.capHoc == 3) {
                    if (this.hienThiHocSinhNghiHoc && data.soLuongHocSinhNghiHoc > 0) {
                        return this.iconWarning;
                    }
                    return this.iconTruongCap3
                } else if (data.capHoc == 4 || data.capHoc == 5 || data.capHoc == 45) {
                    if (this.hienThiHocSinhNghiHoc && data.soLuongHocSinhNghiHoc > 0) {
                        return this.iconWarning;
                    }
                    return this.iconTruongMamNon
                } else if (this.hienThiHocSinhNghiHoc && data.soLuongHocSinhNghiHoc > 0) {
                    return this.iconWarning;
                } else {
                    return this.iconUser
                }
            },
            ganDuLieuThongTin(e) {
                this.thongTinBanDo = e
            },
            getColor(e) {
                console.log("Lấy màu:")
                return '#F00';
            },
            ganDuLieuBanDo(e) {
                console.log("Dữ liệu gán:")
                console.log(e);
                let data = e;

                this.geojson.features = []
                this.danh_sach_cac_truong = [];
                this.danh_sach_trung_tam_huyen = [];
                let quanHuyens = data.quanHuyens;
                let truongHocs = data.truongHocs;
                for (let i = 0; i < truongHocs.length; i++) {
                    if (truongHocs[i].location.length > 0) {
                        this.danh_sach_cac_truong.push(truongHocs[i])
                    }
                }
                for (let i = 0; i < quanHuyens.length; i++) {
                    let trungTamHuyen = {
                        location: quanHuyens[i].centralPoint,
                        name: 'TT ' + quanHuyens[i].tenQuanHuyen
                    }
                    this.danh_sach_trung_tam_huyen.push(trungTamHuyen)
                    let obj = {
                        "type": "Feature",
                        "id": "01",
                        "properties": {
                            "tenQuanHuyen": quanHuyens[i].tenQuanHuyen,
                            "soLuongCanBoGiaoVien": quanHuyens[i].soLuongCanBoGiaoVien,
                            "soLuongCanBoGiaoVienNam": quanHuyens[i].soLuongCanBoGiaoVienNam,
                            "soLuongCanBoGiaoVienNu": quanHuyens[i].soLuongCanBoGiaoVienNu,
                            "soLuongDiemTruong": quanHuyens[i].soLuongDiemTruong,
                            "soLuongHocSinh": quanHuyens[i].soLuongHocSinh,
                            "soLuongHocSinhNam": quanHuyens[i].soLuongHocSinhNam,
                            "soLuongHocSinhNu": quanHuyens[i].soLuongHocSinhNu,
                            "soLuongHocSinhNghiHoc": quanHuyens[i].soLuongHocSinhNghiHoc,
                            "soLuongTruongHoc": quanHuyens[i].soLuongTruongHoc,
                        },
                        "geometry": {
                            "type": "Polygon",
                            "coordinates": [quanHuyens[i].border]
                        }
                    }
                    this.geojson.features.push(obj)
                }
                console.log(this.geojson)
                this.center = quanHuyens[0].centralPoint;
                setTimeout(() => {
                    this.center = quanHuyens[0].centralPoint;
                    this.zoom = 10;
                }, 1000)
            }
        }
    }

</script>
