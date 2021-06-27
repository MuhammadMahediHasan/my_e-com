<template>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Product</li>
                        </ol>
                    </div>
                    <div class="col-sm-6 text-right">
                        <router-link to="/create_product" class="btn bg-gradient-info btn-flat text-right btn-sm">Add Product</router-link>
                    </div>

                    <!-- Modal -->
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
                                <h3 class="card-title">Product DataTable</h3>
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
                                        <th>SubCategory</th>
                                        <th>ChildCategory</th>
                                        <th>Vendor</th>
                                        <th>Color</th>
                                        <th>Size</th>
                                        <th>Unit</th>
                                        <th>Material</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(data_value, index) in productData.data">
                                        <td>{{ index+1 }}</td>
                                        <td>{{ data_value.name }}</td>
                                        <td>{{ data_value.category.name }}</td>
                                        <td>{{ data_value.sub_category.name }}</td>
                                        <td>{{ data_value.child_category.name }}</td>
                                        <td>{{ data_value.vendor.name }}</td>
                                        <td>
                                            <span class="dot" v-for="colors in data_value.color" v-if="colors.color != null" :style="'background-color :' + colors.color.color_code"></span>
                                        </td>
                                        <td>
                                            <span class="border" v-for="sizes in data_value.size" v-text="' '+ sizes.size != null ? sizes.size.name : ''"></span>
                                        </td>
                                        <td>{{ data_value.unit.name }}</td>
                                        <td>{{ data_value.material.name }}</td>
                                        <td>
                                            <i v-if="data_value.status == 1" class="fas fa-check-circle text-success"></i>
                                            <i v-if="data_value.status == 0" class="fas fa-check-circle text-success"></i>
                                        </td>
                                        <td>
                                            <button class="btn btn-danger btn-sm" @click="Delete(index, data_value.id)">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            <router-link type="button" :to="{ name: 'edit-product', params:{ product_id: data_value.id }}" class="btn btn-info btn-sm">
                                                <i class="fa fa-edit"></i>
                                            </router-link>
                                            <router-link type="button" :to="{ name: 'product-image', params:{ product_id: data_value.slug }}" class="btn btn-dark btn-sm">
                                                <i class="far fa-image"></i>
                                            </router-link>
                                            <button class="btn btn-primary btn-sm"  data-toggle="modal" data-target="#myModal" @click="add(data_value.id)">
                                                <i class="fas fa-tag"></i>
                                            </button>
                                            <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#discountModal" @click="discountList(data_value.id)">
                                                <i class="fas fa-tags"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>SubCategory</th>
                                        <th>ChildCategory</th>
                                        <th>Vendor</th>
                                        <th>Color</th>
                                        <th>Size</th>
                                        <th>Unit</th>
                                        <th>Material</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                </table>
                                <pagination :data="productData" @pagination-change-page="getData()"></pagination>
                            </div>
                            <!-- /.card-body -->

                            <div id="myModal" class="modal fade" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Create Unit</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <form @submit.prevent="submit()">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Type</label>
                                                    <select class="form-control" v-model="form.type">
                                                        <option value="">Select</option>
                                                        <option value="1">Percentage</option>
                                                        <option value="2">Taka</option>
                                                    </select>
                                                    <span class="text-danger" v-if='$vuelidation.error("form.type")'>{{ $vuelidation.error('form.type') }}</span>
                                                </div>
                                                <div class="form-group">
                                                    <label>Amount</label>
                                                    <input type="number" class="form-control" v-model="form.amount" placeholder="Enter Amount">
                                                    <span class="text-danger" v-if='$vuelidation.error("form.amount")'>{{ $vuelidation.error('form.amount') }}</span>
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

                            <div id="discountModal" class="modal fade" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Create Unit</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Type</th>
                                                        <th>Amount</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(data_value, index) in productDiscountData">
                                                        <td>{{ index + 1 }}</td>
                                                        <td>{{ data_value.type == 1 ? 'percentage' : 'taka' }}</td>
                                                        <td>{{ data_value.amount }}</td>
                                                        <td>{{ data_value.type == 1 ? 'Active' : 'De-active' }}</td>
                                                        <td>
                                                            <button class="btn btn-danger btn-sm" @click="discountDelete(index, data_value.id)">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                            <button :class="data_value.status == 1 ? 'btn btn-success btn-sm' : 'btn btn-warning btn-sm'" @click="discountStatus(index, data_value.id)">
                                                                <i :class="data_value.status == 1 ? 'far fa-check-circle' : 'far fa-times-circle'"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Type</th>
                                                        <th>Amount</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

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
    name : 'product',
    components: {TableSearchBar},
    data() {
        return {
            form : {
                product_id : '',
                amount : '',
                type : 1,
                status : 1,
            },
            filter : {
                table_row : [10, 20, 30, 50],
                search : '',
                row : 10,
            },
            productData : {},
            productDiscountData : {},
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
                amount: {
                    required: true,
                    numeric: true,
                    msg : 'amount field is required!'
                },
                type: {
                    required: true, msg : 'type field is required!'
                },
                status: {
                    required: true, msg : 'status field is required!'
                },
            },
        },
    },
    methods: {
        getData : function (page = 1){
            const _this = this;
            axios.get(this.baseUrl + 'product?q='+ _this.filter.search+'&page='+page+'&row='+_this.filter.row)
                .then((response) => {
                    _this.productData = response.data.data;
                    console.log( _this.productData );
                })
                .catch((error) => {
                    console.log(error);
                })
        },
        add : function (id){
            const _this = this;
            _this.form.product_id = id;
        },
        discountStatus : function (index, id){
            const _this = this;
            axios.get(this.baseUrl + 'status_product_discount/'+id)
            .then((response) => {
                Vue.$toast.success(response.data.msg);
                _this.productDiscountData[index]['status'] = response.data.data.status;
            })
            .catch((error) => {
                console.log(error);
            })
        },
        discountList : function (id) {
            const _this = this;
            axios.get(this.baseUrl + 'get_product_discount/'+ id)
            .then((response) => {
                _this.productDiscountData = response.data.data;
            })
            .catch((error) => {
                console.log(error);
            })
        },
        submit : function () {
            const _this = this;
            if (this.$vuelidation.valid('form')) {
                this.Loader();
                $('#myModal').modal('hide');
                axios.put(this.baseUrl + 'product_discount/'+ _this.form.product_id, _this.form)
                .then((response) => {
                    Vue.$toast.success('Discount Successfully');
                })
                .catch((error) => {
                    console.log(error);
                })
            }
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
                    axios.delete(this.baseUrl + 'product/' + id)
                        .then((response) => {
                            if (response.data.status == 200) {
                                Vue.swal.fire('Deleted!', '', 'success')
                                _this.productData.data.splice(index,1);
                            }
                        })
                        .catch((error) => {
                            console.log(error);
                        })
                } else if (result.isDenied) {
                    Vue.swal.fire('Product are not Deleted!', '', 'info')
                }
            })

        },
        discountDelete : function (index, id) {
            const _this = this;
            Vue.swal.fire({title: 'Do you want to save the changes?', showCancelButton: true, confirmButtonText: `Delete`})
            .then((result) => {
                if (result.isConfirmed) {
                    this.Loader();
                    axios.delete(this.baseUrl + 'delete_product_discount/' + id)
                    .then((response) => {
                        if (response.data.status == 200) {
                            Vue.swal.fire('Deleted!', '', 'success')
                            _this.productDiscountData.splice(index,1);
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    })
                } else if (result.isDenied) {
                    Vue.swal.fire('Product are not Deleted!', '', 'info')
                }
        })

        },
    },
    created() {
        this.getData();
    }
}
</script>
