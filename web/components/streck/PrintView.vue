<template>
    <div>
      <v-btn id="home-button" style="margin: 15px;" fab fixed color="#DE3163" to="/loehk"><HomeIcon/></v-btn>
        <v-row v-for="(row,key) in rows" :key="key" style="page-break-after: always" dense>
            <v-col cols="4" class="text-center" v-for="(user) in row" :key="user.uid" style="display: flex; flex-direction: column; align-items: center;">
                <strong v-if="user.name !== ''" style="overflow: hidden;">{{ user.name.substr(0, 20) }}</strong>
                <strong v-else><span style="color: transparent">Empty</span></strong>
                <VueBarcode :value="user.uid" height="30">
                    Test
                </VueBarcode>
            </v-col>
        </v-row>
        <v-row v-for="(row,key) in inactive_rows" :key="key" style="page-break-after: always" class="text-center" dense>
            <v-col cols="12">
                <h5 style="text-align: center;">INACTIVE</h5>
            </v-col>
            <v-col cols="4" class="text-center" v-for="(user) in row" :key="user.uid" style="display: flex; flex-direction: column; align-items: center;">
                <strong v-if="user.name !== ''" style="overflow: hidden; margin: auto;">{{ user.name.substr(0, 20) }}</strong>
                <strong v-else><span style="color: transparent">Empty</span></strong>
                <VueBarcode :value="user.uid" height="25">
                    {{user.uid}}
                </VueBarcode>
            </v-col>
        </v-row>
    </div>
</template>

<script lang="ts">


import {Component, Vue} from "vue-property-decorator"
// eslint-disable-next-line @typescript-eslint/ban-ts-comment
// @ts-ignore
import VueBarcode from 'vue-barcode'
import { HomeIcon } from 'vue-feather-icons'
import {InevestAccPrintData} from "@/assets/interfaces";
import {SessionStore} from "@/store/sessionStore";

@Component({
  components:{
    VueBarcode,
    HomeIcon
  }
})
export default class PrintView extends Vue{
  constructor() {
    super()
    this.getData()
  }

  rows: InevestAccPrintData[][] = []
  inactive_rows: InevestAccPrintData[][] = []
  users: InevestAccPrintData[] = []
  last = 0
  inactive: InevestAccPrintData[] = []

  getData(): void{
    //this.state.then(obj => {
      fetch(process.env.VUE_APP_API_URL + '/loehk/investments/print', {
        headers: {
          Authorization: SessionStore.getSessionId() ?? ""
        }
      })
        .then(res => res.json()).then(res => {
        this.users = res.active
        this.last = res.last
        this.inactive = res.inactive
        this.renderData()
      }).catch(() => this.renderData())
    //})
  }
  renderData(): void{
    if (!(this.users.length % 30)) {
      this.users.push({'uid': 'USL' + (this.last < 100 ? '0' : '') + this.last, 'name': '', 'id': this.last})
    }
    while (this.users.length  > 0) {
      const howMany = 30
      while (this.users.length < 30) {
        this.last++;
        this.users.push({'uid': 'USL' + (this.last < 100 ? '0' : '') + this.last, 'name': '', 'id': this.last})
      }
      const row = this.users.splice(0, howMany)
      this.rows.push(row)
    }
    while (this.inactive.length > 0) {
      const howMany = 30
      const row     = this.inactive.splice(0, howMany)
      this.inactive_rows.push(row)
    }
  }
}
</script>

<style scoped>
@media print {
  #home-button{
    display: none;
  }
}
</style>
