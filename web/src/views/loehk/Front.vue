<template>
    <v-row dense>
      <v-col cols="12">
        <v-card-title style="padding: 0;">
          <h3>Statistik</h3>
        </v-card-title>
      </v-col>
      <v-col v-if="loading" cols="12">
        <v-progress-circular color="accent" indeterminate style="width: 100%;" size="50"/>
      </v-col>

      <v-col align-self="stretch" v-if="stats.events">
        <v-card height="100%" min-width="250px" elevation="3" to="/loehk/events">
          <v-card-title><calendar-icon style="margin-right: 5px;"/> Events</v-card-title>
          <v-card-text>
              <p>
                <span class="subtitle-2" style="margin-right: 5px;">Antal:</span> {{stats.events}}
              </p>
              <p>
                <span class="subtitle-2" style="margin-right: 5px;">Nyaste event:</span> "{{stats.event_latest.title}}" skapat den {{ new Date(stats.event_latest.created_at).toLocaleString('sv')}}
              </p>
              <p>
                <span class="subtitle-2" style="margin-right: 5px;">Senast ändrade event:</span> "{{stats.event_updated.title}}" ändrades den {{ new Date(stats.event_updated.updated_at).toLocaleString('sv')}}
              </p>
          </v-card-text>
        </v-card>
      </v-col>

      <v-col align-self="stretch" v-if="stats.products">
        <v-card height="100%" min-width="250px" elevation="3" to="/loehk/prices">
          <v-card-title><shopping-cart-icon style="margin-right: 5px;"/> Produkter</v-card-title>
          <v-card-text>
              <p>
                <span class="subtitle-2" style="margin-right: 5px;">Antal:</span> {{stats.products}}
              </p>
              <p>
                <span class="subtitle-2" style="margin-right: 5px;">Nyaste produkt:</span> "{{stats.product_latest.name}}" skapat den {{ new Date(stats.product_latest.created_at).toLocaleString('sv')}}
              </p>
              <p>
                <span class="subtitle-2" style="margin-right: 5px;">Senast ändrade produkt:</span> "{{stats.product_updated.name}}" ändrades den {{ new Date(stats.product_updated.updated_at).toLocaleString('sv')}}
              </p>
          </v-card-text>
        </v-card>
      </v-col>

      <v-col align-self="stretch" v-if="stats.investment_accounts">
        <v-card height="100%" min-width="250px" elevation="3" to="/loehk/investments">
          <v-card-title><clipboard-icon style="margin-right: 5px;"/> Strecklista</v-card-title>
          <v-card-text>
              <p>
                <span class="subtitle-2" style="margin-right: 5px;">Antal:</span> {{stats.investment_accounts}}
              </p>
              <p>
                <span class="subtitle-2" style="margin-right: 5px;">Nyaste kontot:</span> "{{stats.investment_latest.name}}" skapat den {{ new Date(stats.investment_latest.created_at).toLocaleString('sv')}}
              </p>
              <p>
                <span class="subtitle-2" style="margin-right: 5px;">Senast ändrade kontot:</span> "{{stats.investment_updated.name}}" ändrades den {{ new Date(stats.investment_updated.updated_at).toLocaleString('sv')}}
              </p>
          </v-card-text>
        </v-card>
      </v-col>

      <v-col align-self="stretch" v-if="stats.games">
        <v-card height="100%" min-width="250px" elevation="3" to="/loehk/games">
          <v-card-title><disc-icon style="margin-right: 5px;"/> Spel</v-card-title>
          <v-card-text>
            <p>
              <span class="subtitle-2" style="margin-right: 5px;">Antal:</span> {{stats.games}}
            </p>
            <p>
              <span class="subtitle-2" style="margin-right: 5px;">Nyaste spelet:</span> "{{stats.games_latest.name}}" skapat den {{ new Date(stats.games_latest.created_at).toLocaleString('sv')}}
            </p>
            <p>
              <span class="subtitle-2" style="margin-right: 5px;">Senast ändrade spelet:</span> "{{stats.games_updated.name}}" ändrades den {{ new Date(stats.games_updated.updated_at).toLocaleString('sv')}}
            </p>
          </v-card-text>
        </v-card>
      </v-col>

      <v-col align-self="stretch" v-if="stats.door_status">
        <v-card height="100%" min-width="250px" elevation="3" to="/loehk/door">
          <v-card-title><book-icon style="margin-right: 5px; transform: rotate(180deg)"/> Door</v-card-title>
          <v-card-text>
            <p>
              <span class="subtitle-2" style="margin-right: 5px;">Status:</span> {{stats.door_status.status}}
            </p>
            <p>
              <span class="subtitle-2" style="margin-right: 5px;">Senast ändrad:</span> {{new Date(stats.door_status.updated_at).toLocaleString('sv')}}
            </p>
            <p>
              <span class="subtitle-2" style="margin-right: 5px;">Antal ändringar idag:</span> {{stats.door_status.times_changed}}
            </p>
          </v-card-text>
        </v-card>
      </v-col>

      <v-col align-self="stretch" v-if="stats.sales_month">
        <v-card height="100%" min-width="250px" elevation="3" to="/loehk/sales">
          <v-card-title><dollar-sign-icon style="margin-right: 5px;"/> Försäljning</v-card-title>
          <v-card-text>
            <p>
              <span class="subtitle-2" style="margin-right: 5px;">Sålt:</span> {{stats.sales_month.this_month}}kr
            </p>
            <p>
              <span class="subtitle-2" style="margin-right: 5px;">Skilland med förra månaden:</span> {{stats.sales_month.this_month - stats.sales_month.last_month}}kr
              <v-progress-circular color="primary" size="25" style="top: -3px" :value="stats.sales_month.this_month / stats.sales_month.last_month * 100"/>
            </p>
            <p>
              <span class="subtitle-2" style="margin-right: 5px;">Topp produkt denna månaden:</span> {{stats.sales_month.top_product}}
            </p>
          </v-card-text>
        </v-card>
      </v-col>

    </v-row>
</template>

<script lang="ts">


import {Component, Vue} from "vue-property-decorator";
import {LoehkSummaryData} from "@/assets/ts/interfaces";
import {SessionStore} from "@/assets/ts/sessionStore";
import { DiscIcon, ShoppingCartIcon, ClipboardIcon, CalendarIcon, BookIcon, DollarSignIcon } from "vue-feather-icons";

@Component({
  components:{
    DiscIcon,
    ShoppingCartIcon,
    ClipboardIcon,
    CalendarIcon,
    BookIcon,
    DollarSignIcon
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
    },
    door_status: null,
    sales_month: null
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
