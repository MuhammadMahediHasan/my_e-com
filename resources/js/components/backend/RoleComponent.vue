<template>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Role</li>
                        </ol>
                    </div>
                    <div class="col-sm-6 text-right">
                        <button class="btn bg-gradient-info btn-flat text-right btn-sm" data-toggle="modal"
                                @click="Add()" data-target="#myModal">Add Role
                        </button>
                    </div>

                    <!-- Modal -->
                    <div id="myModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Create Role</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <form @submit.prevent="submit()">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Name</label>
                                                    <input type="text" class="form-control" v-model="form.name"
                                                           placeholder="Enter Name">
                                                    <span class="text-danger" v-if='$vuelidation.error("form.name")'>{{ $vuelidation.error('form.name') }}</span>
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
                                <h3 class="card-title">Role DataTable</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="dataTables_length" id="example1_length">
                                            <label>
                                                Show
                                                <select v-model="filter.row"
                                                        class="custom-select custom-select-sm form-control form-control-sm">
                                                    <option v-for="data_value in filter.table_row">{{ data_value }}
                                                    </option>
                                                </select>
                                                entries
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 text-right">
                                        <div id="example1_filter" class="dataTables_filter">
                                            <label>Search:<input type="search" class="form-control form-control-sm"
                                                                 placeholder="Search" v-model="filter.search"></label>
                                        </div>
                                    </div>
                                </div>
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Guard Name</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(data_value, index) in roleData.data">
                                        <td>{{ index+1 }}</td>
                                        <td>{{ data_value.name }}</td>
                                        <td>{{ data_value.guard_name }}</td></td>
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
                                        <th>Guard Name</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                </table>
                                <pagination :data="roleData" @pagination-change-page="getData()"></pagination>
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
    name: 'role',
    data() {
        return {
            form: {
                name: '',
                guard_name: '',
            },
            filter: {
                table_row: [10, 20, 30, 50],
                search: '',
                row: 10,
            },
            validationErrors : [],
            roleData: {},
            edit_role: false,
            edit_index_no: 0,
            submit_url: '',
        }
    },
    vuelidation : {
        data: {
            form : {
                name: {
                    required: true, msg : 'name field is required!'
                }
            },
        },
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
            if (this.$vuelidation.valid('form')) {
                this.Loader();
                $('#myModal').modal('hide');
                axios.post(this.baseUrl + 'role', _this.form)
                    .then((response) => {
                        _this.roleData.data.push(response.data.data);
                        Vue.$toast.success('Role Created Successfully');
                    })
                    .catch((error) => {
                        console.log(error);
                    })
            }
        },
        getData: function (page = 1) {
            const _this = this;
            axios.get(this.baseUrl + 'role?q=' + _this.filter.search + '&page=' + page + '&row=' + _this.filter.row)
                .then((response) => {
                    _this.roleData = response.data.data;
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
                    axios.delete(this.baseUrl + 'role/' + id)
                        .then((response) => {
                            if (response.data.status == 200) {
                                Vue.$toast.success('Role Deleted Successfully');
                                _this.roleData.data.splice(index, 1);
                            }
                        })
                        .catch((error) => {
                            console.log(error);
                        })
                } else if (result.isDenied) {
                    Vue.swal.fire('Role are not Deleted!', '', 'info')
                }
            })

        },
    },
    created() {
        this.getData();
    }
}
</script>
