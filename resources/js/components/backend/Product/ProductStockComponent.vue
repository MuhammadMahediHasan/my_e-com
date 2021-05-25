<template>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Stock Product</li>
                        </ol>
                    </div>
                    <div class="col-sm-6 text-right">
                        <router-link to="/product_list" class="btn bg-gradient-info btn-flat text-right btn-sm">Product
                            List
                        </router-link>
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
                                <h3 class="card-title">Stock Product</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form @submit.prevent="submit()">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Category </label>
                                                    <select class="form-control" v-model="form.category_id">
                                                        <option value="">Select</option>
                                                        <option v-for="(data_value, index) in categoryData"
                                                                :value="data_value.id">
                                                            {{ data_value.name }}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Sub Category</label>
                                                    <select class="form-control" v-model="form.sub_category_id">
                                                        <option value="">Select</option>
                                                        <option v-for="(data_value, index) in subCategoryData"
                                                                :value="data_value.id">
                                                            {{ data_value.name }}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Child Category</label>
                                                    <select class="form-control" v-model="form.child_category_id">
                                                        <option value="">Select</option>
                                                        <option v-for="(data_value, index) in childCategoryData"
                                                                :value="data_value.id">
                                                            {{ data_value.name }}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6 product_info_sec">
                                                <div class="form-group">
                                                    <label>Search </label>
                                                    <input class="form-control" v-model="filter.search"
                                                           placeholder="Search...">
                                                </div>
                                                <div id="myInputautocomplete-list" class="autocomplete-items">
                                                    <div v-for="(item, index) in productData"
                                                         @click="selectProduct(item)">
                                                        <span v-text="item.name"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label>Discount </label>
                                                            <input class="form-control" name="discount" v-model="form.discount" placeholder="Discount">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label>Expense </label>
                                                            <input class="form-control" name="expense" v-model="form.expense" placeholder="Expense">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label>Remarks </label>
                                                            <textarea class="form-control" name="expense" v-model="form.remarks" rows="3" placeholder="Remarks"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <table id="example1" class="table table-bordered table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Name</th>
                                                        <th>Code</th>
                                                        <th>Color</th>
                                                        <th>Size</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr v-for="(data_value, index) in stockCart">
                                                        <td>{{ index + 1 }}</td>
                                                        <td>{{ data_value.name }}</td>
                                                        <td>{{ data_value.code }}</td>
                                                        <td>
                                                            <select class="form-control" v-if="data_value.color.length > 0" v-model="stockCart[index].color_id" required>
                                                                <option value="">Select Color</option>
                                                                <option v-for="color in data_value.color" :value="color.color.id">{{ color.color.name }}</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select class="form-control" v-if="data_value.size.length > 0" v-model="stockCart[index].size_id" required>
                                                                <option value="">Select Size</option>
                                                                <option v-for="size in data_value.size" :value="size.size.id">{{ size.size.name }}</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control" v-model="stockCart[index].quantity">
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn bg-gradient-primary btn-flat btn-sm" type="submit">Submit
                                        </button>
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
                category_id: '',
                sub_category_id: '',
                child_category_id: '',
                discount : 0,
                expense : 0,
                description : 0,
                remarks : '',
            },
            filter: {
                table_row: [10, 20, 30, 50],
                search: '',
                row: 10,
            },
            productData: {},
            categoryData: {},
            subCategoryData: {},
            childCategoryData: {},
            stockCart: [],
        }
    },
    watch: {
        'filter.search': function (newVal, oldVal) {
            this.getData(newVal);
        },
        'form.category_id': function (newVal, oldVal) {
            this.getSubCategory(newVal);
        },
        'form.sub_category_id': function (newVal, oldVal) {
            this.getChildCategory(newVal);
        },
    },
    methods: {
        getCategory: function () {
            const _this = this;
            axios.get(this.baseUrl + 'sub_category/create')
                .then((response) => {
                    _this.categoryData = response.data.data;
                })
                .catch((error) => {
                    console.log(error);
                })
        },
        getSubCategory: function (id) {
            const _this = this;
            axios.get(this.baseUrl + 'child_category/' + id)
                .then((response) => {
                    _this.subCategoryData = response.data.data;
                })
                .catch((error) => {
                    console.log(error);
                })
        },
        getChildCategory: function (id) {
            const _this = this;
            axios.get(this.baseUrl + 'product/' + id)
                .then((response) => {
                    _this.childCategoryData = response.data.data;
                })
                .catch((error) => {
                    console.log(error);
                })
        },
        getData: function () {
            const _this = this;
            axios.get(this.baseUrl + 'product_stock?q=' + _this.filter.search + '&category_id=' + _this.form.category_id + '&sub_category_id=' + _this.form.sub_category_id + '&child_category_id=' + _this.form.child_category_id)
                .then((response) => {
                    _this.productData = response.data.data;
                })
                .catch((error) => {
                    console.log(error);
                })
        },
        selectProduct: function (data) {
            const _this = this;
            let exist_product = _this.stockCart.findIndex(product => product.code === data.code);
            if (exist_product !== -1) {
                _this.stockCart[exist_product].quantity++;
            } else {
                let product = {
                    "id": data.id,
                    "product_id": data.id,
                    "name": data.name,
                    "code": data.code,
                    "color": data.color,
                    "color_id": '',
                    "size": data.size,
                    "size_id": '',
                    "quantity": 1
                };
                _this.stockCart.push(product);
            }
            console.log(_this.stockCart)
        },
        submit : function () {
            const _this = this;
            axios.post(this.baseUrl + 'product_stock/', {'stock_cart' : _this.stockCart, 'from' : _this.form})
            .then((response) => {
                this.Loader();
                this.resetForm();
                _this.stockCart = [];
            })
            .catch((error) => {
                console.log(error);
            })
        }
    },
    created() {
        this.getCategory();
    }
}
</script>

<style scoped>
.autocomplete-items {
    position: absolute;
    border: 1px solid #d4d4d4;
    border-bottom: none;
    border-top: none;
    z-index: 99;
    top: 100%;
    left: 0;
    right: 0;
}

.autocomplete-items div {
    padding: 6px;
    cursor: pointer;
    background-color: #fff;
    border-bottom: 1px solid #d4d4d4;
}

.autocomplete-form input, .autocomplete-form .autocompletebtn {
    border: 1px solid transparent;
    background-color: #f1f1f1;
    padding: 10px;
    font-size: 16px;
}

.autocomplete-items {
    height: 200px;
    overflow: scroll;
    margin: -9px 8px 10px 8px;
    top: 73px;
}

.product_details {
    margin-top: 23px;
}

.product_info_sec {
    min-height: 300px;
}
</style>
