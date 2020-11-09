import DashBoardComponent from './components/backend/DashBoardComponent'
import CategoryComponent from './components/backend/CategoryComponent'
import SubCategoryComponent from './components/backend/SubCategoryComponent'
import ChildCategoryComponent from './components/backend/ChildCategoryComponent'
import VendorComponent from './components/backend/VendorComponent'
import AttributeComponent from './components/backend/AttributeComponent'
import AttributeValueComponent from './components/backend/AttributeValueComponent'
import AddProductComponent from './components/backend/Product/AddProductComponent'

export const routes = [
    { path: '/', component: DashBoardComponent, name:"/" },
    { path: '/category', component: CategoryComponent, name:"/category" },
    { path: '/sub_category', component: SubCategoryComponent, name:"/sub_category" },
    { path: '/child_category', component: ChildCategoryComponent, name:"/child_category" },
    { path: '/vendor', component: VendorComponent, name:"/vendor" },
    { path: '/attribute', component: AttributeComponent, name:"/attribute" },
    { path: '/attribute_value', component: AttributeValueComponent, name:"/attribute_value" },
    { path: '/create_product', component: AddProductComponent, name:"/create_product" },
]
