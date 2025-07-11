<template>
    <div>
        <lichSuNguoiDung :show="show_lich_su" @close="show_lich_su=false">
        </lichSuNguoiDung>
        <HuongDan :show="show_huong_dan" @close="show_huong_dan=false">
        </HuongDan>
        <DoiMatKhau :show="hien_thi_doi_mat_khau" :item="thongtin" @close="hien_thi_doi_mat_khau=false">
        </DoiMatKhau>
        <div v-if="show_thongtin_phienban">
            <ThongTinPhienBan @close="show_thongtin_phienban=false"></ThongTinPhienBan>
        </div>
        <el-dialog
            title="Chương trình khảo sát ý kiến khách hàng"
            append-to-body
            :visible.sync="show_khao_sat">
            <el-row :gutter="24" style="margin-bottom: 9px !important;">
                <el-col :span="24" >
                    <span style="word-break: break-word;font-size: 16px">Nhằm nâng cao chất lượng dịch vụ. Kính mong quý vị cùng đánh giá chất lượng dịch vụ của chúng tôi bằng cách đưa ra ý kiến trong đợt khảo sát.
                    Sự hợp tác của quý vị sẽ giúp chúng tôi đáp ứng tốt hơn nhu cầu của quý vị về dịch vụ của sản phẩm</span>
                </el-col>
                <el-col :span="24">
                    <label class="form-check-inline">
                        <input class="form-check-inline" type="checkbox" v-model="daThamGia" @change="chonAnKhaoSat" /> Đã tham gia. Không hiển thị lại
                    </label>
<!--                    <el-checkbox style="border: #000" @change="chonAnKhaoSat" v-model="daThamGia"></el-checkbox>-->
                </el-col>
            </el-row>
            <span slot="footer" class="dialog-footer">
                            <el-button @click="dongKhaoSat" class="pt-2 bt-phu" size="mini">Đóng</el-button>
                            <el-button @click="thamGiaKhaoSat" class="bt-chinh" size="mini" type="success">Tham gia khảo sát</el-button>
                        </span>
        </el-dialog>
    </div>
</template>
<script>
import Vue from 'vue';
import ElementUI from 'element-ui'
import locale from '../../utils/custom-elementui-locale'
Vue.use(ElementUI, { locale })
import DoiMatKhau from './MoDalDoiMatKhau';
import lichSuNguoiDung from './lichSuNguoiDung.vue';
import HuongDan from './huongDanSuDung.vue';
import ThongTinPhienBan from './HuongDanFaq';

export default {
    props: [],
    components: {
        "HuongDan": HuongDan,
        "DoiMatKhau": DoiMatKhau,
        "ThongTinPhienBan": ThongTinPhienBan,
        "lichSuNguoiDung": lichSuNguoiDung,
    },
    computed: {},
    data() {
        return {
            show_lich_su: false,
            daThamGia: false,
            show_khao_sat: false,
            hien_thi_doi_mat_khau: false,
            show_huong_dan: false,
            show_thongtin_phienban: false,
            thongtin: JSON.parse(window.userInfo),
        }
    },

    mounted() {
        console.log("Mounted đổi mật khẩu:...")
        console.log(this.thongtin)
        let check_khao_sat = localStorage["chuaThamGiaKhaoSat"]
        console.error('check_khao_sat')
        console.error(check_khao_sat)

        if (check_khao_sat == undefined || !check_khao_sat || check_khao_sat == false || check_khao_sat == 'false') {
           if(this.thongtin.ma_so!=83&&this.thongtin.ma_so!=19){
            this.show_khao_sat = true;
           }
        } else {
            console.error('không hiện khảo sát')
            // this.show_khao_sat = true;
        }
        if (this.thongtin.doipass||this.thongtin.doiPassMd) {
            // this.hien_thi_doi_mat_khau = true;
        }
        $(document).on("click", ".lich-su-nguoi-dung", () => {
            console.log('hiển thị hướng dấn 123456789')
            this.show_lich_su = true;
        });
        $(document).on("click", ".huong-dan-su-dung", () => {
            console.log('hiển thị hướng dấn 123456789')
            if (this.thongtin.role != 1) {
                this.showHuongDan();
            } else {
                this.show_huong_dan = true;
            }
        });
        $(document).on("click", ".doimatkhau", () => {
            this.hien_thi_doi_mat_khau = true;
        });
        $(document).on("click", ".huongdan", () => {
            console.log("ấn hướng dẫn");
            this.show_thongtin_phienban = true;
        });
    },
    watch: {},
    methods: {
        dongKhaoSat() {
            localStorage.setItem('chuaThamGiaKhaoSat', 'true');
            this.show_khao_sat = false;
        },
        chonAnKhaoSat() {
            console.error('chonAnKhaoSat')
            if (this.daThamGia) {
                console.error('case 1')
                localStorage.setItem('chuaThamGiaKhaoSat', 'true');
            } else {
                localStorage.setItem('chuaThamGiaKhaoSat', 'false');
                console.error('case 2')
            }

        },
        thamGiaKhaoSat() {
            this.dongKhaoSat();
            let url = 'https://docs.google.com/forms/d/e/1FAIpQLSc_VS5GCHkfFg8jT6OnxJMNeoupbakkuGmQk2FALIq1XFeOdQ/viewform';
            window.open(url, '_blank');
        },
        showHuongDan() {
            console.error('Show hướng dẫn:')
            console.error(this.thongtin)
            let url = '';
            if (this.thongtin.role == 2 || this.thongtin.role == 3) {
                url = '/templateImport/15062022_HDSD_Edc_SGD_v2.0.pdf';
            }
            if (this.thongtin.role == 4) {
                url = '/templateImport/15062022_HDSD_Edc_PGD_v2.0.pdf';
            }
            if (this.thongtin.role == 5) {
                url = '/templateImport/15062022_HDSD_Edc_TRG_v2.0.pdf';
            }
            window.open(url, '_blank', 'location=yes,scrollbars=yes,status=yes');
        },
        thongBao(t, e) {
            let msg = "";
            let cl = "";
            if (e) {
                msg = e;
            }
            let type = "success";
            if (t) {
                type = t
            }
            if (type == "success") {
                cl = "dts-noty-success"
            }
            if (type == "warning") {
                cl = "dts-noty-warning"
            }
            if (type == "error") {
                cl = "dts-noty-error"
            }
            if (type == "info") {
                cl = "dts-noty-info"
            }
            this.$message({
                customClass: cl,
                showClose: true,
                message: msg,
                type: t,
                duration: 5000
            });
        },
    }
}

</script>

<style scoped>
::v-deep .el-checkbox__inner {
    border: 1px solid #000;
    margin-top: -2px !important;
}
.el-col{

}
</style>
