<template>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Color</li>
                        </ol>
                    </div>
                    <div class="col-sm-6 text-right">
                        <button class="btn bg-gradient-info btn-flat text-right btn-sm" data-toggle="modal" @click="Add()" data-target="#myModal">Add Color
                        </button>
                    </div>

                    <!-- Modal -->
                    <div id="myModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Create Color</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <form @submit.prevent="submit()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" class="form-control" v-model="form.name" placeholder="Enter Name">
                                            <span class="text-danger" v-if='$vuelidation.error("form.name")'>{{ $vuelidation.error('form.name') }}</span>
                                        </div>
                                        <div class="form-group">
                                            <label>Color Select</label>
                                            <input type="color" class="form-control" v-model="form.color_code" placeholder="Enter color_code">
                                            <span class="text-danger" v-if='$vuelidation.error("form.color_code")'>{{ $vuelidation.error('form.color_code') }}</span>
                                        </div>
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea class="form-control" v-model="form.description" placeholder="Description"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control" v-model="form.status">
                                                <option value="">Select</option>
                                                <option value="1">Active</option>
                                                <option value="0">De-active</option>
                                            </select>
                                            <span class="text-danger" v-if='$vuelidation.error("form.status")'>{{ $vuelidation.error('status') }}</span>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn bg-gradient-primary btn-flat btn-sm" type="submit" :disabled="$vuelidation.errors()">Submit</button>
                                        <button type="button" class="btn bg-gradient-secondary btn-flat btn-sm" data-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-header -->

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Color DataTable</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table-search-bar :filter="filter"></table-search-bar>
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Color</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(data_value, index) in colorData.data">
                                        <td>{{ index+1 }}</td>
                                        <td>{{ data_value.name }}</td>
                                        <td>
                                            <span class="dot" :style="'background-color : '+data_value.color_code"></span>
                                        </td>
                                        <td>{{ data_value.status == 1 ? 'Active' : 'De-active' }}</td>
                                        <td>
                                            <button class="btn btn-danger btn-sm" @click="Delete(index, data_value.id)">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            <button class="btn btn-info btn-sm" @click="Edit(index, data_value.id)">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Color</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                </table>
                                <pagination :data="colorData" @pagination-change-page="getData()"></pagination>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import TableSearchBar from "../layouts/tableSearchBar";
export default {
    name : 'color',
    components: {TableSearchBar},
    data() {
        return {
            form : {
                name : '',
                color_code : '',
                description : '',
                status : 1,
            },
            filter : {
                table_row : [10, 20, 30, 50],
                search : '',
                row : 10,
            },
            colorData : {},
            edit_color : false,
            edit_index_no : 0,
            submit_url : '',
        }
    },
    watch: {
        'filter.row': function (newVal, oldVal) {
            this.getData();
        },
        'filter.search': function (newVal, oldVal) {
            this.getData();
        },
    },
    vuelidation : {
        data: {
            form : {
                name: {
                    required: true, msg : 'name field is required!'
                },
                color_code: {
                    required: true, msg : 'color_code field is required!'
                },
                status: {
                    required: true, msg : 'status field is required!'
                },
            },
        },
    },
    methods: {
        submit : function () {
            const _this = this;
            if (this.$vuelidation.valid('form')) {
                this.Loader();
                $('#myModal').modal('hide');
                if (_this.edit_color === false) {
                    axios.post(_this.submit_url, _this.form)
                        .then((response) => {
                            Vue.$toast.success('Color Created Successfully');
                            _this.colorData.data.push(response.data.data);
                        })
                        .catch((error) => {
                            console.log(error);
                        })
                }
                if (_this.edit_color === true) {
                    axios.put(_this.submit_url, _this.form)
                        .then((response) => {
                            Vue.$toast.success('Color Update Successfully');
                            _this.colorData.data[_this.edit_index_no] = response.data.data;
                        })
                        .catch((error) => {
                            console.log(error);
                        })
                }
            }
        },
        getData : function (page = 1){
            const _this = this;
            axios.get(this.baseUrl + 'color?q='+ _this.filter.search+'&page='+page+'&row='+_this.filter.row)
                .then((response) => {
                    _this.colorData = response.data.data;
                    console.log( _this.colorData );
                })
                .catch((error) => {
                    console.log(error);
                })
        },
        Delete : function (index, id) {
            const _this = this;
            Vue.swal.fire({
                title: 'Do you want to save the changes?',
                showCancelButton: true,
                confirmButtonText: `Delete`,
            }).then((result) => {
                if (result.isConfirmed) {
                    this.Loader();
                    axios.delete(this.baseUrl + 'color/' + id)
                        .then((response) => {
                            if (response.data.status == 200) {
                                Vue.$toast.success('Category Deleted Successfully');
                                _this.colorData.data.splice(index,1);
                            }
                        })
                        .catch((error) => {
                            console.log(error);
                        })
                } else if (result.isDenied) {
                    Vue.swal.fire('Color are not Deleted!', '', 'info')
                }
            })

        },
        Edit : function (index, id) {
            const _this = this;
            _this.form = JSON.parse(JSON.stringify(_this.colorData.data[index]));
            _this.edit_color = true;
            _this.edit_index_no = id;
            _this.submit_url = this.baseUrl+ 'color/'+id;
            $('#myModal').modal('show');
        },
        Add : function () {
            const _this = this;
            this.resetForm();
            _this.edit_color = false;
            _this.submit_url = this.baseUrl + 'color';
        }
    },
    created() {
        this.getData();
    }
}
</script>
