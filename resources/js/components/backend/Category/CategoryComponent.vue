<template>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Category</li>
                        </ol>
                    </div>
                    <div class="col-sm-6 text-right">
                        <button class="btn bg-gradient-info btn-flat text-right btn-sm" data-toggle="modal" @click="Add()" data-target="#myModal">Add Category
                        </button>
                    </div>

                    <!-- Modal -->
                    <div id="myModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Create Category</h5>
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
                                        <button type="button" class="btn bg-gradient-secondary btn-flat btn-sm close-modal" data-dismiss="modal">Close</button>
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
                                <h3 class="card-title">Category DataTable</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table-search-bar :filter="filter"></table-search-bar>
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(data_value, index) in listData.data">
                                        <td>{{ index+1 }}</td>
                                        <td>{{ data_value.name }}</td>
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
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                </table>
                                <pagination :data="categoryData" @pagination-change-page="getData()"></pagination>
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
        name : 'category',
        components: {TableSearchBar},
        computed: {
            listData() {
                return this.$store.state.listData
            }
        },
        data() {
            return {
                form : {
                    name : '',
                    description : '',
                    status : 1,
                },
                filter : {
                    table_row : [10, 20, 30, 50],
                    search : '',
                    row : 10,
                },
                categoryData : {},
                edit_category : false,
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
                    if (_this.edit_category === false) {
                        let data= {
                            'url' : _this.submit_url,
                            'data' : _this.form,
                        }
                        this.$store.dispatch('addData', data)
                    }
                    if (_this.edit_category === true) {
                        let data= {
                            'url' : _this.submit_url,
                            'data' : _this.form,
                        }
                        this.$store.dispatch('updateData', data)
                    }
                    jQuery('#myModal').modal('hide');
                }
            },

            getData : function (page = 1){
                const _this = this;
                this.$store.dispatch('getListData', this.baseUrl + 'category?q='+ _this.filter.search+'&page='+page+'&row='+_this.filter.row);
            },

            Delete : function (index, id) {
                let data = {
                    'url' : 'category',
                    'id' : id,
                    'index' : index,
                }
                this.$store.dispatch('deleteData', data)
            },

            Edit : function (index, id) {
                const _this = this;
                const data = _this.listData.data[index]
                _this.form = JSON.parse(JSON.stringify(data));
                _this.edit_category = true;
                _this.edit_index_no = id;
                _this.submit_url = this.baseUrl+ 'category/'+id;
                jQuery('#myModal').modal('show');
            },
            Add : function () {
                const _this = this;
                this.resetForm();
                _this.edit_category = false;
                _this.submit_url = this.baseUrl + 'category';
            }
        },
        created() {
            this.getData();
        }
    }
</script>
