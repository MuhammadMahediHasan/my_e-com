import DashBoardComponent from './components/backend/DashBoardComponent'
import CategoryComponent from './components/backend/CategoryComponent'
import SubCategoryComponent from './components/backend/SubCategoryComponent'
import ChildCategoryComponent from './components/backend/ChildCategoryComponent'
import VendorComponent from './components/backend/VendorComponent'
import SizeComponent from './components/backend/SizeComponent'
import ColorComponent from './components/backend/ColorComponent'
import UnitComponent from './components/backend/UnitComponent'
import AddProductComponent from './components/backend/Product/AddProductComponent'
import ProductListComponent from './components/backend/Product/ProductListComponent'
import ProductEditComponent from './components/backend/Product/ProductEditComponent'
import ProductImageComponent from './components/backend/Product/ProductImageComponent'

export const routes = [
    { path: '/', component: DashBoardComponent, name:"/" },
    { path: '/category', component: CategoryComponent, name:"/category" },
    { path: '/sub_category', component: SubCategoryComponent, name:"/sub_category" },
    { path: '/child_category', component: ChildCategoryComponent, name:"/child_category" },
    { path: '/vendor', component: VendorComponent, name:"/vendor" },
    { path: '/size', component: SizeComponent, name:"/size" },
    { path: '/color', component: ColorComponent, name:"/color" },
    { path: '/unit', component: UnitComponent, name:"/unit" },
    { path: '/create_product', component: AddProductComponent, name:"/create_product" },
    { path: '/product_list', component: ProductListComponent, name:"/product_list" },
    { path:'/edit-product/:product_id', component:ProductEditComponent, name:'edit-product' },
    { path:'/product-image/:product_id', component:ProductImageComponent, name:'product-image' },
]
