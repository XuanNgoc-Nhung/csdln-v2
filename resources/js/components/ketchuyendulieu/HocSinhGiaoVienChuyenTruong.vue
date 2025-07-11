<template>
    <div>
        <div class="row page-header">
            <div class="col-sm-6 text-uppercase">
                <a href="#">TRANG CHỦ</a><span><span class="kytu"> &raquo;</span> kết chuyển dữ liệu lên bộ<span
                        class="kytu"> &raquo;</span>giáo viên, học sinh chuyển trường</span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5 timkiem">
                <label class="typo__label">Chọn đơn vị:</label>
                <div>
                    <eselect style="width:100%" multiple collapseTags v-model="ma_don_vi" :placeholder="'Chọn'" filterable
                        :data="list_don_vi" :fields="['name','value']" />
                </div>
            </div>
            <div class="col-md-3 timkiem">
                <label class="typo__label">Cấp học</label>
                <div>
                    <eselect style="width:100%" multiple collapseTags v-model="cap_hoc" :placeholder="'Chọn'" filterable
                        :data="list_cap_hoc" :fields="['name','id']" />
                </div>
            </div>
            <div class="col-md-4 timkiem">
                <label class="typo__label">Trường học</label>
                <div>
                    <eselect style="width:100%" multiple collapseTags v-model="cap_hoc" :placeholder="'Chọn'" filterable
                        :data="list_cap_hoc" :fields="['name','id']" />
                </div>
            </div>
            <div class="col-md-5 timkiem">
                <label class="typo__label">Tiêu chí so sánh</label>
                <div>
                    <eselect style="width:100%" multiple collapseTags v-model="tieu_chi_so_sanh" :placeholder="'Chọn'" filterable
                        :data="list_tieu_chi_so_sanh" :fields="['name','value']" />
                </div>
            </div>
            <div class="col-md-3 timkiem">
                <label class="typo__label">Tiêu chí bổ sung</label>
                <div>
                    <eselect style="width:100%" multiple collapseTags v-model="tieu_chi_so_sanh" :placeholder="'Chọn'" filterable
                        :data="list_tieu_chi_so_sanh" :fields="['name','value']" />
                </div>
            </div>
        </div>
        <hr/>
        <div class="row text-center">
            <button class="btn btn-success" @click.prevent="soSanh()">So sánh</button>
            <button class="btn btn-info" @click.prevent="soSanh()">Tải DS học sinh chưa khớp</button>
        </div>
    </div>
</template>
<script>
    import Page from "../ui/PagingCustom";
    import rest_api from '../../utils/rest_api';
    import VueAlertify from "vue-alertify";
    import ElementUI from 'element-ui';
    import {
        Select
    } from 'element-ui';
    import ESelectVue from '../ui/ESelect.vue';
import constant from '../../utils/constant';
    Vue.use(ElementUI);
    Vue.use(VueAlertify, {
        notifier: {
            delay: 5,
            position: 'top-right'
        },
        glossary: {
            title: 'Thông báo',
            ok: 'Đồng ý',
            cancel: 'Hủy'
        }
    });
    export default {
        components: {
            Page,
            'eselect': ESelectVue,
        },
        watch: {},
        data() {
            return {
                ma_don_vi: [],
                cap_hoc: [],
                list_don_vi: [],
                list_cap_hoc:  window.listCapHoc,
                tieu_chi_so_sanh:['maTruongHoc','hoTen'],
                list_tieu_chi_so_sanh:  constant.list_tieu_chi_so_sanh,
                thongtin: JSON.parse(window.userInfo),
            }
        },
        props: [],
        mounted() {
            console.log("Mount trong hs,gv");
            this.getDonVi();
        },
        methods: {
            getDonVi() {
                this.list_don_vi = [];
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.ma_so
                };
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    if (data.data.statusResponse == 0) {
                        for (let i = 0; i < data.data.rows.length; i++) {
                            let obj = {
                                name: data.data.rows[i].tenDonVi + ' - [' + data.data.rows[i].maDonVi + ']',
                                value: data.data.rows[i].maDonVi
                            }
                            this.list_don_vi.push(obj);
                        }
                    }
                });
            },
        }
    }

</script>
<style scoped="scoped">
</style>
