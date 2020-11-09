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
                        <button class="btn bg-gradient-info btn-flat text-right btn-sm">Add Product
                        </button>
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
                                <h3 class="card-title">Create New Product</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form @submit.prevent="submit()">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Name</label>
                                                    <input type="text" class="form-control" v-model="form.name"
                                                           placeholder="Enter Name">
                                                    <span class="text-danger" v-if='$vuelidation.error("form.name")'>{{ $vuelidation.error('form.name') }}</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Vendor</label>
                                                    <select class="form-control" v-model="form.vendor_id">
                                                        <option value="">Select</option>
                                                        <option value="1">Active</option>
                                                    </select>
                                                    <span class="text-danger" v-if='$vuelidation.error("form.vendor_id")'>{{ $vuelidation.error('form.vendor_id') }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Category Name</label>
                                                    <select class="form-control" v-model="form.category_id">
                                                        <option value="">Select</option>
                                                        <option v-for="(data_value, index) in categoryData" :value="data_value.id">
                                                            {{ data_value.name }}</option>
                                                    </select>
                                                    <span class="text-danger" v-if='$vuelidation.error("form.category_id")'>{{ $vuelidation.error('form.category_id') }}</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Sub Category</label>
                                                    <select class="form-control" v-model="form.sub_category_id">
                                                        <option value="">Select</option>
                                                        <option v-for="(data_value, index) in subCategoryData" :value="data_value.id">
                                                            {{ data_value.name }}</option>
                                                    </select>
                                                    <span class="text-danger" v-if='$vuelidation.error("form.sub_category_id")'>{{ $vuelidation.error('form.sub_category_id') }}</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Child Category</label>
                                                    <select class="form-control" v-model="form.child_category_id">
                                                        <option value="">Select</option>
                                                        <option v-for="(data_value, index) in childCategoryData" :value="data_value.id">
                                                            {{ data_value.name }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Purchase Price</label>
                                                    <input type="text" class="form-control" v-model="form.purchase_price" placeholder="Enter Name">
                                                    <span class="text-danger" v-if='$vuelidation.error("form.purchase_price")'>{{ $vuelidation.error('form.purchase_price') }}</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Sale Price</label>
                                                    <input type="text" class="form-control" v-model="form.sale_price" placeholder="Enter Name">
                                                    <span class="text-danger" v-if='$vuelidation.error("form.sale_price")'>{{ $vuelidation.error('form.sale_price') }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Description</label>
                                                    <textarea class="form-control" v-model="form.description" placeholder="Description"></textarea>
                                                    <span class="text-danger" v-if="validationErrors.description" v-text="validationErrors.description[0]"></span>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn bg-gradient-primary btn-flat btn-sm" type="submit" :disabled="$vuelidation.errors()">Submit</button>
                                        <button type="button" class="btn bg-gradient-secondary btn-flat btn-sm"
                                                data-dismiss="modal">Close
                                        </button>
                                    </div>
                                </form>
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
    name: 'product',
    data() {
        return {
            form: {
                name: '',
                vendor_id : '',
                category_id : '',
                sub_category_id : '',
                child_category_id : '',
                purchase_price: '',
                sale_price : '',
                description: '',
            },
            filter: {
                table_row: [10, 20, 30, 50],
                search: '',
                row: 10,
            },
            validationErrors : [],
            productData: {},
            categoryData: {},
            subCategoryData: {},
            childCategoryData: {},
            submit_url: '',
        }
    },
    watch: {
        'form.category_id': function (newVal, oldVal) {
            this.getSubCategory(newVal);
        },
        'form.sub_category_id': function (newVal, oldVal) {
            this.getChildCategory(newVal);
        },
    },
    vuelidation : {
        data: {
            form : {
                name: {
                    required: true, msg : 'name field is required!'
                },
                vendor_id : {
                    required: true, msg : 'vendor field is required!'
                },
                category_id  : {
                    required: true, msg : 'category field is required!'
                },
                sub_category_id : {
                    required: true, msg : 'sub category field is required!'
                },
                purchase_price : {
                    required: true, numeric: true,  msg : 'purchase price must be a number!'
                },
                sale_price : {
                    required: true, numeric: true, msg : 'sale price must be a number!'
                },
            },
        },
    },
    methods: {
        submit: function () {
            const _this = this;
            if (this.$vuelidation.valid('form')) {
                this.Loader();
                axios.post(this.baseUrl +'product', _this.form)
                .then((response) => {
                    console.log(response);
                })
                .catch((error) => {
                    console.log(error);
                })
            }
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
        getChildCategory : function (id){
            const _this = this;
            axios.get(this.baseUrl + 'product/'+id)
                .then((response) => {
                    _this.childCategoryData = response.data.data;
                })
                .catch((error) => {
                    console.log(error);
                })
        },
    },
    created() {
        //this.getData();
        this.getCategory();
    }
}
</script>
