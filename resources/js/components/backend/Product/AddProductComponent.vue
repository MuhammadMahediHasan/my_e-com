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
                        <router-link to="/product_list" class="btn bg-gradient-info btn-flat text-right btn-sm">Product List</router-link>
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
                                                        <option v-for="(data_value, index) in vendorData" :value="data_value.id">
                                                            {{ data_value.name }}</option>
                                                    </select>
                                                    <span class="text-danger" v-if='$vuelidation.error("form.vendor_id")'>{{ $vuelidation.error('form.vendor_id') }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Category </label>
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
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Unit </label>
                                                    <select class="form-control" v-model="form.unit_id">
                                                        <option value="">Select</option>
                                                        <option v-for="(data_value, index) in unitData" :value="data_value.id">
                                                            {{ data_value.name }}</option>
                                                    </select>
                                                    <span class="text-danger" v-if='$vuelidation.error("form.unit_id")'>{{ $vuelidation.error('form.unit_id') }}</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Purchase Price</label>
                                                    <input type="text" class="form-control" v-model="form.purchase_price" placeholder="Purchase Price">
                                                    <span class="text-danger" v-if='$vuelidation.error("form.purchase_price")'>{{ $vuelidation.error('form.purchase_price') }}</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Sale Price</label>
                                                    <input type="text" class="form-control" v-model="form.sale_price" placeholder="Sale Price">
                                                    <span class="text-danger" v-if='$vuelidation.error("form.sale_price")'>{{ $vuelidation.error('form.sale_price') }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Material </label>
                                                    <select class="form-control" v-model="form.material_id">
                                                        <option value="">Select</option>
                                                        <option v-for="(data_value, index) in materialData" :value="data_value.id">
                                                            {{ data_value.name }}</option>
                                                    </select>
                                                    <span class="text-danger" v-if='$vuelidation.error("form.material_id")'>{{ $vuelidation.error('form.material_id') }}</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Tags</label>
                                                    <input-tag v-model="form.tags" class="form-control" placeholder="Tages"></input-tag>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <label>Attribute</label>
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" @click="showVariation($event,'color')">
                                                        <label class="form-check-label">Color</label>
                                                    </div>
                                                    <div class="row attribute_value color">
                                                        <div class="form-group" v-for="(data) in colorData">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" @click="addVariation($event, 'color', data.id)">
                                                                <label class="form-check-label">{{ data.name }}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" @click="showVariation($event,'size')">
                                                        <label class="form-check-label">Size</label>
                                                    </div>
                                                    <div class="row attribute_value size">
                                                        <div class="child_attribute" v-for="(data) in sizeData">
                                                            <div class="form-group">
                                                                <input class="form-check-input" type="checkbox" @click="addVariation($event, 'size', data.id)">
                                                                <label class="form-check-label">{{ data.name }}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Description</label>
                                                    <vue-editor v-model="form.description" />
<!--                                                    <textarea class="form-control" v-model="form.description" placeholder="Description"></textarea>-->
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
import { VueEditor } from "vue2-editor";
export default {
    name: 'product',
    components: { VueEditor },
    data() {
        return {
            form: {
                name: '',
                unit_id : '',
                vendor_id : '',
                material_id : '',
                category_id : '',
                sub_category_id : '',
                child_category_id : '',
                purchase_price: '',
                sale_price : '',
                description: '',
                tags: [],
                size: [],
                color: [],
            },
            filter: {
                table_row: [10, 20, 30, 50],
                search: '',
                row: 10,
            },
            validationErrors : [],
            productData: {},
            materialData: {},
            vendorData: {},
            sizeData: {},
            colorData: {},
            unitData: {},
            categoryData: {},
            subCategoryData: {},
            childCategoryData: {},
            optionsValue: [],
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
                unit_id : {
                    required: true, msg : 'unit field is required!'
                },
                material_id : {
                    required: true, msg : 'material field is required!'
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
                    this.resetForm();

                    _this.form.tags = [];
                    _this.form.size = [];
                    _this.form.color = [];

                    console.log(_this.form);
                })
                .catch((error) => {
                    console.log(error);
                })
            }
        },
        getAttribute : function (){
            const _this = this;
            axios.get(this.baseUrl + 'product/create')
                .then((response) => {
                    _this.attributeData = response.data.data;
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
        getVendor : function (){
            const _this = this;
            axios.get(this.baseUrl + 'vendor/create')
                .then((response) => {
                    _this.vendorData = response.data.data;
                })
                .catch((error) => {
                    console.log(error);
                })
        },
        getSize : function (){
            const _this = this;
            axios.get(this.baseUrl + 'size/create')
                .then((response) => {
                    _this.sizeData = response.data.data;
                })
                .catch((error) => {
                    console.log(error);
                })
        },
        getColor : function (){
            const _this = this;
            axios.get(this.baseUrl + 'color/create')
                .then((response) => {
                    _this.colorData = response.data.data;
                })
                .catch((error) => {
                    console.log(error);
                })
        },
        getUnit : function (){
            const _this = this;
            axios.get(this.baseUrl + 'unit/create')
                .then((response) => {
                    _this.unitData = response.data.data;
                })
                .catch((error) => {
                    console.log(error);
                })
        },
        getMaterial : function (){
            const _this = this;
            axios.get(this.baseUrl + 'material/create')
                .then((response) => {
                    _this.materialData = response.data.data;
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
        showVariation : function (event,class_name) {
            const _this = this;
            if (event.target.checked){
                $('.' + class_name).show();
            } else {
                $('.' + class_name).hide();
                $('.' + class_name + ' ' + ' input:checkbox').prop('checked', false);
                if (class_name == 'size') {
                    _this.form.size = [];
                } else {
                    _this.form.color = [];
                }
            }
        },
        addVariation : function (event,type , value) {
            const _this = this;
            if (event.target.checked){
                if(type == 'size')
                    _this.form.size.push(value);
                if (type == 'color')
                    _this.form.color.push(value);
            } else {
                if(type == 'size') {
                    if (_this.form.size.includes(value)){
                        var key = _this.form.size.indexOf(value);
                        if (key > -1) {
                            _this.form.size.splice(key, 1);
                        }
                    }
                }
                if (type == 'color') {
                    if (_this.form.color.includes(value)){
                        var key = _this.form.color.indexOf(value);
                        if (key > -1) {
                            _this.form.color.splice(key, 1);
                        }
                    }
                }
            }
        }
    },
    created() {
        this.getCategory();
        this.getVendor();
        this.getSize();
        this.getColor();
        this.getUnit();
        this.getMaterial();
    }
}
</script>
