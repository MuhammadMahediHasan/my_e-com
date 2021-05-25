<template>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Product Stock Summery</li>
                        </ol>
                    </div>
                    <div class="col-sm-6 text-right">
                        <router-link to="/product_stock" class="btn bg-gradient-info btn-flat text-right btn-sm">Product Stock</router-link>
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
                                <h3 class="card-title">Product Stock Summery</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="dataTables_length" id="example1_length">
                                            <label>
                                                Show
                                                <select v-model="filter.row" class="custom-select custom-select-sm form-control form-control-sm">
                                                    <option v-for="data_value in filter.table_row">{{ data_value }}</option>
                                                </select>
                                                entries
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 text-right">
                                        <div id="example1_filter" class="dataTables_filter">
                                            <label>Search:<input type="search" class="form-control form-control-sm" placeholder="Search" v-model="filter.search"></label>
                                        </div>
                                    </div>
                                </div>
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>SKU</th>
                                        <th>Name</th>
                                        <th>Color</th>
                                        <th>Size</th>
                                        <th>Quantity</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(data_value, index) in productData.data">
                                        <td>{{ index+1 }}</td>
                                        <td>{{ data_value.sku }}</td>
                                        <td>{{ data_value.product.name }}</td>
                                        <td>{{ data_value.color != null ? data_value.color.name : '' }}</td>
                                        <td>{{ data_value.size != null ? data_value.size.name : '' }}</td>
                                        <td>{{ data_value.quantity }}</td>
                                    </tr>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>SKU</th>
                                        <th>Name</th>
                                        <th>Color</th>
                                        <th>Size</th>
                                        <th>Quantity</th>
                                    </tr>
                                    </tfoot>
                                </table>
                                <pagination :data="productData" @pagination-change-page="getData()"></pagination>
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
export default {
    name : 'product',
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
            productData : {},
            edit_product : false,
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
    methods: {
        getData : function (page = 1){
            const _this = this;
            axios.get(this.baseUrl + 'product_stock_summary?q='+ _this.filter.search+'&page='+page+'&row='+_this.filter.row)
                .then((response) => {
                    _this.productData = response.data.data;
                    console.log( _this.productData );
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
    },
    created() {
        this.getData();
    }
}
</script>
