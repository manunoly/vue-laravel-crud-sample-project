import CreatePersonComponent from './component/CreatePersonComponent.vue'
import EditPersonComponent from './component/EditPersonComponent.vue'
import IndexPersonComponent from './component/IndexPersonComponent.vue'


export const routes = [
    {
       
        name: 'Create',
        path:'/create',
        component:CreatePersonComponent
    },
    {
        name: 'Edit',
        path:'/edit',
        component:EditPersonComponent
    },
    { 
        name: 'Index',
        path:'/',
        component:IndexPersonComponent
    },
 
];