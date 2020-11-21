<template>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">General Settings</li>
                        </ol>
                    </div>
                    <div class="col-sm-6 text-right">
                        <router-link to="/" class="btn bg-gradient-info btn-flat text-right btn-sm">Dashboard</router-link>
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
                                                    <label>Phone</label>
                                                    <input type="text" class="form-control" v-model="form.phone"
                                                           placeholder="Enter Phone">
                                                    <span class="text-danger" v-if='$vuelidation.error("form.phone")'>{{ $vuelidation.error('form.phone') }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="text" class="form-control" v-model="form.email" placeholder="Email">
                                                    <span class="text-danger" v-if='$vuelidation.error("form.email")'>{{ $vuelidation.error('form.email') }}</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Address</label>
                                                    <input type="text" class="form-control" v-model="form.address" placeholder="Address">
                                                    <span class="text-danger" v-if='$vuelidation.error("form.address")'>{{ $vuelidation.error('form.address') }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>About Us</label>
                                                    <vue-editor v-model="form.about_us" />
                                                    <span class="text-danger" v-if='$vuelidation.error("form.about_us")'>{{ $vuelidation.error('form.about_us') }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Terms And Condition</label>
                                                    <vue-editor v-model="form.terms_and_condition" />
                                                    <span class="text-danger" v-if='$vuelidation.error("form.terms_and_condition")'>{{ $vuelidation.error('form.terms_and_condition') }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Privacy Policy</label>
                                                    <vue-editor v-model="form.privacy_policy" />
                                                    <span class="text-danger" v-if='$vuelidation.error("form.privacy_policy")'>{{ $vuelidation.error('form.privacy_policy') }}</span>
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
    name: 'general_setting',
    components: { VueEditor },
    data() {
        return {
            form: {
                id: '',
                name: '',
                phone: '',
                email: '',
                address: '',
                about_us: '',
                terms_and_condition: '',
                privacy_policy: '',
            },
            filter: {
                table_row: [10, 20, 30, 50],
                search: '',
                row: 10,
            },
            validationErrors : [],
            general_settingData: {},
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
                phone: {
                    required: true, msg : 'phone field is required!'
                },
                email: {
                    required: true, msg : 'email field is required!'
                },
                address: {
                    required: true, msg : 'address field is required!'
                },
                about_us: {
                    required: true, msg : 'about us field is required!'
                },
                terms_and_condition: {
                    required: true, msg : 'terms and condition field is required!'
                },
                privacy_policy: {
                    required: true, msg : 'privacy policy field is required!'
                },
            },
        },
    },
    methods: {
        submit: function () {
            const _this = this;
            if (this.$vuelidation.valid('form')) {
                this.Loader();
                axios.put(this.baseUrl +'general_setting/'+_this.form.id, _this.form)
                    .then((response) => {
                        //
                    })
                    .catch((error) => {
                        console.log(error);
                    })
            }
        },
        getData : function (){
            const _this = this;
            axios.get(this.baseUrl + 'general_setting')
                .then((response) => {
                    _this.form = response.data.data;
                })
                .catch((error) => {
                    console.log(error);
                })
        },
    },
    created() {
        this.getData();
    }
}
</script>
