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
    component: () => import(/* webåackChunkName: "loehkMain" */ '../components/loehk/LoehkMain.vue'),
    children: [
      {
        path: '',
        name: 'loehk',
        component: () => import(/* webåackChunkName: "loehkFront" */ '../components/loehk/components/Front.vue')
      },
      {
        path: '/loehk/active-year',
        name: 'loehk-active-year',
        component: () => import(/* webåackChunkName: "loehkActiveYear" */ '../components/loehk/components/ActiveYear.vue')
      },
      {
        path: '/loehk/events',
        name: 'loehk-events',
        component: () => import(/* webåackChunkName: "loehkEvents" */ '../components/loehk/components/Events.vue')
      },
      {
        path: '/loehk/investments',
        name: 'loehk-investments',
        component: () => import(/* webåackChunkName: "loehkInvestments" */ '../components/loehk/components/InvestmentAccounts.vue')
      },
      {
        path: '/loehk/prices',
        name: 'loehk-prices',
        component: () => import(/* webåackChunkName: "loehkPrices" */ '../components/loehk/components/Prices.vue')
      },
      {
        path: '/loehk/games',
        name: 'loehk-games',
        component: () => import(/* webåackChunkName: "loehkGames" */ '../components/loehk/components/Games.vue')
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
