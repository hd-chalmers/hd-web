import Vue from 'vue'
import VueRouter, { RouteConfig } from 'vue-router'
import Home from '../views/index.vue'

Vue.use(VueRouter)

const routes: Array<RouteConfig> = [
  {
    path: '/',
    component: () => import(/* webpackChunkName: "base" */ '../views/layouts/base.vue'),
    children: [
      {
        path: '',
        name: 'Home',
        component: Home
      },
      {
        path: '/events',
        name: 'Events',
        component: () => import(/* webpackChunkName: "events" */ '../views/events.vue')
      },
      {
        path: '/committee',
        name: 'Committee',
        component: () => import(/* webpackChunkName: "committee" */ '../views/committee/members.vue')
      },
      {
        path: '/contact',
        name: 'Contact',
        component: () => import(/* webpackChunkName: "contact" */ '../views/contact.vue')
      },
      {
        path: '/login',
        name: 'Login',
        component: () => import(/* webpackChunkName: "login" */ '../views/auth/login.vue')
      },
      {
        path: '/loehk',
        component: () => import(/* webpackChunkName: "loehkMain" */ '../views/layouts/LoehkMain.vue'),
        children: [
          {
            path: '',
            name: 'loehk',
            component: () => import(/* webpackChunkName: "loehkFront" */ '../views/loehk/Front.vue')
          },
          {
            path: '/loehk/active-year',
            name: 'loehk-active-year',
            component: () => import(/* webpackChunkName: "loehkActiveYear" */ '../views/loehk/ActiveYear.vue')
          },
          {
            path: '/loehk/events',
            name: 'loehk-events',
            component: () => import(/* webpackChunkName: "loehkEvents" */ '../views/loehk/Events.vue')
          },
          {
            path: '/loehk/investments',
            name: 'loehk-investments',
            component: () => import(/* webåackChunkName: "loehkInvestments" */ '../views/loehk/InvestmentAccounts.vue')
          },
          {
            path: '/loehk/prices',
            name: 'loehk-prices',
            component: () => import(/* webpackChunkName: "loehkPrices" */ '../views/loehk/Prices.vue')
          },
          {
            path: '/loehk/games',
            name: 'loehk-games',
            component: () => import(/* webpackChunkName: "loehkGames" */ '../views/loehk/Games.vue')
          }
        ]
      }
    ]
  },
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
