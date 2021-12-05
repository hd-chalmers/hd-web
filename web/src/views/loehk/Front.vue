<template>
    <v-row>
        <v-col style="max-width: 1000px">
            <v-card :loading="loading">
                <v-card-title>
                    Statistik
                </v-card-title>
                <v-card-text>
                    <v-list>
                        <v-list-item-group>
                            <v-list-item>
                              <v-list-item-icon> <disc-icon/> </v-list-item-icon>
                                <v-list-item-title>
                                    Antal Spel:
                                </v-list-item-title>
                                <v-list-item-subtitle>
                                    {{ stats.games }}
                                </v-list-item-subtitle>
                            </v-list-item>
                            <v-list-item v-if="stats.games_latest">
                                <v-list-item-title>
                                    Senaste Spel:
                                </v-list-item-title>
                                <v-list-item-subtitle>
                                    {{ stats.games_latest.name }} - {{ stats.games_latest.created_at.substr(0, 10) }} {{ stats.games_latest.created_at.substr(11, 8) }}
                                </v-list-item-subtitle>
                            </v-list-item>
                            <v-list-item  v-if="stats.games_updated">
                                <v-list-item-title>
                                    Senast uppdaterade Spel:
                                </v-list-item-title>
                                <v-list-item-subtitle>
                                    {{ stats.games_updated.name }} - {{ stats.games_updated.updated_at.substr(0, 10) }} {{ stats.games_updated.updated_at.substr(11, 8) }}
                                </v-list-item-subtitle>
                            </v-list-item>
                            <hr>
                            <v-list-item>
                              <v-list-item-icon> <shopping-cart-icon/> </v-list-item-icon>
                                <v-list-item-title>
                                    Antal Produkter:
                                </v-list-item-title>
                                <v-list-item-subtitle>
                                    {{ stats.products }}
                                </v-list-item-subtitle>
                            </v-list-item>
                            <v-list-item  v-if="stats.product_latest">
                                <v-list-item-title>
                                    Senaste Produkt:
                                </v-list-item-title>
                                <v-list-item-subtitle>
                                    {{ stats.product_latest.name }} - {{ stats.product_latest.created_at.substr(0, 10) }} {{ stats.product_latest.created_at.substr(11, 8) }}
                                </v-list-item-subtitle>
                            </v-list-item>
                            <v-list-item  v-if="stats.product_updated">
                                <v-list-item-title>
                                    Senast uppdaterade Produkt:
                                </v-list-item-title>
                                <v-list-item-subtitle>
                                    {{ stats.product_updated.name }} - {{ stats.product_updated.updated_at.substr(0, 10) }} {{ stats.product_updated.updated_at.substr(11, 8) }}
                                </v-list-item-subtitle>
                            </v-list-item>
                            <hr>
                            <v-list-item>
                              <v-list-item-icon> <align-center-icon style="transform: rotate(90deg);"/></v-list-item-icon>
                                <v-list-item-title>
                                    Antal Strecklistor:
                                </v-list-item-title>
                                <v-list-item-subtitle>
                                    {{ stats.investment_accounts }}
                                </v-list-item-subtitle>
                            </v-list-item>
                            <v-list-item v-if="stats.investment_latest">
                                <v-list-item-title>
                                    Senaste Strecklista:
                                </v-list-item-title>
                                <v-list-item-subtitle>
                                    {{ stats.investment_latest.name }} - {{ stats.investment_latest.created_at.substr(0, 10) }} {{ stats.investment_latest.created_at.substr(11, 8) }}
                                </v-list-item-subtitle>
                            </v-list-item>
                            <v-list-item v-if="stats.investment_updated">
                                <v-list-item-title>
                                    Senast uppdaterade Strecklista:
                                </v-list-item-title>
                                <v-list-item-subtitle>
                                    {{ stats.investment_updated.name }} - {{ stats.investment_updated.updated_at.substr(0, 10) }} {{ stats.investment_updated.updated_at.substr(11, 8) }}
                                </v-list-item-subtitle>
                            </v-list-item>
                            <hr>
                            <v-list-item>
                              <v-list-item-icon> <calendar-icon/> </v-list-item-icon>
                                <v-list-item-title>
                                    Antal Events:
                                </v-list-item-title>
                                <v-list-item-subtitle>
                                    {{ stats.events }}
                                </v-list-item-subtitle>
                            </v-list-item>
                            <v-list-item v-if="stats.event_latest">
                                <v-list-item-title>
                                    Senaste Event:
                                </v-list-item-title>
                                <v-list-item-subtitle>
                                    {{ stats.event_latest.title }} - {{ stats.event_latest.created_at.substr(0, 10) }} {{ stats.event_latest.created_at.substr(11, 8) }}
                                </v-list-item-subtitle>
                            </v-list-item>
                            <v-list-item v-if="stats.event_updated">
                                <v-list-item-title>
                                    Senast uppdaterade Event:
                                </v-list-item-title>
                                <v-list-item-subtitle>
                                    {{ stats.event_updated.title }} - {{ stats.event_updated.updated_at.substr(0, 10) }} {{ stats.event_updated.updated_at.substr(11, 8) }}
                                </v-list-item-subtitle>
                            </v-list-item>
                        </v-list-item-group>
                    </v-list>
                </v-card-text>
            </v-card>
        </v-col>
    </v-row>
</template>

<script lang="ts">


import {Component, Vue} from "vue-property-decorator";
import {LoehkSummaryData} from "@/assets/ts/interfaces";
import {SessionStore} from "@/assets/ts/sessionStore";
import { DiscIcon, ShoppingCartIcon, AlignCenterIcon, CalendarIcon } from "vue-feather-icons";

@Component({
  components:{
    DiscIcon,
    ShoppingCartIcon,
    AlignCenterIcon,
    CalendarIcon
  }
})
export default class LoehkFront extends Vue{
  constructor() {
    super()
    this.getStatistics()
  }
  loading = true
  stats: LoehkSummaryData = {
    products: 0,
    product_updated: {
      name: "",
      updated_at: ""
    },
    product_latest: {
      name: "",
      created_at: ""
    },
    investment_accounts: 0,
    investment_latest: {
      uid: "",
      name: "",
      created_at: ""
    },
    investment_updated: {
      uid: "",
      name: "",
      updated_at: ""
    },
    events: 0,
    event_latest: {
      title: "",
      created_at: "",
      date: ""
    },
    event_updated: {
      title: "",
      updated_at: "",
      date: ""
    },
    games: 0,
    games_latest: {
      name: "",
      created_at: "",
      platform: "",
    },
    games_updated: {
      name: "",
      updated_at: "",
      platform: "",
    }
  }

  getStatistics(): void {
      fetch(process.env.VUE_APP_API_URL + '/loehk/front', {
        headers: {
          "Authorization": SessionStore.getSessionId() ?? ""
        }
      }).then(res =>res.json()).then((res: LoehkSummaryData )=> {
        this.stats = res
      }).catch(() => {
        this.$router.push('/login')
      }).finally(() => {
        this.loading = false;
      })
  }
}
</script>

<style scoped>

</style>
