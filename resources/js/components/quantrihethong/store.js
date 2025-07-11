import Vuex from 'vuex'
import Vue from 'vue'

Vue.use(Vuex);
let store = new Vuex.Store({

    state: {
        loaiDuLieu: 0,
        filterGeneral: {}
    },

    mutations: {
        setLoaiDuLieu(state, data){
            state.loaiDuLieu = data;
        },
        setFilter(state, data){
            state.filterGeneral = data;
        }
    }
});
export default store;