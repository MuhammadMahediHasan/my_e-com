<template>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Slider</li>
                        </ol>
                    </div>
                    <div class="col-sm-6 text-right">
                        <button class="btn bg-gradient-info btn-flat text-right btn-sm" data-toggle="modal" @click="Add()" data-target="#myModal">Add Slider
                        </button>
                    </div>

                    <!-- Modal -->
                    <div id="myModal" class="modal fade" role="dialog">
                        <div class="modal-dialog modal-lg">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Create Slider</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <form @submit.prevent="submit()">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="upload-example">
                                                    <cropper ref="cropper"
                                                             class="upload-example-cropper"
                                                             :stencil-props="{ aspectRatio: 10/5 }"
                                                             :src="image" />
                                                    <span class="text-danger" v-if='$vuelidation.error("form.image")'>{{ $vuelidation.error('form.image') }}</span>
                                                    <div class="button-wrapper">
                                                        <span class="button" @click="$refs.file.click()">
                                                              <input type="file" ref="file" @change="uploadImage($event)" accept="image/*"/>
                                                              Choose image
                                                        </span>
                                                        <span class="button" @click="cropImage()"><i class="fas fa-crop-alt"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Title</label>
                                                    <input type="text" class="form-control" v-model="form.title" placeholder="Enter Title">
                                                    <span class="text-danger" v-if='$vuelidation.error("form.title")'>{{ $vuelidation.error('form.title') }}</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
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
                                <h3 class="card-title">Slider DataTable</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table-search-bar :filter="filter"></table-search-bar>
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Image</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(data_value, index) in sliderData.data">
                                        <td>{{ index+1 }}</td>
                                        <td>{{ data_value.title }}</td>
                                        <td>
                                            <img :src="'backend_assets/image/slider/'+data_value.image">
                                        </td>
                                        <td>{{ data_value.status == 1 ? 'Active' : 'De-active' }}</td>
                                        <td>
                                            <button class="btn btn-danger btn-sm" @click="Delete(index, data_value.id)">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            <button class="btn btn-info btn-sm" @click="Edit(index, data_value.id)">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button :class="data_value.status == 1 ? 'btn btn-success btn-sm' : 'btn btn-warning btn-sm'" @click="Status(index, data_value.id)">
                                                <i :class="data_value.status == 1 ? 'far fa-check-circle' : 'far fa-times-circle'"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Image</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                </table>
                                <pagination :data="sliderData" @pagination-change-page="getData()"></pagination>
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
    name : 'slider',
    components: {TableSearchBar},
    data() {
        return {
            form : {
                title : '',
                image : '',
                status : 1,
            },
            filter : {
                table_row : [10, 20, 30, 50],
                search : '',
                row : 10,
            },
            image : 'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSZejv9yWWeQOZhd-OYDFQ8PbR_jo3968ILuA&usqp=CAU',
            sliderData : {},
            edit_slider : false,
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
                title: {
                    required: true, msg : 'title field is required!'
                },
                image: {
                    required: true, msg : 'crop an image'
                },
                status: {
                    required: true, msg : 'status field is required!'
                },
            },
        },
    },
    methods: {
        cropImage() {
            const _this = this;
            const result = this.$refs.cropper.getResult();
            var base64 = result.canvas.toDataURL( "image/jpeg" );
            _this.form.image = base64;
            Vue.$toast.success('Image Croped!');
        },
        uploadImage(event) {
            var input = event.target;
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = (e) => {
                    this.image = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        },
        submit : function () {
            const _this = this;
            if (this.$vuelidation.valid('form')) {
                this.Loader();
                $('#myModal').modal('hide');
                if (_this.edit_slider === false) {
                    axios.post(_this.submit_url, _this.form)
                        .then((response) => {
                            //_this.sliderData.data.push(response.data.data);
                            _this.getData();
                            Vue.$toast.success('Slider Created Successfully');
                        })
                        .catch((error) => {
                            console.log(error);
                        })
                }
                if (_this.edit_slider === true) {
                    axios.put(_this.submit_url, _this.form)
                        .then((response) => {
                            _this.sliderData.data[_this.edit_index_no] = response.data.data;
                            Vue.$toast.success('Slider Updated Successfully');
                        })
                        .catch((error) => {
                            console.log(error);
                        })
                }
            }
        },
        getData : function (page = 1){
            const _this = this;
            axios.get(this.baseUrl + 'slider?q='+ _this.filter.search+'&page='+page+'&row='+_this.filter.row)
                .then((response) => {
                    _this.sliderData = response.data.data;
                })
                .catch((error) => {
                    console.log(error);
                })
        },
        Status : function (index, id){
            const _this = this;
            axios.get(this.baseUrl + 'slider/'+id)
                .then((response) => {
                    Vue.$toast.success(response.data.msg);
                    //console.log(_this.sliderData.data[index]);
                    _this.sliderData.data[index]['status'] = response.data.data.status;
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
                    axios.delete(this.baseUrl + 'slider/' + id)
                        .then((response) => {
                            if (response.data.status == 200) {
                                Vue.$toast.success('Slider Deleted Successfully');
                                _this.sliderData.data.splice(index,1);
                            }
                        })
                        .catch((error) => {
                            console.log(error);
                        })
                } else if (result.isDenied) {
                    Vue.swal.fire('Slider are not Deleted!', '', 'info')
                }
            })

        },
        Edit : function (index, id) {
            const _this = this;
            _this.form = JSON.parse(JSON.stringify(_this.sliderData.data[index]));
            _this.image = "backend_assets/image/slider/"+_this.form.image;
            _this.edit_slider = true;
            _this.edit_index_no = id;
            _this.submit_url = this.baseUrl+ 'slider/'+id;
            $('#myModal').modal('show');
        },
        Add : function () {
            const _this = this;
            this.resetForm();
            _this.edit_slider = false;
            _this.submit_url = this.baseUrl + 'slider';
        }
    },
    created() {
        this.getData();
    }
}
</script>
<style scoped>
.upload-example-cropper {
    border: solid 1px #EEE;
    min-height: 300px;
    width: 100%;
}

.button-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 17px;
}

.button {
    color: white;
    font-size: 16px;
    padding: 10px 20px;
    background: #3fb37f;
    cursor: pointer;
    transition: background 0.5s;
    font-family: Open Sans, Arial;
    margin: 0 10px;
}

.button:hover {
    background: #38d890;
}

.button input {
    display: none;
}
</style>
