import Vuex from 'vuex'
import Vue from 'vue'
import array_util from '../../../utils/array_utils';

Vue.use(Vuex);

let store = new Vuex.Store({

    state: {
        ds_don_vi: [],
        ds_truong_hoc: [],
        common_info: {},

        all_schools: [],
        flag_reload: true
    },

    mutations: {

        setFlagReload(state) {
            state.flag_reload = !state.flag_reload;
        },

        setCommonInfo(state, info) {
            state.common_info = info;
        },

        setDsDonVi(state, ds) {
            array_util.clearArrays(state.ds_don_vi.length);
            state.ds_don_vi = ds;
        },

        setAllSchool(state, ds) {
            array_util.clearArrays(state.all_schools.length);
            state.all_schools = ds;
        },

        setDsTruongHoc(state, ds) {
            array_util.clearArrays(state.ds_truong_hoc.length);
            state.ds_truong_hoc = ds;
        },

        clearDsTruongHoc(state) {
            array_util.clearArrays(state.ds_truong_hoc.length);
        }

    }

});

export default store;