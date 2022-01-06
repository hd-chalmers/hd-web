import Vue from 'vue'
import VueRouter, { RouteConfig } from 'vue-router'
import BaseLayout from '@/views/layouts/base.vue'
import {SessionStore} from "@/assets/ts/sessionStore";

Vue.use(VueRouter)

const routes: Array<RouteConfig> = [
  {
    path: '/loehk/investments/print',
    name: 'loehk-investments-print',
    component: () => import(/* webpackChunkName: "loehkInvestPrint"*/'@/components/streck/PrintView.vue')
  },
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
        path: '/pricelist',
        name: 'Pricelist',
        component: () => import(/* webpackChunkName: "pricelist"*/ '@/views/pricelist/pricelist.vue')
      },
      {
        path: '/games',
        name: 'Games',
        component: () => import(/* webpackChunkName: "games"*/ '@/views/game/GameList.vue')
      },
      {
        path:'/count',
        name: 'Count',
        component: () => import(/* webpackChunkName: "count" */ '@/components/counter.vue')
      },
      {
        path: '/login',
        name: 'Login',
        component: () => import(/* webpackChunkName: "login" */ '@/views/auth/login.vue')
      },
      {
        path: '',
        component: () => import(/* webpackChunkName: "loehkMain" */ '@/views/layouts/LoehkMain.vue'),
        beforeEnter: (to, from, next) => {
          if(SessionStore.getSessionId() === null){
            next("/login")
          }else {
            next()
          }
        },
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
          },
          {
            path: '/loehk/door',
            name: 'loehk-door',
            component: () => import(/* webpackChunkName: "loehkDoor"*/ '@/views/loehk/Door.vue')
          },
          {
            path: '/loehk/sales',
            name: 'loehk-sales',
            component: () => import(/* webpackChunkName: "loehkSales"*/ '@/views/loehk/Sales.vue')
          }
        ]
      },
      {
        path: "*", // Matches an non existent page, must be last in array
        name: "Error404",
        component: () => import(/* webpackChunckName: "Error404"*/ '@/views/errors/error404.vue')
      }
    ]
  }
]

const router = new VueRouter({
  mode: 'history',
  routes
})

export default router
