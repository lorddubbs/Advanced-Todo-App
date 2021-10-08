import Vue from "vue";
import VueRouter from "vue-router";

/*middlewares */
import auth from "../middleware/auth";
import guest from "../middleware/guest";
import isVerified from "../middleware/isVerified";

import Home from "../views/Home.vue";
import Dashboard from "../views/Dashboard.vue";


/*authentication */
import Register from "../modules/auth/register.vue";
import Login from "../modules/auth/login.vue";

/*authentication and user account */
import Email from "../modules/auth/account/Email.vue";
import EmailVerify from "../modules/auth/account/EmailVerify.vue";
import EmailReset from "../modules/auth/account/EmailReset.vue";

/* tasks */
import TaskIndex from "../modules/task/tasks.vue";
import TaskCreate from "../modules/task/taskcreate.vue";
import Task from "../modules/task/task.vue";

/* categories */
import CategoryIndex from "../modules/category/categories.vue";
import CategoryCreate from "../modules/category/categorycreate.vue";

/* user */
import UserProfile from "../modules/user/UserProfile.vue";


Vue.use(VueRouter);

const routes = [
  {
    path: "/",
    name: "Home",
    component: Home,
  },
  {
    path: "/register",
    name: "register",
    component: Register,
    meta: {
      layout: "UserLayout",
      title: "TODO | Register",
      middleware: [guest]
    }
  },
  {
    path: "/login",
    name: "login",
    component: Login,
    meta: {
      layout: "UserLayout",
      title: "TODO | Login",
      middleware: [guest]
    }
  },
  {
    path: "/forgot-password",
    name: "findEmail",
    component: Email,
    meta: {
      layout: "UserLayout",
      title: "TODO | Restore Account"
    }
  },
  {
    path: "/verify-account",
    name: "verifyEmail",
    component: EmailVerify,
    meta: {
      layout: "UserLayout",
      title: "TODO | Verify Email",
      middleware: [isVerified]
    }
  },
  {
    path: "/update-password",
    name: "resetEmail",
    component: EmailReset,
    meta: {
      layout: "UserLayout",
      title: "TODO | Reset Account"
    }
  },
  {
    path: "/dashboard",
    component: Dashboard,
    children: [
      {
        path: '',
        name: 'dashboardHome',
        component: TaskIndex,
        meta: { layout: "MainDashboardLayout", title: "TODO | Dashboard", middleware: [auth] }
      },
      {
        path: 'tasks',
        name: 'tasks',
        component: TaskIndex,
        meta: { layout: "MainDashboardLayout", title: "TODO | Dashboard Tasks", middleware: [auth] }
      },
      {
        path: 'tasks/create/new',
        name: 'createTask',
        component: TaskCreate,
        meta: { layout: "MainDashboardLayout", title: "TODO | Dashboard Create Task", middleware: [auth] }
      },
      {
        path: 'tasks/:id/:task',
        name: 'viewTask',
        props: true,
        component: Task,
        meta: { layout: "MainDashboardLayout", title: "TODO | Dashboard View Task", middleware: [auth] }
      },
      {
        path: 'categories',
        name: 'categories',
        component: CategoryIndex,
        meta: { layout: "MainDashboardLayout", title: "TODO | Dashboard Categories", middleware: [auth] }
      },
      {
        path: 'categories/create/new',
        name: 'createCategory',
        component: CategoryCreate,
        meta: { layout: "MainDashboardLayout", title: "TODO | Dashboard Create Category", middleware: [auth] }
      },
      {
        path: 'user/profile',
        name: 'userProfile',
        component: UserProfile,
        meta: { layout: "MainDashboardLayout", title: "TODO | Dashboard Profile", middleware: [auth] }
      }
    ],
  },
];

const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes,
});

function nextFactory(context, middleware, index) {
  const subsequentMiddleware = middleware[index];
  if (!subsequentMiddleware) return context.next;

  return (...parameters) => {
    // Run the default Vue Router `next()` callback first.
    context.next(...parameters);
    const nextMiddleware = nextFactory(context, middleware, index + 1);
    subsequentMiddleware({ ...context, next: nextMiddleware });
  };
}


router.beforeEach((to, from, next) => {
  
  if (to.meta.middleware) {
    const middleware = Array.isArray(to.meta.middleware)
      ? to.meta.middleware
      : [to.meta.middleware];
  
    const context = {
      to,
      from,
      next
    };
    const nextMiddleware = nextFactory(context, middleware, 1);

    return middleware[0]({ ...context, next: nextMiddleware });
  }
  return next();
});


export default router;