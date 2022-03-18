<template>
    <v-app :style="backgroundProperties">
      <navbar/>
        <v-navigation-drawer v-model="nav" app :mini-variant="$vuetify.breakpoint.lgOnly" :expand-on-hover="$vuetify.breakpoint.lgOnly" :temporary="$vuetify.breakpoint.mobile" clipped>
            <v-list nav>
                <v-list-item-group>
                    <v-list-item to="/loehk/home">
                        <v-list-item-icon>
                              <home-icon/>
                        </v-list-item-icon>
                        <v-list-item-content>
                            Loehk
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item to="/loehk/active-year">
                        <v-list-item-icon>
                            <users-icon/>
                        </v-list-item-icon>
                        <v-list-item-content>
                            Sittande
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item to="/loehk/events">
                        <v-list-item-icon>
                            <calendar-icon/>
                        </v-list-item-icon>
                        <v-list-item-content>
                            Events
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item to="/loehk/investments">
                        <v-list-item-icon>
                            <clipboard-icon/>
                        </v-list-item-icon>
                        <v-list-item-content>
                            Strecklista
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item to="/loehk/prices">
                        <v-list-item-icon>
                            <shopping-cart-icon/>
                        </v-list-item-icon>
                        <v-list-item-content>
                            Prislista
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item to="/loehk/games">
                        <v-list-item-icon>
                          <layers-icon/>
                        </v-list-item-icon>
                        <v-list-item-content>
                            Spel
                        </v-list-item-content>
                    </v-list-item>
                  <v-list-item to="/loehk/door">
                    <v-list-item-icon>
                      <book-icon style="transform: rotate(180deg)"/>
                    </v-list-item-icon>
                    <v-list-item-content>
                      Door
                    </v-list-item-content>
                  </v-list-item>
              <v-list-item to="/loehk/sales">
                <v-list-item-icon>
                  <dollar-sign-icon />
                </v-list-item-icon>
                <v-list-item-content>
                  Försäljning
                </v-list-item-content>
              </v-list-item>
              </v-list-item-group>
            </v-list>
            <template v-slot:append>
                <div class="pa-2">
                    <v-btn block color="purple" outlined dark @click="logout()">
                      <log-out-icon style="margin-right: 7px"/>
                        Logout
                    </v-btn>
                </div>
            </template>
        </v-navigation-drawer>
        <v-main>
            <v-container fluid>
                <v-card>
                    <v-card-title>
                        <v-btn icon @click.stop="nav = !nav">
                            <menu-icon/>
                        </v-btn>
                        Loehk
                    </v-card-title>
                    <v-card-text>
                      <v-scroll-x-transition leave-absolute>
                        <Nuxt/>
                      </v-scroll-x-transition>
                    </v-card-text>
                </v-card>
            </v-container>
        </v-main>
    </v-app>
</template>

<script lang="ts">
import {Vue, Component} from 'vue-property-decorator'
import {HomeIcon, UsersIcon, CalendarIcon, ClipboardIcon,
  ShoppingCartIcon, MonitorIcon, MenuIcon, LogOutIcon,
  BookIcon, DollarSignIcon, LayersIcon} from 'vue-feather-icons'
import {SessionStore} from "@/store/sessionStore";
import Navbar from "~/components/common/navbar.vue";

@Component({
  components: {
    Navbar,
    HomeIcon,
    UsersIcon,
    CalendarIcon,
    ClipboardIcon,
    ShoppingCartIcon,
    MonitorIcon,
    MenuIcon,
    LogOutIcon,
    BookIcon,
    DollarSignIcon,
    LayersIcon
  }
})
export default class LoehkMain extends Vue{
  created(): void{
    this.$vuetify.theme.dark = window.matchMedia('(prefers-color-scheme: dark)').matches

    this.getData()
  }

  nav: boolean | null = null
  state = import('@/store/sessionStore')
  backgroundProperties = ''

  getData(): void{
    fetch(process.env.NUXT_ENV_API_URL + '/background').then(res =>res.json()).then((res: {background_image: string | null}) => {
      this.backgroundProperties = `background-image: url(${res.background_image});` +
        'background-repeat: no-repeat;' +
        'background-position: center;' +
        'background-attachment: fixed;' +
        'background-size: cover ;"'
    })
    // .finally(() => this.$analytics.trackTiming('Initial Load', 'Load layout', Math.round(performance.now())))
  }

  logout():void {
    this.state.then(obj => {
      fetch(process.env.VUE_APP_API_URL + '/logout', {
        method: 'POST',
        // eslint-disable-next-line @typescript-eslint/ban-ts-comment
        // @ts-ignore
        headers: {
          Authorization: SessionStore.getSessionId() ?? ""
        }
      })
      .then(res => {
        if(res.status === 205){
          obj.SessionStore.clearSessionId()
          this.$router.push('/')
        }
      })
    })
  }
}
</script>

<style scoped lang="scss">
  .v-navigation-drawer .v-list .v-item--active.v-list-item--active{
    color: #DE3163;
  }
</style>
