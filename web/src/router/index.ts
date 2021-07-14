import Vue from 'vue'
import VueRouter, { RouteConfig } from 'vue-router'
import BaseLayout from '@/views/layouts/base.vue'
import { users } from '../../../api/src/database'

Vue.use(VueRouter)

const routes: Array<RouteConfig> = [
  {
    path: '/',
    component: BaseLayout,
    children: [
      {
        path: '',
        name: 'Home',
        component: () => import(/* webpackChunkName: "Home" */ '@/views/index.vue')
      },
      {
        path: '/events',
        name: 'Events',
        component: () => import(/* webpackChunkName: "events" */ '@/views/events.vue')
      },
      {
        path: '/committee',
        name: 'Committee',
        component: () => import(/* webpackChunkName: "committee" */ '@/views/committee/members.vue')
      },
      {
        path: '/contact',
        name: 'Contact',
        component: () => import(/* webpackChunkName: "contact" */ '@/views/contact.vue')
      },
      {
        path: '/login',
        name: 'Login',
        component: () => import(/* webpackChunkName: "login" */ '@/views/auth/login.vue')
      },
      {
        path: '',
        component: () => import(/* webpackChunkName: "loehkMain" */ '@/views/layouts/LoehkMain.vue'),
        children: [
          {
            path: '/loehk',
            redirect: '/loehk/home'
          },
          {
            path: '/loehk/home',
            name: 'loehk',
            component: () => import(/* webpackChunkName: "loehkFront" */ '@/views/loehk/Front.vue')
          },
          {
            path: '/loehk/active-year',
            name: 'loehk-active-year',
            component: () => import(/* webpackChunkName: "loehkActiveYear" */ '@/views/loehk/ActiveYear.vue')
          },
          {
            path: '/loehk/events',
            name: 'loehk-events',
            component: () => import(/* webpackChunkName: "loehkEvents" */ '@/views/loehk/Events.vue')
          },
          {
            path: '/loehk/investments',
            name: 'loehk-investments',
            component: () => import(/* webåackChunkName: "loehkInvestments" */ '@/views/loehk/InvestmentAccounts.vue')
          },
          {
            path: '/loehk/prices',
            name: 'loehk-prices',
            component: () => import(/* webpackChunkName: "loehkPrices" */ '@/views/loehk/Prices.vue')
          },
          {
            path: '/loehk/games',
            name: 'loehk-games',
            component: () => import(/* webpackChunkName: "loehkGames" */ '@/views/loehk/Games.vue')
          }
        ]
      }
    ]
  },
  {
    path: '/loehk/investments/print',
    name: 'loehk-investments-print',
    component: () => import(/* webpackChunkName: "loehkInvestPrint"*/'@/components/streck/PrintView.vue')
  }
]

const router = new VueRouter({
  mode: 'history',
  routes
})

export default router
