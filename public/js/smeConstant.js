
console.log("lấy dữ liệu SME");
let check_moet_code = localStorage["danh_sach_chuyen_nganh_dao_tao_khac_moet_code_sme"];
let check_mapping_code = localStorage["danh_sach_phan_ban_sme"];
$(document).ready(function(){
    $(".lienketmenu").click(function(event){
        console.log("Click link trên menu")
        let tmp1 = localStorage["danh_sach_chuyen_nganh_dao_tao_khac_moet_code_sme"];
        let tmp2 = localStorage["danh_sach_phan_ban_sme"];
        if(!tmp2){
            layToanBoSMEMappingCode();
        }
        if(!tmp1){
            layToanBoSMEMoetCode();
        }
    });
  });
if (!check_moet_code) {
    console.log("chưa có dữ liệu SME MoetCode")
    layToanBoSMEMoetCode();
} else {
    console.log("đã có dữ liệu SMEMoetCode");
}
if (!check_mapping_code) {
    console.log("chưa có dữ liệu SME Mapping")
    layToanBoSMEMappingCode();
} else {
    console.log("đã có dữ liệu SME Mapping");
}
function layToanBoSMEMoetCode() {
    console.log("lấy toàn bộ dữ liệu SME MoetCode")
    $.ajax({
        url: '/lay-sme-moet-code',
        type: 'GET',
        dataType: 'json',
        data: {
            type: '1',
        }
    }).done(function (ketqua) {
        console.log("kết quả trả về moetCode:");
        console.log(ketqua);
        if (ketqua.rc == 0) {
            ganKetQuaSMEMoetCode(ketqua.tableData)
        } else {}
        return;
    });
}
function layToanBoSMEMappingCode(){
    console.log("lấy toàn bộ dữ liệu SME MappingCode")
    $.ajax({
        url: '/lay-sme-mapping-code',
        type: 'GET',
        dataType: 'json',
        data: {
            type: '1',
        }
    }).done(function (ketqua) {
        console.log("kết quả trả về mappingCode:");
        console.log(ketqua);
        if (ketqua.rc == 0) {
            ganKetQuaSMEMappingCode(ketqua.tableData)
        } else {}
        return;
    });
}
function ganKetQuaSMEMoetCode(e) {
    console.log("gán kết quả cho danh sách SME moetCode:")
    let dulieu = e;
    console.log(dulieu)
    for (let i = 0; i < dulieu.length; i++) {
        let ldt = []
        for (let j = 0; j < dulieu[i].list_data.length; j++) {
            let obj = {
                name: dulieu[i].list_data[j].constantTitle + " - [" + dulieu[i].list_data[j].moetCode +"]",
                label: dulieu[i].list_data[j].constantTitle,
                value: dulieu[i].list_data[j].moetCode,
            }
            ldt.push(obj);
        }
        ganDuLieuSMEMoetCode(dulieu[i].constantType, ldt)
    }
}
function ganKetQuaSMEMappingCode(e) {
    console.log("gán kết quả cho danh sách SME moetCode:")
    let dulieu = e;
    console.log(dulieu)
    for (let i = 0; i < dulieu.length; i++) {
        let ldt = []
        for (let j = 0; j < dulieu[i].list_data.length; j++) {
            let obj = {
                name: dulieu[i].list_data[j].constantTitle + " - [" + dulieu[i].list_data[j].mappingCode +"]",
                label: dulieu[i].list_data[j].constantTitle,
                value: dulieu[i].list_data[j].mappingCode,
            }
            ldt.push(obj);
        }
        ganDuLieuSMEMappingCode(dulieu[i].constantType, ldt)
    }
}
function ganDuLieuSMEMappingCode(k, dt) {
    
    if (k == 'DM_BENH_VE_MAT') {
        localStorage["danh_sach_benh_ve_mat_sme"] = JSON.stringify(dt)
    }
    if (k == 'TINH_TRANG_DINH_DUONG') {
        localStorage["danh_sach_tinh_trang_dinh_duong_sme"] = JSON.stringify(dt)
    }
    if (k == 'THOI_DIEM_ROI_TRUONG') {
        localStorage["danh_sach_thoi_diem_roi_truong_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_TOT_NGHIEP') {
        localStorage["danh_sach_loai_tot_nghiep"] = JSON.stringify(dt)
    }
    if (k == 'DM_DANH_GIA_KQ_GIAO_DUC') {
        localStorage["danh_sach_danh_gia_ket_qua_giao_duc"] = JSON.stringify(dt)
    }
    if (k == 'DM_VUNG') {
        localStorage["danh_sach_danh_muc_vung"] = JSON.stringify(dt)
    }
    if (k == 'DM_DU_AN') {
        localStorage["danh_sach_danh_muc_du_an"] = JSON.stringify(dt)
    }
    if (k == 'DM_LOAI_TRUNG_TAM') {
        localStorage["danh_sach_danh_muc_loai_trung_tam"] = JSON.stringify(dt)
    }
    if (k == 'DM_LOAI_TRUONG') {
        localStorage["danh_sach_danh_muc_loai_truong"] = JSON.stringify(dt)
    }
    if (k == 'DM_TRUNG_TAM') {
        localStorage["danh_sach_danh_muc_trung_tam"] = JSON.stringify(dt)
    }
    if (k == 'DM_BO_SACH_GIAO_KHOA_SU_DUNG') {
        localStorage["danh_sach_bo_sach_giao_khoa_dang_dung"] = JSON.stringify(dt)
    }
    if (k == 'DM_NHOM_CAP_HOC') {
        localStorage["danh_sach_cap_hoc_2_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_KHOI') {
        localStorage["danh_sach_khoi_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_LY_DO_THOI_HOC') {
        localStorage["danh_sach_ly_do_thoi_hoc_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_DIEN_CHINH_SACH') {
        localStorage["danh_sach_dien_chinh_sach_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_NUOC') {
        localStorage["danh_sach_nuoc_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_TRANG_THAI_HOC_SINH') {
        localStorage["danh_sach_trang_thai_hoc_sinh_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_CAP_DAY_GV_MOET') {
        localStorage["danh_sach_cap_day_gv_moet_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_GIOI_TINH') {
        localStorage["danh_sach_gioi_tinh_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_CAP_HOC') {
        localStorage["danh_sach_cap_hoc_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_XA') {
        localStorage["danh_sach_xa_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_HUYEN') {
        localStorage["danh_sach_huyen_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_TINH') {
        localStorage["danh_sach_tinh_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_MON_HOC') {
        localStorage["danh_sach_mon_hoc_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_GIAI_DOAN_KQHT') {
        localStorage["danh_sach_giai_doan_kqht_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_MUC_DAT_CHUAN_QG_CLGD') {
        localStorage["danh_sach_chuan_quoc_gia_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_LOAI_HINH_TRUONG') {
        localStorage["danh_sach_loai_hinh_truong_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_LOAI_HINH_DAO_TAO') {
        localStorage["danh_sach_loai_hinh_dao_tao_sme"] = JSON.stringify(dt)
    }
    if(k=='NOI_CHUYEN_DI'){
        localStorage["danh_sach_chuyen_di_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_PHAN_BAN') {
        localStorage["danh_sach_phan_ban_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_LOP_DAO_TAO_BOI_DUONG') {
        localStorage["danh_sach_lop_dao_tao_boi_duong_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_HINH_THUC_DAO_TAO_HOC_TAP') {
        localStorage["danh_sach_hinh_thuc_dao_tao_hoc_tap_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_TIET_HOC_NGOAI_NGU') {
        localStorage["danh_sach_so_tiet_hoc_ngoai_ngu_sme"] = JSON.stringify(dt)
    }
    if (k == 'MA_CHUONG_TRINH_HOC_NN') {
        localStorage["danh_sach_chuong_trinh_hoc_ngoai_ngu_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_KIEU_LOP') {
        localStorage["danh_sach_lop_bo_tuc_thcs_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_TIET_HOC') {
        localStorage["danh_sach_so_tiet_hoc_tren_tuan_sme"] = JSON.stringify(dt)
    }
    if (k == 'MA_BUOI_HOC') {
        localStorage["danh_sach_buoi_hoc_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_NHOM_TUOI_MN') {
        localStorage["danh_sach_nhom_tuoi_mam_non_sme"] = JSON.stringify(dt)
    }
    if (k == 'THANH_PHAN_GIA_DINH') {
        localStorage["danh_sach_thanh_phan_gia_dinh_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_LOP_HUONG_NGHIEP_DAY_NGHE') {
        localStorage["danh_sach_huong_nghiep_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_HOC_BAN_TRU') {
        localStorage["danh_sach_hoc_ban_tru_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_SO_BUOI_HOC_TREN_TUAN') {
        localStorage["danh_sach_so_buoi_hoc_tren_tuan_sme"] = JSON.stringify(dt)
    }
    if (k == 'LOAI_NHAP_HOC') {
        localStorage["danh_sach_loai_nhap_hoc_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_LOAI_KHUYET_TAT') {
        localStorage["danh_sach_loai_khuyet_tat_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_KHU_VUC') {
        localStorage["danh_sach_khu_vuc_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_VUNG_KHO_KHAN') {
        localStorage["danh_sach_doi_tuong_uu_tien_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_DOI_TUONG_CHINH_SACH') {
        localStorage["danh_sach_doi_tuong_chinh_sach_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_NHOM_MAU') {
        localStorage["danh_sach_nhom_mau_sme"] = JSON.stringify(dt)
    }
    if (k == 'MA_LOAI_HINH_BOI_DUONG') {
        localStorage["danh_sach_loai_hinh_boi_duong_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_KHEN_THUONG_GV') {
        localStorage["danh_sach_khen_thuong_can_bo_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_HINH_THUC_DAO_TAO') {
        localStorage["danh_sach_hinh_thuc_dao_tao_sme"] = JSON.stringify(dt)
    }
    if (k == 'MA_KET_QUA_NGOAI_NGU') {
        localStorage["danh_sach_ket_qua_boi_duong_ngoai_ngu_sme"] = JSON.stringify(dt)
    }
    if (k == 'MA_KET_QUA_SU_PHAM') {
        localStorage["danh_sach_ket_qua_boi_duong_su_pham_sme"] = JSON.stringify(dt)
    }
    if (k == 'MA_HINH_THUC') {
        localStorage["danh_sach_hinh_thuc_sme"] = JSON.stringify(dt)
    }
    if (k == 'MA_THOI_LUONG_BOI_DUONG') {
        localStorage["danh_sach_thoi_luong_boi_duong_sme"] = JSON.stringify(dt)
    }
    if (k == 'MA_DON_VI_TO_CHUC') {
        localStorage["danh_sach_don_vi_to_chuc_sme"] = JSON.stringify(dt)
    }
    if (k == 'MA_DON_VI') {
        localStorage["danh_sach_don_vi_sme"] = JSON.stringify(dt)
    }
    if (k == 'MA_KHOA_DAO_TAO_NGOAI_NGU') {
        localStorage["danh_sach_khoa_dao_tao_ngoai_ngu_sme"] = JSON.stringify(dt)
    }
    if (k == 'MA_KHOA_DAO_TAO_SU_PHAM') {
        localStorage["danh_sach_khoa_dao_tao_su_pham_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_BAC_LUONG') {
        localStorage["danh_sach_bac_luong_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_KQ_CHUAN_NGHE_NGHIEP') {
        localStorage["danh_sach_danh_gia_chuan_nghe_nghiep_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_GV_TONG_PTRACH_DOI_GIOI') {
        localStorage["danh_sach_giao_vien_tong_phu_trach_gioi_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_GIAO_VIEN_CHU_NHIEM_GIOI') {
        localStorage["danh_sach_giao_vien_chu_nhiem_gioi_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_GIAO_VIEN_GIOI') {
        localStorage["danh_sach_giao_vien_day_gioi_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_DG_VIEN_CHUC') {
        localStorage["danh_sach_danh_gia_vien_chuc_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_CHUNG_CHI_TIENG_DTOC_TSO') {
        localStorage["danh_sach_chung_chi_tieng_dan_toc_thieu_so_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_TRINH_DO') {
        localStorage["danh_sach_trinh_do_khac_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_CHUYEN_MON') {
        localStorage["danh_sach_chuyen_nganh_dao_tao_khac_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_TRINH_DO') {
        localStorage["danh_sach_trinh_do_chinh_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_CHUYEN_MON') {
        localStorage["danh_sach_chuyen_nganh_dao_tao_chinh_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_TRINH_DO_TIN_HOC') {
        localStorage["danh_sach_trinh_do_tin_hoc_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_KHUNG_NLUC_NNGU') {
        localStorage["danh_sach_khung_nang_luc_ngoai_ngu_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_LOAI_CCHI_NNGU') {
        localStorage["danh_sach_loai_chung_chi_ngoai_ngu_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_NHOM_CCHI_NNGU') {
        localStorage["danh_sach_nhom_chung_chi_ngoai_ngu_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_TRINH_DO_NGOAI_NGU') {
        localStorage["danh_sach_trinh_do_ngoai_ngu_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_NGOAI_NGU') {
        localStorage["danh_sach_ngoai_ngu_chinh_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_BOI_DUONG_THAY_SACH') {
        localStorage["danh_sach_boi_duong_thay_sach_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_BOI_DUONG_CBQL_COT_CAN') {
        localStorage["danh_sach_boi_duong_can_bo_cot_can_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_BOI_DUONG_NVU') {
        localStorage["danh_sach_boi_duong_nghiep_vu_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_TRINH_DO_QLGD') {
        localStorage["danh_sach_trinh_do_quan_ly_giao_duc_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_TRINH_DO_LLCT') {
        localStorage["danh_sach_trinh_do_ly_luan_chinh_tri_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_TRINH_DO_CHUYEN_MON') {
        localStorage["danh_sach_trinh_do_chuyen_mon_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_BOI_DUONG_TX') {
        localStorage["danh_sach_ket_qua_boi_duong_thuong_xuyen_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_NGACH_CC') {
        localStorage["danh_sach_ngach_hang_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_NHIEM_VU_KIEM_NHIEM') {
        localStorage["danh_sach_nhiem_vu_kiem_nhiem_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_HINH_THUC_HOP_DONG') {
        localStorage["danh_sach_hinh_thuc_hop_dong_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_LOAI_CAN_BO') {
        localStorage["danh_sach_chuc_vu_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_MON_DAY_GV') {
        localStorage["danh_sach_mon_day_giao_vien_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_NHOM_CAN_BO') {
        localStorage["danh_sach_loai_can_bo_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_DAN_TOC') {
        localStorage["danh_sach_dan_toc_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_NUOC') {
        localStorage["danh_sach_quoc_tich_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_TON_GIAO') {
        localStorage["danh_sach_ton_giao_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_TRANG_THAI_CAN_BO') {
        localStorage["danh_sach_trang_thai_can_bo_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_NGANH_DAO_TAO') {
        localStorage["danh_sach_nganh_dao_tao_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_TRINH_DO_VAN_HOA') {
        localStorage["danh_sach_trinh_do_van_hoa_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_TRINH_DO_QLNN') {
        localStorage["danh_sach_trinh_do_quan_ly_nha_nuoc_sme"] = JSON.stringify(dt)
    }
}
function ganDuLieuSMEMoetCode(k, dt) {
    if (k == 'THOI_DIEM_ROI_TRUONG') {
        localStorage["danh_sach_thoi_diem_roi_truong_moet_code_sme"] = JSON.stringify(dt)
    }
    if (k == 'HINH_THUC_HO_TRO') {
        localStorage["danh_sach_hinh_thuc_hoc_tro_moet_code_sme"] = JSON.stringify(dt)
    }
    if (k == 'MA_LOAI_HINH_BOI_DUONG') {
        localStorage["danh_sach_loai_hinh_boi_duong_moet_code_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_KHEN_THUONG_GV') {
        localStorage["danh_sach_khen_thuong_can_bo_moet_code_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_KY_LUAT_GV') {
        localStorage["danh_sach_ky_luat_can_bo_moet_code_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_HINH_THUC_DAO_TAO') {
        localStorage["danh_sach_hinh_thuc_dao_tao_moet_code_sme"] = JSON.stringify(dt)
    }
    if (k == 'MA_KET_QUA_NGOAI_NGU') {
        localStorage["danh_sach_ket_qua_boi_duong_ngoai_ngu_moet_code_sme"] = JSON.stringify(dt)
    }
    if (k == 'MA_KET_QUA_SU_PHAM') {
        localStorage["danh_sach_ket_qua_boi_duong_su_pham_moet_code_sme"] = JSON.stringify(dt)
    }
    if (k == 'MA_HINH_THUC') {
        localStorage["danh_sach_hinh_thuc_moet_code_sme"] = JSON.stringify(dt)
    }
    if (k == 'MA_THOI_LUONG_BOI_DUONG') {
        localStorage["danh_sach_thoi_luong_boi_duong_moet_code_sme"] = JSON.stringify(dt)
    }
    if (k == 'MA_DON_VI_TO_CHUC') {
        localStorage["danh_sach_don_vi_to_chuc_moet_code_sme"] = JSON.stringify(dt)
    }
    if (k == 'MA_DON_VI') {
        localStorage["danh_sach_don_vi_moet_code_sme"] = JSON.stringify(dt)
    }
    if (k == 'MA_KHOA_DAO_TAO_NGOAI_NGU') {
        localStorage["danh_sach_khoa_dao_tao_ngoai_ngu_moet_code_sme"] = JSON.stringify(dt)
    }
    if (k == 'MA_KHOA_DAO_TAO_SU_PHAM') {
        localStorage["danh_sach_khoa_dao_tao_su_pham_moet_code_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_BAC_LUONG') {
        localStorage["danh_sach_bac_luong_moet_code_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_CHUYEN_MON') {
        localStorage["danh_sach_chuyen_nganh_dao_tao_khac_moet_code_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_TRINH_DO_NGOAI_NGU') {
        localStorage["danh_sach_trinh_do_ngoai_ngu_moet_code_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_NGOAI_NGU') {
        localStorage["danh_sach_ngoai_ngu_chinh_moet_code_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_TRINH_DO_CHUYEN_MON') {
        localStorage["danh_sach_trinh_do_chuyen_mon_moet_code_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_NGACH_CC') {
        localStorage["danh_sach_ngach_hang_moet_code_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_KQ_CHUAN_NGHE_NGHIEP') {
        localStorage["danh_sach_danh_gia_chuan_nghe_nghiep_moet_code_sme"] = JSON.stringify(dt)
    }
    if (k == 'DM_BO_SACH_GIAO_KHOA_SU_DUNG') {
        localStorage["danh_sach_bo_sach_giao_khoa_sme"] = JSON.stringify(dt)
    }
}
