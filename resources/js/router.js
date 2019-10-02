import VueRouter from 'vue-router'

// Pages
import Home from './pages/Home'
import Login from './pages/Login'
import Dashboard from './pages/Dashboard'
import ProjectsIndex from './pages/projects/ProjectsIndex'
import ProjectsCreate from './pages/projects/ProjectsCreate'

// Routes
const routes = [
    {
        path: '/',
        name: 'home',
        component: Home,
        meta: {
            auth: false
        }
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: {
            auth: false
        }
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard,
        meta: {
            auth: true
        }
    },
    {
        path: '/projects',
        name: 'projects',
        component: ProjectsIndex,
        meta: {
            auth: true
        }
    },
    {
        path: '/projects/new',
        name: 'projects.create',
        component: ProjectsCreate,
        meta: {
            auth: true
        }
    },
]

const router = new VueRouter({
    history: true,
    mode: 'history',
    routes,
})

export default router
