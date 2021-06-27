<template>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Child Category</li>
                        </ol>
                    </div>
                    <div class="col-sm-6 text-right">
                        <button class="btn bg-gradient-info btn-flat text-right btn-sm" data-toggle="modal" @click="Add()" data-target="#myModal">Add ChildCategory
                        </button>
                    </div>

                    <!-- Modal -->
                    <div id="myModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Create Child Category</h5>
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
                                            <label>Category</label>
                                            <select class="form-control" v-model="form.sub_category_id">
                                                <option value="">Select Category</option>
                                                <option v-for="data_value in categoryData" :value="data_value.id">{{ data_value.name }}</option>
                                            </select>
                                            <span class="text-danger" v-if='$vuelidation.error("form.sub_category_id")'>{{ $vuelidation.error('form.sub_category_id') }}</span>
                                        </div>
                                        <div class="form-group">
                                            <label>Sub Category</label>
                                            <select class="form-control" v-model="form.child_category_id">
                                                <option value="">Select Sub Category</option>
                                                <option v-for="data_value in subCategoryData" :value="data_value.id">{{ data_value.name }}</option>
                                            </select>
                                            <span class="text-danger" v-if='$vuelidation.error("form.child_category_id")'>{{ $vuelidation.error('form.child_category_id') }}</span>
                                        </div>
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control" v-model="form.status">
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
                                <h3 class="card-title">ChildCategory DataTable</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table-search-bar :filter="filter"></table-search-bar>
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Sub Category</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(data_value, index) in child_categoryData.data">
                                        <td>{{ index+1 }}</td>
                                        <td>{{ data_value.name }}</td>
                                        <td>{{ data_value.category.name }}</td>
                                        <td>{{ data_value.sub_category.name }}</td>
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
                                        <th>Category</th>
                                        <th>Sub Category</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                </table>
                                <pagination :data="child_categoryData" @pagination-change-page="getData()"></pagination>
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
    name : 'child_category',
    components: {TableSearchBar},
    data() {
        return {
            form : {
                name : '',
                sub_category_id : '',
                child_category_id : '',
                status : 1,
                type : 3,
            },
            filter : {
                table_row : [10, 20, 30, 50],
                search : '',
                row : 10,
            },
            categoryData : {},
            subCategoryData : {},
            child_categoryData : {},
            edit_child_category : false,
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
        'form.sub_category_id': function (newVal, oldVal) {
            this.getSubCategory(newVal);
        },
    },
    vuelidation : {
        data: {
            form : {
                name: {
                    required: true, msg : 'name field is required!'
                },
                sub_category_id: {
                    required: true, msg : 'sub category name field is required!'
                },
                child_category_id: {
                    required: true, msg : 'child category name field is required!'
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
                if (_this.edit_child_category === false) {
                    axios.post(_this.submit_url, _this.form)
                        .then((response) => {
                            Vue.$toast.success('Category Created Successfully');
                            this.getData();
                        })
                        .catch((error) => {
                            console.log(error);
                        })
                }
                if (_this.edit_child_category === true) {
                    axios.put(_this.submit_url, _this.form)
                        .then((response) => {
                            Vue.$toast.success('Category Update Successfully');
                            this.getData();
                        })
                        .catch((error) => {
                            console.log(error);
                        })
                }
            }
        },
        getData : function (page = 1){
            const _this = this;
            axios.get(this.baseUrl + 'child_category?q='+ _this.filter.search+'&page='+page+'&row='+_this.filter.row)
                .then((response) => {
                    _this.child_categoryData = response.data.data;
                    //console.log( _this.child_categoryData );
                })
                .catch((error) => {
                    console.log(error);
                })
        },
        getCategory : function (){
            const _this = this;
            axios.get(this.baseUrl + 'sub_category/create')
                .then((response) => {
                    _this.categoryData = response.data.data;
                })
                .catch((error) => {
                    console.log(error);
                })
        },
        getSubCategory : function (id){
            const _this = this;
            axios.get(this.baseUrl + 'child_category/'+id)
                .then((response) => {
                    _this.subCategoryData = response.data.data;
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
                    axios.delete(this.baseUrl + 'child_category/' + id)
                        .then((response) => {
                            if (response.data.status == 200) {
                                Vue.$toast.success('Category Deleted Successfully');
                                _this.child_categoryData.data.splice(index,1);
                            }
                        })
                        .catch((error) => {
                            console.log(error);
                        })
                } else if (result.isDenied) {
                    Vue.swal.fire('ChildCategory are not Deleted!', '', 'info')
                }
            })

        },
        Edit : function (index, id) {
            const _this = this;
            _this.form = JSON.parse(JSON.stringify(_this.child_categoryData.data[index]));
            _this.getSubCategory(_this.form.sub_category_id);
            _this.edit_child_category = true;
            _this.edit_index_no = id;
            _this.submit_url = this.baseUrl+ 'child_category/'+id;
            $('#myModal').modal('show');
        },
        Add : function () {
            const _this = this;
            this.resetForm();
            _this.form.status = 1;
            _this.form.type = 3;
            _this.edit_child_category = false;
            _this.submit_url = this.baseUrl + 'child_category';
        }
    },
    created() {
        this.getData();
        this.getCategory();
    }
}
</script>
