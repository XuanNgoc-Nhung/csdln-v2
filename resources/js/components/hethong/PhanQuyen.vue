<template>

    <div id="modal_decentralization" ref="modal_decentralization" class="modal fade">
        <div class="modal-dialog" style="width: 50%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                        &times;
                    </button>
                    <h3 class="modal-title text-uppercase">Phân Quyền người dùng</h3>
                </div>
                <div class="modal-body" style="width: 90%;margin: 0 auto;">
                    <div class="row">
                        <div class="col-md-2"><h5><b>Chọn quyền:</b></h5></div>
                        <div class="col-md-6">
                            <select
                                @change="selectOption()"
                                class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                style="width:100%">
                                <option value="">-- Supper admin --</option>
                                <option value="">-- Admin Sở --</option>
                                <option value="">-- Người dùng Sở --</option>
                                <option value="">-- Phòng --</option>
                                <option value="">-- Trường --</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <div>
<!--                                <button v-if="tuychinhquyen" v-on:click="tuychinhquyen = !tuychinhquyen" class="btn btn-primary">Sử dụng quyền mặc định</button>-->
<!--                                <button v-else v-on:click="tuychinhquyen = !tuychinhquyen" class="btn btn-primary">Tùy chỉnh quyền</button>-->
                                <input style="margin-top:10px;" v-model="tuychinhquyen" type="checkbox"> Tùy chỉnh quyền
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div v-if="tuychinhquyen" class="col-md-4">
                            <v-jstree :data="data" show-checkbox multiple allow-batch whole-row
                                      @item-click="itemClick"></v-jstree>
                        </div>

                    </div>
                </div>

                <div class="modal-footer clearfix">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng
                    </button>
                    <button type="button" v-on:click="createRoleUser()" class="btn btn-primary">Lưu lại</button>
                </div>
            </div>


        </div>

    </div>

</template>

<script>

    $(document).ready(function () {
        console.log("ready!");
    });

    import VueAlertify from 'vue-alertify';
    import VJstree from 'vue-jstree';
    import utils from '../../utils'

    Vue.use(VueAlertify);
    export default {
        props: ['item', 'show'], components: {
            "v-jstree": VJstree
        },
        watch: {
            show: function (newVal, oldVal) {
                console.log("newVal = " + newVal);
                if (newVal) {
                    $("#modal_decentralization").modal();
                } else {
                    $("#modal_decentralization").modal('hide');
                }
            }
        },
        data() {
            return {
                tuychinhquyen:false,
                student_code: '',
                data: [
                    {
                        "text": "Danh mục",
                        "selected": true,
                        "children": [
                            {
                                "text": "Đơn vị",
                                "selected": true,
                                "children": [
                                    {
                                        "text": "Thêm",
                                        "selected": true
                                    },
                                    {
                                        "text": "Sửa",
                                        "selected": true
                                    },
                                    {
                                        "text": "Xóa",
                                        "selected": true
                                    }
                                ]
                            },
                            {
                                "text": "Trường học",
                                "selected": true,
                                "children": [
                                    {
                                        "text": "Thêm",
                                        "selected": true
                                    },
                                    {
                                        "text": "Sửa",
                                        "selected": true
                                    },
                                    {
                                        "text": "Xóa",
                                        "selected": true
                                    }
                                ]
                            },
                            {
                                "text": "Môn học",
                                "selected": true,
                                "children": [
                                    {
                                        "text": "Thêm",
                                        "selected": true
                                    },
                                    {
                                        "text": "Sửa",
                                        "selected": true
                                    },
                                    {
                                        "text": "Xóa",
                                        "selected": true
                                    }
                                ]
                            },
                            {
                                "text": "Tỉnh thành",
                                "selected": true,
                                "children": [
                                    {
                                        "text": "Thêm",
                                        "selected": true
                                    },
                                    {
                                        "text": "Sửa",
                                        "selected": true
                                    },
                                    {
                                        "text": "Xóa",
                                        "selected": true
                                    }
                                ]
                            },
                            {
                                "text": "Quận huyện",
                                "selected": true,
                                "children": [
                                    {
                                        "text": "Thêm",
                                        "selected": true
                                    },
                                    {
                                        "text": "Sửa",
                                        "selected": true
                                    },
                                    {
                                        "text": "Xóa",
                                        "selected": true
                                    }
                                ]
                            },
                            {
                                "text": "Xã phường",
                                "selected": true,
                                "children": [
                                    {
                                        "text": "Thêm",
                                        "selected": true
                                    },
                                    {
                                        "text": "Sửa",
                                        "selected": true
                                    },
                                    {
                                        "text": "Xóa",
                                        "selected": true
                                    }
                                ]
                            },
                            {
                                "text": "Tổ thôn",
                                "selected": true,
                                "children": [
                                    {
                                        "text": "Thêm",
                                        "selected": true
                                    },
                                    {
                                        "text": "Sửa",
                                        "selected": true
                                    },
                                    {
                                        "text": "Xóa",
                                        "selected": true
                                    }
                                ]
                            },
                            {
                                "text": "Dân tộc",
                                "selected": true,
                                "children": [
                                    {
                                        "text": "Thêm",
                                        "selected": true
                                    },
                                    {
                                        "text": "Sửa",
                                        "selected": true
                                    },
                                    {
                                        "text": "Xóa",
                                        "selected": true
                                    }
                                ]
                            },
                            {
                                "text": "Tôn giáo",
                                "selected": true,
                                "children": [
                                    {
                                        "text": "Thêm",
                                        "selected": true
                                    },
                                    {
                                        "text": "Sửa",
                                        "selected": true
                                    },
                                    {
                                        "text": "Xóa",
                                        "selected": true
                                    }
                                ]
                            },
                            {
                                "text": "Chuyên ngành đào tạo",
                                "selected": true,
                                "children": [
                                    {
                                        "text": "Thêm",
                                        "selected": true
                                    },
                                    {
                                        "text": "Sửa",
                                        "selected": true
                                    },
                                    {
                                        "text": "Xóa",
                                        "selected": true
                                    }
                                ]
                            },
                            {
                                "text": "Đối tượng chính sách",
                                "selected": true,
                                "children": [
                                    {
                                        "text": "Thêm",
                                        "selected": true
                                    },
                                    {
                                        "text": "Sửa",
                                        "selected": true
                                    },
                                    {
                                        "text": "Xóa",
                                        "selected": true
                                    }
                                ]
                            },
                            {
                                "text": "Lý do bỏ học",
                                "selected": true,
                                "children": [
                                    {
                                        "text": "Thêm",
                                        "selected": true
                                    },
                                    {
                                        "text": "Sửa",
                                        "selected": true
                                    },
                                    {
                                        "text": "Xóa",
                                        "selected": true
                                    }
                                ]
                            },
                            {
                                "text": "Loại đối tượng",
                                "selected": true,
                                "children": [
                                    {
                                        "text": "Thêm",
                                        "selected": true
                                    },
                                    {
                                        "text": "Sửa",
                                        "selected": true
                                    },
                                    {
                                        "text": "Xóa",
                                        "selected": true
                                    }
                                ]
                            },
                            {
                                "text": "Lĩnh vực đánh giá phát triển",
                                "selected": true,
                                "children": [
                                    {
                                        "text": "Thêm",
                                        "selected": true
                                    },
                                    {
                                        "text": "Sửa",
                                        "selected": true
                                    },
                                    {
                                        "text": "Xóa",
                                        "selected": true
                                    }
                                ]
                            },
                            {
                                "text": "Chỉ số đánh giá phát triển",
                                "selected": true,
                                "children": [
                                    {
                                        "text": "Thêm",
                                        "selected": true
                                    },
                                    {
                                        "text": "Sửa",
                                        "selected": true
                                    },
                                    {
                                        "text": "Xóa",
                                        "selected": true
                                    }
                                ]
                            },
                            {
                                "text": "Chuẩn chiều cao và cân nặng",
                                "selected": true,
                                "children": [
                                    {
                                        "text": "Thêm",
                                        "selected": true
                                    },
                                    {
                                        "text": "Sửa",
                                        "selected": true
                                    },
                                    {
                                        "text": "Xóa",
                                        "selected": true
                                    }
                                ]
                            },
                        ]
                    },
                    {
                        "text": "Hệ thống",
                    "selected": true,
                        "children": [
                            {
                                "text": "Quản lý người dùng",
                                "selected": true,
                                "children": [
                                    {
                                        "text": "Thêm",
                                        "selected": true
                                    },
                                    {
                                        "text": "Sửa",
                                        "selected": true
                                    },
                                    {
                                        "text": "Xóa",
                                        "selected": true
                                    },
                                    {
                                        "text": "Phân quyền",
                                        "selected": true
                                    }
                                ]
                            },
                            {
                                "text": "Cấu hình email",
                                "selected": true,
                                "children": [
                                    {
                                        "text": "Thêm",
                                        "selected": true
                                    },
                                    {
                                        "text": "Sửa",
                                        "selected": true
                                    },
                                    {
                                        "text": "Xóa",
                                        "selected": true
                                    }
                                ]
                            },
                            {
                                "text": "Cấu hình mẫu email",
                                "selected": true,
                                "children": [
                                    {
                                        "text": "Thêm",
                                        "selected": true
                                    },
                                    {
                                        "text": "Sửa",
                                        "selected": true
                                    },
                                    {
                                        "text": "Xóa",
                                        "selected": true
                                    }
                                ]
                            },
                            {
                                "text": "Quản lý đối tác",
                                "selected": true,
                                "children": [
                                    {
                                        "text": "Thêm",
                                        "selected": true
                                    },
                                    {
                                        "text": "Sửa",
                                        "selected": true
                                    },
                                    {
                                        "text": "Xóa",
                                        "selected": true
                                    }
                                ]
                            },
                        ]
                    },
                    {
                        "text": "Đồng bộ EMIS",
                    "selected": true,
                        "children": [
                            {
                                "text": "Quản lý nhóm tiêu chí",
                                "selected": true,
                                "children": [
                                    {
                                        "text": "Thêm",
                                        "selected": true
                                    },
                                    {
                                        "text": "Sửa",
                                        "selected": true
                                    },
                                    {
                                        "text": "Xóa",
                                        "selected": true
                                    }
                                ]
                            },
                            {
                                "text": "Quản lý tiêu chí",
                                "selected": true,
                                "children": [
                                    {
                                        "text": "Thêm",
                                        "selected": true
                                    },
                                    {
                                        "text": "Sửa",
                                        "selected": true
                                    },
                                    {
                                        "text": "Xóa",
                                        "selected": true
                                    }
                                ]
                            },
                            {
                                "text": "Lịch sử đồng bộ EMIS",
                                "selected": true,
                                "children": [
                                    {
                                        "text": "Thêm",
                                        "selected": true
                                    },
                                    {
                                        "text": "Sửa",
                                        "selected": true
                                    },
                                    {
                                        "text": "Xóa",
                                        "selected": true
                                    }
                                ]
                            }
                        ]
                    },
                    {
                        "text": "Báo cáo động",
                        "selected": true,
                        "children": [
                            {
                                "text": "Quản lý nhóm tiêu chí",
                                "selected": true,
                                "children": [
                                    {
                                        "text": "Thêm"
                                    },
                                    {
                                        "text": "Sửa"
                                    },
                                    {
                                        "text": "Xóa"
                                    }
                                ]
                            },
                            {
                                "text": "Quản lý tiêu chí",
                                "selected": true,
                                "children": [
                                    {
                                        "text": "Thêm",
                                        "selected": true
                                    },
                                    {
                                        "text": "Sửa",
                                        "selected": true
                                    },
                                    {
                                        "text": "Xóa",
                                        "selected": true
                                    }
                                ]
                            },
                            {
                                "text": "Cấu hình báo cáo",
                                "selected": true,
                                "children": [
                                    {
                                        "text": "Thêm",
                                        "selected": true
                                    },
                                    {
                                        "text": "Sửa",
                                        "selected": true
                                    },
                                    {
                                        "text": "Xóa",
                                        "selected": true
                                    }
                                ]
                            }
                        ]
                    },
                    {
                        "text": "Quản trị hệ thống",
                        "selected": true,
                        "children": [
                            {
                                "text": "Quản lý nhóm tiêu chí",
                                "selected": true,
                                "children": [
                                    {
                                        "text": "Thêm"
                                    },
                                    {
                                        "text": "Sửa"
                                    },
                                    {
                                        "text": "Xóa"
                                    }
                                ]
                            },
                            {
                                "text": "Tra cứu lỗi",
                                "selected": true,
                                "children": [
                                    {
                                        "text": "Thêm",
                                        "selected": true
                                    },
                                    {
                                        "text": "Sửa",
                                        "selected": true
                                    },
                                    {
                                        "text": "Xóa",
                                        "selected": true
                                    }
                                ]
                            },
                            {
                                "text": "Tra cứu dữ liệu",
                                "selected": true,
                                "children": [
                                    {
                                        "text": "Thêm",
                                        "selected": true
                                    },
                                    {
                                        "text": "Sửa",
                                        "selected": true
                                    },
                                    {
                                        "text": "Xóa",
                                        "selected": true
                                    }
                                ]
                            },
                            {
                                "text": "Lịch sử chuyển dữ liệu",
                                "selected": true,
                                "children": [
                                    {
                                        "text": "Thêm",
                                        "selected": true
                                    },
                                    {
                                        "text": "Sửa",
                                        "selected": true
                                    },
                                    {
                                        "text": "Xóa",
                                        "selected": true
                                    }
                                ]
                            },
                            {
                                "text": "Trợ giúp",
                                "selected": true,
                                "children": [
                                    {
                                        "text": "Thêm",
                                        "selected": true
                                    },
                                    {
                                        "text": "Sửa",
                                        "selected": true
                                    },
                                    {
                                        "text": "Xóa",
                                        "selected": true
                                    }
                                ]
                            }
                        ]
                    },
                ],

            }
        },
        mounted: function () {
            console.log("mounted !!!!!");
            $(this.$refs.modal_decentralization).on("hidden.bs.modal", this.close);
        },
        methods: {

            itemClick(node) {
                console.log('Chọn:' + node.model.text )
            },
            selectOption(){
                console.log("chọn quyền");
                this.tuychinhquyen = false;
            },

            close() {
                console.log("Đóng modal");
                this.$emit('close');
            },
            createRoleUser(){
                console.log("Phân quyền");
                utils.confirmDialog("Xác nhận phân quyền?", "Đồng ý", () => {
                    console.log("dữ liệu:");
                    console.log(this.data);
                    this.$alertify.success('Phân quyền thành công');
                })
            }

        }

    }
</script>


<style scoped>

</style>
