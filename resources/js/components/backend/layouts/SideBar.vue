<template>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <router-link to="/" class="brand-link">
            <img src="backend_assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">MyE-Com</span>
        </router-link>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="backend_assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">Alexander Pierce</a>
                    <span> <i class="fas fa-map-marker-alt"></i> Santa Ana, CA</span>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <router-link to="/" class="nav-link active">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                            </p>
                        </router-link>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-align-justify"></i>
                            <p>
                                Manage Category
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <router-link to="/category" class="nav-link">
                                    <p>Category</p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/sub_category" class="nav-link">
                                    <p>Sub Category</p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/child_category" class="nav-link">
                                    <p>Child Category</p>
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <router-link to="/vendor" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                Vendor
<!--                                <span class="right badge badge-danger">New</span>-->
                            </p>
                        </router-link>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-adjust"></i>
                            <p>
                                Manage Variation
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <router-link to="/size" class="nav-link">
                                    <p>Size</p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/color" class="nav-link">
                                    <p>Color</p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/unit" class="nav-link">
                                    <p>Unit</p>
                                </router-link>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-cubes"></i>
                            <p>
                                Product
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <router-link to="/create_product" class="nav-link">
                                    <p>Create Product</p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/product_list" class="nav-link">
                                    <p>Product List</p>
                                </router-link>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
</template>
