<router>
{
  beforeEnter:
    (to, from, next) => {
      import('@/store/sessionStore').then(c => {
        if (c.SessionStore.getSessionId() === null) {
          next("/login")
        } else {
          next()
        }
      })
    }
}
</router>

<template>
 <v-container fluid>
   <v-tabs grow v-model="tab" @change="search = ''">
     <v-tab> <list-icon style="margin-right: 5px"/> Köplogg</v-tab>
     <v-tab> <award-icon style="margin-right: 5px"/> Månadens Topp produkter</v-tab>
   </v-tabs>
   <v-text-field solo label="Sök" v-model="search" placeholder="Sök namn och siffror">
     <template v-slot:prepend-inner> <search-icon/> </template>
   </v-text-field>
    <v-progress-linear indeterminate v-if="loadingLog || loadingRank"/>

   <v-tabs-items v-model="tab">

     <v-tab-item>
       <v-data-iterator
       :items="saleLog"
       :items-per-page="100"
       item-key="id"
       :search="search"
       >
         <template v-slot:default="props">
          <v-expansion-panels>
            <v-expansion-panel v-for="item in props.items" :key="item.id">
              <v-expansion-panel-header class="flex justify-space-between text-subtitle-2">
                <span>{{ 0 > item.sum ? '+' + (item.sum * -1) : item.sum}}kr</span>
                <span style="text-align: center">{{item.user}}</span>
                <span style="text-align: right">{{new Date(item.created_at).toLocaleString('sv')}}</span>
              </v-expansion-panel-header>
              <v-expansion-panel-content>
                <v-row v-for="product in item.products" :key="product.id">
                  <v-col>{{product.name}}</v-col>
                  <v-col style="text-align: right"> {{ product.price }} kr</v-col>
                </v-row>
                <p v-if="!item.products.length" style="text-align: center">Är fri belopp</p>
              </v-expansion-panel-content>

            </v-expansion-panel>
          </v-expansion-panels>
         </template>
       </v-data-iterator>
       <v-btn @click="appendLog" outlined :loading="loadingLog" style="width: 100%">Ladda in mer loggar</v-btn>
     </v-tab-item>

     <v-tab-item>
       <v-data-table
         :items="productRanking"
         :headers="rankingHeaders"
         sort-by="amount"
         sort-desc
         :items-per-page="-1"
         :search="search"
       >
         <template v-slot:item.revenue="item">
           {{item.value}}kr
         </template>
       </v-data-table>
     </v-tab-item>

   </v-tabs-items>
 </v-container>
</template>

<script lang="ts">
import {Component, Vue} from "vue-property-decorator"
import {SessionStore} from "@/store/sessionStore"
import {SearchIcon, ListIcon, AwardIcon} from "vue-feather-icons"

@Component({
  components: {
    SearchIcon,
    ListIcon,
    AwardIcon
  },
  layout: "loehk"
})
export default class LoehkSales extends Vue{
  created(): void {
    this.appendLog()
    this.getRanking()
  }

  saleLog: any[] = []
  productRanking: any[] = []
  rankingHeaders = [
    {text: 'Produkt', value: 'name'},
    {text: 'Antal Sålt', value: 'amount'},
    {text: 'Intjänat', value: 'revenue'}
  ]
  offset = 0
  search = ""
  tab: number | null = null
  loadingLog = true
  loadingRank = true

  appendLog(): void {
    this.loadingLog = true

    fetch(process.env.NUXT_ENV_API_URL + "/loehk/sales/" + (this.offset ?? '0'), {
      headers:{
        "Authorization": SessionStore.getSessionId() ?? ''
      }
    }).then(res => res.json()).then((res: any[]) => {
      this.saleLog.push(...res)
      this.offset++
    })
      .catch(() => {this.$router.push("/login")})
    .finally(() => this.loadingLog = false)
  }

  getRanking(): void{
    this.loadingRank = true

    fetch(process.env.NUXT_ENV_API_URL + "/loehk/sales/top", {
      headers: {
        "Authorization": SessionStore.getSessionId() ?? ''
      }
    }).then(res => res.json()).then((res) => {
      this.productRanking = res
    }).catch(() => this.$router.push('/login'))
      .finally(() => this.loadingRank = false)
  }
}
</script>

<style scoped>

</style>
