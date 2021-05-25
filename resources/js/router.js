import DashBoardComponent from './components/backend/DashBoardComponent'
import CategoryComponent from './components/backend/Category/CategoryComponent'
import SubCategoryComponent from './components/backend/Category/SubCategoryComponent'
import ChildCategoryComponent from './components/backend/Category/ChildCategoryComponent'
import VendorComponent from './components/backend/VendorComponent'
import UserComponent from './components/backend/UserComponent'
import SizeComponent from './components/backend/Variation/SizeComponent'
import ColorComponent from './components/backend/Variation/ColorComponent'
import UnitComponent from './components/backend/Variation/UnitComponent'
import GeneralSettingComponent from './components/backend/GeneralSettingComponent'
import SliderComponent from './components/backend/SliderComponent'
import RoleComponent from './components/backend/RoleComponent'
import MaterialComponent from './components/backend/Variation/MaterialComponent'
import AddProductComponent from './components/backend/Product/AddProductComponent'
import ProductListComponent from './components/backend/Product/ProductListComponent'
import ProductEditComponent from './components/backend/Product/ProductEditComponent'
import ProductImageComponent from './components/backend/Product/ProductImageComponent'
import ProductStockComponent from './components/backend/Product/ProductStockComponent'
import ProductStockSummeryComponent from './components/backend/Product/ProductStockSummeryComponent'

export const routes = [
    { path: '/', component: DashBoardComponent, name:"/" },
    { path: '/category', component: CategoryComponent, name:"/category" },
    { path: '/sub_category', component: SubCategoryComponent, name:"/sub_category" },
    { path: '/child_category', component: ChildCategoryComponent, name:"/child_category" },
    { path: '/vendor', component: VendorComponent, name:"/vendor" },
    { path: '/user', component: UserComponent, name:"/user" },
    { path: '/size', component: SizeComponent, name:"/size" },
    { path: '/color', component: ColorComponent, name:"/color" },
    { path: '/unit', component: UnitComponent, name:"/unit" },
    { path: '/general_setting', component: GeneralSettingComponent, name:"/general_setting" },
    { path: '/role', component: RoleComponent, name:"/role" },
    { path: '/slider', component: SliderComponent, name:"/slider" },
    { path: '/material', component: MaterialComponent, name:"/material" },
    { path: '/create_product', component: AddProductComponent, name:"/create_product" },
    { path: '/product_list', component: ProductListComponent, name:"/product_list" },
    { path:'/edit-product/:product_id', component:ProductEditComponent, name:'edit-product' },
    { path:'/product-image/:product_id', component:ProductImageComponent, name:'product-image' },
    { path: '/product_stock', component: ProductStockComponent, name:"/product_stock" },
    { path: '/product_stock_summary', component: ProductStockSummeryComponent, name:"/product_stock_summary" },
]
