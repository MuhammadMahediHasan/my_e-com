import DashBoardComponent from './components/backend/DashBoardComponent'
import CategoryComponent from './components/backend/CategoryComponent'
import SubCategoryComponent from './components/backend/SubCategoryComponent'
import ChildCategoryComponent from './components/backend/ChildCategoryComponent'

export const routes = [
    { path: '/', component: DashBoardComponent, name:"/" },
    { path: '/category', component: CategoryComponent, name:"/category" },
    { path: '/sub_category', component: SubCategoryComponent, name:"/sub_category" },
    { path: '/child_category', component: ChildCategoryComponent, name:"/child_category" },
]
