import Vue from 'vue'
import VueRouter from 'vue-router'
import store from '../store'

Vue.use(VueRouter)

/* Guest Component */
const Login = () => import('../components/Login.vue' /* webpackChunkName: "resource/js/components/login" */)
// const Register = () => import('../components/Register.vue' /* webpackChunkName: "resource/js/components/register" */)
/* Guest Component */

/* Layouts */
const DahboardLayout = () => import('../components/Layouts/Dashboard.vue' /* webpackChunkName: "resource/js/components/layouts/dashboard" */)
/* Layouts */

/* Authenticated Component */
const Dashboard = () => import('../components/Dashboard.vue' /* webpackChunkName: "resource/js/components/dashboard" */)
const DoctorsList = () => import('../components/admin/DoctorsList.vue')
const PatientsList = () => import('../components/admin/PatientsList.vue')
const ExaminationsList = () => import('../components/examination/ExaminationsList.vue')

/* Authenticated Component */



const Routes = [
    {
        name: "login",
        path: "/login",
        component: Login,
        meta: {
            middleware: "guest",
            title: `Login`
        }
    },
    {
        path: "/",
        component: DahboardLayout,
        meta: {
            middleware: ["auth"]
        },
        children: [
            {
                name: "dashboard",
                path: '/',
                component: Dashboard,
                meta: {
                    title: `Dashboard`
                }
            },

            {
                name: "doctors",
                path: '/doctors/list',
                component: DoctorsList,
                meta: {
                    middleware: ["admin"],
                    title: `DoctorsList`
                }
            },
            {
                name: "patients",
                path: '/patients/list',
                component: PatientsList,
                meta: {
                    middleware: ["admin"],
                    title: `PatientsList`
                }
            },
            {
                name: "examinations",
                path: '/examinations/list',
                component: ExaminationsList,
                meta: {
                    middleware: ["doctor", "counter"],
                    title: `ExaminationsList`
                }
            }
        ]
    }
]

var router = new VueRouter({
    mode: 'history',
    routes: Routes
})

router.beforeEach((to, from, next) => {
    document.title = `${to.meta.title} - ${process.env.MIX_APP_NAME}`
    if (to.meta.middleware == "guest") {
        if (store.state.auth.authenticated) {
            next({ name: "dashboard" })
        }
        next()
    } else {
        if (store.state.auth.authenticated) {
            if (typeof to.meta.middleware === 'undefined') {
                next()
            }
            else {
                if (to.meta.middleware.includes(store.state.auth.user.role)) {
                    next()
                } else {
                    next({ name: "login" })

                }
            }
        } else {
            next({ name: "login" })
        }
    }
})

export default router
