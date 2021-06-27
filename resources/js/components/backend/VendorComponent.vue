<template>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Vendor</li>
                        </ol>
                    </div>
                    <div class="col-sm-6 text-right">
                        <button class="btn bg-gradient-info btn-flat text-right btn-sm" data-toggle="modal"
                                @click="Add()" data-target="#myModal">Add Vendor
                        </button>
                    </div>

                    <!-- Modal -->
                    <div id="myModal" class="modal fade" role="dialog">
                        <div class="modal-dialog modal-lg">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Create Vendor</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <form @submit.prevent="submit()">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Shop Name</label>
                                                    <input type="text" class="form-control" v-model="form.name"
                                                           placeholder="Enter Name">
                                                    <span class="text-danger" v-if="validationErrors.name" v-text="validationErrors.name[0]"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Owner Name</label>
                                                    <input type="text" class="form-control" v-model="form.owner_name"
                                                           placeholder="Owner Name">
                                                    <span class="text-danger" v-if="validationErrors.owner_name" v-text="validationErrors.owner_name[0]"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Phone</label>
                                                    <input type="text" class="form-control" v-model="form.phone"
                                                           placeholder="Phone">
                                                    <span class="text-danger" v-if="validationErrors.phone" v-text="validationErrors.phone[0]"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="text" class="form-control" v-model="form.email"
                                                           placeholder="Email">
                                                    <span class="text-danger" v-if="validationErrors.email" v-text="validationErrors.email[0]"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Shop Number</label>
                                                    <input type="text" class="form-control" v-model="form.shop_number"
                                                           placeholder="Enter Number">
                                                    <span class="text-danger" v-if="validationErrors.shop_number" v-text="validationErrors.shop_number[0]"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Address</label>
                                                    <textarea class="form-control" v-model="form.address" placeholder="Address"></textarea>
                                                    <span class="text-danger" v-if="validationErrors.address" v-text="validationErrors.address[0]"></span>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row" v-if="edit_vendor === false">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Password</label>
                                                    <input type="password" class="form-control" v-model="form.password" placeholder="Password">
                                                    <span class="text-danger" v-if="validationErrors.password" v-text="validationErrors.password[0]"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Confirm Password</label>
                                                    <input type="password" class="form-control" v-model="form.password_confirmation" placeholder="Password">
                                                    <span class="text-danger" v-if="validationErrors.password_confirmation" v-text="validationErrors.password_confirmation[0]"></span>
                                                </div>
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
                                <h3 class="card-title">Vendor DataTable</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table-search-bar :filter="filter"></table-search-bar>
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ShopName</th>
                                        <th>Owner Name</th>
                                        <th>Shop Number</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(data_value, index) in vendorData.data">
                                        <td>{{ index+1 }}</td>
                                        <td>{{ data_value.name }}</td>
                                        <td>{{ data_value.owner_name }}</td>
                                        <td>{{ data_value.shop_number }}</td>
                                        <td>{{ data_value.phone }}</td>
                                        <td>{{ data_value.email }}</td>
                                        <td>{{ data_value.address }}</td>
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
                                        <th>ShopName</th>
                                        <th>Owner Name</th>
                                        <th>Shop Number</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                </table>
                                <pagination :data="vendorData" @pagination-change-page="getData()"></pagination>
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
import TableSearchBar from "./layouts/tableSearchBar";
export default {
    name: 'vendor',
    components: {TableSearchBar},
    data() {
        return {
            form: {
                name: '',
                phone: '',
                email: '',
                address: '',
                owner_name: '',
                shop_number: '',
                password: '',
                password_confirmation: '',
            },
            filter: {
                table_row: [10, 20, 30, 50],
                search: '',
                row: 10,
            },
            validationErrors : [],
            vendorData: {},
            edit_vendor: false,
            edit_index_no: 0,
            submit_url: '',
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
        submit: function () {
            const _this = this;

            if (_this.edit_vendor === false) {
                console.log(_this.form);
                axios.post(_this.submit_url, _this.form)
                    .then((response) => {
                        if (response.data.status == 201){
                            _this.validationErrors = response.data.data;
                        } else {
                            this.Loader();
                            $('#myModal').modal('hide');
                            _this.vendorData.data.push(response.data.data);
                            Vue.$toast.success('Vendor Created Successfully');
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    })
            }

            if (_this.edit_vendor === true) {
                axios.put(_this.submit_url, _this.form)
                    .then((response) => {
                        if (response.data.status == 200){
                            this.Loader();
                            $('#myModal').modal('hide');
                            _this.vendorData.data[_this.edit_index_no] = response.data.data;
                            Vue.$toast.success('Vendor Updated Successfully');
                        } else {
                            _this.validationErrors = response.data.data;
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    })
            }

        },
        getData: function (page = 1) {
            const _this = this;
            axios.get(this.baseUrl + 'vendor?q=' + _this.filter.search + '&page=' + page + '&row=' + _this.filter.row)
                .then((response) => {
                    _this.vendorData = response.data.data;
                })
                .catch((error) => {
                    console.log(error);
                })
        },
        Delete: function (index, id) {
            const _this = this;
            Vue.swal.fire({
                title: 'Do you want to save the changes?',
                showCancelButton: true,
                confirmButtonText: `Delete`,
            }).then((result) => {
                if (result.isConfirmed) {
                    this.Loader();
                    axios.delete(this.baseUrl + 'vendor/' + id)
                        .then((response) => {
                            if (response.data.status == 200) {
                                Vue.$toast.success('Vendor Deleted Successfully');
                                _this.vendorData.data.splice(index, 1);
                            }
                        })
                        .catch((error) => {
                            console.log(error);
                        })
                } else if (result.isDenied) {
                    Vue.swal.fire('Vendor are not Deleted!', '', 'info')
                }
            })

        },
        Edit: function (index, id) {
            const _this = this;
            _this.form = _this.EditDepartmentForm = JSON.parse(JSON.stringify(_this.vendorData.data[index]));
            _this.edit_vendor = true;
            _this.edit_index_no = index;
            _this.submit_url = this.baseUrl + 'vendor/' + id;
            $('#myModal').modal('show');
        },
        Add: function () {
            const _this = this;
            this.resetForm();
            _this.edit_vendor = false;
            _this.submit_url = this.baseUrl + 'vendor';
        }
    },
    created() {
        this.getData();
    }
}
</script>
