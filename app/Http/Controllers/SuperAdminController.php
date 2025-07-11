<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SuperAdminController extends BaseController
{
    public function QuanLyCauHoi()
    {
        if(env('BAO_TRI')){
            return view("content.baotri");
        }
        return view('danhmuc.quanlycauhoi');
    }

    public function DonVi()
    {
        if(env('BAO_TRI')){
            return view("content.baotri");
        }
        return view('danhmuc.donvi');
    }

    public function TruongHoc()
    {
        if(env('BAO_TRI')){
            return view("content.baotri");
        }

        return view('danhmuc.truonghoc');
        return view('traCuu.truongHoc');
    }

    public function MonHoc()
    {
        if(env('BAO_TRI')){
            return view("content.baotri");
        }
        return view('danhmuc.monhoc');
    }

    public function TinhThanh()
    {
        if(env('BAO_TRI')){
            return view("content.baotri");
        }
        return view('danhmuc.tinhthanh');
    }

    public function QuanHuyen()
    {
        if(env('BAO_TRI')){
            return view("content.baotri");
        }
        return view('danhmuc.quanhuyen');
    }

    public function XaPhuong()
    {
        if(env('BAO_TRI')){
            return view("content.baotri");
        }
        return view('danhmuc.xaphuong');
    }

    public function ToThon()
    {
        if(env('BAO_TRI')){
            return view("content.baotri");
        }
        return view('danhmuc.tothon');
    }

    public function DanToc()
    {
        if(env('BAO_TRI')){
            return view("content.baotri");
        }
        return view('danhmuc.dantoc');
    }

    public function TonGiao()
    {
        if(env('BAO_TRI')){
            return view("content.baotri");
        }
        return view('danhmuc.tongiao');
    }

    public function ChuyenNganhDaoTao()
    {
        if(env('BAO_TRI')){
            return view("content.baotri");
        }
        return view('danhmuc.chuyennganhdaotao');
    }

    public function DoiTuongChinhSach()
    {
        if(env('BAO_TRI')){
            return view("content.baotri");
        }
        return view('danhmuc.doituongchinhsach');
    }

    public function LyDoBoHoc()
    {
        if(env('BAO_TRI')){
            return view("content.baotri");
        }
        return view('danhmuc.lydobohoc');
    }

    public function LoaiDoiTuong()
    {
        if(env('BAO_TRI')){
            return view("content.baotri");
        }
        return view('danhmuc.loaidoituong');
    }

    public function LinhVucDanhGiaVaPhatTrien()
    {
        if(env('BAO_TRI')){
            return view("content.baotri");
        }
        return view('danhmuc.linhvucdanhgiaphattrien');
    }

    public function ChiSoDanhGiaVaPhatTrien()
    {
        if(env('BAO_TRI')){
            return view("content.baotri");
        }
        return view('danhmuc.chisodanhgiaphattrien');
    }

    public function ChieuCaoCanNang()
    {
        if(env('BAO_TRI')){
            return view("content.baotri");
        }
        return view('danhmuc.chuanchieucaocannang');
    }

    public function QuanLyDoiTac()
    {

        if(env('BAO_TRI')){
            return view("content.baotri");
        }
        return view('danhmuc.quanlydoitac');
    }

    public function QuanLyNhomTieuChi()
    {
        if(env('BAO_TRI')){
            return view("content.baotri");
        }

        return view('danhmuc.quanlynhomtieuchi');
    }

    public function QuanLyTieuChi()
    {
        if(env('BAO_TRI')){
            return view("content.baotri");
        }
        return view('danhmuc.quanlytieuchi');

    }
    public function LichSuDongBoEmis(){

        if(env('BAO_TRI')){
            return view("content.baotri");
        }
        return view('danhmuc.lichsudongboemis');
    }
    public function BaoCaoQuanLyNhomTieuChi(){

        if(env('BAO_TRI')){
            return view("content.baotri");
        }
        return view('danhmuc.baocaoquanlynhomtieuchi');
    }
    public function BaoCaoQuanLyTieuChi(){

        if(env('BAO_TRI')){
            return view("content.baotri");
        }
        return view('danhmuc.baocaoquanlytieuchi');
    }
    public function CauHinhBaoCao(){

        if(env('BAO_TRI')){
            return view("content.baotri");
        }
        return view('danhmuc.cauhinhbaocao');
    }
    public function QuanLyBieuMau(){

        if(env('BAO_TRI')){
            return view("content.baotri");
        }
        return view('danhmuc.quanlybieumau');
    }
    public function PhanCapBieuMau(){

        if(env('BAO_TRI')){
            return view("content.baotri");
        }
        return view('danhmuc.phancapbieumau');
    }
    public function TraCuuLoi(){

        if(env('BAO_TRI')){
            return view("content.baotri");
        }
        return view('danhmuc.tracuuloi');
    }
    public function TraCuuDuLieu(){

        if(env('BAO_TRI')){
            return view("content.baotri");
        }
        return view('danhmuc.tracuudulieu');
    }
    public function TroGiup(){

        if(env('BAO_TRI')){
            return view("content.baotri");
        }
        return view('danhmuc.trogiup');
    }
    public function olapReport(){
        if(env('BAO_TRI')){
            return view("content.baotri");
        }
        return view('baocaodong.baocaoolap');
    }
}
