import Vuex from 'vuex'
import Vue from "vue";

Vue.use(Vuex)

export const store = new Vuex.Store({
    state: {
        listData: [],
        baseUrl: 'api/',
        modalDisplay : false
    },
    actions: {
        addData(context, {data, url}) {
            axios.post(url, data)
            .then((response) => {
                Vue.$toast.success(response.data.msg)
                context.state.listData.push(response.data.data)
            })
            .catch((error) => {
                console.log(error);
            })
        },
        updateData(context, {data, url}) {
            axios.put(url, data)
            .then((response) => {
                Vue.$toast.success(response.data.msg);
                context.commit('updateListData', response.data.data)
            })
            .catch((error) => {
                console.log(error);
            })
        },
        deleteData(context, {index, id, url}) {
            Vue.swal.fire({
                title: 'Do you want to save the changes?',
                showCancelButton: true,
                confirmButtonText: `Delete`,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(context.state.baseUrl + url + '/' + id)
                    .then((response) => {
                        if (response.data.status === 200) {
                            Vue.$toast.success(response.data.msg)
                            context.commit('deleteListData', index)
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    })
                } else if (result.isDenied) {
                    Vue.swal.fire('Not Deleted!', '', 'info')
                }
            })
        },
        getListData(context, url) {
            axios.get(url)
            .then((response) => {
                context.commit('setListData', response.data.data)
            })
            .catch((error) => {
                console.log(error);
            })
        },
    },
    getters: {
        startLoader() {
            this.$loading(true)
        },

        stopLoader() {
            this.$loading(false)
        }
    },
    mutations: {
        deleteListData(state, index) {
            console.log(state.listData.data)
            state.listData.data.splice(index,1)
        },

        setListData(state, data) {
            state.listData = data
        },

        updateListData(state, data) {
            let index = state.listData.data.findIndex(value => value.id === data.id)
            state.listData.data.splice(index, 1, data)
        }
    }
})
