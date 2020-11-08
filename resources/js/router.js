import DashBoardComponent from './components/backend/DashBoardComponent'
import CategoryComponent from './components/backend/CategoryComponent'
import SubCategoryComponent from './components/backend/SubCategoryComponent'
import ChildCategoryComponent from './components/backend/ChildCategoryComponent'
import VendorComponent from './components/backend/VendorComponent'

export const routes = [
    { path: '/', component: DashBoardComponent, name:"/" },
    { path: '/category', component: CategoryComponent, name:"/category" },
    { path: '/sub_category', component: SubCategoryComponent, name:"/sub_category" },
    { path: '/child_category', component: ChildCategoryComponent, name:"/child_category" },
    { path: '/vendor', component: VendorComponent, name:"/vendor" },
]
