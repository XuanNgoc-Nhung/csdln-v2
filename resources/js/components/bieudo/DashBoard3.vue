<template>
    <div>
        <div class="card-bieu-do">
            <el-row :gutter="24" style="margin-bottom:0px !important;" class="">
                <el-col :lg="12" :xl="8">
                    <label class="typo__label">Đơn vị</label>
                    <div v-if="thongtin.role!=5">
                        <eselect style="width:100%" @change="layLaiDuLieuGiaoVien" multiple :disabled="thongtin.role==4"
                            no-match-text="Không tìm thấy bản ghi nào" no-data-text="danh sách lựa chọn trống"
                            collapse-tags v-model="danhSachDonVi" :placeholder="'Chọn'" filterable
                            :data="danh_sach_don_vi" :fields="['tenDonVi','maDonVi']" />
                    </div>
                    <div v-else>
                        <input type="text" :value='tenDonViDangNhap' class="form-control" disabled>
                    </div>
                </el-col>
                <el-col :lg="6" :xl="3">
                    <label class="typo__label">Cấp học</label>
                    <div v-if="thongtin.role!=5">
                        <eselect style="width:100%" @change="layLaiDuLieuGiaoVien" multiple
                            no-match-text="Không tìm thấy bản ghi nào" no-data-text="danh sách lựa chọn trống"
                            collapse-tags v-model="danhSachCapHoc" :placeholder="'Chọn'" filterable
                            :data="danh_sach_cap_hoc_full" :fields="['name','id']" />
                    </div>
                    <div v-else>
                        <input type="text" :value='capHocDangNhap' class="form-control" disabled>
                    </div>
                </el-col>
                <el-col :lg="6" :xl="3">
                    <label class="typo__label">Năm học</label>
                    <el-select class="input-with-select" v-model="namHoc" no-match-text="Không tìm thấy bản ghi nào"
                               no-data-text="danh sách lựa chọn trống" collapse-tags style="width:100%" filterable
                               placeholder="Chọn">
                        <el-option v-for="item in list_nam_hoc" :key="item.id" :label="item.name" :value="item.id">
                        </el-option>
                    </el-select>
                </el-col>
                <el-col :lg="12" :xl="8">
                    <label class="typo__label">Trường học</label>
                    <div v-if="thongtin.role!=5">
                        <eselect style="width:100%" multiple no-match-text="Không tìm thấy bản ghi nào"
                            no-data-text="danh sách lựa chọn trống" collapse-tags v-model="danhSachTruongHoc"
                            :placeholder="'Chọn'" filterable :data="danh_sach_truong_hoc"
                            :fields="['name','value']" />
                    </div>
                    <div v-else>
                        <input type="text" :value='truongHocDangNhap' class="form-control" disabled>
                    </div>
                </el-col>

                <el-col :lg="4" :xl="2" class="">

                    <label class="typo__label" style="color:transparent">Đơn vị</label>
                    <el-button plain size="mini" class="bt-chinh" style=" width:100%;font-size:14px; padding-left:10px;"
                        @click.prevent="getAllDataChart" type="success">Thống kê
                    </el-button>
                </el-col>
            </el-row>
        </div>
        <div class="mobi">
            <div gutter="24" class="row" v-if="thongtin.ma_so!=10&&thongtin.ma_so!=83">
                <div v-if="false" :span="6">
                    <div class="grid-content bg-purple-light" style="position:relative">
                        <div class="dts-card-body thongketangiamsl" style="height: inherit">
                            <p v-if="danhSachDonVi.length==0">{{ tenDonViDangNhap }} </p>
                            <p v-else="danhSachDonVi.length>0">
                                {{ getTenDonVi(danhSachDonVi[0]) }}</p>
                            <p style="font-size:14px !important"><span v-if="danhSachDonVi.length>1">và
                                    <span>{{ danhSachDonVi.length - 1 }} đơn vị
                                        khác</span></span></p>
                        </div>
                    </div>
                </div>
                <div style="margin-bottom: 16px" class="col-md-4 col-sm-6">
                    <div class="grid-content bg-purple-light">
                        <!-- <div class="dts-card-header">
                        <span class="dts-card-title">Trường học</span>
                        <span class="dts-right"><a href="#" @click.prevent="layDuLieuTruongHoc"
                                title="Lấy lại dữ liệu thống kê"><i class="fa-solid fa-rotate-right"></i></a>
                        </span>
                    </div> -->
                        <div v-loading="loadDuLieuTruongHoc" element-loading-background="rgba(0, 0, 0, 0.5)" style="background-color: #fff;padding: 20px;border-radius: 8px">
                            <div v-if="!loadDuLieuTruongHoc" >
                                <div v-if="thongtin.role!=5" class="layout-card">
                                    <div style="">
                                        <svg width="72" height="73" viewBox="0 0 72 73" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <rect y="0.5" width="72" height="72" rx="36" fill="#01856B" />
                                            <g clip-path="url(#clip0_43_806)">
                                                <path
                                                    d="M36.0001 38.3333C35.6465 38.3333 35.3073 38.4738 35.0573 38.7239C34.8072 38.9739 34.6667 39.3131 34.6667 39.6667C34.6667 40.0203 34.8072 40.3594 35.0573 40.6095C35.3073 40.8595 35.6465 41 36.0001 41C36.3537 41 36.6928 40.8595 36.9429 40.6095C37.1929 40.3594 37.3334 40.0203 37.3334 39.6667C37.3334 39.3131 37.1929 38.9739 36.9429 38.7239C36.6928 38.4738 36.3537 38.3333 36.0001 38.3333Z"
                                                    fill="white" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M48 33.5093L37.3333 28.176V25H45.3333V17H34.6667V28.176L24 33.5093V38.3333H18.6667V54.3333H16V57H32V46.3333H40V57H56V54.3333H53.3333V38.3333H48V33.5093ZM50.6667 54.3333V41H48V54.3333H50.6667ZM24 54.3333H21.3333V41H24V54.3333ZM32 39.6667C32 38.6058 32.4214 37.5884 33.1716 36.8382C33.9217 36.0881 34.9391 35.6667 36 35.6667C37.0609 35.6667 38.0783 36.0881 38.8284 36.8382C39.5786 37.5884 40 38.6058 40 39.6667C40 40.7275 39.5786 41.7449 38.8284 42.4951C38.0783 43.2452 37.0609 43.6667 36 43.6667C34.9391 43.6667 33.9217 43.2452 33.1716 42.4951C32.4214 41.7449 32 40.7275 32 39.6667Z"
                                                    fill="white" />
                                                <path d="M37.3334 57V49H34.6667V57H37.3334Z" fill="white" />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_43_806">
                                                    <rect width="40" height="40" fill="white"
                                                        transform="translate(16 17)" />
                                                </clipPath>
                                            </defs>
                                        </svg>

                                        <!-- <img src="../../../../public/images/card-school.svg" /> -->
                                    </div>
                                    <div class="content-card">
                                        <div class="content-item">
                                            <div class="name">Trường học</div>
                                            <div class="number">

                                                {{
                                                    duLieuTangGiamTruongHoc.currentAmount.toLocaleString()
                                                }}
                                            </div>
                                        </div>
                                        <div class="tracker">
                                            <span :style="{
                                                backgroundColor: duLieuTangGiamTruongHoc.status=='augment' ? '#E2FFEC' : '#FFE2E2',
                                                color: duLieuTangGiamTruongHoc.status=='augment' ? '#01856B' : '#B60000',
                                                borderRadius: '5px',
                                                padding:'2px 5px',
                                                marginRight:'10px'
                                              }">
                                                <span v-if="duLieuTangGiamTruongHoc.status=='augment'">
                                                    <svg width="17" height="17" viewBox="0 0 17 17" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <g clip-path="url(#clip0_342_19660)">
                                                            <path
                                                                d="M11.334 4.50002L8.66732 1.83335M8.66732 1.83335L6.00065 4.50002M8.66732 1.83335L8.66732 15.1667"
                                                                stroke="#01856B" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round" />
                                                        </g>
                                                        <defs>
                                                            <clipPath id="clip0_342_19660">
                                                                <rect width="16" height="16" fill="white"
                                                                    transform="matrix(-1 0 0 -1 16.667 16.5)" />
                                                            </clipPath>
                                                        </defs>
                                                    </svg>


                                                </span>
                                                <span v-else>
                                                    <svg width="17" height="17" viewBox="0 0 17 17" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <g clip-path="url(#clip0_34_559)">
                                                            <path
                                                                d="M5.6665 12.5L8.33317 15.1667M8.33317 15.1667L10.9998 12.5M8.33317 15.1667V1.83334"
                                                                stroke="#B60000" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round" />
                                                        </g>
                                                        <defs>
                                                            <clipPath id="clip0_34_559">
                                                                <rect width="16" height="16" fill="white"
                                                                    transform="translate(0.333252 0.5)" />
                                                            </clipPath>
                                                        </defs>
                                                    </svg>

                                                </span>
                                                {{ duLieuTangGiamTruongHoc.percent.toFixed(2) }}%
                                            </span>
                                            so với năm trước ({{ duLieuTangGiamTruongHoc.amount.toLocaleString() }})
                                        </div>
                                    </div>
                                </div>
                                <div v-else>
                                    <p> {{ truongHocDangNhap }}</p>
                                </div>
                            </div>
                            <div v-else style="height : 100px">
                                <p class="text-center">Đang thống kê...</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="margin-bottom: 16px" class="col-md-4 col-sm-6">
                    <div class="grid-content bg-purple-light">
                        <!-- <div class="dts-card-header">
                        <span class="dts-card-title">Giáo viên</span>
                        <span class="dts-right"><a href="#" @click.prevent="layDuLieuGiaoVien"
                                title="Lấy lại dữ liệu thống kê"><i class="fa-solid fa-rotate-right"></i></a>
                        </span>
                    </div> -->
                        <div v-loading="loadDuLieuGiaoVien" element-loading-background="rgba(0, 0, 0, 0.5)" style="background-color: #fff;padding: 20px;border-radius: 8px">
                            <div v-if="!loadDuLieuGiaoVien" class="layout-card">
                                <div style="">
                                    <svg width="73" height="73" viewBox="0 0 73 73" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect x="0.333252" y="0.5" width="72" height="72" rx="36" fill="#01856B" />
                                        <path
                                            d="M36.2084 37C41.2716 37 45.3751 32.8965 45.3751 27.8333C45.3751 22.7702 41.2716 18.6667 36.2084 18.6667C31.1453 18.6667 27.0417 22.7702 27.0417 27.8333C27.0417 32.8965 31.1453 37 36.2084 37ZM43.0691 39.3346L39.6459 53.0417L37.3542 43.3021L39.6459 39.2917H32.7709L35.0626 43.3021L32.7709 53.0417L29.3477 39.3346C24.2416 39.5781 20.1667 43.7532 20.1667 48.9167V51.8958C20.1667 53.7936 21.7065 55.3333 23.6042 55.3333H48.8126C50.7104 55.3333 52.2501 53.7936 52.2501 51.8958V48.9167C52.2501 43.7532 48.1752 39.5781 43.0691 39.3346Z"
                                            fill="white" />
                                    </svg>

                                    <!-- <img src="../../../../public/images/card-teacher.svg" /> -->
                                </div>
                                <div class="content-card">
                                    <div class="content-item">
                                        <div class="name">Giáo viên</div>
                                        <div class="number ">
                                            {{
                                                    duLieuTangGiamGiaoVien.currentAmount.toLocaleString()
                                                }}
                                        </div>
                                    </div>
                                    <!-- <div class="tracker">
                                        <img class="img-tracker" v-if="duLieuTangGiamGiaoVien.status"
                                            :class="{ transform: duLieuTangGiamGiaoVien.status == 'augment' }"
                                            src="../../../../public/images/tracker-teacher.svg" />
                                        {{ getStatus(duLieuTangGiamGiaoVien.status) }}
                                        {{ duLieuTangGiamGiaoVien.percent.toFixed(2) }}%
                                        so với năm trước
                                    </div> -->

                                    <div class="tracker">
                                        <span :style="{
                                            backgroundColor: duLieuTangGiamGiaoVien.status=='augment' ? '#E2FFEC' : '#FFE2E2',
                                            color: duLieuTangGiamGiaoVien.status=='augment' ? '#01856B' : '#B60000',
                                            borderRadius: '5px',
                                            padding:'2px 5px',
                                            marginRight:'10px'
                                          }">
                                            <span v-if="duLieuTangGiamGiaoVien.status=='augment'">
                                                <svg width="17" height="17" viewBox="0 0 17 17" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_342_19660)">
                                                        <path
                                                            d="M11.334 4.50002L8.66732 1.83335M8.66732 1.83335L6.00065 4.50002M8.66732 1.83335L8.66732 15.1667"
                                                            stroke="#01856B" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_342_19660">
                                                            <rect width="16" height="16" fill="white"
                                                                transform="matrix(-1 0 0 -1 16.667 16.5)" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>


                                            </span>
                                            <span v-else>
                                                <svg width="17" height="17" viewBox="0 0 17 17" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_34_559)">
                                                        <path
                                                            d="M5.6665 12.5L8.33317 15.1667M8.33317 15.1667L10.9998 12.5M8.33317 15.1667V1.83334"
                                                            stroke="#B60000" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_34_559">
                                                            <rect width="16" height="16" fill="white"
                                                                transform="translate(0.333252 0.5)" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>
                                            </span>
                                            {{ duLieuTangGiamGiaoVien.percent.toFixed(2) }}%
                                        </span>
                                        so với năm trước ({{ duLieuTangGiamGiaoVien.amount.toLocaleString() }})
                                    </div>
                                </div>
                            </div>
                            <div v-else style="height : 100px">
                                <p class="text-center">Đang thống kê...</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="margin-bottom: 16px" class="col-md-4 col-sm-6">
                    <div class="grid-content bg-purple-light">
                        <!-- <div class="dts-card-header">
                        <span class="dts-card-title">Học sinh</span>
                        <span class="dts-right"><a href="#" @click.prevent="layDuLieuHocSinh"
                                title="Lấy lại dữ liệu thống kê"><i class="fa-solid fa-rotate-right"></i></a>
                        </span>
                    </div> -->
                        <div v-loading="loadDuLieuHocSinh" element-loading-background="rgba(0, 0, 0, 0.5)" style="background-color: #fff;padding: 20px;border-radius: 8px;">
                            <div v-if="!loadDuLieuHocSinh" class="layout-card">
                                <div style="">
                                    <svg width="73" height="73" viewBox="0 0 73 73" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect x="0.666748" y="0.5" width="72" height="72" rx="36" fill="#01856B" />
                                        <path
                                            d="M44.5 31.1667C44.5 35.4639 41.0194 38.9444 36.7222 38.9444C32.425 38.9444 28.9444 35.4639 28.9444 31.1667L29.1583 29.3389L23.1111 26.3056L36.7222 19.5L50.3333 26.3056V36.0278H48.3888V27.2778L44.2861 29.3389L44.5 31.1667ZM36.7222 42.8333C45.3166 42.8333 52.2777 46.3139 52.2777 50.6111V54.5H21.1666V50.6111C21.1666 46.3139 28.1277 42.8333 36.7222 42.8333Z"
                                            fill="white" />
                                    </svg>

                                    <!-- <img src="../../../../public/images/card-student.svg" /> -->
                                </div>
                                <div class="content-card">
                                    <div class="content-item">
                                        <div class="name">Học sinh</div>
                                        <div class="number ">

                                            {{
                                                    duLieuTangGiamHocSinh.currentAmount.toLocaleString()
                                                }}
                                        </div>
                                    </div>
                                    <div class="tracker">
                                        <span :style="{
                                            backgroundColor: duLieuTangGiamHocSinh.status=='augment' ? '#E2FFEC' : '#FFE2E2',
                                            color: duLieuTangGiamHocSinh.status=='augment' ? '#01856B' : '#B60000',
                                            borderRadius: '5px',
                                            padding:'2px 5px',
                                            marginRight:'10px'
                                          }">
                                            <span v-if="duLieuTangGiamHocSinh.status=='augment'">
                                                <svg width="17" height="17" viewBox="0 0 17 17" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_342_19660)">
                                                        <path
                                                            d="M11.334 4.50002L8.66732 1.83335M8.66732 1.83335L6.00065 4.50002M8.66732 1.83335L8.66732 15.1667"
                                                            stroke="#01856B" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_342_19660">
                                                            <rect width="16" height="16" fill="white"
                                                                transform="matrix(-1 0 0 -1 16.667 16.5)" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>


                                            </span>
                                            <span v-else>
                                                <svg width="17" height="17" viewBox="0 0 17 17" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_34_559)">
                                                        <path
                                                            d="M5.6665 12.5L8.33317 15.1667M8.33317 15.1667L10.9998 12.5M8.33317 15.1667V1.83334"
                                                            stroke="#B60000" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_34_559">
                                                            <rect width="16" height="16" fill="white"
                                                                transform="translate(0.333252 0.5)" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                            </span>
                                            {{ duLieuTangGiamHocSinh.percent.toFixed(2) }}%
                                        </span>
                                        so với năm trước ({{ duLieuTangGiamHocSinh.amount.toLocaleString() }})
                                    </div>
                                </div>
                            </div>
                            <div v-else style="height : 100px">
                                <p class="text-center">Đang thống kê...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-bieu-do" style="margin-top:16px">
            <el-row :gutter="24">
                <el-col :span="24">
                    <div class="centerBetweenFlex">
                        <h5><i class="fas fa-school"></i> Trường học</h5>
                        <div class="buttonR">
                            <el-button class="bt-phu" plain type="success" size="mini"
                                @click.prevent="chuyenLinkTraCuuTruongHoc">Chi tiết
                            </el-button>
                        </div>
                    </div>
                </el-col>
                <el-col :md="12" :lg="8">
                    <div class="dts-moibieudo grid-content bg-purple-light">
                        <div class="dts-card-header">
                            <span class="dts-card-title">Tổng quan</span>
                            <span class="dts-right"><a href="#" @click.prevent="getDuLieuTruongHocTongQuan"
                                    title="Lấy lại dữ liệu thống kê"><i class="fa-solid fa-rotate-right"></i></a>
                            </span>
                        </div>
                        <div class="dts-card-body" v-loading="loadTruongHoc.tongQuan"
                            element-loading-background="rgba(0, 0, 0, 0.8)">
                            <div>
                                <!-- <BieuDoTron2 :dulieu="duLieuTruongHoc.tongQuan"></BieuDoTron2> -->
                                <BieuDoTron :dulieu="duLieuTruongHoc.tongQuan" />
                            </div>
                        </div>
                    </div>
                </el-col>
                <el-col :md="12" :lg="8">
                    <div class="dts-moibieudo grid-content bg-purple-light">
                        <div class="dts-card-header">
                            <span class="dts-card-title">Chất lượng đào tạo</span>
                            <span class="dts-right"><a href="#" @click.prevent="getDuLieuTruongHocChatLuongDaoTao"
                                    title="Lấy lại dữ liệu thống kê"><i class="fa-solid fa-rotate-right"></i></a>
                            </span>
                        </div>
                        <div class="dts-card-body" v-loading="loadTruongHoc.chatLuongDaoTao"
                            element-loading-background="rgba(0, 0, 0, 0.8)">
                            <div>
                                <BieuDoCotChong :dulieu="duLieuTruongHoc.chatLuongDaoTao" />
                            </div>
                        </div>
                    </div>
                </el-col>
                <el-col :md="12" :lg="8">
                    <div class="dts-moibieudo grid-content bg-purple-light">
                        <div class="dts-card-header">
                            <span class="dts-card-title">Loại hình đào tạo</span>
                            <span class="dts-right"><a href="#" @click.prevent="getDuLieuTruongHocLoaiHinhDaoTao"
                                    title="Lấy lại dữ liệu thống kê"><i class="fa-solid fa-rotate-right"></i></a>
                            </span>
                        </div>
                        <div class="dts-card-body" v-loading="loadTruongHoc.loaiHinhDaoTao"
                            element-loading-background="rgba(0, 0, 0, 0.8)">
                            <div>
                                <BieuDoCotChong :dulieu="duLieuTruongHoc.loaiHinhDaoTao" />
                            </div>
                        </div>
                    </div>
                </el-col>
            </el-row>
        </div>
        <div class="card-bieu-do">
            <el-row :gutter="24">
                <el-col :span="24">
                    <div class="centerBetweenFlex">
                        <h5><i class="fas fa-user-graduate"></i>Học sinh</h5>
                        <div class="buttonR">
                            <el-button class="bt-phu" plain type="success" size="mini"
                                @click.prevent="chuyenLinkTraCuuHocSinh">Chi tiết
                            </el-button>
                        </div>
                    </div>
                </el-col>
                <!-- <el-col :span="22">
                    <h5><i class="fas fa-user-graduate"></i> Học sinh</h5>
                </el-col>
                <el-col :span="2" class="text-right">
                    <el-button class="bt-phu" plain type="success" size="mini" @click.prevent="chuyenLinkTraCuuHocSinh">
                        Chi tiết
                    </el-button>
                </el-col> -->
                <el-col :md="12" :lg="8">
                    <div class="dts-moibieudo grid-content bg-purple-light">
                        <div class="dts-card-header">
                            <span class="dts-card-title">Tổng quan</span>
                            <span class="dts-right"><a href="#" @click.prevent="getDuLieuHocSinhTongQuan"
                                    title="Lấy lại dữ liệu thống kê"><i class="fa-solid fa-rotate-right"></i></a>
                            </span>
                        </div>
                        <div class="dts-card-body" v-loading="loadingHocSinh.tongQuan"
                            element-loading-background="rgba(0, 0, 0, 0.8)">
                            <div>
                                <BieuDoTron :dulieu="duLieuHocSinh.tongQuan" />
                            </div>
                        </div>
                    </div>
                </el-col>
                <el-col :md="12" :lg="8">
                    <div class="dts-moibieudo grid-content bg-purple-light">
                        <div class="dts-card-header">
                            <span class="dts-card-title">Trạng thái</span>
                            <span class="dts-right"><a href="#" @click.prevent="getDuLieuHocSinhTheoTrangThai"
                                    title="Lấy lại dữ liệu thống kê"><i class="fa-solid fa-rotate-right"></i></a>
                            </span>
                        </div>
                        <div class="dts-card-body" v-loading="loadingHocSinh.trangThai"
                            element-loading-background="rgba(0, 0, 0, 0.8)">
                            <div>
                                <BieuDoCotChong :dulieu="duLieuHocSinh.trangThai" />
                            </div>
                        </div>
                    </div>
                </el-col>
                <el-col :md="12" :lg="8">
                    <div class="dts-moibieudo grid-content bg-purple-light">
                        <div class="dts-card-header">
                            <span class="dts-card-title">Giới tính</span>
                            <span class="dts-right"><a href="#" @click.prevent="getDuLieuHocSinhTheoGioiTinh"
                                    title="Lấy lại dữ liệu thống kê"><i class="fa-solid fa-rotate-right"></i></a>
                            </span>
                        </div>
                        <div class="dts-card-body" v-loading="loadingHocSinh.gioiTinh"
                            element-loading-background="rgba(0, 0, 0, 0.8)">
                            <div>
                                <BieuDoCotChong :dulieu="duLieuHocSinh.gioiTinh" />
                            </div>
                        </div>
                    </div>
                </el-col>
                <el-col :md="12" :lg="8">
                    <div class="dts-moibieudo grid-content bg-purple-light">
                        <div class="dts-card-header">
                            <span class="dts-card-title">Loại hình đào tạo</span>
                            <span class="dts-right"><a href="#" @click.prevent="getDuLieuHocSinhTheoLoaiHinh"
                                    title="Lấy lại dữ liệu thống kê"><i class="fa-solid fa-rotate-right"></i></a>
                            </span>
                        </div>
                        <div class="dts-card-body" v-loading="loadingHocSinh.loaiHinh"
                            element-loading-background="rgba(0, 0, 0, 0.8)">
                            <div>
                                <BieuDoCotChong :dulieu="duLieuHocSinh.loaiHinh" />
                            </div>
                        </div>
                    </div>
                </el-col>
                <el-col :md="12" :lg="8">
                    <div class="dts-moibieudo grid-content bg-purple-light">
                        <div class="dts-card-header">
                            <span class="dts-card-title">Khu vực</span>
                            <span class="dts-right"><a href="#" @click.prevent="getDuLieuHocSinhTheoKhuVuc"
                                    title="Lấy lại dữ liệu thống kê"><i class="fa-solid fa-rotate-right"></i></a>
                            </span>
                        </div>
                        <div class="dts-card-body" v-loading="loadingHocSinh.khuVuc"
                            element-loading-background="rgba(0, 0, 0, 0.8)">
                            <div>
                                <BieuDoCotChong :dulieu="duLieuHocSinh.khuVuc" />
                            </div>
                        </div>
                    </div>
                </el-col>
            </el-row>
        </div>
        <!-- Cán bộ - giáo viên -->
        <div class="card-bieu-do">
            <el-row :gutter="24">
                <el-col :span="24">
                    <div class="centerBetweenFlex">
                        <h5><i class="fas fa-chalkboard-teacher"></i> Cán bộ - Giáo viên - Nhân viên</h5>
                        <div class="buttonR">
                            <el-button class="bt-phu" plain type="success" size="mini"
                                @click.prevent="chuyenLinkTraCuuCbgv">Chi tiết
                            </el-button>
                        </div>
                    </div>
                </el-col>
                <!-- <el-col :span="22">
                    <h5><i class="fas fa-chalkboard-teacher"></i> Cán bộ - Giáo viên - Nhân viên</h5>
                </el-col>
                <el-col :span="2" class="text-right">
                    <el-button class="bt-phu" plain type="success" size="mini" @click.prevent="chuyenLinkTraCuuCbgv">Chi
                        tiết
                    </el-button>
                </el-col> -->
                <el-col :md="12" :lg="8">
                    <div class="dts-moibieudo grid-content bg-purple-light">
                        <div class="dts-card-header">
                            <span class="dts-card-title">Tổng quan</span>
                            <span class="dts-right"><a href="#" @click.prevent="getDuLieuCanBoGiaoVienTongQuan"
                                    title="Lấy lại dữ liệu thống kê"><i class="fa-solid fa-rotate-right"></i></a>
                            </span>
                        </div>
                        <div class="dts-card-body" v-loading="loadCanBoGiaoVien.tongQuan"
                            element-loading-background="rgba(0, 0, 0, 0.8)">
                            <div>
                                <BieuDoTron :dulieu="duLieuCanBoGiaoVien.tongQuan" />
                            </div>
                        </div>
                    </div>
                </el-col>
                <el-col :md="12" :lg="8">
                    <div class="dts-moibieudo grid-content bg-purple-light">
                        <div class="dts-card-header">
                            <span class="dts-card-title">Trình độ chuyên ngành chính</span>
                            <span class="dts-right"><a href="#" @click.prevent="getDuLieuCanBoGiaoVienTrinhDoChinh"
                                    title="Lấy lại dữ liệu thống kê"><i class="fa-solid fa-rotate-right"></i></a>
                            </span>
                        </div>
                        <div class="dts-card-body" v-loading="loadCanBoGiaoVien.trinhDoChinh"
                            element-loading-background="rgba(0, 0, 0, 0.8)">
                            <div>

                                <BieuDoCotChong :dulieu="duLieuCanBoGiaoVien.trinhDoChinh" />
                            </div>
                        </div>
                    </div>
                </el-col>
                <el-col :md="12" :lg="8">
                    <div class="dts-moibieudo grid-content bg-purple-light">
                        <div class="dts-card-header">
                            <span class="dts-card-title">Giới tính</span>
                            <span class="dts-right"><a href="#" @click.prevent="getDuLieuCanBoGiaoVienGioiTinh"
                                    title="Lấy lại dữ liệu thống kê"><i class="fa-solid fa-rotate-right"></i></a>
                            </span>
                        </div>
                        <div class="dts-card-body" v-loading="loadCanBoGiaoVien.gioiTinh"
                            element-loading-background="rgba(0, 0, 0, 0.8)">
                            <div>
                                <BieuDoCotChong :dulieu="duLieuCanBoGiaoVien.gioiTinh" />
                            </div>
                        </div>
                    </div>
                </el-col>
                <el-col :md="12" :lg="8">
                    <div class="dts-moibieudo grid-content bg-purple-light">
                        <div class="dts-card-header">
                            <span class="dts-card-title">Loại hợp đồng</span>
                            <span class="dts-right"><a href="#" @click.prevent="getDuLieuCanBoGiaoVienLoaiHopDong"
                                    title="Lấy lại dữ liệu thống kê"><i class="fa-solid fa-rotate-right"></i></a>
                            </span>
                        </div>
                        <div class="dts-card-body" v-loading="loadCanBoGiaoVien.loaiHopDong"
                            element-loading-background="rgba(0, 0, 0, 0.8)">
                            <div>
                                <BieuDoCotChong :dulieu="duLieuCanBoGiaoVien.loaiHopDong" />
                            </div>
                        </div>
                    </div>
                </el-col>
            </el-row>
        </div>
        <!-- Phân loại cán bộ giáo viên -->
        <div class="card-bieu-do">
            <el-row :gutter="24">
                
                <el-col :span="24">
                    <div class="centerBetweenFlex">
                        <h5><i class="fas fa-chalkboard-teacher"></i> Phân loại cán bộ</h5>
                        <div class="buttonR">
                            <el-button class="bt-phu" plain type="success" size="mini"
                                @click.prevent="chuyenLinkTraCuuCbgv">Chi tiết
                            </el-button>
                        </div>
                    </div>
                </el-col>
                <!-- <el-col :span="22">
                    <h5><i class="fas fa-chalkboard-teacher"></i> Phân loại cán bộ</h5>
                </el-col>
                <el-col :span="2" class="text-right">
                    <el-button class="bt-phu" plain type="success" size="mini" @click.prevent="chuyenLinkTraCuuCbgv">Chi
                        tiết
                    </el-button>
                </el-col> -->
                <el-col :md="12" :lg="8">
                    <div class="dts-moibieudo grid-content bg-purple-light">
                        <div class="dts-card-header">
                            <span class="dts-card-title">Tổng quan</span>
                            <span class="dts-right"><a href="#" @click.prevent="getDuLieuPhanLoaiCanBoTongQuan"
                                    title="Lấy lại dữ liệu thống kê"><i class="fa-solid fa-rotate-right"></i></a>
                            </span>
                        </div>
                        <div class="dts-card-body" v-loading="loadPhanLoaiCanBo.tongQuan"
                            element-loading-background="rgba(0, 0, 0, 0.8)">
                            <div>
                                <BieuDoTron :dulieu="duLieuPhanLoaiCanBo.tongQuan" />
                            </div>
                        </div>
                    </div>
                </el-col>
                <el-col :md="12" :lg="8">
                    <div class="dts-moibieudo grid-content bg-purple-light">
                        <div class="dts-card-header">
                            <span class="dts-card-title">Độ tuổi</span>
                            <span class="dts-right"><a href="#" @click.prevent="getDuLieuPhanLoaiCanBoTheoDoTuoi"
                                    title="Lấy lại dữ liệu thống kê"><i class="fa-solid fa-rotate-right"></i></a>
                            </span>
                        </div>
                        <div class="dts-card-body" v-loading="loadPhanLoaiCanBo.doTuoi"
                            element-loading-background="rgba(0, 0, 0, 0.8)">
                            <div>
                                <BieuDoCotChong :dulieu="duLieuPhanLoaiCanBo.doTuoi" />
                            </div>
                        </div>
                    </div>
                </el-col>
                <el-col :md="12" :lg="8">
                    <div class="dts-moibieudo grid-content bg-purple-light">
                        <div class="dts-card-header">
                            <span class="dts-card-title">Loại hình đào tạo</span>
                            <span class="dts-right"><a href="#"
                                    @click.prevent="getDuLieuPhanLoaiCanBoTheoDoLoaiHinhDaoTao"
                                    title="Lấy lại dữ liệu thống kê"><i class="fa-solid fa-rotate-right"></i></a>
                            </span>
                        </div>
                        <div class="dts-card-body" v-loading="loadPhanLoaiCanBo.loaiHinhDaoTao"
                            element-loading-background="rgba(0, 0, 0, 0.8)">
                            <div>
                                <PhanLoaiCanBoLoaiHinhDaoTao :tuychon="hienThiTungKhoi"
                                    :dulieu="duLieuPhanLoaiCanBo.loaiHinhDaoTao">
                                </PhanLoaiCanBoLoaiHinhDaoTao>
                            </div>
                        </div>
                    </div>
                </el-col>
                <el-col :md="12" :lg="8">
                    <div class="dts-moibieudo grid-content bg-purple-light">
                        <div class="dts-card-header">
                            <span class="dts-card-title">Trạng thái</span>
                            <span class="dts-right">
                                <a href="#" @click.prevent="getDuLieuPhanLoaiCanBoTheoTrangThai"
                                    title="Lấy lại dữ liệu thống kê"><i class="fa-solid fa-rotate-right"></i></a>
                            </span>
                        </div>
                        <div class="dts-card-body" v-loading="loadPhanLoaiCanBo.trangThai"
                            element-loading-background="rgba(0, 0, 0, 0.8)">
                            <div>
                                <PhanLoaiCanBoTrangThai :tuychon="hienThiTungKhoi"
                                    :dulieu="duLieuPhanLoaiCanBo.trangThai">
                                </PhanLoaiCanBoTrangThai>
                            </div>
                        </div>
                    </div>
                </el-col>
            </el-row>
        </div>
        <!-- Phổ điểm -->
        <div class="card-bieu-do">
            <el-row :gutter="24">
                <el-col :span="24">
                    <h5><i class="fas fa-chart-line"></i> Phổ điểm</h5>
                </el-col>
                <el-col :sm="24" :md="12">
                    <div class="dts-moibieudo grid-content bg-purple-light">
                        <div class="dts-card-header">
                            <span class="dts-card-title">Phổ điểm học kỳ I</span>
                            <span class="dts-right"><a href="#" @click.prevent="getPhoDiemHocKyI"
                                    title="Lấy lại dữ liệu thống kê"><i class="fa-solid fa-rotate-right"></i></a>
                            </span>
                        </div>
                        <div class="dts-card-body-ct " v-loading="loadPhoDiem.hocKyI"
                            element-loading-background="rgba(0, 0, 0, 0.8)">
                            <div>
                                <PhoDiemHocKyMot :tuychon="hienThiTungKhoi" :dulieu="duLieuPhoDiem.hocKyI">
                                </PhoDiemHocKyMot>
                            </div>
                        </div>
                    </div>
                </el-col>
                <el-col :sm="24" :md="12">
                    <div class="dts-moibieudo grid-content bg-purple-light">
                        <div class="dts-card-header">
                            <span class="dts-card-title">Phổ điểm học kỳ II</span>
                            <span class="dts-right"><a href="#" @click.prevent="getPhoDiemHocKyII"
                                    title="Lấy lại dữ liệu thống kê"><i class="fa-solid fa-rotate-right"></i></a>
                            </span>
                        </div>
                        <div class="dts-card-body-ct" v-loading="loadPhoDiem.hocKyII"
                            element-loading-background="rgba(0, 0, 0, 0.8)">
                            <div>
                                <PhoDiemHocKyHai :tuychon="hienThiTungKhoi" :dulieu="duLieuPhoDiem.hocKyII">
                                </PhoDiemHocKyHai>
                            </div>
                        </div>
                    </div>
                </el-col>
                <el-col v-if="thongtin.ma_so!=83" :md="12" :lg="8" style="">
                    <div class="dts-moibieudo grid-content bg-purple-light">
                        <div class="dts-card-header">
                            <span class="dts-card-title">Đánh giá học sinh học kỳ I (THCS,THPT) TT58</span>
                            <span class="dts-right"><a href="#" @click.prevent="getPhoDiemDanhGiaHocKyI"
                                    title="Lấy lại dữ liệu thống kê"><i class="fa-solid fa-rotate-right"></i></a>
                            </span>
                        </div>
                        <div class="dts-card-body" v-loading="loadPhoDiem.ketQuaDanhGiaHocKyI"
                            element-loading-background="rgba(0, 0, 0, 0.8)">
                            <div>
                                <PhanLoaiDanhGiaHocKyI :dulieu="duLieuPhoDiem.ketQuaDanhGiaHocKyI">
                                </PhanLoaiDanhGiaHocKyI>
                            </div>
                        </div>
                    </div>
                </el-col>
                <el-col v-if="thongtin.ma_so!=83" :md="12" :lg="8" style="">
                    <div class="dts-moibieudo grid-content bg-purple-light">
                        <div class="dts-card-header">
                            <span class="dts-card-title">Đánh giá học sinh học kỳ II (THCS,THPT) TT58</span>
                            <span class="dts-right"><a href="#" @click.prevent="getPhoDiemDanhGiaHocKyII"
                                    title="Lấy lại dữ liệu thống kê"><i class="fa-solid fa-rotate-right"></i></a>
                            </span>
                        </div>
                        <div class="dts-card-body" v-loading="loadPhoDiem.ketQuaDanhGiaHocKyII"
                            element-loading-background="rgba(0, 0, 0, 0.8)">
                            <div>
                                <PhanLoaiDanhGiaHocKyII :dulieu="duLieuPhoDiem.ketQuaDanhGiaHocKyII">
                                </PhanLoaiDanhGiaHocKyII>
                            </div>
                        </div>
                    </div>
                </el-col>
                <el-col v-if="thongtin.ma_so!=83" :md="12" :lg="8" style="">
                    <div class="dts-moibieudo grid-content bg-purple-light">
                        <div class="dts-card-header">
                            <span class="dts-card-title">Đánh giá học sinh cả năm (THCS,THPT) TT58</span>
                            <span class="dts-right"><a href="#" @click.prevent="getPhoDiemDanhGiaCaNam"
                                    title="Lấy lại dữ liệu thống kê"><i class="fa-solid fa-rotate-right"></i></a>
                            </span>
                        </div>
                        <div class="dts-card-body" v-loading="loadPhoDiem.ketQuaDanhGiaCaNam"
                            element-loading-background="rgba(0, 0, 0, 0.8)">
                            <div>
                                <PhanLoaiDanhGiaCaNam :dulieu="duLieuPhoDiem.ketQuaDanhGiaCaNam">
                                </PhanLoaiDanhGiaCaNam>
                            </div>
                        </div>
                    </div>
                </el-col>
            </el-row>
        </div>
        <!-- Biến động -->
        <div class="card-bieu-do" v-if="thongtin.ma_so==19">
            <el-row :gutter="24">
                <el-col :span="24">
                    <h5><i class="fas fa-chart-line"></i>Dữ liệu biến động</h5>
                </el-col>
                <el-col :sm="24" :md="12">
                    <div class="dts-moibieudo grid-content bg-purple-light">
                        <div class="dts-card-header">
                            <span class="dts-card-title">Tổng số lớp</span>
                            <span class="dts-right"><a href="#" @click.prevent="getBienDongTongSoLopHoc"
                                    title="Lấy lại dữ liệu thống kê"><i class="fa-solid fa-rotate-right"></i></a>
                            </span>
                        </div>
                        <div class="dts-card-body-ct " v-loading="loadBienDong.tongSoLopHoc"
                            element-loading-background="rgba(0, 0, 0, 0.8)">
                            <div>
                                <bieuDoCot :namHoc='namHoc' :tuychon="hienThiTungKhoi"
                                    :dulieu="duLieuBienDong.tongSoLopHoc">
                                </bieuDoCot>
                            </div>
                        </div>
                    </div>
                </el-col>
                <el-col :sm="24" :md="12">
                    <div class="dts-moibieudo grid-content bg-purple-light">
                        <div class="dts-card-header">
                            <span class="dts-card-title">Tổng số giáo viên</span>
                            <span class="dts-right"><a href="#" @click.prevent="getBienDongTongSoGiaoVien"
                                    title="Lấy lại dữ liệu thống kê"><i class="fa-solid fa-rotate-right"></i></a>
                            </span>
                        </div>
                        <div class="dts-card-body-ct " v-loading="loadBienDong.tongSoGiaoVien"
                            element-loading-background="rgba(0, 0, 0, 0.8)">
                            <div>
                                <bieuDoCot :namHoc='namHoc' :tuychon="hienThiTungKhoi"
                                    :dulieu="duLieuBienDong.tongSoGiaoVien">
                                </bieuDoCot>
                            </div>
                        </div>
                    </div>
                </el-col>
                <el-col :sm="24" :md="12">
                    <div class="dts-moibieudo grid-content bg-purple-light">
                        <div class="dts-card-header">
                            <span class="dts-card-title">Giáo viên theo trình độ</span>
                            <span class="dts-right"><a href="#" @click.prevent="getBienDongTrinhDoGiaoVien"
                                    title="Lấy lại dữ liệu thống kê"><i class="fa-solid fa-rotate-right"></i></a>
                            </span>
                        </div>
                        <div class="dts-card-body-ct " v-loading="loadBienDong.trinhDoGiaoVien"
                            element-loading-background="rgba(0, 0, 0, 0.8)">
                            <div>
                                <hocLucHocSinh :namHoc='namHoc' :tuychon="hienThiTungKhoi"
                                    :dulieu="duLieuBienDong.trinhDoGiaoVien">
                                </hocLucHocSinh>
                            </div>
                        </div>
                    </div>
                </el-col>
                <el-col :sm="24" :md="12">
                    <div class="dts-moibieudo grid-content bg-purple-light">
                        <div class="dts-card-header">
                            <span class="dts-card-title">Tổng số học sinh</span>
                            <span class="dts-right"><a href="#" @click.prevent="getBienDongTongSoHocSinh"
                                    title="Lấy lại dữ liệu thống kê"><i class="fa-solid fa-rotate-right"></i></a>
                            </span>
                        </div>
                        <div class="dts-card-body-ct " v-loading="loadBienDong.tongSoHocSinh"
                            element-loading-background="rgba(0, 0, 0, 0.8)">
                            <div>
                                <bieuDoCot :namHoc='namHoc' :tuychon="hienThiTungKhoi"
                                    :dulieu="duLieuBienDong.tongSoHocSinh">
                                </bieuDoCot>
                            </div>
                        </div>
                    </div>
                </el-col>
                <el-col :sm="24" :md="12">
                    <div class="dts-moibieudo grid-content bg-purple-light">
                        <div class="dts-card-header">
                            <span class="dts-card-title">Học lực học sinh</span>
                            <span class="dts-right"><a href="#" @click.prevent="getBienDongHocLucHocSinh"
                                    title="Lấy lại dữ liệu thống kê"><i class="fa-solid fa-rotate-right"></i></a>
                            </span>
                        </div>
                        <div class="dts-card-body-ct " v-loading="loadBienDong.hocLucHocSinh"
                            element-loading-background="rgba(0, 0, 0, 0.8)">
                            <div>
                                <hocLucHocSinh :namHoc='namHoc' :tuychon="hienThiTungKhoi"
                                    :dulieu="duLieuBienDong.hocLucHocSinh">
                                </hocLucHocSinh>
                            </div>
                        </div>
                    </div>
                </el-col>
            </el-row>
        </div>
        <!-- Chi tiết học lực -->
        <div class="card-bieu-do" v-if="thongtin.ma_so==19">
            <el-row :gutter="24">
                <el-col :span="24">
                    <h5><i class="fas fa-chart-line"></i>Học lực, hạnh kiểm</h5>
                </el-col>
                <el-col :sm="24" :lg="12" :xl="12">
                    <label class="typo__label">Đơn vị</label>
                    <eselect style="width:100%" @change="layLaiDuLieuGiaoVien" multiple :disabled="thongtin.role==4"
                        no-match-text="Không tìm thấy bản ghi nào" no-data-text="danh sách lựa chọn trống" collapse-tags
                        v-model="danhSachDonVi" :placeholder="'Chọn đơn vị quản lý'" filterable :data="danh_sach_don_vi"
                        :fields="['tenDonVi','maDonVi']" />
                </el-col>
                <el-col :sm="24" :md="12" :lg="6" :xl="6">
                    <label class="typo__label">Cấp học</label>
                    <eselect style="width:100%" @change="layLaiDuLieuGiaoVien" multiple
                        no-match-text="Không tìm thấy bản ghi nào" no-data-text="danh sách lựa chọn trống" collapse-tags
                        v-model="danhSachCapHoc" :placeholder="'Chọn'" filterable :data="danh_sach_cap_hoc_full"
                        :fields="['name','id']" />

                </el-col>
                <el-col :sm="24" :md="12" :lg="6" :xl="6">
                    <label class="typo__label">Khối học/Nhóm lớp</label>
                    <eselect style="width:100%" multiple collapseTags v-model="dataChiTiet.khoiHoc"
                        :placeholder="'Chọn'" filterable :data="list_khoi_hoc" :fields="['name','id']" />
                </el-col>
                <el-col :sm="24" :lg="12" :xl="12">
                    <label class="typo__label">Trường học</label>
                    <eselect style="width:100%" multiple no-match-text="Không tìm thấy bản ghi nào"
                        no-data-text="danh sách lựa chọn trống" collapse-tags v-model="danhSachTruongHoc"
                        :placeholder="'Chọn'" filterable :data="danh_sach_truong_hoc"
                        :fields="['name','value']" />
                </el-col>
                <el-col :sm="24" :md="12" :lg="3" :xl="3">

                    <label class="typo__label">Học kỳ</label>
                    <eselect v-model="dataChiTiet.hocKy" :data="danh_sach_hoc_ky" :fields="['name','value']" />
                </el-col>
                <el-col :sm="24" :md="12" :lg="3" :xl="3">
                    <label class="typo__label">Năm học</label>
                    <el-select class="input-with-select" v-model="namHoc" no-match-text="Không tìm thấy bản ghi nào"
                        no-data-text="danh sách lựa chọn trống" collapse-tags style="width:100%" filterable
                        placeholder="Chọn năm học">
                        <el-option v-for="item in list_nam_hoc" :key="item.id" :label="item.name" :value="item.id">
                        </el-option>
                    </el-select>
                </el-col>
                <el-col :lg="3">
                    <label class="typo__label" style="color:transparent">Thống kê</label>
                    <el-button class="bt-chinh" size="mini" style="font-size:14px; padding-left:10px;"
                        @click.prevent="layChiTietHocLucVaHanhKiem()" type="success">Thống kê
                    </el-button>
                </el-col>
                <template v-for="item in duLieuChiTiet.hocLuc">
                    <el-col :md="12" :lg="8">
                        <div class="dts-moibieudo grid-content bg-purple-light">
                            <div class="dts-card-header">
                                <span class="dts-card-title">Học lực khối {{ item.khoiHoc }}</span>
                                <!--                                <span class="dts-right"><a href="#" @click.prevent="getDataChiTietHocLuc"-->
                                <!--                                                           title="Lấy lại dữ liệu thống kê"><i-->
                                <!--                                    class="fa-solid fa-rotate-right"></i></a>-->
                                <!--                                </span>-->
                            </div>
                            <div class="dts-card-body" v-loading="loadChiTiet.hocLuc"
                                element-loading-background="rgba(0, 0, 0, 0.8)">
                                <div>
                                    <BieuDoTron :dulieu="mapDuLieuBieuDoTron(item.data)" />
                                </div>
                            </div>
                        </div>
                    </el-col>
                </template>
                <template v-for="item in duLieuChiTiet.hanhKiem">
                    <el-col :md="12" :lg="8">
                        <div class="dts-moibieudo grid-content bg-purple-light">
                            <div class="dts-card-header">
                                <span class="dts-card-title">Hạnh kiểm khối {{ item.khoiHoc }}</span>
                                <!--                                <span class="dts-right"><a href="#" @click.prevent="getDataChiTietHanhKiem"-->
                                <!--                                                           title="Lấy lại dữ liệu thống kê"><i-->
                                <!--                                    class="fa-solid fa-rotate-right"></i></a>-->
                                <!-- </span> -->
                            </div>
                            <div class="dts-card-body" v-loading="loadChiTiet.hanhKiem"
                                element-loading-background="rgba(0, 0, 0, 0.8)">
                                <div>
                                    <BieuDoTron :dulieu="mapDuLieuBieuDoTron(item.data)" />
                                </div>
                            </div>
                        </div>
                    </el-col>
                </template>
                <template v-if="loadChiTiet.hanhKiem&&loadChiTiet.hocLuc">
                    <el-col :span="24">
                        <div class="card-bieu-do dts-card-body-ct " v-loading="true"
                            style="height:50vh; border-radius:5px" element-loading-background="rgba(0, 0, 0, 0.8)">
                        </div>
                    </el-col>
                </template>
            </el-row>
        </div>
    </div>
</template>
<script>
    import rest_api from '../../utils/rest_api';
    import ElementUI from 'element-ui';
    import constant from '../../utils/constant';
    import ESelectVue from '../ui/ESelect.vue';
    import BieuDoTron from './ChartComponent2/bieuDoTron2Custom'
    import BieuDoTron2 from './ChartComponent2/bieuDoTron2Custom'
    import BieuDoCotChong from './ChartComponent2/BieuDoCotChong'
    import BieuDoCotNhom from './ChartComponent2/BieuDoCotNhom'
    import BieuDoDuong from './ChartComponent2/BieuDoDuong'
    import TruongHocChatLuongDaoTao from './DashBoard/TruongHoc/TruongHocChatLuongDaoTao'
    import TongQuanTruongHoc from './DashBoard/TruongHoc/TongQuan'
    import TruongHocLoaiHinhDaoTaoDaoTao from './DashBoard/TruongHoc/TruongHocLoaiHinhDaoTaoDaoTao'
    // Hết trường học
    import TongQuanGiaoVien from './DashBoard/GiaoVien/TongQuanGiaoVien'
    import GiaoVienTrinhDoChinh from './DashBoard/GiaoVien/GiaoVienTrinhDoChinh'
    import GiaoVienGioiTinh from './DashBoard/GiaoVien/GiaoVienGioiTinh'
    import GiaoVienLoaiHopDong from './DashBoard/GiaoVien/GiaoVienLoaiHopDong'
    // Học sinh
    import TongQuanHocSinh from './DashBoard/HocSinh/TongQuanHocSinh'
    import HocSinhKhuVuc from './DashBoard/HocSinh/HocSinhKhuVuc'
    import HocSinhGioiTinh from './DashBoard/HocSinh/HocSinhGioiTinh'
    import HocSinhTrangThai from './DashBoard/HocSinh/HocSinhTrangThai'
    import HocSinhoaiHinhDaoTao from './DashBoard/HocSinh/HocSinhoaiHinhDaoTao'
    import HocSinhPhanLoaiDanhGia from './DashBoard/HocSinh/HocSinhPhanLoaiDanhGia'
    // Phân loại cán bộ
    import TongQuanPhanLoaiCanBo from './DashBoard/PhanLoaiCanBo/TongQuanPhanLoaiCanBo'
    import PhanLoaiCanBoDoTuoi from './DashBoard/PhanLoaiCanBo/PhanLoaiCanBoDoTuoi'
    import PhanLoaiCanBoLoaiHinhDaoTao from './DashBoard/PhanLoaiCanBo/PhanLoaiCanBoLoaiHinhDaoTao'
    import PhanLoaiCanBoTrangThai from './DashBoard/PhanLoaiCanBo/PhanLoaiCanBoTrangThai'
    // Phổ điểm
    import PhoDiemHocKyMot from './DashBoard/PhoDiem/PhoDiemHocKyMot'
    import PhoDiemHocKyHai from './DashBoard/PhoDiem/PhoDiemHocKyHai'
    import PhanLoaiDanhGiaHocKyI from './DashBoard/PhoDiem/PhanLoaiDanhGiaHocKyI'
    import PhanLoaiDanhGiaHocKyII from './DashBoard/PhoDiem/PhanLoaiDanhGiaHocKyII'
    import PhanLoaiDanhGiaCaNam from './DashBoard/PhoDiem/PhanLoaiDanhGiaCaNam'
    // Biến động
    
    import hocLucHocSinh from './DashBoard/bienDong/hocLuc.vue'
    import bieuDoCot from './DashBoard/bienDong/tongSoHocSinh.vue'
    // Trường học
    Vue.use(ElementUI);
    export default {
        props: [],
        data() {
            return {
                dataChiTiet: {
                    hocKy: 1,
                },
                danh_sach_hoc_ky: [{
                        name: 'Học kỳ 1',
                        value: 1
                    },
                    {
                        name: 'Học kỳ 2',
                        value: 2
                    },
                    {
                        name: 'Cả năm',
                        value: 3
                    },
                ],
                thongtin: JSON.parse(window.userInfo),
                hienThiTungKhoi: false,
                loading: true,
                capHocDangNhap: "",
                truongHocDangNhap: "",
                loadingTongQuanCanBoGiaoVien: true,
                DuLieuGiaoVien: {},
                // Load dữ liệu
                loadDuLieuTruongHoc: true,
                loadDuLieuGiaoVien: true,
                loadDuLieuHocSinh: true,
                loadTruongHoc: {
                    tongQuan: true,
                    chatLuongDaoTao: true,
                    loaiHinhDaoTao: true
                },
                tuyChonTruongHoc: {
                    tongQuan: false,
                    chatLuongDaoTao: false,
                    loaiHinhDaoTao: false
                },
                loadCanBoGiaoVien: {
                    tongQuan: true,
                    trinhDoChinh: true,
                    gioiTinh: true,
                    loaiHopDong: true,
                },
                loadingHocSinh: {
                    tongQuan: true,
                    khuVuc: true,
                    gioiTinh: true,
                    trangThai: true,
                    loaiHinh: true,
                    ketQuaDanhGia: true,
                },
                loadPhanLoaiCanBo: {
                    tongQuan: true,
                    doTuoi: true,
                    loaiHinhDaoTao: true,
                    trangThai: true,
                },
                loadPhoDiem: {
                    HKI: true,
                    HKII: true,
                    ketQuaDanhGiaHocKyI: true,
                    ketQuaDanhGiaHocKyII: true,
                    ketQuaDanhGiaCaNam: true,
                },
                loadChiTiet: {
                    hocLuc: true,
                    hanhKiem: true
                },
                duLieuChiTiet: {
                    hocLuc: [],
                    hanhKiem: []
                },
                loadBienDong: {
                    hocLucHocSinh: true,
                    tongSoHocSinh: true,
                    tongSoLopHoc: true,
                    tongSoGiaoVien: true,
                    trinhDoGiaoVien: true,
                },
                // dữ liệu gán
                duLieuTruongHoc: {
                    tongQuan: [],
                    chatLuongDaoTao: [],
                    htChatLuongDaoTao: false,
                    phanTramChatLuongDaoTao: false,
                    loaiHinhDaoTao: [],
                    htLoaiHinhDaoTao: false,
                    phanTramLoaiHinhDaoTao: false,
                },
                duLieuHocSinh: {
                    tongQuan: [],
                    khuVuc: [],
                    gioiTinh: [],
                    trangThai: [],
                    loaiHinh: [],
                },
                duLieuCanBoGiaoVien: {
                    tongQuan: [],
                    trinhDoChinh: [],
                    gioiTinh: [],
                    loaiHopDong: [],
                },
                duLieuPhanLoaiCanBo: {
                    tongQuan: [],
                    doTuoi: [],
                    loaiHinhDaoTao: [],
                    trangThai: [],
                },
                duLieuPhoDiem: {
                    hocKyI: [],
                    hocKyII: [],
                    ketQuaDanhGiaHocKyI: [],
                    ketQuaDanhGiaHocKyII: [],
                    ketQuaDanhGiaCaNam: [],
                },
                duLieuBienDong: {
                    hocLucHocSinh: [],
                    tongSoHocSinh: [],
                    tongSoLopHoc: [],
                    tongSoGiaoVien: [],
                    trinhDoGiaoVien: [],
                },
                duLieuTangGiamTruongHoc: {},
                duLieuTangGiamGiaoVien: {},
                duLieuTangGiamHocSinh: {},
                danh_sach_don_vi: [],
                date: new Date(),
                danh_sach_cap_hoc_full: window.listCapHoc,
                list_nam_hoc: constant.LIST_YEARS_FULL,
                danh_sach_ten_cap_hoc_full: [],
                danh_sach_cap_hoc: [],
                danh_sach_truong_hoc: [],
                danhSachDonVi: [],
                tenDonViDangNhap: "",
                danhSachCapHoc: [],
                danhSachCapHocString: [],
                namHoc: "",
                danhSachTruongHoc: [],
                khoi_cap_mot: constant.khoiCapMot,
                khoi_cap_hai: constant.khoiCapHai,
                khoi_cap_ba: constant.khoiCapBa,
                khoi_cap_4: constant.khoiHocNhaTre,
                khoi_cap_5: constant.khoiHocMauGiao,
                list_khoi_hoc: []
            }
        },
        mounted() {
            // this.layToanBoSMEMappingCode();
            // this.layToanBoSMEMoetCode();
            if (this.thongtin.role == 5) {
                this.bindCapHocDangNhap();
                this.getTenTruong(this.thongtin.ma_truong_hoc)
            }
            this.namHoc = this.thongtin.namHocHienTai;
            if (this.thongtin.role == 4) {
                this.danhSachDonVi = [this.thongtin.ma_don_vi]
            }
            this.mapKhoiHoc(this.thongtin.listCapHoc);
            this.getDonVi();
            this.getTruongHoc();
            this.getAllDataChart();

        },
        components: {
            BieuDoTron,
            BieuDoTron2,
            BieuDoCotChong,
            BieuDoCotNhom,
            BieuDoDuong,
            'eselect': ESelectVue,
            TruongHocChatLuongDaoTao: TruongHocChatLuongDaoTao,
            TongQuanTruongHoc: TongQuanTruongHoc,
            TruongHocLoaiHinhDaoTaoDaoTao: TruongHocLoaiHinhDaoTaoDaoTao,
            // Giáo viên
            TongQuanGiaoVien: TongQuanGiaoVien,
            GiaoVienTrinhDoChinh: GiaoVienTrinhDoChinh,
            GiaoVienGioiTinh: GiaoVienGioiTinh,
            GiaoVienLoaiHopDong: GiaoVienLoaiHopDong,
            //    Học sinh
            TongQuanHocSinh: TongQuanHocSinh,
            HocSinhKhuVuc: HocSinhKhuVuc,
            HocSinhGioiTinh: HocSinhGioiTinh,
            HocSinhTrangThai: HocSinhTrangThai,
            HocSinhoaiHinhDaoTao: HocSinhoaiHinhDaoTao,
            HocSinhPhanLoaiDanhGia: HocSinhPhanLoaiDanhGia,
            // Phân loại cán bộ
            TongQuanPhanLoaiCanBo: TongQuanPhanLoaiCanBo,
            PhanLoaiCanBoDoTuoi: PhanLoaiCanBoDoTuoi,
            PhanLoaiCanBoLoaiHinhDaoTao: PhanLoaiCanBoLoaiHinhDaoTao,
            PhanLoaiCanBoTrangThai: PhanLoaiCanBoTrangThai,
            // Phổ điểm
            PhoDiemHocKyMot: PhoDiemHocKyMot,
            PhoDiemHocKyHai: PhoDiemHocKyHai,
            PhanLoaiDanhGiaHocKyI: PhanLoaiDanhGiaHocKyI,
            PhanLoaiDanhGiaHocKyII: PhanLoaiDanhGiaHocKyII,
            PhanLoaiDanhGiaCaNam: PhanLoaiDanhGiaCaNam,
            // Biến động
            hocLucHocSinh: hocLucHocSinh,
            bieuDoCot: bieuDoCot
        },
        watch: {
            danhSachCapHoc(val) {
                if (val) {
                    console.log("Danh sách cấp học thay đổi")
                    let dulieu = val;
                    let mang = [];
                    for (let i = 0; i < dulieu.length; i++) {
                        if (dulieu[i] < 10) {
                            let arr = dulieu[i].toString();
                            mang.push(arr);
                        } else {
                            let pt = dulieu[i].toString();
                            pt = pt.split('');
                            console.log(pt);
                            mang = mang.concat(pt)
                        }
                    }
                    mang = this.boPhanTuTrung(mang);
                    console.log(mang);
                    this.danhSachCapHocString = mang;
                }
            }
        },
        methods: {

            mapKhoiHoc(e) {
                console.log("map cấp học đã chọn:")
                console.log(e)
                let dulieu = e;
                let khoihoc = [];
                if (dulieu) {
                    for (let i = 0; i < dulieu.length; i++) {
                        if (dulieu[i] == 1) {
                            khoihoc = khoihoc.concat(this.khoi_cap_mot)
                        }
                        if (dulieu[i] == 2) {
                            khoihoc = khoihoc.concat(this.khoi_cap_hai)
                        }
                        if (dulieu[i] == 3) {
                            khoihoc = khoihoc.concat(this.khoi_cap_ba)
                        }
                        if (dulieu[i] == 4) {
                            khoihoc = khoihoc.concat(this.khoi_cap_4)
                        }
                        if (dulieu[i] == 5) {
                            khoihoc = khoihoc.concat(this.khoi_cap_5)
                        }
                        if (dulieu[i] == 45) {
                            khoihoc = khoihoc.concat(this.khoi_cap_4, this.khoi_cap_5)
                        }
                        if (dulieu[i] == 6) {
                            khoihoc = khoihoc.concat(this.khoi_cap_mot, this.khoi_cap_hai, this.khoi_cap_ba, this
                                .khoi_cap_4, this.khoi_cap_5)
                        }
                    }
                } else {
                    khoihoc = khoihoc.concat(this.khoi_cap_mot, this.khoi_cap_hai, this.khoi_cap_ba, this
                        .khoi_cap_4, this.khoi_cap_5)
                }
                console.log("Khối học sau map:");
                khoihoc.sort((a, b) => (a.id > b.id) ? 1 : -1);
                let khoihoc_unique = [];
                khoihoc_unique = [...new Set(khoihoc.map(item => item))];
                this.list_khoi_hoc = khoihoc_unique;
            },
            mapDuLieuBieuDoTron(item) {
                let obj = {
                    category: item.label,
                    series: item.listValue,
                    totalText: 'Học sinh',
                }
                return obj
            },

            boPhanTuTrung(arr) {
                return arr.filter((value, index, arr) => arr.indexOf(value) === index);
            },
            chuyenLinkTraCuuTruongHoc() {
                let uri = 'category/schools';
                window.open(uri, '_blank').focus();
            },
            chuyenLinkTraCuuHocSinh() {
                let uri = 'Look-up-students';
                window.open(uri, '_blank').focus();
            },
            chuyenLinkTraCuuCbgv() {
                let uri = 'Look-up-officials';
                window.open(uri, '_blank').focus();
            },
            getTenTruong(e) {
                let params = {
                    // maDonVi: this.danhSachDonVi,
                    maTruong: e,
                };
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    if (data.data.statusResponse == 0) {
                        this.truongHocDangNhap = data.data.rows[0].tenTruongHoc;
                    } else {
                        this.truongHocDangNhap = this.thongtin.display_name;
                    }
                });
            },
            bindCapHocDangNhap() {
                if (this.thongtin.listCapHoc.length == 1) {
                    for (let i = 0; i < this.thongtin.listCapHoc.length; i++) {
                        if (this.thongtin.listCapHoc[0] == 1) {
                            this.capHocDangNhap = "Trường Tiểu học";
                        }
                        if (this.thongtin.listCapHoc[0] == 2) {
                            this.capHocDangNhap = "Trường THCS";
                        }
                        if (this.thongtin.listCapHoc[0] == 3) {
                            this.capHocDangNhap = "Trường THPT";
                        }
                        if (this.thongtin.listCapHoc[0] == 4) {
                            this.capHocDangNhap = "Trường Nhà trẻ";
                        }
                        if (this.thongtin.listCapHoc[0] == 5) {
                            this.capHocDangNhap = "Trường Nhà trẻ";
                        }
                        if (this.thongtin.listCapHoc[0] == 6) {
                            this.capHocDangNhap = "Trường GDTX";
                        }
                    }
                } else {
                    if (this.thongtin.listCapHoc[0] == 4 && this.thongtin.listCapHoc[1] == 5) {
                        this.capHocDangNhap = "Trường Mầm non";
                    } else {
                        this.capHocDangNhap = "Trường liên cấp";
                    }
                }
            },
            layToanBoSMEMappingCode() {
                const loadingMpc = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                let params = {
                    type: '2'
                }
                rest_api.post("/csdlgd-admin/sme/getDanhSachSmeMoetCode", params, data => {
                    loadingMpc.close();
                    console.log(data);
                    if (data.data.rc == 0) {
                        let data_dm = data.data.tableData;
                        for (let i = 0; i < data_dm.length; i++) {
                            let ldt = [{
                                name: "Chọn",
                                label: "Chọn",
                                value: ""
                            }]
                            for (let j = 0; j < data_dm[i].list_data.length; j++) {
                                let obj = {
                                    name: data_dm[i].list_data[j].constantTitle,
                                    label: data_dm[i].list_data[j].constantTitle,
                                    value: data_dm[i].list_data[j].moetCode,
                                }
                                ldt.push(obj);
                            }
                            this.ganDuLieuSMEMoetCode(data_dm[i].constantType, ldt)
                        }
                    }
                });
            },
            layToanBoSMEMoetCode() {
                const loadingMec = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                let params = {
                    type: '2'
                }
                rest_api.post("/csdlgd-admin/sme/getDanhSachSme", params, data => {
                    loadingMec.close();
                    console.log(data);
                    if (data.data.rc == 0) {
                        let data_dm = data.data.tableData;
                        for (let i = 0; i < data_dm.length; i++) {
                            let ldt = [{
                                name: "Chọn",
                                label: "Chọn",
                                value: ""
                            }]
                            for (let j = 0; j < data_dm[i].list_data.length; j++) {
                                let obj = {
                                    name: data_dm[i].list_data[j].constantTitle,
                                    label: data_dm[i].list_data[j].constantTitle,
                                    value: data_dm[i].list_data[j].mappingCode,
                                }
                                ldt.push(obj);
                            }
                            this.ganDuLieuSME(data_dm[i].constantType, ldt)
                        }
                    }
                });
            },
            ganDuLieuSMEMoetCode(k, dt) {
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
            },
            ganDuLieuSME(k, dt) {
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
                    localStorage["danh_sach_cap_trang_thai_hoc_sinh_sme"] = JSON.stringify(dt)
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
                if (k == 'DM_TON_GIAO') {
                    localStorage["danh_sach_ton_giao_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_TRANG_THAI_CAN_BO') {
                    localStorage["danh_sach_trang_thai_can_bo_sme"] = JSON.stringify(dt)
                }
            },
            tuyChonTruongHocChatLuongDaoTao() {
                this.tuyChonTruongHoc.chatLuongDaoTao = !this.tuyChonTruongHoc.chatLuongDaoTao
            },
            tuyChonTruongHocLoaiHinhDaoTao() {
                this.tuyChonTruongHoc.loaiHinhDaoTao = !this.tuyChonTruongHoc.loaiHinhDaoTao
            },
            getAllDataChart() {
                // Lấy dữ liệu
                this.layDuLieuTruongHoc();
                this.layDuLieuGiaoVien();
                this.layDuLieuHocSinh();
                // Trường học
                this.getDuLieuTruongHocTongQuan();
                this.getDuLieuTruongHocChatLuongDaoTao();
                this.getDuLieuTruongHocLoaiHinhDaoTao();
                // Học sinh
                this.getDuLieuHocSinhTongQuan();
                this.getDuLieuHocSinhTheoKhuVuc();
                this.getDuLieuHocSinhTheoGioiTinh();
                this.getDuLieuHocSinhTheoTrangThai();
                this.getDuLieuHocSinhTheoLoaiHinh();
                // Cán bộ
                this.getDuLieuCanBoGiaoVienTongQuan();
                this.getDuLieuCanBoGiaoVienTrinhDoChinh();
                this.getDuLieuCanBoGiaoVienGioiTinh();
                this.getDuLieuCanBoGiaoVienLoaiHopDong();
                // Phân loại cán bộ
                this.getDuLieuPhanLoaiCanBoTongQuan();
                this.getDuLieuPhanLoaiCanBoTheoDoTuoi();
                this.getDuLieuPhanLoaiCanBoTheoDoLoaiHinhDaoTao();
                this.getDuLieuPhanLoaiCanBoTheoTrangThai();
                // Phổ điểm
                this.getPhoDiemHocKyI();
                this.getPhoDiemHocKyII();
                this.getPhoDiemDanhGiaHocKyI();
                this.getPhoDiemDanhGiaHocKyII();
                this.getPhoDiemDanhGiaCaNam();
                // Biến động
                this.getBienDongTongSoLopHoc()
                this.getBienDongTongSoGiaoVien()
                this.getBienDongTrinhDoGiaoVien()
                this.getBienDongTongSoHocSinh()
                this.getBienDongHocLucHocSinh()
                //Chi tiết học ực, hạnh kiểm
                this.getDataChiTietHocLuc()
                this.getDataChiTietHanhKiem()
            },
            layChiTietHocLucVaHanhKiem() {
                this.getDataChiTietHocLuc()
                this.getDataChiTietHanhKiem()
            },
            ganViTri(e) {
                console.log("Map lại vị trí");
                let data = e;
                console.log(data);
                for (let i = 0; i < data.length; i++) {
                    if (data[i].name == 'MN') {
                        data[i].id = 1
                    };
                    if (data[i].name == 'TH') {
                        data[i].id = 2
                    };
                    if (data[i].name == 'THCS') {
                        data[i].id = 3
                    };
                    if (data[i].name == 'THPT') {
                        data[i].id = 4
                    };
                    if (data[i].name == 'GDTX') {
                        data[i].id = 5
                    };
                    if (data[i].name == 'LC') {
                        data[i].id = 6
                    };
                    if (data[i].name == 'LC145') {
                        data[i].id = 7
                    };
                    if (data[i].name == 'LC12') {
                        data[i].id = 8
                    };
                    if (data[i].name == 'LC23') {
                        data[i].id = 9
                    };
                    if (data[i].name == 'LCK') {
                        data[i].id = 10
                    };
                }
                console.log('***********');
                console.log(data);
                return data;
            },
            mapLaiViTri(array, key) {
                return array.sort(function (a, b) {
                    var x = a[key];
                    var y = b[key];
                    return ((x < y) ? -1 : ((x > y) ? 1 : 0));
                });
            },
            getStatus(e) {
                if (e == 'augment') {
                    return 'Tăng'
                } else if (e == 'abatement') {
                    return 'Giảm'
                } else {
                    return 'Không thay đổi'
                }
            },
            layLaiDuLieuGiaoVien() {
                this.danhSachTruongHoc = [];
                this.danh_sach_truong_hoc = [];
                this.dataChiTiet.khoiHoc = '',
                    this.mapKhoiHoc(this.danhSachCapHoc)
                this.getTruongHoc();
            },
            layLaiDuLieuTangGiamTruongHoc() {
                // Lấy lại các thông tin trường học
            },
            getTruongHoc() {
                // const loading = this.$loading({
                //     lock: true,
                //     text: 'Loading',
                //     spinner: 'el-icon-loading',
                //     background: 'rgba(0, 0, 0, 0.7)'
                // });
                let params = {
                    maDonVi: this.danhSachDonVi,
                    capHoc: this.danhSachCapHoc,
                };
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    // loading.close();
                    let data_demo = [];
                    if (data.data.statusResponse == 0) {
                        for (let i = 0; i < data.data.rows.length; i++) {
                            let obj = {
                                name: data.data.rows[i].tenTruongHoc + " - [" + data.data.rows[i]
                                    .maTruongHoc + "]",
                                value: data.data.rows[i].maTruongHoc,
                            }
                            data_demo.push(obj);
                        }
                        this.danh_sach_truong_hoc = data_demo;
                    } else {
                        this.danh_sach_truong_hoc = [];
                    }
                });
            },
            getTenDonVi(e) {
                let ten = "";
                for (let i = 0; i < this.danh_sach_don_vi.length; i++) {
                    if (this.danh_sach_don_vi[i].maDonVi == e) {
                        ten = this.danh_sach_don_vi[i].ten;
                    }
                }
                return ten;
            },
            getDonVi() {
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.ma_so
                };
                const loadingDv = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    loadingDv.close();
                    // console.log("hihihi");
                    // console.log(data.data);
                    if (data.data.message == 'OK') {
                        // console.log("hihi");
                        let data_demo = data.data.rows;
                        // console.log(JSON.stringify(data_demo));
                        for (let i = 0; i < data_demo.length; i++) {
                            // console.log("object");
                            let obj = {
                                tenDonVi: data_demo[i].tenDonVi.replace("Giáo dục và Đào tạo", "GD&ĐT") +
                                    ' - [' + data_demo[i].maDonVi + ']',
                                maDonVi: data_demo[i].maDonVi,
                                ten: data_demo[i].tenDonVi,
                            }
                            if (this.thongtin.ma_don_vi == data_demo[i].maDonVi) {
                                this.tenDonViDangNhap = data_demo[i].tenDonVi;
                            }
                            // console.log(obj);
                            this.danh_sach_don_vi.push(obj);
                        }
                    }
                });
            },
            getTenMonHocPhoDiem(e) {
                let data = e;
                for (let i = 0; i < data.length; i++) {
                    data[i].name = this.getTenMon(data[i].name);
                }
                return data;
            },
            getTenMon(e) {
                if (e == 'DLY') {
                    return 'Địa lý'
                }
                if (e == 'NN') {
                    return 'Ngoại ngữ'
                }
                if (e == 'HHC') {
                    return 'Hóa học'
                }
                if (e == 'VLY') {
                    return 'Vật lý'
                }
                if (e == 'NVN') {
                    return 'Ngữ văn'
                }
                if (e == 'GCD') {
                    return 'GDCD'
                }
                if (e == 'TOC') {
                    return 'Toán'
                }
                if (e == 'LSU') {
                    return 'Lịch sử'
                }
                if (e == 'SHC') {
                    return 'Sinh học'
                }
            },
            getDataChiTietHocLuc() {
                console.log('getDataChiTietHocLuc')
                this.loadChiTiet.hocLuc = true;
                this.duLieuChiTiet.hocLuc = []
                let params = {
                    "capHocs": this.danhSachCapHoc,
                    "maDonVis": this.danhSachDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": this.danhSachTruongHoc,
                    "hocKy": this.dataChiTiet.hocKy,
                    "namHoc": this.namHoc
                }
                if (this.thongtin.role == 5) {
                    params.maTruongs = [this.thongtin.ma_truong_hoc];
                    params.maDonVis = [this.thongtin.ma_don_vi];
                    params.capHocs = this.thongtin.listCapHoc
                }
                rest_api.post("/csdlgd-report-api/ioc-dashboard/kqHocTapTron", params, data => {
                    this.loadChiTiet.hocLuc = false;
                    if (data.data.rc == 0) {
                        console.log(data.data.item)
                        console.log("phổ điểm lấy về");
                        this.duLieuChiTiet.hocLuc = data.data.item
                    } else {
                        this.duLieuChiTiet.hocLuc = []
                    }
                });

            },
            getDataChiTietHanhKiem() {
                console.log('getDataChiTietHanhKiem')
                this.loadChiTiet.hanhKiem = true;
                this.duLieuChiTiet.hanhKiem = []
                let params = {
                    "capHocs": this.danhSachCapHoc,
                    "maDonVis": this.danhSachDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": this.danhSachTruongHoc,
                    "hocKy": this.dataChiTiet.hocKy,
                    "namHoc": this.namHoc
                }
                if (this.thongtin.role == 5) {
                    params.maTruongs = [this.thongtin.ma_truong_hoc];
                    params.maDonVis = [this.thongtin.ma_don_vi];
                    params.capHocs = this.thongtin.listCapHoc
                }
                rest_api.post("/csdlgd-report-api/ioc-dashboard/kqRenLuyenTron", params, data => {
                    this.loadChiTiet.hanhKiem = false;
                    if (data.data.rc == 0) {
                        console.log(data.data.item)
                        console.log("phổ điểm lấy về");
                        this.duLieuChiTiet.hanhKiem = data.data.item
                    } else {
                        this.duLieuChiTiet.hanhKiem = []
                    }
                });

            },
            getPhoDiemHocKyII() {
                this.loadPhoDiem.hocKyII = true;
                this.duLieuPhoDiem.hocKyII = []
                let params = {
                    "capHocs": this.danhSachCapHoc,
                    "maDonVis": this.danhSachDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": this.danhSachTruongHoc,
                    "hocKy": 2,
                    "namHoc": this.namHoc
                }
                //check rieng hải phòng năm học 2022
                if (this.thongtin.ma_so == 31) {
                    if (this.namHoc == 2023) {
                        params.namHoc = 2022
                    }
                }
                if (this.thongtin.role == 5) {
                    params.maTruongs = [this.thongtin.ma_truong_hoc];
                    params.maDonVis = [this.thongtin.ma_don_vi];
                    params.capHocs = this.thongtin.listCapHoc
                }
                rest_api.post("/csdlgd-report-api/dasboard/ketquahoctap", params, data => {
                    this.loadPhoDiem.hocKyII = false;
                    if (data.data.rc == 0) {
                        this.duLieuPhoDiem.hocKyII = data.data.item.listData;
                        // this.duLieuPhoDiem.hocKyII = this.getTenMonHocPhoDiem(this.duLieuPhoDiem.hocKyII);
                        console.log("phổ điểm lấy về");
                        console.log(this.duLieuPhoDiem);
                    } else {
                        this.duLieuPhoDiem.hocKyII = []
                    }
                });
            },
            getPhoDiemHocKyI() {
                this.loadPhoDiem.hocKyI = true;
                this.duLieuPhoDiem.hocKyI = []
                let params = {
                    "capHocs": this.danhSachCapHoc,
                    "maDonVis": this.danhSachDonVi,
                    "hocKy": 1,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": this.danhSachTruongHoc,
                    "namHoc": this.namHoc
                }
                if (this.thongtin.role == 5) {
                    params.maTruongs = [this.thongtin.ma_truong_hoc];
                    params.maDonVis = [this.thongtin.ma_don_vi];
                    params.capHocs = this.thongtin.listCapHoc
                }
                //check rieng hải phòng năm học 2022
                if (this.thongtin.ma_so == 31) {
                    if (this.namHoc == 2023) {
                        params.namHoc = 2022
                    }
                }
                rest_api.post("/csdlgd-report-api/dasboard/ketquahoctap", params, data => {
                    this.loadPhoDiem.hocKyI = false;
                    if (data.data.rc == 0) {
                        this.duLieuPhoDiem.hocKyI = data.data.item.listData;
                        // this.duLieuPhoDiem.hocKyI = this.getTenMonHocPhoDiem(this.duLieuPhoDiem.hocKyI);
                    } else {
                        this.duLieuPhoDiem.hocKyI = []
                    }
                });
            },
            getDuLieuPhanLoaiCanBoTheoTrangThai() {
                this.loadPhanLoaiCanBo.trangThai = true;
                let params = {
                    // "capHocs": this.danhSachCapHoc,
                    "capHocs": this.danhSachCapHocString,
                    "maDonVis": this.danhSachDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": this.danhSachTruongHoc,
                    "namHoc": this.namHoc
                }
                if (this.thongtin.role == 5) {
                    params.maTruongs = [this.thongtin.ma_truong_hoc];
                    params.maDonVis = [this.thongtin.ma_don_vi];
                    params.capHocs = this.thongtin.listCapHoc
                }
                //check rieng hải phòng năm học 2022
                if (this.thongtin.ma_so == 31) {
                    if (this.namHoc == 2023) {
                        params.namHoc = 2022
                    }
                }
                rest_api.post("/csdlgd-report-api/dasboard/canbogvtrangthai", params, data => {
                    this.loadPhanLoaiCanBo.trangThai = false;
                    if (data.data.rc == 0) {
                        // Lược bớt trạng thái cán bộ
                        let data_dm = data.data.item.listData;
                        for (let i = 0; i < data_dm.length; i++) {
                            let tong_khac = 0;
                            for (let j = 3; j < data_dm[i].data.length; j++) {
                                tong_khac = tong_khac + data_dm[i].data[j];
                            }
                            let du_lieu_sau_map = [data_dm[i].data[0], data_dm[i].data[1], data_dm[i].data[2],
                                tong_khac
                            ];
                            data_dm[i].data = du_lieu_sau_map;
                        }
                        // this.duLieuPhanLoaiCanBo.trangThai = data.data.item.listData;
                        this.duLieuPhanLoaiCanBo.trangThai = data_dm;
                    } else {
                        this.duLieuPhanLoaiCanBo.trangThai = []
                    }
                });
            },
            getDuLieuPhanLoaiCanBoTheoDoLoaiHinhDaoTao() {
                this.loadPhanLoaiCanBo.loaiHinhDaoTao = true;
                let params = {
                    // "capHocs": this.danhSachCapHoc,
                    "capHocs": this.danhSachCapHocString,
                    "maDonVis": this.danhSachDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": this.danhSachTruongHoc,
                    "namHoc": this.namHoc
                }
                if (this.thongtin.role == 5) {
                    params.maTruongs = [this.thongtin.ma_truong_hoc];
                    params.maDonVis = [this.thongtin.ma_don_vi];
                    params.capHocs = this.thongtin.listCapHoc
                }
                //check rieng hải phòng năm học 2022
                if (this.thongtin.ma_so == 31) {
                    if (this.namHoc == 2023) {
                        params.namHoc = 2022
                    }
                }
                rest_api.post("/csdlgd-report-api/dasboard/canbogvloaihinhdaotao", params, data => {
                    this.loadPhanLoaiCanBo.loaiHinhDaoTao = false;
                    if (data.data.rc == 0) {
                        this.duLieuPhanLoaiCanBo.loaiHinhDaoTao = data.data.item.listData;
                    } else {
                        this.duLieuPhanLoaiCanBo.loaiHinhDaoTao = []
                    }
                });
            },
            getDuLieuPhanLoaiCanBoTheoDoTuoi() {
                this.loadPhanLoaiCanBo.doTuoi = true;
                let params = {
                    // "capHocs": this.danhSachCapHoc,
                    "capHocs": this.danhSachCapHocString,
                    "maDonVis": this.danhSachDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": this.danhSachTruongHoc,
                    "namHoc": this.namHoc
                }
                if (this.thongtin.role == 5) {
                    params.maTruongs = [this.thongtin.ma_truong_hoc];
                    params.maDonVis = [this.thongtin.ma_don_vi];
                    params.capHocs = this.thongtin.listCapHoc
                }
                //check rieng hải phòng năm học 2022
                if (this.thongtin.ma_so == 31) {
                    if (this.namHoc == 2023) {
                        params.namHoc = 2022
                    }
                }
                rest_api.post("/csdlgd-report-api/dasboard/canbogvloaidotuoi", params, response => {
                    this.loadPhanLoaiCanBo.doTuoi = false;
                    if (response.data.rc == 0) {
                        let listData = response.data.item.listData;

                        for (let i = 0; i < listData.length; i++) {
                            listData[i].name = this.getTenLoaiCanBo(listData[i].name);
                        }
                        this.duLieuPhanLoaiCanBo.doTuoi = {
                            category: ['<20', '20-29', '30-39', '40-49', '50-54', '55-59', '≥60'],
                            series: listData,
                            height: '400'
                        }
                    } else {
                        this.duLieuPhanLoaiCanBo.doTuoi = {}
                    }
                    console.error('doTuoi')
                    console.error(this.duLieuPhanLoaiCanBo.doTuoi)
                });
            },
            getDuLieuPhanLoaiCanBoTongQuan() {
                this.loadPhanLoaiCanBo.tongQuan = true;
                let params = {
                    // "capHocs": this.danhSachCapHoc,
                    "capHocs": this.danhSachCapHocString,
                    "maDonVis": this.danhSachDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": this.danhSachTruongHoc,
                    "namHoc": this.namHoc
                }
                if (this.thongtin.role == 5) {
                    params.maTruongs = [this.thongtin.ma_truong_hoc];
                    params.maDonVis = [this.thongtin.ma_don_vi];
                    params.capHocs = this.thongtin.listCapHoc
                }
                //check rieng hải phòng năm học 2022
                if (this.thongtin.ma_so == 31) {
                    if (this.namHoc == 2023) {
                        params.namHoc = 2022
                    }
                }
                rest_api.post("/csdlgd-report-api/dasboard/phanLoaiCanBo", params, response => {
                    this.loadPhanLoaiCanBo.tongQuan = false;
                    if (response.data.rc == 0) {
                        this.duLieuPhanLoaiCanBo.tongQuan = {
                            category: ['Cán bộ quản lý', 'Giáo viên', 'Nhân viên'],
                            series: response.data.item.listValue,
                            totalText: 'CBGVNV',
                        }
                    } else {
                        this.duLieuPhanLoaiCanBo.tongQuan = {}
                    }
                });
            },
            getDuLieuHocSinhTheoLoaiHinh() {
                this.loadingHocSinh.loaiHinh = true;
                let params = {
                    // "capHocs": this.danhSachCapHoc,
                    "capHocs": this.danhSachCapHocString,
                    "maDonVis": this.danhSachDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": this.danhSachTruongHoc,
                    "namHoc": this.namHoc
                }
                if (this.thongtin.role == 5) {
                    params.maTruongs = [this.thongtin.ma_truong_hoc];
                    params.maDonVis = [this.thongtin.ma_don_vi];
                    params.capHocs = this.thongtin.listCapHoc
                }
                //check rieng hải phòng năm học 2022
                if (this.thongtin.ma_so == 31) {
                    if (this.namHoc == 2023) {
                        params.namHoc = 2022
                    }
                }
                rest_api.post("/csdlgd-report-api/dasboard/hocsinhloaihinhdaotao", params, response => {
                    this.loadingHocSinh.loaiHinh = false;
                    if (response.data.rc == 0) {
                        let dulieu = response.data.item.listData;
                        let listData = this.ganViTri(dulieu);
                        for (let i = 0; i < listData.length; i++) {
                            listData[i].name = this.getTenCapHoc(listData[i].name);
                        }
                        listData.sort((a, b) => (a.id > b.id) ? 1 : -1)
                        this.duLieuHocSinh.loaiHinh = {
                            category: ['Công lập', 'Tư thục', 'Dân lập'],
                            series: listData,
                            height: '400'
                        }
                    } else {
                        this.duLieuHocSinh.loaiHinh = {}
                    }
                });
            },
            getDuLieuHocSinhTheoTrangThai() {
                this.loadingHocSinh.trangThai = true;
                let params = {
                    // "capHocs": this.danhSachCapHoc,
                    "capHocs": this.danhSachCapHocString,
                    "maDonVis": this.danhSachDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": this.danhSachTruongHoc,
                    "namHoc": this.namHoc
                }
                if (this.thongtin.role == 5) {
                    params.maTruongs = [this.thongtin.ma_truong_hoc];
                    params.maDonVis = [this.thongtin.ma_don_vi];
                    params.capHocs = this.thongtin.listCapHoc
                }
                //check rieng hải phòng năm học 2022
                if (this.thongtin.ma_so == 31) {
                    if (this.namHoc == 2023) {
                        params.namHoc = 2022
                    }
                }
                rest_api.post("/csdlgd-report-api/dasboard/hocsinhtrangthai", params, data => {
                    this.loadingHocSinh.trangThai = false;
                    if (data.data.rc == 0) {
                        let dulieu = data.data.item.listData;
                        let listData = this.ganViTri(dulieu);
                        for (let i = 0; i < listData.length; i++) {
                            listData[i].name = this.getTenCapHoc(listData[i].name);
                        }
                        listData.sort((a, b) => (a.id > b.id) ? 1 : -1)
                        for (let i = 0; i < listData.length; i++) {
                            let dm = [listData[i].data[0], listData[i].data[2]];
                            listData[i].data = dm;
                        }
                        this.duLieuHocSinh.trangThai = {
                            category: ['Đang học', 'Chuyển trường'],
                            series: listData,
                            height: '400'
                        }
                    } else {
                        this.duLieuHocSinh.trangThai = {}
                    }
                });
            },
            getDuLieuHocSinhTheoGioiTinh() {
                this.loadingHocSinh.gioiTinh = true;
                let params = {
                    // "capHocs": this.danhSachCapHoc,
                    "capHocs": this.danhSachCapHocString,
                    "maDonVis": this.danhSachDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": this.danhSachTruongHoc,
                    "namHoc": this.namHoc
                }
                //check rieng hải phòng năm học 2022
                if (this.thongtin.ma_so == 31) {
                    if (this.namHoc == 2023) {
                        params.namHoc = 2022
                    }
                }
                if (this.thongtin.role == 5) {
                    params.maTruongs = [this.thongtin.ma_truong_hoc];
                    params.maDonVis = [this.thongtin.ma_don_vi];
                    params.capHocs = this.thongtin.listCapHoc
                }
                rest_api.post("/csdlgd-report-api/dasboard/hocsinhgioitinh", params, response => {
                    this.loadingHocSinh.gioiTinh = false;
                    if (response.data.rc == 0) {
                        let dulieu = response.data.item.listData;
                        let listData = this.ganViTri(dulieu);
                        for (let i = 0; i < listData.length; i++) {
                            listData[i].name = this.getTenCapHoc(listData[i].name);
                        }
                        listData.sort((a, b) => (a.id > b.id) ? 1 : -1)
                        this.duLieuHocSinh.gioiTinh = {
                            category: ['Nam', 'Nữ'],
                            series: listData,
                            height: '400'
                        }
                    } else {
                        this.duLieuHocSinh.gioiTinh = {}
                    }
                });
            },
            getPhoDiemDanhGiaHocKyI() {
                this.loadPhoDiem.ketQuaDanhGiaHocKyI = true;
                let params = {
                    "capHocs": this.danhSachCapHoc,
                    "maDonVis": this.danhSachDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": this.danhSachTruongHoc,
                    "hocKy": 1,
                    "namHoc": this.namHoc
                }
                if (this.thongtin.role == 5) {
                    params.maTruongs = [this.thongtin.ma_truong_hoc];
                    params.maDonVis = [this.thongtin.ma_don_vi];
                    params.capHocs = this.thongtin.listCapHoc
                }
                //check rieng hải phòng năm học 2022
                if (this.thongtin.ma_so == 31) {
                    if (this.namHoc == 2023) {
                        params.namHoc = 2022
                    }
                }
                rest_api.post("/csdlgd-report-api/dasboard/danhgiahocsinh", params, data => {
                    this.loadPhoDiem.ketQuaDanhGiaHocKyI = false;
                    if (data.data.rc == 0) {
                        this.duLieuPhoDiem.ketQuaDanhGiaHocKyI = data.data.item.listData;
                    } else {
                        this.duLieuPhoDiem.ketQuaDanhGiaHocKyI = []
                    }
                });
            },
            getPhoDiemDanhGiaHocKyII() {
                this.loadPhoDiem.ketQuaDanhGiaHocKyII = true;
                let params = {
                    "capHocs": this.danhSachCapHoc,
                    "maDonVis": this.danhSachDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": this.danhSachTruongHoc,
                    "hocKy": 2,
                    "namHoc": this.namHoc
                }
                if (this.thongtin.role == 5) {
                    params.maTruongs = [this.thongtin.ma_truong_hoc];
                    params.maDonVis = [this.thongtin.ma_don_vi];
                    params.capHocs = this.thongtin.listCapHoc
                }
                //check rieng hải phòng năm học 2022
                if (this.thongtin.ma_so == 31) {
                    if (this.namHoc == 2023) {
                        params.namHoc = 2022
                    }
                }
                rest_api.post("/csdlgd-report-api/dasboard/danhgiahocsinh", params, data => {
                    this.loadPhoDiem.ketQuaDanhGiaHocKyII = false;
                    if (data.data.rc == 0) {
                        this.duLieuPhoDiem.ketQuaDanhGiaHocKyII = data.data.item.listData;
                    } else {
                        this.duLieuPhoDiem.ketQuaDanhGiaHocKyII = []
                    }
                });
            },
            getBienDongTongSoLopHoc() {
                console.log('getBienDongTongSoLopHoc')
                this.loadBienDong.tongSoLopHoc = true;
                let params = {
                    "capHocs": this.danhSachCapHoc,
                    "maDonVis": this.danhSachDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": this.danhSachTruongHoc,
                    "hocKy": 3,
                    "namHoc": this.namHoc
                }
                if (this.thongtin.role == 5) {
                    params.maTruongs = [this.thongtin.ma_truong_hoc];
                    params.maDonVis = [this.thongtin.ma_don_vi];
                    params.capHocs = this.thongtin.listCapHoc
                }
                if (this.thongtin.ma_so == 31) {
                    if (this.namHoc == 2023) {
                        params.namHoc = 2022
                    }
                }
                rest_api.post("/csdlgd-report-api/ioc-dashboard/lop-hoc-theo-nam", params, data => {
                    this.loadBienDong.tongSoLopHoc = false;
                    console.log('kết quả: biến động lớp học')
                    if (data.data.rc == 0) {
                        this.duLieuBienDong.tongSoLopHoc = data.data.item.listData;
                    } else {
                        this.duLieuBienDong.tongSoLopHoc = []
                    }
                });
            },
            getBienDongTongSoGiaoVien() {
                console.log('getBienDongTongSoGiaoVien')
                this.loadBienDong.tongSoGiaoVien = true;
                let params = {
                    "capHocs": this.danhSachCapHoc,
                    "maDonVis": this.danhSachDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": this.danhSachTruongHoc,
                    "hocKy": 3,
                    "namHoc": this.namHoc
                }
                if (this.thongtin.role == 5) {
                    params.maTruongs = [this.thongtin.ma_truong_hoc];
                    params.maDonVis = [this.thongtin.ma_don_vi];
                    params.capHocs = this.thongtin.listCapHoc
                }
                if (this.thongtin.ma_so == 31) {
                    if (this.namHoc == 2023) {
                        params.namHoc = 2022
                    }
                }
                rest_api.post("/csdlgd-report-api/ioc-dashboard/gv-theo-nam", params, data => {
                    this.loadBienDong.tongSoGiaoVien = false;
                    console.log('kết quả: biến động tổng số giáo viên theo năm')
                    if (data.data.rc == 0) {
                        this.duLieuBienDong.tongSoGiaoVien = data.data.item.listData;
                    } else {
                        this.duLieuBienDong.tongSoGiaoVien = []
                    }
                });
            },
            getBienDongTrinhDoGiaoVien() {
                console.log('getBienDongTrinhDoGiaoVien')
                console.log('1')
                this.loadBienDong.trinhDoGiaoVien = true;
                console.log('2')
                let params = {
                    "capHocs": this.danhSachCapHoc,
                    "maDonVis": this.danhSachDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": this.danhSachTruongHoc,
                    "hocKy": 3,
                    "namHoc": this.namHoc
                }
                if (this.thongtin.role == 5) {
                    params.maTruongs = [this.thongtin.ma_truong_hoc];
                    params.maDonVis = [this.thongtin.ma_don_vi];
                    params.capHocs = this.thongtin.listCapHoc
                }
                if (this.thongtin.ma_so == 31) {
                    if (this.namHoc == 2023) {
                        params.namHoc = 2022
                    }
                }
                rest_api.post("/csdlgd-report-api/ioc-dashboard/gv-nam-trinh-do", params, data => {
                    this.loadBienDong.trinhDoGiaoVien = false;
                    console.log('kết quả: biến động trình độ giáo viên')
                    if (data.data.rc == 0) {
                        this.duLieuBienDong.trinhDoGiaoVien = data.data.item.listData;
                    } else {
                        this.duLieuBienDong.trinhDoGiaoVien = []
                    }
                });
            },
            getBienDongTongSoHocSinh() {
                console.log('getBienDongTongSoHocSinh')
                this.loadBienDong.tongSoHocSinh = true;
                let params = {
                    "capHocs": this.danhSachCapHoc,
                    "maDonVis": this.danhSachDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": this.danhSachTruongHoc,
                    "hocKy": 3,
                    "namHoc": this.namHoc
                }
                if (this.thongtin.role == 5) {
                    params.maTruongs = [this.thongtin.ma_truong_hoc];
                    params.maDonVis = [this.thongtin.ma_don_vi];
                    params.capHocs = this.thongtin.listCapHoc
                }
                if (this.thongtin.ma_so == 31) {
                    if (this.namHoc == 2023) {
                        params.namHoc = 2022
                    }
                }
                rest_api.post("/csdlgd-report-api/ioc-dashboard/hs-theo-nam", params, data => {
                    this.loadBienDong.tongSoHocSinh = false;
                    console.log('kết quả: biến động tổng số học sinh')
                    if (data.data.rc == 0) {
                        this.duLieuBienDong.tongSoHocSinh = data.data.item.listData;
                    } else {
                        this.duLieuBienDong.tongSoHocSinh = []
                    }
                });
            },
            getBienDongHocLucHocSinh() {
                console.log('getBienDongHocLucHocSinh')
                this.loadBienDong.hocLucHocSinh = true;
                let params = {
                    "capHocs": this.danhSachCapHoc,
                    "maDonVis": this.danhSachDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": this.danhSachTruongHoc,
                    "hocKy": 3,
                    "namHoc": this.namHoc
                }
                if (this.thongtin.role == 5) {
                    params.maTruongs = [this.thongtin.ma_truong_hoc];
                    params.maDonVis = [this.thongtin.ma_don_vi];
                    params.capHocs = this.thongtin.listCapHoc
                }
                //check rieng hải phòng năm học 2022
                if (this.thongtin.ma_so == 31) {
                    if (this.namHoc == 2023) {
                        params.namHoc = 2022
                    }
                }
                console.log('befor hlhs')
                rest_api.post("/csdlgd-report-api/ioc-dashboard/hs-theo-nam-hoc-luc", params, data => {
                    this.loadBienDong.hocLucHocSinh = false;
                    console.log('kết quả: biến động học lực học sinh')
                    if (data.data.rc == 0) {
                        this.duLieuBienDong.hocLucHocSinh = data.data.item.listData;
                    } else {
                        this.duLieuBienDong.hocLucHocSinh = []
                    }
                });
            },
            getPhoDiemDanhGiaCaNam() {
                this.loadPhoDiem.ketQuaDanhGiaCaNam = true;
                let params = {
                    "capHocs": this.danhSachCapHoc,
                    "maDonVis": this.danhSachDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": this.danhSachTruongHoc,
                    "hocKy": 3,
                    "namHoc": this.namHoc
                }
                if (this.thongtin.role == 5) {
                    params.maTruongs = [this.thongtin.ma_truong_hoc];
                    params.maDonVis = [this.thongtin.ma_don_vi];
                    params.capHocs = this.thongtin.listCapHoc
                }
                //check rieng hải phòng năm học 2022
                if (this.thongtin.ma_so == 31) {
                    if (this.namHoc == 2023) {
                        params.namHoc = 2022
                    }
                }
                rest_api.post("/csdlgd-report-api/dasboard/danhgiahocsinh", params, data => {
                    this.loadPhoDiem.ketQuaDanhGiaCaNam = false;
                    if (data.data.rc == 0) {
                        this.duLieuPhoDiem.ketQuaDanhGiaCaNam = data.data.item.listData;
                    } else {
                        this.duLieuPhoDiem.ketQuaDanhGiaCaNam = []
                    }
                });
            },
            getDuLieuHocSinhTheoKhuVuc() {
                this.loadingHocSinh.khuVuc = true;
                let params = {
                    // "capHocs": this.danhSachCapHoc,
                    "capHocs": this.danhSachCapHocString,
                    "maDonVis": this.danhSachDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": this.danhSachTruongHoc,
                    "namHoc": this.namHoc
                }
                if (this.thongtin.role == 5) {
                    params.maTruongs = [this.thongtin.ma_truong_hoc];
                    params.maDonVis = [this.thongtin.ma_don_vi];
                    params.capHocs = this.thongtin.listCapHoc
                }
                //check rieng hải phòng năm học 2022
                if (this.thongtin.ma_so == 31) {
                    if (this.namHoc == 2023) {
                        params.namHoc = 2022
                    }
                }
                rest_api.post("/csdlgd-report-api/dasboard/hocsinhkhuvuc", params, response => {
                    this.loadingHocSinh.khuVuc = false;
                    if (response.data.rc == 0) {
                        let dulieu = response.data.item.listData;
                        let listData = this.ganViTri(dulieu);
                        for (let i = 0; i < listData.length; i++) {
                            listData[i].name = this.getTenCapHoc(listData[i].name);
                        }
                        listData.sort((a, b) => (a.id > b.id) ? 1 : -1)
                        this.duLieuHocSinh.khuVuc = {
                            category: ['B.Giới-H.Đảo', 'Đô thị', 'Đồng bằng', 'M.Núi-V.Sâu'],
                            series: listData,
                            height: '400'
                        }
                    } else {
                        this.duLieuHocSinh.khuVuc = {}
                    }
                });
            },
            getDuLieuHocSinhTongQuan() {
                this.loadingHocSinh.tongQuan = true;
                let params = {
                    // "capHocs": this.danhSachCapHoc,
                    "capHocs": this.danhSachCapHocString,
                    "maDonVis": this.danhSachDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": this.danhSachTruongHoc,
                    "namHoc": this.namHoc
                }
                if (this.thongtin.role == 5) {
                    params.maTruongs = [this.thongtin.ma_truong_hoc];
                    params.maDonVis = [this.thongtin.ma_don_vi];
                    params.capHocs = this.thongtin.listCapHoc
                }
                //check rieng hải phòng năm học 2022
                if (this.thongtin.ma_so == 31) {
                    if (this.namHoc == 2023) {
                        params.namHoc = 2022
                    }
                }
                rest_api.post("/csdlgd-report-api/dasboard/hocsinh", params, response => {
                    this.loadingHocSinh.tongQuan = false;
                    if (response.data.rc == 0) {
                        this.duLieuHocSinh.tongQuan = {
                            category: ['Mầm non', 'Tiểu học', 'THCS', 'THPT', 'GDTX', 'Liên cấp'],
                            series: response.data.item.listValue,
                            totalText: 'HS',
                        }
                    } else {
                        this.duLieuHocSinh.tongQuan = {
                            category: [],
                            series: [],
                            totalText: 'Học sinh',
                        }
                    }
                    console.error('Dữ liệu tổng quan học sinh:')
                    console.error(this.duLieuHocSinh.tongQuan)
                });
            },
            getDuLieuCanBoGiaoVienLoaiHopDong() {
                this.loadCanBoGiaoVien.loaiHopDong = true;
                let params = {
                    // "capHocs": this.danhSachCapHoc,
                    "capHocs": this.danhSachCapHocString,
                    "maDonVis": this.danhSachDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": this.danhSachTruongHoc,
                    "namHoc": this.namHoc
                }
                if (this.thongtin.role == 5) {
                    params.maTruongs = [this.thongtin.ma_truong_hoc];
                    params.maDonVis = [this.thongtin.ma_don_vi];
                    params.capHocs = this.thongtin.listCapHoc
                }

                //check rieng hải phòng năm học 2022
                if (this.thongtin.ma_so == 31) {
                    if (this.namHoc == 2023) {
                        params.namHoc = 2022
                    }
                }
                rest_api.post("/csdlgd-report-api/dasboard/canbogvloaiHD", params, response => {
                    this.loadCanBoGiaoVien.loaiHopDong = false;
                    if (response.data.rc == 0) {
                        let dulieu = response.data.item.listData;
                        let listData = this.ganViTri(dulieu);
                        for (let i = 0; i < listData.length; i++) {
                            listData[i].name = this.getTenCapHoc(listData[i].name);
                        }
                        listData.sort((a, b) => (a.id > b.id) ? 1 : -1)
                        this.duLieuCanBoGiaoVien.loaiHopDong = {
                            category: ['HĐ KXĐ thời hạn', 'HĐ XĐ thời hạn', 'HĐLĐ'],
                            series: listData,
                            height: '400'
                        }
                    } else {
                        this.duLieuCanBoGiaoVien.loaiHopDong = {}
                    }
                });
            },
            getDuLieuCanBoGiaoVienGioiTinh() {
                this.loadCanBoGiaoVien.gioiTinh = true;
                let params = {
                    // "capHocs": this.danhSachCapHoc,
                    "capHocs": this.danhSachCapHocString,
                    "maDonVis": this.danhSachDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": this.danhSachTruongHoc,
                    "namHoc": this.namHoc
                }
                if (this.thongtin.role == 5) {
                    params.maTruongs = [this.thongtin.ma_truong_hoc];
                    params.maDonVis = [this.thongtin.ma_don_vi];
                    params.capHocs = this.thongtin.listCapHoc
                }

                //check rieng hải phòng năm học 2022
                if (this.thongtin.ma_so == 31) {
                    if (this.namHoc == 2023) {
                        params.namHoc = 2022
                    }
                }
                rest_api.post("/csdlgd-report-api/dasboard/canbogvgioitinh", params, response => {
                    this.loadCanBoGiaoVien.gioiTinh = false;
                    if (response.data.rc == 0) {
                        let dulieu = response.data.item.listData;
                        let listData = this.ganViTri(dulieu);
                        for (let i = 0; i < listData.length; i++) {
                            listData[i].name = this.getTenCapHoc(listData[i].name);
                        }
                        listData.sort((a, b) => (a.id > b.id) ? 1 : -1)
                        this.duLieuCanBoGiaoVien.gioiTinh = {
                            category: ['Nam', 'Nữ'],
                            series: listData,
                            height: '400'
                        }
                    } else {
                        this.duLieuCanBoGiaoVien.gioiTinh = {}
                    }
                });
            },
            getDuLieuCanBoGiaoVienTrinhDoChinh() {
                this.loadCanBoGiaoVien.trinhDoChinh = true;
                let params = {
                    // "capHocs": this.danhSachCapHoc,
                    "capHocs": this.danhSachCapHocString,
                    "maDonVis": this.danhSachDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": this.danhSachTruongHoc,
                    "namHoc": this.namHoc
                }
                if (this.thongtin.role == 5) {
                    params.maTruongs = [this.thongtin.ma_truong_hoc];
                    params.maDonVis = [this.thongtin.ma_don_vi];
                    params.capHocs = this.thongtin.listCapHoc
                }
                //check rieng hải phòng năm học 2022
                if (this.thongtin.ma_so == 31) {
                    if (this.namHoc == 2023) {
                        params.namHoc = 2022
                    }
                }
                rest_api.post("/csdlgd-report-api/dasboard/canbogvtrinhdochinh", params, response => {
                    this.loadCanBoGiaoVien.trinhDoChinh = false;
                    if (response.data.rc == 0) {
                        let dulieu = response.data.item.listData;
                        let listData = this.ganViTri(dulieu);
                        for (let i = 0; i < listData.length; i++) {
                            listData[i].name = this.getTenCapHoc(listData[i].name);
                        }
                        listData.sort((a, b) => (a.id > b.id) ? 1 : -1)
                        this.duLieuCanBoGiaoVien.trinhDoChinh = {
                            category: ['Tiến sĩ', 'Thạc sĩ', 'Đại học', 'Cao đẳng', 'Trung cấp'],
                            series: listData,
                            height: '400'
                        }

                    } else {
                        this.duLieuCanBoGiaoVien.trinhDoChinh = {}
                    }
                });
            },
            getDuLieuCanBoGiaoVienTongQuan() {
                this.loadCanBoGiaoVien.tongQuan = true;
                let params = {
                    // "capHocs": this.danhSachCapHoc,
                    "capHocs": this.danhSachCapHocString,
                    "maDonVis": this.danhSachDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": this.danhSachTruongHoc,
                    "namHoc": this.namHoc
                }
                if (this.thongtin.role == 5) {
                    params.maTruongs = [this.thongtin.ma_truong_hoc];
                    params.maDonVis = [this.thongtin.ma_don_vi];
                    params.capHocs = this.thongtin.listCapHoc
                }
                //check rieng hải phòng năm học 2022
                if (this.thongtin.ma_so == 31) {
                    if (this.namHoc == 2023) {
                        params.namHoc = 2022
                    }
                }
                rest_api.post("/csdlgd-report-api/dasboard/canbogvcaphoc", params, response => {
                    this.loadCanBoGiaoVien.tongQuan = false;
                    if (response.data.rc == 0) {
                        this.duLieuCanBoGiaoVien.tongQuan = {
                            category: ['Mầm non', 'Tiểu học', 'THCS', 'THPT', 'GDTX', 'Liên cấp'],
                            series: response.data.item.listValue,
                            totalText: 'CBGVNV',
                        }
                    } else {
                        this.duLieuCanBoGiaoVien.tongQuan = {}
                    }
                });
            },
            getDuLieuTruongHocLoaiHinhDaoTao() {
                this.loadTruongHoc.loaiHinhDaoTao = true;
                let params = {
                    "capHocs": this.danhSachCapHoc,
                    "maDonVis": this.danhSachDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": this.danhSachTruongHoc,
                    "namHoc": this.namHoc
                }
                if (this.thongtin.role == 5) {
                    params.maTruongs = [this.thongtin.ma_truong_hoc];
                    params.maDonVis = [this.thongtin.ma_don_vi];
                    params.capHocs = this.thongtin.listCapHoc
                }
                //check rieng hải phòng năm học 2022
                if (this.thongtin.ma_so == 31) {
                    if (this.namHoc == 2023) {
                        params.namHoc = 2022
                    }
                }
                rest_api.post("/csdlgd-report-api/dasboard/truonghocloaihinhdaotao", params, data => {
                    this.loadTruongHoc.loaiHinhDaoTao = false;
                    if (data.data.rc == 0) {
                        let dulieu = data.data.item.listData;
                        let listData = this.ganViTri(dulieu);
                        for (let i = 0; i < listData.length; i++) {
                            listData[i].name = this.getTenCapHoc(listData[i].name);
                        }
                        listData.sort((a, b) => (a.id > b.id) ? 1 : -1)
                        this.duLieuTruongHoc.loaiHinhDaoTao = {
                            category: ['Công lập', 'Tư thục', 'Dân lập'],
                            series: listData,
                            height: '400'
                        }
                    } else {
                        this.duLieuTruongHoc.loaiHinhDaoTao = {}
                    }
                });
            },
            getDuLieuTruongHocTongQuan() {
                this.loadTruongHoc.tongQuan = true;
                let params = {
                    "capHocs": this.danhSachCapHoc,
                    "maDonVis": this.danhSachDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": this.danhSachTruongHoc,
                    "namHoc": this.namHoc
                }
                if (this.thongtin.role == 5) {
                    params.maTruongs = [this.thongtin.ma_truong_hoc];
                    params.maDonVis = [this.thongtin.ma_don_vi];
                    params.capHocs = this.thongtin.listCapHoc
                }
                //check rieng hải phòng năm học 2022
                if (this.thongtin.ma_so == 31) {
                    if (this.namHoc == 2023) {
                        params.namHoc = 2022
                    }
                }
                rest_api.post("/csdlgd-report-api/dasboard/truongTron", params, response => {
                    this.loadTruongHoc.tongQuan = false;
                    console.log('Có res')
                    console.log(response)
                    if (response.data.rc == 0) {
                        this.duLieuTruongHoc.tongQuan = {
                            category: ['Mầm non', 'Tiểu học', 'THCS', 'THPT', 'GDTX', 'Liên cấp'],
                            series: response.data.item.listValue,
                            totalText: 'Trường',
                        }
                        if (this.thongtin.ma_so == 10) {
                            this.duLieuTruongHoc.tongQuan.category = ['Mầm non', 'Tiểu học', 'THCS', 'THPT',
                                'GDTX', 'Liên Cấp 1-2', 'Liên cấp 2-3', 'Khác'
                            ]
                        }
                    } else {
                        this.duLieuTruongHoc.tongQuan = {}
                    }
                });
            },
            getDuLieuTruongHocChatLuongDaoTao() {
                this.loadTruongHoc.chatLuongDaoTao = true;
                let params = {
                    "capHocs": this.danhSachCapHoc,
                    "maDonVis": this.danhSachDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": this.danhSachTruongHoc,
                    "namHoc": this.namHoc
                }
                if (this.thongtin.role == 5) {
                    params.maTruongs = [this.thongtin.ma_truong_hoc];
                    params.maDonVis = [this.thongtin.ma_don_vi];
                    params.capHocs = this.thongtin.listCapHoc
                }
                //check rieng hải phòng năm học 2022
                if (this.thongtin.ma_so == 31) {
                    if (this.namHoc == 2023) {
                        params.namHoc = 2022
                    }
                }
                rest_api.post("/csdlgd-report-api/dasboard/truonghocchatluong", params, data => {
                    this.loadTruongHoc.chatLuongDaoTao = false;
                    if (data.data.rc == 0) {
                        let dulieu = data.data.item.listData;
                        let listData = this.ganViTri(dulieu);
                        for (let i = 0; i < listData.length; i++) {
                            listData[i].name = this.getTenCapHoc(listData[i].name);
                        }
                        listData.sort((a, b) => (a.id > b.id) ? 1 : -1)
                        this.duLieuTruongHoc.chatLuongDaoTao = {
                            category: ['C.Lượng tối thiểu', 'Chuẩn mức 1', 'Chuẩn mức 2'],
                            series: listData,
                            height: '400'
                        }
                    } else {
                        this.duLieuTruongHoc.chatLuongDaoTao = {}
                    }
                });
            },
            getTenLoaiCanBo(e) {
                var res = e;
                switch (res) {
                    case 'NV':
                        res = 'Nhân viên';
                        break;
                    case 'QL':
                        res = 'Cán bộ quản lý';
                        break;
                    case 'GV':
                        res = 'Giáo viên';
                        break;
                    default:
                        res = e;
                }
                return res;
            },
            getTenCapHoc(e) {
                var res = e;
                switch (res) {
                    case 'MN':
                        res = 'Mầm non';
                        break;
                    case 'TH':
                        res = 'Tiểu học';
                        break;
                    case 'THCS':
                        res = 'THCS';
                        break;
                    case 'THPT':
                        res = 'THPT';
                        break;
                    case 'GDTX':
                        res = 'GDTX';
                        break;
                    case 'LC':
                        res = 'Liên cấp';
                        break;
                    case 'PTCS':
                        res = 'PTCS';
                        break
                    case 'TRUNGHOC':
                        res = 'Trung học';
                        break;
                    case 'LC145':
                        res = 'MN-TH';
                        break;
                    case 'LC12':
                        res = 'Liên cấp 1-2';
                        break
                    case 'LC23':
                        res = 'Liên cấp 2-3';
                        break;
                    case 'LCK':
                        res = 'Khác';
                        break;
                    default:
                        res = e;
                }
                return res;
            },
            layDuLieuHocSinh() {
                this.loadDuLieuHocSinh = true;
                let params = {
                    "capHocs": this.danhSachCapHoc,
                    "maDonVis": this.danhSachDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": this.danhSachTruongHoc,
                    "type": 1,
                    "namHoc": this.namHoc
                }
                if (this.thongtin.role == 5) {
                    params.maTruongs = [this.thongtin.ma_truong_hoc];
                    params.maDonVis = [this.thongtin.ma_don_vi];
                    params.capHocs = this.thongtin.listCapHoc
                }

                //check rieng hải phòng năm học 2022

                if (this.thongtin.ma_so == 31) {

                    if (this.namHoc == 2023) {
                        params.namHoc = 2022
                    }
                }

                rest_api.post("/csdlgd-report-api/dasboard/thongketanggiam", params, data => {
                    this.loadDuLieuHocSinh = false;
                    if (data.data.rc == 0) {
                        this.duLieuTangGiamHocSinh = data.data.item;
                    } else {
                        this.duLieuTangGiamHocSinh = {}
                    }
                });
            },
            layDuLieuGiaoVien() {
                this.loadDuLieuGiaoVien = true;
                let params = {
                    "capHocs": this.danhSachCapHoc,
                    "maDonVis": this.danhSachDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": this.danhSachTruongHoc,
                    "type": 2,
                    "namHoc": this.namHoc
                }
                if (this.thongtin.role == 5) {
                    params.maTruongs = [this.thongtin.ma_truong_hoc];
                    params.maDonVis = [this.thongtin.ma_don_vi];
                    params.capHocs = this.thongtin.listCapHoc
                }
                //check rieng hải phòng năm học 2022
                if (this.thongtin.ma_so == 31) {
                    if (this.namHoc == 2023) {
                        params.namHoc = 2022
                    }
                }
                rest_api.post("/csdlgd-report-api/dasboard/thongketanggiam", params, data => {
                    this.loadDuLieuGiaoVien = false;
                    if (data.data.rc == 0) {
                        this.duLieuTangGiamGiaoVien = data.data.item;
                    } else {
                        this.duLieuTangGiamGiaoVien = {}
                    }
                });
            },
            layDuLieuTruongHoc() {
                this.loadDuLieuTruongHoc = true;
                let params = {
                    "capHocs": this.danhSachCapHoc,
                    "maDonVis": this.danhSachDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": this.danhSachTruongHoc,
                    "type": 3,
                    "namHoc": this.namHoc
                }
                if (this.thongtin.role == 5) {
                    params.maTruongs = [this.thongtin.ma_truong_hoc];
                    params.maDonVis = [this.thongtin.ma_don_vi];
                    params.capHocs = this.thongtin.listCapHoc
                }

                //check rieng hải phòng năm học 2022
                if (this.thongtin.ma_so == 31) {
                    if (this.namHoc == 2023) {
                        params.namHoc = 2022
                    }
                }


                rest_api.post("/csdlgd-report-api/dasboard/thongketanggiam", params, data => {
                    this.loadDuLieuTruongHoc = false;
                    if (data.data.rc == 0) {
                        this.duLieuTangGiamTruongHoc = data.data.item;
                    } else {
                        this.duLieuTangGiamTruongHoc = {}
                    }
                });
            },
        },
    }

</script>
<style scoped="scoped">
    h5 {
        font-size: 20px !important;
        margin: 0;
    }

    #page-wrapper {
        background: red;
    }

    .el-row {
        margin: 0 !important;
    }

    .el-col {
        border-radius: 4px;
        padding-top: 10px;
        padding-bottom: 10px;
    }

    .bg-purple-dark {
        background: #99a9bf;
    }

    .bg-purple {
        background: #d3dce6;
    }

    .bg-purple-light {
        /* background: #e5e9f2; */
        height: 100px;
    }

    .grid-content {
        border-radius: 4px;
        min-height: 36px;
        display: contents;
    }

    .row-bg {
        padding: 10px 0;
        background-color: #f9fafc;
    }

    /* css custom */
    .dts-card-header {
        background: #f2f3f8;
        height: 25px;
        color: black;
        padding: 5px;
        border-top-right-radius: 10px;
        border-top-left-radius: 10px;
    }

    .dts-card-title {
        color: #070707;
        padding-left: 10px;

        font-weight: bold;
    }

    .dts-card-body {
        padding: 5px;
        background: white;
        height: 300px;
        position: relative;
        border-bottom-right-radius: 10px !important;
        border-bottom-left-radius: 10px !important;
        border: #f2f3f8 2px solid;
    }

    .dts-card-body-ct {
        padding: 5px;
        background: white;
        height: 350px;
        position: relative;
        border-bottom-right-radius: 10px !important;
        border-bottom-left-radius: 10px !important;
        border: #f2f3f8 2px solid;
    }

    .tuychongiaodien {
        border: 1px solid;
        position: absolute;
        right: 0;
        width: 100%;
        background: navajowhite;
        z-index: 2;
    }

    .dts-right {
        float: right;
        padding: 0 5px;
    }

    .dts-right a {

    }

    .card-bieu-do {
        /* border: 1px solid #088A4B; */
        margin: 15px 0;
        background: white;
        border-radius: 10px;

    }

    .card-bieu-do h5 {
        font-size: 20px;
        padding-left: 0px;
        color: black;
        font-weight: 700
    }

    .dts-moibieudo {
        display: contents;
        border: 1px solid blue;
    }

    .amount {
        font-size: 26px;
        color: deeppink;
        font-weight: 600;
    }

    .soluongtanggiam {
        font-size: 24px !important;
    }

    .anhtanggiam {
        margin-top: -10px;
    }

    .list-enter,
    .list-leave-to {
        visibility: hidden;
        height: 0;
        margin: 0;
        padding: 0;
        opacity: 0;
    }

    .list-enter-active,
    .list-leave-active {
        transition: all 0.3s;
    }

    .card-tuychon {
        padding: 10px;
    }

    .dts-truot {
        padding: 3px 0
    }

    .thongketangiamsl {
        background: #044e93;
        border-radius: 10px;
        padding: 12px;
        color: white;
        font-size: 18px !important;
    }

    .thongketangiamsl p {
        font-size: 16px !important;
    }

    .el-loading-mask {

        border-bottom-right-radius: 10px !important;
        border-bottom-left-radius: 10px !important;
    }



    .el-button {
        width: 100% !important;
        font-size: 14px !important;
    }

    .layout-card {
        height: 120px;

        color: #000000;
        border-radius: 20px;
        padding: 0px 10px 0px 10px;
        font-size: 20px !important;
        display: flex;
        align-items: center;
        line-height: 1
    }

    .content-card {
        gap: 0px;
        flex-direction: column;
        display: flex;
        margin-left: 20px;
        width: 100%;
    }

    .content-item {
        display: flex;
        justify-content: space-between;
    }

    .layout-card .name {
        font-size: 24px;
        font-weight: 600;
    }

    .layout-card .number {
        font-weight: 600;
        margin-top: -5px;
        letter-spacing: 1;
        font-size: 36px;
    }

    .layout-card .number-school {
        color: #044E93;
    }

    .layout-card .number-teacher {
        color: #5156CF;
    }

    .layout-card .number-student {
        color: #01856B;
    }

    .layout-card .tracker {
        font-size: 16px;
        display: flex;
        align-items: center;
    }

    .layout-card .img-tracker {
        margin-right: 8px;
        width: 25px;

    }

    .transform {
        transform: rotate(180deg);
    }

    @media screen and (max-width: 768px) {
        .mobi {
            margin: 75px 12px 0;
        }
    }

    h5 i {
        color: #01856B !important;
        padding-right: 6px;
        display: none;
    }

    h5 {
        color: black;
        font-size: 20px
    }

</style>
