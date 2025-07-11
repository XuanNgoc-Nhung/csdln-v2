<template>
    <div  v-loading="loadingMap" element-loading-background="rgba(0, 0, 0, 0.8)">

        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="ioc/logoThaiNguyen.png" alt="Logo IOC" height="60" width="60">
        </div>
        <nav class="main-header navbar navbar-expand">
            <el-row :gutter="10" style="width:100%">
                <el-col :span="2">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                                    class="fas fa-bars"></i></a>
                        </li>
                        <li class="nav-item">
                            <div style="padding-top:8px;padding-left:10px">
                                <input type="checkbox" v-model="darkMode" class="checkbox" id="checkbox">
                                <label for="checkbox" class="label">
                                    <i class="fas fa-moon"></i>
                                    <i class='fas fa-sun'></i>
                                    <div class='ball'></div>
                                </label>
                            </div>
                        </li>
                    </ul>
                </el-col>
                <el-col :span="22">
                    <el-row :gutter="24">
                        <el-col :span="11">
                            <eselect style="width:100%" multiple collapseTags v-model="maDonVi"
                                :placeholder="'Chọn'" filterable :data="list_don_vi"
                                :fields="['name','value']" />
                        </el-col>
                        <el-col :span="6">
                            <eselect style="width:100%" multiple collapseTags v-model="capHoc"
                                :placeholder="'Chọn'" filterable :data="list_cap_hoc" :fields="['name','id']" />
                        </el-col>
                        <el-col :span="4">
                            <eselect style="width:100%" collapseTags v-model="namHoc" :placeholder="'Chọn năm học'"
                                filterable :data="list_nam_hoc" :fields="['name','id']" />
                        </el-col>
                        <el-col :span="2">
                            <el-button size="mini" @click.prevent="layToanBoDuLieu" type="success">Thống kê</el-button>
                        </el-col>
                        <el-col :span="1" class="action-header">
                            <div class="nav-item action-buttom">
                                <span style="color:blue" class="" data-widget="fullscreen" role="button">
                                    <i class="fas fa-expand-arrows-alt"></i>
                                </span>
                            </div>
                            <!-- <div class="nav-item action-buttom">
                                <a class="" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                                    <i class="fas fa-th-large"></i>
                                </a>
                            </div> -->
                        </el-col>
                    </el-row>
                </el-col>
            </el-row>
        </nav>
        <aside class="main-sidebar elevation-4">
            <a href="dashboard" class="brand-link" target="_blank" title="Xem trang CSDL">
                <img src="ioc/logoThaiNguyen.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">CSDL Ngành</span>
            </a>
            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="ioc/teach.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <!-- <a href="#" class="d-block">{{thongtin.display_name}}</a> -->
                        <span class="d-block">{{thongtin.display_name}}</span>
                    </div>
                </div>
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="ioc_dashboard_map" class="nav-link" @click.prevent="chonHienThi('banDo')"
                                :class="{'active':viewActive=='banDo'}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                                    <path
                                        d="M12,6a1,1,0,0,0-1,1V17a1,1,0,0,0,2,0V7A1,1,0,0,0,12,6ZM7,12a1,1,0,0,0-1,1v4a1,1,0,0,0,2,0V13A1,1,0,0,0,7,12Zm10-2a1,1,0,0,0-1,1v6a1,1,0,0,0,2,0V11A1,1,0,0,0,17,10Zm2-8H5A3,3,0,0,0,2,5V19a3,3,0,0,0,3,3H19a3,3,0,0,0,3-3V5A3,3,0,0,0,19,2Zm1,17a1,1,0,0,1-1,1H5a1,1,0,0,1-1-1V5A1,1,0,0,1,5,4H19a1,1,0,0,1,1,1Z" />
                                </svg>
                                <p>
                                    Bản đồ
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="ioc_chart_school" class="nav-link " @click.prevent="chonHienThi('truongHoc')"
                                :class="{'active':viewActive=='truongHoc'}">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 490 490"
                                    style="enable-background:new 0 0 490 490;" xml:space="preserve">
                                    <path
                                        d="M347.732,108.397h-87.419V0h-30.625v0.046l-53.318,31.927l53.318,31.927v44.498h-87.419v166.585H0V490h490V274.982H347.732  V108.397z M172.893,139.022h144.213v135.96H172.893V139.022z M459.375,459.375H30.625V305.607h428.75V459.375z" />
                                    <rect x="69.871" y="335.114" width="31.268" height="30.625" />
                                    <rect x="69.871" y="399.886" width="31.268" height="30.625" />
                                    <rect x="133.663" y="398.6" width="31.268" height="30.625" />
                                    <rect x="133.035" y="335.114" width="31.268" height="30.625" />
                                    <rect x="196.827" y="334.486" width="31.268" height="30.625" />
                                    <rect x="196.827" y="399.243" width="31.268" height="30.625" />
                                    <rect x="260.634" y="399.243" width="31.268" height="30.625" />
                                    <rect x="260.634" y="335.114" width="31.268" height="30.625" />
                                    <rect x="388.876" y="335.114" width="31.268" height="30.625" />
                                    <rect x="325.069" y="398.6" width="31.268" height="30.625" />
                                    <rect x="388.876" y="399.243" width="31.268" height="30.625" />
                                    <rect x="325.069" y="334.486" width="31.268" height="30.625" />
                                    <rect x="203.534" y="165.36" width="31.268" height="30.625" />
                                    <rect x="203.534" y="218.31" width="31.268" height="30.625" />
                                    <rect x="254.57" y="217.682" width="31.268" height="30.625" />
                                    <rect x="255.213" y="165.36" width="31.268" height="30.625" />
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                </svg>
                                <p>
                                    Trường học
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="ioc_chart_teacher" class="nav-link" @click.prevent="chonHienThi('canBoGiaoVien')"
                                :class="{'active':viewActive=='canBoGiaoVien'}">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 489.38 489.38"
                                    style="enable-background:new 0 0 489.38 489.38;" xml:space="preserve">
                                    <g id="XMLID_129_">
                                        <path id="XMLID_134_"
                                            d="M473.725,5.656H213.576c-8.655,0-15.655,7.022-15.655,15.664v110.484l11.319-13.234   c5.375-6.292,12.461-10.172,19.992-11.793V36.978h228.836v204.531H229.233v-34.238l-7.05,8.244   c-6.161,7.189-14.858,11.65-24.262,12.529v29.124c0,8.642,7,15.655,15.655,15.655h84.489L255.141,467.7   c-1.923,8.739,3.6,17.382,12.346,19.31c8.667,1.904,17.382-3.601,19.287-12.331l44.457-201.855h25.844l44.457,201.855   c1.666,7.557,8.369,12.714,15.803,12.705c1.154,0,2.334-0.117,3.502-0.374c8.746-1.928,14.268-10.57,12.328-19.31l-42.92-194.877   h83.481c8.647,0,15.655-7.013,15.655-15.655V21.32C489.38,12.678,482.372,5.656,473.725,5.656z" />
                                        <path id="XMLID_132_"
                                            d="M349.368,97.116c-1.234-3.11-4.732-4.637-7.84-3.406l-92.234,32.555   c-8.465-6.554-20.678-5.383-27.737,2.827l-29.267,34.178l-25.951-22.245c0.171,1.837,0.56,3.622,0.56,5.507v48.291l14.438,12.371   c8.568,7.338,21.385,6.204,28.549-2.198l34.842-40.743l28.1-16.439l73.951-43.267C349.336,103.073,350.469,99.923,349.368,97.116z" />
                                        <path id="XMLID_131_"
                                            d="M109.928,105.776H92.547c-13.308,0-25.01,6.468-32.448,16.327l-53.352,49.12   c-8.313,7.405-9.067,20.232-1.581,28.595l43.528,48.585c7.421,8.309,20.267,9.044,28.579,1.576   c8.334-7.469,9.038-20.262,1.57-28.586l-30.003-33.504l42.616-38.134l-24.82,33.721l24.279,27.107   c13.416,14.992,12.151,38.027-2.834,51.453c-10.231,9.172-24.193,11.324-36.297,7.094c0,0,0.188,93.659,0.188,193.962   c0,13.416,10.874,24.291,24.291,24.291c13.403,0,24.291-10.875,24.291-24.291c0-100.272,0-43.051,0-144.771h16.203   c0,101.646,0,44.468,0,144.771c0,7.004-1.953,13.49-5.067,19.231c4.076,3.135,9.148,5.06,14.676,5.06   c13.424,0,24.298-10.875,24.298-24.291c0-100.272,0.031-58.237,0.031-316.561C150.697,124.022,132.45,105.776,109.928,105.776z" />
                                        <path id="XMLID_130_"
                                            d="M79.592,91.198c6.495,3.376,13.787,5.471,21.62,5.471c7.853,0,15.145-2.095,21.659-5.477   c15.204-7.877,25.684-23.559,25.684-41.862c0-26.146-21.196-47.335-47.344-47.335c-26.144,0-47.335,21.189-47.335,47.335   C53.877,67.643,64.368,83.331,79.592,91.198z" />
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                </svg>
                                <p>
                                    Cán bộ,giáo viên
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="ioc_chart_student" class="nav-link" @click.prevent="chonHienThi('hocSinh')"
                                :class="{'active':viewActive=='hocSinh'}">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 512.001 512.001"
                                    style="enable-background:new 0 0 512.001 512.001;" xml:space="preserve">
                                    <g>
                                        <g>
                                            <path
                                                d="M241.515,198.01c-0.863,0.24-1.73,0.453-2.597,0.638l-28.358,5.898l9.569,48.681h32.241L241.515,198.01z" />
                                        </g>
                                    </g>
                                    <g>
                                        <g>
                                            <path
                                                d="M501.455,233.915c-11.056,0-60.756,0-68.693,0c2.065-2.63,3.447-5.799,3.912-9.236    c2.166-16.001,12.206-90.155,13.609-100.518c1.417-10.458-5.914-20.083-16.371-21.5c-1.966-0.266-3.904-0.221-5.763,0.093    c1.584-2.815,2.877-5.852,3.806-9.093c6.416-22.393-6.536-45.746-28.929-52.161c-22.392-6.416-45.746,6.536-52.161,28.929    c-6.416,22.392,6.537,45.746,28.929,52.161c11.451,3.281,23.147,1.487,32.707-4.034c-0.026,0.161-0.068,0.315-0.089,0.478    c-0.883,6.527-7.686,56.764-8.781,64.853l-38.178-34.109l25.927,14.374c0.51-12.82-7.74-24.808-20.622-28.499    c-19.651-5.63-40.76-2.8-58.233,7.808c-17.474,10.608-29.724,28.03-33.797,48.061c-13.173,64.797-12.166,59.71-12.48,61.705    h46.208c15.374,0,27.775,12.496,27.775,27.775c0,15.339-12.435,27.775-27.775,27.775c-15.857,0-28.711,0-42.123,0    c4.977,10.637,5.398,22.304,1.982,32.697h66.818l19.054,49.406l-8.276,20.912c-4.659,11.775,1.109,25.099,12.885,29.759    c11.765,4.658,25.097-1.102,29.759-12.884l52.052-131.539c6-15.166-5.312-31.423-21.389-31.367    c-12.46,0.037-47.988,0.14-60.15,0.176l11.514-40.19l-27.345-40.993l55.025,49.162H391.41c-5.857,0-10.545,4.795-10.545,10.545    c0,5.824,4.722,10.545,10.545,10.545c16.789,0,99.105,0,110.045,0c5.824,0,10.545-4.722,10.545-10.545    S507.279,233.915,501.455,233.915z M377.024,325.655c0-5.984-3.324-11.189-8.225-13.876l20.713-0.06l-19.878,50.232l-7.908-20.504    C370.219,341.17,377.024,334.215,377.024,325.655z" />
                                        </g>
                                    </g>
                                    <g>
                                        <g>
                                            <path
                                                d="M240.638,164.864c2.124-13.688,16.694-107.59,18.619-119.993c1.705-10.988-5.82-21.275-16.807-22.981    c-10.978-1.703-21.276,5.819-22.981,16.807c-1.99,12.822-15.323,98.751-17.054,109.905L133.62,184.27l17.438-15.013l-39.469-0.282    c-18.747-0.134-34.006,15.068-33.955,33.805c0.039,14.341,0.282,103.131,0.313,114.342c0.042,15.597,10.803,29.233,26.178,32.76    c-23.664,0-18.588,0-42.375,0L33.019,203.718c-1.775-9.031-10.539-14.912-19.565-13.137c-9.031,1.775-14.913,10.535-13.137,19.565    L31.691,369.76c1.501,7.634,8.076,13.173,15.803,13.426l-32.036,83.067c-2.208,5.725,0.643,12.155,6.368,14.363    c5.723,2.209,12.155-0.642,14.363-6.368l35.11-91.037h70.142c4.147,10.754,15.637,40.545,20.074,52.053l-8.719,22.033    c-4.909,12.406,1.168,26.444,13.574,31.353c12.411,4.909,26.445-1.172,31.353-13.574l54.84-138.585    c6.245-15.784-5.337-33.047-22.534-33.047l-55.539,0.162c0.219-13.901,1.283-81.518,1.447-91.858l-13.086,2.722l67.16-34.819    C235.707,176.697,239.655,171.204,240.638,164.864z M172.695,351.928l21.822-0.063l-20.942,52.923l-8.331-21.603    c8.948-0.292,16.116-7.619,16.116-16.637C181.359,360.243,177.858,354.76,172.695,351.928z" />
                                        </g>
                                    </g>
                                    <g>
                                        <g>
                                            <path
                                                d="M312.456,269.891h-115.94c-6.136,0-11.11,4.974-11.11,11.11c0,6.089,4.935,11.11,11.11,11.11c23.732,0,92.698,0,115.94,0    c6.136,0,11.11-4.974,11.11-11.11C323.566,274.864,318.592,269.891,312.456,269.891z" />
                                        </g>
                                    </g>
                                    <g>
                                        <g>
                                            <path
                                                d="M160.012,65.418c-24.259-3.705-46.93,12.957-50.635,37.217c-3.705,24.259,12.956,46.929,37.217,50.635    c24.279,3.708,46.94-13.023,50.635-37.217C200.934,91.794,184.271,69.123,160.012,65.418z" />
                                        </g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                </svg>
                                <p>
                                    Học sinh
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="ioc_chart_student" class="nav-link" @click.prevent="chonHienThi('ketQuaHocTap')"
                                :class="{'active':viewActive=='ketQuaHocTap'}">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 368.554 368.554"
                                    style="enable-background:new 0 0 368.554 368.554;" xml:space="preserve">
                                    <g>
                                        <path
                                            d="M292.371,17.347h-44.344V0h-127.5v17.347H76.183c-20.005,0-36.281,16.275-36.281,36.281v278.646   c0,20.005,16.275,36.281,36.281,36.281h216.188c20.005,0,36.281-16.275,36.281-36.281V53.627   C328.652,33.622,312.376,17.347,292.371,17.347z M135.527,15h97.5v19.693h-97.5V15z M313.652,332.273   c0,11.734-9.546,21.281-21.281,21.281H76.183c-11.734,0-21.281-9.546-21.281-21.281V53.627c0-11.734,9.546-21.281,21.281-21.281   h44.344v17.347h127.5V32.347h44.344c11.734,0,21.281,9.546,21.281,21.281V332.273z" />
                                        <path
                                            d="M249.473,169.358l-7.8,11.849c-1.11,1.686-2.794,1.882-3.467,1.888c-0.691,0.001-2.36-0.161-3.5-1.826l-0.217-0.317   c-3.948-5.77-10.465-8.865-17.431-8.29c-6.967,0.579-12.883,4.711-15.824,11.053l-4.166,8.982   c-1.124,2.426-3.309,2.496-4.194,2.412c-0.887-0.083-3.02-0.555-3.677-3.146l-9.067-35.742c-2.199-8.67-9.665-14.475-18.598-14.475   c-0.036,0-0.071,0-0.107,0c-8.98,0.046-16.437,5.941-18.554,14.668l-8.178,33.702c-0.642,2.646-2.813,3.112-3.716,3.19   c-0.901,0.076-3.122-0.009-4.208-2.507l-8.062-18.541c-3.048-7.012-9.958-11.542-17.603-11.542H79.485v15h21.619   c1.671,0,3.181,0.99,3.847,2.523l8.062,18.541c3.343,7.688,10.895,12.188,19.253,11.47c8.353-0.721,15.027-6.451,17.003-14.598   l8.178-33.702c0.698-2.878,3.068-3.201,4.055-3.206c1.025,0.004,3.36,0.293,4.088,3.164l9.066,35.742   c2.024,7.979,8.628,13.629,16.825,14.393c0.624,0.059,1.243,0.087,1.857,0.087c7.461,0,14.138-4.223,17.337-11.123l4.166-8.982   c0.927-1.998,2.727-2.354,3.458-2.416c0.728-0.056,2.565-0.006,3.809,1.812l0.217,0.317c3.586,5.241,9.498,8.356,15.84,8.355   c0.058,0,0.116,0,0.173,0c6.408-0.057,12.338-3.287,15.861-8.64l7.801-11.849c0.778-1.182,2.088-1.888,3.503-1.888h23.563v-15   h-23.563C259.028,160.718,253.034,163.948,249.473,169.358z" />
                                        <rect x="79.485" y="271.777" width="84.688" height="15" />
                                        <rect x="79.485" y="308.443" width="169.375" height="15" />
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                </svg>
                                <p>
                                    Kết quả học tập
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="logout" class="nav-link">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 490.3 490.3"
                                    style="enable-background:new 0 0 490.3 490.3;" xml:space="preserve">
                                    <g>
                                        <g>
                                            <path
                                                d="M0,121.05v248.2c0,34.2,27.9,62.1,62.1,62.1h200.6c34.2,0,62.1-27.9,62.1-62.1v-40.2c0-6.8-5.5-12.3-12.3-12.3    s-12.3,5.5-12.3,12.3v40.2c0,20.7-16.9,37.6-37.6,37.6H62.1c-20.7,0-37.6-16.9-37.6-37.6v-248.2c0-20.7,16.9-37.6,37.6-37.6h200.6    c20.7,0,37.6,16.9,37.6,37.6v40.2c0,6.8,5.5,12.3,12.3,12.3s12.3-5.5,12.3-12.3v-40.2c0-34.2-27.9-62.1-62.1-62.1H62.1    C27.9,58.95,0,86.75,0,121.05z" />
                                            <path
                                                d="M385.4,337.65c2.4,2.4,5.5,3.6,8.7,3.6s6.3-1.2,8.7-3.6l83.9-83.9c4.8-4.8,4.8-12.5,0-17.3l-83.9-83.9    c-4.8-4.8-12.5-4.8-17.3,0s-4.8,12.5,0,17.3l63,63H218.6c-6.8,0-12.3,5.5-12.3,12.3c0,6.8,5.5,12.3,12.3,12.3h229.8l-63,63    C380.6,325.15,380.6,332.95,385.4,337.65z" />
                                        </g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                </svg>
                                <p>
                                    Đăng xuất
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <div class="content-wrapper">
            <div class="content-header">
                <section class="content">
                    <div class="container-fluid">
                        <div v-if="viewActive=='banDo'">
                            <div class='hienThiBanDo'>
                                <div>
                                    <banDo :darkMode="darkMode" :item="dataMap"></banDo>
                                    <thongKeCoBan :item="thongTinThongKeCoBan"></thongKeCoBan>
                                </div>
                            </div>
                        </div>
                        <div v-if="viewActive=='truongHoc'">
                            <el-row :gutter="20" class="card-bieu-do">
                                <el-col :span="22">
                                    <h5> <i class="fas fa-school"></i> Biểu đồ trường học</h5>
                                </el-col>
                                <!-- <el-col :span="2" class="text-right">
                                    <el-button plain type="success" size="mini">Chi tiết
                                    </el-button>
                                </el-col> -->
                                <el-col :md="24" :lg="6">
                                    <div class="dts-moibieudo grid-content bg-purple-light">
                                        <div class="dts-card-header">
                                            <span class="dts-card-title">Tổng quan</span>
                                            <span class="dts-right"><a href="#"
                                                    @click.prevent="layBieuDoTongQuanTruongHoc"
                                                    title="Lấy lại dữ liệu thống kê"><i
                                                        class="fa-solid fa-rotate-right"></i></a>
                                            </span>
                                        </div>
                                        <div class="dts-card-body">
                                            <div v-loading="loading.tongQuanTruongHoc"
                                                element-loading-background="rgba(0, 0, 0, 0.8)">
                                                <BieuDoHinhTron :label="label.truongHoc.tongQuan"
                                                    :dulieu="duLieuTongQuanTruongHoc">
                                                </BieuDoHinhTron>
                                            </div>
                                        </div>
                                    </div>
                                </el-col>
                                <el-col :span="24" style="height:15px"></el-col>
                                <el-col :md="12" :lg="12">
                                    <div class="dts-moibieudo grid-content bg-purple-light">
                                        <div class="dts-card-header">
                                            <span class="dts-card-title">Chất lượng đào tạo</span>
                                            <span class="dts-right"><a href="#"
                                                    @click.prevent="layBieuDoTruongHocTheoChatLuongDaoTao"
                                                    title="Lấy lại dữ liệu thống kê"><i
                                                        class="fa-solid fa-rotate-right"></i></a>
                                            </span>
                                        </div>
                                        <div class="dts-card-body">
                                            <div v-loading="loading.chatLuongDaoTaoTruongHoc"
                                                element-loading-background="rgba(0, 0, 0, 0.8)">
                                                <BieuDoCotChong :label="label.truongHoc.chatLuongDaoTao"
                                                    :dulieu="duLieuTruongHocTheoChatLuongDaoTao">
                                                </BieuDoCotChong>
                                            </div>
                                        </div>
                                    </div>
                                </el-col>
                                <el-col :md="12" :lg="12">
                                    <div class="dts-moibieudo grid-content bg-purple-light">
                                        <div class="dts-card-header">
                                            <span class="dts-card-title">Loại hình đào tạo</span>
                                            <span class="dts-right"><a href="#"
                                                    @click.prevent="layBieuDoTruongHocTheoLoaiHinhDaoTao"
                                                    title="Lấy lại dữ liệu thống kê"><i
                                                        class="fa-solid fa-rotate-right"></i></a>
                                            </span>
                                        </div>
                                        <div class="dts-card-body">
                                            <div v-loading="loading.loaiHinhDaoTaoTruongHoc"
                                                element-loading-background="rgba(0, 0, 0, 0.8)">
                                                <BieuDoCotChong :label="label.truongHoc.loaiHinhDaoTao"
                                                    :dulieu="duLieuTruongHocTheoLoaiHinhDaoTao">
                                                </BieuDoCotChong>
                                            </div>
                                        </div>
                                    </div>
                                </el-col>
                            </el-row>
                        </div>
                        <div v-if="viewActive=='canBoGiaoVien'">
                            <el-row :gutter="20" class="card-bieu-do">
                                <el-col :span="22">
                                    <h5><i class="fas fa-chalkboard-teacher"></i> Biểu đồ Cán bộ - Giáo viên</h5>
                                </el-col>
                                <!-- <el-col :span="2" class="text-right">
                                    <el-button plain type="success" size="mini">Chi tiết
                                    </el-button>
                                </el-col> -->
                                <el-col :md="24" :lg="6">
                                    <div class="dts-moibieudo grid-content bg-purple-light">
                                        <div class="dts-card-header">
                                            <span class="dts-card-title">Tổng quan</span>
                                            <span class="dts-right"><a href="#"
                                                    @click.prevent="layBieuDoTongQuanCanBoGiaoVien"
                                                    title="Lấy lại dữ liệu thống kê"><i
                                                        class="fa-solid fa-rotate-right"></i></a>
                                            </span>
                                        </div>
                                        <div class="dts-card-body">
                                            <div v-loading="loading.tongQuanCanBoGiaoVien"
                                                element-loading-background="rgba(0, 0, 0, 0.8)">
                                                <BieuDoHinhTron :label="label.canBo.tongQuan"
                                                    :dulieu="duLieuTongQuanCanBoGiaoVien">
                                                </BieuDoHinhTron>
                                            </div>
                                        </div>
                                    </div>
                                </el-col>
                                <el-col :md="24" :lg="6">
                                    <div class="dts-moibieudo grid-content bg-purple-light">
                                        <div class="dts-card-header">
                                            <span class="dts-card-title">Giới tính</span>
                                            <span class="dts-right"><a href="#"
                                                    @click.prevent="layBieuDoGioiTinhCanBoGiaoVien"
                                                    title="Lấy lại dữ liệu thống kê"><i
                                                        class="fa-solid fa-rotate-right"></i></a>
                                            </span>
                                        </div>
                                        <div class="dts-card-body">
                                            <div v-loading="loading.gioiTinhCanBoGiaoVien"
                                                element-loading-background="rgba(0, 0, 0, 0.8)">
                                                <BieuDoHinhTron :label="label.canBo.gioiTinh"
                                                    :dulieu="duLieuGioiTinhCanBoGiaoVien">
                                                </BieuDoHinhTron>
                                            </div>
                                        </div>
                                    </div>
                                </el-col>
                                <el-col :span="24" style="height:15px"></el-col>
                                <el-col :md="12" :lg="12">
                                    <div class="dts-moibieudo grid-content bg-purple-light">
                                        <div class="dts-card-header">
                                            <span class="dts-card-title">Trình độ chính</span>
                                            <span class="dts-right"><a href="#"
                                                    @click.prevent="layBieuDoCanBoGiaoVienTheoTrinhDoChinh"
                                                    title="Lấy lại dữ liệu thống kê"><i
                                                        class="fa-solid fa-rotate-right"></i></a>
                                            </span>
                                        </div>
                                        <div class="dts-card-body">
                                            <div v-loading="loading.trinhDoChinhCanBoGiaoVien"
                                                element-loading-background="rgba(0, 0, 0, 0.8)">
                                                <BieuDoCotChong :label="label.canBo.trinhDoChinh"
                                                    :dulieu="duLieuTrinhDoChinhCanBoGiaoVien">
                                                </BieuDoCotChong>
                                            </div>
                                        </div>
                                    </div>
                                </el-col>
                                <!-- Loại hợp đồng -->
                                <el-col :md="12" :lg="12">
                                    <div class="dts-moibieudo grid-content bg-purple-light">
                                        <div class="dts-card-header">
                                            <span class="dts-card-title">Loại hợp đồng</span>
                                            <span class="dts-right"><a href="#"
                                                    @click.prevent="layBieuDoCanBoGiaoVienTheoLoaiHopDong"
                                                    title="Lấy lại dữ liệu thống kê"><i
                                                        class="fa-solid fa-rotate-right"></i></a>
                                            </span>
                                        </div>
                                        <div class="dts-card-body">
                                            <div v-loading="loading.loaiHopDongCanBoGiaoVien"
                                                element-loading-background="rgba(0, 0, 0, 0.8)">
                                                <BieuDoCotChong :label="label.canBo.loaiHopDong"
                                                    :dulieu="duLieuLoaiHopDongCanBoGiaoVien">
                                                </BieuDoCotChong>
                                            </div>
                                        </div>
                                    </div>
                                </el-col>
                            </el-row>
                        </div>
                        <div v-if="viewActive=='hocSinh'">
                            <el-row :gutter="20" class="card-bieu-do">
                                <el-col :span="22">
                                    <h5> <i class="fas fa-user-graduate"></i> Biểu đồ Học sinh</h5>
                                </el-col>
                                <!-- <el-col :span="2" class="text-right">
                                    <el-button plain type="success" size="mini">Chi tiết
                                    </el-button>
                                </el-col> -->
                                <el-col :md="24" :lg="6">
                                    <div class="dts-moibieudo grid-content bg-purple-light">
                                        <div class="dts-card-header">
                                            <span class="dts-card-title">Tổng quan</span>
                                            <span class="dts-right"><a href="#"
                                                    @click.prevent="layBieuDoTongQuanHocSinh"
                                                    title="Lấy lại dữ liệu thống kê"><i
                                                        class="fa-solid fa-rotate-right"></i></a>
                                            </span>
                                        </div>
                                        <div class="dts-card-body">
                                            <div v-loading="loading.tongQuanHocSinh"
                                                element-loading-background="rgba(0, 0, 0, 0.8)">
                                                <BieuDoHinhTron :label="label.hocSinh.tongQuan"
                                                    :dulieu="duLieuTongQuanHocSinh">
                                                </BieuDoHinhTron>
                                            </div>
                                        </div>
                                    </div>
                                </el-col>
                                <el-col :md="24" :lg="6">
                                    <div class="dts-moibieudo grid-content bg-purple-light">
                                        <div class="dts-card-header">
                                            <span class="dts-card-title">Giới tính</span>
                                            <span class="dts-right"><a href="#"
                                                    @click.prevent="layBieuDoGioiTinhHocSinh"
                                                    title="Lấy lại dữ liệu thống kê"><i
                                                        class="fa-solid fa-rotate-right"></i></a>
                                            </span>
                                        </div>
                                        <div class="dts-card-body">
                                            <div v-loading="loading.gioiTinhHocSinh"
                                                element-loading-background="rgba(0, 0, 0, 0.8)">
                                                <BieuDoHinhTron :label="label.hocSinh.gioiTinh"
                                                    :dulieu="duLieuGioiTinhHocSinh">
                                                </BieuDoHinhTron>
                                            </div>
                                        </div>
                                    </div>
                                </el-col>
                                <el-col :span="24" style="height:15px"></el-col>
                                <el-col :md="12" :lg="12">
                                    <div class="dts-moibieudo grid-content bg-purple-light">
                                        <div class="dts-card-header">
                                            <span class="dts-card-title">Trạng thái học sinh</span>
                                            <span class="dts-right"><a href="#"
                                                    @click.prevent="layBieuDoHocSinhTheoTrangThai"
                                                    title="Lấy lại dữ liệu thống kê"><i
                                                        class="fa-solid fa-rotate-right"></i></a>
                                            </span>
                                        </div>
                                        <div class="dts-card-body">
                                            <div v-loading="loading.trangThaiHocSinh"
                                                element-loading-background="rgba(0, 0, 0, 0.8)">
                                                <BieuDoCotChong :label="label.hocSinh.trangThai"
                                                    :dulieu="duLieuTrangThaiHocSinh">
                                                </BieuDoCotChong>
                                            </div>
                                        </div>
                                    </div>
                                </el-col>
                                <el-col :md="12" :lg="12">
                                    <div class="dts-moibieudo grid-content bg-purple-light">
                                        <div class="dts-card-header">
                                            <span class="dts-card-title">Loại hình đào tạo</span>
                                            <span class="dts-right"><a href="#"
                                                    @click.prevent="layBieuDoHocSinhTheoLoaiHinhDaoTao"
                                                    title="Lấy lại dữ liệu thống kê"><i
                                                        class="fa-solid fa-rotate-right"></i></a>
                                            </span>
                                        </div>
                                        <div class="dts-card-body">
                                            <div v-loading="loading.loaiHinhDaoTaoHocSinh"
                                                element-loading-background="rgba(0, 0, 0, 0.8)">
                                                <BieuDoCotChong :label="label.hocSinh.loaiHinhDaoTao"
                                                    :dulieu="duLieuLoaiHinhDaoTaoHocSinh">
                                                </BieuDoCotChong>
                                            </div>
                                        </div>
                                    </div>
                                </el-col>
                            </el-row>
                        </div>
                        <div v-if="viewActive=='ketQuaHocTap'">
                            <el-row :gutter="20" class="card-bieu-do">
                                <el-col :span="22">
                                    <h5> <i class="fas fa-chart-line"></i> Kết quả học tập</h5>
                                </el-col>
                                <el-col :md="12" :lg="12">
                                    <div class="dts-moibieudo grid-content bg-purple-light">
                                        <div class="dts-card-header">
                                            <span class="dts-card-title">Phổ điểm học kỳ I</span>
                                            <span class="dts-right"><a href="#" @click.prevent="layPhoDiemHocKyI"
                                                    title="Lấy lại dữ liệu thống kê"><i
                                                        class="fa-solid fa-rotate-right"></i></a>
                                            </span>
                                        </div>
                                        <div class="dts-card-body">
                                            <div v-loading="loading.phoDiemHocKyI"
                                                element-loading-background="rgba(0, 0, 0, 0.8)">
                                                <PhoDiem  :dulieu="duLieuPhoDiemHocKyI">
                                                </PhoDiem>
                                            </div>
                                        </div>
                                    </div>
                                </el-col>
                                <el-col :md="12" :lg="12">
                                    <div class="dts-moibieudo grid-content bg-purple-light">
                                        <div class="dts-card-header">
                                            <span class="dts-card-title">Phổ điểm học kỳ II</span>
                                            <span class="dts-right"><a href="#" @click.prevent="layPhoDiemHocKyII"
                                                    title="Lấy lại dữ liệu thống kê"><i
                                                        class="fa-solid fa-rotate-right"></i></a>
                                            </span>
                                        </div>
                                        <div class="dts-card-body">
                                            <div v-loading="loading.phoDiemHocKyII"
                                                element-loading-background="rgba(0, 0, 0, 0.8)">
                                                <PhoDiem  :dulieu="duLieuPhoDiemHocKyII">
                                                </PhoDiem>
                                            </div>
                                        </div>
                                    </div>
                                </el-col>
                                <el-col :span="24" style="height:15px"></el-col>
                                <el-col :md="12" :lg="8">
                                    <div class="dts-moibieudo grid-content bg-purple-light">
                                        <div class="dts-card-header">
                                            <span class="dts-card-title">ĐÁNH GIÁ HỌC SINH HỌC KỲ I (THCS,THPT)</span>
                                            <span class="dts-right"><a href="#"
                                                    @click.prevent="layKetQuaDanhGiaHocKyI"
                                                    title="Lấy lại dữ liệu thống kê"><i
                                                        class="fa-solid fa-rotate-right"></i></a>
                                            </span>
                                        </div>
                                        <div class="dts-card-body">
                                            <div v-loading="loading.ketQuaDanhGiaHocKyI"
                                                element-loading-background="rgba(0, 0, 0, 0.8)">
                                                <BieuDoCotChong :label="label.ketQuaHocTap.danhGiaHocKy"
                                                    :dulieu="duLieuDanhGiaHocSinhKyI">
                                                </BieuDoCotChong>
                                            </div>
                                        </div>
                                    </div>
                                </el-col>
                                <el-col :md="12" :lg="8">
                                    <div class="dts-moibieudo grid-content bg-purple-light">
                                        <div class="dts-card-header">
                                            <span class="dts-card-title">ĐÁNH GIÁ HỌC SINH HỌC KỲ II (THCS,THPT)</span>
                                            <span class="dts-right"><a href="#"
                                                    @click.prevent="layKetQuaDanhGiaHocKyII"
                                                    title="Lấy lại dữ liệu thống kê"><i
                                                        class="fa-solid fa-rotate-right"></i></a>
                                            </span>
                                        </div>
                                        <div class="dts-card-body">
                                            <div v-loading="loading.ketQuaDanhGiaHocKyII"
                                                element-loading-background="rgba(0, 0, 0, 0.8)">
                                                <BieuDoCotChong :label="label.ketQuaHocTap.danhGiaHocKy"
                                                    :dulieu="duLieuDanhGiaHocSinhKyII">
                                                </BieuDoCotChong>
                                            </div>
                                        </div>
                                    </div>
                                </el-col>
                                <el-col :md="12" :lg="8">
                                    <div class="dts-moibieudo grid-content bg-purple-light">
                                        <div class="dts-card-header">
                                            <span class="dts-card-title">ĐÁNH GIÁ HỌC SINH CẢ NĂM (THCS,THPT)</span>
                                            <span class="dts-right"><a href="#"
                                                    @click.prevent="layKetQuaDanhGiaHocKyIII"
                                                    title="Lấy lại dữ liệu thống kê"><i
                                                        class="fa-solid fa-rotate-right"></i></a>
                                            </span>
                                        </div>
                                        <div class="dts-card-body">
                                            <div v-loading="loading.ketQuaDanhGiaHocKyIII"
                                                element-loading-background="rgba(0, 0, 0, 0.8)">
                                                <BieuDoCotChong :label="label.ketQuaHocTap.danhGiaHocKy"
                                                    :dulieu="duLieuDanhGiaHocSinhKyIII">
                                                </BieuDoCotChong>
                                            </div>
                                        </div>
                                    </div>
                                </el-col>
                            </el-row>
                        </div>
                    </div>
                </section>
            </div>
            <!-- <aside class="control-sidebar control-sidebar-dark">
            </aside> -->
        </div>
    </div>
</template>
<script>
    import ESelectVue from '../ui/ESelect.vue';
    import rest_api from "../../utils/rest_api";
    import ElementUI from 'element-ui';
    import banDo from './banDo';
    import BieuDoHinhTron from './bieuDoHinhTron';
    import BieuDoCotChong from './BieuDoCotChong';
    import PhoDiem from './bieuDoPhoDiem'
    import thongKeCoBan from './thongKeCoBan';
    import constant from '../../utils/constant';
    Vue.use(ElementUI);
    export default {
        components: {
            'eselect': ESelectVue,
            'banDo': banDo,
            'thongKeCoBan': thongKeCoBan,
            'BieuDoCotChong': BieuDoCotChong,
            'BieuDoHinhTron': BieuDoHinhTron,
            'PhoDiem': PhoDiem,
        },
        data() {
            return {
                darkMode: false,
                viewActive: 'banDo',
                thongtin: JSON.parse(window.userInfo),
                list_don_vi: [],
                maDonVi: [],
                capHoc: [],
                namHoc: '',
                list_cap_hoc: window.listCapHoc,
                list_nam_hoc: constant.LIST_YEARS_FULL,
                dataMap: '',
                thongTinThongKeCoBan: {},
                loadingMap: false,
                label: {
                    truongHoc: {
                        tongQuan: ['Mầm non', 'Tiểu học', 'THCS', 'THPT', 'GDTX', 'Liên cấp'],
                        chatLuongDaoTao: ['C.Lượng tối thiểu', 'Chuẩn mức 1', 'Chuẩn mức 2'],
                        loaiHinhDaoTao: ['Công lập', 'Tư thục', 'Dân lập'],
                    },
                    canBo: {
                        tongQuan: ['Mầm non', 'Tiểu học', 'THCS', 'THPT', 'GDTX', 'Liên cấp'],
                        gioiTinh: ['Nam', 'Nữ'],
                        trinhDoChinh: ['Tiến sĩ', 'Thạc sĩ', 'Đại học', 'Cao Đẳng', 'Trung cấp'],
                        loaiHopDong: ['HĐ XĐ thời hạn', 'HĐ KXĐ thời hoạn', 'HĐ lao động'],
                    },
                    hocSinh: {
                        tongQuan: ['Mầm non', 'Tiểu học', 'THCS', 'THPT', 'GDTX', 'Liên cấp'],
                        trangThai: ['Đang học', 'Bỏ học', 'Chuyển trường'],
                        loaiHinhDaoTao: ['Công lập', 'Dân lập', 'Tư thục'],
                        gioiTinh: ['Nam', 'Nữ'],
                    },
                    ketQuaHocTap:{
                        danhGiaHocKy:['Giỏi','Khá','T.Bình','Yếu','Kém','Khác']
                    }
                },
                loading: {
                    tongQuanTruongHoc: false,
                    chatLuongDaoTaoTruongHoc: false,
                    loaiHinhDaoTaoTruongHoc: false,
                    tongQuanTruongHoc: false,
                    trinhDoChinhCanBoGiaoVien: false,
                    loaiHopDongCanBoGiaoVien: false,
                    tongQuanHocSinh: false,
                    gioiTinhHocSinh: false,
                    trangThaiHocSinh: false,
                    loaiHinhDaoTaoHocSinh: false,
                    phoDiemHocKyI: false,
                    phoDiemHocKyII: false,
                    ketQuaDanhGiaHocKyI: false,
                    ketQuaDanhGiaHocKyII: false,
                    ketQuaDanhGiaHocKyIII: false,
                },
                duLieuTongQuanTruongHoc: [0],
                duLieuTruongHocTheoChatLuongDaoTao: [],
                duLieuTruongHocTheoLoaiHinhDaoTao: [],
                duLieuTongQuanCanBoGiaoVien: [0],
                duLieuGioiTinhCanBoGiaoVien: [0],
                duLieuTrinhDoChinhCanBoGiaoVien: [],
                duLieuLoaiHopDongCanBoGiaoVien: [],
                duLieuTongQuanHocSinh: [0],
                duLieuGioiTinhHocSinh: [0],
                duLieuTrangThaiHocSinh: [],
                duLieuLoaiHinhDaoTaoHocSinh: [],
                duLieuPhoDiemHocKyI: [],
                duLieuPhoDiemHocKyII: [],
                duLieuDanhGiaHocSinhKyI: [],
                duLieuDanhGiaHocSinhKyII: [],
                duLieuDanhGiaHocSinhKyIII: [],
            }
        },
        mounted() {
            console.log("thông tin đăng nhập:" + this.thongtin);
            console.log(this.thongtin);
            this.maDonVi = [this.thongtin.ma_don_vi]
            this.namHoc = this.thongtin.namHocHienTai;
            this.getDonVi();
            this.layToanBoDuLieu()
        },
        watch: {
            viewActive: function (newVal) {
                if (newVal) {
                    this.layToanBoDuLieu()
                }
            },
            darkMode: function (newVal) {
                const el = document.body;
                let className = 'dark-mode'
                if (newVal) {
                    el.classList.add(className);
                } else {
                    el.classList.remove(className);
                }
            }
        },
        methods: {
            chonHienThi(e) {
                if (e) {
                    this.viewActive = e
                } else {
                    this.viewActive = 'banDo'
                }
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
                    duration: 2500
                });
            },
            getDonVi() {
                console.log("lấy đơn vị")
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.ma_so
                };
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    let du_lieu = [];
                    if (data.data.statusResponse == 0) {
                        let ket_qua = data.data.rows;
                        for (let i = 0; i < ket_qua.length; i++) {
                            let obj = {
                                name: ket_qua[i].tenDonVi.replace("Giáo dục và Đào tạo ", "GD&ĐT ") +
                                    ' - [' + ket_qua[i].maDonVi + ']',
                                value: ket_qua[i].maDonVi,
                            }
                            du_lieu.push(obj)
                        }
                        this.list_don_vi = du_lieu;
                    } else {
                        this.list_don_vi = [];
                    }
                });
            },
            layToanBoDuLieu() {
                if (!this.namHoc || this.namHoc == '') {
                    this.thongBao('error', 'Vui lòng bổ sung năm học thống kê.')
                    return
                }
                if (this.viewActive == 'banDo') {
                    if (!this.maDonVi || this.maDonVi.length == 0) {
                        this.thongBao('error', 'Vui lòng bổ sung đơn vị thống kê.')
                        return
                    }
                    // if (!this.capHoc || this.capHoc.length == 0) {
                    //     this.thongBao('error', 'Vui lòng bổ sung cấp học thống kê.')
                    //     return
                    // }
                    this.getDataBanDo();
                }
                if (this.viewActive == 'truongHoc') {
                    this.layBieuDoTongQuanTruongHoc();
                    this.layBieuDoTruongHocTheoChatLuongDaoTao();
                    this.layBieuDoTruongHocTheoLoaiHinhDaoTao();
                }
                if (this.viewActive == 'canBoGiaoVien') {
                    this.layBieuDoTongQuanCanBoGiaoVien();
                    this.layBieuDoGioiTinhCanBoGiaoVien();
                    this.layBieuDoCanBoGiaoVienTheoTrinhDoChinh();
                    this.layBieuDoCanBoGiaoVienTheoLoaiHopDong();
                }
                if (this.viewActive == 'hocSinh') {
                    this.layBieuDoTongQuanHocSinh()
                    this.layBieuDoGioiTinhHocSinh()
                    this.layBieuDoHocSinhTheoTrangThai()
                    this.layBieuDoHocSinhTheoLoaiHinhDaoTao()
                }
                if (this.viewActive == 'ketQuaHocTap') {
                    this.layPhoDiemHocKyI();
                    this.layPhoDiemHocKyII();
                    this.layKetQuaDanhGiaHocKyI();
                    this.layKetQuaDanhGiaHocKyII();
                    this.layKetQuaDanhGiaHocKyIII();
                }
            },
            getDataBanDo() {
                console.log("lấy đơn vị")
                let params = {
                    capHocs: this.capHoc,
                    maDonVis: this.maDonVi,
                    idSo: this.thongtin.ma_so,
                    namHoc: this.namHoc,
                };
                this.loadingMap = true;
                this.thongTinThongKeCoBan = ''
                rest_api.post("/csdlgd-report-api/ioc/data", params, (response) => {
                    this.loadingMap = false;
                    console.log("response bản đồ:")
                    console.log(response)
                    if (response.data.rc == 0) {
                        this.dataMap = response.data;
                        this.thongTinThongKeCoBan = response.data.tongQuanHuyen;
                    }
                });
            },
            layBieuDoTruongHocTheoLoaiHinhDaoTao() {
                let params = {
                    "capHocs": this.capHoc,
                    "maDonVis": this.maDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": [],
                    "namHoc": this.namHoc
                }
                this.loading.loaiHinhDaoTaoTruongHoc = true;
                rest_api.post("/csdlgd-report-api/dasboard/truonghocloaihinhdaotao", params, data => {
                    this.loading.loaiHinhDaoTaoTruongHoc = false;
                    if (data.data.rc == 0) {
                        this.duLieuTruongHocTheoLoaiHinhDaoTao = data.data.item.listData;
                        let dulieu = data.data.item.listData;
                        this.duLieuTruongHocTheoLoaiHinhDaoTao = this.ganViTri(dulieu);
                        this.duLieuTruongHocTheoLoaiHinhDaoTao.sort((a, b) => (a.id > b.id) ? 1 : -1)
                    } else {
                        this.duLieuTruongHocTheoLoaiHinhDaoTao = []
                    }
                    console.log("duLieuTruongHocTheoLoaiHinhDaoTao")
                    console.log(this.duLieuTruongHocTheoLoaiHinhDaoTao)
                });
            },
            layBieuDoTruongHocTheoChatLuongDaoTao() {
                let params = {
                    "capHocs": this.capHoc,
                    "maDonVis": this.maDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": [],
                    "namHoc": this.namHoc
                }
                this.loading.chatLuongDaoTaoTruongHoc = true;
                rest_api.post("/csdlgd-report-api/dasboard/truonghocchatluong", params, data => {
                    this.loading.chatLuongDaoTaoTruongHoc = false;
                    if (data.data.rc == 0) {
                        this.duLieuTruongHocTheoChatLuongDaoTao = data.data.item.listData;
                        let dulieu = data.data.item.listData;
                        this.duLieuTruongHocTheoChatLuongDaoTao = this.ganViTri(dulieu);
                        this.duLieuTruongHocTheoChatLuongDaoTao.sort((a, b) => (a.id > b.id) ? 1 : -1)
                    } else {
                        this.duLieuTruongHocTheoChatLuongDaoTao = []
                    }
                    console.log("duLieuTruongHocTheoChatLuongDaoTao")
                    console.log(this.duLieuTruongHocTheoChatLuongDaoTao)
                });
            },
            layBieuDoTongQuanTruongHoc() {
                let params = {
                    "capHocs": this.capHoc,
                    "maDonVis": this.maDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": [],
                    "namHoc": this.namHoc
                }
                this.loading.tongQuanTruongHoc = true;
                rest_api.post("/csdlgd-report-api/dasboard/truongTron", params, data => {
                    console.log("Dữ liệu biểu đồ trả về:")
                    this.loading.tongQuanTruongHoc = false;
                    console.log(data)
                    if (data.data.rc == 0) {
                        this.duLieuTongQuanTruongHoc = data.data.item.listValue;
                    } else {
                        this.duLieuTongQuanTruongHoc = [0]
                    }
                });
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
                return data;
            },
            layBieuDoCanBoGiaoVienTheoLoaiHopDong() {
                let params = {
                    "capHocs": this.capHoc,
                    "maDonVis": this.maDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": [],
                    "namHoc": this.namHoc
                }
                this.loading.loaiHopDongCanBoGiaoVien = true;
                rest_api.post("/csdlgd-report-api/dasboard/canbogvloaiHD", params, data => {
                    this.loading.loaiHopDongCanBoGiaoVien = false;
                    if (data.data.rc == 0) {
                        this.duLieuLoaiHopDongCanBoGiaoVien = data.data.item.listData;
                        let dulieu = data.data.item.listData;
                        this.duLieuLoaiHopDongCanBoGiaoVien = this.ganViTri(dulieu);
                        this.duLieuLoaiHopDongCanBoGiaoVien.sort((a, b) => (a.id > b.id) ? 1 : -1)
                    } else {
                        this.duLieuLoaiHopDongCanBoGiaoVien = []
                    }
                    console.log("duLieuLoaiHopDongCanBoGiaoVien")
                    console.log(this.duLieuLoaiHopDongCanBoGiaoVien)
                });
            },
            layBieuDoCanBoGiaoVienTheoTrinhDoChinh() {
                let params = {
                    "capHocs": this.capHoc,
                    "maDonVis": this.maDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": [],
                    "namHoc": this.namHoc
                }
                this.loading.trinhDoChinhCanBoGiaoVien = true;
                rest_api.post("/csdlgd-report-api/dasboard/canbogvtrinhdochinh", params, data => {
                    this.loading.trinhDoChinhCanBoGiaoVien = false;
                    if (data.data.rc == 0) {
                        this.duLieuTrinhDoChinhCanBoGiaoVien = data.data.item.listData;
                        let dulieu = data.data.item.listData;
                        this.duLieuTrinhDoChinhCanBoGiaoVien = this.ganViTri(dulieu);
                        this.duLieuTrinhDoChinhCanBoGiaoVien.sort((a, b) => (a.id > b.id) ? 1 : -1)
                    } else {
                        this.duLieuTrinhDoChinhCanBoGiaoVien = []
                    }
                    console.log("duLieuTrinhDoChinhCanBoGiaoVien")
                    console.log(this.duLieuTrinhDoChinhCanBoGiaoVien)
                });
            },
            layBieuDoGioiTinhCanBoGiaoVien() {
                let params = {
                    "capHocs": this.capHoc,
                    "maDonVis": this.maDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": [],
                    "namHoc": this.namHoc
                }
                this.loading.gioiTinhCanBoGiaoVien = true;
                this.duLieuGioiTinhCanBoGiaoVien = [0]
                rest_api.post("/csdlgd-report-api/dasboard/canbogvgioitinh", params, data => {
                    console.log("Dữ liệu biểu đồ trả về:")
                    this.loading.gioiTinhCanBoGiaoVien = false;
                    console.log(data)
                    if (data.data.rc == 0) {
                        let du_lieu = data.data.item.listData;
                        let nam = 0;
                        let nu = 0;
                        for (let i = 0; i < du_lieu.length; i++) {
                            nam += du_lieu[i].data[0];
                            nu += du_lieu[i].data[1];
                        }
                        this.duLieuGioiTinhCanBoGiaoVien = [nam, nu];
                    } else {
                        this.duLieuGioiTinhCanBoGiaoVien = [0]
                    }
                });
            },
            layBieuDoTongQuanCanBoGiaoVien() {
                let params = {
                    "capHocs": this.capHoc,
                    "maDonVis": this.maDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": [],
                    "namHoc": this.namHoc
                }
                this.loading.tongQuanCanBoGiaoVien = true;
                this.duLieuTongQuanCanBoGiaoVien = [0]
                rest_api.post("/csdlgd-report-api/dasboard/canbogvcaphoc", params, data => {
                    console.log("Dữ liệu biểu đồ trả về:")
                    this.loading.tongQuanCanBoGiaoVien = false;
                    console.log(data)
                    if (data.data.rc == 0) {
                        this.duLieuTongQuanCanBoGiaoVien = data.data.item.listValue;
                    } else {
                        this.duLieuTongQuanCanBoGiaoVien = []
                    }
                });
            },
            layBieuDoHocSinhTheoLoaiHinhDaoTao() {
                let params = {
                    "capHocs": this.capHoc,
                    "maDonVis": this.maDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": [],
                    "namHoc": this.namHoc
                }
                this.loading.loaiHinhDaoTaoHocSinh = true;
                rest_api.post("/csdlgd-report-api/dasboard/hocsinhloaihinhdaotao", params, data => {
                    this.loading.loaiHinhDaoTaoHocSinh = false;
                    if (data.data.rc == 0) {
                        this.duLieuLoaiHinhDaoTaoHocSinh = data.data.item.listData;
                        let dulieu = data.data.item.listData;
                        this.duLieuLoaiHinhDaoTaoHocSinh = this.ganViTri(dulieu);
                        this.duLieuLoaiHinhDaoTaoHocSinh.sort((a, b) => (a.id > b.id) ? 1 : -1)
                    } else {
                        this.duLieuLoaiHinhDaoTaoHocSinh = []
                    }
                    console.log("duLieuLoaiHinhDaoTaoHocSinh")
                    console.log(this.duLieuLoaiHinhDaoTaoHocSinh)
                });
            },
            layBieuDoHocSinhTheoTrangThai() {
                let params = {
                    "capHocs": this.capHoc,
                    "maDonVis": this.maDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": [],
                    "namHoc": this.namHoc
                }
                this.loading.trangThaiHocSinh = true;
                rest_api.post("/csdlgd-report-api/dasboard/hocsinhtrangthai", params, data => {
                    this.loading.trangThaiHocSinh = false;
                    if (data.data.rc == 0) {
                        this.duLieuTrangThaiHocSinh = data.data.item.listData;
                        let dulieu = data.data.item.listData;
                        this.duLieuTrangThaiHocSinh = this.ganViTri(dulieu);
                        this.duLieuTrangThaiHocSinh.sort((a, b) => (a.id > b.id) ? 1 : -1)
                    } else {
                        this.duLieuTrangThaiHocSinh = []
                    }
                    console.log("duLieuLoaiHopDongCanBoGiaoVien")
                    console.log(this.duLieuLoaiHopDongCanBoGiaoVien)
                });
            },
            layBieuDoGioiTinhHocSinh() {
                let params = {
                    "capHocs": this.capHoc,
                    "maDonVis": this.maDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": [],
                    "namHoc": this.namHoc
                }
                this.loading.gioiTinhHocSinh = true;
                this.duLieuGioiTinhHocSinh = [0]
                rest_api.post("/csdlgd-report-api/dasboard/hocsinhgioitinh", params, data => {
                    console.log("Dữ liệu biểu đồ trả về:")
                    this.loading.gioiTinhHocSinh = false;
                    console.log(data)
                    if (data.data.rc == 0) {
                        let du_lieu = data.data.item.listData;
                        let nam = 0;
                        let nu = 0;
                        for (let i = 0; i < du_lieu.length; i++) {
                            nam += du_lieu[i].data[0];
                            nu += du_lieu[i].data[1];
                        }
                        this.duLieuGioiTinhHocSinh = [nam, nu];
                    } else {
                        this.duLieuGioiTinhHocSinh = [0]
                    }
                });
            },
            layBieuDoTongQuanHocSinh() {
                let params = {
                    "capHocs": this.capHoc,
                    "maDonVis": this.maDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": [],
                    "namHoc": this.namHoc
                }
                this.loading.tongQuanHocSinh = true;
                this.duLieuTongQuanHocSinh = [0]
                rest_api.post("/csdlgd-report-api/dasboard/hocsinh", params, data => {
                    console.log("Dữ liệu biểu đồ trả về:")
                    this.loading.tongQuanHocSinh = false;
                    console.log(data)
                    if (data.data.rc == 0) {
                        this.duLieuTongQuanHocSinh = data.data.item.listValue;
                    } else {
                        this.duLieuTongQuanHocSinh = []
                    }
                });
            },
            layPhoDiemHocKyI() {
                this.loading.phoDiemHocKyI = true;
                this.duLieuPhoDiemHocKyI = []
                let params = {
                    "hocKy": 1,
                    "capHocs": this.capHoc,
                    "maDonVis": this.maDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": [],
                    "namHoc": this.namHoc
                }
                rest_api.post("/csdlgd-report-api/dasboard/ketquahoctap", params, data => {
                    this.loading.phoDiemHocKyI = false;
                    if (data.data.rc == 0) {
                        this.duLieuPhoDiemHocKyI = data.data.item.listData;
                    } else {
                        this.duLieuPhoDiemHocKyI = []
                    }
                    console.log("Phổ điểm:")
                    console.log(this.duLieuPhoDiemHocKyI)
                });
            },
            
            layPhoDiemHocKyII() {
                this.loading.phoDiemHocKyII = true;
                this.duLieuPhoDiemHocKyII = []
                let params = {
                    "hocKy": 2,
                    "capHocs": this.capHoc,
                    "maDonVis": this.maDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": [],
                    "namHoc": this.namHoc
                }
                rest_api.post("/csdlgd-report-api/dasboard/ketquahoctap", params, data => {
                    this.loading.phoDiemHocKyII = false;
                    if (data.data.rc == 0) {
                        this.duLieuPhoDiemHocKyII = data.data.item.listData;
                    } else {
                        this.duLieuPhoDiemHocKyII = []
                    }
                    console.log("Phổ điểm:")
                    console.log(this.duLieuPhoDiemHocKyII)
                });
            },
            layKetQuaDanhGiaHocKyI() {
                this.loading.ketQuaDanhGiaHocKyI = true;
                let params = {
                    "hocKy": 1,
                    "capHocs": this.capHoc,
                    "maDonVis": this.maDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": [],
                    "namHoc": this.namHoc
                }
                rest_api.post("/csdlgd-report-api/dasboard/danhgiahocsinh", params, data => {
                this.loading.ketQuaDanhGiaHocKyI = false;
                    if (data.data.rc == 0) {
                        this.duLieuDanhGiaHocSinhKyI = data.data.item.listData;
                    } else {
                        this.duLieuDanhGiaHocSinhKyI = []
                    }
                    console.log(this.duLieuDanhGiaHocSinhKyI)
                });
            },
            
            layKetQuaDanhGiaHocKyII() {
                this.loading.ketQuaDanhGiaHocKyII = true;
                let params = {
                    "hocKy": 2,
                    "capHocs": this.capHoc,
                    "maDonVis": this.maDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": [],
                    "namHoc": this.namHoc
                }
                rest_api.post("/csdlgd-report-api/dasboard/danhgiahocsinh", params, data => {
                this.loading.ketQuaDanhGiaHocKyII = false;
                    if (data.data.rc == 0) {
                        this.duLieuDanhGiaHocSinhKyII = data.data.item.listData;
                    } else {
                        this.duLieuDanhGiaHocSinhKyII = []
                    }
                    console.log(this.duLieuDanhGiaHocSinhKyII)
                });
            },
            
            layKetQuaDanhGiaHocKyIII() {
                this.loading.ketQuaDanhGiaHocKyIII = true;
                let params = {
                    "hocKy": 3,
                    "capHocs": this.capHoc,
                    "maDonVis": this.maDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": [],
                    "namHoc": this.namHoc
                }
                rest_api.post("/csdlgd-report-api/dasboard/danhgiahocsinh", params, data => {
                this.loading.ketQuaDanhGiaHocKyIII = false;
                    if (data.data.rc == 0) {
                        this.duLieuDanhGiaHocSinhKyIII = data.data.item.listData;
                    } else {
                        this.duLieuDanhGiaHocSinhKyIII = []
                    }
                    console.log(this.duLieuDanhGiaHocSinhKyIII)
                });
            }
        }
    }

</script>
<style scoped>
</style>
