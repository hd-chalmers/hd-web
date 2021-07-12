<template>
    <div>
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
                          <i class="material-icons-outlined" style="image-rendering: pixelated">
                            videogame_asset
                          </i>
                        </v-list-item-icon>
                        <v-list-item-content>
                            Spel
                        </v-list-item-content>
                    </v-list-item>
                </v-list-item-group>
            </v-list>
            <template v-slot:append>
                <div class="pa-2">
                    <v-btn block color="purple" outlined dark>
                      <log-out-icon style="margin-right: 7px"/>
                        Logout
                    </v-btn>
                </div>
            </template>
        </v-navigation-drawer>
        <v-main style="padding-left: 0">
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
                        <router-view></router-view>
                      </v-scroll-x-transition>
                    </v-card-text>
                </v-card>
            </v-container>
        </v-main>
    </div>
</template>

<script lang="ts">
import {Vue, Component} from 'vue-property-decorator'
import {HomeIcon, UsersIcon, CalendarIcon, ClipboardIcon,
  ShoppingCartIcon, MonitorIcon, MenuIcon, LogOutIcon} from 'vue-feather-icons'

@Component({
  components: {
    HomeIcon,
    UsersIcon,
    CalendarIcon,
    ClipboardIcon,
    ShoppingCartIcon,
    MonitorIcon,
    MenuIcon,
    LogOutIcon
  }
})
export default class LoehkMain extends Vue{
  nav: boolean | null = null
}
</script>

<style scoped lang="scss">
</style>
