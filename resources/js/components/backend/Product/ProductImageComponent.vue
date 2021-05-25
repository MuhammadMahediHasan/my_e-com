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
                                <h3 class="card-title">Product Image</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="upload-example">
                                            <cropper ref="cropper"
                                                     class="upload-example-cropper"
                                                     :stencil-props="{ aspectRatio: 10/11 }"
                                                     :src="image" />
                                            <div class="button-wrapper">
                                                <span class="button" @click="$refs.file.click()">
                                                      <input type="file" ref="file" @change="uploadImage($event)" accept="image/*"/>
                                                      Choose image
                                                </span>
                                                <span class="button" @click="cropImage(1)"><i class="far fa-image"></i></span>
                                                <span class="button" @click="cropImage(2)"><i class="far fa-images"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="row">
                                            <div class="col-lg-12 text-center">
                                                <h5>Thubmbail Image</h5>
                                                <img :src="'backend_assets/image/thumbnails/'+productData.slug+'.webp'" style="padding-bottom: 5px; width : 35%">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Product Slide Image</h3>
                                </div>
                                <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-3" v-for="(image_value, index) in productMultipleImage"  style="padding-bottom: 15px;">
                                                <img :src="'backend_assets/image/multiple_image/'+image_value.image" style="padding-bottom: 5px; width : 100%">
                                                <button class="btn btn-block btn-outline-danger btn-xs" @click="Delete(index, image_value.id, image_value.product_id)"> <i class="fa fa-trash"></i> </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
            image : "https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSZejv9yWWeQOZhd-OYDFQ8PbR_jo3968ILuA&usqp=CAU",
            productData : {},
            productMultipleImage : {},
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

        cropImage(type) {
            const _this = this;
            const result = this.$refs.cropper.getResult();
            var base64 = result.canvas.toDataURL( "image/jpeg" );
            // const newTab = window.open();
            // newTab.document.body.innerHTML = `<img src="${result.canvas.toDataURL(
            //     "image/jpeg"
            // )}"></img>`;
            _this.saveImage(type, base64)
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

        saveImage : function (type, base64) {
            const _this = this;
            axios.post(this.baseUrl + 'upload_image', {product_id : this.$route.params.product_id ,type : type, image : base64})
            .then((response) => {
                console.log(response);
            })
            .catch((error) => {
                console.log(error);
            })
        },

        getData : function (){
            const _this = this;
            axios.get(this.baseUrl + 'product_multiple_image/'+this.$route.params.product_id)
                .then((response) => {
                    _this.productMultipleImage = response.data.image.data;
                    _this.productData = response.data.product;
                    console.log(_this.productData);
                })
                .catch((error) => {
                    console.log(error);
                })
        },
        Delete : function (index, image_id, product_id) {
            const _this = this;
            Vue.swal.fire({
                title: 'Do you want to save the changes?',
                showCancelButton: true,
                confirmButtonText: `Delete`,
            }).then((result) => {
                if (result.isConfirmed) {
                    this.Loader();
                    axios.get(this.baseUrl + 'product_image_delete/' + image_id+ '/' + product_id)
                        .then((response) => {
                            if (response.data.status == 200) {
                                Vue.swal.fire('Deleted!', '', 'success')
                                _this.productMultipleImage.splice(index,1);
                            }
                        })
                        .catch((error) => {
                            console.log(error);
                        })
                } else if (result.isDenied) {
                    Vue.swal.fire('Product Image not Deleted!', '', 'info')
                }
            })

        },
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
