import Vue from 'vue'
import VueRouter, { RouteConfig } from 'vue-router'
import Home from '../views/index.vue'

Vue.use(VueRouter)

const routes: Array<RouteConfig> = [
  {
    path: '/',
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
    component: () => import(/* webpackChunkName: "Committee" */ '../views/committee/members.vue')
  },
  {
    path: '/contact',
    name: 'Contact',
    component: () => import(/* webpackChunkName: "contact" */ '../views/contact.vue')
  },
  {
    path: '/loehk',
    component: () => import(/* webpackChunkName: "loehkMain" */ '../components/loehk/LoehkMain.vue'),
    children: [
      {
        path: '',
        name: 'loehk',
        component: () => import(/* webpackChunkName: "loehkFront" */ '../components/loehk/components/Front.vue')
      },
      {
        path: '/loehk/active-year',
        name: 'loehk-active-year',
        component: () => import(/* webpackChunkName: "loehkActiveYear" */ '../components/loehk/components/ActiveYear.vue')
      },
      {
        path: '/loehk/events',
        name: 'loehk-events',
        component: () => import(/* webpackChunkName: "loehkEvents" */ '../components/loehk/components/Events.vue')
      },
      {
        path: '/loehk/investments',
        name: 'loehk-investments',
        component: () => import(/* webåackChunkName: "loehkInvestments" */ '../components/loehk/components/InvestmentAccounts.vue')
      },
      {
        path: '/loehk/prices',
        name: 'loehk-prices',
        component: () => import(/* webpackChunkName: "loehkPrices" */ '../components/loehk/components/Prices.vue')
      },
      {
        path: '/loehk/games',
        name: 'loehk-games',
        component: () => import(/* webpackChunkName: "loehkGames" */ '../components/loehk/components/Games.vue')
      }
    ]
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
