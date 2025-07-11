export default {
    tree_menu_all : [
                {
                    "name": "Cấu hình hệ thống",
                    "opened": true,
                    "icon": "fas fa-tachometer-alt",
                    "children": [
                        {
                            "name": "Quản lý hệ thống",
                            "path": "/branch",
                            "icon": "fas fa-tachometer-alt",
                        },
                        {
                            "name": "Quản lý tài khoản hệ thống",
                            "path": "/account",
                            "opened": true,
                            "icon": "fas fa-tachometer-alt",
                            "children" :[
                                {
                                    "name": "Xem chi tiết",
                                },
                                {
                                    "name": "Thêm mới",
                                },
                                {
                                    "name": "Sửa"
                                },
                                {
                                    "name": "Xóa",
                                }
                            ]
                        },
                        {
                            "name": "Quản lý dịch vụ phòng tập",
                            "path": "/service",
                            "icon": "fas fa-tachometer-alt",
                        },
                        {
                            "name": "Quản lý thiết bị phòng tập",
                            "path": "/device",
                            "icon": "fas fa-tachometer-alt",
                        },
                        {
                            "name": "Quản lý nhân viên",
                            "path": "/account/admin-check-in",
                            "icon": "fas fa-tachometer-alt",
                        }
                    ]
                },
                {
                    "opened": true,
                    "name": "Báo cáo thống kê",
                    "path": "",
                    "icon": "fas fa-tachometer-alt",
                    "children": [
                        {
                            "name": "Check in",
                            "path": "/report-checkin",
                            "icon": "fas fa-tachometer-alt",
                        },
                        {
                            "name": "Hợp đồng",
                            "path": "/report-contract",
                            "icon": "fas fa-tachometer-alt",
                        },
                        {
                            "name": "Quản lý dịch vụ phòng tập",
                            "path": "/service",
                            "icon": "fas fa-tachometer-alt",
                        },
                        {
                            "name": "Huấn luyện viên",
                            "path": "/report-pt",
                            "icon": "fas fa-tachometer-alt",
                        },
                        {
                            "name": "Phòng tập",
                            "path": "/report-branch",
                            "icon": "fas fa-tachometer-alt",
                        }
                    ]
                },
                {
                    "opened": true,
                    "name": "Vận hành hệ thống",
                    "icon": "fa fa-warning icon-state-danger",
                    "children": [
                        {
                            "name": "Quản lý hợp đồng",
                            "path": "/indenture",
                            "icon": "fas fa-tachometer-alt",
                        },
                        {
                            "name": "Quản lý gói tập",
                            "path": "/packet",
                            "icon": "fas fa-tachometer-alt",
                        },
                        {
                            "name": "Quản lý yêu cầu mua gói",
                            "path": "/packet/request-buy-online",
                            "icon": "fas fa-tachometer-alt",
                        },
                        {
                            "name": "Quản lý hội viên",
                            "path": "/customer",
                            "icon": "fas fa-tachometer-alt",
                        },
                        {
                            "name": "Quản lý khuyến mại",
                            "path": "/event",
                            "icon": "fas fa-tachometer-alt",
                        },
                        {
                            "name": "Quản lý quyền",
                            "path": "/roles",
                            "icon": "fas fa-tachometer-alt",
                        }
                    ]
                },
                {
                    "opened": true,
                    "name": "Chăm sóc khác hàng",
                    "icon": "fa fa-folder icon-state-default",
                    "children": [
                        {
                            "name": "Quản lý thông báo",
                            "path": "/notify",
                            "icon": "fas fa-tachometer-alt",
                        }
                    ]
                },
                {
                    "name": "Giám sát hệ thống",
                    "icon": "fa fa-warning icon-state-warning",
                    "children": [
                        {
                            "name": "Giám sát tổng thể",
                            "path": "/home",
                            "icon": "fas fa-tachometer-alt",
                        },
                        {
                            "name": "Giám sát phòng tập",
                            "path": "/lich-truc",
                            "icon": "fas fa-tachometer-alt",
                        },
                    ]
                },
                {
                    "name": "Quản lý tin tức",
                    "icon": "fa fa-check icon-state-success",
                    "children": [
                        {
                            "name": "Xem chi tiết",
                            "path": "",
                            "icon": "fas fa-tachometer-alt",
                        },
                        {
                            "name": "Thêm mới",
                            "path": "",
                            "icon": "fas fa-tachometer-alt",
                        }
                    ]
                },
                {
                    "name": "Kế hoạch",
                    "icon": "fa fa-check icon-state-success",
                    "children": [
                        {
                            "name": "Video luyện tập - mới",
                            "path": "/planing-video-new",
                            "icon": "fas fa-tachometer-alt",
                        },
                        {
                            "name": "Loại hình động tác",
                            "path": "/planing/action",
                            "icon": "fas fa-tachometer-alt",
                        },
                        {
                            "name": "Quản lý động tác",
                            "path": "/planing-movement",
                            "icon": "fas fa-tachometer-alt",
                            "children" :[
                                {
                                    "name": "Xem chi tiết",
                                },
                                {
                                    "name": "Thêm mới",
                                },
                                {
                                    "name": "Sửa"
                                },
                                {
                                    "name": "Xóa",
                                },
                                {
                                    "name": "Xem thiết bị tập luyện",
                                },
                                {
                                    "name": "Thêm thiết bị tập luyện",
                                }
                            ]
                        },
                        {
                            "name": "Thiết bị tập luyện",
                            "path": "/planing-equipment",
                            "icon": "fas fa-tachometer-alt",
                            "children" :[
                                {
                                    "name": "Xem chi tiết",
                                },
                                {
                                    "name": "Thêm mới",
                                },
                                {
                                    "name": "Sửa"
                                },
                                {
                                    "name": "Xóa",
                                }
                            ]
                        },
                        {
                            "name": "Nhóm thực phẩm",
                            "path": "/group_food",
                            "icon": "fas fa-tachometer-alt",
                            "children" :[
                                {
                                    "name": "Xem chi tiết",
                                },
                                {
                                    "name": "Thêm mới",
                                },
                                {
                                    "name": "Sửa"
                                },
                                {
                                    "name": "Xóa",
                                }
                            ]
                        },
                        {
                            "name": "Thực phẩm",
                            "path": "/planing-food",
                            "icon": "fas fa-tachometer-alt",
                        },
                        {
                            "name": "Kế hoạch",
                            "path": "/planing/list",
                            "icon": "fas fa-tachometer-alt",
                        },
                        {
                            "name": "Kế hoạch-PT",
                            "path": "/planing/plan-pt",
                            "icon": "fas fa-tachometer-alt",
                        },
                    ]
                },
                {
                    "name": "Huấn luyện viên",
                    "children": [
                        {
                            "name": "Danh sách gói tập",
                            "icon": "fa fa-warning icon-state-warning",
                            "path": "/pt/list-packet",
                            "children" :[
                                {
                                    "name": "Xem chi tiết",
                                },
                                {
                                    "name": "Thêm mới",
                                },
                                {
                                    "name": "Sửa"
                                },
                                {
                                    "name": "Xóa",
                                }
                            ]
                        },
                        {
                            "name": "Danh sách hợp đồng",
                            "icon": "fa fa-warning icon-state-warning",
                            "path": "/pt/list-indenture",
                            "children" :[
                                {
                                    "name": "Xem chi tiết",
                                },
                                {
                                    "name": "Thêm mới",
                                },
                                {
                                    "name": "Sửa"
                                },
                                {
                                    "name": "Xóa",
                                }
                            ]
                        },
                        {
                            "name": "Quản lý tập luyện",
                            "icon": "fa fa-warning icon-state-warning",
                            "path": "/pt/manager-for-pt",
                            "children" :[
                                {
                                    "name": "Xem lịch tập",
                                },
                                {
                                    "name": "Đặt lịch",
                                },
                                {
                                    "name": "Hủy lịch"
                                }
                            ]
                        },
                        {
                            "name": "Quản lý khuyến mại",
                            "icon": "fa fa-warning icon-state-warning",
                            "path": "/pt/list-promotions",
                            "children" :[
                                {
                                    "name": "Xem chi tiết",
                                },
                                {
                                    "name": "Thêm mới",
                                },
                                {
                                    "name": "Sửa"
                                },
                                {
                                    "name": "Xóa",
                                }
                            ]
                        },
                        {
                            "name": "Quản lý thu nhập",
                            "icon": "fa fa-warning icon-state-warning",
                            "path": "/pt/manager-income",
                        }
                    ]
                }
            ]
}
